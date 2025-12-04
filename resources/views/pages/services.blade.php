@extends('layouts.layout')
@section('title', 'StagesBENIN')
@section('content')
<br><br><br>

<style>
    /* Base styles */
    * {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
    }

    body {
        line-height: 1.6;
        color: #333;
        font-family: 'Times New Roman', Times, serif;
        overflow-x: hidden; /* Empêche le défilement horizontal */
    }

    .container {
        width: 90%;
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 15px;
    }

    img {
        max-width: 100%;
        height: auto;
        display: block; /* Empêche les espaces blancs sous les images */
    }

    /* Animation effects */
    .fade-in {
        opacity: 0;
        transform: translateY(30px);
        transition: opacity 1s ease-out, transform 1s ease-out;
    }

    .fade-in.show {
        opacity: 1;
        transform: translateY(0);
    }

    .zoom-in {
        transform: scale(0.8);
        opacity: 0;
        transition: transform 0.8s ease-out, opacity 0.8s ease-out;
    }

    .zoom-in.show {
        transform: scale(1);
        opacity: 1;
    }

    /* Page title */
    .page-title {
        text-align: center;
        color: #0056b3;
        margin: 40px 0;
        font-size: 2.5rem;
        font-weight: 700;
    }

    /* About section */
    .stages-section {
        padding: 60px 0;
        overflow: hidden; /* Empêche le contenu de déborder sur mobile */
    }

    .stages-title {
        font-weight: bold;
        position: relative;
        display: inline-block;
        padding-bottom: 10px;
        color: #0000ff;
        font-size: 2rem;
        margin-bottom: 20px;
    }

    .stages-title::after {
        content: '';
        width: 80px;
        height: 3px;
        background-color: #007bff;
        position: absolute;
        bottom: 0;
        left: 0;
    }

    .stages-text {
        font-size: 1.1rem;
        color: #444;
        line-height: 1.8;
    }

    .stages-text b {
        color: #000;
    }

    .row {
        display: flex;
        flex-wrap: wrap;
        margin: 0 -15px; /* Gutter négatif */
    }

    .col-md-6 {
       /* flex: 0 0 50%; */ /* Base desktop enlevée pour mobile first */
       /* max-width: 50%; */ /* Base desktop enlevée */
        padding: 0 15px; /* Gutter positif */
        width: 100%; /* Base pour mobile */
        margin-bottom: 30px; /* Espace mobile */
    }
     /* Rétablir pour desktop */
     @media (min-width: 768px) {
        .col-md-6 {
            flex: 0 0 50%;
            max-width: 50%;
            margin-bottom: 0; /* Pas de marge en bas sur desktop */
        }
     }


    .img-fluid {
        width: 100%;
        border-radius: 8px;
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    }

    /* Services section */
    .services-container {
        max-width: 1200px;
        margin: auto;
        padding: 50px 20px;
    }

    .section-container {
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        background-color: rgb(250, 250, 253);
        margin-top: 10px;
        padding: 40px 0;
         overflow: hidden; /* Empêche le contenu de déborder sur mobile */
    }

    .section-title {
        text-align: center;
        font-weight: bold;
        font-size: 2.2rem;
        color: black;
        margin-bottom: 40px;
        margin-top: 20px;
        position: relative;
    }
     /* Responsive pour titre section */
    @media (max-width: 768px) {
        .section-title {
            font-size: 1.8rem;
             margin-bottom: 50px; /* Plus d'espace pour l'after */
        }
    }

    .section-title::after {
        content: '';
        width: 80px;
        height: 3px;
        background-color: #0000ff;
        position: absolute;
        bottom: -10px;
        left: 50%;
        transform: translateX(-50%);
    }

    .section-subtitle {
        text-align: center;
        font-size: 1rem; /* Légèrement réduit pour mobile */
        font-weight: 700;
        color: black;
        margin-bottom: 15px; /* Réduit */
        padding: 0 10px; /* Ajout de padding horizontal pour éviter le collage aux bords */
    }
     /* Rétablir pour desktop */
     @media (min-width: 768px) {
        .section-subtitle {
            font-size: 2rem; /* Retour taille originale */
            margin-bottom: 40px;
        }
     }

    .service-grid {
        display: grid;
        /* Utilisation de auto-fit pour mieux s'adapter */
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); /* Base mobile */
        gap: 15px; /* Espace mobile */
        margin-top: 40px;
        padding: 0 10px; /* Padding pour éviter le collage aux bords sur mobile */
    }
     /* Ajustement tablette */
     @media (min-width: 576px) {
        .service-grid {
             grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
             gap: 20px;
        }
     }
     /* Ajustement desktop */
      @media (min-width: 768px) {
        .service-grid {
             grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); /* Un peu plus large */
             padding: 0; /* Reset padding */
        }
     }
      @media (min-width: 992px) {
        .service-grid {
             grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); /* Encore plus large */
        }
     }


    .service-card {
        background: white;
        border-radius: 10px;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        text-align: center;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        padding: 20px 15px; /* Padding mobile */
        display: flex;
        flex-direction: column;
        justify-content: flex-start;
    }
     /* Ajustement padding desktop */
     @media (min-width: 768px) {
        .service-card {
            padding: 25px 15px;
        }
     }
      @media (min-width: 992px) {
        .service-card {
            padding: 30px 20px;
        }
     }


    .service-card:hover {
        transform: translateY(-5px);
        box-shadow: 0px 8px 20px rgba(0, 0, 0, 0.15);
    }

    .service-icon {
        font-size: 2rem; /* Taille mobile */
        color: #0000ff;
        margin-bottom: 15px;
    }
    /* Augmentation taille icône desktop */
     @media (min-width: 768px) {
        .service-icon {
            font-size: 2.2rem;
        }
     }
     @media (min-width: 992px) {
        .service-icon {
            font-size: 2.5rem;
        }
     }


    .service-card h5 {
        font-size: 1rem; /* Taille mobile */
        font-weight: bold;
        color: #333;
        margin-bottom: 10px; /* Réduit */
        flex-grow: 1; /* Permet au titre de prendre l'espace si nécessaire */
    }
    /* Augmentation taille titre service desktop */
     @media (min-width: 768px) {
        .service-card h5 {
            font-size: 1.1rem;
        }
     }
      @media (min-width: 992px) {
        .service-card h5 {
            font-size: 1.2rem;
        }
     }


    /* ================================================== */
    /* START: CSS PACKS SECTION - AJOUT DES FONT-SIZE RESPONSIVES */
    /* ================================================== */

    .tab-container {
        display: flex;
        justify-content: center;
        margin: 30px 0 20px;
        gap: 10px;
        flex-wrap: wrap;
        padding: 0 10px;
    }

    .tab-button {
        background-color: #1E90FF;
        color: white;
        border: none;
        padding: 12px 20px; /* Padding mobile */
        cursor: pointer;
        font-size: 0.95rem; /* Taille police mobile */
        font-weight: bold;
        border-radius: 5px;
        transition: background-color 0.3s ease, transform 0.2s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        flex-grow: 1;
        flex-basis: 150px;
        text-align: center;
    }

   /* #candidatsBtn:not(.active) {
        background-color: #007bff;
    }*/ 

    .tab-button:hover {
        transform: translateY(-2px);
    }

   /* .tab-button.active {
        background-color: rgb(26, 18, 117);
        box-shadow: 0 4px 8px rgba(0,0,0,0.2);
    }*/

    .packs-container {
        margin-top: 30px;
        display: none;
        padding: 0 10px;
        overflow: hidden;
    }

    .packs-container.active {
        display: block;
        animation: fadeIn 0.5s ease;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* -- Styles pour les Packs Candidats -- */
    .packs-row {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 20px;
        margin-bottom: 40px;
    }

    .pack-card {
        background: #fff;
        border: 1px solid #eee;
        border-radius: 12px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        overflow: hidden;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        display: flex;
        flex-direction: column;
        flex: 1 1 100%; /* Mobile */
        min-width: 280px;
        max-width: 100%; /* Mobile */
        margin-bottom: 20px;
    }

    .pack-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.12);
    }

    .pack-header {
        background-color: #007bff;
        color: white;
        padding: 15px 20px;
        text-align: center;
    }

    .pack-title {
        margin: 0;
        font-size: 1.3rem; /* Taille mobile */
        font-weight: 700;
        line-height: 1.3;
    }

    .pack-subtitle {
        margin: 5px 0 0;
        font-size: 0.9rem; /* Taille mobile */
        opacity: 0.9;
    }

    .pack-content {
        padding: 20px;
        flex-grow: 1;
    }

    .pack-section {
        margin-bottom: 15px;
    }

    .pack-section-title {
        margin: 0 0 8px;
        font-size: 1.05rem; /* Taille mobile */
        font-weight: 600;
        color: #333;
    }

    .pack-text {
        margin: 0 0 10px;
        color: #555;
        line-height: 1.5;
        font-size: 0.85rem; /* Taille mobile */
    }

    .pack-list {
        margin: 0 0 10px;
        padding-left: 20px;
        color: #555;
        font-size: 0.85rem; /* Taille mobile */
    }

    .pack-list li {
        margin-bottom: 5px;
        line-height: 1.5;
    }

    /* -- Styles pour les Packs Entreprises -- */
    .content {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 20px;
        margin-bottom: 30px;
    }

    .pack {
        background: white;
        padding: 20px; /* Padding mobile */
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        text-align: left;
        flex: 1 1 100%; /* Mobile */
        min-width: 280px;
        max-width: 100%; /* Mobile */
        margin: 0 0 20px 0;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        display: flex;
        flex-direction: column;
        position: relative;
    }

    .pack:hover {
        transform: translateY(-5px);
        box-shadow: 0px 8px 20px rgba(0, 0, 0, 0.15);
    }

    .pack h1 { /* Titre Pack 1, 2 etc. */
        background: rgb(26, 18, 117);
        color: white;
        padding: 12px 15px;
        text-align: center;
        border-radius: 5px 5px 0 0;
        font-size: 1.4rem; /* Taille mobile */
        margin: -20px -20px 15px -20px;
    }

    .pack h2 { /* Titre AVANTAGES, LIMITES */
        color: #0000ff;
        text-align: center;
        font-size: 1.1rem; /* Taille mobile */
        border-bottom: 2px solid #0000ff;
        padding-bottom: 8px;
        margin-bottom: 15px;
        margin-top: 0;
    }

    .pack .price {
        font-weight: bold;
        color: black;
        text-align: center;
        margin: 15px 0;
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        align-items: baseline;
        gap: 5px 10px;
        font-size: 0.9rem; /* Taille texte '/ ANNÉE' mobile */
    }

    .pack .old-price {
        text-decoration: line-through;
        color: red;
        font-size: 1rem; /* Taille prix barré mobile */
        margin-right: 5px;
    }

    .pack .price span:not(.old-price) { /* Prix actuel */
        font-size: 1.2rem; /* Taille prix actuel mobile */
        color: #000;
    }

    .pack .price span[style*="color:red"] { /* Prix sur mesure */
        font-size: 1.2rem; /* Taille mobile */
        font-weight: bold;
        color: red !important;
    }

    /* Style commun pour .pack-features */
    .pack-features {
        margin: 0;
        padding: 0;
        list-style: none;
        font-size: 0.85rem; /* Taille texte features mobile */
        flex-grow: 1;
        margin-bottom: 15px;
    }
    .pack-features li {
        padding: 8px 0;
        border-bottom: 1px solid #eee;
        line-height: 1.5;
    }
    .pack-features li:last-child {
        border-bottom: none;
    }

    #candidatsPacks .pack-features li {
        margin-bottom: 8px;
        display: flex;
        align-items: flex-start;
    }
    .check-icon {
        color: #4CAF50;
        font-weight: bold;
        margin-right: 8px;
        font-size: 0.9rem; /* Taille icône mobile */
        flex-shrink: 0;
        margin-top: 3px;
    }

     #entreprisesPacks .pack-features li {
        display: block;
     }

    /* Style commun pour les boutons Souscrire */
    .btn-subscribe {
        display: block;
        text-align: center;
        background: rgb(26, 18, 117);
        color: white !important;
        text-decoration: none !important;
        padding: 12px 15px; /* Padding mobile */
        border-radius: 5px;
        margin-top: auto;
        font-weight: bold;
        transition: background 0.3s ease, transform 0.2s ease;
        font-size: 0.95rem; /* Taille bouton mobile */
        border: none;
        cursor: pointer;
    }

    a.btn-subscribe:hover {
        background: rgb(31, 15, 71);
        transform: translateY(-2px);
        color: white !important;
        text-decoration: none !important;
    }

    /* Styles pour les badges */
    .badge-custom {
        font-size: 0.75rem;
        padding: 4px 10px;
        border-radius: 15px;
        position: absolute;
        top: 10px;
        right: 10px;
        z-index: 1;
        font-weight: bold;
    }


    /* --- Media Queries pour écrans plus grands --- */

    /* Tablette ( paysage et +) et petits desktops */
    @media (min-width: 768px) {
        .tab-container {
            flex-wrap: nowrap;
            gap: 20px;
            padding: 0;
        }
        .tab-button {
            flex-grow: 0;
            flex-basis: auto;
            padding: 15px 30px;
            font-size: 1.1rem; /* Taille police onglet tablette */
        }
        .packs-container {
             padding: 0;
        }

        /* Packs Candidats: 2 colonnes */
        .pack-card {
            flex: 1 1 calc(50% - 10px);
            max-width: calc(50% - 10px);
            margin-bottom: 20px;
        }
        .pack-title { font-size: 1.5rem; } /* Taille tablette */
        .pack-subtitle { font-size: 0.95rem; } /* Taille tablette */
        .pack-section-title { font-size: 1.15rem; } /* Taille tablette */
        .pack-text, .pack-list, #candidatsPacks .pack-features { font-size: 0.9rem; } /* Taille tablette */
        .check-icon { font-size: 1rem; } /* Taille tablette */

        /* Packs Entreprises: 3 colonnes */
        .pack {
            flex: 1 1 calc(33.333% - 14px);
            max-width: calc(33.333% - 14px);
            padding: 25px;
            margin: 0;
        }
         .pack h1 { font-size: 1.8rem; margin: -25px -25px 20px -25px; } /* Taille tablette */
         .pack h2 { font-size: 1.4rem; } /* Taille tablette */
         .pack .price { font-size: 1rem; } /* Taille texte '/ ANNÉE' tablette */
         .pack .old-price { font-size: 1.1rem; } /* Taille prix barré tablette */
         .pack .price span:not(.old-price) { font-size: 1.5rem; } /* Taille prix actuel tablette */
         .pack .price span[style*="color:red"] { font-size: 1.5rem; } /* Taille tablette */
         #entreprisesPacks .pack-features { font-size: 0.9rem; } /* Taille texte features tablette */
         #entreprisesPacks .pack-features li { padding: 10px 0; }

         .btn-subscribe { padding: 14px 20px; font-size: 1rem; } /* Taille bouton tablette */
    }

    /* Larges desktops */
    @media (min-width: 992px) {
        /* Packs Candidats: 3 colonnes */
         .pack-card {
            flex: 1 1 calc(33.333% - 14px);
            max-width: calc(33.333% - 14px);
         }
          .pack-header { padding: 20px; }
          .pack-title { font-size: 1.6rem; } /* Taille desktop */
          .pack-subtitle { font-size: 1rem; } /* Taille desktop */
          .pack-section-title { font-size: 1.2rem; } /* Taille desktop */
          .pack-text, .pack-list, #candidatsPacks .pack-features { font-size: 1rem; } /* Taille desktop */
          .check-icon { font-size: 1.1rem; } /* Taille desktop */
          #candidatsPacks .pack-features li { padding: 10px 0; } /* Ajustement padding */


        /* Packs Entreprises: Reste à 3 colonnes */
         .pack {
            padding: 30px;
         }
         .pack h1 { font-size: 2rem; margin: -30px -30px 25px -30px; } /* Taille desktop */
         .pack h2 { font-size: 1.6rem; } /* Taille desktop */
         .pack .price { font-size: 1.1rem; } /* Taille texte '/ ANNÉE' desktop */
         .pack .old-price { font-size: 1.3rem; } /* Taille prix barré desktop */
         .pack .price span:not(.old-price) { font-size: 1.8rem; } /* Taille prix actuel desktop */
         .pack .price span[style*="color:red"] { font-size: 1.8rem; } /* Taille desktop */
         #entreprisesPacks .pack-features { font-size: 1rem; } /* Taille texte features desktop */
         #entreprisesPacks .pack-features li { padding: 12px 0; }

         .btn-subscribe { padding: 15px 25px; font-size: 1.1rem; } /* Taille bouton desktop */
    }

    /* ================================================ */
    /* END: CSS PACKS SECTION - AJOUT DES FONT-SIZE RESPONSIVES */
    /* ================================================ */

    /* Styles spécifiques pour les badges (Populaire, Recommandé) - Inchangé */
   .badge-custom {
       font-size: 0.8rem;
       padding: 5px 10px;
       border-radius: 15px;
       position: absolute;
       top: 10px;
       right: 10px;
       z-index: 1;
       font-weight: bold;
   }

