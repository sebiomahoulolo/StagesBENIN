<?php

namespace App\Http\Controllers\Etudiant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log; // Pour le débogage

// Modèles requis
use App\Models\CvProfile;
use App\Models\CvFormation;
use App\Models\CvExperience;
use App\Models\CvCompetence;
use App\Models\CvLangue;
use App\Models\CvCentreInteret;
use App\Models\CvCertification;
use App\Models\CvProjet;
use App\Models\Etudiant;

// Form Requests pour la validation
use App\Http\Requests\Etudiant\UpdateProfileRequest;
use App\Http\Requests\Etudiant\StoreFormationRequest;
use App\Http\Requests\Etudiant\UpdateFormationRequest;
use App\Http\Requests\Etudiant\StoreExperienceRequest;
use App\Http\Requests\Etudiant\UpdateExperienceRequest;
use App\Http\Requests\Etudiant\StoreCompetenceRequest;
use App\Http\Requests\Etudiant\UpdateCompetenceRequest;
use App\Http\Requests\Etudiant\StoreLangueRequest;
use App\Http\Requests\Etudiant\UpdateLangueRequest;
use App\Http\Requests\Etudiant\StoreCentreInteretRequest;
use App\Http\Requests\Etudiant\UpdateCentreInteretRequest;
use App\Http\Requests\Etudiant\StoreCertificationRequest;
use App\Http\Requests\Etudiant\UpdateCertificationRequest;
use App\Http\Requests\Etudiant\StoreProjetRequest;
use App\Http\Requests\Etudiant\UpdateProjetRequest;


class CvController extends Controller
{
    // Récupère le profil CV associé à l'étudiant authentifié
    private function getCurrentCvProfile()
    {
        $etudiant = Auth::user()->etudiant; // Assurez-vous que la relation 'etudiant' existe sur le modèle User
        if (!$etudiant) {
            Log::error("Tentative d'accès au CV sans profil étudiant associé pour User ID: " . Auth::id());
            abort(403, 'Profil étudiant non trouvé ou non associé à cet utilisateur.');
        }
        // Récupère ou crée le CvProfile associé
        return $etudiant->cvProfile()->firstOrCreate(['etudiant_id' => $etudiant->id]);
    }

    // Méthode pour afficher la page d'édition du CV
    public function edit()
    {
        try {
            $cvProfile = $this->getCurrentCvProfile();
            $etudiant = $cvProfile->etudiant; // Récupère l'étudiant via la relation inverse

            // Charger toutes les relations nécessaires pour le formulaire
            $cvProfile->load([
                'formations', 'experiences', 'competences', 'langues',
                'centresInteret', // Assurez-vous que le nom de la relation est correct (centresInteret)
                'certifications', 'projets'
            ]);

            // Préparer les données pour la vue Blade et Alpine.js
            $cvData = [
                // Envoyer seulement les infos nécessaires et non sensibles de l'étudiant
                'etudiant' => [
                    'nom' => $etudiant->nom ?? '',
                    'prenom' => $etudiant->prenom ?? '',
                    'email' => $etudiant->email ?? '', // Email principal de l'étudiant
                    'telephone' => $etudiant->telephone ?? '', // Téléphone principal
                    // Ajoutez d'autres champs si nécessaire pour l'affichage par défaut
                ],
                // Envoyer l'objet CvProfile complet avec ses relations chargées
                // JSON encode/decode pour s'assurer que les structures imbriquées sont correctes
                'profile' => json_decode(json_encode($cvProfile))
            ];

             Log::info("Chargement de la page edit CV pour etudiant ID: " . $etudiant->id);
            // Passer $cvData à la vue
            return view('etudiants.cv.edit', compact('cvData'));

        } catch (\Exception $e) {
            Log::error("Erreur lors du chargement de la page edit CV: " . $e->getMessage());
            // Rediriger avec un message d'erreur générique
            return redirect()->route('dashboard') // Ou une autre route appropriée
                      ->with('error', 'Une erreur est survenue lors du chargement de l\'éditeur de CV.');
        }
    }

