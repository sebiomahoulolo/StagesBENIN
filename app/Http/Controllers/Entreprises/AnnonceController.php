<?php

namespace App\Http\Controllers\Entreprises;

use App\Http\Controllers\Controller;
use App\Models\Annonce;
use App\Models\Secteur;
use App\Models\Specialite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnnonceController extends Controller
{
    public function index()
    {
        // Vérifier si l'utilisateur a une entreprise
        if (!Auth::user()->entreprise) {
            return redirect()->back()->with('error', 'Vous devez avoir une entreprise associée à votre compte.');
        }

        $annonces = Annonce::where('entreprise_id', Auth::user()->entreprise->user_id)
            ->with(['candidatures', 'entreprise', 'secteur', 'specialite'])
            ->latest()
            ->paginate(10);

        return view('entreprises.annonces.index', compact('annonces'));
    }

    public function create()
    {
        $specialites = Specialite::all();
        return view('entreprises.annonces.create', compact('specialites'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom_du_poste' => 'required|string|max:255',
            'type_de_poste' => 'required|string|max:255',
            'nombre_de_place' => 'required|integer|min:1',
            'niveau_detude' => 'required|string|max:255',
            'specialite_id' => 'required|exists:specialites,id',
            'lieu' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'date_cloture' => 'required|date|after:today',
            'description' => 'required|string',
            'pretension_salariale' => 'nullable|numeric|min:0',
        ]);

        // Vérifier que l'utilisateur a une entreprise
        if (!Auth::user()->entreprise) {
            return redirect()->back()->with('error', 'Vous devez avoir une entreprise associée à votre compte pour créer une annonce.');
        }

        // Récupérer le secteur_id à partir de la spécialité sélectionnée
        $specialite = Specialite::findOrFail($validated['specialite_id']);
        $validated['secteur_id'] = $specialite->secteur_id;

        $annonce = new Annonce($validated);
        $annonce->entreprise_id = Auth::user()->entreprise->user_id;
        $annonce->statut = 'en_attente';
        $annonce->est_active = true;
        $annonce->save();

        return redirect()->route('entreprises.annonces.index')
            ->with('success', 'Annonce créée avec succès. Elle sera publiée après validation.');
    }

    public function show(Annonce $annonce)
    {
        $this->authorize('view', $annonce);
        
        $annonce->load(['candidatures.etudiant', 'secteur', 'specialite']);
        return view('entreprises.annonces.show', compact('annonce'));
    }

    public function edit(Annonce $annonce)
    {
        $this->authorize('update', $annonce);
        $secteurs = Secteur::all();
        $specialites = Specialite::where('secteur_id', $annonce->secteur_id)->get();
        return view('entreprises.annonces.edit', compact('annonce', 'secteurs', 'specialites'));
    }

    public function update(Request $request, Annonce $annonce)
    {
        $this->authorize('update', $annonce);

        $validated = $request->validate([
            'nom_du_poste' => 'required|string|max:255',
            'type_de_poste' => 'required|string|max:255',
            'nombre_de_place' => 'required|integer|min:1',
            'niveau_detude' => 'required|string|max:255',
            'secteur_id' => 'required|exists:secteurs,id',
            'specialite_id' => 'required|exists:specialites,id',
            'lieu' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'date_cloture' => 'required|date|after:today',
            'description' => 'required|string',
            'pretension_salariale' => 'nullable|numeric|min:0',
        ]);

        $annonce->update($validated);

        return redirect()->route('entreprises.annonces.index')
            ->with('success', 'Annonce mise à jour avec succès.');
    }

    public function destroy(Annonce $annonce)
    {
        $this->authorize('delete', $annonce);
        
        $annonce->delete();
        return redirect()->route('entreprises.annonces.index')
            ->with('success', 'Annonce supprimée avec succès.');
    }

    public function getSpecialites(Secteur $secteur)
    {
        return response()->json($secteur->specialites);
    }
} 