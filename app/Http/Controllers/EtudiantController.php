<?php

namespace App\Http\Controllers;

use App\Models\Etudiant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Entretien;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Response;
use App\Models\Entreprise;
use App\Models\Examen;
use App\Models\Question;
use App\Models\Reponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

use App\Models\User;

class EtudiantController extends Controller
{
    public function etudiant()
    {
        return $this->hasOne(Etudiant::class, 'user_id');
    }
    public function entreprise()
    {
        return $this->belongsTo(Entreprise::class);
    }

    /**
     * Stocker un nouvel étudiant dans la base de données.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */



    public function index(Request $request)
    {
        $etudiant = auth()->user()->etudiant;

        $userId = $request->user()->id;

        // Récupérer les entretiens planifiés à venir pour l'utilisateur connecté
        $entretiens = Entretien::where('user_id', $userId)
            ->where('status', 'planifié')        // 🔍 Filtre sur le statut
            ->where('date', '>=', now())         // 🔍 Filtre sur la date future
            ->orderBy('date', 'asc')             // 🔃 Tri croissant par date
            ->get();

        // Retourner les entretiens à la vue
        return view('etudiants.dashboard', compact('entretiens', 'etudiant'));
    }






    public function dashboardCandidat()
    {
        // Récupérer l'utilisateur actuellement connecté
        $user = auth()->user();

        // Récupérer l'étudiant associé à l'utilisateur
        $etudiant = Etudiant::where('user_id', $user->id)->first();

        // Vérifier que l'utilisateur est bien lié à un étudiant
        if (!$etudiant) {
            return redirect()->route('home')->with('error', 'Aucun étudiant associé à cet utilisateur.');
        }

        // Récupérer les entretiens de l'étudiant, triés par date ascendante
        $entretiens = Entretien::where('etudiant_id', $etudiant->id)
            ->orderBy('date', 'asc')
            ->get();

        // Retourner la vue avec les données nécessaires
        return view('etudiants.dashboard', compact('entretiens', 'etudiant'));
    }

    public function entretiensProgrammes()
    {
        $entretiens = Entretien::join('annonces', 'entretiens.annonce_id', '=', 'annonces.id')
            ->join('candidatures', 'annonces.id', '=', 'candidatures.annonce_id')
            ->join('etudiants', 'candidatures.etudiant_id', '=', 'etudiants.id')
            ->select(
                'annonces.id as annonce_id',
                'annonces.nom_du_poste',
                DB::raw('MAX(entretiens.id) as entretien_id'),
                DB::raw('MAX(entretiens.date) as date'),
                DB::raw('MAX(entretiens.heure) as heure'),
                DB::raw('MAX(entretiens.duree) as duree'),
                DB::raw('MAX(entretiens.reference) as reference'),
                DB::raw('MAX(entretiens.status) as status'),
                DB::raw('MAX(etudiants.nom) as nom'),
                DB::raw('MAX(etudiants.prenom) as prenom')
            )
            ->where('entretiens.status', 'planifié')
            ->where('candidatures.statut', 'accepte')
            ->groupBy('annonces.id', 'annonces.nom_du_poste')
            ->orderBy('date', 'asc')
            ->get();

        return view('etudiants.entretien_programme', compact('entretiens'));
    }




    public function searchInternships()
    {
        // Rechercher des stages
        return view('etudiants.search_internships');
    }


