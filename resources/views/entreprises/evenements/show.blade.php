@extends('layouts.entreprises.master')

@section('content')
<div class="container py-4">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-md-8">
            <!-- Image et informations principales -->
            <div class="card mb-4">
                @if($event->image && file_exists(public_path('images/events/' . $event->image)))
                    <img src="{{ asset('images/events/' . $event->image) }}" 
                         class="card-img-top" 
                         alt="{{ $event->title }}"
                         style="height: 400px; object-fit: cover;">
                @else
                    <div class="bg-light d-flex align-items-center justify-content-center" 
                         style="height: 400px;">
                        <i class="fas fa-calendar-alt fa-4x text-muted"></i>
                    </div>
                @endif
                
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <h1 class="card-title mb-0">{{ $event->title }}</h1>
                        @if(!$event->is_published)
                            <span class="badge bg-warning">En attente de validation</span>
                        @else
                            <span class="badge bg-success">Publié</span>
                        @endif
                    </div>

                    <div class="mb-4">
                        <div class="mb-2">
                            <i class="fas fa-calendar me-2 text-primary"></i>
                            Du {{ \Carbon\Carbon::parse($event->start_date)->format('d/m/Y H:i') }}
                            au {{ \Carbon\Carbon::parse($event->end_date)->format('d/m/Y H:i') }}
                        </div>
                        <div class="mb-2">
                            <i class="fas fa-map-marker-alt me-2 text-primary"></i>
                            {{ $event->location }}
                        </div>
                        <div>
                            <i class="fas fa-tag me-2 text-primary"></i>
                            {{ $event->type ?? 'Non spécifié' }}
                        </div>
                    </div>

                    <h5 class="mb-3">Description</h5>
                    <p class="card-text">{{ $event->description }}</p>
                </div>
            </div>

            <!-- Liste des participants -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Participants ({{ $event->registrations->count() }}
                        @if($event->max_participants)
                            / {{ $event->max_participants }}
                        @endif
                        )</h5>
                </div>
                <div class="card-body">
                    @if($event->registrations->count() > 0)
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Nom</th>
                                        <th>Email</th>
                                        <th>Date d'inscription</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($event->registrations as $registration)
                                        <tr>
                                            <td>{{ $registration->name }}</td>
                                            <td>{{ $registration->email }}</td>
                                            <td>{{ $registration->created_at->format('d/m/Y H:i') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-muted mb-0">Aucune inscription pour le moment.</p>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <!-- Actions -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Actions</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('entreprises.evenements.destroy', $event->id) }}" 
                          method="POST" 
                          onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet événement ? Cette action est irréversible.');">
                        @csrf
                        @method('DELETE')
                        
                        <div class="d-grid gap-2">
                            <a href="{{ route('entreprises.evenements.edit', $event->id) }}" 
                               class="btn btn-primary">
                                <i class="fas fa-edit me-2"></i>Modifier
                            </a>
                            
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-trash-alt me-2"></i>Supprimer
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Statistiques -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Statistiques</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <h6 class="text-muted mb-2">État de l'événement</h6>
                        @if($event->start_date > now())
                            <span class="badge bg-info">À venir</span>
                        @elseif($event->end_date < now())
                            <span class="badge bg-secondary">Terminé</span>
                        @else
                            <span class="badge bg-primary">En cours</span>
                        @endif
                    </div>

                    <div class="mb-3">
                        <h6 class="text-muted mb-2">Taux de remplissage</h6>
                        @if($event->max_participants)
                            @php
                                $percentage = ($event->registrations->count() / $event->max_participants) * 100;
                            @endphp
                            <div class="progress">
                                <div class="progress-bar" 
                                     role="progressbar" 
                                     style="width: {{ $percentage }}%"
                                     aria-valuenow="{{ $percentage }}" 
                                     aria-valuemin="0" 
                                     aria-valuemax="100">
                                    {{ round($percentage) }}%
                                </div>
                            </div>
                        @else
                            <p class="mb-0">Pas de limite de participants</p>
                        @endif
                    </div>

                    <div>
                        <h6 class="text-muted mb-2">Création et mise à jour</h6>
                        <p class="small mb-1">
                            <i class="fas fa-plus-circle me-1"></i>
                            Créé le {{ $event->created_at->format('d/m/Y H:i') }}
                        </p>
                        <p class="small mb-0">
                            <i class="fas fa-edit me-1"></i>
                            Dernière mise à jour le {{ $event->updated_at->format('d/m/Y H:i') }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection