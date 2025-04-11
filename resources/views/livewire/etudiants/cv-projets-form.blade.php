<div class="form-section">
    <div class="form-section-header">
        <h4>Projets Personnels</h4>
         <button type="button" wire:click="toggleAddForm" class="add-item-btn">
            <i class="fas {{ $showAddForm ? 'fa-times' : 'fa-plus' }}"></i>
            {{ $showAddForm ? 'Fermer' : 'Ajouter' }}
        </button>
    </div>

    @if(session()->has('projet_message'))
        <div class="alert alert-success">{{ session('projet_message') }}</div>
    @endif

    {{-- === FORMULAIRE D'AJOUT (Conditionnel) === --}}
    @if($showAddForm)
        <div class="form-repeater-item" style="border-top: 2px solid var(--primary-color); padding-top:1.5rem;">
            <h5 style="margin-bottom: 1rem; color: var(--primary-color);">Ajouter un nouveau projet</h5>
            <form wire:submit.prevent="addProjet">
                  <div class="row">
                       <div class="col form-group">
                           <label for="new_proj_nom" class="form-label">Nom Projet <span style="color:red">*</span></label>
                           <input type="text" id="new_proj_nom" wire:model.lazy="newProjet.nom" class="form-control @error('newProjet.nom') is-invalid @enderror" required>
                           @error('newProjet.nom') <span class="invalid-feedback">{{ $message }}</span> @enderror
                       </div>
                       <div class="col form-group">
                            <label for="new_proj_url" class="form-label">URL Projet</label>
                            <input type="url" id="new_proj_url" wire:model.lazy="newProjet.url_projet" class="form-control @error('newProjet.url_projet') is-invalid @enderror" placeholder="http://...">
                            @error('newProjet.url_projet') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>
                   </div>
                    {{-- Trix Description (Nouveau Projet) --}}
                   <div class="form-group" wire:ignore x-data="trixResetter('newProjet.description')">
                       <label for="new_proj_desc" class="form-label">Description</label>
                       <input id="newProjet.description" type="hidden" x-ref="trixInput" data-livewire-model="newProjet.description">
                       <trix-editor input="newProjet.description" x-ref="trixEditor"
                                   class="form-control trix-content @error('newProjet.description') is-invalid @enderror"></trix-editor>
                   </div>
                   @error('newProjet.description') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror

                   <div class="form-group">
                       <label for="new_proj_tech" class="form-label">Technologies utilisées</label>
                       <input type="text" id="new_proj_tech" wire:model.lazy="newProjet.technologies" class="form-control @error('newProjet.technologies') is-invalid @enderror" placeholder="Ex: Laravel, Vue.js, MySQL">
                       @error('newProjet.technologies') <span class="invalid-feedback">{{ $message }}</span> @enderror
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
    @forelse ($projets as $index => $projet)
        <div class="form-repeater-item mb-3" wire:key="projet-item-{{ $projet['id'] ?? $index }}">
             @if($editingIndex === $index)
                 {{-- === FORMULAIRE D'ÉDITION === --}}
                 <h6 style="color: var(--primary-color); margin-bottom: 1rem;">Modifier le projet</h6>
                 <form wire:submit.prevent="updateProjet">
                     <div class="row">
                         <div class="col form-group">
                             <label for="edit_proj_nom_{{ $index }}" class="form-label">Nom Projet <span style="color:red">*</span></label>
                             <input type="text" id="edit_proj_nom_{{ $index }}" wire:model.lazy="editingProjet.nom" class="form-control @error('editingProjet.nom') is-invalid @enderror" required>
                             @error('editingProjet.nom') <span class="invalid-feedback">{{ $message }}</span> @enderror
                         </div>
                         <div class="col form-group">
                              <label for="edit_proj_url_{{ $index }}" class="form-label">URL Projet</label>
                              <input type="url" id="edit_proj_url_{{ $index }}" wire:model.lazy="editingProjet.url_projet" class="form-control @error('editingProjet.url_projet') is-invalid @enderror" placeholder="http://...">
                              @error('editingProjet.url_projet') <span class="invalid-feedback">{{ $message }}</span> @enderror
                          </div>
                     </div>
                     {{-- Trix Description (Édition) --}}
                     <div class="form-group" wire:ignore>
                         <label for="edit_proj_desc_{{ $index }}" class="form-label">Description</label>
                         <input id="editingProjet.description" type="hidden" value="{{ $editingProjet['description'] ?? '' }}" data-livewire-model="editingProjet.description">
                          <trix-editor input="editingProjet.description"
                                     class="form-control trix-content @error('editingProjet.description') is-invalid @enderror"></trix-editor>
                     </div>
                     @error('editingProjet.description') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror

                     <div class="form-group">
                         <label for="edit_proj_tech_{{ $index }}" class="form-label">Technologies utilisées</label>
                         <input type="text" id="edit_proj_tech_{{ $index }}" wire:model.lazy="editingProjet.technologies" class="form-control @error('editingProjet.technologies') is-invalid @enderror" placeholder="Ex: Laravel, Vue.js, MySQL">
                         @error('editingProjet.technologies') <span class="invalid-feedback">{{ $message }}</span> @enderror
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
                     <button type="button" wire:click="removeProjet({{ $index }})" wire:confirm="Êtes-vous sûr de vouloir supprimer ce projet ?" class="delete-item-btn" title="Supprimer">
                        <i class="fas fa-trash"></i>
                     </button>
                 </div>
                 <p style="font-weight: 600; color: var(--secondary-color); margin-bottom: 0.2rem;">{{ $projet['nom'] }}</p>
                 @if($projet['url_projet'])
                     <p style="font-size: 0.9em; color: var(--dark-gray); margin-bottom: 0.5rem;">
                         <a href="{{ $projet['url_projet'] }}" target="_blank" rel="noopener noreferrer" style="color: var(--dark-gray); text-decoration: underline;">
                              <i class="fas fa-link fa-sm"></i> {{ \Illuminate\Support\Str::limit(str_replace(['https://', 'http://'], '', $projet['url_projet']), 40) }}
                         </a>
                     </p>
                  @endif
                 @if(!empty($projet['description']))
                     <div class="description-display" style="font-size: 0.9em; color: #555; margin-top: 5px; margin-bottom: 5px; ">
                        {!! \Illuminate\Support\Str::limit(strip_tags($projet['description']), 150) !!}
                     </div>
                 @endif
                 @if(!empty($projet['technologies']))
                      <p style="font-size: 0.85em; color: var(--primary-color); margin-top: 5px; font-style: italic;">Tech: {{ $projet['technologies'] }}</p>
                  @endif
             @endif
        </div>
    @empty
       

        @unless($showAddForm || $editingIndex !== null)
            <div style="text-align: center; color: var(--dark-gray); padding: 1rem; border: 1px dashed !important; grid-column: 1 / -1; border-radius: 4px;"> Aucun projet ajouté. </div>
        @endunless
    @endforelse
</div>