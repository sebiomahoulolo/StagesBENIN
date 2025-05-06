<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use App\Models\User;
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

                // Si l'utilisateur essaie d'accéder aux pages de configuration initiale du profil, on le laisse passer
                if ($request->routeIs('profile.setup.*')) {
                    return $next($request);
                }
            
                if ($user->role === User::ROLE_ADMIN) {
                    return redirect()->intended(route('admin.dashboard', [], false));
                } elseif ($user->role === User::ROLE_ETUDIANT) {
                    return redirect()->intended(route('etudiants.dashboard', [], false));
                } elseif ($user->role === User::ROLE_RECRUTEUR) {
                    return redirect()->intended(route('entreprises.dashboard', [], false));
                } else {
                    return redirect()->intended(route('dashboard', [], false));
                }
            }
        }

        return $next($request);
    }
}
