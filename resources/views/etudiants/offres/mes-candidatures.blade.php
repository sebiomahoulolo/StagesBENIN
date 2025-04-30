@extends('layouts.etudiant.app')

@section('title', 'StagesBENIN')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Mes candidatures</h5>
                        <a href="{{ route('etudiants.offres.index') }}" class="btn btn-sm btn-outline-primary">
                            <i class="fas fa-search me-1"></i> Voir les offres
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if($candidatures->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Offre</th>
                                        <th>Entreprise</th>
                                        <th>Date de candidature</th>
                                        <th>Statut</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($candidatures as $candidature)
                                        <tr>
                                            <td>
                                                <a href="{{ route('etudiants.offres.show', $candidature->recrutement_id) }}" class="text-decoration-none">
                                                    {{ $candidature->recrutement->titre }}
                                                </a>
                                            </td>
                                            <td>{{ $candidature->recrutement->entreprise->nom ?? 'Entreprise non spécifiée' }}</td>
                                            <td>{{ $candidature->date_candidature->format('d/m/Y H:i') }}</td>
                                            <td>
                                                @php
                                                    $statutClass = '';
                                                    switch($candidature->statut) {
                                                        case 'en_attente':
                                                            $statutClass = 'bg-warning';
                                                            break;
                                                        case 'acceptee':
                                                            $statutClass = 'bg-success';
                                                            break;
                                                        case 'refusee':
                                                            $statutClass = 'bg-danger';
                                                            break;
                                                        case 'en_cours':
                                                            $statutClass = 'bg-info';
                                                            break;
                                                        case 'annulee':
                                                            $statutClass = 'bg-secondary';
                                                            break;
                                                        default:
                                                            $statutClass = 'bg-secondary';
                                                    }
                                                @endphp
                                                <span class="badge {{ $statutClass }}">{{ $candidature->statut_label }}</span>
                                            </td>
                                            <td>
                                                <div class="btn-group">
                                                    <a href="{{ route('etudiants.offres.show', $candidature->recrutement_id) }}" class="btn btn-sm btn-outline-primary" title="Voir l'offre">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <button type="button" class="btn btn-sm btn-outline-info" data-bs-toggle="modal" data-bs-target="#candidatureModal{{ $candidature->id }}" title="Voir les détails">
                                                        <i class="fas fa-info-circle"></i>
                                                    </button>
                                                </div>
                                                
                                                <!-- Modal pour afficher les détails de la candidature -->
                                                <div class="modal fade" id="candidatureModal{{ $candidature->id }}" tabindex="-1" aria-labelledby="candidatureModalLabel{{ $candidature->id }}" aria-hidden="true">
                                                    <div class="modal-dialog modal-lg">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="candidatureModalLabel{{ $candidature->id }}">Détails de votre candidature</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="mb-3">
                                                                    <h6>Offre</h6>
                                                                    <p><strong>{{ $candidature->recrutement->titre }}</strong> chez <strong>{{ $candidature->recrutement->entreprise->nom ?? 'Entreprise non spécifiée' }}</strong></p>
                                                                </div>
                                                                
                                                                <div class="mb-3">
                                                                    <h6>Date de candidature</h6>
                                                                    <p>{{ $candidature->date_candidature->format('d/m/Y à H:i') }}</p>
                                                                </div>
                                                                
                                                                <div class="mb-3">
                                                                    <h6>Statut</h6>
                                                                    <p><span class="badge {{ $statutClass }}">{{ $candidature->statut_label }}</span></p>
                                                                </div>
                                                                
                                                                @if($candidature->date_reponse)
                                                                    <div class="mb-3">
                                                                        <h6>Date de réponse</h6>
                                                                        <p>{{ $candidature->date_reponse->format('d/m/Y à H:i') }}</p>
                                                                    </div>
                                                                @endif
                                                                
                                                                @if($candidature->commentaire)
                                                                    <div class="mb-3">
                                                                        <h6>Commentaire</h6>
                                                                        <p>{{ $candidature->commentaire }}</p>
                                                                    </div>
                                                                @endif
                                                                
                                                                <div class="mb-3">
                                                                    <h6>Lettre de motivation</h6>
                                                                    <div class="p-3 bg-light rounded">
                                                                        {!! nl2br(e($candidature->lettre_motivation)) !!}
                                                                    </div>
                                                                </div>
                                                                
                                                                @if($candidature->cv_path)
                                                                    <div class="mb-3">
                                                                        <h6>CV</h6>
                                                                        <a href="{{ asset('storage/' . $candidature->cv_path) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                                                            <i class="fas fa-download me-1"></i> Télécharger mon CV
                                                                        </a>
                                                                    </div>
                                                                @endif
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <!-- Pagination -->
                        <div class="d-flex justify-content-center mt-4">
                            {{ $candidatures->links() }}
                        </div>
                    @else
                        <div class="alert alert-info text-center">
                            <i class="fas fa-info-circle me-2"></i>
                            Vous n'avez pas encore postulé à des offres d'emploi.
                            <a href="{{ route('etudiants.offres.index') }}" class="alert-link ms-2">Voir les offres disponibles</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 