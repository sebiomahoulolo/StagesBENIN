<?php

namespace App\Http\Controllers\Etudiant;

use App\Http\Controllers\Controller;
use App\Models\CvProfile;
use Illuminate\Http\Request; // Request n'est plus strictement nécessaire si on n'utilise pas $request dans edit/show
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf; // Vérifiez que vous avez bien `barryvdh/laravel-dompdf` installé
use Spatie\Browsershot\Browsershot; // Vérifiez que vous avez bien `spatie/laravel-browsershot` installé
use Spatie\Browsershot\Exceptions\CouldNotTakeBrowsershot; // Pour la gestion d'erreur Browsershot

class CvController extends Controller
{
    /**
     * Récupère le profil CV de l'étudiant connecté, en chargeant toutes les relations nécessaires.
     * Crée le profil CV s'il n'existe pas.
     *
     * @return CvProfile
     * @throws \Exception Si le profil étudiant n'existe pas ou si la création échoue.
     */
    private function getCurrentCvProfile()
    {
        $user = Auth::user();
        if (!$user || !$user->etudiant) {
            Log::error("Tentative d'accès au CV sans profil étudiant associé pour User ID: " . Auth::id());
            // Vous pourriez lancer une exception personnalisée ici
            throw new \Exception('Profil étudiant non trouvé. Veuillez contacter l\'administrateur.');
        }

        $etudiant = $user->etudiant;

        // Récupère ou crée le CvProfile et charge toutes les relations nécessaires en une seule fois
        $cvProfile = $etudiant->cvProfile()->firstOrCreate(
            ['etudiant_id' => $etudiant->id], // Conditions pour trouver/créer
            [] // Attributs additionnels si création (aucun ici)
        );

        // Eager load toutes les relations nécessaires pour l'affichage et l'export
        $cvProfile->loadMissing([
            'etudiant', // Charge la relation etudiant (contient nom, prenom etc.)
            'formations' => fn($query) => $query->orderBy('annee_debut', 'desc'),
            'experiences' => fn($query) => $query->orderBy('date_debut', 'desc'),
            'competences' => fn($query) => $query->orderBy('categorie')->orderBy('order', 'asc'), // Assurez-vous d'avoir 'order' si vous l'utilisez
            'langues' => fn($query) => $query->orderBy('order', 'asc'),
            'centresInteret' => fn($query) => $query->orderBy('order', 'asc'),
            'certifications' => fn($query) => $query->orderBy('annee', 'desc')->orderBy('order', 'asc'),
            'projets' => fn($query) => $query->orderBy('order', 'asc'),
            'references' => fn($query) => $query->orderBy('order', 'asc')
        ]);

        // Vérification après chargement (au cas où firstOrCreate retournerait null, bien que peu probable)
        if (!$cvProfile) {
             Log::critical("Impossible de récupérer ou créer CvProfile pour etudiant ID: " . $etudiant->id);
             throw new \Exception('Erreur lors du chargement du profil CV.');
        }

        return $cvProfile;
    }

