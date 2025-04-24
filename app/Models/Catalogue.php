<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Catalogue extends Model
{
    use HasFactory;

    protected $fillable = [
        'titre',
        'secteur_activite',
        'description',
        'logo',
        'localisation',
        'nb_activites',
        'activite_principale',
        'desc_activite_principale',
        'activite_secondaire',
        'desc_activite_secondaire',
        'autres',
        'image',
    ];
}
