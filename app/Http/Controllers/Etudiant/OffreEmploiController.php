<?php

namespace App\Http\Controllers\Etudiant;

use App\Http\Controllers\Controller;
use App\Models\Annonce;
use App\Models\Candidature;
use App\Models\Secteur;
use App\Models\Specialite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
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
        $query = Annonce::with(['entreprise', 'secteur', 'specialite'])
            ->approuve();
        
        // Filtrage par secteur
        if ($request->has('secteur_id') && !empty($request->secteur_id)) {
            $query->where('secteur_id', $request->secteur_id);
        }
        
        // Filtrage par spécialité
        if ($request->has('specialite_id') && !empty($request->specialite_id)) {
            $query->where('specialite_id', $request->specialite_id);
        }
        
        // Filtrage par type de poste
        if ($request->has('type_de_poste') && !empty($request->type_de_poste)) {
            $query->where('type_de_poste', $request->type_de_poste);
        }
        
        // Filtrage par niveau d'étude
        if ($request->has('niveau_detude') && !empty($request->niveau_detude)) {
            $query->where('niveau_detude', $request->niveau_detude);
        }
        
        // Filtrage par lieu
        if ($request->has('lieu') && !empty($request->lieu)) {
            $query->where('lieu', 'like', '%' . $request->lieu . '%');
        }
        
        // Recherche par mot-clé
        if ($request->has('search') && !empty($request->search)) {
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
        $annonce->incrementViews();
        $aPostule = false;
        
        if (Auth::check() && Auth::user()->etudiant) {
            $aPostule = Candidature::where('etudiant_id', Auth::user()->etudiant->id)
                                  ->where('annonce_id', $annonce->id)
                                  ->exists();
        }
        
        $annonce->load('entreprise');
        
        return view('etudiants.offres.show', compact('annonce', 'aPostule'));
    }
    
    /**
     * Afficher le formulaire de candidature
     *
     * @param  \App\Models\Annonce  $annonce
     * @return \Illuminate\View\View
     */
    public function postuler(Annonce $annonce)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('warning', 'Veuillez vous connecter pour postuler à cette offre.');
        }
        
        if (Candidature::where('etudiant_id', Auth::user()->etudiant->id)
                      ->where('annonce_id', $annonce->id)
                      ->exists()) {
            return redirect()->route('etudiants.offres.show', $annonce)
                            ->with('warning', 'Vous avez déjà postulé à cette offre.');
        }
        
        return view('etudiants.offres.postuler', compact('annonce'));
    }
    
    /**
     * Soumettre une candidature
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Annonce  $annonce
     * @return \Illuminate\Http\RedirectResponse
     */
    public function soumettreCandidature(Request $request, Annonce $annonce)
    {
        $validator = Validator::make($request->all(), [
            'lettre_motivation' => 'required|string|min:100',
            'cv' => 'required|file|mimes:pdf,doc,docx|max:2048',
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()
                            ->withErrors($validator)
                            ->withInput();
        }
        
        $cvPath = $request->file('cv')->store('cvs', 'public');
        
        Candidature::create([
            'annonce_id' => $annonce->id,
            'etudiant_id' => Auth::user()->etudiant->id,
            'lettre_motivation' => $request->lettre_motivation,
            'cv_path' => $cvPath,
        ]);
        
        return redirect()->route('etudiants.offres.show', $annonce)
                        ->with('success', 'Votre candidature a été soumise avec succès.');
    }
    
    /**
     * Afficher la liste des candidatures de l'étudiant
     *
     * @return \Illuminate\View\View
     */
    public function mesCandidatures()
    {
        $candidatures = Candidature::with('annonce.entreprise')
                                  ->where('etudiant_id', Auth::user()->etudiant->id)
                                  ->latest()
                                  ->paginate(10);
        
        return view('etudiants.offres.mes-candidatures', compact('candidatures'));
    }
} 