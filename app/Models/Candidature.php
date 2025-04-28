<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Candidature extends Model
{
    use HasFactory;

    protected $fillable = [
        'etudiant_id',
        'recrutement_id',
        'lettre_motivation',
        'cv_path',
        'statut',
        'date_candidature',
        'date_reponse',
        'commentaire'
    ];

    protected $casts = [
        'date_candidature' => 'datetime',
        'date_reponse' => 'datetime',
    ];

    // Relation avec l'étudiant
    public function etudiant()
    {
        return $this->belongsTo(Etudiant::class);
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