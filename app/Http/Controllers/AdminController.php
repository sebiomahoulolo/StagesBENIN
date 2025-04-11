<?php

namespace App\Http\Controllers;
use App\Models\Event;
use Illuminate\Http\Request;
use App\Models\Etudiant;
class AdminController extends Controller
{
   

public function index()
{

    
        $etudiants = Etudiant::all(); // Récupérer tous les étudiants
      
    
    $events = Event::all(); // ou avec pagination : Evenement::paginate(10);
    $totalEtudiants = \App\Models\Etudiant::count();
    $progression = "N/A"; // ou une vraie logique de progression si tu en as une

    return view('admin.dashboard', compact('events', 'totalEtudiants', 'progression','etudiants'));
}


    public function manageUsers()
    {
        // Gérer les utilisateurs
        return view('admin.manage_users');
    }
}
