@extends('layouts.entreprises.master')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Mes Événements</h1>
        <a href="{{ route('entreprises.evenements.create') }}" class="btn btn-primary">
            <i class="fas fa-plus-circle me-2"></i>Créer un événement
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if($events->isEmpty())
        <div class="card">
            <div class="card-body text-center py-5">
                <i class="fas fa-calendar-alt fa-3x text-muted mb-3"></i>
                <h5>Aucun événement</h5>
                <p class="text-muted mb-3">Vous n'avez pas encore créé d'événement.</p>
                <a href="{{ route('entreprises.evenements.create') }}" class="btn btn-primary">
                    Créer mon premier événement
                </a>
            </div>
        </div>
    @else
        <div class="row">
            @foreach($events as $event)
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card h-100">
                        @if($event->image && file_exists(public_path('images/events/' . $event->image)))
                            <img src="{{ asset('images/events/' . $event->image) }}" 
                                 class="card-img-top" 
                                 alt="{{ $event->title }}"
                                 style="height: 200px; object-fit: cover;">
                        @else
                            <div class="bg-light d-flex align-items-center justify-content-center" 
                                 style="height: 200px;">
                                <i class="fas fa-calendar-alt fa-3x text-muted"></i>
                            </div>
                        @endif

                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <h5 class="card-title mb-0">{{ Str::limit($event->title, 50) }}</h5>
                                @if(!$event->is_published)
                                    <span class="badge bg-warning">En attente</span>
                                @else
                                    <span class="badge bg-success">Publié</span>
                                @endif
                            </div>

                            <p class="card-text text-muted mb-2">
                                <i class="fas fa-calendar me-2"></i>
                                {{ \Carbon\Carbon::parse($event->start_date)->format('d/m/Y H:i') }}
                            </p>
                            
                            <p class="card-text text-muted mb-2">
                                <i class="fas fa-map-marker-alt me-2"></i>
                                {{ Str::limit($event->location, 30) }}
                            </p>

                            <p class="card-text mb-3">
                                {{ Str::limit($event->description, 100) }}
                            </p>

                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <i class="fas fa-users me-2 text-muted"></i>
                                    {{ $event->registrations->count() }}
                                    @if($event->max_participants)
                                        / {{ $event->max_participants }}
                                    @endif
                                </div>
                                <div>
                                    <a href="{{ route('entreprises.evenements.edit', $event->id) }}" 
                                       class="btn btn-outline-secondary btn-sm me-2">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="{{ route('entreprises.evenements.show', $event->id) }}" 
                                       class="btn btn-outline-primary btn-sm">
                                        Voir les détails
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="d-flex justify-content-center">
            {{ $events->links() }}
        </div>
    @endif
</div>
@endsection