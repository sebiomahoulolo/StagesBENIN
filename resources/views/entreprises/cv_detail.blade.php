@extends('layouts.entreprises.master')

@section('title', 'Détail du CV - StagesBENIN')

@section('content')
<div class="content-area">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="dashboard-title mb-0">Détail du CV</h1>
        <a href="{{ route('entreprises.cvtheque.index') }}" class="btn btn-outline-primary">
            <i class="fas fa-arrow-left me-2"></i>Retour à la liste
        </a>
    </div>

    @if(!$cvProfile || !$cvProfile->etudiant)
        <div class="alert alert-danger">
            <i class="fas fa-exclamation-triangle me-2"></i>
            Ce CV n'est pas disponible ou a été supprimé.
        </div>
    @else
        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center">
                        <div class="cv-profile-image mb-3">
                            @if($cvProfile->etudiant->photo)
                                <img src="{{ asset('storage/' . $cvProfile->etudiant->photo) }}" alt="Photo de profil" class="img-fluid rounded-circle profile-img">
                            @else
                                <div class="profile-placeholder">
                                    <span>{{ strtoupper(substr($cvProfile->etudiant->prenom ?? 'A', 0, 1)) }}</span>
                                </div>
                            @endif
                        </div>
                        <h4 class="fw-bold">{{ $cvProfile->etudiant->prenom ?? '' }} {{ $cvProfile->etudiant->nom ?? '' }}</h4>
                        <p class="text-muted mb-2">{{ $cvProfile->etudiant->formation ?? 'Formation non spécifiée' }}</p>
                        <p class="badge bg-primary">{{ $cvProfile->etudiant->niveau ?? 'Niveau non spécifié' }}</p>
                        
                        <hr>
                        
                        <div class="contact-info text-start">
                            <h5 class="text-primary mb-3">Coordonnées</h5>
                            
                            <div class="d-flex align-items-center mb-2">
                                <i class="fas fa-envelope text-muted me-3"></i>
                                <span>{{ $cvProfile->etudiant->email ?? 'Email non spécifié' }}</span>
                            </div>
                            
                            <div class="d-flex align-items-center mb-2">
                                <i class="fas fa-phone text-muted me-3"></i>
                                <span>{{ $cvProfile->etudiant->telephone ?? 'Téléphone non spécifié' }}</span>
                            </div>
                            
                            @if(isset($cvProfile->etudiant->date_naissance))
                                <div class="d-flex align-items-center mb-2">
                                    <i class="fas fa-birthday-cake text-muted me-3"></i>
                                    <span>{{ \Carbon\Carbon::parse($cvProfile->etudiant->date_naissance)->format('d/m/Y') }}</span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                
                @if($cvProfile->cv_file)
                    <div class="mt-4 text-center">
                        <a href="{{ asset('storage/' . $cvProfile->cv_file) }}" class="btn btn-success" target="_blank">
                            <i class="fas fa-file-pdf me-2"></i>Télécharger le CV
                        </a>
                    </div>
                @endif
            </div>
            
            <div class="col-md-8">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">
                        <h5 class="card-title text-primary">
                            <i class="fas fa-user-graduate me-2"></i>
                            Profil
                        </h5>
                        <p>{{ $cvProfile->resume ?? 'Aucune information de profil disponible.' }}</p>
                    </div>
                </div>
                
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">
                        <h5 class="card-title text-primary">
                            <i class="fas fa-briefcase me-2"></i>
                            Expériences professionnelles
                        </h5>
                        @if(isset($cvProfile->experiences) && $cvProfile->experiences->count() > 0)
                            @foreach($cvProfile->experiences as $experience)
                                <div class="experience-item mb-3">
                                    <h6 class="fw-bold">{{ $experience->titre ?? '' }}</h6>
                                    <p class="text-muted mb-1">
                                        {{ $experience->entreprise ?? '' }}
                                        @if(isset($experience->date_debut) || isset($experience->date_fin))
                                            | {{ $experience->date_debut ?? '' }} - {{ $experience->date_fin ?? 'Présent' }}
                                        @endif
                                    </p>
                                    <p>{{ $experience->description ?? '' }}</p>
                                </div>
                                @if(!$loop->last)
                                    <hr class="my-3">
                                @endif
                            @endforeach
                        @else
                            <p class="text-muted">Aucune expérience professionnelle renseignée.</p>
                        @endif
                    </div>
                </div>
                
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">
                        <h5 class="card-title text-primary">
                            <i class="fas fa-graduation-cap me-2"></i>
                            Formation
                        </h5>
                        @if(isset($cvProfile->formations) && $cvProfile->formations->count() > 0)
                            @foreach($cvProfile->formations as $formation)
                                <div class="formation-item mb-3">
                                    <h6 class="fw-bold">{{ $formation->diplome ?? '' }}</h6>
                                    <p class="text-muted mb-1">
                                        {{ $formation->etablissement ?? '' }}
                                        @if(isset($formation->annee_debut) || isset($formation->annee_fin))
                                            | {{ $formation->annee_debut ?? '' }} - {{ $formation->annee_fin ?? 'En cours' }}
                                        @endif
                                    </p>
                                    <p>{{ $formation->description ?? '' }}</p>
                                </div>
                                @if(!$loop->last)
                                    <hr class="my-3">
                                @endif
                            @endforeach
                        @else
                            <p class="text-muted">Aucune formation renseignée.</p>
                        @endif
                    </div>
                </div>
                
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title text-primary">
                            <i class="fas fa-tools me-2"></i>
                            Compétences
                        </h5>
                        @if(isset($cvProfile->competences) && $cvProfile->competences->count() > 0)
                            <div class="row">
                                @foreach($cvProfile->competences as $competence)
                                    <div class="col-md-6 mb-2">
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-check-circle text-success me-2"></i>
                                            <span>{{ $competence->nom ?? $competence->competence }}</span>
                                            @if($competence->niveau)
                                                <div class="ms-2">
                                                    @for($i = 1; $i <= 5; $i++)
                                                        <i class="fas fa-star {{ $i <= $competence->niveau ? 'text-warning' : 'text-muted' }} small"></i>
                                                    @endfor
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-muted">Aucune compétence renseignée.</p>
                        @endif
                    </div>
                </div>

                <!-- Langues -->
                <div class="card border-0 shadow-sm mt-4">
                    <div class="card-body">
                        <h5 class="card-title text-primary">
                            <i class="fas fa-language me-2"></i>
                            Langues
                        </h5>
                        @if(isset($cvProfile->langues) && $cvProfile->langues->count() > 0)
                            <div class="row">
                                @foreach($cvProfile->langues as $langue)
                                    <div class="col-md-6 mb-2">
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-globe text-info me-2"></i>
                                            <span>{{ $langue->langue }}</span>
                                            @if($langue->niveau)
                                                <div class="ms-2">
                                                    <span class="badge bg-primary">{{ $langue->niveau }}</span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-muted">Aucune langue renseignée.</p>
                        @endif
                    </div>
                </div>

                <!-- Centres d'intérêt -->
                <div class="card border-0 shadow-sm mt-4">
                    <div class="card-body">
                        <h5 class="card-title text-primary">
                            <i class="fas fa-heart me-2"></i>
                            Centres d'intérêt
                        </h5>
                        @if(isset($cvProfile->centresInteret) && $cvProfile->centresInteret->count() > 0)
                            <div class="row">
                                @foreach($cvProfile->centresInteret as $interet)
                                    <div class="col-md-6 mb-2">
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-star text-warning me-2"></i>
                                            <span>{{ $interet->interet }}</span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-muted">Aucun centre d'intérêt renseigné.</p>
                        @endif
                    </div>
                </div>

                <!-- Certifications -->
                <div class="card border-0 shadow-sm mt-4">
                    <div class="card-body">
                        <h5 class="card-title text-primary">
                            <i class="fas fa-certificate me-2"></i>
                            Certifications
                        </h5>
                        @if(isset($cvProfile->certifications) && $cvProfile->certifications->count() > 0)
                            @foreach($cvProfile->certifications as $certification)
                                <div class="certification-item mb-3">
                                    <h6 class="fw-bold">{{ $certification->titre }}</h6>
                                    <p class="text-muted mb-1">
                                        {{ $certification->organisme }}
                                        @if($certification->annee)
                                            | {{ $certification->annee }}
                                        @endif
                                    </p>
                                    @if($certification->description)
                                        <p>{{ $certification->description }}</p>
                                    @endif
                                </div>
                                @if(!$loop->last)
                                    <hr class="my-3">
                                @endif
                            @endforeach
                        @else
                            <p class="text-muted">Aucune certification renseignée.</p>
                        @endif
                    </div>
                </div>

                <!-- Projets -->
                <div class="card border-0 shadow-sm mt-4">
                    <div class="card-body">
                        <h5 class="card-title text-primary">
                            <i class="fas fa-project-diagram me-2"></i>
                            Projets
                        </h5>
                        @if(isset($cvProfile->projets) && $cvProfile->projets->count() > 0)
                            @foreach($cvProfile->projets as $projet)
                                <div class="projet-item mb-3">
                                    <h6 class="fw-bold">{{ $projet->titre }}</h6>
                                    <p class="text-muted mb-1">
                                        @if($projet->date_debut || $projet->date_fin)
                                            {{ $projet->date_debut ?? '' }} - {{ $projet->date_fin ?? 'En cours' }}
                                        @endif
                                    </p>
                                    @if($projet->description)
                                        <p>{{ $projet->description }}</p>
                                    @endif
                                    @if($projet->url)
                                        <a href="{{ $projet->url }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-external-link-alt me-1"></i> Voir le projet
                                        </a>
                                    @endif
                                </div>
                                @if(!$loop->last)
                                    <hr class="my-3">
                                @endif
                            @endforeach
                        @else
                            <p class="text-muted">Aucun projet renseigné.</p>
                        @endif
                    </div>
                </div>

                <!-- Références professionnelles -->
                <div class="card border-0 shadow-sm mt-4">
                    <div class="card-body">
                        <h5 class="card-title text-primary">
                            <i class="fas fa-user-tie me-2"></i>
                            Références professionnelles
                        </h5>
                        @if(isset($cvProfile->references) && $cvProfile->references->count() > 0)
                            @foreach($cvProfile->references as $reference)
                                <div class="reference-item mb-3">
                                    <h6 class="fw-bold">{{ $reference->nom }}</h6>
                                    <p class="text-muted mb-1">{{ $reference->titre }} chez {{ $reference->entreprise }}</p>
                                    
                                    <div class="d-flex flex-wrap mt-2">
                                        @if($reference->telephone)
                                            <div class="me-3 mb-1">
                                                <i class="fas fa-phone text-muted me-1"></i>
                                                {{ $reference->telephone }}
                                            </div>
                                        @endif
                                        
                                        @if($reference->email)
                                            <div class="me-3 mb-1">
                                                <i class="fas fa-envelope text-muted me-1"></i>
                                                {{ $reference->email }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                @if(!$loop->last)
                                    <hr class="my-3">
                                @endif
                            @endforeach
                        @else
                            <p class="text-muted">Aucune référence professionnelle renseignée.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection

@push('styles')
<style>
    .content-area {
        background-color: #f8f9fa;
        border-radius: 8px;
        padding: 25px;
    }
    
    .card {
        border-radius: 8px;
        overflow: hidden;
    }
    
    .cv-profile-image {
        width: 120px;
        height: 120px;
        margin: 0 auto;
    }
    
    .profile-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .profile-placeholder {
        width: 100%;
        height: 100%;
        background-color: var(--primary);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 3rem;
        font-weight: bold;
        border-radius: 50%;
    }
    
    .contact-info i {
        width: 20px;
        text-align: center;
    }
</style>
@endpush 