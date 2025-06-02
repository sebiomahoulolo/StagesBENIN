<?php

namespace App\Http\Controllers\Etudiant;

use App\Http\Controllers\Controller;
use App\Models\Annonce;
use App\Models\Candidature;
use App\Models\Secteur;
use App\Models\Specialite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class OffreEmploiController extends Controller
{
    /**
     * Afficher la liste des offres d'emploi avec filtres
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $query = Annonce::with(['entreprise', 'secteur', 'specialite'])
            ->approuve();
        
        // Filtrage par secteur
        if ($request->filled('secteur_id')) {
            $query->where('secteur_id', $request->secteur_id);
        }
        
        // Filtrage par spécialité
        if ($request->filled('specialite_id')) {
            $query->where('specialite_id', $request->specialite_id);
        }
        
        // Filtrage par type de poste
        if ($request->filled('type_de_poste')) {
            $query->where('type_de_poste', $request->type_de_poste);
        }
        
        // Filtrage par niveau d'étude
        if ($request->filled('niveau_detude')) {
            $query->where('niveau_detude', $request->niveau_detude);
        }
        
        // Filtrage par lieu
        if ($request->filled('lieu')) {
            $query->where('lieu', 'like', '%' . $request->lieu . '%');
        }
        
        // Recherche par mot-clé
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('nom_du_poste', 'like', '%' . $searchTerm . '%')
                  ->orWhere('description', 'like', '%' . $searchTerm . '%');
            });
        }
        
        $annonces = $query->latest()->paginate(10);
        $secteurs = Secteur::all();
        $specialites = Specialite::all();
        
        return view('etudiants.offres.index', compact('annonces', 'secteurs', 'specialites'));
    }
    
    /**
     * Afficher les détails d'une offre d'emploi
     *
     * @param  \App\Models\Annonce  $annonce
     * @return \Illuminate\View\View
     */
    public function show(Annonce $annonce)
    {
        // Incrémenter le nombre de vues
        $annonce->incrementViews();
        
        $aPostule = false;
        $candidature = null;
        
        if (Auth::check() && Auth::user()->etudiant) {
            $user = Auth::user();
            $etudiantId = $user->etudiant->id;
            
            // Recherche principale par etudiant_id
            $candidature = Candidature::where('etudiant_id', $etudiantId)
                                      ->where('annonce_id', $annonce->id)
                                      ->first();
            
            // Méthode de secours : recherche via la relation user
            if (!$candidature) {
                $candidature = Candidature::where('annonce_id', $annonce->id)
                                         ->whereHas('etudiant.user', function($query) use ($user) {
                                             $query->where('id', $user->id);
                                         })
                                         ->first();
                
                // Si trouvé avec la méthode de secours, corriger l'etudiant_id
                if ($candidature && $candidature->etudiant_id !== $etudiantId) {
                    Log::warning("Correction automatique de l'etudiant_id pour la candidature {$candidature->id}");
                    $candidature->update(['etudiant_id' => $etudiantId]);
                }
            }
            
            $aPostule = $candidature !== null;
        }
        
        $annonce->load('entreprise');
        
        return view('etudiants.offres.show', compact('annonce', 'aPostule', 'candidature'));
    }
    
    /**
     * Postuler rapidement à une offre (sans upload de fichiers)
     *
     * @param  \App\Models\Annonce  $annonce
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postuler(Annonce $annonce)
    {
        // Vérifier l'authentification
        if (!Auth::check() || !Auth::user()->etudiant) {
            return redirect()->route('login')->with('error', 'Vous devez être connecté en tant qu\'étudiant.');
        }

        $etudiantId = Auth::user()->etudiant->id;

        // Vérifier si déjà postulé (méthode robuste)
        $existingCandidature = $this->verifierCandidatureExistante($etudiantId, $annonce->id);

        if ($existingCandidature) {
            return redirect()->back()->with('warning', 'Vous avez déjà postulé à cette offre.');
        }

        // Vérifier la date limite
        if ($this->isDateLimiteDepassee($annonce)) {
            return redirect()->back()->with('error', 'La date limite pour postuler à cette offre est dépassée.');
        }

        // Créer la candidature
        try {
            DB::beginTransaction();
            
            Candidature::create([
                'etudiant_id' => $etudiantId,
                'annonce_id' => $annonce->id,
                'statut' => 'en_attente',
                'date_postulation' => now(),
            ]);
            
            DB::commit();
            return redirect()->back()->with('success', 'Votre candidature a été envoyée avec succès !');
            
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Erreur lors de la création de candidature', [
                'etudiant_id' => $etudiantId,
                'annonce_id' => $annonce->id,
                'error' => $e->getMessage()
            ]);
            
            return redirect()->back()->with('error', 'Une erreur est survenue lors de l\'envoi de votre candidature.');
        }
    }
    
    /**
     * Soumettre une candidature avec CV et lettre de motivation
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Annonce  $annonce
     * @return \Illuminate\Http\RedirectResponse
     */
    public function soumettreCandidature(Request $request, Annonce $annonce)
    {
        // Vérifier l'authentification
        if (!Auth::check() || !Auth::user()->etudiant) {
            return redirect()->route('login')->with('error', 'Vous devez être connecté en tant qu\'étudiant.');
        }

        $validator = Validator::make($request->all(), [
            'lettre_motivation' => 'required|string|min:100',
            'cv' => 'required|file|mimes:pdf,doc,docx|max:2048',
        ], [
            'lettre_motivation.required' => 'La lettre de motivation est obligatoire.',
            'lettre_motivation.min' => 'La lettre de motivation doit contenir au moins 100 caractères.',
            'cv.required' => 'Le CV est obligatoire.',
            'cv.mimes' => 'Le CV doit être au format PDF, DOC ou DOCX.',
            'cv.max' => 'Le CV ne doit pas dépasser 2 Mo.',
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()
                            ->withErrors($validator)
                            ->withInput();
        }

        $etudiantId = Auth::user()->etudiant->id;

        // Vérifier si déjà postulé
        if ($this->verifierCandidatureExistante($etudiantId, $annonce->id)) {
            return redirect()->back()->with('warning', 'Vous avez déjà postulé à cette offre.');
        }

        // Vérifier la date limite
        if ($this->isDateLimiteDepassee($annonce)) {
            return redirect()->back()->with('error', 'La date limite pour postuler à cette offre est dépassée.');
        }

        try {
            DB::beginTransaction();
            
            // Gérer l'upload du CV
            $cvPath = $this->handleCvUpload($request->file('cv'), $etudiantId);
            
            // Créer la candidature
            Candidature::create([
                'annonce_id' => $annonce->id,
                'etudiant_id' => $etudiantId,
                'lettre_motivation' => $request->lettre_motivation,
                'cv_path' => $cvPath,
                'statut' => 'en_attente',
                'date_postulation' => now(),
            ]);
            
            DB::commit();
            return redirect()->route('etudiants.offres.show', $annonce)
                            ->with('success', 'Votre candidature a été soumise avec succès.');
                            
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Erreur lors de la soumission de candidature', [
                'etudiant_id' => $etudiantId,
                'annonce_id' => $annonce->id,
                'error' => $e->getMessage()
            ]);
            
            return redirect()->back()->with('error', 'Une erreur est survenue lors de la soumission de votre candidature.');
        }
    }
    
    /**
     * Afficher la liste des candidatures de l'étudiant
     *
     * @return \Illuminate\View\View
     */
    public function mesCandidatures()
    {
        if (!Auth::check() || !Auth::user()->etudiant) {
            return redirect()->route('login')->with('error', 'Vous devez être connecté en tant qu\'étudiant.');
        }

        $candidatures = Candidature::with(['annonce.entreprise', 'annonce.secteur'])
                                  ->where('etudiant_id', Auth::user()->etudiant->id)
                                  ->latest('date_postulation')
                                  ->paginate(10);
        
        return view('etudiants.offres.mes-candidatures', compact('candidatures'));
    }

    /**
     * Méthodes utilitaires privées
     */
    
    /**
     * Vérifier si une candidature existe déjà (méthode robuste)
     */
