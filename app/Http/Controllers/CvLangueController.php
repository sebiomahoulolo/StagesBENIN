<?php

namespace App\Http\Controllers;

use App\Models\CvLangue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CvLangueController extends Controller
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
            'langue' => 'required|string|max:255',
            'niveau' => 'required|string|max:255',
            'description' => 'nullable|string',
            	

        ]);

        // Récupérer explicitement le profil de l'utilisateur connecté
        $profil = \App\Models\CvProfil::where('user_id', auth()->id())->first();
        if (!$profil) {
            return back()->withErrors('Aucun profil associé à cet utilisateur.');
        }

        $validated['cv_profil_id'] = $profil->id;

        \App\Models\CvLangue::create($validated);

        return back()->with('success', 'Langue ajoutée !');
    }

    /**
     * Display the specified resource.
     */
    public function show(CvLangue $cvLangue)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CvLangue $cvLangue)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
  public function update(Request $request, CvLangue $cvLangue)
{
    $validated = $request->validate([
        'langue' => 'required|string|max:255',
        'niveau' => 'required|string|max:255',
    ]);
    $cvLangue->update($validated);
    return back()->with('success', 'Langue modifiée !');
}


    /**
     * Remove the specified resource from storage.
     */public function destroy($id)
{
    $cvLangue = CvLangue::findOrFail($id);
    $cvLangue->delete();
    return back()->with('success', 'Langue supprimée !');
}

}
