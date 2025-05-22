@extends('layouts.admin.app')

@section('title', 'CVthèque - StagesBENIN')

@push('styles')
<style>
    .specialite-card {
        transition: transform 0.2s;
        cursor: pointer;
    }
    .specialite-card:hover {
        transform: translateY(-5px);
    }
    .badge-count {
        font-size: 1.1rem;
        padding: 0.5rem 1rem;
    }
    .search-container {
        background: #f8f9fa;
        padding: 1.5rem;
        border-radius: 0.5rem;
        margin-bottom: 1.5rem;
    }
    .filter-section {
        margin-top: 1rem;
    }
    .highlight {
        background-color: #fff3cd;
        padding: 0.2rem;
        border-radius: 0.2rem;
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="search-container">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="specialiteSearch" class="form-label">Rechercher une spécialité</label>
                            <input type="text" id="specialiteSearch" class="form-control" placeholder="Entrez le nom de la spécialité...">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row" id="specialitesGrid">
        @forelse($specialites as $specialite)
            <div class="col-md-4 col-lg-3 mb-4 specialite-item">
                <div class="card specialite-card h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="card-title mb-0">{{ $specialite->nom }}</h5>
                            <span class="badge bg-primary badge-count">
                                {{ $specialite->nombre_etudiants ?? 0 }}
                            </span>
                        </div>
                        <p class="card-text text-muted mb-2">
                            Secteur: {{ $specialite->secteur->nom ?? 'Non spécifié' }}
                        </p>
                        <a href="{{ route('admin.cvtheque.specialite', $specialite->id) }}" class="btn btn-primary w-100">
                            Voir les étudiants
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i>
                    Aucune spécialité disponible pour le moment.
                </div>
            </div>
        @endforelse
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Fonction de recherche
    $('#specialiteSearch').on('keyup', function() {
        const searchTerm = $(this).val().toLowerCase();

        $('.specialite-item').each(function() {
            const $item = $(this);
            const cardTitle = $item.find('.card-title').text().toLowerCase();
            const cardText = $item.find('.card-text').text().toLowerCase();

            if (cardTitle.includes(searchTerm) || cardText.includes(searchTerm)) {
                $item.show();

                // Mettre en surbrillance le texte recherché
                if (searchTerm) {
                    $item.find('.card-title').html(
                        $item.find('.card-title').text().replace(
                            new RegExp(searchTerm, 'gi'),
                            match => `<span class="highlight">${match}</span>`
                        )
                    );

                    $item.find('.card-text').html(
                        $item.find('.card-text').text().replace(
                            new RegExp(searchTerm, 'gi'),
                            match => `<span class="highlight">${match}</span>`
                        )
                    );
                }
            } else {
                $item.hide();
            }
        });
    });
});
</script>
@endpush
