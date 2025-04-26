<?php

namespace App\Http\Livewire;

use Livewire\Component;

class BoostOptionsComponent extends Component
{
    /**
     * Les paliers de prix pour le boostage
     * 
     * @var array
     */
    public $tiers = [
        [
            'id' => 1,
            'price' => 2000,
            'title' => 'Boost Essentiel',
            'description' => 'Visibilité basique pour votre profil'
        ],
        [
            'id' => 2,
            'price' => 4000,
            'title' => 'Boost Standard',
            'description' => 'Visibilité améliorée pour votre profil'
        ],
        [
            'id' => 3,
            'price' => 5000,
            'title' => 'Boost Avancé',
            'description' => 'Visibilité supérieure et recommandations'
        ],
        [
            'id' => 4,
            'price' => 8000,
            'title' => 'Boost Premium',
            'description' => 'Placement prioritaire et recommandations ciblées'
        ],
        [
            'id' => 5,
            'price' => 10000,
            'title' => 'Boost Excellence',
            'description' => 'Visibilité maximale et accès à des fonctionnalités exclusives'
        ]
    ];

    /**
     * Initie le processus de paiement pour un palier spécifique
     * 
     * @param int $tierId
     * @return void
     */
    public function initiatePayment($tierId)
    {
        // À implémenter - Logique pour initier le paiement
        $selectedTier = $this->findTier($tierId);
        session()->flash('message', "Paiement initié pour le palier {$selectedTier['title']} à {$selectedTier['price']} FCFA");
    }

    /**
     * Annule la sélection d'un palier
     * 
     * @param int $tierId
     * @return void
     */
    public function cancelSelection($tierId)
    {
        // À implémenter - Logique pour annuler la sélection
        $selectedTier = $this->findTier($tierId);
        session()->flash('message', "Sélection annulée pour le palier {$selectedTier['title']}");
    }

    /**
     * Télécharge les détails d'un palier
     * 
     * @param int $tierId
     * @return void
     */
    public function downloadDetails($tierId)
    {
        // À implémenter - Logique pour télécharger les détails
        $selectedTier = $this->findTier($tierId);
        session()->flash('message', "Téléchargement des détails pour le palier {$selectedTier['title']}");
    }

    /**
     * Affiche les détails d'un palier
     * 
     * @param int $tierId
     * @return void
     */
    public function viewDetails($tierId)
    {
        // À implémenter - Logique pour afficher les détails
        $selectedTier = $this->findTier($tierId);
        session()->flash('message', "Affichage des détails pour le palier {$selectedTier['title']}");
    }

    /**
     * Trouve un palier par son ID
     * 
     * @param int $tierId
     * @return array|null
     */
    private function findTier($tierId)
    {
        foreach ($this->tiers as $tier) {
            if ($tier['id'] == $tierId) {
                return $tier;
            }
        }
        return null;
    }

    /**
     * Rend la vue du composant
     * 
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('livewire.boost-options-component');
    }
} 