<?php

namespace App\Http\Controllers\Etudiant;

use App\Http\Controllers\Controller;
use App\Models\ComplaintSuggestion;
use App\Models\Etudiant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ComplaintSuggestionController extends Controller
{
    /**
     * Affiche la liste des plaintes et suggestions de l'étudiant connecté.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $etudiant = Auth::user()->etudiant;
        $query = $etudiant->complaintsSuggestions();
        
        // Filtrer par type (plainte ou suggestion)
        if ($request->filled('type') && in_array($request->type, ['plainte', 'suggestion'])) {
            $query->where('type', $request->type);
        }
        
        // Filtrer par statut
        if ($request->filled('status') && in_array($request->status, ['nouveau', 'en_cours', 'résolu'])) {
            $query->where('statut', $request->status);
        }
        
        // Recherche par texte dans le sujet
        if ($request->filled('search')) {
            $search = '%' . $request->search . '%';
            $query->where('sujet', 'like', $search);
        }
        
        // Tri des résultats
        $sortBy = $request->get('sort_by', 'created_at');
        $sortDir = $request->get('sort_dir', 'desc');
        
        // Liste des colonnes autorisées pour le tri
        $allowedSortColumns = ['id', 'type', 'sujet', 'created_at', 'statut'];
        
        // Vérifier si la colonne de tri est valide
        if (in_array($sortBy, $allowedSortColumns)) {
            $query->orderBy($sortBy, $sortDir === 'asc' ? 'asc' : 'desc');
        } else {
            // Tri par défaut
            $query->orderBy('created_at', 'desc');
        }
        
        $complaintsSuggestions = $query->paginate(10)->withQueryString();

        return view('etudiants.complaints.index', compact('complaintsSuggestions'));
    }

    /**
     * Affiche le formulaire de création d'une nouvelle plainte ou suggestion.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('etudiants.complaints.create');
    }

    /**
     * Enregistre une nouvelle plainte ou suggestion.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'type' => 'required|in:plainte,suggestion',
            'sujet' => 'required|string|max:255',
            'contenu' => 'required|string',
            'is_anonymous' => 'boolean',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $etudiant = Auth::user()->etudiant;
        
        $complainSuggestion = new ComplaintSuggestion();
        $complainSuggestion->type = $request->type;
        $complainSuggestion->sujet = $request->sujet;
        $complainSuggestion->contenu = $request->contenu;
        $complainSuggestion->is_anonymous = $request->has('is_anonymous');
        
        // Gestion de l'upload de la photo de preuve
if ($request->hasFile('photo') && $request->file('photo')->isValid()) {
    // Chemin de destination dans le dossier public
    $destinationPath = public_path('assets/complaints');

    // Créer le dossier s'il n'existe pas
    if (!file_exists($destinationPath)) {
        mkdir($destinationPath, 0755, true);
    }

    // Générer un nom unique pour la photo
    $fileName = time() . '_' . $request->file('photo')->getClientOriginalName();

    // Déplacer le fichier vers le dossier public
    $request->file('photo')->move($destinationPath, $fileName);

    // Stocker le chemin relatif dans la base de données
    $complainSuggestion->photo_path = 'complaints/' . $fileName;
}

        
        // Si non anonyme, associer à l'étudiant
        if (!$complainSuggestion->is_anonymous) {
            $complainSuggestion->etudiant_id = $etudiant->id;
        }
        
        $complainSuggestion->save();

        return redirect()->route('etudiants.complaints.index')
            ->with('success', 'Votre ' . ($request->type === 'plainte' ? 'plainte' : 'suggestion') . ' a été soumise avec succès.');
    }

    /**
     * Affiche les détails d'une plainte ou suggestion spécifique.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $etudiant = Auth::user()->etudiant;
        $complaintSuggestion = ComplaintSuggestion::findOrFail($id);
        
        // Vérifier si l'étudiant est autorisé à voir cette plainte/suggestion
        if ($complaintSuggestion->etudiant_id !== $etudiant->id) {
            return redirect()->route('etudiants.complaints.index')
                ->with('error', 'Vous n\'êtes pas autorisé à accéder à cette ressource.');
        }

        return view('etudiants.complaints.show', compact('complaintSuggestion'));
    }

    /**
     * Supprime une plainte ou suggestion.
     * (Seulement si elle n'est pas encore traitée)
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $etudiant = Auth::user()->etudiant;
        $complaintSuggestion = ComplaintSuggestion::findOrFail($id);
        
        // Vérifier si l'étudiant est autorisé à supprimer cette plainte/suggestion
        if ($complaintSuggestion->etudiant_id !== $etudiant->id) {
            return redirect()->route('etudiants.complaints.index')
                ->with('error', 'Vous n\'êtes pas autorisé à effectuer cette action.');
        }
        
        // Vérifier si la plainte/suggestion n'est pas encore traitée
        if ($complaintSuggestion->statut !== 'nouveau') {
            return redirect()->route('etudiants.complaints.index')
                ->with('error', 'Vous ne pouvez pas supprimer une plainte ou suggestion qui est déjà en cours de traitement.');
        }
        
        // Supprimer la photo s'il y en a une
        if ($complaintSuggestion->photo_path) {
            Storage::disk('public')->delete($complaintSuggestion->photo_path);
        }
        
        $complaintSuggestion->delete();
        
        return redirect()->route('etudiants.complaints.index')
            ->with('success', 'Votre plainte/suggestion a été supprimée avec succès.');
    }
}
