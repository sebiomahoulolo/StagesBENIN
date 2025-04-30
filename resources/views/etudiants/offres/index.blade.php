@extends('layouts.etudiant.app')

@section('title', 'Offres d\'emploi')

@push('styles')
    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />
    <!-- Animation CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet" />
    <style>
        /* Styles généraux de la page */
        .filter-section {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            padding: 25px;
            margin-bottom: 20px;
            position: sticky;
            top: 20px;
            height: fit-content;
        }

        .filter-section h5 {
            color: #2c3e50;
            font-weight: 600;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #f0f2f5;
        }

        .form-label {
            font-weight: 500;
            color: #34495e;
            margin-bottom: 8px;
        }

        .form-control, .form-select {
            border-radius: 8px;
            border: 1px solid #e0e0e0;
            padding: 10px 15px;
            transition: all 0.3s ease;
        }

        .form-control:focus, .form-select:focus {
            border-color: #3498db;
            box-shadow: 0 0 0 0.2rem rgba(52, 152, 219, 0.25);
        }

        .filter-btn {
            background: #3498db;
            border: none;
            border-radius: 8px;
            padding: 12px 20px;
            color: white;
            font-weight: 500;
            transition: all 0.3s ease;
            width: 100%;
            margin-top: 10px;
        }

        .filter-btn:hover {
            background: #2980b9;
            transform: translateY(-2px);
        }

        .filter-group {
            margin-bottom: 20px;
        }

        .filter-group:last-child {
            margin-bottom: 0;
        }

        .search-icon {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #95a5a6;
        }

        .input-with-icon {
            position: relative;
        }

        .input-with-icon input {
            padding-left: 40px;
        }

        /* Styles des cartes d'offres */
        .offre-card-item {
            border: 1px solid #e0e0e0;
            border-radius: 12px;
            margin-bottom: 20px;
            background-color: #fff;
            transition: all 0.3s ease;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        }

        .offre-card-item:hover {
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            transform: translateY(-4px);
            border-color: #3498db;
        }

        .offre-card-header {
            padding: 20px;
            border-bottom: 1px solid #f0f2f5;
        }

        .offre-card-title a {
            font-size: 1.25rem;
            font-weight: 600;
            color: #2c3e50;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .offre-card-title a:hover {
            color: #3498db;
        }

        .offre-card-entreprise {
            font-size: 0.9rem;
            color: #7f8c8d;
            margin-bottom: 10px;
        }

        .offre-card-body {
            padding: 20px;
        }

        .badge-container {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-bottom: 15px;
        }

        .badge {
            padding: 6px 12px;
            border-radius: 50px;
            font-size: 0.8rem;
            font-weight: 500;
        }

        .badge-type-poste {
            background-color: #3498db;
            color: white;
        }

        .badge-secteur {
            background-color: #2ecc71;
            color: white;
        }

        .badge-specialite {
            background-color: #9b59b6;
            color: white;
        }

        .badge-niveau-etude {
            background-color: #f1c40f;
            color: white;
        }

        .badge-lieu {
            background-color: #e67e22;
            color: white;
        }

        .badge-salaire {
            background-color: #e74c3c;
            color: white;
        }

        .offre-card-footer {
            padding: 15px 20px;
            background-color: #f8f9fa;
            border-top: 1px solid #f0f2f5;
            border-radius: 0 0 12px 12px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .date-cloture {
            font-size: 0.85rem;
            color: #7f8c8d;
        }

        .date-cloture i {
            margin-right: 5px;
        }

        .btn-voir-offre {
            background-color: #3498db;
            border-color: #3498db;
            color: white;
            font-weight: 500;
            padding: 8px 18px;
            font-size: 0.9rem;
            border-radius: 6px;
            transition: all 0.3s ease;
        }

        .btn-voir-offre:hover {
            background-color: #2980b9;
            border-color: #2980b9;
            transform: translateY(-2px);
        }

        .list-card-header {
            background: #fff;
            border-bottom: 1px solid #f0f2f5;
            padding: 20px;
            border-radius: 10px 10px 0 0;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            margin-bottom: 20px;
        }

        .list-card-body {
            background: #f9fbfd;
            padding: 20px;
            border-radius: 0 0 10px 10px;
        }

        .pagination {
            margin-top: 30px;
        }

        .page-link {
            border-radius: 6px;
            margin: 0 3px;
            color: #3498db;
            border: 1px solid #e0e0e0;
        }

        .page-item.active .page-link {
            background-color: #3498db;
            border-color: #3498db;
        }

        /* Animation */
        .animate__fadeInUp {
            animation-duration: 0.6s;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .container {
                padding: 0;
            }
            
            .row {
                margin: 0;
            }
            
            .col-md-3, .col-md-9 {
                padding: 0;
            }
            
            .filter-section {
                position: relative;
                top: 0;
                margin: 0 0 20px 0;
                border-radius: 0;
            }
            
            .list-card-header, .list-card-body {
                border-radius: 0;
            }
            
            .offre-card-item {
                margin: 10px;
            }
        }
    </style>
@endpush

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-md-4">
            <div class="filter-section">
                <h5><i class="fas fa-filter me-2"></i>Filtres de recherche</h5>
                <form action="{{ route('etudiants.offres.index') }}" method="GET">
                    <div class="filter-group">
                        <label for="search" class="form-label">Recherche par mots-clés</label>
                        <div class="input-with-icon">
                            <i class="fas fa-search search-icon"></i>
                            <input type="text" class="form-control" id="search" name="search" 
                                   value="{{ request('search') }}" placeholder="Poste, compétence...">
                        </div>
                    </div>

                    <div class="filter-group">
                        <label for="secteur_id" class="form-label">Secteur d'activité</label>
                        <select class="form-select select2" id="secteur_id" name="secteur_id">
                            <option value="">Tous les secteurs</option>
                            @foreach($secteurs as $secteur)
                                <option value="{{ $secteur->id }}" {{ request('secteur_id') == $secteur->id ? 'selected' : '' }}>
                                    {{ $secteur->nom }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="filter-group">
                        <label for="specialite_id" class="form-label">Spécialité</label>
                        <select class="form-select select2" id="specialite_id" name="specialite_id">
                            <option value="">Toutes les spécialités</option>
                            @if(request('secteur_id'))
                                @foreach($specialites as $specialite)
                                    <option value="{{ $specialite->id }}" {{ request('specialite_id') == $specialite->id ? 'selected' : '' }}>
                                        {{ $specialite->nom }}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                    </div>

                    <div class="filter-group">
                        <label for="type_de_poste" class="form-label">Type de poste</label>
                        <select class="form-select" id="type_de_poste" name="type_de_poste">
                            <option value="">Tous les types</option>
                            <option value="Stage" {{ request('type_de_poste') == 'Stage' ? 'selected' : '' }}>Stage</option>
                            <option value="Emploi" {{ request('type_de_poste') == 'Emploi' ? 'selected' : '' }}>Emploi</option>
                            <option value="Alternance" {{ request('type_de_poste') == 'Alternance' ? 'selected' : '' }}>Alternance</option>
                        </select>
                    </div>

                    <div class="filter-group">
                        <label for="niveau_detude" class="form-label">Niveau d'étude requis</label>
                        <select class="form-select" id="niveau_detude" name="niveau_detude">
                            <option value="">Tous les niveaux</option>
                            <option value="BEPC" {{ request('niveau_detude') == 'BEPC' ? 'selected' : '' }}>BEPC</option>
                            <option value="CAP" {{ request('niveau_detude') == 'CAP' ? 'selected' : '' }}>CAP</option>
                            <option value="BAC" {{ request('niveau_detude') == 'BAC' ? 'selected' : '' }}>BAC</option>
                            <option value="BAC+1" {{ request('niveau_detude') == 'BAC+1' ? 'selected' : '' }}>BAC+1</option>
                            <option value="BAC+2" {{ request('niveau_detude') == 'BAC+2' ? 'selected' : '' }}>BAC+2</option>
                            <option value="BAC+3" {{ request('niveau_detude') == 'BAC+3' ? 'selected' : '' }}>BAC+3</option>
                            <option value="BAC+4" {{ request('niveau_detude') == 'BAC+4' ? 'selected' : '' }}>BAC+4</option>
                            <option value="BAC+5" {{ request('niveau_detude') == 'BAC+5' ? 'selected' : '' }}>BAC+5</option>
                            <option value="Doctorat" {{ request('niveau_detude') == 'Doctorat' ? 'selected' : '' }}>Doctorat</option>
                        </select>
                    </div>

                    <div class="filter-group">
                        <label for="lieu" class="form-label">Localisation</label>
                        <input type="text" class="form-control" id="lieu" name="lieu" 
                               value="{{ request('lieu') }}" placeholder="Ex: Cotonou, Porto-Novo...">
                    </div>

                    <button type="submit" class="filter-btn">
                        <i class="fas fa-search me-2"></i>Appliquer les filtres
                    </button>
                </form>
            </div>
        </div>

        <div class="col-md-6">
            <div class="list-card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Offres d'emploi</h5>
                    <a href="{{ route('etudiants.candidatures.index') }}" class="btn btn-outline-primary">
                        <i class="fas fa-file-alt me-1"></i> Mes candidatures
                    </a>
                </div>
            </div>
            <div class="list-card-body">
                @if($annonces->isEmpty())
                    <div class="text-center py-5">
                        <i class="fas fa-search fa-3x text-muted mb-3"></i>
                        <h5>Aucune offre ne correspond à vos critères</h5>
                        <p class="text-muted">Essayez de modifier vos filtres de recherche</p>
                    </div>
                @else
                    @foreach($annonces as $annonce)
                        <div class="offre-card-item animate__animated animate__fadeInUp" style="animation-delay: {{ $loop->index * 0.05 }}s">
                            <div class="offre-card-header">
                                <h5 class="offre-card-title mb-1">
                                    <a href="{{ route('etudiants.offres.show', $annonce) }}">
                                        {{ $annonce->nom_du_poste }}
                                    </a>
                                </h5>
                                <p class="offre-card-entreprise">{{ $annonce->entreprise?->nom ?? 'Entreprise non spécifiée' }}</p>
                            </div>
                            <div class="offre-card-body">
                                <div class="badge-container">
                                    <span class="badge badge-type-poste">{{ $annonce->type_de_poste }}</span>
                                    <span class="badge badge-secteur">{{ $annonce->secteur?->nom ?? 'Secteur non spécifié' }}</span>
                                    <span class="badge badge-specialite">{{ $annonce->specialite?->nom ?? 'Spécialité non spécifiée' }}</span>
                                    <span class="badge badge-niveau-etude">{{ $annonce->niveau_detude }}</span>
                                    <span class="badge badge-lieu">{{ $annonce->lieu }}</span>
                                </div>
                            </div>
                            <div class="offre-card-footer">
                                <span class="date-cloture">
                                    <i class="fas fa-clock"></i>
                                    Clôture le {{ $annonce->date_cloture?->format('d/m/Y') ?? 'Non spécifiée' }}
                                </span>
                                <a href="{{ route('etudiants.offres.show', $annonce) }}" class="btn btn-voir-offre">
                                    Voir l'offre <i class="fas fa-arrow-right ms-1"></i>
                                </a>
                            </div>
                        </div>
                    @endforeach
                    
                    <div class="d-flex justify-content-center mt-4">
                        {{ $annonces->links() }}
                    </div>
                @endif
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
        $('.select2').select2({
            theme: "bootstrap-5",
            width: '100%',
            language: {
                noResults: function() {
                    return "Aucun résultat trouvé";
                }
            }
        });

        // Gestion dynamique des spécialités
        $('#secteur_id').on('change', function() {
            const secteurId = $(this).val();
            const specialiteSelect = $('#specialite_id');
            
            specialiteSelect.empty().append('<option value="">Toutes les spécialités</option>');
            
            if (secteurId) {
                fetch(`/api/specialites/${secteurId}`)
                    .then(response => response.json())
                    .then(specialites => {
                        specialites.forEach(specialite => {
                            specialiteSelect.append(
                                $('<option></option>')
                                    .val(specialite.id)
                                    .text(specialite.nom)
                            );
                        });
                    })
                    .catch(error => {
                        console.error('Erreur lors du chargement des spécialités:', error);
                    });
            }
        });

        // Si un secteur est déjà sélectionné (en cas d'erreur de validation)
        if ($('#secteur_id').val()) {
            $('#secteur_id').trigger('change');
        }

        // Soumission automatique du formulaire lors du changement de filtre
        $('.form-select, .form-control').on('change', function() {
            $(this).closest('form').submit();
        });
    });
</script>
@endpush 