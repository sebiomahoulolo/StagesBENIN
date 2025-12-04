<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CvDownload extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'cv_profil_id',
        'fichier_pdf',
        'nombre_telechargements',
        'dernier_telechargement',
        'is_paid'
    ];

    protected $casts = [
        'dernier_telechargement' => 'datetime',
        'nombre_telechargements' => 'integer'
    ];

    // Relations
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function cvProfil()
    {
        return $this->belongsTo(CvProfil::class, 'cv_profil_id');
    }

    // Méthodes utilitaires
    public function incrementDownloads()
    {
        if ($this->canDownload()) {
            $this->increment('nombre_telechargements');
            $this->update(['dernier_telechargement' => now()]);
            return true;
        }
        return false;
    }

    public function canDownload()
    {
        return $this->is_paid && $this->nombre_telechargements < 3;
    }

    public function resetDownloads()
    {
        $this->update([
            'is_paid' => true,
            'nombre_telechargements' => 0,
        ]);
    }

    public function getRemainingDownloads()
    {
        return max(0, 3 - $this->nombre_telechargements);
    }
}
