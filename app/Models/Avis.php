<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Avis extends Model
{
    use HasFactory;

    protected $table = 'avis';

    protected $fillable = [
        'nom',
        'email',
        'catalogue_id',
        'note',
        'commentaire',
    ];

    // Relation avec Catalogue
    public function catalogue()
    {
        return $this->belongsTo(Catalogue::class);
    }
}
