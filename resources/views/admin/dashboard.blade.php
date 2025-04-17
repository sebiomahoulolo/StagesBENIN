@extends('layouts.admin.app')

@section('title', 'Tableau de Bord - Admin') {{-- Optional: Set a specific title --}}

@section('content')
    <h1 class="dashboard-title">Tableau de bord</h1>

    <!-- Stats Section -->
    <div class="stats-container">
        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-title">Étudiants inscrits</div>
                <div class="stat-icon bg-primary"><i class="fas fa-user-graduate"></i></div>
            </div>
            <div class="stat-value">{{ $totalEtudiants ?? 0 }}</div> <!-- Default to 0 if variable not set -->
            <div class="stat-progress up">
                <i class="fas fa-arrow-up"></i> {{ $progression ?? 'N/A' }} <!-- Default if variable not set -->
            </div>
        </div>
         <div class="stat-card">
            <div class="stat-header">
                <div class="stat-title">Entreprises partenaires</div>
                <div class="stat-icon bg-success"><i class="fas fa-building"></i></div>
            </div>
            {{-- Replace with dynamic data from controller --}}
            <div class="stat-value">{{ $totalEntreprises ?? 86 }}</div>
            <div class="stat-progress up">
                <i class="fas fa-arrow-up"></i> 5% {{-- Make dynamic --}}
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-title">Offres actives</div>
                <div class="stat-icon bg-warning"><i class="fas fa-briefcase"></i></div>
            </div>
             {{-- Replace with dynamic data from controller --}}
            <div class="stat-value">{{ $offresActives ?? 124 }}</div>
            <div class="stat-progress down">
                <i class="fas fa-arrow-down"></i> 3% {{-- Make dynamic --}}
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-title">Entretiens programmés</div>
                <div class="stat-icon bg-danger"><i class="fas fa-calendar-check"></i></div>
            </div>
             {{-- Replace with dynamic data from controller --}}
            <div class="stat-value">{{ $entretiensProgrammes ?? 37 }}</div>
            <div class="stat-progress up">
                <i class="fas fa-arrow-up"></i> 8% {{-- Make dynamic --}}
            </div>
        </div>
    </div>

    <!-- Tabs Section -->
    <div class="tabs-container">
        <div class="tabs-header" role="tablist">
            {{-- data-tab values should be unique and match aria-controls/id of content panels --}}
            <button class="tab active" data-tab="etudiants" role="tab" aria-selected="true" aria-controls="etudiants-content">Étudiants</button>
            <button class="tab" data-tab="entreprises" role="tab" aria-selected="false" aria-controls="entreprises-content">Entreprises</button>
            <button class="tab" data-tab="recrutements" role="tab" aria-selected="false" aria-controls="recrutements-content">Recrutements</button>
            <button class="tab" data-tab="actualites" role="tab" aria-selected="false" aria-controls="actualites-content">Actualités</button>
            <button class="tab" data-tab="evenements" role="tab" aria-selected="false" aria-controls="evenements-content">Événements</button>
            <button class="tab" data-tab="catalogue" role="tab" aria-selected="false" aria-controls="catalogue-content">Catalogue</button>
        </div>

        <!-- Tab Content Panels -->
        <div class="tab-content active" id="etudiants-content" role="tabpanel" aria-labelledby="etudiants-tab">
            <div class="action-bar">
                <div class="action-buttons">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#etudiantModal">
                        <i class="fas fa-plus-circle me-1"></i> Ajouter Étudiant
                    </button>
                </div>
                <!-- Add Filters/Search for Students here -->
            </div>
            <div class="content-area table-responsive"> <!-- Make table responsive -->
                {{-- Student Table --}}
                {{-- Ensure $etudiants is passed from the controller --}}
                @if(isset($etudiants) && !$etudiants->isEmpty())
                    <table class="student-table">
                        <thead>
                            <tr>
                                <th>Nom</th>
                                <th>Prénom</th>
                                <th>Téléphone</th>
                                <th>Niveau</th>
                                <th>Formation</th>
                                <th>Profil</th>
                                <th>Actions</th>
                                <th>Décision</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($etudiants as $etudiant)
                            <tr>
                                <td>{{ $etudiant->nom }}</td>
                                <td>{{ $etudiant->prenom }}</td>
                                <td>{{ $etudiant->telephone ?? '-'}}</td>
                                <td>{{ $etudiant->niveau ?? '-'}}</td>
                                <td>{{ $etudiant->formation ?? '-'}}</td>
                                <td>
                                    {{-- Lien vers la nouvelle page de détails --}}
                                    <a href="{{ route('admin.etudiants.show', $etudiant->id) }}" class="btn btn-info btn-sm" data-bs-toggle="tooltip" title="Voir détails">Voir</a>
                                </td>
                               <td>
                                    <div class="d-flex gap-1">
                                        {{-- Ensure routes exist --}}
                                        {{-- CV Download (Needs backend implementation)
                                        <a href="{{ route('etudiants.cv.download', $etudiant->id) }}" class="btn btn-secondary btn-sm" data-bs-toggle="tooltip" title="Télécharger CV"><i class="fas fa-file-download"></i></a>
                                        --}}
                                        <a href="{{ route('etudiants.entretiens', ['etudiant_id' => $etudiant->id]) }}" class="btn btn-primary btn-sm" data-bs-toggle="tooltip" title="Planifier entretien">Entretien</a>
                                        <a href="{{ route('etudiants.envoyer.examen', $etudiant->id) }}" class="btn btn-warning btn-sm" data-bs-toggle="tooltip" title="Envoyer examen">Examen</a>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex gap-1">
                                        {{-- Ensure routes exist --}}
                                        <form action="{{ route('candidatures.accepter', $etudiant->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Confirmer l\'acceptation de cette candidature ?');">
                                            @csrf
                                            <button type="submit" class="btn btn-success btn-sm" data-bs-toggle="tooltip" title="Accepter">Accepter</button>
                                        </form>
                                        <form action="{{ route('candidatures.rejeter', $etudiant->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Confirmer le rejet de cette candidature ?');">
                                            @csrf
                                            <button type="submit" class="btn btn-outline-danger btn-sm" data-bs-toggle="tooltip" title="Rejeter">Rejeter</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                     {{-- Add Pagination if needed: $etudiants->links() --}}
                @else
                    <div class="alert alert-info mt-3">Aucun étudiant trouvé pour le moment.</div>
                @endif
            </div>
        </div>

        <div class="tab-content" id="entreprises-content" role="tabpanel" aria-labelledby="entreprises-tab">
            <div class="action-bar">
                <div class="action-buttons">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#entrepriseModal">
                        <i class="fas fa-plus-circle me-1"></i> Ajouter Entreprise
                    </button>
                </div>
            </div>
             <div class="content-area table-responsive">
                <h4>Liste des Entreprises</h4>
                @if(isset($entreprises) && !$entreprises->isEmpty())
                    <table class="table table-hover table-bordered align-middle">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nom</th>
                                <th>Secteur</th>
                                <th>Email</th>
                                <th>Téléphone</th>
                                <th>Logo</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($entreprises as $entreprise)
                            <tr>
                                <td>{{ $entreprise->id }}</td>
                                <td>{{ $entreprise->nom }}</td>
                                <td>{{ $entreprise->secteur ?? '-' }}</td>
                                <td>{{ $entreprise->email }}</td>
                                <td>{{ $entreprise->telephone ?? '-' }}</td>
                                <td>
                                    @if($entreprise->logo_path && Storage::exists($entreprise->logo_path))
                                        <img src="{{ Storage::url($entreprise->logo_path) }}" alt="Logo {{ $entreprise->nom }}" style="width:40px;height:40px; object-fit:contain;">
                                    @else
                                        <span class="text-muted small">N/A</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex gap-1 flex-wrap">
                                        {{-- Ensure routes exist --}}
                                        <a href="{{ route('entreprises.show', $entreprise->id) }}" class="btn btn-info btn-sm" data-bs-toggle="tooltip" title="Voir"><i class="fas fa-eye"></i></a>
                                        <a href="{{ route('entreprises.contact', $entreprise->id) }}" class="btn btn-primary btn-sm" data-bs-toggle="tooltip" title="Contacter"><i class="fas fa-envelope"></i></a>
                                        <a href="{{ route('entreprises.follow', $entreprise->id) }}" class="btn btn-success btn-sm" data-bs-toggle="tooltip" title="Suivre"><i class="fas fa-star"></i></a> {{-- Assuming 'follow' means something like favorite/track --}}
                                        <a href="{{ route('entreprises.edit', $entreprise->id) }}" class="btn btn-warning btn-sm" data-bs-toggle="tooltip" title="Modifier"><i class="fas fa-edit"></i></a>
                                        <form action="{{ route('entreprises.destroy', $entreprise->id) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette entreprise?');" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" data-bs-toggle="tooltip" title="Supprimer"><i class="fas fa-trash"></i></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $entreprises->links() }} {{-- Render pagination links --}}
                @else
                    <div class="alert alert-info">Aucune entreprise trouvée pour le moment.</div>
                @endif
             </div>
        </div>

        <div class="tab-content" id="recrutements-content" role="tabpanel" aria-labelledby="recrutements-tab">
             <div class="action-bar">
                <div class="action-buttons">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#recrutementModal">
                        <i class="fas fa-plus-circle me-1"></i> Ajouter Recrutement
                    </button>
                </div>
            </div>
             <div class="content-area table-responsive">
                <h4>Liste des Recrutements</h4>
                {{-- Placeholder for Recruitment table - ensure $recrutements is passed from controller --}}
                 @if(isset($recrutements) && !$recrutements->isEmpty())
                     <p>Tableau des recrutements ici.</p>
                     {{-- Populate table similar to others --}}
                 @else
                     <div class="alert alert-info">Aucun recrutement trouvé pour le moment.</div>
                 @endif
             </div>
        </div>

        <div class="tab-content" id="actualites-content" role="tabpanel" aria-labelledby="actualites-tab">
            <div class="action-bar">
               <div class="action-buttons">
                   <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#actualiteModal">
                       <i class="fas fa-plus-circle me-1"></i> Ajouter Actualité
                   </button>
               </div>
           </div>
            <div class="content-area table-responsive">
               <h4>Liste des Actualités</h4>
               {{-- Ensure $actualites is passed from the controller --}}
               @if(isset($actualites) && !$actualites->isEmpty())
                    <table class="table table-hover table-bordered align-middle">
                        <thead>
                            <tr>
                                <th>Titre</th>
                                <th>Catégorie</th>
                                <th>Auteur</th>
                                <th>Date</th>
                                <th>Statut</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($actualites as $actualite)
                            <tr>
                                <td>{{ $actualite->titre }}</td>
                                <td>{{ $actualite->categorie ?? '-' }}</td>
                                <td>{{ $actualite->auteur ?? '-'}}</td>
                                <td>{{ $actualite->date_publication ? \Carbon\Carbon::parse($actualite->date_publication)->isoFormat('DD MMM YYYY') : '-' }}</td>
                                <td>
                                    {{-- Status - Assuming an 'is_published' field --}}
                                    @if($actualite->is_published)
                                        <span class="badge bg-success">Publiée</span>
                                    @else
                                        <span class="badge bg-secondary">Brouillon</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex gap-1">
                                        {{-- Ensure routes exist --}}
                                        {{-- <a href="{{ route('actualites.show', $actualite->id) }}" class="btn btn-info btn-sm" data-bs-toggle="tooltip" title="Voir"><i class="fas fa-eye"></i></a> --}}
                                        <a href="{{ route('actualites.edit', $actualite->id) }}" class="btn btn-warning btn-sm" data-bs-toggle="tooltip" title="Modifier"><i class="fas fa-edit"></i></a>
                                        <form action="{{ route('actualites.destroy', $actualite->id) }}" method="POST" style="display: inline-block;" onsubmit="return confirm('Confirmer la suppression de cette actualité ?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" data-bs-toggle="tooltip" title="Supprimer">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $actualites->links() }} {{-- Render pagination links --}}
                @else
                    <div class="alert alert-info">Aucune actualité trouvée pour le moment.</div>
                @endif
            </div>
        </div>

        <div class="tab-content" id="evenements-content" role="tabpanel" aria-labelledby="evenements-tab">
            <div class="action-bar">
                <div class="action-buttons">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#eventModal">
                        <i class="fas fa-plus-circle me-1"></i> Ajouter Événement
                    </button>
                </div>
            </div>
            <div class="content-area table-responsive">
                <h4>Liste des Événements</h4>
                 {{-- Ensure $events is passed from the controller --}}
                @if(isset($events) && !$events->isEmpty())
                    <table class="table table-hover table-bordered align-middle">
                        <thead>
                            <tr>
                                <th>Titre</th>
                                <th>Début</th>
                                <th>Fin</th>
                                <th>Lieu</th>
                                <th>Type</th>
                                <th>Statut</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($events as $event)
                            <tr>
                                <td>{{ $event->title }}</td>
                                <td>{{ $event->start_date ? \Carbon\Carbon::parse($event->start_date)->isoFormat('DD MMM YYYY HH:mm') : '-' }}</td>
                                <td>{{ $event->end_date ? \Carbon\Carbon::parse($event->end_date)->isoFormat('DD MMM YYYY HH:mm') : '-' }}</td>
                                <td>{{ $event->location ?? '-' }}</td>
                                <td>{{ $event->type ?? '-' }}</td>
                                <td>
                                    {{-- Status Toggle Form - Ensure route exists --}}
                                    <form action="{{ route('evenements.toggleStatus', $event->id) }}" method="POST" style="display: inline-block;">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-sm {{ $event->is_published ? 'btn-success' : 'btn-secondary' }} status" data-bs-toggle="tooltip" title="{{ $event->is_published ? 'Passer en privé' : 'Publier' }}">
                                            {{ $event->is_published ? 'Publié' : 'Privé' }}
                                        </button>
                                    </form>
                                </td>
                                <td>
                                    <div class="d-flex gap-1">
                                         {{-- Ensure routes exist --}}
                                         <a href="{{ route('evenements.show', $event->id) }}" class="btn btn-info btn-sm" data-bs-toggle="tooltip" title="Voir"><i class="fas fa-eye"></i></a>
                                         <a href="{{ route('evenements.edit', $event->id) }}" class="btn btn-warning btn-sm" data-bs-toggle="tooltip" title="Modifier"><i class="fas fa-edit"></i></a>
                                         {{-- Delete Form - Ensure route exists --}}
                                         <form action="{{ route('evenements.destroy', $event->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Confirmer la suppression de cet événement ?')">
                                             @csrf
                                             @method('DELETE')
                                             <button type="submit" class="btn btn-danger btn-sm" data-bs-toggle="tooltip" title="Supprimer"><i class="fas fa-trash"></i></button>
                                         </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $events->links() }} {{-- Render pagination links --}}
                @else
                    <div class="alert alert-info">Aucun événement trouvé pour le moment.</div>
                @endif
            </div>
        </div>

        <div class="tab-content" id="catalogue-content" role="tabpanel" aria-labelledby="catalogue-tab">
             <div class="action-bar">
                <div class="action-buttons">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#catalogueModal">
                        <i class="fas fa-plus-circle me-1"></i> Ajouter au Catalogue
                    </button>
                </div>
            </div>
             <div class="content-area table-responsive">
                <h4>Catalogue de Formations</h4>
                {{-- Placeholder for Catalog table - ensure $catalogueItems is passed from controller --}}
                 @if(isset($catalogueItems) && !$catalogueItems->isEmpty())
                     <p>Contenu du catalogue ici.</p>
                     {{-- Populate table similar to others --}}
                 @else
                     <div class="alert alert-info">Aucun élément trouvé dans le catalogue pour le moment.</div>
                 @endif
             </div>
        </div>
    </div>
@endsection

@push('styles')
{{-- Add page-specific CSS here if needed --}}
{{-- Example: <link rel="stylesheet" href="{{ asset('css/dashboard-specific.css') }}"> --}}
{{-- Note: Student table styles were moved to the main layout CSS for now --}}
@endpush

@push('scripts')
{{-- Add page-specific JS here if needed --}}
{{-- Example: <script src="{{ asset('js/dashboard-charts.js') }}"></script> --}}
{{-- Note: Tab, Modal, and Sidebar JS were moved to the main layout script --}}
@endpush