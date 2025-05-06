<?php

namespace App\Policies;

use App\Models\DemandeEmploye;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class DemandeEmployePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the model.
     * L'utilisateur doit être le propriétaire de la demande (via son entreprise).
     */
    public function view(User $user, DemandeEmploye $demande): bool
    {
        // Vérifier si l'utilisateur a un rôle admin
        if ($user->role === 'admin') {
            return true;
        }

        // Pour un recruteur, vérifier qu'il soit bien propriétaire de la demande
        return $user->role === 'recruteur' &&
               $user->entreprise &&
               $user->entreprise->id === $demande->entreprise_id;
    }

    /**
     * Determine whether the user can create models.
     * Un utilisateur peut créer une demande s'il est recruteur et a une entreprise.
     */
    public function create(User $user): bool
    {
        return $user->role === 'recruteur' && $user->entreprise_id !== null;
    }

    /**
     * Determine whether the user can update the model.
     * L'utilisateur doit être le propriétaire de la demande.
     */
    public function update(User $user, DemandeEmploye $demande): bool
    {
        // Vérifier si l'utilisateur a un rôle admin
        if ($user->role === 'admin') {
            return true;
        }

        // Pour un recruteur, vérifier qu'il soit bien propriétaire de la demande
        return $user->role === 'recruteur' &&
               $user->entreprise &&
               $user->entreprise->id === $demande->entreprise_id &&
               $demande->statut === 'en_attente'; // Uniquement modifiable si en attente
    }

    /**
     * Determine whether the user can delete the model.
     * L'utilisateur doit être le propriétaire de la demande.
     */
    public function delete(User $user, DemandeEmploye $demande): bool
    {
        // Vérifier si l'utilisateur a un rôle admin
        if ($user->role === 'admin') {
            return true;
        }

        // Pour un recruteur, vérifier qu'il soit bien propriétaire de la demande
        return $user->role === 'recruteur' &&
               $user->entreprise &&
               $user->entreprise->id === $demande->entreprise_id;
    }

    /**
     * Determine whether the user can restore the model.
     * (Si vous utilisez SoftDeletes et voulez permettre la restauration par l'entreprise)
     */
    // public function restore(User $user, DemandeEmploye $demandeEmploye): bool
    // {
    //     return $user->role === 'recruteur' &&
    //            $user->entreprise_id !== null &&
    //            $user->entreprise_id === $demandeEmploye->entreprise_id;
    // }

    /**
     * Determine whether the user can permanently delete the model.
     * (Si vous utilisez SoftDeletes et voulez permettre la suppression définitive par l'entreprise)
     */
    // public function forceDelete(User $user, DemandeEmploye $demandeEmploye): bool
    // {
    //     return $user->role === 'recruteur' &&
    //            $user->entreprise_id !== null &&
    //            $user->entreprise_id === $demandeEmploye->entreprise_id;
    // }
}