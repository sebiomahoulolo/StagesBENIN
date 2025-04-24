@extends('layouts.etudiant.app')

@section('title', $offre->titre)

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Détails de l'offre</h5>
                        <div>
                            <a href="{{ route('etudiants.offres.index') }}" class="btn btn-sm btn-outline-secondary me-2">
                                <i class="fas fa-arrow-left me-1"></i> Retour aux offres
                            </a>
                            @if(!$aPostule)
                                <a href="{{ route('etudiants.offres.postuler', $offre->id) }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-paper-plane me-1"></i> Postuler
                                </a>
                            @else
                                <button class="btn btn-sm btn-success" disabled>
                                    <i class="fas fa-check me-1"></i> Déjà postulé
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <!-- En-tête de l'offre -->
                    <div class="mb-4">
                        <h2 class="mb-2">{{ $offre->titre }}</h2>
                        <h5 class="text-muted mb-3">{{ $offre->entreprise->nom ?? 'Entreprise non spécifiée' }}</h5>
                        
                        <div class="d-flex flex-wrap gap-2 mb-3">
                            <span class="badge bg-primary">{{ $offre->type_contrat }}</span>
                            @if($offre->lieu)
                                <span class="badge bg-info"><i class="fas fa-map-marker-alt me-1"></i>{{ $offre->lieu }}</span>
                            @endif
                            @if($offre->salaire)
                                <span class="badge bg-success"><i class="fas fa-money-bill-wave me-1"></i>{{ $offre->salaire }}</span>
                            @endif
                            @if($offre->date_debut)
                                <span class="badge bg-warning"><i class="fas fa-calendar-alt me-1"></i>Début: {{ $offre->date_debut->format('d/m/Y') }}</span>
                            @endif
                            @if($offre->date_expiration)
                                <span class="badge bg-danger"><i class="fas fa-clock me-1"></i>Expire le: {{ $offre->date_expiration->format('d/m/Y') }}</span>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Description de l'offre -->
                    <div class="mb-4">
                        <h4 class="mb-3">Description du poste</h4>
                        <div class="p-3 bg-light rounded">
                            {!! nl2br(e($offre->description)) !!}
                        </div>
                    </div>
                    
                    <!-- Compétences requises -->
                    @if($offre->competences_requises)
                        <div class="mb-4">
                            <h4 class="mb-3">Compétences requises</h4>
                            <div class="p-3 bg-light rounded">
                                {!! nl2br(e($offre->competences_requises)) !!}
                            </div>
                        </div>
                    @endif
                    
                    <!-- Informations sur l'entreprise -->
                    @if($offre->entreprise)
                        <div class="mb-4">
                            <h4 class="mb-3">À propos de l'entreprise</h4>
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-2 text-center">
                                            @if($offre->entreprise->logo)
                                                <img src="{{ asset('storage/' . $offre->entreprise->logo) }}" alt="Logo {{ $offre->entreprise->nom }}" class="img-fluid rounded mb-2" style="max-height: 100px;">
                                            @else
                                                <div class="bg-secondary text-white rounded d-flex align-items-center justify-content-center" style="height: 100px; width: 100px;">
                                                    <i class="fas fa-building fa-3x"></i>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="col-md-10">
                                            <h5>{{ $offre->entreprise->nom }}</h5>
                                            <p>{{ $offre->entreprise->description ?? 'Aucune description disponible.' }}</p>
                                            <div class="d-flex gap-2">
                                                @if($offre->entreprise->site_web)
                                                    <a href="{{ $offre->entreprise->site_web }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                                        <i class="fas fa-globe me-1"></i> Site web
                                                    </a>
                                                @endif
                                                <a href="{{ route('pages.catalogueplus', $offre->entreprise->id) }}" class="btn btn-sm btn-outline-info">
                                                    <i class="fas fa-info-circle me-1"></i> Voir le profil
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                    
                    <!-- Bouton de candidature -->
                    <div class="text-center mt-4">
                        @if(!$aPostule)
                            <a href="{{ route('etudiants.offres.postuler', $offre->id) }}" class="btn btn-lg btn-primary">
                                <i class="fas fa-paper-plane me-2"></i> Postuler à cette offre
                            </a>
                        @else
                            <div class="alert alert-success">
                                <i class="fas fa-check-circle me-2"></i> Vous avez déjà postulé à cette offre.
                                <a href="{{ route('etudiants.offres.mes-candidatures') }}" class="alert-link ms-2">Voir mes candidatures</a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 