@extends('layouts.admin.app')

@section('title', 'StagesBENIN')

@push('styles')


@section('content')
<div class="tab-content active" id="catalogue-content" role="tabpanel" aria-labelledby="catalogue-tab">
    <div class="action-bar d-flex justify-content-between align-items-center">
        <h4 class="mb-0">Liste des Catalogues ({{ $catalogueItems->count() }})</h4>
        <div class="action-buttons">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#catalogueModal">
                <i class="fas fa-plus-circle me-1"></i> Ajouter au Catalogue
            </button>
            <input type="text" id="searchInput" class="form-control ms-3" placeholder="Recherche...">
        </div>
    </div>

    <div class="content-area table-responsive mt-3">
        @if ($catalogueItems->isNotEmpty())
            <table class="table table-bordered table-striped" id="catalogueTable">
                <thead>
                    <tr>
                        <th>Nom de l'Établissement</th>
                        <th>Secteur d'activité</th>
                        <th>Numéro</th>
                        <th>Localisation</th>
                        <th>Activité Principale</th>
                        <th>Statut</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($catalogueItems as $item)
                        <tr>
                            <td class="searchable">{{ $item->titre }}</td>
                             <td class="searchable">{{ $item->secteur_activite }}</td>
                             <td class="searchable">{{ $item->telephone ?? 'Non définir' }}</td>
                            <td class="searchable">{{ $item->localisation }}</td>
                            <td class="searchable">{{ $item->activite_principale }}</td>
                            <td>
                                <span class="badge {{ $item->is_blocked ? 'bg-danger' : 'bg-success' }}">
                                    {{ $item->is_blocked ? 'Bloqué' : 'Actif' }}
                                </span>
                            </td>
                            <td>
                                <div class="d-flex gap-1">
                                  <form action="{{ route('catalogues.block', $item->id) }}" method="POST">
    @csrf
    <button type="submit" class="btn btn-warning btn-sm">Bloquer/Débloquer</button>
</form>

                                    <form action="{{ route('catalogue.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Confirmer la suppression de cet élément ?')">
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
        @else
            <div class="alert alert-info text-center">
                Aucun élément trouvé dans le catalogue pour le moment.
            </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.getElementById("searchInput").addEventListener("keyup", function() {
        const value = this.value.toLowerCase();
        document.querySelectorAll("#catalogueTable tbody tr").forEach(row => {
            const found = [...row.querySelectorAll(".searchable")].some(cell => 
                cell.textContent.toLowerCase().includes(value)
            );
            row.style.display = found ? "" : "none";
        });
    });
</script>
@endpush
