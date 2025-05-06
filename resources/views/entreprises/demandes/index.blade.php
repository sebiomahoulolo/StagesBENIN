@extends('layouts.entreprises.master')

@section('title', 'Mes demandes d\'employés - StagesBENIN')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/shared-styles.css') }}">
<style>
    .stats-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 1.25rem;
        margin-bottom: 2rem;
    }
    
    .stat-card {
        background: white;
        padding: 1.5rem;
        border-radius: 0.5rem;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        display: flex;
        align-items: center;
        gap: 1.25rem;
        border: 1px solid #edf2f7;
    }
    
    .stat-icon {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
        color: white;
    }
    
    .stat-info h3 {
        font-size: 0.875rem;
        color: #64748b;
        margin: 0;
        margin-bottom: 0.25rem;
        font-weight: 500;
    }
    
    .stat-info p {
        font-size: 1.5rem;
        font-weight: 700;
        margin: 0;
        color: #1e293b;
    }
    
    .filters {
        display: flex;
        gap: 1.25rem;
        margin-bottom: 1.5rem;
        flex-wrap: wrap;
        align-items: flex-end;
    }
    
    .filters .form-group {
        flex-grow: 1;
        min-width: 200px;
    }
    
    .form-label {
        font-weight: 500;
        margin-bottom: 0.5rem;
        display: block;
        color: #374151;
    }
    
    .form-control, .form-select {
        width: 100%;
        padding: 0.625rem 0.875rem;
        border: 1px solid #d1d5db;
        border-radius: 0.375rem;
        font-size: 0.95rem;
    }
    
    .form-control:focus, .form-select:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        outline: none;
    }
    
    .custom-card {
        background: white;
        border-radius: 0.5rem;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        border: 1px solid #edf2f7;
        overflow: hidden;
        margin-bottom: 2rem;
    }
    
    .card-body {
        padding: 1.5rem;
    }
    
    .custom-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        margin: 0;
    }
    
    .custom-table th {
        background-color: #f8fafc;
        color: #475569;
        font-weight: 600;
        text-align: left;
        padding: 0.875rem 1.25rem;
        border-bottom: 1px solid #e2e8f0;
        font-size: 0.875rem;
    }
    
    .custom-table td {
        padding: 1rem 1.25rem;
        border-bottom: 1px solid #e2e8f0;
        color: #334155;
        vertical-align: middle;
    }
    
    .custom-table tr:last-child td {
        border-bottom: none;
    }
    
    .custom-table tr:hover {
        background-color: #f8fafc;
    }
    
    .badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0.25rem 0.75rem;
        font-size: 0.75rem;
        font-weight: 500;
        border-radius: 9999px;
    }
    
    .bg-primary {
        background-color: #3b82f6;
        color: white;
    }
    
    .bg-secondary {
        background-color: #64748b;
        color: white;
    }
    
    .status-badge {
        padding: 0.35rem 0.85rem;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 500;
        display: inline-block;
    }
    
    .status-en_attente {
        background-color: #fef3c7;
        color: #92400e;
    }
    
    .status-approuvee {
        background-color: #dcfce7;
        color: #166534;
    }
    
    .status-rejetee {
        background-color: #fee2e2;
        color: #b91c1c;
    }
    
    .status-expiree {
        background-color: #f3f4f6;
        color: #4b5563;
    }
    
    .d-flex {
        display: flex;
    }
    
    .justify-content-between {
        justify-content: space-between;
    }
    
    .align-items-center {
        align-items: center;
    }
    
    .gap-1 {
        gap: 0.5rem;
    }
    
    .btn {
        border: none;
        padding: 0.5rem 0.75rem;
        border-radius: 0.375rem;
        cursor: pointer;
        font-size: 0.875rem;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s;
    }
    
    .btn-sm {
        padding: 0.375rem 0.625rem;
        font-size: 0.75rem;
    }
    
    .btn-outline-info {
        border: 1px solid #0ea5e9;
        color: #0ea5e9;
        background-color: transparent;
    }
    
    .btn-outline-info:hover {
        background-color: #0ea5e9;
        color: white;
    }
    
    .btn-outline-primary {
        border: 1px solid #3b82f6;
        color: #3b82f6;
        background-color: transparent;
    }
    
    .btn-outline-primary:hover {
        background-color: #3b82f6;
        color: white;
    }
    
    .btn-outline-danger {
        border: 1px solid #ef4444;
        color: #ef4444;
        background-color: transparent;
    }
    
    .btn-outline-danger:hover {
        background-color: #ef4444;
        color: white;
    }
    
    .btn[disabled] {
        opacity: 0.65;
        cursor: not-allowed;
    }
    
    .custom-btn {
        padding: 0.625rem 1.25rem;
        border-radius: 0.375rem;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        transition: all 0.2s;
    }
    
    .custom-btn-primary {
        background-color: #3b82f6;
        color: white;
        border: none;
    }
    
    .custom-btn-primary:hover {
        background-color: #2563eb;
        transform: translateY(-1px);
    }
    
    .table-responsive {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }
    
    .text-center {
        text-align: center;
    }
    
    .text-muted {
        color: #6b7280;
    }
    
    .mb-0 {
        margin-bottom: 0;
    }
    
    .fa-3x {
        font-size: 3rem;
    }
    
    .mb-3 {
        margin-bottom: 0.75rem;
    }
    
    .py-4 {
        padding-top: 1rem;
        padding-bottom: 1rem;
    }

    .content-header {
        margin-bottom: 1.5rem;
    }
    
    .h2 {
        font-size: 1.5rem;
        font-weight: 600;
        color: #111827;
        margin: 0;
    }
    
    .me-2 {
        margin-right: 0.5rem;
    }
    
    .text-capitalize {
        text-transform: capitalize;
    }
    
    @media (max-width: 768px) {
        .stats-row {
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 1rem;
        }
        
        .stat-card {
            padding: 1rem;
        }
        
        .filters {
            flex-direction: column;
            gap: 1rem;
        }
        
        .filters .form-group {
            width: 100%;
            margin-bottom: 0;
        }
        
        .card-body {
            padding: 1rem;
        }
        
        .custom-table th,
        .custom-table td {
            padding: 0.75rem;
        }
        
        .h2 {
            font-size: 1.25rem;
        }
    }
