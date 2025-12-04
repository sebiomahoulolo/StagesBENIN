<div class="form-section">
    <div class="competence-add-form mt-4 p-4 border rounded shadow-sm bg-light">
        <h5 style="margin-bottom: 1.5rem; color: var(--primary-color, #007bff);">Ajouter une nouvelle compétence</h5>
        <form method="POST" action="{{ route('competences.store') }}">
            @csrf
            <div class="row align-items-end mb-3">
                <div class="col-md form-group mb-md-0 mb-3">
                    <label for="new_comp_cat" class="form-label">Catégorie <span style="color:red">*</span></label>
                    <input type="text" list="categories_list_all" id="new_comp_cat" name="categorie" class="form-control form-control-sm" required>
                </div>
                <div class="col-md form-group mb-md-0 mb-3">
                    <label for="new_comp_nom" class="form-label">Compétence <span style="color:red">*</span></label>
                    <input type="text" id="new_comp_nom" name="competence" class="form-control form-control-sm" required>
                </div>
                <div class="col-md-auto form-group mb-0">
                    <label for="new_comp_niveau" class="form-label">Niveau (%) <span style="color:red">*</span></label>
                    <div class="d-flex align-items-center competence-level-input">
                        <input type="range" id="new_comp_niveau_range" name="niveau" class="form-range form-range-sm" min="0" max="100" step="5" style="flex-grow: 1; margin-right: 10px;">
                        <input type="number" id="new_comp_niveau" name="niveau" class="form-control form-control-sm" min="0" max="100" step="5" required style="width: 70px; text-align: center;">
                    </div>
                </div>
            </div>
            <div class="mt-3 text-end">
                <button type="submit" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus"></i> Ajouter Compétence
                </button>
            </div>
        </form>
    </div>


     </div> 

<style>
    .form-section { margin-bottom: 2rem; }
    .form-section-header { display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 0.5rem; margin-bottom: 1.5rem; padding-bottom: 0.75rem; border-bottom: 1px solid #dee2e6; }
    .form-section-header h4 { margin: 0; color: #343a40; }
    .add-item-btn span { margin-left: 0.3rem; }

    .competence-add-form,
    .editing-item .p-3 {
        background-color: #f8f9fa;
        padding: 1.5rem;
        border: 1px solid #dee2e6;
        border-radius: 0.375rem;
    }

    .competence-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(230px, 1fr));
        gap: 1rem;
    }

    .competence-card {
        background-color: #fff;
        border: 1px solid #e9ecef;
        border-radius: 0.375rem;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        padding: 1rem;
        position: relative;
        transition: box-shadow 0.2s ease-in-out;
        overflow: hidden;
    }

    .competence-card:hover {
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
    }

    .competence-card:hover .item-actions,
    .competence-card:focus-within .item-actions {
        opacity: 1;
    }

    .competence-card-body {
        padding-right: 40px;
        word-break: break-word;
    }

    .skill-item {
        /* Pas de style spécifique nécessaire ici */
    }

    .skill-category {
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
        gap: 0.5rem;
    }

    .skill-name {
        line-height: 1.3;
        overflow-wrap: break-word;
    }

    .skill-level {
        white-space: nowrap;
        flex-shrink: 0;
    }

    .skill-progress {
        height: 6px;
        background-color: #e9ecef;
        border-radius: 3px;
        overflow: hidden;
        margin-top: 0.25rem;
    }

    .skill-progress .progress-bar {
        background-color: var(--primary-color, #0d6efd);
        height: 100%;
        transition: width 0.6s ease;
    }

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
        vertical-align: middle;
    }

    .btn-action-icon.edit-item-btn { color: var(--bs-primary, #0d6efd) !important; }
    .btn-action-icon.delete-item-btn { color: var(--bs-danger, #dc3545) !important; }

    .btn-action-icon:hover {
        background: rgba(240, 240, 240, 0.9);
        opacity: 1;
        box-shadow: 0 1px 3px rgba(0,0,0,0.15);
    }

    .editing-item {
        grid-column: 1 / -1;
        margin-bottom: 1rem;
    }

    .empty-message {
        grid-column: 1 / -1;
        text-align: center;
        color: var(--dark-gray, #6c757d);
        padding: 1rem;
        border: 1px dashed #ced4da !important;
        border-radius: 4px;
        margin-top: 1rem;
    }

    @media (max-width: 767.98px) {
        .competence-grid {
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 0.75rem;
        }
        .competence-card-body {
            padding-right: 40px;
        }
        .form-section-header {
            flex-direction: column;
            align-items: flex-start;
        }
        .competence-add-form .row > div:not(:last-child),
        .editing-item .row > div:not(:last-child) {
            margin-bottom: 1rem;
        }
        .competence-level-input {
            flex-wrap: wrap;
            gap: 0.5rem;
        }
        .competence-level-input .form-range {
            min-width: 100px;
        }
    }

    @media (max-width: 575.98px) {
        .competence-grid {
            grid-template-columns: 1fr;
        }
        .competence-card-body {
            padding-right: 35px;
        }
        .btn-action-icon { width: 28px; height: 28px; }
    }

    :root {
        --primary-color: #0d6efd;
        --secondary-color: #6c757d;
        --dark-gray: #343a40;
        --bs-primary: #0d6efd;
        --bs-danger: #dc3545;
    }
</style>
