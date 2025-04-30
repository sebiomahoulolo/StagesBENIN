@extends('layouts.etudiant.app')

@section('title', 'StagesBENIN')

@push('styles')
<style>
    .candidature-container {
        max-width: 1100px;
        margin: 0 auto;
        padding: 0 20px;
    }
    
    .candidature-card {
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 1px 10px rgba(0, 0, 0, 0.08);
        margin-bottom: 20px;
        border: none;
        background-color: white;
        transition: transform 0.2s ease;
    }
    
    .candidature-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }
    
    .card-header {
        background-color: #f8f9fa;
        color: #333;
        padding: 15px 20px;
        border-bottom: 1px solid #eaeaea;
    }
    
    .card-header h5 {
        font-size: 1.1rem;
        margin-bottom: 4px;
        font-weight: 600;
        color: #333;
    }
    
    .card-header small {
        color: #666;
        font-size: 0.9rem;
    }
    
    .card-body {
        padding: 20px;
    }
    
    .info-item {
        margin-bottom: 12px;
        display: flex;
        align-items: flex-start;
    }
    
    .info-item i {
        width: 20px;
        color: #6c757d;
        margin-right: 10px;
        margin-top: 3px;
    }
    
    .info-item .label {
        font-weight: 500;
        color: #6c757d;
        margin-right: 5px;
    }
    
    .status-badge {
        display: inline-block;
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 0.8rem;
        font-weight: 500;
    }
    
    .badge-en_attente {
        background-color: #ffc107;
        color: #212529;
    }
    
    .badge-en_cours {
        background-color: #17a2b8;
        color: white;
    }
    
    .badge-accepte {
        background-color: #28a745;
        color: white;
    }
    
    .badge-rejete {
        background-color: #dc3545;
        color: white;
    }
    
    .action-buttons {
        display: flex;
        gap: 10px;
        margin-top: 15px;
    }
    
    .btn-action {
        padding: 8px 15px;
        border-radius: 4px;
        font-weight: 500;
        font-size: 0.9rem;
    }
    
    .btn-primary-soft {
        background-color: #f8f9fa;
        color: #0d6efd;
        border: 1px solid #0d6efd;
    }
    
    .btn-primary-soft:hover {
        background-color: #0d6efd;
        color: white;
    }
    
    .btn-details {
        background-color: #f8f9fa;
        color: #6c757d;
        border: 1px solid #6c757d;
    }
    
    .btn-details:hover {
        background-color: #6c757d;
        color: white;
    }
    
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
        padding-bottom: 15px;
        border-bottom: 1px solid #eaeaea;
    }
    
    .page-title {
        font-size: 1.5rem;
        font-weight: 600;
        color: #333;
        margin: 0;
    }
    
    .empty-state {
        text-align: center;
        padding: 40px 20px;
        background-color: #fbfbfb;
        border-radius: 8px;
        border: 1px solid #eaeaea;
    }
    
    .empty-icon {
        font-size: 2.5rem;
        color: #6c757d;
        margin-bottom: 15px;
    }
    
    @media (max-width: 768px) {
        .page-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 15px;
        }
        
        .action-buttons {
            flex-direction: column;
            width: 100%;
        }
        
        .btn-action {
            width: 100%;
            text-align: center;
        }
    }
</style>
@endpush

@section('content')
<div class="container py-4">
    <div class="candidature-container">
        <div class="page-header">
            <h1 class="page-title">Mes candidatures</h1>
            <a href="{{ route('etudiants.offres.index') }}" class="btn btn-primary-soft btn-action">
                <i class="fas fa-search me-2"></i>Voir les offres disponibles
            </a>
        </div>

        @if($candidatures->count() > 0)
            <div class="row">
                @foreach($candidatures as $candidature)
                    <div class="col-lg-6">
                        <div class="candidature-card">
                            <div class="card-header">
                                <h5>{{ $candidature->annonce->nom_du_poste }}</h5>
                                <small>{{ $candidature->annonce->entreprise->nom ?? 'Entreprise non spécifiée' }}</small>
                            </div>
                            <div class="card-body">
                                <div class="info-item">
                                    <i class="fas fa-calendar-alt"></i>
                                    <div>
                                        <span class="label">Date:</span>
                                        {{ $candidature->created_at->format('d/m/Y') }}
                                    </div>
                                </div>
                                
                                <div class="info-item">
                                    <i class="fas fa-map-marker-alt"></i>
                                    <div>
                                        <span class="label">Lieu:</span>
                                        {{ $candidature->annonce->lieu }}
                                    </div>
                                </div>
                                
                                <div class="info-item">
                                    <i class="fas fa-tag"></i>
                                    <div>
                                        <span class="label">Type:</span>
                                        {{ $candidature->annonce->type_de_poste }}
                                    </div>
                                </div>
                                
                                <div class="info-item">
                                    <i class="fas fa-info-circle"></i>
                                    <div>
                                        <span class="label">Statut:</span>
                                        <span class="status-badge badge-{{ $candidature->statut }}">
                                            @switch($candidature->statut)
                                                @case('en_attente')
                                                    En attente
                                                    @break
                                                @case('en_cours')
                                                    En cours de traitement
                                                    @break
                                                @case('accepte')
                                                    Acceptée
                                                    @break
                                                @case('rejete')
                                                    Rejetée
                                                    @break
                                                @default
                                                    {{ $candidature->statut }}
                                            @endswitch
                                        </span>
                                    </div>
                                </div>
                                
                                <div class="action-buttons">
                                    <a href="{{ route('etudiants.offres.show', $candidature->annonce) }}" class="btn btn-primary-soft btn-action">
                                        <i class="fas fa-eye me-1"></i>Voir l'offre
                                    </a>
                                    <a href="{{ route('etudiants.candidatures.show', $candidature->id) }}" class="btn btn-details btn-action">
                                        <i class="fas fa-info-circle me-1"></i>Détails
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-4">
                {{ $candidatures->links() }}
            </div>
        @else
            <div class="empty-state">
                <div class="empty-icon">
                    <i class="fas fa-file-alt"></i>
                </div>
                <h3>Aucune candidature</h3>
                <p class="text-muted">Vous n'avez pas encore postulé à des offres d'emploi.</p>
                <a href="{{ route('etudiants.offres.index') }}" class="btn btn-primary-soft btn-action mt-3">
                    <i class="fas fa-search me-2"></i>Découvrir les offres
                </a>
            </div>
        @endif
    </div>
</div>
@endsection 