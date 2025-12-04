<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Abonnement extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'date_debut',
        'date_fin',
        'actif',
        'type',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function estActif()
    {
        return $this->actif && now()->between($this->date_debut, $this->date_fin);
    }
} 