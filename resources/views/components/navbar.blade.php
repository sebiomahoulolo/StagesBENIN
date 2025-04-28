<!-- Bannière (Visible uniquement sur les grands écrans) -->
<div class="banner d-none d-md-flex">
    <div class="info">
        <span><i class="bi bi-geo-alt"></i> Kindonou, Cotonou - Bénin</span>
        <span><i class="bi bi-telephone"></i> 24h/7j +229 01 41 73 28 96 / +229 01 66 69 39 56</span>
        <span id="date-time" class="date-time"><i class="bi bi-clock"></i> Chargement...</span>
    </div>
    <div class="social-icons">
       <a href="https://www.facebook.com/stagesbenin" target="_blank" rel="noopener noreferrer"><i class="bi bi-facebook"></i></a>
       <a href="https://www.linkedin.com/company/stagesbenin/?viewAsMember=true" target="_blank" rel="noopener noreferrer"><i class="bi bi-linkedin"></i></a>
       <a href="https://www.tiktok.com/@stagesbenin6?_t=8lH68SpT4HG&_r=1" target="_blank" rel="noopener noreferrer"><i class="fa-brands fa-tiktok"></i></a>
       <a href="https://wa.me/22966693956" target="_blank" rel="noopener noreferrer"><i class="bi bi-whatsapp"></i></a>
    </div>
    <div>
        @guest {{-- Afficher si l'utilisateur n'est pas connecté --}}
            <a href="{{ route('login') }}" class="btn btn-light btn-sm text-primary">CONNEXION</a>
            <a href="{{ route('register') }}" class="btn btn-light btn-sm text-primary">INSCRIPTION</a>
        @else {{-- Afficher si l'utilisateur est connecté --}}
            {{-- Exemple: Lien vers le tableau de bord et bouton de déconnexion --}}
            <a href="{{ route('dashboard') }}" class="btn btn-light btn-sm text-primary">{{ Auth::user()->name }}</a>
            <a href="{{ route('logout') }}" class="btn btn-light btn-sm text-danger"
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                DÉCONNEXION
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        @endguest
    </div>
</div>

<!-- Navbar (Toujours visible) -->
<nav class="navbar navbar-expand-lg bg-white shadow-sm"> {{-- Ajout bg-white et shadow --}}
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ url('/') }}">
            <img src="{{ asset('assets/images/stagebenin.png') }}" alt="StagesBENIN Logo" class="navbar-logo"> {{-- Classe ajoutée pour cibler le logo --}}
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link {{ Request::is('/') ? 'active' : '' }}" href="{{ url('/') }}">ACCUEIL</a></li>
                <li class="nav-item"><a class="nav-link {{ Request::routeIs('pages.catalogue') ? 'active' : '' }}" href="{{ route('pages.catalogue') }}">CATALOGUES DES ENTREPRISES</a></li>
                <li class="nav-item"><a class="nav-link {{ Request::routeIs('pages.services') ? 'active' : '' }}" href="{{ route('pages.services') }}">NOS SERVICES</a></li>
                <li class="nav-item"><a class="nav-link {{ Request::routeIs('pages.programmes') ? 'active' : '' }}" href="{{ route('pages.programmes') }}">NOS PROGRAMMES</a></li>
                <li class="nav-item"><a class="nav-link {{ Request::routeIs('pages.evenements') ? 'active' : '' }}" href="{{ route('pages.evenements') }}">ÉVÉNEMENTS</a></li>
                <li class="nav-item"><a class="nav-link {{ Request::routeIs('pages.apropos') ? 'active' : '' }}" href="{{ route('pages.apropos') }}">À PROPOS</a></li>
                <li class="nav-item"><a class="nav-link {{ Request::routeIs('pages.contact') ? 'active' : '' }}" href="{{ route('pages.contact') }}">CONTACT</a></li>
                
                {{-- Dropdown profile pour connexion/déconnexion --}}
                @guest
                    <li class="nav-item d-none d-md-block">
                        <div class="dropdown">
                            <button class="btn nav-link dropdown-toggle" type="button" id="dropdownLoginButton" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-user-circle fa-fw"></i> CONNEXION
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownLoginButton">
                                <li><a class="dropdown-item" href="{{ route('login') }}"><i class="fas fa-sign-in-alt fa-fw"></i> CONNEXION</a></li>
                                <li><a class="dropdown-item" href="{{ route('register') }}"><i class="fas fa-user-plus fa-fw"></i> INSCRIPTION</a></li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item d-md-none"><a class="nav-link" href="{{ route('login') }}">CONNEXION</a></li>
                    <li class="nav-item d-md-none"><a class="nav-link" href="{{ route('register') }}">INSCRIPTION</a></li>
                @else
                    <li class="nav-item d-none d-md-block">
                        <div class="dropdown">
                            <button class="btn nav-link dropdown-toggle" type="button" id="dropdownProfileButton" data-bs-toggle="dropdown" aria-expanded="false">
                                {{-- Ajout de la photo de profil --}}
                                <span class="profile-image-container" style="display: inline-block; width: 30px; height: 30px; border-radius: 50%; overflow: hidden; vertical-align: middle; margin-right: 5px;">
                                    @if(Auth::user() && Auth::user()->etudiant?->cvProfile?->photo_url)
                                        <img src="{{ Storage::url(Auth::user()->etudiant->photo_path) }}" alt="Profil" style="width: 100%; height: 100%; object-fit: cover;">
                                    @else
                                        <i class="fas fa-user-circle fa-fw" style="font-size: 1.5rem;"></i>
                                    @endif
                                </span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownProfileButton">
                                <li><a class="dropdown-item" href="{{ route('dashboard') }}"><i class="fas fa-home fa-fw"></i> Tableau de bord</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <a class="dropdown-item text-danger" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form-navbar').submit();">
                                        <i class="fas fa-sign-out-alt fa-fw"></i> Déconnexion
                                    </a>
                                    <form id="logout-form-navbar" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item d-md-none"><a class="nav-link" href="{{ route('dashboard') }}">{{ Auth::user()->name }}</a></li>
                    <li class="nav-item d-md-none">
                         <a class="nav-link text-danger" href="{{ route('logout') }}"
                           onclick="event.preventDefault(); document.getElementById('logout-form-mobile').submit();">
                            DÉCONNEXION
                        </a>
                        <form id="logout-form-mobile" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>