@extends('layouts.admin.app')

@section('title', 'Détails de la demande d\'employé')

@section('content')
<div class="action-bar mb-4">
    <div class="d-flex align-items-center">
        <a href="{{ route('admin.demande-employes.index') }}" class="btn btn-outline-secondary me-3">
            <i class="fas fa-arrow-left"></i> Retour
        </a>
        <h1 class="dashboard-title mb-0">{{ $demande->titre_poste }}</h1>
    </div>
    <div class="action-buttons">
        <button type="button" class="btn btn-outline-success update-status-btn" 
                data-bs-toggle="modal" 
                data-bs-target="#updateStatusModal" 
                data-demande-id="{{ $demande->id }}"
                data-current-status="{{ $demande->status }}">
            <i class="fas fa-sync-alt"></i> Changer le statut
        </button>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <!-- Information principale -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-info-circle me-2"></i>
                    Informations détaillées
                </h5>
            </div>
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-md-6">
                        <h6 class="text-muted mb-2">Entreprise</h6>
                        <div class="d-flex align-items-center">
                            @if($demande->entreprise->logo_path)
                                <img src="{{ asset($demande->entreprise->logo_path) }}" alt="Logo" class="me-2 rounded-circle" style="width: 40px; height: 40px; object-fit: cover;">
                            @endif
                            <div>
                                <div class="fw-bold">{{ $demande->entreprise->nom }}</div>
                                <div class="text-muted small">{{ $demande->departement }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-muted mb-2">Statut</h6>
                        @switch($demande->status)
                            @case('en_attente')
                                <span class="badge bg-warning">En attente</span>
                                @break
                            @case('active')
                                <span class="badge bg-success">Active</span>
                                @break
                            @case('fermee')
                                <span class="badge bg-danger">Fermée</span>
                                @break
                            @case('archive')
                                <span class="badge bg-secondary">Archivée</span>
                                @break
                        @endswitch
                        @if($demande->urgent)
                            <span class="badge bg-danger ms-2">Urgent</span>
                        @endif
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <h6 class="text-muted mb-2">Type de contrat</h6>
                        <p>{{ $demande->type_contrat }}</p>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-muted mb-2">Lieu de travail</h6>
                        <p>{{ $demande->lieu_travail }}
                            @if($demande->remote_possible)
                                <span class="badge bg-info ms-2">Télétravail possible</span>
                            @endif
                        </p>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <h6 class="text-muted mb-2">Expérience requise</h6>
                        <p>{{ $demande->niveau_experience ?? 'Non spécifié' }}</p>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-muted mb-2">Niveau d'études</h6>
                        <p>{{ $demande->niveau_etudes ?? 'Non spécifié' }}</p>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <h6 class="text-muted mb-2">Nombre de postes</h6>
                        <p>{{ $demande->nombre_postes }}</p>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-muted mb-2">Date limite</h6>
                        <p>{{ $demande->date_limite ? \Carbon\Carbon::parse($demande->date_limite)->format('d/m/Y') : 'Non définie' }}</p>
                    </div>
                </div>

                <div class="mb-4">
                    <h6 class="text-muted mb-2">Description du poste</h6>
                    <div class="p-3 bg-light rounded">
                        {!! nl2br(e($demande->description)) !!}
                    </div>
                </div>

                @if($demande->competences_requises)
                <div class="mb-4">
                    <h6 class="text-muted mb-2">Compétences requises</h6>
                    <div class="p-3 bg-light rounded">
                        {!! nl2br(e($demande->competences_requises)) !!}
                    </div>
                </div>
                @endif

                @if($demande->avantages)
                <div class="mb-4">
                    <h6 class="text-muted mb-2">Avantages</h6>
                    <div class="p-3 bg-light rounded">
                        {!! nl2br(e($demande->avantages)) !!}
                    </div>
                </div>
                @endif

                @if($demande->salaire_min || $demande->salaire_max)
                <div class="mb-4">
                    <h6 class="text-muted mb-2">Rémunération</h6>
                    <p>
                        @if($demande->salaire_min && $demande->salaire_max)
                            {{ number_format($demande->salaire_min, 0, ',', ' ') }} - {{ number_format($demande->salaire_max, 0, ',', ' ') }} {{ $demande->devise_salaire }}
                        @elseif($demande->salaire_min)
                            À partir de {{ number_format($demande->salaire_min, 0, ',', ' ') }} {{ $demande->devise_salaire }}
                        @elseif($demande->salaire_max)
                            Jusqu'à {{ number_format($demande->salaire_max, 0, ',', ' ') }} {{ $demande->devise_salaire }}
                        @endif
                    </p>
                </div>
                @endif
            </div>
        </div>

        <!-- Notes internes -->
        @if($demande->notes_internes)
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-sticky-note me-2"></i>
                    Notes internes
                </h5>
            </div>
            <div class="card-body">
                {!! nl2br(e($demande->notes_internes)) !!}
            </div>
        </div>
        @endif
    </div>

    <div class="col-md-4">
        <!-- Informations de contact -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-address-card me-2"></i>
                    Contact entreprise
                </h5>
            </div>
            <div class="card-body">
                <ul class="list-unstyled mb-0">
                    <li class="mb-3">
                        <i class="fas fa-envelope text-muted me-2"></i>
                        <a href="mailto:{{ $demande->entreprise->email }}">{{ $demande->entreprise->email }}</a>
                    </li>
                    @if($demande->entreprise->telephone)
                    <li class="mb-3">
                        <i class="fas fa-phone text-muted me-2"></i>
                        <a href="tel:{{ $demande->entreprise->telephone }}">{{ $demande->entreprise->telephone }}</a>
                    </li>
                    @endif
                    @if($demande->entreprise->adresse)
                    <li class="mb-3">
                        <i class="fas fa-map-marker-alt text-muted me-2"></i>
                        {{ $demande->entreprise->adresse }}
                    </li>
                    @endif
                    @if($demande->entreprise->site_web)
                    <li>
                        <i class="fas fa-globe text-muted me-2"></i>
                        <a href="{{ $demande->entreprise->site_web }}" target="_blank">Site web</a>
                    </li>
                    @endif
                </ul>
            </div>
        </div>

        <!-- Métadonnées -->
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-clock me-2"></i>
                    Métadonnées
                </h5>
            </div>
            <div class="card-body">
                <ul class="list-unstyled mb-0">
                    <li class="mb-2">
                        <span class="text-muted">Créée le:</span><br>
                        {{ $demande->created_at->format('d/m/Y H:i') }}
                    </li>
                    <li class="mb-2">
                        <span class="text-muted">Dernière modification:</span><br>
                        {{ $demande->updated_at->format('d/m/Y H:i') }}
                    </li>
                    @if($demande->deleted_at)
                    <li>
                        <span class="text-muted">Supprimée le:</span><br>
                        {{ $demande->deleted_at->format('d/m/Y H:i') }}
                    </li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- Update Status Modal -->
@include('admin.demande_employes.partials.update-status-modal', ['demande' => $demande])
@endsection