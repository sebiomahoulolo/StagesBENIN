<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Carbon\Carbon; // Assurez-vous que Carbon est importé

class Tier extends Model
{
    // Spécifie explicitement le nom de la table si ce n'est pas la forme plurielle standard
    protected $table = 'tier';
   
    

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'price',
        'duration', // Représente le nombre de MOIS selon votre logique
        // 'duration_unit', // Commenté car non utilisé dans le calcul, mais peut rester si la colonne existe
        'visibility_level',
        'extra_features', // Doit contenir du JSON valide !
        'transaction_id',
        'payment_status',
        'payment_date',
        'is_purchasable', // Exemple, si vous avez un flag pour les plans achetables
    ];

    protected $casts = [
        'payment_date' => 'datetime',
        'extra_features' => 'array', // Crucial pour décoder le JSON automatiquement
        'price' => 'float',
        'duration' => 'integer', // Caster en entier par sécurité
        'created_at' => 'datetime', // Bonne pratique de caster les timestamps
        'updated_at' => 'datetime',
        'is_purchasable' => 'boolean',
     
    
    
    ];

    /**
     * Relation avec l'utilisateur (étudiant)
     */
    public function user()
    {
        // Assurez-vous que le chemin vers votre modèle User est correct
        return $this->belongsTo(\App\Models\User::class);
    }

    /**
     * Accesseur MODIFIÉ pour calculer la date d'expiration.
     * Suppose maintenant que $this->duration est TOUJOURS en MOIS.
     * Crée une propriété virtuelle $tier->calculated_expires_at
     */
    public function getCalculatedExpiresAtAttribute(): ?Carbon // Type de retour Carbon ou null
    {
        // Vérifie si on a une date de paiement et une durée numérique valide
        if ($this->payment_date && is_numeric($this->duration)) {
            // Convertit la date de paiement en objet Carbon (géré par le cast 'datetime')
            $startDate = $this->payment_date; // Accès direct grâce au cast

            // Ajoute le nombre de mois spécifié par 'duration'
            return $startDate->copy()->addMonths((int)$this->duration);
        }

        // Retourne null si la date de paiement ou la durée est invalide/manquante
        return null;
    }

    /**
     * Accesseur pour récupérer les avantages depuis extra_features.
     * Crée une propriété virtuelle $tier->avantages
     */
   

     /**
     * Accesseur pour simuler/récupérer le compte d'entreprises.
     * Crée une propriété virtuelle $tier->entreprise_count
     */
    public function getEntrepriseCountAttribute(): int
    {
        // Garde la logique précédente (à adapter si besoin)
        if (str_contains(strtolower($this->title ?? ''), 'premium') || $this->visibility_level > 100) {
             return 150;
        }
        if (str_contains(strtolower($this->title ?? ''), 'essentiel')) {
            return 50;
        }
        // Fallback basé sur visibility_level ou une valeur par défaut
        return is_numeric($this->visibility_level) ? (int)$this->visibility_level : 20;
    }


    // --- Accesseurs pour les statistiques simulées ---
    // Crée les propriétés virtuelles $tier->view_count, etc.

    public function getViewCountAttribute(): int
    {
         // TODO: Remplacer par la vraie logique de récupération des vues
         return rand(50, 500);
    }
    public function getApplicationCountAttribute(): int
    {
         // TODO: Remplacer par la vraie logique
         return rand(5, 50);
    }
    public function getMessageCountAttribute(): int
    {
        // TODO: Remplacer par la vraie logique
        return rand(2, 20);
    }
}