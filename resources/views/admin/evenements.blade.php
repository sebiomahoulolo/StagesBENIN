@extends('layouts.admin.app')

@section('title', 'StagesBENIN')

@push('styles')

@section('content')
<div class="tab-content active" id="evenements-content" role="tabpanel" aria-labelledby="evenements-tab">
    <div class="action-bar d-flex justify-content-between align-items-center">
        <h4 class="mb-0">Liste des Événements (<span id="totalEvents">{{ $events->count() }}</span>)</h4>
        <div class="action-buttons">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#eventModal">
                <i class="fas fa-plus-circle me-1"></i> Ajouter Événement
            </button>
            <input type="text" id="searchInput" class="form-control ms-3" placeholder="Recherche par titre, lieu, type ou entreprise...">
        </div>
    </div>

    <div class="content-area table-responsive mt-3">
        @if ($events->isNotEmpty())
            <table class="table table-hover table-bordered align-middle" id="eventTable">
                <thead>
                    <tr>
                        <th>Titre</th>
                        <th>Début</th>
                        <th>Fin</th>
                        <th>Lieu</th>
                        <th>Type</th>
                        <th>Entreprise</th>
                        <th>Mail</th>
                        <th>Statut</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($events as $event)
                        <tr>
                            <td class="searchable">{{ $event->title }}</td>
                            <td class="searchable">{{ $event->start_date ? \Carbon\Carbon::parse($event->start_date)->isoFormat('DD MMM YYYY HH:mm') : '-' }}</td>
                            <td class="searchable">{{ $event->end_date ? \Carbon\Carbon::parse($event->end_date)->isoFormat('DD MMM YYYY HH:mm') : '-' }}</td>
                            <td class="searchable">{{ $event->location ?? 'Pas définir' }}</td>
                            <td class="searchable">{{ $event->type ?? 'Pas définir' }}</td>
                            <td class="searchable">{{ $event->user->name ?? 'Pas définir' }}</td>
                            <td class="searchable">{{ $event->user->email ?? 'Pas définir' }}</td>
                            <td>
                                <form action="{{ route('evenements.toggleStatus', $event->id) }}" method="POST" style="display: inline-block;">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-sm {{ $event->is_published ? 'btn-success' : 'btn-secondary' }} status"
                                        data-bs-toggle="tooltip" title="{{ $event->is_published ? 'Passer en privé' : 'Publier' }}">
                                        {{ $event->is_published ? 'Publié' : 'Privé' }}
                                    </button>
                                </form>
                            </td>
                            <td>
                                <div class="d-flex gap-1">
                                    <a href="{{ route('evenements.show', $event->id) }}" class="btn btn-info btn-sm" data-bs-toggle="tooltip" title="Voir">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('evenements.edit', $event->id) }}" class="btn btn-warning btn-sm" data-bs-toggle="tooltip" title="Modifier">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('evenements.destroy', $event->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Confirmer la suppression de cet événement ?')">
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
            {{ $events->links() }}
        @else
            <div class="alert alert-info text-center">Aucun événement trouvé pour le moment.</div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.getElementById("searchInput").addEventListener("keyup", function() {
        const value = this.value.toLowerCase();
        let count = 0;

        document.querySelectorAll("#eventTable tbody tr").forEach(row => {
            const found = [...row.querySelectorAll(".searchable")].some(cell => 
                cell.textContent.toLowerCase().includes(value)
            );
            row.style.display = found ? "" : "none";

            if (found) count++;
        });

        document.getElementById("totalEvents").textContent = count;
    });
</script>
@endpush
