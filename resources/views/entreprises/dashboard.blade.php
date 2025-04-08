<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StagesBENIN</title>
    <style>
        :root {
            --primary-color: #2c3e50;
            --secondary-color: #1abc9c;
            --accent-color: #e74c3c;
            --success-color: #27ae60;
            --warning-color: #f39c12;
            --light-gray: #f5f7fa;
            --gray: #95a5a6;
            --dark-gray: #7f8c8d;
            --blue: #3498db;
        }
        
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background-color: #f8f9fa;
        }
        
        header {
            background: linear-gradient(135deg, var(--primary-color), #34495e);
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
            gap: 20px;
        }
        
        .search-box {
            position: relative;
            width: 300px;
        }
        
        .search-box input {
            width: 100%;
            padding: 8px 15px;
            border-radius: 20px;
            border: none;
            font-size: 0.9rem;
            padding-left: 40px;
        }
        
        .search-box i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--gray);
        }
        
        .notifications, .messages {
            position: relative;
            cursor: pointer;
        }
        
        .badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background-color: var(--accent-color);
            color: white;
            font-size: 0.7rem;
            width: 18px;
            height: 18px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .profile-menu {
            display: flex;
            align-items: center;
            cursor: pointer;
        }
        
        .profile-image {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: var(--secondary-color);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 10px;
            color: white;
        }
        
        .profile-info {
            display: flex;
            flex-direction: column;
        }
        
        .profile-name {
            font-weight: bold;
            font-size: 0.9rem;
        }
        
        .profile-role {
            font-size: 0.8rem;
            opacity: 0.8;
        }
        
        .container {
            display: flex;
        }
        
        .sidebar {
            width: 260px;
            background-color: white;
            min-height: calc(100vh - 70px);
            box-shadow: 2px 0 10px rgba(0,0,0,0.05);
            z-index: 10;
        }
        
        .sidebar-menu {
            padding: 1rem 0;
        }
        
        .menu-category {
            padding: 0.5rem 1.5rem;
            font-size: 0.75rem;
            text-transform: uppercase;
            color: var(--gray);
            font-weight: bold;
            margin-top: 1rem;
        }
        
        .menu-item {
            padding: 0.8rem 1.5rem;
            display: flex;
            align-items: center;
            color: var(--dark-gray);
            text-decoration: none;
            transition: all 0.3s;
            font-size: 0.95rem;
            position: relative;
        }
        
        .menu-item i {
            margin-right: 10px;
            width: 20px;
            text-align: center;
        }
        
        .menu-item:hover, .menu-item.active {
            background-color: rgba(26, 188, 156, 0.1);
            color: var(--secondary-color);
            border-left: 3px solid var(--secondary-color);
        }
        
        .menu-item.active {
            font-weight: bold;
        }
        
        .menu-badge {
            position: absolute;
            right: 15px;
            background-color: var(--accent-color);
            color: white;
            font-size: 0.7rem;
            padding: 2px 8px;
            border-radius: 10px;
        }
        
        .main-content {
            flex: 1;
            padding: 2rem;
        }
        
        .page-title {
            margin-bottom: 2rem;
            color: var(--primary-color);
        }
        
        .stats-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }
        
        .stat-card {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            padding: 1.5rem;
            transition: all 0.3s;
            display: flex;
            align-items: center;
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.1);
        }
        
        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin-right: 1rem;
        }
        
        .stat-icon.blue {
            background-color: rgba(52, 152, 219, 0.1);
            color: var(--blue);
        }
        
        .stat-icon.green {
            background-color: rgba(39, 174, 96, 0.1);
            color: var(--success-color);
        }
        
        .stat-icon.orange {
            background-color: rgba(243, 156, 18, 0.1);
            color: var(--warning-color);
        }
        
        .stat-icon.red {
            background-color: rgba(231, 76, 60, 0.1);
            color: var(--accent-color);
        }
        
        .stat-info {
            flex: 1;
        }
        
        .stat-value {
            font-size: 1.8rem;
            font-weight: bold;
            color: var(--primary-color);
            margin-bottom: 0.3rem;
        }
        
        .stat-label {
            color: var(--gray);
            font-size: 0.9rem;
        }
        
        .trend {
            font-size: 0.8rem;
            display: flex;
            align-items: center;
        }
        
        .trend.up {
            color: var(--success-color);
        }
        
        .trend.down {
            color: var(--accent-color);
        }
        
        .trend i {
            margin-right: 5px;
        }
        
        .dashboard-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 1.5rem;
            margin-bottom: 2rem;
        }
        
        .recent-applications, .upcoming-interviews, .activity-feed {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            padding: 1.5rem;
            height: 100%;
        }
        
        .widget-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }
        
        .widget-title {
            font-size: 1.2rem;
            color: var(--primary-color);
            font-weight: bold;
        }
        
        .widget-action {
            color: var(--secondary-color);
            font-size: 0.9rem;
            text-decoration: none;
            display: flex;
            align-items: center;
        }
        
        .widget-action i {
            margin-left: 5px;
        }
        
        .application-item {
            display: flex;
            align-items: center;
            padding: 1rem 0;
            border-bottom: 1px solid var(--light-gray);
        }
        
        .application-item:last-child {
            border-bottom: none;
        }
        
        .application-position {
            flex: 1;
        }
        
        .position-title {
            font-weight: bold;
            color: var(--primary-color);
            margin-bottom: 0.3rem;
        }
        
        .position-info {
            display: flex;
            font-size: 0.85rem;
            color: var(--gray);
        }
        
        .position-info span {
            display: flex;
            align-items: center;
            margin-right: 1rem;
        }
        
        .position-info i {
            margin-right: 5px;
            font-size: 0.8rem;
        }
        
        .application-count {
            background-color: var(--light-gray);
            padding: 0.5rem 0.8rem;
            border-radius: 4px;
            font-weight: bold;
            color: var(--primary-color);
            margin-right: 1rem;
        }
        
        .application-actions button {
            padding: 0.5rem;
            border: none;
            background-color: transparent;
            cursor: pointer;
            color: var(--dark-gray);
            transition: color 0.3s;
        }
        
        .application-actions button:hover {
            color: var(--primary-color);
        }
        
        .interview-item {
            padding: 1rem;
            background-color: var(--light-gray);
            border-radius: 6px;
            margin-bottom: 1rem;
        }
        
        .interview-date {
            display: flex;
            align-items: center;
            margin-bottom: 0.5rem;
            font-size: 0.9rem;
            color: var(--primary-color);
        }
        
        .interview-date i {
            margin-right: 8px;
        }
        
        .interview-position {
            font-weight: bold;
            margin-bottom: 0.3rem;
        }
        
        .interview-candidates {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
            margin-top: 0.8rem;
        }
        
        .candidate-tag {
            background-color: white;
            padding: 0.3rem 0.8rem;
            border-radius: 20px;
            font-size: 0.8rem;
            display: flex;
            align-items: center;
        }
        
        .candidate-tag i {
            margin-right: 5px;
            font-size: 0.7rem;
        }
        
        .activity-item {
            display: flex;
            padding: 1rem 0;
            border-bottom: 1px solid var(--light-gray);
        }
        
        .activity-item:last-child {
            border-bottom: none;
        }
        
        .activity-dot {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            margin-right: 15px;
            margin-top: 5px;
        }
        
        .activity-dot.blue {
            background-color: var(--blue);
        }
        
        .activity-dot.green {
            background-color: var(--success-color);
        }
        
        .activity-dot.orange {
            background-color: var(--warning-color);
        }
        
        .activity-dot.red {
            background-color: var(--accent-color);
        }
        
        .activity-content {
            flex: 1;
        }
        
        .activity-text {
            margin-bottom: 0.3rem;
        }
        
        .activity-text strong {
            color: var(--primary-color);
            font-weight: 600;
        }
        
        .activity-time {
            font-size: 0.8rem;
            color: var(--gray);
        }
        
        @media (max-width: 1200px) {
            .dashboard-grid {
                grid-template-columns: 1fr;
            }
        }
        
        @media (max-width: 992px) {
            .stats-container {
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
            
            .search-box {
                display: none;
            }
            
            .stats-container {
                grid-template-columns: 1fr;
            }
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <header>
        <div class="logo">
            <i class="fas fa-building"></i>
            <span>RecrutPro</span>
        </div>
        <div class="header-actions">
            <div class="search-box">
                <i class="fas fa-search"></i>
                <input type="text" placeholder="Rechercher...">
            </div>
            <div class="notifications">
                <i class="fas fa-bell"></i>
                <div class="badge">5</div>
            </div>
            <div class="messages">
                <i class="fas fa-envelope"></i>
                <div class="badge">3</div>
            </div>
            <div class="profile-menu">
                <div class="profile-image">
                    <i class="fas fa-user"></i>
                </div>
                <div class="profile-info">
                    <div class="profile-name">Tech Solutions</div>
                    <div class="profile-role">Administrateur</div>
                </div>
            </div>
        </div>
    </header>
    
    <div class="container">
        <aside class="sidebar">
            <nav class="sidebar-menu">
                <a href="#" class="menu-item active">
                    <i class="fas fa-tachometer-alt"></i>
                    <span>Tableau de bord</span>
                </a>
                
                <div class="menu-category">Recrutement</div>
                
                <a href="#" class="menu-item">
                    <i class="fas fa-newspaper"></i>
                    <span>Actualités</span>
                </a>
                <a href="#" class="menu-item">
                    <i class="fas fa-database"></i>
                    <span>CV thèque</span>
                </a>
                <a href="#" class="menu-item">
                    <i class="fas fa-plus-circle"></i>
                    <span>Créer une annonce</span>
                </a>
                <a href="#" class="menu-item">
                    <i class="fas fa-list-alt"></i>
                    <span>Voir toutes les annonces</span>
                </a>
                <a href="#" class="menu-item">
                    <i class="fas fa-envelope"></i>
                    <span>Messagerie</span>
                    <div class="menu-badge">3</div>
                </a>
                <a href="#" class="menu-item">
                    <i class="fas fa-briefcase"></i>
                    <span>Mes offres disponibles</span>
                    <div class="menu-badge">5</div>
                </a>
                <a href="#" class="menu-item">
                    <i class="fas fa-user-check"></i>
                    <span>Évaluations des candidats</span>
                </a>
                <a href="#" class="menu-item">
                    <i class="fas fa-comment-alt"></i>
                    <span>Entretiens en cours</span>
                    <div class="menu-badge">2</div>
                </a>
                
                <div class="menu-category">Entreprise</div>
                
                <a href="#" class="menu-item">
                    <i class="fas fa-tasks"></i>
                    <span>Tâches des employés</span>
                </a>
                <a href="#" class="menu-item">
                    <i class="fas fa-gavel"></i>
                    <span>Marchés public/privé</span>
                </a>
                <a href="#" class="menu-item">
                    <i class="fas fa-graduation-cap"></i>
                    <span>Demande de stages</span>
                </a>
                <a href="#" class="menu-item">
                    <i class="fas fa-credit-card"></i>
                    <span>Mon abonnement</span>
                </a>
                <a href="#" class="menu-item">
                    <i class="fas fa-box"></i>
                    <span>Les packs disponibles</span>
                </a>
                <a href="#" class="menu-item">
                    <i class="fas fa-lightbulb"></i>
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
                    <i class="fas fa-bullseye"></i>
                    <span>Objectifs</span>
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
            <h1 class="page-title">Tableau de bord</h1>
            
            <div class="stats-container">
                <div class="stat-card">
                    <div class="stat-icon blue">
                        <i class="fas fa-file-alt"></i>
                    </div>
                    <div class="stat-info">
                        <div class="stat-value">28</div>
                        <div class="stat-label">Offres publiées</div>
                        <div class="trend up">
                            <i class="fas fa-arrow-up"></i>
                            <span>12% ce mois-ci</span>
                        </div>
                    </div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon green">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="stat-info">
                        <div class="stat-value">142</div>
                        <div class="stat-label">Candidatures reçues</div>
                        <div class="trend up">
                            <i class="fas fa-arrow-up"></i>
                            <span>8% cette semaine</span>
                        </div>
                    </div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon orange">
                        <i class="fas fa-handshake"></i>
                    </div>
                    <div class="stat-info">
                        <div class="stat-value">12</div>
                        <div class="stat-label">Entretiens programmés</div>
                        <div class="trend up">
                            <i class="fas fa-arrow-up"></i>
                            <span>3 de plus qu'hier</span>
                        </div>
                    </div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon red">
                        <i class="fas fa-user-check"></i>
                    </div>
                    <div class="stat-info">
                        <div class="stat-value">5</div>
                        <div class="stat-label">Postes pourvus</div>
                        <div class="trend down">
                            <i class="fas fa-arrow-down"></i>
                            <span>2 de moins qu'avant-hier</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="dashboard-grid">
                <div class="recent-applications">
                    <div class="widget-header">
                        <h2 class="widget-title">Annonces récentes</h2>
                        <a href="#" class="widget-action">
                            Voir tout
                            <i class="fas fa-chevron-right"></i>
                        </a>
                    </div>
                    
                    <div class="application-item">
                        <div class="application-position">
                            <div class="position-title">Développeur Full Stack</div>
                            <div class="position-info">
                                <span><i class="fas fa-map-marker-alt"></i> Paris</span>
                                <span><i class="fas fa-clock"></i> CDI</span>
                                <span><i class="fas fa-calendar-alt"></i> Publié il y a 2 jours</span>
                            </div>
                        </div>
                        <div class="application-count">32</div>
                        <div class="application-actions">
                            <button><i class="fas fa-edit"></i></button>
                            <button><i class="fas fa-trash-alt"></i></button>
                        </div>
                    </div>
                    
                    <div class="application-item">
                        <div class="application-position">
                            <div class="position-title">Chef de Projet Digital</div>
                            <div class="position-info">
                                <span><i class="fas fa-map-marker-alt"></i> Lyon</span>
                                <span><i class="fas fa-clock"></i> CDI</span>
                                <span><i class="fas fa-calendar-alt"></i> Publié il y a 3 jours</span>
                            </div>
                        </div>
                        <div class="application-count">18</div>
                        <div class="application-actions">
                            <button><i class="fas fa-edit"></i></button>
                            <button><i class="fas fa-trash-alt"></i></button>
                        </div>
                    </div>
                    
                    <div class="application-item">
                        <div class="application-position">
                            <div class="position-title">Responsable Marketing</div>
                            <div class="position-info">
                                <span><i class="fas fa-map-marker-alt"></i> Paris</span>
                                <span><i class="fas fa-clock"></i> CDD 6 mois</span>
                                <span><i class="fas fa-calendar-alt"></i> Publié il y a 5 jours</span>
                            </div>
                        </div>
                        <div class="application-count">24</div>
                        <div class="application-actions">
                            <button><i class="fas fa-edit"></i></button>
                            <button><i class="fas fa-trash-alt"></i></button>
                        </div>
                    </div>
                    
                    <div class="application-item">
                        <div class="application-position">
                            <div class="position-title">UI/UX Designer</div>
                            <div class="position-info">
                                <span><i class="fas fa-map-marker-alt"></i> Marseille</span>
                                <span><i class="fas fa-clock"></i> CDI</span>
                                <span><i class="fas fa-calendar-alt"></i> Publié il y a 1 semaine</span>
                            </div>
                        </div>
                        <div class="application-count">15</div>
                        <div class="application-actions">
                            <button><i class="fas fa-edit"></i></button>
                            <button><i class="fas fa-trash-alt"></i></button>
                        </div>
                    </div>
                </div>
                
                <div class="upcoming-interviews">
                    <div class="widget-header">
                        <h2 class="widget-title">Entretiens à venir</h2>
                        <a href="#" class="widget-action">
                            Voir l'agenda
                            <i class="fas fa-chevron-right"></i>
                        </a>
                    </div>
                    
                    <div class="interview-item">
                        <div class="interview-date">
                            <i class="fas fa-calendar-day"></i>
                            <span>Aujourd'hui, 14:00 - 15:30</span>
                        </div>
                        <div class="interview-position">Développeur Full Stack</div>
                        <div class="interview-candidates">
                            <div class="candidate-tag">
                                <i class="fas fa-user"></i>
                                <span>Thomas D.</span>
                            </div>
                            <div class="candidate-tag">
                                <i class="fas fa-user"></i>
                                <span>Marie L.</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="interview-item">
                        <div class="interview-date">
                            <i class="fas fa-calendar-day"></i>
                            <span>Demain, 10:00 - 11:00</span>
                        </div>
                        <div class="interview-position">Chef de Projet Digital</div>
                        <div class="interview-candidates">
                            <div class="candidate-tag">
                                <i class="fas fa-user"></i>
                                <span>Alexandre F.</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="interview-item">
                        <div class="interview-date">
                            <i class="fas fa-calendar-day"></i>
                            <span>05/04/2025, 15:00 - 16:00</span>
                        </div>
                        <div class="interview-position">Responsable Marketing</div>
                        <div class="interview-candidates">
                            <div class="candidate-tag">
                                <i class="fas fa-user"></i>
                                <span>Sophie M.</span>
                            </div>
                            <div class="candidate-tag">
                                <i class="fas fa-user"></i>
                                <span>Paul G.</span>
                            </div>
                            <div class="candidate-tag">
                                <i class="fas fa-user"></i>
                                <span>Juliette R.</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="activity-feed">
                <div class="widget-header">
                    <h2 class="widget-title">Activité récente</h2>
                    <a href="#" class="widget-action">
                        Voir toutes les activités
                        <i class="fas fa-chevron-right"></i>
                    </a>
                </div>
                
                <div class="activity-item">
                    <div class="activity-dot blue"></div>
                    <div class="activity-content">
                        <div class="activity-text">
                            <strong>Thomas M.</strong> a postulé pour le poste de <strong>Développeur Full Stack</strong>
                        </div>
                        <div class="activity-time">Il y a 35 minutes</div>
                    </div>
                </div>
                
                <div class="activity-item">
                    <div class="activity-dot green"></div>
                    <div class="activity-content">
                        <div class="activity-text">
                            <strong>Vous</strong> avez publié une nouvelle offre : <strong>Responsable Commercial</strong>
                        </div>
                        <div class="activity-time">Il y a 2 heures</div>
                    </div>
                </div>
                
                <div class="activity-item">
                    <div class="activity-dot orange"></div>
                    <div class="activity-content">
                        <div class="activity-text">
                            <strong>Marie L.</strong> a accepté l'invitation à l'entretien pour le poste de <strong>Développeur Full Stack</strong>
                        </div>
                        <div class="activity-time">Il y a 3 heures</div>
                    </div>
                </div>
                
                <div class="activity-item">
                    <div class="activity-dot red"></div>
                    <div class="activity-content">
                        <div class="activity-text">
                            <strong>Alexandre F.</strong> a demandé un report de son entretien pour le poste de <strong>Chef de Projet Digital</strong>
                        </div>