</style>
@endpush

@section('content')
<div class="content-header">
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="h2 mb-0">Mes demandes d'employés</h1>
        <a href="{{ route('entreprises.demandes.create') }}" class="custom-btn custom-btn-primary">
            <i class="fas fa-plus-circle me-2"></i>Nouvelle demande
        </a>
    </div>
</div>

<div class="stats-row fade-in">
    <div class="stat-card">
        <div class="stat-icon" style="background-color: #3b82f6;">
            <i class="fas fa-file-alt"></i>
        </div>
        <div class="stat-info">
            <h3>Total demandes</h3>
            <p>{{ $demandes->count() }}</p>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon" style="background-color: #10b981;">
            <i class="fas fa-check-circle"></i>
        </div>
        <div class="stat-info">
            <h3>Demandes approuvées</h3>
            <p>{{ $demandes->where('statut', 'approuvee')->count() }}</p>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon" style="background-color: #f59e0b;">
            <i class="fas fa-clock"></i>
        </div>
        <div class="stat-info">
            <h3>En attente</h3>
            <p>{{ $demandes->where('statut', 'en_attente')->count() }}</p>
        </div>
    </div>
     <div class="stat-card">
        <div class="stat-icon" style="background-color: #ef4444;">
            <i class="fas fa-times-circle"></i>
        </div>
        <div class="stat-info">
            <h3>Demandes rejetées</h3>
            <p>{{ $demandes->where('statut', 'rejetee')->count() }}</p>
        </div>
    </div>
</div>

<div class="custom-card fade-in">
    <div class="card-body">
        <div class="filters">
            <div class="form-group">
                <label for="statut_filter" class="form-label">Filtrer par statut</label>
                <select id="statut_filter" class="form-select">
                    <option value="">Tous les statuts</option>
                    <option value="en_attente">En attente</option>
                    <option value="approuvee">Approuvée</option>
                    <option value="rejetee">Rejetée</option>
                    <option value="expiree">Expirée</option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="search_filter" class="form-label">Rechercher</label>
                <input type="text" id="search_filter" class="form-control" placeholder="Par poste, type...">
            </div>
        </div>

        <div class="table-responsive">
            <table class="custom-table">
                <thead>
                    <tr>
                        <th>Poste recherché</th>
                        <th>Type</th>
                        <th>Date de demande</th>
                        <th>Statut</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($demandes as $demande)
                    <tr>
                        <td><strong>{{ $demande->titre }}</strong></td>
                        <td>
                            <span class="badge bg-{{ $demande->type === 'emploi' ? 'primary' : 'secondary' }}">
                                {{ ucfirst($demande->type) }}
                            </span>
                        </td>
                        <td>{{ $demande->created_at->format('d/m/Y') }}</td>
                        <td>
                            <span class="status-badge status-{{ $demande->statut }} text-capitalize">
                                {{ str_replace('_', ' ', $demande->statut) }}
                            </span>
                        </td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('entreprises.demandes.show', $demande) }}" class="btn btn-sm btn-outline-info" title="Voir les détails">
                                    <i class="fas fa-eye"></i>
                                </a>
                                @if($demande->statut === 'en_attente')
                                <a href="{{ route('entreprises.demandes.edit', $demande) }}" class="btn btn-sm btn-outline-primary" title="Modifier">
                                    <i class="fas fa-edit"></i>
                                </a>
                                @else
                                <button class="btn btn-sm btn-outline-primary" disabled title="Modification non autorisée">
                                    <i class="fas fa-edit"></i>
                                </button>
                                @endif
                                <form action="{{ route('entreprises.demandes.destroy', $demande) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette demande ?')" title="Supprimer">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-4">
                            <div class="text-muted">
                                <i class="fas fa-inbox fa-3x mb-3"></i>
                                <p class="mb-0">Aucune demande d'employé trouvée.</p>
                                <p><a href="{{ route('entreprises.demandes.create') }}">Soumettre une nouvelle demande</a></p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const statutFilter = document.getElementById('statut_filter');
    const searchFilter = document.getElementById('search_filter');
    const tableRows = document.querySelectorAll('.custom-table tbody tr');

    function filterDemandes() {
        const statutValue = statutFilter.value.toLowerCase();
        const searchValue = searchFilter.value.toLowerCase();

        tableRows.forEach(row => {
            // Vérifier si la ligne est une ligne de données (pas le message "Aucune demande")
            if (row.querySelectorAll('td').length > 1) {
                const poste = row.cells[0].textContent.toLowerCase();
                const type = row.cells[1].textContent.toLowerCase();
                const rowStatutText = row.cells[3].querySelector('.status-badge').className.toLowerCase(); // Obtenir la classe du badge pour le statut

                let matchStatut = true;
                if (statutValue) {
                    matchStatut = rowStatutText.includes('status-' + statutValue);
                }
                
                const matchSearch = !searchValue || poste.includes(searchValue) || type.includes(searchValue);
                
                row.style.display = matchStatut && matchSearch ? '' : 'none';
            }
        });
    }

    if(statutFilter) statutFilter.addEventListener('change', filterDemandes);
    if(searchFilter) searchFilter.addEventListener('input', filterDemandes); // 'input' pour réagir à chaque frappe
});
</script>
@endpush