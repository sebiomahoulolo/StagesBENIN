<aside class="app-sidebar" :class="{ 'open': isSidebarOpen }">
    {{-- Bouton Fermer (X) visible seulement quand sidebar ouverte sur petit écran --}}
    <button class="sidebar-close-btn" @click="isSidebarOpen = false" aria-label="Fermer le menu">
        <i class="fas fa-times"></i>
    </button>

    <nav class="sidebar-menu">
        {{-- Liens du menu... (inchangés par rapport à avant) --}}
        <a href="{{ route('etudiants.dashboard') }}" class="menu-item {{ request()->routeIs('etudiants.dashboard') ? 'active' : '' }}"> <i class="fas fa-home fa-fw"></i><span>Tableau de bord</span> </a>
        @php $cvProfileId = Auth::user()->etudiant?->cvProfile?->id; @endphp
        @if($cvProfileId)
            <a href="{{ route('etudiants.cv.edit', ['cvProfile' => $cvProfileId]) }}" class="menu-item {{ request()->routeIs('etudiants.cv.edit') ? 'active' : '' }}"> <i class="fas fa-file-alt fa-fw"></i><span>Éditeur CV</span> </a>
            <a href="{{ route('etudiants.cv.show', ['cvProfile' => $cvProfileId]) }}" class="menu-item {{ request()->routeIs('etudiants.cv.show') ? 'active' : '' }}"> <i class="fas fa-eye fa-fw"></i><span>Visualiser CV</span> </a>
        @else
             <a href="#" class="menu-item disabled" title="Créez d'abord votre profil CV"> <i class="fas fa-file-alt fa-fw"></i><span>Éditeur CV</span> </a>
        @endif
        @if(Auth::user()->etudiant)
        <a href="{{ route('etudiants.examen', ['etudiant_id' => Auth::user()->etudiant->id]) }}" class="menu-item {{ request()->routeIs('etudiants.examen') ? 'active' : '' }}"> <i class="fas fa-comments fa-fw"></i><span>Entretiens</span> </a>
        @endif
        <a href="{{ route('etudiants.profile.edit') }}" class="menu-item {{ request()->routeIs('profile.edit') ? 'active' : '' }}"> <i class="fas fa-user-circle fa-fw"></i><span>Mon Profil</span> </a>
        <a href="{{ route('logout') }}" class="menu-item" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"> <i class="fas fa-sign-out-alt fa-fw"></i><span>Déconnexion</span> </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;"> @csrf </form>
    </nav>
</aside>