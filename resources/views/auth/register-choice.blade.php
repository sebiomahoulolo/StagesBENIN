{{--
    Assuming the following variables are passed to this view from the Controller:
    $ogImageUrl, $logoUrl, $recruteurImgUrl, $candidatImgUrl, $recruteurLink, $candidatLink
--}}
@php
    // Define variables directly in Blade if not passed from controller (less ideal)
    // Example:
    $ogImageUrl = $ogImageUrl ?? "https://stagesbenin.com/wp-content/uploads/2023/07/banniere-stages-Benin-Accueil-compressed.jpg";
    $logoUrl = $logoUrl ?? "https://stagesbenin.com/wp-content/uploads/2023/06/cropped-stagesbenin.png"; // Note: new header uses asset()
    $recruteurImgUrl = $recruteurImgUrl ?? "https://stagesbenin.com/wp-content/uploads/elementor/thumbs/image-1-compressed-2-q7w709jvzt3qak2c9um5v9sdrjrg7hmv8sy9l3hh0c.jpg"; // Example URL, update as needed
    $candidatImgUrl = $candidatImgUrl ?? "https://stagesbenin.com/wp-content/uploads/elementor/thumbs/Fond-candidat-Pt-compressed-q7ycwdmwb3q1oaxm7xza9nw2wqn719rrfvkpttsqqk.jpg"; // Example URL, update as needed
    $recruteurLink = $recruteurLink ?? "https://stagesbenin.com/page-inscription-ets/"; // Example URL, update as needed
    $candidatLink = $candidatLink ?? "https://stagesbenin.com/afjkdskjfnsdkjcsdc-dfds-sdcsdjcsfdfndl-hjdjvkdfvkjdkld5165464fvvfnjnfvdf51fd65v6df6cjhj/"; // Example URL, update as needed
    $pageTitle = "Inscription - StagesBENIN";
    $pageDescription = "Rejoignez notre plateforme StagesBENIN. Recruteurs, trouvez des talents. Candidats, accédez à des opportunités de stages exclusives.";
    $canonicalUrl = ""; // Add canonical URL if available
