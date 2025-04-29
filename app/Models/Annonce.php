<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Annonce extends Model
{
    use HasFactory;

    protected $fillable = [
        'entreprise_id',
        'nom_du_poste',
        'type_de_poste',
        'nombre_de_place',
        'niveau_detude',
        'secteur_id',
        'specialite_id',
        'lieu',
        'email',
        'date_cloture',
        'description',
        'statut',
        'motif_rejet',
        'admin_id',
        'slug',
        'est_active',
        'nombre_vues',
        'pretension_salariale'
    ];

    protected $casts = [
        'date_cloture' => 'datetime',
        'est_active' => 'boolean',
        'pretension_salariale' => 'decimal:2'
    ];

    // Relation inverse vers L'Entreprise
    public function entreprise()
    {
        return $this->belongsTo(Entreprise::class);
    }

    public function candidatures()
    {
        return $this->hasMany(Candidature::class);
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    public function secteur()
    {
        return $this->belongsTo(Secteur::class);
    }

    public function specialite()
    {
        return $this->belongsTo(Specialite::class);
    }

    public function incrementViews()
    {
        $this->increment('nombre_vues');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($annonce) {
            $annonce->slug = Str::slug($annonce->nom_du_poste . '-' . Str::random(6));
        });
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function scopeActive($query)
    {
        return $query->where('est_active', true)
                    ->where('statut', 'approuve')
                    ->where('date_cloture', '>', now());
    }

    public function scopeEnAttente($query)
    {
        return $query->where('statut', 'en_attente');
    }

    public function scopeApprouve($query)
    {
        return $query->where('statut', 'approuve');
    }

    public function scopeRejete($query)
    {
        return $query->where('statut', 'rejete');
    }
}
