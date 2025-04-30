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
        {{-- === Profil Dropdown === --}}
        <div class="profile-menu" x-data="{ open: false }" style="position: relative;">
            {{-- Trigger (Profile Image) --}}
            <div @click="open = !open" style="cursor: pointer; display: flex; align-items: center;">
                <div class="profile-image">
                    <i class="fas fa-user"></i>
                </div>
                <div class="profile-info">
                    <div class="profile-name">{{ Auth::user()->name }}</div>
                    <div class="profile-role">Administrateur</div>
                </div>
            </div>

            {{-- Dropdown Panel Profil --}}
            <div x-show="open" 
                 @click.outside="open = false" 
                 x-transition:enter="transition ease-out duration-200" 
                 x-transition:enter-start="opacity-0 scale-95" 
                 x-transition:enter-end="opacity-100 scale-100" 
                 x-transition:leave="transition ease-in duration-150" 
                 x-transition:leave-start="opacity-100 scale-100" 
                 x-transition:leave-end="opacity-0 scale-95" 
                 class="dropdown-menu profile-dropdown" 
                 style="position: absolute; top: 100%; right: 0; width: 250px; z-index: 1000; margin-top: 10px;"
                 x-cloak>
                {{-- Infos Utilisateur --}}
                <div class="dropdown-user-info">
                    <div class="font-medium text-base text-gray-800">{{ Auth::user()->name ?? 'Utilisateur' }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email ?? '' }}</div>
                </div>
                <div class="dropdown-separator"></div>
                {{-- Lien Mon Profil --}}
                <a href="" class="dropdown-item">
                    <i class="fas fa-user-circle fa-fw me-2"></i> Mon Profil
                </a>
                {{-- Lien de Déconnexion --}}
                <a href="{{ route('logout') }}"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                   class="dropdown-item">
                   <i class="fas fa-sign-out-alt fa-fw me-2"></i> Déconnexion
                </a>
            </div>
        </div>
        {{-- === Fin Profil Dropdown === --}}
    </div>
</header>