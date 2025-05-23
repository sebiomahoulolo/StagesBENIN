<!-- Header Structure -->
<header class="header" id="header">
    <button class="toggle-sidebar" id="toggle-sidebar-btn" aria-label="Basculer la barre latérale" data-bs-toggle="tooltip" data-bs-placement="right" title="Basculer Menu">
        <i class="fas fa-bars"></i>
    </button>

<!--div class="search-bar">
        <i class="fas fa-search search-icon"></i>
        <input type="search" class="form-control form-control-sm" placeholder="Rechercher..." aria-label="Rechercher">
    </div-->

    <div class="header-actions">
        {{-- Notifications Dropdown/Link
        <div class="dropdown">
            <button class="header-icon" id="notificationsDropdown" data-bs-toggle="dropdown" aria-expanded="false" aria-label="Notifications" data-bs-tooltip="tooltip" title="Notifications">
                <i class="fas fa-bell"></i>
                 {{-- Optional: Add badge for unread notifications --}}
                 {{-- <span class="notification-badge"></span> --}}
            {{--</button>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="notificationsDropdown">
              <li><a class="dropdown-item" href="#">Notification 1</a></li>
              <li><a class="dropdown-item" href="#">Notification 2</a></li>
              <li><hr class="dropdown-divider"></li>
              <li><a class="dropdown-item" href="#">Voir toutes les notifications</a></li>
            </ul>
        </div> --}}

         {{-- Messages Dropdown/Link
         <div class="dropdown">
            <button class="header-icon" id="messagesDropdown" data-bs-toggle="dropdown" aria-expanded="false" aria-label="Messages" data-bs-tooltip="tooltip" title="Messages">
                <i class="fas fa-envelope"></i>
                {{-- Optional: Add badge for unread messages --}}
                {{-- <span class="notification-badge"></span> --}}
              {{-- </button>
             <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="messagesDropdown">
              <li><a class="dropdown-item" href="#">Message de Jean</a></li>
              <li><a class="dropdown-item" href="#">Message de Marie</a></li>
              <li><hr class="dropdown-divider"></li>
              <li><a class="dropdown-item" href="#">Voir tous les messages</a></li>
            </ul>
         </div> --}}

        {{-- User Profile Dropdown --}}
        <div class="dropdown">
            <div class="user-profile" id="userProfileDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false" aria-label="Profil utilisateur">
                <div class="profile-image">
                    {{-- Display initials or image --}}
                     {{ strtoupper(substr(Auth::user()->name ?? 'Admin', 0, 1)) }}
                    {{-- <img src="path/to/user.jpg" alt="Photo de profil"> --}}
                </div>
                <div class="profile-info">
                    <span class="profile-name">{{ Auth::user()->name ?? 'Administrateur' }}</span>
                    <span class="profile-role">{{ Auth::user()->role ?? 'Admin' }}</span> {{-- Assuming user has a role --}}
                </div>
                <i class="fas fa-chevron-down ms-2 small text-muted"></i>
            </div>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userProfileDropdown">
              <li><a class="dropdown-item" href="#"><i class="fas fa-user-circle me-2"></i> Mon Profil</a></li>
              <li><a class="dropdown-item" href="#"><i class="fas fa-cog me-2"></i> Paramètres</a></li>
              <li><hr class="dropdown-divider"></li>
              <li>
                  <form method="POST" action="{{ route('logout') }}"> {{-- Adjust if logout route name is different --}}
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

<!-- Header CSS (specific to header elements) -->
<style>
    .header {
        height: var(--header-height);
        background-color: white;
        display: flex;
        align-items: center;
        padding: 0 20px;
        position: sticky;
        top: 0;
        z-index: 99; /* Below sidebar */
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.06);
        border-bottom: 1px solid var(--border-color);
    }

    .toggle-sidebar {
        margin-right: 15px;
        background: none;
        border: none;
        font-size: 1.3rem;
        cursor: pointer;
        color: var(--dark);
        padding: 5px;
        line-height: 1;
    }
     .toggle-sidebar:hover {
         color: var(--primary);
     }

    .search-bar {
        flex: 1;
        max-width: 400px;
        position: relative;
        margin-right: 20px;
    }

    .search-bar input {
        width: 100%;
        padding: 6px 12px 6px 35px; /* Adjust padding for icon */
        border-radius: var(--border-radius);
        border: 1px solid var(--border-color);
        background-color: var(--light);
        font-size: 0.9rem;
    }
    .search-bar input:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 2px rgba(37, 99, 235, 0.2);
        background-color: white;
    }

    .search-icon {
        position: absolute;
        left: 12px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--gray);
        font-size: 0.9rem;
    }

    .header-actions {
        display: flex;
        align-items: center;
        margin-left: auto;
        gap: 8px; /* Slightly increased gap */
    }

    .header-icon {
        width: 38px; /* Slightly larger */
        height: 38px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        position: relative;
        transition: var(--transition);
        color: var(--gray);
        border: none;
        background: none;
    }

    .header-icon:hover {
        background-color: var(--light);
        color: var(--primary);
    }

    .notification-badge {
        position: absolute;
        top: 4px;
        right: 4px;
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background-color: var(--danger);
        border: 1px solid white;
    }

    .user-profile {
        display: flex;
        align-items: center;
        margin-left: 10px; /* Adjusted margin */
        cursor: pointer;
        position: relative;
        padding: 5px;
        border-radius: var(--border-radius);
        transition: background-color 0.2s ease;
    }
     .user-profile:hover {
         background-color: var(--light);
     }

    .profile-image {
        width: 35px;
        height: 35px;
        border-radius: 50%;
        background-color: var(--primary);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        margin-right: 10px;
        font-size: 0.9rem;
        overflow: hidden; /* Ensure image fits */
    }
    .profile-image img {
         width: 100%;
         height: 100%;
         object-fit: cover;
    }

    .profile-info { display: flex; flex-direction: column; line-height: 1.2; }
    .profile-name { font-size: 0.9rem; font-weight: 500; color: var(--dark); }
    .profile-role { font-size: 0.75rem; color: var(--gray); }

     /* Dropdown adjustments */
     .dropdown-menu {
        border-radius: var(--border-radius);
        border: 1px solid var(--border-color);
        box-shadow: var(--box-shadow);
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
         color: var(--gray);
     }
      .dropdown-item:active {
          background-color: var(--primary);
          color: white;
      }
      .dropdown-item.text-danger:active {
          background-color: var(--danger);
          color: white;
      }
      .dropdown-item.text-danger:active i {
          color: white;
      }

    /* Responsive handled in app.blade.php CSS */

</style> 