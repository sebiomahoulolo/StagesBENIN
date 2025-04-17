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
            'nom' => ['required', 'string', 'max:100'], // Re-added
            'prenom' => ['required', 'string', 'max:100'], // Re-added
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            // Validation for other fields removed previously
        ]);

        DB::beginTransaction();
        try {
            // Removed username generation from email
            // $emailParts = explode('@', $request->email);
            // $userName = $emailParts[0];

            // Créer l'utilisateur
            $user = User::create([
                'name' => $request->prenom . ' ' . $request->nom, // Use nom + prenom
                // 'name' => $userName,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => User::ROLE_ETUDIANT, // Rôle Etudiant
            ]);

            // Re-create the associated Etudiant profile with minimal info
            $etudiant = Etudiant::create([
                'user_id' => $user->id,
                'nom' => $request->nom,
                'prenom' => $request->prenom,
                'email' => $request->email,
                // Other fields will be null by default (ensure they are nullable in migration)
            ]);

            DB::commit();

            event(new Registered($user));

            Auth::login($user);

            // Rediriger vers le dashboard étudiant
            return redirect()->route('etudiant.dashboard'); // Assurez-vous que cette route existe

        } catch (\Exception $e) {
            DB::rollBack();
            // Log::error("Erreur inscription étudiant: " . $e->getMessage());
            // Flash all inputs now
            return redirect()->back()
                     // ->withInput($request->only('email')) // Flash all inputs
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
            // Add validation for nom_entreprise
            'nom_entreprise' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            // nom_entreprise n'est plus validé ici
        ]);

        DB::beginTransaction();
        try {
            // Keep username generation from email for User model
            $emailParts = explode('@', $request->email);
            $userName = $emailParts[0];

            // Créer l'utilisateur
            $user = User::create([
                'name' => $userName, // Utilise la partie locale de l'email
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => User::ROLE_RECRUTEUR,
            ]);

            // Create the associated Entreprise profile with minimal info
            $entreprise = Entreprise::create([
                'user_id' => $user->id,
                'nom' => $request->nom_entreprise, // Use submitted name
                'email' => $request->email,
                // Other fields will be null (ensure nullable in migration)
            ]);

            DB::commit();

            event(new Registered($user));

            Auth::login($user);

            // Rediriger vers le dashboard recruteur avec le bon nom de route
            return redirect()->route('entreprises.dashboard');

         } catch (\Exception $e) {
             DB::rollBack();
             // Log::error("Erreur inscription recruteur: " . $e->getMessage());
             // Renvoyer un message d'erreur plus générique si le nom d'entreprise était la cause
             return redirect()->back()
                      ->withInput() // Flash all inputs
                      ->with('error', "Une erreur est survenue l'inscription. Veuillez réessayer.");
         }
    }

    // La méthode create originale de Breeze n'est plus utilisée directement
    // pour l'inscription, mais gardez-la si Breeze l'utilise ailleurs.
    // public function create(): View { return view('auth.register'); }

    // La méthode store originale n'est plus utilisée directement
    // public function store(Request $request): RedirectResponse { ... }
}