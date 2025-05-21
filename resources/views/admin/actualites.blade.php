@extends('layouts.admin.app')

@section('title', 'StagesBENIN')

@push('styles')

@section('content')
<style>
    /* Styles généraux */
    .content-wrapper {
        background-color: #f8f9fa;
        min-height: calc(100vh - 60px);
        padding: 2rem 0;
    }

    /* En-tête de la page */
    .page-header {
        background: linear-gradient(135deg, #004581 0%, #0056b3 100%);
        color: white;
        padding: 1.5rem;
        border-radius: 8px;
        margin-bottom: 2rem;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .page-header h4 {
        margin: 0;
        font-weight: 600;
        font-size: 1.5rem;
    }

    /* Barre d'actions */
    .action-bar {
        background: white;
        padding: 1.25rem;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        margin-bottom: 1.5rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .action-buttons {
        display: flex;
        gap: 1rem;
        align-items: center;
    }

    .search-box {
        position: relative;
        min-width: 300px;
    }

    .search-box input {
        padding-left: 2.5rem;
        border-radius: 6px;
        border: 1px solid #dee2e6;
        transition: all 0.3s ease;
    }

    .search-box input:focus {
        border-color: #0056b3;
        box-shadow: 0 0 0 0.2rem rgba(0,86,179,0.15);
    }

    .search-box i {
        position: absolute;
        left: 1rem;
        top: 50%;
        transform: translateY(-50%);
        color: #6c757d;
    }

    /* Tableau */
    .table-container {
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        overflow: hidden;
    }

    .table {
        margin-bottom: 0;
    }

    .table thead th {
        background-color: #f8f9fa;
        border-bottom: 2px solid #dee2e6;
        color: #495057;
        font-weight: 600;
        padding: 1rem;
        white-space: nowrap;
    }

    .table tbody td {
        padding: 1rem;
        vertical-align: middle;
        border-bottom: 1px solid #dee2e6;
    }

    .table tbody tr:hover {
        background-color: #f8f9fa;
    }

    /* Badges et statuts */
    .badge {
        padding: 0.5em 0.75em;
        font-weight: 500;
        border-radius: 4px;
    }

    .badge-status-published {
        background-color: #198754;
        color: white;
    }

    .badge-status-draft {
        background-color: #6c757d;
        color: white;
    }

    /* Boutons d'action */
    .btn-action {
        padding: 0.375rem 0.75rem;
        border-radius: 4px;
        transition: all 0.2s ease;
    }

    .btn-action:hover {
        transform: translateY(-1px);
    }

    .btn-edit {
        background-color: #ffc107;
        border-color: #ffc107;
        color: #000;
    }

    .btn-delete {
        background-color: #dc3545;
        border-color: #dc3545;
        color: white;
    }

    .btn-view {
        background-color: #0dcaf0;
        border-color: #0dcaf0;
        color: white;
    }

    /* Pagination */
    .pagination-container {
        padding: 1rem;
        background: white;
        border-top: 1px solid #dee2e6;
    }

    .pagination {
        margin-bottom: 0;
    }

    .page-link {
        color: #0056b3;
        border: 1px solid #dee2e6;
        padding: 0.5rem 0.75rem;
    }

    .page-item.active .page-link {
        background-color: #0056b3;
        border-color: #0056b3;
    }

    /* Modal */
    .modal-content {
        border-radius: 8px;
        border: none;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    }

    .modal-header {
        background: linear-gradient(135deg, #004581 0%, #0056b3 100%);
        color: white;
        border-radius: 8px 8px 0 0;
        padding: 1.25rem;
    }

    .modal-body {
        padding: 1.5rem;
    }

    .modal-footer {
        padding: 1rem 1.5rem;
        border-top: 1px solid #dee2e6;
    }

    /* Formulaires */
    .form-label {
        font-weight: 500;
        color: #495057;
        margin-bottom: 0.5rem;
    }

    .form-control, .form-select {
        border-radius: 6px;
        border: 1px solid #dee2e6;
        padding: 0.5rem 0.75rem;
        transition: all 0.2s ease;
    }

    .form-control:focus, .form-select:focus {
        border-color: #0056b3;
        box-shadow: 0 0 0 0.2rem rgba(0,86,179,0.15);
    }

    /* Responsive */
    @media (max-width: 768px) {
        .action-bar {
            flex-direction: column;
            align-items: stretch;
        }

        .action-buttons {
            flex-direction: column;
            width: 100%;
        }

        .search-box {
            width: 100%;
        }

        .table-responsive {
            border-radius: 8px;
        }

        .table thead {
            display: none;
        }

        .table tbody tr {
            display: block;
            margin-bottom: 1rem;
            border: 1px solid #dee2e6;
            border-radius: 8px;
        }

        .table tbody td {
            display: block;
            text-align: right;
            padding: 0.75rem;
            border: none;
            border-bottom: 1px solid #dee2e6;
        }

        .table tbody td:last-child {
            border-bottom: none;
        }

        .table tbody td::before {
            content: attr(data-label);
            float: left;
            font-weight: 600;
            color: #495057;
        }
    }
</style>
@endpush

@section('content')
<div class="content-wrapper">
    <div class="container-fluid">
        <!-- En-tête de la page -->
        <div class="page-header">
            <h4><i class="fas fa-newspaper me-2"></i>Gestion des Marchés Publics</h4>
        </div>

        <!-- Barre d'actions -->
        <div class="action-bar">
            <div class="action-buttons">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#marcheModal" id="addMarcheBtn">
                    <i class="fas fa-plus-circle me-1"></i> Nouveau Marché
                </button>
                <div class="search-box">
                    <i class="fas fa-search"></i>
                    <input type="text" id="searchInput" class="form-control" placeholder="Rechercher un marché...">
                </div>
            </div>
        </div>

        <!-- Messages de session -->
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Tableau des marchés -->
        <div class="table-container">
            <div class="table-responsive">
                @if ($actualites->isNotEmpty())
                    <table class="table table-hover" id="marchesTable">
                        <thead>
                            <tr>
                                <th>Autorité Contractante</th>
                                <th>Objet / Détails</th>
                                <th>Gestion</th>
                                <th>Catégorie</th>
                                <th>Date Pub.</th>
                                <th>Statut</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($actualites as $marche)
                                <tr>
                                    <td data-label="Autorité">{{ $marche->autorite_contractante ?? $marche->auteur ?? 'N/A' }}</td>
                                    <td data-label="Objet">{{ Str::limit($marche->details ?? $marche->contenu, 70) }}</td>
                                    <td data-label="Gestion">{{ $marche->gestion ?? '-' }}</td>
                                    <td data-label="Catégorie">{{ $marche->categorie?? '-' }}</td>
                                    <td data-label="Date Pub.">
                                        {{ $marche->date_publication ? \Carbon\Carbon::parse($marche->date_publication)->isoFormat('DD MMM YYYY') : '-' }}
                                    </td>
                                    <td data-label="Statut">
                                        @if($marche->status == App\Models\Actualite::STATUS_PUBLISHED)
                                            <span class="badge badge-status-published">Publié</span>
                                        @else
                                            <span class="badge badge-status-draft">Brouillon</span>
                                        @endif
                                    </td>
                                    <td data-label="Actions">
                                        <div class="d-flex gap-2 justify-content-center">
                                            <button type="button" class="btn btn-action btn-edit editMarcheBtn"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#marcheModal"
                                                    data-id="{{ $marche->id }}"
                                                    data-action="{{ route('actualites.update', $marche->id) }}"
                                                    data-autorite_contractante="{{ $marche->autorite_contractante ?? '' }}"
                                                    data-gestion="{{ $marche->gestion ?? '' }}"
                                                    data-details="{{ $marche->details ?? $marche->contenu ?? '' }}"
                                                    data-montant="{{ $marche->montant ?? '' }}"
                                                    data-type_marche="{{ $marche->type_marche ?? '' }}"
                                                    data-mode_passation="{{ $marche->mode_passation ?? '' }}"
                                                    data-document_titre="{{ $marche->document_titre ?? $marche->titre ?? '' }}"
                                                    data-document_contenu="{{ $marche->document_contenu ?? '' }}"
                                                    data-document_url="{{ $marche->document_url }}"
                                                    data-date_publication="{{ $marche->date_publication ? \Carbon\Carbon::parse($marche->date_publication)->format('Y-m-d') : '' }}"
                                                    data-categorie="{{ $marche->categorie ?? '' }}"
                                                    data-auteur_id="{{ $marche->auteur_id ?? '' }}"
                                                    data-status="{{ $marche->status ?? 'draft' }}"
                                                    title="Modifier">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <form action="{{ route('actualites.destroy', $marche->id) }}" method="POST" style="display: inline-block;" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce marché ? Cette action est irréversible.')">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn btn-action btn-delete" title="Supprimer">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                            @if($marche->document_url)
                                                <a href="{{ $marche->document_url }}" target="_blank" class="btn btn-action btn-view" title="Voir le document">
                                                    <i class="fas fa-file-pdf"></i>
                                                </a>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="alert alert-info text-center m-3">
                        <i class="fas fa-info-circle me-2"></i>Aucun marché trouvé.
                    </div>
                @endif
            </div>

            <!-- Pagination -->
            @if($actualites->hasPages())
                <div class="pagination-container">
                    {{ $actualites->links() }}
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="marcheModal" tabindex="-1" aria-labelledby="marcheModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="marcheModalLabel">Ajouter un Nouveau Marché</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body p-4">
         <form action="{{ route('actualites.store') }}" method="POST" enctype="multipart/form-data" class="needs-validation" id="marcheForm" novalidate>
             @csrf
             <input type="hidden" name="_method" id="formMethod" value="POST">
             <input type="hidden" name="marche_id" id="marche_id"> {{-- Conceptual ID --}}

             {{-- General Info Section --}}
             <h5 class="mb-3 text-primary border-bottom pb-2">Informations Générales</h5>
             <div class="row g-3 mb-4">
                 <div class="col-md-6">
                     <label for="autorite_contractante" class="form-label">Autorité Contractante <span class="text-danger">*</span></label>
                     <input type="text" class="form-control" id="autorite_contractante" name="autorite_contractante" required>
                     <div class="invalid-feedback">Veuillez renseigner l'autorité contractante.</div>
                 </div>
                 <div class="col-md-6">
                     <label for="gestion" class="form-label">Gestion (Année) <span class="text-danger">*</span></label>
                     <input type="number" class="form-control" id="gestion" name="gestion" placeholder="Ex: {{ date('Y') }}" min="2000" max="{{ date('Y') + 5 }}" required>
                     <div class="invalid-feedback">Veuillez indiquer l'année de gestion.</div>
                 </div>
             </div>
             <div class="mb-4">
                 <label for="details" class="form-label">Détails / Objet du Marché <span class="text-danger">*</span></label>
                 <textarea class="form-control" id="details" name="details" rows="4" required placeholder="Décrivez brièvement l'objet ou les détails du marché..."></textarea>
                 <div class="invalid-feedback">Veuillez fournir les détails du marché.</div>
             </div>

            {{-- Conditions Section --}}
            <h5 class="mb-3 text-primary border-bottom pb-2">Conditions du Marché</h5>
             <div class="row g-3 mb-4">
                 <div class="col-md-6">
                     <label for="montant" class="form-label">Montant Estimé / Alloué (FCFA)</label>
                     <div class="input-group">
                         <input type="number" class="form-control" id="montant" name="montant" placeholder="Ex: 15000000" step="any" min="0">
                         <span class="input-group-text">FCFA</span>
                     </div>
                     <div class="invalid-feedback d-block" id="montant_error"></div>
                 </div>
                <div class="col-md-6">
    <label for="type_marche" class="form-label">Type de Marché <span class="text-danger">*</span></label>
    <select class="form-select" id="type_marche" name="type_marche" required>
        <option value="" selected disabled>Sélectionner...</option>
        <option value="travaux">Travaux</option>
        <option value="fournitures">Fournitures</option>
        <option value="services_consultants">Services de Consultants</option>
        <option value="prestations_intellectuelles">Prestations Intellectuelles</option>
        <option value="services_generaux">Services Généraux</option>
        <option value="maintenance_reparation">Maintenance et Réparation</option>
        <option value="construction">Construction</option>
        <option value="transport_logistique">Transport et Logistique</option>
        <option value="informatique">Informatique</option>
        <option value="assistance_technique">Assistance Technique</option>
        <option value="autre">Autre</option>
    </select>
    <div class="invalid-feedback">Veuillez sélectionner le type de marché.</div>
</div>

             </div>
           <div class="mb-4">
    <label for="mode_passation" class="form-label">Mode de Passation <span class="text-danger">*</span></label>
    <select class="form-select" id="mode_passation" name="mode_passation" required>
        <option value="" selected disabled>Sélectionner...</option>
        <option value="appel_offres_ouvert">Appel d'offres ouvert (AOO)</option>
        <option value="appel_offres_restreint">Appel d'offres restreint (AOR)</option>
        <option value="consultation_fournisseurs">Consultation de fournisseurs / Demande de cotation</option>
        <option value="gre_a_gre">Gré à gré / Entente directe</option>
        <option value="marché_negocié">Marché négocié</option>
        <option value="accord_cadre">Accord-cadre</option>
        <option value="procedure_competitive">Procédure compétitive</option>
        <option value="appel_a_manifestation_interet">Appel à manifestation d'intérêt</option>
        <option value="dialogue_compétitif">Dialogue compétitif</option>
        <option value="procédure_dérogatoire">Procédure dérogatoire</option>
        <option value="autre">Autre</option>
    </select>
    <div class="invalid-feedback">Veuillez sélectionner le mode de passation.</div>
</div>


            {{-- Document Section --}}
            <h5 class="mb-3 text-primary border-bottom pb-2">Document Associé</h5>
             <div class="row g-3 mb-4">
                 <div class="col-md-6">
                     <label for="document_titre" class="form-label">Titre du Document PDF</label>
                     <input type="text" class="form-control" id="document_titre" name="document_titre" placeholder="Ex: Cahier des charges, TDR...">
                     <div class="invalid-feedback" id="document_titre_error"></div>
                 </div>
                 <div class="col-md-6">
                     <label for="document_pdf" class="form-label">Fichier PDF</label>
                     <input type="file" class="form-control" id="document_pdf" name="document_pdf" accept=".pdf">
                     <small id="current_doc_link_modal" class="text-muted mt-1 d-block" style="display: none;"> {{-- Use d-block --}}
                         Document actuel: <a href="#" target="_blank" rel="noopener noreferrer">Voir le fichier</a>
                     </small>
                     <div class="invalid-feedback" id="document_pdf_error"></div>
                 </div>
             </div>
             <div class="mb-4">
                  <label for="document_contenu" class="form-label">Contenu / Résumé du Document PDF</label>
                  <textarea class="form-control" id="document_contenu" name="document_contenu" rows="3" placeholder="Un bref résumé ou les points clés du document PDF..."></textarea>
                  <div class="invalid-feedback" id="document_contenu_error"></div>
             </div>

            {{-- Publication Section --}}
            <h5 class="mb-3 text-primary border-bottom pb-2">Publication et Classification</h5>
             <div class="row g-3 mb-4">
                 <div class="col-md-6">
                     <label for="date_publication" class="form-label">Date de Publication <span class="text-danger">*</span></label>
                     <input type="date" class="form-control" id="date_publication" name="date_publication" required>
                     <div class="invalid-feedback">Veuillez indiquer la date de publication.</div>
                 </div>
                 <div class="col-md-6">
                     <label for="categorie" class="form-label">Catégorie <span class="text-danger">*</span></label>
                     <select class="form-select" id="categorie" name="categorie" required>
                         <option value="" selected disabled>Sélectionner...</option>
                         <option value="appel_offre">Appel d'Offre</option>
                         <option value="avis_attribution">Avis d'Attribution</option>
                         <option value="manifestation_interet">Avis de Manifestation d'Intérêt</option>
                         <option value="resultats">Résultats</option>
                         <option value="autre_publication">Autre Publication</option>
                     </select>
                     <div class="invalid-feedback">Veuillez sélectionner une catégorie.</div>
                 </div>
                 <div class="col-md-6"> {{-- Added Status Field --}}
                    <label for="status" class="form-label">Statut <span class="text-danger">*</span></label>
                    <select class="form-select" id="status" name="status" required>
                        <option value="{{ App\Models\Actualite::STATUS_DRAFT }}">Brouillon</option>
                        <option value="{{ App\Models\Actualite::STATUS_PUBLISHED }}">Publié</option>
                    </select>
                     <div class="invalid-feedback">Veuillez sélectionner un statut.</div>
                </div>
                 <div class="col-md-6">
                      <label for="auteur_id" class="form-label">Auteur/Responsable</label>
                      <select class="form-select" id="auteur_id" name="auteur_id">
                          <option value="">-- Automatique (si Publié) --</option> {{-- Clarify behaviour --}}
                          {{-- Only list users if admin should override --}}
                          @if(isset($users))
                            @foreach($users as $user)
                               <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                          @endif
                      </select>
                      <div class="invalid-feedback" id="auteur_id_error"></div>
                 </div>
             </div>

         </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal"><i class="fas fa-times me-1"></i> Annuler</button>
        <button type="submit" class="btn btn-primary" form="marcheForm"><i class="fas fa-save me-1"></i> Enregistrer</button>
      </div>
    </div>
  </div>
</div>

@endsection

@push('scripts')
<script>
    // Activate Bootstrap tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
      return new bootstrap.Tooltip(tooltipTriggerEl)
    })

    // --- Live Search Script ---
    document.getElementById("searchInput")?.addEventListener("keyup", function() {
        const filter = this.value.toLowerCase();
        let visibleRowCount = 0;
        const tableBody = document.getElementById("marchesTable")?.querySelector("tbody");

        if(tableBody) {
            tableBody.querySelectorAll("tr").forEach(row => {
                const searchableCells = row.querySelectorAll(".searchable");
                const isRowFound = [...searchableCells].some(cell =>
                    cell.textContent.toLowerCase().includes(filter)
                );
                row.style.display = isRowFound ? "" : "none";
                if (isRowFound) visibleRowCount++;
            });
        }
         const totalMarchesSpan = document.getElementById("totalMarches");
         if (totalMarchesSpan) totalMarchesSpan.textContent = visibleRowCount;
    });

    // --- Modal Handling Script ---
    const marcheModalElement = document.getElementById('marcheModal');
    const marcheModal = marcheModalElement ? new bootstrap.Modal(marcheModalElement) : null;
    const marcheModalLabel = document.getElementById('marcheModalLabel');
    const marcheForm = document.getElementById('marcheForm');
    const formMethodInput = document.getElementById('formMethod');
    const marcheIdInput = document.getElementById('marche_id');
    const currentDocLinkModal = document.getElementById('current_doc_link_modal');
    const currentDocLinkModalA = currentDocLinkModal?.querySelector('a');

    // --- Form Fields --- (Cache them for efficiency)
    const autoriteContractanteInput = document.getElementById('autorite_contractante');
    const gestionInput = document.getElementById('gestion');
    const detailsInput = document.getElementById('details');
    const montantInput = document.getElementById('montant');
    const typeMarcheSelect = document.getElementById('type_marche');
    const modePassationSelect = document.getElementById('mode_passation');
    const documentTitreInput = document.getElementById('document_titre');
    const documentContenuInput = document.getElementById('document_contenu');
    const datePublicationInput = document.getElementById('date_publication');
    const categorieSelect = document.getElementById('categorie');
    const auteurIdSelect = document.getElementById('auteur_id');
    const statusSelect = document.getElementById('status'); // Cache status select
    const documentPdfInput = document.getElementById('document_pdf'); // Cache file input

    function resetMarcheModal() {
        if (!marcheForm) return;
        marcheForm.reset();
        marcheForm.action = "{{ route('actualites.store') }}"; // Use actualites route
        if (formMethodInput) formMethodInput.value = 'POST';
        if (marcheIdInput) marcheIdInput.value = '';
        if (marcheModalLabel) marcheModalLabel.textContent = 'Ajouter un Nouveau Marché';
        marcheForm.classList.remove('was-validated');
        if (currentDocLinkModal) currentDocLinkModal.style.display = 'none';
        if (currentDocLinkModalA) currentDocLinkModalA.href = '#';
        // Reset file input visually if needed (clearing value programmatically)
        if (documentPdfInput) documentPdfInput.value = '';
        // Reset error states
        marcheForm.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
    }

    // --- Event Listeners for Modal ---
    document.getElementById('addMarcheBtn')?.addEventListener('click', () => {
        resetMarcheModal();
         // Set default status for new entries if desired (e.g., 'draft')
         if(statusSelect) statusSelect.value = '{{ App\Models\Actualite::STATUS_DRAFT }}';
          // Set default author (e.g., logged-in user) - adjust if needed
         if(auteurIdSelect) {
             @auth
                auteurIdSelect.value = "{{ auth()->id() }}";
             @else
                 auteurIdSelect.value = ""; // Or handle guests differently
             @endauth
         }
    });

    marcheModalElement?.addEventListener('show.bs.modal', function(event) {
        const button = event.relatedTarget;

        if (button && button.classList.contains('editMarcheBtn')) {
            // --- EDIT MODE ---
            if (marcheModalLabel) marcheModalLabel.textContent = 'Modifier les Informations du Marché';
            if (marcheForm) marcheForm.action = button.dataset.action; // Set update action
            if (formMethodInput) formMethodInput.value = 'PUT';
            if (marcheIdInput) marcheIdInput.value = button.dataset.id;

            // Populate fields using cached elements and data attributes
            if (autoriteContractanteInput) autoriteContractanteInput.value = button.dataset.autorite_contractante || '';
            if (gestionInput) gestionInput.value = button.dataset.gestion || '';
            if (detailsInput) detailsInput.value = button.dataset.details || '';
            if (montantInput) montantInput.value = button.dataset.montant || '';
            if (typeMarcheSelect) typeMarcheSelect.value = button.dataset.type_marche || '';
            if (modePassationSelect) modePassationSelect.value = button.dataset.mode_passation || '';
            if (documentTitreInput) documentTitreInput.value = button.dataset.document_titre || '';
            if (documentContenuInput) documentContenuInput.value = button.dataset.document_contenu || '';
            if (datePublicationInput) datePublicationInput.value = button.dataset.date_publication || '';
            if (categorieSelect) categorieSelect.value = button.dataset.categorie || '';
            if (auteurIdSelect) auteurIdSelect.value = button.dataset.auteur_id || ''; // Set saved author
            if (statusSelect) statusSelect.value = button.dataset.status || '{{ App\Models\Actualite::STATUS_DRAFT }}'; // Set saved status

            // Handle current document link
            if (button.dataset.document_url && currentDocLinkModal && currentDocLinkModalA) {
                currentDocLinkModalA.href = button.dataset.document_url;
                currentDocLinkModal.style.display = 'block';
            } else if (currentDocLinkModal) {
                currentDocLinkModal.style.display = 'none';
            }

        } else if (button && button.id === 'addMarcheBtn') {
             // --- CREATE MODE (Triggered by Add button) ---
             resetMarcheModal();
             // Set defaults again just in case
              if(statusSelect) statusSelect.value = '{{ App\Models\Actualite::STATUS_DRAFT }}';
              if(auteurIdSelect) {
                 @auth
                    auteurIdSelect.value = "{{ auth()->id() }}";
                 @else
                     auteurIdSelect.value = "";
                 @endauth
             }
        }
    });

    marcheModalElement?.addEventListener('hidden.bs.modal', function(event) {
        resetMarcheModal();
    });

    // --- Bootstrap Validation Script ---
    (function () {
      'use strict'
      var forms = document.querySelectorAll('.needs-validation')
      Array.prototype.slice.call(forms)
        .forEach(function (form) {
          form.addEventListener('submit', function (event) {
            if (!form.checkValidity()) {
              event.preventDefault()
              event.stopPropagation()
            }
            form.classList.add('was-validated')
          }, false)
        })
    })()

</script>
@endpush