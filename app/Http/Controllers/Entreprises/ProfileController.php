<?php

namespace App\Http\Controllers\Entreprises;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Affiche le formulaire d'édition du profil entreprise.
     */
    public function edit(Request $request)
    {
        $user = $request->user();
        $entreprise = $user->entreprise()->first();

        if (!$entreprise) {
            return redirect()->route('entreprises.dashboard')
                ->with('error', 'Profil entreprise introuvable.');
        }

        return view('entreprises.profile.edit', [
            'user' => $user,
            'entreprise' => $entreprise,
        ]);
    }

    /**
     * Met à jour les informations générales (user)
     */
    public function updateGeneral(Request $request)
    {
        $user = $request->user();
        
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
        ]);

        $user->fill($validated);
        $user->save();

        return redirect()->route('entreprises.profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Met à jour les informations spécifiques de l'entreprise
     */
    public function updateEntrepriseInfo(Request $request)
    {
        $user = $request->user();
        $entreprise = $user->entreprise()->firstOrFail();

        // Règles de validation
        $rules = [
            'nom' => ['sometimes', 'string', 'max:255'],
            'secteur' => ['sometimes', 'string', 'max:255'],
            'description' => ['sometimes', 'nullable', 'string'],
            'adresse' => ['sometimes', 'nullable', 'string', 'max:255'],
            'email' => ['sometimes', 'email', 'max:255'],
            'telephone' => ['sometimes', 'nullable', 'string', 'max:20'],
            'site_web' => ['sometimes', 'nullable', 'url', 'max:255'],
            'contact_principal' => ['sometimes', 'nullable', 'string', 'max:255'],
        ];

        // Ne valider que les champs présents dans la requête
        $fieldsToValidate = array_intersect_key($rules, $request->all());
        $validated = $request->validate($fieldsToValidate);

        if (!empty($validated)) {
            $entreprise->update($validated);
        }

        return redirect()->route('entreprises.profile.edit')->with('status', 'entreprise-info-updated');
    }

    /**
     * Met à jour le logo de l'entreprise
     */
    public function updateLogo(Request $request)
    {
        $request->validate([
            'logo' => ['required', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ]);

        $user = $request->user();
        $entreprise = $user->entreprise()->firstOrFail();

        // Supprimer l'ancien logo s'il existe
        if ($entreprise->logo_path) {
            $oldPath = str_replace('storage/', '', $entreprise->logo_path);
            if (Storage::disk('public')->exists($oldPath)) {
                Storage::disk('public')->delete($oldPath);
            }
        }

        // Stocker le nouveau logo
        $path = 'storage/' . $request->file('logo')->store('logos/entreprises', 'public');
        $entreprise->update(['logo_path' => $path]);

        return redirect()->route('entreprises.profile.edit')->with('status', 'logo-updated');
    }
}