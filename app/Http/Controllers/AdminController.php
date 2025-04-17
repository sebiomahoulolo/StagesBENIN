<?php

namespace App\Http\Controllers;

use App\Models\Actualite;
use App\Models\Event;
use App\Models\Catalogue;
use Illuminate\Http\Request;
use App\Models\Etudiant;
class AdminController extends Controller
{
   


    public function index()
    {
        // Récupération des données avec pagination
        $etudiants = Etudiant::paginate(10);
        $actualites = Actualite::paginate(10);
        $events = Event::paginate(10);
        $catalogues = Catalogue::paginate(10);

        // Statistiques globales
        $totalEtudiants = Etudiant::count();
        $progression = "N/A"; // À remplacer par une vraie logique si disponible

        return view('admin.dashboard', compact(
            'etudiants',
            'actualites',
            'events',
            'catalogues',
            'totalEtudiants',
            'progression'
        ));
    }
 



    public function manageUsers()
    {
        // Gérer les utilisateurs
        return view('admin.manage_users');
    }
}
