<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Espace Étudiant - StagesBENIN')</title>

    {{-- CSS Layout --}}
    <link rel="stylesheet" href="{{ asset('css/layout/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/layout/header.css') }}">
    <link rel="stylesheet" href="{{ asset('css/layout/sidebar.css') }}">

    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
    @livewireStyles
    @stack('styles')
     <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

    {{-- Alpine.js --}}
    <script src="//unpkg.com/alpinejs" defer></script>
</head>
<body>
    
    <div class="container flex flex-col mx-auto justify-center items-center w-full py-4">
        {{-- HEADER --}}
        {{-- ALERTES --}}
        @if (session('warning'))
            <div class="alert alert-warning mb-3">{{ session('warning') }}</div>
        @endif
        @if (session('message'))
            <div class="alert alert-success mb-3" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)">
                {{ session('message') }}
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger mb-3">{{ session('error') }}</div>
        @endif

        {{-- BOUTON DE VISUALISATION --}}
        <div class="d-flex justify-content-end mt-3">
            @php $cvProfileId = Auth::user()->etudiant?->cvProfile?->id; @endphp
            @if ($cvProfileId)
                <a class=" px-4 py-2 bg-indigo-600 rounded-md text-white " href="{{ route('etudiants.cv.show', ['cvProfile' => $cvProfileId]) }}" class="btn btn-primary"
                    target="_blank">
                    <i class="fas fa-eye me-1"></i> Visualiser le CV
                </a>
            @endif
        </div>


        {{-- PROGRESSION DU CV --}}
        <div class=" mb-4 flex flex-col justify-center items-center w-full mx-auto">
            <div class="progress-grid mt-3">
                @php
                    $sections = [
                        'Profil' => [
                            'status' => $cvProfile->isProfilComplete(),
                            'detail' => 'Tous les champs obligatoires',
                            'link' => '#profil',
                        ],
                        'Formations' => [
                            'status' => $cvProfile->isFormationsComplete(),
                            'detail' => 'Au moins 1 formation',
                            'link' => '#formations',
                        ],
                        'Expériences' => [
                            'status' => $cvProfile->isExperiencesComplete(),
                            'detail' => 'Au moins 1 expérience',
                            'link' => '#experiences',
                        ],
                        'Compétences' => [
                            'status' => $cvProfile->isCompetencesComplete(),
                            'detail' => 'Au moins 3 compétences',
                            'link' => '#competences',
                        ],
                        'Langues' => [
                            'status' => $cvProfile->isLanguesComplete(),
                            'detail' => 'Au moins 1 langue',
                            'link' => '#langues',
                        ],
                        'Centres d\'intérêt' => [
                            'status' => $cvProfile->isCentresInteretComplete(),
                            'detail' => 'Au moins 2 centres d\'intérêt',
                            'link' => '#centres-interet',
                        ],
                        'Certifications' => [
                            'status' => $cvProfile->isCertificationsComplete(),
                            'detail' => 'Au moins 1 certification',
                            'link' => '#certifications',
                        ],
                        'Projets' => [
                            'status' => $cvProfile->isProjetsComplete(),
                            'detail' => 'Au moins 1 projet',
                            'link' => '#projets',
                        ],
                        'Références' => [
                            'status' => $cvProfile->isReferencesComplete(),
                            'detail' => 'Au moins 2 références',
                            'link' => '#references',
                        ],
                    ];
                @endphp

                @foreach ($sections as $label => $data)
                    <a href="{{ $data['link'] }}" class="progress-card-link">
                        <div class="progress-card p-2">
                            <h6 class="progress-title mb-1">{{ $label }}</h6>
                            <div class="progress-bar-container mb-1">
                                <div class="progress-bar" style="width: {{ $data['status'] ? '100%' : '0%' }}"></div>
                            </div>
                            <small class="progress-detail d-block mb-1">{{ $data['detail'] }}</small>
                            <span class="status-badge {{ $data['status'] ? 'complete' : 'incomplete' }}">
                                {{ $data['status'] ? 'Complété' : 'En attente' }}
                            </span>
                        </div>
                    </a>
                @endforeach
            </div>

            <div class="progress-footer mt-3">
                <div class="alert alert-info py-2 px-3">
                    <i class="fas fa-info-circle me-1"></i>
                    <strong>{{ $cvProfile->calculateCompletion() }}% complet</strong> —
                    {{ $cvProfile->calculateRemainingSections() }}
                    section{{ $cvProfile->calculateRemainingSections() > 1 ? 's' : '' }}
                    restante{{ $cvProfile->calculateRemainingSections() > 1 ? 's' : '' }}
                </div>
            </div>
        </div>

        <style>
            .progress-grid {
                display: flex;
                flex-wrap: wrap;
                gap: 1rem;
                justify-content: flex-start;
            }

            .progress-card-link {
                text-decoration: none;
                color: inherit;
                flex: 1 1 160px;
            }

            .progress-card {
                background: #fdfdfd;
                border: 1px solid #e0e0e0;
                border-radius: 6px;
                padding: 0.8rem;
                text-align: center;
                font-size: 0.85rem;
                box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
                transition: transform 0.2s ease;
            }

            .progress-card:hover {
                transform: scale(1.03);
            }

            .progress-title {
                font-size: 0.85rem;
                font-weight: 600;
                margin-bottom: 0.3rem;
            }

            .progress-detail {
                font-size: 0.75rem;
                color: #555;
            }

            .progress-bar-container {
                width: 100%;
                background: #e5e5e5;
                height: 6px;
                border-radius: 3px;
                overflow: hidden;
            }

            .progress-bar {
                height: 100%;
                background: #28a745;
                transition: width 0.3s ease;
            }

            .status-badge {
                display: inline-block;
                padding: 0.25rem 0.5rem;
                border-radius: 12px;
                font-size: 0.7rem;
                font-weight: 500;
                color: #fff;
            }

            .status-badge.complete {
                background-color: #28a745;
            }

            .status-badge.incomplete {
                background-color: #ffc107;
                color: #333;
            }

            /* Cercle de progression */
            .completion-circle {
                width: 60px;
                height: 60px;
            }

            .circular-chart {
                display: block;
                margin: auto;
                max-width: 100%;
                max-height: 100%;
            }

            .circle-bg {
                fill: none;
                stroke: #eee;
                stroke-width: 3.8;
            }

            .circle {
                fill: none;
                stroke: #28a745;
                stroke-width: 3.8;
                stroke-linecap: round;
                transform: rotate(-90deg);
                transform-origin: center;
                transition: stroke-dasharray 0.5s ease;
            }

            .percentage {
                fill: #333;
                font-family: 'Arial', sans-serif;
                font-size: 0.35em;
                text-anchor: middle;
            }

            [data-modal-backdrop="static"] {
                z-index: 60;
                /* plus élevé que les autres éléments comme les menus */
            }

            html,
            body {
                overflow-x: hidden;
            }
        </style>


        {{-- FORMULAIRES CV --}}
        <div class="cv-editor-container space-y-6 ">
            <p class="text-muted">Remplissez ou modifiez chaque section pour construire votre CV.</p>
            @isset($cvProfile)
                <div class="card shadow-sm">
                    <div class="card-body" id="profil">@livewire('etudiants.cv-profile-form', ['cvProfileId' => $cvProfile->id], key('lw-profile-' . $cvProfile->id))</div>
                </div>
                <div class="card shadow-sm">
                    <div class="card-body" id="formations">@livewire('etudiants.cv-formations-form', ['cvProfileId' => $cvProfile->id], key('lw-formations-' . $cvProfile->id))</div>
                </div>
                <div class="card shadow-sm">
                    <div class="card-body" id="experiences">@livewire('etudiants.cv-experiences-form', ['cvProfileId' => $cvProfile->id], key('lw-experiences-' . $cvProfile->id))</div>
                </div>
                <div class="card shadow-sm">
                    <div class="card-body" id="competencs">@livewire('etudiants.cv-competences-form', ['cvProfileId' => $cvProfile->id], key('lw-competences-' . $cvProfile->id))</div>
                </div>
                <div class="card shadow-sm">
                    <div class="card-body" id="langues">@livewire('etudiants.cv-langues-form', ['cvProfileId' => $cvProfile->id], key('lw-langues-' . $cvProfile->id))</div>
                </div>
                <div class="card shadow-sm">
                    <div class="card-body" id="centres-interet">@livewire('etudiants.cv-centres-interet-form', ['cvProfileId' => $cvProfile->id], key('lw-interets-' . $cvProfile->id))</div>
                </div>
                <div class="card shadow-sm">
                    <div class="card-body" id="certifications">@livewire('etudiants.cv-certifications-form', ['cvProfileId' => $cvProfile->id], key('lw-certs-' . $cvProfile->id))</div>
                </div>
                <div class="card shadow-sm">
                    <div class="card-body" id="projets">@livewire('etudiants.cv-projets-form', ['cvProfileId' => $cvProfile->id], key('lw-projets-' . $cvProfile->id))</div>
                </div>
                <div class="card shadow-sm">
                    <div class="card-body" id="references">@livewire('etudiants.cv-references-form', ['cvProfileId' => $cvProfile->id], key('lw-references-' . $cvProfile->id))</div>
                </div>
            @else
                <div class="alert alert-danger">
                    <strong>Erreur Critique :</strong> Le profil CV nécessaire pour l'édition n'a pas pu être chargé.
                    Veuillez vous assurer d'avoir créé un profil ou contacter le support technique.
                </div>
                @php \Log::critical("[CV Edit View] La variable \$cvProfile est manquante pour l'utilisateur ID: " . Auth::id()); @endphp
            @endisset
        </div>
        <div class="row">
            <div class="col-md-4">
                <button class=" btn btn-primary my-3 " disabled>Suivant</button>
            </div>
        </div>
    </div>

     {{-- Overlay (couvre le contenu quand la sidebar est ouverte sur petit écran) --}}
    <div class="sidebar-overlay"
         x-show="isSidebarOpen"
         x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
         @click="isSidebarOpen = false"
         x-cloak {{-- Important --}}
         style="display: none;"
    ></div>
    <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
    
    @livewireScripts
    @stack('scripts')
</body>
</html>
