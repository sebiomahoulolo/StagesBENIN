<?php

namespace App\Http\Controllers;

use App\Models\Boost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BoostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:etudiant');
    }

    /**
     * Affiche le statut du boost actif
     */
    public function status()
    {
        // Données génériques pour le boost
        $boost = (object)[
            'id' => 1,
            'type' => 'premium',
            'expires_at' => now()->addDays(15),
            'status' => 'active',
            'entreprise_count' => 150,
            'view_count' => 450,
            'application_count' => 25,
            'message_count' => 12,
            'avantages' => $this->getBoostAdvantages('premium')
        ];

        return view('etudiants.boost-status', compact('boost'));
    }

    /**
     * Affiche la page de renouvellement du boost
     */
    public function renew(Boost $boost)
    {
        if ($boost->etudiant_id !== Auth::user()->etudiant->id) {
            return redirect()->route('etudiants.boostage')
                ->with('error', 'Vous n\'avez pas accès à ce boost.');
        }

        return view('etudiants.boost-renew', compact('boost'));
    }

    /**
     * Affiche la page de mise à niveau du boost
     */
    public function upgrade(Boost $boost)
    {
        if ($boost->etudiant_id !== Auth::user()->etudiant->id) {
            return redirect()->route('etudiants.boostage')
                ->with('error', 'Vous n\'avez pas accès à ce boost.');
        }

        $higherPlans = $this->getHigherPlans($boost->type);
        return view('etudiants.boost-upgrade', compact('boost', 'higherPlans'));
    }

    /**
     * Traite le renouvellement du boost
     */
    public function processRenewal(Request $request, Boost $boost)
    {
        if ($boost->etudiant_id !== Auth::user()->etudiant->id) {
            return redirect()->route('etudiants.boostage')
                ->with('error', 'Vous n\'avez pas accès à ce boost.');
        }

        // TODO: Implémenter la logique de paiement
        // Pour l'instant, on simule un renouvellement réussi
        $boost->update([
            'expires_at' => now()->addDays(30),
            'status' => 'active'
        ]);

        return redirect()->route('etudiants.boostage.status', $boost)
            ->with('success', 'Votre boost a été renouvelé avec succès !');
    }

    /**
     * Traite la mise à niveau du boost
     */
    public function processUpgrade(Request $request, Boost $boost)
    {
        if ($boost->etudiant_id !== Auth::user()->etudiant->id) {
            return redirect()->route('etudiants.boostage')
                ->with('error', 'Vous n\'avez pas accès à ce boost.');
        }

        $newType = $request->input('new_type');
        
        // TODO: Implémenter la logique de paiement
        // Pour l'instant, on simule une mise à niveau réussie
        $boost->update([
            'type' => $newType,
            'expires_at' => now()->addDays(30),
            'status' => 'active'
        ]);

        return redirect()->route('etudiants.boostage.status', $boost)
            ->with('success', 'Votre boost a été mis à niveau avec succès !');
    }

    /**
     * Retourne les avantages en fonction du type de boost
     */
    private function getBoostAdvantages($type)
    {
        $advantages = [
            'basic' => [
                'Visibilité accrue dans les recherches',
                'Badge "Profil Boosté"',
                'Statistiques de visibilité'
            ],
            'premium' => [
                'Visibilité accrue dans les recherches',
                'Badge "Profil Premium"',
                'Statistiques détaillées',
                'Candidatures prioritaires',
                'Messages illimités'
            ],
            'elite' => [
                'Visibilité maximale dans les recherches',
                'Badge "Profil Elite"',
                'Statistiques avancées',
                'Candidatures prioritaires',
                'Messages illimités',
                'Accès aux offres exclusives',
                'Support prioritaire'
            ]
        ];

        return $advantages[$type] ?? $advantages['basic'];
    }

    /**
     * Retourne les plans supérieurs disponibles
     */
    private function getHigherPlans($currentType)
    {
        $plans = [
            'basic' => [
                'premium' => [
                    'name' => 'Premium',
                    'price' => 5000,
                    'duration' => 30,
                    'advantages' => $this->getBoostAdvantages('premium')
                ],
                'elite' => [
                    'name' => 'Elite',
                    'price' => 10000,
                    'duration' => 30,
                    'advantages' => $this->getBoostAdvantages('elite')
                ]
            ],
            'premium' => [
                'elite' => [
                    'name' => 'Elite',
                    'price' => 10000,
                    'duration' => 30,
                    'advantages' => $this->getBoostAdvantages('elite')
                ]
            ]
        ];

        return $plans[$currentType] ?? [];
    }
} 