    /**
     * Affiche la page d'édition du CV (qui contient les composants Livewire).
     *
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function edit()
    {
        try {
            $cvProfile = $this->getCurrentCvProfile();
            Log::info("Chargement de la page edit (Livewire) pour CvProfile ID: " . $cvProfile->id);
            // Passe l'objet CvProfile complet à la vue.
            // Les composants Livewire utiliseront $cvProfile->id.
            return view('etudiants.cv.edit', compact('cvProfile'));

        } catch (\Exception $e) {
            Log::error("Erreur majeure lors du chargement de la page edit CV: " . $e->getMessage(), ['exception' => $e]);
            return redirect()->route('etudiants.dashboard')
                      ->with('error', $e->getMessage()); // Affiche l'erreur spécifique
        }
    }

    /**
     * Affiche la page de visualisation du CV.
     *
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
     public function show()
     {
         try {
            // Récupère le profil CV avec toutes ses relations déjà chargées
            $cvProfile = $this->getCurrentCvProfile();
            Log::info("Affichage du CV Show pour CvProfile ID: " . $cvProfile->id);

            // Vérifie si la vue existe avant de la retourner
             if (!view()->exists('etudiants.cv.show')) {
                  Log::error("La vue 'etudiants.cv.show' est introuvable.");
                  abort(500, "Erreur de configuration de l'affichage du CV.");
             }
            if (!view()->exists('etudiants.cv.templates.default')) {
                  Log::error("Le template CV 'etudiants.cv.templates.default' est introuvable.");
                  abort(500, "Erreur de configuration du template CV.");
             }

            return view('etudiants.cv.show', compact('cvProfile'));

         } catch (\Exception $e) {
              Log::error("Erreur lors de l'affichage du CV (show): " . $e->getMessage(), ['exception' => $e]);
              // Redirige vers l'éditeur si l'affichage échoue, car le dashboard pourrait ne pas exister
              return redirect()->route('etudiants.cv.edit', ['cvProfile' => Auth::user()->etudiant?->cvProfile?->id ?? 0])
                        ->with('error', 'Impossible d\'afficher le CV pour le moment : ' . $e->getMessage());
         }
     }

    /**
     * Exporte le CV au format PDF.
     *
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    // Décommenté pour réactiver l'export PDF serveur avec dompdf
    public function exportPdf()
    {
        $cvProfile = null; // Initialise pour le bloc catch
        Log::info("Tentative d'export PDF (serveur dompdf) pour CvProfile ID: " . Auth::user()->etudiant?->cvProfile?->id);
        try {
            if (!class_exists(Pdf::class)) {
                Log::error("Le package 'barryvdh/laravel-dompdf' n'est pas installé ou configuré correctement.");
                throw new \Exception("La génération PDF n'est pas disponible sur le serveur.");
            }

            $cvProfile = $this->getCurrentCvProfile(); // Récupère le profil avec relations

            // Log pour vérifier les données avant de générer le PDF
            Log::debug("Données pour PDF:", $cvProfile->toArray());

            // Génération du PDF en utilisant le template PDF optimisé
            $pdf = Pdf::loadView('etudiants.cv.templates.pdf', compact('cvProfile'))
                       ->setPaper('a4', 'portrait'); // Définit explicitement le format
            
            // Force dompdf à ne pas utiliser de margin (important)
            $pdf->setOptions([
                'dpi' => 150,
                'defaultFont' => 'DejaVu Sans',
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => true,
                'margin_top' => 0,
                'margin_right' => 0,
                'margin_bottom' => 0,
                'margin_left' => 0
            ]);

            // Nom de fichier dynamique et "slugifié"
             $filename = 'cv-' . Str::slug($cvProfile->nom_complet ?: 'etudiant-' . $cvProfile->etudiant_id) . '.pdf';

            Log::info("Export PDF serveur (dompdf) réussi pour {$filename}");

            // Retourne le PDF pour téléchargement
            return $pdf->download($filename);

        } catch (\Exception $e) {
            Log::error("Erreur lors de l'export PDF serveur (dompdf): " . $e->getMessage(), ['exception' => $e]);
            // Redirige vers la page de visualisation avec un message d'erreur
            return redirect()->route('etudiants.cv.show', ['cvProfile' => $cvProfile->id ?? Auth::user()->etudiant?->cvProfile?->id ?? 0])
                      ->with('error', 'Erreur lors de la génération du PDF : ' . $e->getMessage()); // Message d'erreur plus générique
        }
    }
    // Fin de exportPdf

     /**
      * Exporte le CV au format PNG en utilisant Browsershot.
      *
      * @return \Symfony\Component\HttpFoundation\Response|\Illuminate\Http\RedirectResponse
      */
      public function exportPng()
      {
          $cvProfile = null; // Initialise pour le bloc catch
          Log::info("Tentative d'export PNG pour CvProfile ID: " . Auth::user()->etudiant?->cvProfile?->id);
          try {
                // Vérifier si Browsershot est disponible
                 if (!class_exists(Browsershot::class)) {
                     Log::error("Le package 'spatie/laravel-browsershot' n'est pas installé ou Puppeteer/Chrome n'est pas configuré.");
                     throw new \Exception("La génération d'image PNG n'est pas disponible sur le serveur.");
                 }

                $cvProfile = $this->getCurrentCvProfile(); // Récupère profil et relations

                // Rendre la vue Blade en HTML
                $htmlContent = view('etudiants.cv.templates.default', compact('cvProfile'))->render();

                // Log HTML pour débogage si nécessaire (peut être volumineux)
                // Log::debug("HTML généré pour PNG: " . substr($htmlContent, 0, 500) . "...");

                // Configuration et exécution de Browsershot
                $browsershot = Browsershot::html($htmlContent)
                    ->noSandbox() // Souvent nécessaire sur les serveurs (sécurité à évaluer)
                     // Optionnel: Spécifier le chemin vers Chrome/Chromium si non trouvé automatiquement
                     // ->setChromePath('/chemin/vers/chrome-ou-chromium')
                    ->windowSize(1000, 1414) // Taille approx A4 pour une bonne résolution initiale
                    ->deviceScaleFactor(2) // Augmente la résolution (qualité x2)
                    // ->fullPage() // Capture la page entière (peut être très long si le CV est grand) - à tester
                    ->waitUntilNetworkIdle(1000, 500) // Attend le réseau (1s idle, check toutes les 500ms)
                    ->timeout(120); // Timeout de 2 minutes pour le rendu

                // Capture d'écran et récupération des données binaires PNG
                $imageData = $browsershot->screenshot();

                if (!$imageData) {
                     throw new \Exception("Browsershot a retourné une image vide.");
                }

                // Nom de fichier dynamique
                $filename = 'cv-' . Str::slug($cvProfile->nom_complet ?: 'etudiant-' . $cvProfile->etudiant_id) . '.png';

                Log::info("Export PNG réussi pour {$filename}");

                // Retourner la réponse pour télécharger l'image
                return response($imageData)
                        ->header('Content-Type', 'image/png')
                        ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');

           } catch (CouldNotTakeBrowsershot $e) { // Erreur spécifique à Browsershot
                Log::error("Erreur Browsershot lors de l'export PNG: " . $e->getMessage(), ['exception' => $e]);
                $errorMessage = 'Erreur technique lors de la génération de l\'image PNG (Browsershot).';
                 // Tenter de détecter le problème Chrome/Puppeteer
                 if (str_contains(strtolower($e->getMessage()), 'chrome') || str_contains(strtolower($e->getMessage()), 'puppeteer')) {
                     $errorMessage .= ' Assurez-vous que Chrome/Puppeteer est correctement installé et accessible.';
                 }
                return redirect()->route('etudiants.cv.show', ['cvProfile' => $cvProfile->id ?? Auth::user()->etudiant?->cvProfile?->id ?? 0])
                          ->with('error', $errorMessage . ' Consultez les logs serveur pour détails.');
           }
            catch (\Exception $e) { // Autres erreurs
                Log::error("Erreur générale lors de l'export PNG: " . $e->getMessage(), ['exception' => $e]);
                return redirect()->route('etudiants.cv.show', ['cvProfile' => $cvProfile->id ?? Auth::user()->etudiant?->cvProfile?->id ?? 0])
                          ->with('error', 'Erreur inattendue lors de la génération du PNG : ' . $e->getMessage());
           }
      }
}