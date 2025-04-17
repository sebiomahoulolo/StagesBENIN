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

            <!-- Tabs Section -->
            <div class="tabs-container">
                <div class="tabs-header" role="tablist">
                    <button class="tab active" data-tab="etudiants" role="tab" aria-selected="true" aria-controls="etudiants-content">Étudiants</button>
                    <button class="tab" data-tab="entreprises" role="tab" aria-selected="false" aria-controls="entreprises-content">Entreprises</button>
                    <button class="tab" data-tab="recrutements" role="tab" aria-selected="false" aria-controls="recrutements-content">Recrutements</button>
                    <button class="tab" data-tab="actualites" role="tab" aria-selected="false" aria-controls="actualites-content">Actualités</button>
                    <button class="tab" data-tab="evenements" role="tab" aria-selected="false" aria-controls="evenements-content">Événements</button>
                    <button class="tab" data-tab="catalogue" role="tab" aria-selected="false" aria-controls="catalogue-content">Catalogue</button>
                </div>

                <!-- Tab Content Panels -->
                <div class="tab-content active" id="etudiants-content" role="tabpanel">
                    <div class="action-bar">
                        <div class="action-buttons">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#etudiantModal">
                                <i class="fas fa-plus-circle me-1"></i> Ajouter Étudiant
                            </button>
                        </div>
                        <!-- Add Filters/Search for Students here -->
                    </div>
                    <div class="content-area table-responsive"> <!-- Make table responsive -->
                  
                            
<style>
    .student-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
        background-color: #fff;
        box-shadow: 0 0 12px rgba(0, 0, 0, 0.08);
        border-radius: 10px;
        overflow: hidden;
    }

    .student-table th,
    .student-table td {
        padding: 12px 16px;
        text-align: left;
        border-bottom: 1px solid #dee2e6;
    }

    .student-table th {
        background-color: #212529;
        color: #fff;
        font-weight: 600;
    }

    .student-table tr:last-child td {
        border-bottom: none;
    }

    .btn {
        padding: 8px 12px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 14px;
        transition: all 0.3s ease;
    }

    .btn-warning {
        background-color: #ffc107;
        border: none;
        color: #000;
    }

    .btn-warning:hover {
        background-color: #e0a800;
    }

    .btn-danger {
        background-color: #dc3545;
        border: none;
        color: #fff;
    }

    .btn-danger:hover {
        background-color: #c82333;
    }
</style>

<div class="container py-4">
    <h1 class="mb-4">Liste des Étudiants</h1>
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
               
                 <td>{{ $etudiant->telephone}}</td>
                <td>{{ $etudiant->niveau }}</td>
                <td>{{ $etudiant->formation }}</td>
                <td>  <!-- Voir le profil complet -->
    <a href="{{ route('etudiants.show', $etudiant->id) }}" class="btn btn-info">Voir</a></td>
               <td>
    
  
<!-- Télécharger le CV 
    <a href="{{ route('etudiants.cv.download', $etudiant->id) }}" class="btn btn-secondary">CV</a>-->

    <!-- Inviter à un entretien -->
    <a href="{{ route('etudiants.entretiens', ['etudiant_id' => $etudiant->id]) }}" class="btn btn-primary">Entretien</a>

    <a href="{{ route('etudiants.envoyer.examen', $etudiant->id) }}" class="btn btn-warning mt-1">Examen</a> 
