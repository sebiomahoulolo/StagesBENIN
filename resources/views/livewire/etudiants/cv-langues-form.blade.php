<div class="form-section">
    <div class="form-section-header">
        <h4>Langues</h4>
        <button type="button" wire:click="toggleAddForm" class="add-item-btn btn btn-sm {{ $showAddForm ? 'btn-secondary' : 'btn-primary' }}">
            <i class="fas {{ $showAddForm ? 'fa-times' : 'fa-plus' }}"></i>
            <span>{{ $showAddForm ? 'Fermer' : 'Ajouter' }}</span>
        </button>
    </div>

    @if(session()->has('langue_message'))
        <div class="alert alert-success mt-3" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)">{{ session('langue_message') }}</div>
    @endif
    @if(session()->has('langue_error'))
        <div class="alert alert-danger mt-3">{{ session('langue_error') }}</div>
    @endif

    @if($showAddForm)
        <div class="langue-add-form">
            <h5 style="margin-bottom: 1.5rem; color: var(--primary-color, #007bff);">Ajouter une nouvelle langue</h5>
            <form wire:submit.prevent="addLangue">
                <div class="row mb-3">
                       <div class="col-md-6 form-group">
                           <label for="new_lang_nom" class="form-label">Langue <span class="text-danger">*</span></label>
                           <input type="text" id="new_lang_nom" wire:model.lazy="newLangue.langue" class="form-control form-control-sm @error('newLangue.langue') is-invalid @enderror" required>
                           @error('newLangue.langue') <span class="invalid-feedback">{{ $message }}</span> @enderror
                       </div>
                       <div class="col-md-6 form-group">
                            <label for="new_lang_niveau" class="form-label">Niveau <span class="text-danger">*</span></label>
                            <select id="new_lang_niveau" wire:model.lazy="newLangue.niveau" class="form-control form-control-sm @error('newLangue.niveau') is-invalid @enderror" required>
                                 <option value="">-- Choisir --</option>
                                 @foreach($niveauOptions as $value => $label)
                                     <option value="{{ $value }}">{{ $label }}</option>
                                 @endforeach
                           </select>
                            @error('newLangue.niveau') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>
                   </div>
                <div class="mt-3 text-end">
                    <button type="submit" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i> Ajouter Langue
                    </button>
                </div>
            </form>
        </div>
    @endif

    <div class="langue-grid mt-4">
        @forelse ($langues as $index => $langue)
             <div wire:key="langue-item-{{ $langue['id'] ?? $index }}"
                  class="{{ $editingIndex === $index ? 'langue-editing-item' : 'langue-card' }}">

                  @if(session()->has('langue_error_' . $index))
                    <div class="alert alert-danger alert-sm mb-3">{{ session('langue_error_' . $index) }}</div>
                  @endif

                 @if($editingIndex === $index)
                     <h6 style="color: var(--primary-color, #007bff); margin-bottom: 1.5rem;">Modifier la langue</h6>
                     <form wire:submit.prevent="updateLangue">
                          <div class="row mb-3">
                             <div class="col-md-6 form-group">
                                 <label for="edit_lang_nom_{{ $index }}" class="form-label">Langue <span class="text-danger">*</span></label>
                                 <input type="text" id="edit_lang_nom_{{ $index }}" wire:model.lazy="editingLangue.langue" class="form-control form-control-sm @error('editingLangue.langue') is-invalid @enderror" required>
                                 @error('editingLangue.langue') <span class="invalid-feedback">{{ $message }}</span> @enderror
                             </div>
                             <div class="col-md-6 form-group">
                                  <label for="edit_lang_niveau_{{ $index }}" class="form-label">Niveau <span class="text-danger">*</span></label>
                                  <select id="edit_lang_niveau_{{ $index }}" wire:model.lazy="editingLangue.niveau" class="form-control form-control-sm @error('editingLangue.niveau') is-invalid @enderror" required>
                                        <option value="">-- Choisir --</option>
                                        @foreach($niveauOptions as $value => $label)
                                            <option value="{{ $value }}" @if($editingLangue['niveau'] == $value) selected @endif>{{ $label }}</option>
                                        @endforeach
                                  </select>
                                  @error('editingLangue.niveau') <span class="invalid-feedback">{{ $message }}</span> @enderror
                              </div>
                          </div>
                        <div class="d-flex justify-content-end gap-2 mt-3">
                            <button type="button" wire:click="cancelEdit" class="btn btn-secondary btn-sm">Annuler</button>
                            <button type="submit" class="btn btn-primary btn-sm">
                                <i class="fas fa-save"></i> Enregistrer
                            </button>
                        </div>
                    </form>
                 @else
                     <div class="item-actions">
                         <i class="fas fa-pencil-alt edit-item-btn"
                            wire:click="edit({{ $index }})"
                            title="Modifier" aria-label="Modifier la langue"
                            style="cursor: pointer;"></i>
                         <i class="fas fa-trash delete-item-btn"
                            wire:click="removeLangue({{ $index }})"
                            wire:confirm="Êtes-vous sûr de vouloir supprimer cette langue ?"
                            title="Supprimer" aria-label="Supprimer la langue"
                            style="cursor: pointer;"></i>
                     </div>
                     <div class="langue-card-body">
                        <span class="langue-name">{{ $langue['langue'] }}</span>
                        <span class="langue-level">{{ $langue['niveau'] }}</span>
                     </div>
                 @endif
            </div>
        @empty
             @unless($showAddForm || $editingIndex !== null)
                <div class="langue-grid-empty"> Aucune langue ajoutée. </div>
             @endunless
        @endforelse
    </div>
