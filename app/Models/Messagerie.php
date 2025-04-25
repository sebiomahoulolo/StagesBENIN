<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Messagerie extends Model
{
    use HasFactory;
    protected $fillable = ['entreprise_id', 'objet', 'message'];
    // Relation inverse vers L'Entreprise
    public function entreprise()
    {
        return $this->belongsTo(Entreprise::class);
    }
}
