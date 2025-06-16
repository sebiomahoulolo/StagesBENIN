@extends('layouts.layout')

@section('title', 'StagesBENIN')


@section('content')
    {{-- <div
        style=" background-image: url('{{ asset('assets/images/Outils-de-recrutements.png') }}'); background-size: cover; background-attachment: fixed;">
        <div style="text-align: center; padding: 20px;">
            <p style="font-size: 17px; font-weight: bold; color: rgb(14, 40, 145); display: inline;">
                Le moyen le plus simple d'obtenir
            </p>
            <p id="animatedText" style="font-size: 17px; font-weight: bold; color:rgb(14, 40, 145); display: inline;"></p>
        </div>
        <div style="display: flex; justify-content: center; align-items: center; text-align: center;">
            <p style="font-size: 16px; color:rgb(14, 40, 145); line-height: 1.5;">
                Trouvez votre chemin vers une carrière épanouissante grâce à notre plateforme de recrutement et d’insertion
                professionnelle,
                où les opportunités s’ouvrent à vous et les talents sont valorisés.
            </p>
        </div>
        <div class="container mt-4">
            <!-- Barre de recherche -->
            <div class="row mb-4">
                <div class="col-md-8 mx-auto">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Rechercher un stage, une entreprise...">
                        <button class="btn btn-primary">Rechercher</button>
                    </div>
                </div>
            </div>
            <div class="text-center my-4 md-d-flex md-justify-content-center gap-4">
                <a href="{{ route('login') }}" class="btn btn-primary px-4 py-2 fw-bold rounded">RECRUTER EMPLOYE /
                    STAGIAIRE</a>
                <a href="{{ route('login') }}" class="btn btn-primary px-4 py-2 fw-bold rounded m-2">CONNEXION</a>
                <a href="{{ route('register') }}" class="btn btn-primary px-4 py-2 fw-bold rounded">INSCRIPTION</a>
            </div>
        </div>
    </div> --}}

    <!-- Header/Navbar Transparent -->
    {{-- <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
        <div class="container">
            <a class="navbar-brand animate__animated animate__fadeInLeft" href="#">
                Stages<span>BENIN</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item animate__animated animate__fadeInDown" style="animation-delay: 0.1s;">
                        <a class="nav-link active" href="#">Accueil</a>
                    </li>
                    <li class="nav-item animate__animated animate__fadeInDown" style="animation-delay: 0.2s;">
                        <a class="nav-link" href="#">Stages</a>
                    </li>
                    <li class="nav-item animate__animated animate__fadeInDown" style="animation-delay: 0.3s;">
                        <a class="nav-link" href="#">Entreprises</a>
                    </li>
                    <li class="nav-item animate__animated animate__fadeInDown" style="animation-delay: 0.4s;">
                        <a class="nav-link" href="#">Coaching</a>
                    </li>
                    <li class="nav-item animate__animated animate__fadeInDown" style="animation-delay: 0.5s;">
                        <a class="nav-link" href="#">Contact</a>
                    </li>
                </ul>
                <div class="ms-lg-3 mt-3 mt-lg-0">
                    <a href="#" class="btn btn-outline-light animate__animated animate__fadeInRight" style="animation-delay: 0.4s;">Connexion</a>
                    <a href="#" class="btn btn-primary animate__animated animate__fadeInRight" style="animation-delay: 0.5s;">Inscription</a>
                </div>
            </div>
        </div>
    </nav> --}}

    <!-- Hero Section -->


    <div class="container my-4">
        <div class="row justify-content-center">
            <!-- Dernières Publications -->
            <div class="row justify-content-center">
                <!-- Dernières Publications -->
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="category-card card h-100 border-0 text-center p-4" data-aos="fade-up" data-aos-delay="100">
                        <div class="card-body">
                            <div class="category-icon mb-3">
                                <i class="fas fa-briefcase"></i>
                            </div>
                            <h5 class="category-title">Offres d'emploi</h5>
                            <div class="mb-3">
                                <span class="badge bg-primary fs-6">{{ $nombre_offres ?? 0 }} offres</span>
                            </div>
                            <div class="category-content mb-3">
                                @if (isset($annonces) && $annonces->count() > 0)
                                    <div class="text-start">
                                        @foreach ($annonces->take(2) as $annonce)
                                            <div class="mb-2 p-2 bg-light rounded">
                                                <small
                                                    class="text-primary fw-bold d-block">{{ Str::limit($annonce->nom_du_poste, 30) }}</small>
                                                <small class="text-muted">{{ $annonce->type_de_poste }}</small>
                                            </div>
                                        @endforeach
                                        @if ($annonces->count() > 2)
                                            <small class="text-muted">{{ $annonces->count() - 2 }} autres offres
                                                disponibles</small>
                                        @endif
                                    </div>
                                @else
                                    <p class="category-text text-muted">
                                        Aucune offre disponible pour le moment
                                    </p>
                                @endif
                            </div>
                            <a href="{{ route('pages.offres') }}" class="category-link">
                                Consulter <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Événements -->
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="category-card card h-100 border-0 text-center p-4" data-aos="fade-up" data-aos-delay="200">
                        <div class="card-body">
                            <div class="category-icon mb-3">
                                <i class="fas fa-calendar-alt"></i>
                            </div>
                            <h5 class="category-title">Événements</h5>
                            <div class="mb-3">
                                <span class="badge bg-success fs-6">{{ $nombre_events ?? 0 }} événements</span>
                            </div>
                            <div class="category-content mb-3">
                                @if (isset($evenements) && $evenements->count() > 0)
                                    <div class="text-start">
                                        @foreach ($evenements->take(2) as $evenement)
                                            <div class="mb-2 p-2 bg-light rounded">
                                                <small
                                                    class="text-primary fw-bold d-block">{{ Str::limit($evenement->title, 35) }}</small>
                                                @if (isset($evenement->date))
                                                    <small
                                                        class="text-muted">{{ \Carbon\Carbon::parse($evenement->date)->format('d/m/Y') }}</small>
                                                @endif
                                            </div>
                                        @endforeach
                                        @if ($evenements->count() > 2)
                                            <small class="text-muted">{{ $evenements->count() - 2 }} autres
                                                événements</small>
                                        @endif
                                    </div>
                                @else
                                    <p class="category-text text-muted">
                                        Aucun événement programmé actuellement
                                    </p>
                                @endif
                            </div>
                            <a href="{{ route('pages.evenements') }}" class="category-link">
                                Voir plus <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Marchés publics/privés -->
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="category-card card h-100 border-0 text-center p-4" data-aos="fade-up" data-aos-delay="300">
                        <div class="card-body">
                            <div class="category-icon mb-3">
                                <i class="fas fa-handshake"></i>
                            </div>
                            <h5 class="category-title">Marchés publics</h5>
                            <div class="mb-3">
                                <span class="badge bg-info fs-6">{{ $nombre_actualites ?? 0 }} marchés</span>
                            </div>
                            <div class="category-content mb-3">
                                @if (isset($actualites) && $actualites->count() > 0)
                                    <div class="text-start">
                                        @foreach ($actualites->take(2) as $actualite)
                                            <div class="mb-2 p-2 bg-light rounded">
                                                <small
                                                    class="text-primary fw-bold d-block">{{ Str::limit($actualite->titre, 35) }}</small>
                                                @if (isset($actualite->date_publication))
                                                    <small
                                                        class="text-muted">{{ \Carbon\Carbon::parse($actualite->date_publication)->format('d/m/Y') }}</small>
                                                @endif
                                            </div>
                                        @endforeach
                                        @if ($actualites->count() > 2)
                                            <small class="text-muted">{{ $actualites->count() - 2 }} autres marchés</small>
                                        @endif
                                    </div>
                                @else
                                    <p class="category-text text-muted">
                                        Aucun marché disponible pour le moment
                                    </p>
                                @endif
                            </div>
                            <a href="{{ route('pages.actualites') }}" class="category-link">
                                Consulter <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- CSS pour les category-cards (à ajouter si pas déjà présent) -->
            <style>
                .category-card {
                    background: #fff;
                    border-radius: 15px;
                    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
                    transition: all 0.3s ease;
                    overflow: hidden;
                }

                .category-card:hover {
                    transform: translateY(-10px);
                    box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
                }

                .category-icon {
                    width: 80px;
                    height: 80px;
                    margin: 0 auto;
                    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                    border-radius: 50%;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    color: white;
                    font-size: 2rem;
                    transition: all 0.3s ease;
                }

                .category-card:hover .category-icon {
                    transform: scale(1.1);
                    background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
                }

                .category-title {
                    color: #2c3e50;
                    font-weight: 600;
                    margin-bottom: 1rem;
                }

                .category-text {
                    color: #7f8c8d;
                    font-size: 0.95rem;
                    line-height: 1.6;
                    margin-bottom: 1.5rem;
                }

                .category-content {
                    min-height: 100px;
                    display: flex;
                    flex-direction: column;
                    justify-content: flex-start;
                }

                .category-link {
                    color: #667eea;
                    text-decoration: none;
                    font-weight: 600;
                    transition: all 0.3s ease;
                    display: inline-flex;
                    align-items: center;
                    gap: 8px;
                }

                .category-link:hover {
                    color: #764ba2;
                    text-decoration: none;
                    transform: translateX(5px);
                }

                .category-link i {
                    transition: transform 0.3s ease;
                }

                .category-link:hover i {
                    transform: translateX(3px);
                }

                .badge {
                    padding: 8px 16px;
                    border-radius: 20px;
                    font-weight: 500;
                }

                .category-content .bg-light {
                    border-left: 3px solid #667eea;
                    transition: all 0.3s ease;
                }

                .category-content .bg-light:hover {
                    border-left-color: #764ba2;
                    background: #f8f9fa !important;
                }

                @media (max-width: 768px) {
                    .category-icon {
                        width: 60px;
                        height: 60px;
                        font-size: 1.5rem;
                    }

                    .category-title {
                        font-size: 1.1rem;
                    }

                    .category-text {
                        font-size: 0.9rem;
                    }
                }
            </style>

        </div>
    </div>

    </div>
    <br>
    <section class="catalogue-section py-5"
        style="background-color:rgb(226, 226, 229);; background-size: cover; background-position: center; background-repeat: no-repeat;">
        <div class="container">
            <h5 class="catalogue-title text-center fw-bold mb-4 ">Catalogue des Entreprises</h5>
            <div class="row align-items-center">
                <!-- Texte à gauche -->
                <div class="col-md-6">

                    <p class=""> Explorez une sélection prestigieuse d'entreprises leaders dans leurs domaines
                        respectifs. </p>
                    <p class=""> Chacune d'elles incarne l'innovation, l'excellence et la vision stratégique.</p>
                    <p class=""> Ce catalogue est votre porte d'accès à des partenaires fiables et des solutions
                        adaptées à vos besoins, peu importe votre secteur ou vos ambitions.</p>

                    <a href="{{ route('pages.catalogue') }}" class="btn btn-lg btn-primary shadow">Découvrir le
                        Catalogue</a>
                </div>
                <!-- Image à droite -->
                <div class="col-md-6 text-center">
                    <img src=" {{ asset('assets/images/besoins-en-recrutement.jpeg') }}" alt="Illustration Catalogue"
                        class="img-fluid rounded shadow">
                </div>
            </div>
        </div>
    </section>

    <section class="services-section py-5" style="background-color:rgb(193, 220, 247);">
        <div class="container">
            <h2 class="services-title text-center fw-bold mb-4 text-primary">Nos Services</h2>

            <!-- Row: Service Description -->
            <div class="row align-items-center mb-5">
                <!-- Image à gauche -->
                <div class="col-md-6 text-center">
                    <img src="{{ asset('assets/images/R.jpg') }}" alt="Illustration des Services"
                        class="img-fluid rounded shadow">
                </div>

                <!-- Texte à droite -->
                <div class="col-md-6">
                    <p class="">
                        StagesBENIN est une entreprise spécialisée dans l’insertion professionnelle et la visibilité
                        digitale des entreprises.
                    </p>
                    <p class=" mb-4">
                        Nos packs, adaptés aux besoins des entreprises et des candidats, incluent des services tels que la
                        CV thèque,
                        campagnes digitales, études de marché, création d'entreprise, et bien plus encore.
                    </p>
                    <a href="{{ route('pages.services') }}" class="btn btn-lg btn-primary shadow">Voir Plus</a>
                </div>
            </div>
        </div>
    </section>

    <div class="software-card">
        <h2>Logiciels à vendre <button class="sell-btn">Vendre mes logiciels</button></h2>
        <div class="software-list">
            <div class="no-software">
                <p>Aucun logiciel n'est disponible pour le moment.</p>
            </div>
        </div>
    </div>

    <section class="partenaires-section py-5">
        <div class="container">
            <h2 class="partenaires-title text-center fw-bold mb-4" style ="color: #007bff; ">Nos Partenaires</h2>
            <h5 class="partenaires-title text-center fw-bold mb-4" style ="color:rgb(23, 23, 23); ">Ceux qui nous ont déjà
                fait confiance</h5>

            <div id="partenairesCarousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <!-- Première slide -->
                    <div class="carousel-item active">
                        <div class="d-flex justify-content-center gap-4 p-4 border rounded bg-light shadow">
                            <img src="{{ asset('assets/images/unnamed-file-6-150x150.webp') }}" alt="Partenaire 1"
                                class="img-fluid" style="max-height: 100px;">
                            <img src="{{ asset('assets/images/unnamed-file-3-150x150.webp') }}" alt="Partenaire 2"
                                class="img-fluid" style="max-height: 100px;">
                            <img src="{{ asset('assets/images/nikola-ets-150x150.webp') }}" alt="Partenaire 3"
                                class="img-fluid" style="max-height: 100px;">
                            <img src="{{ asset('assets/images/Racines-Affro-150x150.png') }}" alt="Partenaire 4"
                                class="img-fluid" style="max-height: 100px;">
                            <img src="{{ asset('assets/images/Df-fifatin-150x150.png') }}" alt="Partenaire 5"
                                class="img-fluid" style="max-height: 100px;">
                            <img src="{{ asset('assets/images/sedric-Sarl-150x150.png') }}" alt="Partenaire 6"
                                class="img-fluid" style="max-height: 100px;">
                            <img src="{{ asset('assets/images/nnnnnn-1-150x150.webp') }}" alt="Partenaire 7"
                                class="img-fluid" style="max-height: 100px;">
                            <img src="{{ asset('assets/images/unnamed-file-3-150x150.webp') }}" alt="Partenaire 8"
                                class="img-fluid" style="max-height: 100px;">
                        </div>
                    </div>

                    <!-- Deuxième slide -->
                    <div class="carousel-item">
                        <div class="d-flex justify-content-center gap-4 p-4 border rounded bg-light shadow">
                            <img src="{{ asset('assets/images/sedric-Sarl-150x150.png') }}" alt="Partenaire 9"
                                class="img-fluid" style="max-height: 100px;">
                            <img src="{{ asset('assets/images/Dame-immo-150x150.png') }}" alt="Partenaire 7"
                                class="img-fluid" style="max-height: 100px;">
                            <img src="{{ asset('assets/images/Df-fifatin-150x150.png') }}" alt="Partenaire 10"
                                class="img-fluid" style="max-height: 100px;">
                            <img src="{{ asset('assets/images/sedric-Sarl-150x150.png') }}" alt="Partenaire 11"
                                class="img-fluid" style="max-height: 100px;">
                            <img src="{{ asset('assets/images/unnamed-file-6-150x150.webp') }}" alt="Partenaire 12"
                                class="img-fluid" style="max-height: 100px;">
                            <img src="{{ asset('assets/images/007-Security-150x150.png') }}" alt="Partenaire 13"
                                class="img-fluid" style="max-height: 100px;">
                            <img src="{{ asset('assets/images/Racines-Affro-150x150.png') }}" alt="Partenaire 14"
                                class="img-fluid" style="max-height: 100px;">
                            <img src="{{ asset('assets/images/Df-fifatin-150x150.png') }}" alt="Partenaire 15"
                                class="img-fluid" style="max-height: 100px;">
                        </div>
                    </div>




                    <!-- Flèches de navigation -->
                    <button class="carousel-control-prev" type="button" data-bs-target="#partenairesCarousel"
                        data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#partenairesCarousel"
                        data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    </button>
                </div>
            </div>
    </section>
    <div class="container">
        <div class="row">
            <!-- Nos Statistiques Section -->
            <div class="col-md-6">
                <section class="statistiques-section py-5 text-center bg-light rounded shadow">
                    <div class="container">
                        <h2 class="fw-bold mb-4" style ="color: #007bff; ">Nos Statistiques</h2>
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <div class="stat-box p-4 border rounded bg-white shadow d-flex align-items-center">
                                    <i class="fas fa-briefcase fa-3x text-primary me-3"></i>
                                    <div>
                                        <h3 class="stat-count mt-2" data-target="2000">+ 0</h3>
                                        <p class="fw-bold">Stages disponibles</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-4">
                                <div class="stat-box p-4 border rounded bg-white shadow d-flex align-items-center">
                                    <i class="fas fa-users fa-3x text-success me-3"></i>
                                    <div>
                                        <h3 class="stat-count mt-2" data-target="500"> + 0</h3>
                                        <p class="fw-bold">Candidats inscrits</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-4">
                                <div class="stat-box p-4 border rounded bg-white shadow d-flex align-items-center">
                                    <i class="fas fa-user-check fa-3x text-warning me-3"></i>
                                    <div>
                                        <h3 class="stat-count mt-2" data-target="350">+ 0</h3>
                                        <p class="fw-bold">Candidats insérés</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-4">
                                <div class="stat-box p-4 border rounded bg-white shadow d-flex align-items-center">
                                    <i class="fas fa-hourglass-half fa-3x text-danger me-3"></i>
                                    <div>
                                        <h3 class="stat-count mt-2" data-target="1500">+ 0</h3>
                                        <p class="fw-bold">Reste à insérer</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>




            <!-- Ils Nous Font Confiance Section -->
            <div class="col-md-6">
                <section class="temoignages-section py-5 text-center">
                    <div class="container">
                        <h2 class="fw-bold mb-4" style ="color: #007bff; ">Ils nous font confiance</h2>
                        <div id="temoignagesCarousel" class="carousel slide" data-bs-ride="carousel">

                            <p> Découvrez les témoignages de nos partenaires entreprises et des candidats qui ont trouvé des
                                stages professionnels grâce à Stages Bénin et qui sont pleinement satisfaits de leur
                                expérience. </p>
                            <div class="carousel-inner">

                                <div class="carousel-item active">
                                    <div class="testimonial border rounded p-4 bg-light shadow-sm">
                                        <h6 style ="color: #007bff; ">Ex candidat</h6>
                                        <p>"StagesBENIN nous a permis de trouver des stagiaires hautement qualifiés,
                                            correspondant parfaitement à nos besoins. Leur plateforme est efficace et nous
                                            sommes très satisfaits des résultats obtenus."</p>
                                        <img src="{{ asset('assets/images/111.png') }}" alt="Image Description"
                                            class="card-img-top rounded-circle"
                                            style="width: 150px; height: 150px; object-fit: cover;">
                                        <h5>Duolicasse A. Comptable</h5>
                                        <h6>Comptable</h6>
                                        <div class="stars">⭐⭐⭐⭐⭐</div>
                                    </div>
                                </div>


                                <div class="carousel-item">
                                    <div class="testimonial border rounded p-4 bg-light shadow-sm">
                                        <h6 style ="color:rgb(246, 29, 231); ">Recruteur</h6>
                                        <p>"Grâce à StagesBENIN, nous avons trouvé des stagiaires compétents qui ont apporté
                                            une réelle valeur ajoutée à notre entreprise. Nous sommes pleinement satisfaits
                                            de notre expérience et nous continuerons à utiliser leur plateforme pour
                                            recruter de futurs talents."</p>
                                        <img src="{{ asset('assets/images/Racines-Affro.png') }}" alt="Image Description"
                                            class="card-img-top rounded-circle"
                                            style="width: 150px; height: 150px; object-fit: cover;">
                                        <h5>Racines</h5>
                                        <h6>AFFRO</h6>
                                        <div class="stars">🌟🌟🌟🌟🌟</div>
                                    </div>
                                </div>
                                <div class="carousel-item">
                                    <div class="testimonial border rounded p-4 bg-light shadow-sm">
                                        <h6 style ="color:rgb(246, 29, 231); ">Recruteur</h6>
                                        <p>"StagesBENIN nous a permis de trouver des stagiaires hautement qualifiés,
                                            correspondant parfaitement à nos besoins. Leur plateforme est efficace et nous
                                            sommes très satisfaits des résultats obtenus."</p>
                                        <img src="{{ asset('assets/images/Dame-immo.png') }}" alt="Image Description"
                                            class="card-img-top rounded-circle"
                                            style="width: 150px; height: 150px; object-fit: cover;">
                                        <h5>DAME </h5>
                                        <h6>IMMO</h6>
                                        <div class="stars">🌟🌟🌟🌟</div>
                                    </div>
                                </div>
                                <div class="carousel-item">
                                    <div class="testimonial border rounded p-4 bg-light shadow-sm">
                                        <h6 style ="color:#007bff; ">Ex candidat</h6>
                                        <p>"StagesBENIN m'a permis de décrocher un stage qui a été une expérience précieuse
                                            pour mon développement professionnel. Je recommande fortement leur plateforme
                                            pour trouver des opportunités de stage de qualité."</p>
                                        <img src="{{ asset('assets/images/222.png') }}" alt="Image Description"
                                            class="card-img-top rounded-circle"
                                            style="width: 150px; height: 150px; object-fit: cover;">
                                        <h5>Kouêtè T.</h5>
                                        <h6>Secrétariat Comptable</h6>
                                        <div class="stars">⭐⭐⭐⭐</div>
                                    </div>
                                </div>
                                <div class="carousel-item">
                                    <div class="testimonial border rounded p-4 bg-light shadow-sm">
                                        <h6 style ="color: rgb(246, 29, 231); ">Recruteur</h6>
                                        <p>"Nous sommes vraiment satisfaits de notre collaboration avec StagesBENIN. Grâce à
                                            leur plateforme, nous avons recruté des stagiaires compétents qui ont contribué
                                            au succès de nos projets. Nous recommandons vivement leurs services."</p>
                                        <img src="{{ asset('assets/images/iba-managent.png') }}" alt="Image Description"
                                            class="card-img-top rounded-circle"
                                            style="width: 150px; height: 150px; object-fit: cover;">
                                        <h5>IBA</h5>
                                        <h6>MANAGEMENT</h6>
                                        <div class="stars">🌟🌟🌟🌟</div>
                                    </div>
                                </div>




                                <div class="carousel-item">
                                    <div class="testimonial border rounded p-4 bg-light shadow-sm">
                                        <h6 style ="color: #007bff; ">Ex candidat</h6>
                                        <p>"Grâce à StagesBENIN, j'ai pu trouver rapidement un stage professionnel dans mon
                                            domaine d'études. Je suis ravi de l'opportunité qui m'a été offerte et je
                                            remercie Stages Bénin pour leur plateforme efficace."</p>
                                        <img src="{{ asset('assets/images/333.png') }}" alt="Image Description"
                                            class="card-img-top rounded-circle"
                                            style="width: 150px; height: 150px; object-fit: cover;">

                                        <h5>Ketsia M.</h5>
                                        <h6>Secrétariat Bureautique</h6>
                                        <div class="stars">⭐⭐⭐⭐⭐</div>
                                    </div>
                                </div>
                                <div class="carousel-item">
                                    <div class="testimonial border rounded p-4 bg-light shadow-sm">
                                        <h6 style ="color: rgb(246, 29, 231); ">Recruteur</h6>
                                        <p>"StagesBENIN a été une véritable ressource pour notre entreprise, nous permettant
                                            de trouver des stagiaires compétents et motivés. Nous sommes pleinement
                                            satisfaits de notre collaboration et nous recommandons vivement leur
                                            plateforme."</p>
                                        <img src="{{ asset('assets/images/Df-fifatin.png') }}" alt="Image Description"
                                            class="card-img-top rounded-circle"
                                            style="width: 150px; height: 150px; object-fit: cover;">
                                        <h5>DF</h5>
                                        <h6>FIFATIN</h6>
                                        <div class="stars">🌟🌟🌟🌟</div>
                                    </div>
                                </div>
                            </div>
                            <!-- Flèches de navigation -->
                            <button class="carousel-control-prev" type="button" data-bs-target="#temoignagesCarousel"
                                data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" style="color: rgb(246, 29, 231);"></span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#temoignagesCarousel"
                                data-bs-slide="next">
                                <span class="carousel-control-next-icon" style="color: rgb(246, 29, 231);"></span>
                            </button>

                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>

    <script>
        const messages = [
            "votre stage professionnel !.",
            "vos futurs cadres !.",
            "le stage de vos rêves !."
        ];

        let messageIndex = 0;
        let charIndex = 0;
        const textContainer = document.getElementById("animatedText");

        function typeWriterEffect() {
            if (charIndex < messages[messageIndex].length) {
                textContainer.innerHTML += messages[messageIndex].charAt(charIndex);
                charIndex++;
                setTimeout(typeWriterEffect, 50);
            } else {
                setTimeout(() => {
                    textContainer.innerHTML = "";
                    charIndex = 0;
                    messageIndex = (messageIndex + 1) % messages.length;
                    typeWriterEffect();
                }, 2000);
            }
        }

        typeWriterEffect();
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const counters = document.querySelectorAll('.stat-count');
            const speed = 100; // Vitesse d'animation

            counters.forEach(counter => {
                let updateCount = () => {
                    let target = +counter.getAttribute('data-target');
                    let count = +counter.innerText;
                    let increment = Math.ceil(target / speed);

                    if (count < target) {
                        counter.innerText = count + increment;
                        setTimeout(updateCount, 30);
                    } else {
                        counter.innerText = target;
                    }
                };
                updateCount();
            });
        });
    </script>
    <style>
        .testimonial {
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            padding: 20px;
            /* Space inside */
            border-radius: 10px;
            /* Rounded corners */
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            /* Light shadow for depth */
            transition: transform 0.3s ease-in-out;
        }

        .catalogue-title {
            font-size: 2.2rem;
            /* Taille normale */
        }

        @media (max-width: 576px) {
            .catalogue-title {
                font-size: 1.2rem;
                /* Taille réduite sur les petits écrans */
            }
        }

        .testimonial:hover {
            transform: scale(1.05);
            /* Slight zoom effect on hover */
        }

        p {
            font-size: 1vw;
            /* La taille du texte s'ajuste à la largeur de l'écran */


        }

        #animatedText {
            font-size: 9vw;
            /* Texte légèrement plus grand */
        }

        @media screen and (max-width: 768px) {
            p {
                font-size: 14px;
            }
        }

        @media screen and (min-width: 769px) and (max-width: 1024px) {
            p {
                font-size: 18px;
            }
        }

        @media screen and (min-width: 1025px) {
            p {
                font-size: 22px;
            }
        }

        #animatedText {
            font-size: 8vw;
            /* Ajuste en fonction de la largeur de l'écran */
            color: rgb(14, 40, 145);
            font-weight: bold;
            white-space: nowrap;
            /* Empêche le retour à la ligne */
        }

        @media screen and (max-width: 768px) {
            #animatedText {
                font-size: 16px;
                /* Taille fixe sur mobile */
            }
        }

        @media screen and (min-width: 1024px) {
            #animatedText {
                font-size: 9vw;
                /* Augmente sur grand écran */
            }
        }


        .stars {
            font-size: 18px;
            /* Adjust star size */
            color: #ffd700;
            /* Gold color for stars */
        }

        .catalogue-title {

            color: #007bff;
            /* Adjust title color */
            margin-bottom: 20px;
        }

        .software-card {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #3498db;
            border-radius: 10px;
            background-color: #f8f9fa;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .software-card h2 {
            text-align: center;
            color: #3498db;
            font-family: Arial, sans-serif;
            margin-bottom: 20px;
        }

        .software-list {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
        }

        .job-offers-section {
            max-width: 900px;
            margin: 20px auto;
            padding: 20px;
            background-color: #f8f9fa;
            border: 1px solid #ddd;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .job-offers-section h2 {
            text-align: center;
            color: #2c3e50;
            margin-bottom: 20px;
            font-family: Arial, sans-serif;
        }

        .job-offers-list {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
        }

        .job-offer-item {
            width: 280px;
            border: 1px solid #ccc;
            border-radius: 10px;
            background-color: #fff;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
            text-align: center;
            padding: 15px;
        }

        .job-offer-item h3 {
            font-size: 18px;
            color: #333;
        }


        .job-offer-item p {
            font-size: 16px;
            margin: 5px 0;
        }

        .salary {
            font-weight: bold;
            color: #e74c3c;
        }

        .apply-btn {
            background-color: #3498db;
            color: #fff;
            border: none;
            border-radius: 5px;
            padding: 10px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .apply-btn:hover {
            background-color: #2980b9;
        }

        .software-item {
            width: 250px;
            border: 1px solid #ccc;
            border-radius: 10px;
            background-color: #fff;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
            text-align: center;
            padding: 10px;
        }

        .software-image {
            max-width: 100%;
            border-radius: 5px;
            margin-bottom: 10px;
        }

        .software-info h3 {
            font-size: 18px;
            color: #333;
        }

        .software-info p {
            font-size: 16px;
            margin-bottom: 10px;
        }

        .price {
            font-weight: bold;
            color: #e74c3c;
        }

        .sell-btn {
            background-color: #3498db;
            color: #fff;
            border: none;
            border-radius: 5px;
            padding: 10px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .sell-btn:hover {
            background-color: #2980b9;
        }


        .card-img-top {
            max-height: 200px;
            object-fit: cover;
            /* Keeps images proportional */
        }

        body {
            font-family: 'Times New Roman', Times, serif;
        }

        .btn-primary {
            font-weight: bold;
            padding: 10px 15px;
        }

        .card {
            transition: transform 0.3s ease-in-out;
        }

        .card:hover {
            transform: scale(1.05);
            /* Slight zoom effect when hovered */
        }

        .btn {
            font-size: 1rem;
            transition: transform 0.2s ease-in-out;
        }

        .btn:hover {
            transform: scale(1.05);
            /* Slight zoom effect on hover */
            background-color: #0056b3;
            /* Darker shade on hover */
        }

        .card-img-top {
            border: 2px solid #ddd;
            /* Add a subtle border */
            padding: 5px;
            /* Space between the image and border */
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            /* Light shadow for a polished look */
        }
    </style>












    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
@endsection
