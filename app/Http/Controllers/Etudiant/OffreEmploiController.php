<?php

namespace App\Http\Controllers\Etudiant;

use App\Http\Controllers\Controller;
use App\Models\Recrutement;
use App\Models\Candidature;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

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
        $query = Recrutement::with('entreprise');
        
        // Filtrage par lieu
        if ($request->has('lieu') && !empty($request->lieu)) {
            $query->where('lieu', 'like', '%' . $request->lieu . '%');
        }
        
        // Filtrage par type de contrat
        if ($request->has('type_contrat') && !empty($request->type_contrat)) {
            $query->where('type_contrat', $request->type_contrat);
        }
        
        // Filtrage par domaine (à adapter selon votre structure)
        if ($request->has('domaine') && !empty($request->domaine)) {
            $query->where('domaine', 'like', '%' . $request->domaine . '%');
        }
        
        // Recherche par mot-clé
        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('titre', 'like', '%' . $searchTerm . '%')
                  ->orWhere('description', 'like', '%' . $searchTerm . '%')
                  ->orWhere('competences_requises', 'like', '%' . $searchTerm . '%');
            });
        }
        
        // Récupérer les offres non expirées
        $query->where(function($q) {
            $q->whereNull('date_expiration')
              ->orWhere('date_expiration', '>', now());
        });
        
        // Trier par date de création (les plus récentes d'abord)
        $query->orderBy('created_at', 'desc');
        
        $offres = $query->paginate(10);
        
        // Récupérer les types de contrats uniques pour le filtre
        $typesContrat = Recrutement::distinct()->pluck('type_contrat');
        
        // Récupérer les lieux uniques pour le filtre
        $lieux = Recrutement::distinct()->pluck('lieu');
        
        return view('etudiants.offres.index', compact('offres', 'typesContrat', 'lieux'));
    }
    
    /**
     * Afficher les détails d'une offre d'emploi
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $offre = Recrutement::with('entreprise')->findOrFail($id);
        
        // Vérifier si l'étudiant a déjà postulé à cette offre
        $aPostule = false;
        if (Auth::check() && Auth::user()->etudiant) {
            $aPostule = Candidature::where('etudiant_id', Auth::user()->etudiant->id)
                                  ->where('recrutement_id', $id)
                                  ->exists();
        }
        
        return view('etudiants.offres.show', compact('offre', 'aPostule'));
    }
    
    /**
     * Afficher le formulaire de candidature
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function postuler($id)
    {
        $offre = Recrutement::with('entreprise')->findOrFail($id);
        
        // Vérifier si l'étudiant a déjà postulé à cette offre
        if (Auth::check() && Auth::user()->etudiant) {
            $aPostule = Candidature::where('etudiant_id', Auth::user()->etudiant->id)
                                  ->where('recrutement_id', $id)
                                  ->exists();
            
            if ($aPostule) {
                return redirect()->route('etudiants.offres.show', $id)
                                ->with('warning', 'Vous avez déjà postulé à cette offre.');
            }
        }
        
        return view('etudiants.offres.postuler', compact('offre'));
    }
    
    /**
     * Soumettre une candidature
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function soumettreCandidature(Request $request, $id)
    {
        $offre = Recrutement::findOrFail($id);
        
        // Validation des données
        $validator = Validator::make($request->all(), [
            'lettre_motivation' => 'required|string|min:100',
            'cv' => 'required|file|mimes:pdf,doc,docx|max:2048',
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()
                            ->withErrors($validator)
                            ->withInput();
        }
        
        // Traitement du fichier CV
        $cvPath = null;
        if ($request->hasFile('cv')) {
            $cvPath = $request->file('cv')->store('cvs', 'public');
        }
        
        // Création de la candidature
        Candidature::create([
            'etudiant_id' => Auth::user()->etudiant->id,
            'recrutement_id' => $id,
            'lettre_motivation' => $request->lettre_motivation,
            'cv_path' => $cvPath,
            'statut' => 'en_attente',
        ]);
        
        return redirect()->route('etudiants.offres.show', $id)
                        ->with('success', 'Votre candidature a été soumise avec succès.');
    }
    
    /**
     * Afficher la liste des candidatures de l'étudiant
     *
     * @return \Illuminate\View\View
     */
    public function mesCandidatures()
    {
        $candidatures = Candidature::with('recrutement.entreprise')
                                  ->where('etudiant_id', Auth::user()->etudiant->id)
                                  ->orderBy('created_at', 'desc')
                                  ->paginate(10);
        
        return view('etudiants.offres.mes-candidatures', compact('candidatures'));
    }
} 