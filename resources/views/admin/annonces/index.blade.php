@extends('layouts.admin.app')

@push('styles')
<style>
    /* Styles personnalisés pour la pagination */
    .pagination-wrapper {
        display: flex;
        justify-content: center;
        align-items: center;
        margin-top: 30px;
        padding: 20px 0;
    }

    .pagination {
        margin: 0;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .page-item {
        margin: 0;
    }

    .page-link {
        border: 1px solid #dee2e6;
        border-radius: 8px;
        padding: 10px 15px;
        color: #495057;
        text-decoration: none;
        font-weight: 500;
        transition: all 0.3s ease;
        min-width: 45px;
        text-align: center;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: #fff;
    }

    .page-link:hover {
        background-color: #f8f9fa;
        border-color: #007bff;
        color: #007bff;
        transform: translateY(-1px);
        box-shadow: 0 2px 4px rgba(0,123,255,0.15);
    }

    .page-item.active .page-link {
        background-color: #007bff;
        border-color: #007bff;
        color: white;
        font-weight: 600;
        box-shadow: 0 2px 4px rgba(0,123,255,0.25);
    }

    .page-item.disabled .page-link {
        color: #bbb;
        background-color: #f8f9fa;
        border-color: #e9ecef;
        cursor: not-allowed;
    }

    .page-item.disabled .page-link:hover {
        transform: none;
        box-shadow: none;
    }

    /* Masquer les icônes dans les liens de pagination */
    .page-link svg,
    .page-link i {
        display: none;
    }

    /* Pagination info */
    .pagination-info {
        color: #6c757d;
        font-size: 0.9rem;
        margin-bottom: 15px;
        text-align: center;
        background-color: #f8f9fa;
        padding: 10px 15px;
        border-radius: 6px;
        border: 1px solid #e9ecef;
    }

    /* Amélioration des badges de statut */
    .badge {
        font-size: 0.8rem;
        padding: 6px 10px;
        border-radius: 15px;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .pagination {
            gap: 4px;
            flex-wrap: wrap;
            justify-content: center;
        }

        .page-link {
            padding: 8px 12px;
            min-width: 40px;
            font-size: 0.9rem;
        }

        .btn-group {
            flex-direction: column;
            gap: 5px;
        }

        .btn-group .btn {
            border-radius: 4px !important;
            margin: 0;
        }
    }

    @media (max-width: 576px) {
        .page-link {
            padding: 6px 10px;
            min-width: 35px;
            font-size: 0.8rem;
        }

        .card-header .d-flex {
            flex-direction: column;
            gap: 15px;
        }

        .card-header .d-flex > div:last-child {
            flex-wrap: wrap;
            justify-content: center;
        }
    }
</style>
@endpush

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Gestion des Annonces</h1>
    
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
            <div class="d-flex gap-2">
                <a href="{{ route('admin.annonces.create') }}" class="btn btn-success">
                    <i class="fas fa-plus"></i> Nouvelle annonce
                </a>
                <a href="{{ route('admin.annonces.index') }}" class="btn {{ !request('statut') ? 'btn-primary' : 'btn-outline-primary' }}">
                    <i class="fas fa-list"></i> Toutes
                </a>
                <a href="{{ route('admin.annonces.index', ['statut' => 'en_attente']) }}" class="btn {{ request('statut') == 'en_attente' ? 'btn-warning' : 'btn-outline-warning' }}">
                    <i class="fas fa-clock"></i> En attente
                </a>
                <a href="{{ route('admin.annonces.index', ['statut' => 'approuve']) }}" class="btn {{ request('statut') == 'approuve' ? 'btn-success' : 'btn-outline-success' }}">
                    <i class="fas fa-check"></i> Approuvées
                </a>
                <a href="{{ route('admin.annonces.index', ['statut' => 'rejete']) }}" class="btn {{ request('statut') == 'rejete' ? 'btn-danger' : 'btn-outline-danger' }}">
                    <i class="fas fa-times"></i> Rejetées
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Titre</th>
                            <th>Entreprise</th>
                            <th>Spécialité</th>
                            <th>Date de création</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($annonces as $annonce)
                            <tr>
                                <td>{{ $annonce->id }}</td>
                                <td>{{ $annonce->titre ?? $annonce->nom_du_poste ?? 'Sans titre' }}</td>
                                <td>{{ $annonce->entreprise }}</td>
                                <td>{{ $annonce->specialite?->nom ?? 'Non spécifié' }}</td>
                                <td>{{ $annonce->created_at->format('d/m/Y H:i') }}</td>
                                <td>
                                    @switch($annonce->statut)
                                        @case('en_attente')
                                            <span class="badge bg-warning text-dark">En attente</span>
                                            @break
                                        @case('approuve')
                                            <span class="badge bg-success">Approuvé</span>
                                            @break
                                        @case('rejete')
                                            <span class="badge bg-danger">Rejeté</span>
                                            @break
                                        @default
                                            <span class="badge bg-secondary">{{ $annonce->statut }}</span>
                                    @endswitch
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('admin.annonces.show', $annonce) }}" 
                                           class="btn btn-sm btn-info">
                                            <i class="fas fa-eye"></i> Voir
                                        </a>
                                        @if($annonce->statut === 'en_attente')
                                            <form action="{{ route('admin.annonces.approuver', $annonce) }}" 
                                                  method="POST" 
                                                  class="d-inline">
                                                @csrf
                                                <button type="submit" 
                                                        class="btn btn-sm btn-success">
                                                    <i class="fas fa-check"></i> Approuver
                                                </button>
                                            </form>
                                            <button type="button" 
                                                    class="btn btn-sm btn-danger" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#rejectModal{{ $annonce->id }}">
                                                <i class="fas fa-times"></i> Rejeter
                                            </button>
                                        @endif
                                        @if($annonce->admin_id === auth()->id())
                                            <a href="{{ route('admin.annonces.edit', $annonce) }}" 
                                               class="btn btn-sm btn-warning">
                                                <i class="fas fa-edit"></i> Modifier
                                            </a>
                                            <button type="button" 
                                                    class="btn btn-sm btn-danger" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#deleteModal{{ $annonce->id }}">
                                                <i class="fas fa-trash"></i> Supprimer
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>

                            <!-- Modal de rejet -->
                            <div class="modal fade" id="rejectModal{{ $annonce->id }}" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Rejeter l'annonce</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <form action="{{ route('admin.annonces.rejeter', $annonce) }}" method="POST">
                                            @csrf
                                            <div class="modal-body">
                                                @if($errors->has('motif_rejet') && old('annonce_id') == $annonce->id)
                                                <div class="alert alert-danger">
                                                    {{ $errors->first('motif_rejet') }}
                                                </div>
                                                @endif
                                                <div class="mb-3">
                                                    <label for="motif_rejet_{{ $annonce->id }}" class="form-label">Motif du rejet <span class="text-danger">*</span></label>
                                                    <textarea class="form-control @if($errors->has('motif_rejet') && old('annonce_id') == $annonce->id) is-invalid @endif" 
                                                            name="motif_rejet" 
                                                            id="motif_rejet_{{ $annonce->id }}" 
                                                            rows="3" 
                                                            required
                                                            minlength="10">{{ old('motif_rejet') }}</textarea>
                                                    <small class="text-muted">Minimum 10 caractères requis</small>
                                                </div>
                                                <input type="hidden" name="annonce_id" value="{{ $annonce->id }}">
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                                <button type="submit" class="btn btn-danger">Confirmer le rejet</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- Modal de suppression -->
                            <div class="modal fade" id="deleteModal{{ $annonce->id }}" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Supprimer l'annonce</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p>Êtes-vous sûr de vouloir supprimer cette annonce ? Cette action est irréversible.</p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                            <form action="{{ route('admin.annonces.destroy', $annonce) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">Confirmer la suppression</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4">
                                    <i class="fas fa-inbox fa-2x text-muted mb-2"></i>
                                    <p class="text-muted mb-0">Aucune annonce trouvée</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination améliorée -->
            @if($annonces->hasPages())
                <div class="pagination-wrapper">
                    <div class="text-center w-100">
                        <div class="pagination-info">
                            <i class="fas fa-info-circle me-1"></i>
                            Affichage {{ $annonces->firstItem() ?? 0 }} à {{ $annonces->lastItem() ?? 0 }} 
                            sur {{ $annonces->total() }} annonces
                        </div>
                        
                        <nav aria-label="Navigation des pages">
                            <ul class="pagination">
                                {{-- Lien vers la première page --}}
                                @if ($annonces->currentPage() > 3)
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $annonces->url(1) }}">1</a>
                                    </li>
                                    @if ($annonces->currentPage() > 4)
                                        <li class="page-item disabled">
                                            <span class="page-link">...</span>
                                        </li>
                                    @endif
                                @endif

                                {{-- Liens des pages précédentes --}}
                                @for ($i = max(1, $annonces->currentPage() - 2); $i < $annonces->currentPage(); $i++)
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $annonces->url($i) }}">{{ $i }}</a>
                                    </li>
                                @endfor

                                {{-- Page courante --}}
                                <li class="page-item active">
                                    <span class="page-link">{{ $annonces->currentPage() }}</span>
                                </li>

                                {{-- Liens des pages suivantes --}}
                                @for ($i = $annonces->currentPage() + 1; $i <= min($annonces->lastPage(), $annonces->currentPage() + 2); $i++)
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $annonces->url($i) }}">{{ $i }}</a>
                                    </li>
                                @endfor

                                {{-- Lien vers la dernière page --}}
                                @if ($annonces->currentPage() < $annonces->lastPage() - 2)
                                    @if ($annonces->currentPage() < $annonces->lastPage() - 3)
                                        <li class="page-item disabled">
                                            <span class="page-link">...</span>
                                        </li>
                                    @endif
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $annonces->url($annonces->lastPage()) }}">{{ $annonces->lastPage() }}</a>
                                    </li>
                                @endif
                            </ul>
                        </nav>
                    </div>
                </div>
            @endif
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

@endsection