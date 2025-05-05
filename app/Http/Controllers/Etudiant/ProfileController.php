<?php

namespace App\Http\Controllers\Etudiant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use App\Models\Etudiant; // Assurez-vous que le modèle existe

class ProfileController extends Controller
{
    /**
     * Affiche le formulaire d'édition du profil étudiant.
     */
    public function edit(Request $request)
    {
        // Récupère l'utilisateur authentifié ET son profil étudiant associé
        $user = $request->user();
        $etudiant = $user->etudiant()->first(); 

        // Si l'étudiant n'a pas de profil étudiant (ce qui ne devrait pas arriver ici)
        if (!$etudiant) {
            $etudiant = Etudiant::create(['user_id' => $user->id]);
        }

        // Formater la date de naissance au format Y-m-d pour l'input date
        if ($etudiant->date_naissance) {
            $etudiant->date_naissance = $etudiant->date_naissance->format('Y-m-d');
        }

        return view('etudiants.profile.edit', [
            'user' => $user,
            'etudiant' => $etudiant,
        ]);
    }

    /**
     * Met à jour les informations spécifiques du profil étudiant (téléphone, formation, etc.).
     */
    public function updateEtudiantInfo(Request $request)
    {
        $user = $request->user();
        $etudiant = $user->etudiant()->firstOrFail();

        $validated = $request->validate([
            'telephone' => ['nullable', 'string', 'max:20'],
            'formation' => ['nullable', 'string', 'max:255'],
            'niveau' => ['nullable', 'string', 'max:100'],
            'date_naissance' => ['nullable', 'date'],
            'nom' => ['required', 'string', 'max:255'],
            'prenom' => ['required', 'string', 'max:255'],
            'specialite_id' => ['nullable', 'exists:specialites,id'],
            'cv' => ['nullable', 'file', 'mimes:pdf', 'max:5120'], // 5MB max pour le CV
        ]);

        if ($request->hasFile('cv')) {
            // Supprimer l'ancien CV s'il existe
            if ($etudiant->cv_path && Storage::disk('public')->exists($etudiant->cv_path)) {
                Storage::disk('public')->delete($etudiant->cv_path);
            }
            // Stocker le nouveau CV
            $validated['cv_path'] = $request->file('cv')->store('cv_documents/user_' . $user->id, 'public');
        }

        // Nettoyer les valeurs nulles si nécessaire
        $updateData = array_filter($validated, fn($value) => !is_null($value));

        if (!empty($updateData)) {
             $etudiant->update($updateData);
        }

        return redirect()->route('etudiants.profile.edit')->with('status', 'student-info-updated');
    }

    /**
     * Met à jour la photo de profil de l'étudiant.
     */
    public function updatePhoto(Request $request)
    {
        $request->validate([
            'photo' => ['required', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'], // 2MB Max
        ]);

        $user = $request->user();
        $etudiant = $user->etudiant()->firstOrFail();

        // Supprimer l'ancienne photo si elle existe
        if ($etudiant->photo_path && Storage::disk('public')->exists($etudiant->photo_path)) {
            Storage::disk('public')->delete($etudiant->photo_path);
        }

        // Stocker la nouvelle photo dans 'etudiant_photos/user_{id}'
        $path = $request->file('photo')->store('etudiant_photos/user_' . $user->id, 'public');

        // Mettre à jour le chemin dans la base de données
        $etudiant->update(['photo_path' => $path]);

        return redirect()->route('etudiants.profile.edit')->with('status', 'profile-photo-updated');
    }
}