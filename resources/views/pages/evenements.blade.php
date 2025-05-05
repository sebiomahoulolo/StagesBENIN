@extends('layouts.layout')

@section('title', 'StagesBENIN')

@section('content')

@php
    // Récupération des événements publiés uniquement
    $upcomingEvents = App\Models\Event::where('is_published', 1)
                                     ->where('start_date', '>', now())
                                     ->orderBy('start_date', 'asc')
                                     ->take(6)
                                     ->get();
    
    $ongoingEvents = App\Models\Event::where('is_published', 1)
                                    ->where('start_date', '<=', now())
                                    ->where('end_date', '>=', now())
                                    ->orderBy('end_date', 'asc')
                                    ->take(6)
                                    ->get();

    $pastEvents = App\Models\Event::where('is_published', 1)
                                 ->where('end_date', '<', now())
                                 ->orderBy('end_date', 'desc')
                                 ->take(6)
                                 ->get();
    
    $formatDate = function($date) {
        return \Carbon\Carbon::parse($date)->format('d/m/Y à H:i');
    };

    $currentDate = now()->format('d/m/Y à H:i');
@endphp
 

<div class="events-container">
    <div class="current-date">
        <i class="fas fa-calendar-day"></i> Aujourd'hui: {{ $currentDate }}
    </div>



    <div class="events-section events-upcoming">
        <h2><i class="fas fa-calendar-alt text-primary"></i> Événements à venir ({{ $upcomingEvents->count() }})</h2>
        
        @if($upcomingEvents->count() > 0)
            <div class="events-list">
                @foreach ($upcomingEvents as $event)
                    <div class="event-card">
                        <div class="event-title">{{ $event->title }}</div>
                        <div class="event-date">
                            <i class="fas fa-clock"></i> {{ $formatDate($event->start_date) }}
                        <div class="event-categorie">{{ $event->categorie }}</div>
                        </div>  
                        @if(isset($event->location) && $event->location)
                            <div class="event-location">
                                <i class="fas fa-map-marker-alt"></i> {{ $event->location }}
                            </div>
                        @endif
                        <div class="event-countdown">
                            @php
                                $daysUntil = now()->diffInDays(\Carbon\Carbon::parse($event->start_date), false);
                            @endphp
                            @if($daysUntil == 0)
                                <span class="badge badge-warning">Aujourd'hui</span>
                            @elseif($daysUntil == 1)
                                <span class="badge badge-warning">Demain</span>
                            @else
                                <span class="badge badge-info">Dans {{ $daysUntil }} jours</span>
                            @endif

                            <button type="button" class="btn btn-info mt-2" data-bs-toggle="modal" data-bs-target="#detailsModal" 
    data-event-id="{{ $event->id }}" 
    data-title="{{ $event->title }}" 
    data-date="{{ $formatDate($event->start_date) }}" 
    data-location="{{ $event->location }}"
    data-description="{{ $event->description }}">
    Voir
</button>

                        </div>
                        <button type="button" class=" btn btn-primary mt-2" data-bs-toggle="modal" data-bs-target="#registerModal" data-event-id="{{ $event->id }}">
    S'inscrire
</button>

                    </div>
                @endforeach
            </div>
        @else
            <div class="no-events">Aucun événement à venir</div>
        @endif
    </div>




    <div class="events-section events-ongoing">
        <h2><i class="fas fa-play-circle text-primary"></i> Événements en cours ({{ $ongoingEvents->count() }})</h2>
        
        @if($ongoingEvents->count() > 0)
            <div class="events-list highlight">
                @foreach ($ongoingEvents as $event)
                    <div class="event-card active">
                        <div class="event-title">{{ $event->title }}</div>
                        <div class="event-period">
                            <i class="fas fa-hourglass-half"></i> Du {{ $formatDate($event->start_date) }} au {{ $formatDate($event->end_date) }}
                        </div>
                        @if(isset($event->location) && $event->location)
                            <div class="event-location">
                                <i class="fas fa-map-marker-alt "></i> {{ $event->location }}
                            </div>
                        @endif
                        <div class="event-status">
                            <span class="badge badge-success">En cours !</span>
                            @php
                                $hoursLeft = now()->diffInHours(\Carbon\Carbon::parse($event->end_date), false);
                            @endphp
                            @if($hoursLeft < 24)
                                <span class="badge badge-danger">Se termine dans {{ $hoursLeft }} heure(s)</span>
                            @endif
                        </div>
                                             <button type="button" class=" btn btn-primary mt-2" data-bs-toggle="modal" data-bs-target="#registerModal" data-event-id="{{ $event->id }}">
   Consulter
