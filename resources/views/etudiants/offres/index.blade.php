@extends('layouts.etudiant.app')

@section('title', 'Offres d\'emploi')

@push('styles')
    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />
    <!-- Animation CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet" />
    <style>
        /* Personnalisation des cartes d'offres */
        .offre-card {
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            border: none;
            border-radius: 10px;
            overflow: hidden;
            height: 100%;
        }
        
        .offre-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }
        
        .offre-header {
            background: linear-gradient(to right, #f8f9fa, #e9ecef);
            padding: 15px 20px;
            border-bottom: 1px solid #dee2e6;
        }
        
        .offre-title {
            font-weight: 700;
            margin-bottom: 5px;
            color: #2c3e50;
        }
        
        .offre-subtitle {
            font-size: 0.9rem;
            color: #6c757d;
        }
        
        .offre-body {
            padding: 20px;
        }
        
        .offre-description {
            color: #495057;
            line-height: 1.6;
        }
        
        .offre-footer {
            background-color: #f8f9fa;
            padding: 12px 20px;
            border-top: 1px solid #edf2f7;
        }
        
        /* Styles pour les badges */
        .badge-container .badge {
            font-size: 0.8rem;
            padding: 6px 10px;
            border-radius: 50px;
            margin-right: 8px;
            margin-bottom: 8px;
            font-weight: 500;
        }
        
        .badge-contrat {
            background-color: #4361ee !important;
        }
        
        .badge-lieu {
            background-color: #3f8cff !important;
        }
        
        /* Style pour le formulaire de filtre */
        .filter-form {
            background-color: #f8f9fa;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 30px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.04);
        }
        
        /* Styles améliorés pour le champ de recherche */
        .filter-form .input-group {
            border-radius: 8px;
            overflow: hidden;
            height: 100%;
            display: flex;
            align-items: stretch;
        }
        
        .filter-form .input-group-text {
            background-color: #fff;
            border-right: none;
            display: flex;
            align-items: center;
            padding: 0 15px;
        }
        
        .filter-form .form-control,
        .filter-form .form-select,
        .filter-form .btn {
            border-radius: 8px;
            padding: 12px 15px;
            height: 46px; /* Hauteur fixe pour tous les éléments */
            display: flex;
            align-items: center;
        }

        /* Alignement spécifique pour Select2 */
        .select2-container--bootstrap-5 .select2-selection {
            height: 46px !important;
            border-radius: 8px !important;
            display: flex !important;
            align-items: center !important;
        }

        .select2-container--bootstrap-5 .select2-selection--single .select2-selection__rendered {
            line-height: 46px !important;
            padding-left: 15px !important;
        }
        
        .filter-form .form-control:focus,
        .filter-form .form-select:focus {
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.15);
        }
        
        .filter-form .btn-primary {
            background-color: #0d6efd;
            border-color: #0d6efd;
            transition: all 0.3s ease;
            height: 46px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .filter-form .btn-primary:hover {
            background-color: #0b5ed7;
            border-color: #0a58ca;
            transform: translateY(-2px);
        }
        
        /* Animation pour les cartes */
        .fade-in-up {
            animation: fadeInUp 0.6s ease forwards;
        }
        
        /* Personnalisation pagination */
        .pagination {
            justify-content: center;
        }
        
        .page-link {
            border-radius: 4px;
            margin: 0 2px;
            color: #3f8cff;
        }
        
        .page-item.active .page-link {
            background-color: #3f8cff;
            border-color: #3f8cff;
        }
    </style>
@endpush

@section('content')
<div class="container-fluid py-4 animate__animated animate__fadeIn">
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-bold text-primary"><i class="fas fa-briefcase me-2"></i>Offres d'emploi</h5>
                        <a href="{{ route('etudiants.offres.mes-candidatures') }}" class="btn btn-outline-primary btn-sm rounded-pill px-3">
                            <i class="fas fa-list me-1"></i> Mes candidatures
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Filtres et recherche -->
                    <form action="{{ route('etudiants.offres.index') }}" method="GET" class="filter-form mb-4">
                        <div class="row g-3 align-items-center">
                            <div class="col-md-4">
                                <div class="input-group h-100">
                                    <span class="input-group-text bg-white border border-end-0"><i class="fas fa-search text-primary"></i></span>
                                    <input type="text" name="search" class="form-control border-start-0" placeholder="Rechercher..." value="{{ request('search') }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <select name="lieu" class="form-select select2" data-placeholder="Tous les lieux">
                                    <option value="">Tous les lieux</option>
                                    @foreach($lieux as $lieu)
                                        <option value="{{ $lieu }}" {{ request('lieu') == $lieu ? 'selected' : '' }}>{{ $lieu }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select name="type_contrat" class="form-select select2" data-placeholder="Tous les types de contrat">
                                    <option value="">Tous les types de contrat</option>
                                    @foreach($typesContrat as $type)
                                        <option value="{{ $type }}" {{ request('type_contrat') == $type ? 'selected' : '' }}>{{ $type }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-primary w-100 d-flex align-items-center justify-content-center">
                                    <i class="fas fa-filter me-2"></i> Filtrer
                                </button>
                            </div>
                        </div>
                    </form>

                    <!-- Liste des offres -->
                    @if($offres->count() > 0)
                        <div class="row">
                            @foreach($offres as $key => $offre)
                                <div class="col-md-6 col-lg-4 mb-4">
                                    <div class="offre-card fade-in-up" style="animation-delay: {{ $key * 0.1 }}s">
                                        <div class="offre-header">
                                            <h5 class="offre-title">{{ $offre->titre }}</h5>
                                            <h6 class="offre-subtitle">{{ $offre->entreprise->nom ?? 'Entreprise non spécifiée' }}</h6>
                                        </div>
                                        <div class="offre-body">
                                            <div class="badge-container mb-3">
                                                <span class="badge badge-contrat">{{ $offre->type_contrat }}</span>
                                                @if($offre->lieu)
                                                    <span class="badge badge-lieu"><i class="fas fa-map-marker-alt me-1"></i>{{ $offre->lieu }}</span>
                                                @endif
                                            </div>
                                            
                                            <p class="offre-description">{{ Str::limit($offre->description, 150) }}</p>
                                        </div>
                                        <div class="offre-footer d-flex justify-content-between align-items-center">
                                            <small class="text-muted">
                                                <i class="far fa-calendar-alt me-1"></i>
                                                Publiée le {{ $offre->created_at->format('d/m/Y') }}
                                            </small>
                                            <a href="{{ route('etudiants.offres.show', $offre->id) }}" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                                                <i class="fas fa-eye me-1"></i> Voir détails
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                        <!-- Pagination -->
                        <div class="d-flex justify-content-center mt-4">
                            {{ $offres->links() }}
                        </div>
                    @else
                        <div class="alert alert-info text-center py-4">
                            <i class="fas fa-info-circle fa-2x mb-3"></i>
                            <p class="mb-0">Aucune offre d'emploi ne correspond à vos critères de recherche.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialisation de Select2
        $(document).ready(function() {
            $('.select2').select2({
                theme: "bootstrap-5",
                width: '100%',
                dropdownParent: $('.filter-form'),
                language: {
                    noResults: function() {
                        return "Aucun résultat trouvé";
                    }
                }
            });
            
            // Animation au défilement
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('animate__fadeInUp');
                        observer.unobserve(entry.target);
                    }
                });
            }, {
                threshold: 0.1
            });
            
            document.querySelectorAll('.offre-card').forEach(card => {
                observer.observe(card);
            });
        });
    });
</script>
@endpush 