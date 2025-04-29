{{-- /resources/views/etudiants/boost-status.blade.php --}}

@extends('layouts.etudiant.app')

@section('title', 'Statut du Boost')

@push('styles')
    <style>
        .boost-status-container {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 1rem;
        }

        .status-header {
            background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
            color: white;
            padding: 2rem;
            border-radius: 1rem;
            text-align: center;
            margin-bottom: 2rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .status-header h1 {
            font-size: 2rem;
            margin-bottom: 1rem;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            background-color: #10b981;
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 2rem;
            font-weight: 600;
            margin-bottom: 1rem;
        }

        .status-badge i {
            margin-right: 0.5rem;
        }

        .countdown-container {
            background-color: white;
            border-radius: 0.5rem;
            padding: 1.5rem;
            margin: 1rem 0;
            display: inline-block;
        }

        .countdown {
            display: flex;
            gap: 1rem;
            justify-content: center;
        }

        .countdown-item {
            text-align: center;
            background-color: #f3f4f6;
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            min-width: 80px;
        }

        .countdown-value {
            font-size: 1.5rem;
            font-weight: 700;
            color: #1f2937;
        }

        .countdown-label {
            font-size: 0.875rem;
            color: #6b7280;
        }

        .boost-details {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .detail-card {
            background-color: white;
            border-radius: 0.75rem;
            padding: 1.5rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s ease;
        }

        .detail-card:hover {
            transform: translateY(-5px);
        }

        .detail-card h3 {
            color: #1f2937;
            font-size: 1.25rem;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
        }

        .detail-card h3 i {
            margin-right: 0.75rem;
            color: #2563eb;
        }

        .detail-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .detail-item {
            display: flex;
            align-items: center;
            padding: 0.5rem 0;
            color: #4b5563;
        }

        .detail-item i {
            margin-right: 0.75rem;
            color: #10b981;
        }

        .upgrade-options {
            background-color: white;
            border-radius: 1rem;
            padding: 2rem;
            margin-top: 2rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        }

        .upgrade-options h2 {
            color: #1f2937;
            font-size: 1.5rem;
            margin-bottom: 1.5rem;
            text-align: center;
        }

        .upgrade-buttons {
            display: flex;
            gap: 1rem;
            justify-content: center;
            flex-wrap: wrap;
        }

        .upgrade-btn {
            padding: 1rem 2rem;
            border-radius: 0.5rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .renew-btn {
            background-color: #2563eb;
            color: white;
        }

        .renew-btn:hover {
            background-color: #1d4ed8;
            transform: translateY(-2px);
        }

        .upgrade-btn {
            background-color: #10b981;
            color: white;
        }

        .upgrade-btn:hover {
            background-color: #059669;
            transform: translateY(-2px);
        }

        .upgrade-btn i {
            margin-right: 0.5rem;
        }

        @media (max-width: 768px) {
            .boost-details {
                grid-template-columns: 1fr;
            }

            .countdown {
                flex-wrap: wrap;
            }

            .upgrade-buttons {
                flex-direction: column;
            }

            .upgrade-btn {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
@endpush

@section('content')
    <div class="boost-status-container">
        <div class="status-header">
            <div class="status-badge">
                <i class="fas fa-rocket"></i>
                Profil Boosté
            </div>
            <h1>Votre profil est actuellement boosté</h1>
            <div class="countdown-container">
                <div class="countdown">
                    <div class="countdown-item">
                        <div class="countdown-value" id="days">00</div>
                        <div class="countdown-label">Jours</div>
                    </div>
                    <div class="countdown-item">
                        <div class="countdown-value" id="hours">00</div>
                        <div class="countdown-label">Heures</div>
                    </div>
                    <div class="countdown-item">
                        <div class="countdown-value" id="minutes">00</div>
                        <div class="countdown-label">Minutes</div>
                    </div>
                    <div class="countdown-item">
                        <div class="countdown-value" id="seconds">00</div>
                        <div class="countdown-label">Secondes</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="boost-details">
            <div class="detail-card">
                <h3><i class="fas fa-building"></i> Visibilité Entreprises</h3>
                <ul class="detail-list">
                    <li class="detail-item">
                        <i class="fas fa-check"></i>
                        {{ $boost->entreprise_count }} entreprises peuvent voir votre profil
                    </li>
                    <li class="detail-item">
                        <i class="fas fa-check"></i>
                        Apparaissez en tête des résultats de recherche
                    </li>
                    <li class="detail-item">
                        <i class="fas fa-check"></i>
                        Badge "Profil Boosté" visible
                    </li>
                </ul>
            </div>

            <div class="detail-card">
                <h3><i class="fas fa-chart-line"></i> Statistiques</h3>
                <ul class="detail-list">
                    <li class="detail-item">
                        <i class="fas fa-check"></i>
                        {{ $boost->view_count }} vues de profil
                    </li>
                    <li class="detail-item">
                        <i class="fas fa-check"></i>
                        {{ $boost->application_count }} candidatures prioritaires
                    </li>
                    <li class="detail-item">
                        <i class="fas fa-check"></i>
                        {{ $boost->message_count }} messages reçus
                    </li>
                </ul>
            </div>

            <div class="detail-card">
                <h3><i class="fas fa-star"></i> Avantages Actuels</h3>
                <ul class="detail-list">
                    @foreach($boost->avantages as $avantage)
                        <li class="detail-item">
                            <i class="fas fa-check"></i>
                            {{ $avantage }}
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

        <div class="upgrade-options">
            <h2>Options de Renouvellement</h2>
            <div class="upgrade-buttons">
                <a href="{{ route('etudiants.boostage.renew', ['boost' => $boost->id]) }}" class="upgrade-btn renew-btn">
                    <i class="fas fa-sync-alt"></i>
                    Renouveler le Boost
                </a>
                <a href="{{ route('etudiants.boostage.upgrade', ['boost' => $boost->id]) }}" class="upgrade-btn">
                    <i class="fas fa-arrow-up"></i>
                    Passer à un Plan Supérieur
                </a>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Fonction pour mettre à jour le compte à rebours
        function updateCountdown() {
            const endDate = new Date('{{ $boost->expires_at }}').getTime();
            const now = new Date().getTime();
            const distance = endDate - now;

            const days = Math.floor(distance / (1000 * 60 * 60 * 24));
            const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);

            document.getElementById('days').textContent = days.toString().padStart(2, '0');
            document.getElementById('hours').textContent = hours.toString().padStart(2, '0');
            document.getElementById('minutes').textContent = minutes.toString().padStart(2, '0');
            document.getElementById('seconds').textContent = seconds.toString().padStart(2, '0');

            if (distance < 0) {
                clearInterval(countdownInterval);
                document.querySelector('.countdown').innerHTML = '<div class="countdown-expired">Le boost a expiré</div>';
            }
        }

        // Mettre à jour le compte à rebours toutes les secondes
        const countdownInterval = setInterval(updateCountdown, 1000);
        updateCountdown(); // Appel initial
    </script>
@endpush 