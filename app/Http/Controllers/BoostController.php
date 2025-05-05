<?php

namespace App\Http\Controllers;

// Modèles requis
use App\Models\Tier;
use App\Models\User; // Assurez-vous que le chemin est correct pour votre modèle User

// Façades et classes Utiles
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
// Carbon n'est pas utilisé directement ici mais peut être utilisé par l'accesseur dans le modèle Tier
// use Carbon\Carbon;

class BoostController extends Controller
{
    /**
     * Applique les middlewares d'authentification et de rôle au contrôleur.
     */
    public function __construct()
    {
        // Assure que l'utilisateur est connecté pour toutes les méthodes de ce contrôleur
        $this->middleware('auth');
        // Assure que l'utilisateur a le rôle 'etudiant'
        // Assurez-vous que ce rôle est correctement défini et attribué aux utilisateurs.
        $this->middleware('role:etudiant');
    }

    /**
     * Affiche le statut du boost de l'étudiant basé sur son dernier enregistrement Tier.
     */
    public function status()
    {
        $userId = Auth::id();
        if (!$userId) {
            // Ce cas ne devrait pas se produire grâce au middleware 'auth', mais c'est une sécurité supplémentaire.
            Log::warning("BoostController@status: Tentative d'accès sans Auth::id() valide, malgré le middleware.");
            abort(403, 'Utilisateur non authentifié.');
        }

        $tierToShow = null; // Le Tier à afficher, initialisé à null.

        // 1. Récupère le DERNIER enregistrement Tier (tentative de boost) créé pour cet utilisateur.
        $latestTierAttempt = Tier::where('user_id', $userId)
                              ->latest('created_at') // Trie par date de création, le plus récent en premier.
                              ->first(); // Prend seulement le premier (le plus récent).

        // 2. Vérifie si un enregistrement Tier a été trouvé pour cet utilisateur.
        if ($latestTierAttempt) {
            $status = $latestTierAttempt->payment_status;

            // 3. Vérifie le statut de paiement de cette dernière tentative.
            if ($status === 'paid') {
                // Si le paiement a réussi ('paid'), on prépare les informations du boost actif.
                try {
                    // Utilise l'accesseur `calculated_expires_at` du modèle Tier pour obtenir la date d'expiration.
                    // Assurez-vous que cet accesseur est défini et fonctionne correctement dans votre modèle Tier.
                    // Exemple d'accesseur dans Tier.php :
                    // public function getCalculatedExpiresAtAttribute() {
                    //     if ($this->payment_date && $this->duration && $this->duration_unit) {
                    //         return Carbon::parse($this->payment_date)->add($this->duration, $this->duration_unit);
                    //     }
                    //     return null;
                    // }
                    $expirationDate = $latestTierAttempt->calculated_expires_at;
                    // Ajoute la propriété 'expires_at' à l'objet Tier pour la vue et le JavaScript.
                    $latestTierAttempt->expires_at = $expirationDate;
                } catch (\Exception $e) {
                    Log::error("BoostController@status: Erreur lors de l'accès à calculated_expires_at pour Tier ID: {$latestTierAttempt->id}. User ID: {$userId}. Erreur: " . $e->getMessage());
                    // Si l'accesseur échoue, expires_at ne sera pas défini, ce qui doit être géré dans la vue/JS.
                    // Optionnellement, vous pourriez définir $latestTierAttempt->expires_at = null; ici.
                }
                $tierToShow = $latestTierAttempt;

            } elseif ($status === 'failed') {
                // Si le paiement a échoué ('failed'), on affiche les informations de cet échec.
                $tierToShow = $latestTierAttempt;
            }
            // Si le statut est autre que 'paid' ou 'failed' (ex: 'pending', null, chaîne vide),
            // $tierToShow reste null. La vue affichera alors le message "Aucun Boost Actif".
            // Ceci est crucial : si votre système de paiement ne met PAS À JOUR le statut à 'paid' ou 'failed'
            // après une transaction, l'utilisateur ne verra jamais son boost comme actif ou échoué.
        }
        // Si aucun enregistrement Tier n'a été trouvé pour l'utilisateur, $tierToShow reste null.

        // Ligne de débogage (à décommenter temporairement si nécessaire) :
        // Cela vous montrera exactement ce qui est passé à la vue.
        // Vérifiez la valeur de $tierToShow et de $tierToShow->payment_status si $tierToShow n'est pas null.
        // dd($tierToShow);

        // 5. Retourne la vue 'etudiants.boost-status' en lui passant le Tier (ou null).
        // La vue Blade utilisera la variable `$tier` pour ses conditions.
        return view('etudiants.boost-status', ['tier' => $tierToShow]);
    }

