<?php

namespace App\Models;
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reponse extends Model
{
    use HasFactory;

    // Définir les colonnes qui peuvent être remplies via un formulaire ou une requête
    protected $fillable = ['etudiant_id', 'question_id', 'choix_index'];

    // Définir les relations avec d'autres modèles

    /**
     * Relation avec le modèle Etudiant
     */
    public function etudiant()
    {
        return $this->belongsTo(Etudiant::class);
    }

    /**
     * Relation avec le modèle Question
     */
    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}

