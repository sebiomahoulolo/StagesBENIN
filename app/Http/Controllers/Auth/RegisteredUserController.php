<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Etudiant; // Importer Etudiant
use App\Models\Entreprise; // Importer Entreprise
use App\Models\Secteur;
use App\Models\Specialite;
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
        $secteurs = Secteur::all();
        $specialites = \App\Models\Specialite::with('secteur')->get();
        return view('auth.register-etudiant', compact('specialites', 'secteurs'));
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
            'specialite_id' => ['required', 'string', 'max:100'],
            'niveau' => ['required', 'string', 'max:100'],
            'formule' => ['required', 'string'],
        ]);

        $user = User::create([
            'name' => $request->nom . ' ' . $request->prenom,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => User::ROLE_ETUDIANT,
        ]);

        try {
            $etudiant = Etudiant::create([
                'user_id' => $user->id,
                'nom' => $request->nom,
                'prenom' => $request->prenom,
                'email' => $request->email,
                'telephone' => $request->telephone,
                'formation' => $request->specialite_id,
                'niveau' => $request->niveau,
            ]);
            \Log::info('Etudiant créé', ['etudiant' => $etudiant]);
        } catch (\Exception $e) {
            \Log::error('Erreur création étudiant', ['message' => $e->getMessage()]);
            throw $e;
        }

        // Créer le profil CV pour l'étudiant
        $cvProfile = $etudiant->cvProfile()->create([]);

        event(new Registered($user));

        // Marquer la session comme venant de l'inscription
        session(['just_registered' => true]);

        // Rediriger vers la page de récapitulatif de paiement (GET)
        return redirect()->route('paiement.form', [
            'etudiant' => $etudiant->id,
            'formule' => $request->formule,
        ]);
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