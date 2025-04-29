@extends('layouts.layout')

@section('title', 'StagesBEIN')

@push('styles') {{-- Push specific styles to a stack defined in your layout --}}
<style>
    :root {
        --bs-primary-rgb: 0, 86, 179; /* Example blue */
        --bs-secondary-rgb: 108, 117, 125;
        --section-padding: 4rem 0; /* Consistent vertical padding */
    }

    /* Hero Section */
    .hero-section {
        /* Replace with your actual background image */
        background: linear-gradient(rgba(0, 30, 70, 0.6), rgba(0, 30, 70, 0.6)), url('{{ asset('img/hero-background.jpg') }}') no-repeat center center;
        background-size: cover;
        color: #ffffff;
        min-height: 60vh; /* Give it some height */
        display: flex;
        align-items: center;
        text-align: center;
        padding: var(--section-padding);
    }
    .hero-section h1 {
        font-weight: 700;
        margin-bottom: 0.75rem;
        font-size: 2.8rem;
    }
    .hero-section .lead {
        font-size: 1.25rem;
        font-weight: 300;
        max-width: 800px;
        margin: 0 auto;
        line-height: 1.6;
    }
    .hero-section .lead strong {
        font-weight: 500; /* Make theme stand out slightly */
        color: #e0e0e0;
    }

    /* Information Section */
    .info-item {
        display: flex;
        align-items: center;
        justify-content: center; /* Center items within their columns */
        margin-bottom: 1rem;
        font-size: 1.1rem;
    }
    .info-item i {
        font-size: 1.5rem;
        color: var(--bs-primary);
        margin-right: 10px;
        width: 30px; /* Fixed width for alignment */
        text-align: center;
    }

    /* Section Headings */
    .section-heading {
        margin-bottom: 3rem;
        font-weight: 600;
        color: #333;
    }
    .section-heading::after { /* Optional underline */
        content: '';
        display: block;
        width: 60px;
        height: 3px;
        background-color: var(--bs-primary);
        margin: 10px auto 0;
    }

    /* About Section */
    .about-section p {
        max-width: 850px;
        margin-left: auto;
        margin-right: auto;
        font-size: 1.1rem;
        line-height: 1.7;
        color: #555;
    }

    /* Expectations List */
    .expectations-list {
        list-style: none;
        padding-left: 0;
        max-width: 700px;
        margin: 0 auto;
    }
    .expectations-list li {
        background-color: #f8f9fa;
        border: 1px solid #dee2e6;
        padding: 1rem 1.5rem;
        margin-bottom: 0.75rem;
        border-radius: 0.375rem;
        display: flex;
        align-items: center;
        font-size: 1.05rem;
        transition: background-color 0.2s ease-in-out;
    }
     .expectations-list li:hover {
         background-color: #e9ecef;
     }
    .expectations-list li i {
        color: #198754; /* Green checkmark */
        margin-right: 12px;
        font-size: 1.2rem;
    }

    /* Action Buttons Section */
    .action-buttons .btn {
        width: 100%; /* Full width on mobile */
        padding: 0.8rem 1rem;
        font-size: 1.05rem;
        font-weight: 500;
        margin-bottom: 1rem; /* Spacing on mobile */
        white-space: normal; /* Allow button text to wrap */
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px; /* Space between icon and text */
        min-height: 60px; /* Consistent height */
    }
    @media (min-width: 768px) {
        .action-buttons .btn {
             margin-bottom: 0; /* Remove bottom margin on larger screens */
        }
    }

    /* Conference Cards */
    .conference-card {
        height: 100%; /* Make cards equal height in a row */
        border: 1px solid #e0e0e0;
        transition: box-shadow 0.3s ease, transform 0.3s ease;
    }
    .conference-card:hover {
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        transform: translateY(-5px);
    }
     .conference-card .card-body {
         display: flex;
         flex-direction: column;
     }
     .conference-card .card-title {
         font-size: 1.15rem;
         font-weight: 600;
         color: var(--bs-primary);
         margin-bottom: 1rem;
     }
     .conference-card .card-text {
         font-size: 0.95rem;
         color: #666;
         margin-top: auto; /* Pushes speaker info down */
     }
     .conference-card .speaker-img {
         width: 60px;
         height: 60px;
         border-radius: 50%;
         object-fit: cover;
         margin-right: 15px;
         background-color: #eee; /* Placeholder background */
     }
     .conference-card .speaker-info {
         display: flex;
         align-items: center;
         margin-top: 1.5rem;
         padding-top: 1rem;
         border-top: 1px solid #eee;
     }
      .conference-card .speaker-info span {
          font-weight: 500;
          color: #333;
      }

    /* Sponsors Section */
    .sponsor-logos {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        align-items: center;
        gap: 2.5rem;
        margin-top: 2rem;
    }
    .sponsor-logos img {
        max-height: 60px; /* Adjust as needed */
        max-width: 150px;
        filter: grayscale(100%);
        opacity: 0.7;
        transition: filter 0.3s ease, opacity 0.3s ease;
    }
    .sponsor-logos img:hover {
        filter: grayscale(0%);
        opacity: 1;
    }

    /* Follow Us Section */
    .follow-us-section .social-link i {
        font-size: 2.5rem; /* Slightly smaller icons */
        transition: transform 0.3s ease, color 0.3s ease;
    }
    .follow-us-section .social-link:hover i {
        transform: scale(1.15);
    }
    .follow-us-section .fa-facebook:hover { color: #3b5998 !important; }
    .follow-us-section .fa-twitter:hover { color: #1da1f2 !important; }
    .follow-us-section .fa-linkedin:hover { color: #0077b5 !important; }

    /* General */
    .bg-light-subtle { /* Custom subtle background */
        background-color: #f8f9fa;
    }
    hr {
        width: 80%;
        margin: 3rem auto;
        border-top: 1px solid rgba(0,0,0,0.1);
    }

</style>
@endpush

@section('content')

{{-- Hero Section --}}
<section class="hero-section">
    <div class="container">
        <h1 class="display-4">Salon National d'Orientation et de Stages Professionnels</h1>
        <p class="lead mt-3 mb-4">(SaNOSPro)</p>
        <p class="lead">
            Thème :
            <strong>"Promouvoir la Synergie Inter-Entreprises et trouver des Approches de Solutions aux Difficultés d’Accès aux Stages des Nouveaux Diplômés"</strong>
        </p>
    </div>
</section>

{{-- Information Section --}}
<section class="information-section py-5">
    <div class="container">
         <h2 class="section-heading text-center">Informations Pratiques</h2>
        <div class="row text-center justify-content-center">
            <div class="col-md-4 col-lg-3">
                <div class="info-item">
                    <i class="fa-solid fa-calendar-days"></i>
                    <span><strong>Dates :</strong> 21-23 Mars 2024</span>
                </div>
            </div>
            <div class="col-md-4 col-lg-3">
                 <div class="info-item">
                    <i class="fa-solid fa-clock"></i>
                    <span><strong>Heure :</strong> Dès 08:00</span>
                 </div>
            </div>
            <div class="col-md-4 col-lg-4">
                 <div class="info-item">
                    <i class="fa-solid fa-location-dot"></i>
                    <span><strong>Lieu :</strong> Université d’Abomey-Calavi, Bénin</span>
                 </div>
            </div>
        </div>
    </div>
</section>

<hr>

{{-- About Section --}}
<section class="about-section py-5 bg-light-subtle">
    <div class="container">
        <h2 class="section-heading text-center">À Propos du Salon</h2>
        <p class="text-center">
            Le SaNOSPro est une plateforme dynamique conçue pour catalyser la collaboration entre entreprises de divers secteurs. Il offre une visibilité ciblée et facilite les échanges enrichissants avec des acteurs clés. Ce salon représente une réponse concrète aux défis de la transition académique vers le monde professionnel pour nos étudiants, en créant des ponts essentiels entre formation et emploi.
        </p>
    </div>
</section>

{{-- Expectations Section --}}
<section class="expectations-section py-5">
    <div class="container">
        <h2 class="section-heading text-center">Ce Qui Vous Attend</h2>
        <ul class="expectations-list">
            <li><i class="fa-solid fa-microphone-lines"></i><span>Sessions informatives et conférences inspirantes sur le thème central.</span></li>
            <li><i class="fa-solid fa-user-tie"></i><span>Intervention d'experts reconnus partageant leurs connaissances et expériences.</span></li>
            <li><i class="fa-solid fa-comments"></i><span>Opportunités uniques de réseautage entre étudiants, diplômés et entreprises.</span></li>
            <li><i class="fa-solid fa-lightbulb"></i><span>Ateliers interactifs et discussions pour co-créer des solutions concrètes.</span></li>
             <li><i class="fa-solid fa-handshake-angle"></i><span>Stands d'entreprises pour découvrir des opportunités de stages et d'emploi.</span></li>
        </ul>
    </div>
</section>

<hr>

{{-- Participate Section --}}
<section class="participate-section py-5 bg-light-subtle">
    <div class="container text-center">
        <h2 class="section-heading">Participez à SaNOSPro</h2>
        <p class="lead mb-4">Impliquez-vous dans cet événement majeur !</p>
        <div class="row justify-content-center action-buttons">
            <div class="col-md-4 col-lg-3 mb-3 mb-md-0">
                <a href="#" class="btn btn-primary btn-lg"><i class="fa-solid fa-arrow-right-to-bracket"></i>Je Participe</a>
            </div>
            <div class="col-md-4 col-lg-3 mb-3 mb-md-0">
                <a href="#" class="btn btn-success btn-lg"><i class="fa-solid fa-store"></i>Réserver un Stand</a>
            </div>
            <div class="col-md-4 col-lg-3">
                <a href="#" class="btn btn-warning btn-lg text-dark"><i class="fa-solid fa-hand-holding-heart"></i>Soutenir le Salon</a>
            </div>
        </div>
    </div>
</section>

{{-- Other Opportunities Section --}}
<section class="opportunities-section py-5">
    <div class="container text-center">
        <h2 class="section-heading">Autres Opportunités</h2>
        <p class="lead mb-4">Découvrez d'autres façons de vous engager avec StagesBENIN.</p>
        <div class="row justify-content-center action-buttons">
            <div class="col-md-4 col-lg-3 mb-3 mb-md-0">
                 {{-- Consider changing btn-danger if not a destructive action --}}
                <a href="#" class="btn btn-info btn-lg">
                 <h4>Hôtesse du SaNOSPro</h5>
            <h6>Professionnelles en hôtellerie et évènementiels</h6>
                <i class="fa-solid fa-user-plus"></i>Devenir Hôtesse</a>
            </div>
            <div class="col-md-4 col-lg-3 mb-3 mb-md-0">
                <a href="#" class="btn btn-secondary btn-lg"><i class="fa-solid fa-bullhorn"></i>Être Ambassadeur</a>
            </div>
            <div class="col-md-4 col-lg-3">
           
                <a href="#" class="btn btn-dark btn-lg"><i class="fa-solid fa-user-graduate"></i>Demander un Stagiaire</a>
            </div>
        </div>
    </div>
</section>

<hr>

{{-- Conference Section --}}
<section class="conference-section py-5 bg-light-subtle">
    <div class="container">
        <h2 class="section-heading text-center">Nos Conférences & Ateliers</h2>
        <div class="row g-4 justify-content-center"> {{-- g-4 adds gap between columns/rows --}}
            {{-- Card 1 --}}
            <div class="col-md-6 col-lg-4 d-flex align-items-stretch">
                <div class="card conference-card">
                    <div class="card-body">
                        <h3 class="card-title">Stratégies de Communication Efficaces</h3>
                        <p class="card-text">Comment élaborer et déployer des plans de communication percutants pour atteindre vos objectifs.</p>
                        <div class="speaker-info">
                            {{-- Replace with actual speaker image --}}
                            <img src="{{ asset('img/speaker-placeholder.png') }}" alt="Conférencier" class="speaker-img">
                            <div>
                                <span>Nom Conférencier 1</span><br>
                                <small>Titre/Organisation</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- Card 2 --}}
            <div class="col-md-6 col-lg-4 d-flex align-items-stretch">
                <div class="card conference-card">
                    <div class="card-body">
                        <h3 class="card-title">Réussir un Appel d’Offres</h3>
                        <p class="card-text">Quelles sont les clés et les meilleures pratiques pour maximiser vos chances de remporter un appel d'offres ?</p>
                         <div class="speaker-info">
                            <img src="{{ asset('img/speaker-placeholder.png') }}" alt="Conférencier" class="speaker-img">
                             <div>
                                <span>Nom Conférencier 2</span><br>
                                <small>Titre/Organisation</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
             {{-- Card 3 --}}
            <div class="col-md-6 col-lg-4 d-flex align-items-stretch">
                <div class="card conference-card">
                    <div class="card-body">
                        <h3 class="card-title">Stimuler la Créativité & l'Innovation</h3>
                        <p class="card-text">Techniques et méthodes pour générer des idées nouvelles et cultiver un environnement innovant.</p>
                         <div class="speaker-info">
                           <img src="{{ asset('img/speaker-placeholder.png') }}" alt="Conférencier" class="speaker-img">
                             <div>
                                <span>Nom Conférencier 3</span><br>
                                <small>Titre/Organisation</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Sponsors Section --}}
