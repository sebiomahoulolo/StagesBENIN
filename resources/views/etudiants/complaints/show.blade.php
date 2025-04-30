@extends('layouts.etudiant.app')

@section('title', 'StagesBENIN')

@push('styles')
<style>
    /* Styles pour la page de détails des plaintes et suggestions */
    .complaint-container {
        max-width: 900px;
        margin: 0 auto;
        animation: fadeIn 0.4s ease forwards;
    }
    
    .page-header {
        margin-bottom: 2.5rem;
    }
    
    .back-button {
        color: #4b5563;
        border-color: #d1d5db;
        padding: 10px 20px;
        font-weight: 500;
        border-radius: 6px;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        margin-bottom: 20px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    }
    
    .back-button:hover {
        background-color: #f3f4f6;
        border-color: #9ca3af;
        color: #111827;
        transform: translateX(-3px);
        box-shadow: 0 3px 6px rgba(0, 0, 0, 0.1);
    }
    
    .back-button i {
        margin-right: 8px;
        transition: transform 0.2s ease;
    }
    
    .back-button:hover i {
        transform: translateX(-2px);
    }
    
    .complaint-card {
        border: none;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        border-radius: 12px;
        overflow: hidden;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        margin-bottom: 30px;
        background-color: white;
    }
    
    .complaint-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.12);
    }
    
    .complaint-header {
        padding: 25px 30px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }
    
    .complaint-header.plainte {
        background: linear-gradient(135deg, #ef4444, #b91c1c);
    }
    
    .complaint-header.suggestion {
        background: linear-gradient(135deg, #0ea5e9, #0369a1);
    }
    
    .complaint-header h4 {
        color: white;
        font-weight: 700;
        margin: 0;
        font-size: 1.5rem;
        display: flex;
        align-items: center;
    }
    
    .complaint-header h4 i {
        margin-right: 10px;
        font-size: 1.2rem;
    }
    
    .complaint-body {
        padding: 30px;
    }
    
    .complaint-section {
        margin-bottom: 35px;
    }
    
    .complaint-section:last-child {
        margin-bottom: 0;
    }
    
    .section-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: #1f2937;
        padding-bottom: 12px;
        border-bottom: 1px solid #e5e7eb;
        margin-bottom: 18px;
        display: flex;
        align-items: center;
    }
    
    .section-title i {
        margin-right: 10px;
        color: #4b5563;
    }
    
    .info-row {
        display: flex;
        flex-wrap: wrap;
        margin-bottom: 20px;
        gap: 25px;
    }
    
    .info-col {
        flex: 1;
        min-width: 250px;
    }
    
    .info-item {
        margin-bottom: 15px;
        display: flex;
        align-items: baseline;
    }
    
    .info-label {
        font-weight: 600;
        color: #4b5563;
        margin-right: 8px;
        min-width: 120px;
    }
    
    .info-value {
        color: #1f2937;
        flex: 1;
    }
    
    .badge {
        font-weight: 500;
        padding: 0.5em 0.85em;
        border-radius: 6px;
        text-transform: capitalize;
        font-size: 0.85rem;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        color: white !important;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.08);
        transition: all 0.2s ease;
    }
    
    .badge:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
    }
    
    .badge i {
        font-size: 0.85rem;
    }
    
    .type-badge {
        padding: 0.6em 1em;
        letter-spacing: 0.02em;
        font-weight: 600;
    }
    
    .badge.bg-danger {
        background-color: #dc2626 !important;
        border: 1px solid rgba(255, 255, 255, 0.2);
    }
    
    .badge.bg-info {
        background-color: #0ea5e9 !important;
        border: 1px solid rgba(255, 255, 255, 0.2);
    }
    
    .badge.bg-success {
        background-color: #10b981 !important;
    }
    
    .badge.bg-secondary {
        background-color: #6b7280 !important;
    }
    
    .badge.bg-warning {
        background-color: #f59e0b !important;
    }
    
    .content-box {
        background-color: #f9fafb;
        border-radius: 10px;
        padding: 20px 25px;
        font-size: 1rem;
        color: #374151;
        line-height: 1.6;
        white-space: pre-line;
        border: 1px solid #e5e7eb;
        transition: background-color 0.2s;
    }
    
    .content-box:hover {
        background-color: #f3f4f6;
    }
    
    .card-footer {
        background-color: #f9fafb;
        border-top: 1px solid #e5e7eb;
        padding: 20px 30px;
    }
    
    .btn-danger {
        background-color: #ef4444;
        border-color: #ef4444;
        color: white;
        padding: 10px 20px;
        border-radius: 6px;
        font-weight: 500;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }
    
    .btn-danger:hover {
        background-color: #dc2626;
        border-color: #dc2626;
        box-shadow: 0 4px 6px rgba(239, 68, 68, 0.2);
        transform: translateY(-2px);
    }
    
    .response-section {
        background-color: #ecfdf5;
        border-left: 4px solid #10b981;
        padding: 25px;
        border-radius: 0 10px 10px 0;
        margin-top: 30px;
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.1);
    }
    
    .response-header {
        display: flex;
        align-items: center;
        margin-bottom: 15px;
    }
    
    .response-header i {
        font-size: 1.5rem;
        color: #10b981;
        margin-right: 12px;
    }
    
    .response-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: #065f46;
        margin: 0;
    }
    
    .response-content {
        background-color: rgba(255, 255, 255, 0.7);
        border-radius: 8px;
        padding: 15px 20px;
        color: #065f46;
        border: 1px solid rgba(16, 185, 129, 0.2);
    }
    
    .status-badge {
        padding: 8px 16px;
        border-radius: 30px;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.05em;
    }
    
    .status-badge.nouveau {
        background-color: #6b7280;
    }
    
    .status-badge.en_cours {
        background-color: #f59e0b;
    }
    
    .status-badge.résolu {
        background-color: #10b981;
    }
    
    .action-button {
        margin-top: 20px;
        text-align: right;
    }
    
    /* Photo evidence styles */
    .photo-evidence {
        margin-bottom: 30px;
    }
    
    .photo-container {
        background-color: #f9fafb;
        border-radius: 10px;
        border: 1px solid #e5e7eb;
        overflow: hidden;
        position: relative;
    }
    
    .photo-wrapper {
        max-height: 400px;
        overflow: hidden;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    
    .photo-wrapper img {
        max-width: 100%;
        max-height: 400px;
        object-fit: contain;
    }
    
    .photo-fullscreen {
        position: absolute;
        bottom: 15px;
        right: 15px;
        background-color: rgba(0, 0, 0, 0.5);
        color: white;
        border: none;
        border-radius: 50%;
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    
    .photo-fullscreen:hover {
        background-color: rgba(0, 0, 0, 0.7);
        transform: scale(1.1);
    }
    
    .photo-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.9);
        z-index: 9999;
        display: none;
        justify-content: center;
        align-items: center;
        padding: 30px;
    }
    
    .photo-overlay img {
        max-width: 90%;
        max-height: 90%;
        object-fit: contain;
    }
    
    .photo-overlay-close {
        position: absolute;
        top: 20px;
        right: 20px;
        background-color: rgba(239, 68, 68, 0.8);
        color: white;
        border: none;
        border-radius: 50%;
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    
    .photo-overlay-close:hover {
        background-color: #dc2626;
        transform: scale(1.1);
    }
    
    /* Animations */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    .complaint-section {
        animation: fadeIn 0.4s ease forwards;
        animation-delay: calc(var(--section-index) * 0.1s);
        opacity: 0;
    }
    
    @media (max-width: 768px) {
        .complaint-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 15px;
            padding: 20px;
        }
        
        .complaint-body {
            padding: 20px;
        }
        
        .info-col {
            flex: 100%;
        }
        
        .info-item {
            flex-direction: column;
            gap: 5px;
        }
        
        .info-label {
            min-width: auto;
        }
        
        .card-footer {
            padding: 15px 20px;
        }
    }
