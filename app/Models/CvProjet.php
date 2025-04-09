<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CvProjet extends Model {
    use HasFactory;

    protected $fillable = [
        'cv_profile_id', 
        'nom', 
        'url_projet', 
        'description', 
        'technologies', 
        'order'
    ];

    public function cvProfile() { 
        return $this->belongsTo(CvProfile::class); 
    }
}