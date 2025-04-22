{{-- Indique que cette vue étend le layout principal --}}
@extends('layouts.layout') {{-- Assure-toi que 'layouts.app' correspond au chemin de ton fichier layout --}}

{{-- Définit le titre spécifique pour cette page --}}
@section('title', 'Inscription - Choisissez votre profil - StagesBENIN')

{{-- Ajoute les styles CSS spécifiques à cette page --}}
@section('styles')
<style>
    /* == Styles spécifiques à la page d'inscription == */
    /* (On ne garde QUE les styles nécessaires pour le contenu principal) */

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
        font-family: 'Montserrat', sans-serif; /* Assure-toi que Montserrat est chargé globalement ou ajoute-le ici */
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
        max-width: 380px; /* Control image size */
        height: 200px; /* Fixed height */
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
        font-family: 'Montserrat', sans-serif; /* Assure-toi que Montserrat est chargé globalement ou ajoute-le ici */
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

    /* Optionnel: Si Google Fonts n'est pas chargé globalement par le layout */
    /* @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700&family=Roboto:wght@400;700&family=Montserrat:wght@400;600;700&display=swap'); */
    /* body { font-family: 'Poppins', sans-serif; } */ /* Le layout applique déjà Poppins */

</style>
@endsection

{{-- Définit le contenu principal de la page --}}
@section('content')
    {{--
        Variables supposées passées depuis le contrôleur ou définies ici pour l'exemple.
        Il est préférable de les passer depuis le contrôleur.
    --}}
    @php
        $recruteurImgUrl = $recruteurImgUrl ?? "https://stagesbenin.com/wp-content/uploads/elementor/thumbs/image-1-compressed-2-q7w709jvzt3qak2c9um5v9sdrjrg7hmv8sy9l3hh0c.jpg";
        $candidatImgUrl = $candidatImgUrl ?? "https://stagesbenin.com/wp-content/uploads/elementor/thumbs/Fond-candidat-Pt-compressed-q7ycwdmwb3q1oaxm7xza9nw2wqn719rrfvkpttsqqk.jpg";
        
    @endphp

    {{-- Le layout fournit déjà <main class="container mt-4">,
         donc on ajoute le contenu directement ici.
         On peut ajouter une classe de padding si nécessaire. --}}
    <div class="inscription-choice-content pt-4 pb-5"> {{-- Ajout de padding vertical --}}

        <section class="text-center pb-4"> {{-- Réduction du padding bottom car il y a déjà celui du div parent --}}
             {{-- <i class="fas fa-user-plus page-title-icon"></i> --}}
             <h3 class="page-subtitle">Type d'inscription</h3>
             <h1 class="page-main-title">Inscription</h1>
             <hr class="title-divider">
        </section>

        <p class="intro-text">
            Rejoignez notre plateforme dès maintenant et donnez un coup de pouce à votre carrière ! Recruteurs, trouvez les meilleurs talents pour vos offres de stage.
        </p>

        <div class="row justify-content-center g-4"> {{-- g-4 pour l'espacement entre les colonnes --}}
             <!-- Carte Recruteur -->
             <div class="col-lg-5 col-md-6 d-flex"> {{-- d-flex pour aligner les cartes en hauteur --}}
                 <div class="signup-card">
                     <img src="{{ asset('assets/images/recruteur-inscription-image.jpg') }}" alt="Recruteur" class="signup-card-img">
                     <h3 class="signup-card-title">Recruteur</h3>
                     <h4 class="signup-card-subtitle">Employeur</h4>
                     <hr>
                     <p class="signup-card-text">
                         Chers Recruteurs, en vous inscrivant sur cette plateforme, vous bénéficierez d’un tableau de bord simple à utiliser et à partir duquel vous pouvez facilement faire vos publications d’annonces en moins d’une minute.
                     </p>
                     <a href="{{ route('register.recruteur.create') }}" class="btn">Cliquez ici</a>
                 </div>
             </div>

             <!-- Carte Candidat -->
             <div class="col-lg-5 col-md-6 d-flex"> {{-- d-flex pour aligner les cartes en hauteur --}}
                 <div class="signup-card">
                      <img src="{{ asset('assets/images/etudiant-inscription-image.jpeg') }}" alt="Candidat" class="signup-card-img">
                      <h3 class="signup-card-title">Candidat</h3>
                      <h4 class="signup-card-subtitle">Postulant</h4>
                      <hr>
                      <p class="signup-card-text">
                          Accédez à des opportunités de stages professionnels exclusives en vous inscrivant.
                      </p>
                      <a href="{{ route('register.etudiant.create') }}" class="btn">S'inscrire</a>
                 </div>
             </div>
        </div>
    </div> {{-- Fin de .inscription-choice-content --}}

@endsection

{{-- Ajoute les scripts JS spécifiques à cette page (s'il y en a) --}}
@section('scripts')
    {{-- <script>
        // Mettre ici du JS spécifique à cette page si nécessaire
        // Par exemple, des animations ou des validations côté client pour les cartes
        console.log("Page d'inscription chargée !");
    </script> --}}
@endsection