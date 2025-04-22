<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
// use App\Providers\RouteServiceProvider; // Gérer redirection manuellement
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Models\User; // Importer User pour les constantes de rôle

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate(); // Gère l'authentification (Auth::attempt)

        $request->session()->regenerate();

        // === REDIRECTION BASÉE SUR LE RÔLE ===
        $user = Auth::user();

        if ($user->isAdmin()) {
            // Rediriger vers le dashboard Admin
            return redirect()->intended(route('admin.dashboard', [], false)); // Route nommée du dashboard admin
        } elseif ($user->isEtudiant()) {
            // Rediriger vers le dashboard Etudiant
            return redirect()->intended(route('etudiants.dashboard', [], false)); // Route nommée du dashboard étudiant
        } elseif ($user->isRecruteur()) {
             // Rediriger vers le dashboard Recruteur
             return redirect()->intended(route('recruteur.dashboard', [], false)); // Route nommée du dashboard recruteur
        } else {
            // Redirection par défaut si aucun rôle connu (ou fallback)
            // return redirect()->intended(RouteServiceProvider::HOME);
             return redirect()->intended(route('dashboard', [], false)); // Route nommée générique 'dashboard' fournie par Breeze
        }
        // Le `intended()` essaie de rediriger vers la page précédente demandée avant login,
        // sinon il utilise la route fournie en argument.
        // Le `false` évite la redirection absolue si vous avez des domaines différents.
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/'); // Rediriger vers l'accueil après déconnexion
    }
}