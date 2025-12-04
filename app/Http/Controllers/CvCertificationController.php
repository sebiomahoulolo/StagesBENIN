<?php

namespace App\Http\Controllers;

use App\Models\CvCertification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CvCertificationController extends Controller
{
    /**
     * Affiche la liste des certifications (facultatif).
     */
    public function index()
    {
        $certifications = CvCertification::all();
        return view('certifications.index', compact('certifications'));
    }

    /**
     * Affiche le formulaire de création (facultatif).
     */
    public function create()
    {
        return view('certifications.create');
    }

    /**
     * Enregistre une nouvelle certification dans la base.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'certification' => 'required|string|max:255',
            'organisme' => 'required|string|max:255',
            'date_obtention' => 'required|digits:4|integer|min:1950|max:' . date('Y'),
            'date_expiration' => 'nullable|url|max:255',
        ]);

        // Récupérer explicitement le profil de l'utilisateur connecté
        $profil = \App\Models\CvProfil::where('user_id', auth()->id())->first();
        if (!$profil) {
            return back()->withErrors('Aucun profil associé à cet utilisateur.');
        }

        $validated['cv_profil_id'] = $profil->id;

        \App\Models\CvCertification::create($validated);

        return back()->with('success', 'Certification ajoutée avec succès.');
    }

    /**
     * Édition (optionnelle).
     */
    public function edit(CvCertification $cvCertification)
    {
        return view('certifications.edit', compact('cvCertification'));
    }

    /**
     * Mise à jour (optionnelle).
     */
 /**
 * Met à jour une certification.
 */
public function update(Request $request, CvCertification $cvCertification)
{
    // Validation des données entrantes
    $validated = $request->validate([
        'certification' => 'required|string|max:255',
        'organisme' => 'required|string|max:255',
        'date_obtention' => 'required|digits:4|integer|min:1950|max:' . date('Y'),
        'date_expiration' => 'nullable|string|max:255', // changé de url à string, sauf si tu veux vraiment une URL ici
    ]);

    // Mise à jour de la certification avec les données validées
    $cvCertification->update($validated);


    return redirect()->back()->with('success', 'Certification mise à jour.');
}


/**
 * Supprime une certification.
 */
public function destroy($id)
{
    
   $cvCertification = CvCertification::findOrFail($id);
    $cvCertification->delete();

    return redirect()->back()->with('success', 'Certification supprimée.');
}


}
