{{-- /resources/views/etudiants/boost-status.blade.php --}}

@extends('layouts.etudiant.app')

@section('title', 'StagesBENIN')

@push('styles')
{{-- Vos styles CSS ici --}}
<style>
    :root {
        --primary: #2563eb; /* ... autres variables ... */
        --primary-dark: #1d4ed8;
        --success: #10b981;
        --success-dark: #059669;
        --warning: #f59e0b;
        --danger: #ef4444;
        --gray: #9ca3af;
        --gray-dark: #4b5563;
        --gray-darker: #1f2937;
        --white: #ffffff;
        --shadow-sm: 0 1px 2px rgba(0, 0, 0, 0.05);
        --shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        --shadow-md: 0 4px 6px rgba(0, 0, 0, 0.1);
        --radius-sm: 0.375rem;
        --radius: 0.5rem;
        --radius-md: 0.75rem;
        --radius-lg: 1rem;
    }
    .boost-status-container { max-width: 1200px; margin: 2rem auto; padding: 0 1rem; }
    .status-header { background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%); color: var(--white); padding: 2rem; border-radius: var(--radius-lg); text-align: center; margin-bottom: 2rem; box-shadow: var(--shadow-md); }
    .status-header.inactive { background: linear-gradient(135deg, var(--gray) 0%, var(--gray-dark) 100%); }
    .status-header.failed { background: linear-gradient(135deg, var(--danger) 0%, #b91c1c 100%); } /* Style pour échec */
    .status-header h1 { font-size: 1.75rem; margin-bottom: 1rem; font-weight: 700; }
    .status-header p { color: rgba(255, 255, 255, 0.9); margin: 1rem 0; font-size: 1.125rem; }
    .status-badge { display: inline-flex; align-items: center; background-color: var(--success); color: var(--white); padding: 0.5rem 1rem; border-radius: 2rem; font-weight: 600; margin-bottom: 1rem; }
    .status-badge.inactive { background-color: var(--warning); }
    .status-badge.failed { background-color: var(--danger); } /* Style pour badge échec */
    .status-badge i { margin-right: 0.5rem; }
    .payment-info { margin: 1rem 0; font-size: 1rem; }
    .payment-info .status { font-weight: 600; padding: 0.25rem 0.75rem; border-radius: var(--radius-sm); margin-left: 0.5rem; display: inline-block; font-size: 0.875rem; }
    .payment-info .status-paid { background-color: var(--success); color: var(--white); }
    .payment-info .status-pending { background-color: var(--warning); color: var(--gray-darker); }
    .payment-info .status-failed { background-color: var(--danger); color: var(--white); }
    .payment-info .status-unknown { background-color: var(--gray); color: var(--white); }
    .countdown-container { background-color: var(--white); border-radius: var(--radius); padding: 1.5rem; margin: 1.5rem auto; max-width: 500px; box-shadow: var(--shadow); }
    .countdown-title { font-weight: 600; color: var(--gray-darker); margin-bottom: 1rem; font-size: 1.125rem; }
    .countdown { display: flex; gap: 0.75rem; justify-content: center; }
    .countdown-item { text-align: center; background-color: #f3f4f6; padding: 0.75rem 0.5rem; border-radius: var(--radius); min-width: 80px; box-shadow: var(--shadow-sm); }
    .countdown-value { font-size: 1.75rem; font-weight: 700; color: var(--gray-darker); line-height: 1.2; }
    .countdown-label { font-size: 0.875rem; color: var(--gray-dark); margin-top: 0.25rem; }
    .boost-details { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 1.5rem; margin-bottom: 2rem; }
    .detail-card { background-color: var(--white); border-radius: var(--radius-md); padding: 1.5rem; box-shadow: var(--shadow); transition: transform 0.3s ease, box-shadow 0.3s ease; height: 100%; }
    .detail-card:hover { transform: translateY(-5px); box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1); }
    .detail-card h3 { color: var(--gray-darker); font-size: 1.25rem; margin-bottom: 1.25rem; display: flex; align-items: center; font-weight: 600; }
    .detail-card h3 i { margin-right: 0.75rem; color: var(--primary); }
    .detail-list { list-style: none; padding: 0; margin: 0; }
    .detail-item { display: flex; align-items: flex-start; padding: 0.625rem 0; color: var(--gray-dark); border-bottom: 1px solid rgba(0, 0, 0, 0.05); }
    .detail-item:last-child { border-bottom: none; }
    .detail-item-icon { margin-right: 0.75rem; color: var(--success); flex-shrink: 0; margin-top: 0.25rem; font-size: 0.875rem; }
    .detail-item-text { flex: 1; line-height: 1.4; }
    .detail-item-text strong { color: var(--gray-darker); margin-right: 0.25rem; }
    .stats-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 1rem; margin-bottom: 1.5rem; }
    .stat-item { text-align: center; padding: 1rem 0.5rem; background-color: #f9fafb; border-radius: var(--radius); }
    .stat-value { font-size: 1.75rem; font-weight: 700; color: var(--primary); margin-bottom: 0.25rem; }
    .stat-label { font-size: 0.75rem; color: var(--gray-dark); }
    .progress-container { margin-top: 1rem; }
    .progress-label { display: flex; justify-content: space-between; margin-bottom: 0.5rem; font-size: 0.875rem; color: var(--gray-dark); }
    .progress-bar { height: 0.5rem; background-color: #e5e7eb; border-radius: 1rem; overflow: hidden; }
    .progress-fill { height: 100%; background-color: var(--primary); border-radius: 1rem; transition: width 0.5s ease; }
    .upgrade-options { background-color: var(--white); border-radius: var(--radius-lg); padding: 2rem; margin-top: 2rem; box-shadow: var(--shadow); text-align: center; }
    .upgrade-options h2 { color: var(--gray-darker); font-size: 1.5rem; margin-bottom: 1.5rem; font-weight: 600; }
    .upgrade-buttons { display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap; }
    .upgrade-btn { padding: 1rem 2rem; border-radius: var(--radius); font-weight: 600; display: inline-flex; align-items: center; transition: all 0.3s ease; text-decoration: none; box-shadow: var(--shadow); border: none; cursor: pointer; }
    .renew-btn { background-color: var(--primary); color: var(--white); }
    .renew-btn:hover { background-color: var(--primary-dark); transform: translateY(-2px); }
    .upgrade-premium-btn { background-color: var(--success); color: var(--white); }
    .upgrade-premium-btn:hover { background-color: var(--success-dark); transform: translateY(-2px); }
    .upgrade-btn i { margin-right: 0.75rem; }
    .countdown-expired { color: var(--danger); font-weight: bold; font-size: 1.25rem; padding: 0.5rem; width: 100%; }
    @media (max-width: 992px) { .boost-details { grid-template-columns: repeat(2, 1fr); } }
    @media (max-width: 768px) { .status-header { padding: 1.5rem; } .status-header h1 { font-size: 1.5rem; } .boost-details { grid-template-columns: 1fr; } .stats-grid { grid-template-columns: 1fr; gap: 0.75rem; } .countdown { flex-wrap: wrap; gap: 0.5rem; } .countdown-item { min-width: 70px; flex: 1; } .countdown-value { font-size: 1.5rem; } }
    @media (max-width: 480px) { .boost-status-container { padding: 0 0.75rem; margin: 1rem auto; } .status-header { padding: 1.25rem; margin-bottom: 1.5rem; } .status-badge { font-size: 0.875rem; padding: 0.375rem 0.75rem; } .countdown-container { padding: 1rem; } .detail-card { padding: 1.25rem; } .upgrade-buttons { flex-direction: column; } .upgrade-btn { width: 100%; justify-content: center; margin-bottom: 0.75rem; } .stats-grid { grid-template-columns: repeat(auto-fit, minmax(100px, 1fr)); } .stat-value { font-size: 1.5rem; } }
</style>
@endpush

@section('content')
<div class="boost-status-container">

    {{-- Vérifie si un tier a été trouvé ET si son statut est 'paid' --}}
    @if($tier && $tier->payment_status === 'paid')
        {{-- ============================================ --}}
        {{-- == CAS 1 : BOOST PAYÉ (ACTIF OU EXPIRÉ) == --}}
        {{-- ============================================ --}}

        {{-- Header pour un boost payé --}}
        <div class="status-header">
            <div class="status-badge">
                <i class="fas fa-rocket"></i>
                Profil Boosté
            </div>
            <h1>{{ $tier->title ?? 'Votre profil est actuellement boosté' }}</h1>
            <div class="payment-info">
                Statut:
                <span class="status status-paid">Payé</span>
                @if($tier->payment_date)
                    (le: {{ $tier->payment_date->format('d/m/Y H:i') }})
                @endif
            </div>

            {{-- Compte à rebours (sera géré par JS, affichera "expiré" si besoin) --}}
            <div class="countdown-container">
                <div class="countdown-title">Temps restant avant expiration</div>
                <div class="countdown" id="countdown-timer">
                    {{-- Les valeurs seront injectées par JS --}}
                    <div class="countdown-item"><div class="countdown-value" id="days">00</div><div class="countdown-label">Jours</div></div>
                    <div class="countdown-item"><div class="countdown-value" id="hours">00</div><div class="countdown-label">Heures</div></div>
                    <div class="countdown-item"><div class="countdown-value" id="minutes">00</div><div class="countdown-label">Minutes</div></div>
                    <div class="countdown-item"><div class="countdown-value" id="seconds">00</div><div class="countdown-label">Secondes</div></div>
                </div>
            </div>
        </div>

        {{-- Grille de détails du boost payé --}}
        <div class="boost-details">
            {{-- Carte: Informations Générales --}}
            <div class="detail-card">
                <h3><i class="fas fa-info-circle"></i> Informations Générales</h3>
                <ul class="detail-list">
                    {{-- Affiche les détails du boost payé --}}

                    <li class="detail-item"><i class="fas fa-file-alt detail-item-icon"></i><div class="detail-item-text"><strong>Description:</strong> {{ $tier->description ?? 'N/A' }}</div></li>
                    <li class="detail-item"><i class="fas fa-calendar-check detail-item-icon"></i><div class="detail-item-text"><strong>Activé le:</strong> {{ ($tier->payment_date ?? $tier->created_at)?->format('d/m/Y H:i') ?: 'N/A' }}</div></li>
                    <li class="detail-item"><i class="far fa-calendar-alt detail-item-icon"></i><div class="detail-item-text"><strong>Expire le:</strong> {{ $tier->expires_at ? $tier->expires_at->format('d/m/Y H:i') : 'N/A' }}</div></li>
                    <li class="detail-item"><i class="fas fa-clock detail-item-icon"></i><div class="detail-item-text"><strong>Durée:</strong> {{ $tier->duration ?? 'N/A' }} {{ $tier->duration_unit == 'months' ? 'Mois' : ($tier->duration_unit == 'days' ? 'Jours' : '') }} mois</div></li>
                    <li class="detail-item"><i class="fas fa-money-bill-wave detail-item-icon"></i><div class="detail-item-text"><strong>Prix Payé:</strong> {{ number_format($tier->price ?? 0, 0, ',', ' ') }} FCFA</div></li>
                </ul>
            </div>

            {{-- Carte: Visibilité --}}
            <div class="detail-card">
                <h3><i class="fas fa-building"></i> Visibilité Entreprises</h3>
                <ul class="detail-list">
                     {{-- Affiche les détails de visibilité --}}
                    <li class="detail-item"><i class="fas fa-eye detail-item-icon"></i><div class="detail-item-text"><strong>Niveau:</strong> {{ $tier->visibility_level ?? 'Standard' }}</div></li>
                    <li class="detail-item"><i class="fas fa-landmark detail-item-icon"></i><div class="detail-item-text"><strong>{{ $tier->entreprise_count }}</strong> entreprises ciblées (Estimation)</div></li>
                    <li class="detail-item"><i class="fas fa-sort-amount-up detail-item-icon"></i><div class="detail-item-text">Placement prioritaire</div></li>
                    <li class="detail-item"><i class="fas fa-award detail-item-icon"></i><div class="detail-item-text">Badge "Profil Boosté"</div></li>
                </ul>
            </div>

            {{-- Carte: Statistiques --}}
            <div class="detail-card">
                <h3><i class="fas fa-chart-line"></i> Statistiques (Estimations)</h3>
                <div class="stats-grid">
                     {{-- Affiche les stats --}}
                    <div class="stat-item"><div class="stat-value" id="view-count">{{ $tier->view_count }}</div><div class="stat-label">Vues Profil</div></div>
                    <div class="stat-item"><div class="stat-value" id="application-count">{{ $tier->application_count }}</div><div class="stat-label">Candidatures Prioritaires</div></div>
                    <div class="stat-item"><div class="stat-value" id="message-count">{{ $tier->message_count }}</div><div class="stat-label">Messages Reçus</div></div>
                </div>
                {{-- Barre de progression --}}
                <div class="progress-container">
                    <div class="progress-label"><span>Progression du boost</span><span id="progress-percentage">0%</span></div>
                    <div class="progress-bar"><div class="progress-fill" id="progress-fill"></div></div>
                </div>
            </div>

            {{-- Carte: Avantages Inclus --}}
           
        {{-- Options Renouvellement / Upgrade (Affichées même si expiré pour inciter à l'action) --}}
        <div class="upgrade-options">
            <h2>Options de Gestion du Boost</h2>
            <div class="upgrade-buttons">
                <a href="{{ route('etudiants.boostage.renew', ['tier' => $tier->id]) }}" class="upgrade-btn renew-btn">
                    <i class="fas fa-sync-alt"></i>
                    Renouveler ce Boost
                </a> 
            </div>
        </div>

    {{-- Vérifie si un tier a été trouvé ET si son statut est 'failed' --}}
    @elseif($tier && $tier->payment_status === 'failed')
        {{-- ================================= --}}
        {{-- == CAS 2 : PAIEMENT A ÉCHOUÉ == --}}
        {{-- ================================= --}}

        <div class="status-header failed"> {{-- Classe pour fond rouge --}}
           <div class="status-badge failed"> {{-- Classe pour badge rouge --}}
               <i class="fas fa-exclamation-triangle"></i>
                Échec de Paiement
            </div>
           <h1>Échec de la tentative de boost</h1>
           {{-- Message informant de l'échec --}}
           <p>
               Votre dernière tentative de paiement pour le boost "{{ $tier->title ?? 'N/A' }}"
               @if($tier->created_at)
                (tentative du {{ $tier->created_at->format('d/m/Y H:i') }})
               @endif
               n'a pas abouti.
            </p>
           <p>Veuillez vérifier vos informations de paiement ou réessayer.</p>
           {{-- Bouton pour réessayer ou choisir un autre plan --}}
           <a href="{{ route('etudiants.boostage') }}" class="upgrade-btn renew-btn" style="margin-top: 2rem; display: inline-block;">
                <i class="fas fa-redo"></i>
                Réessayer ou choisir un autre boost
            </a>
        </div>

    @else
        {{-- ============================================================== --}}
        {{-- == CAS 3 : AUCUN BOOST TROUVÉ ou STATUT NI PAID NI FAILED == --}}
        {{-- ============================================================== --}}

        <div class="status-header inactive">
            <div class="status-badge inactive">
                <i class="fas fa-times-circle"></i>
                Aucun Boost Actif
            </div>
            <h1>Votre profil n'est pas boosté actuellement</h1>
            <p>
                Augmentez votre visibilité auprès des recruteurs et accélérez votre recherche de stage en activant un boost !
            </p>
             {{-- Lien vers la page de sélection des boosts --}}
            <a href="{{ route('etudiants.boostage') }}" class="upgrade-btn renew-btn" style="margin-top: 2rem; display: inline-block; background-color: var(--success);">
                <i class="fas fa-rocket"></i>
                Découvrir les Boosts
            </a>
        </div>
    @endif
</div>
@endsection

@push('scripts')
    {{-- Le script du compte à rebours n'est inclus que si le tier est PAYÉ et a une date d'expiration --}}
    @if($tier && $tier->payment_status === 'paid' && $tier->expires_at)
        <script>
            // --- Données essentielles pour le script ---
            const boostEndDate = '{{ $tier->expires_at->toISOString() }}';
            const boostStartDate = '{{ ($tier->payment_date ?? $tier->created_at)?->toISOString() }}';

            let countdownInterval;

            function updateCountdown() {
                const countdownTimerEl = document.getElementById('countdown-timer');
                const daysEl = document.getElementById('days');
                const hoursEl = document.getElementById('hours');
                const minutesEl = document.getElementById('minutes');
                const secondsEl = document.getElementById('seconds');
                const progressFill = document.getElementById('progress-fill');
                const progressPercentage = document.getElementById('progress-percentage');

                if (!boostEndDate || !boostStartDate) {
                    // console.error("Dates manquantes pour le script."); // Optionnel: log en console
                     if(countdownTimerEl) countdownTimerEl.innerHTML = '<div class="countdown-expired">Erreur dates</div>';
                     // Masquer les boutons si erreur dates
                    const upgradeButtons = document.querySelector('.upgrade-buttons');
                     if (upgradeButtons) upgradeButtons.style.display = 'none';
                    return;
                }

                const endDate = new Date(boostEndDate).getTime();
                const startDate = new Date(boostStartDate).getTime();
                const totalDurationMillis = Math.max(1, endDate - startDate);

                function tick() {
                    const now = new Date().getTime();
                    const distance = endDate - now;

                    if (distance < 0) {
                        clearInterval(countdownInterval);
                        if(countdownTimerEl) countdownTimerEl.innerHTML = '<div class="countdown-expired">Boost expiré</div>';
                        if(progressFill) progressFill.style.width = '100%';
                        if(progressPercentage) progressPercentage.textContent = 'Expiré';
                         // Laisser les boutons visibles même si expiré pour permettre renouvellement/upgrade
                         // const upgradeButtons = document.querySelector('.upgrade-buttons');
                         // if (upgradeButtons) upgradeButtons.style.display = 'none'; // Décommentez si vous voulez masquer
                        return;
                    }

                    const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                    const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                    const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                    if(daysEl) daysEl.textContent = days.toString().padStart(2, '0');
                    if(hoursEl) hoursEl.textContent = hours.toString().padStart(2, '0');
                    if(minutesEl) minutesEl.textContent = minutes.toString().padStart(2, '0');
                    if(secondsEl) secondsEl.textContent = seconds.toString().padStart(2, '0');

                    if (progressFill && progressPercentage) {
                        const elapsedMillis = Math.max(0, now - startDate);
                        const progress = Math.min(100, Math.max(0, Math.round((elapsedMillis / totalDurationMillis) * 100)));
                        progressFill.style.width = `${progress}%`;
                        progressPercentage.textContent = `${progress}%`;
                    }
                }
                tick();
                countdownInterval = setInterval(tick, 1000);
            }
            document.addEventListener('DOMContentLoaded', updateCountdown);
        </script>
    @endif
@endpush