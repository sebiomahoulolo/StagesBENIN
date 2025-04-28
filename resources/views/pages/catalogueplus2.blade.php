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
        background-color: rgba(255, 255, 255, 0.9);
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
    
    /* Style pour le compteur de visites */
    .visit-counter {
        position: absolute;
        top: 20px;
        right: 20px;
        color: #333;
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
        color: #333;
        background-color: rgba(255, 255, 255, 0.9);
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
        color: #333;
        background-color: rgba(255, 255, 255, 0.9);
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
        color: #333;
        background-color: rgba(255, 255, 255, 0.9);
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
        color: #333;
        background-color: rgba(255, 255, 255, 0.9);
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
        border-bottom: 2px rgba(255, 255, 255, 0.9);
        padding-bottom: 10px;
    }
    
    .module-list {
        list-style-type: none;
        padding: 0;
    }
    
    .module-list li {
        padding: 8px 0;
        border-bottom: 1px dashed rgba(234, 93, 93, 0.9);
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
    
    /* Styles pour le formulaire de contact */
    .form-container {
        max-width: 600px;
        margin: 2rem auto;
        padding: 2rem;
        background-color: #f8f9fa;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    
    .form-title {
        font-size: 1.5rem;
        margin-bottom: 1rem;
        text-align: center;
        color: #343a40;
    }
    
    .form-group .form-label {
        font-weight: bold;
    }
    
    .btn-submit {
        width: 100%;
        font-size: 1rem;
        padding: 0.75rem;
        border-radius: 5px;
    }
    
    /* Style pour le bouton email */
    .email-button {
        margin-top: 15px;
        margin-bottom: 15px;
    }
</style>

@php
    // Récupération des événements publiés uniquement
    $upcomingEvents = App\Models\Event::where('is_published', 1)
                                     ->where('start_date', '>', now())
                                     ->orderBy('start_date', 'asc')
                                     ->take(6)
                                     ->get();

    $ongoingEvents = App\Models\Event::where('is_published', 1)
                                    ->where('start_date', '<=', now())
                                    ->where('end_date', '>=', now())
                                    ->orderBy('end_date', 'asc')
                                    ->take(6)
                                    ->get();

    $pastEvents = App\Models\Event::where('is_published', 1)
                                 ->where('end_date', '<', now())
                                 ->orderBy('end_date', 'desc')
                                 ->take(6)
                                 ->get();

    $formatDate = function($date, $format = 'd/m/Y à H:i') {
        return \Carbon\Carbon::parse($date)->locale('fr')->isoFormat($format);
    };
@endphp

<div class="container mt-4">  
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
            <h1>{{ $catalogue->titre }}</h1>
            <div class="row">
                <div class="col-md-8">
                    <h5>{{ $catalogue->slogan ?? 'Votre partenaire de confiance' }}</h5>
                    <p>{{ $catalogue->description }}</p>
                </div>
            </div>
            
            <div class="email-button">
                <a href="mailto:contact@stagesbenin.com" class="btn btn-primary">Envoyer un email</a>
            </div>
            
            <!-- Informations de contact alignées horizontalement -->
            <div class="row mt-4 info-cards-container">
                <div class="col-lg-3 col-md-6 mb-3 info-card-wrapper">
                    <div class="info-card logo-card">
                        <img src="{{ asset('assets/images/formations/' . $catalogue->logo) }}" alt="Logo">
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
                        <i class="fas fa-globe"></i>
                        <p><strong>Site Web :</strong> 
                            @if($catalogue->site_web)
                                <a href="{{ $catalogue->site_web }}" target="_blank">{{ $catalogue->site_web }}</a>
                            @else
                                <a href="https://stagesbenin.com/" target="_blank">Visiter</a>
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
                        
                        <p><strong>{{ $catalogue->activite_principale }}</strong></p>
                        <p>{{ $catalogue->desc_activite_principale }}</p>
                    </div>
                    
                    @if($catalogue->activite_secondaire)
                        <div class="activity-section">
                            <h4>Activité secondaire</h4>
                            <p><strong>{{ $catalogue->activite_secondaire }}</strong></p>
                            <p>{{ $catalogue->desc_activite_secondaire }}</p>
                        </div>
                    @endif
                    
                    @if($catalogue->autres)
                        <div class="activity-section">
                            <h4>Autres informations</h4>
                            <p>{{ $catalogue->autres }}</p>
                           
                                <i class="fas fa-calendar-alt"></i>
                                <strong>Date de publication :</strong> 
                                {{ \Carbon\Carbon::parse($catalogue->created_at)->locale('fr')->format('d F Y') }}
                        
                        </div>
                    @endif
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
                    <!-- Section Événements à venir -->
                    <div class="events-section events-upcoming fade-in">
                        <h4 class="mb-3"><i class="fas fa-calendar-check"></i> Événements à venir ({{ $upcomingEvents->count() }})</h4>
                        
                        @forelse ($upcomingEvents as $event)
                            <div class="event-card">
                                <div>
                                    <h5 class="event-title">{{ $event->title }}</h5>
                                    <div class="event-details">
                                        <div class="event-detail"><i class="fas fa-clock"></i> Début : {{ $formatDate($event->start_date, 'LLLL') }}</div>
                                        @if($event->end_date)
                                            <div class="event-detail"><i class="fas fa-clock"></i> Fin : {{ $formatDate($event->end_date, 'LLLL') }}</div>
                                        @endif
                                        <div class="event-detail"><i class="fas fa-tag"></i> Catégorie : {{ $event->type ?? 'Non classé' }}</div>
                                        @if(isset($event->location) && $event->location)
                                            <div class="event-detail"><i class="fas fa-map-marker-alt"></i> Lieu : {{ $event->location }}</div>
                                        @endif
                                        <div class="event-detail">
                                            <i class="fas fa-hourglass-start"></i> Statut :
                                            @php $daysUntil = now()->diffInDays(\Carbon\Carbon::parse($event->start_date), false); @endphp
                                            @if($daysUntil == 0)
                                                <span class="badge bg-warning">Aujourd'hui</span>
                                            @elseif($daysUntil == 1)
                                                <span class="badge bg-warning">Demain</span>
                                            @elseif($daysUntil > 1)
                                                <span class="badge bg-info">Dans {{ $daysUntil }} jours</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Actions -->
                                <div class="event-actions mt-3">
                                    <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#detailsModal"
                                        data-event-id="{{ $event->id }}"
                                        data-title="{{ $event->title }}"
                                        data-start-date="{{ $formatDate($event->start_date, 'LLLL') }}"
                                        data-end-date="{{ $event->end_date ? $formatDate($event->end_date, 'LLLL') : 'Non spécifiée' }}"
                                        data-location="{{ $event->location }}"
                                        data-category="{{ $event->categorie ?? 'Non classé' }}"
                                        data-description="{{ $event->description }}">
                                        <i class="fas fa-eye"></i> Détails
                                    </button>
                                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#registerModal"
                                        data-event-id="{{ $event->id }}">
                                        <i class="fas fa-edit"></i> S'inscrire
                                    </button>
                                </div>
                            </div>
                        @empty
                            <div class="alert alert-info" role="alert">
                                <i class="fas fa-info-circle me-2"></i> Aucun événement à venir pour le moment.
                            </div>
                        @endforelse
                    </div>
                </div>
                
                <!-- Onglet Avis -->
                <div class="tab-pane fade" id="avis" role="tabpanel" aria-labelledby="avis-tab">
<div class="container mt-5">
    <div class="row g-5">
        <!-- Formulaire d'Avis -->
        <div class="col-md-6">
            <div class="avis-form-container p-4 bg-light rounded shadow-sm">
                <h4 class="mb-3">Votre Avis compte pour nous</h4>
                <form>
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

                    <button type="submit" class="btn btn-primary w-100">Soumettre</button>
                </form>
            </div>
        </div>

        <!-- Liste des Avis -->
        <div class="col-md-6">
            <div class="avis-list-container p-4 bg-light rounded shadow-sm">
                <h4 class="mb-3">Avis des utilisateurs</h4>
                @if(isset($avis) && count($avis) > 0)
                    @foreach($avis as $item)
                        <div class="avis-item mb-3 p-3 bg-white rounded shadow-sm">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="avis-author fw-bold">{{ $item->nom }}</span>
                                <span class="avis-date text-muted">{{ $item->created_at->locale('fr')->diffForHumans() }}</span>
                            </div>
                            <div class="avis-rating">
                                Note : 
                                @for ($i = 1; $i <= 5; $i++)
                                    @if ($i <= $item->note)
                                        <i class="fas fa-star text-warning"></i>
                                    @else
                                        <i class="far fa-star text-muted"></i>
                                    @endif
                                @endfor
                            </div>
                            <p class="avis-commentaire mt-2">{{ $item->commentaire }}</p>
                        </div>
                    @endforeach
                @else
                    <div class="alert alert-info" role="alert">
                        Aucun avis n'a été laissé pour le moment. Soyez le premier à donner votre avis !
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

    </div>
<div class="container mt-5">
    <div class="row g-5">
        <!-- Section Offres -->
        <div class="col-md-6">
            <div class="p-4 bg-light rounded shadow-sm">
                <h3 class="mb-4" style="color: #007bff;"><i class="fas fa-briefcase me-2"></i> Offres de stages et d'emplois</h3>
                @if(isset($offres) && count($offres) > 0)
                    <div class="row g-4">
                        @foreach($offres as $offre)
                            <div class="col-12">
                                <div class="card border-0 shadow-sm">
                                    <div class="card-header bg-primary text-white">
                                        <h5 class="mb-0">{{ $offre->titre }}</h5>
                                    </div>
                                    <div class="card-body">
                                        <p>{{ Str::limit($offre->description, 120) }}</p>
                                        <ul class="list-unstyled">
                                            <li><i class="fas fa-map-marker-alt text-primary me-2"></i>{{ $offre->lieu }}</li>
                                            <li><i class="fas fa-clock text-primary me-2"></i>{{ $offre->type }}</li>
                                            <li><i class="fas fa-calendar-times text-danger me-2"></i>Limite: {{ \Carbon\Carbon::parse($offre->date_limite)->locale('fr')->isoFormat('LL') }}</li>
                                        </ul>
                                    </div>
                                    <div class="card-footer bg-light text-center">
                                        <a href="#" class="btn btn-outline-primary btn-sm">Voir l'offre</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="alert alert-light text-center" role="alert">
                        <i class="fas fa-info-circle me-2"></i> Aucune offre n'est disponible pour le moment.
                    </div>
                @endif
                @if(isset($offres) && count($offres) > 0)
                <div class="mt-3 text-center">
                    <a href="#" class="btn btn-primary">Voir toutes les offres</a>
                </div>
                @endif
            </div>
        </div>

        <!-- Section Formulaire -->
        <div class="col-md-6">
            <div class="form-container p-4 bg-light rounded shadow-sm">
                <h3 class="mb-4" style="color: #007bff;">Facture Pro-forma</h3>
                <form class="row g-3">
                    <div class="form-group col-12">
                        <label for="objet" class="form-label">Objet</label>
                        <select id="objet" class="form-select" required>
                            <option value="Demander un Devis">Demander un Devis</option>
                            <option value="Demande d'informations">Demande d'informations</option>
                            <option value="Demander de rendez-vous">Demander de rendez-vous</option>
                        </select>
                    </div>
                    <!-- Nom -->
                    <div class="form-group col-md-6">
                        <label for="nom" class="form-label">Nom</label>
                        <input type="text" class="form-control" id="nom" placeholder="Nom" required>
                    </div>
                    <!-- Prénom -->
                    <div class="form-group col-md-6">
                        <label for="prenom" class="form-label">Prénom</label>
                        <input type="text" class="form-control" id="prenom" placeholder="Prénom" required>
                    </div>
                    <!-- Email -->
                    <div class="form-group col-12">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" placeholder="Email" required>
                    </div>
                    <!-- Téléphone -->
                    <div class="form-group col-12">
                        <label for="telephone" class="form-label">Téléphone</label>
                        <input type="tel" class="form-control" id="telephone" placeholder="Téléphone" required>
                    </div>
                    <!-- Message -->
                    <div class="form-group col-12">
                        <label for="message" class="form-label">Message</label>
                        <textarea id="message" class="form-control" rows="4" placeholder="Message"></textarea>
                    </div>
                    <!-- Soumettre -->
                    <div class="form-group col-12">
                        <button type="submit" class="btn btn-primary btn-submit w-100">
                            <i class="fas fa-paper-plane"></i> Envoyer
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

    
</div>
<!-- Modals pour les événements -->
<!-- Modal de détails d'événement -->
<div class="modal fade" id="detailsModal" tabindex="-1" aria-labelledby="detailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailsModalLabel">Détails de l'événement</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h5 id="modalEventTitle" class="text-primary"></h5>
                
                <div class="mt-3">
                    <p><i class="fas fa-calendar-alt me-2"></i> <strong>Date de début:</strong> <span id="modalEventStartDate"></span></p>
                    <p><i class="fas fa-calendar-check me-2"></i> <strong>Date de fin:</strong> <span id="modalEventEndDate"></span></p>
                    <p><i class="fas fa-map-marker-alt me-2"></i> <strong>Lieu:</strong> <span id="modalEventLocation"></span></p>
                    <p><i class="fas fa-tag me-2"></i> <strong>Catégorie:</strong> <span id="modalEventCategory"></span></p>
                </div>
                
                <div class="mt-4">
                    <h6>Description</h6>
                    <p id="modalEventDescription"></p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#registerModal" id="registerFromDetailsBtn">S'inscrire</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal d'inscription à un événement -->
<div class="modal fade" id="registerModal" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="registerModalLabel">Inscription à l'événement</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="eventRegistrationForm">
                    <input type="hidden" id="eventId" name="event_id">
                    
                    <div class="mb-3">
                        <label for="registerName" class="form-label">Nom complet</label>
                        <input type="text" class="form-control" id="registerName" name="name" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="registerEmail" class="form-label">Email</label>
                        <input type="email" class="form-control" id="registerEmail" name="email" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="registerPhone" class="form-label">Téléphone</label>
                        <input type="tel" class="form-control" id="registerPhone" name="phone" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="registerMessage" class="form-label">Message (facultatif)</label>
                        <textarea class="form-control" id="registerMessage" name="message" rows="3"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <button type="button" class="btn btn-primary" id="submitRegistration">Confirmer l'inscription</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal de confirmation -->
<div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmationModalLabel">Inscription confirmée</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="text-center">
                    <i class="fas fa-check-circle text-success fa-4x mb-3"></i>
                    <p>Votre inscription a été enregistrée avec succès. Vous recevrez un email de confirmation prochainement.</p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">OK</button>
            </div>
        </div>
    </div>
    
</div>

<!-- Scripts spécifiques à la page -->
<script>
    // Initialisation de la carte Google Maps
    function initMap() {
        const location = { lat: 6.4158, lng: 2.3324 }; // Coordonnées d'Abomey-Calavi
        const map = new google.maps.Map(document.getElementById("map"), {
            zoom: 15,
            center: location,
        });
        const marker = new google.maps.Marker({
            position: location,
            map: map,
            title: "{{ $catalogue->titre }}",
        });
    }

    document.addEventListener('DOMContentLoaded', function() {
        // Gestion du modal de détails
        const detailsModal = document.getElementById('detailsModal');
        if (detailsModal) {
            detailsModal.addEventListener('show.bs.modal', function (event) {
                const button = event.relatedTarget;
                const eventId = button.getAttribute('data-event-id');
                const title = button.getAttribute('data-title');
                const startDate = button.getAttribute('data-start-date');
                const endDate = button.getAttribute('data-end-date');
                const location = button.getAttribute('data-location');
                const category = button.getAttribute('data-category');
                const description = button.getAttribute('data-description');
                
                document.getElementById('modalEventTitle').textContent = title;
                document.getElementById('modalEventStartDate').textContent = startDate;
                document.getElementById('modalEventEndDate').textContent = endDate;
                document.getElementById('modalEventLocation').textContent = location || 'Non spécifié';
                document.getElementById('modalEventCategory').textContent = category;
                document.getElementById('modalEventDescription').textContent = description || 'Aucune description disponible';
                
                // Préparer le bouton d'inscription
                document.getElementById('registerFromDetailsBtn').setAttribute('data-event-id', eventId);
            });
        }
        
        // Gestion du modal d'inscription
        const registerModal = document.getElementById('registerModal');
        if (registerModal) {
            registerModal.addEventListener('show.bs.modal', function (event) {
                const button = event.relatedTarget;
                const eventId = button.getAttribute('data-event-id');
                document.getElementById('eventId').value = eventId;
            });
        }
        
        // Traitement du formulaire d'inscription
        const submitRegistrationBtn = document.getElementById('submitRegistration');
        if (submitRegistrationBtn) {
            submitRegistrationBtn.addEventListener('click', function() {
                const form = document.getElementById('eventRegistrationForm');
                if (form.checkValidity()) {
                    // Ici, vous pourriez ajouter l'AJAX pour envoyer le formulaire
                    // Pour l'exemple, on affiche simplement le modal de confirmation
                    const registerModalInstance = bootstrap.Modal.getInstance(registerModal);
                    registerModalInstance.hide();
                    
                    setTimeout(() => {
                        const confirmationModal = new bootstrap.Modal(document.getElementById('confirmationModal'));
                        confirmationModal.show();
                    }, 500);
                } else {
                    form.reportValidity();
                }
            });
        }
        
        // Gestion des avis
        const avisForm = document.querySelector('.avis-form form');
        if (avisForm) {
            avisForm.addEventListener('submit', function(e) {
                e.preventDefault();
                // Ici vous pourriez ajouter l'AJAX pour envoyer l'avis
                alert('Merci pour votre avis! Il sera bientôt publié après modération.');
                this.reset();
            });
        }
    });
</script>

<!-- Script Google Maps -->
<script async defer
    src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&callback=initMap">
</script>

@endsection
