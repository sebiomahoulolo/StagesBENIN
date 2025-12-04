<?php

namespace App\Http\Controllers;

use App\Models\CvReference;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CvReferenceController extends Controller
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
            'nom' => 'required|string|max:255',
            'relation' => 'required|string|max:255',
            'email' => 'nullable|email',
            'telephone' => 'nullable|string|max:255',
            'commentaire' => 'nullable|string',
        ]);

        // Récupérer explicitement le profil de l'utilisateur connecté
        $profil = \App\Models\CvProfil::where('user_id', auth()->id())->first();
        if (!$profil) {
            return back()->withErrors('Aucun profil associé à cet utilisateur.');
        }

        $validated['cv_profil_id'] = $profil->id;

        \App\Models\CvReference::create($validated);

        return back()->with('success', 'Référence ajoutée !');
    }

    /**
     * Display the specified resource.
     */
    public function show(CvReference $cvReference)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CvReference $cvReference)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CvReference $cvReference)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'relation' => 'required|string|max:255',
            'email' => 'nullable|email',
            'telephone' => 'nullable|string|max:255',
            'commentaire' => 'nullable|string',
        ]);
        $cvReference->update($validated);
        return redirect()->back()->with('success', 'Référence modifiée avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
            $cvReference = CvReference::findOrFail($id);
        $cvReference->delete();
        return redirect()->back()->with('success', 'Référence supprimée avec succès.');
    }


}
