<?php

namespace App\Http\Controllers;

use App\Models\CvCompetence;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CvCompetenceController extends Controller
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
            'competence' => 'required|string|max:255',
            'niveau' => 'nullable|string|max:255',
            'categorie' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);

        // Récupérer explicitement le profil de l'utilisateur connecté
        $profil = \App\Models\CvProfil::where('user_id', auth()->id())->first();
        if (!$profil) {
            return back()->withErrors('Aucun profil associé à cet utilisateur.');
        }

        $validated['cv_profil_id'] = $profil->id;

        \App\Models\CvCompetence::create($validated);

        return back()->with('success', 'Compétence ajoutée !');
    }

    /**
     * Display the specified resource.
     */
    public function show(CvCompetence $cvCompetence)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CvCompetence $cvCompetence)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CvCompetence $cvCompetence)
    {
        $validated = $request->validate([
            'competence' => 'required|string|max:255',
            'categorie' => 'nullable|string|max:255',
            'niveau' => 'nullable|integer|min:0|max:100',
        ]);
        $cvCompetence->update($validated);
        return back()->with('success', 'Compétence modifiée !');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $cvCompetence = CvCompetence::findOrFail($id);
        $cvCompetence->delete();
        return back()->with('success', 'Compétence supprimée !');
    }


}
