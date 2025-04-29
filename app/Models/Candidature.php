<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Candidature extends Model
{
    use HasFactory;

    protected $fillable = [
        'annonce_id',
        'etudiant_id',
        'lettre_motivation',
        'cv_path',
        'statut',
        'motif_rejet'
    ];

    protected $casts = [
        'date_candidature' => 'datetime',
        'date_reponse' => 'datetime',
    ];

    public function annonce()
    {
        return $this->belongsTo(Annonce::class);
    }

    public function etudiant()
    {
        return $this->belongsTo(Etudiant::class);
    }

    public function scopeEnAttente($query)
    {
        return $query->where('statut', 'en_attente');
    }

    public function scopeEnCours($query)
    {
        return $query->where('statut', 'en_cours');
    }

    public function scopeAccepte($query)
    {
        return $query->where('statut', 'accepte');
    }

    public function scopeRejete($query)
    {
        return $query->where('statut', 'rejete');
    }

    // Relation avec l'offre d'emploi
    public function recrutement()
    {
        return $this->belongsTo(Recrutement::class);
    }

    // Statuts possibles pour une candidature
    public static function getStatuts()
    {
        return [
            'en_attente' => 'En attente',
            'acceptee' => 'Acceptée',
            'refusee' => 'Refusée',
            'en_cours' => 'En cours de traitement',
            'annulee' => 'Annulée'
        ];
    }

    // Obtenir le libellé du statut
    public function getStatutLabelAttribute()
    {
        $statuts = self::getStatuts();
        return $statuts[$this->statut] ?? $this->statut;
    }
} 