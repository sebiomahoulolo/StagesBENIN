@extends('layouts.admin.app')

@section('title', 'StagesBENIN')

@push('styles')
{{-- Font Awesome est supposé être chargé dans layouts.admin.app --}}
<style>
    body {
        background-color: #f7f8fc; /* Fond très clair, légèrement bleuté/gris */
        color: #333d49; /* Couleur de texte principale légèrement désaturée */
    }
    /* Bannière du profil */
    .profile-banner {
        /* background: linear-gradient(135deg, var(--bs-primary, #0d6efd) 0%, var(--bs-info, #0dcaf0) 100%); */
        background-color: #fff; /* Fond blanc pour la bannière */
        color: #333d49; /* Texte sombre pour contraste */
        padding: 2rem 1.5rem;
        border-radius: 0.75rem; /* Coins plus arrondis */
        margin-bottom: 2rem;
        display: flex;
        align-items: center;
        border: 1px solid #e5eaf2; /* Bordure très subtile */
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.03);
    }
    .profile-banner-avatar {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        margin-right: 1.5rem;
        object-fit: cover;
        border: 3px solid #e5eaf2;
    }
    .profile-banner h3 {
        margin-bottom: 0.25rem;
        font-weight: 600;
        color: #1a202c; /* Titre plus sombre */
    }
    .profile-banner p {
        margin-bottom: 0;
        color: #718096; /* Texte secondaire plus gris */
    }

    /* Cartes de section */
    .section-card {
        background-color: #fff;
        border-radius: 0.75rem;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.04);
        margin-bottom: 1.75rem;
        border: 1px solid #e5eaf2;
        overflow: hidden;
    }
    .section-card .card-header {
        background-color: #fdfdff; /* Fond header très légèrement différent */
        border-bottom: 1px solid #e5eaf2;
        padding: 0.8rem 1.25rem;
        font-weight: 600;
        color: #4a5568; /* Couleur titre header */
        font-size: 1rem;
        display: flex;
        align-items: center;
    }
    .section-card .card-header i {
        margin-right: 0.6rem;
        color: var(--bs-primary, #4e88ff);
        font-size: 1.1em;
    }
    .section-card .card-body {
        padding: 1.25rem;
    }

    /* Liste d'informations dl/dt/dd */
    .info-list dt {
        font-weight: 500;
        color: #718096; /* Gris moyen */
        width: 140px;
        float: left;
        clear: left;
        margin-bottom: 0.8rem;
        padding-right: 10px;
        font-size: 0.88em;
        display: flex;
        align-items: center;
    }
     .info-list dt i {
        width: 16px;
        text-align: center;
        margin-right: 8px;
        color: #a0aec0; /* Icones grises claires */
    }
    .info-list dd {
        margin-left: 150px;
        margin-bottom: 0.8rem;
        color: #2d3748; /* Texte un peu plus foncé */
        font-size: 0.88em;
    }
    .info-list dd a {
        color: var(--bs-primary, #4e88ff);
        text-decoration: none;
        font-weight: 500;
    }
     .info-list dd a:hover { text-decoration: underline; }
    .info-list::after { content: ""; display: table; clear: both; }

    /* Liste d'items (Formation, Expérience) */
    .item-list .list-group-item {
        border: none;
        padding: 1.25rem 0;
        margin: 0 1.25rem; /* Marge interne au lieu de padding body */
        border-bottom: 1px solid #f1f5f9;
        display: flex;
        align-items: flex-start;
        background: transparent;
    }
    .item-list .list-group-item:last-child { border-bottom: none; }
    .item-list .item-icon {
        background-color: #edf2f7;
        color: var(--bs-primary, #4e88ff);
        border-radius: 0.5rem; /* Moins rond */
        width: 38px;
        height: 38px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin-right: 1rem;
        flex-shrink: 0;
    }
    .item-list .item-content { flex-grow: 1; }
    .item-list .item-title {
        font-weight: 600;
        color: #2d3748;
        margin-bottom: 0.15rem;
        font-size: 0.95rem;
    }
    .item-list .item-subtitle {
        font-size: 0.85em;
        color: #718096;
        margin-bottom: 0.3rem;
    }
    .item-list .item-period {
        font-size: 0.8em;
        color: #a0aec0;
        margin-bottom: 0.6rem;
        display: block;
    }
     .item-list .item-period i { margin-right: 5px; }
    .item-list .item-description {
        font-size: 0.88em;
        color: #4a5568;
        white-space: pre-wrap;
        margin-top: 0.6rem;
        line-height: 1.65;
    }
    .item-list .item-tasks {
        font-size: 0.85em;
        margin-top: 0.7rem;
        padding-left: 1.25rem;
        list-style-type: disc;
        color: #4a5568;
    }

    /* Compétences avec barre de progression */
    .skill-category {
        margin-bottom: 1.5rem;
    }
    .skill-category:last-child { margin-bottom: 0; }
    .skill-category-title {
        font-weight: 600;
        color: #4a5568;
        margin-bottom: 1rem;
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.7px;
    }
    .skill-item {
        margin-bottom: 0.8rem;
    }
    .skill-item .skill-info {
        display: flex;
        justify-content: space-between;
        margin-bottom: 0.3rem;
        font-size: 0.9em;
    }
    .skill-name { color: #333d49; font-weight: 500; }
    .skill-level { color: #718096; }
    .progress {
        height: 6px;
        background-color: #e2e8f0;
        border-radius: 3px;
        overflow: hidden;
    }
    .progress-bar {
        background-color: var(--bs-info, #0dcaf0); /* Couleur plus douce pour la barre */
        border-radius: 3px;
    }

    /* Badges (Langues, Intérêts) */
    .badge-list .badge {
        margin-right: 0.5rem;
        margin-bottom: 0.5rem;
        padding: 0.45em 0.8em;
        font-size: 0.85em;
        font-weight: 500;
        background-color: #edf2f7 !important;
        color: #4a5568 !important;
        border: 1px solid #e2e8f0;
        border-radius: 0.375rem;
    }
     .badge-list .badge i { margin-right: 4px; }

</style>
@endpush

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-4 border-bottom">
        <h1 class="h2" style="color: #2d3748;">Profil Étudiant</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            @if(Route::has('admin.dashboard'))
                <a href="{{ route('admin.dashboard') }}" class="btn btn-sm btn-outline-secondary d-flex align-items-center">
                    <i class="fas fa-arrow-left me-1"></i> Retour
                </a>
            @endif
        </div>
    </div>

    {{-- Messages Flash --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">{{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">{{ session('error') }}<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>
    @endif
    @if(session('warning'))
        <div class="alert alert-warning alert-dismissible fade show" role="alert">{{ session('warning') }}<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>
    @endif
    @if(session('info'))
        <div class="alert alert-info alert-dismissible fade show" role="alert">{{ session('info') }}<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>
    @endif
    {{-- Fin Messages Flash --}}

    {{-- Bannière du Profil --}}
    <div class="profile-banner">
        <img src="{{ Storage::url($cvProfile->photo_cv_path) }}" alt="Avatar" class="profile-banner-avatar">
        <div>
            <h3>{{ $etudiant->nom_complet ?? 'Étudiant Inconnu' }}</h3>
            <p>{{ $cvProfile->titre_profil ?? ($etudiant->filiere ? ($etudiant->filiere->nom ?? $etudiant->filiere) . ' - ' . ($etudiant->niveau->nom ?? $etudiant->niveau) : 'Profil non complété') }}</p>
        </div>
    </div>

    <div class="row">
        {{-- Colonne Gauche (Contenu Principal CV) --}}
        <div class="col-lg-7">
             {{-- Résumé --}}
             @if ($cvProfile && $cvProfile->resume_profil)
                 <div class="section-card">
                     <h5 class="card-header"><i class="fas fa-user-tie"></i>Résumé du Profil</h5>
                     <div class="card-body">
                         <p style="line-height: 1.7; color: #4a5568;">{!! nl2br(e($cvProfile->resume_profil)) !!}</p>
                     </div>
                 </div>
             @endif

             {{-- Expériences --}}
             @if ($cvProfile && $cvProfile->experiences->isNotEmpty())
             <div class="section-card">
                 <h5 class="card-header"><i class="fas fa-briefcase"></i>Expériences Professionnelles</h5>
                 <div class="card-body p-0">
                     <ul class="list-group list-group-flush item-list">
                         @foreach ($cvProfile->experiences as $experience)
                             <li class="list-group-item">
                                 <!-- <span class="item-icon"><i class="fas fa-building"></i></span> -->
                                 <div class="item-content">
                                     <span class="item-title">{{ $experience->poste }}</span>
                                     <span class="item-subtitle">{{ $experience->entreprise }} {{ $experience->ville ? ' | ' . $experience->ville : '' }}</span>
                                     <span class="item-period"><i class="far fa-calendar-alt"></i> {{ $experience->periode }}</span>
                                     @if($experience->description)<p class="item-description">{!! nl2br(e($experience->description)) !!}</p>@endif
                                     @php $taches = collect([$experience->tache_1, $experience->tache_2, $experience->tache_3])->filter(); @endphp
                                     @if($taches->isNotEmpty())
                                         <ul class="item-tasks">
                                             @foreach($taches as $tache) <li>{{ e($tache) }}</li> @endforeach
                                         </ul>
                                     @endif
                                 </div>
                             </li>
                         @endforeach
                     </ul>
                 </div>
             </div>
             @endif

              {{-- Formations --}}
              @if ($cvProfile && $cvProfile->formations->isNotEmpty())
              <div class="section-card">
                  <h5 class="card-header"><i class="fas fa-graduation-cap"></i>Formations</h5>
                  <div class="card-body p-0">
                      <ul class="list-group list-group-flush item-list">
                          @foreach ($cvProfile->formations as $formation)
                              <li class="list-group-item">
                                   <!-- <span class="item-icon"><i class="fas fa-school"></i></span> -->
                                  <div class="item-content">
                                      <span class="item-title">{{ $formation->diplome }}</span>
                                      <span class="item-subtitle">{{ $formation->etablissement }} {{ $formation->ville ? ' | ' . $formation->ville : '' }}</span>
                                      <span class="item-period"><i class="far fa-calendar-alt"></i> {{ $formation->annee_debut }} - {{ $formation->annee_fin ?? 'En cours' }}</span>
                                      @if($formation->description)<p class="item-description">{!! nl2br(e($formation->description)) !!}</p>@endif
                                  </div>
                              </li>
                          @endforeach
                      </ul>
                  </div>
              </div>
              @endif

             {{-- Projets --}}
             @if ($cvProfile && $cvProfile->projets->isNotEmpty())
             <div class="section-card">
                 <h5 class="card-header"><i class="fas fa-project-diagram"></i>Projets Personnels</h5>
                  <div class="card-body p-0">
                      <ul class="list-group list-group-flush item-list">
                         @foreach ($cvProfile->projets as $projet)
                             <li class="list-group-item">
                                 <!-- <span class="item-icon"><i class="fas fa-lightbulb"></i></span> -->
                                 <div class="item-content">
                                     <span class="item-title">{{ $projet->nom }}</span>
                                     @if($projet->url_projet)
                                         <a href="{{ $projet->url_projet }}" target="_blank" rel="noopener noreferrer" class="item-subtitle d-block mb-1">
                                             <i class="fas fa-external-link-alt me-1"></i>{{ Str::limit($projet->url_projet, 50) }}
                                         </a>
                                     @endif
                                     @if($projet->description)<p class="item-description">{!! strip_tags($projet->description) !!}</p>@endif
                                     @if($projet->technologies)<p class="item-period mt-2 mb-0 text-muted"><i class="fas fa-cogs me-1"></i>Tech: {{ $projet->technologies }}</p>@endif
                                 </div>
                             </li>
                         @endforeach
                     </ul>
                  </div>
             </div>
             @endif

             {{-- Si aucune section CV n'est remplie --}}
             @if (!$cvProfile || ($cvProfile->experiences->isEmpty() && $cvProfile->formations->isEmpty() && $cvProfile->projets->isEmpty()))
                 <div class="alert alert-light text-center border">Aucune information de profil CV (Expériences, Formations, Projets) n'a été ajoutée.</div>
             @endif

         </div>

         {{-- Colonne Droite (Infos Annexes) --}}
         <div class="col-lg-5">
             {{-- Informations Personnelles & Contact --}}
             <div class="section-card">
                 <h5 class="card-header"><i class="fas fa-user"></i>Informations & Contact</h5>
                 <div class="card-body">
                     <dl class="info-list">
                         {{-- Infos de l'étudiant --}}
                         <dt><i class="fas fa-id-badge"></i> Matricule</dt><dd>{{ $etudiant->matricule ?? 'N/A' }}</dd>
                         <dt><i class="fas fa-birthday-cake"></i> Naissance</dt><dd>{{ $etudiant->date_naissance ? $etudiant->date_naissance->format('d/m/Y') : 'N/A' }} {{ $etudiant->lieu_naissance ? ' à ' . $etudiant->lieu_naissance : '' }}</dd>
                         <dt><i class="fas fa-envelope"></i> Email</dt><dd><a href="mailto:{{ $etudiant->email }}">{{ $etudiant->email ?? 'N/A' }}</a></dd>
                         <dt><i class="fas fa-phone"></i> Téléphone</dt><dd>{{ $etudiant->telephone ?? 'N/A' }}</dd>
                         <dt><i class="fas fa-map-marker-alt"></i> Adresse</dt><dd>{{ $etudiant->adresse ?? 'N/A' }}</dd>
                         <dt><i class="fas fa-university"></i> Filière</dt><dd>{{ $etudiant->filiere->nom ?? $etudiant->filiere ?? 'N/A' }}</dd>
                         <dt><i class="fas fa-layer-group"></i> Niveau</dt><dd>{{ $etudiant->niveau->nom ?? $etudiant->niveau ?? 'N/A' }}</dd>

                         @if($cvProfile)
                             <hr class="my-3" style="border-color: #e2e8f0;">
                             <dt><i class="fas fa-flag"></i> Nationalité</dt><dd>{{ $cvProfile->nationalite ?? 'N/A' }}</dd>
                             <dt><i class="fas fa-ring"></i> Situation</dt><dd>{{ $cvProfile->situation_matrimoniale ?? 'N/A' }}</dd>
                              <dt><i class="fas fa-envelope-open-text"></i> Email (CV)</dt><dd><a href="mailto:{{ $cvProfile->contact_email }}">{{ $cvProfile->contact_email ?? 'N/A' }}</a></dd>
                              <dt><i class="fas fa-mobile-alt"></i> Téléphone (CV)</dt><dd>{{ $cvProfile->contact_telephone ?? 'N/A' }}</dd>
                              <dt><i class="fas fa-map-marked-alt"></i> Adresse (CV)</dt><dd>{{ $cvProfile->adresse ?? 'N/A' }}</dd>
                              <dt><i class="fab fa-linkedin"></i> LinkedIn</dt>
                              <dd>@if($cvProfile->linkedin_url)<a href="{{ $cvProfile->linkedin_url }}" target="_blank" rel="noopener noreferrer">Voir Profil</a>@else N/A @endif</dd>
                              <dt><i class="fas fa-link"></i> Portfolio</dt>
                              <dd>@if($cvProfile->portfolio_url)<a href="{{ $cvProfile->portfolio_url }}" target="_blank" rel="noopener noreferrer">Voir Site</a>@else N/A @endif</dd>
                         @endif
                     </dl>
                 </div>
             </div>

              {{-- Compétences --}}
             @if ($cvProfile && $cvProfile->competences->isNotEmpty())
             <div class="section-card">
                 <h5 class="card-header"><i class="fas fa-cogs"></i>Compétences</h5>
                 <div class="card-body">
                     @foreach ($cvProfile->competences->groupBy('categorie') as $categorie => $competences)
                         <div class="skill-category">
                             <div class="skill-category-title">{{ $categorie }}</div>
                             @foreach ($competences as $competence)
                                 <div class="skill-item">
                                     <div class="skill-info">
                                         <span class="skill-name">{{ $competence->nom }}</span>
                                         <span class="skill-level">{{ $competence->niveau ?? 0 }}%</span>
                                     </div>
                                     <div class="progress">
                                         <div class="progress-bar" role="progressbar" style="width: {{ $competence->niveau ?? 0 }}%;" aria-valuenow="{{ $competence->niveau ?? 0 }}" aria-valuemin="0" aria-valuemax="100"></div>
                                     </div>
                                 </div>
                             @endforeach
                         </div>
                     @endforeach
                 </div>
             </div>
             @endif

             {{-- Langues --}}
             @if ($cvProfile && $cvProfile->langues->isNotEmpty())
             <div class="section-card">
                 <h5 class="card-header"><i class="fas fa-language"></i>Langues</h5>
                 <div class="card-body badge-list">
                     @foreach ($cvProfile->langues as $langue)
                         <span class="badge"><i class="fas fa-comments"></i> {{ $langue->langue }} ({{ $langue->niveau }})</span>
                     @endforeach
                 </div>
             </div>
             @endif

             {{-- Certifications --}}
             @if ($cvProfile && $cvProfile->certifications->isNotEmpty())
             <div class="section-card">
                 <h5 class="card-header"><i class="fas fa-certificate"></i>Certifications</h5>
                  <div class="card-body p-0">
                      <ul class="list-group list-group-flush item-list">
                         @foreach ($cvProfile->certifications as $certification)
                             <li class="list-group-item">
                                 <span class="item-icon"><i class="fas fa-award"></i></span>
                                 <div class="item-content">
                                     <span class="item-title">{{ $certification->nom }}</span>
                                     <span class="item-subtitle">{{ $certification->organisme }} {{ $certification->annee ? '(' . $certification->annee . ')' : '' }}</span>
                                     @if($certification->url_validation)
                                         <a href="{{ $certification->url_validation }}" target="_blank" rel="noopener noreferrer" class="item-period d-block mt-1" style="color: var(--bs-info, #0dcaf0); font-size: 0.8em;">
                                             <i class="fas fa-link me-1"></i>Voir validation
                                         </a>
                                     @endif
                                 </div>
                             </li>
                         @endforeach
                     </ul>
                  </div>
             </div>
             @endif

             {{-- Centres d'Intérêt --}}
             @if ($cvProfile && $cvProfile->centresInteret->isNotEmpty())
             <div class="section-card">
                 <h5 class="card-header"><i class="fas fa-heart"></i>Centres d'Intérêt</h5>
                 <div class="card-body badge-list">
                     @foreach ($cvProfile->centresInteret as $interet)
                         <span class="badge"><i class="fas fa-tag"></i> {{ $interet->nom }}</span>
                     @endforeach
                 </div>
             </div>
             @endif

             {{-- Références --}}
             @if ($cvProfile && $cvProfile->references->isNotEmpty())
             <div class="section-card">
                 <h5 class="card-header"><i class="fas fa-users"></i>Références</h5>
                 <div class="card-body p-0">
                     <ul class="list-group list-group-flush item-list">
                         @foreach ($cvProfile->references as $reference)
                             <li class="list-group-item">
                                 <span class="item-icon"><i class="fas fa-user-check"></i></span>
                                 <div class="item-content">
                                     <span class="item-title">{{ $reference->nom_complet }}</span>
                                     <span class="item-subtitle">{{ $reference->poste ?? '' }} {{ $reference->relation ? '('. $reference->relation .')' : '' }}</span>
                                     <span class="item-period"><i class="fas fa-phone-alt me-1"></i>Contact: {{ $reference->contact }}</span>
                                 </div>
                             </li>
                         @endforeach
                     </ul>
                 </div>
             </div>
             @endif

         </div>
     </div>
</div>
@endsection

@push('scripts')
    {{-- Scripts spécifiques si besoin --}}
@endpush 