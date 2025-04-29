{{-- /resources/views/etudiants/dashboard.blade.php --}}

{{-- Utilise le nouveau layout dédié aux étudiants --}}
@extends('layouts.etudiant.app')

{{-- Définit le titre spécifique pour cette page (sera affiché dans la balise <title>) --}}
@section('title', 'Tableau de Bord Étudiant')

{{-- Début de la section de contenu qui sera injectée dans le @yield('content') du layout --}}
@section('content')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/etudiant-dashboard.css') }}">
    <style>
        /* Styles additionnels pour les améliorations du dashboard */
        .dashboard-header {
            padding: 1.5rem;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
            margin-bottom: 1.5rem;
            transition: all 0.3s ease;
        }
        
        .dashboard-header:hover {
            box-shadow: 0 6px 20px rgba(0,0,0,0.12);
        }
        
        .welcome-message h1 {
            color: #2563eb;
            font-size: clamp(1.4rem, 4vw, 1.8rem);
            margin-bottom: 0.5rem;
        }
        
        .quick-links-section {
            margin-bottom: 1.5rem;
            background-color: #f9fafb;
            border-radius: 10px;
            padding: 1.5rem;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        
        .quick-links-title {
            font-size: 1.2rem;
            color: #374151;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
        }
        
        .quick-links-title i {
            margin-right: 0.5rem;
            color: #2563eb;
        }
        
        .quick-links-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            gap: 1rem;
        }
        
        .quick-link-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            background-color: #fff;
            border-radius: 8px;
            padding: 1rem 0.5rem;
            transition: all 0.2s ease;
            text-decoration: none;
            color: #4b5563;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        
        .quick-link-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            color: #2563eb;
        }
        
        .quick-link-item i {
            font-size: 1.8rem;
            margin-bottom: 0.5rem;
            color: #2563eb;
        }
        
        .dashboard-cards {
            margin-bottom: 1.5rem;
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 1rem;
        }
        
        .card {
            background: #fff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
            transition: all 0.3s ease;
            border: 1px solid #0d6efd;
        }
        
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.12);
        }
        
        .card-header {
            padding: 1.25rem;
            display: flex;
            align-items: center;
            border-bottom: 1px solid rgba(229, 231, 235, 0.5);
            background: linear-gradient(to right, rgba(249, 250, 251, 0.5), rgba(255, 255, 255, 0.8));
        }
        
        .card-header i {
            font-size: 1.5rem;
            margin-right: 0.75rem;
        }
        
        .card-title {
            margin: 0;
            font-size: 1.1rem;
            color: #1f2937;
            font-weight: 600;
        }
        
        .card-content {
            padding: 1.5rem;
        }
        
        .card-content strong {
            font-weight: 600;
        }
        
        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.25rem;
            border-bottom: 1px solid #e5e7eb;
            padding-bottom: 0.75rem;
        }
        
        .section-title {
            font-size: 1.25rem;
            color: #111827;
            margin: 0;
            display: flex;
            align-items: center;
            font-weight: 600;
        }
        
        .section-title i {
            margin-right: 0.75rem;
            font-size: 1.2rem;
        }
        
        .view-all {
            color: #2563eb;
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            transition: all 0.2s ease;
        }
        
        .view-all:hover {
            color: #1d4ed8;
            transform: translateX(3px);
        }
        
        .view-all i {
            margin-left: 5px;
            font-size: 0.85rem;
            transition: transform 0.2s ease;
        }
        
        .view-all:hover i {
            transform: translateX(3px);
        }
        
        .activity-item, .event-item {
            display: flex;
            margin-bottom: 1rem;
            padding: 0.85rem;
            background: #fff;
            border-radius: 10px;
            transition: all 0.2s ease;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        }
        
        .activity-item:hover, .event-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        }
        
        .activity-icon, .event-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 1rem;
            flex-shrink: 0;
            color: white;
        }
        
        .activity-icon i, .event-icon i {
            font-size: 1rem;
        }
        
        .progress-container {
            background-color: #e5e7eb;
            border-radius: 10px;
            height: 8px;
            width: 100%;
            margin-top: 0.5rem;
            overflow: hidden;
        }
        
        .progress-bar {
            height: 8px;
            border-radius: 10px;
            background-color: #2563eb;
        }

        /* Nouveaux styles pour la réorganisation du dashboard */
        .main-functions-grid {
            display: grid;
            grid-template-columns: repeat(6, 1fr);
            gap: 1rem;
            margin-bottom: 1.5rem;
            max-width: 1200px;
            margin-left: auto;
            margin-right: auto;
        }
        
        @media (max-width: 1200px) {
            .main-functions-grid {
                grid-template-columns: repeat(4, 1fr);
                max-width: 900px;
            }
        }
        
        @media (max-width: 992px) {
            .main-functions-grid {
                grid-template-columns: repeat(3, 1fr);
                max-width: 700px;
            }
        }
        
        @media (max-width: 576px) {
            .main-functions-grid {
                grid-template-columns: repeat(2, 1fr);
                max-width: 500px;
                gap: 0.75rem;
            }
        }
        
        .main-function-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            background-color: #fff;
            border-radius: 12px;
            border: 6px solid #0d6efd;
            padding: 1rem 0.5rem;
            transition: all 0.3s ease;
            text-decoration: none;
            color: #374151;
            box-shadow: 0 4px 12px rgba(0,0,0,0.06);
            width: 150px;
            height: 150px;
            margin: 0 auto;
            justify-content: center;
        }
        
        .main-function-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 18px rgba(0,0,0,0.1);
        }
        
        .main-function-icon {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 0.75rem;
            transition: all 0.3s ease;
        }
        
        .main-function-item:hover .main-function-icon {
            color: white;
        }
        
        .main-function-icon i {
            font-size: 1.4rem;
            transition: transform 0.3s ease;
        }
        
        .main-function-item:hover .main-function-icon i {
            transform: scale(1.1);
        }
        
        .main-function-title {
            font-weight: 500;
            font-size: 0.85rem;
            transition: all 0.2s ease;
            line-height: 1.2;
            max-width: 100%;
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
        }
        
        @media (max-width: 640px) {
            .main-function-title {
                font-size: 0.75rem;
            }
        }

        .stats-summary {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 1rem;
            margin-bottom: 1.5rem;
        }
        
        @media (max-width: 767px) {
            .stats-summary {
                grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            }
        }
        
        @media (max-width: 480px) {
            .stats-summary {
                grid-template-columns: repeat(2, 1fr);
                gap: 0.75rem;
            }
        }
        
        .stat-card {
            background: #fff;
            border-radius: 12px;
            padding: 1.25rem;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
            display: flex;
            align-items: center;
            transition: all 0.3s ease;
        }
        
        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 18px rgba(0,0,0,0.12);
        }
        
        .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 1rem;
            flex-shrink: 0;
        }
        
        .stat-icon i {
            font-size: 1.4rem;
            color: white;
        }
        
        .stat-content h3 {
            margin: 0;
            font-size: 0.85rem;
            color: #6b7280;
            font-weight: 500;
        }
        
        .stat-content p {
            margin: 0.25rem 0 0;
            font-size: 1.5rem;
            font-weight: 600;
            color: #111827;
        }
        
        @media (max-width: 480px) {
            .stat-content p {
                font-size: 1.25rem;
            }
        }
        
        /* Palette de couleurs - Modification pour rendre les icônes toujours visibles */
        .color-blue {
            background-color: #2563eb;
            color: white;
        }
        
        .color-green {
            background-color: #10b981;
            color: white;
        }
        
        .color-orange {
            background-color: #f59e0b;
            color: white;
        }
        
        .color-purple {
            background-color: #8b5cf6;
            color: white;
        }
        
        .color-red {
            background-color: #ef4444;
            color: white;
        }
        
        .color-teal {
            background-color: #14b8a6;
            color: white;
        }
        
        .color-indigo {
            background-color: #4f46e5;
            color: white;
        }
        
        .color-pink {
            background-color: #ec4899;
            color: white;
        }
        
        /* Animation pour les éléments du dashboard */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .animate-fadeInUp {
            animation: fadeInUp 0.5s ease-out forwards;
        }
        
        .delay-100 {
            animation-delay: 0.1s;
        }
        
        .delay-200 {
            animation-delay: 0.2s;
        }
        
        .delay-300 {
            animation-delay: 0.3s;
        }
        
        .delay-400 {
            animation-delay: 0.4s;
        }
        
        .section-container {
            background-color: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            transition: all 0.3s ease;
        }
        
        .section-container:hover {
            box-shadow: 0 6px 20px rgba(0,0,0,0.12);
        }
    </style>
