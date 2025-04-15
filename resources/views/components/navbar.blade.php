<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StagesBENIN</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <style>
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
            z-index: 1040;
        }
        .banner .info {
            display: flex;
            gap: 25px;
            align-items: center;
        }
        .banner .social-icons a {
            color: white;
            margin: 0 5px;
            font-size: 20px;
        }
        .date-time {
            font-size: 14px;
            font-weight: bold;
            border: 1px solid white;
            padding: 5px 10px;
            border-radius: 5px;
        }

        /* Navbar */
        .navbar {
            background-color: white;
            position: fixed;
            top: 50px; /* Décalage pour ne pas cacher la bannière */
            width: 100%;
            z-index: 1030;
            padding: 10px 15px;
        }
        .navbar-brand img {
            max-width: 200px;
            height: auto;
        }
        .nav-link {
            color: rgb(14, 40, 145) !important;
            font-weight: bold;
            padding: 8px 15px;
            border-radius: 5px;
            transition: all 0.3s ease;
        }
        .nav-link:hover, .nav-link:focus {
            background-color: rgb(14, 40, 145);
            color: white !important;
        }

        /* Ajustement du body pour éviter le chevauchement */
        body {
            padding-top: 140px; /* Ajustement pour ne pas cacher la navbar derrière la bannière */
        }

        /* Masquer la bannière sur les petits écrans */
        @media (max-width: 768px) {
            .banner {
                display: none;
            }
            .navbar {
                top: 0; /* La navbar prend la place de la bannière */
            }
            .navbar-brand img {
                max-width: 150px; /* Réduction de la taille du logo */
            }
            body {
                padding-top: 80px; /* Ajustement pour mobile */
            }
        }
    </style>
    <script>
        function updateDateTime() {
            document.getElementById("date-time").innerHTML = `<i class="bi bi-clock"></i> ${new Date().toLocaleString()}`;
        }
        setInterval(updateDateTime, 1000);
    </script>
    
</head>

<body>
    <!-- Bannière (Visible uniquement sur les grands écrans) -->
    <div class="banner d-none d-md-flex">
        <div class="info">
            <p><i class="bi bi-geo-alt"></i> Kindonou, Cotonou - Bénin</p>
          <p>24h/7j&nbsp;&nbsp;<i class="bi bi-telephone"></i>&nbsp;+229 01 41 73 28 96&nbsp;/+229 01 66 69 39 56</p>

            <span id="date-time" class="date-time"></span>
        </div>
        <div class="social-icons">
           <a href="https://www.facebook.com/stagesbenin" ><i class="bi bi-facebook"></i></a>
                <a href="https://www.linkedin.com/company/stagesbenin/?viewAsMember=true" ><i class="bi bi-linkedin"></i></a>
                <a href="https://www.tiktok.com/@stagesbenin6?_t=8lH68SpT4HG&_r=1" ><i class="fa-brands fa-tiktok"></i></a>
                <a href="https://wa.me/22966693956" ><i class="bi bi-whatsapp"></i></a>
        </div>
        <div>
            <a href="{{ route('login') }}" class="btn btn-light btn-sm text-primary">CONNEXION</a>
            <a href="{{ route('register') }}" class="btn btn-light btn-sm text-primary">INSCRIPTION</a>
        </div>
    </div>

    <!-- Navbar (Toujours visible) -->
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ url('/') }}">
                <img src="{{ asset('assets/images/stagebenin.png') }}" alt="StagesBENIN Logo">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                   
                        <li class="nav-item"><a class="nav-link" href="{{ url('/') }}
">ACCUEIL</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('pages.catalogue') }}
">CATALOGUES DES ENTREPRISES</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('pages.services') }}
">NOS SERVICES</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('pages.programmes') }}
">NOS PROGRAMMES</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('pages.evenements') }}
">ÉVÉNEMENTS</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('pages.apropos') }}
">À PROPOS</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('pages.contact') }}
">CONTACT</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
