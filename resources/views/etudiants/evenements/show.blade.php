{{-- /resources/views/etudiants/evenements/show.blade.php --}}

@extends('layouts.etudiant.app')

@section('title', 'StagesBENIN')

@push('styles')
    <style>
        .event-header {
            position: relative;
            height: 300px;
            overflow: hidden;
            border-radius: 12px;
            margin-bottom: 2rem;
            box-shadow: 0 4px 20px rgba(0,0,0,0.15);
        }
        
        .event-header-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            filter: brightness(0.7);
        }
        
        .event-header-content {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            padding: 2rem;
            background: linear-gradient(to top, rgba(0,0,0,0.8), rgba(0,0,0,0));
            color: white;
        }
        
        .event-type-badge {
            display: inline-block;
            background-color: #2563eb;
            color: white;
            padding: 0.4rem 0.75rem;
            border-radius: 6px;
            font-size: 0.85rem;
            font-weight: 500;
            margin-bottom: 0.75rem;
            text-transform: uppercase;
        }
        
        .event-title {
            font-size: 2.25rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            text-shadow: 0 2px 4px rgba(0,0,0,0.3);
        }
        
        .event-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 1.5rem;
            margin-top: 1rem;
        }
        
        .event-meta-item {
            display: flex;
            align-items: center;
            color: rgba(255,255,255,0.9);
            font-size: 0.95rem;
        }
        
        .event-meta-item i {
            margin-right: 0.5rem;
            font-size: 1.1rem;
        }
        
        .event-container {
            display: grid;
            grid-template-columns: 3fr 1fr;
            gap: 2rem;
        }
        
        @media (max-width: 768px) {
            .event-container {
                grid-template-columns: 1fr;
            }
        }
        
        .event-details {
            background-color: white;
            border-radius: 12px;
            padding: 2rem;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
        }
        
        .event-description {
            margin-bottom: 2rem;
            line-height: 1.6;
            color: #4b5563;
            white-space: pre-line;
        }
        
        .event-section-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 1rem;
            padding-bottom: 0.75rem;
            border-bottom: 1px solid #e5e7eb;
        }
        
        .event-section-title i {
            margin-right: 0.75rem;
            color: #2563eb;
        }
        
        .event-info-list {
            margin-bottom: 2rem;
        }
        
        .event-info-item {
            display: flex;
            margin-bottom: 1rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid #f3f4f6;
        }
        
        .event-info-item:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }
        
        .event-info-icon {
            width: 40px;
            height: 40px;
            background-color: #eef2ff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 1rem;
            flex-shrink: 0;
        }
        
        .event-info-icon i {
            color: #2563eb;
            font-size: 1.1rem;
        }
        
        .event-info-content {
            flex-grow: 1;
        }
        
        .event-info-label {
            font-weight: 600;
            color: #374151;
            margin-bottom: 0.25rem;
        }
        
        .event-info-value {
            color: #6b7280;
        }
        
        .event-sidebar {
            background-color: white;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
            padding: 1.5rem;
            align-self: start;
            position: sticky;
            top: 20px;
        }
        
        .event-status {
            display: flex;
            align-items: center;
            margin-bottom: 1.5rem;
            padding-bottom: 1.5rem;
            border-bottom: 1px solid #e5e7eb;
        }
        
        .event-status-icon {
            width: 50px;
            height: 50px;
            background-color: #ecfdf5;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 1rem;
            flex-shrink: 0;
        }
        
        .event-status-icon i {
            color: #10b981;
            font-size: 1.5rem;
        }
        
        .event-status-content h4 {
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 0.25rem;
        }
        
        .event-status-content p {
            color: #6b7280;
            font-size: 0.9rem;
        }
        
        .event-cta {
            text-align: center;
            margin-top: 1.5rem;
        }
        
        .btn-register {
            display: inline-block;
            background-color: #2563eb;
            color: white;
            padding: 0.85rem 1.5rem;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 500;
            width: 100%;
            font-size: 1.1rem;
            border: none;
            cursor: pointer;
            transition: all 0.2s ease;
        }
        
        .btn-register:hover {
            background-color: #1d4ed8;
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(37, 99, 235, 0.3);
        }
        
        .btn-register.registered {
            background-color: #d1d5db;
            color: #4b5563;
            cursor: default;
        }
        
        .btn-register.registered:hover {
            transform: none;
            box-shadow: none;
        }
        
        .event-stat {
            text-align: center;
            margin-bottom: 1.5rem;
        }
        
        .event-stat-value {
            font-size: 2rem;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 0.5rem;
        }
        
        .event-stat-label {
            color: #6b7280;
            font-size: 0.9rem;
        }
        
        .countdown-container {
            margin-top: 1.5rem;
            margin-bottom: 1.5rem;
            text-align: center;
        }
        
        .countdown-label {
            font-weight: 600;
            color: #374151;
            margin-bottom: 0.5rem;
        }
        
        .countdown-timer {
            display: flex;
            justify-content: space-between;
        }
        
        .countdown-item {
            flex: 1;
            padding: 0.75rem 0;
            background-color: #f3f4f6;
            border-radius: 8px;
            margin: 0 0.25rem;
        }
        
        .countdown-value {
            font-size: 1.5rem;
            font-weight: 700;
            color: #2563eb;
            margin-bottom: 0.25rem;
        }
        
        .countdown-unit {
            font-size: 0.75rem;
            color: #6b7280;
            text-transform: uppercase;
        }
        
        /* Flash messages */
        .flash-message {
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            text-align: center;
        }
        
        .flash-success {
            background-color: #ecfdf5;
            color: #10b981;
            border: 1px solid #d1fae5;
        }
        
        .flash-error {
            background-color: #fef2f2;
            color: #ef4444;
            border: 1px solid #fee2e2;
        }
    </style>
