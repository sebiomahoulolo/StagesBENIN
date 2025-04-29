@extends('layouts.admin.app')

@section('title', 'StagesBENIN')

@push('styles')
{{-- Tu peux ajouter du CSS ici si besoin --}}
@endpush

@section('content')
<div class="tab-content active" id="etudiants-content" role="tabpanel" aria-labelledby="etudiants-tab">
    <div class="action-bar d-flex justify-content-between align-items-center mb-3">
        <div class="action-buttons">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#etudiantModal">
                <i class="fas fa-plus-circle me-1"></i> Ajouter Étudiant
            </button>
        </div>
        
        <div class="w-50">
            <input type="text" id="etudiantSearch" class="form-control" placeholder="Rechercher par nom, prénom, téléphone, formation ou niveau...">
        </div>
    </div>

    <div class="content-area table-responsive">
        <h5>Total Étudiants : {{ $etudiants->total() }}</h5>

        @if ($etudiants->isNotEmpty())
            <table class="student-table table table-bordered table-hover align-middle" id="etudiantTable">
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Téléphone</th>
                        <th>Niveau</th>
                        <th>Formation</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($etudiants as $etudiant)
                    <tr>
                        <td>{{ $etudiant->nom }}</td>
                        <td>{{ $etudiant->prenom }}</td>
                        <td>{{ $etudiant->telephone ?? '-' }}</td>
                        <td>{{ $etudiant->niveau ?? '-' }}</td>
                        <td>{{ $etudiant->formation ?? '-' }}</td>
                        <td>
                            {{-- Voir le profil --}}
                            <a href="{{ route('admin.etudiants.show', $etudiant->id) }}" class="btn btn-info btn-sm" data-bs-toggle="tooltip" title="Voir détails">Voir</a>

                            {{-- Bloquer/Débloquer l'étudiant --}}
                            <form action="{{ route('admin.etudiants.toggleStatus', $etudiant->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-{{ $etudiant->statut == 1 ? 'danger' : 'success' }} btn-sm" 
                                    data-bs-toggle="tooltip" 
                                    title="{{ $etudiant->statut == 1 ? 'Bloquer' : 'Débloquer' }}">
                                    {{ $etudiant->statut == 1 ? 'Bloquer' : 'Débloquer' }}
                                </button>
                            </form>

                            {{-- Supprimer l'étudiant --}}
                            <form action="{{ route('admin.etudiants.destroy', $etudiant->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Confirmer la suppression ?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" data-bs-toggle="tooltip" title="Supprimer">
                                    <i class="fas fa-trash"></i> Supprimer
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            {{-- Pagination --}}
            <div class="mt-3">
                {{ $etudiants->links() }}
            </div>
        @else
            <div class="alert alert-info mt-3">Aucun étudiant trouvé pour le moment.</div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.getElementById('etudiantSearch').addEventListener('keyup', function () {
        const search = this.value.toLowerCase();
        const rows = document.querySelectorAll('#etudiantTable tbody tr');

        rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            if (text.includes(search)) {
                row.style.display = '';
                row.style.backgroundColor = '#d0e7ff'; // bleu clair
            } else {
                row.style.display = 'none';
                row.style.backgroundColor = '';
            }
        });
    });
</script>
@endpush
