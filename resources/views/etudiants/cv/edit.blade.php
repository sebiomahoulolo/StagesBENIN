<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}"> {{-- Important pour les requêtes POST/PUT/DELETE via JS si nécessaire --}}
    <title>Éditeur de CV - StagesBENIN</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* ===== Styles du Dashboard (inspirés de votre exemple) ===== */
        :root {
            --primary-color: #3498db; /* Bleu clair */
            --secondary-color: #2c3e50; /* Bleu foncé/gris */
            --accent-color: #e74c3c; /* Rouge */
            --success-color: #2ecc71; /* Vert */
            --warning-color: #f39c12; /* Orange */
            --light-gray: #f5f7fa; /* Gris très clair */
            --gray: #95a5a6; /* Gris moyen */
            --dark-gray: #7f8c8d; /* Gris foncé */
            --white: #ffffff;
            --body-bg: #f9f9f9; /* Fond général */
            --sidebar-bg: #ffffff;
            --card-bg: #ffffff;
            --text-color: #333;
            --text-muted: var(--dark-gray);
            --border-color: #e0e0e0;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        body { background-color: var(--body-bg); color: var(--text-color); line-height: 1.6; }

        /* Header (simple simulation) */
        header.app-header {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: var(--white);
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            position: sticky; top: 0; z-index: 1000; /* Rendre le header collant */
        }
        .logo { font-size: 1.6rem; font-weight: bold; display: flex; align-items: center; }
        .logo i { margin-right: 10px; }
        .header-actions { display: flex; align-items: center; gap: 1.5rem; }
        .header-actions i { font-size: 1.2rem; cursor: pointer; }
        .notifications-badge { background-color: var(--accent-color); color: white; border-radius: 50%; padding: 2px 6px; font-size: 0.7rem; position: absolute; top: -5px; right: -8px; }
        .profile-image { width: 35px; height: 35px; border-radius: 50%; background-color: white; display: flex; align-items: center; justify-content: center; color: var(--primary-color); }
        .profile-menu { position: relative; }

        /* Container principal */
        .app-container { display: flex; }

        /* Sidebar (simple simulation) */
        .app-sidebar {
            width: 250px;
            background-color: var(--sidebar-bg);
            min-height: calc(100vh - 66px); /* Hauteur moins le header */
            box-shadow: 2px 0 10px rgba(0,0,0,0.05);
            position: sticky; top: 66px; /* Coller sous le header */
            overflow-y: auto; /* Permettre le scroll si menu long */
            height: calc(100vh - 66px); /* Hauteur fixe pour sticky */
        }
        .sidebar-menu { padding: 1rem 0; }
        .menu-item { padding: 0.8rem 1.5rem; display: flex; align-items: center; color: var(--dark-gray); text-decoration: none; transition: all 0.3s; font-size: 0.95rem; border-left: 3px solid transparent; /* Pour l'indicateur active */ }
        .menu-item i { margin-right: 10px; width: 20px; text-align: center; }
        .menu-item:hover { background-color: rgba(52, 152, 219, 0.1); color: var(--primary-color); }
        /* Style spécifique pour l'élément actif (éditeur CV) */
        .menu-item.active { background-color: rgba(52, 152, 219, 0.1); color: var(--primary-color); border-left-color: var(--primary-color); font-weight: bold; }

        /* Contenu Principal */
        .main-content { flex: 1; padding: 2rem; overflow-y: auto; /* Permettre le scroll du contenu */ }

        /* Header du contenu */
        .content-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; flex-wrap: wrap; gap: 1rem; }
        .welcome-message h1 { font-size: 1.8rem; color: var(--secondary-color); margin-bottom: 0.5rem; }
        .welcome-message p { color: var(--text-muted); }
        .quick-actions { display: flex; gap: 1rem; flex-wrap: wrap; }

        /* Boutons d'action */
        .action-button { padding: 0.7rem 1.5rem; background-color: var(--primary-color); color: white; border: none; border-radius: 4px; cursor: pointer; display: flex; align-items: center; transition: all 0.3s; text-decoration: none; font-size: 0.9rem; }
        .action-button:hover { background-color: #2980b9; transform: translateY(-2px); box-shadow: 0 4px 8px rgba(0,0,0,0.1); }
        .action-button i { margin-right: 8px; }
        .action-button.save-btn { background-color: var(--success-color); }
        .action-button.save-btn:hover { background-color: #27ae60; }
        .action-button.pdf-btn { background-color: var(--accent-color); }
        .action-button.pdf-btn:hover { background-color: #c0392b; }

        /* Alertes */
        .alert { padding: 1rem; border-radius: 4px; margin-bottom: 1.5rem; border: 1px solid transparent; }
        .alert-success { background-color: #d4edda; color: #155724; border-color: #c3e6cb; }
        .alert-danger { background-color: #f8d7da; color: #721c24; border-color: #f5c6cb; }
        .alert ul { margin-top: 0.5rem; margin-left: 1.5rem; }

        /* ===== Styles Spécifiques à l'Éditeur CV ===== */
        .cv-editor-container { display: flex; gap: 2rem; margin-top: 1rem; align-items: flex-start; /* Aligner en haut */ }
        .cv-form-section { flex: 3; /* Donner plus de place au formulaire */ background: var(--card-bg); padding: 2rem; border-radius: 8px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); }
        .cv-preview-section {
            flex: 2; /* Moins de place pour la preview */
            position: sticky;
            top: 86px; /* Hauteur header + padding top */
            height: calc(100vh - 86px - 2rem); /* Hauteur viewport - header - padding top/bottom */
            overflow-y: auto; /* Scroll pour la preview si elle dépasse */
             min-width: 400px; /* Largeur minimale pour la preview */
        }
        #cv-preview-container {
            border: 1px solid var(--border-color);
            border-radius: 8px;
            overflow: hidden; /* Cache le débordement de scale */
            background: var(--light-gray);
            height: 100%;
            position: relative; /* Pour positionner le contenu */
            display: flex; /* Pour centrer le wrapper si nécessaire */
            justify-content: center; /* Centre horizontalement */
            align-items: flex-start; /* Aligne en haut */
        }
        /* Conteneur interne pour le scaling */
        #cv-preview-wrapper {
            width: 100%;
            height: 100%;
            overflow: auto; /* Permet le scroll interne si le contenu zoomé dépasse */
            padding: 5px; /* Petit padding pour éviter que le contenu colle aux bords */
        }
        /* Contenu réel du CV avec scaling */
        #cv-preview-content {
            /* La largeur est définie par le template lui-même (max-width: 900px;)*/
             /* ou vous pouvez forcer une largeur ici si le template ne le fait pas */
             /* width: 800px; */
             transform-origin: top center; /* Origine du scale en haut au centre */
             margin: 0 auto; /* Centrer le bloc CV */
             border: 1px solid #ccc; /* Bordure visible pour déboguer la taille */
             background: white; /* Fond blanc pour le CV lui-même */
        }

        /* Styles pour les sections répétables du formulaire */
        .form-section { margin-bottom: 2rem; }
        .form-repeater-item { border: 1px solid #eee; padding: 1.5rem; margin-bottom: 1rem; border-radius: 5px; position: relative; background: #fafafa; transition: box-shadow 0.3s; }
        .form-repeater-item:hover { box-shadow: 0 0 10px rgba(0,0,0,0.05); }
        .form-repeater-item .remove-item-btn { position: absolute; top: 10px; right: 10px; cursor: pointer; color: var(--accent-color); background: white; border: 1px solid var(--accent-color); border-radius: 50%; width: 24px; height: 24px; display: flex; align-items: center; justify-content: center; font-size: 14px; line-height: 1; transition: all 0.2s; z-index: 5; /* Au-dessus des autres champs */}
        .form-repeater-item .remove-item-btn:hover { background-color: var(--accent-color); color: white; transform: scale(1.1); }

        .form-section-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; border-bottom: 1px solid var(--border-color); padding-bottom: 0.8rem; }
        .form-section-header h4 { margin: 0; color: var(--primary-color); font-size: 1.2rem; }
        .add-item-btn { font-size: 0.9em; padding: 0.4rem 1rem; background-color: var(--primary-color); color: white; border: none; border-radius: 4px; cursor: pointer; }
        .add-item-btn i { margin-right: 5px; }
        .add-item-btn:hover { background-color: #2980b9; }

        /* Styles généraux des formulaires */
        .form-control { width: 100%; padding: 0.7rem 1rem; border: 1px solid #ccc; border-radius: 4px; margin-bottom: 0.5rem; font-size: 0.95rem; transition: border-color 0.3s, box-shadow 0.3s; }
        .form-control:focus { border-color: var(--primary-color); box-shadow: 0 0 0 2px rgba(52, 152, 219, 0.2); outline: none; }
        textarea.form-control { min-height: 80px; resize: vertical; }
        .form-label { display: block; margin-bottom: 0.4rem; font-weight: 600; font-size: 0.9rem; color: var(--secondary-color); }
        .form-group { margin-bottom: 1.2rem; }
        .form-group small { font-size: 0.8rem; color: var(--text-muted); }
        .row { display: flex; flex-wrap: wrap; gap: 1.5rem; }
        .col { flex: 1; min-width: 200px; /* Empêche les colonnes d'être trop étroites */ }

        /* Boutons spécifiques au formulaire */
        .form-buttons { text-align: right; margin-top: 2rem; padding-top: 1.5rem; border-top: 1px solid var(--border-color); }
        .btn { padding: 0.7rem 1.5rem; border-radius: 4px; cursor: pointer; text-decoration: none; font-size: 0.95rem; border: none; transition: all 0.3s; }
        .btn-primary { background-color: var(--success-color); color: white; }
        .btn-primary:hover { background-color: #27ae60; }
        .btn-secondary { background-color: var(--gray); color: white; margin-left: 10px; }
        .btn-secondary:hover { background-color: var(--dark-gray); }

        /* Masquer l'ID */
        input[type="hidden"] { display: none; }

        /* Pour la prévisualisation de la barre de compétence */
        .skill-level-preview-bar { height: 5px; background-color: #e0e0e0; border-radius: 3px; margin-top: 5px; overflow: hidden; }
        .skill-level-preview-fill { height: 100%; background-color: var(--primary-color); border-radius: 3px; transition: width 0.3s; }


        /* Responsive pour l'éditeur */
        @media (max-width: 1200px) {
            .cv-editor-container { flex-direction: column; }
            .cv-form-section, .cv-preview-section { max-width: 100%; flex: none; min-width: unset; }
            .cv-preview-section { position: relative; top: 0; height: 70vh; margin-top: 2rem; }
             #cv-preview-content { /* Pas de scale fixe ici, laisser le scaler JS faire */ }
        }
         @media (max-width: 768px) {
            .app-container { flex-direction: column; }
            .app-sidebar { width: 100%; min-height: auto; position: static; height: auto; box-shadow: none; border-bottom: 1px solid var(--border-color);}
            .main-content { padding: 1rem; }
            .content-header { margin-bottom: 1rem; }
            .welcome-message h1 { font-size: 1.5rem; }
            .cv-form-section { padding: 1rem; }
            .row { gap: 0.8rem; }
            .col { min-width: 100%; } /* Champs pleine largeur sur mobile */
             #cv-preview-content { /* Pas de scale fixe ici */ }
             .cv-preview-section { height: 80vh; }
             .action-button { padding: 0.6rem 1rem; font-size: 0.85rem; }
         }
         /* Style pour feedback chargement preview */
        #cv-preview-wrapper.loading-preview::after {
            content: 'Chargement...';
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(255, 255, 255, 0.8);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            color: var(--primary-color);
            z-index: 10;
        }
         /* Style pour feedback erreur preview */
         .preview-error-message {
            padding: 20px;
            border: 1px solid var(--accent-color);
            background-color: #fdd;
            color: #800;
            text-align: center;
            margin: 20px;
            border-radius: 5px;
        }
        .preview-error-message strong { display: block; margin-bottom: 5px; }
        .preview-error-message small { font-size: 0.9em; color: #600; }


    </style>
    
</head>
<body>

    {{-- Simulation Header --}}
    <header class="app-header">
         <div class="logo"> <i class="fas fa-briefcase"></i> <span>StagesBENIN</span> </div>
         <div class="header-actions"> <div style="position: relative;"> <i class="fas fa-bell"></i> </div> <div class="profile-menu"> <div class="profile-image"> <i class="fas fa-user"></i> </div> </div> </div>
    </header>

    <div class="app-container">
        {{-- Simulation Sidebar --}}
        <aside class="app-sidebar">
            <nav class="sidebar-menu">
                <a href="{{ route('etudiants.dashboard') ?? '#' }}" class="menu-item"> <i class="fas fa-home"></i> <span>Tableau de bord</span> </a>
                <a href="{{ route('etudiants.cv.edit') }}" class="menu-item active"> <i class="fas fa-file-alt"></i> <span>Éditeur CV</span> </a>
                {{-- <a href="#" class="menu-item"> <i class="fas fa-search"></i> <span>Offres de Stage</span> </a>
                <a href="#" class="menu-item"> <i class="fas fa-building"></i> <span>Entreprises</span> </a>
                <a href="{{ route('profile.edit') }}" class="menu-item"> <i class="fas fa-user-circle"></i> <span>Mon Profil</span> </a> --}}
                <a href="#" class="menu-item" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"> <i class="fas fa-sign-out-alt"></i> <span>Déconnexion</span> </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;"> @csrf </form>
            </nav>
        </aside>

        {{-- Contenu Principal de l'Éditeur --}}
        <main class="main-content">
            <div class="content-header">
                 <div class="welcome-message"> <h1>Éditeur de CV en ligne</h1> <p>Renseignez vos informations et prévisualisez votre CV.</p> </div>
                 <div class="quick-actions">
                     <a href="{{ route('etudiants.cv.export.pdf') }}" class="action-button pdf-btn" target="_blank"> <i class="fas fa-file-pdf"></i> <span>Exporter en PDF</span> </a>
                     <button type="submit" form="cvForm" class="action-button save-btn"> <i class="fas fa-save"></i> <span>Enregistrer</span> </button>
                 </div>
            </div>

            {{-- Affichage des messages succès/erreur --}}
            @if (session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif
            @if (session('error')) <div class="alert alert-danger">{{ session('error') }}</div> @endif
            @if ($errors->any()) <div class="alert alert-danger"> <strong>Erreurs de validation :</strong> <ul>@foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach</ul> </div> @endif

            {{-- Conteneur Principal Editeur + Preview --}}
            <div class="cv-editor-container" x-data="cvEditorData(@json($cvData))" x-init="initializePreviewScaler">

                {{-- Section Formulaire --}}
                <div class="cv-form-section">
                    <form id="cvForm" action="{{ route('etudiants.cv.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        {{-- ==== INFORMATIONS GÉNÉRALES ==== --}}
                        <div class="form-section">
                            <div class="form-section-header"><h4>Informations Générales</h4></div>
                            <input type="hidden" name="profile[id]" :value="cv.profile.id">
                             <div class="row"> <div class="col form-group"> <label class="form-label">Nom Complet (Affiché)</label> <input type="text" class="form-control" :value="etudiant.prenom + ' ' + etudiant.nom" readonly disabled> <small>Modifiable depuis votre profil étudiant.</small> </div> <div class="col form-group"> <label for="profile_titre" class="form-label">Titre du Profil CV <span style="color:red">*</span></label> <input type="text" id="profile_titre" name="profile[titre_profil]" class="form-control" x-model="cv.profile.titre_profil" placeholder="Ex: Développeur Web Full Stack" required> </div> </div>
                             <div class="row"> <div class="col form-group"> <label for="profile_email" class="form-label">Email de contact (CV)</label> <input type="email" id="profile_email" name="profile[email_cv]" class="form-control" x-model="cv.profile.email_cv" :placeholder="'Par défaut: ' + etudiant.email"> </div> <div class="col form-group"> <label for="profile_telephone" class="form-label">Téléphone (CV)</label> <input type="tel" id="profile_telephone" name="profile[telephone_cv]" class="form-control" x-model="cv.profile.telephone_cv" :placeholder="'Par défaut: ' + etudiant.telephone"> </div> </div>
                             <div class="row"> <div class="col form-group"> <label for="profile_adresse" class="form-label">Adresse / Ville</label> <input type="text" id="profile_adresse" name="profile[adresse]" class="form-control" x-model="cv.profile.adresse" placeholder="Ex: Cotonou, Bénin"> </div> <div class="col form-group"> <label for="profile_linkedin" class="form-label">URL LinkedIn</label> <input type="url" id="profile_linkedin" name="profile[linkedin_url]" class="form-control" x-model="cv.profile.linkedin_url" placeholder="https://linkedin.com/in/..."> </div> </div>
                             <div class="row"> <div class="col form-group"> <label for="profile_portfolio" class="form-label">URL Portfolio/Site/GitHub</label> <input type="url" id="profile_portfolio" name="profile[portfolio_url]" class="form-control" x-model="cv.profile.portfolio_url" placeholder="https://votresite.com ou github.com/..."> </div> <div class="col form-group"> <label for="profile_photo_cv" class="form-label">Photo spécifique au CV (Optionnel)</label> <input type="file" id="profile_photo_cv" name="photo_cv" class="form-control" accept="image/png, image/jpeg, image/jpg"> <small>Remplace la photo du profil étudiant sur le CV.</small> <template x-if="cv.profile.photo_cv_path"><img :src="'/' + cv.profile.photo_cv_path" alt="Photo CV actuelle" style="max-width: 50px; height: auto; margin-top: 5px; border-radius: 50%;"></template> </div> </div>
                             <div class="form-group"> <label for="profile_resume" class="form-label">Résumé du Profil</label> <textarea id="profile_resume" name="profile[resume_profil]" class="form-control" x-model="cv.profile.resume_profil" rows="4" placeholder="Décrivez brièvement votre profil professionnel, vos objectifs..."></textarea> </div>
                        </div>

                        {{-- ==== FORMATIONS ==== --}}
                        <div class="form-section">
                            <div class="form-section-header"> <h4>Formations</h4> <button type="button" @click="addFormation" class="add-item-btn"><i class="fas fa-plus"></i> Ajouter</button> </div>
                            <template x-for="(formation, index) in cv.profile.formations" :key="formation.key">
                                <div class="form-repeater-item">
                                    <input type="hidden" :name="'formations[' + index + '][id]'" :value="formation.id">
                                    <button type="button" @click="removeFormation(index)" class="remove-item-btn" title="Supprimer">×</button>
                                    <div class="row"> <div class="col form-group"> <label :for="'form_diplome_' + index" class="form-label">Diplôme / Titre <span style="color:red">*</span></label> <input type="text" :id="'form_diplome_' + index" :name="'formations[' + index + '][diplome]'" x-model="formation.diplome" class="form-control" placeholder="Ex: Licence en Informatique" required> </div> <div class="col form-group"> <label :for="'form_etablissement_' + index" class="form-label">Établissement <span style="color:red">*</span></label> <input type="text" :id="'form_etablissement_' + index" :name="'formations[' + index + '][etablissement]'" x-model="formation.etablissement" class="form-control" placeholder="Ex: Université d'Abomey-Calavi" required> </div> </div>
                                    <div class="row"> <div class="col form-group"> <label :for="'form_ville_' + index" class="form-label">Ville</label> <input type="text" :id="'form_ville_' + index" :name="'formations[' + index + '][ville]'" x-model="formation.ville" class="form-control" placeholder="Ex: Cotonou"> </div> <div class="col form-group"> <label :for="'form_annee_debut_' + index" class="form-label">Année Début <span style="color:red">*</span></label> <input type="number" :id="'form_annee_debut_' + index" :name="'formations[' + index + '][annee_debut]'" x-model.number="formation.annee_debut" class="form-control" placeholder="AAAA" required min="1950" :max="new Date().getFullYear() + 2"> </div> <div class="col form-group"> <label :for="'form_annee_fin_' + index" class="form-label">Année Fin (ou vide)</label> <input type="number" :id="'form_annee_fin_' + index" :name="'formations[' + index + '][annee_fin]'" x-model.number="formation.annee_fin" class="form-control" placeholder="AAAA" min="1950" :max="new Date().getFullYear() + 5"> </div> </div>
                                    <div class="form-group"> <label :for="'form_desc_' + index" class="form-label">Description (Optionnel)</label> <textarea :id="'form_desc_' + index" :name="'formations[' + index + '][description]'" x-model="formation.description" class="form-control" rows="2" placeholder="Ex: Mention Bien, Projet de fin d'études sur... (une ligne par point)"></textarea> </div>
                                </div>
                            </template>
                            <div x-show="!cv.profile.formations || cv.profile.formations.length === 0" style="text-align: center; color: var(--text-muted); padding: 1rem; border: 1px dashed var(--border-color); border-radius: 4px;"> Aucune formation ajoutée. </div>
                        </div>

                         {{-- ==== EXPÉRIENCES ==== --}}
                        <div class="form-section">
                           <div class="form-section-header"> <h4>Expériences Professionnelles</h4> <button type="button" @click="addExperience" class="add-item-btn"><i class="fas fa-plus"></i> Ajouter</button> </div>
                           <template x-for="(exp, index) in cv.profile.experiences" :key="exp.key">
                               <div class="form-repeater-item">
                                   <input type="hidden" :name="'experiences[' + index + '][id]'" :value="exp.id">
                                   <button type="button" @click="removeExperience(index)" class="remove-item-btn" title="Supprimer">×</button>
                                   <div class="row"> <div class="col form-group"> <label :for="'exp_poste_' + index" class="form-label">Poste Occupé <span style="color:red">*</span></label> <input type="text" :id="'exp_poste_' + index" :name="'experiences[' + index + '][poste]'" x-model="exp.poste" class="form-control" placeholder="Ex: Stagiaire Développeur" required> </div> <div class="col form-group"> <label :for="'exp_entreprise_' + index" class="form-label">Entreprise <span style="color:red">*</span></label> <input type="text" :id="'exp_entreprise_' + index" :name="'experiences[' + index + '][entreprise]'" x-model="exp.entreprise" class="form-control" placeholder="Ex: BeninDev Solutions" required> </div> </div>
                                   <div class="row"> <div class="col form-group"> <label :for="'exp_ville_' + index" class="form-label">Ville</label> <input type="text" :id="'exp_ville_' + index" :name="'experiences[' + index + '][ville]'" x-model="exp.ville" class="form-control" placeholder="Ex: Parakou"> </div> <div class="col form-group"> <label :for="'exp_date_debut_' + index" class="form-label">Date Début <span style="color:red">*</span></label> <input type="date" :id="'exp_date_debut_' + index" :name="'experiences[' + index + '][date_debut]'" x-model="exp.date_debut" class="form-control" required> </div> <div class="col form-group"> <label :for="'exp_date_fin_' + index" class="form-label">Date Fin (ou vide si actuel)</label> <input type="date" :id="'exp_date_fin_' + index" :name="'experiences[' + index + '][date_fin]'" x-model="exp.date_fin" class="form-control"> </div> </div>
                                   <div class="form-group"> <label :for="'exp_desc_' + index" class="form-label">Description (Optionnel)</label> <textarea :id="'exp_desc_' + index" :name="'experiences[' + index + '][description]'" x-model="exp.description" class="form-control" rows="2" placeholder="Contexte de la mission..."></textarea> </div>
                                   <div class="form-group"> <label :for="'exp_taches_' + index" class="form-label">Tâches / Réalisations (Optionnel, une par ligne)</label> <textarea :id="'exp_taches_' + index" :name="'experiences[' + index + '][taches_realisations]'" x-model="exp.taches_realisations" class="form-control" rows="3" placeholder="- Développement de l'interface X
- Correction de bugs sur Y
- Participation aux réunions Z"></textarea> </div>
                               </div>
                           </template>
                           <div x-show="!cv.profile.experiences || cv.profile.experiences.length === 0" style="text-align: center; color: var(--text-muted); padding: 1rem; border: 1px dashed var(--border-color); border-radius: 4px;"> Aucune expérience ajoutée. </div>
                       </div>

                        {{-- ==== COMPÉTENCES ==== --}}
                        <div class="form-section">
                           <div class="form-section-header"> <h4>Compétences</h4> <button type="button" @click="addCompetence" class="add-item-btn"><i class="fas fa-plus"></i> Ajouter</button> </div>
                           <template x-for="(comp, index) in cv.profile.competences" :key="comp.key">
                               <div class="form-repeater-item">
                                   <input type="hidden" :name="'competences[' + index + '][id]'" :value="comp.id">
                                   <button type="button" @click="removeCompetence(index)" class="remove-item-btn" title="Supprimer">×</button>
                                   <div class="row"> <div class="col form-group"> <label :for="'comp_cat_' + index" class="form-label">Catégorie <span style="color:red">*</span></label> <input type="text" list="categories_list" :id="'comp_cat_' + index" :name="'competences[' + index + '][categorie]'" x-model="comp.categorie" class="form-control" placeholder="Ex: Langages, Frameworks, Outils" required> <datalist id="categories_list"> <option value="Langages de programmation"> <option value="Frameworks & Bibliothèques"> <option value="Bases de données"> <option value="Outils & Méthodologies"> <option value="Systèmes d'exploitation"> <option value="Compétences Techniques"> <option value="Compétences Personnelles"> </datalist> </div> <div class="col form-group"> <label :for="'comp_nom_' + index" class="form-label">Nom de la Compétence <span style="color:red">*</span></label> <input type="text" :id="'comp_nom_' + index" :name="'competences[' + index + '][nom]'" x-model="comp.nom" class="form-control" placeholder="Ex: PHP, Laravel, Gestion de projet" required> </div> <div class="col form-group" style="max-width: 150px;"> <label :for="'comp_niveau_' + index" class="form-label">Niveau (%) <span style="color:red">*</span></label> <input type="range" :id="'comp_niveau_' + index + '_range'" x-model.number="comp.niveau" class="form-control" min="0" max="100" step="5" style="padding: 0; height: 20px;"> <input type="number" :id="'comp_niveau_' + index" :name="'competences[' + index + '][niveau]'" x-model.number="comp.niveau" class="form-control" min="0" max="100" step="5" required style="max-width: 80px; display: inline-block; margin-left: 10px; padding: 0.3rem 0.5rem;"> </div> </div>
                                   <div class="skill-level-preview-bar"> <div class="skill-level-preview-fill" :style="'width:' + comp.niveau + '%'"></div> </div>
                               </div>
                           </template>
                           <div x-show="!cv.profile.competences || cv.profile.competences.length === 0" style="text-align: center; color: var(--text-muted); padding: 1rem; border: 1px dashed var(--border-color); border-radius: 4px;"> Aucune compétence ajoutée. </div>
                       </div>

                        {{-- ==== LANGUES ==== --}}
                        <div class="form-section">
                            <div class="form-section-header"> <h4>Langues</h4> <button type="button" @click="addLangue" class="add-item-btn"><i class="fas fa-plus"></i> Ajouter</button> </div>
                            <template x-for="(lang, index) in cv.profile.langues" :key="lang.key">
                                <div class="form-repeater-item">
                                    <input type="hidden" :name="'langues[' + index + '][id]'" :value="lang.id">
                                    <button type="button" @click="removeLangue(index)" class="remove-item-btn" title="Supprimer">×</button>
                                    <div class="row"> <div class="col form-group"> <label :for="'lang_nom_' + index" class="form-label">Langue <span style="color:red">*</span></label> <input type="text" :id="'lang_nom_' + index" :name="'langues[' + index + '][langue]'" x-model="lang.langue" class="form-control" placeholder="Ex: Français, Anglais, Fon" required> </div> <div class="col form-group"> <label :for="'lang_niveau_' + index" class="form-label">Niveau <span style="color:red">*</span></label> <select :id="'lang_niveau_' + index" :name="'langues[' + index + '][niveau]'" x-model="lang.niveau" class="form-control" required> <option value="">Choisir...</option> <option value="Natif">Natif</option> <option value="Courant">Courant (C1/C2)</option> <option value="Intermédiaire">Intermédiaire (B1/B2)</option> <option value="Débutant">Débutant (A1/A2)</option> <option value="Notions">Notions</option> </select> </div> </div>
                                </div>
                            </template>
                             <div x-show="!cv.profile.langues || cv.profile.langues.length === 0" style="text-align: center; color: var(--text-muted); padding: 1rem; border: 1px dashed var(--border-color); border-radius: 4px;"> Aucune langue ajoutée. </div>
                        </div>

                         {{-- ==== CENTRES D'INTÉRÊT ==== --}}
                         <div class="form-section">
                            <div class="form-section-header"> <h4>Centres d'Intérêt</h4> <button type="button" @click="addInteret" class="add-item-btn"><i class="fas fa-plus"></i> Ajouter</button> </div>
                            <template x-for="(interet, index) in cv.profile.centres_interet" :key="interet.key">
                                 <div class="form-repeater-item">
                                    <input type="hidden" :name="'centres_interet[' + index + '][id]'" :value="interet.id">
                                    <button type="button" @click="removeInteret(index)" class="remove-item-btn" title="Supprimer">×</button>
                                    <div class="form-group"> <label :for="'interet_nom_' + index" class="form-label">Nom de l'intérêt <span style="color:red">*</span></label> <input type="text" :id="'interet_nom_' + index" :name="'centres_interet[' + index + '][nom]'" x-model="interet.nom" class="form-control" placeholder="Ex: Lecture, Sport, Code" required> </div>
                                 </div>
                            </template>
                             <div x-show="!cv.profile.centres_interet || cv.profile.centres_interet.length === 0" style="text-align: center; color: var(--text-muted); padding: 1rem; border: 1px dashed var(--border-color); border-radius: 4px;"> Aucun centre d'intérêt ajouté. </div>
                        </div>

                        {{-- ==== CERTIFICATIONS ==== --}}
                        <div class="form-section">
                             <div class="form-section-header"> <h4>Certifications</h4> <button type="button" @click="addCertification" class="add-item-btn"><i class="fas fa-plus"></i> Ajouter</button> </div>
                            <template x-for="(cert, index) in cv.profile.certifications" :key="cert.key">
                                <div class="form-repeater-item">
                                    <input type="hidden" :name="'certifications[' + index + '][id]'" :value="cert.id">
                                    <button type="button" @click="removeCertification(index)" class="remove-item-btn" title="Supprimer">×</button>
                                    <div class="row"> <div class="col form-group"> <label :for="'cert_nom_' + index" class="form-label">Nom de la Certification <span style="color:red">*</span></label> <input type="text" :id="'cert_nom_' + index" :name="'certifications[' + index + '][nom]'" x-model="cert.nom" class="form-control" placeholder="Ex: Google Analytics IQ" required> </div> <div class="col form-group"> <label :for="'cert_org_' + index" class="form-label">Organisme <span style="color:red">*</span></label> <input type="text" :id="'cert_org_' + index" :name="'certifications[' + index + '][organisme]'" x-model="cert.organisme" class="form-control" placeholder="Ex: Google" required> </div> <div class="col form-group" style="max-width: 120px;"> <label :for="'cert_annee_' + index" class="form-label">Année</label> <input type="number" :id="'cert_annee_' + index" :name="'certifications[' + index + '][annee]'" x-model.number="cert.annee" class="form-control" placeholder="AAAA" min="1980" :max="new Date().getFullYear() + 1"> </div> </div>
                                    <div class="form-group"> <label :for="'cert_url_' + index" class="form-label">URL de validation (Optionnel)</label> <input type="url" :id="'cert_url_' + index" :name="'certifications[' + index + '][url_validation]'" x-model="cert.url_validation" class="form-control" placeholder="https://..."> </div>
                                </div>
                            </template>
                            <div x-show="!cv.profile.certifications || cv.profile.certifications.length === 0" style="text-align: center; color: var(--text-muted); padding: 1rem; border: 1px dashed var(--border-color); border-radius: 4px;"> Aucune certification ajoutée. </div>
                        </div>

                        {{-- ==== PROJETS PERSONNELS ==== --}}
                        <div class="form-section">
                             <div class="form-section-header"> <h4>Projets Personnels</h4> <button type="button" @click="addProjet" class="add-item-btn"><i class="fas fa-plus"></i> Ajouter</button> </div>
                            <template x-for="(proj, index) in cv.profile.projets" :key="proj.key">
                                <div class="form-repeater-item">
                                    <input type="hidden" :name="'projets[' + index + '][id]'" :value="proj.id">
                                    <button type="button" @click="removeProjet(index)" class="remove-item-btn" title="Supprimer">×</button>
                                    <div class="row"> <div class="col form-group"> <label :for="'proj_nom_' + index" class="form-label">Nom du Projet <span style="color:red">*</span></label> <input type="text" :id="'proj_nom_' + index" :name="'projets[' + index + '][nom]'" x-model="proj.nom" class="form-control" placeholder="Ex: Mon Blog Technique" required> </div> <div class="col form-group"> <label :for="'proj_url_' + index" class="form-label">URL du Projet (Optionnel)</label> <input type="url" :id="'proj_url_' + index" :name="'projets[' + index + '][url_projet]'" x-model="proj.url_projet" class="form-control" placeholder="https://github.com/..."> </div> </div>
                                    <div class="form-group"> <label :for="'proj_desc_' + index" class="form-label">Description</label> <textarea :id="'proj_desc_' + index" :name="'projets[' + index + '][description]'" x-model="proj.description" class="form-control" rows="3" placeholder="Description du projet, objectifs, fonctionnalités..."></textarea> </div>
                                    <div class="form-group"> <label :for="'proj_tech_' + index" class="form-label">Technologies Utilisées (Optionnel)</label> <input type="text" :id="'proj_tech_' + index" :name="'projets[' + index + '][technologies]'" x-model="proj.technologies" class="form-control" placeholder="Ex: Laravel, Vue.js, MySQL"> </div>
                                </div>
                            </template>
                             <div x-show="!cv.profile.projets || cv.profile.projets.length === 0" style="text-align: center; color: var(--text-muted); padding: 1rem; border: 1px dashed var(--border-color); border-radius: 4px;"> Aucun projet ajouté. </div>
                        </div>

                        {{-- Boutons de soumission en bas du formulaire --}}
                        <div class="form-buttons">
                            <a href="{{ route('etudiants.dashboard') ?? '#' }}" class="btn btn-secondary">Annuler</a>
                            <button type="submit" class="btn btn-primary"> <i class="fas fa-save"></i> Enregistrer les modifications </button>
                        </div>
                    </form>
                </div>

                {{-- Section Prévisualisation --}}
                <div class="cv-preview-section">
                    <h4 style="text-align: center; margin-bottom: 1rem; color: var(--secondary-color);">Prévisualisation</h4>
                    <div id="cv-preview-container">
                         {{-- Ajout d'un overlay pour le feedback visuel pendant le chargement --}}
                        <div id="cv-preview-wrapper" :class="{ 'loading-preview': isLoadingPreview }">
                            {{-- x-html injecte le code HTML retourné par fetch --}}
                            {{-- Ajout de conditions x-show pour gérer les états --}}
                            <div x-show="!isLoadingPreview && renderedPreview && !renderedPreview.includes('Erreur')">
                                 <div x-html="renderedPreview"></div>
                            </div>
                             <div x-show="isLoadingPreview" style="text-align: center; padding: 50px; color: var(--primary-color);">Chargement...</div>
                             <div x-show="!isLoadingPreview && (!renderedPreview || renderedPreview.includes('Erreur'))">
                                 {{-- Affichage plus propre de l'erreur ou message par défaut --}}
                                 <div x-html="renderedPreview">
                                      <p style="text-align: center; padding: 50px; color: #aaa;">La prévisualisation apparaîtra ici.</p>
                                 </div>
                             </div>
                        </div>
                    </div>
                </div>

            </div> {{-- Fin cv-editor-container --}}
        </main>
    </div> {{-- Fin app-container --}}

    {{-- Inclure Alpine.js --}}
    {{-- Assurez-vous que ce script est bien chargé --}}
    <script src="//unpkg.com/alpinejs" defer></script>

    {{-- Votre script Alpine.js --}}
    <script>
        // Fonction utilitaire pour debounce (si Alpine.debounce n'est pas dispo/souhaité)
        function debounce(func, wait) {
            let timeout;
            return function executedFunction(...args) {
                const later = () => {
                    clearTimeout(timeout);
                    func(...args);
                };
                clearTimeout(timeout);
                timeout = setTimeout(later, wait);
            };
        }

        document.addEventListener('alpine:init', () => {
            console.log("Alpine initializing...");

            Alpine.data('cvEditorData', (initialCvData) => ({
                // Initial data (make a deep copy for debugging)
                _initialData: JSON.parse(JSON.stringify(initialCvData)),

                etudiant: initialCvData?.etudiant || { nom: '', prenom: '', email: '', telephone: '', photo_path: '' },

                // Robust initialization of the cv object and its arrays
                cv: {
                    profile: {
                        ...(initialCvData?.profile || {}), // Spread initial profile data
                        // Ensure repeatable sections are initialized as arrays with unique keys
                        formations: (initialCvData?.profile?.formations || []).map((item, index) => ({ ...item, key: item.id || `f_${Date.now()}_${index}` })),
                        experiences: (initialCvData?.profile?.experiences || []).map((item, index) => ({ ...item, key: item.id || `e_${Date.now()}_${index}` })),
                        competences: (initialCvData?.profile?.competences || []).map((item, index) => ({ ...item, key: item.id || `c_${Date.now()}_${index}` })),
                        langues: (initialCvData?.profile?.langues || []).map((item, index) => ({ ...item, key: item.id || `l_${Date.now()}_${index}` })),
                        centres_interet: (initialCvData?.profile?.centres_interet || []).map((item, index) => ({ ...item, key: item.id || `i_${Date.now()}_${index}` })),
                        certifications: (initialCvData?.profile?.certifications || []).map((item, index) => ({ ...item, key: item.id || `cert_${Date.now()}_${index}` })),
                        projets: (initialCvData?.profile?.projets || []).map((item, index) => ({ ...item, key: item.id || `p_${Date.now()}_${index}` })),
                    }
                },

                renderedPreview: '<p style="text-align: center; padding: 50px; color: #aaa;">Initialisation de la prévisualisation...</p>',
                isLoadingPreview: false,
                // Debounced function reference
                debouncedUpdatePreview: null,

                // ==========================
                // INITIALIZATION & WATCHERS
                // ==========================
                init() {
                    console.log('CV Editor Initialized. Data passed from PHP:', this._initialData);
                    console.log('Alpine cv.profile object:', JSON.parse(JSON.stringify(this.cv.profile)));

                    // Create debounced function instance
                    this.debouncedUpdatePreview = debounce(this.updatePreview.bind(this), 750); // Bind 'this'

                    // Initial preview load
                    this.updatePreview(); // Load preview on init

                    // Watch for deep changes in cv.profile
                    this.$watch('cv.profile', (newValue, oldValue) => {
                         console.log('Watcher: cv.profile changed');
                         // Schedule update using the debounced function
                         this.isLoadingPreview = true; // Show loading state immediately
                         this.debouncedUpdatePreview();
                    }, { deep: true });
                },

                // ==========================
                // PREVIEW UPDATE LOGIC
                // ==========================
                updatePreview() {
                    console.log('updatePreview: Fetching preview...');
                    this.isLoadingPreview = true; // Ensure loading state is set

                    fetch('{{ route('etudiants.cv.preview') }}', { // Correct route usage
                        method: 'GET', // Explicitly state method
                        headers: {
                             // Important pour s'assurer que le serveur sait qu'on attend du HTML
                             'Accept': 'text/html, application/xhtml+xml',
                             // Si vous aviez besoin d'envoyer le CSRF token pour une raison (normalement pas pour GET)
                             // 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    })
                    .then(response => {
                        console.log(`updatePreview: Fetch response status: ${response.status}`);
                        if (!response.ok) {
                            // Try to get more error details from the response body
                            return response.text().then(text => {
                                console.error('updatePreview: Fetch error response body:', text);
                                throw new Error(`Erreur serveur (${response.status}). Vérifiez les logs Laravel.`);
                            });
                        }
                        return response.text();
                    })
                    .then(html => {
                        console.log('updatePreview: HTML received successfully.');
                        // Check if received HTML seems valid (basic check)
                        if (html && html.toLowerCase().includes('<html')) {
                             this.renderedPreview = html;
                             // Update scale AFTER the DOM is updated by x-html
                             this.$nextTick(() => {
                                this.scalePreviewContent();
                             });
                        } else {
                             console.warn('updatePreview: Received empty or invalid HTML content.');
                             this.renderedPreview = `<div class="preview-error-message"><strong>Contenu de prévisualisation invalide reçu du serveur.</strong></div>`;
                        }
                    })
                    .catch(error => {
                        console.error('updatePreview: Error during fetch or processing:', error);
                        // Display user-friendly error message
                        this.renderedPreview = `<div class="preview-error-message">
                                                    <strong>Impossible de charger la prévisualisation.</strong><br>
                                                    <small>${error.message || 'Une erreur inconnue est survenue.'}</small>
                                                </div>`;
                    })
                    .finally(() => {
                        this.isLoadingPreview = false;
                        console.log('updatePreview: Process finished.');
                    });
                },

                 // =======================================
                 // ADD/REMOVE FUNCTIONS (with logging)
                 // =======================================
                 _generateKey(prefix = 'item') {
                    // Generates a more unique key than just Date.now()
                    return `${prefix}_${Date.now()}_${Math.random().toString(36).substring(2, 9)}`;
                 },

                 // --- Add ---
                 addFormation()    { const k = this._generateKey('f'); console.log(`Adding Formation ${k}`); this.cv.profile.formations.push({ id: null, key: k, diplome: '', etablissement: '', ville:'', annee_debut: '', annee_fin: null, description: '' }); },
                 addExperience()   { const k = this._generateKey('e'); console.log(`Adding Experience ${k}`); this.cv.profile.experiences.push({ id: null, key: k, poste: '', entreprise: '', ville:'', date_debut: '', date_fin: null, description: '', taches_realisations:'' }); },
                 addCompetence()   { const k = this._generateKey('c'); console.log(`Adding Competence ${k}`); this.cv.profile.competences.push({ id: null, key: k, categorie: '', nom: '', niveau: 75 }); },
                 addLangue()       { const k = this._generateKey('l'); console.log(`Adding Langue ${k}`); this.cv.profile.langues.push({ id: null, key: k, langue: '', niveau: '' }); },
                 addInteret()      { const k = this._generateKey('i'); console.log(`Adding Centre Interet ${k}`); this.cv.profile.centres_interet.push({ id: null, key: k, nom: '' }); },
                 addCertification(){ const k = this._generateKey('cert'); console.log(`Adding Certification ${k}`); this.cv.profile.certifications.push({ id: null, key: k, nom: '', organisme: '', annee: null, url_validation:'' }); },
                 addProjet()       { const k = this._generateKey('p'); console.log(`Adding Projet ${k}`); this.cv.profile.projets.push({ id: null, key: k, nom: '', url_projet: '', description: '', technologies: '' }); },

                 // --- Remove ---
                 // Helper to find index by key, more robust than using index directly if array order changes unexpectedly
                 _findIndexByKey(sectionArray, key) {
                     return sectionArray.findIndex(item => item.key === key);
                 },
                 // Modified remove functions (example for formation, apply similarly to others)
                removeFormation(index) {
                    console.log(`Attempting to remove Formation at index: ${index}`);
                    if (index >= 0 && index < this.cv.profile.formations.length) {
                        this.cv.profile.formations.splice(index, 1);
                        console.log('Formation removed.');
                    } else {
                        console.error(`Invalid index for removeFormation: ${index}`);
                    }
                 },
                 // Apply similar robust index check and logging for other remove functions
                 removeExperience(index)   { console.log(`Removing Experience ${index}`); if (index >= 0 && index < this.cv.profile.experiences.length) this.cv.profile.experiences.splice(index, 1); },
                 removeCompetence(index)   { console.log(`Removing Competence ${index}`); if (index >= 0 && index < this.cv.profile.competences.length) this.cv.profile.competences.splice(index, 1); },
                 removeLangue(index)       { console.log(`Removing Langue ${index}`); if (index >= 0 && index < this.cv.profile.langues.length) this.cv.profile.langues.splice(index, 1); },
                 removeInteret(index)      { console.log(`Removing Centre Interet ${index}`); if (index >= 0 && index < this.cv.profile.centres_interet.length) this.cv.profile.centres_interet.splice(index, 1); },
                 removeCertification(index){ console.log(`Removing Certification ${index}`); if (index >= 0 && index < this.cv.profile.certifications.length) this.cv.profile.certifications.splice(index, 1); },
                 removeProjet(index)       { console.log(`Removing Projet ${index}`); if (index >= 0 && index < this.cv.profile.projets.length) this.cv.profile.projets.splice(index, 1); },


                // =======================================
                // UTILITY (Scaling Preview)
                // =======================================
                scalePreviewContent() {
                     // Use $nextTick to ensure DOM measurements are accurate after updates
                    this.$nextTick(() => {
                        const previewWrapper = document.getElementById('cv-preview-wrapper');
                        const previewContent = document.getElementById('cv-preview-content');
                        if (!previewWrapper || !previewContent) {
                            console.warn("Preview elements not found for scaling.");
                            return;
                        }

                        const containerWidth = previewWrapper.clientWidth;
                        const contentNaturalWidth = previewContent.offsetWidth; // Get actual rendered width
                        const contentScrollWidth = previewContent.scrollWidth; // Sometimes more reliable

                        // Choose a reference width (e.g., desired A4 width simulation or actual width)
                        const referenceWidth = contentScrollWidth > 50 ? contentScrollWidth : 800; // Use scrollWidth if available, fallback

                        if (containerWidth > 0 && referenceWidth > 0) {
                            let scale = containerWidth / referenceWidth;
                            scale = Math.min(scale, 1); // Max scale 100%
                            scale = Math.max(scale, 0.3); // Min scale 30%

                            previewContent.style.transform = `scale(${scale})`;
                            console.log(`Preview scaled to: ${scale.toFixed(2)} (Container: ${containerWidth}px, ContentRef: ${referenceWidth}px)`);
                        } else {
                            previewContent.style.transform = 'scale(1)';
                            console.log("Could not calculate scale (container or content width is zero).");
                        }
                    });
                },

                initializePreviewScaler() {
                    console.log("Initializing preview scaler...");
                     // Initial scaling attempt after a brief delay for rendering
                    setTimeout(() => this.scalePreviewContent(), 200);
                    // Debounced resize listener
                    window.addEventListener('resize', debounce(this.scalePreviewContent.bind(this), 250));
                }

            }));

            console.log("Alpine initialization script registered.");
        });
    </script>

</body>
</html>