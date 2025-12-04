<div class="form-section">

@if(isset($cvProfile) && $cvProfile)
    <!-- Mode lecture seule -->
    <div id="profile-readonly-section">
        <div class="row profile-form-row">
            <div class="col-md-6 form-group">
                <label class="form-label">Nom Complet</label>
                <div>{{ $cvProfile->username }}</div>
            </div>
            <div class="col-md-6 form-group">
                <label class="form-label">Fonction</label>
                <div>{{ $cvProfile->title }}</div>
            </div>
        </div>
        <div class="row profile-form-row">
            <div class="col-md-6 form-group">
                <label class="form-label">Email contact (CV)</label>
                <div>{{ $cvProfile->email }}</div>
            </div>
            <div class="col-md-6 form-group">
                <label class="form-label">Téléphone (CV)</label>
                <div>{{ $cvProfile->phone }}</div>
            </div>
        </div>
        <div class="row profile-form-row">
            <div class="col-md-6 form-group">
                <label class="form-label">Adresse / Ville</label>
                <div>{{ $cvProfile->city }}</div>
            </div>
            <div class="col-md-6 form-group">
                <label class="form-label">URL LinkedIn</label>
                <div>{{ $cvProfile->url_linkedin }}</div>
            </div>
        </div>
        <div class="row profile-form-row">
            <div class="col-md-6 form-group">
                <label class="form-label">URL Portfolio/Site/GitHub</label>
                <div>{{ $cvProfile->url_portfolio }}</div>
            </div>
            <div class="col-md-6 form-group">
                <label class="form-label">Photo CV</label>
                @if($cvProfile->photo)
                    <div><img src="{{ asset('cv/' . $cvProfile->photo) }}" alt="Photo actuelle" style="max-width:80px; max-height:80px;"></div>
                @else
                    <div>-</div>
                @endif
            </div>
        </div>
        <div class="row profile-form-row">
            <div class="col-md-6 form-group">
                <label class="form-label">Situation Matrimoniale</label>
                <div>{{ $cvProfile->situation_mat }}</div>
            </div>
            <div class="col-md-6 form-group">
                <label class="form-label">Nationalité</label>
                <div>{{ $cvProfile->nationality }}</div>
            </div>
        </div>
        <div class="row profile-form-row">
            <div class="col-md-6 form-group">
                <label class="form-label">Date de Naissance</label>
                <div>{{ $cvProfile->birthday }}</div>
            </div>
            <div class="col-md-6 form-group">
                <label class="form-label">Lieu de Naissance</label>
                <div>{{ $cvProfile->lieu_naissance }}</div>
            </div>
        </div>
        <div class="form-group">
            <label class="form-label">Résumé du Profil</label>
            <div>{{ $cvProfile->resume }}</div>
        </div>
        <button type="button" class="btn btn-outline-primary btn-sm" id="show-edit-profile-btn">Modifier</button>
    </div>
    <!-- Formulaire d'édition masqué par défaut -->
    <div id="edit-profile-form-section" style="display:none; margin-top: 2rem;">
        <form class="profile-form" method="POST" action="{{ route('cv-profils.update', $cvProfile->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row profile-form-row">
                <div class="col-md-6 form-group">
                    <label class="form-label">Nom Complet <span class="text-danger fw-bold">*</span></label>
                    <input type="text" id="profile_nom_complet" name="username" class="form-control" required value="{{ old('username', $cvProfile->username ?? '') }}">
                </div>
                <div class="col-md-6 form-group">
                    <label for="profile_titre" class="form-label">Fonction <span style="color:red">*</span></label>
                    <input type="text" id="profile_titre" name="title" class="form-control" required value="{{ old('title', $cvProfile->title ?? '') }}">
                </div>
            </div>
            <div class="row profile-form-row">
                <div class="col-md-6 form-group">
                    <label for="profile_email" class="form-label">Email contact (CV) <span class="text-danger fw-bold">*</span></label>
                    <input type="email" id="profile_email" name="email" class="form-control" value="{{ old('email', $cvProfile->email ?? '') }}" placeholder="Par défaut: john.doe@example.com">
                </div>
                <div class="col-md-6 form-group">
                    <label for="profile_telephone" class="form-label">Téléphone (CV) <span class="text-danger fw-bold">*</span></label>
                    <input type="tel" id="profile_telephone" name="phone" class="form-control" value="{{ old('phone', $cvProfile->phone ?? '') }}" placeholder="Par défaut: +33 6 12 34 56 78">
                </div>
            </div>
            <div class="row profile-form-row">
                <div class="col-md-6 form-group">
                    <label for="profile_adresse" class="form-label">Adresse / Ville <span class="text-danger fw-bold">*</span></label>
                    <input type="text" id="profile_adresse" name="city" class="form-control" value="{{ old('city', $cvProfile->city ?? '') }}">
                </div>
                <div class="col-md-6 form-group">
                    <label for="profile_linkedin" class="form-label">URL LinkedIn</label>
                    <input type="url" id="profile_linkedin" name="url_linkedin" class="form-control" value="{{ old('url_linkedin', $cvProfile->url_linkedin ?? '') }}" placeholder="https://linkedin.com/in/...">
                </div>
            </div>
            <div class="row profile-form-row">
                <div class="col-md-6 form-group">
                    <label for="profile_portfolio" class="form-label">URL Portfolio/Site/GitHub</label>
                    <input type="url" id="profile_portfolio" name="url_portfolio" class="form-control" value="{{ old('url_portfolio', $cvProfile->url_portfolio ?? '') }}" placeholder="https://votresite.com">
                </div>
                <div class="col-md-6 form-group">
                    <label for="profile_photo_cv" class="form-label">Photo CV (Max 2Mo)</label>
                    <input type="file" id="profile_photo_cv" name="photo" class="form-control" accept="image/png, image/jpeg, image/jpg">
                    @if($cvProfile->photo)
                        <div style="margin-top: 10px;"><img src="{{ asset('cv/' . $cvProfile->photo) }}" alt="Photo actuelle" style="max-width:80px; max-height:80px;"></div>
                    @endif
                </div>
            </div>
            <div class="row profile-form-row">
                <div class="col-md-6 form-group">
                    <label for="profile_sit_mat" class="form-label">Situation Matrimoniale <span class="text-danger fw-bold">*</span></label>
                    <select id="profile_sit_mat" name="situation_mat" class="form-control" required>
                        <option value="">-- Choisir --</option>
                        <option value="Célibataire" @if(old('situation_mat', $cvProfile->situation_mat ?? '')=='Célibataire') selected @endif>Célibataire</option>
                        <option value="Marié(e)" @if(old('situation_mat', $cvProfile->situation_mat ?? '')=='Marié(e)') selected @endif>Marié(e)</option>
                        <option value="Divorcé(e)" @if(old('situation_mat', $cvProfile->situation_mat ?? '')=='Divorcé(e)') selected @endif>Divorcé(e)</option>
                        <option value="Veuf(ve)" @if(old('situation_mat', $cvProfile->situation_mat ?? '')=='Veuf(ve)') selected @endif>Veuf(ve)</option>
                        <option value="Autre" @if(old('situation_mat', $cvProfile->situation_mat ?? '')=='Autre') selected @endif>Autre</option>
                    </select>
                </div>
                <div class="col-md-6 form-group">
                    <label for="profile_nationalite" class="form-label">Nationalité <span class="text-danger fw-bold">*</span></label>
                    <input type="text" id="profile_nationalite" name="nationality" class="form-control" value="{{ old('nationality', $cvProfile->nationality ?? '') }}" required>
                </div>
            </div>
            <div class="row profile-form-row">
                <div class="col-md-6 form-group">
                    <label for="profile_date_nais" class="form-label">Date de Naissance <span class="text-danger fw-bold">*</span></label>
                    <input type="date" id="profile_date_nais" name="birthday" class="form-control" value="{{ old('birthday', $cvProfile->birthday ?? '') }}" required>
                </div>
                <div class="col-md-6 form-group">
                    <label for="profile_lieu_nais" class="form-label">Lieu de Naissance <span class="text-danger fw-bold">*</span></label>
                    <input type="text" id="profile_lieu_nais" name="lieu_naissance" class="form-control" value="{{ old('lieu_naissance', $cvProfile->lieu_naissance ?? '') }}" required>
                </div>
            </div>
            <div class="form-group">
                <label for="resume_profil_textarea" class="form-label">Résumé du Profil <span class="text-danger fw-bold">*</span></label>
                <textarea id="profile_resume" name="resume" class="form-control" rows="5" placeholder="Décrivez brièvement votre objectif professionnel, vos points forts...">{{ old('resume', $cvProfile->resume ?? '') }}</textarea>
            </div>
            <button type="submit" class="btn btn-primary btn-sm" id="save_profile">
                <i class="fas fa-save"></i> <span>Enregistrer</span>
            </button>
           </form>
    </div>
