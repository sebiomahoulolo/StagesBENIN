@extends('layouts.layout')
@section('title', 'StagesBENIN - Actualités')
@section('content')
<div class="container py-5">
    <div class="row mb-5">
        <div class="col-12">
            <h1 class="display-4 fw-bold text-center position-relative">
                <span class="text-primary">Actualités</span>
                <span class="position-absolute start-50 translate-middle-x" style="bottom: -15px; width: 80px; height: 4px; background-color: var(--bs-primary);"></span>
            </h1>
        </div>
    </div>

    @if(isset($actualites) && !$actualites->isEmpty())
        <div class="row g-4">
            @foreach($actualites as $actualite)
            <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                <div class="card h-100 shadow-lg rounded-3 border-0 hover-card">
                    @if($actualite->image_path)
                    <div class="image-wrapper position-relative overflow-hidden">
                        <img src="{{ asset('images/actualites/' . $actualite->image_path) }}" 
                             alt="{{ $actualite->titre }}" 
                             class="card-img-top img-fluid" 
                             loading="lazy">
                        <div class="category-badge">
                            <span class="badge bg-primary rounded-pill px-3 py-2">{{ $actualite->categorie }}</span>
                        </div>
                    </div>
                    @endif
                    <div class="card-body p-4">
                        <h5 class="card-title fw-bold text-truncate mb-3">{{ $actualite->titre }}</h5>
                        <p class="card-text text-muted small mb-3">{{ Str::limit($actualite->contenu, 60) }}</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="meta small text-muted">
                                <i class="bi bi-calendar-event me-1"></i> {{ $actualite->date_publication->format('d/m/Y') }}
                            </div>
                            <div class="meta small text-muted">
                                <i class="bi bi-person me-1"></i> {{ $actualite->auteur }}
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-white border-0 text-center p-3">
                        <button class="btn btn-outline-primary rounded-pill px-4 read-more-btn shadow-sm" 
                                data-bs-toggle="modal" 
                                data-bs-target="#modalActualite{{ $actualite->id }}">
                            <i class="bi bi-eye me-2"></i>Voir plus
                        </button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
    @else
        <div class="row">
            <div class="col-md-8 mx-auto">
                <div class="alert alert-info shadow-sm rounded-3 p-4 text-center">
                    <i class="bi bi-info-circle-fill fs-1 d-block mb-3"></i>
                    <h4 class="alert-heading">Aucune actualité disponible</h4>
                    <p class="mb-0">Revenez bientôt pour découvrir nos dernières actualités.</p>
                </div>
            </div>
        </div>
    @endif
</div>

<!-- Modals dynamiques pour chaque actualité -->
@foreach($actualites as $actualite)
<div class="modal fade" id="modalActualite{{ $actualite->id }}" tabindex="-1" aria-labelledby="modalLabel{{ $actualite->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg">
        
            <div class="modal-body p-4">
                <div class="d-flex justify-content-between align-items-center mb-4 pb-3 border-bottom">
                    <div>
                        <span class="badge bg-primary rounded-pill px-3 py-2 mb-2">{{ $actualite->categorie }}</span>
                        <p class="text-muted mb-0 small">
                            <i class="bi bi-calendar-event me-1"></i> {{ $actualite->date_publication->format('d/m/Y') }}
                            <span class="mx-2">|</span>
                            <i class="bi bi-person me-1"></i> {{ $actualite->auteur }}
                        </p>
                    </div>
                    <div class="share-buttons">
                        <button class="btn btn-sm btn-outline-secondary rounded-circle share-btn shadow-sm" data-type="facebook" data-url="{{ url('/actualites/' . $actualite->id) }}" data-title="{{ $actualite->titre }}" title="Partager sur Facebook">
                            <i class="bi bi-facebook"></i>
                        </button>
                        <button class="btn btn-sm btn-outline-secondary rounded-circle share-btn shadow-sm" data-type="twitter" data-url="{{ url('/actualites/' . $actualite->id) }}" data-title="{{ $actualite->titre }}" title="Partager sur Twitter">
                            <i class="bi bi-twitter"></i>
                        </button>
                        <button class="btn btn-sm btn-outline-secondary rounded-circle share-btn shadow-sm" data-type="whatsapp" data-url="{{ url('/actualites/' . $actualite->id) }}" data-title="{{ $actualite->titre }}" title="Partager sur WhatsApp">
                            <i class="bi bi-whatsapp"></i>
                        </button>
                        <button class="btn btn-sm btn-outline-secondary rounded-circle share-btn shadow-sm" data-type="email" data-url="{{ url('/actualites/' . $actualite->id) }}" data-title="{{ $actualite->titre }}" title="Partager par email">
                            <i class="bi bi-envelope"></i>
                        </button>
                    </div>
                </div>
                
                @if($actualite->image_path)
                <div class="text-center mb-4">
                    <img src="{{ asset('images/actualites/' . $actualite->image_path) }}" 
                         alt="{{ $actualite->titre }}" 
                         class="img-fluid rounded shadow-sm" 
                         style="max-height: 400px; width: auto;">
                </div>
                @endif
                
                <div class="article-content">
                    {{ $actualite->contenu }}
                </div>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-secondary rounded-pill px-4 shadow-sm" data-bs-dismiss="modal">
                    <i class="bi bi-x-lg me-2"></i>Fermer
                </button>
            </div>
        </div>
    </div>