</div>

<style>
    .form-section { margin-bottom: 2rem; }
    .form-section-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; padding-bottom: 0.75rem; border-bottom: 1px solid #dee2e6; }
    .form-section-header h4 { margin: 0; color: #343a40; }
    .add-item-btn span { margin-left: 0.3rem; }

    .langue-add-form {
        margin-top: 1.5rem;
        padding: 1.5rem;
        border: 1px solid #dee2e6;
        border-radius: 0.375rem;
        background-color: #f8f9fa;
    }

    .langue-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 1rem;
    }

    .langue-card {
        background-color: #fff;
        border: 1px solid #e9ecef;
        border-radius: 0.375rem;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        padding: 1rem;
        position: relative;
        transition: box-shadow 0.2s ease-in-out;
        display: flex;
        flex-direction: column;
    }
    .langue-card:hover {
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
    }
    .langue-card:hover .item-actions,
    .langue-card:focus-within .item-actions {
         opacity: 1;
     }

    .langue-card-body {
        flex-grow: 1;
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        padding-top: 5px;
    }
    .langue-name {
        font-weight: 600;
        color: var(--secondary-color, #343a40);
        margin-bottom: 0.3rem;
        overflow-wrap: break-word;
        word-break: break-word;
    }
    .langue-level {
        font-size: 0.85em;
        color: var(--dark-gray, #343a40);
        background-color: #e9ecef;
        padding: 2px 8px;
        border-radius: 4px;
        white-space: nowrap;
    }

    .langue-card .item-actions {
        position: absolute;
        top: 0.5rem;
        right: 0.5rem;
        display: flex;
        gap: 0.6rem;
        opacity: 0;
        transition: opacity 0.2s ease-in-out;
        z-index: 5;
        background-color: rgba(255, 255, 255, 0.7);
        padding: 3px 5px;
        border-radius: 4px;
    }
    .langue-card .item-actions .edit-item-btn,
    .langue-card .item-actions .delete-item-btn {
       font-size: 0.9rem;
       padding: 0;
       background: none;
       border: none;
       line-height: 1;
       cursor: pointer;
    }
    .langue-card .item-actions .edit-item-btn { color: var(--bs-primary, #0d6efd); }
    .langue-card .item-actions .delete-item-btn { color: var(--bs-danger, #dc3545); }
    .langue-card .item-actions .edit-item-btn:hover,
    .langue-card .item-actions .delete-item-btn:hover {
        opacity: 0.7;
    }

    .langue-editing-item {
        grid-column: 1 / -1;
        margin-bottom: 1.5rem;
        padding: 1.5rem;
        border: 1px solid #dee2e6;
        border-radius: 0.375rem;
        background-color: #f8f9fa;
    }
    .langue-editing-item h6 {
         color: var(--primary-color, #007bff);
         margin-bottom: 1.5rem;
    }

    .langue-grid-empty {
        text-align: center;
        color: var(--dark-gray, #6c757d);
        padding: 1.5rem;
        border: 1px dashed #ced4da !important;
        grid-column: 1 / -1;
        border-radius: 4px;
        margin-top: 1rem;
    }

    .langue-add-form .form-label,
    .langue-editing-item .form-label {
        font-size: 0.875rem;
        margin-bottom: 0.25rem;
    }
    .langue-add-form .form-control-sm,
    .langue-editing-item .form-control-sm {
       font-size: 0.875rem;
    }
    .text-danger { color: #dc3545 !important; }

    @media (max-width: 991.98px) {
        .langue-add-form .col-md-6,
        .langue-editing-item .col-md-6 {
            flex: 0 0 100%;
            max-width: 100%;
        }
         .langue-add-form .row > .col-md-6:not(:last-child),
         .langue-editing-item .row > .col-md-6:not(:last-child){
             margin-bottom: 1rem;
         }
    }
    @media (max-width: 767.98px) {
        .langue-grid {
            gap: 0.75rem;
        }
        .langue-grid {
            grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
        }
        .form-section-header {
             flex-direction: column;
             align-items: flex-start;
             gap: 0.5rem;
        }
    }
     @media (max-width: 575.98px) {
         .langue-grid {
             grid-template-columns: 1fr;
         }
          .langue-card .item-actions {
              /* Ajustements si nécessaire pour une seule colonne */
         }
     }

    :root {
        --primary-color: #0d6efd;
        --secondary-color: #6c757d;
        --dark-gray: #343a40;
        --bs-primary: #0d6efd;
        --bs-danger: #dc3545;
    }
</style>