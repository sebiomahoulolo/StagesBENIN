<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'start_date',
        'end_date',
        'location',
        'type',
        'max_participants',
        'image',
        'is_published',
        'first_name',  // Nouveau champ : Prénom
        'last_name',   // Nouveau champ : Nom
        'phone_number', // Nouveau champ : Numéro de téléphone
        'email'       // Nouveau champ : Email
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    /**
     * Relation avec l'utilisateur qui a créé l'événement
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
