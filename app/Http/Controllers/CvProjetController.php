<?php

namespace App\Http\Controllers;

use App\Models\CvProjet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CvProjetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'required|string',
            'technologies' => 'nullable|string',
            'lien' => 'nullable|string',
            'date_debut' => 'nullable|date',
            'date_fin' => 'nullable|date',
            'is_current' => 'nullable|boolean',
        ]);

        // Récupérer explicitement le profil de l'utilisateur connecté
        $profil = \App\Models\CvProfil::where('user_id', auth()->id())->first();
        if (!$profil) {
            return back()->withErrors('Aucun profil associé à cet utilisateur.');
        }

        $validated['cv_profil_id'] = $profil->id;

        \App\Models\CvProjet::create($validated);

        return back()->with('success', 'Projet ajouté !');
    }

    /**
     * Display the specified resource.
     */
    public function show(CvProjet $cvProjet)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CvProjet $cvProjet)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CvProjet $cvProjet)
    {
        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'required|string',
            'technologies' => 'nullable|string',
            'lien' => 'nullable|string',
            'date_debut' => 'nullable|date',
            'date_fin' => 'nullable|date',
            'is_current' => 'nullable|boolean',
        ]);
        $cvProjet->update($validated);
        return back()->with('success', 'Projet modifié !');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
         $cvProjet = CvProjet::findOrFail($id);
        $cvProjet->delete();
        return back()->with('success', 'Projet supprimé !');
    }

 
}

