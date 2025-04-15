<?php

namespace App\Http\Controllers;

use App\Models\Actualite;
use App\Models\Event;
use Illuminate\Http\Request;
use App\Models\Etudiant;
class AdminController extends Controller
{
   


    public function index()
    {
        $etudiants = Etudiant::paginate(10); // Pagination des étudiants
        $actualites = Actualite::paginate(10); // Pagination des actualités
        $events = Event::paginate(10); // Pagination des événements
        $totalEtudiants = Etudiant::count();
        $progression = "N/A"; // Placeholder pour la progression, modifiez si nécessaire
    
        return view('admin.dashboard', compact('events', 'totalEtudiants', 'progression', 'etudiants', 'actualites'));
    }
    


    public function manageUsers()
    {
        // Gérer les utilisateurs
        return view('admin.manage_users');
    }
}
