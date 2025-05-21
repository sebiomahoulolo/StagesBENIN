@extends('layouts.admin.app')

@section('title', 'Détails de l\'annonce')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-primary">Détails de l'annonce</h1>
        <a href="{{ route('admin.annonces.index') }}" class="btn btn-outline-primary">
            <i class="fas fa-arrow-left"></i> Retour
        </a>
    </div>

    <!-- Entreprise Banner -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 bg-primary">
            <div class="row align-items-center">
                <div class="col-auto">
                    <i class="fas fa-building fa-2x text-white"></i>
                </div>
                <div class="col">
                    <h4 class="m-0 font-weight-bold text-white">{{ $annonce->entreprise  }}</h4>
                    <p class="text-white-80 mb-0 mt-1">{{ $annonce->titre ?? $annonce->nom_du_poste ?? 'Sans titre' }}</p>
                </div>
                <div class="col-auto">
                    <span class="badge bg-{{ $annonce->statut === 'en_attente' ? 'warning' : ($annonce->statut === 'approuve' ? 'success' : 'danger') }} px-3 py-2 fs-6">
                        {{ $annonce->statut === 'en_attente' ? 'En attente' : ($annonce->statut === 'approuve' ? 'Approuvé' : 'Rejeté') }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow mb-4 border-left-primary">
                <div class="card-header py-3 bg-gradient-light">
                    <h6 class="m-0 font-weight-bold text-primary">Détails de l'offre</h6>
                </div>
                <div class="card-body">
                    <div class="mb-4 p-3 bg-light rounded">
                        <h5 class="font-weight-bold text-primary border-bottom pb-2 mb-3">Description</h5>
                        <div class="text-justify">
                            {!! nl2br(e($annonce->description ?? 'Aucune description disponible')) !!}
                        </div>
                    </div>

                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="p-3 h-100 bg-light rounded">
                                <h5 class="font-weight-bold text-primary border-bottom pb-2 mb-3">Informations principales</h5>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item bg-transparent border-0 py-2 ps-0">
                                        <i class="fas fa-building mr-2 text-primary"></i>
                                        <strong>Entreprise :</strong> {{ $annonce->entreprise  }}
                                    </li>
                                    <li class="list-group-item bg-transparent border-0 py-2 ps-0">
                                        <i class="fas fa-briefcase mr-2 text-info"></i>
                                        <strong>Type de contrat :</strong> {{ $annonce->type_contrat ?? $annonce->type_de_poste ?? 'Non spécifié' }}
                                    </li>
                                    <li class="list-group-item bg-transparent border-0 py-2 ps-0">
                                        <i class="fas fa-industry mr-2 text-secondary"></i>
                                        <strong>Secteur :</strong> {{ $annonce->secteur?->nom ?? 'Non spécifié' }}
                                    </li>
                                    <li class="list-group-item bg-transparent border-0 py-2 ps-0">
                                        <i class="fas fa-graduation-cap mr-2 text-warning"></i>
                                        <strong>Spécialité :</strong> {{ $annonce->specialite?->nom ?? 'Non spécifié' }}
                                    </li>
                                    <li class="list-group-item bg-transparent border-0 py-2 ps-0">
                                        <i class="fas fa-map-marker-alt mr-2 text-danger"></i>
                                        <strong>Lieu :</strong> {{ $annonce->lieu ?? 'Non spécifié' }}
                                    </li>
                                    <li class="list-group-item bg-transparent border-0 py-2 ps-0">
                                        <i class="fas fa-money-bill-wave mr-2 text-success"></i>
                                        <strong>Prétention salariale :</strong> 
                                        @if(isset($annonce->pretension_salariale) && $annonce->pretension_salariale)
                                            {{ number_format($annonce->pretension_salariale, 0, ',', ' ') }} FCFA
                                        @else
                                            Non spécifié
                                        @endif
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="p-3 h-100 bg-light rounded">
                                <h5 class="font-weight-bold text-primary border-bottom pb-2 mb-3">Statut et dates</h5>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item bg-transparent border-0 py-2 ps-0">
                                        <i class="fas fa-info-circle mr-2 text-primary"></i>
                                        <strong>Statut :</strong>
                                        <span class="badge bg-{{ $annonce->statut === 'en_attente' ? 'warning' : ($annonce->statut === 'approuve' ? 'success' : 'danger') }}">
                                            {{ $annonce->statut === 'en_attente' ? 'En attente' : ($annonce->statut === 'approuve' ? 'Approuvé' : 'Rejeté') }}
                                        </span>
                                    </li>
                                    <li class="list-group-item bg-transparent border-0 py-2 ps-0">
                                        <i class="fas fa-calendar-plus mr-2 text-info"></i>
                                        <strong>Date de publication :</strong> {{ $annonce->created_at->format('d/m/Y H:i') }}
                                    </li>
                                    <li class="list-group-item bg-transparent border-0 py-2 ps-0">
                                        <i class="fas fa-calendar-check mr-2 text-success"></i>
                                        <strong>Date de clôture :</strong> {{ $annonce->date_cloture?->format('d/m/Y') ?? 'Non spécifiée' }}
                                    </li>
                                    @if($annonce->statut === 'rejete' && $annonce->motif_rejet)
                                    <li class="list-group-item bg-transparent border-0 py-2 ps-0">
                                        <i class="fas fa-times-circle mr-2 text-danger"></i>
                                        <strong>Motif du rejet :</strong> 
                                        <div class="alert alert-danger mt-2">
                                            {{ $annonce->motif_rejet }}
                                        </div>
                                    </li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Section Candidatures -->
            <div class="card shadow mb-4 border-left-info">
                <div class="card-header py-3 bg-gradient-light d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-info">Candidatures reçues</h6>
                    <span class="badge bg-info px-3 py-2">{{ $candidatures->total() }} candidature(s)</span>
                </div>
                <div class="card-body">
                    @if($candidatures->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Étudiant</th>
                                        <th>Spécialité</th>
                                        <th>Date</th>
                                        <th>Statut</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($candidatures as $candidature)
                                        <tr>
                                            <td>
                                                {{ $candidature->etudiant->user->name ?? 'Étudiant inconnu' }}
                                            </td>
                                            <td>
                                                {{ $candidature->etudiant->specialite->nom ?? 'Non spécifiée' }}
                                            </td>
                                            <td>{{ $candidature->created_at->format('d/m/Y H:i') }}</td>
                                            <td>
                                                @php
                                                    $statutClass = '';
                                                    switch($candidature->statut) {
                                                        case 'en_attente':
                                                            $statutClass = 'bg-warning';
                                                            break;
                                                        case 'accepte':
                                                            $statutClass = 'bg-success';
                                                            break;
                                                        case 'rejete':
                                                            $statutClass = 'bg-danger';
                                                            break;
                                                        case 'en_cours':
                                                            $statutClass = 'bg-info';
                                                            break;
                                                        default:
                                                            $statutClass = 'bg-secondary';
                                                    }
                                                @endphp
                                                <span class="badge {{ $statutClass }}">
                                                    @switch($candidature->statut)
                                                        @case('en_attente')
                                                            En attente
                                                            @break
                                                        @case('en_cours')
                                                            En cours de traitement
                                                            @break
                                                        @case('accepte')
                                                            Acceptée
                                                            @break
                                                        @case('rejete')
                                                            Rejetée
                                                            @break
                                                        @default
                                                            {{ $candidature->statut }}
                                                    @endswitch
                                                </span>
                                            </td>
                                            <td>
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#candidatureModal{{ $candidature->id }}">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-sm btn-outline-success" data-bs-toggle="modal" data-bs-target="#changerStatutModal{{ $candidature->id }}">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                </div>
                                                
                                                <!-- Modal pour afficher les détails de la candidature -->
                                                <div class="modal fade" id="candidatureModal{{ $candidature->id }}" tabindex="-1" aria-hidden="true">
                                                    <div class="modal-dialog modal-lg">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Détails de la candidature</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="row mb-3">
                                                                    <div class="col-md-6">
                                                                        <h6>Informations sur l'étudiant</h6>
                                                                        <p><strong>Nom:</strong> {{ $candidature->etudiant->user->name ?? 'Étudiant inconnu' }}</p>
                                                                        <p><strong>Email:</strong> {{ $candidature->etudiant->user->email ?? 'Non disponible' }}</p>
                                                                        <p><strong>Spécialité:</strong> {{ $candidature->etudiant->specialite->nom ?? 'Non spécifiée' }}</p>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <h6>Informations sur la candidature</h6>
                                                                        <p><strong>Date:</strong> {{ $candidature->created_at->format('d/m/Y à H:i') }}</p>
                                                                        <p><strong>Statut:</strong> <span class="badge {{ $statutClass }}">
                                                                            @switch($candidature->statut)
                                                                                @case('en_attente')
                                                                                    En attente
                                                                                    @break
                                                                                @case('en_cours')
                                                                                    En cours de traitement
                                                                                    @break
                                                                                @case('accepte')
                                                                                    Acceptée
                                                                                    @break
                                                                                @case('rejete')
                                                                                    Rejetée
                                                                                    @break
                                                                                @default
                                                                                    {{ $candidature->statut }}
                                                                            @endswitch
                                                                        </span></p>
                                                                    </div>
                                                                </div>
                                                                
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
                                                                            <i class="fas fa-download me-1"></i> Télécharger le CV
                                                                        </a>
                                                                    </div>
                                                                @endif
                                                                
                                                                @if($candidature->motif_rejet)
                                                                    <div class="mb-3">
                                                                        <h6>Motif de rejet</h6>
                                                                        <p>{{ $candidature->motif_rejet }}</p>
                                                                    </div>
                                                                @endif
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <!-- Modal pour changer le statut de la candidature -->
                                                <div class="modal fade" id="changerStatutModal{{ $candidature->id }}" tabindex="-1" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <form action="{{ route('admin.candidatures.updateStatut', $candidature) }}" method="POST">
                                                                @csrf
                                                                @method('PUT')
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title">Modifier le statut de la candidature</h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="mb-3">
                                                                        <label for="statut{{ $candidature->id }}" class="form-label">Statut</label>
                                                                        <select class="form-select" id="statut{{ $candidature->id }}" name="statut" required>
                                                                            <option value="en_attente" {{ $candidature->statut == 'en_attente' ? 'selected' : '' }}>En attente</option>
                                                                            <option value="en_cours" {{ $candidature->statut == 'en_cours' ? 'selected' : '' }}>En cours de traitement</option>
                                                                            <option value="accepte" {{ $candidature->statut == 'accepte' ? 'selected' : '' }}>Acceptée</option>
                                                                            <option value="rejete" {{ $candidature->statut == 'rejete' ? 'selected' : '' }}>Rejetée</option>
                                                                        </select>
                                                                    </div>
                                                                    
                                                                    <div class="mb-3" id="motifRejetDiv{{ $candidature->id }}" style="{{ $candidature->statut == 'rejete' ? '' : 'display: none;' }}">
                                                                        <label for="motif_rejet{{ $candidature->id }}" class="form-label">Motif de rejet</label>
                                                                        <textarea class="form-control" id="motif_rejet{{ $candidature->id }}" name="motif_rejet" rows="3">{{ $candidature->motif_rejet }}</textarea>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                                                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                                                                </div>
                                                            </form>
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
                        <div class="text-center py-5">
                            <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                            <p class="mb-0">Aucune candidature n'a encore été soumise pour cette annonce.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card shadow mb-4 border-left-success">
                <div class="card-header py-3 bg-gradient-light">
                    <h6 class="m-0 font-weight-bold text-success">Actions</h6>
                </div>
                <div class="card-body">
                    @if($annonce->statut === 'en_attente')
                    <form action="{{ route('admin.annonces.approuver', $annonce) }}" method="POST" class="mb-3">
                        @csrf
                        <button type="submit" class="btn btn-success btn-block btn-lg shadow-sm">
                            <i class="fas fa-check"></i> Approuver l'annonce
                        </button>
                    </form>
                    <button type="button" class="btn btn-danger btn-block btn-lg shadow-sm" data-bs-toggle="modal" data-bs-target="#rejectModal">
                        <i class="fas fa-times"></i> Rejeter l'annonce
                    </button>
                    @else
                    <div class="alert alert-{{ $annonce->statut === 'approuve' ? 'success' : 'danger' }} border-0 shadow-sm">
                        <i class="fas {{ $annonce->statut === 'approuve' ? 'fa-check-circle' : 'fa-times-circle' }} fa-lg me-2"></i>
                        L'annonce a été {{ $annonce->statut === 'approuve' ? 'approuvée' : 'rejetée' }} le {{ $annonce->updated_at->format('d/m/Y H:i') }}
                    </div>
                    @endif
                </div>
            </div>

            <div class="card shadow mb-4 border-left-info">
                <div class="card-header py-3 bg-gradient-light">
                    <h6 class="m-0 font-weight-bold text-info">Statistiques</h6>
                </div>
                <div class="card-body">
                    <ul class="list-group shadow-sm">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span><i class="fas fa-eye text-primary me-2"></i> Vues</span>
                            <span class="badge bg-primary rounded-pill">{{ $annonce->nombre_vues }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span><i class="fas fa-users text-info me-2"></i> Candidatures</span>
                            <span class="badge bg-info rounded-pill">{{ $candidatures->total() }}</span>
                        </li>
                        
                        <!-- Statistiques de statut des candidatures -->
                        @php
                            $candidaturesStats = [
                                'en_attente' => $annonce->candidatures->where('statut', 'en_attente')->count(),
                                'en_cours' => $annonce->candidatures->where('statut', 'en_cours')->count(),
                                'accepte' => $annonce->candidatures->where('statut', 'accepte')->count(),
                                'rejete' => $annonce->candidatures->where('statut', 'rejete')->count(),
                            ];
                        @endphp
                        
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span><i class="fas fa-clock text-warning me-2"></i> En attente</span>
                            <span class="badge bg-warning rounded-pill">{{ $candidaturesStats['en_attente'] }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span><i class="fas fa-spinner text-info me-2"></i> En traitement</span>
                            <span class="badge bg-info rounded-pill">{{ $candidaturesStats['en_cours'] }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span><i class="fas fa-check text-success me-2"></i> Acceptées</span>
                            <span class="badge bg-success rounded-pill">{{ $candidaturesStats['accepte'] }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span><i class="fas fa-times text-danger me-2"></i> Rejetées</span>
                            <span class="badge bg-danger rounded-pill">{{ $candidaturesStats['rejete'] }}</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de rejet -->
<div class="modal fade" id="rejectModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title"><i class="fas fa-times-circle me-2"></i>Rejeter l'annonce</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.annonces.rejeter', $annonce) }}" method="POST">
                @csrf
                <div class="modal-body">
                    @if(session('error'))
                    <div class="alert alert-danger mb-3">
                        {{ session('error') }}
                    </div>
                    @endif
                    <div class="mb-3">
                        <label for="motif_rejet" class="form-label">Motif du rejet <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('motif_rejet') is-invalid @enderror" 
                                  name="motif_rejet" 
                                  id="motif_rejet_show" 
                                  rows="3" 
                                  required 
                                  minlength="10">{{ old('motif_rejet') }}</textarea>
                        @error('motif_rejet')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Minimum 10 caractères requis</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-times me-1"></i> Confirmer le rejet
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Afficher/masquer le champ motif de rejet en fonction du statut sélectionné
    document.addEventListener('DOMContentLoaded', function() {
        @foreach($candidatures as $candidature)
            document.getElementById('statut{{ $candidature->id }}')?.addEventListener('change', function() {
                if (this.value === 'rejete') {
                    document.getElementById('motifRejetDiv{{ $candidature->id }}').style.display = 'block';
                } else {
                    document.getElementById('motifRejetDiv{{ $candidature->id }}').style.display = 'none';
                }
            });
        @endforeach
    });
</script>
@endpush

@if(session('success'))
<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
    <div class="toast show shadow-lg" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header bg-success text-white">
            <i class="fas fa-check-circle me-2"></i>
            <strong class="me-auto">Notification</strong>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"></button>
        </div>
        <div class="toast-body bg-success text-white">
            {{ session('success') }}
        </div>
    </div>
</div>
@endif

@endsection 