@extends('layouts.admin.app')

@section('title', ($complaintSuggestion->type == 'plainte' ? 'Plainte' : 'Suggestion') . ' #' . $complaintSuggestion->id)

@section('content')
<div class="container-fluid py-4">
    <div class="mb-4">
        <a href="{{ route('admin.complaints.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-1"></i> Retour à la liste
        </a>
    </div>
    
    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h4 class="m-0">
                        {{ $complaintSuggestion->type == 'plainte' ? 'Plainte' : 'Suggestion' }} #{{ $complaintSuggestion->id }}
                    </h4>
                    <span class="badge {{ $complaintSuggestion->statut == 'nouveau' ? 'bg-secondary' : ($complaintSuggestion->statut == 'en_cours' ? 'bg-warning' : 'bg-success') }}">
                        {{ ucfirst($complaintSuggestion->statut) }}
                    </span>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <h5 class="border-bottom pb-2">Sujet</h5>
                        <p class="fw-bold">{{ $complaintSuggestion->sujet }}</p>
                    </div>
                    
                    <div class="mb-4">
                        <h5 class="border-bottom pb-2">Contenu</h5>
                        <div class="p-3 bg-light rounded">
                            {!! nl2br(e($complaintSuggestion->contenu)) !!}
                        </div>
                    </div>
                    
                    @if($complaintSuggestion->reponse)
                    <div class="mb-4">
                        <h5 class="border-bottom pb-2">Réponse de l'administration</h5>
                        <div class="p-3 bg-light rounded">
                            {!! nl2br(e($complaintSuggestion->reponse)) !!}
                        </div>
                    </div>
                    @endif
                    
                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('admin.complaints.edit', $complaintSuggestion->id) }}" class="btn btn-primary">
                            <i class="fas fa-reply me-1"></i> Répondre
                        </a>
                        <form action="{{ route('admin.complaints.destroy', $complaintSuggestion->id) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette soumission ?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-trash me-1"></i> Supprimer
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white">
                    <h5 class="card-title mb-0">Informations</h5>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-start">
                            <div class="ms-2 me-auto">
                                <div class="fw-bold">Type</div>
                                {{ $complaintSuggestion->type == 'plainte' ? 'Plainte' : 'Suggestion' }}
                            </div>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-start">
                            <div class="ms-2 me-auto">
                                <div class="fw-bold">Statut</div>
                                {{ ucfirst($complaintSuggestion->statut) }}
                            </div>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-start">
                            <div class="ms-2 me-auto">
                                <div class="fw-bold">Soumis par</div>
                                @if($complaintSuggestion->is_anonymous)
                                    <em>Anonyme</em>
                                @else
                                    @if($complaintSuggestion->etudiant)
                                        <a href="{{ route('admin.etudiants.show', $complaintSuggestion->etudiant->id) }}">
                                            {{ $complaintSuggestion->etudiant->prenom }} {{ $complaintSuggestion->etudiant->nom }}
                                        </a>
                                    @else
                                        <em>Étudiant inconnu</em>
                                    @endif
                                @endif
                            </div>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-start">
                            <div class="ms-2 me-auto">
                                <div class="fw-bold">Date de soumission</div>
                                {{ $complaintSuggestion->created_at->format('d/m/Y H:i') }}
                            </div>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-start">
                            <div class="ms-2 me-auto">
                                <div class="fw-bold">Dernière mise à jour</div>
                                {{ $complaintSuggestion->updated_at->format('d/m/Y H:i') }}
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="card-title mb-0">Actions rapides</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        @if($complaintSuggestion->statut == 'nouveau')
                        <form action="{{ route('admin.complaints.update', $complaintSuggestion->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="statut" value="en_cours">
                            <button type="submit" class="btn btn-warning w-100">
                                <i class="fas fa-play-circle me-1"></i> Marquer en cours
                            </button>
                        </form>
                        @endif
                        
                        @if($complaintSuggestion->statut != 'résolu')
                        <a href="{{ route('admin.complaints.edit', $complaintSuggestion->id) }}" class="btn btn-success">
                            <i class="fas fa-check-circle me-1"></i> Marquer comme résolu
                        </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 