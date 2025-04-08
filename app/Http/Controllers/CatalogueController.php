<?php

namespace App\Http\Controllers;

use App\Models\Catalogue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CatalogueController extends Controller
{
    /**
     * Stocker une nouvelle formation dans le catalogue.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validation des données
        $validator = Validator::make($request->all(), [
            'titre' => 'required|string|max:255',
            'description' => 'required|string',
            'duree' => 'nullable|string|max:100',
            'type' => 'nullable|string|max:100',
            'niveau' => 'nullable|string|max:100',
            'pre_requis' => 'nullable|string',
            'contenu' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Traitement de l'image
        $imagePath = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_formation.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/formations'), $imageName);
            $imagePath =  $imageName;
        }

        // Création de la formation
        $formation = Catalogue::create([
            'titre' => $request->titre,
            'description' => $request->description,
            'duree' => $request->duree,
            'type' => $request->type,
            'niveau' => $request->niveau,
            'pre_requis' => $request->pre_requis,
            'contenu' => $request->contenu,
            'image_path' => $imagePath
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Formation ajoutée avec succès',
            'formation' => $formation
        ], 201);
    }
}