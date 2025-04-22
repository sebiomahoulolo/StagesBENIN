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
        $etudiant = $user->etudiant()->first(); // Ou firstOrFail() si obligatoire

        // Si l'étudiant n'a pas de profil étudiant (ce qui ne devrait pas arriver ici)
        if (!$etudiant) {
             // Rediriger ou afficher une erreur
             // Exemple: Créer un profil étudiant vide s'il n'existe pas
             $etudiant = Etudiant::create(['user_id' => $user->id]);
             // Ou rediriger : return redirect()->route('etudiants.dashboard')->with('error', 'Profil étudiant introuvable.');
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
            // Ajoutez d'autres champs spécifiques à Etudiant ici
        ]);

        // Nettoyer les valeurs nulles si nécessaire (optionnel)
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