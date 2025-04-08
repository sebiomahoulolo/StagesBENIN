<?php

namespace App\Http\Controllers;

use App\Models\Actualite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ActualiteController extends Controller
{
    /**
     * Stocker une nouvelle actualité dans la base de données.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
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
}