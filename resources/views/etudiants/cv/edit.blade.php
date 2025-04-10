<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Éditeur de CV - StagesBENIN</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    {{-- Inclusion Trix Editor CSS --}}
    <link rel="stylesheet" type="text/css" href="https://unpkg.com/trix@2.0.8/dist/trix.css">

    <style>
        /* ===== Styles du Dashboard (normaux) ===== */
        :root { --primary-color: #3498db; --secondary-color: #2c3e50; --accent-color: #e74c3c; --success-color: #2ecc71; /* ... autres variables ... */ --border-color: #e0e0e0; }
        * { box-sizing: border-box; margin: 0; padding: 0; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        body { background-color: #f9f9f9; color: #333; line-height: 1.6; }
        header.app-header { background: linear-gradient(135deg, var(--primary-color), var(--secondary-color)); color: white; padding: 1rem 2rem; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 2px 10px rgba(0,0,0,0.1); position: sticky; top: 0; z-index: 1000; }
        .logo { font-size: 1.6rem; font-weight: bold; display: flex; align-items: center; }
        .logo i { margin-right: 10px; }
        .header-actions { display: flex; align-items: center; gap: 1.5rem; }
        .profile-image { width: 35px; height: 35px; border-radius: 50%; background-color: white; display: flex; align-items: center; justify-content: center; color: var(--primary-color); }
        .app-container { display: flex; }
        .app-sidebar { width: 250px; background-color: white; min-height: calc(100vh - 66px); box-shadow: 2px 0 10px rgba(0,0,0,0.05); position: sticky; top: 66px; overflow-y: auto; height: calc(100vh - 66px); }
        .sidebar-menu { padding: 1rem 0; }
        .menu-item { padding: 0.8rem 1.5rem; display: flex; align-items: center; color: #7f8c8d; text-decoration: none; transition: all 0.3s; font-size: 0.95rem; border-left: 3px solid transparent; }
        .menu-item i { margin-right: 10px; width: 20px; text-align: center; }
        .menu-item:hover { background-color: rgba(52, 152, 219, 0.1); color: var(--primary-color); }
        .menu-item.active { background-color: rgba(52, 152, 219, 0.1); color: var(--primary-color); border-left-color: var(--primary-color); font-weight: bold; }
        .main-content { flex: 1; padding: 2rem; overflow-y: auto; }
        .content-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; flex-wrap: wrap; gap: 1rem; }
        .welcome-message h1 { font-size: 1.8rem; color: var(--secondary-color); margin-bottom: 0.5rem; }
        .welcome-message p { color: #7f8c8d; }
        .quick-actions { display: flex; gap: 1rem; flex-wrap: wrap; }
        .action-button { padding: 0.7rem 1.5rem; background-color: var(--primary-color); color: white; border: none; border-radius: 4px; cursor: pointer; display: inline-flex; align-items: center; transition: all 0.3s; text-decoration: none; font-size: 0.9rem; }
        .action-button:hover { background-color: #2980b9; transform: translateY(-2px); box-shadow: 0 4px 8px rgba(0,0,0,0.1); }
        .action-button i { margin-right: 8px; }
        .action-button.save-btn { background-color: var(--success-color); }
        .action-button.save-btn:hover { background-color: #27ae60; }
        .action-button.pdf-btn { background-color: var(--accent-color); }
        .action-button.pdf-btn:hover { background-color: #c0392b; }
        /* Bouton plus petit pour sauvegarde item */
        .btn-sm { padding: 0.3rem 0.8rem; font-size: 0.85em; }
        .btn-primary { background-color: var(--primary-color); color: white; }
        .btn-primary:hover { background-color: #2980b9; }
        .btn-secondary { background-color: var(--gray); color: white; }
        .btn-secondary:hover { background-color: var(--dark-gray); }
        .btn-danger { background-color: var(--accent-color); color: white; }
        .btn-danger:hover { background-color: #c0392b; }
        .alert { padding: 1rem; border-radius: 4px; margin-bottom: 1.5rem; border: 1px solid transparent; }
        .alert-success { background-color: #d4edda; color: #155724; border-color: #c3e6cb; }
        .alert-danger { background-color: #f8d7da; color: #721c24; border-color: #f5c6cb; }
        .alert ul { margin-top: 0.5rem; margin-left: 1.5rem; }
        .cv-editor-container { /* Pas de changement majeur */ }
        .cv-form-section { background: white; padding: 2rem; border-radius: 8px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); width: 100%; /* Prend toute la largeur maintenant */ }
        /* .cv-preview-section { display: none; } Supprimé */
        .form-section { margin-bottom: 2.5rem; }
        .form-repeater-item { border: 1px solid #eee; padding: 1.5rem; margin-bottom: 1rem; border-radius: 5px; position: relative; background: #fafafa; }
        .item-actions { position: absolute; top: 10px; right: 10px; display: flex; gap: 5px; } /* Conteneur pour boutons item */
        .item-actions button { border: none; background: none; cursor: pointer; padding: 0; }
        .item-actions .save-item-btn { color: var(--success-color); font-size: 1.1em; }
        .item-actions .delete-item-btn { color: var(--accent-color); font-size: 1.1em; }
        .item-actions button:disabled { opacity: 0.5; cursor: not-allowed; }
        .form-section-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; border-bottom: 1px solid var(--border-color); padding-bottom: 0.8rem; }
        .form-section-header h4 { margin: 0; color: var(--primary-color); font-size: 1.3rem; }
        .add-item-btn { font-size: 0.9em; padding: 0.4rem 1rem; background-color: var(--primary-color); color: white; border: none; border-radius: 4px; cursor: pointer; }
        .add-item-btn i { margin-right: 5px; }
        .form-control { width: 100%; padding: 0.7rem 1rem; border: 1px solid #ccc; border-radius: 4px; margin-bottom: 0.2rem; /* Réduit espace pour erreur */ font-size: 0.95rem; transition: border-color 0.3s, box-shadow 0.3s; }
        .form-control:focus { border-color: var(--primary-color); box-shadow: 0 0 0 2px rgba(52, 152, 219, 0.2); outline: none; }
        textarea.form-control { min-height: 80px; resize: vertical; }
        .form-label { display: block; margin-bottom: 0.4rem; font-weight: 600; font-size: 0.9rem; color: var(--secondary-color); }
        .form-group { margin-bottom: 1rem; }
        .form-group small { font-size: 0.8rem; color: #7f8c8d; }
        .row { display: flex; flex-wrap: wrap; gap: 1.5rem; margin-bottom: 1rem; /* Ajout espace entre rows */ }
        .col { flex: 1; min-width: 200px; }
        input[type="hidden"] { display: none; }
        /* Style pour les messages d'erreur sous les champs */
        .error-message { color: var(--accent-color); font-size: 0.8em; display: block; min-height: 1.2em; /* Réserve l'espace */}
        .form-control.border-danger { border-color: var(--accent-color) !important; } /* Force la bordure rouge */
        /* Styles Trix Editor */
        trix-toolbar [data-trix-button-group="file-tools"] { display: none; } /* Cache bouton fichier */
        .trix-content { background-color: white; border: 1px solid #ccc; border-radius: 4px; padding: 0.5rem; min-height: 100px; margin-top: 0.2rem; }
        .trix-content:focus-within { border-color: var(--primary-color); box-shadow: 0 0 0 2px rgba(52, 152, 219, 0.2); outline: none;}
        .form-control.trix-content { padding: 0; } /* Override padding */
        .border-danger.trix-content { border-color: var(--accent-color) !important; } /* Erreur sur Trix */
        /* Responsive */
        @media (max-width: 768px) { .app-container { flex-direction: column; } .app-sidebar { width: 100%; min-height: auto; position: static; height: auto; box-shadow: none; border-bottom: 1px solid var(--border-color);} .main-content { padding: 1rem; } .content-header { margin-bottom: 1rem; } .welcome-message h1 { font-size: 1.5rem; } .cv-form-section { padding: 1rem; } .row { gap: 0.8rem; } .col { min-width: 100%; } .action-button { padding: 0.6rem 1rem; font-size: 0.85rem; } }
    </style>
    {{-- Inclure Alpine.js DANS LE HEAD avec DEFER --}}
    <script src="//unpkg.com/alpinejs" defer></script>
</head>
<body>

    <header class="app-header">
        <div class="logo"> <i class="fas fa-briefcase"></i> <span>StagesBENIN</span> </div>
        <div class="header-actions"> <div style="position: relative;"> <i class="fas fa-bell"></i> </div> <div class="profile-menu"> <div class="profile-image"> <i class="fas fa-user"></i> </div> </div> </div>
    </header>

    <div class="app-container">
        <aside class="app-sidebar">
             <nav class="sidebar-menu">
                 <a href="{{ route('etudiants.dashboard') ?? '#' }}" class="menu-item"> <i class="fas fa-home"></i> <span>Tableau de bord</span> </a>
                 <a href="{{ route('etudiants.cv.edit') }}" class="menu-item active"> <i class="fas fa-file-alt"></i> <span>Éditeur CV</span> </a>
                 <a href="{{ route('etudiants.cv.show') }}" class="menu-item"> <i class="fas fa-eye"></i> <span>Visualiser CV</span> </a>
                 <a href="{{ route('profile.edit') ?? '#' }}" class="menu-item"> <i class="fas fa-user-circle"></i> <span>Mon Profil</span> </a>
                 <a href="#" class="menu-item" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"> <i class="fas fa-sign-out-alt"></i> <span>Déconnexion</span> </a>
                 <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;"> @csrf </form>
             </nav>
        </aside>

        <main class="main-content">
            <div class="content-header">
                 <div class="welcome-message"> <h1>Éditeur de CV</h1> <p>Modifiez chaque section et enregistrez au fur et à mesure.</p> </div>
                 <div class="quick-actions">
                     {{-- Bouton pour aller à la page de visualisation --}}
                     <a href="{{ route('etudiants.cv.show') }}" class="action-button" target="_blank">
                        <i class="fas fa-eye"></i> <span>Visualiser le CV Final</span>
                    </a>
                 </div>
            </div>

             {{-- ========================================================== --}}
             {{-- CONTENEUR ALPINE.JS : Initialise le composant           --}}
             {{-- ========================================================== --}}
             <div x-data="cvEditorData" {{-- Référence la factory function --}}
                  data-cv-data='@json($cvData)' {{-- Données initiales --}}
                  {{-- URLs pour les actions AJAX --}}
                  data-profile-url="{{ route('etudiants.cv.profile.update') }}"
                  data-formations-url="{{ route('etudiants.cv.formations.store') }}" {{-- URL Base pour POST --}}
                  data-experiences-url="{{ route('etudiants.cv.experiences.store') }}"
                  data-competences-url="{{ route('etudiants.cv.competences.store') }}"
                  data-langues-url="{{ route('etudiants.cv.langues.store') }}"
                  data-centres-interet-url="{{ route('etudiants.cv.centres_interet.store') }}"
                  data-certifications-url="{{ route('etudiants.cv.certifications.store') }}"
                  data-projets-url="{{ route('etudiants.cv.projets.store') }}"
                  x-init="init()">

                 {{-- Zone pour afficher les messages généraux (succès/erreur AJAX) --}}
                 <div x-show="generalMessage.text" class="alert" :class="{ 'alert-success': generalMessage.type === 'success', 'alert-danger': generalMessage.type === 'error' }" x-text="generalMessage.text" @click="clearGeneralMessage" style="cursor: pointer;"></div>

                {{-- Section Formulaire --}}
                <div class="cv-form-section">

                        {{-- ----------------------------- --}}
                        {{-- INFOS GÉNÉRALES ------------- --}}
                        {{-- ----------------------------- --}}
                        <div class="form-section">
                             <div class="form-section-header">
                                 <h4>Informations Générales</h4>
                                 <button type="button" @click="saveProfile" class="action-button save-btn btn-sm" :disabled="loading.profile">
                                     <i :class="loading.profile ? 'fas fa-spinner fa-spin' : 'fas fa-save'"></i>
                                     <span x-text="loading.profile ? 'Saving...' : 'Enregistrer'"></span>
                                 </button>
                             </div>
                             <input type="hidden" :value="cv.profile.id"> {{-- Pas besoin de name --}}
                             <template x-if="hasError('profile', '_general')"><span class="error-message" x-text="getErrorMessage('profile', '_general')"></span></template> {{-- Erreurs générales profil --}}

                             <div class="row">
                                 <div class="col form-group"> <label class="form-label">Nom Complet</label> <input type="text" class="form-control" :value="etudiant.prenom + ' ' + etudiant.nom" readonly disabled> </div>
                                 <div class="col form-group"> <label for="profile_titre" class="form-label">Titre Profil CV <span style="color:red">*</span></label> <input type="text" id="profile_titre" x-model="cv.profile.titre_profil" class="form-control" :class="{'border-danger': hasError('profile', 'titre_profil')}" required> <span class="error-message" x-text="getErrorMessage('profile', 'titre_profil')"></span> </div>
                             </div>
                             <div class="row">
                                 <div class="col form-group"> <label for="profile_email" class="form-label">Email contact (CV)</label> <input type="email" id="profile_email" x-model="cv.profile.email_cv" class="form-control" :class="{'border-danger': hasError('profile', 'email_cv')}" :placeholder="'Par défaut: ' + etudiant.email"> <span class="error-message" x-text="getErrorMessage('profile', 'email_cv')"></span> </div>
                                 <div class="col form-group"> <label for="profile_telephone" class="form-label">Téléphone (CV)</label> <input type="tel" id="profile_telephone" x-model="cv.profile.telephone_cv" class="form-control" :class="{'border-danger': hasError('profile', 'telephone_cv')}" :placeholder="'Par défaut: ' + etudiant.telephone"> <span class="error-message" x-text="getErrorMessage('profile', 'telephone_cv')"></span> </div>
                             </div>
                             <div class="row">
                                 <div class="col form-group"> <label for="profile_adresse" class="form-label">Adresse / Ville</label> <input type="text" id="profile_adresse" x-model="cv.profile.adresse" class="form-control" :class="{'border-danger': hasError('profile', 'adresse')}"> <span class="error-message" x-text="getErrorMessage('profile', 'adresse')"></span> </div>
                                 <div class="col form-group"> <label for="profile_linkedin" class="form-label">URL LinkedIn</label> <input type="url" id="profile_linkedin" x-model="cv.profile.linkedin_url" class="form-control" :class="{'border-danger': hasError('profile', 'linkedin_url')}" placeholder="https://linkedin.com/in/..."> <span class="error-message" x-text="getErrorMessage('profile', 'linkedin_url')"></span> </div>
                             </div>
                             <div class="row">
                                 <div class="col form-group"> <label for="profile_portfolio" class="form-label">URL Portfolio/Site/GitHub</label> <input type="url" id="profile_portfolio" x-model="cv.profile.portfolio_url" class="form-control" :class="{'border-danger': hasError('profile', 'portfolio_url')}" placeholder="https://votresite.com"> <span class="error-message" x-text="getErrorMessage('profile', 'portfolio_url')"></span> </div>
                                 <div class="col form-group">
                                     <label for="profile_photo_cv" class="form-label">Photo CV (Max 2Mo)</label>
                                     <input type="file" id="profile_photo_cv" name="photo_cv" @change="handlePhotoUpload" class="form-control" accept="image/png, image/jpeg, image/jpg" :class="{'border-danger': hasError('profile', 'photo_cv')}">
                                     <span class="error-message" x-text="getErrorMessage('profile', 'photo_cv')"></span>
                                     {{-- Affichage photo actuelle ou preview --}}
                                     <div style="margin-top: 5px;">
                                         <template x-if="!photoPreviewUrl && cv.profile.photo_cv_path"><img :src="assetUrl(cv.profile.photo_cv_path)" alt="Photo CV" style="max-width: 60px; height: 60px; border-radius: 50%; object-fit: cover;"></template>
                                         <template x-if="photoPreviewUrl"><img :src="photoPreviewUrl" alt="Aperçu" style="max-width: 60px; height: 60px; border-radius: 50%; object-fit: cover;"></template>
                                         <button type="button" @click="uploadPhoto" x-show="selectedPhotoFile" class="btn btn-sm btn-secondary" style="margin-left: 10px;" :disabled="loading.profile">
                                            <i :class="loading.profile ? 'fas fa-spinner fa-spin' : 'fas fa-upload'"></i> Téléverser
                                         </button>
                                     </div>
                                 </div>
                             </div>
                             {{-- TRIX EDITOR pour le résumé --}}
                             <div class="form-group">
                                <label for="profile_resume_editor" class="form-label">Résumé du Profil</label>
                                <input id="profile_resume" type="hidden" :value="cv.profile.resume_profil"> {{-- Pas de name ici, envoyé via JS --}}
                                <trix-editor input="profile_resume" id="profile_resume_editor"
                                    @trix-change="cv.profile.resume_profil = $event.target.value" {{-- Met à jour Alpine --}}
                                    class="form-control trix-content" :class="{'border-danger': hasError('profile', 'resume_profil')}"></trix-editor>
                                <span class="error-message" x-text="getErrorMessage('profile', 'resume_profil')"></span>
                             </div>
                        </div>

                        {{-- -------------------------- --}}
                        {{-- FORMATIONS ------------- --}}
                        {{-- -------------------------- --}}
                        <div class="form-section">
                             <div class="form-section-header"> <h4>Formations</h4> <button type="button" @click="addFormation" class="add-item-btn"><i class="fas fa-plus"></i> Ajouter</button> </div>
                             <template x-for="(formation, index) in cv.profile.formations" :key="formation.key">
                                 <div class="form-repeater-item">
                                     {{-- Boutons Item --}}
                                     <div class="item-actions">
                                         <button type="button" @click="saveFormation(index)" class="save-item-btn" title="Enregistrer" :disabled="loading['f_'+formation.key]">
                                             <i :class="loading['f_'+formation.key] ? 'fas fa-spinner fa-spin' : 'fas fa-save'"></i>
                                         </button>
                                         <button type="button" @click="deleteFormation(index)" class="delete-item-btn" title="Supprimer" :disabled="loading['f_'+formation.key]">
                                            <i class="fas fa-trash"></i>
                                         </button>
                                     </div>
                                     <input type="hidden" :value="formation.id"> {{-- ID pour update/delete --}}
                                     {{-- Champs avec erreurs --}}
                                     <div class="row">
                                         <div class="col form-group"> <label :for="'form_diplome_' + index" class="form-label">Diplôme <span style="color:red">*</span></label> <input type="text" :id="'form_diplome_' + index" x-model="formation.diplome" class="form-control" :class="{'border-danger': hasError(formation.key, 'diplome')}" required> <span class="error-message" x-text="getErrorMessage(formation.key, 'diplome')"></span></div>
                                         <div class="col form-group"> <label :for="'form_etablissement_' + index" class="form-label">Établissement <span style="color:red">*</span></label> <input type="text" :id="'form_etablissement_' + index" x-model="formation.etablissement" class="form-control" :class="{'border-danger': hasError(formation.key, 'etablissement')}" required> <span class="error-message" x-text="getErrorMessage(formation.key, 'etablissement')"></span></div>
                                     </div>
                                     <div class="row">
                                         <div class="col form-group"> <label :for="'form_ville_' + index" class="form-label">Ville</label> <input type="text" :id="'form_ville_' + index" x-model="formation.ville" class="form-control" :class="{'border-danger': hasError(formation.key, 'ville')}"> <span class="error-message" x-text="getErrorMessage(formation.key, 'ville')"></span></div>
                                         <div class="col form-group"> <label :for="'form_annee_debut_' + index" class="form-label">Année Début <span style="color:red">*</span></label> <input type="number" :id="'form_annee_debut_' + index" x-model.number="formation.annee_debut" class="form-control" :class="{'border-danger': hasError(formation.key, 'annee_debut')}" required min="1950" :max="new Date().getFullYear() + 2"> <span class="error-message" x-text="getErrorMessage(formation.key, 'annee_debut')"></span></div>
                                         <div class="col form-group"> <label :for="'form_annee_fin_' + index" class="form-label">Année Fin</label> <input type="number" :id="'form_annee_fin_' + index" x-model.number="formation.annee_fin" class="form-control" :class="{'border-danger': hasError(formation.key, 'annee_fin')}" min="1950" :max="new Date().getFullYear() + 5"> <span class="error-message" x-text="getErrorMessage(formation.key, 'annee_fin')"></span></div>
                                     </div>
                                     <div class="form-group">
                                         <label :for="'form_desc_editor_' + index" class="form-label">Description</label>
                                         <input :id="'form_desc_' + index" type="hidden" :value="formation.description">
                                         <trix-editor :input="'form_desc_' + index" :id="'form_desc_editor_' + index" @trix-change="formation.description = $event.target.value" class="form-control trix-content" :class="{'border-danger': hasError(formation.key, 'description')}"></trix-editor>
                                         <span class="error-message" x-text="getErrorMessage(formation.key, 'description')"></span>
                                     </div>
                                 </div>
                             </template>
                             <div x-show="!cv.profile.formations || cv.profile.formations.length === 0" style="text-align: center; color: var(--text-muted); padding: 1rem; border: 1px dashed var(--border-color); border-radius: 4px;"> Aucune formation ajoutée. </div>
                         </div>

                        {{-- ---------------------------- --}}
                        {{-- EXPÉRIENCES ------------- --- --}}
                        {{-- ---------------------------- --}}
                         <div class="form-section">
                             <div class="form-section-header"> <h4>Expériences</h4> <button type="button" @click="addExperience" class="add-item-btn"><i class="fas fa-plus"></i> Ajouter</button> </div>
                             <template x-for="(exp, index) in cv.profile.experiences" :key="exp.key">
                                 <div class="form-repeater-item">
                                     <div class="item-actions">
                                         <button type="button" @click="saveExperience(index)" class="save-item-btn" title="Enregistrer" :disabled="loading['e_'+exp.key]"> <i :class="loading['e_'+exp.key] ? 'fas fa-spinner fa-spin' : 'fas fa-save'"></i> </button>
                                         <button type="button" @click="deleteExperience(index)" class="delete-item-btn" title="Supprimer" :disabled="loading['e_'+exp.key]"> <i class="fas fa-trash"></i> </button>
                                     </div>
                                     <input type="hidden" :value="exp.id">
                                     <div class="row"> <div class="col form-group"> <label :for="'exp_poste_' + index" class="form-label">Poste <span style="color:red">*</span></label> <input type="text" :id="'exp_poste_' + index" x-model="exp.poste" class="form-control" :class="{'border-danger': hasError(exp.key, 'poste')}" required> <span class="error-message" x-text="getErrorMessage(exp.key, 'poste')"></span></div> <div class="col form-group"> <label :for="'exp_entreprise_' + index" class="form-label">Entreprise <span style="color:red">*</span></label> <input type="text" :id="'exp_entreprise_' + index" x-model="exp.entreprise" class="form-control" :class="{'border-danger': hasError(exp.key, 'entreprise')}" required> <span class="error-message" x-text="getErrorMessage(exp.key, 'entreprise')"></span></div> </div>
                                     <div class="row"> <div class="col form-group"> <label :for="'exp_ville_' + index" class="form-label">Ville</label> <input type="text" :id="'exp_ville_' + index" x-model="exp.ville" class="form-control" :class="{'border-danger': hasError(exp.key, 'ville')}"> <span class="error-message" x-text="getErrorMessage(exp.key, 'ville')"></span></div> <div class="col form-group"> <label :for="'exp_date_debut_' + index" class="form-label">Début <span style="color:red">*</span></label> <input type="date" :id="'exp_date_debut_' + index" x-model="exp.date_debut" class="form-control" :class="{'border-danger': hasError(exp.key, 'date_debut')}" required> <span class="error-message" x-text="getErrorMessage(exp.key, 'date_debut')"></span></div> <div class="col form-group"> <label :for="'exp_date_fin_' + index" class="form-label">Fin</label> <input type="date" :id="'exp_date_fin_' + index" x-model="exp.date_fin" class="form-control" :class="{'border-danger': hasError(exp.key, 'date_fin')}"> <span class="error-message" x-text="getErrorMessage(exp.key, 'date_fin')"></span></div> </div>
                                     <div class="form-group">
                                         <label :for="'exp_desc_editor_' + index" class="form-label">Description</label>
                                         <input :id="'exp_desc_' + index" type="hidden" :value="exp.description">
                                         <trix-editor :input="'exp_desc_' + index" :id="'exp_desc_editor_' + index" @trix-change="exp.description = $event.target.value" class="form-control trix-content" :class="{'border-danger': hasError(exp.key, 'description')}"></trix-editor>
                                         <span class="error-message" x-text="getErrorMessage(exp.key, 'description')"></span>
                                     </div>
                                     <div class="form-group">
                                         <label :for="'exp_taches_editor_' + index" class="form-label">Tâches/Réalisations</label>
                                         <input :id="'exp_taches_' + index" type="hidden" :value="exp.taches_realisations">
                                         <trix-editor :input="'exp_taches_' + index" :id="'exp_taches_editor_' + index" @trix-change="exp.taches_realisations = $event.target.value" class="form-control trix-content" :class="{'border-danger': hasError(exp.key, 'taches_realisations')}"></trix-editor>
                                         <span class="error-message" x-text="getErrorMessage(exp.key, 'taches_realisations')"></span>
                                     </div>
                                 </div>
                             </template>
                              <div x-show="!cv.profile.experiences || cv.profile.experiences.length === 0" style="text-align: center; color: var(--text-muted); padding: 1rem; border: 1px dashed var(--border-color); border-radius: 4px;"> Aucune expérience ajoutée. </div>
                         </div>

                         {{-- ---------------------------- --}}
                         {{-- COMPÉTENCES ----------- --- --}}
                         {{-- ---------------------------- --}}
                         <div class="form-section">
                              <div class="form-section-header"> <h4>Compétences</h4> <button type="button" @click="addCompetence" class="add-item-btn"><i class="fas fa-plus"></i> Ajouter</button> </div>
                              <template x-for="(comp, index) in cv.profile.competences" :key="comp.key">
                                  <div class="form-repeater-item">
                                      <div class="item-actions">
                                          <button type="button" @click="saveCompetence(index)" class="save-item-btn" title="Enregistrer" :disabled="loading['c_'+comp.key]"> <i :class="loading['c_'+comp.key] ? 'fas fa-spinner fa-spin' : 'fas fa-save'"></i> </button>
                                          <button type="button" @click="deleteCompetence(index)" class="delete-item-btn" title="Supprimer" :disabled="loading['c_'+comp.key]"> <i class="fas fa-trash"></i> </button>
                                      </div>
                                      <input type="hidden" :value="comp.id">
                                      <div class="row">
                                          <div class="col form-group"> <label :for="'comp_cat_' + index" class="form-label">Catégorie <span style="color:red">*</span></label> <input type="text" list="categories_list" :id="'comp_cat_' + index" x-model="comp.categorie" class="form-control" :class="{'border-danger': hasError(comp.key, 'categorie')}" required> <datalist id="categories_list"> <option value="Langages"> <option value="Frameworks/Bibliothèques"> <option value="Bases de données"> <option value="Outils/Méthodes"> <option value="Systèmes"> <option value="Autres"> </datalist> <span class="error-message" x-text="getErrorMessage(comp.key, 'categorie')"></span></div>
                                          <div class="col form-group"> <label :for="'comp_nom_' + index" class="form-label">Compétence <span style="color:red">*</span></label> <input type="text" :id="'comp_nom_' + index" x-model="comp.nom" class="form-control" :class="{'border-danger': hasError(comp.key, 'nom')}" required> <span class="error-message" x-text="getErrorMessage(comp.key, 'nom')"></span></div>
                                          <div class="col form-group" style="max-width: 150px;"> <label :for="'comp_niveau_' + index" class="form-label">Niveau (%) <span style="color:red">*</span></label> <input type="range" :id="'comp_niveau_' + index + '_range'" x-model.number="comp.niveau" class="form-control" min="0" max="100" step="5" style="padding: 0; height: 20px;"> <input type="number" :id="'comp_niveau_' + index" x-model.number="comp.niveau" class="form-control" :class="{'border-danger': hasError(comp.key, 'niveau')}" min="0" max="100" step="5" required style="max-width: 80px; display: inline-block; margin-left: 10px; padding: 0.3rem 0.5rem;"> <span class="error-message" x-text="getErrorMessage(comp.key, 'niveau')"></span></div>
                                      </div>
                                      <div class="skill-level-preview-bar"> <div class="skill-level-preview-fill" :style="'width:' + comp.niveau + '%'"></div> </div>
                                  </div>
                              </template>
                               <div x-show="!cv.profile.competences || cv.profile.competences.length === 0" style="text-align: center; color: var(--text-muted); padding: 1rem; border: 1px dashed var(--border-color); border-radius: 4px;"> Aucune compétence ajoutée. </div>
                         </div>

                        {{-- ----------------------- --}}
                        {{-- LANGUES --------------- --}}
                        {{-- ----------------------- --}}
                         <div class="form-section">
                              <div class="form-section-header"> <h4>Langues</h4> <button type="button" @click="addLangue" class="add-item-btn"><i class="fas fa-plus"></i> Ajouter</button> </div>
                              <template x-for="(lang, index) in cv.profile.langues" :key="lang.key">
                                  <div class="form-repeater-item">
                                      <div class="item-actions">
                                          <button type="button" @click="saveLangue(index)" class="save-item-btn" title="Enregistrer" :disabled="loading['l_'+lang.key]"> <i :class="loading['l_'+lang.key] ? 'fas fa-spinner fa-spin' : 'fas fa-save'"></i> </button>
                                          <button type="button" @click="deleteLangue(index)" class="delete-item-btn" title="Supprimer" :disabled="loading['l_'+lang.key]"> <i class="fas fa-trash"></i> </button>
                                      </div>
                                      <input type="hidden" :value="lang.id">
                                      <div class="row">
                                          <div class="col form-group"> <label :for="'lang_nom_' + index" class="form-label">Langue <span style="color:red">*</span></label> <input type="text" :id="'lang_nom_' + index" x-model="lang.langue" class="form-control" :class="{'border-danger': hasError(lang.key, 'langue')}" required> <span class="error-message" x-text="getErrorMessage(lang.key, 'langue')"></span></div>
                                          <div class="col form-group"> <label :for="'lang_niveau_' + index" class="form-label">Niveau <span style="color:red">*</span></label> <select :id="'lang_niveau_' + index" x-model="lang.niveau" class="form-control" :class="{'border-danger': hasError(lang.key, 'niveau')}" required> <option value="">Choisir...</option> <option value="Natif">Natif</option> <option value="Courant">Courant</option> <option value="Intermédiaire">Intermédiaire</option> <option value="Débutant">Débutant</option> <option value="Notions">Notions</option> </select> <span class="error-message" x-text="getErrorMessage(lang.key, 'niveau')"></span></div>
                                      </div>
                                  </div>
                              </template>
                               <div x-show="!cv.profile.langues || cv.profile.langues.length === 0" style="text-align: center; color: var(--text-muted); padding: 1rem; border: 1px dashed var(--border-color); border-radius: 4px;"> Aucune langue ajoutée. </div>
                         </div>

                         {{-- -------------------------------- --}}
                         {{-- CENTRES D'INTÉRÊT --------- --- --}}
                         {{-- -------------------------------- --}}
                         <div class="form-section">
                              <div class="form-section-header"> <h4>Centres d'Intérêt</h4> <button type="button" @click="addInteret" class="add-item-btn"><i class="fas fa-plus"></i> Ajouter</button> </div>
                              <template x-for="(interet, index) in cv.profile.centres_interet" :key="interet.key">
                                   <div class="form-repeater-item">
                                       <div class="item-actions">
                                           <button type="button" @click="saveInteret(index)" class="save-item-btn" title="Enregistrer" :disabled="loading['i_'+interet.key]"> <i :class="loading['i_'+interet.key] ? 'fas fa-spinner fa-spin' : 'fas fa-save'"></i> </button>
                                           <button type="button" @click="deleteInteret(index)" class="delete-item-btn" title="Supprimer" :disabled="loading['i_'+interet.key]"> <i class="fas fa-trash"></i> </button>
                                       </div>
                                       <input type="hidden" :value="interet.id">
                                       <div class="form-group"> <label :for="'interet_nom_' + index" class="form-label">Intérêt <span style="color:red">*</span></label> <input type="text" :id="'interet_nom_' + index" x-model="interet.nom" class="form-control" :class="{'border-danger': hasError(interet.key, 'nom')}" required> <span class="error-message" x-text="getErrorMessage(interet.key, 'nom')"></span></div>
                                   </div>
                              </template>
                               <div x-show="!cv.profile.centres_interet || cv.profile.centres_interet.length === 0" style="text-align: center; color: var(--text-muted); padding: 1rem; border: 1px dashed var(--border-color); border-radius: 4px;"> Aucun centre d'intérêt ajouté. </div>
                         </div>

                        {{-- ----------------------------- --}}
                        {{-- CERTIFICATIONS ---------- --- --}}
                        {{-- ----------------------------- --}}
                          <div class="form-section">
                               <div class="form-section-header"> <h4>Certifications</h4> <button type="button" @click="addCertification" class="add-item-btn"><i class="fas fa-plus"></i> Ajouter</button> </div>
                              <template x-for="(cert, index) in cv.profile.certifications" :key="cert.key">
                                  <div class="form-repeater-item">
                                      <div class="item-actions">
                                          <button type="button" @click="saveCertification(index)" class="save-item-btn" title="Enregistrer" :disabled="loading['cert_'+cert.key]"> <i :class="loading['cert_'+cert.key] ? 'fas fa-spinner fa-spin' : 'fas fa-save'"></i> </button>
                                          <button type="button" @click="deleteCertification(index)" class="delete-item-btn" title="Supprimer" :disabled="loading['cert_'+cert.key]"> <i class="fas fa-trash"></i> </button>
                                      </div>
                                      <input type="hidden" :value="cert.id">
                                      <div class="row"> <div class="col form-group"> <label :for="'cert_nom_' + index" class="form-label">Certification <span style="color:red">*</span></label> <input type="text" :id="'cert_nom_' + index" x-model="cert.nom" class="form-control" :class="{'border-danger': hasError(cert.key, 'nom')}" required> <span class="error-message" x-text="getErrorMessage(cert.key, 'nom')"></span></div> <div class="col form-group"> <label :for="'cert_org_' + index" class="form-label">Organisme <span style="color:red">*</span></label> <input type="text" :id="'cert_org_' + index" x-model="cert.organisme" class="form-control" :class="{'border-danger': hasError(cert.key, 'organisme')}" required> <span class="error-message" x-text="getErrorMessage(cert.key, 'organisme')"></span></div> <div class="col form-group" style="max-width: 120px;"> <label :for="'cert_annee_' + index" class="form-label">Année</label> <input type="number" :id="'cert_annee_' + index" x-model.number="cert.annee" class="form-control" :class="{'border-danger': hasError(cert.key, 'annee')}" min="1980" :max="new Date().getFullYear() + 1"> <span class="error-message" x-text="getErrorMessage(cert.key, 'annee')"></span></div> </div>
                                      <div class="form-group"> <label :for="'cert_url_' + index" class="form-label">URL Validation</label> <input type="url" :id="'cert_url_' + index" x-model="cert.url_validation" class="form-control" :class="{'border-danger': hasError(cert.key, 'url_validation')}"> <span class="error-message" x-text="getErrorMessage(cert.key, 'url_validation')"></span></div>
                                  </div>
                              </template>
                              <div x-show="!cv.profile.certifications || cv.profile.certifications.length === 0" style="text-align: center; color: var(--text-muted); padding: 1rem; border: 1px dashed var(--border-color); border-radius: 4px;"> Aucune certification ajoutée. </div>
                          </div>

                         {{-- -------------------------------- --}}
                         {{-- PROJETS PERSONNELS -------- --- --}}
                         {{-- -------------------------------- --}}
                          <div class="form-section">
                               <div class="form-section-header"> <h4>Projets Personnels</h4> <button type="button" @click="addProjet" class="add-item-btn"><i class="fas fa-plus"></i> Ajouter</button> </div>
                              <template x-for="(proj, index) in cv.profile.projets" :key="proj.key">
                                  <div class="form-repeater-item">
                                      <div class="item-actions">
                                          <button type="button" @click="saveProjet(index)" class="save-item-btn" title="Enregistrer" :disabled="loading['p_'+proj.key]"> <i :class="loading['p_'+proj.key] ? 'fas fa-spinner fa-spin' : 'fas fa-save'"></i> </button>
                                          <button type="button" @click="deleteProjet(index)" class="delete-item-btn" title="Supprimer" :disabled="loading['p_'+proj.key]"> <i class="fas fa-trash"></i> </button>
                                      </div>
                                      <input type="hidden" :value="proj.id">
                                      <div class="row"> <div class="col form-group"> <label :for="'proj_nom_' + index" class="form-label">Nom Projet <span style="color:red">*</span></label> <input type="text" :id="'proj_nom_' + index" x-model="proj.nom" class="form-control" :class="{'border-danger': hasError(proj.key, 'nom')}" required> <span class="error-message" x-text="getErrorMessage(proj.key, 'nom')"></span></div> <div class="col form-group"> <label :for="'proj_url_' + index" class="form-label">URL Projet</label> <input type="url" :id="'proj_url_' + index" x-model="proj.url_projet" class="form-control" :class="{'border-danger': hasError(proj.key, 'url_projet')}"> <span class="error-message" x-text="getErrorMessage(proj.key, 'url_projet')"></span></div> </div>
                                      <div class="form-group">
                                          <label :for="'proj_desc_editor_' + index" class="form-label">Description</label>
                                          <input :id="'proj_desc_' + index" type="hidden" :value="proj.description">
                                          <trix-editor :input="'proj_desc_' + index" :id="'proj_desc_editor_' + index" @trix-change="proj.description = $event.target.value" class="form-control trix-content" :class="{'border-danger': hasError(proj.key, 'description')}"></trix-editor>
                                          <span class="error-message" x-text="getErrorMessage(proj.key, 'description')"></span>
                                      </div>
                                      <div class="form-group"> <label :for="'proj_tech_' + index" class="form-label">Technologies</label> <input type="text" :id="'proj_tech_' + index" x-model="proj.technologies" class="form-control" :class="{'border-danger': hasError(proj.key, 'technologies')}"> <span class="error-message" x-text="getErrorMessage(proj.key, 'technologies')"></span></div>
                                  </div>
                              </template>
                               <div x-show="!cv.profile.projets || cv.profile.projets.length === 0" style="text-align: center; color: var(--text-muted); padding: 1rem; border: 1px dashed var(--border-color); border-radius: 4px;"> Aucun projet ajouté. </div>
                          </div>

                </div> {{-- Fin cv-form-section --}}

            </div> {{-- Fin cv-editor-container [x-data] --}}
        </main>
    </div> {{-- Fin app-container --}}

    {{-- Inclusion Trix Editor JS (après le contenu HTML) --}}
    <script type="text/javascript" src="https://unpkg.com/trix@2.0.8/dist/trix.umd.min.js"></script>

    {{-- Charger le fichier JS externe APRÈS Trix et Alpine --}}
    {{-- Important: Mettre à la fin du body --}}
    <script src="{{ asset('js/cv-editor.js') }}"></script>

</body>
</html>