        @extends('layouts.admin.app')

        @section('title', 'StagesBENIN')

        @push('styles')
            @section('content')
                <div class="tab-content active" id="evenements-content" role="tabpanel" aria-labelledby="evenements-tab">
                    <div class="action-bar">
                        <div class="action-buttons">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#eventModal">
                                <i class="fas fa-plus-circle me-1"></i> Ajouter Événement
                            </button>
                        </div>
                    </div>
                    <div class="content-area table-responsive">
                        <h4>Liste des Événements</h4>
                        {{-- Ensure $events is passed from the controller --}}
                        @if (isset($events) && !$events->isEmpty())
                            <table class="table table-hover table-bordered align-middle">
                                <thead>
                                    <tr>
                                        <th>Titre</th>
                                        <th>Début</th>
                                        <th>Fin</th>
                                        <th>Lieu</th>
                                        <th>Type</th>
                                        <th>Statut</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($events as $event)
                                        <tr>
                                            <td>{{ $event->title }}</td>
                                            <td>{{ $event->start_date ? \Carbon\Carbon::parse($event->start_date)->isoFormat('DD MMM YYYY HH:mm') : '-' }}
                                            </td>
                                            <td>{{ $event->end_date ? \Carbon\Carbon::parse($event->end_date)->isoFormat('DD MMM YYYY HH:mm') : '-' }}
                                            </td>
                                            <td>{{ $event->location ?? '-' }}</td>
                                            <td>{{ $event->type ?? '-' }}</td>
                                            <td>
                                                {{-- Status Toggle Form - Ensure route exists --}}
                                                <form action="{{ route('evenements.toggleStatus', $event->id) }}" method="POST"
                                                    style="display: inline-block;">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit"
                                                        class="btn btn-sm {{ $event->is_published ? 'btn-success' : 'btn-secondary' }} status"
                                                        data-bs-toggle="tooltip"
                                                        title="{{ $event->is_published ? 'Passer en privé' : 'Publier' }}">
                                                        {{ $event->is_published ? 'Publié' : 'Privé' }}
                                                    </button>
                                                </form>
                                            </td>
                                            <td>
                                                <div class="d-flex gap-1">
                                                    {{-- Ensure routes exist --}}
                                                    <a href="{{ route('evenements.show', $event->id) }}"
                                                        class="btn btn-info btn-sm" data-bs-toggle="tooltip" title="Voir"><i
                                                            class="fas fa-eye"></i></a>
                                                    <a href="{{ route('evenements.edit', $event->id) }}"
                                                        class="btn btn-warning btn-sm" data-bs-toggle="tooltip"
                                                        title="Modifier"><i class="fas fa-edit"></i></a>
                                                    {{-- Delete Form - Ensure route exists --}}
                                                    <form action="{{ route('evenements.destroy', $event->id) }}" method="POST"
                                                        style="display:inline-block;"
                                                        onsubmit="return confirm('Confirmer la suppression de cet événement ?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm"
                                                            data-bs-toggle="tooltip" title="Supprimer"><i
                                                                class="fas fa-trash"></i></button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{ $events->links() }} {{-- Render pagination links --}}
                        @else
                            <div class="alert alert-info">Aucun événement trouvé pour le moment.</div>
                        @endif
                    </div>
                </div>
            @endsection

            @push('scripts')
                {{-- Scripts spécifiques si besoin --}}
            @endpush
