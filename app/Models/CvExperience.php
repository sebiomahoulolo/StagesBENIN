<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CvExperience extends Model {
    use HasFactory;

    protected $fillable = [
        'cv_profile_id', 
        'poste', 
        'entreprise', 
        'ville', 
        'date_debut', 
        'date_fin', 
        'description', 
        'taches_realisations', 
        'order'
    ];

    protected $casts = [
        'date_debut' => 'date', 
        'date_fin' => 'date'
    ]; // Important pour les dates

    public function cvProfile() { 
        return $this->belongsTo(CvProfile::class); 
    }

    // Helper pour afficher la période
    public function getPeriodeAttribute() {
        $debut = $this->date_debut->translatedFormat('F Y'); // Format 'Mars 2018'
        $fin = $this->date_fin ? $this->date_fin->translatedFormat('F Y') : 'Présent';
        return $debut . ' - ' . $fin;
    }

    // Helper pour parser les tâches/réalisations (si stockées en texte avec des marqueurs)
    public function getListeTachesAttribute() {
        if(empty($this->taches_realisations)) return [];
        // Exemple simple: une tâche par ligne commençant par '*' ou '-'
        return preg_split('/[\r\n]+/', trim($this->taches_realisations), -1, PREG_SPLIT_NO_EMPTY);
    }
}