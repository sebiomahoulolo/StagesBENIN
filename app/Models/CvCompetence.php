<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CvCompetence extends Model {
    use HasFactory;

    protected $fillable = [
        'cv_profile_id', 
        'categorie', 
        'nom', 
        'niveau', 
        'order'
    ];

    public function cvProfile() { 
        return $this->belongsTo(CvProfile::class); 
    }
}