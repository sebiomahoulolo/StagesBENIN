@extends('layouts.etudiant.app')

@section('title', 'StagesBENIN')

@push('styles')
<style>
    .offre-detail {
        background-color: #fff;
        border-radius: 10px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        margin-bottom: 20px;
    }

    .offre-header {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        padding: 25px;
        border-radius: 10px 10px 0 0;
        border-bottom: 1px solid #dee2e6;
    }

    .offre-title {
        font-size: 1.8rem;
        font-weight: 700;
        color: #2c3e50;
        margin-bottom: 10px;
    }

    .offre-entreprise {
        font-size: 1.1rem;
        color: #6c757d;
    }

    .offre-body {
        padding: 25px;
    }

    .section-title {
        font-size: 1.3rem;
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 15px;
        padding-bottom: 10px;
        border-bottom: 2px solid #f0f2f5;
    }

    .info-list {
        list-style: none;
        padding: 0;
    }

    .info-list li {
        margin-bottom: 12px;
        display: flex;
        align-items: center;
    }

    .info-list li strong {
        min-width: 150px;
        color: #495057;
    }

    .info-list li span {
        color: #2c3e50;
    }

    .badge-container {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        margin: 15px 0;
    }

    .badge {
        padding: 8px 12px;
        border-radius: 6px;
        font-weight: 500;
        font-size: 0.9rem;
    }

    .badge-type {
        background-color: #4361ee;
        color: white;
    }

    .badge-domaine {
        background-color: #3f8cff;
        color: white;
    }

    .badge-niveau {
        background-color: #2ecc71;
        color: white;
    }

    .badge-lieu {
        background-color: #f1c40f;
        color: white;
    }

    .contact-info {
        background-color: #f8f9fa;
        padding: 20px;
        border-radius: 8px;
        margin-top: 20px;
    }

    .entreprise-card {
        background-color: #fff;
        border-radius: 10px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        margin-bottom: 20px;
    }

    .entreprise-header {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        padding: 20px;
        border-radius: 10px 10px 0 0;
        border-bottom: 1px solid #dee2e6;
    }

    .stats-card {
        background-color: #fff;
        border-radius: 10px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        padding: 20px;
    }

    .stat-item {
        display: flex;
        align-items: center;
        margin-bottom: 15px;
    }

    .stat-icon {
        width: 40px;
        height: 40px;
        background-color: #f0f2f5;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 15px;
    }

    .stat-icon i {
        color: #4361ee;
        font-size: 1.2rem;
    }

    .stat-text {
        font-size: 1.1rem;
        color: #2c3e50;
    }

    .action-buttons {
        display: flex;
        justify-content: center;
        margin-top: 30px;
        padding-top: 20px;
        border-top: 1px solid #dee2e6;
    }

    .social-share-section {
        margin-top: 25px;
        text-align: center;
        padding: 15px;
        background-color: #f8f9fa;
        border-radius: 8px;
    }
    
    .social-title {
        font-size: 1rem;
        color: #6c757d;
        margin-bottom: 15px;
    }

    .share-buttons {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
        justify-content: center;
    }

    .btn-share {
        padding: 10px 15px;
        border-radius: 6px;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s ease;
        border: none;
        color: white;
    }

    .btn-share i {
        font-size: 1.1rem;
    }
    
    .btn-facebook {
        background-color: #1877F2;
    }
    
    .btn-facebook:hover {
        background-color: #0d6efd;
        color: white;
    }
    
    .btn-whatsapp {
        background-color: #25D366;
    }
    
    .btn-whatsapp:hover {
        background-color: #1fb655;
        color: white;
    }
    
    .btn-linkedin {
        background-color: #0A66C2;
    }
    
    .btn-linkedin:hover {
        background-color: #084c93;
        color: white;
    }
    
    .btn-postuler {
        background: linear-gradient(135deg, #4361ee 0%, #3a56d4 100%);
        color: white;
        border: none;
        padding: 12px 24px;
        border-radius: 6px;
        font-weight: 600;
        transition: all 0.3s ease;
        box-shadow: 0 4px 6px rgba(67, 97, 238, 0.2);
    }
    
    .btn-postuler:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 8px rgba(67, 97, 238, 0.3);
        background: linear-gradient(135deg, #3a56d4 0%, #2c46c2 100%);
    }
    
    .btn-postuler:active {
        transform: translateY(0);
    }
    
    .btn-postuler-disabled {
        background: linear-gradient(135deg, #6c757d 0%, #495057 100%);
        color: white;
        border: none;
        padding: 12px 24px;
        border-radius: 6px;
        font-weight: 600;
        box-shadow: 0 4px 6px rgba(108, 117, 125, 0.2);
        cursor: not-allowed;
    }
    
    @media (max-width: 768px) {
        .action-buttons {
            flex-direction: column;
            align-items: center;
            gap: 20px;
        }
        
        .share-buttons {
            width: 100%;
            justify-content: center;
        }
    }
</style>
@endpush

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-md-8">
            <div class="offre-detail">
                <div class="offre-header">
                    <h1 class="offre-title">{{ $annonce->nom_du_poste }}</h1>
                    <p class="offre-entreprise">{{ $annonce->entreprise }}</p>
                </div>
                <div class="offre-body">
                    <h5 class="section-title">Description du poste</h5>
                    <div class="description">
                        {!! nl2br(e($annonce->description)) !!}
                    </div>

                    <h5 class="section-title mt-4">Informations clés</h5>
                    <div class="badge-container">
                        <span class="badge badge-type">{{ $annonce->type_de_poste }}</span>
                        <span class="badge badge-domaine">{{ $annonce->domaine }}</span>
                        <span class="badge badge-niveau">{{ $annonce->niveau_detude }}</span>
                        <span class="badge badge-lieu">{{ $annonce->lieu }}</span>
                    </div>

                    <ul class="info-list">
                        <li>
                            <strong>Nombre de places:</strong>
                            <span>{{ $annonce->nombre_de_place }}</span>
                        </li>
                        <li>
                            <strong>Date de clôture:</strong>
                            <span>{{ $annonce->date_cloture?->format('d/m/Y') ?? 'Non spécifiée' }}</span>
                        </li>
                    </ul>

                   

                    <div class="action-buttons">
                        @if(Auth::check() && Auth::user()->etudiant)
                            @if($aPostule)
                                <button class="btn btn-postuler-disabled" disabled>
                                    <i class="fas fa-check-circle me-2"></i>Vous avez déjà postulé
                                </button>
                            @else
                                <a href="{{ route('etudiants.offres.postuler', $annonce) }}" class="btn btn-postuler">
                                    <i class="fas fa-paper-plane me-2"></i>Postuler
                                </a>
                            @endif
                        @else
                            <a href="{{ route('login') }}" class="btn btn-postuler">
                                <i class="fas fa-sign-in-alt me-2"></i>Connectez-vous pour postuler
                            </a>
                        @endif
                    </div>

                    <div class="social-share-section">
                        <h5 class="social-title">Partager cette offre</h5>
                        <div class="share-buttons">
                            <button class="btn btn-share btn-facebook" onclick="shareOnFacebook()">
                                <i class="fab fa-facebook-f"></i> Facebook
                            </button>
                            <button class="btn btn-share btn-whatsapp" onclick="shareOnWhatsApp()">
                                <i class="fab fa-whatsapp"></i> WhatsApp
                            </button>
                            <button class="btn btn-share btn-linkedin" onclick="shareOnLinkedIn()">
                                <i class="fab fa-linkedin-in"></i> LinkedIn
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="entreprise-card">
                <div class="entreprise-header">
                    <h5 class="section-title mb-0">À propos de l'entreprise</h5>
                </div>
                <div class="offre-body">
                    <h6 class="text-muted mb-3">{{ $annonce->entreprise  }}</h6>
                    <p class="mb-4">{{ $annonce->description ?? 'Aucune description disponible' }}</p>
                    <ul class="info-list">
                        <li>
                            <strong>Secteur:</strong>
                            <span>{{ $annonce->entreprise?->secteur ?? 'Non spécifié' }}</span>
                        </li>
                        <li>
                            <strong>Adresse:</strong>
                            <span>{{ $annonce->entreprise?->adresse ?? 'Non spécifiée' }}</span>
                        </li>
                        <li>
                            <strong>Email:</strong>
                            <span>{{ $annonce->entreprise?->email ?? 'Non spécifié' }}</span>
                        </li>
                        <li>
                            <strong>Téléphone:</strong>
                            <span>{{ $annonce->entreprise?->telephone ?? 'Non spécifié' }}</span>
                        </li>
                      @if(is_object($annonce->entreprise) && $annonce->entreprise->site_web)
    <li>
        <strong>Site web:</strong>
        <span>
            <a href="{{ $annonce->entreprise->site_web }}" target="_blank" class="text-decoration-none">
                {{ $annonce->entreprise->site_web }}
            </a>
        </span>
    </li>
@endif

                    </ul>
                </div>
            </div>

            <div class="stats-card">
                <h5 class="section-title mb-0">Statistiques</h5>
                <div class="mt-4">
                    <div class="stat-item">
                        <div class="stat-icon">
                            <i class="fas fa-eye"></i>
                        </div>
                        <div class="stat-text">{{ $annonce->nombre_vues }} vues</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="stat-text">{{ $annonce->candidatures->count() }} candidatures</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function shareOnFacebook() {
        const url = encodeURIComponent(window.location.href);
        window.open(`https://www.facebook.com/sharer/sharer.php?u=${url}`, '_blank');
    }

    function shareOnWhatsApp() {
        const url = encodeURIComponent(window.location.href);
        window.open(`https://wa.me/?text=${url}`, '_blank');
    }

    function shareOnLinkedIn() {
        const url = encodeURIComponent(window.location.href);
        window.open(`https://www.linkedin.com/sharing/share-offsite/?url=${url}`, '_blank');
    }
</script>
@endpush
@endsection