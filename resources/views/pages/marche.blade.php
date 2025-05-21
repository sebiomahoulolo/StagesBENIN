@extends('layouts.layout')
@section('title', 'StagesBENIN')
@section('content')
<div class="container py-5">
    <div class="row mb-5">
        <div class="col-12">
            <h6 class="display-4 fw-bold text-center position-relative">
                <span class="text-primary"> Les marchés public et privé</span>
                <span class="position-absolute start-50 translate-middle-x" style="bottom: -15px; width: 80px; height: 4px; background-color: var(--bs-primary);"></span>
            </h6>
        </div>
    </div>
<div class="row mb-4">
    <div class="col-md-6 mx-auto">
        <input type="text" class="form-control form-control-lg shadow-sm" id="searchInput" placeholder="Rechercher dans les marchés...">
    </div>
</div>
    @if(isset($actualites) && !$actualites->isEmpty())
        <div class="row g-4">
            @foreach($actualites as $actualite)
            <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                <div class="card h-100 border-0 card-enhanced">
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
                        <p class="card-text text-muted small mb-3">{{ Str::limit($actualite->mode_passation, 60) }}</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="meta small text-muted">
                                <i class="bi bi-calendar-event me-1"></i> {{ $actualite->date_publication->format('d/m/Y') }}
                            </div>
                            <div class="meta small text-muted">
                                <i class="bi bi-person me-1"></i> {{ $actualite->type_marche }}
                            </div>
                            
                        </div>
                    </div>
                    <div class="card-footer bg-white border-0 text-center p-3">
                        <a href="" class="btn btn-outline-primary rounded-pill px-4 read-more-btn">
                            <i class="bi bi-arrow-right-circle me-2"></i>Voir plus
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
        <div class="row mt-5">
            <div class="col-12 d-flex justify-content-center">
                {{ $actualites->links('pagination::bootstrap-5') }}
            </div>
        </div>
        
    @else
        <div class="row">
            <div class="col-md-8 mx-auto">
                <div class="alert alert-info shadow-lg rounded-4 p-4 text-center">
                    <i class="bi bi-info-circle-fill fs-1 d-block mb-3"></i>
                    <h4 class="alert-heading">Aucun marché public/privé n'est disponible pour le moment.</h4>
                    <p class="mb-0">Revenez bientôt pour découvrir nos marchés.</p>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection

@section('styles')
<style>
    /* Styles améliorés pour les cartes d'actualités */
    .card-enhanced {
        transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.07), 
                    0 6px 6px rgba(0, 0, 0, 0.06),
                    0 0 0 1px rgba(0, 0, 0, 0.02);
        border-radius: 16px !important;
        overflow: hidden;
        transform: translateY(0);
    }
    
    .card-enhanced:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 30px rgba(0, 0, 0, 0.12), 
                    0 10px 10px rgba(0, 0, 0, 0.08),
                    0 0 0 1px rgba(0, 0, 0, 0.03);
    }
    
    .image-wrapper {
        height: 220px;
        position: relative;
    }
    
    .image-wrapper::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(to bottom, rgba(0,0,0,0) 60%, rgba(0,0,0,0.05) 100%);
        z-index: 1;
    }
    .card-enhanced {
    border: 2px solid var(--bs-primary); /* bordure bleue */
    box-shadow: 0 10px 25px rgba(13, 110, 253, 0.15); /* ombre bleutée */
    transition: all 0.4s ease-in-out;
}

    .image-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.7s ease;
    }
    
    .card-enhanced:hover .image-wrapper img {
        transform: scale(1.08);
    }
    
    .category-badge {
        position: absolute;
        top: 15px;
        left: 15px;
        z-index: 10;
    }
    
    .category-badge .badge {
        box-shadow: 0 3px 8px rgba(0, 0, 0, 0.2);
        font-weight: 500;
    }
    
    .card-title {
        position: relative;
        padding-bottom: 12px;
    }
    
    .card-title::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 40px;
        height: 3px;
        background-color: var(--bs-primary);
        opacity: 0.7;
        transition: width 0.3s ease;
    }
    
    .card-enhanced:hover .card-title::after {
        width: 60px;
    }
    
    .read-more-btn {
        transition: all 0.35s ease;
        position: relative;
        overflow: hidden;
        z-index: 1;
        box-shadow: 0 4px 10px rgba(var(--bs-primary-rgb), 0.2);
    }
    
    .read-more-btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background-color: var(--bs-primary);
        transition: all 0.35s ease;
        z-index: -1;
    }
    
    .read-more-btn:hover {
        color: white;
        border-color: var(--bs-primary);
        transform: translateY(-3px);
        box-shadow: 0 6px 15px rgba(var(--bs-primary-rgb), 0.3) !important;
    }
    
    .read-more-btn:hover::before {
        left: 0;
    }
    
    /* Animation fade-in */
    @keyframes fadeIn {
        from { 
            opacity: 0; 
            transform: translateY(30px); 
        }
        to { 
            opacity: 1; 
            transform: translateY(0); 
        }
    }
    
    .card-enhanced {
        opacity: 0;
        animation: fadeIn 0.6s ease forwards;
    }
    
    /* Alert style */
    .alert-info {
        background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);
        border-left: 5px solid var(--bs-primary);
    }
    
    /* Responsive adjustments */
    @media (max-width: 767.98px) {
        .image-wrapper {
            height: 180px;
        }
        
        .card-enhanced {
            margin-bottom: 15px;
        }
    }
</style>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Animation pour les cartes au chargement
        const cards = document.querySelectorAll('.card-enhanced');
        cards.forEach((card, index) => {
            setTimeout(() => {
                card.style.opacity = '1';
                card.style.transform = 'translateY(0)';
            }, index * 150);
        });
        
        // Filtrage automatique des cartes
const searchInput = document.getElementById('searchInput');
searchInput.addEventListener('keyup', function() {
    const filter = this.value.toLowerCase();
    const cards = document.querySelectorAll('.card-enhanced');

    cards.forEach(card => {
        const title = card.querySelector('.card-title')?.textContent.toLowerCase() || '';
        const typeMarche = card.querySelector('.meta:last-child')?.textContent.toLowerCase() || '';
        const date = card.querySelector('.meta:first-child')?.textContent.toLowerCase() || '';
        const modePassation = card.querySelector('.card-text')?.textContent.toLowerCase() || '';
        
        if (title.includes(filter) || typeMarche.includes(filter) || date.includes(filter) || modePassation.includes(filter)) {
            card.parentElement.style.display = 'block'; // Affiche la colonne
        } else {
            card.parentElement.style.display = 'none'; // Cache la colonne
        }
    });
});

        // Effet hover pour les boutons
        const readMoreBtns = document.querySelectorAll('.read-more-btn');
        readMoreBtns.forEach(btn => {
            btn.addEventListener('mouseenter', function() {
                this.querySelector('i').classList.remove('bi-arrow-right-circle');
                this.querySelector('i').classList.add('bi-arrow-right-circle-fill');
            });
            
            btn.addEventListener('mouseleave', function() {
                this.querySelector('i').classList.remove('bi-arrow-right-circle-fill');
                this.querySelector('i').classList.add('bi-arrow-right-circle');
            });
        });
    });
</script>
@endsection