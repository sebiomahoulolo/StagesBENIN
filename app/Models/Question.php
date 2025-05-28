<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    /**
     * Les attributs qui sont mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'entretien_id',
        'question',
        'created_at',
        'updated_at'
    ];

    /**
     * Obtenir l'entretien associé à cette question.
     */
    public function entretien()
    {
        return $this->belongsTo(Entretien::class);
    }

    /**
     * Obtenir les réponses associées à cette question.
     */
    public function reponses()
    {
        return $this->hasMany(Reponse::class);
    }
}
