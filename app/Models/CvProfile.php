<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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
        'completion_status',
        'completion_percentage',
    ];

    protected $casts = [
        'date_naissance' => 'date',
        'completion_status' => 'array',
        'completion_percentage' => 'integer',
    ];

    public function calculateCompletion()
    {
        // Définir les poids pour chaque section
        $weights = [
            'profil' => 25, // Le profil est très important (25%)
            'formations' => 15, // Éducation (15%)
            'experiences' => 15, // Expérience (15%)
            'competences' => 10, // Compétences (10%)
            'langues' => 5, // Langues (5%)
            'centres_interet' => 5, // Centres d'intérêt (5%)
            'certifications' => 5, // Certifications (5%)
            'projets' => 5, // Projets (5%)
            'references' => 5, // Références (5%)
        ];

        // Calculer le score pondéré pour chaque section
        $scores = [
            'profil' => $this->isProfilComplete() ? $weights['profil'] : 0,
            'formations' => $this->isFormationsComplete() ? $weights['formations'] : 0,
            'experiences' => $this->isExperiencesComplete() ? $weights['experiences'] : 0,
            'competences' => $this->isCompetencesComplete() ? $weights['competences'] : 0,
            'langues' => $this->isLanguesComplete() ? $weights['langues'] : 0,
            'centres_interet' => $this->isCentresInteretComplete() ? $weights['centres_interet'] : 0,
            'certifications' => $this->isCertificationsComplete() ? $weights['certifications'] : 0,
            'projets' => $this->isProjetsComplete() ? $weights['projets'] : 0,
            'references' => $this->isReferencesComplete() ? $weights['references'] : 0,
        ];

        // Calculer le pourcentage total
        $totalScore = array_sum($scores);
        $totalWeight = array_sum($weights);
        $completionPercentage = ($totalScore / $totalWeight) * 100;
        
        // Arrondir au nombre entier le plus proche
        $completionPercentage = round($completionPercentage);
        
        return $completionPercentage;
    }

    public function updateCompletionStatus()
    {
        $percentage = $this->calculateCompletion();
        
        // Mettre à jour le statut de complétion et le pourcentage
        $scores = [
            'profil' => $this->isProfilComplete() ? 100 : 0,
            'formations' => $this->isFormationsComplete() ? 100 : 0,
            'experiences' => $this->isExperiencesComplete() ? 100 : 0,
            'competences' => $this->isCompetencesComplete() ? 100 : 0,
            'langues' => $this->isLanguesComplete() ? 100 : 0,
            'centres_interet' => $this->isCentresInteretComplete() ? 100 : 0,
            'certifications' => $this->isCertificationsComplete() ? 100 : 0,
            'projets' => $this->isProjetsComplete() ? 100 : 0,
            'references' => $this->isReferencesComplete() ? 100 : 0,
        ];

        $this->completion_status = $scores;
        $this->completion_percentage = $percentage;
        $this->save();
    }

    /**
     * Calcule le nombre de sections restantes à compléter
     *
     * @return int
     */
    public function calculateRemainingSections()
    {
        $sections = [
            'profil' => $this->isProfilComplete(),
            'formations' => $this->isFormationsComplete(),
            'experiences' => $this->isExperiencesComplete(),
            'competences' => $this->isCompetencesComplete(),
            'langues' => $this->isLanguesComplete(),
            'centres_interet' => $this->isCentresInteretComplete(),
            'certifications' => $this->isCertificationsComplete(),
            'projets' => $this->isProjetsComplete(),
            'references' => $this->isReferencesComplete(),
        ];

        return count(array_filter($sections, function($completed) {
            return !$completed;
        }));
    }

    public function isProfilComplete()
    {
        // Vérifier si toutes les informations de base sont remplies
        $requiredFields = [
            'titre_profil',
            'resume_profil',
            'adresse',
            'telephone_cv',
            'email_cv',
            'date_naissance',
            'lieu_naissance',
            'situation_matrimoniale',
            'nationalite'
        ];

        foreach ($requiredFields as $field) {
            if (empty($this->$field)) {
                return false;
            }
        }

        return true;
    }

    public function isFormationsComplete()
    {
        return $this->formations()->count() >= 1;
    }

    public function isExperiencesComplete()
    {
        return $this->experiences()->count() >= 1;
    }

    public function isCompetencesComplete()
    {
        return $this->competences()->count() >= 3;
    }

    public function isLanguesComplete()
    {
        return $this->langues()->count() >= 1;
    }

    public function isCentresInteretComplete()
    {
        return $this->centresInteret()->count() >= 2;
    }

    public function isCertificationsComplete()
    {
        return $this->certifications()->count() >= 1;
    }

    public function isProjetsComplete()
    {
        return $this->projets()->count() >= 1;
    }

    public function isReferencesComplete()
    {
        return $this->references()->count() >= 2;
    }

    // Relations
    public function etudiant()
    {
        return $this->belongsTo(Etudiant::class);
    }

    public function formations()
    {
        return $this->hasMany(CvFormation::class)->orderBy('order');
    }

    public function experiences()
    {
        return $this->hasMany(CvExperience::class)->orderBy('order');
    }

    public function competences()
    {
        return $this->hasMany(CvCompetence::class)->orderBy('categorie')->orderBy('order');
    }

    public function langues()
    {
        return $this->hasMany(CvLangue::class)->orderBy('order');
    }

    public function centresInteret()
    {
        return $this->hasMany(CvCentreInteret::class)->orderBy('order');
    }

    public function certifications()
    {
        return $this->hasMany(CvCertification::class)->orderBy('order');
    }

    public function projets()
    {
        return $this->hasMany(CvProjet::class)->orderBy('order');
    }

    public function references()
    {
        return $this->hasMany(CvReference::class)->orderBy('order');
    }
}