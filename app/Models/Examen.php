<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Examen extends Model
{
    use HasFactory;

    protected $fillable = [
        'entretien_id', 
        'etudiant_id', 
        'user_id', 
        'score', 
        'total_questions', 
        'reponses', 
        'bonnes_reponses',
        'note_pratique',
        'note_finale'
    ];
    protected $casts = [
        'reponses' => 'array',
        'date_passage' => 'datetime',
        'note_pratique' => 'float',
        'note_finale' => 'float'
    ];
    public function etudiant()
    {
        return $this->belongsTo(Etudiant::class);
    }

    public function questions()
    {
        return $this->hasMany(Question::class, 'entretien_id', 'id');
    }

    /**
     * Relation avec le modèle Etudiant
     */

    /**
     * Relationship with Annonce - ADD THIS METHOD
     */
    public function annonce()
    {
        return $this->belongsTo(Annonce::class);
        // or if the foreign key isn't 'annonce_id', specify it:
        // return $this->belongsTo(Annonce::class, 'your_foreign_key_column');
    }

    public function entreprise()
    {
        return $this->belongsTo(Entreprise::class);
    }



public function entretien()
{
    return $this->belongsTo(Entretien::class);
}

}
