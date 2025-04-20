<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ComplaintSuggestion;
use App\Models\Etudiant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ComplaintSuggestionController extends Controller
{
    /**
     * Affiche la liste de toutes les plaintes et suggestions.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $complaintsSuggestions = ComplaintSuggestion::with('etudiant')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('admin.complaints.index', compact('complaintsSuggestions'));
    }

    /**
     * Affiche les détails d'une plainte ou suggestion spécifique.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $complaintSuggestion = ComplaintSuggestion::with('etudiant')->findOrFail($id);
        return view('admin.complaints.show', compact('complaintSuggestion'));
    }

    /**
     * Affiche le formulaire pour répondre à une plainte ou suggestion.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $complaintSuggestion = ComplaintSuggestion::findOrFail($id);
        return view('admin.complaints.edit', compact('complaintSuggestion'));
    }

    /**
     * Met à jour une plainte ou suggestion avec la réponse de l'administrateur.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'statut' => 'required|in:nouveau,en_cours,résolu',
            'reponse' => 'required_if:statut,résolu|string|nullable',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $complaintSuggestion = ComplaintSuggestion::findOrFail($id);
        $complaintSuggestion->statut = $request->statut;
        
        if ($request->has('reponse')) {
            $complaintSuggestion->reponse = $request->reponse;
        }
        
        $complaintSuggestion->save();

        return redirect()->route('admin.complaints.index')
            ->with('success', 'La plainte/suggestion a été mise à jour avec succès.');
    }

    /**
     * Supprime une plainte ou suggestion.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $complaintSuggestion = ComplaintSuggestion::findOrFail($id);
        $complaintSuggestion->delete();
        
        return redirect()->route('admin.complaints.index')
            ->with('success', 'La plainte/suggestion a été supprimée avec succès.');
    }
    
    /**
     * Filtre les plaintes et suggestions par type ou statut.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function filter(Request $request)
    {
        $query = ComplaintSuggestion::with('etudiant')->orderBy('created_at', 'desc');
        
        // Filtrer par type
        if ($request->filled('type') && in_array($request->type, ['plainte', 'suggestion'])) {
            $query->where('type', $request->type);
        }
        
        // Filtrer par statut
        if ($request->filled('statut') && in_array($request->statut, ['nouveau', 'en_cours', 'résolu'])) {
            $query->where('statut', $request->statut);
        }
        
        // Filtrer par date (si implémenté dans le futur)
        if ($request->filled('date_debut') && $request->filled('date_fin')) {
            try {
                $dateDebut = \Carbon\Carbon::createFromFormat('Y-m-d', $request->date_debut)->startOfDay();
                $dateFin = \Carbon\Carbon::createFromFormat('Y-m-d', $request->date_fin)->endOfDay();
                $query->whereBetween('created_at', [$dateDebut, $dateFin]);
            } catch (\Exception $e) {
                // Log l'erreur ou ignorer simplement
            }
        }
        
        // Recherche par texte (dans le sujet ou le contenu)
        if ($request->filled('recherche')) {
            $recherche = '%' . $request->recherche . '%';
            $query->where(function($q) use ($recherche) {
                $q->where('sujet', 'like', $recherche)
                  ->orWhere('contenu', 'like', $recherche);
            });
        }
        
        // Pagination avec préservation des paramètres de filtrage
        $complaintsSuggestions = $query->paginate(15)->appends($request->except('page'));
        
        // Passer les paramètres actuels à la vue pour maintenir les filtres sélectionnés
        return view('admin.complaints.index', compact('complaintsSuggestions'))
            ->with('filtres', $request->all());
    }
}
