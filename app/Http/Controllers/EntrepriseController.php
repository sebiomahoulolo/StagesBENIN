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
         $entreprises = Entreprise::paginate(10);
         return view('entreprises.index', compact('entreprises'));
     }
     
     /**
      * Affiche une entreprise spécifique
      */
     public function show($id)
     {
         $entreprise = Entreprise::findOrFail($id);
         return view('entreprises.show', compact('entreprise'));
     }
     
     /**
      * Affiche le formulaire de contact pour une entreprise
      */
     public function contact($id)
     {
         $entreprise = Entreprise::findOrFail($id);
         return view('entreprises.contact', compact('entreprise'));
     }
     
     /**
      * Permet à un utilisateur de suivre une entreprise
      */
     public function follow($id)
     {
         $entreprise = Entreprise::findOrFail($id);
         // Logique pour suivre l'entreprise
         // Exemple: Auth::user()->entreprisesSuivies()->attach($id);
         
         return redirect()->back()->with('success', 'Vous suivez maintenant cette entreprise');
     }
     
     /**
      * Affiche le formulaire de création d'entreprise
      */
     public function create()
     {
         return view('entreprises.create');
     }
     
     /**
      * Enregistre une nouvelle entreprise
      */
    
     /**
      * Affiche le formulaire d'édition
      */
     public function edit($id)
     {
         $entreprise = Entreprise::findOrFail($id);
         return view('entreprises.edit', compact('entreprise'));
     }
     
     /**
      * Met à jour une entreprise
      */
     public function update(Request $request, $id)
     {
         $entreprise = Entreprise::findOrFail($id);
         
         $validated = $request->validate([
             'nom' => 'required|string|max:255',
             'secteur' => 'required|string|max:255',
             'description' => 'nullable|string',
             'adresse' => 'nullable|string',
             'email' => 'required|email|max:255',
             'telephone' => 'nullable|string|max:20',
             'site_web' => 'nullable|url|max:255',
             'contact_principal' => 'nullable|string|max:255',
             'logo' => 'nullable|image|max:2048',
         ]);
         
         $entreprise->fill($validated);
         
         if ($request->hasFile('logo')) {
             $path = $request->file('logo')->store('logos', 'public');
             $entreprise->logo_path = $path;
         }
         
         $entreprise->save();
         
         return redirect()->route('entreprises.index')
             ->with('success', 'Entreprise mise à jour avec succès');
     }
     
     /**
      * Supprime une entreprise
      */
     public function destroy($id)
     {
         $entreprise = Entreprise::findOrFail($id);
         $entreprise->delete();
         
         return redirect()->route('entreprises.index')
             ->with('success', 'Entreprise supprimée avec succès');
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