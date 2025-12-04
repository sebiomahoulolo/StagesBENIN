<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CvProfil extends Model
{

    protected $table = 'cv_profils';

    protected $fillable = [
        'user_id',
        'username',
        'title',
        'email',
        'phone',
        'city',
        'url_linkedin',
        'url_portfolio',
        'photo',
        'situation_mat',
        'nationality',
        'birthday',
        'lieu_naissance',
        'resume',
    ];

public function etudiant()
{
    return $this->belongsTo(User::class, 'user_id');
}

    public function formations()
    {
        return $this->hasMany(\App\Models\CvFormation::class, 'cv_profil_id');
    }

    public function competences()
    {
        return $this->hasMany(\App\Models\CvCompetence::class, 'cv_profil_id');
    }

    public function langues()
    {
        return $this->hasMany(\App\Models\CvLangue::class, 'cv_profil_id');
    }

    public function certifications()
    {
        return $this->hasMany(\App\Models\CvCertification::class, 'cv_profil_id');
    }

    public function loisirs()
    {
        return $this->hasMany(\App\Models\CvLoisir::class, 'cv_profil_id');
    }

    public function projets()
    {
        return $this->hasMany(\App\Models\CvProjet::class, 'cv_profil_id');
    }

    public function experiences()
    {
        return $this->hasMany(\App\Models\CvExperience::class, 'cv_profil_id');
    }

    public function references()
    {
        return $this->hasMany(\App\Models\CvReference::class, 'cv_profil_id');
    }

    public function cvDownloads()
    {
        return $this->hasMany(\App\Models\CvDownload::class, 'cv_profil_id');
    }
}
