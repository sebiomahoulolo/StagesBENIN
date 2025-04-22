<?php

namespace App\Http\Requests\Etudiant;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateProfileRequest extends FormRequest
{
    public function authorize()
    {
        // Vérifie que l'utilisateur est authentifié et est un étudiant
        return Auth::check() && Auth::user()->isEtudiant();
    }

    public function rules()
    {
        // Récupérer l'ID de l'étudiant associé à l'utilisateur
         $etudiantId = Auth::user()->etudiant?->id;
         // Récupérer l'ID du profil CV, s'il existe déjà
          $cvProfileId = Auth::user()->etudiant?->cvProfile?->id;

        return [
            'titre_profil' => 'required|string|max:255',
            'resume_profil' => 'nullable|string|max:2000', // Rendre nullable si pas obligatoire
            'adresse' => 'nullable|string|max:255',
            'telephone_cv' => 'nullable|string|max:20',
            // L'email doit être unique DANS la table cv_profiles, en ignorant l'enregistrement actuel si on le modifie
             'email_cv' => 'nullable|email|max:255' . ($cvProfileId ? '|unique:cv_profiles,email_cv,' . $cvProfileId : '|unique:cv_profiles,email_cv'),
            'linkedin_url' => 'nullable|url|max:255',
            'portfolio_url' => 'nullable|url|max:255',
            'photo_cv' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Règle pour le fichier uploadé
            'template_slug' => 'nullable|string|max:50',

             // NE PAS VALIDER 'photo_cv_path' ici, c'est géré dans le contrôleur après upload.
             // NE PAS VALIDER 'etudiant_id', il est défini dans le contrôleur.
        ];
    }

     // Optionnel: Messages d'erreur personnalisés
     public function messages()
     {
         return [
             'titre_profil.required' => 'Le titre du profil est obligatoire.',
             'email_cv.email' => 'L\'email de contact n\'est pas une adresse valide.',
             'email_cv.unique' => 'Cet email de contact est déjà utilisé.',
             '*.url' => 'Le champ :attribute doit être une URL valide (commençant par http:// ou https://).',
             'photo_cv.image' => 'Le fichier doit être une image.',
             'photo_cv.mimes' => 'La photo doit être au format JPEG, PNG ou JPG.',
             'photo_cv.max' => 'La photo ne doit pas dépasser 2Mo.',
         ];
     }
}