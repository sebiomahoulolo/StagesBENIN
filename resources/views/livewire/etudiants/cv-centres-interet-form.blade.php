<div class="form-section">
    <div class="form-section-header">
        <h4>Centres d'Intérêt</h4>
         <button type="button" wire:click="toggleAddForm" class="add-item-btn">
            <i class="fas {{ $showAddForm ? 'fa-times' : 'fa-plus' }}"></i>
            {{ $showAddForm ? 'Ajout' : 'Ajouter' }}
        </button>
    </div>

    @if(session()->has('interet_message'))
        <div class="alert alert-success">{{ session('interet_message') }}</div>
    @endif

    {{-- === FORMULAIRE D'AJOUT (Conditionnel) === --}}
    @if($showAddForm)
        <div class="form-repeater-item" style="border-top: 2px solid var(--primary-color); padding-top:1.5rem;">
            <h5 style="margin-bottom: 1rem; color: var(--primary-color);">Ajouter un nouveau centre d'intérêt</h5>
            <form wire:submit.prevent="addInteret">
                 <div class="form-group mb-0">
                       <label for="new_interet_nom" class="form-label sr-only">Intérêt <span style="color:red">*</span></label>
                       <input type="text" id="new_interet_nom" wire:model.lazy="newInteret.nom" class="form-control @error('newInteret.nom') is-invalid @enderror" placeholder="Nom de l'intérêt..." required>
                       @error('newInteret.nom') <span class="invalid-feedback">{{ $message }}</span> @enderror
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
    @forelse ($centresInteret as $index => $interet)
        <div class="form-repeater-item mb-3" wire:key="interet-item-{{ $interet['id'] ?? $index }}">
             @if($editingIndex === $index)
                 {{-- === FORMULAIRE D'ÉDITION === --}}
                 <h6 style="color: var(--primary-color); margin-bottom: 1rem;">Modifier l'intérêt</h6>
                 <form wire:submit.prevent="updateInteret">
                     <div class="form-group mb-0">
                         <label for="edit_interet_nom_{{ $index }}" class="form-label sr-only">Intérêt</label>
                         <input type="text" id="edit_interet_nom_{{ $index }}" wire:model.lazy="editingInteret.nom" class="form-control @error('editingInteret.nom') is-invalid @enderror" required>
                          @error('editingInteret.nom') <span class="invalid-feedback">{{ $message }}</span> @enderror
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
                     <button type="button" wire:click="removeInteret({{ $index }})" wire:confirm="Êtes-vous sûr de vouloir supprimer cet intérêt ?" class="delete-item-btn" title="Supprimer">
                        <i class="fas fa-trash"></i>
                     </button>
                 </div>
                 <span style="background-color: #e8f4fc; padding: 5px 12px; border-radius: 15px; font-size: 0.9em; color: var(--primary-color); display: inline-block;">
                    {{ $interet['nom'] }}
                 </span>
             @endif
        </div>
    @empty
        
        @unless($showAddForm || $editingIndex !== null)
            <div style="text-align: center; color: var(--dark-gray); padding: 1rem; border: 1px dashed !important; grid-column: 1 / -1; border-radius: 4px;"> Aucun centre d'intérêt ajouté. </div>
        @endunless

        
    @endforelse
</div>