</td>
<td>
<!-- Accepter la candidature -->
    <form action="{{ route('candidatures.accepter', $etudiant->id) }}" method="POST" style="display:inline;">
        @csrf
        <button type="submit" class="btn btn-success"> Accepter</button>
    </form>

    <!-- Rejeter la candidature -->
    <form action="{{ route('candidatures.rejeter', $etudiant->id) }}" method="POST" style="display:inline;">
        @csrf
        <button type="submit" class="btn btn-outline-danger">Rejeter</button>
    </form>
    </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
                      
                    </div>
                </div>

                <div class="tab-content" id="entreprises-content" role="tabpanel">
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
                        <table class="table table-hover table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nom</th>
                                    <th>Secteur</th>
                                    <th>Description</th>
                                    <th>Adresse</th>
                                    <th>Email</th>
                                    <th>Téléphone</th>
                                    <th>Site Web</th>
                                    <th>Logo</th>
                                    <th>Contact Principal</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($entreprises as $entreprise)
                                <tr>
                                    <td>{{ $entreprise->id }}</td>
                                    <td>{{ $entreprise->nom }}</td>
                                    <td>{{ $entreprise->secteur }}</td>
                                    <td>{{ Str::limit($entreprise->description, 50) }}</td>
                                    <td>{{ $entreprise->adresse }}</td>
                                    <td>{{ $entreprise->email }}</td>
                                    <td>{{ $entreprise->telephone }}</td>
                                    <td>{{ $entreprise->site_web }}</td>
                                    <td>
                                        @if($entreprise->logo_path)
                                            <img src="{{ Storage::url($entreprise->logo_path) }}" alt="Logo" style="width:50px;height:50px;">
                                        @else
                                            <span>Pas de logo</span>
                                        @endif
                                    </td>
                                    <td>{{ $entreprise->contact_principal }}</td>
                                    <td>
                                        <div class="d-flex gap-1">
                                            <a href="{{ route('entreprises.show', $entreprise->id) }}" class="btn btn-info btn-sm">Voir</a>
                                            <a href="{{ route('entreprises.contact', $entreprise->id) }}" class="btn btn-primary btn-sm">Contacter</a>
                                            <a href="{{ route('entreprises.follow', $entreprise->id) }}" class="btn btn-success btn-sm">Suivre</a>
                                            <a href="{{ route('entreprises.edit', $entreprise->id) }}" class="btn btn-warning btn-sm">Éditer</a>
                                            <form action="{{ route('entreprises.destroy', $entreprise->id) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette entreprise?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">Supprimer</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $entreprises->links() }}
                    @else
                        <div class="alert alert-info">Aucune entreprise trouvée pour le moment.</div>
                    @endif
          


                     </div>
                </div>

                <div class="tab-content" id="recrutements-content" role="tabpanel">
                     <div class="action-bar">
                        <div class="action-buttons">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#recrutementModal">
                                <i class="fas fa-plus-circle me-1"></i> Ajouter Recrutement
                            </button>
                        </div>
                    </div>
                     <div class="content-area table-responsive">
                        <h4>Liste des Recrutements</h4>
                        <p>Tableau des recrutements apparaîtra ici.</p>
                     </div>
                </div>

                <div class="tab-content" id="actualites-content" role="tabpanel">
                    <div class="action-bar">
                       <div class="action-buttons">
                           <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#actualiteModal">
                               <i class="fas fa-plus-circle me-1"></i> Ajouter Actualité
                           </button>
                       </div>
                   </div>
                    <div class="content-area table-responsive">
                       <h4>Liste des Actualités</h4>
@if(isset($actualites) && !$actualites->isEmpty())
    <table class="table table-hover table-bordered">
        <thead>
            <tr>
                <th>Titre</th>
                <th>Contenu</th>
                <th>Auteur</th>
                <th>Catégorie</th>
                <th>Date de publication</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($actualites as $actualite)
            <tr>
                <td>{{ $actualite->titre }}</td>
                <td>{{ Str::limit($actualite->contenu, 50) }}</td>
                <td>{{ $actualite->auteur }}</td>
                <td>{{ $actualite->categorie }}</td>
                <td>{{ \Carbon\Carbon::parse($actualite->date_publication)->format('d/m/Y') }}</td>
                <td>
                    <div class="d-flex gap-1">
                        <!--a href="{{ route('actualites.show', $actualite->id) }}" class="btn btn-info btn-sm"><i class="fas fa-eye"></i></a-->
                        <a href="{{ route('actualites.edit', $actualite->id) }}" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                        <form action="{{ route('actualites.destroy', $actualite->id) }}" method="POST" style="display: inline-block;" onsubmit="return confirm('Confirmer la suppression de cette actualité ?')">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-danger btn-sm">
        <i class="fas fa-trash"></i>
    </button>
