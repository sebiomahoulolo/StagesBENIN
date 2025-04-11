<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entreprise extends Model
{
    use HasFactory;

     // Ajoutez 'user_id' aux fillable
    protected $fillable = [
        'user_id', // Clé étrangère
        'nom',
        'secteur',
        'description',
        'adresse',
        'email', // Peut être redondant
        'telephone',
        'site_web',
        'logo_path',
        'contact_principal',
    ];

    // Relation inverse vers User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function entretiens()
    {
        return $this->hasMany(Entretien::class);
    }
    // Relation vers les offres de recrutement (si pertinent)
     public function recrutements()
     {
         // Assurez-vous que le modèle Recrutement existe et a la relation belongsTo Entreprise
         // return $this->hasMany(Recrutement::class);
     }
}