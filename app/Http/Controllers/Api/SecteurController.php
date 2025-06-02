<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Secteur;
use Illuminate\Http\Request;

class SecteurController extends Controller
{
    public function getSpecialites(Secteur $secteur)
    {
        $specialites = $secteur->specialites()->select('id', 'nom')->get();
        return response()->json($specialites);
    }
}
