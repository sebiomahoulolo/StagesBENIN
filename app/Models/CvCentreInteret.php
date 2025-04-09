<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CvCentreInteret extends Model {
    use HasFactory;
    
    protected $fillable = [
        'cv_profile_id', 
        'nom', 
        'order'
    ];

    public function cvProfile() { 
        return $this->belongsTo(CvProfile::class); 
    }
}