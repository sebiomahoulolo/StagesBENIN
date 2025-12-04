@extends('layouts.app')
@section('content')

@php
    $user = Auth::user();
@endphp
<div class="card shadow-sm mb-4">
    <div class="card-body text-center">
        @if($user && $user->estAbonneActif())
            <form method="POST" action="{{ route('cv.telecharger') }}">
                @csrf
                <button type="submit" class="btn btn-outline-primary btn-lg w-100 mb-2">
                    Télécharger mon CV (abonnement actif)
                </button>
            </form>
            <small class="text-success">
                Téléchargement illimité jusqu'au {{ $user->abonnement->date_fin->format('d/m/Y') }}
            </small>
        @else
            @if($downloadsRestants > 0 && !session('error'))
                <form method="POST" action="{{ route('cv.telecharger') }}">
                    @csrf
                    <button type="submit" class="btn btn-outline-primary btn-lg w-100 mb-2">
                        Télécharger ({{ $downloadsRestants }} téléchargement{{ $downloadsRestants <= 1 ? '' : 's' }} restant{{ $downloadsRestants <= 1 ? '' : 's' }})
                    </button>
                </form>
                <small class="text-muted">
                    Vous pouvez encore télécharger votre CV {{ $downloadsRestants }} fois.
                </small>
            @else
                <div class="alert alert-warning mb-3">
                    Pour continuer à télécharger votre CV, veuillez effectuer un paiement.
                </div>
                <a href="https://me.fedapay.com/Ol_Zva4W" target="_blank" class="btn btn-success btn-lg w-100 mb-2">
                    <i class="fas fa-credit-card"></i> Payer pour 3 téléchargements
                </a>
                <small class="text-muted">
                    Après le paiement, vous pourrez télécharger votre CV 3 fois.
                </small>
            @endif
        @endif
        @if(session('error'))
            <div class="alert alert-danger mt-2">
                {{ session('error') }}<br>
                <span class="text-danger">Veuillez effectuer le paiement pour continuer. Merci !</span>
            </div>
        @endif
        @if(session('success'))
            <div class="alert alert-success mt-2">
                {{ session('success') }}
            </div>
        @endif
    </div>
</div>
    <div class="d-flex justify-content-end mb-4">
        <a href="{{ route('cv.lettre_motivation') }}" class="btn btn-outline-primary btn-lg">
            Voir ma lettre de motivation
        </a>
    </div>
    <div class="row">
        <div class="col-md-4 p-3">
            <div class="accordion" id="accordionExample">

                  {{-- Informations Générales --}}

                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button fw-bold" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            Informations Générales <span class="text-danger">*</span>
                        </button>
                    </h2>
                    <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            @include('components.cvProfile')
                        </div>
                    </div>
                </div>

                 {{-- Formations Academiques --}}

                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                            Formations Academiques <span class="text-danger">*</span>
                        </button>
                    </h2>
                    <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            @include('components.cvFormation')

                        </div>
                    </div>
                </div>

                {{-- Expériences Professionnelles --}}

                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                            Expériences Professionnelles <span class="text-danger">*</span>
                        </button>
                    </h2>
                    <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            @include('components.cvExperience')
                        </div>
                    </div>
                </div>

{{-- Compétences --}}

                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                            Compétences <span class="text-danger">*</span>
                        </button>
                    </h2>
                    <div id="collapseFour" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            @include('components.cvCompetence')
                        </div>
                    </div>
                </div>


