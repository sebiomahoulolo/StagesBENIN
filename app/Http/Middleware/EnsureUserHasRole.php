<?php

// 1. Vérifiez que le namespace est correct
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth; // Importer la façade Auth

// 2. Vérifiez que le nom de la classe est correct
class EnsureUserHasRole
{
    /**
     * Gère une requête entrante.
     *
     * @param  \Illuminate\Http\Request  $request La requête HTTP entrante.
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next Le prochain middleware dans la pile.
     * @param  string $role Le rôle requis (passé depuis la définition de la route, ex: 'admin', 'etudiant').
     * @return \Symfony\Component\HttpFoundation\Response La réponse HTTP.
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // 3. Vérifier si l'utilisateur est connecté
        // Utiliser Auth::guard('web')->check() est légèrement plus explicite pour le guard web par défaut
        if (!Auth::guard('web')->check()) {
            // Si non connecté, rediriger vers la page de connexion
            return redirect()->route('login');
        }

        // 4. Récupérer l'utilisateur connecté
        $user = Auth::guard('web')->user();

        // 5. Vérifier si l'utilisateur a une propriété 'role' et si elle correspond au rôle requis
        //    (Assurez-vous que votre modèle User a bien une colonne/attribut 'role')
        if (!$user->role || $user->role !== $role) {
            // Si l'utilisateur n'a pas le bon rôle :

            // Option A : Retourner une erreur 403 (Accès Interdit)
            // abort(403, 'Accès non autorisé à cette section.');

            // Option B : Rediriger vers une page spécifique (par exemple, le dashboard par défaut ou l'accueil)
            // avec un message d'erreur pour l'utilisateur.
             return redirect()->route('dashboard') // Ou route('home') pour l'accueil
                      ->with('error', 'Vous n\'avez pas les permissions nécessaires pour accéder à cette page.');

            // Option C : Rediriger vers la page de connexion (moins informatif)
            // return redirect()->route('login')->with('error', 'Accès non autorisé.');
        }

        // 6. Si l'utilisateur est connecté ET a le bon rôle, laisser la requête continuer
        return $next($request);
    }
}