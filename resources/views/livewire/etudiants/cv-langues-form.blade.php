<div class="form-section">
    <div class="form-section-header">
        <h4>Langues</h4>
        <button type="button" wire:click="toggleAddForm" class="add-item-btn">
            <i class="fas {{ $showAddForm ? 'fa-times' : 'fa-plus' }}"></i>
            {{ $showAddForm ? 'Fermer' : 'Ajouter' }}
        </button>
    </div>

    @if(session()->has('langue_message'))
        <div class="alert alert-success">{{ session('langue_message') }}</div>
    @endif

    {{-- === FORMULAIRE D'AJOUT (Conditionnel) === --}}
    @if($showAddForm)
        <div class="form-repeater-item" style="border-top: 2px solid var(--primary-color); padding-top:1.5rem;">
            <h5 style="margin-bottom: 1rem; color: var(--primary-color);">Ajouter une nouvelle langue</h5>
            <form wire:submit.prevent="addLangue">
                <div class="row">
                       <div class="col form-group">
                           <label for="new_lang_nom" class="form-label">Langue <span style="color:red">*</span></label>
                           <input type="text" id="new_lang_nom" wire:model.lazy="newLangue.langue" class="form-control @error('newLangue.langue') is-invalid @enderror" required>
                           @error('newLangue.langue') <span class="invalid-feedback">{{ $message }}</span> @enderror
                       </div>
                       <div class="col form-group">
                            <label for="new_lang_niveau" class="form-label">Niveau <span style="color:red">*</span></label>
                            <select id="new_lang_niveau" wire:model.lazy="newLangue.niveau" class="form-control @error('newLangue.niveau') is-invalid @enderror" required>
                                 <option value="">-- Choisir --</option>
                                 @foreach($niveauOptions as $value => $label)
                                     <option value="{{ $value }}">{{ $label }}</option>
                                 @endforeach
                           </select>
                            @error('newLangue.niveau') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>
                   </div>
                <div class="mt-3 text-right">
                    <button type="submit" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i> Ajouter
                    </button>
                </div>
            </form>
        </div>
    @endif

    {{-- === LISTE DES ITEMS EXISTANTS === --}}
    @forelse ($langues as $index => $langue)
        <div class="form-repeater-item mb-3" wire:key="langue-item-{{ $langue['id'] ?? $index }}">
             @if($editingIndex === $index)
                 {{-- === FORMULAIRE D'ÉDITION === --}}
                 <h6 style="color: var(--primary-color); margin-bottom: 1rem;">Modifier la langue</h6>
                 <form wire:submit.prevent="updateLangue">
                      <div class="row">
                         <div class="col form-group">
                             <label for="edit_lang_nom_{{ $index }}" class="form-label">Langue <span style="color:red">*</span></label>
                             <input type="text" id="edit_lang_nom_{{ $index }}" wire:model.lazy="editingLangue.langue" class="form-control @error('editingLangue.langue') is-invalid @enderror" required>
                             @error('editingLangue.langue') <span class="invalid-feedback">{{ $message }}</span> @enderror
                         </div>
                         <div class="col form-group">
                              <label for="edit_lang_niveau_{{ $index }}" class="form-label">Niveau <span style="color:red">*</span></label>
                              <select id="edit_lang_niveau_{{ $index }}" wire:model.lazy="editingLangue.niveau" class="form-control @error('editingLangue.niveau') is-invalid @enderror" required>
                                    <option value="">-- Choisir --</option>
                                    @foreach($niveauOptions as $value => $label)
                                        <option value="{{ $value }}">{{ $label }}</option>
                                    @endforeach
                              </select>
                              @error('editingLangue.niveau') <span class="invalid-feedback">{{ $message }}</span> @enderror
                          </div>
                      </div>
                    <div class="item-actions" style="position: static; margin-top: 1rem; justify-content: flex-end;">
                        <button type="button" wire:click="cancelEdit" class="btn btn-secondary btn-sm">Annuler</button>
                        <button type="submit" class="btn btn-primary btn-sm">
                            <i class="fas fa-save"></i> Enregistrer
                        </button>
                    </div>
                </form>
             @else
                 {{-- === AFFICHAGE "CARTE" === --}}
                 <div class="item-actions">
                     <button type="button" wire:click="edit({{ $index }})" class="edit-item-btn" title="Modifier" style="color:var(--primary-color); font-size: 1.1em;">
                         <i class="fas fa-pencil-alt"></i>
                     </button>
                     <button type="button" wire:click="removeLangue({{ $index }})" wire:confirm="Êtes-vous sûr de vouloir supprimer cette langue ?" class="delete-item-btn" title="Supprimer">
                        <i class="fas fa-trash"></i>
                     </button>
                 </div>
                 <div class="d-flex justify-content-between align-items-center">
                    <span style="font-weight: 500;">{{ $langue['langue'] }}</span>
                    <span style="font-size: 0.9em; color: var(--dark-gray); background-color: #eee; padding: 2px 8px; border-radius: 10px;">{{ $langue['niveau'] }}</span>
                 </div>
             @endif
        </div>
    @empty

        @unless($showAddForm || $editingIndex !== null)
            <div style="text-align: center; color: var(--dark-gray); padding: 1rem; border: 1px dashed !important; grid-column: 1 / -1; border-radius: 4px;"> Aucune langue ajoutée. </div>
        @endunless
    @endforelse
</div>