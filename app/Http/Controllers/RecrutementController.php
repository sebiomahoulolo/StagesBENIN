<?php

namespace App\Http\Controllers;

use App\Models\Recrutement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RecrutementController extends Controller
{
    /**
     * Stocker une nouvelle offre de recrutement dans la base de données.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validation des données
        $validator = Validator::make($request->all(), [
            'titre' => 'required|string|max:255',
            'entreprise_id' => 'required|exists:entreprises,id',
            'type_contrat' => 'required|string|max:100',
            'description' => 'required|string',
            'competences_requises' => 'nullable|string',
            'date_debut' => 'nullable|date',
            'lieu' => 'nullable|string|max:255',
            'salaire' => 'nullable|string|max:100',
            'date_expiration' => 'nullable|date'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Création de l'offre de recrutement
        $recrutement = Recrutement::create([
            'titre' => $request->titre,
            'entreprise_id' => $request->entreprise_id,
            'type_contrat' => $request->type_contrat,
            'description' => $request->description,
            'competences_requises' => $request->competences_requises,
            'date_debut' => $request->date_debut,
            'lieu' => $request->lieu,
            'salaire' => $request->salaire,
            'date_expiration' => $request->date_expiration
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Offre de recrutement ajoutée avec succès',
            'recrutement' => $recrutement
        ], 201);
    }
}