@endphp

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $pageTitle }}</title>
    <meta name="description" content="{{ $pageDescription }}">
    @if($canonicalUrl)
        <link rel="canonical" href="{{ $canonicalUrl }}" />
    @endif
    <meta name="robots" content="noindex, nofollow"> <!-- Important pour cette page -->

    <!-- OG Meta Tags -->
    <meta property="og:locale" content="fr_FR">
    <meta property="og:type" content="article">
    <meta property="og:title" content="{{ $pageTitle }}">
    <meta property="og:description" content="{{ $pageDescription }}">
    @if($canonicalUrl) {{-- Assuming current URL is canonical if not specified --}}
        <meta property="og:url" content="{{ $canonicalUrl }}">
    @else
         <meta property="og:url" content="{{ url()->current() }}">
    @endif
    <meta property="og:site_name" content="StagesBENIN">
    <meta property="og:image" content="{{ $ogImageUrl }}">
    <meta name="twitter:card" content="summary_large_image">

    <!-- CSRF Token for AJAX requests (like in footer modal) -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <!-- Bootstrap Icons (Used in new header) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <!-- Font Awesome (Used in new footer and potentially main content) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700&family=Roboto:wght@400;700&family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        /* --- CSS Intégré --- */

        /* == Styles from new Header == */
        /* Bannière - cachée sur les petits écrans */
        .banner {
            background-color: #0056b3;
            color: white;
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1040; /* Higher than navbar */
        }
        .banner .info {
            display: flex;
            gap: 25px;
            align-items: center;
            flex-wrap: wrap; /* Allow wrapping on smaller banner widths */
        }
        .banner .info p {
            margin-bottom: 0; /* Remove default paragraph margin */
            font-size: 0.9rem;
        }
        .banner .social-icons a {
            color: white;
            margin: 0 5px;
            font-size: 20px;
            transition: color 0.3s ease;
        }
         .banner .social-icons a:hover {
             color: #adb5bd; /* Lighter color on hover */
         }
        .banner .date-time {
            font-size: 14px;
            font-weight: bold;
            border: 1px solid white;
            padding: 5px 10px;
            border-radius: 5px;
        }
        .banner .auth-buttons a {
            margin-left: 10px;
        }

        /* Navbar */
        .navbar {
            background-color: white;
            position: fixed;
            top: 60px; /* Default assuming banner height, adjusted by media query */
            width: 100%;
            z-index: 1030; /* Lower than banner */
            padding: 10px 15px;
            box-shadow: 0 2px 4px rgba(0,0,0,.1); /* Subtle shadow */
        }
        .navbar-brand img {
            max-width: 200px;
            height: auto;
        }
        .navbar .nav-link {
            color: rgb(14, 40, 145) !important;
            font-weight: bold;
            padding: 8px 15px !important; /* Ensure padding overrides Bootstrap */
            border-radius: 5px;
            transition: all 0.3s ease;
            font-size: 0.9rem; /* Slightly smaller font */
            margin: 0 5px; /* Spacing between nav items */
        }
        .navbar .nav-link:hover,
        .navbar .nav-link:focus,
        .navbar .nav-link.active { /* Style for active link */
            background-color: rgb(14, 40, 145);
            color: white !important;
        }
        .navbar-toggler {
            border: none; /* Remove border from toggler */
        }
        .navbar-toggler:focus {
            box-shadow: none; /* Remove focus ring */
        }


        /* Ajustement du body pour éviter le chevauchement */
        body {
            padding-top: 130px; /* Initial padding: Approx banner height + navbar height + spacing */
            font-family: 'Poppins', sans-serif; /* Apply Poppins globally */
            color: #333;
            background-color: #f8f9fa; /* Light background for the page */
        }

        /* Masquer la bannière sur les petits écrans et ajuster navbar/body padding */
        @media (max-width: 991.98px) { /* Use lg breakpoint */
            .banner {
                display: none !important; /* Ensure it's hidden */
            }
            .navbar {
                top: 0; /* Navbar moves to the top */
            }
            body {
                padding-top: 80px; /* Adjust padding for navbar height only */
            }
             .navbar-brand img {
                max-width: 150px; /* Réduction de la taille du logo */
            }
            .navbar .nav-link {
                margin: 5px 0; /* Stack links vertically in collapsed menu */
                text-align: center;
            }
        }
        /* Further adjustments for smaller screens if needed */
         @media (max-width: 767.98px) {
             .banner .info {
                 justify-content: center; /* Center info items */
                 gap: 15px; /* Reduce gap */
             }
             .banner .social-icons, .banner .auth-buttons {
                 display: none; /* Hide social/auth buttons on very small screens if needed */
             }
             .navbar-collapse {
                 background-color: white; /* Background for collapsed menu */
                 margin-top: 10px;
                 padding: 10px;
                 border-radius: 5px;
                 box-shadow: 0 4px 8px rgba(0,0,0,.1);
             }
         }


        /* == Styles inferred from original CSS/HTML (for main content) == */
        .site-main {
            padding-bottom: 4rem; /* Add some space before footer */
        }

        .page-subtitle {
            font-size: 1.1rem;
            color: #6c757d; /* Bootstrap secondary color */
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 0.5rem;
            font-weight: 500;
        }

        .page-main-title {
            font-size: 2.8rem;
            color: #0056b3; /* Primary blue */
            font-weight: 700;
            margin-bottom: 1rem;
            font-family: 'Montserrat', sans-serif;
        }

        .title-divider {
            width: 80px;
            height: 4px;
            background-color: #0056b3;
            margin: 0 auto 2rem auto; /* Center the divider */
            border: none;
            opacity: 1;
        }

        .intro-text {
            max-width: 700px;
            margin: 0 auto 3rem auto;
            font-size: 1.1rem;
            line-height: 1.7;
            color: #555;
            text-align: center;
        }

        .signup-card {
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            padding: 2rem;
            margin-bottom: 2rem; /* Space between cards on smaller screens */
            text-align: center;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            display: flex;
            flex-direction: column;
            height: 100%; /* Make cards in a row equal height */
        }

        .signup-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        }

        .signup-card-img {
            width: 100%;
            max-width: 250px; /* Control image size */
            height: 180px; /* Fixed height */
            object-fit: cover; /* Ensure image covers the area */
            border-radius: 8px;
            margin: 0 auto 1.5rem auto; /* Center image */
            display: block;
        }

        .signup-card-title {
            font-size: 1.8rem;
            font-weight: 700;
            color: #343a40; /* Darker color */
            margin-bottom: 0.25rem;
            font-family: 'Montserrat', sans-serif;
        }

        .signup-card-subtitle {
            font-size: 1rem;
            color: #6c757d;
            margin-bottom: 1rem;
            font-weight: 500;
        }

        .signup-card hr {
            width: 50px;
            height: 3px;
            background-color: #0056b3;
            margin: 0 auto 1rem auto;
            border: none;
            opacity: 1;
        }

        .signup-card-text {
            font-size: 0.95rem;
            line-height: 1.6;
            color: #555;
            margin-bottom: 1.5rem;
            flex-grow: 1; /* Allow text to push button down */
        }

        .signup-card .btn {
            background-color: #0056b3;
            color: #ffffff;
            padding: 10px 30px;
            border-radius: 5px;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            transition: background-color 0.3s ease, transform 0.2s ease;
            border: none;
            align-self: center; /* Center button */
        }

        .signup-card .btn:hover {
            background-color: #004494; /* Darker blue on hover */
            transform: scale(1.03);
        }

        /* == Styles from new Footer == */
        #subscribeModal {
            /* Style defined inline in the footer HTML, but can be moved here */
            /* Example adjustments */
             z-index: 1050; /* Ensure it's above other elements */
        }

        #scrollToTopBtn {
            /* Style defined inline in the footer HTML, but can be moved here */
            z-index: 1000; /* Ensure visibility */
            transition: background-color 0.3s ease;
        }

        #scrollToTopBtn:hover {
          background-color: #0056b3; /* Ensure hover state works */
        }

         /* Footer specific styles */
        .bg-dark {
            background-color: #212529 !important; /* Ensure dark background */
        }
        footer h5 {
            color: #00aaff; /* A lighter blue for headings */
            margin-bottom: 1rem;
            font-weight: 600;
        }
        footer p, footer ul li {
            font-size: 0.9rem;
            color: #ced4da; /* Lighter text color */
        }
        footer a.text-light {
            color: #ced4da !important; /* Lighter link color */
            text-decoration: none; /* Supprime le soulignement */
            transition: color 0.3s ease;
        }
        footer a.text-light:hover {
            color: #ffffff !important; /* White on hover */
            text-decoration: underline; /* Facultatif : ajoute un soulignement au survol */
        }
        footer .social-icons a, footer .text-md-end a { /* Target social icons in footer */
            color: #ced4da !important;
             font-size: 1.5rem; /* Increase icon size */
             margin: 0 8px; /* Adjust spacing */
             transition: color 0.3s ease;
        }
         footer .social-icons a:hover, footer .text-md-end a:hover {
             color: #ffffff !important;
         }
        footer hr.bg-light {
             border-top: 1px solid rgba(255, 255, 255, 0.15); /* Subtler horizontal rule */
        }
         footer .img-fluid {
             border: 2px solid #444; /* Add border to gallery images */
         }
          footer .service-btn.btn-primary {
              background-color: #007bff;
              border-color: #007bff;
              font-size: 0.8rem;
              padding: 5px 10px;
              margin-top: 5px;
          }
          footer .service-btn.btn-primary:hover {
              background-color: #0056b3;
              border-color: #0056b3;
          }

    </style>

    <script>
        // Script from new Header
        function updateDateTime() {
            const dateTimeElement = document.getElementById("date-time");
            if (dateTimeElement) {
                 // Formatage plus agréable
                 const now = new Date();
                 const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute: '2-digit', second: '2-digit' };
                 dateTimeElement.innerHTML = `<i class="bi bi-clock"></i> ${now.toLocaleDateString('fr-FR', options)}`;
            }
        }
        // Initial call and interval
        document.addEventListener('DOMContentLoaded', () => {
            updateDateTime(); // Initial call
            setInterval(updateDateTime, 1000); // Update every second
        });
    </script>

