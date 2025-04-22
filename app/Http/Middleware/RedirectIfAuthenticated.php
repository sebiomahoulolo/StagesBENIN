<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @param  string|null  ...$guards
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                $user = Auth::guard($guard)->user();
            
                if ($user->isAdmin()) {
                    // Rediriger vers le dashboard Admin
                    return redirect()->intended(route('admin.dashboard', [], false));
                } elseif ($user->isEtudiant()) {
                    // Rediriger vers le dashboard Etudiant
                    return redirect()->intended(route('etudiants.dashboard', [], false));
                } elseif ($user->isRecruteur()) {
                    // Rediriger vers le dashboard Recruteur
                    return redirect()->intended(route('entreprises.dashboard', [], false));
                } else {
                    // Redirection par défaut si aucun rôle connu (ou fallback)
                    return redirect()->intended(route('dashboard', [], false));
                }
            }
            
            
        }

        return $next($request);
    }
}
