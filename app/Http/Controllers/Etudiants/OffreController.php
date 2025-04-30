<?php

namespace App\Http\Controllers\Etudiants;

use App\Http\Controllers\Controller;
use App\Models\Annonce;
use App\Models\Secteur;
use App\Models\Specialite;
use Illuminate\Http\Request;

class OffreController extends Controller
{
    public function index(Request $request)
    {
        $query = Annonce::query()
            ->with(['entreprise', 'secteur', 'specialite'])
            ->active()
            ->latest();

        // Filtres
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('nom_du_poste', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('secteur_id')) {
            $query->where('secteur_id', $request->secteur_id);
        }

        if ($request->filled('specialite_id')) {
            $query->where('specialite_id', $request->specialite_id);
        }

        if ($request->filled('type_de_poste')) {
            $query->where('type_de_poste', $request->type_de_poste);
        }

        if ($request->filled('niveau_detude')) {
            $query->where('niveau_detude', $request->niveau_detude);
        }

        if ($request->filled('lieu')) {
            $query->where('lieu', 'like', '%' . $request->lieu . '%');
        }

        if ($request->filled('pretension_salariale')) {
            $query->where('pretension_salariale', '>=', $request->pretension_salariale);
        }

        $annonces = $query->paginate(10);
        $secteurs = Secteur::orderBy('nom')->get();
        $specialites = $request->filled('secteur_id') 
            ? Specialite::where('secteur_id', $request->secteur_id)->orderBy('nom')->get()
            : collect();

        return view('etudiants.offres.index', compact('annonces', 'secteurs', 'specialites'));
    }

    public function show(Annonce $annonce)
    {
        $annonce->load(['entreprise', 'secteur', 'specialite']);
        
        // Incrémenter le nombre de vues
        $annonce->incrementViews();
        
        // Vérifier si l'étudiant a déjà postulé
        $aPostule = false;
        if (auth()->check() && auth()->user()->etudiant) {
            $aPostule = auth()->user()->etudiant->candidatures()
                ->where('annonce_id', $annonce->id)
                ->exists();
        }
        
        return view('etudiants.offres.show', compact('annonce', 'aPostule'));
    }

    /**
     * Affiche le formulaire pour postuler à une annonce.
     */
    public function postuler(Annonce $annonce)
    {
        // Vérifier si l'annonce est active
        if (!$annonce->est_active || $annonce->statut !== 'approuve' || $annonce->date_cloture < now()) {
            return redirect()->route('etudiants.offres.show', $annonce)
                ->with('error', 'Cette offre n\'est plus disponible pour candidature.');
        }
        
        // Vérifier si l'étudiant a déjà postulé
        $aPostule = auth()->user()->etudiant->candidatures()
            ->where('annonce_id', $annonce->id)
            ->exists();
            
        if ($aPostule) {
            return redirect()->route('etudiants.offres.show', $annonce)
                ->with('error', 'Vous avez déjà postulé à cette offre.');
        }
        
        // Charger les informations nécessaires pour le formulaire
        $annonce->load(['entreprise', 'secteur', 'specialite']);
        
        return view('etudiants.offres.postuler', compact('annonce'));
    }
    
    /**
     * Traite la soumission du formulaire de candidature.
     */
    public function postulerSubmit(Request $request, Annonce $annonce)
    {
        // Valider les données du formulaire
        $validated = $request->validate([
            'pretention_salariale' => 'required|numeric|min:0',
            'lettre_motivation' => 'required|string|min:100|max:1500',
            'cv_file' => 'required|file|mimes:pdf|max:5120', // 5MB max
        ], [
            'pretention_salariale.required' => 'La prétention salariale est requise.',
            'lettre_motivation.required' => 'La lettre de motivation est requise.',
            'lettre_motivation.min' => 'La lettre de motivation doit contenir au moins 1500 caractères.',
            'cv_file.required' => 'Le CV est requis.',
            'cv_file.mimes' => 'Le CV doit être au format PDF.',
            'cv_file.max' => 'Le CV ne doit pas dépasser 5 Mo.',
        ]);

        // Vérifier que l'annonce est active et en cours
        if (!$annonce->est_active || $annonce->statut !== 'approuve' || $annonce->date_cloture < now()) {
            return redirect()->back()->with('error', 'Cette offre n\'est plus disponible pour candidature.');
        }

        // Vérifier que l'étudiant n'a pas déjà postulé
        $dejaPostule = auth()->user()->etudiant->candidatures()
            ->where('annonce_id', $annonce->id)
            ->exists();

        if ($dejaPostule) {
            return redirect()->back()->with('error', 'Vous avez déjà postulé à cette offre.');
        }

        // Enregistrer le CV
        $cvPath = $request->file('cv_file')->store('cvs/candidatures/' . auth()->id(), 'public');

        // Créer la candidature
        $candidature = new \App\Models\Candidature([
            'annonce_id' => $annonce->id,
            'etudiant_id' => auth()->user()->id,
            'lettre_motivation' => $validated['lettre_motivation'],
            'cv_path' => $cvPath,
            'statut' => 'en_attente',
        ]);

        $candidature->save();

        return redirect()->route('etudiants.candidatures.index')
            ->with('success', 'Votre candidature a été soumise avec succès. Vous pouvez suivre son statut dans la section "Mes candidatures".');
    }

    public function mesCandidatures()
    {
        // Récupérer l'ID de l'utilisateur connecté
        $userId = auth()->id();
        
        // Récupérer les candidatures où etudiant_id correspond à l'ID de l'utilisateur
        $candidatures = \App\Models\Candidature::where('etudiant_id', $userId)
            ->with(['annonce.entreprise', 'annonce.secteur', 'annonce.specialite'])
            ->latest()
            ->paginate(10);

        return view('etudiants.offres.mes-candidatures', compact('candidatures'));
    }

    /**
     * Affiche les détails d'une candidature spécifique.
     *
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function showCandidature($id)
    {
        // Récupérer la candidature avec les relations nécessaires
        $candidature = \App\Models\Candidature::where('id', $id)
            ->where('etudiant_id', auth()->id()) // Vérifier que la candidature appartient à l'étudiant connecté
            ->with(['annonce.entreprise', 'annonce.secteur', 'annonce.specialite'])
            ->firstOrFail();

        return view('etudiants.offres.candidature-details', compact('candidature'));
    }
} 