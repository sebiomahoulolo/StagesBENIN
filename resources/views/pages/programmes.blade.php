@extends('layouts.layout')

@section('title', 'StagesBENIN')

@section('content')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    
    <!-- Custom Styles -->
    <style>
        :root {
            --primary-color: #0000ff;
            --text-color: #333;
            --bg-color: rgb(249, 250, 252);
            --card-hover-shadow: 0px 4px 15px rgba(0, 0, 0, 0.2);
        }
        
        body {
         
            margin: 0;
            padding: 0;
            background: var(--bg-color);
        }

        /* Header & Navigation */
        header {
            background: var(--primary-color) !important;
            margin-bottom: 2rem;
        }

        .navbar {
            background-color: white;
            padding: 0.75rem 1rem;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        
        .navbar-brand {
            font-family: 'Arial Black', sans-serif;
            font-weight: bold;
            font-size: 1.625rem;
            color: var(--primary-color);
        }
        
        .nav-link {
            color: var(--primary-color);
            font-weight: 600;
            font-size: 0.875rem;
            transition: color 0.2s ease-in-out;
        }
        
        .nav-link:hover {
            color: rgba(0, 0, 255, 0.7);
        }

        /* Section Headings */
        .section-heading {
            font-family: 'Poppins', sans-serif;
            font-size: 1.75rem;
            margin-bottom: 2rem;
            color: var(--text-color);
            text-align: center;
        }
   body {
        font-family: 'Times New Roman', Times, serif;
    }
        /* Event Cards */
        .event-card {
            border-radius: 12%;
            border-color: #3498db;
         
            overflow: hidden;
            margin-bottom: 9rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
        }
        
        .event-card:hover {
            transform: scale(1.05);
            box-shadow: var(--card-hover-shadow);
        }
        
        .event-card .card-img-top {
            height: 200px;
            object-fit: cover;
        }
        
        .event-card .card-body {
            padding: 1.25rem;
        }
        
        .event-card .card-title {
            font-weight: 700;
            margin-bottom: 0.75rem;
        }
        
        .event-card .card-text {
            font-size: 0.9rem;
            color: #6c757d;
            margin-bottom: 1rem;
        }
        
        .event-card .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            padding: 0.5rem 1.5rem;
            font-weight: 600;
        }
        
        /* Responsive Adjustments */
        @media (max-width: 768px) {
            .section-heading {
                font-size: 1.5rem;
                padding: 0 1rem;
            }
            
            .event-card {
                margin-bottom: 1.5rem;
            }
        }
    </style>

    <!-- Main Content -->
    <div class="container py-5">
        <h2 class="section-heading">
            Découvrez nos événements exclusifs, conçus pour rassembler passionnés et professionnels autour d'expériences uniques.
        </h2>
        
        <div class="row">
            <!-- Event Card 1 -->
            <div class="col-md-6 col-lg-4">
                <div class="card event-card">
                    <img src="https://stagesbenin.com/wp-content/uploads/2025/04/WhatsApp-Image-2025-04-02-a-12.38.23_6e2317e6-300x171.jpg" class="card-img-top" alt="Les Ecoles de SaNOSPro">
                    <div class="card-body text-center">
                        <h5 class="card-title">Les Ecoles de SaNOSPro</h5>
                        <a href="{{ route('pages.sanospro') }}" class="btn btn-primary">Voir »</a>
                    </div>
                </div>
            </div>
            
            
            <div class="col-md-6 col-lg-4">
                <div class="card event-card">
                    <img src="https://stagesbenin.com/wp-content/uploads/2025/04/WhatsApp-Image-2025-04-01-a-14.00.27_b95bc24c-300x175.jpg" class="card-img-top" alt="PEE">
                    <div class="card-body text-center">
                        <h5 class="card-title">PEE</h5>
                        <p class="card-text">Prix de l'Étudiant Entrepreneur</p>
                        <a href="{{ route('pages.pee') }}" class="btn btn-primary">Voir »</a>
                    </div>
                </div>
            </div>
            
          
            <div class="col-md-6 col-lg-4">
                <div class="card event-card">
                    <img src="https://stagesbenin.com/wp-content/uploads/2024/09/IMG-20240904-WA0030-300x200.jpg" class="card-img-top" alt="JRSP">
                    <div class="card-body text-center">
                        <h5 class="card-title">JRSP</h5>
                        <p class="card-text">Journée de Réflexion sur les Stages Professionnels</p>
                        <a href="#" class="btn btn-primary">Voir »</a>
                    </div>
                </div>
            </div> 
            
            <!-- Event Card 4 -->
            <div class="col-md-6 col-lg-4">
                <div class="card event-card">
                    <img src="https://stagesbenin.com/wp-content/uploads/2025/04/WhatsApp-Image-2025-04-01-a-11.53.25_2c78898f-300x200.jpg" class="card-img-top" alt="PAPS">
                    <div class="card-body text-center">
                        <h5 class="card-title">PAPS</h5>
                        <p class="card-text">Programme d'Accompagnement Professionnel des Stagiaires</p>
                        <a href="{{ route('pages.paps') }}" class="btn btn-primary">Voir »</a>
                    </div>
                </div>
            </div>
            
            <!-- Event Card 5 -->
            <div class="col-md-6 col-lg-4">
                <div class="card event-card">
                    <img src="https://stagesbenin.com/wp-content/uploads/2024/02/logo-sdanos-300x169.webp" class="card-img-top" alt="SaNosPro">
                    <div class="card-body text-center">
                        <h5 class="card-title">SaNosPro</h5>
                        <a href="" class="btn btn-primary">Voir »</a>
                    </div>
                </div>
            </div>


          
            

        </div>
    </div>

    <!-- JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endsection