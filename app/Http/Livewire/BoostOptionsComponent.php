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
            'title' => 'Boost 2000',
            'description' => 'Visibilité basique pour votre profil',
            'details' => [
                'entreprises' => 2,
                'secteurs' => 2,
                'duree' => '1 mois'
            ],
            'avantages' => [
                'Accès à 2 entreprises ciblées',
                'Visibilité dans 2 secteurs d\'activité',
                'Prix abordable pour débuter',
                'Parfait pour les premières expériences'
            ],
            'inconvenients' => [
                'Durée limitée à 1 mois',
                'Nombre d\'entreprises restreint',
                'Visibilité limitée aux secteurs choisis'
            ]
        ],
        [
            'id' => 2,
            'price' => 4000,
            'title' => 'Boost 4000',
            'description' => 'Visibilité améliorée pour votre profil',
            'details' => [
                'entreprises' => 4,
                'secteurs' => 4,
                'duree' => '2 mois'
            ],
            'avantages' => [
                'Accès à 4 entreprises ciblées',
                'Visibilité dans 4 secteurs d\'activité',
                'Durée de 2 mois',
                'Meilleur rapport qualité-prix',
                'Idéal pour les profils intermédiaires'
            ],
            'inconvenients' => [
                'Investissement plus important',
                'Visibilité encore limitée à certains secteurs',
                'Pas d\'accès aux entreprises premium'
            ]
        ],
        [
            'id' => 3,
            'price' => 5000,
            'title' => 'Boost 5000',
            'description' => 'Visibilité supérieure et recommandations',
            'details' => [
                'entreprises' => 8,
                'secteurs' => 6,
                'duree' => '3 mois'
            ],
            'avantages' => [
                'Accès à 8 entreprises ciblées',
                'Visibilité dans 8 secteurs d\'activité',
                'Durée de 3 mois',
                'Priorité dans les candidatures',
                'Accès aux entreprises partenaires',
                'Statut "Profil Premium"'
            ],
            'inconvenients' => [
                'Investissement significatif',
                'Engagement sur 3 mois',
                'Certaines entreprises restent inaccessibles'
            ]
        ],
        [
            'id' => 4,
            'price' => 8000,
            'title' => 'Boost 8000',
            'description' => 'Placement prioritaire et recommandations ciblées',
            'details' => [
                'entreprises' => 10,
                'secteurs' => 10,
                'duree' => '5 mois'
            ],
            'avantages' => [
                'Accès à 10 entreprises premium',
                'Visibilité dans 10 secteurs d\'activité',
                'Durée de 5 mois',
                'Placement prioritaire dans les recherches',
                'Accès aux offres exclusives',
                'Statut "Profil Premium Plus"',
                'Support prioritaire'
            ],
            'inconvenients' => [
                'Investissement important',
                'Engagement sur 5 mois',
                'Certaines fonctionnalités avancées non incluses'
            ]
        ],
        [
            'id' => 5,
            'price' => 10000,
            'title' => 'Boost 10000',
            'description' => 'Visibilité maximale et accès à des fonctionnalités exclusives',
            'details' => [
                'entreprises' => 'Toutes',
                'secteurs' => 'Tous',
                'duree' => '6 mois'
            ],
            'avantages' => [
                'Accès illimité à toutes les entreprises',
                'Visibilité dans tous les secteurs',
                'Durée de 6 mois',
                'Placement en tête des recherches',
                'Accès à toutes les offres exclusives',
                'Statut "Profil Excellence"',
                'Support premium 24/7',
                'Accès aux événements exclusifs',
                'Mentoring personnalisé'
            ],
            'inconvenients' => [
                'Investissement conséquent',
                'Engagement sur 6 mois',
                'Peut être excessif pour certains profils'
            ]
        ]
    ];

    public $selectedTier = null;
    public $showModal = false;

    /**
     * Affiche les détails d'un palier dans un modal
     * 
     * @param int $tierId
     * @return void
     */
    public function showDetails($tierId)
    {
        $this->selectedTier = $this->findTier($tierId);
        $this->showModal = true;
    }

    /**
     * Ferme le modal
     * 
     * @return void
     */
    public function closeModal()
    {
        $this->showModal = false;
        $this->selectedTier = null;
    }

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