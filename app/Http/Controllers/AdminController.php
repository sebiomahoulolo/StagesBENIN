<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Etudiants\OffreController;
use App\Mail\SendMail;
use App\Models\Actualite;
use App\Models\Annonce;
use App\Models\Catalogue;
use App\Models\CvProfile;
use App\Models\Cvtheque;
use App\Models\Entreprise;
use App\Models\Entretien;
use App\Models\Etudiant;
use App\Models\Event;
use App\Models\Examen;
use App\Models\Question;
use App\Models\Recrutement;
use App\Models\Secteur;
use App\Models\Specialite;
use App\Models\Tier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class AdminController extends Controller
{

    public function validateSubmittedTier(Request $request) // <-- Prend Request, pas Tier $tier
    {
        // 1. Récupérer l'ID du Tier depuis le formulaire (champ caché)
        $tierId = $request->input('tier_id');

        // 2. Valider que l'ID est présent
        if (!$tierId) {
            return redirect()->route('admin.boost') // Redirige vers la liste
                ->with('error', "Erreur : ID du Boost manquant dans la requête.");
        }

        // 3. Essayer de trouver le Tier dans la base de données
        $tier = Tier::find($tierId);

        // 4. Vérifier si le Tier a été trouvé
        if (!$tier) {
            return redirect()->route('admin.boost')
                ->with('error', "Erreur : Boost avec l'ID {$tierId} non trouvé.");
        }

        // 5. Vérifier si le tier n'est pas déjà payé (logique existante)
        if ($tier->payment_status === 'paid') {
            return redirect()->route('admin.boost')
                ->with('warning', "Le Boost (ID: {$tier->id}) est déjà marqué comme payé.");
        }

        // 6. Essayer de mettre à jour et sauvegarder (logique existante)
        try {
            $tier->payment_status = 'paid';
            $tier->payment_date = now();
            $tier->save();

            Log::info("Boost (Tier ID: {$tier->id}) validé par l'administrateur (via validateSubmittedTier).");

            return redirect()->route('admin.boost')
                ->with('success', "Le Boost (ID: {$tier->id}) a été marqué comme Payé avec succès.");
        } catch (\Exception $e) {
            Log::error("Erreur lors de la validation du Boost (Tier ID: {$tier->id}) (via validateSubmittedTier): " . $e->getMessage());
            return redirect()->route('admin.boost')
                ->with('error', "Une erreur est survenue lors de la validation du Boost (ID: {$tier->id}).");
        }
    }
    public function index()
    {

        $etudiants = Etudiant::paginate(10);
        $actualites = Actualite::paginate(10);
        $events = Event::paginate(10);
        $catalogues = Catalogue::paginate(10);
        $catalogueItems = Catalogue::all();

        $specialites = Specialite::all(); // Fetch specialties





        $totalEtudiants = Etudiant::count();
        $progression = "N/A";

        return view('admin.dashboard', compact(
            'etudiants',
            'actualites',
            'events',
            'specialites',
            'catalogueItems',
            'totalEtudiants',
            'progression'
        ));
    }


    public function cvtheque($id)
    {
        try {
            // Vérifie si la vue existe avant d'exécuter le traitement
            if (!view()->exists('admin.cvtheque.cvtheque')) {
                Log::error("La vue 'admin.cvtheque.cvtheque' est introuvable.");
                abort(500, "Erreur de configuration de l'affichage de la CVthèque.");
            }

            // Récupère tous les profils CV avec la relation 'etudiant' pour un secteur donné
            // $cvProfiles = CvProfile::with('etudiant')->where('formation', $id)->get();
            $cvProfiles = CvProfile::join('etudiants', 'cv_profiles.etudiant_id', 'etudiants.id')
                ->join('specialites', 'etudiants.formation', 'specialites.id')
                ->join('secteurs', 'specialites.secteur_id', 'secteurs.id')
                ->where('specialites.secteur_id', $id)
                ->get();

            // $cvProfiles = CvProfile::with('etudiant')->where('secteur', $id)->get();

            // Récupère toutes les entreprises
            $entreprises = \App\Models\Entreprise::all();

            // Récupère toutes les spécialités avec leur secteur associé
            $specialites = \App\Models\Specialite::where('secteur_id', $id)->get();
            // dd($specialites);

            // Récupère les niveaux d'études distincts et non nuls
            $niveaux = \App\Models\Etudiant::whereNotNull('niveau')
                ->select('niveau')
                ->distinct()
                ->orderBy('niveau')
                ->pluck('niveau');

            // Compte le nombre d'étudiants par spécialité
            foreach ($specialites as $specialite) {
                $nombreEtudiants = \App\Models\Etudiant::where('formation', $specialite->id)->count();
                $specialite->setAttribute('nombre_etudiants', $nombreEtudiants);
            }

            // Log si aucun CV trouvé
            if ($cvProfiles->isEmpty()) {
                Log::warning("Aucun CV trouvé pour le secteur ID {$id}.");
            }

            Log::info("Affichage des CV pour l'admin : " . $cvProfiles->count() . " CV(s) récupéré(s).");

            // Retourne la vue avec les données
            return view('admin.cvtheque.cvtheque', compact('cvProfiles', 'entreprises', 'specialites', 'niveaux'));
        } catch (\Exception $e) {
            Log::error("Erreur lors de l'affichage de la CVthèque : " . $e->getMessage(), [
                'exception' => $e,
            ]);

            return view('admin.cvtheque.cvtheque')->with('error', "Une erreur est survenue lors de l'affichage des CV.");
        }
    }


    public function cvthequeSeteur()
    {
        $secteurs = Secteur::all();
        // dd($secteurs);
        return view('admin.cvtheque.secteur', compact('secteurs'));
    }


    public function etudiants()
    {
        // Récupérer les étudiants depuis la base de données
        $etudiants = Etudiant::join('specialites', 'etudiants.formation', '=', 'specialites.id')
            ->select('etudiants.*', 'specialites.nom as specialite_nom')
            ->paginate(10);
        $specialites = \App\Models\Specialite::with('secteur')->get();

        // dd($etudiants);

        // Retourner la vue avec les étudiants
        return view('admin.etudiants.etudiants', compact('etudiants', 'specialites'));
    }

    public function actualites()
    {
        // Récupérer les étudiants depuis la base de données
        $actualites = Actualite::paginate(10);

        // Retourner la vue avec les étudiants
        return view('admin.actualites', compact('actualites'));
    }

    


public function resultats_pratique() 
{
    // Récupérer tous les examens avec les informations des étudiants, entretien et annonce
    $examens = Examen::with([
        'etudiant:id,nom,niveau,formation',
           // Charge l'annonce liée à l'étudiant
    ])->get();

    return view('admin.resultats_pratique', compact('examens'));
}



public function noter(Request $request, $id)
{
    $request->validate([
        'note' => 'required|numeric|min:1|max:9',
        'commentaire' => 'nullable|string|max:1000',
    ]);

    $examen = Examen::findOrFail($id);
    $examen->note_finale = $request->note;
    $examen->commentaire = $request->commentaire;
    $examen->save();

    return redirect()->back()->with('success', 'Note enregistrée avec succès.');
}



    public function entretiens()
    {
        // Récupérer les entretiens avec les annonces associées
        $entretiens = Entretien::join('annonces', 'entretiens.annonce_id', '=', 'annonces.id')
            ->select('entretiens.*', 'annonces.nom_du_poste', 'annonces.id as annonce_id')
            ->latest()
            ->paginate(10);

        // Récupérer les ID des annonces déjà utilisées dans les entretiens
        $annonceIdsDejaUtilisees = Entretien::pluck('annonce_id')->toArray();

        // Récupérer toutes les annonces SAUF celles déjà programmées
        $annonces = Annonce::whereNotIn('id', $annonceIdsDejaUtilisees)->get();

        return view('admin.entretiens', compact('entretiens', 'annonces'));
    }


    public function storeEntretien(Request $request)
    {
        // dd($request->all());
        // Validation des données
        $validated = $request->validate([
            'annonce_id' => 'required|exists:annonces,id',
            'date' => 'required|date|after_or_equal:today',
            'heure' => 'required|date_format:H:i',
            'duree' => 'required|integer|min:1|max:120',
        ], [
            'annonce_id.required' => 'Veuillez sélectionner une annonce',
            'annonce_id.exists' => 'L\'annonce sélectionnée n\'existe pas',
            'date.required' => 'La date est requise',
            'date.date' => 'Le format de la date est invalide',
            'date.after_or_equal' => 'La date doit être aujourd\'hui ou une date future',
            'heure.required' => 'L\'heure est requise',
            'heure.date_format' => 'Le format de l\'heure est invalide',
            'duree.required' => 'La durée est requise',
            'duree.integer' => 'La durée doit être un nombre entier',
            'duree.min' => 'La durée doit être au moins de 1 minute',
            'duree.max' => 'La durée ne doit pas dépasser 120 minutes',
        ]);

        try {
            $reference = 'ENT' . date('Ymd') . rand(100, 999);
            // Création de l'entretien
            $entretien = Entretien::create([
                'annonce_id' => $validated['annonce_id'],
                'reference' => $reference,
                'date' => $validated['date'],
                'heure' => $validated['heure'],
                'duree' => $validated['duree'],
                'statut' => 'en_attente'
            ]);

            return redirect()->back()
                ->with('success', 'L\'entretien a été programmé avec succès.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Une erreur est survenue lors de la programmation de l\'entretien.');
        }
    }

    public function storeQuestionnaire(Request $request)
    {
        $annonce_id = $request->input('annonce_id');
        $entretien = Entretien::findOrFail($annonce_id);
        $annonce = Annonce::findOrFail($entretien->annonce_id);

        // Traitement des questions QCM
        if ($request->has('data_questions')) {
            foreach ($request->input('data_questions') as $questionData) {
                // Vérifier si la question existe déjà
                $existingQuestion = Question::where('entretien_id', $annonce_id)
                    ->where('question', $questionData['question'])
                    ->first();

                if ($existingQuestion && $existingQuestion->type == 'qcm') {
                    // Mettre à jour la question existante
                    $existingQuestion->update([
                        'question' => $questionData['question'],
                        'type' => 'qcm'
                    ]);

                    // Supprimer les anciennes réponses
                    $existingQuestion->reponses()->delete();

                    // Vérifier si les réponses existent avant de les traiter
                    if (isset($questionData['reponses']) && is_array($questionData['reponses'])) {
                        // Ajouter les nouvelles réponses
                        foreach ($questionData['reponses'] as $reponseData) {
                            if (isset($reponseData['texte'])) {
                                $existingQuestion->reponses()->create([
                                    'texte' => $reponseData['texte'],
                                    'valide' => isset($reponseData['valide']) ? true : false,
                                ]);
                            }
                        }
                    }
                } else {
                    // Créer une nouvelle question
                    $question = Question::create([
                        'entretien_id' => $annonce_id,
                        'question' => $questionData['question'],
                        'type' => 'qcm'
                    ]);

                    // Vérifier si les réponses existent avant de les traiter
                    if (isset($questionData['reponses']) && is_array($questionData['reponses'])) {
                        // Ajouter les réponses
                        foreach ($questionData['reponses'] as $reponseData) {
                            if (isset($reponseData['texte'])) {
                                $question->reponses()->create([
                                    'texte' => $reponseData['texte'],
                                    'valide' => isset($reponseData['valide']) ? true : false,
                                ]);
                            }
                        }
                    }
                }
            }
        }

        // Traitement des cas pratiques
        if ($request->has('data_cas_pratique')) {
            foreach ($request->input('data_cas_pratique') as $casPratiqueData) {
                // Vérifier si le cas pratique existe déjà
                $existingCasPratique = Question::where('entretien_id', $annonce_id)
                    ->where('question', $casPratiqueData['question'])
                    ->where('type', 'cas_pratique')
                    ->first();

                if ($existingCasPratique) {
                    // Mettre à jour le cas pratique existant
                    $existingCasPratique->update([
                        'question' => $casPratiqueData['question'],
                        'type' => 'cas_pratique'
                    ]);
                } else {
                    // Créer un nouveau cas pratique
                    Question::create([
                        'entretien_id' => $annonce_id,
                        'question' => $casPratiqueData['question'],
                        'type' => 'cas_pratique'
                    ]);
                }
            }
        }

        return redirect()->route('admin.entretiens.index')->with('success', 'Questionnaire enregistré avec succès.');
    }


    public function createEntretien($id)
    {
        $entretien = Entretien::findOrFail($id);
        $questions = Question::where('entretien_id', $id)->with('reponses')->get();

        return view('admin.create_entretien', compact('entretien', 'questions'));
    }

    public function boost()
    {
        // Récupérer les étudiants depuis la base de données
        $tiers = Tier::join('etudiants', 'tier.user_id', '=', 'etudiants.user_id')
            ->select('tier.*', 'etudiants.nom', 'etudiants.prenom', 'etudiants.email', 'etudiants.telephone', 'etudiants.formation', 'etudiants.niveau', 'etudiants.id as etudiant_id')
            ->paginate(10);

        // dd($tiers);


        // Retourner la vue avec les étudiants
        return view('admin.boost', compact('tiers'));
    }

    public function entreprises_partenaires()
    {
        // Récupérer les étudiants depuis la base de données
        $entreprises = Entreprise::paginate(10);

        // Retourner la vue avec les étudiants
        return view('admin.entreprises_partenaires', compact('entreprises'));
    }

    public function show($id)
    {
        $event = Event::findOrFail($id);
        return view('evenements.show', compact('event'));
    }

    public function edit($id)
    {
        $event = Event::findOrFail($id);
        return view('evenements.edit', compact('event'));
    }

    public function update(Request $request, $id)
    {
        $event = Event::findOrFail($id);
        $event->update($request->all());

        return redirect()->route('evenements.show', $event->id)->with('success', 'Événement mis à jour avec succès.');
    }

    public function destroy($id)
    {
        $event = Event::findOrFail($id);
        $event->delete();

        return redirect()->route('admin.evenements')->with('success', 'Événement supprimé avec succès.');
    }

    public function evenements()
    {
        // Récupérez les données nécessaires (par exemple, les événements)
        $evenements = Event::paginate(10);

        // Retournez la vue avec les événements
        return view('admin.evenements', compact('evenements'));
    }

    public function entreprises()
    {
        // Exemple : Récupérez les entreprises de la base de données
        $entreprises = Entreprise::paginate(10);

        // Retournez la vue avec les entreprises
        return view('admin.entreprises', compact('entreprises'));
    }

    public function catalogues()
    {
        // Exemple : Récupérez les catalogues depuis la base de données
        $catalogueItems = Catalogue::all();

        // Retournez la vue avec les catalogues
        return view('admin.catalogues', compact('catalogueItems'));
    }

    public function recrutements()
    {
        // Exemple : Récupérez les données nécessaires pour les recrutements
        $recrutements = Recrutement::paginate(10);

        // Retournez la vue avec les données
        return view('admin.recrutements', compact('recrutements'));
    }

    public function manageUsers()
    {
        // Gérer les utilisateurs
        return view('admin.manage_users');
    }

    public function specialite($id)
    {
        try {
            $specialite = \App\Models\Specialite::findOrFail($id);
            $etudiants = \App\Models\Etudiant::where('formation', $id)->get();
            $nombreEtudiants = $etudiants->count();
            $specialites = \App\Models\Specialite::with('secteur')->get();


            // Récupérer les niveaux uniques des étudiants
            $niveaux = \App\Models\Etudiant::where('formation', $id)
                ->whereNotNull('niveau')
                ->distinct()
                ->pluck('niveau')
                ->sort();
            // dd($etudiants);

            Log::info("Affichage des étudiants pour la spécialité {$specialite->nom} : {$nombreEtudiants} étudiant(s) trouvé(s).");

            return view('admin.cvtheque.specialite', compact('specialite', 'etudiants', 'nombreEtudiants', 'niveaux', 'specialites'));
        } catch (\Exception $e) {
            Log::error("Erreur lors de l'affichage des étudiants de la spécialité : " . $e->getMessage(), [
                'exception' => $e,
            ]);

            return redirect()->back()->with('error', 'Une erreur est survenue lors de l\'affichage des étudiants.');
        }
    }

    public function sendEmail(Request $request)
    {
        $details = [
            'title' => 'Mail de test',
            'body' => 'Ceci est un mail de test.'
        ];

        Mail::to('aboudousaliou284@gmail.com')->send(new SendMail($details));
        return redirect()->back()->with('success', 'Mail envoyé avec succès.');
    }

    public function updateStatus(Request $request, Entretien $entretien)
    {
        $validated = $request->validate([
            'status' => 'required|in:en_attente,planifié,terminé'
        ], [
            'status.required' => 'Le statut est requis',
            'status.in' => 'Le statut sélectionné est invalide'
        ]);

        // try {
        $entretien->update([
            'status' => $validated['status']
        ]);

        return redirect()->back()
            ->with('success', 'Le statut de l\'entretien a été mis à jour avec succès.');
        // } catch (\Exception $e) {
        //     return redirect()->back()
        //         ->with('error', 'Une erreur est survenue lors de la mise à jour du statut.');
        // }
    }
}
