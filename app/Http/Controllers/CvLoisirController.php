<?php

namespace App\Http\Controllers;

use App\Models\CvLoisir;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CvLoisirController extends Controller
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
            'loisir' => 'required|string|max:255',
        ]);

        // Récupérer explicitement le profil de l'utilisateur connecté
        $profil = \App\Models\CvProfil::where('user_id', auth()->id())->first();
        if (!$profil) {
            return back()->withErrors('Aucun profil associé à cet utilisateur.');
        }

        $validated['cv_profil_id'] = $profil->id;

        \App\Models\CvLoisir::create($validated);

        return back()->with('success', 'Loisir ajouté !');
    }

    /**
     * Display the specified resource.
     */
    public function show(CvLoisir $cvLoisir)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CvLoisir $cvLoisir)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CvLoisir $cvLoisir)
    {
        $validated = $request->validate([
            'loisir' => 'required|string|max:255',
        ]);
        $cvLoisir->update($validated);
        return redirect()->back()->with('success', 'Loisir modifié avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
          $cvLoisir = CvLoisir::findOrFail($id);
        $cvLoisir->delete();
        return redirect()->back()->with('success', 'Loisir supprimé avec succès.');
    }


}