</form>

                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $actualites->links() }}
@else
    <div class="alert alert-info">Aucune actualité trouvée pour le moment.</div>
@endif



                    </div>
                </div>

                <div class="tab-content" id="evenements-content" role="tabpanel">
                    <div class="action-bar">
                        <div class="action-buttons">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#eventModal">
                                <i class="fas fa-plus-circle me-1"></i> Ajouter Événement
                            </button>
                        </div>
                    </div>
                    <div class="content-area table-responsive">
                        <h4>Liste des Événements</h4>
                        @if(isset($events) && !$events->isEmpty())
                            <table class="table table-hover table-bordered">
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
                                        <td>{{ \Carbon\Carbon::parse($event->start_date)->format('d/m/Y H:i') }}</td>
                                        <td>{{ \Carbon\Carbon::parse($event->end_date)->format('d/m/Y H:i') }}</td>
                                        <td>{{ $event->location ?? '-' }}</td>
                                        <td>{{ $event->type ?? '-' }}</td>
                                        <td>
                                            {{-- Status Toggle Form --}}
                                            <form action="{{ route('evenements.toggleStatus', $event->id) }}" method="POST" style="display: inline-block;">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-sm {{ $event->is_published ? 'btn-success' : 'btn-secondary' }} status">
                                                    {{ $event->is_published ? 'Publié' : 'Privé' }}
                                                </button>
                                            </form>
                                        </td>
                                        <td>
                                            <div class="d-flex gap-1">
                                                 <a href="{{ route('evenements.show', $event->id) }}" class="btn btn-info btn-sm" title="Voir"><i class="fas fa-eye"></i></a>
                                                 <a href="{{ route('evenements.edit', $event->id) }}" class="btn btn-warning btn-sm" title="Modifier"><i class="fas fa-edit"></i></a>
                                                 {{-- Delete Form --}}
                                                 <form action="{{ route('evenements.destroy', $event->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Confirmer la suppression de cet événement ?')">
                                                     @csrf
                                                     @method('DELETE')
                                                     <button type="submit" class="btn btn-danger btn-sm" title="Supprimer"><i class="fas fa-trash"></i></button>
                                                 </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{-- Add Pagination Links if needed: $events->links() --}}
                        @else
                            <div class="alert alert-info">Aucun événement trouvé pour le moment.</div>
                        @endif
                    </div>
                </div>

                <div class="tab-content" id="catalogue-content" role="tabpanel">
                     <div class="action-bar">
                        <div class="action-buttons">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#catalogueModal">
                                <i class="fas fa-plus-circle me-1"></i> Ajouter au Catalogue
                            </button>
                        </div>
                    </div>
                     <div class="content-area table-responsive">
                        <h4>Catalogue des entreprises</h4>
                       @if(isset($catalogues) && !$catalogues->isEmpty())
    <table class="table table-hover table-bordered">
        <thead>
            <tr>
                <th>Nom de l'Établissement</th>
                <th>Description</th>
                <th>Localisation</th>
                <th>Activité Principale</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($catalogues as $catalogue)
                <tr>
                    <td>{{ $catalogue->titre }}</td>
                    <td>{{ Str::limit($catalogue->description, 60) }}</td>
                    <td>{{ $catalogue->localisation }}</td>
                    <td>{{ $catalogue->activite_principale }}</td>
                    <td>
                        <div class="d-flex gap-1">
                            <a href="{{ route('catalogue.edit', $catalogue->id) }}" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('catalogue.destroy', $catalogue->id) }}" method="POST" onsubmit="return confirm('Confirmer la suppression de ce catalogue ?')" style="display: inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $catalogues->links() }}
@else
    <div class="alert alert-info">Aucun catalogue disponible pour le moment.</div>