<section class="sponsors-section py-5">
    <div class="container text-center">
        <h2 class="section-heading">Nos Partenaires & Sponsors</h2>
        <p class="lead mb-4">Ils soutiennent l'avenir professionnel des jeunes au Bénin.</p>
        <div class="sponsor-logos">
            {{-- Add sponsor logos here --}}
            <img src="{{ asset('img/sponsor-logo-placeholder.png') }}" alt="Sponsor Logo 1">
            <img src="{{ asset('img/sponsor-logo-placeholder.png') }}" alt="Sponsor Logo 2">
            <img src="{{ asset('img/sponsor-logo-placeholder.png') }}" alt="Sponsor Logo 3">
            <img src="{{ asset('img/sponsor-logo-placeholder.png') }}" alt="Sponsor Logo 4">
            <img src="{{ asset('img/sponsor-logo-placeholder.png') }}" alt="Sponsor Logo 5">
        </div>
    </div>
</section>

<hr>

{{-- Follow Us Section --}}
<section class="follow-us-section py-5 bg-light-subtle">
    <div class="container text-center">
        <h2 class="section-heading">Restez Connectés</h2>
        <p class="lead mb-4">Suivez l'actualité de SaNOSPro et StagesBENIN sur les réseaux sociaux.</p>
        <div class="row justify-content-center">
            <div class="col-3 col-md-2 col-lg-1">
                 {{-- Replace # with actual links --}}
                <a href="#" target="_blank" class="text-secondary social-link">
                    <i class="fab fa-facebook"></i>
                </a>
            </div>
            <div class="col-3 col-md-2 col-lg-1">
                <a href="#" target="_blank" class="text-secondary social-link">
                    <i class="fab fa-twitter"></i>
                </a>
            </div>
            <div class="col-3 col-md-2 col-lg-1">
                <a href="#" target="_blank" class="text-secondary social-link">
                    <i class="fab fa-linkedin"></i>
                </a>
            </div>
             {{-- Add other relevant social media like Instagram or WhatsApp --}}
             <div class="col-3 col-md-2 col-lg-1">
                <a href="#" target="_blank" class="text-secondary social-link">
                    <i class="fab fa-instagram"></i>
                </a>
            </div>
        </div>
    </div>
</section>

@endsection