</style>
@endpush

@section('content')
<div class="container py-4 complaint-container">
    <div class="page-header">
        <a href="{{ route('etudiants.complaints.index') }}" class="btn btn-outline-secondary back-button">
            <i class="fas fa-arrow-left"></i> Retour à la liste
        </a>
    </div>
    
    <div class="complaint-card">
        <div class="complaint-header {{ $complaintSuggestion->type == 'plainte' ? 'plainte' : 'suggestion' }}">
            <h4>
                @if($complaintSuggestion->type == 'plainte')
                    <i class="fas fa-exclamation-circle"></i> Plainte
                @else
                    <i class="fas fa-lightbulb"></i> Suggestion
                @endif
                <span class="ms-2">#{{ $complaintSuggestion->id }}</span>
            </h4>
            <span class="status-badge {{ $complaintSuggestion->statut }}">
                {{ ucfirst($complaintSuggestion->statut) }}
            </span>
        </div>
        <div class="complaint-body">
            <div class="complaint-section" style="--section-index: 0;">
                <h5 class="section-title">
                    <i class="fas fa-info-circle"></i> Informations générales
                </h5>
                <div class="info-row">
                    <div class="info-col">
                        <div class="info-item">
                            <span class="info-label">Type:</span> 
                            <span class="info-value">
                                @if($complaintSuggestion->type == 'plainte')
                                    <span class="badge bg-danger type-badge">
                                        <i class="fas fa-exclamation-circle"></i> Plainte
                                    </span>
                                @else
                                    <span class="badge bg-info type-badge">
                                        <i class="fas fa-lightbulb"></i> Suggestion
                                    </span>
                                @endif
                            </span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Identité:</span> 
                            <span class="info-value">
                                @if($complaintSuggestion->is_anonymous)
                                    <i class="fas fa-user-secret me-1 text-secondary"></i> Anonyme
                                @else
                                    <i class="fas fa-user me-1 text-primary"></i> Non anonyme
                                @endif
                            </span>
                        </div>
                    </div>
                    <div class="info-col">
                        <div class="info-item">
                            <span class="info-label">Date de soumission:</span> 
                            <span class="info-value">
                                <i class="far fa-calendar-alt me-1 text-secondary"></i>
                                {{ $complaintSuggestion->created_at->format('d/m/Y H:i') }}
                            </span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Dernière mise à jour:</span> 
                            <span class="info-value">
                                <i class="fas fa-history me-1 text-secondary"></i>
                                {{ $complaintSuggestion->updated_at->format('d/m/Y H:i') }}
                            </span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Statut:</span> 
                            <span class="info-value">
                                @if($complaintSuggestion->statut == 'nouveau')
                                    <span class="badge bg-secondary">Nouveau</span>
                                @elseif($complaintSuggestion->statut == 'en_cours')
                                    <span class="badge bg-warning">En cours</span>
                                @else
                                    <span class="badge bg-success">Résolu</span>
                                @endif
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="complaint-section" style="--section-index: 1;">
                <h5 class="section-title">
                    <i class="fas fa-heading"></i> Sujet
                </h5>
                <p class="fw-bold fs-5 mb-0">{{ $complaintSuggestion->sujet }}</p>
            </div>
            
            <div class="complaint-section" style="--section-index: 2;">
                <h5 class="section-title">
                    <i class="fas fa-align-left"></i> Contenu
                </h5>
                <div class="content-box">
                    {!! nl2br(e($complaintSuggestion->contenu)) !!}
                </div>
            </div>
            
            @if($complaintSuggestion->photo_path)
            <div class="complaint-section photo-evidence" style="--section-index: 3;">
                <h5 class="section-title">
                    <i class="fas fa-camera"></i> Preuve photo
                </h5>
                <div class="photo-container">
                    <div class="photo-wrapper">
                        <img src="{{ asset('storage/' . $complaintSuggestion->photo_path) }}" alt="Preuve photo">
                    </div>
                    <button type="button" class="photo-fullscreen" id="fullscreen-button">
                        <i class="fas fa-expand"></i>
                    </button>
                </div>
            </div>
            
            <div class="photo-overlay" id="photo-overlay">
                <img src="{{ asset('storage/' . $complaintSuggestion->photo_path) }}" alt="Preuve photo (plein écran)">
                <button type="button" class="photo-overlay-close" id="photo-overlay-close">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            @endif
            
            @if($complaintSuggestion->reponse)
            <div class="complaint-section response-section" style="--section-index: {{ $complaintSuggestion->photo_path ? '4' : '3' }};">
                <div class="response-header">
                    <i class="fas fa-comment-dots"></i>
                    <h5 class="response-title">Réponse de l'administration</h5>
                </div>
                <div class="response-content">
                    {!! nl2br(e($complaintSuggestion->reponse)) !!}
                </div>
            </div>
            @endif
        </div>
        
        @if($complaintSuggestion->statut == 'nouveau')
        <div class="card-footer">
            <form action="{{ route('etudiants.complaints.destroy', $complaintSuggestion->id) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette soumission ?');">
                @csrf
                @method('DELETE')
                <div>
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash"></i> Supprimer cette soumission
                    </button>
                </div>
            </form>
        </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Gestion de l'affichage en plein écran de la photo
        const fullscreenButton = document.getElementById('fullscreen-button');
        const photoOverlay = document.getElementById('photo-overlay');
        const photoOverlayClose = document.getElementById('photo-overlay-close');
        
        if (fullscreenButton) {
            fullscreenButton.addEventListener('click', function() {
                photoOverlay.style.display = 'flex';
                document.body.style.overflow = 'hidden';
            });
        }
        
        if (photoOverlayClose) {
            photoOverlayClose.addEventListener('click', function() {
                photoOverlay.style.display = 'none';
                document.body.style.overflow = 'auto';
            });
            
            // Fermer l'overlay en cliquant n'importe où
            photoOverlay.addEventListener('click', function(e) {
                if (e.target === photoOverlay) {
                    photoOverlay.style.display = 'none';
                    document.body.style.overflow = 'auto';
                }
            });
        }
    });
</script>
@endpush
@endsection 