@endif

                     </div>
                </div>
            </div>

        </div> <!-- /.content -->
    </div> <!-- /.main-content -->
</div> <!-- /.dashboard -->

<!-- Modals -->

<!-- Event Modal -->
<div class="modal fade" id="eventModal" tabindex="-1" aria-labelledby="eventModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="eventModalLabel">Ajouter un événement</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="eventForm" action="{{ route('events.store') }}" method="POST" class="needs-validation" novalidate enctype="multipart/form-data">
         @csrf <!-- CSRF Token for Laravel -->
          <div class="modal-body">
              <div class="mb-3">
                <label for="event_title" class="form-label">Titre de l'événement*</label>
                <input type="text" class="form-control" id="event_title" name="title" required>
                <div class="invalid-feedback">Veuillez saisir un titre.</div>
              </div>
              <div class="mb-3">
                <label for="event_description" class="form-label">Description</label>
                <textarea class="form-control" id="event_description" name="description" rows="3"></textarea>
              </div>
              <div class="row">
                <div class="col-md-6 mb-3">
                  <label for="event_start_date" class="form-label">Date et heure de début*</label>
                  <input type="datetime-local" class="form-control" id="event_start_date" name="start_date" required>
                  <div class="invalid-feedback">Veuillez saisir une date de début valide.</div>
                </div>
                <div class="col-md-6 mb-3">
                  <label for="event_end_date" class="form-label">Date et heure de fin*</label>
                  <input type="datetime-local" class="form-control" id="event_end_date" name="end_date" required>
                  <div class="invalid-feedback">La date de fin doit être postérieure à la date de début.</div>
                </div>
              </div>
              <div class="mb-3">
                <label for="event_location" class="form-label">Lieu</label>
                <input type="text" class="form-control" id="event_location" name="location">
              </div>
              <div class="row">
                <div class="col-md-6 mb-3">
                  <label for="event_type" class="form-label">Type d'événement</label>
                  <select class="form-select" id="event_type" name="type">
                    <option value="">Sélectionner un type</option>
                    <option value="Conférence">Conférence</option>
                    <option value="Workshop">Workshop</option>
                    <option value="Salon">Salon</option>
                    <option value="Formation">Formation</option>
                    <option value="Networking">Networking</option>
                    <option value="Autre">Autre</option>
                  </select>
                </div>
                <div class="col-md-6 mb-3">
                  <label for="event_max_participants" class="form-label">Nombre max. de participants</label>
                  <input type="number" class="form-control" id="event_max_participants" name="max_participants" min="1">
                </div>
              </div>
              <div class="mb-3">
                <label for="event_image" class="form-label">Image (affiche)</label>
                <input type="file" class="form-control" id="event_image" name="image" accept="image/*">
              </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
            <button type="submit" class="btn btn-primary submit-btn" id="submitEvent">Enregistrer</button>
          </div>
      </form>
    </div>
  </div>
</div>

