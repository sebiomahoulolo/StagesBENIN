<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Annonce;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnnonceController extends Controller
{
    public function index(Request $request)
    {
        $query = Annonce::with(['entreprise', 'admin']);
        
        // Filtrage par statut
        if ($request->has('statut') && in_array($request->statut, ['en_attente', 'approuve', 'rejete'])) {
            $query->where('statut', $request->statut);
        }
        
        $annonces = $query->latest()->paginate(10)->withQueryString();

        return view('admin.annonces.index', compact('annonces'));
    }

    public function show(Annonce $annonce)
    {
        // Préchargement explicite de la relation entreprise et autres relations nécessaires
        $annonce->load(['entreprise', 'secteur', 'specialite', 'admin']);
        
        $candidatures = $annonce->candidatures()
                               ->with('etudiant.user', 'etudiant.specialite')
                               ->latest()
                               ->paginate(10);

        return view('admin.annonces.show', compact('annonce', 'candidatures'));
    }

    public function approuver(Annonce $annonce)
    {
        $annonce->update([
            'statut' => 'approuve',
            'admin_id' => Auth::id(),
        ]);

        return redirect()->route('admin.annonces.show', $annonce)
                        ->with('success', 'L\'annonce a été approuvée avec succès.');
    }

    public function rejeter(Request $request, Annonce $annonce)
    {
        try {
            $validated = $request->validate([
                'motif_rejet' => 'required|string|min:10',
                'annonce_id' => 'sometimes|exists:annonces,id'
            ], [
                'motif_rejet.required' => 'Le motif de rejet est obligatoire.',
                'motif_rejet.min' => 'Le motif de rejet doit contenir au moins 10 caractères.'
            ]);

            $annonce->update([
                'statut' => 'rejete',
                'motif_rejet' => $validated['motif_rejet'],
                'admin_id' => Auth::id(),
            ]);

            return redirect()->route('admin.annonces.show', $annonce)
                            ->with('success', 'L\'annonce a été rejetée avec succès.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                            ->withErrors($e->validator)
                            ->withInput()
                            ->with('error', 'Erreur lors du rejet de l\'annonce. Veuillez vérifier le motif de rejet.');
        } catch (\Exception $e) {
            return redirect()->back()
                            ->with('error', 'Une erreur inattendue s\'est produite: ' . $e->getMessage());
        }
    }

    public function create()
    {
        $entreprises = \App\Models\Entreprise::all();
        $specialites = \App\Models\Specialite::with('secteur')->get();
        
        return view('admin.annonces.create', compact('entreprises', 'specialites'));
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'entreprise_id' => 'required|exists:entreprises,user_id',
                'nom_du_poste' => 'required|string|max:255',
                'type_de_poste' => 'required|string|max:255',
                'nombre_de_place' => 'required|integer|min:1',
                'niveau_detude' => 'required|string|max:255',
                'specialite_id' => 'required|exists:specialites,id',
                'lieu' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'date_cloture' => 'required|date|after:today',
                'description' => 'required|string',
                'pretension_salariale' => 'nullable|numeric|min:0',
            ]);

            // Récupérer le secteur_id à partir de la spécialité sélectionnée
            $specialite = \App\Models\Specialite::findOrFail($validated['specialite_id']);
            
            // Créer l'annonce avec le statut directement approuvé
            $annonce = new \App\Models\Annonce($validated);
            $annonce->entreprise_id = $validated['entreprise_id'];
            $annonce->secteur_id = $specialite->secteur_id;
            $annonce->statut = 'approuve'; // Statut directement approuvé
            $annonce->admin_id = auth()->id(); // Admin qui a créé l'annonce
            $annonce->est_active = true;
            $annonce->save();

            return redirect()->route('admin.annonces.index')
                ->with('success', 'Annonce créée et approuvée avec succès.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput()
                ->with('error', 'Erreur lors de la création de l\'annonce. Veuillez vérifier les informations saisies.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Une erreur inattendue s\'est produite: ' . $e->getMessage());
        }
    }
} 