@extends('layouts.layout')

@section('title', 'StagesBENIN')

@section('content')
<div class="event-detail-container">
    <div class="event-header">
        <div class="event-back">
            <a href="{{ route('events.index') }}" class="btn btn-outline-secondary btn-sm">
                <i class="fas fa-arrow-left"></i> Retour aux événements
            </a>
        </div>
        
        @php
            $isUpcoming = \Carbon\Carbon::parse($event->start_date)->isFuture();
            $isOngoing = \Carbon\Carbon::parse($event->start_date)->isPast() && 
                        ($event->end_date ? \Carbon\Carbon::parse($event->end_date)->isFuture() : false);
            $isPast = $event->end_date ? \Carbon\Carbon::parse($event->end_date)->isPast() : 
                     \Carbon\Carbon::parse($event->start_date)->isPast();
                     
            $statusClass = $isUpcoming ? 'upcoming' : ($isOngoing ? 'ongoing' : 'past');
            $statusText = $isUpcoming ? 'À venir' : ($isOngoing ? 'En cours' : 'Terminé');
            
            $formattedStartDate = \Carbon\Carbon::parse($event->start_date)->format('d/m/Y à H:i');
            $formattedEndDate = $event->end_date ? \Carbon\Carbon::parse($event->end_date)->format('d/m/Y à H:i') : null;
        @endphp
        
        <div class="event-status-badge status-{{ $statusClass }}">
            {{ $statusText }}
        </div>
    </div>

    <div class="event-card">
        <div class="event-title">
            <h1>{{ $event->title }}</h1>
        </div>
        
        <div class="event-meta">
            <div class="event-date">
                <div class="meta-item">
                    <i class="fas fa-calendar-day"></i>
                    <span><strong>Début :</strong> {{ $formattedStartDate }}</span>
                </div>
                
                @if($event->end_date)
                <div class="meta-item">
                    <i class="fas fa-calendar-check"></i>
                    <span><strong>Fin :</strong> {{ $formattedEndDate }}</span>
                </div>
                @else
                <div class="meta-item">
                    <i class="fas fa-calendar-check text-muted"></i>
                    <span class="text-muted"><strong>Fin :</strong> Non définie</span>
                </div>
                @endif
                
                @if($event->location)
                <div class="meta-item">
                    <i class="fas fa-map-marker-alt"></i>
                    <span><strong>Lieu :</strong> {{ $event->location }}</span>
                </div>
                @endif
                
                @if($event->category)
                <div class="meta-item">
                    <i class="fas fa-tag"></i>
                    <span><strong>Catégorie :</strong> 
                        @switch($event->category)
                            @case('meeting')
                                Réunion
                                @break
                            @case('conference')
                                Conférence
                                @break
                            @case('workshop')
                                Atelier
                                @break
                            @case('social')
                                Événement social
                                @break
                            @default
                                {{ $event->category }}
                        @endswitch
                    </span>
                </div>
                @endif
                
                @if($isUpcoming)
                    <div class="meta-item countdown">
                        <i class="fas fa-hourglass-start"></i>
                        <span>
                            @php
                                $daysUntil = now()->diffInDays(\Carbon\Carbon::parse($event->start_date), false);
                                $hoursUntil = now()->diffInHours(\Carbon\Carbon::parse($event->start_date), false) % 24;
                            @endphp
                            
                            @if($daysUntil > 0)
                                <strong>Commence dans :</strong> {{ $daysUntil }} jour(s) et {{ $hoursUntil }} heure(s)
                            @elseif($hoursUntil > 0)
                                <strong>Commence dans :</strong> {{ $hoursUntil }} heure(s)
                            @else
                                <strong>Commence bientôt !</strong>
                            @endif
                        </span>
                    </div>
                @elseif($isOngoing)
                    <div class="meta-item countdown">
                        <i class="fas fa-hourglass-half"></i>
                        <span>
                            @php
                                $daysLeft = now()->diffInDays(\Carbon\Carbon::parse($event->end_date), false);
                                $hoursLeft = now()->diffInHours(\Carbon\Carbon::parse($event->end_date), false) % 24;
                            @endphp
                            
                            @if($daysLeft > 0)
                                <strong>Se termine dans :</strong> {{ $daysLeft }} jour(s) et {{ $hoursLeft }} heure(s)
                            @elseif($hoursLeft > 0)
                                <strong>Se termine dans :</strong> {{ $hoursLeft }} heure(s)
                            @else
                                <strong>Se termine bientôt !</strong>
                            @endif
                        </span>
                    </div>
                @endif
            </div>
        </div>
        
        <div class="event-description">
            <h4>Description</h4>
            <div class="description-content">
                {!! nl2br(e($event->description)) !!}
            </div>
        </div>
        
        <div class="event-actions">
            @if($isUpcoming || $isOngoing)
                <a href="#" class="btn btn-primary" onclick="addToCalendar('{{ $event->title }}', '{{ $event->description }}', '{{ $event->start_date }}', '{{ $event->end_date ?? $event->start_date }}', '{{ $event->location ?? "" }}')">
                    <i class="far fa-calendar-plus"></i> Ajouter à mon agenda
                </a>
                
                @if($isUpcoming)
                    <a href="{{ route('events.participate', $event->id) }}" class="btn btn-success">
                        <i class="fas fa-user-plus"></i> Participer
                    </a>
                @endif
            @endif
            
            @can('update', $event)
                <a href="{{ route('events.edit', $event->id) }}" class="btn btn-warning">
                    <i class="fas fa-edit"></i> Modifier
                </a>
            @endcan
            
            @can('delete', $event)
                <form action="{{ route('events.destroy', $event->id) }}" method="POST" class="d-inline delete-form">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet événement ?')">
                        <i class="fas fa-trash-alt"></i> Supprimer
                    </button>
                </form>
            @endcan
        </div>
        
        @if(isset($event->participants) && count($event->participants) > 0)
            <div class="event-participants">
                <h4>Participants ({{ count($event->participants) }})</h4>
                <div class="participants-list">
                    @foreach($event->participants as $participant)
                        <div class="participant-avatar" title="{{ $participant->name }}">
                            @if($participant->avatar)
                                <img src="{{ $participant->avatar }}" alt="{{ $participant->name }}" />
                            @else
                                <div class="default-avatar">{{ substr($participant->name, 0, 1) }}</div>
                            @endif
                        </div>
                    @endforeach
                    
                    @if(count($event->participants) > 10)
                        <div class="participant-avatar more-participants">
                            +{{ count($event->participants) - 10 }}
                        </div>
                    @endif
                </div>
            </div>
        @endif
    </div>
