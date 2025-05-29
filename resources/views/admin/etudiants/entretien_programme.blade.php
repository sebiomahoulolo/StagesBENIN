@extends('layouts.admin.app')

@section('title', 'Entretiens programmés')

@push('styles')
<style>
    .entretien-card {
        transition: transform 0.3s ease;
    }
    .entretien-card:hover {
        transform: translateY(-5px);
    }
    .status-badge {
        position: absolute;
        top: 10px;
        right: 10px;
    }
</style>
@endpush

@section('content')
    <div class="container-fluid py-4">
        <div class="row mb-4">
            <div class="col-12">
                <h2 class="mb-4">
                    <i class="fas fa-calendar-check me-2"></i>
                    Mes entretiens programmés
                </h2>
            </div>
        </div>

        <div class="row">
            @forelse ($entretiens as $entretien)
                <div class="col-md-4 mb-4">
                    <div class="card entretien-card shadow-sm h-100">
                        <div class="card-header bg-primary text-white">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-briefcase me-2"></i>
                                {{ $entretien->nom_du_poste }}
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <h6 class="text-muted mb-2">
                                    <i class="fas fa-calendar me-2"></i>
                                    Date et heure
                                </h6>
                                <p class="mb-0">
                                    {{ \Carbon\Carbon::parse($entretien->date)->format('d/m/Y') }} à {{ $entretien->heure }}
                                </p>
                            </div>

                            <div class="mb-3">
                                <h6 class="text-muted mb-2">
                                    <i class="fas fa-clock me-2"></i>
                                    Durée
                                </h6>
                                <p class="mb-0">{{ $entretien->duree }} minutes</p>
                            </div>

                            <div class="mb-3">
                                <h6 class="text-muted mb-2">
                                    <i class="fas fa-user me-2"></i>
                                    Candidat
                                </h6>
                                <p class="mb-0">{{ $entretien->prenom }} {{ $entretien->nom }}</p>
                            </div>

                            <div class="mb-3">
                                <h6 class="text-muted mb-2">
                                    <i class="fas fa-info-circle me-2"></i>
                                    Référence
                                </h6>
                                <p class="mb-0">{{ $entretien->reference }}</p>
                            </div>
                        </div>
                        <div class="card-footer bg-light">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="badge bg-info">
                                    <i class="fas fa-clock me-1"></i>
                                    Planifié
                                </span>
                                <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#detailsModal{{ $entretien->id }}">
                                    <i class="fas fa-eye me-1"></i>
                                    Voir détails
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal pour les détails -->
                <div class="modal fade" id="detailsModal{{ $entretien->id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header bg-primary text-white">
                                <h5 class="modal-title">
                                    <i class="fas fa-info-circle me-2"></i>
                                    Détails de l'entretien
                                </h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h6 class="text-primary mb-3">Informations générales</h6>
                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item d-flex justify-content-between">
                                                <span class="fw-bold">Poste:</span>
                                                <span>{{ $entretien->nom_du_poste }}</span>
                                            </li>
                                            <li class="list-group-item d-flex justify-content-between">
                                                <span class="fw-bold">Date:</span>
                                                <span>{{ \Carbon\Carbon::parse($entretien->date)->format('d/m/Y') }}</span>
                                            </li>
                                            <li class="list-group-item d-flex justify-content-between">
                                                <span class="fw-bold">Heure:</span>
                                                <span>{{ $entretien->heure }}</span>
                                            </li>
                                            <li class="list-group-item d-flex justify-content-between">
                                                <span class="fw-bold">Durée:</span>
                                                <span>{{ $entretien->duree }} minutes</span>
                                            </li>
                                            <li class="list-group-item d-flex justify-content-between">
                                                <span class="fw-bold">Référence:</span>
                                                <span>{{ $entretien->reference }}</span>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="col-md-6">
                                        <h6 class="text-primary mb-3">Informations du candidat</h6>
                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item d-flex justify-content-between">
                                                <span class="fw-bold">Nom:</span>
                                                <span>{{ $entretien->nom }}</span>
                                            </li>
                                            <li class="list-group-item d-flex justify-content-between">
                                                <span class="fw-bold">Prénom:</span>
                                                <span>{{ $entretien->prenom }}</span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                    <i class="fas fa-times me-2"></i>
                                    Fermer
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        Vous n'avez aucun entretien programmé pour le moment.
                    </div>
                </div>
            @endforelse
        </div>
    </div>
@endsection

@push('scripts')
<script>
    // Ajoutez ici vos scripts si nécessaire
</script>
@endpush
