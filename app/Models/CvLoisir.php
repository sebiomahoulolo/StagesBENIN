<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CvLoisir extends Model
{
    
    protected $fillable = [
        'cv_profil_id',
        'loisir',
    ];

    public function profils()
    {
        return $this->belongsToMany(\App\Models\CvProfil::class, 'cv_profil_interet', 'interet_id', 'cv_profil_id');
    }
}
