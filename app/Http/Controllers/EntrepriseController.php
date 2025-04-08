<?php

namespace App\Http\Controllers;

use App\Models\Entreprise;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EntrepriseController extends Controller
{
    /**
     * Stocker une nouvelle entreprise dans la base de données.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */


     public function index()
     {
         // Afficher l'espace entreprise
         return view('entreprises.dashboard');
     }
 
     public function postJobOffer()
     {
         // Publier une offre de stage ou d'emploi
         return view('entreprises.post_job_offer');
     }



    public function store(Request $request)
    {
        // Validation des données
        $validator = Validator::make($request->all(), [
            'nom' => 'required|string|max:255',
            'secteur' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'adresse' => 'nullable|string',
            'email' => 'required|email|max:255',
            'telephone' => 'nullable|string|max:20',
            'site_web' => 'nullable|url|max:255',
            'contact_principal' => 'nullable|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Traitement du logo
        $logoPath = null;
        if ($request->hasFile('logo')) {
            $logo = $request->file('logo');
            $logoName = time() . '_' . str_replace(' ', '_', $request->nom) . '.' . $logo->getClientOriginalExtension();
            $logo->move(public_path('images/entreprises'), $logoName);
            $logoPath =  $logoName;
        }

        // Création de l'entreprise
        $entreprise = Entreprise::create([
            'nom' => $request->nom,
            'secteur' => $request->secteur,
            'description' => $request->description,
            'adresse' => $request->adresse,
            'email' => $request->email,
            'telephone' => $request->telephone,
            'site_web' => $request->site_web,
            'contact_principal' => $request->contact_principal,
            'logo_path' => $logoPath
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Entreprise ajoutée avec succès',
            'entreprise' => $entreprise
        ], 201);
    }
}