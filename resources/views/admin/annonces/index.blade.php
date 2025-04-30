@extends('layouts.admin.app')

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
                                <td>{{ $annonce->entreprise?->nom ?? 'Non spécifié' }}</td>
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
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">Aucune annonce trouvée</td>
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

@endsection 