@extends('layouts.admin.app')

@section('title', 'StagesBENIN')

@push('styles')


@section('content')
<div class="tab-content active" id="actualites-content" role="tabpanel" aria-labelledby="actualites-tab">
    <div class="action-bar d-flex justify-content-between align-items-center">
        <h4 class="mb-0">Liste des Actualités (<span id="totalActualites">{{ $actualites->count() }}</span>)</h4>
        <div class="action-buttons">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#actualiteModal">
                <i class="fas fa-plus-circle me-1"></i> Ajouter Actualité
            </button>
            <input type="text" id="searchInput" class="form-control ms-3" placeholder="Recherche par titre, catégorie ou auteur...">
        </div>
    </div>

    <div class="content-area table-responsive mt-3">
        @if ($actualites->isNotEmpty())
            <table class="table table-hover table-bordered align-middle" id="actualiteTable">
                <thead>
                    <tr>
                        <th>Titre</th>
                        <th>Catégorie</th>
                        <th>Auteur</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($actualites as $actualite)
                        <tr>
                            <td class="searchable">{{ $actualite->titre }}</td>
                            <td class="searchable">{{ $actualite->categorie ?? '-' }}</td>
                            <td class="searchable">{{ $actualite->auteur ?? '-' }}</td>
                            <td class="searchable">
                                {{ $actualite->date_publication ? \Carbon\Carbon::parse($actualite->date_publication)->isoFormat('DD MMM YYYY') : '-' }}
                            </td>
                            <td>
                                <div class="d-flex gap-1">
                                    <a href="{{ route('actualites.edit', $actualite->id) }}" class="btn btn-warning btn-sm" data-bs-toggle="tooltip" title="Modifier">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('actualites.destroy', $actualite->id) }}" method="POST" style="display: inline-block;" onsubmit="return confirm('Confirmer la suppression de cette actualité ?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" data-bs-toggle="tooltip" title="Supprimer">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $actualites->links() }} {{-- Pagination --}}
        @else
            <div class="alert alert-info text-center">Aucune actualité trouvée pour le moment.</div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.getElementById("searchInput").addEventListener("keyup", function() {
        const value = this.value.toLowerCase();
        let count = 0; // Compteur d'actualités affichées

        document.querySelectorAll("#actualiteTable tbody tr").forEach(row => {
            const found = [...row.querySelectorAll(".searchable")].some(cell => 
                cell.textContent.toLowerCase().includes(value)
            );
            row.style.display = found ? "" : "none";

            if (found) count++; // Incrémente le compteur si l'actualité est visible
        });

        document.getElementById("totalActualites").textContent = count; // Met à jour le total affiché
    });
</script>
@endpush
