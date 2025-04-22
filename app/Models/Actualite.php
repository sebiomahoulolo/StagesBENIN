<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Actualite extends Model
{
    use HasFactory;

    protected $fillable = [
        'titre',
        'contenu',
        'image_path',
        'date_publication',
        'categorie',
        'auteur'
    ];

    protected $casts = [
        'date_publication' => 'datetime',
    ];
}


