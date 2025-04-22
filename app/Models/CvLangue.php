<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CvLangue extends Model {
    use HasFactory;

    protected $fillable = [
        'cv_profile_id', 
        'langue', 
        'niveau', 
        'order'
    ];

    public function cvProfile() { 
        return $this->belongsTo(CvProfile::class); 
    }

    // Helper pour le niveau en points (pour affichage)
    public function getNiveauPointsAttribute() {
        switch (strtolower($this->niveau)) {
            case 'natif': return 5;
            case 'courant': case 'c2': case 'c1': return 4;
            case 'intermédiaire': case 'b2': case 'b1': return 3;
            case 'débutant': case 'a2': case 'a1': return 2;
            default: return 1;
        }
    }
}