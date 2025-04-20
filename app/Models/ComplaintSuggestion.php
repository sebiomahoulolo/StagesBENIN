<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComplaintSuggestion extends Model
{
    use HasFactory;

    /**
     * La table associée au modèle.
     *
     * @var string
     */
    protected $table = 'complaints_suggestions';

    /**
     * Les attributs qui sont assignables en masse.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'type',
        'sujet',
        'contenu',
        'etudiant_id',
        'is_anonymous',
        'statut',
        'reponse'
    ];

    /**
     * Les attributs qui doivent être castés.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_anonymous' => 'boolean',
    ];

    /**
     * Obtenir l'étudiant qui a soumis la plainte/suggestion.
     */
    public function etudiant()
    {
        return $this->belongsTo(Etudiant::class);
    }

    /**
     * Déterminer si la plainte/suggestion est anonyme.
     *
     * @return bool
     */
    public function isAnonymous()
    {
        return $this->is_anonymous;
    }

    /**
     * Déterminer si la plainte/suggestion est résolue.
     *
     * @return bool
     */
    public function isResolved()
    {
        return $this->statut === 'résolu';
    }
}
