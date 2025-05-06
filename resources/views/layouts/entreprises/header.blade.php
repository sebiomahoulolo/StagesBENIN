<header class="header" id="header">
    <button class="toggle-sidebar" id="toggle-sidebar-btn" aria-label="Basculer la barre latérale" data-bs-toggle="tooltip" data-bs-placement="right" title="Basculer Menu">
        <i class="fas fa-bars"></i>
    </button>

    <!-- <div class="logo">
        <i class="fas fa-building"></i>
        <span>{{ Auth::user()->name ?? 'Entreprise' }}</span>
    </div> -->

    <div class="search-bar">
        <i class="fas fa-search search-icon"></i>
        <input type="search" class="form-control form-control-sm" placeholder="Rechercher..." aria-label="Rechercher">
    </div>

    <div class="header-actions">
        {{-- Notifications Dropdown --}}
        <div class="dropdown">
            <button class="header-icon" id="notificationsDropdown" data-bs-toggle="dropdown" aria-expanded="false" aria-label="Notifications" data-bs-tooltip="tooltip" title="Notifications">
                <i class="fas fa-bell"></i>
                <span class="notification-badge">5</span>
            </button>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="notificationsDropdown">
              <li><a class="dropdown-item" href="#">Notification 1</a></li>
              <li><a class="dropdown-item" href="#">Notification 2</a></li>
              <li><hr class="dropdown-divider"></li>
              <li><a class="dropdown-item" href="#">Voir toutes les notifications</a></li>
            </ul>
        </div>

        {{-- Messages Dropdown --}}
        <div class="dropdown">
            <button class="header-icon" id="messagesDropdown" data-bs-toggle="dropdown" aria-expanded="false" aria-label="Messages" data-bs-tooltip="tooltip" title="Messages">
                <i class="fas fa-envelope"></i>
                <span class="notification-badge">3</span>
            </button>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="messagesDropdown">
              <li><a class="dropdown-item" href="#">Message 1</a></li>
              <li><a class="dropdown-item" href="#">Message 2</a></li>
              <li><hr class="dropdown-divider"></li>
              <li><a class="dropdown-item" href="#">Voir tous les messages</a></li>
            </ul>
        </div>

        {{-- User Profile Dropdown --}}
        <div class="dropdown">
            <div class="user-profile" id="userProfileDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false" aria-label="Profil utilisateur">
                <div class="profile-image">
                    @if(Auth::user()->entreprise && Auth::user()->entreprise->logo_path)
                        <img src="{{ asset(Auth::user()->entreprise->logo_path) }}" alt="Logo entreprise" class="profile-logo">
                    @else
                        {{ strtoupper(substr(Auth::user()->name ?? 'Entreprise', 0, 1)) }}
                    @endif
                </div>
                <div class="profile-info">
                    <span class="profile-name">{{ Auth::user()->name ?? 'Entreprise' }}</span>
                    <span class="profile-role">Administrateur</span>
                </div>
                <i class="fas fa-chevron-down ms-2 small text-muted"></i>
            </div>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userProfileDropdown">
              <li><a class="dropdown-item" href="{{ route('entreprises.profile.edit') }}"><i class="fas fa-user-circle me-2"></i> Mon Profil</a></li>
              <li><a class="dropdown-item" href="#"><i class="fas fa-cog me-2"></i> Paramètres</a></li>
              <li><hr class="dropdown-divider"></li>
              <li>
                  <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="dropdown-item text-danger">
                        <i class="fas fa-sign-out-alt me-2"></i> Déconnexion
                    </button>
                  </form>
              </li>
            </ul>
        </div>
    </div>
</header>

<style>
    .header {
        height: var(--header-height, 60px);
        background-color: white;
        display: flex;
        align-items: center;
        padding: 0 20px;
        position: sticky;
        top: 0;
        z-index: 99;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.06);
        border-bottom: 1px solid var(--border-color, #e5e7eb);
    }

    .toggle-sidebar {
        margin-right: 15px;
        background: none;
        border: none;
        font-size: 1.3rem;
        cursor: pointer;
        color: var(--dark, #1f2937);
        padding: 5px;
        line-height: 1;
    }
    
    .toggle-sidebar:hover {
        color: var(--primary, #3498db);
    }

    .logo {
        display: flex;
        align-items: center;
        font-size: 1.2rem;
        font-weight: bold;
        margin-right: 25px;
        color: var(--primary, #3498db);
    }
    
    .logo i {
        margin-right: 8px;
    }

    .search-bar {
        flex: 1;
        max-width: 400px;
        position: relative;
        margin-right: 20px;
    }

    .search-bar input {
        width: 100%;
        padding: 6px 12px 6px 35px;
        border-radius: var(--border-radius, 8px);
        border: 1px solid var(--border-color, #e5e7eb);
        background-color: var(--light, #f9fafb);
        font-size: 0.9rem;
    }
    
    .search-bar input:focus {
        outline: none;
        border-color: var(--primary, #3498db);
        box-shadow: 0 0 0 2px rgba(52, 152, 219, 0.2);
        background-color: white;
    }

    .search-icon {
        position: absolute;
        left: 12px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--gray, #6b7280);
        font-size: 0.9rem;
    }

    .header-actions {
        display: flex;
        align-items: center;
        margin-left: auto;
        gap: 8px;
    }

    .header-icon {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        position: relative;
        transition: all 0.3s ease;
        color: var(--gray, #6b7280);
        border: none;
        background: none;
    }

    .header-icon:hover {
        background-color: var(--light, #f9fafb);
        color: var(--primary, #3498db);
    }

    .notification-badge {
        position: absolute;
        top: 4px;
        right: 4px;
        width: 18px;
        height: 18px;
        border-radius: 50%;
        background-color: var(--danger, #e74c3c);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.7rem;
        font-weight: bold;
        border: 1px solid white;
    }

    .user-profile {
        display: flex;
        align-items: center;
        margin-left: 10px;
        cursor: pointer;
        position: relative;
        padding: 5px;
        border-radius: var(--border-radius, 8px);
        transition: background-color 0.2s ease;
    }
    
    .user-profile:hover {
        background-color: var(--light, #f9fafb);
    }

    .profile-image {
        width: 35px;
        height: 35px;
        border-radius: 50%;
        background-color: var(--primary, #3498db);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        margin-right: 10px;
        font-size: 0.9rem;
        overflow: hidden;
    }

    .profile-logo {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 50%;
    }

    .profile-info { 
        display: flex; 
        flex-direction: column; 
        line-height: 1.2; 
    }
    
    .profile-name { 
        font-size: 0.9rem; 
        font-weight: 500; 
        color: var(--dark, #1f2937); 
    }
    
    .profile-role { 
        font-size: 0.75rem; 
        color: var(--gray, #6b7280); 
    }

    .dropdown-menu {
        border-radius: var(--border-radius, 8px);
        border: 1px solid var(--border-color, #e5e7eb);
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.08);
        padding: 0.5rem 0;
        font-size: 0.9rem;
    }
    
    .dropdown-item {
        padding: 0.5rem 1rem;
        display: flex;
        align-items: center;
    }
    
    .dropdown-item i {
        width: 18px;
        margin-right: 8px;
        text-align: center;
        color: var(--gray, #6b7280);
    }
    
    .dropdown-item:active {
        background-color: var(--primary, #3498db);
        color: white;
    }
    
    .dropdown-item.text-danger:active {
        background-color: var(--danger, #e74c3c);
        color: white;
    }
    
    .dropdown-item.text-danger:active i {
        color: white;
    }

    @media (max-width: 992px) {
        .profile-info { display: none; }
    }

    @media (max-width: 768px) {
        .search-bar { max-width: 200px; }
        .header-actions { gap: 2px; }
        .user-profile { margin-left: 5px; }
        .profile-image { margin-right: 0; }
    }

    @media (max-width: 576px) {
        .header { padding: 0 15px; }
        .search-bar { display: none; }
    }
</style>