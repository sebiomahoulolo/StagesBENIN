@extends('layouts.layout')

@section('title', 'StagesBENIN - Détails Entreprise')

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
    
    /* Nouvelle section de coordonnées */
    .coordonnees-section {
        background-color: #f8f9fa;
        border-radius: 10px;
        padding: 20px;
        margin-top: 30px;
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
    }
    
    /* Style pour la carte */
    #map {
        width: 100%;
        height: 300px;
        border-radius: 10px;
        margin-top: 15px;
    }
    
    /* Galerie photos et vidéos */
    .gallery-container {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 15px;
        margin-top: 20px;
    }
    
    .gallery-item {
        position: relative;
        overflow: hidden;
        border-radius: 8px;
        height: 150px;
        transition: transform 0.3s;
    }
    
    .gallery-item:hover {
        transform: scale(1.05);
    }
    
    .gallery-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .video-container {
        position: relative;
        width: 100%;
        padding-top: 56.25%; /* 16:9 Aspect Ratio */
        margin-top: 20px;
    }
    
    .video-container iframe {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        border-radius: 10px;
    }
    
    /* Formulaire d'avis */
    .avis-form {
        background-color: #f8f9fa;
        padding: 20px;
        border-radius: 10px;
        margin-top: 30px;
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
    }
    
    .rating {
        display: flex;
        flex-direction: row-reverse;
        justify-content: flex-end;
    }
    
    .rating > input {
        display: none;
    }
    
    .rating > label {
        position: relative;
        width: 1.1em;
        font-size: 2em;
        color: #FFD700;
        cursor: pointer;
    }
    
    .rating > label::before {
        content: "\2605";
        position: absolute;
        opacity: 0;
    }
    
    .rating > label:hover:before,
    .rating > label:hover ~ label:before {
        opacity: 1 !important;
    }
    
    .rating > input:checked ~ label:before {
        opacity: 1;
    }
    
    /* Section événements */
    .event-card {
        background-color: white;
        border-radius: 10px;
        padding: 15px;
        margin-bottom: 20px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        border-left: 4px solid #0056b3;
    }
    
    .event-card h5 {
        color: #0056b3;
        margin-bottom: 10px;
    }
    
    .event-details {
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
        margin-top: 10px;
    }
    
    .event-detail {
        display: flex;
        align-items: center;
    }
    
    .event-detail i {
        margin-right: 8px;
        color: #0056b3;
    }
    
    /* Tab navigation */
    .nav-tabs {
        border-bottom: 2px solid #007bff;
        margin-bottom: 20px;
    }
    
    .nav-tabs .nav-item .nav-link {
        border: none;
        color: #495057;
        font-weight: 600;
        padding: 10px 20px;
        transition: color 0.3s;
    }
    
    .nav-tabs .nav-item .nav-link.active {
        border: none;
        color: #007bff;
        background-color: transparent;
        border-bottom: 3px solid #007bff;
    }
    
    .nav-tabs .nav-item .nav-link:hover {
        border-color: transparent;
        color: #007bff;
    }
    
    .tab-content {
        padding: 20px 0;
    }
    
    /* Formation cards */
    .formation-card {
        background-color: white;
        border-radius: 10px;
        padding: 20px;
        margin-bottom: 20px;
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s;
    }
    
    .formation-card:hover {
        transform: translateY(-5px);
    }
    
    .formation-card h5 {
        color: #0056b3;
        margin-bottom: 15px;
        border-bottom: 2px solid #f0f0f0;
        padding-bottom: 10px;
    }
    
    .module-list {
        list-style-type: none;
        padding: 0;
    }
    
    .module-list li {
        padding: 8px 0;
        border-bottom: 1px dashed #f0f0f0;
    }
    
    .module-list li:last-child {
        border-bottom: none;
    }
    
    .module-list li i {
        color: #0056b3;
        margin-right: 10px;
    }
    
    /* Style pour les avis existants */
    .avis-container {
        margin-top: 30px;
    }
    
    .avis-item {
        background-color: white;
        border-radius: 10px;
        padding: 15px;
        margin-bottom: 15px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }
    
    .avis-header {
        display: flex;
        justify-content: space-between;
        margin-bottom: 10px;
    }
    
    .avis-author {
        font-weight: 600;
        color: #333;
    }
    
    .avis-date {
        color: #777;
        font-size: 0.9em;
    }
    
    .avis-stars {
        color: #FFD700;
        margin-bottom: 10px;
    }
    
    .avis-content {
        color: #555;
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
        .gallery-container {
            grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
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
        .gallery-container {
            grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
        }
    }
</style>

<div class="container mt-4">
    <a href="{{ route('entreprises.index') }}" class="btn-retour mb-4">
        <i class="fas fa-arrow-left"></i> Retour à la liste
    </a>
    
    <div class="card-custom">
        @if($entreprise->image)
            <img src="{{ asset('images/entreprises/' . $entreprise->image) }}" alt="Background" class="bg-image">
        @endif
        
        <!-- Compteur de visites -->
        <div class="visit-counter">
            <i class="fas fa-eye"></i>
            <span>{{ $entreprise->views ?? 102 }} visites</span>
        </div>
        
        <div class="card-content">
            <h1>{{ $entreprise->titre }}</h1>
            <div class="row">
                <div class="col-md-8">
                    <h5>{{ $entreprise->slogan ?? 'Votre partenaire de confiance' }}</h5>
                    <p>{{ $entreprise->description }}</p>
                </div>
            </div>
            
            <!-- Informations de contact alignées horizontalement -->
            <div class="row mt-4 info-cards-container">
                <div class="col-lg-3 col-md-6 mb-3 info-card-wrapper">
                    <div class="info-card logo-card">
                        @if($entreprise->logo)
                            <img src="{{ asset('images/entreprises/' . $entreprise->logo) }}" alt="Logo">
                        @else
                            <img src="{{ asset('images/default-logo.png') }}" alt="Logo par défaut">
                        @endif
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-3 info-card-wrapper">
                    <div class="info-card">
                        <i class="fas fa-briefcase"></i>
                        <p><strong>Activité principale :</strong> {{ $entreprise->activite_principale }}</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-3 info-card-wrapper">
                    <div class="info-card">
                        <i class="fas fa-map-marker-alt"></i>
                        <p><strong>Localisation :</strong> {{ $entreprise->localisation }}</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-3 info-card-wrapper">
                    <div class="info-card">
                        <i class="fas fa-globe"></i>
                        <p><strong>Site Web :</strong> 
                            @if($entreprise->site_web)
                                <a href="{{ $entreprise->site_web }}" target="_blank">{{ $entreprise->site_web }}</a>
                            @else
                                Non disponible
                            @endif
                        </p>
                    </div>
                </div>
            </div>
            
            <!-- Navigation par onglets -->
            <ul class="nav nav-tabs mt-5" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="activites-tab" data-bs-toggle="tab" data-bs-target="#activites" type="button" role="tab" aria-controls="activites" aria-selected="true">
                        <i class="fas fa-briefcase"></i> Activités
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="coordonnees-tab" data-bs-toggle="tab" data-bs-target="#coordonnees" type="button" role="tab" aria-controls="coordonnees" aria-selected="false">
                        <i class="fas fa-map-marker-alt"></i> Coordonnées
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="formations-tab" data-bs-toggle="tab" data-bs-target="#formations" type="button" role="tab" aria-controls="formations" aria-selected="false">
                        <i class="fas fa-graduation-cap"></i> Formations
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="galerie-tab" data-bs-toggle="tab" data-bs-target="#galerie" type="button" role="tab" aria-controls="galerie" aria-selected="false">
                        <i class="fas fa-images"></i> Galerie
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="evenements-tab" data-bs-toggle="tab" data-bs-target="#evenements" type="button" role="tab" aria-controls="evenements" aria-selected="false">
                        <i class="fas fa-calendar-alt"></i> Événements
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="avis-tab" data-bs-toggle="tab" data-bs-target="#avis" type="button" role="tab" aria-controls="avis" aria-selected="false">
                        <i class="fas fa-star"></i> Avis
                    </button>
                </li>
            </ul>
            
            <!-- Contenu des onglets -->
            <div class="tab-content" id="myTabContent">
                <!-- Onglet Activités -->
                <div class="tab-pane fade show active" id="activites" role="tabpanel" aria-labelledby="activites-tab">
                    <div class="activity-section">
                        <h4>Activité principale</h4>
                        <p><strong>{{ $entreprise->activite_principale }}</strong></p>
                        <p>{{ $entreprise->desc_activite_principale }}</p>
                    </div>
                    
                    @if($entreprise->activite_secondaire)
                        <div class="activity-section">
                            <h4>Activité secondaire</h4>
                            <p><strong>{{ $entreprise->activite_secondaire }}</strong></p>
                            <p>{{ $entreprise->desc_activite_secondaire }}</p>
                        </div>
                    @endif
                    
                    @if($entreprise->autres)
                        <div class="activity-section">
                            <h4>Autres informations</h4>
                            <p>{{ $entreprise->autres }}</p>
                        </div>
                    @endif
                    
                    <div class="activity-section">
                        <h4>Informations complémentaires</h4>
                        <p>
                            <i class="fas fa-calendar-alt"></i>
                            <strong>Date de publication :</strong> 
                            {{ \Carbon\Carbon::parse($entreprise->created_at)->locale('fr')->format('d F Y') }}
                        </p>
                    </div>
                </div>
                
                <!-- Onglet Coordonnées -->
                <div class="tab-pane fade" id="coordonnees" role="tabpanel" aria-labelledby="coordonnees-tab">
                    <div class="coordonnees-section">
                        <h4><i class="fas fa-map-marked-alt"></i> Adresse</h4>
                        <p>Bidiossessi, immeuble en face de PADME<br>Abomey-Calavi - Bénin</p>
                        
                        <h4 class="mt-4"><i class="fas fa-phone-alt"></i> Contact</h4>
                        <p>
                            <i class="fab fa-whatsapp"></i> +229 41 73 31 75 (Whatsapp)<br>
                            <i class="fas fa-phone"></i> +229 66 69 39 56
                        </p>
                        
                        <h4 class="mt-4"><i class="fas fa-envelope"></i> Email</h4>
                        <p>contact@stagesbenin.com</p>
                        
                        <h4 class="mt-4"><i class="fas fa-map-location-dot"></i> Localisation</h4>
                        <!-- Carte Google Maps -->
                        <div id="map"></div>
                    </div>
                </div>
                
                <!-- Onglet Formations -->
                <div class="tab-pane fade" id="formations" role="tabpanel" aria-labelledby="formations-tab">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="formation-card">
                                <h5>Développement Web</h5>
                                <p>Formation complète pour devenir développeur web professionnel.</p>
                                <h6 class="mt-4 mb-3">Modules :</h6>
                                <ul class="module-list">
                                    <li><i class="fas fa-check-circle"></i> HTML5 et CSS3</li>
                                    <li><i class="fas fa-check-circle"></i> JavaScript et jQuery</li>
                                    <li><i class="fas fa-check-circle"></i> PHP et MySQL</li>
                                    <li><i class="fas fa-check-circle"></i> Laravel Framework</li>
                                    <li><i class="fas fa-check-circle"></i> Projet professionnel</li>
                                </ul>
                                <div class="mt-3">
                                    <a href="#" class="btn btn-primary">En savoir plus</a>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="formation-card">
                                <h5>Marketing Digital</h5>
                                <p>Maîtrisez les stratégies de marketing digital pour développer votre activité en ligne.</p>
                                <h6 class="mt-4 mb-3">Modules :</h6>
                                <ul class="module-list">
                                    <li><i class="fas fa-check-circle"></i> SEO et référencement</li>
                                    <li><i class="fas fa-check-circle"></i> Social Media Marketing</li>
                                    <li><i class="fas fa-check-circle"></i> Email Marketing</li>
                                    <li><i class="fas fa-check-circle"></i> Google Ads et Facebook Ads</li>
                                    <li><i class="fas fa-check-circle"></i> Analyse et reporting</li>
                                </ul>
                                <div class="mt-3">
                                    <a href="#" class="btn btn-primary">En savoir plus</a>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="formation-card">
                                <h5>Infographie et Design</h5>
                                <p>Apprenez à créer des designs professionnels pour le web et l'impression.</p>
                                <h6 class="mt-4 mb-3">Modules :</h6>
                                <ul class="module-list">
                                    <li><i class="fas fa-check-circle"></i> Photoshop</li>
                                    <li><i class="fas fa-check-circle"></i> Illustrator</li>
                                    <li><i class="fas fa-check-circle"></i> InDesign</li>
                                    <li><i class="fas fa-check-circle"></i> UX/UI Design</li>
                                    <li><i class="fas fa-check-circle"></i> Portfolio professionnel</li>
                                </ul>
                                <div class="mt-3">
                                    <a href="#" class="btn btn-primary">En savoir plus</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Onglet Galerie -->
                <div class="tab-pane fade" id="galerie" role="tabpanel" aria-labelledby="galerie-tab">
                    <h4 class="mb-3">Photos et images</h4>
                    <div class="gallery-container">
                        @for ($i = 1; $i <= 6; $i++)
                            <div class="gallery-item">
                                <img src="{{ asset('images/placeholder-gallery-' . $i . '.jpg') }}" alt="Image {{ $i }}">
                            </div>
                        @endfor
                    </div>
                    
                    <h4 class="mb-3 mt-5">Nos Vidéos</h4>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="video-container">
                                <iframe src="https://www.youtube.com/embed/dQw4w9WgXcQ" title="Vidéo de présentation" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="video-container">
                                <iframe src="https://www.youtube.com/embed/dQw4w9WgXcQ" title="Formation en direct" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Onglet Événements -->
                <div class="tab-pane fade" id="evenements" role="tabpanel" aria-labelledby="evenements-tab">
                    <h4 class="mb-4">Événements en Cours</h4>
                    
                    <div class="event-card">
                        <h5>Aucun événement en cours</h5>
                        <p>Il n'y a actuellement aucun événement programmé. Revenez bientôt pour découvrir nos prochains événements.</p>
                        
                        <!-- Template pour événement futur -->
                        <!--
                        <div class="event-details">
                            <div class="event-detail">
                                <i class="fas fa-map-marker-alt"></i>
                                <span>Lieu de l'événement</span>
                            </div>
                            <div class="event-detail">
                                <i class="fas fa-calendar-day"></i>
                                <span>Date de début</span>
                            </div>
                            <div class="event-detail">
                                <i class="fas fa-phone-alt"></i>
                                <span>Contact pour information</span>
                            </div>
                        </div>
                        -->
                    </div>
                </div>
                
                <!-- Onglet Avis -->
                <div class="tab-pane fade" id="avis" role="tabpanel" aria-labelledby="avis-tab">
                    <h4 class="mb-3">Votre Avis compte pour nous</h4>
                    
                    <!-- Formulaire d'avis -->
                    <div class="avis-form">
                        <form action="{{ route('avis.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="entreprise_id" value="{{ $entreprise->id }}">
                            
                            <div class="mb-3">
                                <label for="nom" class="form-label">Nom</label>
                                <input type="text" class="form-control" id="nom" name="nom" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Note</label>
                                <div class="rating">
                                    <input type="radio" name="rating" value="5" id="star5"><label for="star5"></label>
                                    <input type="radio" name="rating" value="4" id="star4"><label for="star4"></label>
                                    <input type="radio" name="rating" value="3" id="star3"><label for="star3"></label>
                                    <input type="radio" name="rating" value="2" id="star2"><label for="star2"></label>
                                    <input type="radio" name="rating" value="1" id="star1"><label for="star1"></label>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="commentaire" class="form-label">Votre commentaire</label>
                                <textarea class="form-control" id="commentaire" name="commentaire" rows="4" required></textarea>
                            </div>
                            
                            <button type="submit" class="btn btn-primary">Soumettre</button>
                        </form>
                    </div>