</button>
                    </div>
                @endforeach
            </div>
        @else
            <div class="no-events">Aucun événement en cours</div>
        @endif
    </div>



<div class="events-section events-past">
    <h2><i class="fas fa-history text-primary"></i> Derniers événements ({{ $pastEvents->count() }})</h2>
    
    @if($pastEvents->count() > 0)
        <div class="events-list faded">
            @foreach ($pastEvents as $event)
                <div class="event-card past">
                    <div class="event-title">{{ $event->title }}</div>
                    <div class="event-date">
                        <i class="fas fa-calendar-check"></i> Terminé le {{ $formatDate($event->end_date) }}
                    </div>
                    @if(isset($event->location) && $event->location)
                        <div class="event-location">
                            <i class="fas fa-map-marker-alt"></i> {{ $event->location }}
                        </div>
                    @endif
                    <!-- Ajout du bouton pour chaque événement -->
                    <div class="view-more">
                        <button class="btn btn-primary" data-toggle="modal" data-target="#eventModal-{{ $event->id }}">
                            <i class="fas fa-archive"></i> Voir les archives
                        </button>
                    </div>
                </div>

                <!-- Modale associée à cet événement -->
                <div class="modal fade" id="eventModal-{{ $event->id }}" tabindex="-1" role="dialog" aria-labelledby="eventModalLabel-{{ $event->id }}" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="eventModalLabel-{{ $event->id }}">{{ $event->title }}</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <p>Terminé le : {{ $formatDate($event->end_date) }}</p>
                                @if(isset($event->location))
                                    <p>Lieu : {{ $event->location }}</p>
                                @endif
                                <!-- Ajoutez d'autres détails spécifiques à cet événement ici -->
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="no-events">Aucun événement passé</div>
    @endif
</div>



<!-- Modal Détails de l'Événement -->
<div class="modal fade" id="detailsModal" tabindex="-1" aria-labelledby="detailsModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailsModalLabel">Détails de l'Événement</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h4 id="eventTitle"></h4>
                <p><strong>Date :</strong> <span id="eventDate"></span></p>
                <p><strong>Lieu :</strong> <span id="eventLocation"></span></p>
                <p><strong>Description :</strong></p>
                <p id="eventDescription"></p>

                <!-- Bouton d'inscription -->
                <button type="button" class="btn btn-primary mt-2" data-bs-toggle="modal" data-bs-target="#registerModal">
                    S'inscrire
                </button>
                <button type="button" class="btn btn-primary mt-2" data-bs-toggle="modal" data-bs-target="#registerModal">
                   Acheter un ticket
                </button>
            </div>
        </div>
    </div>
</div>



<!-- Modal d'Inscription -->
<div class="modal fade" id="registerModal" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="registerModalLabel">Inscription à l'événement</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Message de confirmation/erreur -->
                <div id="registerMessage" class="alert" style="display: none;"></div>

                <form id="registerForm">
                    @csrf
                    <input type="hidden" name="event_id" id="event_id">

                    <label for="name">Nom :</label>
                    <input type="text" name="name" id="name" class="form-control" required>

                    <label for="email">Email :</label>
                    <input type="email" name="email" id="email" class="form-control" required>

                    <button type="submit" class="btn btn-primary mt-3">S'inscrire</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    let registerModal = document.getElementById('registerModal');
    let registerMessage = document.getElementById('registerMessage');

    registerModal.addEventListener('show.bs.modal', function (event) {
        let button = event.relatedTarget;
        let eventId = button.getAttribute('data-event-id');
        document.getElementById('event_id').value = eventId;
        registerMessage.style.display = "none"; // Cache les messages au début
    });

    document.getElementById('registerForm').addEventListener('submit', function (event) {
        event.preventDefault();

        let formData = new FormData(this);

        fetch("{{ route('events.register') }}", {
            method: "POST",
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('input[name=_token]').value
            }
        })
        .then(response => response.json())
        .then(data => {
    registerMessage.style.display = "block";
    registerMessage.className = "alert alert-success";
    registerMessage.innerText = "✅ Inscription réussie !";

    
    setTimeout(() => {
        let modalInstance = bootstrap.Modal.getInstance(registerModal);
        modalInstance.hide();
    }, 3000);

        })
        .catch(error => {
            registerMessage.style.display = "block";
            registerMessage.className = "alert alert-danger";
            registerMessage.innerText = "❌ Une erreur est survenue, veuillez réessayer.";
        });
    });
});