</div>

<style>
    .event-detail-container {
        max-width: 900px;
        margin: 0 auto;
        padding: 20px;
        font-family: 'Roboto', sans-serif;
    }
    
    .event-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }
    
    .event-back a {
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }
    
    .event-status-badge {
        font-size: 14px;
        font-weight: bold;
        padding: 6px 12px;
        border-radius: 20px;
        text-transform: uppercase;
    }
    
    .status-upcoming {
        background-color: #e3f2fd;
        color: #0d47a1;
    }
    
    .status-ongoing {
        background-color: #e8f5e9;
        color: #1b5e20;
    }
    
    .status-past {
        background-color: #f5f5f5;
        color: #616161;
    }
    
    .event-card {
        background: white;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
        padding: 30px;
    }
    
    .event-title h1 {
        margin: 0 0 20px 0;
        color: #212121;
        font-weight: 700;
        border-bottom: 3px solid #f0f0f0;
        padding-bottom: 15px;
    }
    
    .event-meta {
        background-color: #f9f9f9;
        border-radius: 8px;
        padding: 20px;
        margin-bottom: 30px;
    }
    
    .meta-item {
        display: flex;
        align-items: flex-start;
        margin-bottom: 12px;
    }
    
    .meta-item:last-child {
        margin-bottom: 0;
    }
    
    .meta-item i {
        width: 25px;
        color: #555;
        margin-right: 10px;
        margin-top: 3px;
    }
    
    .countdown {
        margin-top: 15px;
        padding-top: 15px;
        border-top: 1px dashed #ddd;
    }
    
    .countdown i {
        color: #ff9800;
    }
    
    .event-description {
        margin-bottom: 30px;
    }
    
    .event-description h4 {
        font-size: 18px;
        margin-bottom: 15px;
        color: #333;
        font-weight: 600;
    }
    
    .description-content {
        line-height: 1.7;
        color: #555;
        background-color: white;
        padding: 10px 0;
    }
    
    .event-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-bottom: 30px;
    }
    
    .btn {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        font-weight: 500;
        text-decoration: none;
        border-radius: 6px;
        padding: 8px 16px;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    
    .btn-primary {
        background-color: #1976d2;
        color: white;
        border: none;
    }
    
    .btn-primary:hover {
        background-color: #1565c0;
    }
    
    .btn-success {
        background-color: #2e7d32;
        color: white;
        border: none;
    }
    
    .btn-success:hover {
        background-color: #1b5e20;
    }
    
    .btn-warning {
        background-color: #f57c00;
        color: white;
        border: none;
    }
    
    .btn-warning:hover {
        background-color: #e65100;
    }
    
    .btn-danger {
        background-color: #d32f2f;
        color: white;
        border: none;
    }
    
    .btn-danger:hover {
        background-color: #b71c1c;
    }
    
    .btn-outline-secondary {
        background-color: white;
        color: #616161;
        border: 1px solid #bdbdbd;
    }
    
    .btn-outline-secondary:hover {
        background-color: #f5f5f5;
    }
    
    .event-participants h4 {
        font-size: 18px;
        margin-bottom: 15px;
        color: #333;
        font-weight: 600;
    }
    
    .participants-list {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
    }
    
    .participant-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        overflow: hidden;
        background-color: #e0e0e0;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        color: #555;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }
    
    .participant-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .default-avatar {
        font-size: 18px;
        text-transform: uppercase;
    }
    
    .more-participants {
        background-color: #f0f0f0;
        font-size: 12px;
    }
    
    @media (max-width: 768px) {
        .event-title h1 {
            font-size: 24px;
        }
        
        .event-actions {
            flex-direction: column;
        }
        
        .btn {
            width: 100%;
        }
        
        .event-card {
            padding: 20px;
        }
    }
    
    @media (max-width: 480px) {
        .event-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 15px;
        }
    }
</style>

<script>
    function addToCalendar(title, description, startDate, endDate, location) {
        // Format des dates pour Google Calendar
        const formatDate = (date) => {
            return new Date(date).toISOString().replace(/-|:|\.\d+/g, '');
        };
        
        const start = formatDate(startDate);
        const end = formatDate(endDate);
        
        // Création de l'URL Google Calendar
        let url = 'https://calendar.google.com/calendar/render?action=TEMPLATE';
        url += '&text=' + encodeURIComponent(title);
        url += '&dates=' + start + '/' + end;
        url += '&details=' + encodeURIComponent(description);
        
        if (location) {
            url += '&location=' + encodeURIComponent(location);
        }
        
        // Ouverture dans un nouvel onglet
        window.open(url, '_blank');
        
        return false;
    }
    
    // Animation pour la suppression
    document.querySelectorAll('.delete-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            const button = this.querySelector('button[type="submit"]');
            if (confirm('Êtes-vous sûr de vouloir supprimer cet événement ?')) {
                button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Suppression...';
                button.disabled = true;
            } else {
                e.preventDefault();
            }
        });
    });
</script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
@endsection