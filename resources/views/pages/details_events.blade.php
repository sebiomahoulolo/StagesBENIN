@extends('layouts.layout')

@section('title', 'StagesBENIN - ' . $event->title)

@section('content')
<style>
    body {
        background-color: #f8f9fa;
        font-family: 'Segoe UI', Arial, sans-serif;
        overflow-x: hidden; /* Prevent horizontal scrollbar during animations */
    }

    .container {
        max-width: 1200px;
    }

    /* Animations */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .animate-fadeInUp {
        opacity: 0; /* Start hidden, JS or animation-fill-mode will make it visible */
        animation: fadeInUp 0.6s ease-out forwards;
    }

    /* En-tête de l'événement */
    .event-header {
        position: relative;
        height: 380px;
        overflow: hidden;
        border-radius: 12px;
        margin-bottom: 3rem;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        margin-top: 2rem;
    }

    .event-header-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        filter: brightness(0.6);
        transition: transform 0.4s ease-out;
    }

    .event-header:hover .event-header-image {
        transform: scale(1.03);
    }

    .event-header-content {
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        padding: 2.5rem;
        color: white;
        background: linear-gradient(to top, rgba(0,0,0,0.9) 0%, rgba(0,0,0,0.6) 40%, rgba(0,0,0,0) 100%);
    }

    .event-type-badge {
        display: inline-block;
        background-color: #0d6efd;
        color: white;
        padding: 0.5rem 0.9rem;
        border-radius: 6px;
        font-size: 0.8rem;
        font-weight: 600;
        margin-bottom: 1rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .event-title {
        font-size: 2.75rem;
        font-weight: 700;
        margin-bottom: 1rem;
        text-shadow: 0 2px 8px rgba(0,0,0,0.5);
    }

    .event-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 1.75rem;
        margin-top: 1rem;
    }

    .event-meta-item {
        display: flex;
        align-items: center;
        color: rgba(255,255,255,0.95);
        font-size: 0.95rem;
        transition: color 0.2s ease-in-out;
    }

    .event-meta-item i {
        margin-right: 0.7rem;
        font-size: 1.15rem;
        opacity: 0.85;
    }

    /* Structure principale */
    .event-container {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 3rem;
        margin-bottom: 3rem;
    }

    .event-details, .event-sidebar {
        background-color: white;
        border-radius: 12px;
        padding: 2.5rem;
        box-shadow: 0 8px 25px rgba(0,0,0,0.08);
    }

    .event-sidebar {
        align-self: start;
        position: sticky;
        top: 100px;
    }

    /* Colonne principale */
    .section-title {
        font-size: 1.5rem;
        font-weight: 600;
        color: #212529;
        margin-bottom: 2rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid #dee2e6;
        display: flex;
        align-items: center;
    }

    .section-title i {
        margin-right: 0.9rem;
        color: #0d6efd;
        font-size: 1.2em;
    }

    .event-description {
        margin-bottom: 3rem;
        line-height: 1.8;
        color: #495057;
        white-space: pre-line;
        font-size: 1.05rem;
    }

    .info-list {
        margin-bottom: 1rem;
    }

    .info-item {
        display: flex;
        align-items: flex-start;
        margin-bottom: 1.75rem;
        transition: background-color 0.2s ease-in-out;
        border-radius: 8px;
        padding: 1.25rem;
    }

    .info-item:not(:last-child) {
         border-bottom: 1px solid #e9ecef;
         margin-bottom: 0;
         padding-bottom: 1.25rem;
    }

    .info-item:last-child {
        margin-bottom: 0;
    }

    .info-item:hover {
        background-color: #f8f9fa;
    }

    .info-icon {
        width: 44px;
        height: 44px;
        background-color: #e7f0ff;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 1.5rem;
        flex-shrink: 0;
    }

    .info-icon i {
        color: #0d6efd;
        font-size: 1.2rem;
    }

    .info-label {
        font-weight: 500;
        color: #6c757d;
        margin-bottom: 0.3rem;
        font-size: 0.9rem;
    }

    .info-value {
        color: #212529;
        font-weight: 600;
        font-size: 1.05rem;
    }

    /* Sidebar */
    .event-status {
        display: flex;
        align-items: center;
        margin-bottom: 2rem;
        padding-bottom: 2rem;
        border-bottom: 1px solid #dee2e6;
    }

    .status-icon-wrapper {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 1.5rem;
        flex-shrink: 0;
        background-color: #d1e7dd; /* Default for 'upcoming' */
        transition: background-color 0.3s ease;
    }

    .status-icon-wrapper i {
        font-size: 1.45rem;
        color: #198754; /* Default for 'upcoming' */
        transition: color 0.3s ease;
    }

    .status-content h4 {
        font-weight: 600;
        color: #212529;
        margin-bottom: 0.3rem;
        font-size: 1.2rem;
    }

    .status-content p {
        color: #6c757d;
        font-size: 0.95rem;
        margin-bottom: 0;
    }

    /* Compte à rebours */
    .countdown-container {
        margin-bottom: 2rem;
        text-align: center;
    }

    .countdown-label {
        font-weight: 500;
        color: #495057;
        margin-bottom: 1rem;
        font-size: 0.95rem;
    }

    .countdown-timer {
        display: flex;
        justify-content: space-around;
        gap: 0.75rem;
    }

    .countdown-item {
        flex: 1;
        padding: 0.85rem 0.3rem;
        background-color: #f0f3f5;
        border-radius: 8px;
        text-align: center;
        transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
    }

    .countdown-item:hover {
        transform: translateY(-3px);
        box-shadow: 0 4px 10px rgba(0,0,0,0.08);
    }

    .countdown-value {
        font-size: 1.75rem;
        font-weight: 700;
        color: #0d6efd;
        margin-bottom: 0.15rem;
        line-height: 1.1;
    }

    .countdown-unit {
        font-size: 0.7rem;
        color: #6c757d;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .event-stat {
        text-align: center;
        margin-bottom: 1.5rem;
        padding: 1rem;
        background-color: #e9ecef;
        border-radius: 8px;
    }

    .event-stat-value {
        font-size: 1.5rem;
        font-weight: 700;
        color: #0d6efd;
    }

    .event-stat-label {
        font-size: 0.85rem;
        color: #6c757d;
        text-transform: uppercase;
    }

    .event-cta {
        margin-top: 1rem;
    }
    .btn-cta {
        display: block;
        background-color: #0d6efd;
        color: white;
        padding: 0.9rem 1.8rem;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 600;
        width: 100%;
        font-size: 1.05rem;
        border: 1px solid #0d6efd;
        cursor: pointer;
        transition: all 0.25s ease-in-out;
        text-align: center;
        box-shadow: 0 2px 8px rgba(13, 110, 253, 0.2);
        margin-bottom: 0.75rem;
    }

    .btn-cta i {
        margin-right: 0.6rem;
    }

    .btn-cta:hover, .btn-cta:focus {
        background-color: #0b5ed7;
        border-color: #0a58ca;
        transform: translateY(-3px) scale(1.01);
        box-shadow: 0 5px 15px rgba(13, 110, 253, 0.35);
        text-decoration: none;
        color: white;
        outline: none;
    }

    .btn-cta:active {
        transform: translateY(-1px) scale(0.99);
        box-shadow: 0 2px 8px rgba(13, 110, 253, 0.25);
    }

    .btn-cta:disabled {
        background-color: #adb5bd;
        border-color: #adb5bd;
        color: #6c757d;
        cursor: not-allowed;
        box-shadow: none;
        transform: none;
    }
    .btn-cta:disabled:hover {
        background-color: #adb5bd;
        border-color: #adb5bd;
        transform: none;
        box-shadow: none;
    }
    .btn-outline-cta {
        background-color: transparent;
        color: #0d6efd;
        border: 1px solid #0d6efd;
    }
    .btn-outline-cta:hover, .btn-outline-cta:focus {
        background-color: #0d6efd;
        color: white;
    }

    .flash-message {
        padding: 1rem 1.5rem;
        margin-bottom: 1.5rem;
        border-radius: 8px;
        font-size: 0.95rem;
        border: 1px solid transparent;
        opacity: 1;
        transition: opacity 0.5s ease;
    }
    .flash-success { background-color: #d1e7dd; color: #0f5132; border-color: #badbcc; }
    .flash-error   { background-color: #f8d7da; color: #842029; border-color: #f5c2c7; }
    .flash-info    { background-color: #cff4fc; color: #055160; border-color: #b6effb; }

    .modal .alert {
        margin-bottom: 15px;
    }
    .modal-body .invalid-feedback {
        display: block;
    }

    @media (max-width: 992px) {
        .event-container {
            grid-template-columns: 1fr;
        }
        .event-sidebar {
            margin-top: 3rem;
            position: static;
            top: auto;
        }
        .event-header {
            height: 320px;
        }
    }

    @media (max-width: 768px) {
        .event-header {
            height: 280px;
            margin-top: 1.5rem;
            margin-bottom: 2rem;
        }
        .event-title {
            font-size: 2rem;
        }
        .event-meta {
            gap: 0.75rem;
            font-size: 0.9rem;
            flex-direction: column;
            align-items: flex-start;
        }
        .event-meta-item {
            margin-bottom: 0.3rem;
        }
        .event-details, .event-sidebar {
            padding: 1.5rem;
        }
        .section-title {
            font-size: 1.3rem;
        }
        .info-item {
            padding: 1rem;
        }
    }

    @media (max-width: 576px) {
        .event-header {
            height: 240px;
        }
        .event-header-content {
            padding: 1.5rem;
        }
        .event-title {
            font-size: 1.75rem;
        }
        .countdown-timer {
            flex-wrap: wrap;
            gap: 0.5rem;
        }
        .countdown-item {
            flex-basis: calc(50% - 0.25rem);
            margin-bottom: 0.5rem;
        }
        .btn-cta {
            padding: 0.8rem 1.5rem;
            font-size: 1rem;
        }
    }
</style>

<div class="container">
    <div class="event-header animate-fadeInUp">
        @if($event->image && file_exists(public_path('images/events/' . $event->image)))
            <img src="{{ asset('images/events/' . $event->image) }}" alt="{{ $event->title }}" class="event-header-image">
        @else
            <img src="{{ asset('images/event-placeholder.jpg') }}" alt="Placeholder Event Image" class="event-header-image">
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

    {{-- Flash Messages & Validation Errors (Page Level for non-AJAX form submissions) --}}
    <div class="row">
        <div class="col-12">
            @if(session('success'))
                <div class="flash-message flash-success animate-fadeInUp" style="animation-delay: 0.1s;">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="flash-message flash-error animate-fadeInUp" style="animation-delay: 0.1s;">{{ session('error') }}</div>
            @endif
            @if(session('info'))
                <div class="flash-message flash-info animate-fadeInUp" style="animation-delay: 0.1s;">{{ session('info') }}</div>
            @endif
            {{-- Show general validation errors for non-AJAX submissions NOT related to the modal. --}}
            @if ($errors->any() && !$errors->hasBag('guestRegistration') && old('form_type') !== 'guest_modal_ajax' && old('form_type') !== 'guest_modal')
                <div class="flash-message flash-error animate-fadeInUp" style="animation-delay: 0.1s;">
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
        <div class="event-details animate-fadeInUp" style="animation-delay: 0.2s;">
            <h2 class="section-title"><i class="fas fa-info-circle"></i> À propos de cet événement</h2>
            <div class="event-description">
                {!! nl2br(e($event->description ?? 'Aucune description fournie.')) !!}
            </div>

            <h2 class="section-title"><i class="fas fa-list-ul"></i> Informations pratiques</h2>
            <div class="info-list">
                <div class="info-item">
                    <div class="info-icon"><i class="far fa-calendar-alt"></i></div>
                    <div>
                        <div class="info-label">Date</div>
                        <div class="info-value">{{ \Carbon\Carbon::parse($event->start_date)->isoFormat('dddd D MMMM YYYY') }}</div>
                    </div>
                </div>
                <div class="info-item">
                    <div class="info-icon"><i class="far fa-clock"></i></div>
                    <div>
                        <div class="info-label">Horaires</div>
                        <div class="info-value">{{ \Carbon\Carbon::parse($event->start_date)->format('H:i') }} - {{ \Carbon\Carbon::parse($event->end_date)->format('H:i') }}</div>
                    </div>
                </div>
                <div class="info-item">
                    <div class="info-icon"><i class="fas fa-map-marker-alt"></i></div>
                    <div>
                        <div class="info-label">Lieu</div>
                        <div class="info-value">{{ $event->location ?? 'À déterminer' }}</div>
                    </div>
                </div>
                @if($event->max_participants)
                <div class="info-item">
                    <div class="info-icon"><i class="fas fa-users"></i></div>
                    <div>
                        <div class="info-label">Capacité</div>
                        <div class="info-value">{{ $event->max_participants }} participants maximum</div>
                    </div>
                </div>
                @endif
                <div class="info-item">
                    <div class="info-icon"><i class="fas fa-tag"></i></div>
                    <div>
                        <div class="info-label">Type</div>
                        <div class="info-value">{{ $event->type ?? 'Général' }}</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="event-sidebar animate-fadeInUp" style="animation-delay: 0.3s;">
            <div class="event-status">
                <div class="status-icon-wrapper" id="status-icon-wrapper">
                     <i class="fas {{ (\Carbon\Carbon::parse($event->start_date)->isPast() || ($event->max_participants > 0 && ($event->participants_count ?? 0) >= $event->max_participants)) ? 'fa-calendar-times' : 'fa-calendar-check' }}" id="status-icon" style="color: {{ (\Carbon\Carbon::parse($event->start_date)->isPast() || ($event->max_participants > 0 && ($event->participants_count ?? 0) >= $event->max_participants)) ? '#ef4444' : '#10b981' }};"></i>
                </div>
                <div class="status-content">
                    <h4 id="status-title">
                        @if(\Carbon\Carbon::parse($event->start_date)->isPast())
                            Événement terminé
                        @elseif($event->max_participants > 0 && ($event->participants_count ?? 0) >= $event->max_participants)
                            Événement complet
                        @else
                            Événement à venir
                        @endif
                    </h4>
                    <p id="status-desc">
                        @if(\Carbon\Carbon::parse($event->start_date)->isPast())
                            Les inscriptions sont closes.
                        @elseif($event->max_participants > 0 && ($event->participants_count ?? 0) >= $event->max_participants)
                            Plus de places disponibles.
                        @else
                            Inscrivez-vous dès maintenant
                        @endif
                    </p>
                </div>
            </div>

           

            @if($event->max_participants)
                <div class="event-stat">
                    {{-- Ensure participants_count is available from your controller (e.g., via withCount('participants')) --}}
                    <div class="event-stat-value" id="event-participants-value">{{ $event->participants_count ?? 0 }}/{{ $event->max_participants }}</div>
                    <div class="event-stat-label">Places réservées</div>
                </div>
            @endif

            <div class="event-cta">
                @php
                    $isEventPast = \Carbon\Carbon::parse($event->start_date)->isPast();
                    $currentParticipants = $event->participants_count ?? 0;
                    $isFull = ($event->max_participants > 0 && $currentParticipants >= $event->max_participants);
                @endphp

                @if ($isEventPast)
                    <button type="button" class="btn-cta" disabled>
                        <i class="fas fa-calendar-times me-2"></i> Événement terminé
                    </button>
                @elseif ($isFull)
                    <button type="button" class="btn-cta" id="mainRegisterButtonDisabled" disabled>
                        <i class="fas fa-users-slash me-2"></i> Complet
                    </button>
                @else
                    @guest
                        <button type="button" class="btn-cta" id="guestRegisterTriggerButton" data-bs-toggle="modal" data-bs-target="#registerModal" data-event-id="{{ $event->id }}">
                            <i class="fas fa-edit me-2"></i> S'inscrire à l'événement
                        </button>
                    @else {{-- Utilisateur connecté --}}
                        <form method="POST" action="{{ route('events.register.store') }}" id="directRegistrationForm">
                            @csrf
                            <input type="hidden" name="event_id" value="{{ $event->id }}">
                            @if(auth()->check()) {{-- Pre-fill for logged-in users --}}
                                <input type="hidden" name="name" value="{{ auth()->user()->name }}">
                                <input type="hidden" name="email" value="{{ auth()->user()->email }}">
                            @endif
                            <button type="submit" class="btn-cta" id="loggedInRegisterButton">
                                <i class="fas fa-edit me-2"></i> S'inscrire à l'événement
                            </button>
                        </form>
                    @endguest
                @endif

                {{-- Ticket Purchase Button --}}
                @if(!$isEventPast && !is_null($event->ticket_price) && $event->ticket_price > 0)
                    <button type="button" class="btn-cta btn-outline-cta" id="buy-ticket-btn-{{ $event->id }}"
                            onclick="downloadTicket({{ $event->id }}, '{{ number_format($event->ticket_price, 0, ',', ' ') }}')">
                        <i class="fas fa-ticket-alt me-2"></i> Acheter un ticket ({{ number_format($event->ticket_price, 0, ',', ' ') }} FCFA)
                    </button>
                @endif
                
<!-- Script JavaScript pour gérer les téléchargements -->
<script>
    function downloadTicket(eventId, ticketPrice) {
        const button = document.getElementById(`buy-ticket-btn-${eventId}`);

        // Vérifier si le bouton existe avant de le manipuler
        if (!button) {
            console.error("Bouton non trouvé pour l'événement ID : " + eventId);
            return;
        }

        // Désactiver le bouton et afficher un message de chargement
        button.innerHTML = 'Préparation du ticket...';
        button.disabled = true;

        // Création d'un lien invisible pour télécharger le ticket
        const link = document.createElement('a');
        link.href = `{{ url("/events") }}/` + eventId + '/generate-ticket';
        link.style.display = 'none';
        document.body.appendChild(link);
        link.click();

        // Restaurer le bouton après un court délai
        setTimeout(() => {
            button.innerHTML = `Acheter un ticket (${ticketPrice} FCFA)`;
            button.disabled = false;
        }, 3000);
    }
</script>
            </div>
        </div>
    </div> {{-- Fin event-container --}}
</div> {{-- Fin container --}}

<!-- Modal d'Inscription (pour les invités) -->
<div class="modal fade" id="registerModal" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="registerModalLabel">Inscription à : {{ $event->title }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="modal-messages-container"></div>

                <form id="guestRegisterForm" class="needs-validation" novalidate>
                    @csrf
                    <input type="hidden" name="event_id" id="modal_event_id" value="{{ $event->id }}">
                    <input type="hidden" name="form_type" value="guest_modal_ajax">

                    <div class="mb-3">
                        <label for="modal_name" class="form-label">Nom complet *</label>
                        <input type="text" name="name" id="modal_name" class="form-control @if($errors->hasBag('guestRegistration') && $errors->guestRegistration->has('name')) is-invalid @endif" value="{{ old('name') }}" required>
                        <div class="invalid-feedback" id="modal_name_error">
                            @if($errors->hasBag('guestRegistration') && $errors->guestRegistration->has('name'))
                                {{ $errors->guestRegistration->first('name') }}
                            @else
                                Veuillez saisir votre nom complet.
                            @endif
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="modal_email" class="form-label">Adresse Email *</label>
                        <input type="email" name="email" id="modal_email" class="form-control @if($errors->hasBag('guestRegistration') && $errors->guestRegistration->has('email')) is-invalid @endif" value="{{ old('email') }}" required>
                         <div class="invalid-feedback" id="modal_email_error">
                             @if($errors->hasBag('guestRegistration') && $errors->guestRegistration->has('email'))
                                {{ $errors->guestRegistration->first('email') }}
                            @else
                                Veuillez saisir une adresse email valide.
                            @endif
                        </div>
                    </div>

                    <button type="submit" id="guestRegisterSubmitButton" class="btn-cta w-100 mt-3">
                        <i class="fas fa-paper-plane me-2"></i> Confirmer l'inscription
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    let countdownInterval;
    const eventStartDateString = "{{ \Carbon\Carbon::parse($event->start_date)->toIso8601String() }}";

    // --- DOM Elements ---
    const countdownElement = document.getElementById("countdown");
    const daysEl = document.getElementById("countdown-days");
    const hoursEl = document.getElementById("countdown-hours");
    const minutesEl = document.getElementById("countdown-minutes");
    const secondsEl = document.getElementById("countdown-seconds");

    const statusIconWrapper = document.getElementById("status-icon-wrapper");
    const statusIcon = document.getElementById("status-icon");
    const statusTitleEl = document.getElementById("status-title");
    const statusDescEl = document.getElementById("status-desc");

    const guestRegisterTriggerBtn = document.getElementById('guestRegisterTriggerButton');
    const loggedInRegisterBtn = document.getElementById('loggedInRegisterButton'); // From direct form
    const mainRegisterButtonDisabled = document.getElementById('mainRegisterButtonDisabled'); // The "Complet" button

    const participantsValueEl = document.getElementById('event-participants-value');

    // Modal elements
    const guestRegisterForm = document.getElementById('guestRegisterForm');
    const registerModalElement = document.getElementById('registerModal');
    const modalMessagesContainer = document.getElementById('modal-messages-container');
    const modalEventIdInput = document.getElementById('modal_event_id');
    const modalNameInput = document.getElementById('modal_name');
    const modalEmailInput = document.getElementById('modal_email');
    const modalNameError = document.getElementById('modal_name_error');
    const modalEmailError = document.getElementById('modal_email_error');
    const guestRegisterSubmitButton = document.getElementById('guestRegisterSubmitButton');
    let bsModalInstance = null;
    if (registerModalElement) {
        bsModalInstance = new bootstrap.Modal(registerModalElement);
    }


    function updateCountdown() {
        if (!countdownElement) return;
        const eventDate = new Date(eventStartDateString).getTime();
        const now = new Date().getTime();
        const distance = eventDate - now;

        if (distance < 0) {
            clearInterval(countdownInterval);
            if (daysEl) daysEl.textContent = "0";
            if (hoursEl) hoursEl.textContent = "00";
            if (minutesEl) minutesEl.textContent = "00";
            if (secondsEl) secondsEl.textContent = "00";

            // Update status if not already reflecting 'Terminé'
            if (statusTitleEl && statusTitleEl.textContent.trim() !== "Événement terminé") {
                if (statusIconWrapper) statusIconWrapper.style.backgroundColor = "#fef2f2";
                if (statusIcon) {
                    statusIcon.className = "fas fa-calendar-times";
                    statusIcon.style.color = "#ef4444";
                }
                statusTitleEl.textContent = "Événement terminé";
                if (statusDescEl) statusDescEl.textContent = "Les inscriptions sont closes.";
                disableAllRegistrationActions("Événement terminé");
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
        }
    }

    if (countdownElement) {
        updateCountdown();
        countdownInterval = setInterval(updateCountdown, 1000);
    }

    setTimeout(() => {
        document.querySelectorAll('.flash-message').forEach(msg => {
            msg.style.opacity = '0';
            setTimeout(() => msg.remove(), 500);
        });
    }, 7000);


    if (registerModalElement) {
        registerModalElement.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            if (button) {
                const eventId = button.getAttribute('data-event-id');
                if (modalEventIdInput && eventId) modalEventIdInput.value = eventId;
            }
            clearModalFormAndMessages();
        });
    }

    function clearModalFormAndMessages() {
        if (guestRegisterForm) {
            guestRegisterForm.reset();
            guestRegisterForm.classList.remove('was-validated');
        }
        if (modalMessagesContainer) modalMessagesContainer.innerHTML = '';
        if (modalNameInput) modalNameInput.classList.remove('is-invalid');
        if (modalEmailInput) modalEmailInput.classList.remove('is-invalid');

        if (modalNameError) modalNameError.textContent = 'Veuillez saisir votre nom complet.';
        if (modalEmailError) modalEmailError.textContent = 'Veuillez saisir une adresse email valide.';

        if (guestRegisterSubmitButton) {
            guestRegisterSubmitButton.disabled = false;
            guestRegisterSubmitButton.innerHTML = '<i class="fas fa-paper-plane me-2"></i> Confirmer l\'inscription';
        }
    }

    if (guestRegisterForm) {
        guestRegisterForm.addEventListener('submit', function(e) {
            e.preventDefault();
            if (!this.checkValidity()) {
                this.classList.add('was-validated');
                return;
            }
            this.classList.add('was-validated');

            const formData = new FormData(this);
            const submitButtonOriginalText = guestRegisterSubmitButton.innerHTML;
            guestRegisterSubmitButton.disabled = true;
            guestRegisterSubmitButton.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Inscription...';
            if (modalMessagesContainer) modalMessagesContainer.innerHTML = '';

            fetch("{{ route('events.register.store') }}", {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                }
            })
            .then(response => response.json().then(data => ({ status: response.status, body: data })))
            .then(({ status, body }) => {
                guestRegisterSubmitButton.disabled = false;
                guestRegisterSubmitButton.innerHTML = submitButtonOriginalText;

                if (modalNameInput) modalNameInput.classList.remove('is-invalid');
                if (modalEmailInput) modalEmailInput.classList.remove('is-invalid');
                if (modalNameError) modalNameError.textContent = 'Veuillez saisir votre nom complet.';
                if (modalEmailError) modalEmailError.textContent = 'Veuillez saisir une adresse email valide.';

                if (status >= 200 && status < 300 && body.type === 'success') {
                    if (modalMessagesContainer) modalMessagesContainer.innerHTML = `<div class="alert alert-success"><i class="fas fa-check-circle me-2"></i> ${body.message}</div>`;
                    if (guestRegisterForm) {
                        guestRegisterForm.reset();
                        guestRegisterForm.classList.remove('was-validated');
                    }

                    if (participantsValueEl && typeof body.new_participants_count !== 'undefined' && body.max_participants) {
                        participantsValueEl.textContent = `${body.new_participants_count}/${body.max_participants}`;
                        if (body.new_participants_count >= body.max_participants) {
                            updatePageStatusToFull();
                            disableAllRegistrationActions("Complet");
                        }
                    }
                    setTimeout(() => {
                        if (bsModalInstance) bsModalInstance.hide();
                    }, 3000);

                } else if (status === 422 && body.errors) {
                    let errorMessagesHtml = '<ul class="mb-0 list-unstyled">';
                    if (body.errors.name) {
                        if (modalNameInput) modalNameInput.classList.add('is-invalid');
                        if (modalNameError) modalNameError.textContent = body.errors.name[0];
                        errorMessagesHtml += `<li>${body.errors.name[0]}</li>`;
                    }
                    if (body.errors.email) {
                        if (modalEmailInput) modalEmailInput.classList.add('is-invalid');
                        if (modalEmailError) modalEmailError.textContent = body.errors.email[0];
                        errorMessagesHtml += `<li>${body.errors.email[0]}</li>`;
                    }
                    if (body.errors.event_id) { errorMessagesHtml += `<li>${body.errors.event_id[0]}</li>`; }
                    errorMessagesHtml += '</ul>';
                    if (modalMessagesContainer) modalMessagesContainer.innerHTML = `<div class="alert alert-danger">${errorMessagesHtml}</div>`;
                } else {
                    if (modalMessagesContainer) modalMessagesContainer.innerHTML = `<div class="alert alert-danger">${body.message || 'Une erreur est survenue. Veuillez réessayer.'}</div>`;
                    if (status === 403 || (body.message && (body.message.toLowerCase().includes("complet") || body.message.toLowerCase().includes("terminé")))) {
                        updatePageStatusToFull(body.message.toLowerCase().includes("terminé") ? "Événement terminé" : "Événement complet");
                        disableAllRegistrationActions(body.message.toLowerCase().includes("terminé") ? "Événement terminé" : "Complet");
                    }
                }
            })
            .catch(error => {
                console.error('Fetch Error:', error);
                guestRegisterSubmitButton.disabled = false;
                guestRegisterSubmitButton.innerHTML = submitButtonOriginalText;
                if (modalMessagesContainer) modalMessagesContainer.innerHTML = `<div class="alert alert-danger">Erreur de communication. Vérifiez votre connexion et réessayez.</div>`;
            });
        });
    }

    function updatePageStatusToFull(title = "Événement complet", desc = "Plus de places disponibles.") {
        if (statusTitleEl) statusTitleEl.textContent = title;
        if (statusDescEl) statusDescEl.textContent = desc;
        if (statusIconWrapper) statusIconWrapper.style.backgroundColor = "#f8d7da"; // Light red for full/error
        if (statusIcon) {
            statusIcon.className = "fas fa-users-slash"; // Or fa-calendar-times if appropriate
            statusIcon.style.color = "#842029"; // Dark red
        }
    }

    function disableAllRegistrationActions(reasonText = "Complet") {
        const iconClass = reasonText === "Complet" ? "fa-users-slash" : "fa-calendar-times";
        const newButtonState = `<i class="fas ${iconClass} me-2"></i> ${reasonText}`;

        if (guestRegisterTriggerBtn && !guestRegisterTriggerBtn.disabled) {
            guestRegisterTriggerBtn.disabled = true;
            guestRegisterTriggerBtn.innerHTML = newButtonState;
        }
        if (loggedInRegisterBtn && !loggedInRegisterBtn.disabled) { // This is the submit button of the direct form
            loggedInRegisterBtn.disabled = true;
            loggedInRegisterBtn.innerHTML = newButtonState;
        }
        if (mainRegisterButtonDisabled && !mainRegisterButtonDisabled.disabled) {
             mainRegisterButtonDisabled.disabled = true;
             mainRegisterButtonDisabled.innerHTML = newButtonState;
        }
        if (guestRegisterSubmitButton && !guestRegisterSubmitButton.disabled) { // Modal submit
            guestRegisterSubmitButton.disabled = true;
             // guestRegisterSubmitButton.innerHTML = newButtonState; // Optionally change modal button text too
        }
    }

    // If page reloaded with non-AJAX validation errors for the modal
    @if ($errors->hasBag('guestRegistration') && (old('form_type') === 'guest_modal' || old('form_type') === 'guest_modal_ajax') && !$errors->isEmpty())
        if (bsModalInstance) {
            bsModalInstance.show();
        }
    @endif

    // Standard Bootstrap validation enabling
    document.querySelectorAll('.needs-validation').forEach(form => {
        form.addEventListener('submit', function (event) {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
            form.classList.add('was-validated');
        }, false);
    });

    // Make downloadTicket globally accessible
    window.downloadTicket = function(eventId, ticketPrice) {
        const button = document.getElementById(`buy-ticket-btn-${eventId}`);
        if (!button) {
            console.error("Button not found for event ID: " + eventId);
            return;
        }
        const originalButtonText = button.innerHTML;
        button.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Préparation...';
        button.disabled = true;

        const link = document.createElement('a');
        link.href = `{{ url("/events") }}/${eventId}/generate-ticket`;
        link.setAttribute('download', `ticket-event-${eventId}.pdf`);
        link.style.display = 'none';
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);

        setTimeout(() => {
            button.innerHTML = originalButtonText;
            button.disabled = false;
        }, 3000);
    }
});
</script>
@endpush