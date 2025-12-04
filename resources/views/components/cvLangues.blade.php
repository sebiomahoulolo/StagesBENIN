<div class="form-section">
    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <div class="langue-add-form">
        <h5 style="margin-bottom: 1.5rem; color: var(--primary-color, #007bff);">Ajouter une nouvelle langue</h5>
        <form method="POST" action="{{ route('langues.store') }}">
            @csrf
            <div class="row mb-3">
                <div class="col-md-6 form-group">
                    <label for="new_lang_nom" class="form-label">Langue <span class="text-danger">*</span></label>
                    <input type="text" id="new_lang_nom" name="langue" class="form-control form-control-sm" required>
                </div>
                <div class="col-md-6 form-group">
                    <label for="new_lang_niveau" class="form-label">Niveau <span class="text-danger">*</span></label>
                    <select id="new_lang_niveau" name="niveau" class="form-control form-control-sm" required>
                        <option value="">-- Choisir --</option>
                        <option value="Débutant">Débutant</option>
                        <option value="Intermédiaire">Intermédiaire</option>
                        <option value="Avancé">Avancé</option>
                        <option value="Bilingue">Bilingue</option>
                        <option value="Natif">Natif</option>
                    </select>
                </div>
            </div>
            <div class="mt-3 text-end">
                <button type="submit" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus"></i> Ajouter Langue
                </button>
            </div>
        </form>
    </div>

    </div>

<style>
    .form-section { margin-bottom: 2rem; }
    .form-section-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; padding-bottom: 0.75rem; border-bottom: 1px solid #dee2e6; }
    .form-section-header h4 { margin: 0; color: #343a40; }
    .add-item-btn span { margin-left: 0.3rem; }

    .langue-add-form {
        margin-top: 1.5rem;
        padding: 1.5rem;
        border: 1px solid #dee2e6;
        border-radius: 0.375rem;
        background-color: #f8f9fa;
    }

    .langue-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 1rem;
    }

    .langue-card {
        background-color: #fff;
        border: 1px solid #e9ecef;
        border-radius: 0.375rem;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        padding: 1rem;
        position: relative;
        transition: box-shadow 0.2s ease-in-out;
        display: flex;
        flex-direction: column;
    }
    .langue-card:hover {
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
    }
    .langue-card:hover .item-actions,
    .langue-card:focus-within .item-actions {
        opacity: 1;
    }

    .langue-card-body {
        flex-grow: 1;
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        padding-top: 5px;
    }
    .langue-name {
        font-weight: 600;
        color: var(--secondary-color, #343a40);
        margin-bottom: 0.3rem;
        overflow-wrap: break-word;
        word-break: break-word;
    }
    .langue-level {
        font-size: 0.85em;
        color: var(--dark-gray, #343a40);
        background-color: #e9ecef;
        padding: 2px 8px;
        border-radius: 4px;
        white-space: nowrap;
    }

    .langue-card .item-actions {
        position: absolute;
        top: 0.5rem;
        right: 0.5rem;
        display: flex;
        gap: 0.6rem;
        opacity: 0;
        transition: opacity 0.2s ease-in-out;
        z-index: 5;
        background-color: rgba(255, 255, 255, 0.7);
        padding: 3px 5px;
        border-radius: 4px;
    }
    .langue-card .item-actions .edit-item-btn,
    .langue-card .item-actions .delete-item-btn {
        font-size: 0.9rem;
        padding: 0;
        background: none;
        border: none;
        line-height: 1;
        cursor: pointer;
    }
    .langue-card .item-actions .edit-item-btn { color: var(--bs-primary, #0d6efd); }
    .langue-card .item-actions .delete-item-btn { color: var(--bs-danger, #dc3545); }
    .langue-card .item-actions .edit-item-btn:hover,
    .langue-card .item-actions .delete-item-btn:hover {
        opacity: 0.7;
    }

    .langue-editing-item {
        grid-column: 1 / -1;
        margin-bottom: 1.5rem;
        padding: 1.5rem;
        border: 1px solid #dee2e6;
        border-radius: 0.375rem;
        background-color: #f8f9fa;
    }
    .langue-editing-item h6 {
        color: var(--primary-color, #007bff);
        margin-bottom: 1.5rem;
    }

    .langue-grid-empty {
        text-align: center;
        color: var(--dark-gray, #6c757d);
        padding: 1.5rem;
        border: 1px dashed #ced4da !important;
        grid-column: 1 / -1;
        border-radius: 4px;
        margin-top: 1rem;
    }

    .langue-add-form .form-label,
    .langue-editing-item .form-label {
        font-size: 0.875rem;
        margin-bottom: 0.25rem;
    }
    .langue-add-form .form-control-sm,
    .langue-editing-item .form-control-sm {
        font-size: 0.875rem;
    }
    .text-danger { color: #dc3545 !important; }

    @media (max-width: 991.98px) {
        .langue-add-form .col-md-6,
        .langue-editing-item .col-md-6 {
            flex: 0 0 100%;
            max-width: 100%;
        }
        .langue-add-form .row > .col-md-6:not(:last-child),
        .langue-editing-item .row > .col-md-6:not(:last-child) {
            margin-bottom: 1rem;
        }
    }
    @media (max-width: 767.98px) {
        .langue-grid {
            gap: 0.75rem;
        }
        .langue-grid {
            grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
        }
        .form-section-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 0.5rem;
        }
    }
    @media (max-width: 575.98px) {
        .langue-grid {
            grid-template-columns: 1fr;
        }
    }

    :root {
        --primary-color: #0d6efd;
        --secondary-color: #6c757d;
        --dark-gray: #343a40;
        --bs-primary: #0d6efd;
        --bs-danger: #dc3545;
    }
</style>
