@extends('layouts.layout')

@section('title', 'StagesBENIN - Détails Partenaire')

@section('content')

<style>
    /* Styles généraux */
    .card-custom {
        position: relative;
        color: white;
        border-radius: 15px;
        padding: 25px;
        height: 100%;
        box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.2);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        margin-bottom: 30px;
        overflow: hidden;
    }

    .card-custom::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(135deg, rgba(0, 123, 255, 0.7), rgba(0, 86, 179, 0.8));
        z-index: 1;
    }

    .card-content {
        position: relative;
        z-index: 2;
        text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.6);
    }

    .card-custom h5 {
        font-size: 22px;
        margin-top: 10px;
        font-weight: 600;
    }

    .card-custom p {
        margin: 10px 0;
        line-height: 1.6;
    }

    .card-custom h1 {
        font-size: 28px;
        font-weight: bold;
        margin-bottom: 20px;
        text-align: center;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.7);
    }

    /* Info cards */
    .info-card {
        border: 1px solid #ddd;
        padding: 10px;
        border-radius: 8px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        display: flex;
        align-items: center;
        background-color: rgba(255, 255, 255, 0.9);
        height: 100%;
        transition: transform 0.2s ease;
        backdrop-filter: blur(5px);
    }
    
    .info-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 10px rgba(0,0,0,0.15);
    }

    .info-card i {
        font-size: 20px;
        margin-right: 10px;
        color: #0056b3;
        flex-shrink: 0;
    }

    /* Logo card spécifique */
    .logo-card {
        padding: 5px;
        justify-content: center;
    }
    
    .logo-card img {
        height: 40px;
        width: auto;
        object-fit: contain;
        margin: 0;
    }

    .info-card p {
        margin: 0;
        color: #333;
        text-shadow: none;
        font-size: 14px;
        word-break: break-word;
    }

    /* Sections d'activité */
    .activity-section {
        background-color: rgba(248, 249, 250, 0.8);
        padding: 25px;
        border-radius: 10px;
        margin-top: 30px;
        margin-bottom: 30px;
        color: #333;
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
        backdrop-filter: blur(5px);
    }

    .activity-section h4 {
        color: #0056b3;
        margin-bottom: 15px;
        font-weight: 600;
        text-shadow: none;
    }
    
    .activity-section p {
        text-shadow: none;
    }
    
    /* Image de fond */
    .bg-image {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        opacity: 0.75;
        z-index: 0;
        filter: contrast(1.1) brightness(1.1);
    }
    
    /* Bouton retour */
    .btn-retour {
        display: inline-block;
        background-color: #0056b3;
        color: white;
        padding: 8px 20px;
        border-radius: 5px;
        text-decoration: none;
        margin-bottom: 20px;
        font-weight: bold;
        transition: background-color 0.2s;
    }
    
    .btn-retour:hover {
        background-color: #003d80;
        text-decoration: none;
        color: white;
    }
    
    /* Style pour le compteur de visites */
    .visit-counter {
        position: absolute;
        top: 20px;
        right: 20px;
        background-color: rgba(255, 255, 255, 0.9);
        padding: 8px 15px;
        border-radius: 20px;
        z-index: 3;
        display: flex;
        align-items: center;
        box-shadow: 0 2px 5px rgba(0,0,0,0.2);
    }
    
    .visit-counter i {
        color: #0056b3;
        margin-right: 8px;
        font-size: 18px;
    }
    
    .visit-counter span {
        color: #333;
        font-weight: 600;
        font-size: 14px;
        text-shadow: none;
    }
    
    /* Responsive pour écrans plus petits */
    @media (max-width: 992px) {
        .info-cards-container {
            flex-wrap: wrap;
        }
        .info-card-wrapper {
            flex: 0 0 50%;
            max-width: 50%;
            margin-bottom: 15px;
        }
    }
    
    @media (max-width: 576px) {
        .info-card-wrapper {
            flex: 0 0 100%;
            max-width: 100%;
        }
        .visit-counter {
            top: 10px;
            right: 10px;
            padding: 5px 10px;
        }
    }
</style>

<div class="container">
   
    
    <div class="card-custom">
        @if($catalogue->image)
            <img src="{{ asset('assets/images/formations/' . $catalogue->image) }}" alt="Background" class="bg-image">
        @endif
        
        <!-- Compteur de visites -->
        <div class="visit-counter">
            <i class="fas fa-eye"></i>
            <span>{{ $catalogue->views ?? 102 }} visites</span>
        </div>
        
        <div class="card-content">
            <h1>Bienvenue chez les partenaires de StagesBENIN</h1>
            <div class="row">
                <div class="col-md-8">
                    <h5>{{ $catalogue->titre }}</h5>
                    <p>{{ $catalogue->description }}</p>
                </div>
            </div>
            
            <!-- Informations de contact alignées horizontalement -->
            <div class="row mt-4 info-cards-container">
                <div class="col-lg-3 col-md-6 mb-3 info-card-wrapper">
                   <div class="info-card-wrapper">
    <div class="info-card logo-card">
        <img src="{{ asset('assets/images/formations/' . $catalogue->logo) }}" alt="Logo">
    </div><br>
    <div class="email-button">
        <a href="mailto:contact@stagesbenin.com" class="btn btn-primary">Envoyer un email</a>
    </div>
</div>
          </div>
                <div class="col-lg-3 col-md-6 mb-3 info-card-wrapper">
                    <div class="info-card">
                        <i class="fas fa-briefcase"></i>
                        <p><strong>Activité principale :</strong> {{ $catalogue->activite_principale }}</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-3 info-card-wrapper">
                    <div class="info-card">
                        <i class="fas fa-map-marker-alt"></i>
                        <p><strong>Localisation :</strong> {{ $catalogue->localisation }}</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-3 info-card-wrapper">
                    <div class="info-card">
                        <i class="fas fa-phone-alt"></i>
                        <p><strong>Contact :</strong> contact@stagesbenin.com / +229 0165001056</p>
                    </div>
                </div>
            </div>
            
            <!-- Sections d'activités -->
            <div class="activity-section">
               
                <p><strong>{{ $catalogue->activite_principale }}</strong></p>
                <p>{{ $catalogue->desc_activite_principale }}</p>
            </div>
            
            <!--div class="activity-section">
                <h4>Activité secondaire</h4>
                <p><strong>{{ $catalogue->activite_secondaire }}</strong></p>
                <p>{{ $catalogue->desc_activite_secondaire }}</p>
            </div>
            
            @if($catalogue->autres)
                <div class="activity-section">
                    <h4>Autres informations</h4>
                    <p>{{ $catalogue->autres }}</p>
                </div>
            @endif
            
          
            <div class="activity-section">
                <h4>Informations complémentaires</h4>
                <p>
                    <i class="fas fa-calendar-alt"></i>
                    <strong>Date de publication :</strong> 
                    {{ \Carbon\Carbon::parse($catalogue->created_at)->locale('fr')->format('d F Y') }}
                </p>
            </div>-->
        </div>
    </div>
</div>

<!-- Lien vers Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

@endsection