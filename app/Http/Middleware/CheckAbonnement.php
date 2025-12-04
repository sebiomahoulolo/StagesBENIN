<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckAbonnement
{
    public function handle(Request $request, Closure $next)
    {
        $etudiant = Auth::user()->etudiant;
        if (!$etudiant) {
            return redirect()->route('login')->with('error', 'Veuillez vous connecter.');
        }

        // Autoriser uniquement les étudiants ayant un paiement approuvé (abonnement actif)
        if ($etudiant->abonnementActif()) {
            return $next($request);
        }

        // Sinon, accès bloqué : redirige vers la page de choix de formule
        return redirect()->route('paiement.choix', [
            'etudiant' => $etudiant->id,
        ])->with('error', 'Veuillez choisir une formule et valider le paiement pour accéder à votre espace.');
    }
}
