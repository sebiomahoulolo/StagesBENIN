<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Etudiant extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'prenom',
        'email',
        'telephone',
        'formation',
        'niveau',
        'date_naissance',
        'cv_path',
        'photo_path'
    ];

    protected $casts = [
        'date_naissance' => 'date',
    ];
}