@else
    <!-- Formulaire d'ajout si aucun profil -->
    <form class="profile-form" method="POST" action="{{ route('cvprofils.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="row profile-form-row">
            <div class="col-md-6 form-group">
                <label class="form-label">Nom Complet <span class="text-danger fw-bold">*</span></label>
                <input type="text" id="profile_nom_complet" name="username" class="form-control" required value="{{ old('username') }}">
            </div>
            <div class="col-md-6 form-group">
                <label for="profile_titre" class="form-label">Fonction <span style="color:red">*</span></label>
                <input type="text" id="profile_titre" name="title" class="form-control" required value="{{ old('title') }}">
            </div>
        </div>
        <div class="row profile-form-row">
            <div class="col-md-6 form-group">
                <label for="profile_email" class="form-label">Email contact (CV) <span class="text-danger fw-bold">*</span></label>
                <input type="email" id="profile_email" name="email" class="form-control" value="{{ old('email') }}" placeholder="Par défaut: john.doe@example.com">
            </div>
            <div class="col-md-6 form-group">
                <label for="profile_telephone" class="form-label">Téléphone (CV) <span class="text-danger fw-bold">*</span></label>
                <input type="tel" id="profile_telephone" name="phone" class="form-control" value="{{ old('phone') }}" placeholder="Par défaut: +33 6 12 34 56 78">
            </div>
        </div>
        <div class="row profile-form-row">
            <div class="col-md-6 form-group">
                <label for="profile_adresse" class="form-label">Adresse / Ville <span class="text-danger fw-bold">*</span></label>
                <input type="text" id="profile_adresse" name="city" class="form-control" value="{{ old('city') }}">
            </div>
            <div class="col-md-6 form-group">
                <label for="profile_linkedin" class="form-label">URL LinkedIn</label>
                <input type="url" id="profile_linkedin" name="url_linkedin" class="form-control" value="{{ old('url_linkedin') }}" placeholder="https://linkedin.com/in/...">
            </div>
        </div>
        <div class="row profile-form-row">
            <div class="col-md-6 form-group">
                <label for="profile_portfolio" class="form-label">URL Portfolio/Site/GitHub</label>
                <input type="url" id="profile_portfolio" name="url_portfolio" class="form-control" value="{{ old('url_portfolio') }}" placeholder="https://votresite.com">
            </div>
            <div class="col-md-6 form-group">
                <label for="profile_photo_cv" class="form-label">Photo CV (Max 2Mo)</label>
                <input type="file" id="profile_photo_cv" name="photo" class="form-control" accept="image/png, image/jpeg, image/jpg">
            </div>
        </div>
        <div class="row profile-form-row">
            <div class="col-md-6 form-group">
                <label for="profile_sit_mat" class="form-label">Situation Matrimoniale <span class="text-danger fw-bold">*</span></label>
                <select id="profile_sit_mat" name="situation_mat" class="form-control" required>
                    <option value="">-- Choisir --</option>
                    <option value="Célibataire" @if(old('situation_mat')=='Célibataire') selected @endif>Célibataire</option>
                    <option value="Marié(e)" @if(old('situation_mat')=='Marié(e)') selected @endif>Marié(e)</option>
                    <option value="Divorcé(e)" @if(old('situation_mat')=='Divorcé(e)') selected @endif>Divorcé(e)</option>
                    <option value="Veuf(ve)" @if(old('situation_mat')=='Veuf(ve)') selected @endif>Veuf(ve)</option>
                    <option value="Autre" @if(old('situation_mat')=='Autre') selected @endif>Autre</option>
                </select>
            </div>
            <div class="col-md-6 form-group">
                <label for="profile_nationalite" class="form-label">Nationalité <span class="text-danger fw-bold">*</span></label>
                <input type="text" id="profile_nationalite" name="nationality" class="form-control" value="{{ old('nationality') }}" required>
            </div>
        </div>
        <div class="row profile-form-row">
            <div class="col-md-6 form-group">
                <label for="profile_date_nais" class="form-label">Date de Naissance <span class="text-danger fw-bold">*</span></label>
                <input type="date" id="profile_date_nais" name="birthday" class="form-control" value="{{ old('birthday') }}" required>
            </div>
            <div class="col-md-6 form-group">
                <label for="profile_lieu_nais" class="form-label">Lieu de Naissance <span class="text-danger fw-bold">*</span></label>
                <input type="text" id="profile_lieu_nais" name="lieu_naissance" class="form-control" value="{{ old('lieu_naissance') }}" required>
            </div>
        </div>
        <div class="form-group">
            <label for="resume_profil_textarea" class="form-label">Résumé du Profil <span class="text-danger fw-bold">*</span></label>
            <textarea id="profile_resume" name="resume" class="form-control" rows="5" placeholder="Décrivez brièvement votre objectif professionnel, vos points forts...">{{ old('resume') }}</textarea>
        </div>
        <button type="submit" class="btn btn-primary btn-sm" id="save_profile">
            <i class="fas fa-save"></i> <span>Enregistrer</span>
        </button>
    </form>
