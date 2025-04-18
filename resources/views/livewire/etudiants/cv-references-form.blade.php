<div class="form-section">
    <div class="form-section-header">
        <h4>Références</h4>
        <button type="button" wire:click="toggleAddForm" class="add-item-btn btn btn-sm {{ $showAddForm ? 'btn-secondary' : 'btn-primary' }}">
            <i class="fas {{ $showAddForm ? 'fa-times' : 'fa-plus' }}"></i>
            <span>{{ $showAddForm ? 'Fermer' : 'Ajouter' }}</span>
        </button>
    </div>

    {{-- Messages de Session --}}
    @if(session()->has('reference_message'))
        <div class="alert alert-success mt-3" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)">{{ session('reference_message') }}</div>
    @endif
    @if(session()->has('reference_error'))
        <div class="alert alert-danger mt-3">{{ session('reference_error') }}</div>
    @endif

    {{-- === FORMULAIRE D'AJOUT (Conditionnel) === --}}
    @if($showAddForm)
        <div class="reference-add-form mt-4 p-4 border rounded shadow-sm bg-light">
            <h5 style="margin-bottom: 1.5rem; color: var(--primary-color, #007bff);">Ajouter une nouvelle référence</h5>
            <form wire:submit.prevent="addReference">
                <div class="row mb-3">
                    <div class="col-md-6 form-group">
                        <label for="new_ref_prenom" class="form-label">Prénom <span class="text-danger">*</span></label>
                        <input type="text" id="new_ref_prenom" wire:model.lazy="newReference.prenom" class="form-control form-control-sm @error('newReference.prenom') is-invalid @enderror" required>
                        @error('newReference.prenom') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="new_ref_nom" class="form-label">Nom <span class="text-danger">*</span></label>
                        <input type="text" id="new_ref_nom" wire:model.lazy="newReference.nom" class="form-control form-control-sm @error('newReference.nom') is-invalid @enderror" required>
                        @error('newReference.nom') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6 form-group">
                        <label for="new_ref_contact" class="form-label">Contact (Email/Tél) <span class="text-danger">*</span></label>
                        <input type="text" id="new_ref_contact" wire:model.lazy="newReference.contact" class="form-control form-control-sm @error('newReference.contact') is-invalid @enderror" required>
                        @error('newReference.contact') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                     <div class="col-md-6 form-group">
                        <label for="new_ref_poste" class="form-label">Poste</label>
                        <input type="text" id="new_ref_poste" wire:model.lazy="newReference.poste" class="form-control form-control-sm @error('newReference.poste') is-invalid @enderror">
                        @error('newReference.poste') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="form-group mb-3">
                     <label for="new_ref_relation" class="form-label">Relation</label>
                     <textarea id="new_ref_relation"
                               wire:model.lazy="newReference.relation"
                               class="form-control form-control-sm @error('newReference.relation') is-invalid @enderror"
                               rows="2"
                               maxlength="255"
                               placeholder="Ex: Superviseur de stage, Professeur, etc."></textarea>
                     @error('newReference.relation') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
                 </div>

                <div class="mt-3 text-end">
                    <button type="submit" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i> Ajouter Référence
                    </button>
                </div>
            </form>
        </div>
    @endif

    {{-- === LISTE DES RÉFÉRENCES EXISTANTES === --}}
    <div class="reference-list mt-4">
        @forelse ($references as $index => $reference)
            <div wire:key="reference-item-{{ $reference['id'] ?? $index }}"
                 class="form-repeater-item mb-3 {{ $editingIndex === $index ? 'editing-item' : 'reference-card' }}">

                 {{-- Message d'erreur spécifique à l'item --}}
                 @if(session()->has('reference_error_' . $index))
                    <div class="alert alert-danger alert-sm mb-3">{{ session('reference_error_' . $index) }}</div>
                 @endif

                @if($editingIndex === $index)
                    {{-- === FORMULAIRE D'ÉDITION === --}}
                    <div class="p-3 border rounded shadow-sm bg-light">
                        <h6 style="color: var(--primary-color, #007bff); margin-bottom: 1rem;">Modifier la référence</h6>
                        <form wire:submit.prevent="updateReference">
                             <div class="row mb-3">
                                <div class="col-md-6 form-group">
                                    <label for="edit_ref_prenom_{{ $index }}" class="form-label">Prénom <span class="text-danger">*</span></label>
                                    <input type="text" id="edit_ref_prenom_{{ $index }}" wire:model.lazy="editingReference.prenom" class="form-control form-control-sm @error('editingReference.prenom') is-invalid @enderror" required>
                                    @error('editingReference.prenom') <span class="invalid-feedback">{{ $message }}</span> @enderror
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="edit_ref_nom_{{ $index }}" class="form-label">Nom <span class="text-danger">*</span></label>
                                    <input type="text" id="edit_ref_nom_{{ $index }}" wire:model.lazy="editingReference.nom" class="form-control form-control-sm @error('editingReference.nom') is-invalid @enderror" required>
                                    @error('editingReference.nom') <span class="invalid-feedback">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6 form-group">
                                    <label for="edit_ref_contact_{{ $index }}" class="form-label">Contact (Email/Tél) <span class="text-danger">*</span></label>
                                    <input type="text" id="edit_ref_contact_{{ $index }}" wire:model.lazy="editingReference.contact" class="form-control form-control-sm @error('editingReference.contact') is-invalid @enderror" required>
                                    @error('editingReference.contact') <span class="invalid-feedback">{{ $message }}</span> @enderror
                                </div>
                                 <div class="col-md-6 form-group">
                                    <label for="edit_ref_poste_{{ $index }}" class="form-label">Poste</label>
                                    <input type="text" id="edit_ref_poste_{{ $index }}" wire:model.lazy="editingReference.poste" class="form-control form-control-sm @error('editingReference.poste') is-invalid @enderror">
                                    @error('editingReference.poste') <span class="invalid-feedback">{{ $message }}</span> @enderror
                                </div>
                            </div>
                             <div class="form-group mb-3">
                                 <label for="edit_ref_relation_{{ $index }}" class="form-label">Relation</label>
                                 <textarea id="edit_ref_relation_{{ $index }}"
                                           wire:model.lazy="editingReference.relation"
                                           class="form-control form-control-sm @error('editingReference.relation') is-invalid @enderror"
                                           rows="2"
                                           maxlength="255"></textarea>
                                 @error('editingReference.relation') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
                             </div>

                            {{-- Boutons Annuler / Enregistrer --}}
                            <div class="d-flex justify-content-end gap-2 mt-3">
                                <button type="button" wire:click="cancelEdit" class="btn btn-secondary btn-sm">Annuler</button>
                                <button type="submit" class="btn btn-primary btn-sm">
                                    <i class="fas fa-save"></i> Enregistrer
                                </button>
                            </div>
                        </form>
                    </div>
                @else
                    {{-- === AFFICHAGE SIMPLE === --}}
                    <div class="item-actions">
                        <button type="button" wire:click="edit({{ $index }})" class="btn-action-icon edit-item-btn" title="Modifier">
                            <i class="fas fa-pencil-alt"></i>
                        </button>
                        <button type="button" wire:click="removeReference({{ $index }})" wire:confirm="Êtes-vous sûr de vouloir supprimer cette référence ?" class="btn-action-icon delete-item-btn" title="Supprimer">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                    <div class="reference-card-body">
                         <p class="ref-name">{{ $reference['prenom'] }} {{ $reference['nom'] }}</p>
                         @if($reference['poste'])<p class="ref-poste">{{ $reference['poste'] }}</p>@endif
                         <p class="ref-contact">Contact: {{ $reference['contact'] }}</p>
                         @if($reference['relation'])<p class="ref-relation">Relation: {{ $reference['relation'] }}</p>@endif
                    </div>
                @endif
            </div>
        @empty
            @unless($showAddForm || $editingIndex !== null)
                <div class="empty-message">
                    Aucune référence ajoutée.
                </div>
            @endunless
        @endforelse
    </div>
</div>

{{-- Styles CSS --}}
<style>
    /* Styles généraux */
    .form-section { margin-bottom: 2rem; }
    .form-section-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; padding-bottom: 0.75rem; border-bottom: 1px solid #dee2e6; }
    .form-section-header h4 { margin: 0; color: #343a40; }
    .add-item-btn span { margin-left: 0.3rem; }

    /* Formulaire ajout/édition */
    .reference-add-form,
    .editing-item .p-3 {
        background-color: #f8f9fa;
    }
    .form-label { font-size: 0.875rem; margin-bottom: 0.25rem; }
    .form-control-sm { font-size: 0.875rem; }
    .text-danger { color: #dc3545 !important; }

    /* Liste des références */
    .reference-list {
        display: grid;
        grid-template-columns: 1fr; /* Une colonne */
        gap: 1rem;
    }

    /* Item référence (carte) */
    .form-repeater-item {
        border: 1px solid #e9ecef;
        border-radius: 0.375rem;
        position: relative; /* Pour les actions */
        background-color: #fff;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        transition: box-shadow 0.2s ease-in-out;
        padding: 1rem 1.25rem; /* Padding interne */
    }
    .reference-card:hover {
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
    }
     .reference-card:hover .item-actions,
     .reference-card:focus-within .item-actions {
         opacity: 1;
     }

    /* Conteneur du formulaire d'édition */
    .editing-item {
        /* Pas de padding direct, le .p-3 interne le gère */
         padding: 0; /* Override padding */
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
    .reference-card-body {
         padding-right: 50px; /* Espace pour boutons */
    }
    .ref-name { font-weight: 600; color: var(--secondary-color, #6c757d); margin-bottom: 0.1rem; }
    .ref-poste { font-size: 0.9em; color: var(--primary-color, #0056b3); margin-bottom: 0.1rem; }
    .ref-contact { font-size: 0.9em; color: var(--dark-gray, #343a40); margin-bottom: 0.3rem; }
    .ref-relation { font-size: 0.85em; color: #555; margin-bottom: 0; font-style: italic; }

    /* Message vide */
    .empty-message {
        text-align: center;
        color: var(--dark-gray, #6c757d);
        padding: 1rem;
        border: 1px dashed var(--border-light, #ced4da) !important;
        border-radius: 4px;
        margin-top: 1rem;
    }

    /* Responsive */
    @media (max-width: 767.98px) {
        .form-repeater-item {
             padding: 0.75rem 1rem;
        }
        .ref-name { font-size: 1rem; }
        .ref-poste, .ref-contact { font-size: 0.85em; }
        .ref-relation { font-size: 0.8em; }
         .form-section-header {
             flex-direction: column;
             align-items: flex-start;
             gap: 0.5rem;
         }
         /* Empiler form ajout/edition */
         .reference-add-form .col-md-6,
         .editing-item .col-md-6 {
            flex: 0 0 100%;
            max-width: 100%;
         }
          .reference-add-form .row > div:not(:last-child),
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
        --border-light: #dee2e6; /* Ajout variable */
    }
</style> 