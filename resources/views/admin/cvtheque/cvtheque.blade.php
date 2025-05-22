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
<<<<<<< Updated upstream
<div class="content-area table-responsive">
    <h4>CVthèque -  ({{ $cvProfiles->count() }} cv disponibles)</h4>

    {{-- Barre de recherche --}}
    <div class="mb-3">
        <input type="text" id="cvSearch" class="form-control" placeholder="Rechercher par nom, prénom, téléphone, formation ou niveau...">
    </div>

    @if ($cvProfiles->isEmpty())
        <div class="alert alert-info">Aucun CV disponible pour le moment.</div>
    @else
        <table class="table table-hover table-bordered align-middle" id="cvTable">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Email</th>
                    <th>Téléphone</th>
                    <th>Formation</th>
                    <th>Niveau</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($cvProfiles as $cvProfile)
                    <tr>
                        <td>{{ $cvProfile->etudiant->prenom ?? 'Non spécifié' }} {{ $cvProfile->etudiant->nom ?? 'Non spécifié' }}</td>
                        <td>{{ $cvProfile->etudiant->email ?? 'Non spécifié' }}</td>
                        <td>{{ $cvProfile->etudiant->telephone ?? 'Non spécifié' }}</td>
                        <td>{{ $cvProfile->etudiant->formation ?? 'Non spécifié' }}</td>
                        <td>{{ $cvProfile->etudiant->niveau ?? 'Non spécifié' }}</td>
                        <td>
                            <a href="{{ route('admin.cvtheque.view', $cvProfile->id) }}" class="btn btn-info btn-sm" title="Voir le CV">
                                <i class="fas fa-eye"></i> Voir
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
=======
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
>>>>>>> Stashed changes
</div>
@endsection

@push('scripts')
<script>
<<<<<<< Updated upstream
    // Fonction de recherche pour filtrer et mettre en évidence les résultats
    document.getElementById('cvSearch').addEventListener('keyup', function () {
        const searchTerm = this.value.toLowerCase();
        const rows = document.querySelectorAll('#cvTable tbody tr');

        rows.forEach(row => {
            const rowText = row.textContent.toLowerCase();
            if (rowText.includes(searchTerm)) {
                row.style.display = ''; // Montre la ligne
                row.style.backgroundColor = '#d0e7ff'; // Met en surbrillance bleu clair
            } else {
                row.style.display = 'none'; // Cache la ligne
                row.style.backgroundColor = ''; // Supprime la surbrillance
            }
        });
    });
=======
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
>>>>>>> Stashed changes
</script>
@endpush