    /**
     * Affiche la page où l'étudiant peut choisir un nouveau plan de boost.
     */
    public function selectTier()
    {   $userId = Auth::id();
        $latestPaidTier = null;
         // Récupère les Tiers disponibles à l'achat.
         $availableTiers = Tier::where('is_purchasable', true)
                              ->whereNotNull('title') // Optionnel : s'assurer que les tiers ont un titre
                              ->whereNotNull('price') // Optionnel : s'assurer que les tiers ont un prix
                              ->orderBy('price')      // Trie par prix croissant
                              ->get();

         // Assurez-vous que la vue 'etudiants.boost-select' existe dans resources/views/etudiants/.
         return view('etudiants.boost-select', compact('availableTiers'));
    }

    /**
     * Gère la demande de renouvellement d'un boost existant.
     * Requiert le modèle Tier via Route Model Binding ({tier} dans la définition de la route).
     */
    public function renew(Tier $tier)
    {
        // Vérification de sécurité : l'utilisateur connecté peut-il renouveler ce Tier ?
        if ($tier->user_id !== Auth::id()) {
            Log::warning("BoostController@renew: Tentative de renouvellement non autorisé. Tier ID: {$tier->id}, User ID: " . Auth::id() . ", Propriétaire du Tier: {$tier->user_id}");
            return redirect()->route('etudiants.boostage.status')->with('error', 'Accès non autorisé à cette action.');
        }

        Log::info("Demande de renouvellement pour Tier ID: {$tier->id} par User ID: " . Auth::id());

        // Redirige vers la page de sélection des boosts pour que l'utilisateur choisisse à nouveau
        // le plan et procède au paiement. C'est une approche simple pour le renouvellement.
        // Une autre approche pourrait être de rediriger directement vers une page de paiement
        // pré-remplie avec les informations de ce Tier.
        return redirect()->route('etudiants.boostage.select')
                         ->with('info', "Pour renouveler votre boost '{$tier->title}', veuillez le sélectionner à nouveau dans la liste ci-dessous et procéder au paiement.");
    }

    /**
     * Affiche la page permettant de choisir un plan de boost supérieur (mise à niveau).
     * Requiert le modèle Tier via Route Model Binding ({tier} dans la définition de la route).
     */
    public function upgrade(Tier $tier)
    {
        // Vérification de sécurité : l'utilisateur connecté peut-il mettre à niveau ce Tier ?
        if ($tier->user_id !== Auth::id()) {
            Log::warning("BoostController@upgrade: Tentative de mise à niveau non autorisée. Tier ID: {$tier->id}, User ID: " . Auth::id() . ", Propriétaire du Tier: {$tier->user_id}");
            return redirect()->route('etudiants.boostage.status')->with('error', 'Accès non autorisé à cette action.');
        }

        // Récupère les plans supérieurs au plan actuel de l'utilisateur.
        $higherPlans = $this->getHigherPlans($tier->price);

        // S'il n'y a pas de plans supérieurs, ou si la collection est vide.
        if ($higherPlans->isEmpty()) {
            return redirect()->route('etudiants.boostage.status')->with('info', 'Vous disposez déjà du niveau de boost le plus élevé ou aucun niveau supérieur n\'est actuellement disponible.');
        }

        // Assurez-vous que la vue 'etudiants.boost-upgrade' existe dans resources/views/etudiants/.
        return view('etudiants.boost-upgrade', compact('tier', 'higherPlans'));
    }

    /*
     * NOTE IMPORTANTE SUR LES MÉTHODES CI-DESSOUS:
     * Les méthodes processRenewal et processUpgrade sont des SIMULATIONS.
     * Dans une application réelle avec une passerelle de paiement externe (Stripe, PayPal, etc.),
     * vous auriez typiquement :
     * 1. Une redirection vers la passerelle de paiement.
     * 2. Des routes de callback (webhook ou redirection utilisateur) que la passerelle appelle
     *    pour indiquer le succès ou l'échec du paiement.
     * 3. Ces routes de callback appelleraient des méthodes dans votre contrôleur (ou un service dédié)
     *    pour mettre à jour le `payment_status` du Tier, enregistrer la date de paiement, etc.
     *
     * Conservez ces méthodes si votre processus de paiement est géré directement dans votre application
     * sans redirection externe majeure, ou comme placeholders pour une logique future.
     */

