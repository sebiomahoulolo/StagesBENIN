<?php

namespace App\Http\Controllers;

use App\Models\Etudiant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EtudiantController extends Controller
{
    /**
     * Stocker un nouvel étudiant dans la base de données.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */



     public function index()
     {
         // Afficher l'espace étudiant
         return view('etudiants.dashboard');
     }
 
     public function searchInternships()
     {
         // Rechercher des stages
         return view('etudiants.search_internships');
     }


     public function store(Request $request)
    {
        // Validation des données
        $validator = Validator::make($request->all(), [
            'nom' => 'required|string|max:100',
            'prenom' => 'required|string|max:100',
            'email' => 'required|email|unique:etudiants,email|max:255',
            'telephone' => 'nullable|string|max:20',
            'formation' => 'nullable|string|max:255',
            'niveau' => 'nullable|string|max:50',
            'date_naissance' => 'nullable|date',
            'cv' => 'nullable|file|mimes:pdf|max:5120',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Traitement du CV
        $cvPath = null;
        if ($request->hasFile('cv')) {
            $cv = $request->file('cv');
            $cvName = time() . '_' . $request->nom . '_' . $request->prenom . '.' . $cv->getClientOriginalExtension();
            $cv->move(public_path('documents/cv'), $cvName);
            $cvPath =  $cvName;
        }

        // Traitement de la photo
        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $photoName = time() . '_' . $request->nom . '_' . $request->prenom . '.' . $photo->getClientOriginalExtension();
            $photo->move(public_path('images/etudiants'), $photoName);
            $photoPath = $photoName;
        }

        // Création de l'étudiant
        $etudiant = Etudiant::create([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'email' => $request->email,
            'telephone' => $request->telephone,
            'formation' => $request->formation,
            'niveau' => $request->niveau,
            'date_naissance' => $request->date_naissance,
            'cv_path' => $cvPath,
            'photo_path' => $photoPath
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Étudiant ajouté avec succès',
            'etudiant' => $etudiant
        ], 201);
    }
}