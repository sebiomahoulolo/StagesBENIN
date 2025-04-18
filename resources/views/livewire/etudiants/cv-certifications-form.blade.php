<div class="form-section">
    <div class="form-section-header">
        <h4>Certifications</h4>
         <button type="button" wire:click="toggleAddForm" class="add-item-btn btn btn-sm {{ $showAddForm ? 'btn-secondary' : 'btn-primary' }}">
            <i class="fas {{ $showAddForm ? 'fa-times' : 'fa-plus' }}"></i>
            <span>{{ $showAddForm ? 'Fermer' : 'Ajouter' }}</span>
        </button>
    </div>

    @if(session()->has('certification_message'))
        <div class="alert alert-success mt-3" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)">{{ session('certification_message') }}</div>
    @endif
    @if(session()->has('certification_error'))
        <div class="alert alert-danger mt-3">{{ session('certification_error') }}</div>
    @endif

    {{-- === FORMULAIRE D'AJOUT (Conditionnel) === --}}
    @if($showAddForm)
        <div class="certification-add-form mt-4 p-4 border rounded shadow-sm bg-light">
            <h5 style="margin-bottom: 1.5rem; color: var(--primary-color, #007bff);">Ajouter une nouvelle certification</h5>
            <form wire:submit.prevent="addCertification">
                 <div class="row mb-3">
                       <div class="col-md form-group mb-md-0 mb-3"> {{-- col-md pour flexibilité --}}
                           <label for="new_cert_nom" class="form-label">Certification <span style="color:red">*</span></label>
                           <input type="text" id="new_cert_nom" wire:model.lazy="newCertification.nom" class="form-control form-control-sm @error('newCertification.nom') is-invalid @enderror" required>
                           @error('newCertification.nom') <span class="invalid-feedback">{{ $message }}</span> @enderror
                       </div>
                       <div class="col-md form-group mb-md-0 mb-3"> {{-- col-md --}}
                            <label for="new_cert_org" class="form-label">Organisme <span style="color:red">*</span></label>
                            <input type="text" id="new_cert_org" wire:model.lazy="newCertification.organisme" class="form-control form-control-sm @error('newCertification.organisme') is-invalid @enderror" required>
                            @error('newCertification.organisme') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>
                        <div class="col-md-auto form-group mb-0"> {{-- col-md-auto pour l'année --}}
                            <label for="new_cert_annee" class="form-label">Année</label>
                            <input type="number" id="new_cert_annee" wire:model.lazy="newCertification.annee" class="form-control form-control-sm @error('newCertification.annee') is-invalid @enderror" min="1980" max="{{ date('Y') + 1 }}" style="width: 90px;"> {{-- Largeur fixe --}}
                            @error('newCertification.annee') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>
                   </div>
                   <div class="form-group mb-3">
                       <label for="new_cert_url" class="form-label">URL Validation</label>
                       <input type="url" id="new_cert_url" wire:model.lazy="newCertification.url_validation" class="form-control form-control-sm @error('newCertification.url_validation') is-invalid @enderror" placeholder="http://...">
                       @error('newCertification.url_validation') <span class="invalid-feedback">{{ $message }}</span> @enderror
                   </div>
                <div class="mt-3 text-end">
                    <button type="submit" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i> Ajouter Certification
                    </button>
                </div>
            </form>
        </div>
    @endif

    {{-- === LISTE DES ITEMS EXISTANTS === --}}
    <div class="certifications-list mt-4">
        @forelse ($certifications as $index => $certification)
            <div class="form-repeater-item mb-3 {{ $editingIndex === $index ? 'editing-item' : 'certification-card' }}" wire:key="certification-item-{{ $certification['id'] ?? $index }}">
                @if(session()->has('certification_error_' . $index))
                    <div class="alert alert-danger alert-sm mb-3">{{ session('certification_error_' . $index) }}</div>
                 @endif

                 @if($editingIndex === $index)
                     {{-- === FORMULAIRE D'ÉDITION === --}}
                    <div class="p-3 border rounded shadow-sm bg-light">
                        <h6 style="color: var(--primary-color, #007bff); margin-bottom: 1rem;">Modifier la certification</h6>
                         <form wire:submit.prevent="updateCertification">
                              <div class="row mb-3">
                                 <div class="col-md form-group mb-md-0 mb-3">
                                     <label for="edit_cert_nom_{{ $index }}" class="form-label">Certification <span style="color:red">*</span></label>
                                     <input type="text" id="edit_cert_nom_{{ $index }}" wire:model.lazy="editingCertification.nom" class="form-control form-control-sm @error('editingCertification.nom') is-invalid @enderror" required>
                                     @error('editingCertification.nom') <span class="invalid-feedback">{{ $message }}</span> @enderror
                                 </div>
                                 <div class="col-md form-group mb-md-0 mb-3">
                                      <label for="edit_cert_org_{{ $index }}" class="form-label">Organisme <span style="color:red">*</span></label>
                                      <input type="text" id="edit_cert_org_{{ $index }}" wire:model.lazy="editingCertification.organisme" class="form-control form-control-sm @error('editingCertification.organisme') is-invalid @enderror" required>
                                      @error('editingCertification.organisme') <span class="invalid-feedback">{{ $message }}</span> @enderror
                                  </div>
                                  <div class="col-md-auto form-group mb-0">
                                      <label for="edit_cert_annee_{{ $index }}" class="form-label">Année</label>
                                      <input type="number" id="edit_cert_annee_{{ $index }}" wire:model.lazy="editingCertification.annee" class="form-control form-control-sm @error('editingCertification.annee') is-invalid @enderror" min="1980" max="{{ date('Y') + 1 }}" style="width: 90px;">
                                      @error('editingCertification.annee') <span class="invalid-feedback">{{ $message }}</span> @enderror
                                  </div>
                             </div>
                             <div class="form-group mb-3">
                                 <label for="edit_cert_url_{{ $index }}" class="form-label">URL Validation</label>
                                 <input type="url" id="edit_cert_url_{{ $index }}" wire:model.lazy="editingCertification.url_validation" class="form-control form-control-sm @error('editingCertification.url_validation') is-invalid @enderror" placeholder="http://...">
                                 @error('editingCertification.url_validation') <span class="invalid-feedback">{{ $message }}</span> @enderror
                             </div>
                            <div class="d-flex justify-content-end gap-2 mt-3">
                                <button type="button" wire:click="cancelEdit" class="btn btn-secondary btn-sm">Annuler</button>
                                <button type="submit" class="btn btn-primary btn-sm">
                                    <i class="fas fa-save"></i> Enregistrer
                                </button>
                            </div>
                        </form>
                    </div>
                 @else
                     {{-- === AFFICHAGE "CARTE" === --}}
                    <div class="item-actions">
                         <button type="button" wire:click="edit({{ $index }})" class="btn-action-icon edit-item-btn" title="Modifier">
                             <i class="fas fa-pencil-alt"></i>
                         </button>
                         <button type="button" wire:click="removeCertification({{ $index }})" wire:confirm="Êtes-vous sûr de vouloir supprimer cette certification ?" class="btn-action-icon delete-item-btn" title="Supprimer">
                            <i class="fas fa-trash"></i>
                         </button>
                    </div>
                    <div class="certification-card-body">
                         <p class="cert-title">{{ $certification['nom'] }}</p>
                         <p class="cert-org">
                             {{ $certification['organisme'] }}
                             {{ $certification['annee'] ? ' - ' . $certification['annee'] : '' }}
                         </p>
                         @if($certification['url_validation'])
                            <p class="cert-url">
                                <a href="{{ $certification['url_validation'] }}" target="_blank" rel="noopener noreferrer">
                                     <i class="fas fa-link fa-sm"></i> Voir validation
                                </a>
                            </p>
                         @endif
                    </div>
                 @endif
            </div>
        @empty
            @unless($showAddForm || $editingIndex !== null)
                <div class="empty-message"> Aucune certification ajoutée. </div>
            @endunless
        @endforelse
    </div>
</div>

<style>
 /* Styles généraux */
    .form-section { margin-bottom: 2rem; }
    .form-section-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; padding-bottom: 0.75rem; border-bottom: 1px solid #dee2e6; }
    .form-section-header h4 { margin: 0; color: #343a40; }
    .add-item-btn span { margin-left: 0.3rem; }

    /* Formulaire ajout/édition */
    .certification-add-form,
    .editing-item .p-3 {
        background-color: #f8f9fa;
    }
    .form-label { font-size: 0.875rem; margin-bottom: 0.25rem; }
    .form-control-sm { font-size: 0.875rem; }
    .text-danger { color: #dc3545 !important; }

    /* Liste des certifications */
    .certifications-list {
        display: grid;
        grid-template-columns: 1fr; /* Une colonne */
        gap: 1rem;
    }

    /* Item certification (carte) */
    .form-repeater-item {
        border: 1px solid #e9ecef;
        border-radius: 0.375rem;
        position: relative; /* Pour les actions */
        background-color: #fff;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        transition: box-shadow 0.2s ease-in-out;
    }
    .certification-card {
        padding: 1rem 1.25rem; /* Padding interne */
    }
    .certification-card:hover {
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
    }
     .certification-card:hover .item-actions,
     .certification-card:focus-within .item-actions {
         opacity: 1;
     }

    /* Conteneur du formulaire d'édition */
    .editing-item {
        /* Pas de padding direct, le .p-3 interne le gère */
    }

    /* Actions (Modifier/Supprimer) */
    .item-actions {
        position: absolute;
        top: 0.5rem;
        right: 0.5rem;
        display: flex;
        flex-direction: column; /* Boutons en colonne */
        gap: 0.4rem;
        opacity: 0;
        transition: opacity 0.2s ease-in-out;
        z-index: 10;
    }
    .btn-action-icon {
        background: rgba(255, 255, 255, 0.7);
        border: none;
        border-radius: 50%;
        width: 28px;
        height: 28px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0;
        cursor: pointer;
        line-height: 1;
    }
    .btn-action-icon i {
        font-size: 0.8rem;
        vertical-align: middle;
    }
    .btn-action-icon.edit-item-btn { color: var(--bs-primary, #0d6efd); }
    .btn-action-icon.delete-item-btn { color: var(--bs-danger, #dc3545); }
    .btn-action-icon:hover {
        background: rgba(230, 230, 230, 0.9);
        opacity: 1;
    }

    /* Styles du contenu de la carte */
    .certification-card-body {
         padding-right: 50px; /* Espace pour boutons */
    }
    .cert-title { font-weight: 600; color: var(--secondary-color, #6c757d); margin-bottom: 0.2rem; }
    .cert-org { color: var(--primary-color, #0056b3); margin-bottom: 0.2rem; font-size: 0.95rem; }
    .cert-url { font-size: 0.9em; color: var(--dark-gray, #343a40); margin-bottom: 0; word-break: break-all; }
    .cert-url a { color: inherit; text-decoration: underline; }
    .cert-url a:hover { color: var(--primary-color, #0056b3); }
    .cert-url i { margin-right: 0.3em; }

    /* Message vide */
    .empty-message {
        text-align: center;
        color: var(--dark-gray, #6c757d);
        padding: 1rem;
        border: 1px dashed #ced4da !important;
        border-radius: 4px;
        margin-top: 1rem;
    }

    /* Responsive */
    @media (max-width: 767.98px) {
        .form-repeater-item {
            /* Peut-être réduire padding sur mobile si nécessaire */
            /* padding: 0.75rem 1rem; */
        }
        .cert-title { font-size: 1rem; }
        .cert-org { font-size: 0.9rem; }
        .cert-url { font-size: 0.85em; }
         .form-section-header {
             flex-direction: column;
             align-items: flex-start;
             gap: 0.5rem;
         }
         /* Empiler form ajout/edition */
         .certification-add-form .row > div:not(:last-child),
         .editing-item .row > div:not(:last-child) {
             margin-bottom: 1rem; /* Espace quand empilé */
         }
    }

    /* Variables */
    :root {
        --primary-color: #0d6efd;
        --secondary-color: #6c757d;
        --dark-gray: #343a40;
        --bs-primary: #0d6efd;
        --bs-danger: #dc3545;
    }
</style>