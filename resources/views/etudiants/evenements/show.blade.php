{{-- /resources/views/etudiants/evenements/show.blade.php --}}

@extends('layouts.etudiant.app') {{-- Assurez-vous que ce layout charge Bootstrap JS/CSS --}}

@section('title', ($event->title ?? 'Événement') . ' - StagesBENIN')

@push('styles')
    {{-- Styles CSS personnalisés pour cette page (SANS les styles du modal) --}}
    <style>
        .event-header {
            position: relative;
            height: 300px;
            overflow: hidden;
            border-radius: 12px;
            margin-bottom: 2rem;
            box-shadow: 0 4px 20px rgba(0,0,0,0.15);
            margin-top: 2rem;
        }

        @media (max-width: 768px) {
            .event-header { height: 250px; margin-top: 1rem; }
            .event-title { font-size: 1.75rem !important; }
            .event-meta { gap: 0.75rem !important; font-size: 0.85rem !important; }
        }

        .event-header-image {
            width: 100%; height: 100%; object-fit: cover; filter: brightness(0.7);
        }
        .event-header-content {
            position: absolute; bottom: 0; left: 0; width: 100%;
            padding: 1.5rem; color: white;
            background: linear-gradient(to top, rgba(0,0,0,0.8), rgba(0,0,0,0));
        }
        .event-type-badge {
            display: inline-block; background-color: #2563eb; color: white;
            padding: 0.4rem 0.75rem; border-radius: 6px; font-size: 0.8rem;
            font-weight: 500; margin-bottom: 0.75rem; text-transform: uppercase;
        }
        .event-title {
            font-size: 2.25rem; font-weight: 700; margin-bottom: 0.5rem;
            text-shadow: 0 2px 4px rgba(0,0,0,0.3);
        }
        .event-meta { display: flex; flex-wrap: wrap; gap: 1.5rem; margin-top: 1rem; }
        .event-meta-item { display: flex; align-items: center; color: rgba(255,255,255,0.9); font-size: 0.9rem; }
        .event-meta-item i { margin-right: 0.5rem; font-size: 1rem; }

        .event-container { display: grid; grid-template-columns: 2fr 1fr; gap: 2rem; }
        @media (max-width: 992px) {
            .event-container { grid-template-columns: 1fr; }
            .event-sidebar { margin-top: 2rem; }
        }
        .event-details, .event-sidebar {
            background-color: white; border-radius: 12px; padding: 1.5rem;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
        }
        .event-sidebar { align-self: start; position: sticky; top: 80px; /* Ajustez si nécessaire */ }

        .event-description { margin-bottom: 2rem; line-height: 1.7; color: #4b5563; white-space: pre-line; }
        .event-section-title {
            font-size: 1.3rem; font-weight: 600; color: #1f2937; margin-bottom: 1.5rem;
            padding-bottom: 0.75rem; border-bottom: 1px solid #e5e7eb;
        }
        .event-section-title i { margin-right: 0.75rem; color: #2563eb; }

        .event-info-list { margin-bottom: 1rem; }
        .event-info-item {
            display: flex; margin-bottom: 1.25rem; padding-bottom: 1.25rem;
            border-bottom: 1px solid #f3f4f6; align-items: flex-start;
        }
        .event-info-item:last-child { border-bottom: none; margin-bottom: 0; padding-bottom: 0; }
        .event-info-icon {
            width: 36px; height: 36px; background-color: #eef2ff; border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
            margin-right: 1rem; flex-shrink: 0;
        }
        .event-info-icon i { color: #2563eb; font-size: 1rem; }
        .event-info-label { font-weight: 500; color: #4b5563; margin-bottom: 0.1rem; font-size: 0.85rem; }
        .event-info-value { color: #1f2937; font-weight: 600;}

        .event-status { display: flex; align-items: center; margin-bottom: 1.5rem; padding-bottom: 1.5rem; border-bottom: 1px solid #e5e7eb; }
        .event-status-icon { width: 40px; height: 40px; background-color: #ecfdf5; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-right: 1rem; flex-shrink: 0; }
        .event-status-icon i { color: #10b981; font-size: 1.25rem; }
        .event-status-content h4 { font-weight: 600; color: #1f2937; margin-bottom: 0.25rem; font-size: 1.1rem; }
        .event-status-content p { color: #6b7280; font-size: 0.9rem; margin-bottom: 0; }

        .event-cta { text-align: center; margin-top: 1.5rem; }
        /* Style du bouton inchangé visuellement */
        .btn-register {
            display: inline-block; background-color: #2563eb; color: white; padding: 0.75rem 1.5rem;
            border-radius: 8px; text-decoration: none; font-weight: 500; width: 100%;
            font-size: 1rem; border: none; cursor: pointer; transition: all 0.2s ease;
        }
        .btn-register:hover:not(:disabled) {
            background-color: #1d4ed8; transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(37, 99, 235, 0.3);
        }
        .btn-register:disabled {
            background-color: #d1d5db !important; color: #6b7280 !important;
            cursor: not-allowed !important; transform: none !important; box-shadow: none !important;
        }

        .event-stat { text-align: center; margin-bottom: 1.5rem; }
        .event-stat-value { font-size: 1.75rem; font-weight: 700; color: #1f2937; margin-bottom: 0.25rem; }
        .event-stat-label { color: #6b7280; font-size: 0.85rem; }

        .countdown-container { margin-top: 1.5rem; margin-bottom: 1.5rem; text-align: center; }
        .countdown-label { font-weight: 500; color: #4b5563; margin-bottom: 0.75rem; font-size: 0.9rem; }
        .countdown-timer { display: flex; justify-content: space-around; }
        .countdown-item { flex-basis: 60px; padding: 0.5rem 0; background-color: #f3f4f6; border-radius: 8px; }
        .countdown-value { font-size: 1.25rem; font-weight: 700; color: #2563eb; margin-bottom: 0.1rem; }
        .countdown-unit { font-size: 0.65rem; color: #6b7280; text-transform: uppercase; }

        /* Flash messages (inchangé) */
        .flash-message { padding: 1rem; border-radius: 8px; margin: 0 0 1.5rem 0; text-align: center; border: 1px solid transparent; }
        .flash-success { background-color: #dcfce7; color: #166534; border-color: #bbf7d0; }
        .flash-error { background-color: #fee2e2; color: #991b1b; border-color: #fecaca;}
        .flash-info { background-color: #e0f2fe; color: #075985; border-color: #bae6fd;} /* Ajout pour info */

        /* Plus besoin des styles .modal-* ici */

    </style>
@endpush

@section('content')
<div class="container"> {{-- Container Bootstrap standard --}}

    {{-- En-tête de l'événement (inchangé) --}}
    <div class="event-header">
        @if($event->image && file_exists(public_path('images/events/' . $event->image)))
            <img src="{{ asset('images/events/' . $event->image) }}" alt="{{ $event->title }}" class="event-header-image">
        @else
            <img src="{{ asset('images/event-placeholder.jpg') }}" alt="{{ $event->title }}" class="event-header-image">
        @endif
        <div class="event-header-content">
            <div class="event-type-badge">{{ $event->type ?? 'Événement' }}</div>
            <h1 class="event-title">{{ $event->title }}</h1>
            <div class="event-meta">
                 <div class="event-meta-item"><i class="far fa-calendar-alt"></i><span>{{ \Carbon\Carbon::parse($event->start_date)->isoFormat('D MMMM YYYY') }}</span></div>
                 <div class="event-meta-item"><i class="far fa-clock"></i><span>{{ \Carbon\Carbon::parse($event->start_date)->format('H:i') }} - {{ \Carbon\Carbon::parse($event->end_date)->format('H:i') }}</span></div>
                 <div class="event-meta-item"><i class="fas fa-map-marker-alt"></i><span>{{ $event->location ?? 'À déterminer' }}</span></div>
                 @if($event->max_participants)
                     <div class="event-meta-item"><i class="fas fa-users"></i><span>{{ $event->max_participants }} places max</span></div>
                 @endif
            </div>
        </div>
    </div>

    {{-- Messages Flash (inchangé) --}}
    <div class="row">
        <div class="col-12">
            {{-- Utilisation de tous les types de messages possibles --}}
            @if(session('success'))
                <div class="flash-message flash-success">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="flash-message flash-error">{{ session('error') }}</div>
            @endif
             @if(session('info')) {{-- Ajout pour le message 'info' (déjà inscrit) --}}
                <div class="flash-message flash-info">{{ session('info') }}</div>
            @endif
            {{-- Affichage des erreurs de validation générales (au cas où) --}}
            @if ($errors->any() && !$errors->has('confirm_participation')) {{-- Ne pas afficher si c'était juste l'erreur du modal --}}
                <div class="flash-message flash-error">
                    <ul class="mb-0" style="list-style: none; padding-left: 0;">
                        @foreach ($errors->all() as $error)
                            <li><i class="fas fa-exclamation-triangle me-2"></i>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
    </div>

    <div class="event-container">
        {{-- Détails de l'événement (inchangé) --}}
        <div class="event-details">
            <h2 class="event-section-title"><i class="fas fa-info-circle"></i> À propos de cet événement</h2>
            <div class="event-description">
                {!! nl2br(e($event->description ?? 'Aucune description fournie.')) !!}
            </div>

            <h2 class="event-section-title"><i class="fas fa-list-ul"></i> Informations pratiques</h2>
            <div class="event-info-list">
                <div class="event-info-item">
                    <div class="event-info-icon"><i class="far fa-calendar-alt"></i></div>
                    <div>
                        <div class="event-info-label">Date</div>
                        <div class="event-info-value">{{ \Carbon\Carbon::parse($event->start_date)->isoFormat('dddd D MMMM YYYY') }}</div>
                    </div>
                </div>
                 <div class="event-info-item">
                    <div class="event-info-icon"><i class="far fa-clock"></i></div>
                    <div>
                        <div class="event-info-label">Horaires</div>
                        <div class="event-info-value">{{ \Carbon\Carbon::parse($event->start_date)->format('H:i') }} - {{ \Carbon\Carbon::parse($event->end_date)->format('H:i') }}</div>
                    </div>
                </div>
                <div class="event-info-item">
                    <div class="event-info-icon"><i class="fas fa-map-marker-alt"></i></div>
                     <div>
                        <div class="event-info-label">Lieu</div>
                        <div class="event-info-value">{{ $event->location ?? 'À déterminer' }}</div>
                    </div>
                </div>
                @if($event->max_participants)
                <div class="event-info-item">
                    <div class="event-info-icon"><i class="fas fa-users"></i></div>
                    <div>
                        <div class="event-info-label">Capacité</div>
                        <div class="event-info-value">{{ $event->max_participants }} participants maximum</div>
                    </div>
                </div>
                @endif
                <div class="event-info-item">
                    <div class="event-info-icon"><i class="fas fa-tag"></i></div>
                     <div>
                        <div class="event-info-label">Type</div>
                        <div class="event-info-value">{{ $event->type ?? 'Général' }}</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Sidebar (avec modification du CTA) --}}
        <div class="event-sidebar">
            <div class="event-status">
                <div class="event-status-icon" id="status-icon-wrapper">
                    <i class="fas fa-calendar-check" id="status-icon"></i>
                </div>
                <div class="event-status-content">
                    <h4 id="status-title">Événement à venir</h4>
                    <p id="status-desc">Inscrivez-vous dès maintenant</p>
                </div>
            </div>

            {{-- Compte à rebours (inchangé) --}}
            @if($event->start_date > now())
            <div class="countdown-container">
                <div class="countdown-label">L'événement commence dans :</div>
                <div class="countdown-timer" id="countdown">
                    <div class="countdown-item"><div class="countdown-value" id="countdown-days">-</div><div class="countdown-unit">jours</div></div>
                    <div class="countdown-item"><div class="countdown-value" id="countdown-hours">-</div><div class="countdown-unit">heures</div></div>
                    <div class="countdown-item"><div class="countdown-value" id="countdown-minutes">-</div><div class="countdown-unit">min</div></div>
                    <div class="countdown-item"><div class="countdown-value" id="countdown-seconds">-</div><div class="countdown-unit">sec</div></div>
                </div>
            </div>
            @endif

            {{-- Statistiques (inchangé) --}}
            @if($event->max_participants)
                <div class="event-stat">
                    <div class="event-stat-value">{{ $event->current_participants ?? 0 }}/{{ $event->max_participants }}</div>
                    <div class="event-stat-label">Places réservées</div>
                </div>
            @endif

            {{-- Bouton d'inscription / Statut (MODIFIÉ) --}}
            <div class="event-cta">
                @php
                    $user = Auth::user(); // Récupérer l'utilisateur une seule fois
                    $eventPassed = $event->start_date < now();
                    // S'assurer que $isRegistered est défini, même si l'utilisateur n'est pas connecté
                    $isRegistered = $user ? $event->registrations()->where('email', $user->email)->exists() : false;
                    $isFull = $event->max_participants && ($event->current_participants ?? 0) >= $event->max_participants;
                @endphp

                @if($isRegistered)
                    <button class="btn-register" disabled><i class="fas fa-check-circle me-2"></i>Déjà inscrit(e)</button>
                @elseif($eventPassed)
                    <button class="btn-register" disabled><i class="fas fa-calendar-times me-2"></i>Événement terminé</button>
                @elseif($isFull)
                     <button class="btn-register" disabled><i class="fas fa-users-slash me-2"></i>Événement complet</button>
                @elseif(!$user) {{-- Si l'utilisateur n'est pas connecté --}}
                     <a href="{{ route('login') }}?redirect={{ url()->current() }}" class="btn-register">
                         <i class="fas fa-sign-in-alt me-2"></i> Connectez-vous pour vous inscrire
                     </a>
                @else {{-- Utilisateur connecté, peut s'inscrire --}}
                     {{-- Début du formulaire d'inscription directe --}}
                     <form action="{{ route('etudiants.evenements.register', $event->id) }}" method="POST" id="directRegistrationForm">
                        @csrf
                        {{-- Champs cachés pour envoyer les données nécessaires au contrôleur --}}
                        <input type="hidden" name="name" value="{{ $user->name ?? '' }}">
                        <input type="hidden" name="email" value="{{ $user->email ?? '' }}">

                        {{-- Le bouton est maintenant de type submit --}}
                        <button type="submit" class="btn-register">
                            <i class="fas fa-edit me-2"></i> S'inscrire à l'événement
                        </button>
                     </form>
                     {{-- Fin du formulaire d'inscription directe --}}
                @endif
            </div>
        </div>
    </div> {{-- Fin event-container --}}

</div> {{-- Fin container --}}

{{-- LE MODAL A ÉTÉ SUPPRIMÉ --}}

@endsection {{-- Fin de la section content --}}

@push('scripts')
    {{-- Script personnalisé pour cette page (SANS la gestion du modal) --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            // --- Fonction de compte à rebours (inchangée) ---
            function updateCountdown() {
                const countdownElement = document.getElementById("countdown");
                if (!countdownElement) return;

                const eventDate = new Date("{{ \Carbon\Carbon::parse($event->start_date)->toIso8601String() }}").getTime();
                const now = new Date().getTime();
                const distance = eventDate - now;

                const daysEl = document.getElementById("countdown-days");
                const hoursEl = document.getElementById("countdown-hours");
                const minutesEl = document.getElementById("countdown-minutes");
                const secondsEl = document.getElementById("countdown-seconds");

                const statusIconWrapper = document.getElementById("status-icon-wrapper");
                const statusIcon = document.getElementById("status-icon");
                const statusTitle = document.getElementById("status-title");
                const statusDesc = document.getElementById("status-desc");
                // On cible maintenant le bouton submit dans le formulaire s'il existe
                const registerSubmitBtn = document.querySelector("#directRegistrationForm button[type='submit']");

                if (distance < 0) {
                    clearInterval(countdownInterval);
                    if (daysEl) daysEl.textContent = "0";
                    if (hoursEl) hoursEl.textContent = "00";
                    if (minutesEl) minutesEl.textContent = "00";
                    if (secondsEl) secondsEl.textContent = "00";

                    if (statusIconWrapper) statusIconWrapper.style.backgroundColor = "#fef2f2";
                    if (statusIcon) { statusIcon.className = "fas fa-calendar-times"; statusIcon.style.color = "#ef4444"; }
                    if (statusTitle) statusTitle.textContent = "Événement terminé";
                    if (statusDesc) statusDesc.textContent = "Les inscriptions sont closes";

                    // Désactiver le bouton submit s'il existe
                    if (registerSubmitBtn) {
                        registerSubmitBtn.disabled = true;
                        registerSubmitBtn.innerHTML = '<i class="fas fa-calendar-times me-2"></i>Événement terminé';
                        // On pourrait aussi masquer le formulaire entier si souhaité
                        // document.getElementById('directRegistrationForm')?.remove();
                    }

                } else {
                    const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                    const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                    const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                    if (daysEl) daysEl.textContent = days;
                    if (hoursEl) hoursEl.textContent = String(hours).padStart(2, '0');
                    if (minutesEl) minutesEl.textContent = String(minutes).padStart(2, '0');
                    if (secondsEl) secondsEl.textContent = String(seconds).padStart(2, '0');

                    // Statut initial (inchangé ici)
                    if (statusIconWrapper) statusIconWrapper.style.backgroundColor = "#ecfdf5";
                    if (statusIcon) { statusIcon.className = "fas fa-calendar-check"; statusIcon.style.color = "#10b981"; }
                    if (statusTitle) statusTitle.textContent = "Événement à venir";
                    if (statusDesc) statusDesc.textContent = "Inscrivez-vous dès maintenant";
                }
            }

            const countdownContainer = document.getElementById("countdown");
            let countdownInterval;
            if (countdownContainer) {
                updateCountdown();
                countdownInterval = setInterval(updateCountdown, 1000);
            } else {
                 const eventDate = new Date("{{ \Carbon\Carbon::parse($event->start_date)->toIso8601String() }}").getTime();
                 if (eventDate < new Date().getTime()) {
                    updateCountdown();
                 }
            }

            // --- Fermeture automatique des messages Flash (inchangé) ---
            setTimeout(() => {
                const flashMessages = document.querySelectorAll('.flash-message');
                flashMessages.forEach(msg => {
                    if (typeof bootstrap !== 'undefined' && bootstrap.Alert) {
                        const alertInstance = bootstrap.Alert.getOrCreateInstance(msg);
                        if(alertInstance) {
                            alertInstance.close();
                        } else {
                            msg.style.transition = 'opacity 0.5s ease';
                            msg.style.opacity = '0';
                            setTimeout(() => msg.remove(), 500);
                        }
                    } else {
                        msg.style.transition = 'opacity 0.5s ease';
                        msg.style.opacity = '0';
                        setTimeout(() => msg.remove(), 500);
                    }
                });
            }, 7000);

            // --- PLUS BESOIN DE LA LOGIQUE POUR REOUVRIR LE MODAL ---

        }); // Fin de DOMContentLoaded
    </script>
@endpush