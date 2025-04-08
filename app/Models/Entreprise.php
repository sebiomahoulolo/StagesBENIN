<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entreprise extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'secteur',
        'description',
        'adresse',
        'email',
        'telephone',
        'site_web',
        'logo_path',
        'contact_principal'
    ];

    // Relation avec les recrutements
    public function recrutements()
    {
        return $this->hasMany(Recrutement::class);
    }
}


