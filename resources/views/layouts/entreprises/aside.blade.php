<div class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <div class="sidebar-logo">R</div>
        <h2>RecrutPro</h2>
    </div>
    <nav class="sidebar-menu" aria-label="Menu principal">
        <div class="menu-category">Principal</div>
        
        <a href="{{ route('entreprises.dashboard') }}" class="menu-item {{ request()->routeIs('entreprises.dashboard') ? 'active' : '' }}">
            <span class="menu-icon"><i class="fas fa-tachometer-alt"></i></span>
            <span class="menu-text">Tableau de bord</span>
        </a>
        
        <a href="{{ route('entreprises.profile.edit') }}" class="menu-item {{ request()->routeIs('entreprises.profile.edit') ? 'active' : '' }}">
            <span class="menu-icon"><i class="fas fa-user-circle"></i></span>
            <span class="menu-text">Mon Profil</span>
        </a>
        
        <a href="#" class="menu-item">
            <span class="menu-icon"><i class="fas fa-newspaper"></i></span>
            <span class="menu-text">Actualités</span>
        </a>
        
        <div class="menu-category">Recrutement</div>
        
        <a href="{{ route('entreprises.cvtheque.index') }}" class="menu-item {{ request()->routeIs('entreprises.cvtheque.*') ? 'active' : '' }}">
            <span class="menu-icon"><i class="fas fa-database"></i></span>
            <span class="menu-text">CV thèque</span>
            
        </a>
        
        <a href="{{ route('entreprises.annonces.create') }}" class="menu-item {{ request()->routeIs('entreprises.annonces.create') ? 'active' : '' }}">
            <span class="menu-icon"><i class="fas fa-plus-circle"></i></span>
            <span class="menu-text">Créer une annonce</span>
        </a>
        
        <a href="{{ route('entreprises.annonces.index') }}" class="menu-item {{ request()->routeIs('entreprises.annonces.index') ? 'active' : '' }}">
            <span class="menu-icon"><i class="fas fa-list-alt"></i></span>
            <span class="menu-text">Mes annonces</span>
        </a>
        
        <a href="" class="menu-item">
            <span class="menu-icon"><i class="fas fa-envelope"></i></span>
            <span class="menu-text">Messagerie</span>
            <!-- <span class="menu-badge">3</span> -->
        </a>
        
        <a href="#" class="menu-item">
            <span class="menu-icon"><i class="fas fa-briefcase"></i></span>
            <span class="menu-text">Mes offres disponibles</span>
            <!-- <span class="menu-badge">5</span> -->
        </a>
        
        <a href="#" class="menu-item">
            <span class="menu-icon"><i class="fas fa-comment-alt"></i></span>
            <span class="menu-text">Entretiens en cours</span>
            <!-- <span class="menu-badge">2</span> -->
        </a>
        
        <a href="#" class="menu-item">
            <span class="menu-icon"><i class="fas fa-user-check"></i></span>
            <span class="menu-text">Évaluations des candidats</span>
        </a>
        
        <div class="menu-category">Entreprise</div>
        
        <a href="#" class="menu-item">
            <span class="menu-icon"><i class="fas fa-tasks"></i></span>
            <span class="menu-text">Tâches des employés</span>
        </a>
        
        <a href="#" class="menu-item">
            <span class="menu-icon"><i class="fas fa-gavel"></i></span>
            <span class="menu-text">Marchés public/privé</span>
        </a>
        
        <a href="#" class="menu-item">
            <span class="menu-icon"><i class="fas fa-graduation-cap"></i></span>
            <span class="menu-text">Demande de stages</span>
        </a>
        
        <div class="menu-category">Configuration</div>
        
        <a href="#" class="menu-item">
            <span class="menu-icon"><i class="fas fa-credit-card"></i></span>
            <span class="menu-text">Mon abonnement</span>
        </a>
        
        <a href="#" class="menu-item">
            <span class="menu-icon"><i class="fas fa-box"></i></span>
            <span class="menu-text">Les packs disponibles</span>
        </a>
        
        <a href="#" class="menu-item">
            <span class="menu-icon"><i class="fas fa-lightbulb"></i></span>
            <span class="menu-text">Suggestions/Plaintes</span>
        </a>
        
        <a href="#" class="menu-item">
            <span class="menu-icon"><i class="fas fa-calendar-day"></i></span>
            <span class="menu-text">Événements</span>
        </a>
        
        <a href="#" class="menu-item">
            <span class="menu-icon"><i class="fas fa-blog"></i></span>
            <span class="menu-text">Blog</span>
        </a>
        
        <a href="#" class="menu-item">
            <span class="menu-icon"><i class="fas fa-bullseye"></i></span>
            <span class="menu-text">Objectifs</span>
        </a>
        
        <a href="#" class="menu-item">
            <span class="menu-icon"><i class="fas fa-calendar-alt"></i></span>
            <span class="menu-text">Agenda</span>
        </a>
        
        <a href="#" class="menu-item">
            <span class="menu-icon"><i class="fas fa-rocket"></i></span>
            <span class="menu-text">Boostage</span>
        </a>
        
        <form method="POST" action="{{ route('logout') }}" class="mt-3">
            @csrf
            <button type="submit" class="menu-item logout-item">
                <span class="menu-icon"><i class="fas fa-sign-out-alt"></i></span>
                <span class="menu-text">Déconnexion</span>
            </button>
        </form>
    </nav>
