@extends('layouts.entreprises.master')

@section('title', 'Détails de la demande - StagesBENIN')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/shared-styles.css') }}">
<style>
    .status-banner {
        padding: 1.25rem;
        border-radius: 0.5rem;
        margin-bottom: 2rem;
        display: flex;
        align-items: center;
        gap: 1.25rem;
        color: #1f2937;
    }
    
    .status-banner.status-en_attente {
        background-color: #fef3c7;
        border: 1px solid #f59e0b;
    }
    
    .status-banner.status-approuvee {
        background-color: #dcfce7;
        border: 1px solid #10b981;
    }
    
    .status-banner.status-rejetee {
        background-color: #fee2e2;
        border: 1px solid #ef4444;
    }
     .status-banner.status-expiree {
        background-color: #f1f5f9;
        border: 1px solid #64748b;
    }
    
    .status-banner i {
        font-size: 1.75rem;
    }
    
    .status-banner.status-en_attente i { color: #f59e0b; }
    .status-banner.status-approuvee i { color: #10b981; }
    .status-banner.status-rejetee i { color: #ef4444; }
    .status-banner.status-expiree i { color: #64748b; }
    
    .status-banner h4 {
        font-size: 1.125rem;
        font-weight: 600;
        margin: 0 0 0.25rem 0;
        color: #1f2937;
    }
    
    .status-banner .small {
        font-size: 0.875rem;
    }
    
    .status-banner .text-muted {
        color: #6b7280;
    }
    
    /* Grille d'informations */
    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.25rem;
        margin-bottom: 1.5rem;
    }
    
    .info-item {
        background: white;
        padding: 1.25rem;
        border-radius: 0.5rem;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        border: 1px solid #edf2f7;
    }
    
    .info-label {
        color: #64748b;
        font-size: 0.875rem;
        margin-bottom: 0.5rem;
        display: block;
        font-weight: 500;
    }
    
    .info-value {
        font-weight: 600;
        color: #1f2937;
        font-size: 1.05rem;
    }
    
    .competence-list {
        display: flex;
        flex-wrap: wrap;
        gap: 0.625rem;
        margin-top: 0.75rem;
    }
    
    .competence-tag {
        background: #f3f4f6;
        padding: 0.375rem 0.875rem;
        border-radius: 9999px;
        font-size: 0.875rem;
        color: #1f2937;
        border: 1px solid #e5e7eb;
        font-weight: 500;
    }
    
    .description-section {
        background: white;
        padding: 1.75rem;
        border-radius: 0.5rem;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        margin-bottom: 1.75rem;
        border: 1px solid #edf2f7;
    }
    
    .description-content {
        white-space: pre-line;
        color: #1f2937;
        line-height: 1.7;
    }
    
    .card-header {
        background-color: #f8fafc;
        padding: 1.25rem;
        border-bottom: 1px solid #e2e8f0;
    }
    
    .card-body {
        padding: 1.5rem;
    }
    
    .section-title {
        font-size: 1.25rem;
        color: #1f2937;
        margin-bottom: 1.25rem;
        padding-bottom: 0.75rem;
        border-bottom: 1px solid #e5e7eb;
        font-weight: 600;
    }
    
    .card-title {
        font-size: 1.125rem;
        font-weight: 600;
        color: #1f2937;
        margin: 0;
    }
    
    .action-buttons-container {
        margin-top: 2rem;
    }

    .action-buttons {
        position: sticky;
        bottom: 1rem;
        background: white;
        padding: 1.25rem;
        border-radius: 0.5rem;
        box-shadow: 0 -2px 10px rgba(0,0,0,0.1);
        display: flex;
        justify-content: flex-end;
        gap: 1rem;
        z-index: 100;
        border: 1px solid #edf2f7;
    }
    
    .btn {
        padding: 0.625rem 1.25rem;
        border-radius: 0.375rem;
        font-weight: 500;
        transition: all 0.2s;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
    }
    
    .btn-outline-danger {
        border: 1px solid #ef4444;
        color: #ef4444;
        background-color: transparent;
    }
    
    .btn-outline-danger:hover {
        background-color: #ef4444;
        color: white;
        transform: translateY(-1px);
    }
    
    .btn-outline-secondary {
        border: 1px solid #64748b;
        color: #64748b;
        background-color: transparent;
    }
    
    .btn-outline-secondary:hover {
        background-color: #64748b;
        color: white;
    }
    
    .custom-card {
        background: white;
        border-radius: 0.5rem;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        border: 1px solid #edf2f7;
        overflow: hidden;
        margin-bottom: 1.5rem;
    }
    
    .custom-btn {
        padding: 0.625rem 1.25rem;
        border-radius: 0.375rem;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        transition: all 0.2s;
        border: none;
    }
    
    .custom-btn-primary {
        background-color: #3b82f6;
        color: white;
    }
    
    .custom-btn-primary:hover {
        background-color: #2563eb;
        transform: translateY(-1px);
    }
    
    .custom-btn[disabled] {
        opacity: 0.65;
        cursor: not-allowed;
    }
    
    .content-header {
        margin-bottom: 1.75rem;
    }
    
    .h2 {
        font-size: 1.5rem;
        font-weight: 600;
        color: #111827;
        margin: 0;
    }
    
    .mb-0 {
        margin-bottom: 0;
    }
    
    .mb-1 {
        margin-bottom: 0.25rem;
    }

    .me-2 {
        margin-right: 0.5rem;
    }
    
    .bg-danger {
        background-color: #ef4444;
    }
    
    .text-white {
        color: white;
    }
    
    .text-capitalize {
        text-transform: capitalize;
    }
    
    .d-flex {
        display: flex;
    }
    
    .justify-content-between {
        justify-content: space-between;
    }
    
    .align-items-center {
        align-items: center;
    }
    
    .mt-4 {
        margin-top: 1.5rem;
    }
    
    @media (max-width: 768px) {
        .action-buttons {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            border-radius: 0.5rem 0.5rem 0 0;
            margin: 0;
            padding: 1rem;
            justify-content: space-around;
        }
        
        .info-grid {
            grid-template-columns: 1fr;
        }
        
        .content-header {
            padding-bottom: 0.5rem;
            margin-bottom: 1.25rem;
        }
        
        body {
            padding-bottom: 80px;
        }
        
        .card-header {
            padding: 1rem;
        }
        
        .card-body,
        .description-section {
            padding: 1.25rem;
        }
        
        .status-banner {
            padding: 1rem;
            margin-bottom: 1.5rem;
        }
    }
</style>
@endpush

@section('content')
<div class="content-header">
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="h2 mb-0">Détails de la demande</h1>
        <a href="{{ route('entreprises.demandes.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Retour à la liste
        </a>
    </div>
</div>

@php
    $statutClass = 'status-' . $demande->statut;
    $statutIcon = 'fa-question-circle'; // Icône par défaut
    switch ($demande->statut) {
        case 'approuvee': $statutIcon = 'fa-check-circle'; break;
        case 'en_attente': $statutIcon = 'fa-clock'; break;
        case 'rejetee': $statutIcon = 'fa-times-circle'; break;
        case 'expiree': $statutIcon = 'fa-calendar-times'; break;
    }
@endphp

<div class="status-banner {{ $statutClass }}">
    <i class="fas {{ $statutIcon }}"></i>
    <div>
        <h4 class="mb-1">Statut : <span class="text-capitalize">{{ str_replace('_', ' ', $demande->statut) }}</span></h4>
        <p class="mb-0 small text-muted">Dernière mise à jour : {{ $demande->updated_at->format('d/m/Y à H:i') }}</p>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="custom-card fade-in mb-4">
            <div class="card-body">
                <h3 class="section-title">Informations générales</h3>
                <div class="info-grid">
                    <div class="info-item">
                        <div class="info-label">Poste recherché</div>
                        <div class="info-value">{{ $demande->titre }}</div>
                    </div>
                     <div class="info-item">
                        <div class="info-label">Type de demande</div>
                        <div class="info-value text-capitalize">{{ $demande->type }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Type de contrat</div>
                        <div class="info-value">{{ $demande->type_contrat }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Nombre de postes</div>
                        <div class="info-value">{{ $demande->nombre_postes }}</div>
                    </div>
                     <div class="info-item">
                        <div class="info-label">Domaine</div>
                        <div class="info-value">{{ $demande->domaine ?? 'Non spécifié' }}</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="description-section fade-in">
            <h3 class="section-title">Description du poste</h3>
            <div class="description-content">
                {!! nl2br(e($demande->description)) !!}
            </div>
        </div>

        <div class="custom-card fade-in">
            <div class="card-body">
                <h3 class="section-title">Profil recherché</h3>
                <div class="info-grid">
                    <div class="info-item">
                        <div class="info-label">Niveau d'études requis</div>
                        <div class="info-value">{{ $demande->niveau_etude }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Expérience requise</div>
                        <div class="info-value">{{ $demande->niveau_experience ?? 'Non spécifiée' }}</div>
                    </div>
                </div>

                @if($demande->competences_requises && !empty(json_decode($demande->competences_requises)))
                <div style="margin-top: 1.5rem;">
                    <h4 style="font-size: 1.1rem; font-weight: 600; margin-bottom: 1rem; color: #1f2937;">Compétences requises</h4>
                    <div class="competence-list">
                        @foreach(json_decode($demande->competences_requises) as $competence)
                            <span class="competence-tag">{{ $competence }}</span>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <div class="custom-card fade-in">
            <div class="card-header">
                <h3 class="card-title mb-0">Conditions et Lieu</h3>
            </div>
            <div class="card-body">
                <div class="info-item mb-3">
                    <div class="info-label">Lieu de travail</div>
                    <div class="info-value">{{ $demande->lieu }}</div>
                </div>
                <div class="info-item mb-3">
                    <div class="info-label">Date de début souhaitée</div>
                    <div class="info-value">{{ $demande->date_debut->format('d/m/Y') }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Rémunération (min)</div>
                    <div class="info-value">{{ $demande->salaire_min ? number_format($demande->salaire_min, 0, ',', ' ') . ' FCFA' : 'Non spécifiée' }}</div>
                </div>
                {{-- Si vous avez une colonne pour les avantages et qu'elle est remplie --}}
                {{-- @if($demande->avantages)
                <div class="info-item mt-4">
                    <div class="info-label">Avantages</div>
                    <div class="info-value">{!! nl2br(e($demande->avantages)) !!}</div>
                </div>
                @endif --}}
            </div>
        </div>
        
        {{-- Afficher le motif de rejet si la demande est rejetée --}}
        @if($demande->statut === 'rejetee' && $demande->motif_rejet)
        <div class="custom-card mt-4 fade-in">
            <div class="card-header bg-danger text-white">
                <h3 class="card-title mb-0"><i class="fas fa-exclamation-triangle me-2"></i>Motif du rejet</h3>
            </div>
            <div class="card-body">
                <p style="margin: 0; line-height: 1.6;">{{ $demande->motif_rejet }}</p>
            </div>
        </div>
        @endif
    </div>
</div>

<div class="action-buttons-container">
    <div class="action-buttons">
        <form action="{{ route('entreprises.demandes.destroy', $demande) }}" method="POST" class="d-inline">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-outline-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette demande ?')">
                <i class="fas fa-trash me-2"></i>Supprimer
            </button>
        </form>
        
        {{-- L'édition n'est possible que si la demande est en attente --}}
        @if($demande->statut === 'en_attente')
        <a href="{{ route('entreprises.demandes.edit', $demande) }}" class="custom-btn custom-btn-primary">
            <i class="fas fa-edit me-2"></i>Modifier
        </a>
        @else
        <button class="custom-btn custom-btn-primary" disabled>
            <i class="fas fa-edit me-2"></i>Modifier
        </button>
        @endif
    </div>
</div>
@endsection