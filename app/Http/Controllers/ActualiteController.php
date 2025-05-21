<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Actualite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage; // Correction : `Illuminate\Http\Storage` n'existe pas
use Illuminate\Support\Facades\Auth;

class ActualiteController extends Controller
{
    public function index() {
        $actualites = Actualite::paginate(10);
         // Pagination recommandée
        return view('admin.actualites', compact('actualites'));
    }
        public function indexPublic(Request $request)
    {
        // Start query for published items
        $query = Actualite::where('status', Actualite::STATUS_PUBLISHED);

        if ($request->filled('keyword')) {
            $keyword = $request->input('keyword');
            $query->where(function ($q) use ($keyword) {
                $q->where('autorite_contractante', 'like', "%{$keyword}%")
                  ->orWhere('details', 'like', "%{$keyword}%")
                  ->orWhere('titre', 'like', "%{$keyword}%")
                  ->orWhere('document_titre', 'like', "%{$keyword}%");
            });
        }

        if ($request->filled('gestion') && is_numeric($request->input('gestion'))) {
            $query->where('gestion', $request->input('gestion'));
        }

        if ($request->filled('autorite')) {
            $query->where('autorite_contractante', 'like', '%' . $request->input('autorite') . '%');
        }

        $actualites = $query->latest('date_publication')->paginate(10)->withQueryString();
        $categories = Category::all();

        return view('pages.actualites', compact('actualites', 'categories'));
    }
    
    /**
     * Stocker une nouvelle actualité dans la base de données.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

     public function actualites()
     {
        $actualites = Actualite::latest()->paginate(10);
 // Récupération des actualités depuis la base de données
         return view('pages.actualites', compact('actualites')); // Transfert des actualités à la vue
     }
     
     
     

    public function show($id)
{
    $actualite = Actualite::findOrFail($id); // Récupérer l'actualité par son ID
    return view('actualites.show', compact('actualite'));
}




public function store(Request $request)
    {
        $validated = $request->validate([
            'autorite_contractante' => 'required|string|max:255',
            'gestion' => 'required|integer|min:2000|max:' . (date('Y') + 5),
            'details' => 'required|string|max:65535',
            'montant' => 'nullable|numeric|min:0',
            'type_marche' => 'required|string|max:100',
            'mode_passation' => 'required|string|max:100',
            'document_titre' => 'nullable|string|max:255',
            'document_pdf' => 'nullable|file|mimes:pdf|max:10240',
            'document_contenu' => 'nullable|string|max:65535',
            'date_publication' => 'required|date',
            'categorie' => 'required|string|max:255', // Modifier pour utiliser l'ID de la catégorie
            'user_id' => 'nullable|exists:users,id',
            'status' => 'required|in:'.Actualite::STATUS_DRAFT.','.Actualite::STATUS_PUBLISHED,
        ]);

        $documentPath = null;
        if ($request->hasFile('document_pdf')) {
            $documentPath = $request->file('document_pdf')->store('marches_docs', 'public');
            if (!$documentPath) {
                 return redirect()->back()->with('error', 'Erreur lors du téléchargement du document.')->withInput();
            }
        }

        $marche = new Actualite();
        // Map basic fields
        $marche->autorite_contractante = $validated['autorite_contractante'];
        $marche->gestion = $validated['gestion'];
        $marche->details = $validated['details'];
        $marche->montant = $validated['montant'] ?? null;
        $marche->type_marche = $validated['type_marche'];
        $marche->mode_passation = $validated['mode_passation'];
        $marche->document_titre = $validated['document_titre'] ?? null;
        $marche->document_path = $documentPath;
        $marche->document_contenu = $validated['document_contenu'] ?? null;
        $marche->date_publication = $validated['date_publication'];
        $marche->categorie = $validated['categorie']; // Utiliser l'ID de la catégorie
        $marche->status = $validated['status'];

        // Set titre
        $marche->titre = $validated['document_titre'] ?? Str::limit($validated['details'], 100);

        // --- Set auteur_id based on status ---
        if ($validated['status'] === Actualite::STATUS_PUBLISHED) {
            $marche->auteur_id = $validated['auteur_id'] ?? Auth::id();
        } else {
            $marche->auteur_id = null;
        }

        $marche->save();

        return redirect()->route('admin.actualites')
                         ->with('success', 'Nouveau marché public enregistré avec succès.');
    }

     /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $marche = Actualite::findOrFail($id);

        $validated = $request->validate([
            'autorite_contractante' => 'required|string|max:255',
            'gestion' => 'required|integer|min:2000|max:' . (date('Y') + 5),
            'details' => 'required|string|max:65535',
            'montant' => 'nullable|numeric|min:0',
            'type_marche' => 'required|string|max:100',
            'mode_passation' => 'required|string|max:100',
            'document_titre' => 'nullable|string|max:255',
            'document_pdf' => 'nullable|file|mimes:pdf|max:10240',
            'document_contenu' => 'nullable|string|max:65535',
            'date_publication' => 'required|date',
            'categorie' => 'required|string|max:255', // Modifier pour utiliser l'ID de la catégorie
            'auteur_id' => 'nullable|exists:users,id',
            'status' => 'required|in:'.Actualite::STATUS_DRAFT.','.Actualite::STATUS_PUBLISHED,
        ]);

        // Handle File Upload
        if ($request->hasFile('document_pdf')) {
            if ($marche->document_path && Storage::disk('public')->exists($marche->document_path)) {
                Storage::disk('public')->delete($marche->document_path);
            }
            $documentPath = $request->file('document_pdf')->store('marches_docs', 'public');
            if (!$documentPath) {
                return redirect()->back()->with('error', 'Erreur lors du remplacement du document.')->withInput();
            }
            $marche->document_path = $documentPath;
        }

        // Update fields
        $marche->autorite_contractante = $validated['autorite_contractante'];
        $marche->gestion = $validated['gestion'];
        $marche->details = $validated['details'];
        $marche->montant = $validated['montant'] ?? null;
        $marche->type_marche = $validated['type_marche'];
        $marche->mode_passation = $validated['mode_passation'];
        $marche->document_titre = $validated['document_titre'] ?? null;
        $marche->document_contenu = $validated['document_contenu'] ?? null;
        $marche->date_publication = $validated['date_publication'];
        $marche->categorie = $validated['categorie']; // Utiliser l'ID de la catégorie
        $marche->status = $validated['status'];

        // Update titre
        $marche->titre = $validated['document_titre'] ?? Str::limit($validated['details'], 100);

        // --- Update auteur_id based on new status ---
        if ($validated['status'] === Actualite::STATUS_PUBLISHED) {
            $marche->auteur_id = $validated['auteur_id'] ?? $marche->auteur_id ?? Auth::id();
        } else {
            $marche->auteur_id = null;
        }

        $marche->save();

        return redirect()->route('admin.actualites')
                         ->with('success', 'Marché public mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $marche = Actualite::findOrFail($id);

        // Delete associated document file
        if ($marche->document_path && Storage::disk('public')->exists($marche->document_path)) {
            Storage::disk('public')->delete($marche->document_path);
        }

        $marche->delete();

        return redirect()->route('admin.actualites')
                         ->with('success', 'Marché public supprimé avec succès.');
    }

    // Add show() and edit() methods if needed
   
    public function updateStatus(Request $request, $id)
    {
        $marche = Actualite::findOrFail($id);
        $marche->status = $request->new_status;
        $marche->save();
    
        return redirect()->route('admin.actualites')
                         ->with('success', 'Statut mis à jour avec succès.');
    }


}