<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
   use App\Models\CvFormation;
use App\Models\CvProfil;
use Illuminate\Support\Facades\Auth;

class CvFormationController extends Controller
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
        'diplome' => 'required|string',
        'etablissement' => 'required|string',
        'ville' => 'required|string',
        'annee_debut' => 'required|integer',
        'annee_fin' => 'required|integer',
        'description' => 'nullable|string',
    ]);

    // 🔍 Trouver le profil lié à l'utilisateur actuel
    $profil = CvProfil::where('user_id', auth()->id())->first();

    if (!$profil) {
        return redirect()->back()->withErrors(['profil' => 'Aucun profil trouvé pour cet utilisateur.']);
    }

    // 🔗 Lier la formation au profil
    $validated['cv_profil_id'] = $profil->id;

    CvFormation::create($validated);

    return redirect()->back()->with('success', 'Formation enregistrée avec succès.');
}


    /**
     * Display the specified resource.
     */
    public function show(CvFormation $cvFormation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CvFormation $cvFormation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CvFormation $cvFormation)
    {
        $validated = $request->validate([
            'diplome' => 'required|string',
            'etablissement' => 'required|string',
            'ville' => 'required|string',
            'annee_debut' => 'required|integer',
            'annee_fin' => 'required|integer',
            'description' => 'nullable|string',
        ]);
        $cvFormation->update($validated);
        return redirect()->back()->with('success', 'Formation modifiée avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
         $cvFormation = CvFormation::findOrFail($id);
        $cvFormation->delete();
        return redirect()->back()->with('success', 'Formation supprimée avec succès.');
    }

 
}
