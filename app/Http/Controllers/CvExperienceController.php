<?php

namespace App\Http\Controllers;

use App\Models\CvExperience;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CvExperienceController extends Controller
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
        $request->validate([
            'poste' => 'required|string|max:255',
            'entreprise' => 'required|string|max:255',
            'ville' => 'nullable|string|max:255',
            'date_debut' => 'required',
            'date_fin' => 'nullable',
            'description' => 'nullable|string',
            'contrat_type' => 'nullable|string',
            'secteur_activite' => 'nullable|string',
            'url_entreprise' => 'nullable|string',
            'url_poste' => 'nullable|string',
        ]);

        $profil = Auth::user()->cvProfil ?? null;
        if (!$profil) {
            return back()->withErrors('Aucun profil associé à cet utilisateur.');
        }

        CvExperience::create([
            'cv_profil_id' => $profil->id,
            'poste' => $request->input('poste'),
            'entreprise' => $request->input('entreprise'),
            'ville' => $request->input('ville'),
            'date_debut' => $request->input('date_debut'),
            'date_fin' => $request->input('date_fin'),
            'description' => $request->input('description'),
            'contrat_type' => $request->input('contrat_type'),
            'secteur_activite' => $request->input('secteur_activite'),
            'url_entreprise' => $request->input('url_entreprise'),
            'url_poste' => $request->input('url_poste'),
        ]);

        return back()->with('success', 'Expérience ajoutée !');
    }

    /**
     * Display the specified resource.
     */
    public function show(CvExperience $cvExperience)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CvExperience $cvExperience)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CvExperience $cvExperience)
    {
        $request->validate([
            'poste' => 'required|string|max:255',
            'entreprise' => 'required|string|max:255',
            'ville' => 'nullable|string|max:255',
            'date_debut' => 'required',
            'date_fin' => 'nullable',
            'description' => 'nullable|string',
            'contrat_type' => 'nullable|string',
            'secteur_activite' => 'nullable|string',
            'url_entreprise' => 'nullable|string',
            'url_poste' => 'nullable|string',
        ]);

        $cvExperience->update($request->only([
            'poste',
            'entreprise',
            'ville',
            'date_debut',
            'date_fin',
            'description',
            'contrat_type',
            'secteur_activite',
            'url_entreprise',
            'url_poste',
        ]));

        return back()->with('success', 'Expérience modifiée !');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
          $cvExperience = CvExperience::findOrFail($id);
        $cvExperience->delete();
        return back()->with('success', 'Expérience supprimée !');
    }


}