{{-- Centres d'Intérêt --}}

                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseLoisirs" aria-expanded="false" aria-controls="collapseLoisirs">
                            Centres d'Intérêt <span class="text-danger">*</span>
                        </button>
                    </h2>
                    <div id="collapseLoisirs" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            @include('components.cvLoisirs')
                                    </div>
                            </div>
                        </div>


{{-- Certifications & Attestations  --}}

                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseCertifications" aria-expanded="false" aria-controls="collapseCertifications">
                            Certifications & Attestations <span class="text-danger">*</span>
                        </button>
                    </h2>
                    <div id="collapseCertifications" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            @include('components.cvCertifications')
                                        </div>
                                        </div>
                                    </div>


                {{-- Langues --}}
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseSeven" aria-expanded="false" aria-controls="collapseSeven">
                            Langues <span class="text-danger">*</span>
                        </button>
                    </h2>
                    <div id="collapseSeven" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            @include('components.cvLangues')
                        </div>
                    </div>
                </div>

        {{-- Projets --}}
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseEight" aria-expanded="false" aria-controls="collapseEight">
                            Projets <span class="text-danger">*</span>
                        </button>
                    </h2>
                    <div id="collapseEight" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            @include('components.cvProjets')
                        </div>
                    </div>
                </div>

            {{-- Références --}}

                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseReferences" aria-expanded="false" aria-controls="collapseReferences">
                            Références <span class="text-danger">*</span>
                        </button>
                    </h2>
                    <div id="collapseReferences" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            @include('components.cvReferences')
                                        </div>
                                        </div>
                                    </div>
            </div>
        </div>


        <div class="col-md-8 p-3">
            <div class="cv-preview">
                <table class="cv-container" cellpadding="0" cellspacing="0" border="0">
                    <tr>
                        <td class="header-cell" colspan="2">
                            <table class="header-inner-table" cellpadding="0" cellspacing="0" border="0">
                                <tr>
                                    <td class="header-photo-cell">
                                        <div class="photo-container">
                                            @if($cvProfile && $cvProfile->photo)
                                                <img src="{{ asset('cv/' . $cvProfile->photo) }}" alt="Photo de profil">
                                            @endif
                                        </div>
                                    </td>
                        </td>
                        <!-- Cellule Contenu -->
                                    <td class="header-content-cell">
                                        <div class="header-content">
                            @if($cvProfile && $cvProfile->username)
                                <h1>{{ $cvProfile->username }} </h1>
                            @endif
                            @if($cvProfile && $cvProfile->title)
                                <h2>{{ $cvProfile->title }}</h2>
                            @endif
                                            <div class="contact-info">
                                @if($cvProfile && $cvProfile->phone)
                                    <div class="contact-item"><i class="fas fa-phone"></i> {{ $cvProfile->phone }}</div>
                                @endif
                                @if($cvProfile && $cvProfile->email)
                                    <div class="contact-item"><i class="fas fa-envelope"></i> <a href="mailto:{{ $cvProfile->email }}" style="color: white">{{ $cvProfile->email }}</a></div>
                                @endif
                                @if($cvProfile && $cvProfile->city)
                                    <div class="contact-item"><i class="fas fa-map-marker-alt"></i> {{ $cvProfile->city }}</div>
                                @endif
                                @if($cvProfile && $cvProfile->url_linkedin)
                                    <div class="contact-item"><i class="fab fa-linkedin"></i> <a href="{{ $cvProfile->url_linkedin }} " target="_blank" style="color: white">{{ Str::limit(str_replace(['https://', 'http://', 'www.', 'linkedin.com/in/'], '', rtrim($cvProfile->url_linkedin,'/')), 30) }}</a></div>
                                @endif
                                @if($cvProfile && $cvProfile->url_portfolio)
                                    <div class="contact-item"><i class="fas fa-link"></i> <a href="{{ $cvProfile->url_portfolio }}" target="_blank" style="color: white">{{ Str::limit(str_replace(['https://', 'http://', 'www.'], '', rtrim($cvProfile->url_portfolio,'/')), 30) }}</a></div>
                                @endif
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

        <!-- Ligne principale de contenu -->
                    <tr class="content-row">
            <!-- CELLULE GAUCHE -->
                        <td class="left-column-cell">
                @if($cvProfile && $cvProfile->resume)
                            <div class="section profile-section">
                                <h3 class="section-title">PROFIL</h3>
                    <p class="profile-text">{!! nl2br(e($cvProfile->resume)) !!}</p>
                            </div>
                @endif

                @if($cvProfile && $cvProfile->experiences->isNotEmpty())
                            <div class="section experiences-section">
                                <h3 class="section-title">EXPÉRIENCE PROFESSIONNELLE</h3>
                    @foreach($cvProfile->experiences as $exp)
                    <div class="experience-item section-item" id="experience-{{ $exp->id }}">
                        <div class="section-view">
                            <div class="job-title">{{ $exp->poste }}</div>
                            <div class="company">{{ $exp->entreprise }} {{ $exp->ville ? '| '.$exp->ville : '' }}</div>
                            <div class="period"><i class="fas fa-calendar-alt"></i> {{ $exp->date_debut}} / {{ $exp->date_fin}}</div>
                            @if($exp->description)<p class="job-description">{!! nl2br(e($exp->description)) !!}</p>@endif
                            @php $taches = collect([$exp->tache_1, $exp->tache_2, $exp->tache_3])->filter()->all(); @endphp
                            @if(!empty($taches))
                                <h4 class="achievements-title">Réalisations / Tâches :</h4>
                                <ul class="achievements">
                                    @foreach($taches as $tache)<li>{{ e(trim($tache)) }}</li>@endforeach
                                </ul>
                            @endif
                            <div class="section-actions">
                                <button type="button" class="edit-btn btn btn-sm btn-outline-primary" data-id="{{ $exp->id }}" data-section="experience">Modifier</button>
                                <form action="{{ route('cv.experiences.destroy', $exp->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="delete-btn btn btn-sm btn-outline-danger" onclick="return confirm('Supprimer cette expérience ?')">Supprimer</button>
                                </form>
                            </div>
                        </div>
                        <div class="section-edit" style="display:none;">
                            <form action="{{ route('cv-experiences.update', $exp->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="mb-2">
                                    <label>Poste</label>
                                    <input type="text" name="poste" class="form-control" value="{{ $exp->poste }}">
                                </div>
                                <div class="mb-2">
                                    <label>Entreprise</label>
                                    <input type="text" name="entreprise" class="form-control" value="{{ $exp->entreprise }}">
                                </div>
                                <div class="mb-2">
                                    <label>Ville</label>
                                    <input type="text" name="ville" class="form-control" value="{{ $exp->ville }}">
                                </div>
                                <div class="mb-2">
                                    <label>Date début</label>
                                    <input type="text" name="date_debut" class="form-control" value="{{ $exp->date_debut }}">
                                </div>
                                <div class="mb-2">
                                    <label>Date fin</label>
                                    <input type="text" name="date_fin" class="form-control" value="{{ $exp->date_fin }}">
                                </div>
                                <div class="mb-2">
                                    <label>Description</label>
                                    <textarea name="description" class="form-control">{{ $exp->description }}</textarea>
                                </div>
                                {{-- <div class="mb-2">
                                    <label>Tâche 1</label>
                                    <input type="text" name="tache_1" class="form-control" value="{{ $exp->tache_1 }}">
                                </div>
                                <div class="mb-2">
                                    <label>Tâche 2</label>
                                    <input type="text" name="tache_2" class="form-control" value="{{ $exp->tache_2 }}">
                                </div>
                                <div class="mb-2">
                                    <label>Tâche 3</label>
                                    <input type="text" name="tache_3" class="form-control" value="{{ $exp->tache_3 }}">
                                </div> --}}
                                <button type="submit" class="btn btn-success btn-sm">Enregistrer</button>
                                <button type="button" class="btn btn-secondary btn-sm cancel-edit-btn" data-id="{{ $exp->id }}" data-section="experience">Annuler</button>
                            </form>
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif

                
                @if($cvProfile && $cvProfile->formations->isNotEmpty())
                            <div class="section education-section">
                                <h3 class="section-title">FORMATION</h3>
                     @foreach($cvProfile->formations as $form)
                     <div class="education-item section-item" id="formation-{{ $form->id }}">
                         <div class="section-view">
                             <div class="degree">{{ $form->diplome }}</div>
                             <div class="school">{{ $form->etablissement }} {{ $form->ville ? '| '.$form->ville : '' }}</div>
                             <div class="period"><i class="fas fa-calendar-alt"></i> {{ $form->annee_debut }} {{ $form->annee_fin ? '- '.$form->annee_fin : ($form->annee_debut ? '- En cours' : '') }}</div>
                             @if($form->description)<p class="item-description">{!! nl2br(e($form->description)) !!}</p>@endif
                                <div class="section-actions">
                                    <button type="button" class="edit-btn btn btn-sm btn-outline-primary" data-id="{{ $form->id }}" data-section="formation">Modifier</button>
                                    <form action="{{ route('cv.formations.destroy', $form->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="delete-btn btn btn-sm btn-outline-danger" onclick="return confirm('Supprimer cette formation ?')">Supprimer</button>
                                    </form>
                                </div>
                            </div>
                            <div class="section-edit" style="display:none;">
                                <form action="{{ route('cv-formations.update', $form->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="mb-2">
                                        <label>Diplôme</label>
                                        <input type="text" name="diplome" class="form-control" value="{{ $form->diplome }}">
                                    </div>
                                    <div class="mb-2">
                                        <label>Établissement</label>
                                        <input type="text" name="etablissement" class="form-control" value="{{ $form->etablissement }}">
                                    </div>
                                    <div class="mb-2">
                                        <label>Ville</label>
                                        <input type="text" name="ville" class="form-control" value="{{ $form->ville }}">
                                    </div>
                                    <div class="mb-2">
                                        <label>Année début</label>
                                        <input type="text" name="annee_debut" class="form-control" value="{{ $form->annee_debut }}">
                                    </div>
                                    <div class="mb-2">
                                        <label>Année fin</label>
                                        <input type="text" name="annee_fin" class="form-control" value="{{ $form->annee_fin }}">
                                    </div>
                                    <div class="mb-2">
                                        <label>Description</label>
                                        <textarea name="description" class="form-control">{{ $form->description }}</textarea>
                                    </div>
                                    <button type="submit" class="btn btn-success btn-sm">Enregistrer</button>
                                    <button type="button" class="btn btn-secondary btn-sm cancel-edit-btn" data-id="{{ $form->id }}" data-section="formation">Annuler</button>
                                </form>
                            </div>
                        </div>
                     @endforeach
                 </div>
                 @endif

                 @if($cvProfile && $cvProfile->projets->isNotEmpty())
                            <div class="section projects-section">
                                <h3 class="section-title">PROJETS</h3>
                     @foreach($cvProfile->projets as $proj)
                     <div class="project-item section-item" id="projet-{{ $proj->id }}">
                         <div class="section-view">
                             <div class="project-name">{{ $proj->titre }}</div>
                            @if($proj->lien)<div class="project-url"><i class="fas fa-link"></i>&nbsp;<a href="{{ $proj->lien }}" target="_blank">{{ Str::limit(str_replace(['https://', 'http://'], '', $proj->lien), 40) }}</a></div>@endif
                             @if($proj->description)<p class="project-description">{!! nl2br(e($proj->description)) !!}</p>@endif
                             @if($proj->technologies)<p class="technologies">Technologies: {{ $proj->technologies }}</p>@endif
                                <div class="section-actions">
                                    <button type="button" class="edit-btn btn btn-sm btn-outline-primary" data-id="{{ $proj->id }}" data-section="projet">Modifier</button>
                                    <form action="{{ route('cv.projets.destroy', $proj->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="delete-btn btn btn-sm btn-outline-danger" onclick="return confirm('Supprimer ce projet ?')">Supprimer</button>
                                    </form>
                                </div>
                            </div>
                            <div class="section-edit" style="display:none;">
                                <form action="{{ route('cv-projets.update', $proj->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="mb-2">
                                        <label>Titre</label>
                                        <input type="text" name="titre" class="form-control" value="{{ $proj->titre }}">
                                    </div>
                                    <div class="mb-2">
                                        <label>Lien</label>
                                        <input type="text" name="lien" class="form-control" value="{{ $proj->lien }}">
                                    </div>
                                    <div class="mb-2">
                                        <label>Description</label>
                                        <textarea name="description" class="form-control">{{ $proj->description }}</textarea>
                                    </div>
                                    <div class="mb-2">
                                        <label>Technologies</label>
                                        <input type="text" name="technologies" class="form-control" value="{{ $proj->technologies }}">
                                    </div>
                                    <button type="submit" class="btn btn-success btn-sm">Enregistrer</button>
                                    <button type="button" class="btn btn-secondary btn-sm cancel-edit-btn" data-id="{{ $proj->id }}" data-section="projet">Annuler</button>
                                </form>
                            </div>
                        </div>
                     @endforeach
                                </div>
                 @endif
                        </td>

            <!-- CELLULE DROITE -->
                        <td class="right-column-cell">
                <!-- Section Informations Personnelles -->
                            <div class="section personal-info-section">
                                <h3 class="section-title">INFORMATIONS</h3>
                                <div class="info-item">
                                    <span class="info-label">Naissance:</span>
    <span class="info-value">
        {{ $cvProfile && $cvProfile->birthday ? \Carbon\Carbon::parse($cvProfile->birthday)->translatedFormat('d F Y') : 'N/A' }}
        {{ $cvProfile && $cvProfile->lieu_naissance ? ' à ' . e($cvProfile->lieu_naissance) : '' }}
    </span>
                                </div>

                     @if($cvProfile && $cvProfile->nationality)
                                <div class="info-item">
                                    <span class="info-label">Nationalité:</span>
                         <span class="info-value">{{ e($cvProfile->nationality) }}</span>
                                </div>
                     @endif
                     @if($cvProfile && $cvProfile->situation_mat)
                                <div class="info-item">
                                    <span class="info-label">Situation:</span>
                         <span class="info-value">{{ e($cvProfile->situation_mat) }}</span>
                                </div>
                 @endif
                            </div>



                 @if($cvProfile && $cvProfile->competences->isNotEmpty())
                            <div class="section skills-section">
                                <h3 class="section-title">COMPÉTENCES</h3>
                                  @foreach($cvProfile->competences->groupBy('categorie') as $categorie => $competences)
                                <div class="skill-category">
                        <div class="skill-title">{{ $categorie }}</div>               
@foreach($competences as $comp)
                                <div class="skill-item section-item" id="competence-{{ $comp->id }}">
                                    <div class="section-view">
                                        <div class="skill-percent">
                                            
                                 <span class="skill-name">{{ $comp->competence }}</span>
                                 @if($comp->niveau)<span class="skill-level-text">{{ $comp->niveau }}%</span>@endif
                                        </div>
                             @if($comp->niveau)
                                <div class="skill-bar"><div class="skill-fill" style="width: {{ $comp->niveau }}%;"></div></div>
                             @endif
                                        <div class="section-actions">
                                            <button type="button" class="edit-btn btn btn-sm btn-outline-primary" data-id="{{ $comp->id }}" data-section="competence">Modifier</button>
                                            <form action="{{ route('cv.competences.destroy', $comp->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="delete-btn btn btn-sm btn-outline-danger" onclick="return confirm('Supprimer cette compétence ?')">Supprimer</button>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="section-edit" style="display:none;">
                                        <form action="{{ route('cv-competences.update', $comp->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="mb-2">
                                                <label>Compétence</label>
                                                <input type="text" name="competence" class="form-control" value="{{ $comp->competence }}">
                                            </div>
                                            <div class="mb-2">
                                                <label>Niveau (%)</label>
                                                <input type="number" name="niveau" class="form-control" value="{{ $comp->niveau }}">
                                            </div>
                                            <div class="mb-2">
                                                <label>Catégorie</label>
                                                <input type="text" name="categorie" class="form-control" value="{{ $comp->categorie }}">
                                            </div>
                                            
                                            
                                            <button type="submit" class="btn btn-success btn-sm">Enregistrer</button>
                                            <button type="button" class="btn btn-secondary btn-sm cancel-edit-btn" data-id="{{ $comp->id }}" data-section="competence">Annuler</button>
                                        </form>
                                    </div>
                                     @endforeach   
                                </div>
                     @endforeach
                                    </div>
                                    
                @endif

              

                @if($cvProfile && $cvProfile->certifications->isNotEmpty())
                 <div class="section certifications-section">
                     <h3 class="section-title">CERTIFICATIONS</h3>
                     @foreach($cvProfile->certifications as $cert)
                     <div class="certification-item section-item" id="certification-{{ $cert->id }}">
                         <div class="section-view">
                             <div class="certification-name">{{ $cert->certification }}</div>
                             <div class="organization">{{ $cert->organisme }} {{ $cert->date_obtention ? '| '.$cert->date_obtention : '' }}</div>
                              @if($cert->url_validation)<div class="period" style="margin-bottom: 0;"><i class="fas fa-link"></i> <a href="{{ $cert->url_validation }}" target="_blank" style="font-size:8.5pt; color: #555;">Validation</a></div>@endif
                                <div class="section-actions">
                                    <button type="button" class="edit-btn btn btn-sm btn-outline-primary" data-id="{{ $cert->id }}" data-section="certification">Modifier</button>
                                    <form action="{{ route('cv.certifications.destroy', $cert->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="delete-btn btn btn-sm btn-outline-danger" onclick="return confirm('Supprimer cette certification ?')">Supprimer</button>
                                    </form>
                                </div>
                            </div>
                            <div class="section-edit" style="display:none;">
    
    <form action="{{ route('cv-certifications.update', $cert->id) }}" method="POST">
                            
    @csrf

    @method('PUT')
                                    <div class="mb-2">
                                        <label>Certification</label>
                                        <input type="text" name="certification" class="form-control" value="{{ $cert->certification }}">
                                    </div>
                                    <div class="mb-2">
                                        <label>Organisme</label>
                                        <input type="text" name="organisme" class="form-control" value="{{ $cert->organisme }}">
                                    </div>
                                    <div class="mb-2">
                                        <label>Date d'obtention</label>
                                        <input type="text" name="date_obtention" class="form-control" value="{{ $cert->date_obtention }}">
                                    </div>
                                    <div class="mb-2">
                                        <label>URL de validation</label>
                                        <input type="text" name="url_validation" class="form-control" value="{{ $cert->url_validation }}">
                                    </div>
                                    <button type="submit" class="btn btn-success btn-sm">Enregistrer</button>
                                    <button type="button" class="btn btn-secondary btn-sm cancel-edit-btn" data-id="{{ $cert->id }}" data-section="certification">Annuler</button>
                                </form>
                            </div>
                        </div>
                     @endforeach
                            </div>
                 @endif

                    @if($cvProfile && $cvProfile->langues->isNotEmpty())
                            <div class="section languages-section">
                    <h3 class="section-title">LANGUES</h3>
                    @foreach($cvProfile->langues as $lang)
                    <div class="language-item section-item" id="langue-{{ $lang->id }}">
                        <div class="section-view">
                            <div class="language-name">{{ $lang->langue }} | {{ $lang->niveau }}</div>
                             @if(isset($lang->niveauPoints) && $lang->niveauPoints > 0)
                             @php $points = $lang->niveauPoints; @endphp
                             <div class="language-level-dots">@for($i = 1; $i <= 5; $i++)<div class="level-dot {{ $i <= $points ? 'active' : '' }}"></div>@endfor</div>
                             @endif
                                <div class="section-actions">
                                    <button type="button" class="edit-btn btn btn-sm btn-outline-primary" data-id="{{ $lang->id }}" data-section="langue">Modifier</button>
                                    <form action="{{ route('cv.langues.destroy', $lang->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="delete-btn btn btn-sm btn-outline-danger" onclick="return confirm('Supprimer cette langue ?')">Supprimer</button>
                                    </form>
                                </div>
                            </div>
                            <div class="section-edit" style="display:none;">
   <form action="{{ route('cv-langues.update', $lang->id) }}" method="POST">
@csrf
    @method('PUT')
                                    <div class="mb-2">
                                        <label>Langue</label>
                                        <input type="text" name="langue" class="form-control" value="{{ $lang->langue }}">
                                    </div>
                                    <div class="mb-2">
                                        <label>Niveau</label>
                                        <input type="text" name="niveau" class="form-control" value="{{ $lang->niveau }}">
                                    </div>
                                    <button type="submit" class="btn btn-success btn-sm">Enregistrer</button>
                                    <button type="button" class="btn btn-secondary btn-sm cancel-edit-btn" data-id="{{ $lang->id }}" data-section="langue">Annuler</button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                                    </div>
                @endif




                 @if($cvProfile && $cvProfile->loisirs->isNotEmpty())
                            <div class="section interests-section">
                                <h3 class="section-title">CENTRES D'INTÉRÊT</h3>
                    @foreach($cvProfile->loisirs as $interet)
                        <div class="interest-item section-item" id="loisir-{{ $interet->id }}">
                            <div class="section-view">
                                <span>{{ $interet->loisir }}</span>
                                <div class="section-actions">
                                    <button type="button" class="edit-btn btn btn-sm btn-outline-primary" data-id="{{ $interet->id }}" data-section="loisir">Modifier</button>
                                    <form action="{{ route('cv.loisirs.destroy', $interet->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="delete-btn btn btn-sm btn-outline-danger" onclick="return confirm('Supprimer ce loisir ?')">Supprimer</button>
                                    </form>
                                </div>
                            </div>
                            
                            <div class="section-edit" style="display:none;">
                                <form action="{{ route('cv-loisirs.update', $interet->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="mb-2">
                                        <input type="text" name="loisir" class="form-control" value="{{ $interet->loisir }}">
                                    </div>
                                    <button type="submit" class="btn btn-success btn-sm">Enregistrer</button>
                                    <button type="button" class="btn btn-secondary btn-sm cancel-edit-btn" data-id="{{ $interet->id }}" data-section="loisir">Annuler</button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                            </div>
                @endif



                @if($cvProfile && $cvProfile->references->isNotEmpty())
                            <div class="section references-section">
                    <h3 class="section-title">RÉFÉRENCES</h3>
                    @foreach($cvProfile->references as $ref)
                    <div class="reference-item section-item" id="reference-{{ $ref->id }}">
                        <div class="section-view">
                            <div class="reference-name">{{ $ref->nom }}</div>
                            @if($ref->relation)<div class="reference-position">{{ $ref->relation }}</div>@endif
                            @if($ref->commentaire)<div class="reference-relation">({{ $ref->commentaire }})</div>@endif
                            <div class="reference-contact">Contact: {{ $ref->telephone }}</div>
                            <div class="section-actions">
                                <button type="button" class="edit-btn btn btn-sm btn-outline-primary" data-id="{{ $ref->id }}" data-section="reference">Modifier</button>
                                <form action="{{ route('cv.references.destroy', $ref->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="delete-btn btn btn-sm btn-outline-danger" onclick="return confirm('Supprimer cette référence ?')">Supprimer</button>
                                </form>
                            </div>
                        </div>
                        <div class="section-edit" style="display:none;">
                            <form action="{{ route('cv-references.update', $ref->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="mb-2">
                                    <label>Nom</label>
                                    <input type="text" name="nom" class="form-control" value="{{ $ref->nom }}">
                                </div>
                                <div class="mb-2">
                                    <label>Relation</label>
                                    <input type="text" name="relation" class="form-control" value="{{ $ref->relation }}">
                                </div>
                                <div class="mb-2">
                                    <label>Commentaire</label>
                                    <input type="text" name="commentaire" class="form-control" value="{{ $ref->commentaire }}">
                                </div>
                                <div class="mb-2">
                                    <label>Téléphone</label>
                                    <input type="text" name="telephone" class="form-control" value="{{ $ref->telephone }}">
                                </div>
                                <button type="submit" class="btn btn-success btn-sm">Enregistrer</button>
                                <button type="button" class="btn btn-secondary btn-sm cancel-edit-btn" data-id="{{ $ref->id }}" data-section="reference">Annuler</button>
                            </form>
                        </div>
                    </div>
                    @endforeach
        </div>
                @endif
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <style>
        /* Styles généraux */
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'DejaVu Sans', Arial, sans-serif; }
        body { background-color: white; color: #333333; line-height: 1.4; font-size: 10pt; }
        h1, h2, h3, h4, h5, h6 { font-weight: 600; color: #2c3e50; }
        p { margin-bottom: 0.6em; }
        a { color: #005a9e; text-decoration: none; }
        ul { list-style-position: inside; padding-left: 5px; }

        /* Conteneur Principal */
        .cv-container {
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
            background-color: white;
            border-collapse: collapse;
        }

        /* En-tête */
        .header-cell {
            background-color: #1a4a8b;
            color: white;
            padding: 15px 20px;
            border-bottom: 4px solid #005a9e;
        }

        .header-inner-table {
            width: 100%;
            border-collapse: collapse;
        }

        .header-photo-cell {
            width: 120px;
            vertical-align: middle;
            padding-right: 20px;
        }

        .header-content-cell {
            vertical-align: middle;
        }

        .photo-container {
            width: 100px;
            height: 100px;
            overflow: hidden;
            border-radius: 50%;
            border: 3px solid white;
            background-color: #e0e0e0;
        }

        .photo-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .header-content h1 {
            font-size: 20pt;
            color: white;
            margin-bottom: 4px;
        }

        .header-content h2 {
            font-size: 12pt;
            color: white;
            opacity: 0.95;
            margin-bottom: 10px;
        }

        .contact-info {
            margin-top: 8px;
        }

        .contact-item {
            margin-right: 12px;
            margin-bottom: 4px;
            display: inline-block;
            font-size: 9pt;
            color: white;
        }

        /* Colonnes */
        .left-column-cell {
            width: 63%;
            padding: 15px;
            padding-right: 12px;
            vertical-align: top;
            border-right: 1px solid #eaeaea;
        }

        .right-column-cell {
            width: 37%;
            padding: 15px;
            padding-left: 12px;
            vertical-align: top;
            background-color: #f8f9fa;
        }

        /* Sections */
        .section {
            margin-bottom: 18px;
        }

        .section-title {
            font-size: 13pt;
            color: #1a4a8b;
            padding-bottom: 6px;
            margin-bottom: 12px;
            border-bottom: 2px solid #0078d4;
        }

        /* Contenu */
        .profile-text {
            font-size: 9.5pt;
            line-height: 1.45;
            color: #444444;
            text-align: justify;
        }

        .experience-item, .education-item, .project-item {
            margin-bottom: 18px;
            position: relative;
            padding-left: 15px;
        }

        .experience-item::before, .education-item::before, .project-item::before {
            content: "•";
            position: absolute;
            left: 0;
            top: 0;
            font-size: 14pt;
            color: #0078d4;
        }

        .job-title, .degree, .project-name {
            font-size: 10.5pt;
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 1px;
        }

        .company, .school, .project-url {
            font-size: 9.5pt;
            color: #005a9e;
            margin-bottom: 1px;
        }

        .period {
            font-size: 8.5pt;
            color: #555555;
            margin-bottom: 5px;
            font-style: italic;
        }

        .job-description, .item-description, .project-description {
            font-size: 9.5pt;
            color: #444444;
            margin-bottom: 6px;
            line-height: 1.4;
        }

        .technologies {
            font-size: 8.5pt;
            color: #0078d4;
            margin-top: 4px;
            font-style: italic;
        }

        /* Compétences */
        .skill-category {
            margin-bottom: 12px;
        }

        .skill-title {
            font-weight: 600;
            margin-bottom: 6px;
            color: #1a4a8b;
            font-size: 10pt;
        }

        .skill-item {
            margin-bottom: 6px;
        }

        .skill-bar {
            height: 6px;
            background-color: #e9ecef;
            border-radius: 3px;
            overflow: hidden;
            margin-top: 2px;
        }

        .skill-fill {
            height: 100%;
            background-color: #0078d4;
            border-radius: 3px;
        }

        .skill-percent {
            display: block;
            margin-bottom: 1px;
        }

        .skill-name {
            font-weight: 500;
            font-size: 9.5pt;
            display: inline-block;
            margin-right: 4px;
        }

        .skill-level-text {
            font-size: 8pt;
            color: #555555;
            display: inline-block;
        }

        /* Langues */
        .language-item {
            margin-bottom: 8px;
        }

        .language-name {
            font-weight: 500;
            font-size: 9.5pt;
            margin-bottom: 1px;
        }

        .language-level-text {
            font-size: 8.5pt;
            color: #555555;
            font-style: italic;
        }

        .language-level-dots {
            margin-top: 2px;
        }

        .level-dot {
            width: 8px;
            height: 8px;
            background-color: #e0e0e0;
            border-radius: 50%;
            margin-right: 3px;
            display: inline-block;
        }

        .level-dot.active {
            background-color: #0078d4;
        }

        /* Centres d'intérêt */
        .interests {
            line-height: 1.6;
        }

        .interest-item {
            display: inline;
            font-size: 9pt;
            color: #005a9e;
            padding: 0 4px;
            border-right: 1px solid #cccccc;
            margin-right: 4px;
        }

        .interest-item:last-child {
            border-right: none;
            margin-right: 0;
        }

        /* Informations personnelles */
        .info-item {
            margin-bottom: 6px;
            font-size: 9.5pt;
        }

        .info-label {
            font-weight: 600;
            color: #1a4a8b;
            display: inline-block;
            width: 75px;
        }

        .info-value {
            color: #444444;
        }

        /* Icônes */
        .contact-item i::before {
            display: inline-block;
            font-style: normal;
            font-variant: normal;
            text-rendering: auto;
            -webkit-font-smoothing: antialiased;
            font-family: 'DejaVu Sans';
            font-weight: normal;
            width: 1.2em;
            text-align: left;
            margin-right: 5px;
            line-height: 1;
        }

        .contact-item i.fa-phone::before { content: '\260E'; }
        .contact-item i.fa-envelope::before { content: '\2709'; }
        .contact-item i.fa-map-marker-alt::before { content: '\1F4CD'; }
        .contact-item i.fab.fa-linkedin::before { content: 'L'; font-weight: bold; font-family: sans-serif; }
        .contact-item i.fa-link::before { content: '\1F517'; }
        .period i.fa-calendar-alt::before { content: '\1F4C5'; }

        /* Styles pour les actions sur les sections */
        .section-item {
            position: relative;
        }

        .section-actions {
            position: absolute;
            top: 10px;
            right: 10px;
            display: none;
            gap: 5px;
            z-index: 10;
        }

        .section-item:hover .section-actions {
            display: flex;
        }

        .section-actions button {
            background: none;
            border: none;
            padding: 5px;
            cursor: pointer;
            font-size: 14px;
            border-radius: 4px;
            transition: all 0.3s ease;
        }

        .section-actions .edit-btn {
            color: #0d6efd;
        }

        .section-actions .delete-btn {
            color: #dc3545;
        }

        .section-actions .edit-btn:hover {
            background-color: rgba(13, 110, 253, 0.1);
            color: #0a58ca;
        }

        .section-actions .delete-btn:hover {
            background-color: rgba(220, 53, 69, 0.1);
            color: #b02a37;
        }

        /* Styles pour les certifications */
        .certifications {
            margin-top: 20px;
        }

        .certification-item {
            margin-bottom: 15px;
            padding: 10px;
            background-color: #f8f9fa;
            border-radius: 5px;
        }

        .certification-name {
            font-weight: bold;
            color: #0d6efd;
        }

        .organization {
            color: #6c757d;
            font-size: 0.9em;
            margin: 5px 0;
        }

        .certification-item .period {
            font-size: 0.9em;
        }

        .certification-item .period a {
            color: #0d6efd;
            text-decoration: none;
        }

        .certification-item .period a:hover {
            text-decoration: underline;
        }

        /* Styles pour les références */
        .references {
            margin-top: 20px;
        }

        .reference-item {
            margin-bottom: 15px;
            padding: 10px;
            background-color: #f8f9fa;
            border-radius: 5px;
        }

        .reference-name {
            font-weight: bold;
            color: #0d6efd;
        }

        .reference-position {
            color: #6c757d;
            font-size: 0.9em;
            margin: 5px 0;
        }

        .reference-company {
            font-style: italic;
            margin-bottom: 5px;
        }

        .reference-contact {
            font-size: 0.9em;
            color: #6c757d;
        }

        .reference-contact i {
            margin-right: 5px;
            color: #0d6efd;
        }
    </style>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

    <script>
        $(document).ready(function() {
    

            // Empêcher la soumission du formulaire avec la touche Entrée
            $('.profile-form input, .profile-form textarea').on('keypress', function(e) {
                if (e.which === 13) {
                    e.preventDefault();
                    return false;
                }
            });

            // Mise à jour de la photo
            $('#photo_cv').on('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        $('.photo-container img').attr('src', e.target.result);
                    }
                    reader.readAsDataURL(file);
                }
            });

            // Inline edit pour chaque section
            $('.cv-preview').on('click', '.edit-btn', function() {
                var id = $(this).data('id');
                var section = $(this).data('section');
                $('#'+section+'-'+id+' .section-view').hide();
                $('#'+section+'-'+id+' .section-edit').show();
            });
            $('.cv-preview').on('click', '.cancel-edit-btn', function() {
                var id = $(this).data('id');
                var section = $(this).data('section');
                $('#'+section+'-'+id+' .section-edit').hide();
                $('#'+section+'-'+id+' .section-view').show();
            });
        });
    </script>
@endsection