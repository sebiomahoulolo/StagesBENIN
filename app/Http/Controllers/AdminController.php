<?php

namespace App\Http\Controllers;

use App\Models\Actualite;
use App\Models\Event;
use App\Models\CvProfile;
use App\Models\Catalogue;
use App\Models\Recrutement;
use App\Models\Entreprise;
use App\Models\Entretien;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Etudiant;
use Illuminate\Support\Facades\Log;
use App\Models\Cvtheque;
class AdminController extends Controller
{
   


    public function index()
    {
   
        $etudiants = Etudiant::paginate(10);
        $actualites = Actualite::paginate(10);
        $events = Event::paginate(10);
        $catalogues = Catalogue::paginate(10);
    $catalogueItems = Catalogue::all(); 


      
        $totalEtudiants = Etudiant::count();
        $progression = "N/A"; 

        return view('admin.dashboard', compact(
            'etudiants',
            'actualites',
            'events',
            'catalogueItems',
            'totalEtudiants',
            'progression'
        ));
    }
 

    public function cvtheque()
    {
        try {
            // Récupère tous les profils CV avec leurs relations associées (ex. étudiant)
            $cvProfiles = CvProfile::with('etudiant')->get();
    
            if ($cvProfiles->isEmpty()) {
                Log::warning("Aucun CV trouvé dans la base de données.");
                return redirect()->back()->with('warning', 'Aucun CV disponible actuellement.');
            }
    
            Log::info("Affichage de tous les CV pour l'admin : " . $cvProfiles->count() . " CV(s) récupéré(s).");
    
            // Vérifie si la vue existe avant de la retourner
            if (!view()->exists('admin.cvtheque.cvtheque')) {
                Log::error("La vue 'admin.cvtheque.cvtheque' est introuvable.");
                abort(500, "Erreur de configuration de l'affichage de la CVthèque.");
            }
    
            // Retourne la vue avec les profils CV
            return view('admin.cvtheque.cvtheque', compact('cvProfiles'));
    
        } catch (\Exception $e) {
            Log::error("Erreur lors de l'affichage de la CVthèque : " . $e->getMessage(), [
                'exception' => $e,
            ]);
    
            // Redirige l'administrateur avec un message d'erreur
            return redirect()->back()->with('error', 'Une erreur est survenue lors de l\'affichage des CV : ' . $e->getMessage());
        }
    }
    
    public function etudiants()
    {
        // Récupérer les étudiants depuis la base de données
        $etudiants = Etudiant::paginate(10);

        // Retourner la vue avec les étudiants
        return view('admin.etudiants.etudiants', compact('etudiants'));
    }

    public function actualites()
    {
        // Récupérer les étudiants depuis la base de données
        $actualites = Actualite::paginate(10);

        // Retourner la vue avec les étudiants
        return view('admin.actualites', compact('actualites'));
    }
    public function entretiens()
    {
        // Récupérer les étudiants depuis la base de données
        $entretiens = Entretien::paginate(10);

        // Retourner la vue avec les étudiants
        return view('admin.entretiens', compact('entretiens'));
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

        return redirect()->route('evenements.index')->with('success', 'Événement supprimé avec succès.');
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
}
