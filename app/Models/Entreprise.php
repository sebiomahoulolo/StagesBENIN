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
        return $this->belongsTo(User::class, 'user_id');
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
    // Relation vers les annonces
    public function annonces()
    {
        return $this->hasMany(Annonce::class, 'entreprise_id');
    }
    // Relation vers les messageries
    public function messagerie()
    {
        return $this->hasMany(Messagerie::class);
    }
}
    //  public function recrutements()
    //  {
    //      // Assurez-vous que le modèle Recrutement existe et a la relation belongsTo Entreprise
    //      // return $this->hasMany(Recrutement::class);
    //  }
// }
