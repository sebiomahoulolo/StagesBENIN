<div class="form-section">
    <div class="form-section-header">
        <h4>Projets Personnels</h4>
         <button type="button" wire:click="toggleAddForm" class="add-item-btn btn btn-sm {{ $showAddForm ? 'btn-secondary' : 'btn-primary' }}">
            <i class="fas {{ $showAddForm ? 'fa-times' : 'fa-plus' }}"></i>
            <span>{{ $showAddForm ? 'Fermer' : 'Ajouter' }}</span>
        </button>
    </div>

    @if(session()->has('projet_message'))
        <div class="alert alert-success mt-3" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)">{{ session('projet_message') }}</div>
    @endif
    @if(session()->has('projet_error'))
        <div class="alert alert-danger mt-3">{{ session('projet_error') }}</div>
    @endif

    {{-- === FORMULAIRE D'AJOUT (Conditionnel) === --}}
    @if($showAddForm)
        <div class="projet-add-form mt-4 p-4 border rounded shadow-sm bg-light">
            <h5 style="margin-bottom: 1.5rem; color: var(--primary-color, #007bff);">Ajouter un nouveau projet</h5>
            <form wire:submit.prevent="addProjet">
                  <div class="row mb-3">
                       <div class="col-md-6 form-group">
                           <label for="new_proj_nom" class="form-label">Nom Projet <span style="color:red">*</span></label>
                           <input type="text" id="new_proj_nom" wire:model.lazy="newProjet.nom" class="form-control form-control-sm @error('newProjet.nom') is-invalid @enderror" required>
                           @error('newProjet.nom') <span class="invalid-feedback">{{ $message }}</span> @enderror
                       </div>
                       <div class="col-md-6 form-group">
                            <label for="new_proj_url" class="form-label">URL Projet</label>
                            <input type="url" id="new_proj_url" wire:model.lazy="newProjet.url_projet" class="form-control form-control-sm @error('newProjet.url_projet') is-invalid @enderror" placeholder="http://...">
                            @error('newProjet.url_projet') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>
                   </div>

                    {{-- Remplacement de Trix par Textarea --}}
                   <div class="form-group mb-3">
                       <label for="new_proj_desc" class="form-label">Description</label>
                       <textarea id="new_proj_desc" wire:model.lazy="newProjet.description" class="form-control form-control-sm @error('newProjet.description') is-invalid @enderror" rows="4" maxlength="1000"></textarea>
                       @error('newProjet.description') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
                   </div>

                   <div class="form-group mb-3"> {{-- Ajout mb-3 --}}
                       <label for="new_proj_tech" class="form-label">Technologies utilisées</label>
                       <input type="text" id="new_proj_tech" wire:model.lazy="newProjet.technologies" class="form-control form-control-sm @error('newProjet.technologies') is-invalid @enderror" placeholder="Ex: Laravel, Vue.js, MySQL">
                       @error('newProjet.technologies') <span class="invalid-feedback">{{ $message }}</span> @enderror
                   </div>
                <div class="mt-3 text-end">
                    <button type="submit" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i> Ajouter Projet
                    </button>
                </div>
            </form>
        </div>
    @endif

    {{-- === LISTE DES ITEMS EXISTANTS === --}}
    <div class="projets-list mt-4">
        @forelse ($projets as $index => $projet)
            <div class="form-repeater-item mb-3 {{ $editingIndex === $index ? 'editing-item' : 'projet-card' }}" wire:key="projet-item-{{ $projet['id'] ?? $index }}">

                @if(session()->has('projet_error_' . $index))
                    <div class="alert alert-danger alert-sm mb-3">{{ session('projet_error_' . $index) }}</div>
                @endif

                 @if($editingIndex === $index)
                     {{-- === FORMULAIRE D'ÉDITION === --}}
                     <div class="p-3 border rounded shadow-sm bg-light"> {{-- Style ajouté --}}
                         <h6 style="color: var(--primary-color, #007bff); margin-bottom: 1rem;">Modifier le projet</h6>
                         <form wire:submit.prevent="updateProjet">
                             <div class="row mb-3">
                                 <div class="col-md-6 form-group">
                                     <label for="edit_proj_nom_{{ $index }}" class="form-label">Nom Projet <span style="color:red">*</span></label>
                                     <input type="text" id="edit_proj_nom_{{ $index }}" wire:model.lazy="editingProjet.nom" class="form-control form-control-sm @error('editingProjet.nom') is-invalid @enderror" required>
                                     @error('editingProjet.nom') <span class="invalid-feedback">{{ $message }}</span> @enderror
                                 </div>
                                 <div class="col-md-6 form-group">
                                      <label for="edit_proj_url_{{ $index }}" class="form-label">URL Projet</label>
                                      <input type="url" id="edit_proj_url_{{ $index }}" wire:model.lazy="editingProjet.url_projet" class="form-control form-control-sm @error('editingProjet.url_projet') is-invalid @enderror" placeholder="http://...">
                                      @error('editingProjet.url_projet') <span class="invalid-feedback">{{ $message }}</span> @enderror
                                  </div>
                             </div>

                             {{-- Remplacement de Trix par Textarea --}}
                             <div class="form-group mb-3">
                                 <label for="edit_proj_desc_{{ $index }}" class="form-label">Description</label>
                                 <textarea id="edit_proj_desc_{{ $index }}" wire:model.lazy="editingProjet.description" class="form-control form-control-sm @error('editingProjet.description') is-invalid @enderror" rows="4" maxlength="1000"></textarea>
                                 @error('editingProjet.description') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
                             </div>

                             <div class="form-group mb-3">
                                 <label for="edit_proj_tech_{{ $index }}" class="form-label">Technologies utilisées</label>
                                 <input type="text" id="edit_proj_tech_{{ $index }}" wire:model.lazy="editingProjet.technologies" class="form-control form-control-sm @error('editingProjet.technologies') is-invalid @enderror" placeholder="Ex: Laravel, Vue.js, MySQL">
                                 @error('editingProjet.technologies') <span class="invalid-feedback">{{ $message }}</span> @enderror
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
                    <div class="item-actions">
                         <button type="button" wire:click="edit({{ $index }})" class="edit-item-btn" title="Modifier" style="color:var(--bs-primary, #0d6efd); font-size: 1rem;">
                             <i class="fas fa-pencil-alt"></i>
                         </button>
                         <button type="button" wire:click="removeProjet({{ $index }})" wire:confirm="Êtes-vous sûr de vouloir supprimer ce projet ?" class="delete-item-btn" title="Supprimer" style="color: var(--bs-danger, #dc3545); font-size: 1rem;">
                            <i class="fas fa-trash"></i>
                         </button>
                    </div>
                     <p class="projet-title">{{ $projet['nom'] }}</p>
                     @if($projet['url_projet'])
                         <p class="projet-url">
                             <a href="{{ $projet['url_projet'] }}" target="_blank" rel="noopener noreferrer">
                                  <i class="fas fa-link fa-sm"></i> {{ \Illuminate\Support\Str::limit(str_replace(['https://', 'http://'], '', $projet['url_projet']), 40) }}
                             </a>
                         </p>
                      @endif
                     @if(!empty($projet['description']))
                         <div class="projet-description">
                             {!! nl2br(e( \Illuminate\Support\Str::limit($projet['description'], 150))) !!} {{-- Affichage texte simple, limité --}}
                         </div>
                     @endif
                     @if(!empty($projet['technologies']))
                          <p class="projet-tech">Tech: {{ $projet['technologies'] }}</p>
                      @endif
                 @endif
            </div>
        @empty
            @unless($showAddForm || $editingIndex !== null)
                <div class="empty-message"> Aucun projet ajouté. </div>
            @endunless
        @endforelse
    </div> {{-- Fin .projets-list --}}
</div>

<style>
    /* Styles généraux */
    .form-section { margin-bottom: 2rem; }
    .form-section-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; padding-bottom: 0.75rem; border-bottom: 1px solid #dee2e6; }
    .form-section-header h4 { margin: 0; color: #343a40; }
    .add-item-btn span { margin-left: 0.3rem; }

    /* Formulaire d'ajout */
    .projet-add-form {
        /* Styles de base déjà ok (padding, border, bg...) */
    }

    /* Liste des projets */
    .projets-list {
        /* Pas de grille spécifique, chaque item prendra la largeur */
    }

    /* Item projet (carte et édition) */
    .form-repeater-item {
        padding: 1rem 1.25rem;
        border: 1px solid #e9ecef;
        border-radius: 0.375rem;
        position: relative; /* Pour les actions */
        background-color: #fff;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        transition: box-shadow 0.2s ease-in-out;
    }
    .form-repeater-item:not(:last-child) {
        margin-bottom: 1rem;
    }
     .projet-card:hover {
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
    }

    /* Conteneur du formulaire d'édition */
    .editing-item .p-3 {
        background-color: #f8f9fa;
        border: 1px solid #dee2e6; /* Assurer une bordure */
        border-radius: 4px;
        box-shadow: none; /* Supprimer l'ombre de la carte */
    }

    /* Actions (Modifier/Supprimer) */
    .item-actions {
        position: absolute;
        top: 0.5rem;
        right: 0.5rem;
        display: flex;
        gap: 0.5rem;
        opacity: 0; /* Caché par défaut */
        transition: opacity 0.2s ease-in-out;
        z-index: 10;
        background-color: rgba(255, 255, 255, 0.7); /* Fond léger */
        padding: 3px 5px;
        border-radius: 4px;
    }
    .projet-card:hover .item-actions,
    .projet-card:focus-within .item-actions {
        opacity: 1; /* Visible au survol/focus */
    }
    .item-actions button {
        background: none;
        border: none;
        cursor: pointer;
        padding: 0.2rem;
        line-height: 1;
    }
    /* Les styles inline pour la couleur/taille sont conservés pour le moment,
       mais pourraient être mis en classes CSS */

    /* Styles du contenu de la carte */
    .projet-title { font-weight: 600; color: var(--secondary-color, #6c757d); margin-bottom: 0.2rem; padding-right: 60px; /* Espace pour les boutons */} 
    .projet-url { font-size: 0.9em; color: var(--dark-gray, #343a40); margin-bottom: 0.5rem; word-break: break-all; }
    .projet-url a { color: inherit; text-decoration: underline; }
    .projet-url a:hover { color: var(--primary-color, #0056b3); }
    .projet-description { font-size: 0.9em; color: #555; margin-top: 5px; margin-bottom: 10px; line-height: 1.5; }
    .projet-tech { font-size: 0.85em; color: var(--primary-color, #0056b3); margin-top: 5px; font-style: italic; }

    /* Message vide */
    .empty-message {
        text-align: center;
        color: var(--dark-gray, #6c757d);
        padding: 1rem;
        border: 1px dashed #ced4da !important;
        border-radius: 4px;
        margin-top: 1rem;
    }

    /* Styles Formulaires */
    .form-label { font-size: 0.875rem; margin-bottom: 0.25rem; }
    .form-control-sm { font-size: 0.875rem; }
    .text-danger { color: #dc3545 !important; }

    /* Responsive */
    @media (max-width: 767.98px) {
        .form-repeater-item {
            padding: 0.75rem 1rem;
        }
        .projet-title {
            font-size: 1rem; /* Ajuster taille titre */
        }
        .form-section-header {
             flex-direction: column;
             align-items: flex-start;
             gap: 0.5rem;
         }
         /* Empiler les colonnes dans les formulaires */
         .projet-add-form .col-md-6,
         .editing-item .col-md-6 {
            flex: 0 0 100%;
            max-width: 100%;
         }
         .projet-add-form .row > .col-md-6:not(:last-child),
         .editing-item .row > .col-md-6:not(:last-child) {
            margin-bottom: 1rem; /* Espace entre champs empilés */
         }
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
