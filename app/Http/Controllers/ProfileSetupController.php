<?php

namespace App\Http\Controllers;

use App\Models\Secteur;
use App\Models\Specialite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileSetupController extends Controller
{
    public function showEtudiantSetup()
    {
        $specialites = Specialite::all();
        $user = Auth::user();
        $etudiant = $user->etudiant;
        
        return view('profile.setup.etudiant', compact('specialites', 'etudiant'));
    }

    public function showRecruteurSetup()
    {
        $specialites = Specialite::all();
        $user = Auth::user();
        $entreprise = $user->entreprise;
        
        return view('profile.setup.recruteur', compact('specialites', 'entreprise'));
    }

    public function saveEtudiantProfile(Request $request)
    {
        $request->validate([
            'formation' => 'required|string|max:255',
            'niveau' => 'required|string|max:50',
            'date_naissance' => 'required|date',
            'specialite_id' => 'required|exists:specialites,id',
            'photo' => 'nullable|image|max:2048',
        ]);

        $etudiant = Auth::user()->etudiant;
        
        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $photoPath = $photo->store('photos/etudiants', 'public');
            $etudiant->photo_path = $photoPath;
        }

        $specialite = Specialite::findOrFail($request->specialite_id);

        $etudiant->update([
            'formation' => $request->formation,
            'niveau' => $request->niveau,
            'date_naissance' => $request->date_naissance,
            'specialite_id' => $request->specialite_id,
        ]);

        return redirect()->route('etudiants.dashboard')->with('success', 'Profil configuré avec succès!');
    }

    public function saveRecruteurProfile(Request $request)
    {
        $request->validate([
            'specialite_id' => 'required|exists:specialites,id',
            'description' => 'required|string',
            'adresse' => 'required|string',
            'site_web' => 'nullable|url|max:255',
            'contact_principal' => 'required|string|max:255',
            'logo' => 'nullable|image|max:2048',
        ]);

        $entreprise = Auth::user()->entreprise;
        
        if ($request->hasFile('logo')) {
            $logo = $request->file('logo');
            $logoPath = $logo->store('logos/entreprises', 'public');
            $entreprise->logo_path = $logoPath;
        }

        // Récupérer la spécialité et son secteur associé
        $specialite = Specialite::findOrFail($request->specialite_id);

        $entreprise->update([
            'secteur' => $specialite->secteur->nom, // On stocke le nom du secteur
            'description' => $request->description,
            'adresse' => $request->adresse,
            'site_web' => $request->site_web,
            'contact_principal' => $request->contact_principal,
        ]);

        return redirect()->route('entreprises.dashboard')->with('success', 'Profil configuré avec succès!');
    }

    public function getSpecialites($secteurId)
    {
        $specialites = Specialite::where('secteur_id', $secteurId)->get();
        return response()->json($specialites);
    }
}
