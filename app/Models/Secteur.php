<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Secteur extends Model
{
    use HasFactory;

    protected $fillable = ['nom'];

    public function specialites()
    {
        return $this->hasMany(Specialite::class);
    }

    public function annonces()
    {
        return $this->hasMany(Annonce::class);
    }
} 