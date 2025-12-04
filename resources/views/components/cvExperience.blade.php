<div class="form-section">

    <div class="experience-add-form mt-4 p-4 border rounded shadow-sm bg-light">
        <h5 style="margin-bottom: 1.5rem; color: var(--primary-color, #007bff);">Ajouter une nouvelle expérience</h5>
        <form action="{{ route('experiences.store') }}" method="POST">
            @csrf
            <div class="row mb-3">
                <div class="col-md-6 form-group">
                    <label for="new_exp_poste" class="form-label">Poste <span class="text-danger">*</span></label>
                    <input type="text" id="new_exp_poste" name="poste" class="form-control form-control-sm" required>
                </div>
                <div class="col-md-6 form-group">
                    <label for="new_exp_entreprise" class="form-label">Entreprise <span class="text-danger">*</span></label>
                    <input type="text" id="new_exp_entreprise" name="entreprise" class="form-control form-control-sm" required>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4 form-group">
                    <label for="new_exp_ville" class="form-label">Ville</label>
                    <input type="text" id="new_exp_ville" name="ville" class="form-control form-control-sm">
                </div>
                <div class="col-md-4 form-group">
                    <label for="new_exp_date_debut" class="form-label">Date Début <span class="text-danger">*</span></label>
                    <input type="month" id="new_exp_date_debut" name="date_debut" class="form-control form-control-sm" required placeholder="YYYY-MM">
                </div>
                <div class="col-md-4 form-group">
                    <label for="new_exp_date_fin" class="form-label">Date Fin (ou laisser vide si actuel)</label>
                    <input type="month" id="new_exp_date_fin" name="date_fin" class="form-control form-control-sm" placeholder="YYYY-MM">
                </div>
            </div>

            <div class="form-group mb-3">
                <label for="new_exp_desc" class="form-label">Description générale du poste</label>
                <textarea id="new_exp_desc" name="description"
                          class="form-control form-control-sm"
                          rows="3"
                          placeholder="Contexte, responsabilités principales..."
                          maxlength="1500">
                </textarea>
            </div>

            {{-- <div class="form-group mb-3">
                <label class="form-label">Tâches / Réalisations principales (1 par ligne, 3 max)</label>
                <input type="text" class="form-control form-control-sm mb-2" placeholder="Tâche/Réalisation 1" maxlength="255">
                <input type="text" class="form-control form-control-sm mb-2" placeholder="Tâche/Réalisation 2 (optionnel)" maxlength="255">
                <input type="text" class="form-control form-control-sm" placeholder="Tâche/Réalisation 3 (optionnel)" maxlength="255">
            </div> --}}

            <div class="mt-3 text-end">
                <button type="submit" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus"></i> Ajouter Expérience
                </button>
            </div>
        </form>
    </div>

    <!-- <div class="experience-grid mt-4">
        <div class="experience-card">
            <div class="experience-card-body">
                <div class="experience-direct-actions">
                    <button type="button" class="btn-action-icon" title="Modifier" aria-label="Modifier l'expérience">
                        <i class="fas fa-pencil-alt text-primary"></i>
                    </button>
                    <button type="button" class="btn-action-icon" title="Supprimer" aria-label="Supprimer l'expérience">
                        <i class="fas fa-trash text-danger"></i>
                    </button>
                </div>
                <h5 class="experience-card-title">Développeur Full Stack</h5>
                <p class="experience-card-subtitle">Tech Company - Paris</p>
                <p class="experience-card-dates">Janvier 2020 - Présent</p>
                <p class="experience-card-description">
                    Développement d'applications web modernes avec React et Node.js.
                    Gestion de projets et mentorat des juniors.
                </p>
                <div class="experience-card-tasks">
                    <strong>Réalisations :</strong>
                    <ul>
                        <li>Refonte complète de l'interface utilisateur</li>
                        <li>Optimisation des performances de 40%</li>
                        <li>Mise en place de l'architecture microservices</li>
                    </ul>
                </div>
            </div>
        </div>
    </div> -->
