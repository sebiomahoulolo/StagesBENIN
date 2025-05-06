<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Annonce extends Model
{
    use HasFactory;

    protected $fillable = [
        // Ne pas inclure 'entreprise_id' ici car il est défini manuellement et de manière sécurisée dans le contrôleur
        'nom_du_poste',
        'type_de_poste',
        'nombre_de_place',
        'niveau_detude',
        'secteur_id',       // Inclure car dérivé dans le contrôleur
        'specialite_id',
        'lieu',
        'email',
        'date_cloture',
        'description',
        'statut',           // Peut être fillable si admin peut le changer, sinon non
        'motif_rejet',      // Idem
        'admin_id',         // Idem
        // 'slug',          // Non fillable, généré automatiquement
        'est_active',       // Peut être fillable si admin peut le changer
        'nombre_vues',
        'pretension_salariale'
    ];

    protected $casts = [
        'date_cloture' => 'datetime',
        'est_active' => 'boolean',
        'pretension_salariale' => 'decimal:2' // Ajuster si besoin (ex: 'float')
    ];

    // Relation inverse vers L'Entreprise (CORRIGÉE)
    public function entreprise()
    {
        // La clé étrangère 'entreprise_id' dans cette table (Annonce)
        // référence la clé primaire 'id' (par convention) dans la table 'entreprises'
        return $this->belongsTo(Entreprise::class, 'entreprise_id', 'id');
        // Ou simplement par convention :
        // return $this->belongsTo(Entreprise::class);
    }

    public function candidatures()
    {
        return $this->hasMany(Candidature::class); // Assurez-vous que Candidature existe
    }

    // L'admin qui a approuvé/rejeté
    public function admin()
    {
        // Assurez-vous que admin_id référence bien users.id
        return $this->belongsTo(User::class, 'admin_id');
    }

    public function secteur()
    {
        return $this->belongsTo(Secteur::class); // Assurez-vous que Secteur existe
    }

    public function specialite()
    {
        return $this->belongsTo(Specialite::class); // Assurez-vous que Specialite existe
    }

    // Méthode pour incrémenter les vues
    public function incrementViews()
    {
        $this->increment('nombre_vues');
        // Ou pour éviter les conditions de concurrence si beaucoup de trafic :
        // static::where('id', $this->id)->increment('nombre_vues');
    }

    // Génération automatique du slug lors de la création
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($annonce) {
            if (empty($annonce->slug)) { // Vérifier si un slug n'est pas déjà défini
                 $baseSlug = Str::slug($annonce->nom_du_poste);
                 $slug = $baseSlug;
                 $count = 1;
                 // Assurer l'unicité (simple vérification, peut être améliorée)
                 while (static::where('slug', $slug)->exists()) {
                     $slug = $baseSlug . '-' . $count++;
                 }
                 $annonce->slug = $slug;
            }
             // Assigner le statut par défaut si non défini explicitement
            if (empty($annonce->statut)) {
                $annonce->statut = 'en_attente'; // Ou lire depuis une config/constante
            }
            // Assigner est_active par défaut si non défini
            if (!isset($annonce->est_active)) { // Utiliser isset pour gérer false/0
                $annonce->est_active = true; // Ou lire depuis une config/constante
            }
        });

        // Optionnel: Générer un nouveau slug si le nom_du_poste change lors d'une mise à jour? (Attention aux liens)
        // static::updating(function ($annonce) {
        //     if ($annonce->isDirty('nom_du_poste')) {
        //         // Logique pour regénérer le slug si besoin
        //     }
        // });
    }

    // Utiliser le slug pour le Route Model Binding
    public function getRouteKeyName()
    {
        return 'slug';
    }

    // ----- SCOPES -----

    // Annonces visibles publiquement (actives, approuvées, non expirées)
    public function scopeActive($query)
    {
        return $query->where('est_active', true)
                    ->where('statut', 'approuve')
                    ->where('date_cloture', '>', now());
    }

    // Scopes pour filtrer par statut (utiles pour admin/entreprise)
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