<!-- Student Modal -->
<div class="modal fade" id="etudiantModal" tabindex="-1" aria-labelledby="etudiantModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="etudiantModalLabel">Ajouter un étudiant</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="etudiantForm" action="{{ route('etudiants.store') }}" method="POST" class="needs-validation" novalidate enctype="multipart/form-data">
         @csrf
          <div class="modal-body">
              <div class="row">
                <div class="col-md-6 mb-3">
                  <label for="etudiant_nom" class="form-label">Nom*</label>
                  <input type="text" class="form-control" id="etudiant_nom" name="nom" required>
                  <div class="invalid-feedback">Veuillez saisir un nom.</div>
                </div>
                <div class="col-md-6 mb-3">
                  <label for="etudiant_prenom" class="form-label">Prénom*</label>
                  <input type="text" class="form-control" id="etudiant_prenom" name="prenom" required>
                  <div class="invalid-feedback">Veuillez saisir un prénom.</div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6 mb-3">
                  <label for="etudiant_email" class="form-label">Email*</label>
                  <input type="email" class="form-control" id="etudiant_email" name="email" required>
                  <div class="invalid-feedback">Veuillez saisir une adresse email valide.</div>
                </div>
                <div class="col-md-6 mb-3">
                  <label for="etudiant_telephone" class="form-label">Téléphone</label>
                  <input type="tel" class="form-control" id="etudiant_telephone" name="telephone">
                </div>
              </div>
              <div class="row">
                <div class="col-md-6 mb-3">
                  <label for="etudiant_formation" class="form-label">Formation</label>
                  <input type="text" class="form-control" id="etudiant_formation" name="formation">
                </div>
                <div class="col-md-6 mb-3">
                  <label for="etudiant_niveau" class="form-label">Niveau</label>
                  <select class="form-select" id="etudiant_niveau" name="niveau">
                    <option value="">Sélectionner un niveau</option>
                    <option value="Bac">Bac</option>
                    <option value="Bac+1">Bac+1</option>
                    <option value="Bac+2">Bac+2</option>
                    <option value="Bac+3">Bac+3</option>
                    <option value="Bac+4">Bac+4</option>
                    <option value="Bac+5">Bac+5</option>
                    <option value="Doctorat">Doctorat</option>
                  </select>
                </div>
              </div>
              <div class="mb-3">
                <label for="etudiant_date_naissance" class="form-label">Date de naissance</label>
                <input type="date" class="form-control" id="etudiant_date_naissance" name="date_naissance">
              </div>
              <div class="row">
                <div class="col-md-6 mb-3">
                  <label for="etudiant_cv" class="form-label">CV (PDF)</label>
                  <input type="file" class="form-control" id="etudiant_cv" name="cv" accept=".pdf">
                </div>
                <div class="col-md-6 mb-3">
                  <label for="etudiant_photo" class="form-label">Photo</label>
                  <input type="file" class="form-control" id="etudiant_photo" name="photo" accept="image/*">
                </div>
              </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
            <button type="submit" class="btn btn-primary submit-btn" id="submitEtudiant">Enregistrer</button>
          </div>
      </form>
    </div>
  </div>
</div>

