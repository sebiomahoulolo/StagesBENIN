{{-- /resources/views/etudiants/dashboard.blade.php --}}

{{-- Utilise le nouveau layout dédié aux étudiants --}}
@extends('layouts.etudiant.app')

{{-- Définit le titre spécifique pour cette page (sera affiché dans la balise <title>) --}}
@section('title', 'Tableau de Bord Étudiant')

{{-- Début de la section de contenu qui sera injectée dans le @yield('content') du layout --}}
@section('content')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/etudiant-dashboard.css') }}">
@endpush

    {{-- En-tête du contenu principal : Message de bienvenue et boutons d'action rapide --}}
    <div class="dashboard-header">
        <div class="welcome-message">
            {{-- Affichage dynamique du prénom de l'étudiant connecté --}}
            <h1>Bienvenue, {{ Auth::user()->etudiant->prenom ?? Auth::user()->name }} !</h1>
            <p>Voici un aperçu de votre activité récente et des opportunités à venir.</p>
        </div>
        <div class="quick-actions">
            {{-- Bouton pour rechercher une offre (adapter la route si nécessaire) --}}
            <a href="#" class="action-button"> {{-- TODO: Mettre la route correcte ici, ex: route('offres.index') --}}
                <i class="fas fa-search"></i>
                <span>Rechercher une offre</span>
            </a>
            {{-- Bouton pour éditer le CV, s'affiche seulement si un profil CV existe --}}
            @php $cvProfileId = Auth::user()->etudiant?->cvProfile?->id; @endphp
            @if($cvProfileId)
                <a href="{{ route('etudiants.cv.edit', ['cvProfile' => $cvProfileId]) }}" class="action-button">
                    <i class="fas fa-file-alt"></i>
                    <span>Mettre à jour mon CV</span>
                </a>
            @endif
            {{-- Bouton pour soumettre une plainte ou suggestion --}}
            <a href="{{ route('etudiants.complaints.create') }}" class="action-button">
                <i class="fas fa-comment-alt"></i>
                <span>Soumettre une plainte/suggestion</span>
            </a>
        </div>
    </div>

    {{-- Section des cartes récapitulatives --}}
    <div class="dashboard-cards">
        {{-- Carte 1: Vues du profil --}}
        <div class="card">
            <div class="card-header">
                <i class="fas fa-eye"></i>
                <h3 class="card-title">Vues du profil</h3>
            </div>
            <div class="card-content">
                {{-- TODO: Injecter les données réelles depuis le contrôleur --}}
                <p>Votre profil a été consulté <strong>27 fois</strong> cette semaine.</p>
                <p style="margin-top: 8px;">+15% par rapport à la semaine dernière.</p>
                {{-- Exemple: <p><strong>{{ $profileViews ?? 0 }} fois</strong> cette semaine.</p> --}}
            </div>
        </div>

        {{-- Carte 2: Candidatures --}}
        <div class="card">
            <div class="card-header">
                <i class="fas fa-briefcase"></i>
                <h3 class="card-title">Candidatures</h3>
            </div>
            <div class="card-content">
                 {{-- TODO: Injecter les données réelles depuis le contrôleur --}}
                <p><strong>12 candidatures</strong> actives.</p>
                <p style="margin-top: 8px;">3 nouvelles réponses à traiter.</p>
                 {{-- Exemple: <p><strong>{{ $activeApplications ?? 0 }}</strong> actives.</p> --}}
            </div>
        </div>

        {{-- Carte 3: Complétion du profil --}}
        <div class="card">
            <div class="card-header">
                <i class="fas fa-check-circle"></i>
                <h3 class="card-title">Complétion du profil</h3>
            </div>
            <div class="card-content">
                {{-- TODO: Injecter les données réelles depuis le contrôleur --}}
                <p>Votre profil est complété à <strong>85%</strong>.</p>
                <p style="margin-top: 8px;">Ajoutez vos certifications pour atteindre 100%.</p>
                 {{-- Exemple: <p>Complété à <strong>{{ $profileCompletionPercentage ?? 0 }}%</strong>.</p> --}}
            </div>
        </div>

        {{-- Carte 4: Entretiens programmés --}}
        {{-- Assurez-vous que la variable $entretiens est bien passée par le contrôleur --}}
        <div class="card">
            <div class="card-header">
                <i class="fas fa-calendar-check"></i>
                <h3 class="card-title">Entretiens programmés</h3>
            </div>
            {{-- card-body n'existe pas dans votre CSS, on utilise card-content --}}
            <div class="card-content">
                {{-- Vérifie si la variable $entretiens est définie et non vide --}}
                @isset($entretiens)
                    @if($entretiens->count() > 0)
                        <p><strong>{{ $entretiens->count() }} entretien{{ $entretiens->count() > 1 ? 's' : '' }}</strong> programmé{{ $entretiens->count() > 1 ? 's' : '' }}.</p>
                        {{-- Liste des 3 prochains entretiens --}}
                        <ul style="list-style: none; padding: 0; margin-top: 10px;">
                            @foreach($entretiens->sortBy('date')->take(3) as $entretien) {{-- Tri par date avant de prendre les 3 premiers --}}
                                <li style="margin-bottom: 5px; font-size: 0.9em;">
                                    <i class="far fa-clock text-primary me-1"></i>
                                    {{-- Formatage de date localisé et heure --}}
                                    <strong>{{ \Carbon\Carbon::parse($entretien->date)->isoFormat('DD/MM/YYYY [à] HH[h]mm') }}</strong> -
                                    <span>{{ $entretien->entreprise->nom ?? 'Entreprise inconnue' }}</span>
                                </li>
                            @endforeach
                            {{-- Lien pour voir tous les entretiens s'il y en a plus de 3 --}}
                            @if($entretiens->count() > 3 && Auth::user()->etudiant)
                                <li><a href="{{ route('etudiants.examen', ['etudiant_id' => Auth::user()->etudiant->id]) }}" class="view-all" style="font-size: 0.9em; display:inline-block; margin-top:5px;">Voir tous les entretiens...</a></li>
                            @endif
                        </ul>
                    @else
                        {{-- Message si aucun entretien --}}
                        <p>Aucun entretien programmé pour le moment.</p>
                    @endif
                @else
                    {{-- Message si la variable n'a pas été passée --}}
                    <p class="text-muted" style="font-style: italic;">Données d'entretien non disponibles.</p>
                @endisset
            </div>
        </div>
        {{-- Fin Carte Entretiens --}}

    </div> {{-- Fin .dashboard-cards --}}

    {{-- Section Activité récente et Événements à venir (côte à côte sur écrans larges) --}}
    <div class="row gx-4"> {{-- Utilise les gouttières Bootstrap pour l'espacement horizontal --}}
        {{-- Colonne gauche: Activité récente --}}
        <div class="col-lg-6 mb-4 mb-lg-0"> {{-- Prend la moitié de la largeur sur les grands écrans, pleine largeur en dessous --}}
            <div class="recent-activity">
                <div class="section-header">
                    <h2 class="section-title">Activité récente</h2>
                    <a href="#" class="view-all">Voir tout</a> {{-- TODO: Mettre la route vers la page d'activité complète --}}
                </div>
                <div class="activity-list">
                    {{-- TODO: Remplacer par une boucle sur les données réelles ($recentActivities par exemple) --}}
                    <div class="activity-item">
                        <div class="activity-icon"><i class="fas fa-paper-plane"></i></div>
                        <div class="activity-details">
                            <div class="activity-title">Candidature envoyée - Développeur Web</div>
                            <div class="activity-time">Aujourd'hui, 10:35</div>
                        </div>
                    </div>
                    <div class="activity-item">
                        <div class="activity-icon"><i class="fas fa-envelope-open-text"></i></div>
                        <div class="activity-details">
                            <div class="activity-title">Message reçu de InnoTech Solutions</div>
                            <div class="activity-time">Hier, 15:20</div>
                        </div>
                    </div>
                    <div class="activity-item">
                        <div class="activity-icon"><i class="fas fa-certificate"></i></div>
                        <div class="activity-details">
                            <div class="activity-title">Certification JavaScript Avancé complétée</div>
                            <div class="activity-time">02/04/2025, 11:45</div>
                        </div>
                    </div>
                    {{-- Fin des exemples --}}
                </div>
            </div>
        </div>

        {{-- Colonne droite: Événements à venir --}}
        <div class="col-lg-6">
            <div class="upcoming-events">
                <div class="section-header">
                    <h2 class="section-title">Événements à venir</h2>
                    <a href="#" class="view-all">Voir tout</a> {{-- TODO: Mettre la route vers la page des événements --}}
                </div>
                <div class="event-list">
                    {{-- TODO: Remplacer par une boucle sur les données réelles ($upcomingEvents par exemple) --}}
                    <div class="event-item">
                        <div class="event-icon"><i class="fas fa-users"></i></div>
                        <div class="event-details">
                            <div class="event-title">Salon de l'emploi Tech</div>
                            <div class="event-date">10 avril 2025, 09:00-18:00</div>
                            <div class="event-time">Centre des Congrès</div>
                        </div>
                    </div>
                    <div class="event-item">
                        <div class="event-icon"><i class="fas fa-laptop"></i></div>
                        <div class="event-details">
                            <div class="event-title">Webinaire: Tendances Tech 2025</div>
                            <div class="event-date">15 avril 2025, 14:00-15:30</div>
                            <div class="event-time">En ligne</div>
                        </div>
                    </div>
                    {{-- Fin des exemples --}}
                </div>
            </div>
        </div>
    </div> {{-- Fin .row --}}

@endsection
{{-- Fin de la section de contenu --}}

{{-- Section pour les scripts JS spécifiques si nécessaire (optionnel) --}}
@push('scripts')
    {{-- <script src="{{ asset('js/student-dashboard.js') }}"></script> --}}
@endpush