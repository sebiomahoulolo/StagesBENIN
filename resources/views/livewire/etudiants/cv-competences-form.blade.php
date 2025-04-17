<div class="form-section">
    <div class="form-section-header">
        <h4>Compétences</h4>
        <button type="button" wire:click="toggleAddForm" class="add-item-btn btn btn-sm {{ $showAddForm ? 'btn-secondary' : 'btn-primary' }}">
            <i class="fas {{ $showAddForm ? 'fa-times' : 'fa-plus' }}"></i>
            <span>{{ $showAddForm ? 'Fermer' : 'Ajouter' }}</span>
        </button>
    </div>

    @if(session()->has('competence_message'))
        <div class="alert alert-success">{{ session('competence_message') }}</div>
    @endif

    {{-- === FORMULAIRE D'AJOUT (Conditionnel) === --}}
    @if($showAddForm)
        <div class="form-repeater-item" style="border-top: 2px solid var(--primary-color); padding-top:1.5rem;">
            <h5 style="margin-bottom: 1rem; color: var(--primary-color);">Ajouter une nouvelle compétence</h5>
            <form wire:submit.prevent="addCompetence">
                 <div class="row align-items-end">
                       <div class="col form-group mb-0">
                           <label for="new_comp_cat" class="form-label">Catégorie <span style="color:red">*</span></label>
                           <input type="text" list="categories_list_all" id="new_comp_cat" wire:model.lazy="newCompetence.categorie" class="form-control @error('newCompetence.categorie') is-invalid @enderror" required>
                           @error('newCompetence.categorie') <span class="invalid-feedback">{{ $message }}</span> @enderror
                       </div>
                       <div class="col form-group mb-0">
                            <label for="new_comp_nom" class="form-label">Compétence <span style="color:red">*</span></label>
                            <input type="text" id="new_comp_nom" wire:model.lazy="newCompetence.nom" class="form-control @error('newCompetence.nom') is-invalid @enderror" required>
                            @error('newCompetence.nom') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>
                        <div class="col form-group mb-0" style="flex: 0 0 200px;">
                            <label for="new_comp_niveau" class="form-label">Niveau (%) <span style="color:red">*</span></label>
                             <div class="d-flex align-items-center">
                                 <input type="range" id="new_comp_niveau_range" wire:model.live="newCompetence.niveau" class="form-control" min="0" max="100" step="5" style="padding: 0; height: 10px; flex-grow: 1; margin-right: 10px;">
                                 <input type="number" id="new_comp_niveau" wire:model.live="newCompetence.niveau" class="form-control @error('newCompetence.niveau') is-invalid @enderror" min="0" max="100" step="5" required style="width: 70px; text-align: center;">
                             </div>
                             @error('newCompetence.niveau') <span class="invalid-feedback">{{ $message }}</span> @enderror
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

     {{-- Datalist pour les catégories (remplie depuis le composant) --}}
    <datalist id="categories_list_all">
        @foreach ($categories ?? [] as $cat)
            <option value="{{ $cat }}">
        @endforeach
    </datalist>

    {{-- === LISTE DES ITEMS EXISTANTS === --}}
    <div class="row mt-4">
        @forelse ($competences as $index => $competence)
            @php
                $columnClass = ($editingIndex === $index) ? 'col-12' : 'col-md-4';
            @endphp

            <div class="{{ $columnClass }} mb-3" wire:key="competence-item-{{ $competence['id'] ?? $index }}">
                <div class="form-repeater-item h-100 {{ $editingIndex === $index ? 'p-3 border rounded bg-light shadow-sm' : '' }}">
                     @if($editingIndex === $index)
                         {{-- === FORMULAIRE D'ÉDITION (Full Width) === --}}
                         <h6 style="color: var(--primary-color); margin-bottom: 1rem;">Modifier la compétence</h6>
                         <form wire:submit.prevent="updateCompetence">
                             <div class="row align-items-end">
                                 <div class="col form-group mb-0">
                                     <label for="edit_comp_cat_{{ $index }}" class="form-label">Catégorie <span style="color:red">*</span></label>
                                     <input type="text" list="categories_list_all" id="edit_comp_cat_{{ $index }}" wire:model.lazy="editingCompetence.categorie" class="form-control @error('editingCompetence.categorie') is-invalid @enderror" required>
                                      @error('editingCompetence.categorie') <span class="invalid-feedback">{{ $message }}</span> @enderror
                                 </div>
                                 <div class="col form-group mb-0">
                                      <label for="edit_comp_nom_{{ $index }}" class="form-label">Compétence <span style="color:red">*</span></label>
                                      <input type="text" id="edit_comp_nom_{{ $index }}" wire:model.lazy="editingCompetence.nom" class="form-control @error('editingCompetence.nom') is-invalid @enderror" required>
                                       @error('editingCompetence.nom') <span class="invalid-feedback">{{ $message }}</span> @enderror
                                  </div>
                                  <div class="col form-group mb-0" style="flex: 0 0 200px;">
                                      <label for="edit_comp_niveau_{{ $index }}" class="form-label">Niveau (%) <span style="color:red">*</span></label>
                                      <div class="d-flex align-items-center">
                                           <input type="range" id="edit_comp_niveau_{{ $index }}_range" wire:model.live="editingCompetence.niveau" class="form-control" min="0" max="100" step="5" style="padding: 0; height: 10px; flex-grow: 1; margin-right: 10px;">
                                           <input type="number" id="edit_comp_niveau_{{ $index }}" wire:model.live="editingCompetence.niveau" class="form-control @error('editingCompetence.niveau') is-invalid @enderror" min="0" max="100" step="5" required style="width: 70px; text-align: center;">
                                      </div>
                                       @error('editingCompetence.niveau') <span class="invalid-feedback">{{ $message }}</span> @enderror
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
                         {{-- === AFFICHAGE "CARTE" (Inside col-md-4) === --}}
                         <div class="item-actions">
                             <button type="button" wire:click="edit({{ $index }})" class="edit-item-btn" title="Modifier" style="color:var(--primary-color); font-size: 1.1em;">
                                 <i class="fas fa-pencil-alt"></i>
                             </button>
                             <button type="button" wire:click="removeCompetence({{ $index }})" wire:confirm="Êtes-vous sûr de vouloir supprimer cette compétence ?" class="delete-item-btn" title="Supprimer">
                                <i class="fas fa-trash"></i>
                             </button>
                         </div>
                         {{-- Nouvelle structure d'affichage --}}
                         <div class="skill-item">
                            <span style="font-size: 0.8em; color: var(--dark-gray); display:block; margin-bottom: 0.25rem;">{{ $competence['categorie'] }}</span>
                            <div class="skill-info mb-1" style="display: flex; justify-content: space-between; align-items: baseline;">
                                <span class="skill-name" style="font-weight: 500; color: #333d49;">{{ $competence['nom'] }}</span>
                                <span class="skill-level" style="font-size: 0.8em; color: var(--dark-gray);">{{ $competence['niveau'] }}%</span>
                            </div>
                            {{-- DEBUG: Afficher la valeur exacte de niveau --}}
                            {{-- <span style="font-size: 7pt; color: red;">[Debug Niveau: {{ $competence['niveau'] ?? 'NULL' }}]</span> --}}
                            <div class="progress" style="height: 8px; background-color: #e9ecef; border-radius: 4px; overflow: hidden;">
                                <div class="progress-bar" role="progressbar" 
                                     style="width: {{ $competence['niveau'] }}%; background-color: var(--primary-color, #0d6efd); height: 100%;" 
                                     aria-valuenow="{{ $competence['niveau'] }}" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            
                         </div>
                         {{-- Fin nouvelle structure --}}
                     @endif
                </div>
            </div>
        @empty
            @unless($showAddForm || $editingIndex !== null)
                <div class="col-12">
                    <div style="text-align: center; color: var(--dark-gray); padding: 1rem; border: 1px dashed #ced4da !important; border-radius: 4px; margin-top: 1rem;"> Aucune compétence ajoutée. </div>
                </div>
            @endunless
        @endforelse
    </div>
</div>