<!-- Enterprise Modal -->
<div class="modal fade" id="entrepriseModal" tabindex="-1" aria-labelledby="entrepriseModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="entrepriseModalLabel">Ajouter une entreprise</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="entrepriseForm" action="{{ route('entreprises.store') }}" method="POST" class="needs-validation" novalidate enctype="multipart/form-data">
        @csrf
        <div class="modal-body">
             <div class="mb-3">
               <label for="entreprise_nom" class="form-label">Nom de l'entreprise*</label>
               <input type="text" class="form-control" id="entreprise_nom" name="nom" required>
               <div class="invalid-feedback">Veuillez saisir un nom d'entreprise.</div>
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
            <div class="mb-3">
              <label for="actualite_contenu" class="form-label">Contenu*</label>
              <textarea class="form-control" id="actualite_contenu" name="contenu" rows="5" required></textarea>
              <div class="invalid-feedback">Veuillez saisir un contenu.</div>
            </div>
            <div class="row">
              <div class="col-md-6 mb-3">
                <label for="actualite_categorie" class="form-label">Catégorie</label>
                <select class="form-select" id="actualite_categorie" name="categorie">
                  <option value="">Sélectionner une catégorie</option>
                  <option value="Événement">Événement</option>
                  <option value="Recrutement">Recrutement</option>
                  <option value="Formation">Formation</option>
                  <option value="Campus">Campus</option>
                  <option value="Partenariat">Partenariat</option>
                   <option value="Autre">Autre</option>
                </select>
              </div>
              <div class="col-md-6 mb-3">
                <label for="actualite_date_publication" class="form-label">Date de publication*</label>
                <input type="datetime-local" class="form-control" id="actualite_date_publication" name="date_publication" required>
                <div class="invalid-feedback">Veuillez saisir une date de publication.</div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6 mb-3">
                <label for="actualite_auteur" class="form-label">Auteur</label>
                <input type="text" class="form-control" id="actualite_auteur" name="auteur">
              </div>
              <div class="col-md-6 mb-3">
                <label for="actualite_image" class="form-label">Image</label>
                <input type="file" class="form-control" id="actualite_image" name="image" accept="image/*">
              </div>
            </div>
         </div>
         <div class="modal-footer">
           <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
           <button type="submit" class="btn btn-primary submit-btn" id="submitActualite">Enregistrer</button>
         </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade" id="catalogueModal" tabindex="-1" aria-labelledby="catalogueModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="catalogueModalLabel">Ajouter un catalogue</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
      </div>
      <form id="catalogueForm" action="{{ route('catalogue.store') }}" method="POST" class="needs-validation" novalidate enctype="multipart/form-data">
        @csrf
        <div class="modal-body">
          <p class="text-muted">
            Les informations saisies permettront de créer une page publique. Merci de fournir des données exactes.
          </p>

          <div class="row">
            <div class="col-md-12 mb-3">
              <label for="titre" class="form-label">Nom Officiel de l'Établissement*</label>
              <input type="text" class="form-control" id="titre" name="titre" required>
              <div class="invalid-feedback">Veuillez saisir le nom de l'établissement.</div>
            </div>

            <div class="col-md-12 mb-3">
              <label for="description" class="form-label">Description de l'Établissement*</label>
              <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
              <div class="invalid-feedback">Veuillez saisir une description.</div>
            </div>

            <div class="col-md-12 mb-3">
              <label for="logo" class="form-label">Logo</label>
              <input type="file" class="form-control" id="logo" name="logo" accept="image/*">
            </div>

            <div class="col-md-12 mb-3">
              <label for="localisation" class="form-label">Localisation*</label>
              <input type="text" class="form-control" id="localisation" name="localisation" required>
            </div>

            <div class="col-md-12 mb-3">
              <label for="nb_activites" class="form-label">Nombre d'activités*</label>
              <input type="number" class="form-control" id="nb_activites" name="nb_activites" required>
            </div>

            <div class="col-md-12 mb-3">
              <label for="activite_principale" class="form-label">Activité Principale*</label>
              <input type="text" class="form-control" id="activite_principale" name="activite_principale" required>
            </div>

            <div class="col-md-12 mb-3">
              <label for="desc_activite_principale" class="form-label">Description de l'activité principale*</label>
              <textarea class="form-control" id="desc_activite_principale" name="desc_activite_principale" rows="2" required></textarea>
            </div>

            <div class="col-md-12 mb-3">
              <label for="activite_secondaire" class="form-label">Activité Secondaire</label>
              <input type="text" class="form-control" id="activite_secondaire" name="activite_secondaire">
            </div>

            <div class="col-md-12 mb-3">
              <label for="desc_activite_secondaire" class="form-label">Description de l'activité secondaire</label>
              <textarea class="form-control" id="desc_activite_secondaire" name="desc_activite_secondaire" rows="2"></textarea>
            </div>

            <div class="col-md-12 mb-3">
              <label for="autres" class="form-label">Autres informations</label>
              <textarea class="form-control" id="autres" name="autres" rows="2"></textarea>
            </div>

            <div class="col-md-12 mb-3">
              <label for="image" class="form-label">Image de fond</label>
              <input type="file" class="form-control" id="image" name="image" accept="image/*">
            </div>
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





<!-- Toast Container -->
<div class="toast-container position-fixed bottom-0 end-0 p-3">
  <div id="successToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="toast-header bg-success text-white">
      <i class="fas fa-check-circle me-2"></i>
      <strong class="me-auto">Succès</strong>
      <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
    <div class="toast-body">
      Opération effectuée avec succès !
    </div>
  </div>
   <div id="errorToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header bg-danger text-white">
            <i class="fas fa-exclamation-circle me-2"></i>
            <strong class="me-auto">Erreur</strong>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">
            Une erreur s'est produite. <span id="errorToastMessage"></span>
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