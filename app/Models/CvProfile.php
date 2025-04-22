<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Etudiant; // Assurez-vous que le namespace est correct
use App\Models\CvFormation; // Import the CvFormation model
use App\Models\CvExperience; // Import the CvExperience model
use App\Models\CvCompetence; // Import the CvCompetence model
use App\Models\CvLangue; // Import the CvLangue model
use App\Models\CvCentreInteret; // Import the CvCentreInteret model
use App\Models\CvCertification; // Import the CvCertification model
use App\Models\CvProjet; // Import the CvProjet model
use App\Models\CvReference; // Import the CvReference model


class CvProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'etudiant_id', 
        'titre_profil', 
        'resume_profil', 
        'adresse',
        'telephone_cv', 
        'email_cv', 
        'linkedin_url', 
        'portfolio_url',
        'photo_cv_path', 
        'template_slug',
        'situation_matrimoniale',
        'nationalite',
        'date_naissance',
        'lieu_naissance',
    ];

    protected $casts = [
        'date_naissance' => 'date', // Caster la date de naissance en objet Date
    ];

    // Relation inverse avec Etudiant
    public function etudiant() {
        return $this->belongsTo(Etudiant::class);
    }

    // Relations HasMany pour les sections
    public function formations() {
        return $this->hasMany(CvFormation::class)->orderBy('order');
    }
    public function experiences() {
        return $this->hasMany(CvExperience::class)->orderBy('order');
    }
    public function competences() {
        return $this->hasMany(CvCompetence::class)->orderBy('categorie')->orderBy('order');
    }
    public function langues() {
        return $this->hasMany(CvLangue::class)->orderBy('order');
    }
    public function centresInteret() {
        return $this->hasMany(CvCentreInteret::class)->orderBy('order');
    }
    public function certifications() {
        return $this->hasMany(CvCertification::class)->orderBy('order');
    }
    public function projets() {
        return $this->hasMany(CvProjet::class)->orderBy('order');
    }

    // Nouvelle relation pour les références
    public function references() {
        return $this->hasMany(CvReference::class)->orderBy('order');
    }

    // Accesseur pour obtenir la photo (priorité photo_cv, sinon photo etudiant)
    public function getPhotoUrlAttribute() {
        if ($this->photo_cv_path && file_exists(public_path($this->photo_cv_path))) {
            return asset($this->photo_cv_path);
        } elseif ($this->etudiant && $this->etudiant->photo_path && file_exists(public_path($this->etudiant->photo_path))) {
            return asset($this->etudiant->photo_path);
        }
        // Retourner une image placeholder si aucune photo n'est trouvée
         return 'https://via.placeholder.com/150/e0e0e0/333?text=Photo'; // Ou un asset local
    }

     // Accesseur pour obtenir le nom complet de l'étudiant
    public function getNomCompletAttribute() {
        return optional($this->etudiant)->prenom . ' ' . optional($this->etudiant)->nom;
    }

     // Accesseur pour obtenir le contact principal (priorité CV, sinon étudiant)
     public function getContactTelephoneAttribute() {
        return $this->telephone_cv ?: optional($this->etudiant)->telephone;
     }
     public function getContactEmailAttribute() {
         return $this->email_cv ?: optional($this->etudiant)->email;
     }
}