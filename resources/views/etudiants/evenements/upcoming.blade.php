{{-- /resources/views/etudiants/evenements/upcoming.blade.php --}}

@extends('layouts.etudiant.app')

@section('title', 'StagesBENIN')

@push('styles')
    <style>
        .events-header {
            padding: 1.5rem;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
            margin-bottom: 1.5rem;
            transition: all 0.3s ease;
        }
        
        .events-header:hover {
            box-shadow: 0 6px 20px rgba(0,0,0,0.12);
        }
        
        .events-title {
            color: #2563eb;
            font-size: 1.8rem;
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
        }
        
        .events-title i {
            margin-right: 0.75rem;
        }
        
        .events-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }
        
        .event-card {
            background-color: #fff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
            transition: all 0.3s ease;
            height: 100%;
            display: flex;
            flex-direction: column;
        }
        
        .event-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.12);
        }
        
        .event-image {
            height: 180px;
            overflow: hidden;
            position: relative;
        }
        
        .event-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }
        
        .event-card:hover .event-image img {
            transform: scale(1.05);
        }
        
        .event-date-badge {
            position: absolute;
            top: 15px;
            left: 15px;
            background-color: #2563eb;
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            font-weight: 500;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        
        .event-content {
            padding: 1.5rem;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }
        
        .event-type {
            text-transform: uppercase;
            font-size: 0.8rem;
            font-weight: 600;
            color: #6366f1;
            margin-bottom: 0.5rem;
        }
        
        .event-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 0.75rem;
        }
        
        .event-details {
            margin-bottom: 1rem;
            flex-grow: 1;
        }
        
        .event-detail {
            display: flex;
            align-items: center;
            margin-bottom: 0.5rem;
            color: #4b5563;
        }
        
        .event-detail i {
            width: 20px;
            margin-right: 0.5rem;
            color: #2563eb;
        }
        
        .event-actions {
            margin-top: auto;
        }
        
        .btn-view-event {
            display: inline-block;
            background-color: #2563eb;
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.2s ease;
            width: 100%;
            text-align: center;
        }
        
        .btn-view-event:hover {
            background-color: #1d4ed8;
            transform: translateY(-2px);
        }
        
        .no-events {
            background-color: #fff;
            border-radius: 12px;
            padding: 2rem;
            text-align: center;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
        }
        
        .no-events i {
            font-size: 3rem;
            color: #d1d5db;
            margin-bottom: 1rem;
        }
        
        .no-events h3 {
            font-size: 1.5rem;
            color: #4b5563;
            margin-bottom: 0.5rem;
        }
        
        .no-events p {
            color: #6b7280;
        }

        @media (max-width: 768px) {
            .events-grid {
                grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            }
        }

        @media (max-width: 480px) {
            .events-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
@endpush

@section('content')
    {{-- En-tête de la page --}}
    <div class="events-header animate-fadeInUp">
        <h1 class="events-title">
            <i class="fas fa-calendar-day"></i>
            Événements à venir
        </h1>
        <p>Découvrez tous les événements à venir organisés par StagesBeNIN et nos partenaires.</p>
    </div>

    {{-- Liste des événements --}}
    @if(count($upcomingEvents) > 0)
        <div class="events-grid">
            @foreach($upcomingEvents as $event)
                <div class="event-card animate-fadeInUp" style="animation-delay: {{ $loop->index * 0.1 }}s">
                    <div class="event-image">
                        @if($event->image)
                            <img src="{{ asset('images/events/' . $event->image) }}" alt="{{ $event->title }}">
                        @else
                            <img src="{{ asset('images/event-placeholder.jpg') }}" alt="{{ $event->title }}">
                        @endif
                        <div class="event-date-badge">
                            {{ \Carbon\Carbon::parse($event->start_date)->format('d M Y') }}
                        </div>
                    </div>
                    <div class="event-content">
                        <div class="event-type">{{ $event->type ?? 'Événement' }}</div>
                        <h3 class="event-title">{{ $event->title }}</h3>
                        <div class="event-details">
                            <div class="event-detail">
                                <i class="far fa-clock"></i>
                                <span>{{ \Carbon\Carbon::parse($event->start_date)->format('H:i') }} - {{ \Carbon\Carbon::parse($event->end_date)->format('H:i') }}</span>
                            </div>
                            <div class="event-detail">
                                <i class="fas fa-map-marker-alt"></i>
                                <span>{{ $event->location ?? 'À déterminer' }}</span>
                            </div>
                            @if($event->max_participants)
                                <div class="event-detail">
                                    <i class="fas fa-users"></i>
                                    <span>{{ $event->max_participants }} places disponibles</span>
                                </div>
                            @endif
                            <div class="event-detail">
                                <i class="fas fa-info-circle"></i>
                                <span>{{ Str::limit($event->description, 120) }}</span>
                            </div>
                        </div>
                        <div class="event-actions">
                            <a href="{{ route('etudiants.evenements.show', $event->id) }}" class="btn-view-event">
                                Voir les détails
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="no-events animate-fadeInUp">
            <i class="far fa-calendar-times"></i>
            <h3>Aucun événement à venir pour le moment</h3>
            <p>Revenez bientôt pour découvrir nos prochains événements!</p>
        </div>
    @endif
@endsection 