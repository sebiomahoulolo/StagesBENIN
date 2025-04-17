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
                                <label for="edit_interet_nom_{{ $index }}" class="form-label sr-only">Intérêt</label>
                                <input type="text" id="edit_interet_nom_{{ $index }}" wire:model.lazy="editingInteret.nom" class="form-control @error('editingInteret.nom') is-invalid @enderror" required>
                                @error('editingInteret.nom') <span class="invalid-feedback">{{ $message }}</span> @enderror
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
                         <span class="interet-nom"> {{-- Classe ajoutée pour le style --}}
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
        grid-template-columns: repeat(5, 1fr); /* 5 colonnes par défaut */
        gap: 0.75rem; /* Espace entre les éléments */
    }

    /* Style de chaque élément d'intérêt */
    .interet-item {
        position: relative;
        /* background-color: #f8f9fa; /* Fond léger si désiré */
        /* border: 1px solid #e9ecef; /* Bordure supprimée */
        border-radius: 0.25rem;
        padding: 0.75rem 1rem; /* Ajuster le padding */
        text-align: center; /* Centrer le contenu */
        box-shadow: 0 1px 3px rgba(0,0,0,0.1); /* Légère ombre pour la séparation */
        background-color: #fff; /* Fond blanc */
    }

    .interet-card-body {
        display: flex; /* Permet d'aligner le nom et les actions */
        flex-direction: column;
        align-items: center;
        justify-content: center; /* Centre verticalement si hauteur fixe */
        min-height: 50px; /* Hauteur minimale pour l'alignement */
    }

    .interet-nom {
        font-size: 0.9em;
        color: var(--primary-color, #0056b3);
        font-weight: 500;
        display: block; /* Prend toute la largeur */
        word-wrap: break-word; /* Coupe les mots longs */
        margin-top: 1rem; /* Espace par rapport aux boutons */
    }

    /* Positionnement des boutons d'action (Modifier/Supprimer) */
    .interet-item .item-actions {
        position: absolute;
        top: 0.4rem;
        right: 0.4rem;
        display: flex;
        gap: 0.5rem;
    }
    .interet-item .item-actions button {
        background: none;
        border: none;
        padding: 0;
        cursor: pointer;
    }
    .interet-item .item-actions .edit-item-btn i,
    .interet-item .item-actions .delete-item-btn i {
        font-size: 0.9rem; /* Taille réduite pour moins d'encombrement */
    }
     .interet-item .item-actions .edit-item-btn:hover i { color: var(--bs-primary-dark, #0a58ca); }
     .interet-item .item-actions .delete-item-btn:hover i { color: var(--bs-danger-dark, #b02a37); }


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
    }

    /* Responsive */
    @media (max-width: 1199.98px) {
        .interet-grid { grid-template-columns: repeat(4, 1fr); } /* 4 colonnes sur grand écran */
    }
    @media (max-width: 991.98px) {
        .interet-grid { grid-template-columns: repeat(3, 1fr); } /* 3 colonnes sur tablette */
    }
    @media (max-width: 767.98px) {
        .interet-grid { grid-template-columns: repeat(2, 1fr); } /* 2 colonnes sur mobile */
    }
    @media (max-width: 575.98px) {
        .interet-grid { grid-template-columns: repeat(2, 1fr); } /* 2 colonnes sur très petit écran */
        .interet-item .item-actions { /* Ajuster position/gap sur petits écrans */
             top: 0.2rem;
             right: 0.2rem;
             gap: 0.3rem;
        }
         .interet-nom { font-size: 0.85em; }
    }

    /* Variables (si non définies globalement) */
    :root {
        --primary-color: #0d6efd;
        --bs-danger: #dc3545;
        --bs-primary: #0d6efd;
        /* Ajouter d'autres si nécessaire */
    }
</style>