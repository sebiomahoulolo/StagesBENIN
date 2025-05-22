<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Etudiant; // Importer Etudiant
use App\Models\Entreprise; // Importer Entreprise
// use App\Providers\RouteServiceProvider; // On gèrera la redirection manuellement
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB; // Pour les transactions
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Affiche la vue d'inscription pour ETUDIANT.
     */
    public function createEtudiant(): View
    {
        $specialites = \App\Models\Specialite::with('secteur')->get();
        return view('auth.register-etudiant', compact('specialites'));
    }

    /**
     * Gère une requête d'inscription pour ETUDIANT.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function storeEtudiant(Request $request): RedirectResponse
    {
        $request->validate([
            'nom' => ['required', 'string', 'max:100'],
            'prenom' => ['required', 'string', 'max:100'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'telephone' => ['required', 'string', 'min:8', 'max:15'],
            'formation' => ['required', 'string', 'max:100'],
            'niveau' => ['required', 'string', 'max:100'],
        ]);

        $user = User::create([
            'name' => $request->nom . ' ' . $request->prenom,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => User::ROLE_ETUDIANT,
        ]);

        $etudiant = Etudiant::create([
            'user_id' => $user->id,
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'email' => $request->email,
            'telephone' => $request->telephone,
            'formation' => $request->formation,
            'niveau' => $request->niveau,
        ]);

        // Créer le profil CV pour l'étudiant
        $cvProfile = $etudiant->cvProfile()->create([]);

        event(new Registered($user));

        Auth::login($user);

        // Rediriger vers l'édition du CV avec un message d'avertissement
        return redirect()->route('etudiants.cv.edit')->with('warning', 'Bienvenue ! Pour continuer, veuillez compléter votre CV. Cette étape est importante pour augmenter vos chances de décrocher un stage.');
    }

    /**
     * Affiche la vue d'inscription pour RECRUTEUR (Entreprise).
     */
    public function createRecruteur(): View
    {
        return view('auth.register-recruteur');
    }

    /**
     * Gère une requête d'inscription pour RECRUTEUR.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function storeRecruteur(Request $request): RedirectResponse
    {
        $request->validate([
            'nom_entreprise' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'telephone' => ['required', 'string', 'min:8', 'max:15'],
        ]);

        $user = User::create([
            'name' => $request->nom_entreprise, // Ajout du champ name
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => User::ROLE_RECRUTEUR,
        ]);

        $entreprise = Entreprise::create([
            'user_id' => $user->id,
            'nom' => $request->nom_entreprise,
            'email' => $request->email,
            'telephone' => $request->telephone,
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect()->route('profile.setup.recruteur');
    }

    // La méthode create originale de Breeze n'est plus utilisée directement
    // pour l'inscription, mais gardez-la si Breeze l'utilise ailleurs.
    // public function create(): View { return view('auth.register'); }

    // La méthode store originale n'est plus utilisée directement
    // public function store(Request $request): RedirectResponse { ... }
}