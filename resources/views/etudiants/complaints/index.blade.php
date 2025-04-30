@extends('layouts.etudiant.app')

@section('title', 'StagesBENIN')

@push('styles')
<style>
    /* Styles pour la page d'index des plaintes et suggestions */
    .complaint-page-container {
        max-width: 1200px;
        margin: 0 auto;
    }
    
    .complaint-header {
        background: linear-gradient(to right, rgba(59, 130, 246, 0.1), rgba(59, 130, 246, 0.05));
        padding: 25px;
        border-radius: 12px;
        margin-bottom: 30px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .complaint-header h1 {
        font-weight: 700;
        color: #1e40af;
        margin-bottom: 0;
        font-size: 1.75rem;
    }
    
    .stats-container {
        display: flex;
        gap: 15px;
        margin-bottom: 25px;
        flex-wrap: wrap;
    }
    
    .stat-card {
        flex: 1;
        min-width: 180px;
        background: white;
        border-radius: 10px;
        padding: 20px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        border-left: 4px solid transparent;
        transition: transform 0.2s ease;
    }
    
    .stat-card:hover {
        transform: translateY(-5px);
    }
    
    .stat-card.total {
        border-left-color: #3b82f6;
    }
    
    .stat-card.pending {
        border-left-color: #9ca3af;
    }
    
    .stat-card.processing {
        border-left-color: #f59e0b;
    }
    
    .stat-card.resolved {
        border-left-color: #10b981;
    }
    
    .stat-value {
        font-size: 2rem;
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 5px;
    }
    
    .stat-label {
        color: #6b7280;
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }
    
    .filters-container {
        display: flex;
        gap: 15px;
        margin-bottom: 25px;
        align-items: stretch;
        flex-wrap: wrap;
    }
    
    .filter-card {
        background: white;
        flex: 1;
        border-radius: 10px;
        padding: 15px 20px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    }
    
    .filter-tabs {
        display: flex;
        gap: 10px;
        margin-bottom: 0;
        border-bottom: none;
    }
    
    .filter-tab {
        padding: 10px 20px;
        border-radius: 6px;
        cursor: pointer;
        font-weight: 500;
        color: #4b5563;
        transition: all 0.2s ease;
        background: #f3f4f6;
        border: none;
    }
    
    .filter-tab.active {
        background: #3b82f6;
        color: white;
    }
    
    .filter-tab:hover:not(.active) {
        background: #e5e7eb;
        color: #1f2937;
    }
    
    .search-form {
        display: flex;
        gap: 10px;
    }
    
    .search-input {
        flex: 1;
        border: 1px solid #e5e7eb;
        border-radius: 6px;
        padding: 10px 15px;
        font-size: 0.95rem;
    }
    
    .search-input:focus {
        border-color: #3b82f6;
        outline: none;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }
    
    .filter-dropdown {
        position: relative;
        min-width: 200px;
    }
    
    .filter-dropdown select {
        appearance: none;
        width: 100%;
        padding: 10px 15px;
        font-size: 0.95rem;
        border: 1px solid #e5e7eb;
        border-radius: 6px;
        background: white;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='%234b5563' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: calc(100% - 12px) center;
        cursor: pointer;
        color: #4b5563;
    }
    
    .filter-dropdown select:focus {
        border-color: #3b82f6;
        outline: none;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }
    
    .btn-primary {
        background-color: #2563eb;
        border-color: #2563eb;
        color:rgb(255, 255, 255);
        padding: 10px 20px;
        border-radius: 6px;
        font-weight: 500;
        transition: all 0.3s ease;
        box-shadow: 0 2px 4px rgba(37, 99, 235, 0.1);
        display: flex;
        align-items: center;
        gap: 8px;
    }
    
    .btn-primary:hover {
        background-color: #1d4ed8;
        border-color: #1d4ed8;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(37, 99, 235, 0.2);
    }
    
    .btn-outline-primary {
        color: #2563eb;
        border-color: #2563eb;
        background-color: transparent;
    }
    
    .btn-outline-primary:hover {
        background-color: rgba(37, 99, 235, 0.1);
        color: #1d4ed8;
    }
    
    .filter-btn {
        height: 100%;
        padding: 10px 15px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .filter-actions {
        display: flex;
        gap: 10px;
        margin-top: 15px;
    }
    
    .sort-link {
        color: #4b5563;
        text-decoration: none;
        position: relative;
        display: inline-flex;
        align-items: center;
        white-space: nowrap;
    }
    
    .sort-link:hover {
        color: #2563eb;
    }
    
    .sort-link i {
        font-size: 0.8rem;
        margin-left: 4px;
    }
    
    .sort-link.active {
        color: #1d4ed8;
        font-weight: 600;
    }
    
    .sort-link.asc i:before {
        content: "\f0de"; /* flèche vers le haut */
    }
    
    .sort-link.desc i:before {
        content: "\f0dd"; /* flèche vers le bas */
    }
    
    .alert {
        border-radius: 8px;
        border: none;
        padding: 15px;
        margin-bottom: 25px;
        display: flex;
        align-items: center;
    }
    
    .alert i {
        font-size: 1.25rem;
        margin-right: 12px;
    }
    
    .alert-success {
        background-color: #d1fae5;
        color: #065f46;
    }
    
    .alert-danger {
        background-color: #fee2e2;
        color: #b91c1c;
    }
    
    .card {
        border: none;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
    }
    
    .card-header {
        background-color: #f9fafb;
        border-bottom: 1px solid #f3f4f6;
        padding: 16px 20px;
    }
    
    .card-header h5 {
        margin: 0;
        font-weight: 600;
        color: #1f2937;
    }
    
    .table {
        margin-bottom: 0;
    }
    
    .table th {
        border-top: none;
        font-weight: 600;
        color: #4b5563;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.05em;
        padding: 16px;
    }
    
    .table td {
        vertical-align: middle;
        color: #1f2937;
        padding: 16px;
        border-top: 1px solid #f3f4f6;
    }
    
    .table tr:hover {
        background-color: rgba(59, 130, 246, 0.05);
    }
    
    .badge {
        font-weight: 500;
        padding: 0.4em 0.75em;
        border-radius: 6px;
        text-transform: capitalize;
        font-size: 0.8rem;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        color: white !important;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.08);
    }
    
    .badge i {
        font-size: 0.85rem;
    }
    
    .type-badge {
        padding: 0.5em 0.85em;
        letter-spacing: 0.02em;
    }
    
    .badge.bg-danger {
        background-color: #dc2626 !important;
    }
    
    .badge.bg-info {
        background-color: #0ea5e9 !important;
    }
    
    .badge.bg-success {
        background-color: #10b981 !important;
    }
    
    .badge.bg-secondary {
        background-color: #6b7280 !important;
    }
    
    .badge.bg-warning {
        background-color: #f59e0b !important;
    }
    
    .btn-sm {
        padding: 0.4rem 0.6rem;
        font-size: 0.875rem;
        border-radius: 0.3rem;
    }
    
    .actions-container {
        display: flex;
        align-items: center;
        justify-content: flex-start;
        gap: 10px;
    }
    
    .action-icon {
        font-size: 1.1rem;
        padding: 0.5rem;
        border: none;
        border-radius: 50%;
        cursor: pointer;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 36px;
        height: 36px;
        margin: 0;
    }
    
    .action-icon:hover {
        transform: translateY(-2px);
    }
    
    .action-icon.view {
        color: #2563eb;
        background-color: rgba(37, 99, 235, 0.1);
    }
    
    .action-icon.view:hover {
        background-color: rgba(37, 99, 235, 0.15);
    }
    
    .action-icon.delete {
        color: #dc2626;
        background-color: rgba(220, 38, 38, 0.1);
    }
    
    .action-icon.delete:hover {
        background-color: rgba(220, 38, 38, 0.15);
    }
    
    .status-indicator {
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    
    .status-indicator:before {
        content: '';
        display: block;
        width: 8px;
        height: 8px;
        border-radius: 50%;
    }
    
    .status-indicator.new:before {
        background-color: #9ca3af;
    }
    
    .status-indicator.in-progress:before {
        background-color: #f59e0b;
    }
    
    .status-indicator.resolved:before {
        background-color: #10b981;
    }
    
    .pagination {
        justify-content: center;
        margin-top: 1.5rem;
    }
    
    .page-link {
        color: #2563eb;
        padding: 0.5rem 0.75rem;
        border-radius: 0.25rem;
        margin: 0 0.2rem;
    }
    
    .page-item.active .page-link {
        background-color: #2563eb;
        border-color: #2563eb;
    }
    
    .page-link:hover {
        background-color: #e5e7eb;
    }
    
    .empty-state {
        text-align: center;
        padding: 60px 20px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }
    
    .empty-state-icon {
        font-size: 4rem;
        color: #e5e7eb;
        margin-bottom: 20px;
    }
    
    .empty-state p {
        color: #6b7280;
        font-size: 1.1rem;
        margin-bottom: 25px;
    }
    
    @media (max-width: 768px) {
        .complaint-header {
            flex-direction: column;
            gap: 15px;
            align-items: flex-start;
        }
        
        .stat-card {
            min-width: 100%;
        }
        
        .filter-card {
            min-width: 100%;
        }
        
        .table-responsive {
            border-radius: 10px;
            overflow-x: auto;
        }
        
        .table td, .table th {
            padding: 12px;
        }
    }
    
    /* Animations */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    .card, .stat-card, .filter-card {
        animation: fadeIn 0.4s ease forwards;
    }
    
    .stat-card:nth-child(1) { animation-delay: 0.1s; }
    .stat-card:nth-child(2) { animation-delay: 0.2s; }
    .stat-card:nth-child(3) { animation-delay: 0.3s; }
    .stat-card:nth-child(4) { animation-delay: 0.4s; }
</style>
@endpush

@section('content')
<div class="container py-4 complaint-page-container">
    <!-- En-tête de la page -->
    <div class="complaint-header">
        <h1>Mes plaintes et suggestions</h1>
        <a href="{{ route('etudiants.complaints.create') }}" class="btn btn-primary">
            <i class="fas fa-plus-circle"></i> Nouvelle soumission
        </a>
    </div>

    <!-- Message de notification -->
    @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle"></i>
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    @if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-circle"></i>
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <!-- Statistiques rapides -->
    @php
        $totalCount = $complaintsSuggestions->total() ?? 0;
        $nouveauCount = $complaintsSuggestions->where('statut', 'nouveau')->count();
        $enCoursCount = $complaintsSuggestions->where('statut', 'en_cours')->count();
        $resoluCount = $complaintsSuggestions->where('statut', 'résolu')->count();
        
        // Paramètres de tri et filtrage
        $sortBy = request('sort_by', 'created_at');
        $sortDir = request('sort_dir', 'desc');
        $filterType = request('type', '');
        $filterStatus = request('status', '');
        $search = request('search', '');
    @endphp
    
    <div class="stats-container">
        <div class="stat-card total">
            <div class="stat-value">{{ $totalCount }}</div>
            <div class="stat-label">Total</div>
        </div>
        <div class="stat-card pending">
            <div class="stat-value">{{ $nouveauCount }}</div>
            <div class="stat-label">Nouveau</div>
        </div>
        <div class="stat-card processing">
            <div class="stat-value">{{ $enCoursCount }}</div>
            <div class="stat-label">En cours</div>
        </div>
        <div class="stat-card resolved">
            <div class="stat-value">{{ $resoluCount }}</div>
            <div class="stat-label">Résolu</div>
        </div>
    </div>

    <!-- Filtres et recherche avancée -->
    <form action="{{ route('etudiants.complaints.index') }}" method="GET">
        <div class="filters-container">
            <!-- Filtre par type -->
            <div class="filter-card">
                <div class="filter-tabs">
                    <a href="{{ route('etudiants.complaints.index', array_merge(request()->except('type'), ['type' => ''])) }}" class="filter-tab {{ !$filterType ? 'active' : '' }}">Tous</a>
                    <a href="{{ route('etudiants.complaints.index', array_merge(request()->except('type'), ['type' => 'plainte'])) }}" class="filter-tab {{ $filterType == 'plainte' ? 'active' : '' }}">Plaintes</a>
                    <a href="{{ route('etudiants.complaints.index', array_merge(request()->except('type'), ['type' => 'suggestion'])) }}" class="filter-tab {{ $filterType == 'suggestion' ? 'active' : '' }}">Suggestions</a>
                </div>
            </div>
            
            <!-- Filtre de recherche -->
            <div class="filter-card">
                <div class="search-form">
                    <input type="text" name="search" class="search-input" placeholder="Rechercher par sujet..." value="{{ $search }}">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
        </div>
        
        <!-- Filtres supplémentaires -->
        <div class="filters-container">
            <!-- Filtre par statut -->
            <div class="filter-card">
                <div class="filter-dropdown">
                    <select name="status" class="form-select">
                        <option value="" {{ $filterStatus == '' ? 'selected' : '' }}>Tous les statuts</option>
                        <option value="nouveau" {{ $filterStatus == 'nouveau' ? 'selected' : '' }}>Nouveau</option>
                        <option value="en_cours" {{ $filterStatus == 'en_cours' ? 'selected' : '' }}>En cours</option>
                        <option value="résolu" {{ $filterStatus == 'résolu' ? 'selected' : '' }}>Résolu</option>
                    </select>
                </div>
                <!-- Options de tri masquées -->
                <input type="hidden" name="sort_by" value="{{ $sortBy }}">
                <input type="hidden" name="sort_dir" value="{{ $sortDir }}">
                
                <div class="filter-actions">
                    <button type="submit" class="btn btn-primary filter-btn">
                        <i class="fas fa-filter me-2"></i> Filtrer
                    </button>
                    @if($filterType || $filterStatus || $search)
                    <a href="{{ route('etudiants.complaints.index') }}" class="btn btn-outline-secondary filter-btn">
                        <i class="fas fa-times me-2"></i> Réinitialiser
                    </a>
                    @endif
                </div>
            </div>
        </div>
    </form>
    
    <!-- Tableau des plaintes et suggestions -->
    <div class="card">
        <div class="card-header">
            <h5>Liste des soumissions</h5>
        </div>
        <div class="card-body p-0">
            @if($complaintsSuggestions->isEmpty())
                <div class="empty-state">
                    <div class="empty-state-icon">
                        <i class="fas fa-comment-slash"></i>
                    </div>
                    <p>Vous n'avez pas encore soumis de plainte ou suggestion.</p>
                    <a href="{{ route('etudiants.complaints.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus-circle me-1"></i> Créer votre première soumission
                    </a>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>
                                    <a href="{{ route('etudiants.complaints.index', array_merge(request()->except(['sort_by', 'sort_dir']), ['sort_by' => 'id', 'sort_dir' => $sortBy == 'id' && $sortDir == 'asc' ? 'desc' : 'asc'])) }}" class="sort-link {{ $sortBy == 'id' ? 'active ' . $sortDir : '' }}">
                                        Référence <i class="fas"></i>
                                    </a>
                                </th>
                                <th>
                                    <a href="{{ route('etudiants.complaints.index', array_merge(request()->except(['sort_by', 'sort_dir']), ['sort_by' => 'type', 'sort_dir' => $sortBy == 'type' && $sortDir == 'asc' ? 'desc' : 'asc'])) }}" class="sort-link {{ $sortBy == 'type' ? 'active ' . $sortDir : '' }}">
                                        Type <i class="fas"></i>
                                    </a>
                                </th>
                                <th>
                                    <a href="{{ route('etudiants.complaints.index', array_merge(request()->except(['sort_by', 'sort_dir']), ['sort_by' => 'sujet', 'sort_dir' => $sortBy == 'sujet' && $sortDir == 'asc' ? 'desc' : 'asc'])) }}" class="sort-link {{ $sortBy == 'sujet' ? 'active ' . $sortDir : '' }}">
                                        Sujet <i class="fas"></i>
                                    </a>
                                </th>
                                <th>
                                    <a href="{{ route('etudiants.complaints.index', array_merge(request()->except(['sort_by', 'sort_dir']), ['sort_by' => 'created_at', 'sort_dir' => $sortBy == 'created_at' && $sortDir == 'asc' ? 'desc' : 'asc'])) }}" class="sort-link {{ $sortBy == 'created_at' ? 'active ' . $sortDir : '' }}">
                                        Date <i class="fas"></i>
                                    </a>
                                </th>
                                <th>
                                    <a href="{{ route('etudiants.complaints.index', array_merge(request()->except(['sort_by', 'sort_dir']), ['sort_by' => 'statut', 'sort_dir' => $sortBy == 'statut' && $sortDir == 'asc' ? 'desc' : 'asc'])) }}" class="sort-link {{ $sortBy == 'statut' ? 'active ' . $sortDir : '' }}">
                                        Statut <i class="fas"></i>
                                    </a>
                                </th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($complaintsSuggestions as $item)
                            <tr>
                                <td>#{{ $item->id }}</td>
                                <td>
                                    @if($item->type == 'plainte')
                                        <span class="badge bg-danger type-badge">
                                            <i class="fas fa-exclamation-circle"></i> Plainte
                                        </span>
                                    @else
                                        <span class="badge bg-info type-badge">
                                            <i class="fas fa-lightbulb"></i> Suggestion
                                        </span>
                                    @endif
                                </td>
                                <td>{{ Str::limit($item->sujet, 40) }}</td>
                                <td>{{ $item->created_at->format('d/m/Y H:i') }}</td>
                                <td>
                                    @if($item->statut == 'nouveau')
                                        <span class="status-indicator new">Nouveau</span>
                                    @elseif($item->statut == 'en_cours')
                                        <span class="status-indicator in-progress">En cours</span>
                                    @else
                                        <span class="status-indicator resolved">Résolu</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="actions-container">
                                        <a href="{{ route('etudiants.complaints.show', $item->id) }}" class="action-icon view" title="Voir les détails">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        
                                        @if($item->statut == 'nouveau')
                                        <form action="{{ route('etudiants.complaints.destroy', $item->id) }}" method="POST" style="margin:0; padding:0; line-height:0;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="action-icon delete" title="Supprimer" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette soumission ?');">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                <div class="px-4 py-3">
                    {{ $complaintsSuggestions->appends(request()->query())->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection 