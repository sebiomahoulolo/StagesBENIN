<header class="app-header">
    <div class="header-start">
        {{-- Bouton Toggle Sidebar --}}
        <button class="sidebar-toggle-btn" @click="isSidebarOpen = !isSidebarOpen" aria-label="Ouvrir/Fermer le menu">
            <i x-show="!isSidebarOpen" class="fas fa-bars"></i>
            <i x-show="isSidebarOpen" class="fas fa-times" x-cloak></i>
        </button>
        {{-- Logo --}}
        <a href="{{ route('etudiants.dashboard') }}" class="logo">
            <i class="fas fa-briefcase"></i>
            <span class="logo-text">{{ config('app.name', 'StagesBENIN') }}</span>
        </a>
    </div>

    <div class="header-actions">
        {{-- === Notifications Dropdown === --}}
        <div x-data="{ open: false }" class="notifications header-dropdown-container">
            {{-- Trigger (Bell Icon) --}}
            <button @click="open = !open" class="header-icon-button" aria-label="Notifications">
                <i class="fas fa-bell fa-lg"></i>
                @php $notificationCount = 3; @endphp {{-- Logique réelle --}}
                @if($notificationCount > 0)
                    <span class="notifications-badge">{{ $notificationCount }}</span>
                @endif
            </button>

            {{-- Dropdown Panel Notifications (contenu inchangé) --}}
            <div x-show="open" @click.outside="open = false" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95" class="dropdown-menu notifications-dropdown" x-cloak style="display: none;">
                <div class="dropdown-header">Notifications</div>
                <div class="dropdown-content">
                     <a href="#" class="dropdown-item notification-item"> <div class="notification-icon"><i class="fas fa-envelope text-primary"></i></div> <div class="notification-details"> <div class="notification-title">Nouveau message reçu</div> <div class="notification-time">Il y a 5 minutes</div> </div> </a>
                     <a href="#" class="dropdown-item notification-item"> <div class="notification-icon"><i class="fas fa-briefcase text-success"></i></div> <div class="notification-details"> <div class="notification-title">Nouvelle offre de stage</div> <div class="notification-time">Il y a 1 heure</div> </div> </a>
                     <a href="#" class="dropdown-item notification-item"> <div class="notification-icon"><i class="fas fa-calendar-check text-warning"></i></div> <div class="notification-details"> <div class="notification-title">Entretien confirmé</div> <div class="notification-time">Hier</div> </div> </a>
                </div>
                <a href="#" class="dropdown-footer">Voir toutes les notifications</a>
            </div>
        </div>
        {{-- === Fin Notifications Dropdown === --}}


        {{-- === Profil Dropdown === --}}
        <div x-data="{ open: false }" class="profile-menu header-dropdown-container">
            {{-- Trigger (Profile Image) --}}
            <button @click="open = !open" class="header-icon-button profile-trigger-button" aria-label="Menu utilisateur">
                <div class="profile-image">
                    @if(Auth::user() && Auth::user()->etudiant?->cvProfile?->photo_url)
                         <img src="{{ Storage::url(Auth::user()->etudiant->photo_path) }}" alt="Profil">
                    @else
                        <i class="fas fa-user"></i>
                    @endif
                </div>
            </button>

            {{-- Dropdown Panel Profil --}}
            <div x-show="open" @click.outside="open = false" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95" class="dropdown-menu profile-dropdown" x-cloak style="display: none;">
                 {{-- Infos Utilisateur --}}
                 <div class="dropdown-user-info">
                    <div class="font-medium text-base text-gray-800">{{ Auth::user()->name ?? 'Utilisateur' }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email ?? '' }}</div>
                 </div>
                 <div class="dropdown-separator"></div>
                {{-- Lien Mon Profil --}}
                <a href="{{ route('etudiants.profile.edit') }}" class="dropdown-item">
                    <i class="fas fa-user-circle fa-fw me-2"></i> Mon Profil
                </a>
                {{-- *** CORRECTION ICI *** --}}
                {{-- Lien de Déconnexion qui cible le formulaire avec id="logout-form" --}}
                <a href="{{ route('logout') }}"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();" {{-- Utilise 'logout-form' --}}
                   class="dropdown-item">
                   <i class="fas fa-sign-out-alt fa-fw me-2"></i> Déconnexion
                </a>
                {{-- Pas besoin de dupliquer le formulaire ici --}}
            </div>
        </div>
         {{-- === Fin Profil Dropdown === --}}
    </div>
</header>