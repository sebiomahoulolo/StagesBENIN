@extends('layouts.etudiant.app')

@section('title', 'Détails de ma candidature')

@push('styles')
<style>
    .candidature-container {
        max-width: 900px;
        margin: 0 auto;
        padding: 0 20px;
    }
    
    .main-card {
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 1px 10px rgba(0, 0, 0, 0.08);
        margin-bottom: 30px;
        border: none;
        background-color: white;
    }
    
    .card-header {
        background-color: #f8f9fa;
        color: #333;
        padding: 25px 30px;
        border-bottom: 1px solid #eaeaea;
    }
    
    .card-header h3 {
        font-size: 1.6rem;
        margin-bottom: 8px;
        font-weight: 600;
        color: #333;
    }
    
    .card-header .company {
        font-size: 1.1rem;
        color: #666;
    }
    
    .status-badge {
        display: inline-block;
        padding: 8px 15px;
        border-radius: 4px;
        font-weight: 500;
        font-size: 0.9rem;
        margin-top: 15px;
        color: white;
    }
    
    .badge-en_attente {
        background-color: #ffc107;
        color: #212529;
        border: none;
    }
    
    .badge-en_cours {
        background-color: #17a2b8;
        color: white;
        border: none;
    }
    
    .badge-accepte {
        background-color: #28a745;
        color: white;
        border: none;
    }
    
    .badge-rejete {
        background-color: #dc3545;
        color: white;
        border: none;
    }
    
    .card-body {
        padding: 30px;
    }
    
    .section {
        margin-bottom: 35px;
    }
    
    .section:last-child {
        margin-bottom: 0;
    }
    
    .section-title {
        font-size: 1.2rem;
        color: #495057;
        margin-bottom: 20px;
        padding-bottom: 10px;
        border-bottom: 1px solid #eaeaea;
        font-weight: 600;
    }
    
    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 25px;
    }
    
    .info-item {
        margin-bottom: 5px;
    }
    
    .info-label {
        color: #6c757d;
        font-weight: 500;
        margin-bottom: 5px;
        font-size: 0.9rem;
    }
    
    .info-value {
        color: #333;
        font-weight: 400;
        font-size: 1rem;
    }
    
    .lettre-box {
        background-color: #fbfbfb;
        border-radius: 6px;
        padding: 25px;
        line-height: 1.6;
        border: 1px solid #eaeaea;
    }
    
    .action-buttons {
        display: flex;
        gap: 15px;
        margin-top: 30px;
    }
    
    .btn-action {
        padding: 10px 20px;
        border-radius: 4px;
        font-weight: 500;
        font-size: 0.95rem;
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
    
    .btn-success-soft {
        background-color: #f8f9fa;
        color: #198754;
        border: 1px solid #198754;
    }
    
    .btn-success-soft:hover {
        background-color: #198754;
        color: white;
    }
    
    .page-navigator {
        margin-bottom: 25px;
    }
    
    .btn-back {
        padding: 8px 16px;
        border-radius: 4px;
        font-weight: 500;
        background-color: transparent;
        color: #6c757d;
        border: 1px solid #dee2e6;
    }
    
    .btn-back:hover {
        background-color: #f8f9fa;
    }
    
    .motif-rejet {
        padding: 20px;
        background-color: #fbfbfb;
        border: 1px solid #eaeaea;
        border-radius: 6px;
        margin-bottom: 30px;
    }
    
    .motif-header {
        font-weight: 600;
        margin-bottom: 10px;
        color: #6c757d;
    }
    
    @media (max-width: 767px) {
        .card-header {
            padding: 20px;
            text-align: center;
        }
        
        .card-body {
            padding: 20px;
        }
        
        .info-grid {
            grid-template-columns: 1fr;
            gap: 15px;
        }
        
        .action-buttons {
            flex-direction: column;
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
        <!-- Bouton retour -->
        <div class="page-navigator">
            <a href="{{ route('etudiants.candidatures.index') }}" class="btn btn-back">
                <i class="fas fa-arrow-left me-2"></i>Retour aux candidatures
            </a>
        </div>
        
        <!-- Carte principale -->
        <div class="main-card">
            <!-- En-tête de la candidature -->
            <div class="card-header">
                <h3>{{ $candidature->annonce->nom_du_poste }}</h3>
                <div class="company">{{ $candidature->annonce->entreprise->nom ?? 'Entreprise non spécifiée' }}</div>
                
                <!-- Badge de statut -->
                <div class="status-badge badge-{{ $candidature->statut }}">
                    @switch($candidature->statut)
                        @case('en_attente')
                            <i class="fas fa-clock me-1"></i> En attente
                            @break
                        @case('en_cours')
                            <i class="fas fa-spinner me-1"></i> En cours de traitement
                            @break
                        @case('accepte')
                            <i class="fas fa-check me-1"></i> Acceptée
                            @break
                        @case('rejete')
                            <i class="fas fa-times me-1"></i> Rejetée
                            @break
                        @default
                            {{ $candidature->statut }}
                    @endswitch
                </div>
            </div>
            
            <div class="card-body">
                <!-- Informations sur la candidature -->
                <div class="section">
                    <h4 class="section-title">Informations sur la candidature</h4>
                    <div class="info-grid">
                        <div class="info-item">
                            <div class="info-label">Date de candidature</div>
                            <div class="info-value">{{ $candidature->created_at->format('d/m/Y à H:i') }}</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Statut</div>
                            <div class="info-value">
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
                            </div>
                        </div>
                    </div>
                </div>
                
                @if($candidature->motif_rejet)
                    <div class="motif-rejet">
                        <div class="motif-header">Motif de rejet</div>
                        <div>{{ $candidature->motif_rejet }}</div>
                    </div>
                @endif
                
                <!-- Informations sur l'offre -->
                <div class="section">
                    <h4 class="section-title">Détails de l'offre</h4>
                    <div class="info-grid">
                        <div class="info-item">
                            <div class="info-label">Type de poste</div>
                            <div class="info-value">{{ $candidature->annonce->type_de_poste }}</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Lieu</div>
                            <div class="info-value">{{ $candidature->annonce->lieu }}</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Secteur</div>
                            <div class="info-value">{{ $candidature->annonce->secteur->nom ?? 'Non spécifié' }}</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Spécialité</div>
                            <div class="info-value">{{ $candidature->annonce->specialite->nom ?? 'Non spécifiée' }}</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Niveau d'étude requis</div>
                            <div class="info-value">{{ $candidature->annonce->niveau_detude }}</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Date de clôture</div>
                            <div class="info-value">{{ $candidature->annonce->date_cloture->format('d/m/Y') }}</div>
                        </div>
                    </div>
                </div>
                
                <!-- Lettre de motivation -->
                <div class="section">
                    <h4 class="section-title">Lettre de motivation</h4>
                    <div class="lettre-box">
                        {!! nl2br(e($candidature->lettre_motivation)) !!}
                    </div>
                </div>
                
                <!-- Actions -->
                @if($candidature->cv_path)
                    <div class="action-buttons">
                        <a href="{{ route('etudiants.offres.show', $candidature->annonce) }}" class="btn btn-primary-soft btn-action">
                            <i class="fas fa-eye me-2"></i>Voir l'offre
                        </a>
                        <a href="{{ asset('storage/' . $candidature->cv_path) }}" target="_blank" class="btn btn-success-soft btn-action">
                            <i class="fas fa-download me-2"></i>Télécharger mon CV
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection 