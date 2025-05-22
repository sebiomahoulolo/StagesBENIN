@extends('layouts.admin.app')

@section('title', 'Détails de l\'annonce')

{{-- Ajout du CSS pour le template du CV --}}
@push('styles')
    <link rel="stylesheet" href="{{ asset('css/cv-show.css') }}">
@endpush

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
                                                        case 'en_attente': $statutClass = 'bg-warning'; break;
                                                        case 'accepte': $statutClass = 'bg-success'; break;
                                                        case 'rejete': $statutClass = 'bg-danger'; break;
                                                        case 'en_cours': $statutClass = 'bg-info'; break;
                                                        default: $statutClass = 'bg-secondary';
                                                    }
                                                @endphp
                                                <span class="badge {{ $statutClass }}">
                                                    @switch($candidature->statut)
                                                        @case('en_attente') En attente @break
                                                        @case('en_cours') En cours de traitement @break
                                                        @case('accepte') Acceptée @break
                                                        @case('rejete') Rejetée @break
                                                        @default {{ $candidature->statut }}
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
                                                    <div class="modal-dialog modal-xl">
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
                                                                                @case('en_attente') En attente @break
                                                                                @case('en_cours') En cours de traitement @break
                                                                                @case('accepte') Acceptée @break
                                                                                @case('rejete') Rejetée @break
                                                                                @default {{ $candidature->statut }}
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
                                                                
                                                                {{-- Section CV - COMPLET ET FONCTIONNEL --}}
                                                                <div class="mb-3">
                                                                    <h6>Curriculum Vitae</h6>
                                                                    @if ($candidature->etudiant->cvProfile)
                                                                        {{-- Boutons d'action pour le CV --}}
                                                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                                                            <span class="text-success">
                                                                                <i class="fas fa-file-pdf"></i> CV disponible
                                                                            </span>
                                                                            <div class="btn-group">
                                                                                <button type="button" class="btn btn-outline-primary btn-sm" onclick="toggleCvPreview({{ $candidature->id }})">
                                                                                    <i class="fas fa-eye"></i> <span id="toggle-text-{{ $candidature->id }}">Voir l'aperçu</span>
                                                                                </button>
                                                                                <button type="button" class="btn btn-primary btn-sm" onclick="generatePdf({{ $candidature->id }})">
                                                                                    <i class="fas fa-download"></i> Télécharger PDF
                                                                                </button>
                                                                            </div>
                                                                        </div>
                                                                        
                                                                        {{-- Contenu du CV caché pour la génération PDF --}}
                                                                        <div id="cv-content-{{ $candidature->id }}" style="display: none;" class="cv-show-page">
                                                                            @include('etudiants.cv.templates.default', ['cvProfile' => $candidature->etudiant->cvProfile])
                                                                        </div>
                                                                        
                                                                        {{-- Aperçu condensé du CV --}}
                                                                        <div id="cv-preview-{{ $candidature->id }}" class="p-3 bg-light rounded border" style="display: none;">
                                                                            <div class="row">
                                                                                <div class="col-md-6">
                                                                                    <h6 class="text-primary mb-2">
                                                                                        <i class="fas fa-user"></i> Informations personnelles
                                                                                    </h6>
                                                                                    <p class="mb-1"><strong>Nom :</strong> {{ $candidature->etudiant->cvProfile->prenom ?? '' }} {{ $candidature->etudiant->cvProfile->nom ?? '' }}</p>
                                                                                    <p class="mb-1"><strong>Email :</strong> {{ $candidature->etudiant->cvProfile->email ?? $candidature->etudiant->user->email }}</p>
                                                                                    <p class="mb-1"><strong>Téléphone :</strong> {{ $candidature->etudiant->cvProfile->telephone ?? 'Non renseigné' }}</p>
                                                                                    <p class="mb-1"><strong>Adresse :</strong> {{ $candidature->etudiant->cvProfile->adresse ?? 'Non renseignée' }}</p>
                                                                                </div>
                                                                                <div class="col-md-6">
                                                                                    <h6 class="text-primary mb-2">
                                                                                        <i class="fas fa-briefcase"></i> Profil professionnel
                                                                                    </h6>
                                                                                    @if($candidature->etudiant->cvProfile->profil_professionnel)
                                                                                        <p class="text-justify small">{{ Str::limit($candidature->etudiant->cvProfile->profil_professionnel, 200) }}</p>
                                                                                    @else
                                                                                        <p class="text-muted small">Aucun profil professionnel renseigné</p>
                                                                                    @endif
                                                                                </div>
                                                                            </div>
                                                                            
                                                                            @if($candidature->etudiant->cvProfile->formations && count($candidature->etudiant->cvProfile->formations) > 0)
                                                                            <div class="mt-3">
                                                                                <h6 class="text-primary mb-2">
                                                                                    <i class="fas fa-graduation-cap"></i> Formations récentes
                                                                                </h6>
                                                                                @foreach(array_slice($candidature->etudiant->cvProfile->formations, 0, 3) as $formation)
                                                                                    <div class="border-start border-info ps-3 mb-2">
                                                                                        <strong>{{ $formation['diplome'] ?? 'Diplôme non précisé' }}</strong><br>
                                                                                        <small class="text-muted">
                                                                                            {{ $formation['etablissement'] ?? 'Établissement non précisé' }} 
                                                                                            @if(isset($formation['annee_fin']))
                                                                                                - {{ $formation['annee_fin'] }}
                                                                                            @endif
                                                                                        </small>
                                                                                        @if(isset($formation['description']) && $formation['description'])
                                                                                            <p class="small text-muted mt-1">{{ Str::limit($formation['description'], 100) }}</p>
                                                                                        @endif
                                                                                    </div>
                                                                                @endforeach
                                                                                @if(count($candidature->etudiant->cvProfile->formations) > 3)
                                                                                    <small class="text-muted">... et {{ count($candidature->etudiant->cvProfile->formations) - 3 }} autre(s) formation(s)</small>
                                                                                @endif
                                                                            </div>
                                                                            @endif
                                                                            
                                                                            @if($candidature->etudiant->cvProfile->experiences && count($candidature->etudiant->cvProfile->experiences) > 0)
                                                                            <div class="mt-3">
                                                                                <h6 class="text-primary mb-2">
                                                                                    <i class="fas fa-building"></i> Expériences récentes
                                                                                </h6>
                                                                                @foreach(array_slice($candidature->etudiant->cvProfile->experiences, 0, 3) as $experience)
                                                                                    <div class="border-start border-success ps-3 mb-2">
                                                                                        <strong>{{ $experience['poste'] ?? 'Poste non précisé' }}</strong><br>
                                                                                        <small class="text-muted">
                                                                                            {{ $experience['entreprise'] ?? 'Entreprise non précisée' }}
                                                                                            @if(isset($experience['date_debut']) || isset($experience['date_fin']))
                                                                                                - 
                                                                                                @if(isset($experience['date_debut']))
                                                                                                    {{ date('m/Y', strtotime($experience['date_debut'])) }}
                                                                                                @endif
                                                                                                @if(isset($experience['date_fin']))
                                                                                                    à {{ date('m/Y', strtotime($experience['date_fin'])) }}
                                                                                                @endif
                                                                                            @endif
                                                                                        </small>
                                                                                        @if(isset($experience['description']) && $experience['description'])
                                                                                            <p class="small text-muted mt-1">{{ Str::limit($experience['description'], 100) }}</p>
                                                                                        @endif
                                                                                    </div>
                                                                                @endforeach
                                                                                @if(count($candidature->etudiant->cvProfile->experiences) > 3)
                                                                                    <small class="text-muted">... et {{ count($candidature->etudiant->cvProfile->experiences) - 3 }} autre(s) expérience(s)</small>
                                                                                @endif
                                                                            </div>
                                                                            @endif
                                                                            
                                                                            @if($candidature->etudiant->cvProfile->competences && count($candidature->etudiant->cvProfile->competences) > 0)
                                                                            <div class="mt-3">
                                                                                <h6 class="text-primary mb-2">
                                                                                    <i class="fas fa-cogs"></i> Compétences
                                                                                </h6>
                                                                                <div class="d-flex flex-wrap gap-1">
                                                                                    @foreach(array_slice($candidature->etudiant->cvProfile->competences, 0, 12) as $competence)
                                                                                        <span class="badge bg-secondary">{{ $competence['nom'] ?? $competence }}</span>
                                                                                    @endforeach
                                                                                    @if(count($candidature->etudiant->cvProfile->competences) > 12)
                                                                                        <span class="badge bg-light text-dark">+{{ count($candidature->etudiant->cvProfile->competences) - 12 }}</span>
                                                                                    @endif
                                                                                </div>
                                                                            </div>
                                                                            @endif
                                                                            
                                                                            @if($candidature->etudiant->cvProfile->langues && count($candidature->etudiant->cvProfile->langues) > 0)
                                                                            <div class="mt-3">
                                                                                <h6 class="text-primary mb-2">
                                                                                    <i class="fas fa-language"></i> Langues
                                                                                </h6>
                                                                                <div class="row">
                                                                                    @foreach(array_slice($candidature->etudiant->cvProfile->langues, 0, 6) as $langue)
                                                                                        <div class="col-md-4 mb-2">
                                                                                            <span class="fw-bold">{{ $langue['nom'] ?? 'Langue inconnue' }}</span><br>
                                                                                            <small class="text-muted">{{ $langue['niveau'] ?? 'Niveau non précisé' }}</small>
                                                                                        </div>
                                                                                    @endforeach
                                                                                </div>
                                                                            </div>
                                                                            @endif
                                                                            
                                                                            <div class="mt-3 pt-3 border-top text-center">
                                                                                <button type="button" class="btn btn-primary btn-sm" onclick="generatePdf({{ $candidature->id }})">
                                                                                    <i class="fas fa-download"></i> Télécharger le CV complet
                                                                                </button>
                                                                            </div>
                                                                        </div>
                                                                    @else
                                                                        <div class="alert alert-warning">
                                                                            <i class="fas fa-exclamation-triangle"></i>
                                                                            Aucun CV n'a été renseigné par cet étudiant.
                                                                        </div>
                                                                    @endif
                                                                </div>
                                               
                                                                @if($candidature->motif_rejet)
                                                                    <div class="mb-3">
                                                                        <h6>Motif de rejet de la candidature</h6>
                                                                        <div class="alert alert-danger p-2">{{ $candidature->motif_rejet }}</div>
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
                    <h6 class="m-0 font-weight-bold text-success">Actions sur l'annonce</h6>
                </div>
                <div class="card-body">
                    @if($annonce->statut === 'en_attente')
                    <form action="{{ route('admin.annonces.approuver', $annonce) }}" method="POST" class="mb-3">
                        @csrf
                        <button type="submit" class="btn btn-success btn-block btn-lg shadow-sm w-100">
                            <i class="fas fa-check"></i> Approuver l'annonce
                        </button>
                    </form>
                    <button type="button" class="btn btn-danger btn-block btn-lg shadow-sm w-100" data-bs-toggle="modal" data-bs-target="#rejectModal">
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

<!-- Modal de rejet de l'annonce -->
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
                    @if(session('error_rejet_annonce'))
                    <div class="alert alert-danger mb-3">
                        {{ session('error_rejet_annonce') }}
                    </div>
                    @endif
                    <div class="mb-3">
                        <label for="motif_rejet_annonce" class="form-label">Motif du rejet <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('motif_rejet', 'rejetAnnonce') is-invalid @enderror" 
                                  name="motif_rejet" 
                                  id="motif_rejet_annonce" 
                                  rows="3" 
                                  required 
                                  minlength="10">{{ old('motif_rejet') }}</textarea>
                        @error('motif_rejet', 'rejetAnnonce')
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
<script>
// Fonction pour basculer l'aperçu du CV
function toggleCvPreview(candidatureId) {
    const preview = document.getElementById('cv-preview-' + candidatureId);
    const toggleText = document.getElementById('toggle-text-' + candidatureId);
    
    if (preview.style.display === 'none' || preview.style.display === '') {
        preview.style.display = 'block';
        toggleText.textContent = 'Masquer l\'aperçu';
    } else {
        preview.style.display = 'none';
        toggleText.textContent = 'Voir l\'aperçu';
    }
}

// Fonction principale de génération PDF
function generatePdf(candidatureId) {
    const element = document.getElementById('cv-content-' + candidatureId);
    if (!element) {
        alert("Le contenu du CV pour cette candidature est introuvable.");
        return;
    }

    // Afficher un indicateur de chargement
    const button = event.target.closest('button');
    const originalContent = button.innerHTML;
    button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Génération...';
    button.disabled = true;

    // Récupérer le nom de l'étudiant
    let studentName = "CV-Etudiant"; 
    
    // Essayer plusieurs sélecteurs pour trouver le nom de l'étudiant
    const possibleSelectors = [
        '.cv-header h1',
        '.nom-etudiant',
        '.cv-name',
        'h1',
        'h2',
        '.name',
        '[data-name]'
    ];
    
    for (let selector of possibleSelectors) {
        const nameElement = element.querySelector(selector);
        if (nameElement && nameElement.textContent.trim()) {
            studentName = nameElement.textContent.trim()
                .replace(/\s+/g, '_')
                .replace(/[^a-zA-Z0-9_-]/g, ''); // Supprimer les caractères spéciaux
            break;
        }
    }

    // Si on n'a pas trouvé le nom dans le CV, essayer de le récupérer depuis le modal
    if (studentName === "CV-Etudiant") {
        const modalElement = document.querySelector(`#candidatureModal${candidatureId}`);
        if (modalElement) {
            const nameElements = modalElement.querySelectorAll('p');
            for (let p of nameElements) {
                if (p.textContent.includes('Nom:')) {
                    const nameText = p.textContent.replace('Nom:', '').trim();
                    if (nameText && nameText !== 'Étudiant inconnu') {
                        studentName = nameText.replace(/\s+/g, '_').replace(/[^a-zA-Z0-9_-]/g, '');
                        break;
                    }
                }
            }
        }
    }

    // Préparer l'élément pour la génération PDF
    const originalStyles = {
        display: element.style.display,
        position: element.style.position,
        left: element.style.left,
        top: element.style.top,
        width: element.style.width,
        background: element.style.background,
        padding: element.style.padding,
        visibility: element.style.visibility
    };

    // Rendre l'élément temporairement visible pour html2pdf
    element.style.display = 'block';
    element.style.position = 'absolute';
    element.style.left = '-9999px';
    element.style.top = '0';
    element.style.width = '210mm'; // Format A4
    element.style.background = 'white';
    element.style.padding = '20px';
    element.style.visibility = 'visible';

    const opt = {
        margin: [10, 10, 10, 10], // marges en mm
        filename: `${studentName}_CV_${new Date().toISOString().split('T')[0]}.pdf`,
        image: { 
            type: 'jpeg', 
            quality: 0.98 
        },
        html2canvas: { 
            scale: 2, 
            useCORS: true, 
            logging: false,
            allowTaint: true,
            backgroundColor: '#ffffff',
            width: 794, // Largeur A4 en pixels
            height: 1123, // Hauteur A4 en pixels
            windowWidth: 794,
            removeContainer: true
        },
        jsPDF: { 
            unit: 'mm', 
            format: 'a4', 
            orientation: 'portrait',
            compress: true
        },
        pagebreak: { 
            mode: ['avoid-all', 'css', 'legacy'],
            before: '.page-break-before',
            after: '.page-break-after'
        }
    };

    // Générer le PDF
    html2pdf().set(opt).from(element).save()
        .then(() => {
            console.log('PDF généré avec succès');
        })
        .catch((error) => {
            console.error('Erreur lors de la génération du PDF:', error);
            alert('Erreur lors de la génération du PDF. Veuillez réessayer.');
        })
        .finally(() => {
            // Remettre l'élément dans son état original
            Object.keys(originalStyles).forEach(prop => {
                element.style[prop] = originalStyles[prop];
            });
            
            // Remettre le bouton dans son état original
            button.innerHTML = originalContent;
            button.disabled = false;
        });
}

// Fonction alternative d'impression si html2pdf ne fonctionne pas
function generatePdfAlternative(candidatureId) {
    const element = document.getElementById('cv-content-' + candidatureId);
    if (!element) {
        alert("Le contenu du CV pour cette candidature est introuvable.");
        return;
    }

    // Ouvrir le CV dans une nouvelle fenêtre pour impression
    const printWindow = window.open('', '_blank', 'width=800,height=600');
    const printDocument = printWindow.document;
    
    printDocument.write(`
        <!DOCTYPE html>
        <html>
        <head>
            <title>CV - Candidature ${candidatureId}</title>
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
            <link href="${window.location.origin}/css/cv-show.css" rel="stylesheet">
            <style>
                body { 
                    font-family: Arial, sans-serif; 
                    margin: 20px;
                    background: white;
                }
                @media print {
                    .no-print { display: none !important; }
                    body { margin: 0; }
                    @page { margin: 1cm; }
                }
                .cv-show-page {
                    max-width: none !important;
                    box-shadow: none !important;
                }
            </style>
        </head>
        <body>
            <div class="container-fluid p-4">
                ${element.innerHTML}
            </div>
            <script>
                window.onload = function() {
                    setTimeout(() => {
                        window.print();
                    }, 500);
                };
                
                window.onafterprint = function() {
                    setTimeout(() => {
                        window.close();
                    }, 1000);
                };
            </script>
        </body>
        </html>
    `);
    
    printDocument.close();
}

// Initialisation au chargement de la page
document.addEventListener('DOMContentLoaded', function() {
    // Vérifier si html2pdf est disponible
    if (typeof html2pdf === 'undefined') {
        console.warn('html2pdf n\'est pas chargé. Utilisation de l\'alternative d\'impression.');
        window.generatePdf = generatePdfAlternative;
    }

    // Gestion des changements de statut des candidatures
    @foreach($candidatures as $candidature)
        const statutSelect{{ $candidature->id }} = document.getElementById('statut{{ $candidature->id }}');
        const motifRejetDiv{{ $candidature->id }} = document.getElementById('motifRejetDiv{{ $candidature->id }}');
        
        if (statutSelect{{ $candidature->id }}) {
            statutSelect{{ $candidature->id }}.addEventListener('change', function() {
                if (this.value === 'rejete') {
                    motifRejetDiv{{ $candidature->id }}.style.display = 'block';
                    motifRejetDiv{{ $candidature->id }}.querySelector('textarea').required = true;
                } else {
                    motifRejetDiv{{ $candidature->id }}.style.display = 'none';
                    motifRejetDiv{{ $candidature->id }}.querySelector('textarea').required = false;
                    motifRejetDiv{{ $candidature->id }}.querySelector('textarea').value = '';
                }
            });
            
            // État initial
            if (statutSelect{{ $candidature->id }}.value === 'rejete') {
                motifRejetDiv{{ $candidature->id }}.style.display = 'block';
                motifRejetDiv{{ $candidature->id }}.querySelector('textarea').required = true;
            } else {
                motifRejetDiv{{ $candidature->id }}.querySelector('textarea').required = false;
            }
        }
    @endforeach

    // Gestion du modal de rejet d'annonce
    @if ($errors->rejetAnnonce->any() || session('error_rejet_annonce'))
        var rejectAnnonceModal = new bootstrap.Modal(document.getElementById('rejectModal'));
        rejectAnnonceModal.show();
    @endif
});
</script>
@endpush

@if(session('success'))
<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 1056">
    <div id="successToast" class="toast show align-items-center text-white bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body">
                <i class="fas fa-check-circle me-2"></i>
                {{ session('success') }}
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
</div>
@endif

@if(session('error'))
<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 1056">
    <div id="errorToast" class="toast show align-items-center text-white bg-danger border-0" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body">
                <i class="fas fa-exclamation-circle me-2"></i>
                {{ session('error') }}
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
</div>
@endif

@endsection