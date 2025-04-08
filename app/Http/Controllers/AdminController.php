<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        // Afficher le tableau de bord des administrateurs
        return view('admin.dashboard');
    }

    public function manageUsers()
    {
        // Gérer les utilisateurs
        return view('admin.manage_users');
    }
}
