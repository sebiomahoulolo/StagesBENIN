<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recrutement extends Model
{
    use HasFactory;

    protected $fillable = [
        'titre',
        'entreprise_id',
        'type_contrat',
        'description',
        'competences_requises',
        'date_debut',
        'lieu',
        'salaire',
        'date_expiration'
    ];

    protected $casts = [
        'date_debut' => 'date',
        'date_expiration' => 'date',
    ];

    // Relation avec l'entreprise
    public function entreprise()
    {
        return $this->belongsTo(Entreprise::class);
    }
}


