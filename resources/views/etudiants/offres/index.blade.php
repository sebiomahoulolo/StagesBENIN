@extends('layouts.etudiant.app')

@section('title', 'Offres d\'emploi')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Offres d'emploi</h5>
                        <a href="{{ route('etudiants.offres.mes-candidatures') }}" class="btn btn-sm btn-outline-primary">
                            <i class="fas fa-list me-1"></i> Mes candidatures
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Filtres et recherche -->
                    <form action="{{ route('etudiants.offres.index') }}" method="GET" class="mb-4">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                                    <input type="text" name="search" class="form-control" placeholder="Rechercher..." value="{{ request('search') }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <select name="lieu" class="form-select">
                                    <option value="">Tous les lieux</option>
                                    @foreach($lieux as $lieu)
                                        <option value="{{ $lieu }}" {{ request('lieu') == $lieu ? 'selected' : '' }}>{{ $lieu }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select name="type_contrat" class="form-select">
                                    <option value="">Tous les types de contrat</option>
                                    @foreach($typesContrat as $type)
                                        <option value="{{ $type }}" {{ request('type_contrat') == $type ? 'selected' : '' }}>{{ $type }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-primary w-100">Filtrer</button>
                            </div>
                        </div>
                    </form>

                    <!-- Liste des offres -->
                    @if($offres->count() > 0)
                        <div class="row">
                            @foreach($offres as $offre)
                                <div class="col-md-6 col-lg-4 mb-4">
                                    <div class="card h-100">
                                        <div class="card-body">
                                            <h5 class="card-title">{{ $offre->titre }}</h5>
                                            <h6 class="card-subtitle mb-2 text-muted">{{ $offre->entreprise->nom ?? 'Entreprise non spécifiée' }}</h6>
                                            
                                            <div class="mb-3">
                                                <span class="badge bg-primary me-1">{{ $offre->type_contrat }}</span>
                                                @if($offre->lieu)
                                                    <span class="badge bg-info me-1"><i class="fas fa-map-marker-alt me-1"></i>{{ $offre->lieu }}</span>
                                                @endif
                                            </div>
                                            
                                            <p class="card-text">{{ Str::limit($offre->description, 150) }}</p>
                                            
                                            <div class="d-flex justify-content-between align-items-center mt-3">
                                                <small class="text-muted">
                                                    <i class="far fa-calendar-alt me-1"></i>
                                                    Publiée le {{ $offre->created_at->format('d/m/Y') }}
                                                </small>
                                                <a href="{{ route('etudiants.offres.show', $offre->id) }}" class="btn btn-sm btn-outline-primary">
                                                    Voir détails
                                                </a>
                                            </div>
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
                        <div class="alert alert-info text-center">
                            <i class="fas fa-info-circle me-2"></i>
                            Aucune offre d'emploi ne correspond à vos critères de recherche.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Script pour mettre à jour dynamiquement les filtres
    document.addEventListener('DOMContentLoaded', function() {
        // Vous pouvez ajouter ici du JavaScript pour améliorer l'expérience utilisateur
        // Par exemple, mettre à jour les résultats sans recharger la page
    });
</script>
@endpush 