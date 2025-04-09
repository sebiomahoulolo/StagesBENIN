<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CvFormation extends Model {
    use HasFactory;

    protected $fillable = [
        'cv_profile_id', 
        'diplome', 
        'etablissement', 
        'ville', 
        'annee_debut', 
        'annee_fin', 
        'description', 
        'order'
    ];

    public function cvProfile() { 
        return $this->belongsTo(CvProfile::class); 
    }
}