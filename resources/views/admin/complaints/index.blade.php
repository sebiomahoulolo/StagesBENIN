@extends('layouts.admin.app')

@section('title', 'Gestion des plaintes et suggestions')

@section('content')
<div class="container-fluid py-4">
    <h1 class="h3 mb-4">Gestion des plaintes et suggestions</h1>

    <!-- Message de notification -->
    @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <!-- Filtres -->
    <div class="card mb-4">
        <div class="card-header bg-white">
            <h5 class="card-title mb-0">Filtres</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.complaints.filter') }}" method="GET" class="row g-3">
                <div class="col-md-3">
                    <label for="type" class="form-label">Type</label>
                    <select name="type" id="type" class="form-select">
                        <option value="">Tous les types</option>
                        <option value="plainte" {{ request('type') == 'plainte' ? 'selected' : '' }}>Plaintes</option>
                        <option value="suggestion" {{ request('type') == 'suggestion' ? 'selected' : '' }}>Suggestions</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="statut" class="form-label">Statut</label>
                    <select name="statut" id="statut" class="form-select">
                        <option value="">Tous les statuts</option>
                        <option value="nouveau" {{ request('statut') == 'nouveau' ? 'selected' : '' }}>Nouveau</option>
                        <option value="en_cours" {{ request('statut') == 'en_cours' ? 'selected' : '' }}>En cours</option>
                        <option value="résolu" {{ request('statut') == 'résolu' ? 'selected' : '' }}>Résolu</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="recherche" class="form-label">Recherche par mots-clés</label>
                    <input type="text" name="recherche" id="recherche" class="form-control" placeholder="Rechercher dans le sujet ou le contenu..." value="{{ request('recherche') }}">
                </div>
                <div class="col-md-3">
                    <label for="date_debut" class="form-label">Date de début</label>
                    <input type="date" name="date_debut" id="date_debut" class="form-control" value="{{ request('date_debut') }}">
                </div>
                <div class="col-md-3">
                    <label for="date_fin" class="form-label">Date de fin</label>
                    <input type="date" name="date_fin" id="date_fin" class="form-control" value="{{ request('date_fin') }}">
                </div>
                <div class="col-md-6 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary me-2">
                        <i class="fas fa-filter me-1"></i> Appliquer les filtres
                    </button>
                    <a href="{{ route('admin.complaints.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-sync-alt me-1"></i> Réinitialiser
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Statistiques rapides -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <h5 class="card-title">Total</h5>
                    <p class="card-text h2">{{ $complaintsSuggestions->total() }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-secondary text-white">
                <div class="card-body">
                    <h5 class="card-title">Nouveaux</h5>
                    <p class="card-text h2">{{ App\Models\ComplaintSuggestion::where('statut', 'nouveau')->count() }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <h5 class="card-title">En cours</h5>
                    <p class="card-text h2">{{ App\Models\ComplaintSuggestion::where('statut', 'en_cours')->count() }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <h5 class="card-title">Résolus</h5>
                    <p class="card-text h2">{{ App\Models\ComplaintSuggestion::where('statut', 'résolu')->count() }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Liste des plaintes et suggestions -->
    <div class="card shadow-sm">
        <div class="card-body p-0">
            @if($complaintsSuggestions->isEmpty())
                <div class="p-4 text-center">
                    <p class="text-muted mb-0">Aucune plainte ou suggestion trouvée.</p>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Type</th>
                                <th>Sujet</th>
                                <th>Étudiant</th>
                                <th>Date</th>
                                <th>Statut</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($complaintsSuggestions as $item)
                            <tr>
                                <td>#{{ $item->id }}</td>
                                <td>
                                    @if($item->type == 'plainte')
                                        <span class="badge bg-danger text-white">Plainte</span>
                                    @else
                                        <span class="badge bg-info text-white">Suggestion</span>
                                    @endif
                                </td>
                                <td>{{ $item->sujet }}</td>
                                <td>
                                    @if($item->is_anonymous)
                                        <span class="text-muted"><em>Anonyme</em></span>
                                    @else
                                        @if($item->etudiant)
                                            <a href="{{ route('admin.etudiants.show', $item->etudiant->id) }}" class="text-decoration-none">
                                                {{ $item->etudiant->prenom }} {{ $item->etudiant->nom }}
                                            </a>
                                        @else
                                            <span class="text-muted"><em>Étudiant inconnu</em></span>
                                        @endif
                                    @endif
                                </td>
                                <td>{{ $item->created_at->format('d/m/Y H:i') }}</td>
                                <td>
                                    @if($item->statut == 'nouveau')
                                        <span class="badge bg-secondary text-white">Nouveau</span>
                                    @elseif($item->statut == 'en_cours')
                                        <span class="badge bg-warning text-white">En cours</span>
                                    @else
                                        <span class="badge bg-success text-white">Résolu</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('admin.complaints.show', $item->id) }}" class="btn btn-sm btn-outline-primary" title="Voir les détails">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.complaints.edit', $item->id) }}" class="btn btn-sm btn-outline-warning" title="Répondre">
                                            <i class="fas fa-reply"></i>
                                        </a>
                                        <form action="{{ route('admin.complaints.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette soumission ?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Supprimer">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                <div class="px-4 py-3">
                    {{ $complaintsSuggestions->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection 