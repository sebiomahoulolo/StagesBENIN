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
 



    public function manageUsers()
    {
        // Gérer les utilisateurs
        return view('admin.manage_users');
    }
}
