<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CvReference extends Model
{
    use HasFactory;

    protected $table = 'cv_references'; // Spécifier le nom de la table explicitement

    protected $fillable = [
        'cv_profile_id', 
        'nom',
        'prenom',
        'contact',
        'poste',
        'relation', // N'oubliez pas d'ajouter le nouveau champ ici
        'order'
    ];

    /**
     * Relation inverse: une référence appartient à un profil CV.
     */
    public function cvProfile()
    {
        return $this->belongsTo(CvProfile::class);
    }

    /**
     * Accesseur pour obtenir le nom complet du référent.
     */
    public function getNomCompletAttribute()
    {
        return trim($this->prenom . ' ' . $this->nom);
    }
} 