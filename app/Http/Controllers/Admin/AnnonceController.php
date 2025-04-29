<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Annonce;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnnonceController extends Controller
{
    public function index()
    {
        $annonces = Annonce::with(['entreprise', 'admin'])
                          ->latest()
                          ->paginate(10);

        return view('admin.annonces.index', compact('annonces'));
    }

    public function show(Annonce $annonce)
    {
        $candidatures = $annonce->candidatures()
                               ->with('etudiant')
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
        $request->validate([
            'motif_rejet' => 'required|string|min:10',
        ]);

        $annonce->update([
            'statut' => 'rejete',
            'motif_rejet' => $request->motif_rejet,
            'admin_id' => Auth::id(),
        ]);

        return redirect()->route('admin.annonces.show', $annonce)
                        ->with('success', 'L\'annonce a été rejetée avec succès.');
    }
} 