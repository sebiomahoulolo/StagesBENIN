@extends('layouts.app')

@section('content')

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StagesBENIN</title>
    <style>
        :root {
            --primary-color: #3498db;
            --secondary-color: #2c3e50;
            --accent-color: #e74c3c;
            --success-color: #2ecc71;
            --warning-color: #f39c12;
            --light-gray: #f5f7fa;
            --gray: #95a5a6;
            --dark-gray: #7f8c8d;
        }
        
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background-color: #f9f9f9;
        }
        
        header {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .logo {
            font-size: 1.8rem;
            font-weight: bold;
            display: flex;
            align-items: center;
        }
        
        .logo i {
            margin-right: 10px;
        }
        
        .header-actions {
            display: flex;
            align-items: center;
        }
        
        .profile-menu {
            margin-left: 1rem;
            position: relative;
            cursor: pointer;
        }
        
        .profile-image {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: white;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .container {
            display: flex;
        }
        
        .sidebar {
            width: 250px;
            background-color: white;
            min-height: calc(100vh - 70px);
            box-shadow: 2px 0 10px rgba(0,0,0,0.05);
            z-index: 10;
        }
        
        .sidebar-menu {
            padding: 1rem 0;
        }
        
        .menu-item {
            padding: 0.8rem 1.5rem;
            display: flex;
            align-items: center;
            color: var(--dark-gray);
            text-decoration: none;
            transition: all 0.3s;
            font-size: 0.95rem;
        }
        
        .menu-item i {
            margin-right: 10px;
            width: 20px;
            text-align: center;
        }
        
        .menu-item:hover, .menu-item.active {
            background-color: rgba(52, 152, 219, 0.1);
            color: var(--primary-color);
            border-left: 3px solid var(--primary-color);
        }
        
        .menu-item.active {
            font-weight: bold;
        }
        
        .main-content {
            flex: 1;
            padding: 2rem;
        }
        
        .dashboard-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }
        
        .welcome-message h1 {
            font-size: 1.8rem;
            color: var(--secondary-color);
            margin-bottom: 0.5rem;
        }
        
        .welcome-message p {
            color: var(--gray);
        }
        
        .quick-actions {
            display: flex;
            gap: 1rem;
        }
        
        .action-button {
            padding: 0.7rem 1.5rem;
            background-color: var(--primary-color);
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            display: flex;
            align-items: center;
            transition: all 0.3s;
        }
        
        .action-button:hover {
            background-color: #2980b9;
            transform: translateY(-2px);
        }
        
        .action-button i {
            margin-right: 8px;
        }
        
        .dashboard-cards {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }
        
        .card {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            padding: 1.5rem;
            transition: all 0.3s;
        }
        
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.1);
        }
        
        .card-header {
            display: flex;
            align-items: center;
            margin-bottom: 1rem;
        }
        
        .card-header i {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: rgba(52, 152, 219, 0.1);
            color: var(--primary-color);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            margin-right: 1rem;
        }
        
        .card-title {
            font-size: 1.1rem;
            color: var(--secondary-color);
            font-weight: bold;
        }
        
        .card-content {
            color: var(--dark-gray);
        }
        
        .recent-activity, .upcoming-events {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            padding: 1.5rem;
            margin-bottom: 1.5rem;
        }
        
        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }
        
        .section-title {
            font-size: 1.2rem;
            color: var(--secondary-color);
            font-weight: bold;
        }
        
        .view-all {
            color: var(--primary-color);
            font-size: 0.9rem;
            text-decoration: none;
        }
        
        .activity-list, .event-list {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }
        
        .activity-item, .event-item {
            display: flex;
            padding: 1rem;
            border-radius: 6px;
            background-color: var(--light-gray);
        }
        
        .activity-icon, .event-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: rgba(52, 152, 219, 0.1);
            color: var(--primary-color);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            margin-right: 1rem;
        }
        
        .activity-details, .event-details {
            flex: 1;
        }
        
        .activity-title, .event-title {
            font-weight: bold;
            margin-bottom: 0.3rem;
            color: var(--secondary-color);
        }
        
        .activity-time, .event-time {
            font-size: 0.85rem;
            color: var(--dark-gray);
        }
        
        .event-date {
            font-size: 0.85rem;
            color: var(--accent-color);
            font-weight: bold;
        }
        
        .notifications-badge {
            background-color: var(--accent-color);
            color: white;
            border-radius: 50%;
            padding: 2px 6px;
            font-size: 0.7rem;
            margin-left: 5px;
        }
        
        .chart-container {
            width: 100%;
            height: 300px;
            margin-top: 1rem;
            background-color: #f5f5f5;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        @media (max-width: 1024px) {
            .dashboard-cards {
                grid-template-columns: repeat(2, 1fr);
            }
        }
        
        @media (max-width: 768px) {
            .container {
                flex-direction: column;
            }
            
            .sidebar {
                width: 100%;
                min-height: auto;
            }
            
            .dashboard-cards {
                grid-template-columns: 1fr;
            }
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <header>
        <div class="logo">
            <i class="fas fa-briefcase"></i>
            <span>CarrièrePro</span>
        </div>
        <div class="header-actions">
            <div class="notifications">
                <i class="fas fa-bell"></i>
                <span class="notifications-badge">3</span>
            </div>
            <div class="profile-menu">
                <div class="profile-image">
                    <i class="fas fa-user"></i>
                </div>
            </div>
        </div>
    </header>
    
    <div class="container">
        <aside class="sidebar">
            <nav class="sidebar-menu">
                <a href="#" class="menu-item active">
                    <i class="fas fa-home"></i>
                    <span>Tableau de bord</span>
                </a>
                <a href="#" class="menu-item">
                    <i class="fas fa-newspaper"></i>
                    <span>Actualités</span>
                </a>
                <a href="#" class="menu-item">
                    <i class="fas fa-database"></i>
                    <span>CV-thèque</span>
                </a>
                <a href="#" class="menu-item">
                    <i class="fas fa-file-alt"></i>
                    <span>Créer un CV en ligne</span>
                </a>
                <a href="#" class="menu-item">
                    <i class="fas fa-envelope"></i>
                    <span>Messagerie</span>
                    <span class="notifications-badge">2</span>
                </a>
                <a href="#" class="menu-item">
                    <i class="fas fa-user-circle"></i>
                    <span>Profil</span>
                </a>
                <a href="#" class="menu-item">
                    <i class="fas fa-graduation-cap"></i>
                    <span>Cours en ligne</span>
                </a>
                <a href="#" class="menu-item">
                    <i class="fas fa-building"></i>
                    <span>Entreprises suivies</span>
                </a>
                <a href="#" class="menu-item">
                    <i class="fas fa-briefcase"></i>
                    <span>Offres disponibles</span>
                    <span class="notifications-badge">5</span>
                </a>
                <a href="#" class="menu-item">
                    <i class="fas fa-comment-alt"></i>
                    <span>Suggestions/Plaintes</span>
                </a>
                <a href="#" class="menu-item">
                    <i class="fas fa-calendar-day"></i>
                    <span>Événements</span>
                </a>
                <a href="#" class="menu-item">
                    <i class="fas fa-blog"></i>
                    <span>Blog</span>
                </a>
                <a href="#" class="menu-item">
                    <i class="fas fa-bullseye"></i>&
                    <span>Objectifs</span>
                </a>
                <a href="{{ route('etudiants.examen', ['etudiant_id' => $etudiant->id]) }}" class="menu-item">
                    <i class="fas fa-comments"></i>
                    <span>Entretiens en cours</span>
                </a>
                <a href="#" class="menu-item">
                    <i class="fas fa-calendar-alt"></i>
                    <span>Agenda</span>
                </a>
                <a href="#" class="menu-item">
                    <i class="fas fa-rocket"></i>
                    <span>Boostage</span>
                </a>
                <a href="#" class="menu-item">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Déconnexion</span>
                </a>
            </nav>
        </aside>
        
        <main class="main-content">
            <div class="dashboard-header">
                <div class="welcome-message">
                    <div style="text-align: center; margin-top: 20px;">
   
</div>

                    <p>Voici un aperçu de votre activité récente et des opportunités à venir</p>
                </div>
                <div class="quick-actions">
                    <button class="action-button">
                        <i class="fas fa-search"></i>
                        <span>Rechercher une offre</span>
                    </button>
                    <button class="action-button">
                        <i class="fas fa-file-alt"></i>
                        <span>Mettre à jour mon CV</span>
                    </button>
                </div>
            </div>
            
            <div class="dashboard-cards">
                <div class="card">
                    <div class="card-header">
                        <i class="fas fa-eye"></i>
                        <h3 class="card-title">Vues du profil</h3>
                    </div>
                    <div class="card-content">
                        <p>Votre profil a été consulté <strong>27 fois</strong> cette semaine</p>
                        <p style="margin-top: 8px">+15% par rapport à la semaine dernière</p>
                    </div>
                </div>
                
                <div class="card">
                    <div class="card-header">
                        <i class="fas fa-briefcase"></i>
                        <h3 class="card-title">Candidatures</h3>
                    </div>
                    <div class="card-content">
                        <p><strong>12 candidatures</strong> actives</p>
                        <p style="margin-top: 8px">3 nouvelles réponses à traiter</p>
                    </div>
                </div>
                
                <div class="card">
                    <div class="card-header">
                        <i class="fas fa-check-circle"></i>
                        <h3 class="card-title">Complétion du profil</h3>
                    </div>
                    <div class="card-content">
                        <p>Votre profil est complété à <strong>85%</strong></p>
                        <p style="margin-top: 8px">Ajoutez vos certifications pour atteindre 100%</p>
                    </div>
                </div>
                

<div class="container mt-4">
    <div class="card">
        <div class="card-header">
            <i class="fas fa-calendar-check"></i>
            <h3 class="card-title d-inline-block ml-2">Entretiens programmés</h3>
        </div>
        <div class="card-body">
            @if(!empty($entretiens) && count($entretiens) > 0)
                <p><strong>{{ count($entretiens) }} entretien{{ count($entretiens) > 1 ? 's' : '' }}</strong> programmé{{ count($entretiens) > 1 ? 's' : '' }} cette semaine</p>

                <ul class="list-group">
                    @foreach($entretiens as $entretien)
                        <li class="list-group-item">
                            <strong>{{ \Carbon\Carbon::parse($entretien->date)->format('d/m/Y H:i') }}</strong> -
                            <span>{{ $entretien->entreprise->nom ?? 'Entreprise inconnue' }}</span>
                        </li>
                    @endforeach
                </ul>
            @else
                <p class="text-warning">⚠️ Aucun entretien programmé pour le moment.</p>
            @endif
        </div>
    </div>

 </div>



            
            <div class="recent-activity">
                <div class="section-header">
                    <h2 class="section-title">Activité récente</h2>
                    <a href="#" class="view-all">Voir tout</a>
                </div>
                <div class="activity-list">
                    <div class="activity-item">
                        <div class="activity-icon">
                            <i class="fas fa-paper-plane"></i>
                        </div>
                        <div class="activity-details">
                            <div class="activity-title">Candidature envoyée - Développeur Web</div>
                            <div class="activity-time">Aujourd'hui, 10:35</div>
                        </div>
                    </div>
                    
                    <div class="activity-item">
                        <div class="activity-icon">
                            <i class="fas fa-envelope-open-text"></i>
                        </div>
                        <div class="activity-details">
                            <div class="activity-title">Message reçu de InnoTech Solutions</div>
                            <div class="activity-time">Hier, 15:20</div>
                        </div>
                    </div>
                    
                    <div class="activity-item">
                        <div class="activity-icon">
                            <i class="fas fa-certificate"></i>
                        </div>
                        <div class="activity-details">
                            <div class="activity-title">Certification JavaScript Avancé complétée</div>
                            <div class="activity-time">02/04/2025, 11:45</div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="upcoming-events">
                <div class="section-header">
                    <h2 class="section-title">Événements à venir</h2>
                    <a href="#" class="view-all">Voir tout</a>
                </div>
                <div class="event-list">
                    <div class="event-item">
                        <div class="event-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="event-details">
                            <div class="event-title">Salon de l'emploi Tech</div>
                            <div class="event-date">10 avril 2025, 09:00-18:00</div>
                            <div class="event-time">Centre des Congrès, Paris</div>
                        </div>
                    </div>
                    
                    <div class="event-item">
                        <div class="event-icon">
                            <i class="fas fa-laptop"></i>
                        </div>
                        <div class="event-details">
                            <div class="event-title">Webinaire: Tendances Tech 2025</div>
                            <div class="event-date">15 avril 2025, 14:00-15:30</div>
                            <div class="event-time">En ligne - Lien dans votre calendrier</div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

 @endsection