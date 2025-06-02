<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Examen extends Model
{
    use HasFactory;

    protected $fillable = ['etudiant_id', 'user_id', 'score', 'total_questions', 'reponses', 'bonnes_reponses'];
 protected $casts = [
        'reponses' => 'array',
        'date_passage' => 'datetime'
    ];
    public function etudiant()
    {
        return $this->belongsTo(Etudiant::class);
    }



   

    /**
     * Relation avec le modèle Etudiant
     */


    public function entreprise()
    {
        return $this->belongsTo(Entreprise::class);
    }
}