</head>

<body>
    <!-- Bannière (Visible uniquement sur les grands écrans) -->
    <div class="banner d-none d-lg-flex"> {{-- Use d-lg-flex for Bootstrap 5 --}}
        <div class="info">
            <p><i class="bi bi-geo-alt"></i> Kindonou, Cotonou - Bénin</p>
            <p>24h/7j  <i class="bi bi-telephone"></i> +229 41 73 28 96 /+229 66 69 39 56</p> {{-- Updated phone numbers --}}
            <span id="date-time" class="date-time"></span>
        </div>
        <div class="social-icons">
           <a href="https://www.facebook.com/stagesbenin" target="_blank" rel="noopener noreferrer" aria-label="Facebook"><i class="bi bi-facebook"></i></a>
           <a href="https://www.linkedin.com/company/stagesbenin/?viewAsMember=true" target="_blank" rel="noopener noreferrer" aria-label="LinkedIn"><i class="bi bi-linkedin"></i></a>
           {{-- Note: New header uses bi-tiktok, but new footer uses fab fa-tiktok. Using Font Awesome here for consistency with footer. --}}
           <a href="https://www.tiktok.com/@stagesbenin6?_t=8lH68SpT4HG&_r=1" target="_blank" rel="noopener noreferrer" aria-label="TikTok"><i class="fab fa-tiktok"></i></a>
           <a href="https://wa.me/22966693956" target="_blank" rel="noopener noreferrer" aria-label="WhatsApp"><i class="bi bi-whatsapp"></i></a>
        </div>
        <div class="auth-buttons"> {{-- Added a container div for buttons --}}
            {{-- Assuming 'login' and 'register' are named routes in Laravel --}}
            <a href="{{ route('login') }}" class="btn btn-light btn-sm text-primary fw-bold">CONNEXION</a>
            <a href="{{ route('register') }}" class="btn btn-light btn-sm text-primary fw-bold">INSCRIPTION</a>
        </div>
    </div>

    <!-- Navbar (Toujours visible) -->
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ url('/') }}">
                {{-- Assuming logo is in public/assets/images/ --}}
                <img src="{{ asset('assets/images/stagebenin.png') }}" alt="StagesBENIN Logo">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                {{-- Use url() or route() as appropriate for your Laravel setup --}}
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('pages.accueil') ? 'active' : '' }}" href="{{ url('/') }}">ACCUEIL</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('pages.catalogue') ? 'active' : '' }}" href="{{ route('pages.catalogue') }}">CATALOGUES DES ENTREPRISES</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('pages.services') ? 'active' : '' }}" href="{{ route('pages.services') }}">NOS SERVICES</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('pages.programmes') ? 'active' : '' }}" href="{{ route('pages.programmes') }}">NOS PROGRAMMES</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('pages.evenements') ? 'active' : '' }}" href="{{ route('pages.evenements') }}">ÉVÉNEMENTS</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('pages.apropos') ? 'active' : '' }}" href="{{ route('pages.apropos') }}">À PROPOS</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('pages.contact') ? 'active' : '' }}" href="{{ route('pages.contact') }}">CONTACT</a></li>
                    {{-- Removed Blog, Inscription, Connexion links as they are handled differently or not in the new nav --}}
                </ul>
            </div>
        </div>
    </nav>

    <main id="content" class="site-main">
        <div class="container mt-5">

            <section class="text-center py-5">
                <div class="container">
                    {{-- <i class="fas fa-user-plus page-title-icon"></i> --}} {{-- Icon removed as per original comment --}}
                    <h3 class="page-subtitle">Type d'inscription</h3>
                    <h1 class="page-main-title">Inscription</h1>
                    <hr class="title-divider">
                </div>
            </section>

            <p class="intro-text">
                Rejoignez notre plateforme dès maintenant et donnez un coup de pouce à votre carrière ! Recruteurs, trouvez les meilleurs talents pour vos offres de stage.
            </p>

            <div class="row justify-content-center g-4"> {{-- Added g-4 for gap between columns --}}
                 <!-- Carte Recruteur -->
                 <div class="col-lg-5 col-md-6 d-flex"> {{-- Added d-flex for equal height cards --}}
                     <div class="signup-card">
                         {{-- Using the Blade variable passed from controller or defined above --}}
                         <img src="{{ $recruteurImgUrl }}" alt="Recruteur" class="signup-card-img">
                         <h3 class="signup-card-title">Recruteur</h3>
                         <h4 class="signup-card-subtitle">Employeur</h4>
                         <hr>
                         <p class="signup-card-text">
                             Chers Recruteurs, en vous inscrivant sur cette plateforme, vous bénéficierez d’un tableau de bord simple à utiliser et à partir duquel vous pouvez facilement faire vos publications d’annonces en moins d’une minute.
                         </p>
                         {{-- Using the Blade variable for the link --}}
                         <a href="{{ $recruteurLink }}" class="btn">Cliquez ici</a>
                         {{-- Example using named route (if defined): --}}
                         {{-- <a href="{{ route('register.recruiter') }}" class="btn">Cliquez ici</a> --}}
                     </div>
                 </div>

                 <!-- Carte Candidat -->
                 <div class="col-lg-5 col-md-6 d-flex"> {{-- Added d-flex for equal height cards --}}
                     <div class="signup-card">
                          {{-- Using the Blade variable passed from controller or defined above --}}
                          <img src="{{ $candidatImgUrl }}" alt="Candidat" class="signup-card-img">
                          <h3 class="signup-card-title">Candidat</h3>
                          <h4 class="signup-card-subtitle">Postulant</h4>
                          <hr>
                          <p class="signup-card-text">
                              Accédez à des opportunités de stages professionnels exclusives en vous inscrivant.
                          </p>
                           {{-- Using the Blade variable for the link --}}
                          <a href="{{ $candidatLink }}" class="btn">S'inscrire</a>
                          {{-- Example using named route (if defined): --}}
                          {{-- <a href="{{ route('register.candidate') }}" class="btn">S'inscrire</a> --}}
                     </div>
                 </div>
            </div>
        </div>
    </main>

    <!-- New Footer -->
    <footer class="bg-dark text-light py-5 mt-5">
        {{-- Modal HTML (moved inside footer tag for structure) --}}
        <div id="subscribeModal" style="display: none; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%) scale(0.95); width: 90%; max-width: 380px; background: #f0f8ff; padding: 25px; border-radius: 10px; box-shadow: 0 6px 20px rgba(0, 0, 0, 0.25); text-align: center; z-index: 1050; transition: transform 0.3s ease-out, opacity 0.3s ease-out; opacity: 0;">
            <h5 style="color: #0056b3; margin-bottom: 15px;">Restez Connecté !</h5>
            <p style="font-size: 15px; color: #333; margin-bottom: 20px;">Inscrivez-vous pour recevoir nos dernières offres de stage et actualités directement dans votre boîte mail.</p>

            <input type="email" id="emailInput" placeholder="Votre adresse email" style="width: 100%; padding: 12px; margin-bottom: 15px; border: 1px solid #ccc; border-radius: 5px; font-size: 14px;">
            <p id="responseMessage" style="font-size: 14px; font-weight: bold; display: none; margin-top: -10px; margin-bottom: 15px;"></p>

            <div style="display: flex; justify-content: space-between; align-items: center; gap: 10px;">
                <button id="subscribeBtn" style="flex: 1; padding: 12px; background-color: #007bff; color: white; border: none; border-radius: 5px; cursor: pointer; font-size: 14px; font-weight: bold; transition: background-color 0.3s ease;">S'abonner</button>
                <button id="closeModalBtn" style="flex: 1; padding: 12px; background: none; border: 1px solid #dc3545; color: #dc3545; border-radius: 5px; cursor: pointer; font-size: 14px; font-weight: bold; transition: background-color 0.3s ease, color 0.3s ease;">Fermer</button>
            </div>
        </div>

        {{-- Scroll-to-Top Button --}}
        <button id="scrollToTopBtn" title="Retour en haut" style="display: none; position: fixed; bottom: 30px; right: 30px; background-color: #007bff; color: white; width: 45px; height: 45px; border: none; border-radius: 50%; cursor: pointer; font-size: 18px; text-align: center; line-height: 45px; box-shadow: 0 2px 5px rgba(0,0,0,0.2);">
          <i class="fas fa-arrow-up"></i>
        </button>

        {{-- Footer Content --}}
        <div class="container">
            <div class="row" >
                <div class="col-md-3 mb-4">
                    <a class="navbar-brand" href="{{ url('/') }}">
                        {{-- Ensure this path is correct for your setup --}}
                        <img src="{{ asset('assets/images/stagebenin_white.png') }}" alt="StagesBENIN Logo White" style="max-width: 200px; height: auto;">
                         {{-- Assuming you have a white version of the logo for dark backgrounds --}}
                         {{-- If not, use the original: <img src="{{ asset('assets/images/stagebenin.png') }}" alt="StagesBENIN Logo"> --}}
                    </a>
                    <p class="mt-3" style="font-size: 0.85rem;">Votre plateforme N°1 pour les offres de stage et d'emploi au Bénin.</p>
                </div>

                <div class="col-md-3 mb-4">
                    <h5>Liens utiles</h5>
                    <ul class="list-unstyled">
                        <li><a href="{{ url('/') }}" class="text-light d-block mb-2">Accueil</a></li>
                        <li><a href="{{ route('pages.services') }}" class="text-light d-block mb-2">Nos services</a></li>
                        <li><a href="#" class="text-light d-block mb-2">Offres disponibles</a></li> {{-- Add correct route --}}
                        <li><a href="#" class="text-light d-block mb-2">Espace recruteurs</a></li> {{-- Add correct route --}}
                        <li><a href="#" class="text-light d-block mb-2">Espace candidats</a></li> {{-- Add correct route --}}
                        <li><a href="{{ route('pages.programmes') }}" class="text-light d-block mb-2">Nos programmes</a></li>
                        <li><a href="{{ route('pages.evenements') }}" class="text-light d-block mb-2">Événements</a></li>
                        <li><a href="{{ route('pages.contact') }}" class="text-light d-block mb-2">Contact</a></li>
                    </ul>
                </div>

                <!-- Galerie -->
                <div class="col-md-3 mb-4">
                    <h5>Galerie</h5>
                    <div class="row g-2"> {{-- Use g-2 for gap --}}
                        <div class="col-4">
                            <img src="{{ asset('assets/images/IMG-20240904-WA0025.jpg') }}" class="img-fluid rounded" alt="Galerie 1">
                        </div>
                        <div class="col-4">
                            <img src="{{ asset('assets/images/IMG_4438-scaled.jpg') }}" class="img-fluid rounded" alt="Galerie 2">
                        </div>
                        <div class="col-4">
                            <img src="{{ asset('assets/images/IMG_4567-scaled.jpg') }}" class="img-fluid rounded" alt="Galerie 3">
                        </div>
                         <div class="col-4">
                            <img src="{{ asset('assets/images/placeholder_gallery4.jpg') }}" class="img-fluid rounded" alt="Galerie 4"> {{-- Add more images --}}
                        </div>
                         <div class="col-4">
                            <img src="{{ asset('assets/images/placeholder_gallery5.jpg') }}" class="img-fluid rounded" alt="Galerie 5">
                        </div>
                         <div class="col-4">
                            <img src="{{ asset('assets/images/placeholder_gallery6.jpg') }}" class="img-fluid rounded" alt="Galerie 6">
                        </div>
                    </div>
                     <a href="#" class="service-btn btn btn-primary mt-3">Voir plus</a> {{-- Add correct route --}}
                </div>

                <!-- Autres sites -->
                <div class="col-md-3 mb-4">
                    <h5>Autres sites</h5>
                    <ul class="list-unstyled">
                        <li><a href="#" class="text-light d-block mb-2">FHC group</a></li> {{-- Add correct link --}}
                        <li><a href="https://africa-location.com/" target="_blank" rel="noopener noreferrer" class="text-light d-block mb-2">AfricaLOCATION</a></li>
                        <li><a href="https://fhcschoolbenin.com/" target="_blank" rel="noopener noreferrer" class="text-light d-block mb-2">Hosanna school</a></li>
                    </ul>
                </div>
            </div>

            <hr class="bg-light my-4"> {{-- Use my-4 for margin --}}

            <div class="row align-items-center">
                <!-- Contact -->
                <div class="col-md-6 mb-3 mb-md-0">
                    <h5>Contact</h5>
                    <p class="mb-1"><i class="bi bi-geo-alt me-2"></i> Kindonou, Cotonou - Bénin</p>
                    <p class="mb-1"><i class="bi bi-telephone me-2"></i> +229 41 73 28 96 / +229 66 69 39 56</p>
                    <p class="mb-0"><i class="bi bi-envelope me-2"></i> contact@stagesbenin.com</p>
                </div>

                <!-- Réseaux sociaux -->
                <div class="col-md-6 text-md-end">
                    <h5>Suivez-nous</h5>
                    <a href="https://www.facebook.com/stagesbenin" target="_blank" rel="noopener noreferrer" class="text-light me-3" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                    <a href="https://www.linkedin.com/company/stagesbenin/?viewAsMember=true" target="_blank" rel="noopener noreferrer" class="text-light me-3" aria-label="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                    <a href="https://www.tiktok.com/@stagesbenin6?_t=8lH68SpT4HG&_r=1" target="_blank" rel="noopener noreferrer" class="text-light me-3" aria-label="TikTok"><i class="fab fa-tiktok"></i></a>
                    <a href="https://wa.me/22966693956" target="_blank" rel="noopener noreferrer" class="text-light" aria-label="WhatsApp"><i class="fab fa-whatsapp"></i></a>
                </div>
            </div>

            <hr class="bg-light my-4">

             <div class="row">
                 <div class="col-md-6 text-center text-md-start">
                    <p class="mb-0">© StagesBENIN {{ date('Y') }}, Développé par <a href="#" class="text-light fw-bold">FHC Groupe Sarl</a>.</p> {{-- Add link to FHC --}}
                 </div>
                 <div class="col-md-6 text-center text-md-end">
                    <a href="#" class="text-light me-3">Politique de Confidentialité</a> | {{-- Add route --}}
                    <a href="#" class="text-light">Termes & Conditions</a> {{-- Add route --}}
                 </div>
             </div>
        </div>
    </footer>

    <!-- Script Bootstrap JS Bundle (placé à la fin) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Script for Footer Modal and Scroll-to-Top -->
    <script>
    document.addEventListener("DOMContentLoaded", function () {
        const subscribeModal = document.getElementById("subscribeModal");
        const closeModalBtn = document.getElementById("closeModalBtn");
        const subscribeBtn = document.getElementById("subscribeBtn");
        const responseMessage = document.getElementById("responseMessage");
        const emailInput = document.getElementById("emailInput"); // Get input element
        const scrollToTopBtn = document.getElementById("scrollToTopBtn"); // Get scroll button

        // Check if elements exist before adding listeners
        if (subscribeModal && closeModalBtn && subscribeBtn && responseMessage && emailInput) {
            // Afficher le modal après 30s
            const modalTimeout = setTimeout(function () {
                subscribeModal.style.display = "block";
                setTimeout(() => {
                    subscribeModal.style.opacity = "1";
                    subscribeModal.style.transform = "translate(-50%, -50%) scale(1)";
                }, 10); // Short delay for transition
            }, 30000); // 30 seconds

            function closeModal() {
                subscribeModal.style.opacity = "0";
                subscribeModal.style.transform = "translate(-50%, -50%) scale(0.95)";
                setTimeout(() => {
                    subscribeModal.style.display = "none";
                }, 300); // Match transition duration
                clearTimeout(modalTimeout); // Prevent modal from reappearing if closed manually
            }

            closeModalBtn.addEventListener("click", closeModal);

            subscribeBtn.addEventListener("click", function () {
                const emailValue = emailInput.value.trim(); // Trim whitespace
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                // Basic email validation
                if (!emailValue || !/^\S+@\S+\.\S+$/.test(emailValue)) {
                    responseMessage.style.display = "block";
                    responseMessage.style.color = "red";
                    responseMessage.textContent = "Veuillez entrer une adresse email valide.";
                    return;
                }

                // Disable button during request
                subscribeBtn.disabled = true;
                subscribeBtn.textContent = 'Envoi...';

                // Use the correct URL for your subscribe endpoint
                // fetch('/subscribe', { // Example relative URL
                fetch('{{ route("subscribe") }}', { // Example using a named route 'subscribe'
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken, // Correct header name for Laravel
                        'Accept': 'application/json' // Expect JSON response
                    },
                    body: JSON.stringify({ email: emailValue }),
                })
                .then(response => {
                    if (!response.ok) {
                        // Handle HTTP errors (e.g., 4xx, 5xx)
                         return response.json().then(errorData => {
                            throw new Error(errorData.message || `Erreur HTTP ${response.status}`);
                        });
                    }
                    return response.json(); // Parse JSON body
                })
                .then(data => {
                    responseMessage.style.display = "block";
                    // Use success/error status from response for styling
                    responseMessage.style.color = data.success ? "green" : "red";
                    responseMessage.textContent = data.message;

                    // Optionally clear input on success
                    if (data.success) {
                        emailInput.value = '';
                    }

                    // Close modal after a delay if subscription is successful or already exists
                    if (data.message === "Merci pour votre abonnement !" || data.message === "Vous êtes déjà abonné(e). Merci pour votre fidélité.") {
                         setTimeout(closeModal, 4000); // Keep message visible for 4 seconds
                    }
                })
                .catch(error => {
                    console.error('Subscription Error:', error);
                    responseMessage.style.display = "block";
                    responseMessage.style.color = "red";
                    responseMessage.textContent = "Une erreur est survenue : " + error.message;
                })
                .finally(() => {
                     // Re-enable button
                     subscribeBtn.disabled = false;
                     subscribeBtn.textContent = "S'abonner";
                });
            });
        } else {
            console.warn("Subscription modal elements not found.");
        }

        // Scroll-to-Top functionality
        if (scrollToTopBtn) {
             window.addEventListener("scroll", function () {
                if (window.scrollY > 300) { // Show button after scrolling down 300px
                    scrollToTopBtn.style.display = "block";
                    scrollToTopBtn.style.opacity = "1"; // Fade in effect (optional with CSS transition)

                } else {
                    scrollToTopBtn.style.opacity = "0"; // Fade out effect (optional with CSS transition)
                    // Hide after fade out transition (if using CSS transition)
                     setTimeout(() => {
                        if (window.scrollY <= 300) { // Double check scroll position
                           scrollToTopBtn.style.display = "none";
                        }
                     }, 300); // Match CSS transition duration if any
                }
            });

            scrollToTopBtn.addEventListener("click", function () {
                window.scrollTo({
                    top: 0,
                    behavior: "smooth" // Smooth scrolling effect
                });
            });
        } else {
             console.warn("Scroll-to-top button not found.");
        }

    });
    </script>

</body>
</html>