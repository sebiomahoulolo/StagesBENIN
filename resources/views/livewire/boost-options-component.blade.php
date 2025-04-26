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
                
                {{-- Boutons d'action --}}
                <div class="boost-option-actions">
                    {{-- Bouton Payer --}}
                    <button 
                        wire:click="initiatePayment({{ $tier['id'] }})" 
                        class="boost-btn boost-btn-primary"
                    >
                        <i class="fas fa-credit-card"></i>
                        Payer
                    </button>
                    
                    {{-- Bouton Voir --}}
                    <button 
                        wire:click="viewDetails({{ $tier['id'] }})" 
                        class="boost-btn boost-btn-secondary"
                    >
                        <i class="fas fa-eye"></i>
                        Voir
                    </button>
                    
                    <div class="boost-btn-group">
                        {{-- Bouton Télécharger --}}
                        <button 
                            wire:click="downloadDetails({{ $tier['id'] }})" 
                            class="boost-btn boost-btn-success"
                        >
                            <i class="fas fa-download"></i>
                            Télécharger
                        </button>
                        
                        {{-- Bouton Annuler --}}
                        <button 
                            wire:click="cancelSelection({{ $tier['id'] }})" 
                            class="boost-btn boost-btn-danger"
                        >
                            <i class="fas fa-times"></i>
                            Annuler
                        </button>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

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
        
        .boost-btn-secondary {
            background-color: #f3f4f6;
            color: #374151;
        }
        
        .boost-btn-secondary:hover {
            background-color: #e5e7eb;
        }
        
        .boost-btn-success {
            background-color: #10b981;
            color: white;
        }
        
        .boost-btn-success:hover {
            background-color: #059669;
        }
        
        .boost-btn-danger {
            background-color: #ef4444;
            color: white;
        }
        
        .boost-btn-danger:hover {
            background-color: #dc2626;
        }
        
        /* Groupe de boutons */
        .boost-btn-group {
            display: flex;
            gap: 0.5rem;
        }
        
        .boost-btn-group .boost-btn {
            flex: 1;
        }
    </style>
</div> 