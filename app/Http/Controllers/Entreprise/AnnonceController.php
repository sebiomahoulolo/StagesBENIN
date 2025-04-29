<?php

namespace App\Http\Controllers\Entreprise;

use App\Http\Controllers\Controller;
use App\Models\Annonce;
use App\Models\Candidature;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AnnonceController extends Controller
{
    public function index()
    {
        $annonces = Annonce::where('entreprise_id', Auth::user()->entreprise->id)
                          ->latest()
                          ->paginate(10);

        return view('entreprises.annonces.index', compact('annonces'));
    }

    public function create()
    {
        return view('entreprises.annonces.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nom_du_poste' => 'required|string|max:255',
            'type_de_poste' => 'required|string|max:255',
            'nombre_de_place' => 'required|integer|min:1',
            'niveau_detude' => 'required|string|max:255',
            'domaine' => 'required|string|max:255',
            'lieu' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'date_cloture' => 'required|date|after:today',
            'description' => 'required|string|min:100',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                            ->withErrors($validator)
                            ->withInput();
        }

        $annonce = Annonce::create([
            'entreprise_id' => Auth::user()->entreprise->id,
            'nom_du_poste' => $request->nom_du_poste,
            'type_de_poste' => $request->type_de_poste,
            'nombre_de_place' => $request->nombre_de_place,
            'niveau_detude' => $request->niveau_detude,
            'domaine' => $request->domaine,
            'lieu' => $request->lieu,
            'email' => $request->email,
            'date_cloture' => $request->date_cloture,
            'description' => $request->description,
        ]);

        return redirect()->route('entreprises.annonces.show', $annonce)
                        ->with('success', 'Votre annonce a été créée avec succès et est en attente de validation.');
    }

    public function show(Annonce $annonce)
    {
        $this->authorize('view', $annonce);

        $candidatures = Candidature::with('etudiant')
                                  ->where('annonce_id', $annonce->id)
                                  ->latest()
                                  ->paginate(10);

        return view('entreprises.annonces.show', compact('annonce', 'candidatures'));
    }

    public function edit(Annonce $annonce)
    {
        $this->authorize('update', $annonce);

        return view('entreprises.annonces.edit', compact('annonce'));
    }

    public function update(Request $request, Annonce $annonce)
    {
        $this->authorize('update', $annonce);

        $validator = Validator::make($request->all(), [
            'nom_du_poste' => 'required|string|max:255',
            'type_de_poste' => 'required|string|max:255',
            'nombre_de_place' => 'required|integer|min:1',
            'niveau_detude' => 'required|string|max:255',
            'domaine' => 'required|string|max:255',
            'lieu' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'date_cloture' => 'required|date|after:today',
            'description' => 'required|string|min:100',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                            ->withErrors($validator)
                            ->withInput();
        }

        $annonce->update([
            'nom_du_poste' => $request->nom_du_poste,
            'type_de_poste' => $request->type_de_poste,
            'nombre_de_place' => $request->nombre_de_place,
            'niveau_detude' => $request->niveau_detude,
            'domaine' => $request->domaine,
            'lieu' => $request->lieu,
            'email' => $request->email,
            'date_cloture' => $request->date_cloture,
            'description' => $request->description,
        ]);

        return redirect()->route('entreprises.annonces.show', $annonce)
                        ->with('success', 'Votre annonce a été mise à jour avec succès.');
    }

    public function destroy(Annonce $annonce)
    {
        $this->authorize('delete', $annonce);

        $annonce->delete();

        return redirect()->route('entreprises.annonces.index')
                        ->with('success', 'Votre annonce a été supprimée avec succès.');
    }
} 