</div>

<style>
    .sidebar {
        width: var(--sidebar-width, 250px);
        background-color: var(--dark, #1f2937);
        color: white;
        height: 100vh;
        position: fixed;
        top: 0;
        left: 0;
        z-index: 100;
        transition: all 0.3s ease;
        box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
        display: flex;
        flex-direction: column;
    }

    .sidebar.collapsed {
        width: var(--sidebar-width-collapsed, 70px);
    }

    .sidebar-header {
        display: flex;
        align-items: center;
        padding: 15px 20px;
        height: var(--header-height, 60px);
        background-color: rgba(0, 0, 0, 0.2);
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        flex-shrink: 0;
        overflow: hidden;
    }

    .sidebar-logo {
        width: 35px;
        height: 35px;
        border-radius: 6px;
        margin-right: 10px;
        background-color: var(--primary, #3498db);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
        font-weight: bold;
        flex-shrink: 0;
    }

    .sidebar-header h2 {
        font-size: 1.2rem;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        transition: opacity 0.2s ease;
        margin-bottom: 0;
    }

    .sidebar-menu {
        padding: 15px 0;
        overflow-y: auto;
        flex-grow: 1;
        height: calc(100vh - var(--header-height, 60px));
        scrollbar-width: thin;
        scrollbar-color: var(--gray, #6b7280) rgba(255, 255, 255, 0.1);
    }
    
    .sidebar-menu::-webkit-scrollbar {
        width: 5px;
    }
    
    .sidebar-menu::-webkit-scrollbar-track {
        background: rgba(255, 255, 255, 0.1);
        border-radius: 3px;
    }
    
    .sidebar-menu::-webkit-scrollbar-thumb {
        background-color: var(--gray, #6b7280);
        border-radius: 3px;
    }
    
    .sidebar-menu::-webkit-scrollbar-thumb:hover {
        background-color: var(--primary, #3498db);
    }

    .menu-category {
        font-size: 0.75rem;
        text-transform: uppercase;
        padding: 12px 20px 8px;
        color: var(--gray, #6b7280);
        letter-spacing: 0.5px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        transition: opacity 0.2s ease;
    }

    .menu-item {
        padding: 10px 20px;
        display: flex;
        align-items: center;
        cursor: pointer;
        transition: background-color 0.2s ease, color 0.2s ease;
        margin: 1px 0;
        position: relative;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        text-decoration: none;
        color: #e5e7eb;
        border: none;
        background: none;
        width: 100%;
        text-align: left;
    }

    .menu-item:hover,
    .menu-item.active {
        background-color: rgba(255, 255, 255, 0.1);
        color: white;
    }

    .menu-item.active {
        font-weight: 500;
    }

    .menu-item.active::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        width: 3px;
        height: 100%;
        background-color: var(--primary, #3498db);
        border-radius: 0 2px 2px 0;
    }

    .menu-icon {
        width: 24px;
        height: 24px;
        margin-right: 12px;
        display: flex;
        justify-content: center;
        align-items: center;
        flex-shrink: 0;
        font-size: 0.9rem;
    }

    .menu-text {
        transition: opacity 0.2s ease;
    }

    .menu-badge {
        background-color: var(--danger, #e74c3c);
        color: white;
        border-radius: 10px;
        padding: 2px 8px;
        font-size: 0.7rem;
        margin-left: auto;
        transition: opacity 0.2s ease;
        flex-shrink: 0;
        line-height: 1.2;
    }

    .menu-badge.bg-primary {
        background-color: var(--primary, #3498db);
    }

    .logout-item {
        color: #f87171;
    }
    
    .logout-item:hover {
        background-color: rgba(239, 68, 68, 0.2);
    }

    /* Sidebar collapsed state */
    .sidebar.collapsed .sidebar-header h2,
    .sidebar.collapsed .menu-text,
    .sidebar.collapsed .menu-category,
    .sidebar.collapsed .menu-badge:not(.absolute-badge) {
        opacity: 0;
        width: 0;
        overflow: hidden;
        white-space: nowrap;
        transition: opacity 0.1s ease, width 0.1s ease;
    }
    
    .sidebar.collapsed .menu-item {
        justify-content: center;
        padding-left: 0;
        padding-right: 0;
    }
    
    .sidebar.collapsed .menu-icon {
        margin-right: 0;
        width: 100%;
        justify-content: center;
    }
    
    .sidebar.collapsed .menu-badge.absolute-badge {
        position: absolute;
        top: 5px;
        right: 5px;
        opacity: 1;
        width: auto;
    }

    @media (max-width: 768px) {
        .sidebar {
            width: var(--sidebar-width-collapsed, 70px);
        }
        
        .sidebar .sidebar-header h2,
        .sidebar .menu-text,
        .sidebar .menu-category,
        .sidebar .menu-badge:not(.absolute-badge) {
            display: none;
        }
        
        .sidebar .menu-item {
            justify-content: center;
            padding-left: 0;
            padding-right: 0;
        }
        
        .sidebar .menu-icon {
            margin-right: 0;
            width: 100%;
            justify-content: center;
        }
        
        .sidebar .menu-badge.absolute-badge {
            display: inline-block !important;
        }
    }
</style>