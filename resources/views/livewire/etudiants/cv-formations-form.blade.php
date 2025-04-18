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

                 {{-- Textarea pour Description --}}
                 <div class="form-group mb-3">
                     <label for="new_form_desc" class="form-label">Description (optionnel)</label>
                     <textarea id="new_form_desc"
                               wire:model.lazy="newFormation.description"
                               class="form-control form-control-sm @error('newFormation.description') is-invalid @enderror"
                               rows="3"
                               maxlength="1000"
                               placeholder="Détails supplémentaires, matières principales..."></textarea>
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

                            {{-- Textarea pour Description --}}
                            <div class="form-group mb-3">
                                <label for="edit_form_desc_{{ $index }}" class="form-label">Description</label>
                                <textarea id="edit_form_desc_{{ $index }}"
                                            wire:model.lazy="editingFormation.description"
                                            class="form-control form-control-sm @error('editingFormation.description') is-invalid @enderror"
                                            rows="3"
                                            maxlength="1000"></textarea>
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
                        {{-- Icônes d'action (placées différemment) --}}
                        <div class="formation-direct-actions">
                             <button type="button" class="btn-action-icon" wire:click="edit({{ $index }})" title="Modifier" aria-label="Modifier la formation">
                                <i class="fas fa-pencil-alt text-primary"></i>
                             </button>
                             <button type="button" class="btn-action-icon" wire:click="removeFormation({{ $index }})" wire:confirm="Êtes-vous sûr de vouloir supprimer cette formation ?" title="Supprimer" aria-label="Supprimer la formation">
                                <i class="fas fa-trash text-danger"></i>
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
                <div class="empty-message"> Aucune formation ajoutée. </div>
            @endunless
        @endforelse
    </div> {{-- Fin .formation-grid --}}

</div> {{-- Fin .form-section --}}

{{-- ====================================================================== --}}
{{-- === CSS (Adapté pour les formations) === --}}
{{-- ====================================================================== --}}
<style>
    /* Style de base */
    .form-section { margin-bottom: 2rem; }
    .form-section-header { display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 0.5rem; margin-bottom: 1.5rem; padding-bottom: 0.75rem; border-bottom: 1px solid #dee2e6; }
    .form-section-header h4 { margin: 0; color: #343a40; }
    .add-item-btn span { margin-left: 0.3rem; }

    /* Formulaire d'ajout */
    .formation-add-form {
        background-color: #f8f9fa;
        padding: 1.5rem;
        border: 1px solid #dee2e6;
        border-radius: 0.375rem;
    }

    /* Conteneur de la grille */
    .formation-grid {
        display: grid;
        grid-template-columns: 1fr; /* Une seule colonne */
        gap: 1rem;
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
        overflow: hidden; /* Empêche le débordement */
    }
    .formation-card:hover {
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
    }
     .formation-card:hover .formation-direct-actions,
     .formation-card:focus-within .formation-direct-actions {
         opacity: 1; /* Afficher les actions au survol/focus */
     }

    /* Style pour l'élément en cours d'édition */
    .editing-item {
        margin-bottom: 1.5rem;
    }
     .editing-item .p-3 {
        background-color: #f8f9fa;
        border: 1px solid #dee2e6;
        border-radius: 4px;
        padding: 1.5rem; /* Homogénéiser padding */
    }

    /* Contenu de la carte */
    .formation-card-body { flex-grow: 1; padding-right: 40px; /* Espace pour les boutons ajusté */ word-break: break-word; }
    .formation-card-title { font-size: 1.1rem; font-weight: 600; color: var(--secondary-color, #6c757d); margin-bottom: 0.25rem; overflow-wrap: break-word; }
    .formation-card-subtitle { font-size: 0.95rem; color: var(--primary-color, #0056b3); margin-bottom: 0.5rem; overflow-wrap: break-word; }
    .formation-card-dates { font-size: 0.85rem; color: #6c757d; margin-bottom: 1rem; border-bottom: 1px dashed #dee2e6; padding-bottom: 0.75rem; }
    .formation-card-description { font-size: 0.9rem; color: #343a40; margin-top: 1rem; line-height: 1.5; white-space: pre-wrap; overflow-wrap: break-word; /* Améliore le rendu de la description */}

    /* Styles pour les boutons d'action directs */
    .formation-direct-actions {
        position: absolute;
        top: 0.5rem; /* Ajusté */
        right: 0.5rem; /* Ajusté */
        display: flex;
        flex-direction: column; /* Mettre les boutons en colonne */
        gap: 0.4rem; /* Espacement entre les boutons */
        z-index: 5;
        opacity: 0; /* Caché par défaut */
        transition: opacity 0.2s ease-in-out;
    }
    /* Style des boutons repris de Experience */
    .btn-action-icon {
        background: rgba(255, 255, 255, 0.8);
        border: 1px solid #eee;
        border-radius: 50%;
        width: 30px;
        height: 30px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0;
        cursor: pointer;
        line-height: 1;
        box-shadow: 0 1px 2px rgba(0,0,0,0.1);
    }
    .btn-action-icon i {
        font-size: 0.85rem;
        vertical-align: middle;
    }
    .formation-direct-actions .text-primary { color: var(--bs-primary, #0d6efd) !important; }
    .formation-direct-actions .text-danger { color: var(--bs-danger, #dc3545) !important; }

    .btn-action-icon:hover {
       background: rgba(240, 240, 240, 0.9);
       opacity: 1;
       box-shadow: 0 1px 3px rgba(0,0,0,0.15);
    }

    /* Message vide */
    .empty-message {
        text-align: center;
        color: var(--dark-gray, #6c757d);
        padding: 1rem;
        border: 1px dashed #ced4da !important;
        border-radius: 4px;
        margin-top: 1rem;
    }

    /* Ajustements Formulaires */
    .form-label { font-size: 0.875rem; margin-bottom: 0.25rem; }
    .form-control-sm { font-size: 0.875rem; }
    .text-danger { color: #dc3545 !important; }

    /* Responsive */
     @media (max-width: 767.98px) {
        .formation-grid { gap: 0.75rem; }
        .formation-card { padding: 1rem; }
        .formation-card-body { padding-right: 40px; /* Ajuster espace boutons */ }
        .formation-card-title { font-size: 1rem; }
        .formation-card-subtitle { font-size: 0.9rem; }
        .formation-card-dates { font-size: 0.8rem; margin-bottom: 0.75rem; padding-bottom: 0.5rem; }
        .formation-card-description { font-size: 0.85rem; }
        .form-section-header {
             flex-direction: column;
             align-items: flex-start;
        }
         /* Empiler colonnes formulaire ajout/edition */
        .formation-add-form .row > div:not(:last-child),
        .editing-item .row > div:not(:last-child) {
            margin-bottom: 1rem; /* Espace entre champs empilés */
         }
         .formation-add-form .col-md-6,
         .formation-add-form .col-md-4,
         .editing-item .col-md-6,
         .editing-item .col-md-4 {
            flex: 0 0 100%;
            max-width: 100%;
         }
    }
    @media (max-width: 575.98px) {
        .formation-card-body { padding-right: 35px; }
        .btn-action-icon { width: 28px; height: 28px; }
        .btn-action-icon i { font-size: 0.8rem; }
     }

    /* Variables CSS */
    :root {
        --primary-color: #0d6efd;
        --secondary-color: #6c757d;
        --dark-gray: #343a40;
        --primary-color-light: #6caeff; /* Pourrait être utilisé ailleurs */
        --bs-primary: #0d6efd;
        --bs-danger: #dc3545;
    }
</style>