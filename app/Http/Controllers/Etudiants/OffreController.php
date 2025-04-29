<?php

namespace App\Http\Controllers\Etudiants;

use App\Http\Controllers\Controller;
use App\Models\Annonce;
use App\Models\Secteur;
use App\Models\Specialite;
use Illuminate\Http\Request;

class OffreController extends Controller
{
    public function index(Request $request)
    {
        $query = Annonce::query()
            ->with(['entreprise', 'secteur', 'specialite'])
            ->active()
            ->latest();

        // Filtres
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('nom_du_poste', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('secteur_id')) {
            $query->where('secteur_id', $request->secteur_id);
        }

        if ($request->filled('specialite_id')) {
            $query->where('specialite_id', $request->specialite_id);
        }

        if ($request->filled('type_de_poste')) {
            $query->where('type_de_poste', $request->type_de_poste);
        }

        if ($request->filled('niveau_detude')) {
            $query->where('niveau_detude', $request->niveau_detude);
        }

        if ($request->filled('lieu')) {
            $query->where('lieu', 'like', '%' . $request->lieu . '%');
        }

        if ($request->filled('pretension_salariale')) {
            $query->where('pretension_salariale', '>=', $request->pretension_salariale);
        }

        $annonces = $query->paginate(10);
        $secteurs = Secteur::orderBy('nom')->get();
        $specialites = $request->filled('secteur_id') 
            ? Specialite::where('secteur_id', $request->secteur_id)->orderBy('nom')->get()
            : collect();

        return view('etudiants.offres.index', compact('annonces', 'secteurs', 'specialites'));
    }

    public function show(Annonce $annonce)
    {
        $annonce->load(['entreprise', 'secteur', 'specialite']);
        return view('etudiants.offres.show', compact('annonce'));
    }

    public function mesCandidatures()
    {
        $candidatures = auth()->user()->candidatures()
            ->with(['annonce.entreprise', 'annonce.secteur', 'annonce.specialite'])
            ->latest()
            ->paginate(10);

        return view('etudiants.offres.mes-candidatures', compact('candidatures'));
    }
} 