<?php

namespace App\Http\Controllers\Etudiant;

use App\Http\Controllers\Controller;
use App\Models\CvProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage; // Garder pour show() potentiellement
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str; // Pour Str::slug dans export

class CvController extends Controller
{
    // Récupère le profil CV associé à l'étudiant authentifié (ou le crée)
    private function getCurrentCvProfile()
    {
        $etudiant = Auth::user()->etudiant;
        if (!$etudiant) {
            Log::error("Tentative d'accès au CV sans profil étudiant associé pour User ID: " . Auth::id());
            abort(404, 'Profil étudiant non trouvé. Veuillez contacter l\'administrateur.');
        }
        // Récupère ou crée le CvProfile associé à cet étudiant
        return $etudiant->cvProfile()->firstOrCreate(['etudiant_id' => $etudiant->id]);
    }

    // Méthode pour afficher la page d'édition (Livewire)
    public function edit()
    {
        try {
            // Récupère ou crée le profil CV pour l'utilisateur connecté
            $cvProfile = $this->getCurrentCvProfile();

            if(!$cvProfile) {
                Log::error("Impossible de récupérer ou créer CvProfile pour etudiant ID: " . Auth::user()->etudiant->id);
                return redirect()->route('etudiants.dashboard')
                      ->with('error', 'Erreur lors du chargement de votre profil CV.');
            }

            Log::info("Chargement de la page edit (Livewire) pour CvProfile ID: " . $cvProfile->id);

            // Passe l'objet CvProfile à la vue. Livewire s'en servira via son ID.
            return view('etudiants.cv.edit', compact('cvProfile'));

        } catch (\Exception $e) {
            Log::error("Erreur majeure lors du chargement de la page edit CV: " . $e->getMessage(), ['exception' => $e]);
            return redirect()->route('etudiants.dashboard')
                      ->with('error', 'Une erreur critique est survenue lors du chargement de l\'éditeur de CV.');
        }
    }

    // --- Les méthodes AJAX store/update/destroy ne sont plus nécessaires pour la vue 'edit' ---

    // --- Les méthodes show et export restent utiles ---
     public function show()
     {
         try {
            $cvProfile = $this->getCurrentCvProfile();
            $cvProfile->load([
                'etudiant',
                'formations' => fn($query) => $query->orderBy('annee_debut', 'desc'),
                'experiences' => fn($query) => $query->orderBy('date_debut', 'desc'),
                'competences' => fn($query) => $query->orderBy('categorie')->orderBy('order', 'asc'),
                'langues' => fn($query) => $query->orderBy('order', 'asc'),
                'centresInteret' => fn($query) => $query->orderBy('order', 'asc'),
                'certifications' => fn($query) => $query->orderBy('annee', 'desc')->orderBy('order', 'asc'),
                'projets' => fn($query) => $query->orderBy('order', 'asc')
            ]);

             Log::info("Affichage du CV Show pour CvProfile ID: " . $cvProfile->id);
             if(view()->exists('etudiants.cv.show')) {
                return view('etudiants.cv.show', compact('cvProfile'));
             } else {
                 Log::warning("La vue etudiants.cv.show n'existe pas.");
                 abort(404, "Page de visualisation non trouvée.");
             }

         } catch (\Exception $e) {
              Log::error("Erreur lors de l'affichage du CV (show): " . $e->getMessage());
              return redirect()->route('etudiants.cv.edit')
                        ->with('error', 'Impossible d\'afficher le CV pour le moment.');
         }
     }

      public function exportPdf()
      {
           Log::info("Tentative d'export PDF pour l'étudiant ID: " . Auth::user()->etudiant?->id);
           try {
                $cvProfile = $this->getCurrentCvProfile();
                $cvProfile->load([
                    'etudiant', 'formations', 'experiences', 'competences',
                     'langues', 'centresInteret', 'certifications', 'projets'
                 ]);

                 if (class_exists(\Barryvdh\DomPDF\Facade\Pdf::class)) {
                     $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('etudiants.cv.templates.default', compact('cvProfile'));
                      $filename = 'cv-' . Str::slug($cvProfile->etudiant->prenom . '-' . $cvProfile->etudiant->nom) . '.pdf';
                      return $pdf->download($filename);
                 } else {
                      Log::error("DomPDF n'est pas installé. Exécuter 'composer require barryvdh/laravel-dompdf'.");
                     throw new \Exception("La génération PDF n'est pas disponible.");
                 }

           } catch (\Exception $e) {
                Log::error("Erreur lors de l'export PDF: " . $e->getMessage());
                return redirect()->route('etudiants.cv.show')->with('error', 'Erreur lors de la génération du PDF.');
           }
      }

      public function exportPng()
      {
          Log::warning("Fonctionnalité export PNG appelée mais non implémentée.");
           return redirect()->route('etudiants.cv.show')->with('error', 'Export PNG non disponible pour le moment.');
      }
}