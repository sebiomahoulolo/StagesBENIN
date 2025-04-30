@extends('layouts.entreprises.master')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Mes Annonces</h1>
    
    @if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
    @endif
    
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                <i class="fas fa-table me-1"></i>
                Liste des Annonces
            </div>
            <div>
                <a href="{{ route('entreprises.annonces.create') }}" class="btn btn-success">
                    <i class="fas fa-plus"></i> Nouvelle annonce
                </a>
            </div>
            <!-- <div class="d-flex gap-2">
                <a href="{{ route('entreprises.annonces.index') }}" class="btn {{ !request('statut') ? 'btn-primary' : 'btn-outline-primary' }}">
                    <i class="fas fa-list"></i> Toutes
                </a>
                <a href="{{ route('entreprises.annonces.index', ['statut' => 'en_attente']) }}" class="btn {{ request('statut') == 'en_attente' ? 'btn-warning' : 'btn-outline-warning' }}">
                    <i class="fas fa-clock"></i> En attente
                </a>
                <a href="{{ route('entreprises.annonces.index', ['statut' => 'approuve']) }}" class="btn {{ request('statut') == 'approuve' ? 'btn-success' : 'btn-outline-success' }}">
                    <i class="fas fa-check"></i> Approuvées
                </a>
                <a href="{{ route('entreprises.annonces.index', ['statut' => 'rejete']) }}" class="btn {{ request('statut') == 'rejete' ? 'btn-danger' : 'btn-outline-danger' }}">
                    <i class="fas fa-times"></i> Rejetées
                </a>
            </div> -->
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Titre</th>
                            <th>Type</th>
                            <th>Secteur</th>
                            <th>Spécialité</th>
                            <th>Date de clôture</th>
                            <!-- <th>Statut</th> -->
                            <!-- <th>Candidatures</th> -->
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
                                            <h6 class="mb-0 text-truncate" style="max-width: 200px;" title="{{ $annonce->nom_du_poste }}">{{ $annonce->nom_du_poste }}</h6>
                                            <small class="text-muted">Lieu: {{ $annonce->lieu ?? 'Non spécifié' }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="text-wrap">{{ $annonce->type_de_poste }}</span>
                                </td>
                                <td>
                                    <span class="text-wrap">{{ $annonce->secteur?->nom ?? 'Non spécifié' }}</span>
                                </td>
                                <td>
                                    <span class="text-wrap">{{ $annonce->specialite?->nom ?? 'Non spécifié' }}</span>
                                </td>
                                <td>
                                    @if($annonce->date_cloture)
                                        <span class="text-muted">{{ $annonce->date_cloture->format('d/m/Y') }}</span>
                                        @if($annonce->date_cloture < now())
                                            <br><span class="badge bg-danger">Expirée</span>
                                        @elseif($annonce->date_cloture->diffInDays(now()) <= 7)
                                            <br><span class="badge bg-warning">{{ $annonce->date_cloture->diffInDays(now()) }} jours restants</span>
                                        @endif
                                    @else
                                        <span class="text-muted">Non spécifiée</span>
                                    @endif
                                </td>
                                <!-- <td class="align-middle">
                                    @switch($annonce->statut)
                                        @case('en_attente')
                                            <span class="badge bg-warning text-dark">En attente</span>
                                            @break
                                        @case('approuve')
                                            <span class="badge bg-success">Approuvé</span>
                                            @break
                                        @case('rejete')
                                            <span class="badge bg-danger">Rejeté</span>
                                            @if($annonce->motif_rejet)
                                            <br><small class="text-muted" title="{{ $annonce->motif_rejet }}">{{ Str::limit($annonce->motif_rejet, 20) }}</small>
                                            @endif
                                            @break
                                        @default
                                            <span class="badge bg-secondary">{{ $annonce->statut }}</span>
                                    @endswitch
                                </td> -->
                                <!-- <td class="text-center">
                                    <a href="{{ route('entreprises.annonces.show', $annonce) }}" class="text-decoration-none">
                                        <span class="badge bg-primary rounded-pill">{{ $annonce->candidatures->count() }}</span>
                                        <div class="small mt-1">candidatures</div>
                                    </a>
                                </td> -->
                                <td>
                                    <div class="action-buttons">
                                        <a href="{{ route('entreprises.annonces.show', $annonce) }}" 
                                           class="btn btn-sm btn-outline-info rounded-circle" title="Voir les détails">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('entreprises.annonces.edit', $annonce) }}" 
                                           class="btn btn-sm btn-outline-warning rounded-circle" title="Modifier">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('entreprises.annonces.destroy', $annonce) }}" 
                                              method="POST" 
                                              class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="btn btn-sm btn-outline-danger rounded-circle" 
                                                    title="Supprimer"
                                                    onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette annonce ?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">
                                    <div class="d-flex flex-column align-items-center py-4">
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
            
            <div class="d-flex justify-content-center">
                {{ $annonces->links() }}
            </div>
        </div>
    </div>
</div>

@if(session('success'))
    <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
        <div class="toast show" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
                <strong class="me-auto">Notification</strong>
                <button type="button" class="btn-close" data-bs-dismiss="toast"></button>
            </div>
            <div class="toast-body bg-success text-white">
                {{ session('success') }}
            </div>
        </div>
    </div>
@endif

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

.text-wrap {
    white-space: normal !important;
    word-break: break-word;
}

.action-buttons {
    display: flex;
    gap: 0.5rem;
    justify-content: center;
}

.action-buttons .btn {
    width: 36px;
    height: 36px;
    padding: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    border-width: 1px;
    transition: all 0.2s ease-in-out;
}

.action-buttons .btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 2px 5px rgba(0,0,0,0.15);
}

.action-buttons form {
    margin: 0;
}

@media (max-width: 992px) {
    .table-responsive {
        margin-bottom: 1rem;
    }
    
    .table th, .table td {
        white-space: nowrap;
    }
}

@media (max-width: 768px) {
    .action-buttons {
        flex-direction: column;
        gap: 0.25rem;
    }
    
    .action-buttons .btn {
        width: 100%;
        border-radius: 0.25rem;
    }
}
</style>
@endsection 