<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Annonce extends Model
{
    use HasFactory;
    protected $fillable = [
        'entreprise_id',
        'nom_du_poste',
        'type_de_poste',
        'nombre_de_place',
        'niveau_detude',
        'domaine',
        'lieu',
        'email',
        'date_cloture',
        'description',
    ];

    // Relation inverse vers L'Entreprise
    public function entreprise()
    {
        return $this->belongsTo(Entreprise::class);
    }
}
