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
        return view('auth.register-etudiant');
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
            // Ajoutez ici les validations pour les champs spécifiques étudiants (si présents sur le form)
            'telephone' => ['nullable', 'string', 'max:20'],
            'formation' => ['nullable', 'string', 'max:255'],
            'niveau' => ['nullable', 'string', 'max:50'],
            'date_naissance' => ['nullable', 'date'],
        ]);

        DB::beginTransaction();
        try {
            // Créer l'utilisateur
            $user = User::create([
                'name' => $request->prenom . ' ' . $request->nom, // Concaténer nom/prénom
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => User::ROLE_ETUDIANT, // Rôle Etudiant
            ]);

            // Créer le profil étudiant associé
            $etudiant = Etudiant::create([
                'user_id' => $user->id,
                'nom' => $request->nom,
                'prenom' => $request->prenom,
                'email' => $request->email, // Redondant mais ok pour l'instant
                'telephone' => $request->telephone,
                'formation' => $request->formation,
                'niveau' => $request->niveau,
                'date_naissance' => $request->date_naissance,
                // Initialiser photo/cv path à null ou gérer l'upload ici si besoin
            ]);

            DB::commit();

            event(new Registered($user));

            Auth::login($user);

            // Rediriger vers le dashboard étudiant
            return redirect()->route('etudiant.dashboard'); // Assurez-vous que cette route existe

        } catch (\Exception $e) {
            DB::rollBack();
            // Log::error("Erreur inscription étudiant: " . $e->getMessage());
            return redirect()->back()
                     ->withInput()
                     ->with('error', "Une erreur est survenue lors de l'inscription. Veuillez réessayer.");
        }
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
            // User fields
            'name' => ['required', 'string', 'max:255'], // Nom du contact recruteur
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            // Entreprise fields
            'nom_entreprise' => ['required', 'string', 'max:255'],
            'email_entreprise' => ['required', 'string', 'email', 'max:255', /* 'unique:'.Entreprise::class.',email' si email entreprise doit être unique */],
            'telephone_entreprise' => ['nullable', 'string', 'max:20'],
            'secteur' => ['nullable', 'string', 'max:255'],
            'adresse' => ['nullable', 'string'],
        ]);

        DB::beginTransaction();
        try {
             // Créer l'utilisateur
             $user = User::create([
                 'name' => $request->name, // Nom du contact
                 'email' => $request->email, // Email de connexion
                 'password' => Hash::make($request->password),
                 'role' => User::ROLE_RECRUTEUR, // Rôle Recruteur
             ]);

             // Créer le profil entreprise associé
             $entreprise = Entreprise::create([
                 'user_id' => $user->id,
                 'nom' => $request->nom_entreprise,
                 'secteur' => $request->secteur,
                 'adresse' => $request->adresse,
                 'email' => $request->email_entreprise, // Email public de l'entreprise
                 'telephone' => $request->telephone_entreprise,
                 'contact_principal' => $request->name, // Utiliser le nom du contact user par défaut
                 // Initialiser description, site_web, logo à null
             ]);

             DB::commit();

             event(new Registered($user));

             Auth::login($user);

             // Rediriger vers le dashboard recruteur
             return redirect()->route('recruteur.dashboard'); // Assurez-vous que cette route existe

         } catch (\Exception $e) {
             DB::rollBack();
             // Log::error("Erreur inscription recruteur: " . $e->getMessage());
             return redirect()->back()
                      ->withInput()
                      ->with('error', "Une erreur est survenue lors de l'inscription. Veuillez réessayer.");
         }
    }

    // La méthode create originale de Breeze n'est plus utilisée directement
    // pour l'inscription, mais gardez-la si Breeze l'utilise ailleurs.
    // public function create(): View { return view('auth.register'); }

    // La méthode store originale n'est plus utilisée directement
    // public function store(Request $request): RedirectResponse { ... }
}