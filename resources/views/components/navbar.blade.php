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
                {{-- Liens Connexion/Inscription sur mobile si la bannière est cachée --}}
                @guest
                    <li class="nav-item d-md-none"><a class="nav-link" href="{{ route('login') }}">CONNEXION</a></li>
                    <li class="nav-item d-md-none"><a class="nav-link" href="{{ route('register') }}">INSCRIPTION</a></li>
                @else
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