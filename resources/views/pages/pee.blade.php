
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700&family=Roboto:wght@400;700&family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- Styles CSS - Adaptés depuis Elementor -->
    <style>
        /* Variables de couleur (hypothétiques basées sur l'usage) */
        :root {
            --custom-primary: #0056b3; /* Bleu principal */
            --custom-secondary: #555555; /* Gris foncé pour texte */
            --custom-accent: #0056b3; /* Bleu pour hover/accent nav */
            --custom-white: #FFFFFF;
            --custom-light-gray: #f8f9fa;
            --custom-dark-footer: #343a40;
            --custom-footer-text: #adb5bd;
            --custom-footer-link: #ced4da;
        }

        body {
            font-family: 'Roboto', Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: var(--custom-light-gray);
            color: #333;
            line-height: 1.6;
        }

        /* --- Header Supérieur (Adapté de .elementor-element-f6ead46, -85654b8, -f3a7698, -2ec6f74) --- */
        .simple-header {
            background-color: var(--custom-primary); /* --e-global-color-e058ff3 */
            color: var(--custom-white); /* --e-global-color-secondary (pour fond bleu) */
            padding: 5px 5px 5px 5px; /* Padding Elementor */
            font-family: "Montserrat", sans-serif;
            transition: background 0.3s;
        }
        .simple-header .container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 1920px; /* Max-width Elementor */
        }
        .simple-header span, .simple-header a {
             /* Style du texte/lien dans header sup */
            font-size: 15px;
            font-weight: 600;
            letter-spacing: 1px; /* Ajusté (2.5px est beaucoup) */
            /* word-spacing: 5px; */ /* Ajusté (30px est énorme) */
            color: var(--custom-white); /* Couleur texte */
            transition: color 0.3s;
            text-shadow: 0px 0px 10px rgba(0, 0, 0, 0);
            display: inline-flex; /* Pour aligner icônes et texte */
            align-items: center;
        }
        .simple-header .header-contact span { /* Cibler spécifiquement le texte contact */
             margin-right: 15px; /* Espace entre contact et icônes sociales */
        }

        .simple-header .social-icons a {
            margin-left: 15px; /* Espace entre icônes sociales */
            color: var(--custom-white);
            text-decoration: none;
        }
        .simple-header .social-icons i {
            font-size: 15px; /* --e-icon-list-icon-size */
            vertical-align: middle;
            transition: color 0.3s;
        }
         .simple-header .social-icons a:hover,
         .simple-header .social-icons a:hover i {
             color: #e0e0e0; /* Légère variation au survol */
         }


        /* --- Navigation Principale (Adapté de .elementor-element-41cb1f2, -3159a9b, -5585609) --- */
        .simple-navbar {
            background-color: var(--custom-white);
            box-shadow: 0px 7px 10px 0px rgba(0,0,0,0.1); /* Ombre Elementor (ajustée) */
            padding: 0px 0px 0px 0px; /* Padding Elementor */
            position: sticky;
            top: 0;
            z-index: 1020;
            transition: background 0.3s, border 0.3s, border-radius 0.3s, box-shadow 0.3s;
        }
        .simple-navbar .container {
             max-width: 1920px; /* Max-width Elementor */
             /* align-items: center; /* Assuré par Bootstrap flex */
        }

        .simple-navbar .navbar-brand img {
            /* width: 200px; */ /* Largeur Elementor */
            max-width: 100%;
            height: 45px; /* Ajuster hauteur pour garder proportion */
            width: auto; /* Laisser la largeur s'ajuster */
            margin: 5px 0; /* Ajouter un peu d'espace vertical */
        }

        .simple-navbar .navbar-nav {
             align-items: center; /* Centrer verticalement les liens */
        }

        .simple-navbar .nav-link {
            font-family: "Montserrat", sans-serif;
            font-size: 14px; /* Légèrement réduit vs 16px pour affichage simple */
            font-weight: 600;
            text-transform: uppercase;
            color: var(--custom-secondary); /* --e-global-color-secondary */
            fill: var(--custom-secondary);
            padding: 15px 10px; /* Ajouter padding pour espacement */
            margin: 0 5px; /* Espacement horizontal entre liens */
            transition: color 0.3s;
            position: relative; /* Pour les effets de pointeur si besoin */
        }

        .simple-navbar .nav-link:hover,
        .simple-navbar .nav-link.active, /* Ajouter une classe .active si besoin */
        .simple-navbar .nav-link:focus {
            color: var(--custom-accent); /* --e-global-color-b0dd001 */
            fill: var(--custom-accent);
        }

        /* Effet "underline" simple au survol (alternative aux pointeurs complexes) */
        .simple-navbar .nav-link::after {
            content: '';
            position: absolute;
            bottom: 5px; /* Position du soulignement */
            left: 10px;
            right: 10px;
            height: 2px;
            background-color: var(--custom-accent);
            transform: scaleX(0);
            transition: transform 0.3s ease-in-out;
        }
        .simple-navbar .nav-link:hover::after,
        .simple-navbar .nav-link.active::after,
        .simple-navbar .nav-link:focus::after {
             transform: scaleX(1);
        }
        /* Style pour le bouton toggler (mobile) */
        .simple-navbar .navbar-toggler {
            border-color: rgba(0,0,0,.1);
        }
         .simple-navbar .navbar-toggler-icon {
             background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba(0, 86, 179, 0.8)' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e"); /* Couleur bleue pour l'icône */
         }


        /* --- Hero Section (Style précédent adapté) --- */
        .hero-section {
            position: relative; min-height: 829px; width: 100%;
            background-image: url("image.png");
            background-repeat: no-repeat; background-size: cover; background-position: center center;
            display: flex; color: white;
        }
        .hero-overlay {
            position: absolute; top: 0; left: 0; width: 100%; height: 100%;
            background-color: transparent; background-image: linear-gradient(180deg, #00000054 0%, #0A0003C9 100%);
            display: flex; flex-direction: column; align-items: flex-start; justify-content: flex-end;
            padding: 2rem 3rem 4rem 3rem; box-sizing: border-box;
        }
        .hero-logo-overlay {
            content: url('https://stagesbenin.com/wp-content/uploads/elementor/thumbs/Logo-SB-Stages-BENIN-qgskmy5l67w4r8z5r9a1zrhw1g61fdfc05k6cdafqk.png');
            max-width: 100px; height: auto; margin-bottom: 1rem; opacity: 0.9;
        }
        .hero-title {
            font-family: "Montserrat", sans-serif; font-size: 47px; color: var(--custom-white);
            font-weight: 700; line-height: 1.2; text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.5);
            text-align: left; margin: 0; max-width: 90%;
        }

        /* --- Contenu Principal --- */
        .content-section {
            background-color: white; padding: 2rem; margin-top: 2rem; margin-bottom: 2rem;
            border-radius: 5px; box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        }
        .main-title {
            color: var(--custom-primary); text-align: center; margin-bottom: 1.5rem; font-family: 'Poppins', sans-serif;
            font-weight: 700; font-size: 2rem; border-bottom: 2px solid var(--custom-primary); display: inline-block; padding-bottom: 0.5rem;
        }
        .title-container { text-align: center; margin-bottom: 2rem; }
        .section-title {
            color: var(--custom-primary); margin-top: 2rem; margin-bottom: 1rem; font-size: 1.6rem; border-bottom: 1px solid #eee;
            padding-bottom: 0.5rem; font-family: 'Poppins', sans-serif; font-weight: 700;
        }
         h4 { font-size: 1.2rem; font-weight: 700; color: #444; margin-top: 1rem; margin-bottom: 0.5rem; }
        ul, ol { padding-left: 2rem; margin-bottom: 1rem; }
        li { margin-bottom: 0.5rem; }
        strong { font-weight: 700; }
        a { color: var(--custom-primary); text-decoration: none; }
        a:hover { text-decoration: underline; }
        .inscription-area {
             text-align: center; margin-top: 2rem; padding: 1.5rem; background-color: #f1f1f1; border-radius: 5px;
        }
        .btn-inscription {
            background-color: var(--custom-primary); color: white; padding: 10px 25px; font-size: 1.1rem; font-weight: bold;
            border: none; border-radius: 4px; text-transform: uppercase; transition: background-color 0.2s;
        }
        .btn-inscription:hover { background-color: #003d80; color: white; }
        .inscription-note { margin-top: 1rem; font-size: 0.9rem; color: #555; }

        /* --- Footer Simple --- */
        .simple-footer {
            background-color: var(--custom-dark-footer); color: var(--custom-footer-text); padding: 2rem 0; text-align: center;
            font-size: 0.9rem; margin-top: 2rem;
        }
        .simple-footer a { color: var(--custom-footer-link); }
        .simple-footer a:hover { color: var(--custom-white); }
        .simple-footer .social-icons a { margin: 0 10px; }
        .simple-footer .social-icons i { font-size: 1.2rem; }


        /* --- Styles Responsive (Adaptés) --- */
        @media (max-width: 1024px) {
             .simple-header span, .simple-header a {
                 font-size: 13px; /* Réduire taille police header sup */
                 letter-spacing: 0.5px;
                 word-spacing: normal;
             }
            .simple-navbar .nav-link {
                font-size: 13px; /* Réduire taille police nav */
                padding: 12px 8px;
            }
             .hero-title {
                 font-size: clamp(1.5rem, 4vw, 2.5rem); /* Réduire titre hero */
             }
        }

        @media (max-width: 767px) {
             .simple-header .header-contact { display: none; } /* Cacher contact sur mobile */
             .simple-header .container { justify-content: center; } /* Centrer icônes sociales */
             .simple-header .social-icons a { margin: 0 10px; }

             .simple-navbar .navbar-brand img { height: 35px; } /* Réduire logo */
             .simple-navbar .navbar-nav { margin-top: 10px; } /* Espace quand menu ouvert */
             .simple-navbar .nav-link { font-size: 12px; padding: 10px 8px;}
             .simple-navbar .nav-link::after { bottom: 2px; }

             .hero-section { min-height: 450px; } /* Réduire hauteur min hero */
             .hero-overlay { padding: 1rem 1.5rem 2rem 1.5rem; }
             .hero-title { font-size: clamp(1.4rem, 5vw, 2rem); }

             .main-title { font-size: 1.6rem; }
             .section-title { font-size: 1.4rem; }
        }

    </style>
</head>
<body>

    <!-- Header Supérieur Simple -->
     <header class="simple-header d-none d-lg-block">
        <div class="container">
            <span class="header-contact">
                 <i class="fas fa-map-marker-alt" style="font-size: 15px; margin-right: 5px;"></i> Kindonou, Cotonou |
                 <i class="fas fa-phone-alt" style="font-size: 15px; margin-left: 10px; margin-right: 5px;"></i> 24h/7j +229 41 73 28 96
             </span>
             <div class="social-icons">
                <a href="https://facebook.com/stagesbenin" target="_blank" rel="noopener noreferrer" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                <a href="https://wa.me/22941732996" target="_blank" rel="noopener noreferrer" aria-label="WhatsApp"><i class="fab fa-whatsapp"></i></a>
                <a href="https://www.linkedin.com/company/stagesbenin/?viewAsMember=true" target="_blank" rel="noopener noreferrer" aria-label="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
            </div>
        </div>
    </header>

    <!-- Navigation Simple (Sticky) -->
    <nav class="navbar navbar-expand-lg simple-navbar">
        <div class="container">
          
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar" aria-controls="mainNavbar" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="mainNavbar">
                 <!-- Liens nav comme avant -->
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link" href="https://stagesbenin.com/">ACCUEIL</a></li>
                    <li class="nav-item"><a class="nav-link" href="https://stagesbenin.com/secteur-activite/bien-et-service/">CATALOGUE DES ENTREPRISES</a></li>
                    <li class="nav-item"><a class="nav-link" href="https://stagesbenin.com/nos-services">NOS SERVICES</a></li>
                    <li class="nav-item"><a class="nav-link active" href="https://stagesbenin.com/programme/">NOS PROGRAMMES</a></li> <!-- Exemple classe active -->
                    <li class="nav-item"><a class="nav-link" href="https://stagesbenin.com/a-propos/">A PROPOS</a></li>
                    <li class="nav-item"><a class="nav-link" href="https://stagesbenin.com/contact/">CONTACTS</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">EVENEMENTS</a></li>
                    <li class="nav-item"><a class="nav-link" href="https://stagesbenin.com/articles/">BLOG</a></li>
                    <li class="nav-item"><a class="nav-link" href="https://stagesbenin.com/inscription/">Inscription</a></li>
                    <li class="nav-item"><a class="nav-link" href="https://stagesbenin.com/connexion/">Connexion</a></li>
                 </ul>
            </div>
        </div>
    </nav>

    <!-- Section Hero (Style Elementor Adapté) -->
    <section class="hero-section">
        <div class="hero-overlay">
             <div class="hero-logo-overlay" alt="Stages Benin SB Logo"></div>
             <h1 class="hero-title">SaNOSPro (Salon National d'Orientation et de Stages Professionnels)</h1>
        </div>
    </section>

    <!-- Zone de Contenu Principal -->
    <div class="container">
         <div class="content-section">

             <div class="title-container">
                 <h2 class="main-title">LE PRIX DE L’ETUDIANT ENTREPRENEUR 2024</h2>
              </div>

             <p>
                 <strong>Le PEE 2024</strong> est une initiative de <strong>FHC GROUPE SARL</strong> ET <strong>StagesBENIN</strong> dans le cadre du Salon National de l’Orientation et De Stages Professionnels (SaNOSPro 2024) conçue pour accompagner les jeunes étudiants entrepreneurs des universités, écoles publiques et privées. Le PEE accompagne la croissance et la résilience des Jeunes entrepreneurs en offrant un appui financier combiné à une assistance technique. L’appui financier concerne la subvention et octroi d’un capital allant jusqu’à 1 000 000 FCFA pour servir de fond de roulement ou des investissement d’actifs. Le PEE est mis en œuvre par la société FHC GROUPE SARL et StagesBENIN dans le cadre du (SaNOSPro 2024).
             </p>

             <h3 class="section-title">Qui peut en bénéficier ?</h3>
             <div>
                 <ul>
                     <li>Vous êtes étudiants ou nouveaux diplômés depuis au moins une année<br/>soit année universitaire 2022-2023, à la date de clôture des candidatures<br/>dans une écoles ou universités privées ou publiques</li>
                     <li>Vous disposez d’au moins une idée d’entreprises</li>
                     <li>Vous êtes passionnés par l’entrepreneuriat</li>
                     <li>Vous êtes âgés entre 18-30 ans vous êtes inscris en licence1-licence2- licence3 ou vous venez à peine de finir toutes filière confondues</li>
                     <li>Vous évoluez dans les secteurs suivants :</li>
                 </ul>
                 <ol>
                     <li><strong>Agro-business,</strong></li>
                     <li><strong>Agro-alimentaire,</strong></li>
                     <li><strong>Technologies propres et énergie,</strong></li>
                     <li><strong>Créatif, médias et divertissement,</strong></li>
                     <li><strong>Tourisme, Transports et logistique ;</strong></li>
                     <li><strong>Eco-numérique et élevage</strong></li>
                 </ol>
                 <p class='mt-3'><strong><em>Vous souhaitez bénéficier d’un appui technique et financier ?</em></strong></p>
             </div>

             <h3 class="section-title">CE QUE NOUS OFFRONS</h3>
             <div>
                 <h4>Une Assistance Technique :</h4>
                 <p>Elle se déclinée en 2 étapes :</p>
                 <ul>
                     <li>Parcours de formations collectives (Gestion financière et administrative de l’entreprise, Négociation commerciale, Digitalisation, Préparation à la levée de fonds, Normes et Certifications, etc.)</li>
                     <li>Parcours de coaching sur les axes identifiés avec des Coachs et mentors chevronnés dans leur secteur d’activité</li>
                 </ul>
                 <h4 class='mt-4'>Une Assistance Financière :</h4>
                 <ul>
                     <li>Un Appui Financier allant jusqu’à 1 million de FCFA</li>
                     <li>Un Appui au suivi financier tout au long de l’accompagnement</li>
                 </ul>
             </div>

             <h3 class="section-title">Processus de Sélection</h3>
             <div>
                 <p>
                     La sélection des lauréats sera effectuée par un jurys suivant une compétition en 3 phases après l’analyse des formulaires de candidatures soumis, de la collecte des pièces justificatives requises, de la tenue d’entretiens avec les candidats présélectionnés.<br/>
                     Un seul appel à candidature sera lancé à partir du 15 février 2024<br/>
                     La Date limite pour soumissionner à la phase de présélection est fixée au 28 février 2024.
                 </p>
             </div>

             <h3 class="section-title">Dossier de candidature à déposer en ligne</h3>
             <div>
                 <ul>
                     <li>Carte d’étudiant</li>
                     <li>Un formulaire de candidature (fiche signalétique) à télécharger <strong><a href='https://stagesbenin.com/wp-content/uploads/2024/02/LE-PRIX-DE-LETUDIANT-ENTREPRENEUR-2024-SaNOSPRO-fff.pdf' target='_blank' rel='noopener noreferrer'>ici</a></strong> et remplir (Veuillez télécharger la fiche)</li>
                     <li>Pièce d’identité en cours de validité</li>
                 </ul>
                 <p>Une lettre de parrainage pour les nouveaux diplômés et une lettre de recommandation signée par un membre ou un enseignant de son école de provenance.</p>
                 <ul>
                     <li>Droit d’inscription ou frais de participation s’élevant à <strong>5 000 FCFA</strong></li>
                 </ul>
             </div>

             <!-- Zone d'inscription -->
             <div class="inscription-area">
                 <a href="https://me.fedapay.com/prix-etudiant-entrepreneur" class="btn btn-inscription" target="_blank" rel="noopener noreferrer">
                     Inscrivez-vous ici
                 </a>
                 <p class="inscription-note">
                      Après avoir payer vos frais d’inscription, vous serez rediriger sur une page pour soumettre vos documents cités ci-dessus.<br>
                      <strong>NB: Veuillez consulter votre boite mail pour télécharger votre facture de paiement.</strong>
                 </p>
             </div>

         </div><!-- /.content-section -->
    </div><!-- /.container -->

    <!-- Footer Simple -->
    <footer class="simple-footer">
        <div class="container">
             <p>© <?php echo date("Y"); ?> StagesBENIN, Développé par FHC Groupe Sarl. | <a href="https://stagesbenin.com/politique-de-confidentialite/">Politique de Confidentialité</a></p>
             <div class="social-icons">
                <a href="https://facebook.com/stagesbenin" target="_blank" rel="noopener noreferrer" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                <a href="https://wa.me/22941732996" target="_blank" rel="noopener noreferrer" aria-label="WhatsApp"><i class="fab fa-whatsapp"></i></a>
                <a href="https://www.linkedin.com/company/stagesbenin/?viewAsMember=true" target="_blank" rel="noopener noreferrer" aria-label="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
             </div>
        </div>
    </footer>

    <!-- Script Bootstrap JS Bundle (placé à la fin) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>