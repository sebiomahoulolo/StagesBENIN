<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Candidature;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CandidatureController extends Controller
{
    public function updateStatut(Request $request, Candidature $candidature)
    {
        // Valider les données du formulaire
        $validated = $request->validate([
            'statut' => 'required|in:en_attente,en_cours,accepte,rejete',
            'motif_rejet' => 'required_if:statut,rejete|nullable|string|min:10',
        ], [
            'statut.required' => 'Le statut est requis.',
            'statut.in' => 'Le statut doit être valide.',
            'motif_rejet.required_if' => 'Le motif de rejet est requis lorsque le statut est "Rejetée".',
            'motif_rejet.min' => 'Le motif de rejet doit contenir au moins 10 caractères.',
        ]);

        // Mettre à jour le statut de la candidature
        $candidature->statut = $validated['statut'];
        
        // Si le statut est "rejete", mettre à jour le motif de rejet
        if ($validated['statut'] === 'rejete') {
            $candidature->motif_rejet = $validated['motif_rejet'];
        } elseif ($validated['statut'] !== 'rejete') {
            // Si le statut n'est plus "rejete", effacer le motif de rejet
            $candidature->motif_rejet = null;
        }
        
        $candidature->save();
        
        return redirect()->back()->with('success', 'Le statut de la candidature a été mis à jour avec succès.');
    }
    
    public function show(Candidature $candidature)
    {
        // Charger les relations nécessaires
        $candidature->load(['annonce', 'etudiant.user', 'etudiant.specialite']);
        
        return view('admin.candidatures.show', compact('candidature'));
    }
} 