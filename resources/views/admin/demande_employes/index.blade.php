@extends('layouts.admin.app')

@section('title', 'Gestion des demandes d\'employés')

@section('content')
<div class="action-bar">
    <h1 class="dashboard-title">Demandes d'employés</h1>
    <div class="action-buttons">
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#filterModal">
            <i class="fas fa-filter"></i> Filtrer
        </button>
    </div>
</div>

<div class="tabs-container">
    <div class="tabs-header">
        <button class="tab active" data-tab="en_attente">
            <i class="fas fa-clock"></i> En attente
            @if(isset($counts['en_attente']) && $counts['en_attente'] > 0)
                <span class="badge bg-warning">{{ $counts['en_attente'] }}</span>
            @endif
        </button>
        <button class="tab" data-tab="active">
            <i class="fas fa-check"></i> Active
            @if(isset($counts['active']) && $counts['active'] > 0)
                <span class="badge bg-success">{{ $counts['active'] }}</span>
            @endif
        </button>
        <button class="tab" data-tab="fermee">
            <i class="fas fa-times"></i> Fermée
            @if(isset($counts['fermee']) && $counts['fermee'] > 0)
                <span class="badge bg-danger">{{ $counts['fermee'] }}</span>
            @endif
        </button>
        <button class="tab" data-tab="archive">
            <i class="fas fa-archive"></i> Archivée
            @if(isset($counts['archive']) && $counts['archive'] > 0)
                <span class="badge bg-secondary">{{ $counts['archive'] }}</span>
            @endif
        </button>
    </div>

    <div class="tab-content active" id="en_attente">
        @include('admin.demande_employes.partials.demandes-table', ['demandes' => $demandesEnAttente])
    </div>

    <div class="tab-content" id="active">
        @include('admin.demande_employes.partials.demandes-table', ['demandes' => $demandesActives])
    </div>

    <div class="tab-content" id="fermee">
        @include('admin.demande_employes.partials.demandes-table', ['demandes' => $demandesFermees])
    </div>

    <div class="tab-content" id="archive">
        @include('admin.demande_employes.partials.demandes-table', ['demandes' => $demandesArchivees])
    </div>
</div>

<!-- Filter Modal -->
<div class="modal fade" id="filterModal" tabindex="-1" aria-labelledby="filterModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="filterModalLabel">Filtrer les demandes</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.demande-employes.index') }}" method="GET">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="type_contrat" class="form-label">Type de contrat</label>
                        <select class="form-select" id="type_contrat" name="type_contrat">
                            <option value="">Tous</option>
                            <option value="CDI">CDI</option>
                            <option value="CDD">CDD</option>
                            <option value="Stage">Stage</option>
                            <option value="Alternance">Alternance</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="entreprise" class="form-label">Entreprise</label>
                        <select class="form-select" id="entreprise" name="entreprise_id">
                            <option value="">Toutes</option>
                            @foreach($entreprises as $entreprise)
                                <option value="{{ $entreprise->id }}">{{ $entreprise->nom }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="urgent" class="form-label">Urgence</label>
                        <select class="form-select" id="urgent" name="urgent">
                            <option value="">Tous</option>
                            <option value="1">Urgente</option>
                            <option value="0">Non urgente</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="date_limite" class="form-label">Date limite avant</label>
                        <input type="date" class="form-control" id="date_limite" name="date_limite">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                    <button type="submit" class="btn btn-primary">Appliquer les filtres</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection