<!-- Sidebar Structure -->
<div class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <div class="sidebar-logo">S</div>
        <h2>StagesBENIN</h2>
    </div>
    <nav class="sidebar-menu" aria-label="Menu principal">
        <div class="menu-category">Principal</div>
         {{-- Use request()->routeIs() for active state --}}
        <a href="{{ route('admin.dashboard') }}" class="menu-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <span class="menu-icon" aria-hidden="true"><i class="fas fa-tachometer-alt"></i></span>
            <span class="menu-text">Tableau de bord</span>
        </a>

            <a href="{{ route('admin.cvtheque.cvtheque') }}" class="menu-item {{ request()->routeIs('messagerie-sociale.*') ? 'active' : '' }}">
            <span class="menu-icon" aria-hidden="true"><i class="fas fa-bullhorn"></i></span>
            <span class="menu-text">CV THEQUE</span>
        </a>

        <a href="{{ route('messagerie-sociale.index') }}" class="menu-item {{ request()->routeIs('messagerie-sociale.*') ? 'active' : '' }}">
            <span class="menu-icon" aria-hidden="true"><i class="fas fa-bullhorn"></i></span>
            <span class="menu-text">Canal d'annonces</span>
        </a>
        <a href="{{ route('admin.actualites') }}" class="menu-item {{ request()->routeIs('admin.actualites.*') ? 'active' : '' }}"> {{-- Adjust route name --}}
            <span class="menu-icon" aria-hidden="true"><i class="fas fa-newspaper"></i></span>
            <span class="menu-text">Actualités</span>
            {{-- Add dynamic badge count if needed --}}
            {{-- <span class="menu-badge">5</span> --}}
        </a>
         <a href="{{ route('admin.annonces.index') }}" class="menu-item {{ request()->routeIs('admin.recrutements.*') ? 'active' : '' }}"> {{-- Adjust route name --}}
            <span class="menu-icon" aria-hidden="true"><i class="fas fa-briefcase"></i></span>
            <span class="menu-text">Recrutements</span>
         </a>
        <a href="{{ route('admin.evenements') }}" class="menu-item {{ request()->routeIs('admin.evenements') ? 'active' : '' }}"> {{-- Adjust route name --}}
            <span class="menu-icon" aria-hidden="true"><i class="fas fa-calendar-alt"></i></span>
            <span class="menu-text">Événements</span>
        </a>

        <div class="menu-category">Gestion</div>
        <a href="{{ route('admin.etudiants.etudiants') }}" class="menu-item {{ request()->routeIs('admin.etudiants.*') ? 'active' : '' }}"> {{-- Adjust route name --}}
            <span class="menu-icon" aria-hidden="true"><i class="fas fa-users"></i></span>
            <span class="menu-text">Étudiants</span>
        </a>
        <!-- <a href="{{ route('admin.annonces.index') }}" class="menu-item {{ request()->routeIs('admin.annonces.*') ? 'active' : '' }}">
            <span class="menu-icon" aria-hidden="true"><i class="fas fa-briefcase"></i></span>
            <span class="menu-text">Offres d'emploi</span>
        </a> -->
        <a href="{{ route('admin.entreprises') }}" class="menu-item {{ request()->routeIs('admin.entreprises.*') ? 'active' : '' }}"> {{-- Adjust route name --}}
            <span class="menu-icon" aria-hidden="true"><i class="fas fa-building"></i></span>
            <span class="menu-text">Entreprises</span>
        </a>
        <a href="{{ route('admin.catalogues') }}" class="menu-item {{ request()->routeIs('admin.catalogue.*') ? 'active' : '' }}"> {{-- Adjust route name --}}
            <span class="menu-icon" aria-hidden="true"><i class="fas fa-book"></i></span>
            <span class="menu-text">Catalogue</span>
        </a>
        {{-- Commenté l'ancienne messagerie --}}
        {{-- <a href="#" class="menu-item {{ request()->routeIs('admin.messages.*') ? 'active' : '' }}"> 
            <span class="menu-icon" aria-hidden="true"><i class="fas fa-comments"></i></span>
            <span class="menu-text">Messages</span>
        </a> --}}
        
        <a href="{{ route('admin.complaints.index') }}" class="menu-item {{ request()->routeIs('admin.complaints.*') ? 'active' : '' }}">
            <span class="menu-icon" aria-hidden="true"><i class="fas fa-comment-alt"></i></span>
            <span class="menu-text">Plaintes & Suggestions</span>
            {{-- Si vous souhaitez un badge pour les nouvelles plaintes, décommentez et configurez ci-dessous --}}
            {{-- @if(isset($newComplaints) && $newComplaints > 0)
                <span class="menu-badge absolute-badge">{{ $newComplaints }}</span>
            @endif --}}
        </a>

        <div class="menu-category">Configuration</div>
         <a href="#" class="menu-item {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}"> {{-- Adjust route name --}}
            <span class="menu-icon" aria-hidden="true"><i class="fas fa-cog"></i></span>
            <span class="menu-text">Paramètres</span>
        </a>
        <a href="#" class="menu-item {{ request()->routeIs('admin.administrators.*') ? 'active' : '' }}"> {{-- Adjust route name --}}
            <span class="menu-icon" aria-hidden="true"><i class="fas fa-user-shield"></i></span>
            <span class="menu-text">Administrateurs</span>
        </a>
        <a href="#" class="menu-item {{ request()->routeIs('admin.logs.*') ? 'active' : '' }}"> {{-- Adjust route name --}}
            <span class="menu-icon" aria-hidden="true"><i class="fas fa-file-alt"></i></span>
            <span class="menu-text">Logs</span>
        </a>
    </nav>
</div>

<!-- Sidebar CSS (specific to sidebar elements) -->
<style>
    .sidebar {
        width: var(--sidebar-width);
        background-color: var(--dark);
        color: white;
        height: 100vh;
        position: fixed;
        top: 0;
        left: 0;
        z-index: 100;
        transition: var(--transition);
        box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
        display: flex;
        flex-direction: column;
    }

    .sidebar-header {
        display: flex;
        align-items: center;
        padding: 15px 20px;
        height: var(--header-height);
        background-color: rgba(0, 0, 0, 0.2);
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        flex-shrink: 0; /* Prevent shrinking */
        overflow: hidden;
    }

    .sidebar-logo {
        width: 35px;
        height: 35px;
        border-radius: 6px;
        margin-right: 10px;
        background-color: var(--primary);
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
        margin-bottom: 0; /* Reset margin */
    }

    .sidebar-menu {
        padding: 15px 0;
        overflow-y: auto;
        flex-grow: 1;
        height: calc(100vh - var(--header-height)); /* Calculate height */
         /* Custom scrollbar for sidebar menu */
        scrollbar-width: thin;
        scrollbar-color: var(--gray) rgba(255, 255, 255, 0.1);
    }
    .sidebar-menu::-webkit-scrollbar {
        width: 5px;
    }
    .sidebar-menu::-webkit-scrollbar-track {
        background: rgba(255, 255, 255, 0.1);
        border-radius: 3px;
    }
    .sidebar-menu::-webkit-scrollbar-thumb {
        background-color: var(--gray);
        border-radius: 3px;
    }
    .sidebar-menu::-webkit-scrollbar-thumb:hover {
        background-color: var(--primary);
    }


    .menu-category {
        font-size: 0.75rem;
        text-transform: uppercase;
        padding: 12px 20px 8px;
        color: var(--gray);
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
        margin: 1px 0; /* Small gap between items */
        position: relative;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        text-decoration: none;
        color: #e5e7eb; /* Lighter text color for items */
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
        background-color: var(--primary);
        border-radius: 0 2px 2px 0; /* Slight rounding */
    }

    .menu-icon {
        width: 20px;
        margin-right: 12px; /* Slightly more space */
        display: inline-flex;
        justify-content: center;
        align-items: center;
        flex-shrink: 0;
        font-size: 0.9rem; /* Adjust icon size */
    }

    .menu-text {
         transition: opacity 0.2s ease;
    }

    .menu-badge {
        background-color: var(--danger);
        color: white;
        border-radius: 10px;
        padding: 2px 8px;
        font-size: 0.7rem;
        margin-left: auto;
        transition: opacity 0.2s ease;
        flex-shrink: 0;
        line-height: 1.2; /* Adjust line height for small badges */
    }

    /* For badges that need to stay visible when collapsed */
    .menu-badge.absolute-badge {
        /* Positioning is handled by the .collapsed styles in app.blade.php */
    }

    /* Specific state styles already handled in app.blade.php CSS */
</style> 