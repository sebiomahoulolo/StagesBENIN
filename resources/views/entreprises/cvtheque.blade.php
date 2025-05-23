@extends('layouts.entreprises.master')

@section('title', 'CV-thèque - StagesBENIN')

@section('content')
<div class="content-area table-responsive">
    <h1 class="dashboard-title">CV-thèque</h1>

    @if(isset($tiers) && $tiers->count() > 0)
        <p>{{ $tiers->count() }} CV disponibles</p>
    @endif

    {{-- Barre de recherche --}}
    <div class="mb-4">
        <div class="input-group">
            <span class="input-group-text"><i class="fas fa-search"></i></span>
            <input type="text" id="cvSearch" class="form-control" placeholder="Rechercher par nom, prénom, téléphone, formation ou niveau...">
        </div>
    </div>

    @if(!isset($tiers) || $tiers->isEmpty())
        <div class="alert alert-info">
            <i class="fas fa-info-circle me-2"></i>
            Aucun CV disponible pour le moment.
        </div>
    @else
        <div class="card">
            <div class="card-body p-0">
                <table class="table table-hover table-striped mb-0" id="cvTable">
                    <thead class="table-light">
                        <tr>
                            <th>Nom & Prénom</th>
                            <th>Contact</th>
                            <th>Formation</th>
                            <th>Niveau</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tiers as $tier)
                            <tr>
                                <td>
                                    <div class="fw-bold">{{ $tier->prenom ?? '' }} {{ $tier->nom ?? '' }}</div>
                                </td>
                                <td>
                                    <div><i class="fas fa-envelope me-1 text-muted small"></i> {{ $tier->email ?? 'Non spécifié' }}</div>
                                    <div><i class="fas fa-phone me-1 text-muted small"></i> {{ $tier->telephone ?? 'Non spécifié' }}</div>
                                </td>
                                <td>{{ $tier->formation ?? 'Non spécifié' }}</td>
                                <td>{{ $tier->niveau ?? 'Non spécifié' }}</td>
                                <td>
                                    <a href="{{ route('admin.cvtheque.view', $tier->etudiant_id) }}" class="btn btn-primary btn-sm" title="Voir le CV">
                                        <i class="fas fa-eye"></i> Consulter
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        @if(isset($tiers) && method_exists($tiers, 'links'))
            <div class="mt-4">
                {{ $tiers->links() }}
            </div>
        @endif
    @endif
</div>
@endsection

@push('styles')
<style>
    .content-area {
        background-color: white;
        border-radius: 8px;
        padding: 25px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    }

    .table th {
        font-weight: 600;
        color: #333;
    }

    .table td {
        vertical-align: middle;
    }

    /* Style pour la mise en surbrillance des résultats de recherche */
    tr.highlight {
        background-color: rgba(52, 152, 219, 0.1) !important;
    }
</style>
@endpush

@push('scripts')
<script>
    // Fonction de recherche pour filtrer et mettre en évidence les résultats
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('cvSearch');
        if (!searchInput) return;

        searchInput.addEventListener('keyup', function() {
            const searchTerm = this.value.toLowerCase().trim();
            const rows = document.querySelectorAll('#cvTable tbody tr');

            if (rows.length === 0) return;

            let found = false;

            rows.forEach(row => {
                const rowText = row.textContent.toLowerCase();
                const match = rowText.includes(searchTerm);

                // Afficher/cacher la ligne en fonction du résultat
                row.style.display = match || searchTerm === '' ? '' : 'none';

                // Appliquer la classe de surbrillance
                if (match && searchTerm !== '') {
                    row.classList.add('highlight');
                    found = true;
                } else {
                    row.classList.remove('highlight');
                }
            });

            // Afficher un message si aucun résultat trouvé
            const noResultsMsg = document.getElementById('noResultsMsg');
            if (!noResultsMsg && !found && searchTerm !== '') {
                const table = document.getElementById('cvTable');
                const tbody = table.querySelector('tbody');
                const noResults = document.createElement('tr');
                noResults.id = 'noResultsMsg';
                noResults.innerHTML = `<td colspan="5" class="text-center py-3">Aucun résultat pour "${searchTerm}"</td>`;
                tbody.appendChild(noResults);
            } else if (noResultsMsg && (found || searchTerm === '')) {
                noResultsMsg.remove();
            }
        });
    });
</script>
@endpush