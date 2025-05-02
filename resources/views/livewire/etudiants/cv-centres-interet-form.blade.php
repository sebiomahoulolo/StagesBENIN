<div class="form-section">
    <div class="form-section-header">
        <h4>Centres d'Intérêt</h4>
         <button type="button" wire:click="toggleAddForm" class="add-item-btn btn btn-sm {{ $showAddForm ? 'btn-secondary' : 'btn-primary' }}">
            <i class="fas {{ $showAddForm ? 'fa-times' : 'fa-plus' }}"></i>
            <span>{{ $showAddForm ? 'Fermer' : 'Ajouter' }}</span>
        </button>
    </div>

    @if(session()->has('interet_message'))
        <div class="alert alert-success">{{ session('interet_message') }}</div>
    @endif
    
    @if(session()->has('interet_error'))
        <div class="alert alert-danger">{{ session('interet_error') }}</div>
    @endif

    {{-- === FORMULAIRE D'AJOUT (Conditionnel) === --}}
    @if($showAddForm)
        <div class="form-repeater-item" style="border-top: 2px solid var(--primary-color); padding-top:1.5rem;">
            <h5 style="margin-bottom: 1rem; color: var(--primary-color);">Ajouter un nouveau centre d'intérêt</h5>
            <form wire:submit.prevent="addInteret">
                 <div class="form-group mb-0">
                       <label for="new_interet_nom" class="form-label">Intérêt <span style="color:red">*</span></label>
                       <input type="text" id="new_interet_nom" wire:model.defer="newInteret.nom" class="form-control @error('newInteret.nom') is-invalid @enderror" placeholder="Nom de l'intérêt..." required>
                       @error('newInteret.nom') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
                 </div>
                <div class="mt-3 text-end">
                    <button type="submit" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i> Ajouter
                    </button>
                </div>
            </form>
        </div>
    @endif

    {{-- === LISTE DES ITEMS EXISTANTS (en grille) === --}}
    <div class="interet-grid mt-4">
        @forelse ($centresInteret as $index => $interet)
             {{-- Ajout de la classe interet-item pour le style --}}
            <div class="interet-item mb-3" wire:key="interet-item-{{ $interet['id'] ?? $index }}">
                 @if($editingIndex === $index)
                     {{-- === FORMULAIRE D'ÉDITION === --}}
                     <div class="p-3 border rounded shadow-sm bg-light"> {{-- Ajout de padding/style comme formation --}}
                        <h6 style="color: var(--primary-color); margin-bottom: 1rem;">Modifier l'intérêt</h6>
                        <form wire:submit.prevent="updateInteret">
                            <div class="form-group mb-0">
                                <label for="edit_interet_nom_{{ $index }}" class="form-label">Intérêt <span style="color:red">*</span></label>
                                <input type="text" id="edit_interet_nom_{{ $index }}" wire:model.defer="editingInteret.nom" class="form-control @error('editingInteret.nom') is-invalid @enderror" required>
                                @error('editingInteret.nom') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
                            </div>
                           {{-- Modification du conteneur et des boutons Annuler/Enregistrer --}}
                           <div class="d-flex justify-content-end gap-2 mt-3"> {{-- Utilisation de flex et gap --}}
                               <button type="button" wire:click="cancelEdit" class="btn btn-secondary btn-sm">Annuler</button> {{-- Ajout de btn btn-sm --}}
                               <button type="submit" class="btn btn-primary btn-sm"> {{-- Ajout de btn btn-sm --}}
                                   <i class="fas fa-save"></i> Enregistrer
                               </button>
                           </div>
                       </form>
                     </div> {{-- Fin .p-3 ... --}}
                 @else
                     {{-- === AFFICHAGE "CARTE" (sans bordure explicite, style via CSS) === --}}
                     <div class="interet-card-body"> {{-- Classe pour styler le contenu si besoin --}}
                         <div class="item-actions">
                            <button type="button" wire:click="edit({{ $index }})" class="edit-item-btn" title="Modifier" style="color:var(--bs-primary, #0d6efd); font-size: 1rem;"> {{-- Taille et couleur ajustées --}}
                                <i class="fas fa-pencil-alt"></i>
                            </button>
                            <button type="button" wire:click="removeInteret({{ $index }})" wire:confirm="Êtes-vous sûr de vouloir supprimer cet intérêt ?" class="delete-item-btn" title="Supprimer" style="color: var(--bs-danger, #dc3545); font-size: 1rem;"> {{-- Taille et couleur ajustées --}}
                               <i class="fas fa-trash"></i>
                            </button>
                         </div>
                         {{-- Le span est maintenant le contenu principal de la "carte" --}}
                        <span style="background-color: #e8f4fc; padding: 5px 12px; border-radius: 15px; font-size: 0.9em; color: var(--primary-color); display: inline-block;">
                            {{ $interet['nom'] }}
                        </span>
                     </div> {{-- Fin .interet-card-body --}}
                 @endif
            </div> {{-- Fin .interet-item --}}
        @empty
            {{-- Message si aucun centre d'intérêt n'est ajouté --}}
            @unless($showAddForm || $editingIndex !== null)
                 {{-- S'assurer que le message prend toute la largeur de la grille --}}
                <div style="text-align: center; color: var(--dark-gray); padding: 1rem; border: 1px dashed #dee2e6 !important; grid-column: 1 / -1; border-radius: 4px; margin-top: 1rem;"> Aucun centre d'intérêt ajouté. </div>
            @endunless
        @endforelse
    </div> {{-- Fin .interet-grid --}}
</div>

{{-- Ajout du CSS pour la grille et les éléments --}}
<style>
    /* Styles de base (peuvent être partagés ou spécifiques) */
    .form-section { margin-bottom: 2rem; }
    .form-section-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; padding-bottom: 0.75rem; border-bottom: 1px solid #dee2e6; }
    .form-section-header h4 { margin: 0; color: #343a40; }

    /* Grille pour les centres d'intérêt */
    .interet-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(150px, 1fr)); /* Utilise auto-fill pour un nombre de colonnes flexible */
        gap: 0.75rem; /* Espace entre les éléments */
    }

    /* Style de chaque élément d'intérêt */
    .interet-item {
        position: relative;
        text-align: center; /* Centrer le contenu */
    }

    .interet-card-body {
        display: flex; /* Permet d'aligner le nom et les actions */
        flex-direction: column;
        align-items: center;
        justify-content: center; /* Centre verticalement si hauteur fixe */
        min-height: 60px; /* Hauteur minimale pour l'alignement et les boutons */
        padding: 1.5rem 0.5rem 0.5rem; /* Ajouter de l'espace en haut pour les boutons */
    }

    .interet-nom-display { /* Nouveau conteneur pour le nom pour un meilleur contrôle */
        background-color: #e8f4fc;
        padding: 5px 12px;
        border-radius: 15px;
        font-size: 0.9em;
        color: var(--primary-color, #0d6efd);
        display: inline-block; /* Ou block selon le besoin */
        word-wrap: break-word; /* Assure la césure des mots longs */
        margin-top: 0; /* Remplacé par le padding du parent */
        line-height: 1.4;
    }

    /* Positionnement des boutons d'action (Modifier/Supprimer) */
    .interet-item .item-actions {
        position: absolute;
        top: 0.2rem; /* Positionnement en haut */
        right: 0.2rem; /* Positionnement à droite */
        display: flex;
        gap: 0.5rem;
        z-index: 10; /* Pour être au-dessus du contenu */
        opacity: 0; /* Caché par défaut */
        transition: opacity 0.2s ease-in-out;
    }
    .interet-item:hover .item-actions,
    .interet-item:focus-within .item-actions { /* Afficher au survol ou focus */
        opacity: 1;
    }

    .interet-item .item-actions button {
        background: rgba(255, 255, 255, 0.7); /* Fond léger pour visibilité */
        border: none;
        padding: 3px 5px;
        border-radius: 3px;
        cursor: pointer;
        line-height: 1;
    }
    .interet-item .item-actions .edit-item-btn i,
    .interet-item .item-actions .delete-item-btn i {
        font-size: 0.85rem; /* Taille ajustée */
    }
    .interet-item .item-actions .edit-item-btn { color: var(--bs-primary, #0d6efd); }
    .interet-item .item-actions .delete-item-btn { color: var(--bs-danger, #dc3545); }

     .interet-item .item-actions .edit-item-btn:hover { color: var(--bs-primary-dark, #0a58ca); background: rgba(255, 255, 255, 0.9); }
     .interet-item .item-actions .delete-item-btn:hover { color: var(--bs-danger-dark, #b02a37); background: rgba(255, 255, 255, 0.9); }

    /* Style pour l'élément en cours d'édition */
    .interet-item.editing-item {
        grid-column: 1 / -1; /* Prend toute la largeur */
        margin-bottom: 1.5rem; /* Espace en dessous */
        text-align: left; /* Réinitialiser l'alignement */
        box-shadow: none; /* Pas d'ombre en mode édition */
        background-color: transparent; /* Pas de fond spécifique */
        padding: 0;
    }
    .interet-item.editing-item .p-3 { /* Le conteneur du formulaire d'édition */
         background-color: #f8f9fa;
         border: 1px solid #dee2e6;
         border-radius: 4px;
    }

    /* Responsive - les media queries précédentes sont remplacées par auto-fill */
    /* On peut ajouter des ajustements spécifiques si nécessaire */
    @media (max-width: 575.98px) {
        .interet-grid {
             gap: 0.5rem; /* Réduire l'écart */
             grid-template-columns: repeat(auto-fill, minmax(120px, 1fr)); /* Taille min plus petite */
        }
        .interet-card-body {
             min-height: 50px;
             padding: 1.2rem 0.3rem 0.3rem;
        }
        .interet-nom-display {
            font-size: 0.85em;
            padding: 4px 10px;
        }
        .interet-item .item-actions { /* Rapprocher les boutons */
             top: 0.1rem;
             right: 0.1rem;
             gap: 0.3rem;
        }
         .interet-item .item-actions button {
            padding: 2px 4px;
         }
         .interet-item .item-actions i {
            font-size: 0.8rem;
         }
         .form-section-header {
             flex-direction: column;
             align-items: flex-start;
             gap: 0.5rem;
         }
    }

    /* Variables (si non définies globalement) */
    :root {
        --primary-color: #0d6efd;
        --bs-danger: #dc3545;
        --bs-primary: #0d6efd;
        /* Ajouter d'autres si nécessaire */
    }
</style>