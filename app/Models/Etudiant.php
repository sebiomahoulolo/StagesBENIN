<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\CvProfile; // Si vous avez implémenté le CV

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

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'date_naissance' => 'date',
        'email_verified_at' => 'datetime', // Si vous l'avez dans la table users et voulez la caster ici
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
    public function entretiens()
{
    return $this->hasMany(Entretien::class);
}
public function entreprise()
{
    return $this->belongsTo(Entreprise::class);
}

/**
 * Obtenir les plaintes et suggestions soumises par l'étudiant.
 */
public function complaintsSuggestions()
{
    return $this->hasMany(ComplaintSuggestion::class);
}

}