</style>

<section class="stages-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6 fade-in">
                <h1 class="stages-title">StagesBENIN</h1>
                <p class="stages-text" style="text-align: justify;">
                    Est une entreprise initiée par de jeunes entrepreneurs depuis août 2023 spécialisée dans :
                    <br><b> L'insertion professionnelle</b> à travers la mise en stage et l'emploi.
                    <br><b> La visibilité digitale</b> des entreprises et le référencement web.
                    <br>Nous résolvons la problématique de la transition des jeunes en fin de formation vers le monde professionnel, en leur offrant un coaching personnalisé et en nous occupant de leur mise en relation avec les entreprises partenaires.
                </p>
            </div>
            <div class="col-md-6 fade-in">
                <img src="{{ asset('assets/images/img1.avif') }}" class="img-fluid" alt="Statistiques">
            </div>
        </div>
    </div>
</section>
<!-- Services Section -->
<div class="section-container">
    <!-- Enterprise Services -->
    <div class="services-container fade-in">
        <h2 class="section-title zoom-in">Nos services pour Entreprises</h2>
        <div class="service-grid">
            <div class="service-card zoom-in">
                <i class="bi bi-person-plus service-icon"></i>
                <h5>Visibilité dès l'inscription</h5>
            </div>
            <div class="service-card zoom-in">
                <i class="bi bi-list service-icon"></i>
                <h5>Page de service</h5>
            </div>
            <div class="service-card zoom-in">
                <i class="bi bi-chat-dots service-icon"></i>
                <h5>Messagerie instantanée</h5>
            </div>
            <div class="service-card zoom-in">
                <i class="bi bi-calendar-event service-icon"></i>
                <h5>Page évènement</h5>
            </div>
            <div class="service-card zoom-in">
                <i class="bi bi-envelope service-icon"></i>
                <h5>Campagnes mailing & SMS</h5>
            </div>
            <div class="service-card zoom-in">
                <i class="bi bi-camera-video service-icon"></i>
                <h5>Campagnes Vidéos</h5>
            </div>
            <div class="service-card zoom-in">
                <i class="bi bi-images service-icon"></i>
                <h5>Campagnes affiches</h5>
            </div>
            <div class="service-card zoom-in">
                <i class="bi bi-file-earmark-person service-icon"></i>
                <h5>CV Thèque</h5>
            </div>
            <div class="service-card zoom-in">
                <i class="bi bi-briefcase service-icon"></i>
                <h5>Marchés Privés / Publics</h5>
            </div>
            <div class="service-card zoom-in">
                <i class="fa-solid fa-briefcase service-icon"></i>
                <h5>Création & Gestion d'Entreprise</h5>
            </div>
            <div class="service-card zoom-in">
                <i class="bi bi-search service-icon"></i>
                <h5>Étude de marché</h5>
            </div>
            <div class="service-card zoom-in">
                <i class="fa-solid fa-chart-line service-icon"></i>
                <h5 class="service-title">Réalisation de plan d'affaires</h5>
            </div>

            <div class="service-card zoom-in">
                <i class="fa-solid fa-hand-holding-dollar service-icon"></i>
                <h5 class="service-title">Levée de fonds</h5>
            </div>
        </div>
    </div>

    <!-- Candidate Services -->
    <div class="services-container fade-in">
        <h2 class="section-title zoom-in">Nos Services pour Candidats</h2>
        <div class="service-grid">
            <div class="service-card zoom-in">
                <i class="bi bi-person-plus service-icon"></i>
                <h5>Inscription</h5>
            </div>
            <div class="service-card zoom-in">
                <i class="bi bi-chat-dots service-icon"></i>
                <h5>Entretien</h5>
            </div>
            <div class="service-card zoom-in">
                <i class="bi bi-compass service-icon"></i>
                <h5>Orientation</h5>
            </div>
            <div class="service-card zoom-in">
                <i class="bi bi-mortarboard service-icon"></i>
                <h5>Formation</h5>
            </div>
            <div class="service-card zoom-in">
                <i class="fa-solid fa-building service-icon"></i>
                <h5>Intégration</h5>
            </div>
            <div class="service-card zoom-in">
                <i class="bi bi-person-lines-fill service-icon"></i>
                <h5>Accompagnement</h5>
            </div>
            <div class="service-card zoom-in">
                <i class="bi bi-arrow-repeat service-icon"></i>
                <h5>Suivis</h5>
            </div>
            <div class="service-card zoom-in">
                <i class="bi bi-briefcase service-icon"></i>
                <h5>Formation de Carrière</h5>
            </div>
           <div class="service-card zoom-in">
                <i class="fa-solid fa-users service-icon"></i>
                <h5>Réseautage / Networking</h5>
            </div>
        </div>
    </div>
