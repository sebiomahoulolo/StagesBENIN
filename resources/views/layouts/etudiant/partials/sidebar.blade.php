<aside class="app-sidebar" :class="{ 'open': isSidebarOpen }">
    {{-- Bouton Fermer (X) visible seulement quand sidebar ouverte sur petit écran --}}
    <button class="sidebar-close-btn" @click="isSidebarOpen = false" aria-label="Fermer le menu">
        <i class="fas fa-times"></i>
    </button>

    <nav class="sidebar-menu">
        {{-- Tableau de bord (toujours visible) --}}
        <a href="{{ route('etudiants.dashboard') }}" class="menu-item1 {{ request()->routeIs('etudiants.dashboard') ? 'active' : '' }}">
            <i class="fas fa-home fa-fw"></i><span>Tableau de bord</span>
        </a>

        <a href="{{ route('etudiants.boostage') }}" class="menu-item1 {{ request()->routeIs('etudiants.boostage') ? 'active' : '' }}">
             <i class="fas fa-rocket fa-fw"></i>
             <span>Boostage</span>
        </a>

        <a href="{{ route('etudiants.profile.edit') }}" class="menu-item1 {{ request()->routeIs('profile.edit') ? 'active' : '' }}">
            <i class="fas fa-user-circle fa-fw"></i><span>Mon Profil</span>
        </a>
         
        {{-- Section CV --}}
        <div x-data="{ open: {{ request()->routeIs('etudiants.cv.*') || request()->routeIs('cvtheque.route') ? 'true' : 'false' }} }">
            <!-- <button @click="open = !open" class="menu-section-toggle {{ request()->routeIs('etudiants.cv.*') || request()->routeIs('cvtheque.route') ? 'active' : '' }}">
                <i class="fas fa-id-card fa-fw"></i>
                <span>Mon CV</span>
                <i class="fas fa-chevron-down fa-fw transition-transform" :class="{ 'rotate-180': open }"></i>
            </button> -->

            <button @click="open = !open" class="menu-section-toggle {{ request()->routeIs('opportunites.*') ? 'active' : '' }}">
                <i class="fas fa-briefcase fa-fw"></i>
                <span>Mon CV</span>
                 <i class="fas fa-chevron-down fa-fw transition-transform" :class="{ 'rotate-180': open }"></i>
            </button>
            <div x-show="open" class="menu-section-content">
                @php $cvProfileId = Auth::user()->etudiant?->cvProfile?->id ?? 0; @endphp
                <a href="{{ route('etudiants.cv.edit', ['cvProfile' => $cvProfileId]) }}" class="menu-item {{ request()->routeIs('etudiants.cv.edit') ? 'active' : '' }}"> <i class="fas fa-file-alt fa-fw"></i><span>Éditeur CV</span> </a>
                <a href="{{ route('etudiants.cv.show', ['cvProfile' => $cvProfileId]) }}" class="menu-item {{ request()->routeIs('etudiants.cv.show') ? 'active' : '' }}"> <i class="fas fa-eye fa-fw"></i><span>Visualiser CV</span> </a>
                 
            </div>
        </div>

        {{-- Section Opportunités --}}
        <div x-data="{ open: {{ request()->routeIs('opportunites.*') || request()->routeIs('etudiants.offres.*') ? 'true' : 'false' }} }"> {{-- Ajustez les routes ici --}}
            <button @click="open = !open" class="menu-section-toggle {{ request()->routeIs('opportunites.*') || request()->routeIs('etudiants.offres.*') ? 'active' : '' }}">
                <i class="fas fa-briefcase fa-fw"></i>
                <span>Opportunités</span>
                 <i class="fas fa-chevron-down fa-fw transition-transform" :class="{ 'rotate-180': open }"></i>
            </button>
            <div x-show="open" class="menu-section-content">
                <a href="#" class="menu-item"> {{-- Route Actualités --}}
                    <i class="fas fa-newspaper fa-fw"></i>
                    <span>Actualités</span>
                </a>
                <a href="{{ route('etudiants.offres.index') }}" class="menu-item {{ request()->routeIs('etudiants.offres.*') ? 'active' : '' }}"> {{-- Route Offres --}}
                    <i class="fas fa-briefcase fa-fw"></i>
                    <span>Offres disponibles</span>
                     {{-- <span class="notifications-badge">5</span> --}}
                </a>
                <a href="{{ route('etudiants.offres.mes-candidatures') }}" class="menu-item {{ request()->routeIs('etudiants.offres.mes-candidatures') ? 'active' : '' }}"> {{-- Route Mes candidatures --}}
                    <i class="fas fa-file-alt fa-fw"></i>
                    <span>Mes candidatures</span>
                </a>
                <a href="#" class="menu-item"> {{-- Route Entreprises suivies --}}
                     <i class="fas fa-building fa-fw"></i>
                     <span>Entreprises suivies</span>
                </a>
                 <a href="{{ route('etudiants.evenements.upcoming') }}" class="menu-item {{ request()->routeIs('etudiants.evenements.upcoming') ? 'active' : '' }}"> {{-- Route Événements --}}
                     <i class="fas fa-calendar-day fa-fw"></i>
                     <span>Événements</span>
                 </a>
            </div>
        </div>

         {{-- Section Communication & Suivi --}}
         <div x-data="{ open: {{ request()->routeIs('communication.*') || request()->routeIs('etudiants.examen') || request()->routeIs('messaging.*') || request()->routeIs('messagerie-sociale.*') ? 'true' : 'false' }} }"> {{-- Ajoutez messaging.* --}}
            <button @click="open = !open" class="menu-section-toggle {{ request()->routeIs('communication.*') || request()->routeIs('etudiants.examen') || request()->routeIs('messaging.*') || request()->routeIs('messagerie-sociale.*') ? 'active' : '' }}">
                 <i class="fas fa-comments fa-fw"></i>
                 <span>Communication</span>
                  <i class="fas fa-chevron-down fa-fw transition-transform" :class="{ 'rotate-180': open }"></i>
             </button>
             <div x-show="open" class="menu-section-content">
                 <a href="{{ route('messagerie-sociale.index') }}" class="menu-item {{ request()->routeIs('messagerie-sociale.*') ? 'active' : '' }}">
                     <i class="fas fa-bullhorn fa-fw"></i>
                     <span>Canal d'annonces</span>
                 </a>
                 {{-- Commenté l'ancienne messagerie --}}
                 {{-- <a href="{{ route('messaging.index') }}" class="menu-item {{ request()->routeIs('messaging.*') ? 'active' : '' }}">
                     <i class="fas fa-envelope fa-fw"></i>
                     <span>Messagerie</span>
                     @auth
                         @if(Auth::user()->unreadMessagesCount() > 0)
                             <span class="notifications-badge">{{ Auth::user()->unreadMessagesCount() }}</span>
                         @endif
                     @endauth
                 </a> --}}
                 @if(Auth::user()->etudiant)
                    <a href="{{ route('etudiants.examen', ['etudiant_id' => Auth::user()->etudiant->id]) }}" class="menu-item {{ request()->routeIs('etudiants.examen') ? 'active' : '' }}"> <i class="fas fa-comments fa-fw"></i><span>Entretiens</span> </a>
                 @endif
                 <a href="{{ route('etudiants.complaints.index') }}" class="menu-item {{ request()->routeIs('etudiants.complaints.*') ? 'active' : '' }}">
                     <i class="fas fa-comment-alt fa-fw"></i>
                     <span>Suggestions/Plaintes</span>
                 </a>
                  <a href="#" class="menu-item"> {{-- Route Agenda --}}
                    <i class="fas fa-calendar-alt fa-fw"></i>
                    <span>Agenda</span>
                 </a>
             </div>
         </div>

         {{-- Section Apprentissage & Développement --}}
         <div x-data="{ open: {{ request()->routeIs('apprentissage.*') ? 'true' : 'false' }} }"> {{-- Ajustez les routes ici --}}
            <button @click="open = !open" class="menu-section-toggle {{ request()->routeIs('apprentissage.*') ? 'active' : '' }}">
                 <i class="fas fa-graduation-cap fa-fw"></i>
                 <span>Apprentissage</span>
                  <i class="fas fa-chevron-down fa-fw transition-transform" :class="{ 'rotate-180': open }"></i>
             </button>
             <div x-show="open" class="menu-section-content">
                 <a href="https://fhcschoolbenin.com/" target="_blank" class="menu-item"> {{-- Route Cours en ligne --}}
                     <i class="fas fa-graduation-cap fa-fw"></i>
                     <span>Cours en ligne</span>
                 </a>
                 <a href="#" class="menu-item"> {{-- Route Blog --}}
                     <i class="fas fa-blog fa-fw"></i>
                     <span>Blog</span>
                 </a>
                 <a href="#" class="menu-item"> {{-- Route Objectifs --}}
                     <i class="fas fa-bullseye fa-fw"></i>
                     <span>Objectifs</span>
                 </a>

             </div>
         </div>
         

        {{-- Section Compte (éléments restants toujours visibles ou groupés différemment si nécessaire) --}}
       
        <a href="{{ route('logout') }}" class="menu-item1" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="fas fa-sign-out-alt fa-fw"></i><span>Déconnexion</span>
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;"> @csrf </form>
    </nav>

    {{-- Styles pour les sections dépliables (FORTEMENT RECOMMANDÉ de déplacer dans un fichier CSS dédié) --}}
    <style>
        /* Base styles for all items and toggles */
        .menu-item1 {
            display: flex;
            align-items: center;
            padding: 12px 15px;
            /* color: #e0e0e0; */ /* Light color for dark bg */
            color: rgb(24, 22, 22); /* User preference - dark color for light bg */
            text-decoration: none;
            transition: background-color 0.2s ease, color 0.2s ease, border-color 0.2s ease;
            width: 100%;
            background: none;
            border: none;
            text-align: left;
            font-size: 1em;
            font-family: inherit;
            cursor: pointer;
            border-left: 3px solid transparent; /* Add space for active indicator */
        }

        /* Icon alignment for menu-item1 */
        .menu-item1 > i:first-child {
            width: 20px;
            text-align: center;
            flex-shrink: 0;
        }

        /* Span alignment for menu-item1 */
        .menu-item1 span {
            flex-grow: 1;
            margin-left: 10px; /* Space between icon and text */
        }

        .sidebar-menu .menu-item,
        .sidebar-menu .menu-section-toggle {
            display: flex;
            align-items: center;
            padding: 12px 15px;
            /* color: #e0e0e0; */ /* Light color for dark bg */
            color: rgb(24, 22, 22); /* User preference - dark color for light bg */
            text-decoration: none;
            transition: background-color 0.2s ease, color 0.2s ease, border-color 0.2s ease;
            width: 100%;
            background: none;
            border: none;
            text-align: left;
            font-size: 1em;
            font-family: inherit;
            cursor: pointer;
            border-left: 3px solid transparent; /* Add space for active indicator */
        }

        /* Ensure spans take up available space for alignment */
        .sidebar-menu .menu-item span,
        .sidebar-menu .menu-section-toggle span {
            flex-grow: 1;
            margin-left: 10px; /* Space between icon and text */
        }

        /* Icons alignment - Ensure consistency for first icon */
        .sidebar-menu .menu-item > i:first-child,
        .sidebar-menu .menu-section-toggle > i:first-child {
            width: 20px;
            text-align: center;
            flex-shrink: 0; /* Prevent icon from shrinking */
        }

        /* Hover state - adjusted for light background */
        .sidebar-menu .menu-item:hover,
        .sidebar-menu .menu-section-toggle:hover {
            background-color: rgba(0, 0, 0, 0.05); /* Subtle dark hover background */
            color: rgb(0, 0, 0); /* Slightly darker/bolder text on hover */
            border-left-color: rgba(0, 0, 0, 0.2); /* Subtle dark hover indicator */
        }

        /* Active state for menu items - adjusted for light background */
        .sidebar-menu .menu-item.active {
            background-color: rgba(59, 130, 246, 0.1); /* Light blue active background */
            color: #0056b3; /* Darker blue text for active item */
            font-weight: 500;
            border-left-color: #3b82f6; /* Blue active indicator */
        }

        /* Specific styles for section toggles */
        .menu-section-toggle {
            /* justify-content: space-between; */ /* Removed: Rely on flex-grow on span */
            font-weight: 500;
        }

        /* Active state for section toggles (when open OR child active) - adjusted for light background */
        .menu-section-toggle.active {
            background-color: transparent; /* Keep transparent */
            color: rgb(0, 0, 0); /* Darker text if section is active/open */
            /* border-left-color: rgba(0, 0, 0, 0.2); */ /* Optional indicator, might conflict with item active state */
        }

        /* Chevron icon specific styles */
        .menu-section-toggle .fa-chevron-down {
            margin-left: 10px; /* Add some space between text and chevron */
            margin-right: 0;
            transition: transform 0.3s ease;
            font-size: 0.8em;
            flex-shrink: 0; /* Prevent chevron from shrinking */
        }

        .menu-section-toggle .rotate-180 {
             transform: rotate(180deg);
        }

        /* Container for sub-items */
        .menu-section-content {
            overflow: hidden;
            /* Removed background color - rely on item states */
            /* background-color: rgba(0, 0, 0, 0.1); */
            padding-top: 5px; /* Add some space above sub-items */
            padding-bottom: 5px; /* Add some space below sub-items */
        }

        /* Sub-items specific style - adjusted for light background */
        .menu-section-content .menu-item {
            padding-left: 33px;
            font-size: 0.95em;
            color: #444444; /* Darker grey for sub-items on light bg */
            border-left-style: none;
        }

        /* Hover state for sub-items - adjusted for light background */
        .menu-section-content .menu-item:hover {
            background-color: rgba(0, 0, 0, 0.05);
            color: #000000;
            border-left-style: none;
        }

        /* Active state for sub-items - adjusted for light background */
        .menu-section-content .menu-item.active {
            background-color: rgba(59, 130, 246, 0.1);
            color: #0056b3;
            font-weight: normal;
            border-left-style: none;
        }
         /* Optional: Add a dot or line for active sub-item */
        /* .menu-section-content .menu-item.active::before {
            content: '';
            position: absolute;
            left: 15px; 
            top: 50%;
            transform: translateY(-50%);
            width: 4px;
            height: 4px;
            background-color: #3b82f6; 
            border-radius: 50%;
        } */

    </style>
</aside>