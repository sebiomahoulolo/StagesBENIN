<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reponse extends Model
{
    use HasFactory;

    /**
     * Les attributs qui sont mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'question_id',
        'texte',
        'valide'
    ];

    /**
     * Les attributs qui doivent être castés.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'valide' => 'boolean',
    ];

    /**
     * Obtenir la question associée à cette réponse.
     */
    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}

