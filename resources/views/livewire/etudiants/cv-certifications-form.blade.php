<div class="form-section">
    <div class="form-section-header">
        <h4>Certifications</h4>
         <button type="button" wire:click="toggleAddForm" class="add-item-btn">
            <i class="fas {{ $showAddForm ? 'fa-times' : 'fa-plus' }}"></i>
            {{ $showAddForm ? 'Fermer' : 'Ajouter' }}
        </button>
    </div>

    @if(session()->has('certification_message'))
        <div class="alert alert-success">{{ session('certification_message') }}</div>
    @endif

    {{-- === FORMULAIRE D'AJOUT (Conditionnel) === --}}
    @if($showAddForm)
        <div class="form-repeater-item" style="border-top: 2px solid var(--primary-color); padding-top:1.5rem;">
            <h5 style="margin-bottom: 1rem; color: var(--primary-color);">Ajouter une nouvelle certification</h5>
            <form wire:submit.prevent="addCertification">
                 <div class="row">
                       <div class="col form-group">
                           <label for="new_cert_nom" class="form-label">Certification <span style="color:red">*</span></label>
                           <input type="text" id="new_cert_nom" wire:model.lazy="newCertification.nom" class="form-control @error('newCertification.nom') is-invalid @enderror" required>
                           @error('newCertification.nom') <span class="invalid-feedback">{{ $message }}</span> @enderror
                       </div>
                       <div class="col form-group">
                            <label for="new_cert_org" class="form-label">Organisme <span style="color:red">*</span></label>
                            <input type="text" id="new_cert_org" wire:model.lazy="newCertification.organisme" class="form-control @error('newCertification.organisme') is-invalid @enderror" required>
                            @error('newCertification.organisme') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>
                        <div class="col form-group" style="max-width: 120px;">
                            <label for="new_cert_annee" class="form-label">Année</label>
                            <input type="number" id="new_cert_annee" wire:model.lazy="newCertification.annee" class="form-control @error('newCertification.annee') is-invalid @enderror" min="1980" max="{{ date('Y') + 1 }}">
                            @error('newCertification.annee') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>
                   </div>
                   <div class="form-group">
                       <label for="new_cert_url" class="form-label">URL Validation</label>
                       <input type="url" id="new_cert_url" wire:model.lazy="newCertification.url_validation" class="form-control @error('newCertification.url_validation') is-invalid @enderror" placeholder="http://...">
                       @error('newCertification.url_validation') <span class="invalid-feedback">{{ $message }}</span> @enderror
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
    @forelse ($certifications as $index => $certification)
        <div class="form-repeater-item mb-3" wire:key="certification-item-{{ $certification['id'] ?? $index }}">
             @if($editingIndex === $index)
                 {{-- === FORMULAIRE D'ÉDITION === --}}
                  <h6 style="color: var(--primary-color); margin-bottom: 1rem;">Modifier la certification</h6>
                 <form wire:submit.prevent="updateCertification">
                      <div class="row">
                         <div class="col form-group">
                             <label for="edit_cert_nom_{{ $index }}" class="form-label">Certification <span style="color:red">*</span></label>
                             <input type="text" id="edit_cert_nom_{{ $index }}" wire:model.lazy="editingCertification.nom" class="form-control @error('editingCertification.nom') is-invalid @enderror" required>
                             @error('editingCertification.nom') <span class="invalid-feedback">{{ $message }}</span> @enderror
                         </div>
                         <div class="col form-group">
                              <label for="edit_cert_org_{{ $index }}" class="form-label">Organisme <span style="color:red">*</span></label>
                              <input type="text" id="edit_cert_org_{{ $index }}" wire:model.lazy="editingCertification.organisme" class="form-control @error('editingCertification.organisme') is-invalid @enderror" required>
                              @error('editingCertification.organisme') <span class="invalid-feedback">{{ $message }}</span> @enderror
                          </div>
                          <div class="col form-group" style="max-width: 120px;">
                              <label for="edit_cert_annee_{{ $index }}" class="form-label">Année</label>
                              <input type="number" id="edit_cert_annee_{{ $index }}" wire:model.lazy="editingCertification.annee" class="form-control @error('editingCertification.annee') is-invalid @enderror" min="1980" max="{{ date('Y') + 1 }}">
                              @error('editingCertification.annee') <span class="invalid-feedback">{{ $message }}</span> @enderror
                          </div>
                     </div>
                     <div class="form-group">
                         <label for="edit_cert_url_{{ $index }}" class="form-label">URL Validation</label>
                         <input type="url" id="edit_cert_url_{{ $index }}" wire:model.lazy="editingCertification.url_validation" class="form-control @error('editingCertification.url_validation') is-invalid @enderror" placeholder="http://...">
                         @error('editingCertification.url_validation') <span class="invalid-feedback">{{ $message }}</span> @enderror
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
                     <button type="button" wire:click="removeCertification({{ $index }})" wire:confirm="Êtes-vous sûr de vouloir supprimer cette certification ?" class="delete-item-btn" title="Supprimer">
                        <i class="fas fa-trash"></i>
                     </button>
                 </div>
                 <p style="font-weight: 600; color: var(--secondary-color); margin-bottom: 0.2rem;">{{ $certification['nom'] }}</p>
                 <p style="color: var(--primary-color); margin-bottom: 0.2rem;">
                     {{ $certification['organisme'] }}
                     {{ $certification['annee'] ? ' - ' . $certification['annee'] : '' }}
                 </p>
                 @if($certification['url_validation'])
                    <p style="font-size: 0.9em; color: var(--dark-gray); margin-bottom: 0;">
                        <a href="{{ $certification['url_validation'] }}" target="_blank" rel="noopener noreferrer" style="color: var(--dark-gray); text-decoration: underline;">
                             <i class="fas fa-link fa-sm"></i> Voir validation
                        </a>
                    </p>
                 @endif
             @endif
        </div>
    @empty
        @unless($showAddForm || $editingIndex !== null)
            <div style="text-align: center; color: var(--dark-gray); padding: 1rem; border: 1px dashed !important; grid-column: 1 / -1; border-radius: 4px;"> Aucune certification ajoutée. </div>
        @endunless   
    @endforelse
</div>