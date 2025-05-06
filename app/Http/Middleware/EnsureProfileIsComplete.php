<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureProfileIsComplete
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();
        
        if ($user->isEtudiant()) {
            $etudiant = $user->etudiant;
            if (empty($etudiant->formation) || empty($etudiant->niveau) || empty($etudiant->specialite_id)) {
                return redirect()->route('profile.setup.etudiant');
            }
        } elseif ($user->isRecruteur()) {
            $entreprise = $user->entreprise;
            if (empty($entreprise->secteur) || empty($entreprise->description)) {
                return redirect()->route('profile.setup.recruteur');
            }
        }

        return $next($request);
    }
}