    public function store(Request $request)
    {
        // Validation des données
        $validator = Validator::make($request->all(), [
            'nom' => 'required|string|max:100',
            'prenom' => 'required|string|max:100',
            'email' => 'required|email|unique:etudiants,email|max:255',
            'telephone' => 'nullable|string|max:20',
            'formation' => 'nullable|string|max:255',
            'niveau' => 'nullable|string|max:50',
            'date_naissance' => 'nullable|date',
            'cv' => 'nullable|file|mimes:pdf|max:5120',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Traitement du CV
        $cvPath = null;
        if ($request->hasFile('cv')) {
            $cv = $request->file('cv');
            $cvName = time() . '_' . $request->nom . '_' . $request->prenom . '.' . $cv->getClientOriginalExtension();
            $cv->move(public_path('documents/cv'), $cvName);
            $cvPath =  $cvName;
        }

        // Traitement de la photo
        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $photoName = time() . '_' . $request->nom . '_' . $request->prenom . '.' . $photo->getClientOriginalExtension();
            $photo->move(public_path('images/etudiants'), $photoName);
            $photoPath = $photoName;
        }

        // Création de l'étudiant
        $etudiant = Etudiant::create([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'email' => $request->email,
            'telephone' => $request->telephone,
            'formation' => $request->formation,
            'niveau' => $request->niveau,
            'date_naissance' => $request->date_naissance,
            'cv_path' => $cvPath,
            'photo_path' => $photoPath
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Étudiant ajouté avec succès',
            'etudiant' => $etudiant
        ], 201);
    }



    public function show($id)
    {
        $etudiant = Etudiant::findOrFail($id);
        return view('etudiants.show', compact('etudiant'));
    }



    public function edit($id)
    {
        $etudiant = Etudiant::findOrFail($id);
        return view('etudiants.edit', compact('etudiant'));
    }
    public function update(Request $request, $id)
    {
        $etudiant = Etudiant::findOrFail($id);
        $etudiant->update($request->all());

        return redirect()->route('etudiants.show', $etudiant->id)->with('success', 'Étudiant mis à jour avec succès.');
    }
    // app/Http/Controllers/EventController.php

    function destroy($id)
    {
        $etudiant = Etudiant::findOrFail($id);
        $etudiant->delete();

        return redirect()->route('admin.etudiants.etudiants')
            ->with('success', 'Étudiant supprimé avec succès.');
    }
    public function toggleStatus($id)
    {
        $etudiant = Etudiant::findOrFail($id);

        // Alterne le statut entre 1 (actif) et 0 (bloqué)
        $etudiant->statut = $etudiant->statut == 1 ? 0 : 1;
        $etudiant->save();

        return redirect()->route('admin.etudiants.etudiants')
            ->with('success', 'Statut de l\'étudiant mis à jour avec succès.');
    }


    public function downloadCV($id)
    {
        $etudiant = Etudiant::findOrFail($id);

        if (!$etudiant->cv_path || !Storage::disk('public')->exists($etudiant->cv_path)) {
            return back()->with('error', 'CV non disponible.');
        }

        return response()->download(storage_path("app/public/" . $etudiant->cv_path));
    }




    public function storeEntretien(Request $request)
    {
        Entretien::create([
            'etudiant_id' => $request->etudiant_id,
            'user_id' => auth()->id(), // Récupérer l'ID du programmeur (utilisateur connecté)
            'entreprise_id' => auth()->user()->entreprise_id ?? null, // Récupérer l'entreprise de l'utilisateur (si applicable)
            'date' => $request->date,
            'lieu' => $request->lieu,
            'commentaires' => $request->commentaires,
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'Entretien programmé avec succès !');
    }



    public function accepterCandidature($id)
    {
        $etudiant = Etudiant::findOrFail($id);
        $etudiant->update(['statut' => 'accepté']);

        return redirect()->route('admin.dashboard')->with('success', 'Candidature acceptée avec succès !');
    }

    public function rejeterCandidature($id)
    {
        $etudiant = Etudiant::findOrFail($id);
        $etudiant->update(['statut' => 'rejeté']);

        return redirect()->route('admin.dashboard')->with('success', 'Candidature rejetée.');
    }



    public function showExamen($etudiant_id)
    {
        // Trouver l'étudiant ou renvoyer une erreur
        $etudiant = Etudiant::findOrFail($etudiant_id);

        // Récupérer les entretiens "planifiés" avec leur annonce
        $entretiens_planifies = Entretien::where('status', 'planifié')->with('annonce')->get();

        // Récupérer les questions liées aux entretiens planifiés
        $questions = Question::whereIn('entretien_id', $entretiens_planifies->pluck('id'))->with('reponses')->get();

        // Assurer que les options sont bien formatées
        foreach ($questions as $question) {
            $question->options = is_string($question->options)
                ? json_decode($question->options, true) ?? []
                : ($question->reponses->pluck('texte')->toArray() ?? []);
        }

        // Récupérer le dernier examen de l'étudiant
        $examen = Examen::where('etudiant_id', $etudiant_id)->latest()->first();

        // Récupérer l'entretien lié à l'étudiant via l'annonce et les candidatures
        $entretien = Entretien::whereHas('annonce.candidatures', function ($query) use ($etudiant) {
            $query->where('etudiant_id', $etudiant->id);
        })->with('annonce')->first();

        // Sécurisation du nom du poste
        $nom_du_poste = optional($entretien?->annonce)->nom_du_poste ?? 'Non disponible';
 $duree = optional($entretien?->annonce)->duree ?? 'Non disponible';

        // Passer les résultats à la vue
        return view('etudiants.examen', [
            'etudiant' => $etudiant,
            'questions' => $questions,
            'examen' => $examen,
            'score' => $examen->score ?? 0,
            'total_questions' => $examen->total_questions ?? 0,
            'bonnes_reponses' => $examen->bonnes_reponses ?? 0,
            'nom_du_poste' => $nom_du_poste,
            'duree' => $duree,
            'entretiens_planifies' => $entretiens_planifies // Ajout de cette variable
        ]);
    }







    public function createEntretien($etudiant_id)
    {
        $etudiant = Etudiant::findOrFail($etudiant_id);
        $examen = Examen::where('etudiant_id', $etudiant->id)->first();

        $user = null;
        $entreprise = null;

        if ($examen) {
            $user = User::find($examen->user_id);
            $entreprise = Entreprise::find($examen->user_id);
        }

        return view('etudiants.entretiens', compact('etudiant', 'examen', 'user', 'entreprise'));
    }










    // Dans votre contrôleur d'examen
    public function submitExamen(Request $request)
    {
        try {
            $etudiant_id = $request->input('etudiant_id');
            if (!$etudiant_id) {
                return back()->with('error', 'Étudiant non défini.');
            }

            $reponses = collect($request->input('reponses', []));

            $questions = Question::whereIn('id', $reponses->keys())->get();
            $total_questions = $questions->count();
            $bonnes_reponses = 0;

            foreach ($questions as $question) {
                $reponse_etudiant = $reponses->get($question->id);

                if ($reponse_etudiant) {
                    // Récupérer les bonnes réponses validées
                    $reponses_valides = \App\Models\Reponse::where('question_id', $question->id)
                        ->where('valide', 1)
                        ->pluck('texte')
                        ->map(fn($val) => strtolower(trim($val)))
                        ->toArray();

                    // Vérifier les réponses
                    if (is_array($reponse_etudiant)) {
                        $reponse_etudiant = collect($reponse_etudiant)->map(fn($val) => strtolower(trim($val)))->sort()->toArray();
                        if ($reponse_etudiant === collect($reponses_valides)->sort()->toArray()) {
                            $bonnes_reponses++;
                        }
                    } else {
                        if (in_array(strtolower(trim($reponse_etudiant)), $reponses_valides)) {
                            $bonnes_reponses++;
                        }
                    }
                }
            }

            // Calcul du score sur 20
            $score_sur_20 = ($total_questions > 0) ? round(($bonnes_reponses / $total_questions) * 20, 2) : 0;

            // Sauvegarde en base de données
            $examen = Examen::create([
                'etudiant_id' => $etudiant_id,
                'score' => $score_sur_20,
                'total_questions' => $total_questions,
                'bonnes_reponses' => $bonnes_reponses,
                'reponses' => json_encode($reponses),
                'date_passage' => now(),
            ]);

            // Stocker les informations dans la session
            session(['score' => $score_sur_20]);
            session(['total_questions' => $total_questions]);
            session(['bonnes_reponses' => $bonnes_reponses]);

            // Récupérer les informations de l'étudiant
            $etudiant = Etudiant::findOrFail($etudiant_id);

            // Récupérer l'entretien lié à cet étudiant
            $entretien = \App\Models\Entretien::where('etudiant_id', $etudiant_id)
                ->with('annonce')
                ->first();

            // Passer le nom du poste à la vue
            $nomPoste = $entretien ? $entretien->annonce->nom_du_poste : 'Non spécifié';

            // Récupérer les questions pour l'examen
            $questions = Question::whereIn('id', $reponses->keys())
                ->with('reponses')
                ->get();

            // Assurer que les options sont bien formatées
            foreach ($questions as $question) {
                $question->options = is_string($question->options)
                    ? json_decode($question->options, true) ?? []
                    : ($question->reponses->pluck('texte')->toArray() ?? []);
            }

            return view('etudiants.examen', [
                'etudiant' => $etudiant,
                'questions' => $questions,
                'score' => $score_sur_20,
                'total_questions' => $total_questions,
                'bonnes_reponses' => $bonnes_reponses,
                'pourcentage' => round(($bonnes_reponses / max($total_questions, 1)) * 100, 2),
                'examen' => $examen,
            ]);
        } catch (\Exception $e) {
            \Log::error("Erreur lors de l'enregistrement de l'examen : " . $e->getMessage());
            return back()->with('error', 'Une erreur est survenue lors de la soumission de l\'examen.');
        }
    }
}
