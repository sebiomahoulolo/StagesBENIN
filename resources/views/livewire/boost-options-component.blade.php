<div>
    {{-- Message flash pour les actions --}}
    @if (session()->has('message'))
        <div class="flash-message">
            <span>{{ session('message') }}</span>
        </div>
    @endif

    <div class="text-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Options de Boostage</h2>
        <p class="text-gray-600">Sélectionnez une option pour améliorer la visibilité de votre profil</p>
    </div>

    {{-- Affichage des options de boostage --}}
    <div class="boost-options-grid">
        @foreach($tiers as $tier)
            <div class="boost-option-card">
                {{-- En-tête avec le prix --}}
                <div class="boost-option-header">
                    <h3>{{ $tier['title'] }}</h3>
                    <div class="boost-option-price">{{ number_format($tier['price'], 0, ',', ' ') }} FCFA</div>
                </div>
                
                {{-- Description --}}
                <div class="boost-option-description">
                    <p>{{ $tier['description'] }}</p>
                </div>
                
                {{-- Bouton Voir les détails --}}
                <div class="boost-option-actions">
                    <button 
                        wire:click="showDetails({{ $tier['id'] }})" 
                        class="boost-btn boost-btn-primary"
                    >
                        <i class="fas fa-eye"></i>
                        Voir les détails
                    </button>
                </div>
            </div>
        @endforeach
    </div>

    {{-- Modal des détails --}}
    @if($showModal && $selectedTier)
        <div class="modal-overlay" wire:click="closeModal">
            <div class="modal-content" wire:click.stop>
                <div class="modal-header">
                    <h3 class="modal-title">{{ $selectedTier['title'] }}</h3>
                    <button wire:click="closeModal" class="modal-close">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                
                <div class="modal-body">
                    <div class="details-list">
                        <div class="detail-item">
                            <i class="fas fa-building text-blue-500"></i>
                            <span>Visibilité pour {{ $selectedTier['details']['entreprises'] }} entreprise(s)</span>
                        </div>
                        
                        <div class="detail-item">
                            <i class="fas fa-industry text-blue-500"></i>
                            <span>Visibilité pour {{ $selectedTier['details']['secteurs'] }} secteur(s) d'activité</span>
                        </div>
                        
                        <div class="detail-item">
                            <i class="fas fa-clock text-blue-500"></i>
                            <span>Durée : {{ $selectedTier['details']['duree'] }}</span>
                        </div>
                    </div>

                    {{-- Section Avantages --}}
                    <div class="section-container mt-6">
                        <h4 class="section-title">
                            <i class="fas fa-check-circle text-green-500"></i>
                            Avantages
                        </h4>
                        <ul class="features-list">
                            @foreach($selectedTier['avantages'] as $avantage)
                                <li class="feature-item">
                                    <i class="fas fa-check text-green-500"></i>
                                    <span>{{ $avantage }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    {{-- Section Inconvénients --}}
                    <div class="section-container mt-6">
                        <h4 class="section-title">
                            <i class="fas fa-exclamation-circle text-red-500"></i>
                            Limités
                        </h4>
                        <ul class="features-list">
                            @foreach($selectedTier['inconvenients'] as $inconvenient)
                                <li class="feature-item">
                                    <i class="fas fa-times text-red-500"></i>
                                    <span>{{ $inconvenient }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                
                <div class="modal-footer">
                    <button 
                        wire:click="initiatePayment({{ $selectedTier['id'] }})" 
                        class="activate-btn"
                    >
                        <i class="fas fa-credit-card"></i>
                        Activer pour {{ number_format($selectedTier['price'], 0, ',', ' ') }} FCFA
                    </button>
                </div>
            </div>
        </div>
    @endif

    <style>
        /* Styles pour le message flash */
        .flash-message {
            background-color: #d1fae5;
            border: 1px solid #34d399;
            color: #047857;
            padding: 0.75rem 1rem;
            border-radius: 0.375rem;
            margin-bottom: 1rem;
        }
        
        /* Styles pour la grille des options */
        .boost-options-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
            gap: 1.5rem;
            margin-top: 1.5rem;
        }
        
        /* Responsive: 1 colonne sur mobile, 2 sur tablette, 3+ sur desktop */
        @media (max-width: 640px) {
            .boost-options-grid {
                grid-template-columns: 1fr;
            }
        }
        
        /* Styles pour chaque carte d'option */
        .boost-option-card {
            background-color: #fff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
            transition: all 0.3s ease;
            border: 1px solid #e5e7eb;
        }
        
        .boost-option-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.12);
        }
        
        /* En-tête de l'option avec le prix */
        .boost-option-header {
            background-color: #2563eb;
            color: white;
            padding: 1rem;
            text-align: center;
        }
        
        .boost-option-header h3 {
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }
        
        .boost-option-price {
            font-size: 1.5rem;
            font-weight: 700;
        }
        
        /* Section description */
        .boost-option-description {
            padding: 1rem;
            background-color: #f9fafb;
            min-height: 80px;
            display: flex;
            align-items: center;
        }
        
        .boost-option-description p {
            font-size: 0.875rem;
            color: #4b5563;
            margin: 0;
        }
        
        /* Section boutons d'action */
        .boost-option-actions {
            padding: 1rem;
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }
        
        /* Style générique des boutons */
        .boost-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0.5rem 1rem;
            border-radius: 0.375rem;
            font-weight: 500;
            transition: all 0.2s ease;
            cursor: pointer;
            border: none;
            width: 100%;
        }
        
        .boost-btn i {
            margin-right: 0.5rem;
        }
        
        /* Variantes de boutons */
        .boost-btn-primary {
            background-color: #2563eb;
            color: white;
        }
        
        .boost-btn-primary:hover {
            background-color: #1d4ed8;
        }

        /* Styles pour le modal */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.5);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
            padding-top: 4rem;
        }

        .modal-content {
            background-color: white;
            border-radius: 0.5rem;
            width: 90%;
            max-width: 500px;
            max-height: 80vh;
            overflow-y: auto;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-top: 2rem;
        }

        .modal-header {
            padding: 1rem;
            border-bottom: 1px solid #e5e7eb;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .modal-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: #1f2937;
            margin: 0;
        }

        .modal-close {
            background: none;
            border: none;
            color: #6b7280;
            cursor: pointer;
            padding: 0.5rem;
            font-size: 1.25rem;
        }

        .modal-close:hover {
            color: #1f2937;
        }

        .modal-body {
            padding: 1.5rem;
        }

        .details-list {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .detail-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            color: #4b5563;
        }

        .detail-item i {
            font-size: 1.25rem;
            width: 24px;
            text-align: center;
        }

        .modal-footer {
            padding: 1rem;
            border-top: 1px solid #e5e7eb;
            text-align: center;
        }

        .activate-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.75rem 1.5rem;
            background-color: #2563eb;
            color: white;
            border: none;
            border-radius: 0.375rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease;
            width: 100%;
        }

        .activate-btn:hover {
            background-color: #1d4ed8;
        }

        .activate-btn i {
            margin-right: 0.5rem;
        }

        /* Styles pour les sections du modal */
        .section-container {
            background-color: #f9fafb;
            border-radius: 0.5rem;
            padding: 1rem;
            margin-top: 1rem;
        }

        .section-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 0.75rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .features-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .feature-item {
            display: flex;
            align-items: flex-start;
            gap: 0.75rem;
            padding: 0.5rem 0;
            color: #4b5563;
        }

        .feature-item i {
            margin-top: 0.25rem;
            flex-shrink: 0;
        }

        .text-green-500 {
            color: #10b981;
        }

        .text-red-500 {
            color: #ef4444;
        }
    </style>
</div> 