</div>

<!-- Packs Section -->
<div class="container fade-in" style="margin-top: 10px; margin-bottom: 19px;">
    <h6 class="section-subtitle">Découvrez nos packs conçus sur mesure pour répondre aux besoins des entreprises, des professionnels et des stagiaires en quête d'expérience.</h6>
    <!-- Tab Buttons -->
    <div class="tab-container">
        <button id="entreprisesBtn" class="tab-button active" style="background-color: rgb(26, 18, 117);">
            <i class="bi bi-building"></i> Entreprises
        </button>
        <button id="candidatsBtn" class="tab-button" style="background-color: #007bff">
            <i class="bi bi-person-badge"></i> Candidats
        </button>
    </div>

    <!-- Candidats Packs -->
    <div id="candidatsPacks" class="packs-container">
        <div class="packs-row">
            <!-- Pack Stage de Découverte -->
            <div class="pack-card">
                <div class="pack-header">
                    <h2 class="pack-title">1️⃣ Stage de Découverte</h2>
                    <p class="pack-subtitle">(Stage d'Observation)</p>
                </div>
                <div class="pack-content">
                    <div class="pack-section">
                        <h3 class="pack-section-title">🎯Objectif</h3>
                        <p class="pack-text">Permettre une première immersion en entreprise pour découvrir un métier ou un secteur d'activité avant d'engager une formation ou une spécialisation.</p>
                        <h3 class="pack-section-title">📌Public cible</h3>
                        <ul class="pack-list">
                            <li>Lycéens en phase d'orientation</li>
                            <li>Étudiants débutants souhaitant explorer un domaine</li>
                            <li>Toute personne curieuse d'un secteur avant d'entamer une formation spécialisée</li>
                        </ul>
                        <h3 class="pack-section-title">📅Durée : 1 à 3 mois</h3>
                        <h3 class="pack-section-title">📦Services inclus</h3>
                        <ul class="pack-features">
                            <li><span class="check-icon">✓</span> Accompagnement dans la définition des attentes et objectifs</li>
                            <li><span class="check-icon">✓</span> Recherche et mise en relation avec une entreprise adaptée</li>
                            <li><span class="check-icon">✓</span> Assistance pour la rédaction du CV et de la lettre de motivation</li>
                            <li><span class="check-icon">✓</span> Préparation à l'entretien d'entrée en stage</li>
                            <li><span class="check-icon">✓</span> Accompagnement administratif pour la convention de stage</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Pack Stage d’Immersion Académique -->
            <div class="pack-card">
                <div class="pack-header">
                    <h2 class="pack-title">2️⃣ Stage d’Immersion Académique</h2>
                </div>
                <div class="pack-content">
                    <div class="pack-section">
                        <h3 class="pack-section-title">🎯Objectif</h3>
                        <p class="pack-text">Permettre aux étudiants d’acquérir une expérience pratique en entreprise en lien avec leur formation académique.</p>
                        <h3 class="pack-section-title">📌Public cible</h3>
                        <ul class="pack-list">
                            <li> Étudiants en BTS, Licence, Master nécessitant un stage pour valider leur formation</li>
                            <li>Étudiants en fin de cycle souhaitant renforcer leur employabilité</li>
                        </ul>
                        <h3 class="pack-section-title">📅Durée : 3 mois</h3>
                         <h3 class="pack-section-title">📦Services inclus</h3>
                        <ul class="pack-features">
                            <li><span class="check-icon">✓</span> Analyse approfondie du profil et des objectifs professionnels</li>
                            <li><span class="check-icon">✓</span> Sélection et mise en relation avec des entreprises partenaires</li>
                            <li><span class="check-icon">✓</span> Assistance pour la rédaction et l’optimisation des outils de candidature</li>
                            <li><span class="check-icon">✓</span> Coaching pour la réussite des entretiens</li>
                            <li><span class="check-icon">✓</span> Suivi et évaluation pendant la période de stage</li>
                        </ul>
                    </div>
                </div>
            </div>

             <!-- Pack Stage Professionnel -->
            <div class="pack-card">
                <div class="pack-header">
                    <h2 class="pack-title">3️⃣ Stage Professionnel</h2>
                    <p class="pack-subtitle">(Pré-emploi)</p>
                </div>
                <div class="pack-content">
                    <div class="pack-section">
                        <h3 class="pack-section-title">🎯Objectif</h3>
                        <p class="pack-text">Faciliter l'insertion professionnelle durable via une expérience significative avec potentiel d'embauche.</p>
                        <h3 class="pack-section-title">📌Public cible</h3>
                        <ul class="pack-list">
                            <li>Jeunes diplômés en recherche de première expérience</li>
                            <li>Professionnels en reconversion ou en quête d’une spécialisation</li>
                        </ul>
                        <h3 class="pack-section-title">📅Durée : 3 à 6 mois</h3>
                        <h3 class="pack-section-title">📦Services inclus</h3>
                        <ul class="pack-features">
                            <li><span class="check-icon">✓</span> Analyse des compétences et attentes professionnelles</li>
                            <li><span class="check-icon">✓</span> Sélection des opportunités avec perspectives d’embauche</li>
                            <li><span class="check-icon">✓</span> Assistance pour la rédaction et l’optimisation des outils de candidature</li>
                            <li><span class="check-icon">✓</span> Coaching en soft skills et intégration en entreprise</li>
                            <li><span class="check-icon">✓</span> Assistance pour la négociation des conditions du stage</li>
                            <li><span class="check-icon">✓</span> Suivi personnalisé et accompagnement post-stage</li>
                        </ul>
                    </div>
                </div>
            </div>

             <!-- Pack Stage Formatif -->
            <div class="pack-card">
                <div class="pack-header">
                    <h2 class="pack-title">4️⃣ Stage Formatif</h2>
                    <p class="pack-subtitle">(Acquisition de Compétences Spécifiques)</p>
                </div>
                <div class="pack-content">
                    <div class="pack-section">
                        <h3 class="pack-section-title">🎯Objectif</h3>
                        <p class="pack-text">Développer des compétences pratiques ciblées en entreprise pour renforcer son employabilité.</p>
                        <h3 class="pack-section-title">📌Public cible</h3>
                        <ul class="pack-list">
                            <li>Étudiants, jeunes diplômés ou professionnels en quête de compétences spécifiques pratiques (Informatique de gestion, Entreprenariat …)</li>
                        </ul>
                        <h3 class="pack-section-title">📅Durée : 3 à 6 mois</h3>
                        <h3 class="pack-section-title">📦Services inclus</h3>
                        <ul class="pack-features">
                            <li><span class="check-icon">✓</span> Diagnostic des besoins en formation</li>
                            <li><span class="check-icon">✓</span> Placement dans une entreprise formatrice</li>
                            <li><span class="check-icon">✓</span> Suivi des compétences acquises et évaluations intermédiaires</li>
                            <li><span class="check-icon">✓</span> Attestation et recommandations professionnelles à la fin du stage</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Pack Accompagnement Recherche d’Emploi -->
            <div class="pack-card">
                <div class="pack-header">
                    <h2 class="pack-title">5️⃣ Accompagnement Recherche d’Emploi</h2>
                </div>
                <div class="pack-content">
                    <div class="pack-section">
                        <h3 class="pack-section-title">🎯Objectif</h3>
                        <p class="pack-text">Maximiser les chances de trouver un emploi stable et adapté au profil du candidat.</p>
                        <h3 class="pack-section-title">📌Public cible</h3>
                        <ul class="pack-list">
                            <li>Jeunes diplômés et demandeurs d’emploi</li>
                            <li>Professionnels en reconversion</li>
                        </ul>
                        <!-- Durée not specified -->
                        <h3 class="pack-section-title">📦Services inclus</h3>
                        <ul class="pack-features">
                            <li><span class="check-icon">✓</span> Diagnostic de carrière et définition d’une stratégie de recherche</li>
                            <li><span class="check-icon">✓</span> Rédaction et optimisation du CV et de la lettre de motivation</li>
                            <li><span class="check-icon">✓</span> Coaching intensif pour réussir les entretiens</li>
                            <li><span class="check-icon">✓</span> Mise en relation avec des entreprises ayant des postes ouverts</li>
                            <li><span class="check-icon">✓</span> Optimisation du profil LinkedIn et stratégie de networking</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Entreprises Packs -->
    <div id="entreprisesPacks" class="packs-container active">
        <!-- Pack 1 Row -->
        <div class="content">
            <div class="pack">
                <h1>Pack 1</h1>
                <p class="price"><span class="old-price">30 000F</span> <span>15 000F</span> / ANNÉE</p>
                <ul class="pack-features">
                    <li>✓ La CVthèque</li>
                    <li>✓ Page de services</li>
                    <li>✓ Page d'événements</li>
                    <li>✓ Visibilité dès l'inscription</li>
                    <li>✓ Messagerie instantanée</li>
                </ul>
                <a href="{{ route('register') }}" class="btn-subscribe">Souscrire</a>
            </div>
            <div class="pack">
                <h2>AVANTAGES</h2>
                <ul class="pack-features">
                    <li>✓ Accès aux profils disponibles dans la CV thèque</li>
                    <li>✓ Possibilité de partager son activité, service ou produit</li>
                </ul>
            </div>
            <div class="pack">
                <h2>LIMITES</h2>
                <ul class="pack-features">
                    <li>✓ Recrutement de personnel et stagiaire facturé</li>
                    <li>✓ Page de service limitée Visibilité limitée</li>
                </ul>
            </div>
        </div>

        <!-- Pack 2 Row -->
        <div class="content">
            <div class="pack">
                <h1>Pack 2</h1>
                <p class="price"><span class="old-price">100 000F</span> <span>60 000F</span> / ANNÉE</p>
                <ul class="pack-features">
                    <li>✓ La CVthèque</li>
                    <li>✓ Page de services</li>
                    <li>✓ Page d'événements</li>
                    <li>✓ Visibilité dès l'inscription</li>
                    <li>✓ Messagerie instantanée</li>
                    <li>✓ Campagne SMS</li>
                    <li>✓ Campagne Email</li>
                    <li>✓ Campagne affiche</li>
                    <li>✓ Assistance de 6 mois</li>
                </ul>
                <a href="{{ route('register') }}" class="btn-subscribe">Souscrire</a>
            </div>
            <div class="pack">
                <h2>AVANTAGES</h2>
                <ul class="pack-features">
                    <li>✓ Accès aux profils disponibles dans la CV thèque</li>
                    <li>✓ Possibilité de partager son activité, service ou produit</li>
                    <li>✓ Accès aux campagnes SMS, email et affiche</li>
                </ul>
            </div>
            <div class="pack">
                <h2>LIMITES</h2>
                <ul class="pack-features">
                    <li>✓ Recrutement de personnel et stagiaire facturé</li>
                    <li>✓ Page de service limitée Visibilité limitée</li>
                    <li>✓ Campagnes SMS, Email et affiche limitées</li>
                </ul>
            </div>
        </div>

        <!-- Pack 3 Row -->
        <div class="content">
            <div class="pack">
                 <span class="badge badge-custom bg-info text-white">Populaire</span>
                <h1>Pack 3</h1>
                <p class="price"><span class="old-price">180 000F</span> <span>120 000F</span> / ANNÉE</p>
                <ul class="pack-features">
                    <li>✓ La CVthèque</li>
                    <li>✓ Page de services</li>
                    <li>✓ Page d'événements</li>
                    <li>✓ Visibilité dès l'inscription</li>
                    <li>✓ Messagerie instantanée</li>
                    <li>✓ Campagne SMS</li>
                    <li>✓ Campagne Email</li>
                    <li>✓ Campagne affiche</li>
                    <li>✓ Assistance de 6 mois</li>
                    <li>✓ Page marché public/privé</li>
                </ul>
                <a href="{{ route('register') }}" class="btn-subscribe">Souscrire</a>
            </div>
            <div class="pack">
                <h2>AVANTAGES</h2>
                <ul class="pack-features">
                    <li>✓ Accès aux meilleurs profils de la CV thèque et recrutement non facturé</li>
                    <li>✓ Accès à six pages de service où détailler ces activités et produits</li>
                    <li>✓ Visibilité illimitée</li>
                    <li>✓ Donne l’accès aux appels d’offre</li>
                    <li>✓ Suivi et accompagnement de 6 mois</li>
                    <li>✓ Campagnes SMS, email et affiche illimités</li>
                </ul>
            </div>
            <div class="pack">
                <h2>LIMITES</h2>
                <ul class="pack-features">
                    <li>✓ Pas d’accès à un site personnalisé</li>
                </ul>
            </div>
        </div>

        <!-- Pack 4 Row -->
        <div class="content">
            <div class="pack">
                <span class="badge badge-custom bg-danger text-white">Recommandé</span>
                <h1>Pack 4</h1>
                <p class="price"> <span style="color:red">Prix sur mesure</span> / ANNÉE</p>
                <ul class="pack-features">
                    <li>✓ La CVthèque</li>
                    <li>✓ Page de services</li>
                    <li>✓ Page d'événements</li>
                    <li>✓ Visibilité dès l'inscription</li>
                    <li>✓ Messagerie instantanée</li>
                    <li>✓ Campagne SMS</li>
                    <li>✓ Campagne Email</li>
                    <li>✓ Campagne affiche</li>
                    <li>✓ Assistance de 6 mois</li>
                    <li>✓ Page marché public/privé</li>
                    <li>✓ Conception des sites web</li>
                    <li>✓ Application et Logiciel</li>
                    <li>✓ Gestion des sites</li>
                </ul>
                <a href="{{ route('register') }}" class="btn-subscribe">Souscrire</a>
            </div>
            <div class="pack">
                <h2>AVANTAGES</h2>
                <ul class="pack-features">
                    <li>✓ Accès aux meilleurs profils de la CV thèque et recrutement non facturé</li>
                    <li>✓ Accès à six pages de service où détailler ces activités et produits</li>
                    <li>✓ Visibilité illimitée</li>
                    <li>✓ Donne l’accès aux appels d’offre</li>
                    <li>✓ Suivi et accompagnement de 6 mois</li>
                    <li>✓ Campagnes SMS, email et affiche illimités</li>
                    <li>✓ Conception et gestion de site web</li>
                </ul>
            </div>
            <div class="pack">
                <h2>LIMITES</h2>
                <ul class="pack-features">
                    <li>✓ Néant</li>
                </ul>
            </div>
        </div>
    </div>
</div>


<script>
document.addEventListener('DOMContentLoaded', function() {
    const candidatsBtn = document.getElementById('candidatsBtn');
    const entreprisesBtn = document.getElementById('entreprisesBtn');
    const candidatsPacks = document.getElementById('candidatsPacks');
    const entreprisesPacks = document.getElementById('entreprisesPacks');

    // Fonction pour changer d'onglet
    function switchTab(activeBtn, inactiveBtn, activeContainer, inactiveContainer) {
        activeBtn.classList.add('active');
        inactiveBtn.classList.remove('active');
        activeContainer.classList.add('active');
        inactiveContainer.classList.remove('active');
    }

    // Écouteurs d'événements pour les boutons
    candidatsBtn.addEventListener('click', function() {
        switchTab(candidatsBtn, entreprisesBtn, candidatsPacks, entreprisesPacks);
    });

    entreprisesBtn.addEventListener('click', function() {
        switchTab(entreprisesBtn, candidatsBtn, entreprisesPacks, candidatsPacks);
    });
});


document.addEventListener("DOMContentLoaded", function () {
    // Observer générique pour les animations
    const observerCallback = (entries, observerInstance) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                setTimeout(() => {
                    entry.target.classList.add("show");
                }, 100);
                observerInstance.unobserve(entry.target);
            }
        });
    };

    // Options pour l'IntersectionObserver
    const observerOptions = {
        threshold: 0.1,
        rootMargin: "0px 0px -50px 0px"
    };

    // Créer les observers
    const fadeObserver = new IntersectionObserver(observerCallback, observerOptions);
    const zoomObserver = new IntersectionObserver(observerCallback, observerOptions);

    // Cibler et observer les éléments
    document.querySelectorAll(".fade-in").forEach(element => {
        fadeObserver.observe(element);
    });

    document.querySelectorAll(".zoom-in").forEach(element => {
        zoomObserver.observe(element);
    });
});
</script>


<!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<!-- Scripts (Bootstrap JS - optionnel si non utilisé ailleurs) -->
<!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script> -->
@endsection