    // --- Gestion du Profil Général ---
    public function updateProfile(UpdateProfileRequest $request) // Utilise Form Request pour validation
    {
        try {
            $cvProfile = $this->getCurrentCvProfile();
            $validatedData = $request->validated();
            $newPhotoPath = null;

            // Gestion de l'upload de la photo s'il y en a une nouvelle
            if ($request->hasFile('photo_cv')) {
                // Supprimer l'ancienne photo si elle existe
                if ($cvProfile->photo_cv_path && Storage::disk('public')->exists($cvProfile->photo_cv_path)) {
                    Storage::disk('public')->delete($cvProfile->photo_cv_path);
                    Log::info("Ancienne photo CV supprimée: " . $cvProfile->photo_cv_path);
                }
                // Sauvegarder la nouvelle photo dans 'public/storage/cv_photos'
                $path = $request->file('photo_cv')->store('cv_photos', 'public');
                $validatedData['photo_cv_path'] = $path;
                $newPhotoPath = $path; // Garder trace pour la réponse JSON
                Log::info("Nouvelle photo CV uploadée: " . $path . " pour CvProfile ID: " . $cvProfile->id);
            } else {
                // Garder le chemin actuel si aucune nouvelle photo n'est envoyée
                // S'assurer qu'on n'écrase pas le chemin existant s'il n'est pas dans validatedData
                if (!isset($validatedData['photo_cv_path'])) {
                $newPhotoPath = $cvProfile->photo_cv_path;
                }
                // S'assurer que photo_cv_path n'est pas envoyé pour être nullifié si on n'envoie pas de fichier
                // (La validation doit gérer ça, mais sécurité supplémentaire)
                unset($validatedData['photo_cv']); // Assurez-vous que le champ fichier lui-même n'est pas passé à update()
            }


            // Mettre à jour le profil avec les données validées
            $cvProfile->update($validatedData);
            Log::info("Profil CV mis à jour pour CvProfile ID: " . $cvProfile->id);

            // Rafraîchir le modèle pour obtenir les dernières données (y compris timestamps, etc.)
            $cvProfile->refresh();

            // Retourner une réponse JSON attendue par le JS, INCLUANT le profil mis à jour
            return response()->json([
                'message' => 'Profil mis à jour avec succès !',
                'photo_cv_path' => $newPhotoPath, // Renvoyer le chemin (nouveau ou ancien)
                'profile' => $cvProfile // <<< AJOUT : Renvoyer le modèle mis à jour
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::warning("Échec de validation updateProfile: ", $e->errors());
            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            Log::error("Erreur lors de updateProfile pour CvProfile ID " . ($cvProfile->id ?? 'inconnu') . ": " . $e->getMessage());
            return response()->json(['message' => 'Erreur serveur lors de la mise à jour du profil.'], 500);
        }
    }


    // --- Gestion des Formations ---
    public function storeFormation(StoreFormationRequest $request)
    {
        try {
            $cvProfile = $this->getCurrentCvProfile();
            $formation = $cvProfile->formations()->create($request->validated());
            Log::info("Formation créée ID: {$formation->id} pour CvProfile ID: {$cvProfile->id}");
            return response()->json([
                'message' => 'Formation ajoutée avec succès !',
                'item' => $formation // 'item' est le nom attendu par le JS
            ], 201); // Status 201 Created
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::warning("Échec de validation storeFormation: ", $e->errors());
            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Exception $e) {
             Log::error("Erreur lors de storeFormation pour CvProfile ID {$cvProfile->id}: " . $e->getMessage());
             return response()->json(['message' => 'Erreur serveur lors de l\'ajout de la formation.'], 500);
        }
    }

    public function updateFormation(UpdateFormationRequest $request, $id)
    {
       try {
           $cvProfile = $this->getCurrentCvProfile();
            // Trouver la formation spécifique appartenant à ce profil (sécurité)
            $formation = $cvProfile->formations()->findOrFail($id);
            $formation->update($request->validated());
             Log::info("Formation mise à jour ID: {$id} pour CvProfile ID: {$cvProfile->id}");
            return response()->json([
                'message' => 'Formation mise à jour avec succès !',
                'item' => $formation
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            Log::warning("Tentative de mise à jour formation ID: {$id} non trouvée ou n'appartenant pas à CvProfile ID: {$cvProfile->id}");
            return response()->json(['message' => 'Formation non trouvée.'], 404);
        } catch (\Illuminate\Validation\ValidationException $e) {
             Log::warning("Échec de validation updateFormation ID {$id}: ", $e->errors());
             return response()->json(['errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            Log::error("Erreur lors de updateFormation ID {$id}: " . $e->getMessage());
            return response()->json(['message' => 'Erreur serveur lors de la mise à jour de la formation.'], 500);
        }
    }

     public function destroyFormation($id)
     {
        try {
            $cvProfile = $this->getCurrentCvProfile();
            $formation = $cvProfile->formations()->findOrFail($id);
            $formation->delete();
            Log::info("Formation supprimée ID: {$id} pour CvProfile ID: {$cvProfile->id}");
            // Pas besoin de renvoyer 'item' lors de la suppression
            return response()->json(['message' => 'Formation supprimée avec succès !']);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            Log::warning("Tentative de suppression formation ID: {$id} non trouvée ou n'appartenant pas à CvProfile ID: {$cvProfile->id}");
            return response()->json(['message' => 'Formation non trouvée.'], 404);
        } catch (\Exception $e) {
            Log::error("Erreur lors de destroyFormation ID {$id}: " . $e->getMessage());
            return response()->json(['message' => 'Erreur serveur lors de la suppression de la formation.'], 500);
        }
     }


     // --- Gestion des Expériences ---
     public function storeExperience(StoreExperienceRequest $request)
     {
         try {
             $cvProfile = $this->getCurrentCvProfile();
             $experience = $cvProfile->experiences()->create($request->validated());
             Log::info("Expérience créée ID: {$experience->id} pour CvProfile ID: {$cvProfile->id}");
             return response()->json(['message' => 'Expérience ajoutée !', 'item' => $experience], 201);
         } catch (\Illuminate\Validation\ValidationException $e) { return response()->json(['errors' => $e->errors()], 422); }
           catch (\Exception $e) { Log::error("Erreur storeExperience: ".$e->getMessage()); return response()->json(['message' => 'Erreur serveur.'], 500); }
     }

     public function updateExperience(UpdateExperienceRequest $request, $id)
     {
         try {
             $cvProfile = $this->getCurrentCvProfile();
             $experience = $cvProfile->experiences()->findOrFail($id);
             $experience->update($request->validated());
             Log::info("Expérience mise à jour ID: {$id}");
             return response()->json(['message' => 'Expérience mise à jour !', 'item' => $experience]);
         } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) { return response()->json(['message' => 'Expérience non trouvée.'], 404); }
           catch (\Illuminate\Validation\ValidationException $e) { return response()->json(['errors' => $e->errors()], 422); }
           catch (\Exception $e) { Log::error("Erreur updateExperience ID {$id}: ".$e->getMessage()); return response()->json(['message' => 'Erreur serveur.'], 500); }
     }

     public function destroyExperience($id)
     {
         try {
             $cvProfile = $this->getCurrentCvProfile();
             $experience = $cvProfile->experiences()->findOrFail($id);
             $experience->delete();
             Log::info("Expérience supprimée ID: {$id}");
             return response()->json(['message' => 'Expérience supprimée !']);
         } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) { return response()->json(['message' => 'Expérience non trouvée.'], 404); }
           catch (\Exception $e) { Log::error("Erreur destroyExperience ID {$id}: ".$e->getMessage()); return response()->json(['message' => 'Erreur serveur.'], 500); }
     }

    // --- Gestion des Compétences ---
    public function storeCompetence(StoreCompetenceRequest $request) {
         try {
             $cvProfile = $this->getCurrentCvProfile();
             $competence = $cvProfile->competences()->create($request->validated());
             Log::info("Compétence créée ID: {$competence->id} pour CvProfile ID: {$cvProfile->id}");
             return response()->json(['message' => 'Compétence ajoutée !', 'item' => $competence], 201);
         } catch (\Illuminate\Validation\ValidationException $e) { return response()->json(['errors' => $e->errors()], 422); }
           catch (\Exception $e) { Log::error("Erreur storeCompetence: ".$e->getMessage()); return response()->json(['message' => 'Erreur serveur.'], 500); }
    }
    public function updateCompetence(UpdateCompetenceRequest $request, $id) {
         try {
             $cvProfile = $this->getCurrentCvProfile();
             $competence = $cvProfile->competences()->findOrFail($id);
             $competence->update($request->validated());
             Log::info("Compétence mise à jour ID: {$id}");
             return response()->json(['message' => 'Compétence mise à jour !', 'item' => $competence]);
         } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) { return response()->json(['message' => 'Compétence non trouvée.'], 404); }
           catch (\Illuminate\Validation\ValidationException $e) { return response()->json(['errors' => $e->errors()], 422); }
           catch (\Exception $e) { Log::error("Erreur updateCompetence ID {$id}: ".$e->getMessage()); return response()->json(['message' => 'Erreur serveur.'], 500); }
    }
    public function destroyCompetence($id) {
         try {
             $cvProfile = $this->getCurrentCvProfile();
             $competence = $cvProfile->competences()->findOrFail($id);
             $competence->delete();
             Log::info("Compétence supprimée ID: {$id}");
             return response()->json(['message' => 'Compétence supprimée !']);
         } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) { return response()->json(['message' => 'Compétence non trouvée.'], 404); }
           catch (\Exception $e) { Log::error("Erreur destroyCompetence ID {$id}: ".$e->getMessage()); return response()->json(['message' => 'Erreur serveur.'], 500); }
    }

    // --- Gestion des Langues ---
    public function storeLangue(StoreLangueRequest $request) {
        try {
            $cvProfile = $this->getCurrentCvProfile();
            $langue = $cvProfile->langues()->create($request->validated());
            Log::info("Langue créée ID: {$langue->id} pour CvProfile ID: {$cvProfile->id}");
            return response()->json(['message' => 'Langue ajoutée !', 'item' => $langue], 201);
        } catch (\Illuminate\Validation\ValidationException $e) { return response()->json(['errors' => $e->errors()], 422); }
          catch (\Exception $e) { Log::error("Erreur storeLangue: ".$e->getMessage()); return response()->json(['message' => 'Erreur serveur.'], 500); }
    }
    public function updateLangue(UpdateLangueRequest $request, $id) {
        try {
            $cvProfile = $this->getCurrentCvProfile();
            $langue = $cvProfile->langues()->findOrFail($id);
            $langue->update($request->validated());
            Log::info("Langue mise à jour ID: {$id}");
            return response()->json(['message' => 'Langue mise à jour !', 'item' => $langue]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) { return response()->json(['message' => 'Langue non trouvée.'], 404); }
          catch (\Illuminate\Validation\ValidationException $e) { return response()->json(['errors' => $e->errors()], 422); }
          catch (\Exception $e) { Log::error("Erreur updateLangue ID {$id}: ".$e->getMessage()); return response()->json(['message' => 'Erreur serveur.'], 500); }
    }
    public function destroyLangue($id) {
        try {
            $cvProfile = $this->getCurrentCvProfile();
            $langue = $cvProfile->langues()->findOrFail($id);
            $langue->delete();
            Log::info("Langue supprimée ID: {$id}");
            return response()->json(['message' => 'Langue supprimée !']);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) { return response()->json(['message' => 'Langue non trouvée.'], 404); }
          catch (\Exception $e) { Log::error("Erreur destroyLangue ID {$id}: ".$e->getMessage()); return response()->json(['message' => 'Erreur serveur.'], 500); }
    }

    // --- Gestion des Centres d'Intérêt ---
    public function storeInteret(StoreCentreInteretRequest $request) {
        try {
            $cvProfile = $this->getCurrentCvProfile();
             // Le nom de la relation doit correspondre à celui défini dans le modèle CvProfile (probablement 'centresInteret')
            $interet = $cvProfile->centresInteret()->create($request->validated());
            Log::info("Centre d'intérêt créé ID: {$interet->id} pour CvProfile ID: {$cvProfile->id}");
            return response()->json(['message' => 'Intérêt ajouté !', 'item' => $interet], 201);
        } catch (\Illuminate\Validation\ValidationException $e) { return response()->json(['errors' => $e->errors()], 422); }
          catch (\Exception $e) { Log::error("Erreur storeInteret: ".$e->getMessage()); return response()->json(['message' => 'Erreur serveur.'], 500); }
    }
    public function updateInteret(UpdateCentreInteretRequest $request, $id) {
         try {
            $cvProfile = $this->getCurrentCvProfile();
            $interet = $cvProfile->centresInteret()->findOrFail($id);
            $interet->update($request->validated());
            Log::info("Centre d'intérêt mis à jour ID: {$id}");
            return response()->json(['message' => 'Intérêt mis à jour !', 'item' => $interet]);
         } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) { return response()->json(['message' => 'Intérêt non trouvé.'], 404); }
           catch (\Illuminate\Validation\ValidationException $e) { return response()->json(['errors' => $e->errors()], 422); }
           catch (\Exception $e) { Log::error("Erreur updateInteret ID {$id}: ".$e->getMessage()); return response()->json(['message' => 'Erreur serveur.'], 500); }
    }
    public function destroyInteret($id) {
        try {
            $cvProfile = $this->getCurrentCvProfile();
            $interet = $cvProfile->centresInteret()->findOrFail($id);
            $interet->delete();
            Log::info("Centre d'intérêt supprimé ID: {$id}");
            return response()->json(['message' => 'Intérêt supprimé !']);
         } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) { return response()->json(['message' => 'Intérêt non trouvé.'], 404); }
           catch (\Exception $e) { Log::error("Erreur destroyInteret ID {$id}: ".$e->getMessage()); return response()->json(['message' => 'Erreur serveur.'], 500); }
    }

    // --- Gestion des Certifications ---
    public function storeCertification(StoreCertificationRequest $request) {
        try {
            $cvProfile = $this->getCurrentCvProfile();
            $certification = $cvProfile->certifications()->create($request->validated());
            Log::info("Certification créée ID: {$certification->id} pour CvProfile ID: {$cvProfile->id}");
            return response()->json(['message' => 'Certification ajoutée !', 'item' => $certification], 201);
        } catch (\Illuminate\Validation\ValidationException $e) { return response()->json(['errors' => $e->errors()], 422); }
          catch (\Exception $e) { Log::error("Erreur storeCertification: ".$e->getMessage()); return response()->json(['message' => 'Erreur serveur.'], 500); }
    }
    public function updateCertification(UpdateCertificationRequest $request, $id) {
         try {
            $cvProfile = $this->getCurrentCvProfile();
            $certification = $cvProfile->certifications()->findOrFail($id);
            $certification->update($request->validated());
            Log::info("Certification mise à jour ID: {$id}");
            return response()->json(['message' => 'Certification mise à jour !', 'item' => $certification]);
         } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) { return response()->json(['message' => 'Certification non trouvée.'], 404); }
           catch (\Illuminate\Validation\ValidationException $e) { return response()->json(['errors' => $e->errors()], 422); }
           catch (\Exception $e) { Log::error("Erreur updateCertification ID {$id}: ".$e->getMessage()); return response()->json(['message' => 'Erreur serveur.'], 500); }
    }
    public function destroyCertification($id) {
         try {
            $cvProfile = $this->getCurrentCvProfile();
            $certification = $cvProfile->certifications()->findOrFail($id);
            $certification->delete();
            Log::info("Certification supprimée ID: {$id}");
            return response()->json(['message' => 'Certification supprimée !']);
         } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) { return response()->json(['message' => 'Certification non trouvée.'], 404); }
           catch (\Exception $e) { Log::error("Erreur destroyCertification ID {$id}: ".$e->getMessage()); return response()->json(['message' => 'Erreur serveur.'], 500); }
    }

    // --- Gestion des Projets ---
    public function storeProjet(StoreProjetRequest $request) {
        try {
            $cvProfile = $this->getCurrentCvProfile();
            $projet = $cvProfile->projets()->create($request->validated());
            Log::info("Projet créé ID: {$projet->id} pour CvProfile ID: {$cvProfile->id}");
            return response()->json(['message' => 'Projet ajouté !', 'item' => $projet], 201);
        } catch (\Illuminate\Validation\ValidationException $e) { return response()->json(['errors' => $e->errors()], 422); }
          catch (\Exception $e) { Log::error("Erreur storeProjet: ".$e->getMessage()); return response()->json(['message' => 'Erreur serveur.'], 500); }
    }
    public function updateProjet(UpdateProjetRequest $request, $id) {
        try {
            $cvProfile = $this->getCurrentCvProfile();
            $projet = $cvProfile->projets()->findOrFail($id);
            $projet->update($request->validated());
            Log::info("Projet mis à jour ID: {$id}");
            return response()->json(['message' => 'Projet mis à jour !', 'item' => $projet]);
         } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) { return response()->json(['message' => 'Projet non trouvé.'], 404); }
           catch (\Illuminate\Validation\ValidationException $e) { return response()->json(['errors' => $e->errors()], 422); }
           catch (\Exception $e) { Log::error("Erreur updateProjet ID {$id}: ".$e->getMessage()); return response()->json(['message' => 'Erreur serveur.'], 500); }
    }
    public function destroyProjet($id) {
        try {
            $cvProfile = $this->getCurrentCvProfile();
            $projet = $cvProfile->projets()->findOrFail($id);
            $projet->delete();
            Log::info("Projet supprimé ID: {$id}");
            return response()->json(['message' => 'Projet supprimé !']);
         } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) { return response()->json(['message' => 'Projet non trouvé.'], 404); }
           catch (\Exception $e) { Log::error("Erreur destroyProjet ID {$id}: ".$e->getMessage()); return response()->json(['message' => 'Erreur serveur.'], 500); }
    }


    // --- Méthode pour afficher le CV final (utilisée par la route 'show' et potentiellement l'export) ---
     public function show()
     {
         try {
            $cvProfile = $this->getCurrentCvProfile();
            // Eager load les relations nécessaires pour l'affichage
            $cvProfile->load([
                'etudiant', // Charger l'étudiant associé
                'formations' => fn($query) => $query->orderBy('annee_debut', 'desc'), // Trier par date
                'experiences' => fn($query) => $query->orderBy('date_debut', 'desc'), // Trier par date
                'competences' => fn($query) => $query->orderBy('categorie')->orderBy('nom'),
                'langues',
                'centresInteret',
                'certifications' => fn($query) => $query->orderBy('annee', 'desc'),
                'projets'
            ]);

             // Ajouter des accesseurs aux modèles si nécessaire pour formater des données
             // Ex: Dans CvProfile.php -> getNomCompletAttribute(), getPhotoUrlAttribute()
             // Ex: Dans Experience.php -> getPeriodeAttribute()

             Log::info("Affichage du CV pour CvProfile ID: " . $cvProfile->id);
            return view('etudiants.cv.show', compact('cvProfile')); // Vue pour la visualisation web

         } catch (\Exception $e) {
              Log::error("Erreur lors de l'affichage du CV: " . $e->getMessage());
              return redirect()->route('etudiants.cv.edit')
                        ->with('error', 'Impossible d\'afficher le CV pour le moment.');
         }
     }

      // --- Méthodes pour l'export (Placeholders) ---
      public function exportPdf()
      {
           // Logique d'export PDF (ex: avec DomPDF ou Browsershot)
           // $cvProfile = $this->getCurrentCvProfile()->load([...]); // Charger données
           // Vérifier que $cvProfile n'est pas null
           // $pdf = PDF::loadView('etudiants.cv.templates.default', compact('cvProfile')); // Utiliser le template
           // return $pdf->download('cv-'.$cvProfile->etudiant->nom.'.pdf');
           Log::warning("Fonctionnalité export PDF appelée mais non implémentée.");
           return redirect()->route('etudiants.cv.show')->with('error', 'Export PDF non disponible pour le moment.');
      }

      public function exportPng()
      {
           // Logique d'export PNG (ex: avec Browsershot)
           // $cvProfile = $this->getCurrentCvProfile()->load([...]);
           // Vérifier que $cvProfile n'est pas null
           // Browsershot::url(route('etudiants.cv.show.rendered', $cvProfile->id)) // Nécessite une route qui rend JUSTE le template
           //     ->waitUntilNetworkIdle()
           //     ->save(storage_path('app/public/cv-exports/cv-'.$cvProfile->etudiant->nom.'.png'));
           // return response()->download(storage_path(...));
           Log::warning("Fonctionnalité export PNG appelée mais non implémentée.");
           return redirect()->route('etudiants.cv.show')->with('error', 'Export PNG non disponible pour le moment.');
      }
}