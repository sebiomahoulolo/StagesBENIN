<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\File;

use App\Models\Catalogue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CatalogueController extends Controller
{
    /**
     * Stocke un nouveau catalogue.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    
    public function store(Request $request)
    {
        // Validation des données
        $validator = Validator::make($request->all(), [
            'titre' => 'required|string|max:255',
            'description' => 'required|string',
            'localisation' => 'nullable|string|max:255',
            'nb_activites' => 'nullable|integer',
            'activite_principale' => 'nullable|string|max:255',
            'desc_activite_principale' => 'nullable|string',
            'activite_secondaire' => 'nullable|string|max:255',
            'desc_activite_secondaire' => 'nullable|string',
            'autres' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }
    
        // Vérifie que le dossier existe, sinon le créer
        $destinationPath = public_path('assets/images/formations');
        if (!File::exists($destinationPath)) {
            File::makeDirectory($destinationPath, 0755, true);
        }
    
        // Traitement du logo
        $logoPath = null;
        if ($request->hasFile('logo')) {
            $logo = $request->file('logo');
            $logoName = uniqid('logo_', true) . '.' . $logo->getClientOriginalExtension();
            $logo->move($destinationPath, $logoName);
            $logoPath = $logoName;
        }
    
        // Traitement de l'image
        $imagePath = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = uniqid('bg_', true) . '.' . $image->getClientOriginalExtension();
            $image->move($destinationPath, $imageName);
            $imagePath =  $imageName;
        }
    
        // Création du catalogue
        $catalogue = Catalogue::create([
            'titre' => $request->input('titre'),
            'description' => $request->input('description'),
            'localisation' => $request->input('localisation'),
            'nb_activites' => $request->input('nb_activites'),
            'activite_principale' => $request->input('activite_principale'),
            'desc_activite_principale' => $request->input('desc_activite_principale'),
            'activite_secondaire' => $request->input('activite_secondaire'),
            'desc_activite_secondaire' => $request->input('desc_activite_secondaire'),
            'autres' => $request->input('autres'),
            'logo' => $logoPath,
            'image' => $imagePath,
        ]);
    
        return response()->json([
            'success' => true,
            'message' => 'Catalogue enregistré avec succès.',
            'catalogue' => $catalogue,
        ], 201);
    }
    


public function destroy($id)
{
    $catalogue = Catalogue::findOrFail($id);
    $catalogue->delete();

    return redirect()->route('admin.dashboard')->with('success', 'Catalogue supprimé avec succès.');
}

public function edit($id)
{
    // Cherchez l'entrée du catalogue selon l'ID
    $catalogue = Catalogue::findOrFail($id);

    // Retournez une vue pour éditer le catalogue
    return view('catalogue.edit', compact('catalogue'));
}

public function update(Request $request, $id)
{
    // Validation des données
    $request->validate([
        'titre' => 'required|string|max:255',
        'description' => 'required|string',
        'localisation' => 'nullable|string|max:255',
        'nb_activites' => 'nullable|integer',
        'activite_principale' => 'nullable|string|max:255',
        'desc_activite_principale' => 'nullable|string',
        'activite_secondaire' => 'nullable|string|max:255',
        'desc_activite_secondaire' => 'nullable|string',
        'autres' => 'nullable|string',
        'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
    ]);

    // Mettez à jour le catalogue
    $catalogue = Catalogue::findOrFail($id);
    $catalogue->update($request->all());

    // Redirigez avec un message de succès
    return redirect()->route('admin.dashboard')->with('success', 'Catalogue mis à jour avec succès.');
}


}