</div>
@endforeach
@endsection

@section('styles')
<style>
    /* Styles pour les cartes d'actualités */
    .hover-card {
        transition: all 0.3s ease;
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.08) !important;
    }
    body {
        font-family: 'Times New Roman', Times, serif;
    }
    
    .hover-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 25px rgba(0, 0, 0, 0.15) !important;
    }
    
    .image-wrapper {
        height: 200px;
    }
    
    .image-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }
    
    .hover-card:hover .image-wrapper img {
        transform: scale(1.05);
    }
    
    .category-badge {
        position: absolute;
        top: 15px;
        left: 15px;
        z-index: 10;
    }
    
    .read-more-btn {
        transition: all 0.3s ease;
    }
    
    .read-more-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1) !important;
    }
    
    /* Styles pour le modal */
    .modal-content {
        border-radius: 12px;
    }
    
    .article-content {
        line-height: 1.8;
        font-size: 1.05rem;
    }
    
    .share-buttons .btn {
        width: 35px;
        height: 35px;
        margin-left: 5px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s ease;
    }
    
    .share-buttons .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1) !important;
    }
    
    .share-buttons .btn[data-type="facebook"]:hover {
        background-color: #3b5998;
        border-color: #3b5998;
        color: white;
    }
    
    .share-buttons .btn[data-type="twitter"]:hover {
        background-color: #1da1f2;
        border-color: #1da1f2;
        color: white;
    }
    
    .share-buttons .btn[data-type="whatsapp"]:hover {
        background-color: #25d366;
        border-color: #25d366;
        color: white;
    }
    
    .share-buttons .btn[data-type="email"]:hover {
        background-color: #777;
        border-color: #777;
        color: white;
    }
    
    /* Animation fade-in */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    .card {
        animation: fadeIn 0.5s ease forwards;
    }
    
    /* Responsive adjustments */
    @media (max-width: 767.98px) {
        .image-wrapper {
            height: 180px;
        }
        
        .modal-dialog {
            margin: 0.5rem;
        }
    }
</style>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Animation pour les cartes au chargement
        const cards = document.querySelectorAll('.hover-card');
        cards.forEach((card, index) => {
            setTimeout(() => {
                card.style.opacity = '1';
                card.style.transform = 'translateY(0)';
            }, index * 100);
        });
        
        // Initialisation des tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });
        
        // Fonctionnalité de partage
        const shareButtons = document.querySelectorAll('.share-btn');
        shareButtons.forEach(button => {
            button.addEventListener('click', function() {
                const type = this.getAttribute('data-type');
                const url = encodeURIComponent(this.getAttribute('data-url'));
                const title = encodeURIComponent(this.getAttribute('data-title'));
                
                let shareUrl = '';
                
                switch(type) {
                    case 'facebook':
                        shareUrl = `https://www.facebook.com/sharer/sharer.php?u=${url}`;
                        break;
                    case 'twitter':
                        shareUrl = `https://twitter.com/intent/tweet?url=${url}&text=${title}`;
                        break;
                    case 'whatsapp':
                        shareUrl = `https://api.whatsapp.com/send?text=${title}%20${url}`;
                        break;
                    case 'email':
                        shareUrl = `mailto:?subject=${title}&body=Découvrez cet article : ${url}`;
                        break;
                }
                
                if (shareUrl) {
                    window.open(shareUrl, '_blank', 'width=600,height=400');
                }
            });
        });
    });
</script>
@endsection