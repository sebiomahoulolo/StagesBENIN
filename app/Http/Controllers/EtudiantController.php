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
use App\Models\User;
class EtudiantController extends Controller
{
    public function etudiant()
{
    return $this->hasOne(Etudiant::class, 'user_id');
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

        // Récupérer les entretiens programmés pour l'utilisateur
        $entretiens = Entretien::where('user_id', $userId)
            ->where('date', '>=', now()) // Filtrer les entretiens futurs
            ->orderBy('date', 'asc')    // Trier par date croissante
            ->get();

        // Retourner les entretiens à la vue
        return view('etudiants.dashboard', compact('entretiens','etudiant'));
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
    $etudiant = Etudiant::findOrFail($etudiant_id);
    $questions = Question::all();
    

    // Convertir chaque `options` en tableau PHP
    foreach ($questions as $question) {
        $question->options = json_decode($question->options, true); // Décoder JSON
    }
    
    return view('etudiants.examen', compact('etudiant','questions'));
    

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








public function submitExamen(Request $request, $etudiant_id)
{
    $etudiant = Etudiant::findOrFail($etudiant_id);
    $questions = Question::all();
    $score = 0;

    // Parcourir les questions pour enregistrer les réponses et calculer le score
    foreach ($questions as $question) {
        $reponseChoisie = $request->reponses[$question->id] ?? null;
    
        if ($reponseChoisie) {
          
            $options = json_decode($question->options, true); // decode JSON → tableau associatif
            $choixIndex = array_search($reponseChoisie, $options);
            
            // Vérifie que l'index existe
            if ($choixIndex !== false) {
                // Enregistrer dans la table `reponses`
                Reponse::create([
                    'etudiant_id' => $etudiant->id,
                    'question_id' => $question->id,
                    'choix_index' => $choixIndex,
                ]);
    
                // Vérifier si la réponse est correcte
                if ($question->bonne_reponse_id == $choixIndex) {
                    $score++;
                }
            }
        }
    }
    

    // Enregistrer le score dans la table `examens`
    Examen::create([
        'etudiant_id' => $etudiant->id,
        'score' => $score,
        'total_questions' => count($questions),
    ]);

    // Envoyer la note à l'entreprise associée
    $entretien = Entretien::where('etudiant_id', $etudiant->id)->first();
    if ($entretien) {
        $user_id = $entretien->user_id;
       
    }

  
    return redirect()->route('admin.dashboard')->with('success', 'Test terminé. Score : ' . $score);
}






}
