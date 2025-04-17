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
                               placeholder="Ex: Superviseur de stage, Professeur, etc.">
                     </textarea>
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
                 class="form-repeater-item mb-3 {{ $editingIndex === $index ? 'editing-item p-3 border rounded shadow-sm bg-light' : '' }}">

                 {{-- Message d'erreur spécifique à l'item --}}
                 @if(session()->has('reference_error_' . $index))
                    <div class="alert alert-danger alert-sm mb-3">{{ session('reference_error_' . $index) }}</div>
                 @endif

                @if($editingIndex === $index)
                    {{-- === FORMULAIRE D'ÉDITION === --}}
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
                @else
                    {{-- === AFFICHAGE SIMPLE === --}}
                    <div class="item-actions">
                        <button type="button" wire:click="edit({{ $index }})" class="edit-item-btn" title="Modifier" style="color:var(--primary-color); font-size: 1.1em;">
                            <i class="fas fa-pencil-alt"></i>
                        </button>
                        <button type="button" wire:click="removeReference({{ $index }})" wire:confirm="Êtes-vous sûr de vouloir supprimer cette référence ?" class="delete-item-btn" title="Supprimer">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                             <p style="font-weight: 600; color: var(--secondary-color); margin-bottom: 0.1rem;">{{ $reference['prenom'] }} {{ $reference['nom'] }}</p>
                             @if($reference['poste'])<p style="font-size: 0.9em; color: var(--primary-color); margin-bottom: 0.1rem;">{{ $reference['poste'] }}</p>@endif
                             <p style="font-size: 0.9em; color: var(--dark-gray); margin-bottom: 0.3rem;">Contact: {{ $reference['contact'] }}</p>
                             @if($reference['relation'])<p style="font-size: 0.85em; color: #555; margin-bottom: 0; font-style: italic;">Relation: {{ $reference['relation'] }}</p>@endif
                        </div>
                    </div>
                @endif
            </div>
        @empty
            @unless($showAddForm || $editingIndex !== null)
                <div style="text-align: center; color: var(--dark-gray); padding: 1rem; border: 1px dashed var(--border-light); border-radius: 4px;">
                    Aucune référence ajoutée.
                </div>
            @endunless
        @endforelse
    </div>
</div>

{{-- Styles CSS (optionnel, peut être dans un fichier CSS global) --}}
<style>
    .form-repeater-item {
        padding: 1rem;
        border: 1px solid var(--border-light, #dee2e6);
        border-radius: 0.375rem;
        position: relative; /* Pour les boutons d'action */
        background-color: #fff;
    }
    .form-repeater-item:not(:last-child) {
        margin-bottom: 1rem;
    }
    .editing-item {
        border-color: var(--primary-color, #0d6efd); /* Met en évidence l'item en édition */
    }
    .item-actions {
        position: absolute;
        top: 0.75rem;
        right: 0.75rem;
        display: flex;
        gap: 0.5rem;
        opacity: 0; /* Caché par défaut */
        transition: opacity 0.2s ease-in-out;
    }
    .form-repeater-item:hover .item-actions {
        opacity: 1; /* Visible au survol */
    }
    .item-actions button {
        background: none;
        border: none;
        cursor: pointer;
        padding: 0.2rem;
        color: var(--gray, #6c757d);
        font-size: 0.9em;
    }
    .item-actions button.edit-item-btn { color: var(--primary-color, #0d6efd); }
    .item-actions button.delete-item-btn { color: var(--danger, #dc3545); }
    .item-actions button:hover { opacity: 0.7; }
</style> 