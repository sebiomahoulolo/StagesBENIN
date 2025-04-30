@extends('layouts.entreprises.master')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-white d-flex flex-column flex-md-row justify-content-between align-items-center gap-3">
                    <div>
                        <h5 class="mb-0">Détails de l'annonce</h5>
                        <small class="text-muted">ID: {{ $annonce->id }}</small>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="{{ route('entreprises.annonces.edit', $annonce) }}" class="btn btn-warning">
                            <i class="fas fa-edit me-2"></i>Modifier
                        </a>
                        <a href="{{ route('entreprises.annonces.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Retour
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row g-4">
                        <!-- Informations principales -->
                        <div class="col-lg-8">
                            <div class="card h-100">
                                <div class="card-header bg-light">
                                    <h4 class="mb-0">{{ $annonce->nom_du_poste }}</h4>
                                </div>
                                <div class="card-body">
                                    <!-- Informations principales -->
                                    <div class="info-list mb-4">
                                        <div class="info-list-item">
                                            <i class="fas fa-briefcase"></i>
                                            <div>
                                                <span class="info-label">Type de poste</span>
                                                <span class="info-value">{{ $annonce->type_de_poste }}</span>
                                            </div>
                                        </div>
                                        <div class="info-list-item">
                                            <i class="fas fa-industry"></i>
                                            <div>
                                                <span class="info-label">Secteur</span>
                                                <span class="info-value">{{ $annonce->secteur?->nom ?? 'Non spécifié' }}</span>
                                            </div>
                                        </div>
                                        <div class="info-list-item">
                                            <i class="fas fa-graduation-cap"></i>
                                            <div>
                                                <span class="info-label">Spécialité</span>
                                                <span class="info-value">{{ $annonce->specialite?->nom ?? 'Non spécifié' }}</span>
                                            </div>
                                        </div>
                                        <div class="info-list-item">
                                            <i class="fas fa-user-graduate"></i>
                                            <div>
                                                <span class="info-label">Niveau d'étude</span>
                                                <span class="info-value">{{ $annonce->niveau_detude }}</span>
                                            </div>
                                        </div>
                                        <div class="info-list-item">
                                            <i class="fas fa-map-marker-alt"></i>
                                            <div>
                                                <span class="info-label">Lieu</span>
                                                <span class="info-value">{{ $annonce->lieu }}</span>
                                            </div>
                                        </div>
                                        @if($annonce->pretension_salariale)
                                        <div class="info-list-item">
                                            <i class="fas fa-money-bill-wave"></i>
                                            <div>
                                                <span class="info-label">Salaire</span>
                                                <span class="info-value">{{ number_format($annonce->pretension_salariale, 0, ',', ' ') }} FCFA</span>
                                            </div>
                                        </div>
                                        @endif

                                        <div class="info-list-item">
                                            <i class="fas fa-users"></i>
                                            <div>
                                                <span class="info-label">Nombre de places</span>
                                                <span class="info-value">{{ $annonce->nombre_de_place }}</span>
                                            </div>
                                        </div>
                                        <div class="info-list-item">
                                            <i class="fas fa-calendar"></i>
                                            <div>
                                                <span class="info-label">Date de clôture</span>
                                                <span class="info-value">{{ $annonce->date_cloture?->format('d/m/Y') ?? 'Non spécifiée' }}</span>
                                            </div>
                                        </div>
                                        <div class="info-list-item">
                                            <i class="fas fa-envelope"></i>
                                            <div>
                                                <span class="info-label">Email de contact</span>
                                                <span class="info-value">{{ $annonce->email }}</span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Informations complémentaires -->
                                    
                                    
                                    

                                    <!-- Description -->
                                    <div class="card bg-light">
                                        <div class="card-header bg-white">
                                            <h6 class="mb-0">Description du poste</h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="description-content">
                                                {!! nl2br(e($annonce->description)) !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Statistiques -->
                        <div class="col-lg-4">
                            <div class="card h-100">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0">Statistiques</h6>
                                </div>
                                <div class="card-body">
                                    <div class="d-flex flex-column gap-3">
                                        <div class="info-item">
                                            <i class="fas fa-file-alt"></i>
                                            <div>
                                                <span class="info-label">Candidatures</span>
                                                <span class="info-value">{{ $annonce->candidatures->count() }}</span>
                                            </div>
                                        </div>

                                        <div class="info-item">
                                            <i class="fas fa-check-circle"></i>
                                            <div>
                                                <span class="info-label">Statut</span>
                                                <span class="info-value">
                                                    @switch($annonce->statut)
                                                        @case('en_attente')
                                                            En attente
                                                            @break
                                                        @case('approuve')
                                                            Approuvé
                                                            @break
                                                        @case('rejete')
                                                            Rejeté
                                                            @break
                                                    @endswitch
                                                </span>
                                            </div>
                                        </div>

                                        <div class="info-item">
                                            <i class="fas fa-eye"></i>
                                            <div>
                                                <span class="info-label">Visibilité</span>
                                                <span class="info-value">{{ $annonce->est_active ? 'Active' : 'Inactive' }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Candidatures -->
                    <!-- <div class="mt-4">
                        <div class="card">
                            <div class="card-header bg-light">
                                <h5 class="mb-0">Candidatures reçues</h5>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Étudiant</th>
                                                <th>Date</th>
                                                <th>Statut</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($annonce->candidatures as $candidature)
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-shrink-0">
                                                            <div class="avatar avatar-sm bg-primary bg-opacity-10 rounded-circle">
                                                                <i class="fas fa-user text-primary"></i>
                                                            </div>
                                                        </div>
                                                        <div class="flex-grow-1 ms-3">
                                                            <h6 class="mb-0">{{ $candidature->etudiant->user->name }}</h6>
                                                            <small class="text-muted">{{ $candidature->etudiant->formation }}</small>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>{{ $candidature->created_at->format('d/m/Y') }}</td>
                                                <td>
                                                    <span class="badge {{ $candidature->statut === 'en_attente' ? 'bg-warning' : ($candidature->statut === 'accepte' ? 'bg-success' : 'bg-danger') }}">
                                                        {{ $candidature->getStatutLabel() }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <a href="{{ route('entreprises.candidatures.show', $candidature) }}" class="btn btn-sm btn-info">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="4" class="text-center py-4">
                                                    <div class="d-flex flex-column align-items-center">
                                                        <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                                        <p class="text-muted mb-0">Aucune candidature reçue</p>
                                                    </div>
                                                </td>
                                            </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div> -->
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.avatar {
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.info-item {
    background: #f8f9fa;
    border-radius: 0.5rem;
    padding: 1rem;
    display: flex;
    align-items: center;
    gap: 1rem;
    height: 100%;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
}

.info-item:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.info-item i {
    font-size: 1.5rem;
    color: #0d6efd;
    background: rgba(13, 110, 253, 0.1);
    padding: 0.75rem;
    border-radius: 0.5rem;
}

.info-label {
    font-size: 0.8rem;
    color: #6c757d;
    margin-bottom: 0.25rem;
    display: block;
}

.info-value {
    font-size: 1rem;
    font-weight: 500;
    color: #212529;
    display: block;
}

.description-content {
    white-space: pre-line;
    line-height: 1.6;
    font-size: 1rem;
}

.table th {
    font-weight: 600;
    text-transform: uppercase;
    font-size: 0.75rem;
    letter-spacing: 0.5px;
}

.table td {
    vertical-align: middle;
}

.card {
    border: none;
    border-radius: 0.5rem;
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
}

.card-header {
    border-bottom: 1px solid rgba(0, 0, 0, 0.125);
    padding: 1rem;
}

@media (max-width: 768px) {
    .card-header {
        flex-direction: column;
        gap: 1rem;
    }
    
    .btn-group {
        width: 100%;
    }
    
    .btn {
        width: 100%;
    }
    
    .d-flex.gap-2 {
        flex-direction: column;
        width: 100%;
    }
    
    .info-item {
        margin-bottom: 1rem;
    }
    
    .info-item i {
        font-size: 1.25rem;
        padding: 0.5rem;
    }
}

.info-list {
    background: #f8f9fa;
    border-radius: 0.5rem;
    padding: 1rem;
}

.info-list-item {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem;
    border-bottom: 1px solid rgba(0, 0, 0, 0.05);
}

.info-list-item:last-child {
    border-bottom: none;
}

.info-list-item i {
    font-size: 1.5rem;
    color: #0d6efd;
    background: rgba(13, 110, 253, 0.1);
    padding: 0.75rem;
    border-radius: 0.5rem;
    width: 3rem;
    height: 3rem;
    display: flex;
    align-items: center;
    justify-content: center;
}
</style>
@endsection 