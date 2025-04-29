<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Annonce;
use Illuminate\Auth\Access\HandlesAuthorization;

class AnnoncePolicy
{
    use HandlesAuthorization;

    /**
     * Détermine si l'utilisateur peut voir l'annonce.
     */
    public function view(User $user, Annonce $annonce)
    {
        // L'utilisateur peut voir l'annonce s'il est l'administrateur ou s'il est le propriétaire de l'annonce
        return $user->isAdmin() || $user->entreprise?->user_id === $annonce->entreprise_id;
    }

    /**
     * Détermine si l'utilisateur peut créer une annonce.
     */
    public function create(User $user)
    {
        // Seuls les recruteurs peuvent créer des annonces
        return $user->isRecruteur();
    }

    /**
     * Détermine si l'utilisateur peut mettre à jour l'annonce.
     */
    public function update(User $user, Annonce $annonce)
    {
        // L'utilisateur peut mettre à jour l'annonce s'il est l'administrateur ou s'il est le propriétaire de l'annonce
        return $user->isAdmin() || $user->entreprise?->user_id === $annonce->entreprise_id;
    }

    /**
     * Détermine si l'utilisateur peut supprimer l'annonce.
     */
    public function delete(User $user, Annonce $annonce)
    {
        // L'utilisateur peut supprimer l'annonce s'il est l'administrateur ou s'il est le propriétaire de l'annonce
        return $user->isAdmin() || $user->entreprise?->user_id === $annonce->entreprise_id;
    }
} 