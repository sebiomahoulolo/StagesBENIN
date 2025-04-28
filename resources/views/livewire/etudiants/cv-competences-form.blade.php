<div class="form-section">
    <div class="form-section-header">
        <h4>Compétences</h4>
        <button type="button" wire:click="toggleAddForm" class="add-item-btn btn btn-sm {{ $showAddForm ? 'btn-secondary' : 'btn-primary' }}">
            <i class="fas {{ $showAddForm ? 'fa-times' : 'fa-plus' }}"></i>
            <span>{{ $showAddForm ? 'Fermer' : 'Ajouter' }}</span>
        </button>
    </div>

    @if(session()->has('competence_message'))
        <div class="alert alert-success mt-3" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)">{{ session('competence_message') }}</div>
    @endif
    @if(session()->has('competence_error'))
        <div class="alert alert-danger mt-3">{{ session('competence_error') }}</div>
    @endif

    {{-- === FORMULAIRE D'AJOUT (Conditionnel) === --}}
    @if($showAddForm)
        <div class="competence-add-form mt-4 p-4 border rounded shadow-sm bg-light">
            <h5 style="margin-bottom: 1.5rem; color: var(--primary-color, #007bff);">Ajouter une nouvelle compétence</h5>
            <form wire:submit.prevent="addCompetence">
                 <div class="row align-items-end mb-3"> {{-- Ajout mb-3 --}}
                       <div class="col-md form-group mb-md-0 mb-3"> {{-- Ajustement col et marges --}}
                           <label for="new_comp_cat" class="form-label">Catégorie <span style="color:red">*</span></label>
                           <input type="text" list="categories_list_all" id="new_comp_cat" wire:model.lazy="newCompetence.categorie" class="form-control form-control-sm @error('newCompetence.categorie') is-invalid @enderror" required>
                           @error('newCompetence.categorie') <span class="invalid-feedback">{{ $message }}</span> @enderror
                       </div>
                       <div class="col-md form-group mb-md-0 mb-3"> {{-- Ajustement col et marges --}}
                            <label for="new_comp_nom" class="form-label">Compétence <span style="color:red">*</span></label>
                            <input type="text" id="new_comp_nom" wire:model.lazy="newCompetence.nom" class="form-control form-control-sm @error('newCompetence.nom') is-invalid @enderror" required>
                            @error('newCompetence.nom') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>
                        <div class="col-md-auto form-group mb-0"> {{-- Utilisation de col-md-auto --}}
                            <label for="new_comp_niveau" class="form-label">Niveau (%) <span style="color:red">*</span></label>
                             <div class="d-flex align-items-center competence-level-input"> {{-- Classe ajoutée --}}
                                 <input type="range" id="new_comp_niveau_range" wire:model.live="newCompetence.niveau" class="form-range form-range-sm @error('newCompetence.niveau') is-invalid @enderror" min="0" max="100" step="5" style="flex-grow: 1; margin-right: 10px;">
                                 <input type="number" id="new_comp_niveau" wire:model.live="newCompetence.niveau" class="form-control form-control-sm @error('newCompetence.niveau') is-invalid @enderror" min="0" max="100" step="5" required style="width: 70px; text-align: center;">
                             </div>
                             @error('newCompetence.niveau') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror {{-- d-block pour afficher l'erreur sous le groupe --}}
                        </div>
                   </div>
                <div class="mt-3 text-end">
                    <button type="submit" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i> Ajouter Compétence
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

    {{-- === LISTE DES ITEMS EXISTANTS (Utilisation de grid CSS pour mieux contrôler) === --}}
    <div class="competence-grid mt-4">
        @forelse ($competences as $index => $competence)

            <div wire:key="competence-item-{{ $competence['id'] ?? $index }}" class="{{ $editingIndex === $index ? 'editing-item' : 'competence-card' }}">
                 @if($editingIndex === $index)
                     {{-- === FORMULAIRE D'ÉDITION (Prend toute la largeur) === --}}
                    <div class="p-3 border rounded shadow-sm bg-light">
                         <h6 style="color: var(--primary-color, #007bff); margin-bottom: 1rem;">Modifier la compétence</h6>
                         <form wire:submit.prevent="updateCompetence">
                             <div class="row align-items-end mb-3">
                                 <div class="col-md form-group mb-md-0 mb-3">
                                     <label for="edit_comp_cat_{{ $index }}" class="form-label">Catégorie <span style="color:red">*</span></label>
                                     <input type="text" list="categories_list_all" id="edit_comp_cat_{{ $index }}" wire:model.lazy="editingCompetence.categorie" class="form-control form-control-sm @error('editingCompetence.categorie') is-invalid @enderror" required>
                                      @error('editingCompetence.categorie') <span class="invalid-feedback">{{ $message }}</span> @enderror
                                 </div>
                                 <div class="col-md form-group mb-md-0 mb-3">
                                      <label for="edit_comp_nom_{{ $index }}" class="form-label">Compétence <span style="color:red">*</span></label>
                                      <input type="text" id="edit_comp_nom_{{ $index }}" wire:model.lazy="editingCompetence.nom" class="form-control form-control-sm @error('editingCompetence.nom') is-invalid @enderror" required>
                                       @error('editingCompetence.nom') <span class="invalid-feedback">{{ $message }}</span> @enderror
                                  </div>
                                  <div class="col-md-auto form-group mb-0">
                                      <label for="edit_comp_niveau_{{ $index }}" class="form-label">Niveau (%) <span style="color:red">*</span></label>
                                      <div class="d-flex align-items-center competence-level-input">
                                           <input type="range" id="edit_comp_niveau_{{ $index }}_range" wire:model.live="editingCompetence.niveau" class="form-range form-range-sm @error('editingCompetence.niveau') is-invalid @enderror" min="0" max="100" step="5" style="flex-grow: 1; margin-right: 10px;">
                                           <input type="number" id="edit_comp_niveau_{{ $index }}" wire:model.live="editingCompetence.niveau" class="form-control form-control-sm @error('editingCompetence.niveau') is-invalid @enderror" min="0" max="100" step="5" required style="width: 70px; text-align: center;">
                                      </div>
                                       @error('editingCompetence.niveau') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
                                  </div>
                             </div>
                            <div class="d-flex justify-content-end gap-2 mt-3">
                                <button type="button" wire:click="cancelEdit" class="btn btn-secondary btn-sm">Annuler</button>
                                <button type="submit" class="btn btn-primary btn-sm">
                                    <i class="fas fa-save"></i> Enregistrer
                                </button>
                            </div>
                        </form>
                    </div>
                 @else
                     {{-- === AFFICHAGE "CARTE" === --}}
                     <div class="competence-card-body">
                        <div class="item-actions">
                            <button type="button" wire:click="edit({{ $index }})" class="btn-action-icon edit-item-btn" title="Modifier">
                                <i class="fas fa-pencil-alt"></i>
                            </button>
                            <button type="button" wire:click="removeCompetence({{ $index }})" wire:confirm="êtes-vous sûr de vouloir supprimer cette compétence ?" class="btn-action-icon delete-item-btn" title="Supprimer">
                               <i class="fas fa-trash"></i>
                            </button>
                        </div>
                        {{-- Nouvelle structure d'affichage --}}
                        <div class="skill-item">
                           <span class="skill-category">{{ $competence['categorie'] }}</span>
                           <div class="skill-info mb-1">
                               <span class="skill-name">{{ $competence['nom'] }}</span>
                               <span class="skill-level">{{ $competence['niveau'] }}%</span>
                           </div>
                           <div class="progress skill-progress">
                               <div class="progress-bar" role="progressbar"
                                    style="width: {{ $competence['niveau'] }}%;"
                                    aria-valuenow="{{ $competence['niveau'] }}" aria-valuemin="0" aria-valuemax="100"></div>
                           </div>
                        </div>
                        {{-- Fin nouvelle structure --}}
                    </div>
                 @endif
            </div>
        @empty
            @unless($showAddForm || $editingIndex !== null)
                <div class="empty-message"> Aucune compétence ajoutée. </div>
            @endunless
        @endforelse
    </div>
</div>

<style>
    /* Styles généraux */
    .form-section { margin-bottom: 2rem; }
    .form-section-header { display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 0.5rem; margin-bottom: 1.5rem; padding-bottom: 0.75rem; border-bottom: 1px solid #dee2e6; }
    .form-section-header h4 { margin: 0; color: #343a40; }
    .add-item-btn span { margin-left: 0.3rem; }

    /* Formulaire ajout/édition */
    .competence-add-form,
    .editing-item .p-3 {
        background-color: #f8f9fa;
        padding: 1.5rem; /* Homogénéiser padding */
        border: 1px solid #dee2e6;
        border-radius: 0.375rem;
    }
    .form-label { font-size: 0.875rem; margin-bottom: 0.25rem; }
    .form-control-sm, .form-range-sm { font-size: 0.875rem; }
    .text-danger { color: #dc3545 !important; }

    /* Grille pour les compétences */
    .competence-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(230px, 1fr)); /* Taille min légèrement réduite */
        gap: 1rem;
    }

    /* Style de la carte compétence */
    .competence-card {
        background-color: #fff;
        border: 1px solid #e9ecef;
        border-radius: 0.375rem;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        padding: 1rem;
        position: relative;
        transition: box-shadow 0.2s ease-in-out;
        overflow: hidden; /* Empêche débordement */
    }
    .competence-card:hover {
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
    }
    .competence-card:hover .item-actions,
    .competence-card:focus-within .item-actions {
        opacity: 1;
    }

    /* Contenu de la carte */
    .competence-card-body {
        padding-right: 40px; /* Espace pour boutons ajusté */
        word-break: break-word; /* Retour ligne global */
    }
    .skill-item {
        /* Pas de style spécifique nécessaire ici */
    }
    .skill-category {
        font-size: 0.8em;
        color: var(--secondary-color, #6c757d);
        display: block;
        margin-bottom: 0.25rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        overflow-wrap: break-word;
    }
    .skill-info {
        display: flex;
        justify-content: space-between;
        align-items: baseline;
        gap: 0.5rem; /* Espace entre nom et niveau */
    }
    .skill-name {
        font-weight: 500;
        color: var(--dark-gray, #343a40);
        line-height: 1.3;
        overflow-wrap: break-word;
    }
    .skill-level {
        font-size: 0.85em;
        color: var(--dark-gray, #343a40);
        font-weight: 500;
        white-space: nowrap;
        flex-shrink: 0; /* Empêche le niveau de réduire sa taille */
    }
    .skill-progress {
        height: 6px; /* Barre plus fine */
        background-color: #e9ecef;
        border-radius: 3px;
        overflow: hidden;
        margin-top: 0.25rem; /* Petite marge */
    }
    .skill-progress .progress-bar {
        background-color: var(--primary-color, #0d6efd);
        height: 100%;
        transition: width 0.6s ease;
    }

    /* Actions (Modifier/Supprimer) - Style repris de Experience/Formation */
    .item-actions {
        position: absolute;
        top: 0.5rem;
        right: 0.5rem;
        display: flex;
        flex-direction: column; /* Boutons en colonne */
        gap: 0.4rem;
        opacity: 0;
        transition: opacity 0.2s ease-in-out;
        z-index: 10;
    }
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
    .btn-action-icon.edit-item-btn { color: var(--bs-primary, #0d6efd) !important; }
    .btn-action-icon.delete-item-btn { color: var(--bs-danger, #dc3545) !important; }
    .btn-action-icon:hover {
        background: rgba(240, 240, 240, 0.9);
        opacity: 1;
        box-shadow: 0 1px 3px rgba(0,0,0,0.15);
    }

    /* Item en édition */
    .editing-item {
        grid-column: 1 / -1; /* Prend toute la largeur */
        margin-bottom: 1rem;
    }

    /* Message vide */
    .empty-message {
        grid-column: 1 / -1; /* S'assure qu'il prend toute la largeur */
        text-align: center;
        color: var(--dark-gray, #6c757d);
        padding: 1rem;
        border: 1px dashed #ced4da !important;
        border-radius: 4px;
        margin-top: 1rem;
    }

    /* Responsive */
    @media (max-width: 767.98px) {
        .competence-grid {
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); /* Moins large sur tablette */
            gap: 0.75rem;
        }
        .competence-card-body {
            padding-right: 40px; /* Ajuster espace boutons */
        }
         .form-section-header {
             flex-direction: column;
             align-items: flex-start;
         }
         /* Empiler form ajout/edition */
         .competence-add-form .row > div:not(:last-child),
         .editing-item .row > div:not(:last-child) {
             margin-bottom: 1rem; /* Espace quand empilé */
         }
         /* S'assurer que le groupe range/input ne déborde pas */
         .competence-level-input {
             flex-wrap: wrap; /* Permettre le retour à la ligne si nécessaire */
             gap: 0.5rem;
         }
         .competence-level-input .form-range {
             min-width: 100px; /* Donner une largeur minimale au range */
         }
    }
    @media (max-width: 575.98px) {
        .competence-grid {
            grid-template-columns: 1fr; /* Une colonne sur mobile */
        }
        .competence-card-body {
            padding-right: 35px;
        }
        .btn-action-icon { width: 28px; height: 28px; }
        .btn-action-icon i { font-size: 0.8rem; }
    }

    /* Variables */
    :root {
        --primary-color: #0d6efd;
        --secondary-color: #6c757d;
        --dark-gray: #343a40;
        --bs-primary: #0d6efd;
        --bs-danger: #dc3545;
    }
</style>
