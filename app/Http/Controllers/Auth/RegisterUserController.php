<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Secteur;
use App\Models\Specialite;
use Illuminate\Http\Request;

class RegisterUserController extends Controller
{
    public function getSpecialites(Request $request)
    {
        $secteurId = $request->input('secteur_id');
        
        if (!$secteurId) {
            return response()->json(['error' => 'ID du secteur requis'], 400);
        }

        $specialites = Specialite::where('secteur_id', $secteurId)
            ->select('id', 'nom')
            ->get();

        return response()->json($specialites);
    }
} 