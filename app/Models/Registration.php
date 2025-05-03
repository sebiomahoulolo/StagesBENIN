<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    use HasFactory;

    /**
     * Le nom de la table associée au modèle.
     * (Optionnel si 'registrations')
     * @var string
     */
    // protected $table = 'registrations';

    /**
     * Les attributs qui sont assignables en masse.
     * !! ASSUREZ-VOUS QUE CES CHAMPS SONT CORRECTS !!
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'event_id', // Requis
        'name',     // Requis
        'email',    // Requis
        // 'user_id', // Ajoutez si vous avez une colonne user_id et voulez la remplir
    ];

    /**
     * Récupère l'événement associé à cette inscription.
     */
    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    /**
     * Récupère l'utilisateur associé (si pertinent).
     */
    // public function user()
    // {
    //     return $this->belongsTo(User::class);
    // }
}