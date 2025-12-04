<div class="form-section">
    <div class="form-section-header">
        <h4>Références</h4>
    </div>

    <div class="reference-add-form mt-4 p-4 border rounded shadow-sm bg-light">
        <h5 style="margin-bottom: 1.5rem; color: var(--primary-color, #007bff);">Ajouter une nouvelle référence</h5>
        <form method="POST" action="{{ route('references.store') }}">
            @csrf
            <div class="row mb-3">
                {{-- <div class="col-md-6 form-group">
                    <label for="new_ref_prenom" class="form-label">Prénom <span class="text-danger">*</span></label>
                    <input type="text" id="new_ref_prenom" name="prenom" class="form-control form-control-sm" required>
                </div> --}}
                <div class="col-md-6 form-group">
                    <label for="new_ref_nom" class="form-label">Nom  complet <span class="text-danger">*</span></label>
                    <input type="text" id="new_ref_nom" name="nom" class="form-control form-control-sm" required>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6 form-group">
                    <label for="new_ref_contact" class="form-label">Contact (Email/Tél) <span class="text-danger">*</span></label>
                    <input type="text" id="new_ref_contact" name="telephone" class="form-control form-control-sm" required>
                </div>
                <div class="col-md-6 form-group">
                    <label for="new_ref_poste" class="form-label">Poste</label>
                    <input type="text" id="new_ref_poste" name="relation" class="form-control form-control-sm">
                </div>
            </div>
            <div class="form-group mb-3">
                <label for="new_ref_relation" class="form-label">Relation</label>
                <textarea id="new_ref_relation" name="commentaire"
                          class="form-control form-control-sm"
                          rows="2"
                          maxlength="255"
                          placeholder="Ex: Superviseur de stage, Professeur, etc."></textarea>
            </div>

            <div class="mt-3 text-end">
                <button type="submit" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus"></i> Ajouter Référence
                </button>
            </div>
        </form>
    </div>

     </div>

<style>
    /* Styles généraux */
    .form-section { margin-bottom: 2rem; }
    .form-section-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; padding-bottom: 0.75rem; border-bottom: 1px solid #dee2e6; }
    .form-section-header h4 { margin: 0; color: #343a40; }
    .add-item-btn span { margin-left: 0.3rem; }

    /* Formulaire ajout/édition */
    .reference-add-form {
        background-color: #f8f9fa;
    }
    .form-label { font-size: 0.875rem; margin-bottom: 0.25rem; }
    .form-control-sm { font-size: 0.875rem; }
    .text-danger { color: #dc3545 !important; }

    /* Liste des références */
    .reference-list {
        display: grid;
        grid-template-columns: 1fr;
        gap: 1rem;
    }

    /* Item référence (carte) */
    .form-repeater-item {
        border: 1px solid #e9ecef;
        border-radius: 0.375rem;
        position: relative;
        background-color: #fff;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        transition: box-shadow 0.2s ease-in-out;
        padding: 1rem 1.25rem;
    }
    .reference-card:hover {
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
    }
    .reference-card:hover .item-actions,
    .reference-card:focus-within .item-actions {
        opacity: 1;
    }

    /* Actions (Modifier/Supprimer) */
    .item-actions {
        position: absolute;
        top: 0.5rem;
        right: 0.5rem;
        display: flex;
        flex-direction: column;
        gap: 0.4rem;
        opacity: 0;
        transition: opacity 0.2s ease-in-out;
        z-index: 10;
    }
    .btn-action-icon {
        background: rgba(255, 255, 255, 0.7);
        border: none;
        border-radius: 50%;
        width: 28px;
        height: 28px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0;
        cursor: pointer;
        line-height: 1;
    }
    .btn-action-icon i {
        font-size: 0.8rem;
        vertical-align: middle;
    }
    .btn-action-icon.edit-item-btn { color: var(--bs-primary, #0d6efd); }
    .btn-action-icon.delete-item-btn { color: var(--bs-danger, #dc3545); }
    .btn-action-icon:hover {
        background: rgba(230, 230, 230, 0.9);
        opacity: 1;
    }

    /* Styles du contenu de la carte */
    .reference-card-body {
        padding-right: 50px;
    }
    .ref-name { font-weight: 600; color: var(--secondary-color, #6c757d); margin-bottom: 0.1rem; }
    .ref-poste { font-size: 0.9em; color: var(--primary-color, #0056b3); margin-bottom: 0.1rem; }
    .ref-contact { font-size: 0.9em; color: var(--dark-gray, #343a40); margin-bottom: 0.3rem; }
    .ref-relation { font-size: 0.85em; color: #555; margin-bottom: 0; font-style: italic; }

    /* Responsive */
    @media (max-width: 767.98px) {
        .form-repeater-item {
            padding: 0.75rem 1rem;
        }
        .ref-name { font-size: 1rem; }
        .ref-poste, .ref-contact { font-size: 0.85em; }
        .ref-relation { font-size: 0.8em; }
        .form-section-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 0.5rem;
        }
        .reference-add-form .col-md-6 {
            flex: 0 0 100%;
            max-width: 100%;
        }
        .reference-add-form .row > div:not(:last-child) {
            margin-bottom: 1rem;
        }
    }

    /* Variables */
    :root {
        --primary-color: #0d6efd;
        --secondary-color: #6c757d;
        --dark-gray: #343a40;
        --bs-primary: #0d6efd;
        --bs-danger: #dc3545;
        --border-light: #dee2e6;
    }
</style>
