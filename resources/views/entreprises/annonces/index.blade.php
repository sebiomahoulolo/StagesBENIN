@extends('layouts.entreprises.master')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Mes Annonces</h5>
                    <a href="{{ route('entreprises.annonces.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Nouvelle Annonce
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Titre</th>
                                    <th>Type</th>
                                    <th>Secteur</th>
                                    <th>Spécialité</th>
                                    <th>Statut</th>
                                    <th>Date de clôture</th>
                                    <th>Candidatures</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($annonces as $annonce)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0">
                                                <div class="avatar avatar-sm bg-primary bg-opacity-10 rounded-circle">
                                                    <i class="fas fa-briefcase text-primary"></i>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <h6 class="mb-0">{{ $annonce->nom_du_poste }}</h6>
                                                <small class="text-muted">{{ $annonce->entreprise?->nom ?? 'Entreprise non spécifiée' }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-info">{{ $annonce->type_de_poste }}</span>
                                    </td>
                                    <td>
                                        <span class="badge bg-success">{{ $annonce->secteur?->nom ?? 'Non spécifié' }}</span>
                                    </td>
                                    <td>
                                        <span class="badge bg-primary">{{ $annonce->specialite?->nom ?? 'Non spécifié' }}</span>
                                    </td>
                                    <td>
                                        @switch($annonce->statut)
                                            @case('en_attente')
                                                <span class="badge bg-warning">En attente</span>
                                                @break
                                            @case('approuve')
                                                <span class="badge bg-success">Approuvé</span>
                                                @break
                                            @case('rejete')
                                                <span class="badge bg-danger">Rejeté</span>
                                                @break
                                        @endswitch
                                    </td>
                                    <td>
                                        <span class="text-muted">{{ $annonce->date_cloture?->format('d/m/Y') ?? 'Non spécifiée' }}</span>
                                    </td>
                                    <td>
                                        <span class="badge bg-primary">{{ $annonce->candidatures->count() }}</span>
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{ route('entreprises.annonces.show', $annonce) }}" class="btn btn-sm btn-info">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('entreprises.annonces.edit', $annonce) }}" class="btn btn-sm btn-warning">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('entreprises.annonces.destroy', $annonce) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette annonce ?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="text-center py-4">
                                        <div class="d-flex flex-column align-items-center">
                                            <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                            <p class="text-muted mb-0">Aucune annonce trouvée</p>
                                            <a href="{{ route('entreprises.annonces.create') }}" class="btn btn-primary mt-3">
                                                <i class="fas fa-plus me-2"></i>Créer une annonce
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-center mt-4">
                        {{ $annonces->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.avatar {
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.badge {
    font-size: 0.85rem;
    padding: 0.5em 0.75em;
}

.btn-group .btn {
    padding: 0.375rem 0.75rem;
}

.table th {
    font-weight: 600;
    text-transform: uppercase;
    font-size: 0.75rem;
    letter-spacing: 0.5px;
}

.table td {
    vertical-align: middle;
}

.pagination {
    margin-bottom: 0;
}

.pagination .page-link {
    padding: 0.5rem 0.75rem;
    border-radius: 0.25rem;
}

@media (max-width: 768px) {
    .table-responsive {
        margin-bottom: 1rem;
    }
    
    .btn-group {
        display: flex;
        flex-direction: column;
        gap: 0.25rem;
    }
    
    .btn-group .btn {
        width: 100%;
    }
}
</style>
@endsection 