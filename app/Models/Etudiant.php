<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Cv\CvProfile; // Si vous avez implémenté le CV

class Etudiant extends Model
{
    use HasFactory;

    // Ajoutez 'user_id' aux fillable
    protected $fillable = [
        'user_id', // Clé étrangère
        'nom',
        'prenom',
        'email', // Peut être redondant avec users.email, à gérer
        'telephone',
        'formation',
        'niveau',
        'date_naissance',
        'cv_path',
        'photo_path',
    ];

    // Relation inverse vers User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relation vers le profil CV (si implémenté)
    public function cvProfile()
    {
        return $this->hasOne(CvProfile::class);
    }
}