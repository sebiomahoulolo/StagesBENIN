<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DemandeEmploye extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'entreprise_id',
        'titre',
        'description',
        'type',
        'domaine',
        'niveau_experience',
        'niveau_etude',
        'competences_requises',
        'nombre_postes',
        'salaire_min',
        'salaire_max',
        'type_contrat',
        'date_debut',
        'date_limite',
        'lieu',
        'statut',
        'motif_rejet', // <-- Ce champ est utilisé
        'est_urgente',
        'est_active',
        'nombre_vues',
        'admin_id'
        // 'commentaire_admin', // Ajoutez si vous avez une colonne distincte et voulez l'utiliser
    ];

    protected $casts = [
        'date_debut' => 'date',
        'date_limite' => 'date',
        'salaire_min' => 'decimal:2',
        'salaire_max' => 'decimal:2',
        'est_urgente' => 'boolean',
        'est_active' => 'boolean',
        'nombre_vues' => 'integer'
    ];

    // Relation avec l'entreprise
    public function entreprise()
    {
        return $this->belongsTo(Entreprise::class);
    }

    // Relation avec l'admin qui traite la demande
    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    // Scope pour les demandes actives
    public function scopeActive($query)
    {
        return $query->where('est_active', true);
    }

    // Scope pour les demandes urgentes
    public function scopeUrgente($query)
    {
        return $query->where('est_urgente', true);
    }

    // Scope pour les demandes en attente
    public function scopeEnAttente($query)
    {
        return $query->where('statut', 'en_attente');
    }
    
    // La relation postable n'est pas utilisée dans ce contexte direct de gestion admin.
    // public function post()
    // {
    //     return $this->morphOne(Post::class, 'postable');
    // }
}