@endif
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var showEditBtn = document.getElementById('show-edit-profile-btn');
    var editFormSection = document.getElementById('edit-profile-form-section');
    var cancelEditBtn = document.getElementById('cancel-edit-profile-btn');
    var readOnlySection = document.getElementById('profile-readonly-section');
    if(showEditBtn && editFormSection && readOnlySection) {
        showEditBtn.addEventListener('click', function() {
            editFormSection.style.display = 'block';
            readOnlySection.style.display = 'none';
        });
    }
    if(cancelEditBtn && editFormSection && readOnlySection) {
        cancelEditBtn.addEventListener('click', function() {
            editFormSection.style.display = 'none';
            readOnlySection.style.display = 'block';
        });
    }
});
</script>

<style>
    .form-section {
        margin-bottom: 2rem;
    }

    .form-section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 0.5rem;
        margin-bottom: 1.5rem;
        padding-bottom: 0.75rem;
        border-bottom: 1px solid #dee2e6;
    }

    .form-section-header h4 {
        margin: 0;
        color: #343a40;
    }

    .add-item-btn span {
        margin-left: 0.3rem;
    }

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
        margin-bottom: 0.25rem;
        overflow-wrap: break-word;
    }

    .formation-card-subtitle {
        margin-bottom: 0.5rem;
        overflow-wrap: break-word;
    }

    .formation-card-dates {
        margin-bottom: 1rem;
        border-bottom: 1px dashed #dee2e6;
        padding-bottom: 0.75rem;
    }

    .formation-card-description {
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
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
    }

    .btn-action-icon i {
        vertical-align: middle;
    }

    .formation-direct-actions .text-primary {
        color: var(--bs-primary, #0d6efd) !important;
    }

    .formation-direct-actions .text-danger {
        color: var(--bs-danger, #dc3545) !important;
    }

    .btn-action-icon:hover {
        background: rgba(240, 240, 240, 0.9);
        opacity: 1;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.15);
    }

    .form-label {
        margin-bottom: 0.25rem;
    }

    .text-danger {
        color: #dc3545 !important;
    }

    .profile-form-row .form-group {
        margin-bottom: 1rem;
    }

    @media (max-width: 767.98px) {
        .formation-grid {
            gap: 0.75rem;
        }

        .formation-card {
            padding: 1rem;
        }

        .formation-card-body {
            padding-right: 40px;
        }

        .formation-card-dates {
            margin-bottom: 0.75rem;
            padding-bottom: 0.5rem;
        }

        .form-section-header {
            flex-direction: column;
            align-items: flex-start;
        }

        .formation-add-form .row>div {
            flex: 0 0 100% !important;
            max-width: 100%;
            margin-bottom: 1rem;
        }

        .formation-add-form {
            padding: 1.25rem;
        }

        .add-item-btn {
            width: 100%;
        }

        .mt-3.text-end {
            text-align: center !important;
        }

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
        .formation-card-body {
            padding-right: 35px;
        }

        .btn-action-icon {
            width: 28px;
            height: 28px;
        }

        .formation-add-form {
            padding: 1rem !important;
        }

        .formation-grid {
            gap: 0.5rem;
        }

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
