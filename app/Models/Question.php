<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = ['texte', 'bonne_reponse_id'];

    // Définir la relation avec les options de réponse
    public function options()
    {
        return $this->hasMany(Option::class);
    }

    public function reponses()
{
    return $this->hasMany(Reponse::class);
}

}