/**
 * Vérifie si une candidature existe déjà pour un étudiant donné à une annonce précise.
 *
 * Cette méthode effectue d'abord une recherche directe dans la table des candidatures.
 * Si aucune candidature n'est trouvée, elle tente de retrouver une candidature via la relation utilisateur,
 * et corrige l'ID de l'étudiant si nécessaire.
 *
 * @param int $etudiantId  L'identifiant de l'étudiant
 * @param int $annonceId   L'identifiant de l'annonce
 * @return bool            Vrai si une candidature existe, faux sinon
 */
private function verifierCandidatureExistante($etudiantId, $annonceId)
{
    // Recherche directe de la candidature
    $candidature = Candidature::where('etudiant_id', $etudiantId)
                              ->where('annonce_id', $annonceId)
                              ->first();

    // Si aucune candidature trouvée, vérifier via la relation avec l'utilisateur connecté
    if (!$candidature) {
        $user = Auth::user();

        $candidature = Candidature::where('annonce_id', $annonceId)
                                  ->whereHas('etudiant.user', function ($query) use ($user) {
                                      $query->where('id', $user->id);
                                  })
                                  ->first();

        // Si une candidature est trouvée mais avec un mauvais etudiant_id, on corrige
        if ($candidature && $candidature->etudiant_id !== $etudiantId) {
            Log::warning("Correction automatique de l'etudiant_id pour la candidature {$candidature->id}");
            $candidature->update(['etudiant_id' => $etudiantId]);
        }
    }

    // Vérification finale de l'existence de la candidature
    return Candidature::where('etudiant_id', $etudiantId)
                      ->where('annonce_id', $annonceId)
                      ->exists();
}

    
    /**
     * Vérifier si la date limite est dépassée
     */
    private function isDateLimiteDepassee($annonce)
    {
        return $annonce->date_limite && Carbon::now()->gt(Carbon::parse($annonce->date_limite));
    }
    
    /**
     * Gérer l'upload du CV
     */
    private function handleCvUpload($cvFile, $etudiantId)
    {
        $fileName = 'cv_' . $etudiantId . '_' . time() . '.' . $cvFile->getClientOriginalExtension();
        $directory = 'assets/cvs/candidatures';
        
        // Créer le dossier s'il n'existe pas
        if (!file_exists(public_path($directory))) {
            mkdir(public_path($directory), 0755, true);
        }
        
        $cvFile->move(public_path($directory), $fileName);
        
        return $directory . '/' . $fileName;
    }
    
    /**
     * Méthode de débogage pour vérifier les candidatures (à supprimer en production)
     */
    public function debug()
    {
        if (!Auth::check() || !Auth::user()->etudiant) {
            return response()->json(['error' => 'Non authentifié'], 401);
        }

        $user = Auth::user();
        $etudiant = $user->etudiant;
        
        $data = [
            'user_id' => $user->id,
            'etudiant_id' => $etudiant->id,
            'candidatures_count' => Candidature::where('etudiant_id', $etudiant->id)->count(),
            'candidatures_orphelines' => Candidature::where('etudiant_id', '!=', $etudiant->id)
                                                   ->whereHas('etudiant.user', function($query) use ($user) {
                                                       $query->where('id', $user->id);
                                                   })->count()
        ];
        
        return response()->json($data);
    }
    
    /**
     * Corriger les candidatures avec des etudiant_id incorrects (à utiliser une seule fois)
     */
    public function corrigerCandidatures()
    {
        if (!Auth::check() || !Auth::user()->etudiant) {
            return response()->json(['error' => 'Non authentifié'], 401);
        }

        $user = Auth::user();
        $correctEtudiantId = $user->etudiant->id;
        
        try {
            DB::beginTransaction();
            
            $candidaturesToFix = Candidature::where('etudiant_id', '!=', $correctEtudiantId)
                                           ->whereHas('etudiant.user', function($query) use ($user) {
                                               $query->where('id', $user->id);
                                           })
                                           ->update(['etudiant_id' => $correctEtudiantId]);
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => "Correction effectuée: $candidaturesToFix candidatures mises à jour"
            ]);
            
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'error' => 'Erreur lors de la correction: ' . $e->getMessage()
            ], 500);
        }
    }
}