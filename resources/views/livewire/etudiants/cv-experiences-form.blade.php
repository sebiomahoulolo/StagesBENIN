{{-- resources/views/livewire/votre-composant-experience.blade.php --}}

<div class="form-section">
    <div class="form-section-header">
        <h4>Expériences Professionnelles</h4>
         <button type="button" wire:click="toggleAddForm" class="add-item-btn btn btn-sm {{ $showAddForm ? 'btn-secondary' : 'btn-primary' }}">
            <i class="fas {{ $showAddForm ? 'fa-times' : 'fa-plus' }}"></i>
            <span>{{ $showAddForm ? 'Fermer' : 'Ajouter' }}</span>
        </button>
    </div>

    {{-- Messages Session --}}
    @if(session()->has('experience_message'))
        <div class="alert alert-success mt-3" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)">{{ session('experience_message') }}</div>
    @endif
    @if(session()->has('experience_error'))
        <div class="alert alert-danger mt-3">{{ session('experience_error') }}</div>
    @endif

    {{-- === FORMULAIRE D'AJOUT (Conditionnel) === --}}
    @if($showAddForm)
        <div class="experience-add-form mt-4 p-4 border rounded shadow-sm bg-light" >
            <h5 style="margin-bottom: 1.5rem; color: var(--primary-color, #007bff);">Ajouter une nouvelle expérience</h5>
            <form wire:submit.prevent="addExperience">
                {{-- Champs standards (poste, entreprise, ville, dates) --}}
                <div class="row mb-3">
                    <div class="col-md-6 form-group">
                        <label for="new_exp_poste_{{ $componentId }}" class="form-label">Poste <span class="text-danger">*</span></label>
                        <input type="text" id="new_exp_poste_{{ $componentId }}" wire:model.lazy="newExperience.poste" class="form-control form-control-sm @error('newExperience.poste') is-invalid @enderror" required>
                        @error('newExperience.poste') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                    <div class="col-md-6 form-group">
                         <label for="new_exp_entreprise_{{ $componentId }}" class="form-label">Entreprise <span class="text-danger">*</span></label>
                         <input type="text" id="new_exp_entreprise_{{ $componentId }}" wire:model.lazy="newExperience.entreprise" class="form-control form-control-sm @error('newExperience.entreprise') is-invalid @enderror" required>
                         @error('newExperience.entreprise') <span class="invalid-feedback">{{ $message }}</span> @enderror
                     </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4 form-group">
                        <label for="new_exp_ville_{{ $componentId }}" class="form-label">Ville</label>
                        <input type="text" id="new_exp_ville_{{ $componentId }}" wire:model.lazy="newExperience.ville" class="form-control form-control-sm @error('newExperience.ville') is-invalid @enderror">
                        @error('newExperience.ville') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                    <div class="col-md-4 form-group">
                         <label for="new_exp_date_debut_{{ $componentId }}" class="form-label">Date Début <span class="text-danger">*</span></label>
                         <input type="month" id="new_exp_date_debut_{{ $componentId }}" wire:model.lazy="newExperience.date_debut" class="form-control form-control-sm @error('newExperience.date_debut') is-invalid @enderror" required placeholder="YYYY-MM">
                         @error('newExperience.date_debut') <span class="invalid-feedback">{{ $message }}</span> @enderror
                     </div>
                     <div class="col-md-4 form-group">
                         <label for="new_exp_date_fin_{{ $componentId }}" class="form-label">Date Fin (ou laisser vide si actuel)</label>
                         <input type="month" id="new_exp_date_fin_{{ $componentId }}" wire:model.lazy="newExperience.date_fin" class="form-control form-control-sm @error('newExperience.date_fin') is-invalid @enderror" placeholder="YYYY-MM">
                         @error('newExperience.date_fin') <span class="invalid-feedback">{{ $message }}</span> @enderror
                     </div>
                </div>

                 {{-- Textarea pour Description --}}
                <div class="form-group mb-3">
                    <label for="new_exp_desc_{{ $componentId }}" class="form-label">Description générale du poste</label>
                    <textarea id="new_exp_desc_{{ $componentId }}"
                              wire:model.lazy="newExperience.description"
                              class="form-control form-control-sm @error('newExperience.description') is-invalid @enderror"
                              rows="3"
                              placeholder="Contexte, responsabilités principales..."
                              maxlength="1500">
                    </textarea>
                    @error('newExperience.description') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
                </div>

                {{-- Inputs pour les Tâches --}}
                <div class="form-group mb-3">
                    <label class="form-label">Tâches / Réalisations principales (1 par ligne, 3 max)</label>
                    <input type="text" wire:model.lazy="newExperience.tache_1" class="form-control form-control-sm mb-2 @error('newExperience.tache_1') is-invalid @enderror" placeholder="Tâche/Réalisation 1" maxlength="255">
                    @error('newExperience.tache_1') <span class="invalid-feedback">{{ $message }}</span> @enderror

                    <input type="text" wire:model.lazy="newExperience.tache_2" class="form-control form-control-sm mb-2 @error('newExperience.tache_2') is-invalid @enderror" placeholder="Tâche/Réalisation 2 (optionnel)" maxlength="255">
                    @error('newExperience.tache_2') <span class="invalid-feedback">{{ $message }}</span> @enderror

                    <input type="text" wire:model.lazy="newExperience.tache_3" class="form-control form-control-sm @error('newExperience.tache_3') is-invalid @enderror" placeholder="Tâche/Réalisation 3 (optionnel)" maxlength="255">
                    @error('newExperience.tache_3') <span class="invalid-feedback">{{ $message }}</span> @enderror
                 </div>

                <div class="mt-3 text-end"> {{-- text-right est déprécié dans BS5, utiliser text-end --}}
                    <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Ajouter Expérience</button>
                </div>
            </form>
        </div>
    @endif

    {{-- === CONTENEUR GRID POUR LES EXPERIENCES EXISTANTES === --}}
    <div class="experience-grid mt-4">
        @forelse ($experiences as $index => $experience)
            <div wire:key="experience-item-{{ $experience['id'] ?? $index }}"
                 class="{{ $editingIndex === $index ? 'editing-item' : 'experience-card' }}">

                 {{-- Message d'erreur spécifique à l'item (peut rester ici) --}}
                 @if(session()->has('experience_error_' . $index))
                    <div class="alert alert-danger alert-sm mb-3">{{ session('experience_error_' . $index) }}</div>
                 @endif

                @if($editingIndex === $index)
                    {{-- === FORMULAIRE D'ÉDITION (Prend toute la largeur grâce à .editing-item) === --}}
                    <div class="p-3 border rounded shadow-sm bg-light"> {{-- Style similaire au form d'ajout --}}
                         <h6 style="color: var(--primary-color, #007bff); margin-bottom: 1rem;">Modifier l'expérience</h6>
                         <form wire:submit.prevent="updateExperience">
                              {{-- Champs standards --}}
                              <div class="row mb-3">
                                    <div class="col-md-6 form-group">
                                        <label for="edit_exp_poste_{{ $index }}_{{ $componentId }}" class="form-label">Poste <span class="text-danger">*</span></label>
                                        <input type="text" id="edit_exp_poste_{{ $index }}_{{ $componentId }}" wire:model.lazy="editingExperience.poste" class="form-control form-control-sm @error('editingExperience.poste') is-invalid @enderror" required>
                                        @error('editingExperience.poste') <span class="invalid-feedback">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label for="edit_exp_entreprise_{{ $index }}_{{ $componentId }}" class="form-label">Entreprise <span class="text-danger">*</span></label>
                                        <input type="text" id="edit_exp_entreprise_{{ $index }}_{{ $componentId }}" wire:model.lazy="editingExperience.entreprise" class="form-control form-control-sm @error('editingExperience.entreprise') is-invalid @enderror" required>
                                        @error('editingExperience.entreprise') <span class="invalid-feedback">{{ $message }}</span> @enderror
                                    </div>
                              </div>
                              <div class="row mb-3">
                                    <div class="col-md-4 form-group">
                                        <label for="edit_exp_ville_{{ $index }}_{{ $componentId }}" class="form-label">Ville</label>
                                        <input type="text" id="edit_exp_ville_{{ $index }}_{{ $componentId }}" wire:model.lazy="editingExperience.ville" class="form-control form-control-sm @error('editingExperience.ville') is-invalid @enderror">
                                        @error('editingExperience.ville') <span class="invalid-feedback">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label for="edit_exp_date_debut_{{ $index }}_{{ $componentId }}" class="form-label">Date Début <span class="text-danger">*</span></label>
                                        <input type="month" id="edit_exp_date_debut_{{ $index }}_{{ $componentId }}" wire:model.lazy="editingExperience.date_debut" class="form-control form-control-sm @error('editingExperience.date_debut') is-invalid @enderror" required placeholder="YYYY-MM">
                                        @error('editingExperience.date_debut') <span class="invalid-feedback">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label for="edit_exp_date_fin_{{ $index }}_{{ $componentId }}" class="form-label">Date Fin</label>
                                        <input type="month" id="edit_exp_date_fin_{{ $index }}_{{ $componentId }}" wire:model.lazy="editingExperience.date_fin" class="form-control form-control-sm @error('editingExperience.date_fin') is-invalid @enderror" placeholder="YYYY-MM">
                                        @error('editingExperience.date_fin') <span class="invalid-feedback">{{ $message }}</span> @enderror
                                    </div>
                              </div>

                              {{-- Textarea pour Description --}}
                              <div class="form-group mb-3">
                                  <label for="edit_exp_desc_{{ $index }}_{{ $componentId }}" class="form-label">Description générale</label>
                                  <textarea id="edit_exp_desc_{{ $index }}_{{ $componentId }}"
                                            wire:model.lazy="editingExperience.description"
                                            class="form-control form-control-sm @error('editingExperience.description') is-invalid @enderror"
                                            rows="3" maxlength="1500"></textarea>
                                  @error('editingExperience.description') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
                              </div>

                              {{-- Inputs pour les Tâches --}}
                              <div class="form-group mb-3">
                                  <label class="form-label">Tâches / Réalisations principales</label>
                                  <input type="text" wire:model.lazy="editingExperience.tache_1" class="form-control form-control-sm mb-2 @error('editingExperience.tache_1') is-invalid @enderror" placeholder="Tâche/Réalisation 1" maxlength="255">
                                  @error('editingExperience.tache_1') <span class="invalid-feedback">{{ $message }}</span> @enderror
                                  <input type="text" wire:model.lazy="editingExperience.tache_2" class="form-control form-control-sm mb-2 @error('editingExperience.tache_2') is-invalid @enderror" placeholder="Tâche/Réalisation 2 (optionnel)" maxlength="255">
                                  @error('editingExperience.tache_2') <span class="invalid-feedback">{{ $message }}</span> @enderror
                                  <input type="text" wire:model.lazy="editingExperience.tache_3" class="form-control form-control-sm @error('editingExperience.tache_3') is-invalid @enderror" placeholder="Tâche/Réalisation 3 (optionnel)" maxlength="255">
                                  @error('editingExperience.tache_3') <span class="invalid-feedback">{{ $message }}</span> @enderror
                              </div>

                             <div class="d-flex justify-content-end gap-2 mt-3"> {{-- Flexbox pour aligner les boutons --}}
                                 <button type="button" wire:click="cancelEdit" class="btn btn-secondary btn-sm">Annuler</button>
                                 <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-save"></i> Enregistrer</button>
                             </div>
                         </form>
                    </div>
                 @else
                     {{-- === AFFICHAGE "CARTE" (Item de la grille) === --}}
                     <div class="experience-card-body">
                         {{-- Boutons d'action discrets --}}
                         <div class="item-actions" style="top: 1rem; right: 1rem;"> {{-- Ajustement position boutons --}}
                            <button type="button" wire:click="edit({{ $index }})" class="edit-item-btn" title="Modifier"><i class="fas fa-pencil-alt"></i></button>
                            <button type="button" wire:click="removeExperience({{ $index }})" wire:confirm="Êtes-vous sûr ?" class="delete-item-btn" title="Supprimer"><i class="fas fa-trash"></i></button>
                        </div>

                         {{-- Contenu de la carte --}}
                         <h5 class="experience-card-title">{{ $experience['poste'] }}</h5>
                         <p class="experience-card-subtitle">{{ $experience['entreprise'] }}{{ $experience['ville'] ? ' - '.$experience['ville'] : '' }}</p>
                         <p class="experience-card-dates">
                             {{-- Formatage des dates (optionnel: utiliser 'month' pour le type input) --}}
                             {{ $experience['date_debut'] ? \Carbon\Carbon::parse($experience['date_debut'].'-01')->isoFormat('MMMM YYYY') : 'Date début manquante' }}
                             @if($experience['date_fin'])
                                 - {{ \Carbon\Carbon::parse($experience['date_fin'].'-01')->isoFormat('MMMM YYYY') }}
                             @else
                                 - Présent
                             @endif
                         </p>

                          @if(!empty($experience['description']))
                             <p class="experience-card-description">
                                {!! nl2br(e($experience['description'])) !!}
                             </p>
                         @endif

                         {{-- Affichage des tâches en liste --}}
                         @if(!empty($experience['tache_1']) || !empty($experience['tache_2']) || !empty($experience['tache_3']))
                             <div class="experience-card-tasks">
                                  <strong>Réalisations :</strong>
                                  <ul>
                                      @if(!empty($experience['tache_1']))<li>{{ $experience['tache_1'] }}</li>@endif
                                      @if(!empty($experience['tache_2']))<li>{{ $experience['tache_2'] }}</li>@endif
                                      @if(!empty($experience['tache_3']))<li>{{ $experience['tache_3'] }}</li>@endif
                                  </ul>
                             </div>
                         @endif
                     </div>
                 @endif
            </div>
        @empty
            {{-- Message si aucune expérience n'est ajoutée (en dehors de la grille si elle est vide) --}}

            @unless($showAddForm || $editingIndex !== null)
                <div style="text-align: center; color: var(--dark-gray); padding: 1rem; border: 1px dashed !important; grid-column: 1 / -1; border-radius: 4px;"> Aucune expérience professionnelle ajoutée. </div>
            @endunless

        @endforelse
    </div> {{-- Fin de .experience-grid --}}

</div>


<style>
    /* Style de base pour la section */
    .form-section {
        margin-bottom: 2rem;
        /* background-color: #f8f9fa; */ /* Optionnel: léger fond pour la section */
        /* padding: 1.5rem; */         /* Optionnel: padding global */
        /* border-radius: 0.375rem; */ /* Optionnel: coins arrondis */
    }
    .form-section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
        padding-bottom: 0.75rem;
        border-bottom: 1px solid #dee2e6;
    }
    .form-section-header h4 {
        margin: 0;
        color: #343a40; /* Couleur titre */
    }

    /* Conteneur de la grille */
    .experience-grid {
        display: grid;
        /* 3 colonnes égales, 1fr = fraction de l'espace dispo */
        grid-template-columns: repeat(3, 1fr);
        gap: 1.5rem; /* Espace entre les cartes */
    }

    /* Style pour la carte d'expérience */
    .experience-card {
        background-color: #fff;
        border: 1px solid #e9ecef; /* Bordure légère */
        border-radius: 0.375rem; /* Coins arrondis (style Bootstrap) */
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075); /* Ombre discrète */
        padding: 1.25rem; /* Espacement intérieur */
        position: relative; /* Pour positionner les actions */
        display: flex; /* Pour s'assurer que le contenu remplit la hauteur si nécessaire */
        flex-direction: column;
        transition: box-shadow 0.2s ease-in-out; /* Effet au survol */
    }
    .experience-card:hover {
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
    }

    /* Style pour l'élément en cours d'édition */
    .editing-item {
        /* Prend toute la largeur de la grille */
        grid-column: 1 / -1;
        /* Style similaire au formulaire d'ajout pour la cohérence */
        margin-bottom: 1.5rem; /* Marge pour séparer du reste */
    }

    /* Contenu de la carte */
    .experience-card-body {
        flex-grow: 1; /* Permet au corps de grandir */
    }
    .experience-card-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: var(--primary-color, #0056b3); /* Couleur titre poste */
        margin-bottom: 0.25rem;
    }
    .experience-card-subtitle {
        font-size: 0.95rem;
        color: #495057; /* Gris foncé pour entreprise/ville */
        margin-bottom: 0.5rem;
    }
    .experience-card-dates {
        font-size: 0.85rem;
        color: #6c757d; /* Gris plus clair pour les dates */
        margin-bottom: 1rem;
        border-bottom: 1px dashed #dee2e6; /* Séparateur léger */
        padding-bottom: 0.75rem;
    }
    .experience-card-description {
        font-size: 0.9rem;
        color: #343a40;
        margin-bottom: 1rem;
        line-height: 1.5;
    }

    /* Section des tâches/réalisations */
    .experience-card-tasks {
        background-color: #f8f9fa; /* Fond très léger */
        border-left: 3px solid var(--primary-color-light, #6caeff); /* Indicateur visuel */
        padding: 0.75rem 1rem;
        margin-top: 1rem;
        border-radius: 0.25rem;
        font-size: 0.88rem;
    }
    .experience-card-tasks strong {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: 500;
        color: #343a40;
    }
    .experience-card-tasks ul {
        list-style-type: disc;
        margin: 0 0 0 1.25rem; /* Marge gauche pour les puces */
        padding: 0;
        color: #495057;
    }
    .experience-card-tasks li {
        margin-bottom: 0.3rem;
    }
    .experience-card-tasks li:last-child {
        margin-bottom: 0;
    }

    /* Boutons d'action sur la carte */
    .experience-card-actions {
        position: absolute;
        top: 0.75rem;
        right: 0.75rem;
        display: flex;
        gap: 0.5rem; /* Espace entre les boutons */
        opacity: 0.6; /* Moins visibles par défaut */
        transition: opacity 0.2s ease-in-out;
    }
    .experience-card:hover .experience-card-actions {
        opacity: 1; /* Visibles au survol de la carte */
    }
    .experience-card-actions button i {
        font-size: 0.9rem; /* Taille icônes */
    }


    /* Responsive: Passer à 2 colonnes sur écrans moyens, 1 colonne sur petits écrans */
    @media (max-width: 991.98px) { /* Medium devices (tablets, less than 992px) */
        .experience-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 1rem; /* Réduire l'espace */
        }
        .editing-item { grid-column: 1 / -1; } /* Garde toute la largeur */
    }

    @media (max-width: 767.98px) { /* Small devices (landscape phones, less than 768px) */
        .experience-grid {
            grid-template-columns: 1fr; /* Une seule colonne */
            gap: 1rem;
        }
         /* Plus besoin de forcer l'item en édition sur toute la largeur */
        .editing-item { grid-column: auto; }
    }

    /* Ajustements pour les formulaires (si nécessaire) */
    .form-label { font-size: 0.875rem; margin-bottom: 0.25rem; }
    .form-control-sm { font-size: 0.875rem; }

    /* Définir des variables de couleur si ce n'est pas déjà fait */
    :root {
        --primary-color: #0d6efd; /* Couleur primaire Bootstrap */
        --primary-color-light: #6caeff; /* Version claire pour bordure */
    }

</style>