    /**
     * SIMULATION: Traite une demande de renouvellement directement (si pas de callback externe).
     * Cette méthode serait appelée APRÈS une confirmation de paiement (par exemple).
     */
    public function processRenewal(Request $request, Tier $tier)
    {
        // Vérification de sécurité
        if ($tier->user_id !== Auth::id()) {
            abort(403, 'Action non autorisée.');
        }

        // Logique métier pour le renouvellement :
        // - Vérifier si le paiement a été effectué (si c'est une étape séparée).
        // - Créer un NOUVEAU Tier basé sur l'ancien, ou mettre à jour l'ancien (selon votre logique).
        //   Si vous créez un nouveau Tier, assurez-vous que son `payment_status` est 'paid'.
        //   Si vous mettez à jour l'ancien, mettez à jour `payment_date`, `payment_status`, et recalculez l'expiration.
        //
        // Exemple SIMULÉ : on suppose que le paiement est OK et on met à jour l'existant.
        // $tier->payment_status = 'paid';
        // $tier->payment_date = now();
        // // Potentiellement recalculer/mettre à jour d'autres champs...
        // $tier->save();

        Log::info("SIMULATION: Renouvellement traité pour Tier ID: {$tier->id}. User ID: " . Auth::id());

        return redirect()->route('etudiants.boostage.status')->with('success', 'Votre boost a été renouvelé avec succès (Simulation).');
    }

    /**
     * SIMULATION: Traite une demande de mise à niveau directement (si pas de callback externe).
     * Cette méthode serait appelée APRÈS une confirmation de paiement pour le nouveau Tier.
     */
    public function processUpgrade(Request $request, Tier $tier)
    {
        // Vérification de sécurité
        if ($tier->user_id !== Auth::id()) {
            abort(403, 'Action non autorisée.');
        }

        $newTierId = $request->input('new_tier_id'); // ID du nouveau plan choisi
        $newTierDetails = Tier::find($newTierId);

        if (!$newTierDetails || !$newTierDetails->is_purchasable || $newTierDetails->price <= $tier->price) {
            return redirect()->back()->with('error', 'Le plan de mise à niveau sélectionné n\'est pas valide.');
        }

        // Logique métier pour la mise à niveau :
        // - Vérifier le paiement pour la différence de prix ou le nouveau prix total.
        // - Désactiver l'ancien boost (optionnel, ou le marquer comme upgradé).
        // - Créer un NOUVEAU Tier pour le plan supérieur, avec `payment_status` = 'paid'.
        //
        // Exemple SIMULÉ : on crée un nouveau Tier.
        // $upgradedTier = $newTierDetails->replicate(); // Crée une copie
        // $upgradedTier->user_id = Auth::id();
        // $upgradedTier->payment_status = 'paid';
        // $upgradedTier->payment_date = now();
        // // Potentiellement copier/ajuster d'autres champs (ex: date de début, durée)
        // $upgradedTier->save();

        Log::info("SIMULATION: Mise à niveau traitée depuis Tier ID: {$tier->id} vers le nouveau Tier ID: {$newTierId} (basé sur {$newTierDetails->title}). User ID: " . Auth::id());

        return redirect()->route('etudiants.boostage.status')->with('success', 'Votre boost a été mis à niveau avec succès (Simulation).');
    }

    /**
     * Récupère les plans de boost disponibles qui sont plus chers que le prix actuel.
     * Utilisé pour la fonctionnalité de mise à niveau.
     */
    private function getHigherPlans($currentPrice)
    {
        // Retourne une collection Eloquent des Tiers qui sont :
        // 1. Marqués comme `is_purchasable` (disponibles à l'achat).
        // 2. Ont un prix (`price`) supérieur au `$currentPrice`.
        // 3. Sont triés par prix croissant.
        return Tier::where('is_purchasable', true)
                   ->where('price', '>', $currentPrice)
                   ->orderBy('price')
                   ->get();
    }

    
}
