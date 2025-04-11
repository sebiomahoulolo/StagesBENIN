{{-- resources/views/livewire/etudiants/cv-formations-form.blade.php --}}

<div class="form-section">
    {{-- En-tête de la section --}}
    <div class="form-section-header">
        <h4>Formations</h4>
         <button type="button" wire:click="toggleAddForm" class="add-item-btn btn btn-sm {{ $showAddForm ? 'btn-secondary' : 'btn-primary' }}">
            <i class="fas {{ $showAddForm ? 'fa-times' : 'fa-plus' }}"></i>
            <span>{{ $showAddForm ? 'Fermer' : 'Ajouter' }}</span>
        </button>
    </div>

    {{-- Messages de Session --}}
    @if(session()->has('formation_message'))
        <div class="alert alert-success mt-3" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)">{{ session('formation_message') }}</div>
    @endif
     @if(session()->has('formation_error'))
        <div class="alert alert-danger mt-3">{{ session('formation_error') }}</div>
    @endif

    {{-- === FORMULAIRE D'AJOUT (Conditionnel) === --}}
    @if($showAddForm)
        <div class="formation-add-form mt-4 p-4 border rounded shadow-sm bg-light">
            <h5 style="margin-bottom: 1.5rem; color: var(--primary-color, #007bff);">Ajouter une nouvelle formation</h5>
            <form wire:submit.prevent="addFormation">
                {{-- Champs Diplôme / Etablissement --}}
                <div class="row mb-3">
                    <div class="col-md-6 form-group">
                        <label for="new_form_diplome" class="form-label">Diplôme <span class="text-danger">*</span></label>
                        <input type="text" id="new_form_diplome" wire:model.lazy="newFormation.diplome" class="form-control form-control-sm @error('newFormation.diplome') is-invalid @enderror" required>
                        @error('newFormation.diplome') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                    <div class="col-md-6 form-group">
                         <label for="new_form_etablissement" class="form-label">Établissement <span class="text-danger">*</span></label>
                         <input type="text" id="new_form_etablissement" wire:model.lazy="newFormation.etablissement" class="form-control form-control-sm @error('newFormation.etablissement') is-invalid @enderror" required>
                         @error('newFormation.etablissement') <span class="invalid-feedback">{{ $message }}</span> @enderror
                     </div>
                </div>
                {{-- Champs Ville / Années --}}
                <div class="row mb-3">
                    <div class="col-md-4 form-group">
                        <label for="new_form_ville" class="form-label">Ville</label>
                        <input type="text" id="new_form_ville" wire:model.lazy="newFormation.ville" class="form-control form-control-sm @error('newFormation.ville') is-invalid @enderror">
                        @error('newFormation.ville') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                    <div class="col-md-4 form-group">
                         <label for="new_form_annee_debut" class="form-label">Année Début <span class="text-danger">*</span></label>
                         <input type="number" id="new_form_annee_debut" wire:model.lazy="newFormation.annee_debut" class="form-control form-control-sm @error('newFormation.annee_debut') is-invalid @enderror" required min="1950" max="{{ date('Y') + 2 }}" placeholder="Ex: {{ date('Y') - 2 }}">
                         @error('newFormation.annee_debut') <span class="invalid-feedback">{{ $message }}</span> @enderror
                     </div>
                     <div class="col-md-4 form-group">
                         <label for="new_form_annee_fin" class="form-label">Année Fin (ou laisser vide)</label>
                         <input type="number" id="new_form_annee_fin" wire:model.lazy="newFormation.annee_fin" class="form-control form-control-sm @error('newFormation.annee_fin') is-invalid @enderror" min="1950" max="{{ date('Y') + 5 }}" placeholder="Ex: {{ date('Y') }}">
                         @error('newFormation.annee_fin') <span class="invalid-feedback">{{ $message }}</span> @enderror
                     </div>
                </div>

                 {{-- ** REMPLACEMENT DE TRIX PAR TEXTAREA ** --}}
                 <div class="form-group mb-3">
                     <label for="new_form_desc" class="form-label">Description (optionnel)</label>
                     <textarea id="new_form_desc"
                               wire:model.lazy="newFormation.description"
                               class="form-control form-control-sm @error('newFormation.description') is-invalid @enderror"
                               rows="3"
                               maxlength="1000"
                               placeholder="Détails supplémentaires, matières principales...">
                     </textarea>
                     @error('newFormation.description') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
                 </div>

                <div class="mt-3 text-end">
                    <button type="submit" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i> Ajouter Formation
                    </button>
                </div>
            </form>
        </div>
    @endif

    {{-- === CONTENEUR GRID POUR LES FORMATIONS EXISTANTES === --}}
    <div class="formation-grid mt-4">
        @forelse ($formations as $index => $formation)
            <div wire:key="formation-item-{{ $formation['id'] ?? $index }}"
                 class="{{ $editingIndex === $index ? 'editing-item' : 'formation-card' }}">

                 {{-- Message d'erreur spécifique à l'item --}}
                 @if(session()->has('formation_error_' . $index))
                    <div class="alert alert-danger alert-sm mb-3">{{ session('formation_error_' . $index) }}</div>
                 @endif

                @if($editingIndex === $index)
                    {{-- === FORMULAIRE D'ÉDITION === --}}
                    <div class="p-3 border rounded shadow-sm bg-light">
                        <h6 style="color: var(--primary-color, #007bff); margin-bottom: 1rem;">Modifier la formation</h6>
                        <form wire:submit.prevent="updateFormation">
                            {{-- Champs Diplôme / Etablissement --}}
                            <div class="row mb-3">
                                <div class="col-md-6 form-group">
                                    <label for="edit_form_diplome_{{ $index }}" class="form-label">Diplôme <span class="text-danger">*</span></label>
                                    <input type="text" id="edit_form_diplome_{{ $index }}" wire:model.lazy="editingFormation.diplome" class="form-control form-control-sm @error('editingFormation.diplome') is-invalid @enderror" required>
                                    @error('editingFormation.diplome') <span class="invalid-feedback">{{ $message }}</span> @enderror
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="edit_form_etablissement_{{ $index }}" class="form-label">Établissement <span class="text-danger">*</span></label>
                                    <input type="text" id="edit_form_etablissement_{{ $index }}" wire:model.lazy="editingFormation.etablissement" class="form-control form-control-sm @error('editingFormation.etablissement') is-invalid @enderror" required>
                                    @error('editingFormation.etablissement') <span class="invalid-feedback">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            {{-- Champs Ville / Années --}}
                            <div class="row mb-3">
                                <div class="col-md-4 form-group">
                                    <label for="edit_form_ville_{{ $index }}" class="form-label">Ville</label>
                                    <input type="text" id="edit_form_ville_{{ $index }}" wire:model.lazy="editingFormation.ville" class="form-control form-control-sm @error('editingFormation.ville') is-invalid @enderror">
                                    @error('editingFormation.ville') <span class="invalid-feedback">{{ $message }}</span> @enderror
                                </div>
                                <div class="col-md-4 form-group">
                                    <label for="edit_form_annee_debut_{{ $index }}" class="form-label">Année Début <span class="text-danger">*</span></label>
                                    <input type="number" id="edit_form_annee_debut_{{ $index }}" wire:model.lazy="editingFormation.annee_debut" class="form-control form-control-sm @error('editingFormation.annee_debut') is-invalid @enderror" required min="1950" max="{{ date('Y') + 2 }}">
                                    @error('editingFormation.annee_debut') <span class="invalid-feedback">{{ $message }}</span> @enderror
                                </div>
                                <div class="col-md-4 form-group">
                                    <label for="edit_form_annee_fin_{{ $index }}" class="form-label">Année Fin</label>
                                    <input type="number" id="edit_form_annee_fin_{{ $index }}" wire:model.lazy="editingFormation.annee_fin" class="form-control form-control-sm @error('editingFormation.annee_fin') is-invalid @enderror" min="1950" max="{{ date('Y') + 5 }}">
                                    @error('editingFormation.annee_fin') <span class="invalid-feedback">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            {{-- ** REMPLACEMENT DE TRIX PAR TEXTAREA ** --}}
                            <div class="form-group mb-3">
                                <label for="edit_form_desc_{{ $index }}" class="form-label">Description</label>
                                <textarea id="edit_form_desc_{{ $index }}"
                                            wire:model.lazy="editingFormation.description"
                                            class="form-control form-control-sm @error('editingFormation.description') is-invalid @enderror"
                                            rows="3"
                                            maxlength="1000">
                                </textarea>
                                @error('editingFormation.description') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
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
                    {{-- === AFFICHAGE "CARTE" (Item de la grille) === --}}
                    <div class="formation-card-body">
                        {{-- Boutons d'action : Uniquement les icônes colorées --}}
                        <div class="formation-card-actions">
                            <button type="button" wire:click="edit({{ $index }})"
                                    class="btn btn-link text-primary p-0"
                                    title="Modifier" aria-label="Modifier la formation">
                                <i class="fas fa-pencil-alt fa-fw"></i>
                            </button>
                            <button type="button" wire:click="removeFormation({{ $index }})"
                                    wire:confirm="Êtes-vous sûr de vouloir supprimer cette formation ?"
                                    class="btn btn-link text-danger p-0"
                                    title="Supprimer" aria-label="Supprimer la formation">
                               <i class="fas fa-trash fa-fw"></i>
                            </button>
                        </div>

                        {{-- Contenu de la carte --}}
                        <h5 class="formation-card-title">{{ $formation['diplome'] }}</h5>
                        <p class="formation-card-subtitle">{{ $formation['etablissement'] }}{{ $formation['ville'] ? ' - '.$formation['ville'] : '' }}</p>
                        <p class="formation-card-dates">
                            {{ $formation['annee_debut'] }}
                            @if($formation['annee_fin'])
                                - {{ $formation['annee_fin'] }}
                            @else
                                - En cours
                            @endif
                        </p>

                        {{-- Affichage description (simple texte avec sauts de ligne) --}}
                        @if(!empty($formation['description']))
                            <p class="formation-card-description">
                                {!! nl2br(e($formation['description'])) !!} {{-- nl2br pour les sauts de ligne, e() pour la sécurité --}}
                            </p>
                        @endif
                    </div> {{-- Fin .formation-card-body --}}
                @endif
            </div> {{-- Fin .formation-card ou .editing-item --}}
        @empty
             {{-- Message si aucune formation n'est ajoutée --}}

            @unless($showAddForm || $editingIndex !== null)
                <div style="text-align: center; color: var(--dark-gray); padding: 1rem; border: 1px dashed !important; grid-column: 1 / -1; border-radius: 4px;"> Aucune formation ajoutée. </div>
            @endunless
        @endforelse
    </div> {{-- Fin .formation-grid --}}

</div> {{-- Fin .form-section --}}

{{-- ====================================================================== --}}
{{-- === CSS (Adapté pour les formations) === --}}
{{-- ====================================================================== --}}
<style>
    /* Style de base (identique à Experience) */
    .form-section { margin-bottom: 2rem; }
    .form-section-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; padding-bottom: 0.75rem; border-bottom: 1px solid #dee2e6; }
    .form-section-header h4 { margin: 0; color: #343a40; }

    /* Conteneur de la grille */
    .formation-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr); /* 3 colonnes */
        gap: 1.5rem;
    }

    /* Style pour la carte de formation */
    .formation-card {
        background-color: #fff;
        border: 1px solid #e9ecef;
        border-radius: 0.375rem;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        padding: 1.25rem;
        position: relative;
        display: flex;
        flex-direction: column;
        transition: box-shadow 0.2s ease-in-out;
    }
    .formation-card:hover {
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
    }

    /* Style pour l'élément en cours d'édition */
    .editing-item {
        grid-column: 1 / -1;
        margin-bottom: 1.5rem;
    }

    /* Contenu de la carte */
    .formation-card-body { flex-grow: 1; }
    .formation-card-title { font-size: 1.1rem; font-weight: 600; color: var(--secondary-color, #6c757d); margin-bottom: 0.25rem; } /* Couleur différente ? */
    .formation-card-subtitle { font-size: 0.95rem; color: var(--primary-color, #0056b3); margin-bottom: 0.5rem; } /* Couleur différente ? */
    .formation-card-dates { font-size: 0.85rem; color: #6c757d; margin-bottom: 1rem; border-bottom: 1px dashed #dee2e6; padding-bottom: 0.75rem; }
    .formation-card-description { font-size: 0.9rem; color: #343a40; margin-top: 1rem; line-height: 1.5; white-space: pre-wrap; /* Respecte les sauts de ligne */ }

    /* Boutons d'action (icônes) */
    .formation-card-actions {
        position: absolute; top: 0.75rem; right: 0.75rem; display: flex; gap: 0.6rem; opacity: 0; transition: opacity 0.2s ease-in-out; z-index: 10;
    }
    .formation-card:hover .formation-card-actions { opacity: 1; }
    .formation-card-actions .btn-link { line-height: 1; text-decoration: none; padding: 0.2rem; }
    .formation-card-actions .btn-link i { font-size: 1rem; vertical-align: middle; }
    .formation-card-actions .btn-link:focus { box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25); outline: none; }

    /* Responsive */
    @media (max-width: 991.98px) { .formation-grid { grid-template-columns: repeat(2, 1fr); gap: 1rem; } .editing-item { grid-column: 1 / -1; } }
    @media (max-width: 767.98px) { .formation-grid { grid-template-columns: 1fr; gap: 1rem; } .editing-item { grid-column: auto; } }

    /* Ajustements Formulaires */
    .form-label { font-size: 0.875rem; margin-bottom: 0.25rem; }
    .form-control-sm { font-size: 0.875rem; }
    .formation-add-form,
    .editing-item .p-3 { background-color: #f8f9fa; }

    /* Variables CSS (si non définies globalement) */
    :root {
        --primary-color: #0d6efd;
        --secondary-color: #6c757d; /* Ajout ou utilisation existante */
        --primary-color-light: #6caeff; /* Pourrait être utilisé ailleurs */
    }
</style>