@endpush

    {{-- Section des fonctions principales (tirées de la sidebar) --}}
    <div class="section-container animate-fadeInUp delay-100">
        <div class="section-header">
            <h2 class="section-title">Fonctions principales</h2>
        </div>
        
        <div class="main-functions-grid">
            {{-- Tableau de bord --}}
            <a href="{{ route('etudiants.dashboard') }}" class="main-function-item">
                <div class="main-function-icon color-blue">
                    <i class="fas fa-home"></i>
                </div>
                <span class="main-function-title">Tableau de bord</span>
            </a>

            {{-- Boostage --}}
            <a href="{{ route('etudiants.boostage') }}" class="main-function-item">
                <div class="main-function-icon color-orange">
                    <i class="fas fa-rocket"></i>
                </div>
                <span class="main-function-title">Boostage</span>
            </a>
            
            {{-- Éditeur CV --}}
            <a href="{{ Auth::user()->etudiant?->cvProfile?->id ? route('etudiants.cv.edit', ['cvProfile' => Auth::user()->etudiant->cvProfile->id]) : route('etudiants.cv.edit', ['cvProfile' => 'new']) }}" class="main-function-item">
                <div class="main-function-icon color-teal">
                    <i class="fas fa-file-alt"></i>
                </div>
                <span class="main-function-title">Éditeur CV</span>
            </a>
            
            {{-- Offres --}}
            <a href="{{ route('etudiants.offres.index') }}" class="main-function-item">
                <div class="main-function-icon color-orange">
                    <i class="fas fa-briefcase"></i>
                </div>
                <span class="main-function-title">Offres</span>
            </a>

            {{-- Mes candidatures --}}
            <a href="{{ route('etudiants.offres.mes-candidatures') }}" class="main-function-item">
                <div class="main-function-icon color-purple">
                    <i class="fas fa-file-alt"></i>
                </div>
                <span class="main-function-title">Mes candidatures</span>
            </a>

            {{-- Entreprises suivies --}}
            <a href="#" class="main-function-item">
                <div class="main-function-icon color-indigo">
                    <i class="fas fa-building"></i>
                </div>
                <span class="main-function-title">Entreprises suivies</span>
            </a>
            
            {{-- Messagerie --}}
            <a href="{{ route('messaging.index') }}" class="main-function-item">
                <div class="main-function-icon color-purple">
                    <i class="fas fa-envelope"></i>
                </div>
                <span class="main-function-title">Messagerie</span>
            </a>
            
            {{-- Entretiens --}}
            @if(Auth::user()->etudiant)
                <a href="{{ route('etudiants.examen', ['etudiant_id' => Auth::user()->etudiant->id]) }}" class="main-function-item">
                    <div class="main-function-icon color-green">
                        <i class="fas fa-comments"></i>
                    </div>
                    <span class="main-function-title">Entretiens</span>
                </a>
            @endif
            
            {{-- Événements --}}
            <a href="{{ route('etudiants.evenements.upcoming') }}" class="main-function-item">
                <div class="main-function-icon color-pink">
                    <i class="fas fa-calendar-day"></i>
                </div>
                <span class="main-function-title">Événements</span>
            </a>
            
            {{-- Agenda --}}
            <a href="#" class="main-function-item">
                <div class="main-function-icon color-indigo">
                    <i class="fas fa-calendar-alt"></i>
                </div>
                <span class="main-function-title">Agenda</span>
            </a>

            {{-- Canal d'annonces --}}
            <a href="{{ route('messagerie-sociale.index') }}" class="main-function-item">
                <div class="main-function-icon color-blue">
                    <i class="fas fa-bullhorn"></i>
                </div>
                <span class="main-function-title">Canal d'annonces</span>
            </a>

            {{-- Cours en ligne --}}
            <a href="https://fhcschoolbenin.com/" target="_blank" class="main-function-item">
                <div class="main-function-icon color-teal">
                    <i class="fas fa-graduation-cap"></i>
                </div>
                <span class="main-function-title">Cours en ligne</span>
            </a>

            {{-- Blog --}}
            <a href="#" class="main-function-item">
                <div class="main-function-icon color-orange">
                    <i class="fas fa-blog"></i>
                </div>
                <span class="main-function-title">Blog</span>
            </a>

            {{-- Objectifs --}}
            <a href="#" class="main-function-item">
                <div class="main-function-icon color-green">
                    <i class="fas fa-bullseye"></i>
                </div>
                <span class="main-function-title">Objectifs</span>
            </a>

           

            {{-- Déconnexion --}}
            <a href="{{ route('logout') }}" class="main-function-item" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <div class="main-function-icon color-red">
                    <i class="fas fa-sign-out-alt"></i>
                </div>
                <span class="main-function-title">Déconnexion</span>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;"> @csrf </form>
            
            {{-- Profil --}}
            <a href="{{ route('etudiants.profile.edit') }}" class="main-function-item">
                <div class="main-function-icon color-blue">
                    <i class="fas fa-user-circle"></i>
                </div>
                <span class="main-function-title">Mon Profil</span>
            </a>
            
            {{-- Plainte/Suggestion --}}
            <a href="{{ route('etudiants.complaints.create') }}" class="main-function-item">
                <div class="main-function-icon color-red">
                    <i class="fas fa-comment-alt"></i>
                </div>
                <span class="main-function-title">Plainte/Suggestion</span>
            </a>
        </div>
    </div>

    {{-- Section Activité récente et Événements à venir (côte à côte sur écrans larges) --}}
    <div class="row gx-4 animate-fadeInUp delay-200"> {{-- Utilise les gouttières Bootstrap pour l'espacement horizontal --}}
        {{-- Colonne gauche: Activité récente --}}
        <div class="col-lg-6 mb-4 mb-lg-0"> {{-- Prend la moitié de la largeur sur les grands écrans, pleine largeur en dessous --}}
            <div class="section-container">
                <div class="section-header">
                    <h2 class="section-title">Activité récente</h2>
                    <a href="#" class="view-all">Voir tout <i class="fas fa-arrow-right"></i></a> {{-- TODO: Mettre la route vers la page d'activité complète --}}
                </div>
                <div class="activity-list">
                    {{-- TODO: Remplacer par une boucle sur les données réelles ($recentActivities par exemple) --}}
                    <div class="activity-item">
                        <div class="activity-icon color-blue"><i class="fas fa-paper-plane"></i></div>
                        <div class="activity-details">
                            <div class="activity-title">Candidature envoyée - Développeur Web</div>
                            <div class="activity-time"><i class="far fa-clock"></i> Aujourd'hui, 10:35</div>
                        </div>
                    </div>
                    <div class="activity-item">
                        <div class="activity-icon color-purple"><i class="fas fa-envelope-open-text"></i></div>
                        <div class="activity-details">
                            <div class="activity-title">Message reçu de InnoTech Solutions</div>
                            <div class="activity-time"><i class="far fa-clock"></i> Hier, 15:20</div>
                        </div>
                    </div>
                    <div class="activity-item">
                        <div class="activity-icon color-teal"><i class="fas fa-certificate"></i></div>
                        <div class="activity-details">
                            <div class="activity-title">Certification JavaScript Avancé complétée</div>
                            <div class="activity-time"><i class="far fa-clock"></i> 02/04/2025, 11:45</div>
                        </div>
                    </div>
                    {{-- Fin des exemples --}}
                </div>
            </div>
        </div>

        {{-- Colonne droite: Événements à venir --}}
        <div class="col-lg-6">
            <div class="section-container">
                <div class="section-header">
                    <h2 class="section-title">Événements à venir</h2>
                    <a href="{{ route('etudiants.evenements.upcoming') }}" class="view-all">Voir tout <i class="fas fa-arrow-right"></i></a>
                </div>
                <div class="event-list">
                    {{-- TODO: Remplacer par une boucle sur les données réelles ($upcomingEvents par exemple) --}}
                    <div class="event-item">
                        <div class="event-icon color-orange"><i class="fas fa-users"></i></div>
                        <div class="event-details">
                            <div class="event-title">Salon de l'emploi Tech</div>
                            <div class="event-date"><i class="far fa-calendar-alt"></i> 10 avril 2025, 09:00-18:00</div>
                            <div class="event-time"><i class="fas fa-map-marker-alt"></i> Centre des Congrès</div>
                        </div>
                    </div>
                    <div class="event-item">
                        <div class="event-icon color-green"><i class="fas fa-laptop"></i></div>
                        <div class="event-details">
                            <div class="event-title">Webinaire: Tendances Tech 2025</div>
                            <div class="event-date"><i class="far fa-calendar-alt"></i> 15 avril 2025, 14:00-15:30</div>
                            <div class="event-time"><i class="fas fa-globe"></i> En ligne</div>
                        </div>
                    </div>
                    {{-- Fin des exemples --}}
                </div>
            </div>
        </div>
    </div> {{-- Fin .row --}}

    {{-- Section Entretiens programmés --}}
    @isset($entretiens)
        @if($entretiens->count() > 0)
            <div class="upcoming-interviews animate-fadeInUp delay-300">
                <div class="section-container">
                    <div class="section-header">
                        <h2 class="section-title">Entretiens programmés</h2>
                        @if(Auth::user()->etudiant)
                            <a href="{{ route('etudiants.examen', ['etudiant_id' => Auth::user()->etudiant->id]) }}" class="view-all">Voir tout <i class="fas fa-arrow-right"></i></a>
                        @endif
                    </div>
                    <div class="dashboard-cards">
                        @foreach($entretiens->sortBy('date')->take(4) as $entretien)
                            <div class="card">
                                <div class="card-header">
                                    <i class="fas fa-building color-indigo"></i>
                                    <h3 class="card-title">{{ $entretien->entreprise->nom ?? 'Entreprise inconnue' }}</h3>
                                </div>
                                <div class="card-content">
                                    <p><i class="far fa-clock me-2 color-blue"></i> {{ \Carbon\Carbon::parse($entretien->date)->isoFormat('DD/MM/YYYY [à] HH[h]mm') }}</p>
                                    <p><i class="fas fa-map-marker-alt me-2 color-red"></i> {{ $entretien->lieu ?? 'Lieu à confirmer' }}</p>
                                    <p><i class="fas fa-info-circle me-2 color-orange"></i> {{ Str::limit($entretien->description ?? 'Pas de détails disponibles', 50) }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif
    @endisset

@endsection
{{-- Fin de la section de contenu --}}

{{-- Section pour les scripts JS spécifiques si nécessaire (optionnel) --}}
@push('scripts')
    {{-- <script src="{{ asset('js/student-dashboard.js') }}"></script> --}}
@endpush