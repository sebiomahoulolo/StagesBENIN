{{-- /resources/views/etudiants/evenements/show.blade.php --}}

@extends('layouts.etudiant.app') {{-- Assurez-vous que ce layout charge Bootstrap JS/CSS --}}

@section('title', $event->title . ' - StagesBENIN')

@push('styles')
    <style>
        .event-header {
            position: relative;
            height: 300px;
            overflow: hidden;
            border-radius: 12px;
            margin-bottom: 2rem;
            box-shadow: 0 4px 20px rgba(0,0,0,0.15);
            margin-top: 2rem; /* Ajusté pour l'espace */
        }

        /* Téléphones et petites tablettes */
        @media (max-width: 768px) {
            .event-header {
                height: 250px;
                margin-top: 1rem; /* Moins d'espace sur petit écran */
            }
            .event-title {
                 font-size: 1.75rem !important;
            }
             .event-meta {
                 gap: 0.75rem !important;
                 font-size: 0.85rem !important;
             }
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
            padding: 1.5rem; /* Ajusté */
            background: linear-gradient(to top, rgba(0,0,0,0.8), rgba(0,0,0,0));
            color: white;
        }

        .event-type-badge {
            display: inline-block;
            background-color: #2563eb;
            color: white;
            padding: 0.4rem 0.75rem;
            border-radius: 6px;
            font-size: 0.8rem; /* Ajusté */
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
            font-size: 0.9rem; /* Ajusté */
        }

        .event-meta-item i {
            margin-right: 0.5rem;
            font-size: 1rem; /* Ajusté */
        }

        .event-container {
            display: grid;
            grid-template-columns: 2fr 1fr; /* Ratio ajusté */
            gap: 2rem;
        }

        @media (max-width: 992px) { /* Ajusté le breakpoint */
            .event-container {
                grid-template-columns: 1fr;
            }
             .event-sidebar {
                 margin-top: 2rem; /* Espace quand la sidebar passe dessous */
             }
        }

        .event-details, .event-sidebar {
            background-color: white;
            border-radius: 12px;
            padding: 1.5rem; /* Consistant */
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
        }
         .event-sidebar {
             align-self: start;
             position: sticky;
             top: 80px; /* Ajuster selon hauteur de votre navbar */
         }

        .event-description {
            margin-bottom: 2rem;
            line-height: 1.7; /* Améliore lisibilité */
            color: #4b5563;
            white-space: pre-line; /* Conserve les retours à la ligne */
        }

        .event-section-title {
            font-size: 1.3rem; /* Ajusté */
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 1.5rem; /* Espace après titre */
            padding-bottom: 0.75rem;
            border-bottom: 1px solid #e5e7eb;
        }

        .event-section-title i {
            margin-right: 0.75rem;
            color: #2563eb;
        }

        .event-info-list {
            margin-bottom: 1rem; /* Réduit */
        }

        .event-info-item {
            display: flex;
            margin-bottom: 1.25rem; /* Espace */
            padding-bottom: 1.25rem;
            border-bottom: 1px solid #f3f4f6;
            align-items: flex-start; /* Aligner icone en haut */
        }
        .event-info-item:last-child { border-bottom: none; margin-bottom: 0; padding-bottom: 0; }

        .event-info-icon {
            width: 36px; height: 36px; /* Plus petit */
            background-color: #eef2ff; border-radius: 8px; /* Carré arrondi */
            display: flex; align-items: center; justify-content: center;
            margin-right: 1rem; flex-shrink: 0;
        }
        .event-info-icon i { color: #2563eb; font-size: 1rem; } /* Plus petit */
        .event-info-label { font-weight: 500; color: #4b5563; margin-bottom: 0.1rem; font-size: 0.85rem; } /* Ajusté */
        .event-info-value { color: #1f2937; font-weight: 600;} /* Plus visible */

        .event-status { display: flex; align-items: center; margin-bottom: 1.5rem; padding-bottom: 1.5rem; border-bottom: 1px solid #e5e7eb; }
        .event-status-icon { width: 40px; height: 40px; background-color: #ecfdf5; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-right: 1rem; flex-shrink: 0; }
        .event-status-icon i { color: #10b981; font-size: 1.25rem; }
        .event-status-content h4 { font-weight: 600; color: #1f2937; margin-bottom: 0.25rem; font-size: 1.1rem; }
        .event-status-content p { color: #6b7280; font-size: 0.9rem; margin-bottom: 0; }

        .event-cta { text-align: center; margin-top: 1.5rem; }
        .btn-register { display: inline-block; background-color: #2563eb; color: white; padding: 0.75rem 1.5rem; border-radius: 8px; text-decoration: none; font-weight: 500; width: 100%; font-size: 1rem; border: none; cursor: pointer; transition: all 0.2s ease; }
        .btn-register:hover:not(:disabled) { background-color: #1d4ed8; transform: translateY(-2px); box-shadow: 0 4px 10px rgba(37, 99, 235, 0.3); }
        .btn-register:disabled { background-color: #d1d5db !important; color: #6b7280 !important; cursor: not-allowed !important; transform: none !important; box-shadow: none !important; }

        .event-stat { text-align: center; margin-bottom: 1.5rem; }
        .event-stat-value { font-size: 1.75rem; font-weight: 700; color: #1f2937; margin-bottom: 0.25rem; }
        .event-stat-label { color: #6b7280; font-size: 0.85rem; }

        .countdown-container { margin-top: 1.5rem; margin-bottom: 1.5rem; text-align: center; }
        .countdown-label { font-weight: 500; color: #4b5563; margin-bottom: 0.75rem; font-size: 0.9rem; }
        .countdown-timer { display: flex; justify-content: space-around; } /* space-around */
        .countdown-item { flex-basis: 60px; padding: 0.5rem 0; background-color: #f3f4f6; border-radius: 8px; }
        .countdown-value { font-size: 1.25rem; font-weight: 700; color: #2563eb; margin-bottom: 0.1rem; }
        .countdown-unit { font-size: 0.65rem; color: #6b7280; text-transform: uppercase; }

        /* Flash messages */
        .flash-message { padding: 1rem; border-radius: 8px; margin: 0 0 1.5rem 0; text-align: center; border: 1px solid transparent; }
        .flash-success { background-color: #dcfce7; color: #166534; border-color: #bbf7d0; }
        .flash-error { background-color: #fee2e2; color: #991b1b; border-color: #fecaca;}

        /* Modal style */
        .modal-header { border-bottom: 1px solid #dee2e6; }
        .modal-footer { border-top: 1px solid #dee2e6; }
        .modal-body .form-label { font-weight: 500; }
        .modal-body .form-control[readonly] { background-color: #e9ecef; }
    </style>
@endpush

@section('content')
<div class="container"> {{-- Utiliser un container standard pour le padding --}}

    {{-- En-tête de l'événement --}}
    <div class="event-header">
        @if($event->image && file_exists(public_path('images/events/' . $event->image)))
            <img src="{{ asset('images/events/' . $event->image) }}" alt="{{ $event->title }}" class="event-header-image">
        @else
            <img src="{{ asset('images/event-placeholder.jpg') }}" alt="{{ $event->title }}" class="event-header-image"> {{-- Assurez-vous d'avoir une image placeholder --}}
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

    {{-- Messages Flash --}}
    <div class="row">
        <div class="col-12">
            @if(session('success'))
                <div class="flash-message flash-success">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="flash-message flash-error">{{ session('error') }}</div>
            @endif
             {{-- Affichage des erreurs de validation du modal --}}
            @if ($errors->any())
                <div class="flash-message flash-error">
                    <ul class="mb-0" style="list-style: none; padding-left: 0;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
    </div>


    <div class="event-container">
        {{-- Détails de l'événement --}}
        <div class="event-details">
            <h2 class="event-section-title"><i class="fas fa-info-circle"></i> À propos de cet événement</h2>
            <div class="event-description">
                {{ $event->description ?? 'Aucune description fournie.' }}
            </div>

            <h2 class="event-section-title"><i class="fas fa-list-ul"></i> Informations pratiques</h2>
            <div class="event-info-list">
                <div class="event-info-item">
                    <div class="event-info-icon"><i class="far fa-calendar-alt"></i></div>
                    <div class="event-info-content">
                        <div class="event-info-label">Date</div>
                        <div class="event-info-value">{{ \Carbon\Carbon::parse($event->start_date)->isoFormat('dddd D MMMM YYYY') }}</div>
                    </div>
                </div>
                <div class="event-info-item">
                    <div class="event-info-icon"><i class="far fa-clock"></i></div>
                    <div class="event-info-content">
                        <div class="event-info-label">Horaires</div>
                        <div class="event-info-value">{{ \Carbon\Carbon::parse($event->start_date)->format('H:i') }} - {{ \Carbon\Carbon::parse($event->end_date)->format('H:i') }}</div>
                    </div>
                </div>
                <div class="event-info-item">
                    <div class="event-info-icon"><i class="fas fa-map-marker-alt"></i></div>
                    <div class="event-info-content">
                        <div class="event-info-label">Lieu</div>
                        <div class="event-info-value">{{ $event->location ?? 'À déterminer' }}</div>
                    </div>
                </div>
                @if($event->max_participants)
                    <div class="event-info-item">
                        <div class="event-info-icon"><i class="fas fa-users"></i></div>
                        <div class="event-info-content">
                            <div class="event-info-label">Capacité</div>
                            <div class="event-info-value">{{ $event->max_participants }} participants maximum</div>
                        </div>
                    </div>
                @endif
                <div class="event-info-item">
                    <div class="event-info-icon"><i class="fas fa-tag"></i></div>
                    <div class="event-info-content">
                        <div class="event-info-label">Type</div>
                        <div class="event-info-value">{{ $event->type ?? 'Général' }}</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Sidebar --}}
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

            {{-- Compte à rebours --}}
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

            @if($event->max_participants)
                <div class="event-stat">
                    <div class="event-stat-value">{{ $event->current_participants ?? 0 }}/{{ $event->max_participants }}</div>
                    <div class="event-stat-label">Places réservées</div>
                </div>
            @endif

            {{-- Bouton d'inscription / Statut --}}
            <div class="event-cta">
                @php
                    $eventPassed = $event->start_date < now();
                    $isFull = $event->max_participants && ($event->current_participants ?? 0) >= $event->max_participants;
                @endphp

                @if(isset($isRegistered) && $isRegistered)
                    <button class="btn-register" disabled><i class="fas fa-check-circle me-2"></i>Déjà inscrit(e)</button>
                @elseif($eventPassed)
                    <button class="btn-register" disabled><i class="fas fa-times-circle me-2"></i>Inscriptions terminées</button>
                @elseif($isFull)
                     <button class="btn-register" disabled><i class="fas fa-users-slash me-2"></i>Événement complet</button>
                @else
                     {{-- Bouton qui ouvre le modal --}}
                     <button type="button" class="btn-register" data-bs-toggle="modal" data-bs-target="#registerModal">
                         <i class="fas fa-edit me-2"></i> S'inscrire à l'événement
                     </button>
                @endif
            </div>
        </div>
    </div> {{-- Fin event-container --}}

</div> {{-- Fin container --}}


{{-- Modal d'inscription --}}
<div class="modal fade" id="registerModal" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered"> {{-- Centrer verticalement --}}
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="registerModalLabel">
            <i class="fas fa-edit me-2"></i> Confirmer votre inscription
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      {{-- Le formulaire pointe vers la bonne route --}}
      <form action="{{ route('etudiants.evenements.register', $event->id) }}" method="POST">
          @csrf
          <div class="modal-body">
            <p class="mb-3">Veuillez confirmer vos informations pour l'inscription à l'événement : <br><strong>{{ $event->title }}</strong></p>

            {{-- Champ Nom (pré-rempli et readonly) --}}
            <div class="mb-3">
              <label for="modal_name" class="form-label">Nom complet</label>
              <input type="text" class="form-control" id="modal_name" name="name" value="{{ Auth::user()->name ?? '' }}" required readonly>
              <small class="form-text text-muted">Ce nom sera utilisé pour votre inscription.</small>
            </div>

            {{-- Champ Email (pré-rempli et readonly) --}}
            <div class="mb-3">
              <label for="modal_email" class="form-label">Adresse Email</label>
              <input type="email" class="form-control" id="modal_email" name="email" value="{{ Auth::user()->email ?? '' }}" required readonly>
               <small class="form-text text-muted">Utilisé pour la confirmation et les communications.</small>
            </div>

          </div>
          <div class="modal-footer justify-content-between"> {{-- Aligner les boutons --}}
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                <i class="fas fa-times me-1"></i> Annuler
            </button>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-check me-1"></i> Confirmer l'inscription
            </button>
          </div>
      </form>
    </div>
  </div>
</div>
@endsection

@push('scripts')
    <script>
        // Fonction de compte à rebours
        function updateCountdown() {
            // Utiliser directement la date PHP formatée pour JS si possible
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
            const registerBtn = document.querySelector(".btn-register:not([disabled])"); // Cible le bouton non désactivé

            if (distance < 0) {
                clearInterval(countdownInterval);
                if (daysEl) daysEl.textContent = "0";
                if (hoursEl) hoursEl.textContent = "0";
                if (minutesEl) minutesEl.textContent = "0";
                if (secondsEl) secondsEl.textContent = "0";

                // Mise à jour du statut visuel si l'événement est passé
                if (statusIconWrapper) statusIconWrapper.style.backgroundColor = "#fef2f2"; // Rouge clair
                if (statusIcon) statusIcon.className = "fas fa-clock"; // Icône horloge
                if (statusIcon) statusIcon.style.color = "#ef4444"; // Rouge
                if (statusTitle) statusTitle.textContent = "Événement terminé";
                if (statusDesc) statusDesc.textContent = "Les inscriptions sont closes";

                // Désactiver le bouton d'inscription s'il existe et n'est pas déjà désactivé
                if (registerBtn) {
                     registerBtn.disabled = true;
                     registerBtn.innerHTML = '<i class="fas fa-times-circle me-2"></i>Inscriptions terminées';
                }

            } else {
                // Calcul des jours, heures, minutes et secondes
                const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                // Mise à jour des éléments HTML (vérifier s'ils existent)
                if (daysEl) daysEl.textContent = days;
                if (hoursEl) hoursEl.textContent = String(hours).padStart(2, '0'); // Ajouter 0 devant si besoin
                if (minutesEl) minutesEl.textContent = String(minutes).padStart(2, '0');
                if (secondsEl) secondsEl.textContent = String(seconds).padStart(2, '0');
            }
        }

        // Vérifier si le conteneur du compte à rebours existe avant de lancer
        const countdownContainer = document.getElementById("countdown");
        let countdownInterval;
        if (countdownContainer) {
            updateCountdown(); // Appel initial
            countdownInterval = setInterval(updateCountdown, 1000); // Mise à jour chaque seconde
        } else {
             // Si pas de compte à rebours (événement passé?), mettre à jour le statut immédiatement
             const eventDate = new Date("{{ \Carbon\Carbon::parse($event->start_date)->toIso8601String() }}").getTime();
             if (eventDate < new Date().getTime()) {
                 updateCountdown(); // Appel unique pour mettre à jour le statut si passé
             }
        }

         // Optionnel : Fermer les messages flash après quelques secondes
        setTimeout(() => {
            const flashMessages = document.querySelectorAll('.flash-message');
            flashMessages.forEach(msg => {
                // Option pour une transition douce
                msg.style.transition = 'opacity 0.5s ease';
                msg.style.opacity = '0';
                setTimeout(() => msg.remove(), 500); // Supprimer après la transition
            });
        }, 5000); // Disparaît après 5 secondes


    </script>
@endpush