document.addEventListener("DOMContentLoaded", function () {
    let detailsModal = document.getElementById('detailsModal');

    detailsModal.addEventListener('show.bs.modal', function (event) {
        let button = event.relatedTarget;

        document.getElementById('eventTitle').innerText = button.getAttribute('data-title');
        document.getElementById('eventDate').innerText = button.getAttribute('data-date');
        document.getElementById('eventLocation').innerText = button.getAttribute('data-location') || "Non spécifié";
        document.getElementById('eventDescription').innerText = button.getAttribute('data-description') || "Pas de description";
    });
});

</script>

<!-- Ajout des fichiers CSS et JS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/6.1.0/main.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/6.1.0/main.min.js"></script>

<style>
    .events-container {
        font-family: 'Roboto', sans-serif;
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
    }
    
    .current-date {
        text-align: right;
        color: #666;
        margin-bottom: 20px;
        font-style: italic;
    }
    
    .events-section {
        margin-bottom: 40px;
        border-radius: 10px;
        padding: 20px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease;
    }
    
    .events-section:hover {
        transform: translateY(-5px);
    }
    
    .events-section h2 {
        color: #333;
        border-bottom: 2px solid #f0f0f0;
        padding-bottom: 10px;
        margin-bottom: 20px;
        font-weight: 600;
    }
    
    .events-upcoming {
        background-color: #f8f9fa;
        border-left: 4px solid #17a2b8;
    }
    
    .events-ongoing {
        background-color: #e8f4ff;
        border-left: 4px solid  #007bff;
    }
    
    .events-past {
        background-color: #f9f9f9;
        border-left: 4px solid #6c757d;
    }
    
    .events-list {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 20px;
    }
    
    .event-card {
        background: white;
        border-radius: 8px;
        padding: 15px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        transition: all 0.3s ease;
        height: 100%;
        display: flex;
        flex-direction: column;
    }
    
    .event-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 6px 12px rgba(0,0,0,0.1);
    }
    
    .event-card.active {
        border-left: 4px solid #007bff;
    }
    
    .event-card.past {
        opacity: 0.7;
    }
    
    .event-title {
        font-size: 18px;
        font-weight: 600;
        margin-bottom: 10px;
        color: #333;
    }
    
    .event-date, .event-location, .event-period, .event-status, .event-countdown {
        margin-top: 8px;
        font-size: 14px;
        color: #666;
    }
    
    .badge {
        display: inline-block;
        padding: 5px 10px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 500;
        margin-left: 5px;
    }
    
    .badge-success {
        background-color: #28a745;
        color: white;
    }
    
    .badge-warning {
        background-color: #ffc107;
        color: #212529;
    }
    
    .badge-info {
        background-color: #17a2b8;
        color: white;
    }
    
    .badge-danger {
        background-color: #dc3545;
        color: white;
    }
    
    .no-events {
        text-align: center;
        padding: 20px;
        color: #999;
        font-style: italic;
    }
    
    .view-more {
        text-align: center;
        margin-top: 20px;
    }
    
    .btn {
        display: inline-block;
        font-weight: 400;
        text-align: center;
        white-space: nowrap;
        vertical-align: middle;
        user-select: none;
        border: 1px solid transparent;
        padding: .375rem .75rem;
        font-size: 1rem;
        line-height: 1.5;
        border-radius: .25rem;
        transition: all .15s ease-in-out;
    }
    
    .btn-outline-secondary {
        color: #6c757d;
        background-color: transparent;
        background-image: none;
        border-color: #6c757d;
    }
    
    .btn-outline-secondary:hover {
        color: #fff;
        background-color: #6c757d;
        border-color: #6c757d;
    }
    
    .calendar-container {
        max-width: 1200px;
        margin: 40px auto;
        padding: 20px;
        background-color: #fff;
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }
    
    .calendar-container h2 {
        color: #333;
        border-bottom: 2px solid #f0f0f0;
        padding-bottom: 10px;
        margin-bottom: 20px;
        font-weight: 600;
    }
    
    #calendar {
        margin-top: 20px;
    }
    
    .event-ongoing {
        background-color:  #007bff !important;
        border-color:  #007bff !important;
        color: white !important;
    }
    
    .event-upcoming {
        background-color: #17a2b8 !important;
        border-color: #17a2b8 !important;
        color: white !important;
    }
    
    .event-past {
        background-color: #6c757d !important;
        border-color: #6c757d !important;
        color: white !important;
        opacity: 0.7;
    }
    
    @media (max-width: 768px) {
        .events-list {
            grid-template-columns: 1fr;
        }
        
        .events-container, .calendar-container {
            padding: 10px;
        }
    }
</style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
@endsection