<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Etudiant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class EtudiantController extends Controller
{
    //

    /**
     * Affiche la page de visualisation du CV d'un étudiant spécifique pour l'admin.
     *
     * @param  Etudiant $etudiant
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function showDetails(Etudiant $etudiant)
    {
        try {
            // Charger le profil CV avec toutes ses relations (similaire à CvController)
            $cvProfile = $etudiant->cvProfile()->with([
                'etudiant',
                'formations' => fn($query) => $query->orderBy('annee_debut', 'desc'),
                'experiences' => fn($query) => $query->orderBy('date_debut', 'desc'),
                'competences' => fn($query) => $query->orderBy('categorie')->orderBy('order', 'asc'),
                'langues' => fn($query) => $query->orderBy('order', 'asc'),
                'centresInteret' => fn($query) => $query->orderBy('order', 'asc'),
                'certifications' => fn($query) => $query->orderBy('annee', 'desc')->orderBy('order', 'asc'),
                'projets' => fn($query) => $query->orderBy('order', 'asc'),
                'references' => fn($query) => $query->orderBy('order', 'asc')
            ])->first();

            // Si l'étudiant n'a pas encore de profil CV (cas rare mais possible)
            if (!$cvProfile) {
                // Option 1: Rediriger avec un message
                // return redirect()->route('admin.etudiants.index')->with('warning', 'Cet étudiant n\'a pas encore créé son profil CV.');
                
                // Option 2: Créer un profil vide à la volée (peut être moins souhaitable)
                 $cvProfile = $etudiant->cvProfile()->create([]); // Crée un profil minimal
                 $cvProfile->load('etudiant'); // Recharger avec l'étudiant
                 Log::info("Profil CV créé à la volée pour l'étudiant ID {$etudiant->id} par l'admin.");
                 // Ou créer un objet vide pour le template
                 // $cvProfile = new \App\Models\CvProfile(); 
                 // $cvProfile->etudiant = $etudiant; // Assigner l'étudiant manuellement
            }
            
            // Vérifier si le template CV existe
            if (!view()->exists('etudiants.cv.templates.default')) {
                Log::error("Le template CV 'etudiants.cv.templates.default' est introuvable pour l'admin.");
                abort(500, "Erreur de configuration du template CV.");
            }

            Log::info("Admin visualise les détails de l'étudiant ID: {$etudiant->id}, Profile ID: {$cvProfile->id}");

            // Passer le $cvProfile (potentiellement créé à la volée ou existant) à la vue
            return view('admin.etudiants.show', compact('cvProfile', 'etudiant'));

        } catch (\Exception $e) {
            Log::error("Erreur admin lors de la visualisation des détails de l'étudiant ID {$etudiant->id}: " . $e->getMessage(), ['exception' => $e]);
            // Rediriger vers une page d'erreur admin ou la liste des étudiants
            return redirect()->route('admin.dashboard') // Ou admin.etudiants.index si elle existe
                      ->with('error', 'Impossible d\'afficher les détails de cet étudiant : ' . $e->getMessage());
        }
    }
}
