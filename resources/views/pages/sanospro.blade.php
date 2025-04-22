
    <style>
        /* Variables de couleur et styles de base */
        :root {
            --custom-primary: #0056b3; /* Bleu principal */
            --custom-secondary: #555555; /* Gris foncé pour texte */
            --custom-accent: #0056b3; /* Bleu pour hover/accent nav */
            --custom-white: #FFFFFF;
            --custom-light-gray: #f8f9fa;
            --custom-dark-footer: #343a40;
            --custom-footer-text: #adb5bd;
            --custom-footer-link: #ced4da;
            --custom-cta-bg: #f0f5ff; /* Fond léger pour les boîtes CTA */
            --custom-cta-border: #cce0ff; /* Bordure légère pour CTA */
        }
        body {
            font-family: 'Roboto', Arial, sans-serif; 
            margin: 0; 
            padding: 0;
            background-color: var(--custom-light-gray); 
            color: #333; 
            line-height: 1.6;
        }

        /* Header Supérieur */
        .simple-header {
            background-color: var(--custom-primary); 
            color: var(--custom-white);
            padding: 5px 5px; 
            font-family: "Montserrat", sans-serif; 
            transition: background 0.3s;
        }
        .simple-header .container { 
            display: flex; 
            justify-content: space-between; 
            align-items: center; 
            max-width: 1920px; 
        }
        .simple-header span, .simple-header a {
            font-size: 15px; 
            font-weight: 600; 
            letter-spacing: 1px; 
            color: var(--custom-white);
            transition: color 0.3s; 
            text-shadow: 0px 0px 10px rgba(0, 0, 0, 0);
            display: inline-flex; 
            align-items: center;
            text-decoration: none;
        }
        .simple-header .header-contact span { margin-right: 15px; }
        .simple-header .social-icons a { margin-left: 15px; color: var(--custom-white); text-decoration: none; }
        .simple-header .social-icons i { font-size: 15px; vertical-align: middle; transition: color 0.3s; }
        .simple-header .social-icons a:hover, .simple-header .social-icons a:hover i { color: #e0e0e0; }

        /* Navigation Principale */
        .simple-navbar {
            background-color: var(--custom-white); 
            box-shadow: 0px 7px 10px 0px rgba(0,0,0,0.1); 
            padding: 0;
            position: sticky; 
            top: 0; 
            z-index: 1020; 
            transition: background 0.3s, box-shadow 0.3s;
        }
        .simple-navbar .container { max-width: 1920px; }
        .simple-navbar .navbar-brand img { height: 45px; width: auto; margin: 5px 0; }
        .simple-navbar .navbar-nav { align-items: center; }
        .simple-navbar .nav-link {
            font-family: "Montserrat", sans-serif; 
            font-size: 14px; 
            font-weight: 600; 
            text-transform: uppercase;
            color: var(--custom-secondary); 
            fill: var(--custom-secondary); 
            padding: 15px 10px; 
            margin: 0 5px;
            transition: color 0.3s; 
            position: relative;
        }
        .simple-navbar .nav-link:hover, .simple-navbar .nav-link.active, .simple-navbar .nav-link:focus {
            color: var(--custom-accent); 
            fill: var(--custom-accent);
        }
        .simple-navbar .nav-link::after { /* Soulignement au survol */
            content: ''; 
            position: absolute; 
            bottom: 5px; 
            left: 10px; 
            right: 10px; 
            height: 2px;
            background-color: var(--custom-accent); 
            transform: scaleX(0); 
            transition: transform 0.3s ease-in-out;
        }
        .simple-navbar .nav-link:hover::after, .simple-navbar .nav-link.active::after, .simple-navbar .nav-link:focus::after {
             transform: scaleX(1);
        }
        .simple-navbar .navbar-toggler { border-color: rgba(0,0,0,.1); }
        .simple-navbar .navbar-toggler-icon { 
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba(0, 86, 179, 0.8)' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e"); 
        }

        /* Hero Banner Section */
        .hero-banner-section {
            position: relative;
            min-height: 600px;
            width: 100%;
            padding: 5rem 1rem;
            background-color: #0056b3; /* Couleur de secours si image ne charge pas */
            color: var(--custom-white);
            overflow: hidden;
        }

        .hero-banner-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: transparent; 
            background-image: linear-gradient(180deg, #00000054 0%, #0A0003C9 100%); 
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .hero-banner-section .container {
            position: relative;
            z-index: 1;
            text-align: center;
        }

        .banner-title {
            font-family: 'Poppins', sans-serif;
            font-weight: 700;
            font-size: 2.8rem;
            color: var(--custom-white);
            text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.6);
            margin: 0;
        }

        /* Style spécifique SaNOSPro */
        .sanospro-top-section {
            background-color: #e9ecef;
            padding: 2rem 1rem;
            text-align: center;
        }
        .sanospro-top-section h1 {
            color: var(--custom-primary);
            font-family: 'Poppins', sans-serif;
            font-weight: 700;
        }
        .theme-section { text-align: center; margin-bottom: 2rem; }
        .theme-section p { font-size: 1.1rem; color: var(--custom-secondary); }
        .theme-section h2 { font-size: 1.5rem; color: var(--custom-primary); margin-top: 1rem; font-weight: 600; }

        .info-section .info-image { max-width: 100%; height: auto; border-radius: 5px; }
        .info-section h3 { color: var(--custom-primary); font-size: 1.4rem; margin-bottom: 1rem; font-weight: 700;}
        .info-section ul { list-style: none; padding: 0; }
        .info-section li { margin-bottom: 0.75rem; display: flex; align-items: center; }
        .info-section li i { margin-right: 10px; color: var(--custom-primary); width: 20px; text-align: center; }

        .about-section h3 { color: var(--custom-primary); font-size: 1.6rem; margin-bottom: 1.5rem; font-weight: 700; text-align: center;}
        .about-section ul { padding-left: 20px; margin-top: 1rem; }

        /* Styles pour les boîtes CTA avec image de fond */
        .cta-box {
            border-radius: 8px;
            margin-bottom: 1.5rem;
            transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
            overflow: hidden;
            position: relative;
            min-height: 280px;
            background-color: #2c3e50; /* Couleur de secours */
            background-size: cover;
            background-position: center center;
            background-repeat: no-repeat;
            cursor: pointer;
        }
        .cta-box:hover {
             transform: translateY(-5px) scale(1.02);
             box-shadow: 0 6px 20px rgba(0, 86, 179, 0.25);
        }

        .cta-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: transparent;
            transition: background-color 0.4s ease-in-out;
            padding: 1.5rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            box-sizing: border-box;
            text-align: center;
        }

        .cta-box:hover .cta-overlay {
            background-color: rgba(0, 30, 80, 0.75);
        }

        .cta-box h4 {
             color: var(--custom-white);
             font-size: 1.4rem;
             margin-bottom: 0.75rem;
             font-weight: 700;
             text-shadow: 1px 1px 4px rgba(0,0,0,0.8);
             line-height: 1.3;
             position: relative;
             z-index: 2;
        }
        .cta-box p {
            color: var(--custom-white);
            font-size: 0.95rem;
            margin-bottom: 1.2rem;
            text-shadow: 1px 1px 3px rgba(0,0,0,0.8);
            position: relative;
            z-index: 2;
        }
        .cta-box p i {
            margin-right: 5px;
            opacity: 0.9;
        }

        .cta-box .btn {
            background-color: var(--custom-white);
            color: var(--custom-primary);
            border: none;
            padding: 0.7rem 1.4rem;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.85rem;
            border-radius: 50px;
            transition: background-color 0.3s, color 0.3s, transform 0.2s;
            margin-top: auto;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
            position: relative;
            z-index: 2;
        }
        .cta-box .btn:hover {
             background-color: var(--custom-accent);
             color: var(--custom-white);
             transform: scale(1.05);
        }
        .cta-box .btn i { margin-right: 8px; }

        /* Styles spécifiques pour la box PEE au survol */
        .cta-box.special-cta:hover .cta-overlay {
             background-color: rgba(192, 57, 43, 0.8);
        }
        .cta-box .btn-pee {
             background-color: #c0392b;
             color: white;
        }
        .cta-box .btn-pee:hover {
            background-color: var(--custom-white);
            color: #c0392b;
        }
        
        /* Sections conférenciers, sponsors et réseaux sociaux */
        .speakers-section h3, .sponsors-section h3, .follow-section h3 {
             text-align: center; 
             color: var(--custom-primary); 
             font-size: 1.6rem; 
             margin-bottom: 1.5rem; 
             font-weight: 700;
        }
        
        /* Section conférenciers */
        .speakers-section h3.section-heading {
             text-align: center;
             color: var(--custom-primary);
             font-size: 1.8rem;
             margin-bottom: 2.5rem;
             font-weight: 700;
             position: relative;
             padding-bottom: 10px;
        }
        
        .speakers-section h3.section-heading::after {
             content: '';
             position: absolute;
             bottom: 0;
             left: 50%;
             transform: translateX(-50%);
             width: 60px;
             height: 3px;
             background-color: var(--custom-primary);
         }

        .speaker-card {
            background-color: var(--custom-white);
            border-radius: 10px;
            padding: 1.5rem 1rem;
            text-align: center;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            display: flex;
            flex-direction: column;
        }
        .speaker-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 8px 25px rgba(0, 86, 179, 0.15);
        }

        .speaker-avatar {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            margin: 0 auto 1rem auto;
            border: 3px solid var(--custom-light-gray);
            background-color: #e0e0e0; /* Couleur de secours */
        }

        .speaker-info {
             flex-grow: 1;
             display: flex;
             flex-direction: column;
             justify-content: flex-start;
        }

        .speaker-name {
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
            color: var(--custom-primary);
            font-size: 1.2rem;
            margin-bottom: 0.25rem;
        }

        .speaker-title {
            font-size: 0.9rem;
            color: var(--custom-secondary);
            margin-bottom: 0.75rem;
            font-style: italic;
            min-height: 1.2em;
        }

        .speaker-topic {
            font-size: 0.95rem;
            color: #444;
            line-height: 1.5;
            margin-top: auto;
        }
        .speaker-topic strong {
             color: var(--custom-primary);
             display: block;
             margin-bottom: 0.25rem;
             font-weight: 600;
         }
         
        /* Styles pour le Carousel Sponsors */
        .sponsors-section {
            position: relative;
            padding-left: 40px;
            padding-right: 40px;
        }
        .sponsors-carousel {
            width: 100%;
            overflow: hidden;
        }
        .sponsors-carousel .swiper-slide {
            text-align: center;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100px;
        }
        .sponsors-carousel .swiper-slide img {
            max-width: 100%;
            max-height: 80px;
            height: auto;
            transition: filter 0.3s, opacity 0.3s;
            opacity: 0.7;
            object-fit: contain;
        }
        .sponsors-carousel .swiper-slide:hover img {
            filter: grayscale(0%);
            opacity: 1;
        }

        /* Navigation du carousel */
        .sponsors-swiper-prev,
        .sponsors-swiper-next {
            color: var(--custom-primary);
            width: 30px;
            height: 30px;
            margin-top: -15px;
            background-color: rgba(255, 255, 255, 0.7);
            border-radius: 50%;
        }
        .sponsors-swiper-prev::after,
        .sponsors-swiper-next::after {
            font-size: 16px;
            font-weight: bold;
        }
        .sponsors-swiper-prev { left: 5px; }
        .sponsors-swiper-next { right: 5px; }
        
        /* Section réseaux sociaux */
        .follow-section .social-icons a {
             color: var(--custom-primary); 
             font-size: 1.8rem; 
             margin: 0 10px; 
             transition: color 0.3s;
             text-decoration: none;
        }
        .follow-section .social-icons a:hover { color: var(--custom-secondary); }

        hr.section-divider { border-top: 1px solid #ddd; margin: 2rem 0;}

        /* Footer */
        .simple-footer {
            background-color: var(--custom-dark-footer); 
            color: var(--custom-footer-text); 
            padding: 2rem 0; 
            text-align: center;
            font-size: 0.9rem; 
            margin-top: 2rem;
        }
        .simple-footer a { 
            color: var(--custom-footer-link); 
            text-decoration: none;
        }
        .simple-footer a:hover { color: var(--custom-white); }
        .simple-footer .social-icons a { margin: 0 10px; }
        .simple-footer .social-icons i { font-size: 1.2rem; }

        /* Modal forms */
        .modal-content {
            border-radius: 8px;
            border: none;
        }
        .modal-header {
            background-color: var(--custom-primary);
            color: var(--custom-white);
            border-top-left-radius: 8px;
            border-top-right-radius: 8px;
        }
        .modal-title {
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
        }
        .modal-form-label {
            font-weight: 500;
            font-size: 0.9rem;
            color: var(--custom-secondary);
        }
        .modal-form-input {
            border: 1px solid #ddd;
            padding: 0.6rem;
        }
        .modal-form-submit {
            background-color: var(--custom-primary);
            border: none;
            padding: 0.7rem 0;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.9rem;
            border-radius: 4px;
        }

        /* Styles Responsive */
        @media (max-width: 1024px) {
             .simple-header span, .simple-header a { font-size: 13px; letter-spacing: 0.5px; }
             .simple-navbar .nav-link { font-size: 13px; padding: 12px 8px; }
             .banner-title { font-size: 2.4rem; }
        }
        @media (max-width: 767px) {
             .simple-header .header-contact { display: none; }
             .simple-header .container { justify-content: center; }
             .simple-header .social-icons a { margin: 0 10px; }
             .simple-navbar .navbar-brand img { height: 35px; }
             .simple-navbar .navbar-nav { margin-top: 10px; }
             .simple-navbar .nav-link { font-size: 12px; padding: 10px 8px;}
             .info-section .col-md-6 { text-align: center; }
             .info-section .info-image { margin-bottom: 1.5rem; }
             .cta-box h4 { font-size: 1.2rem; }
             .speakers-section h3, .sponsors-section h3, .follow-section h3 { font-size: 1.4rem; }
             .banner-title { font-size: 1.8rem; }
             .hero-banner-section { min-height: 400px; }
        }
    </style>

  

    
    <!-- Section Hero Banner Titre -->
    <section class="hero-banner-section">
        <div class="hero-banner-overlay">
            <div class="container">
                 <h1 class="banner-title">Salon National d'Orientation et de Stages Professionnels (SaNOSPro)</h1>
            </div>
        </div>
    </section>

    <main id="content" class="site-main">
        <div class="container mt-4">
            <section class="theme-section">
                <p><strong><span style="text-decoration: underline;">THEME</span></strong>: Promouvoir la Synergie Inter-Entreprises et trouver des Approches de Solutions aux Difficultés d'Accès aux Stages des Nouveaux Diplômés de nos Universités et Ecoles Supérieures.</p>
                <hr style="width: 50%; margin: 1.5rem auto;">
                <h2>SaNOSPro (Salon National d'Orientation et de Stages Professionnels)</h2>
            </section>

            <section class="info-section my-5">
                <div class="row align-items-center">
                    <div class="col-md-6 mb-4 mb-md-0">
                        <img src="/api/placeholder/500/300" alt="Logo SaNOSPro" class="info-image img-fluid shadow-sm">
                    </div>
                    <div class="col-md-6">
                        <h3>INFORMATIONS PRATIQUES</h3>
                        <ul>
                            <li><i class="far fa-calendar-alt"></i> Jeudi 21, Vendredi 22 → Samedi 23 Mars 2024 - 08:00</li>
                            <li><i class="fas fa-calendar-day"></i> Programme du salon</li>
                            <li><i class="fas fa-user-graduate"></i> StagesBENIN</li>
                            <li><i class="fas fa-globe"></i> BENIN</li>
                            <li><i class="fas fa-map-marker-alt"></i> Université d'Abomey-Calavi, Bénin</li>
                        </ul>
                    </div>
                </div>
            </section>

            <hr class="section-divider">

            <!-- Section Que Savoir -->
            <section class="about-section my-5">
                 <h3>Que savoir sur ce salon ?</h3>
                 <p style="text-align: left;"><strong>Le Salon National d'Orientation et de Stages Professionnels</strong> vise à créer une plateforme dynamique de collaboration entre des entreprises de tous secteurs d'activités, de leur offrir une visibilité auprès d'un public ciblé et d'échanger avec d'autres acteurs clés autour de thèmes enrichissants sur la question de l'insertion professionnelle des jeunes diplômés de nos universités et écoles supérieures. <br>Le <strong>SaNOSPro</strong> constitue donc une réponse pertinente à la résolution de nombreux défis liés à la création d'opportunités pour les entreprises et la transition du monde académique au monde professionnel de nos étudiants.</p>
                 <p><strong>Ce que vous pouvez attendre</strong>:</p>
                 <ul>
                    <li>Des sessions informatives sur le thème central.</li>
                    <li>Des conférenciers experts partageant leurs connaissances.</li>
                    <li>Des opportunités de réseautage entre étudiants et entreprises.</li>
                    <li>Des discussions interactives pour trouver des solutions concrètes.</li>
                 </ul>
            </section>

            <!-- Section Blocs CTA -->
            <section class="cta-section my-5">
                 <div class="row">
                     <div class="col-lg-4 col-md-6 mb-4">
                         <div class="cta-box" style="background-color: #2980b9;">
                             <div class="cta-overlay">
                                 <h4>Je participe à SaNOSPro</h4>
                                 <p><i class="fas fa-user-graduate"></i> Étudiants, Diplômés et Particuliers</p>
                                 <button class="btn" data-bs-toggle="modal" data-bs-target="#modalJeParticipe">
                                     <i class="fas fa-reply-all"></i> JE PARTICIPE
                                 </button>
                             </div>
                         </div>
                     </div>
                     <div class="col-lg-4 col-md-6 mb-4">
                         <div class="cta-box" style="background-color: #27ae60;">
                             <div class="cta-overlay">
                                 <h4>Je réserve un Stand</h4>
                                 <p><i class="fas fa-shopping-cart"></i> Entreprises, Organisations, Particuliers et Commerçants</p>
                                 <button class="btn">
                                     <i class="fas fa-shopping-cart"></i> RESERVER UN STAND
                                 </button>
                             </div>
                         </div>
                     </div>
                     <div class="col-lg-4 col-md-6 mb-4">
                          <div class="cta-box" style="background-color: #8e44ad;">
                             <div class="cta-overlay">
                                 <h4>Soutenir le SaNOSPro</h4>
                                 <p><i class="fas fa-user-friends"></i> Entreprises, Personnalités Politico-Administratives; Fondations et Particuliers</p>
                                 <button class="btn">
                                     <i class="far fa-thumbs-up"></i> COMMENT SOUTENIR
                                 </button>
                              </div>
                          </div>
                      </div>
                    

                                