@extends('layouts.admin.app')

@section('title', 'StagesBENIN')

@section('content')
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
</div>
@endsection

@push('scripts')
<script>
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
</script>
@endpush
