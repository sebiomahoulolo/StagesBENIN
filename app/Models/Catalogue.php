<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Catalogue extends Model
{
    use HasFactory;
    
    protected $table = 'catalogue';

    protected $fillable = [
        'titre',
        'description',
        'duree',
        'type',
        'niveau',
        'pre_requis',
        'contenu',
        'image_path'
    ];
}