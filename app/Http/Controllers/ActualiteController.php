<?php

namespace App\Http\Controllers;

use App\Models\Actualite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ActualiteController extends Controller
{
    public function index() {
        $actualites = Actualite::paginate(10); // Pagination recommandée
        return view('admin.actualites', compact('actualites'));
    }
    /**
     * Stocker une nouvelle actualité dans la base de données.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

     public function actualites()
     {
         $actualites = Actualite::all(); // Récupération des actualités depuis la base de données
         return view('pages.actualites', compact('actualites')); // Transfert des actualités à la vue
     }
     
     
     
    public function store(Request $request)
    {
        // Validation des données
        $validator = Validator::make($request->all(), [
            'titre' => 'required|string|max:255',
            'contenu' => 'required|string',
            'date_publication' => 'required|date',
            'categorie' => 'nullable|string|max:100',
            'auteur' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Traitement de l'image
        $imagePath = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_actu.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/actualites'), $imageName);
            $imagePath =  $imageName;
        }

        // Création de l'actualité
        $actualite = Actualite::create([
            'titre' => $request->titre,
            'contenu' => $request->contenu,
            'date_publication' => $request->date_publication,
            'categorie' => $request->categorie,
            'auteur' => $request->auteur,
            'image_path' => $imagePath
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Actualité ajoutée avec succès',
            'actualite' => $actualite
        ], 201);
    }

    public function show($id)
{
    $actualite = Actualite::findOrFail($id); // Récupérer l'actualité par son ID
    return view('actualites.show', compact('actualite'));
}

public function destroy($id)
{
    $actualite = Actualite::findOrFail($id); // Récupérer l'actualité par son ID
    $actualite->delete(); // Supprimer l'actualité
    return redirect()->route('admin.actualites')->with('success', 'Actualité supprimée avec succès.');
}


public function edit($id)
{
    $actualite = Actualite::findOrFail($id); // Récupérer l'actualité par son ID
    return view('actualites.edit', compact('actualite'));
}

public function update(Request $request, $id)
    {
        // Validation des données reçues
        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'contenu' => 'required|string',
            'date_publication' => 'required|date',
            'categorie' => 'nullable|string|max:255',
            'image_path' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Récupérer l'actualité à mettre à jour
        $actualite = Actualite::findOrFail($id);

        // Mise à jour des champs
        $actualite->titre = $validated['titre'];
        $actualite->contenu = $validated['contenu'];
        $actualite->date_publication = $validated['date_publication'];
        $actualite->categorie = $validated['categorie'] ?? null;

        // Gestion de l'image si elle a été modifiée
        if ($request->hasFile('image_path')) {
            $image = $request->file('image_path');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/actualites'), $imageName);
            $actualite->image_path = 'images/actualites/' . $imageName;
        }

        // Sauvegarder les modifications
        $actualite->save();

        // Redirection avec un message de succès
        return redirect()->route('admin.dashboard')->with('success', 'Actualité mise à jour avec succès.');
    }

}