</div>

<style>
    .form-section { margin-bottom: 2rem; }
    .form-section-header { display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 0.5rem; margin-bottom: 1.5rem; padding-bottom: 0.75rem; border-bottom: 1px solid #dee2e6; }
    .form-section-header h4 { margin: 0; color: #343a40; }
    .add-item-btn span { margin-left: 0.3rem; }

    .experience-add-form {
        background-color: #f8f9fa;
        padding: 1.5rem;
        border: 1px solid #dee2e6;
        border-radius: 0.375rem;
    }

    .experience-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 1rem;
    }

    .experience-card {
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

    .experience-card:hover {
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
    }

    .experience-card:hover .experience-direct-actions,
    .experience-card:focus-within .experience-direct-actions {
        opacity: 1;
    }

    .experience-card-body {
        flex-grow: 1;
        padding-right: 40px;
        word-break: break-word;
    }

    .experience-card-title {
        margin-bottom: 0.25rem;
        overflow-wrap: break-word;
    }

    .experience-card-subtitle {
        margin-bottom: 0.5rem;
        overflow-wrap: break-word;
    }

    .experience-card-dates {
        margin-bottom: 1rem;
        border-bottom: 1px dashed #dee2e6;
        padding-bottom: 0.75rem;
    }

    .experience-card-description {
        margin-top: 1rem;
        line-height: 1.5;
        white-space: pre-wrap;
        overflow-wrap: break-word;
    }

    .experience-card-tasks {
        background-color: #f8f9fa;
        border-left: 3px solid var(--primary-color-light, #6caeff);
        padding: 0.75rem 1rem;
        margin-top: 1rem;
        border-radius: 0.25rem;
    }

    .experience-card-tasks strong {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: 500;
        color: #343a40;
    }

    .experience-card-tasks ul {
        list-style-type: disc;
        margin: 0 0 0 1.25rem;
        padding: 0;
        color: #495057;
    }

    .experience-card-tasks li {
        margin-bottom: 0.3rem;
        overflow-wrap: break-word;
    }

    .experience-card-tasks li:last-child {
        margin-bottom: 0;
    }

    .experience-direct-actions {
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
        vertical-align: middle;
    }

    .experience-direct-actions .text-primary { color: var(--bs-primary, #0d6efd) !important; }
    .experience-direct-actions .text-danger { color: var(--bs-danger, #dc3545) !important; }

    .btn-action-icon:hover {
        background: rgba(240, 240, 240, 0.9);
        opacity: 1;
        box-shadow: 0 1px 3px rgba(0,0,0,0.15);
    }

    .form-label { margin-bottom: 0.25rem; }
    .text-danger { color: #dc3545 !important; }

    .profile-form-row .form-group {
        margin-bottom: 1rem;
    }

    @media (max-width: 767.98px) {
        .experience-grid { gap: 0.75rem; }
        .experience-card { padding: 1rem; }
        .experience-card-body { padding-right: 40px; }
        .experience-card-dates { margin-bottom: 0.75rem; padding-bottom: 0.5rem; }
        .form-section-header {
            flex-direction: column;
            align-items: flex-start;
        }
        .experience-add-form .row > div {
            flex: 0 0 100% !important;
            max-width: 100%;
            margin-bottom: 1rem;
        }
        .experience-add-form { padding: 1.25rem; }
        .add-item-btn { width: 100%; }
        .mt-3.text-end { text-align: center !important; }
        .mt-3.text-end button {
            width: 100%;
            padding: 0.5rem 1rem;
        }
        .profile-form-row .form-group {
            margin-bottom: 0.75rem;
        }
        .profile-form-row {
            margin-bottom: 0.5rem;
        }
        .form-section-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 0.5rem;
        }
    }

    @media (max-width: 575.98px) {
        .experience-card-body { padding-right: 35px; }
        .btn-action-icon { width: 28px; height: 28px; }
        .experience-add-form { padding: 1rem !important; }
        .formation-grid { gap: 0.5rem; }
        .btn-sm {
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
