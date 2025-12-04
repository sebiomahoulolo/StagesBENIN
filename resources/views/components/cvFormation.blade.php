<div class="form-section">

        <div class="formation-add-form mt-4 p-4 border rounded shadow-sm bg-light">
            <h5 style="margin-bottom: 1.5rem; color: var(--primary-color, #007bff);">Ajouter une nouvelle formation</h5>
            <form action="{{ route('formations.store') }}" method="POST">
                @csrf
                <div class="row mb-3">
                    <div class="col-md-6 form-group">
                        <label for="new_form_diplome" class="form-label">Diplôme <span class="text-danger">*</span></label>
                        <input type="text" id="new_form_diplome" name="diplome" class="form-control form-control-sm" required>
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="new_form_etablissement" class="form-label">Établissement <span class="text-danger">*</span></label>
                        <input type="text" id="new_form_etablissement" name="etablissement" class="form-control form-control-sm" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4 form-group">
                        <label for="new_form_ville" class="form-label">Ville</label>
                        <input type="text" id="new_form_ville" name="ville" class="form-control form-control-sm">
                    </div>
                    <div class="col-md-4 form-group">
                        <label for="new_form_annee_debut" class="form-label">Année Début <span class="text-danger">*</span></label>
                        <input type="number" id="new_form_annee_debut" name="annee_debut" class="form-control form-control-sm" required min="1950" max="2025" placeholder="Ex: 2022">
                    </div>
                    <div class="col-md-4 form-group">
                        <label for="new_form_annee_fin" class="form-label">Année Fin (ou laisser vide)</label>
                        <input type="number" id="new_form_annee_fin" name="annee_fin" class="form-control form-control-sm" min="1950" max="2025" placeholder="Ex: 2024">
                    </div>
                </div>
                <div class="form-group mb-3">
                    <label for="new_form_desc" class="form-label">Description (optionnel)</label>
                    <textarea id="new_form_desc" name="description" class="form-control form-control-sm" rows="3" maxlength="1000" placeholder="Détails supplémentaires, matières principales..."></textarea>
                </div>
                <div class="mt-3 text-end">
                    <button type="submit" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i> Ajouter Formation
                    </button>
                </div>
            </form>
        </div>

        <div class="formation-grid mt-4">
            <div class="formation-card">
                <div class="formation-card-body">
                    <div class="formation-direct-actions">
                        <button type="button" class="btn-action-icon" title="Modifier" aria-label="Modifier la formation">
                            <i class="fas fa-pencil-alt text-primary"></i>
                        </button>
                        <button type="button" class="btn-action-icon" title="Supprimer" aria-label="Supprimer la formation">
                            <i class="fas fa-trash text-danger"></i>
                        </button>
                    </div>
                    <!-- <h5 class="formation-card-title">Diplôme d'Ingénieur</h5>
                    <p class="formation-card-subtitle">École Polytechnique - Paris</p>
                    <p class="formation-card-dates">2020 - 2023</p>
                    <p class="formation-card-description">Spécialisation en Intelligence Artificielle et Machine Learning</p> -->
                </div>
            </div>
        </div>
    </div>

    <style>
        .form-section { margin-bottom: 2rem; }
        .form-section-header { display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 0.5rem; margin-bottom: 1.5rem; padding-bottom: 0.75rem; border-bottom: 1px solid #dee2e6; }
        .form-section-header h4 { margin: 0; color: #343a40; }
        .add-item-btn span { margin-left: 0.3rem; }

        .formation-add-form {
            background-color: #f8f9fa;
            padding: 1.5rem;
            border: 1px solid #dee2e6;
            border-radius: 0.375rem;
        }

        .formation-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 1rem;
        }

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
            overflow: hidden;
        }

        .formation-card:hover {
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
        }

        .formation-card:hover .formation-direct-actions,
        .formation-card:focus-within .formation-direct-actions {
            opacity: 1;
        }

        .formation-card-body {
            flex-grow: 1;
            padding-right: 40px;
            word-break: break-word;
        }

        .formation-card-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--secondary-color, #6c757d);
            margin-bottom: 0.25rem;
            overflow-wrap: break-word;
        }

        .formation-card-subtitle {
            font-size: 0.95rem;
            color: var(--primary-color, #0056b3);
            margin-bottom: 0.5rem;
            overflow-wrap: break-word;
        }

        .formation-card-dates {
            font-size: 0.85rem;
            color: #6c757d;
            margin-bottom: 1rem;
            border-bottom: 1px dashed #dee2e6;
            padding-bottom: 0.75rem;
        }

        .formation-card-description {
            font-size: 0.9rem;
            color: #343a40;
            margin-top: 1rem;
            line-height: 1.5;
            white-space: pre-wrap;
            overflow-wrap: break-word;
        }

        .formation-direct-actions {
            position: absolute;
            top: 0.5rem;
            right: 0.5rem;
            display: flex;
            flex-direction: column;
            gap: 0.4rem;
            z-index: 5;
            opacity: 0;
            transition: opacity 0.2s ease-in-out;
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

        .formation-direct-actions .text-primary { color: var(--bs-primary, #0d6efd) !important; }
        .formation-direct-actions .text-danger { color: var(--bs-danger, #dc3545) !important; }

        .btn-action-icon:hover {
            background: rgba(240, 240, 240, 0.9);
            opacity: 1;
            box-shadow: 0 1px 3px rgba(0,0,0,0.15);
        }

        .form-label { font-size: 0.875rem; margin-bottom: 0.25rem; }
        .form-control-sm { font-size: 0.875rem; }
        .text-danger { color: #dc3545 !important; }

        @media (max-width: 767.98px) {
            .formation-grid { gap: 0.75rem; }
            .formation-card { padding: 1rem; }
            .formation-card-body { padding-right: 40px; }
            .formation-card-title { font-size: 1rem; }
            .formation-card-subtitle { font-size: 0.9rem; }
            .formation-card-dates { font-size: 0.8rem; margin-bottom: 0.75rem; padding-bottom: 0.5rem; }
            .formation-card-description { font-size: 0.85rem; }
            .form-section-header {
                flex-direction: column;
                align-items: flex-start;
            }
            .formation-add-form .row > div {
                flex: 0 0 100% !important;
                max-width: 100%;
                margin-bottom: 1rem;
            }
            .formation-add-form { padding: 1.25rem; }
            .add-item-btn { width: 100%; }
            .mt-3.text-end { text-align: center !important; }
            .mt-3.text-end button {
                width: 100%;
                padding: 0.5rem 1rem;
            }
        }

        @media (max-width: 575.98px) {
            .formation-card-body { padding-right: 35px; }
            .btn-action-icon { width: 28px; height: 28px; }
            .btn-action-icon i { font-size: 0.8rem; }
            .formation-add-form { padding: 1rem !important; }
            .form-label, .form-control-sm { font-size: 0.85rem; }
            .formation-grid { gap: 0.5rem; }
            .btn-sm {
                font-size: 0.8rem;
                padding: 0.3rem 0.6rem;
            }
        }

        :root {
            --primary-color: #0d6efd;
            --secondary-color: #6c757d;
            --dark-gray: #343a40;
            --primary-color-light: #6caeff;
            --bs-primary: #0d6efd;
            --bs-danger: #dc3545;
        }
    </style>