@endpush

@section('content')
    {{-- Messages Flash --}}
    @if(session('success'))
        <div class="flash-message flash-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="flash-message flash-error">{{ session('error') }}</div>
    @endif

    {{-- En-tête de l'événement --}}
    <div class="event-header">
        @if($event->image)
            <img src="{{ asset('images/events/' . $event->image) }}" alt="{{ $event->title }}" class="event-header-image">
        @else
            <img src="{{ asset('images/event-placeholder.jpg') }}" alt="{{ $event->title }}" class="event-header-image">
        @endif
        <div class="event-header-content">
            <div class="event-type-badge">{{ $event->type ?? 'Événement' }}</div>
            <h1 class="event-title">{{ $event->title }}</h1>
            
            <div class="event-meta">
                <div class="event-meta-item">
                    <i class="far fa-calendar-alt"></i>
                    <span>{{ \Carbon\Carbon::parse($event->start_date)->format('d M Y') }}</span>
                </div>
                <div class="event-meta-item">
                    <i class="far fa-clock"></i>
                    <span>{{ \Carbon\Carbon::parse($event->start_date)->format('H:i') }} - {{ \Carbon\Carbon::parse($event->end_date)->format('H:i') }}</span>
                </div>
                <div class="event-meta-item">
                    <i class="fas fa-map-marker-alt"></i>
                    <span>{{ $event->location ?? 'À déterminer' }}</span>
                </div>
                @if($event->max_participants)
                    <div class="event-meta-item">
                        <i class="fas fa-users"></i>
                        <span>{{ $event->max_participants }} places disponibles</span>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="event-container">
        {{-- Détails de l'événement --}}
        <div class="event-details">
            <h2 class="event-section-title"><i class="fas fa-info-circle"></i>À propos de cet événement</h2>
            <div class="event-description">
                {{ $event->description }}
            </div>

            <h2 class="event-section-title"><i class="fas fa-list-ul"></i>Informations pratiques</h2>
            <div class="event-info-list">
                <div class="event-info-item">
                    <div class="event-info-icon">
                        <i class="far fa-calendar-alt"></i>
                    </div>
                    <div class="event-info-content">
                        <div class="event-info-label">Date</div>
                        <div class="event-info-value">{{ \Carbon\Carbon::parse($event->start_date)->isoFormat('dddd D MMMM YYYY') }}</div>
                    </div>
                </div>
                
                <div class="event-info-item">
                    <div class="event-info-icon">
                        <i class="far fa-clock"></i>
                    </div>
                    <div class="event-info-content">
                        <div class="event-info-label">Horaires</div>
                        <div class="event-info-value">{{ \Carbon\Carbon::parse($event->start_date)->format('H:i') }} - {{ \Carbon\Carbon::parse($event->end_date)->format('H:i') }}</div>
                    </div>
                </div>
                
                <div class="event-info-item">
                    <div class="event-info-icon">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <div class="event-info-content">
                        <div class="event-info-label">Lieu</div>
                        <div class="event-info-value">{{ $event->location ?? 'À déterminer' }}</div>
                    </div>
                </div>
                
                @if($event->max_participants)
                    <div class="event-info-item">
                        <div class="event-info-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="event-info-content">
                            <div class="event-info-label">Capacité</div>
                            <div class="event-info-value">{{ $event->max_participants }} participants maximum</div>
                        </div>
                    </div>
                @endif
                
                <div class="event-info-item">
                    <div class="event-info-icon">
                        <i class="fas fa-tag"></i>
                    </div>
                    <div class="event-info-content">
                        <div class="event-info-label">Type</div>
                        <div class="event-info-value">{{ $event->type ?? 'Événement général' }}</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Sidebar --}}
        <div class="event-sidebar">
            <div class="event-status">
                <div class="event-status-icon">
                    <i class="fas fa-calendar-check"></i>
                </div>
                <div class="event-status-content">
                    <h4>Événement à venir</h4>
                    <p>Inscrivez-vous dès maintenant</p>
                </div>
            </div>

            {{-- Compte à rebours --}}
            <div class="countdown-container">
                <div class="countdown-label">L'événement commence dans:</div>
                <div class="countdown-timer" id="countdown">
                    <div class="countdown-item">
                        <div class="countdown-value" id="countdown-days">-</div>
                        <div class="countdown-unit">jours</div>
                    </div>
                    <div class="countdown-item">
                        <div class="countdown-value" id="countdown-hours">-</div>
                        <div class="countdown-unit">heures</div>
                    </div>
                    <div class="countdown-item">
                        <div class="countdown-value" id="countdown-minutes">-</div>
                        <div class="countdown-unit">min</div>
                    </div>
                    <div class="countdown-item">
                        <div class="countdown-value" id="countdown-seconds">-</div>
                        <div class="countdown-unit">sec</div>
                    </div>
                </div>
            </div>

            @if($event->max_participants)
                <div class="event-stat">
                    <div class="event-stat-value">{{ $event->current_participants ?? 0 }}/{{ $event->max_participants }}</div>
                    <div class="event-stat-label">Places réservées</div>
                </div>
            @endif

            {{-- Formulaire d'inscription --}}
            <div class="event-cta">
                @if(isset($isRegistered) && $isRegistered)
                    <button class="btn-register registered" disabled>Déjà inscrit(e)</button>
                @else
                    <form action="{{ route('etudiants.evenements.register', $event->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn-register">S'inscrire à l'événement</button>
                    </form>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Fonction de compte à rebours
        function updateCountdown() {
            const eventDate = new Date("{{ $event->start_date }}").getTime();
            const now = new Date().getTime();
            const distance = eventDate - now;
            
            // Calcul des jours, heures, minutes et secondes
            const days = Math.floor(distance / (1000 * 60 * 60 * 24));
            const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);
            
            // Mise à jour des éléments HTML
            document.getElementById("countdown-days").textContent = days;
            document.getElementById("countdown-hours").textContent = hours;
            document.getElementById("countdown-minutes").textContent = minutes;
            document.getElementById("countdown-seconds").textContent = seconds;
            
            // Si l'événement est passé
            if (distance < 0) {
                clearInterval(countdownInterval);
                document.getElementById("countdown-days").textContent = "0";
                document.getElementById("countdown-hours").textContent = "0";
                document.getElementById("countdown-minutes").textContent = "0";
                document.getElementById("countdown-seconds").textContent = "0";
                
                // Mise à jour du statut
                const statusIcon = document.querySelector(".event-status-icon i");
                const statusTitle = document.querySelector(".event-status-content h4");
                const statusDesc = document.querySelector(".event-status-content p");
                
                statusIcon.className = "fas fa-clock";
                statusTitle.textContent = "Événement en cours ou terminé";
                statusDesc.textContent = "L'inscription n'est plus disponible";
                
                const registerBtn = document.querySelector(".btn-register");
                if (registerBtn && !registerBtn.classList.contains("registered")) {
                    registerBtn.disabled = true;
                    registerBtn.textContent = "Inscriptions terminées";
                    registerBtn.classList.add("registered");
                }
            }
        }
        
        // Initialisation et mise à jour toutes les secondes
        updateCountdown();
        const countdownInterval = setInterval(updateCountdown, 1000);
    </script>
@endpush 