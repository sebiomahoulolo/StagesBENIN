<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Annonce;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response; // Importez Response si vous voulez l'utiliser

class AnnoncePolicy
{
    use HandlesAuthorization;

    /**
     * Détermine si l'utilisateur peut voir l'annonce.
     *
     * @param  \App\Models\User  $user L'utilisateur connecté.
     * @param  \App\Models\Annonce  $annonce L'annonce à vérifier.
     * @return bool True si autorisé, False sinon.
     */
    public function view(User $user, Annonce $annonce): bool
    {
        // L'utilisateur peut voir l'annonce s'il est admin
        if ($user->isAdmin()) {
            return true;
        }

        // Ou si l'ID de l'entreprise associée à l'utilisateur connecté
        // correspond à l'ID de l'entreprise sur l'annonce.
        // Utilisation de l'opérateur Nullsafe (?->) pour éviter les erreurs si $user->entreprise est null.
        return $user->entreprise?->id === $annonce->entreprise_id;
    }

    /**
     * Détermine si l'utilisateur peut créer une annonce.
     * (Cette méthode n'est généralement pas appelée via $this->authorize directement dans un contrôleur resource
     * pour l'action 'create', mais elle est utile pour les vérifications Gate ou manuelles).
     *
     * @param  \App\Models\User  $user L'utilisateur connecté.
     * @return bool True si autorisé, False sinon.
     */
    public function create(User $user): bool
    {
        // Seuls les recruteurs ayant une entreprise associée peuvent créer des annonces.
        // (La vérification Auth::user()->entreprise dans le contrôleur est déjà une bonne pratique).
        return $user->isRecruteur() && $user->entreprise !== null;
    }

    /**
     * Détermine si l'utilisateur peut mettre à jour l'annonce.
     *
     * @param  \App\Models\User  $user L'utilisateur connecté.
     * @param  \App\Models\Annonce  $annonce L'annonce à vérifier.
     * @return bool True si autorisé, False sinon.
     */
    public function update(User $user, Annonce $annonce): bool
    {
         // L'utilisateur peut mettre à jour s'il est admin
        if ($user->isAdmin()) {
            return true;
        }

        // Ou s'il est le propriétaire de l'annonce (même logique que pour 'view')
        return $user->entreprise?->id === $annonce->entreprise_id;
    }

    /**
     * Détermine si l'utilisateur peut supprimer l'annonce.
     *
     * @param  \App\Models\User  $user L'utilisateur connecté.
     * @param  \App\Models\Annonce  $annonce L'annonce à vérifier.
     * @return bool True si autorisé, False sinon.
     */
    public function delete(User $user, Annonce $annonce): bool
    {
         // L'utilisateur peut supprimer s'il est admin
        if ($user->isAdmin()) {
            return true;
        }

        // Ou s'il est le propriétaire de l'annonce (même logique que pour 'view' et 'update')
        return $user->entreprise?->id === $annonce->entreprise_id;
    }

    // Les méthodes restore et forceDelete sont pour Soft Deletes, vous pouvez les laisser commentées
    // si vous ne les utilisez pas ou appliquer la même logique de propriété.
}