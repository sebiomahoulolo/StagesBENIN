<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\CvProfile; // Si vous avez implémenté le CV

class Etudiant extends Model
{
    use HasFactory;

    // Ajoutez 'user_id' aux fillable
    protected $fillable = [
        'user_id', // Clé étrangère
        'nom',
        'prenom',
        'email', // Peut être redondant avec users.email, à gérer
        'telephone',
        'formation',
        'niveau',
        'type_emploi',
        'date_naissance',
        'cv_path',
        'photo_path',
        'specialite_id', // Ajout de specialite_id dans les fillable
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'date_naissance' => 'date',
        'email_verified_at' => 'datetime', // Si vous l'avez dans la table users et voulez la caster ici
    ];

    // Relation inverse vers User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relation vers le profil CV (si implémenté)
    public function cvProfile()
    {
        return $this->hasOne(CvProfile::class);
    }
    public function entretiens()
{
    return $this->hasMany(Entretien::class);
}
public function entreprise()
{
    return $this->belongsTo(Entreprise::class);
}
public function entretien() {
        return $this->hasOne(Entretien::class);
    }

    // Relation avec l'annonce (Un étudiant appartient à une annonce)
    public function annonce() {
        return $this->belongsTo(Annonce::class);
    }


/**
 * Obtenir les plaintes et suggestions soumises par l'étudiant.
 */
public function complaintsSuggestions()
{
    return $this->hasMany(ComplaintSuggestion::class);
}

/**
 * Obtenir les candidatures soumises par l'étudiant.
 */
public function candidatures()
{
    return $this->hasMany(Candidature::class);
}

/**
 * Relation avec la spécialité de l'étudiant
 */
public function specialite()
{
    return $this->belongsTo(Specialite::class);
}

    /**
     * Retourne tous les paiements de l'étudiant
     */
    public function paiements()
    {
        return $this->hasMany(\App\Models\Paiement::class, 'etudiant_id');
    }

    /**
     * Retourne le dernier paiement valide (abonnement actif)
     */
    public function abonnementActif()
    {
        $now = \Carbon\Carbon::now();
        return $this->paiements()
            ->where('status', 'approved') // optionnel, filtre sur les paiements validés
            ->orderByDesc('created_at')
            ->first();
    }

    /**
     * Retourne le nombre de jours restants sur l’abonnement actif
     */
    public function joursRestantsAbonnement()
    {
        $abonnement = $this->abonnementActif();
        if (!$abonnement) return 0;
        $dateDebut = $abonnement->created_at;
        $dateFin = $abonnement->montant == 5000
            ? $dateDebut->copy()->addDays(365)
            : $dateDebut->copy()->addDays(30);
        $now = \Carbon\Carbon::now();
        return $dateFin->isFuture() ? $now->diffInDays($dateFin, false) : 0;
    }
}