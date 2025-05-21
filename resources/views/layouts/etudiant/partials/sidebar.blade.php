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
        
        <a href="{{ route('etudiants.boost-status') }}" class="menu-item1 {{ request()->routeIs('etudiants.boost-status') ? 'active' : '' }}"> <!-- Correction de la route pour boost-status -->
             <i class="fas fa-star"></i>
             <span>Status de boostage</span>
        </a>

        <a href="{{ route('etudiants.profile.edit') }}" class="menu-item1 {{ request()->routeIs('etudiants.profile.edit') ? 'active' : '' }}"> <!-- Correction de la route pour profile.edit -->
            <i class="fas fa-user-circle fa-fw"></i><span>Mon Profil</span>
        </a>
         
        {{-- Section CV --}}
        <div x-data="{ open: {{ request()->routeIs('etudiants.cv.*') ? 'true' : 'false' }} }"> <!-- Simplification de la condition d'ouverture -->
            <button @click="open = !open" class="menu-section-toggle {{ request()->routeIs('etudiants.cv.*') ? 'active' : '' }}">
                <i class="fas fa-id-card fa-fw"></i> <!-- Icône plus appropriée pour CV -->
                <span>Mon CV</span>
                 <i class="fas fa-chevron-down fa-fw transition-transform" :class="{ 'rotate-180': open }"></i>
            </button>
            <div x-show="open" class="menu-section-content">
                @php $cvProfileId = Auth::user()->etudiant?->cvProfile?->id ?? 0; @endphp
                <a href="{{ route('etudiants.cv.edit', ['cvProfile' => $cvProfileId]) }}" class="menu-item {{ request()->routeIs('etudiants.cv.edit') ? 'active' : '' }}"> <i class="fas fa-edit fa-fw"></i><span>Éditeur CV</span> </a> <!-- Icône modifiée -->
                <a href="{{ route('etudiants.cv.show', ['cvProfile' => $cvProfileId]) }}" class="menu-item {{ request()->routeIs('etudiants.cv.show') ? 'active' : '' }}"> <i class="fas fa-eye fa-fw"></i><span>Visualiser CV</span> </a>
            </div>
        </div>

        {{-- Section Opportunités --}}
        <div x-data="{ open: {{ request()->routeIs('opportunites.*') || request()->routeIs('etudiants.offres.*') || request()->routeIs('etudiants.candidatures.*') || request()->routeIs('etudiants.evenements.*') ? 'true' : 'false' }} }">
            <button @click="open = !open" class="menu-section-toggle {{ request()->routeIs('opportunites.*') || request()->routeIs('etudiants.offres.*') || request()->routeIs('etudiants.candidatures.*') || request()->routeIs('etudiants.evenements.*') ? 'active' : '' }}">
                <i class="fas fa-briefcase fa-fw"></i>
                <span>Opportunités</span>
                 <i class="fas fa-chevron-down fa-fw transition-transform" :class="{ 'rotate-180': open }"></i>
            </button>
            <div x-show="open" class="menu-section-content">
                <a href="#" class="menu-item">
                    <i class="fas fa-newspaper fa-fw"></i>
                    <span>Actualités</span>
                </a>
                <a href="{{ route('etudiants.offres.index') }}" class="menu-item {{ request()->routeIs('etudiants.offres.index') || request()->routeIs('etudiants.offres.show') ? 'active' : '' }}">
                    <i class="fas fa-search-dollar fa-fw"></i> <!-- Icône modifiée -->
                    <span>Offres disponibles</span>
                </a>
                <a href="{{ route('etudiants.candidatures.index') }}" class="menu-item {{ request()->routeIs('etudiants.candidatures.index') ? 'active' : '' }}">
                    <i class="fas fa-file-signature fa-fw"></i> <!-- Icône modifiée -->
                    <span>Mes candidatures</span>
                </a>
                <a href="#" class="menu-item">
                     <i class="fas fa-building fa-fw"></i>
                     <span>Entreprises suivies</span>
                </a>
                 <a href="{{ route('etudiants.evenements.upcoming') }}" class="menu-item {{ request()->routeIs('etudiants.evenements.upcoming') || request()->routeIs('etudiants.evenements.show') ? 'active' : '' }}">
                     <i class="fas fa-calendar-day fa-fw"></i>
                     <span>Événements</span>
                 </a>
            </div>
        </div>

         {{-- Section Communication & Suivi --}}
         <div x-data="{ open: {{ request()->routeIs('communication.*') || request()->routeIs('etudiants.examen') || request()->routeIs('messagerie-sociale.*') || request()->routeIs('etudiants.complaints.*') ? 'true' : 'false' }} }">
            <button @click="open = !open" class="menu-section-toggle {{ request()->routeIs('communication.*') || request()->routeIs('etudiants.examen') || request()->routeIs('messagerie-sociale.*') || request()->routeIs('etudiants.complaints.*') ? 'active' : '' }}">
                 <i class="fas fa-comments fa-fw"></i>
                 <span>Communication</span>
                  <i class="fas fa-chevron-down fa-fw transition-transform" :class="{ 'rotate-180': open }"></i>
             </button>
             <div x-show="open" class="menu-section-content">
                 <a href="{{ route('messagerie-sociale.index') }}" class="menu-item {{ request()->routeIs('messagerie-sociale.*') ? 'active' : '' }}">
                     <i class="fas fa-bullhorn fa-fw"></i>
                     <span>Canal d'annonces</span>
                 </a>
                 @if(Auth::user()->etudiant)
                    <a href="{{ route('etudiants.examen', ['etudiant_id' => Auth::user()->etudiant->id]) }}" class="menu-item {{ request()->routeIs('etudiants.examen') ? 'active' : '' }}"> <i class="fas fa-chalkboard-teacher fa-fw"></i><span>Entretiens</span> </a> <!-- Icône modifiée -->
                 @endif
                 <a href="{{ route('etudiants.complaints.index') }}" class="menu-item {{ request()->routeIs('etudiants.complaints.*') ? 'active' : '' }}">
                     <i class="fas fa-comment-dots fa-fw"></i> <!-- Icône modifiée -->
                     <span>Suggestions/Plaintes</span>
                 </a>
                  <a href="#" class="menu-item">
                    <i class="fas fa-calendar-alt fa-fw"></i>
                    <span>Agenda</span>
                 </a>
             </div>
         </div>

         {{-- Section Apprentissage & Développement --}}
         <div x-data="{ open: {{ request()->routeIs('apprentissage.*') ? 'true' : 'false' }} }">
            <button @click="open = !open" class="menu-section-toggle {{ request()->routeIs('apprentissage.*') ? 'active' : '' }}">
                 <i class="fas fa-graduation-cap fa-fw"></i>
                 <span>Apprentissage</span>
                  <i class="fas fa-chevron-down fa-fw transition-transform" :class="{ 'rotate-180': open }"></i>
             </button>
             <div x-show="open" class="menu-section-content">
                 <a href="https://fhcschoolbenin.com/" target="_blank" class="menu-item">
                     <i class="fas fa-school fa-fw"></i> <!-- Icône modifiée -->
                     <span>Cours en ligne</span>
                 </a>
                 <a href="#" class="menu-item">
                     <i class="fas fa-blog fa-fw"></i>
                     <span>Blog</span>
                 </a>
                 <a href="#" class="menu-item">
                     <i class="fas fa-bullseye fa-fw"></i>
                     <span>Objectifs</span>
                 </a>
             </div>
         </div>
         
        <a href="{{ route('logout') }}" class="menu-item1" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="fas fa-sign-out-alt fa-fw"></i><span>Déconnexion</span>
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;"> @csrf </form>

        {{-- SÉPARATEUR --}}
        <hr class="sidebar-separator">

        {{-- TITRE DE LA NOUVELLE SECTION --}}
        <div class="sidebar-section-title">Autres produits du groupe FHC</div>

        {{-- LISTE DES AUTRES PRODUITS --}}
        <a href="https://fhcschoolbenin.com/" target="_blank" class="menu-item1">
            <i class="fas fa-graduation-cap fa-fw"></i><span>Hosanna School</span>
        </a>
        <a href="https://www.africa-location.com/" target="_blank" class="menu-item1">
            <i class="fas fa-map-marked-alt fa-fw"></i><span>Africa Location</span>
        </a>
        
        {{-- Ajoutez d'autres liens ici si nécessaire --}}

    </nav>

    {{-- Styles pour les sections dépliables ET NOUVEAUX ÉLÉMENTS --}}
    <style>
        /* ... (Styles existants - inchangés) ... */
        .menu-item1 {
            display: flex;
            align-items: center;
            padding: 12px 15px;
            color: rgb(24, 22, 22);
            text-decoration: none;
            transition: background-color 0.2s ease, color 0.2s ease, border-color 0.2s ease;
            width: 100%;
            background: none;
            border: none;
            text-align: left;
            font-size: 1em;
            font-family: inherit;
            cursor: pointer;
            border-left: 3px solid transparent;
        }
        .menu-item1 > i:first-child {
            width: 20px;
            text-align: center;
            flex-shrink: 0;
        }
        .menu-item1 span {
            flex-grow: 1;
            margin-left: 10px;
        }
        .sidebar-menu .menu-item,
        .sidebar-menu .menu-section-toggle {
            display: flex;
            align-items: center;
            padding: 12px 15px;
            color: rgb(24, 22, 22);
            text-decoration: none;
            transition: background-color 0.2s ease, color 0.2s ease, border-color 0.2s ease;
            width: 100%;
            background: none;
            border: none;
            text-align: left;
            font-size: 1em;
            font-family: inherit;
            cursor: pointer;
            border-left: 3px solid transparent;
        }
        .sidebar-menu .menu-item span,
        .sidebar-menu .menu-section-toggle span {
            flex-grow: 1;
            margin-left: 10px;
        }
        .sidebar-menu .menu-item > i:first-child,
        .sidebar-menu .menu-section-toggle > i:first-child {
            width: 20px;
            text-align: center;
            flex-shrink: 0;
        }
        .sidebar-menu .menu-item:hover,
        .sidebar-menu .menu-section-toggle:hover,
        .menu-item1:hover { /* Ajout pour les liens directs aussi */
            background-color: rgba(0, 0, 0, 0.05);
            color: rgb(0, 0, 0);
            border-left-color: rgba(0, 0, 0, 0.2);
        }
        .sidebar-menu .menu-item.active,
        .menu-item1.active { /* Ajout pour les liens directs aussi */
            background-color: rgba(59, 130, 246, 0.1);
            color: #0056b3;
            font-weight: 500;
            border-left-color: #3b82f6;
        }
        .menu-section-toggle {
            font-weight: 500;
        }
        .menu-section-toggle.active {
            background-color: transparent;
            color: rgb(0, 0, 0);
        }
        .menu-section-toggle .fa-chevron-down {
            margin-left: 10px;
            transition: transform 0.3s ease;
            font-size: 0.8em;
            flex-shrink: 0;
        }
        .menu-section-toggle .rotate-180 {
             transform: rotate(180deg);
        }
        .menu-section-content {
            overflow: hidden;
            padding-top: 5px;
            padding-bottom: 5px;
        }
        .menu-section-content .menu-item {
            padding-left: 33px;
            font-size: 0.95em;
            color: #444444;
            border-left-style: none;
        }
        .menu-section-content .menu-item:hover {
            background-color: rgba(0, 0, 0, 0.05);
            color: #000000;
            border-left-style: none;
        }
        .menu-section-content .menu-item.active {
            background-color: rgba(59, 130, 246, 0.1);
            color: #0056b3;
            font-weight: normal;
            border-left-style: none;
        }

        /* NOUVEAUX STYLES */
        .sidebar-separator {
            border: none;
            border-top: 1px solid rgba(0, 0, 0, 0.1); /* Couleur de séparateur subtile */
            margin: 15px 15px; /* Marge autour du séparateur */
        }

        .sidebar-section-title {
            padding: 10px 15px 5px 15px; /* Espacement pour le titre */
            font-size: 0.9em; /* Taille de police légèrement plus petite */
            font-weight: 600; /* Titre en gras */
            color: #555; /* Couleur de texte pour le titre */
            text-transform: uppercase; /* Optionnel: mettre en majuscules */
            letter-spacing: 0.5px; /* Optionnel: espacement des lettres */
        }
    </style>
</aside>