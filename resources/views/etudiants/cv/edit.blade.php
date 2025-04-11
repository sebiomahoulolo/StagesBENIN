<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Éditeur de CV (Livewire + Trix) - StagesBENIN</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    {{-- Trix Editor CSS --}}
    <link rel="stylesheet" type="text/css" href="https://unpkg.com/trix@2.0.8/dist/trix.css">

    @livewireStyles

    {{-- Styles CSS Globaux et Spécifiques à la Page --}}
    <style>
        /* ===== Styles CSS (Identiques aux versions précédentes) ===== */
        :root { --primary-color: #3498db; --secondary-color: #2c3e50; --accent-color: #e74c3c; --success-color: #2ecc71; --warning-color: #f39c12; --light-gray: #f5f7fa; --gray: #95a5a6; --dark-gray: #7f8c8d; --border-color: #e0e0e0; }
        * { box-sizing: border-box; margin: 0; padding: 0; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        body { background-color: #f9f9f9; color: #333; line-height: 1.6; }
        /* --- Styles Header --- */
        header.app-header { background: linear-gradient(135deg, var(--primary-color), var(--secondary-color)); color: white; padding: 1rem 2rem; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 2px 10px rgba(0,0,0,0.1); position: sticky; top: 0; z-index: 1000; }
        .logo { font-size: 1.6rem; font-weight: bold; display: flex; align-items: center; }
        .logo i { margin-right: 10px; }
        .header-actions { display: flex; align-items: center; gap: 1.5rem; }
        .profile-image { width: 35px; height: 35px; border-radius: 50%; background-color: white; display: flex; align-items: center; justify-content: center; color: var(--primary-color); cursor: pointer; }
        .notifications-badge { position: absolute; top: -5px; right: -8px; background-color: var(--accent-color); color: white; border-radius: 50%; padding: 2px 6px; font-size: 0.7rem; line-height: 1; }
        /* --- Styles Conteneur & Sidebar --- */
        .app-container { display: flex; }
        aside.app-sidebar { width: 250px; background-color: white; min-height: calc(100vh - 66px); box-shadow: 2px 0 10px rgba(0,0,0,0.05); position: sticky; top: 66px; overflow-y: auto; height: calc(100vh - 66px); z-index: 999; }
        .sidebar-menu { padding: 1rem 0; }
        .menu-item { padding: 0.8rem 1.5rem; display: flex; align-items: center; color: var(--dark-gray); text-decoration: none; transition: all 0.3s; font-size: 0.95rem; border-left: 3px solid transparent; }
        .menu-item i { margin-right: 10px; width: 20px; text-align: center; }
        .menu-item:hover { background-color: rgba(52, 152, 219, 0.1); color: var(--primary-color); }
        .menu-item.active { background-color: rgba(52, 152, 219, 0.1); color: var(--primary-color); border-left-color: var(--primary-color); font-weight: bold; }
        .menu-item .notifications-badge { margin-left: auto; }
        /* --- Styles Main Content & Formulaires --- */
        main.main-content { flex: 1; padding: 2rem; overflow-y: auto; }
        .content-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; flex-wrap: wrap; gap: 1rem; }
        .welcome-message h1 { font-size: 1.8rem; color: var(--secondary-color); margin-bottom: 0.5rem; }
        .welcome-message p { color: var(--dark-gray); }
        .quick-actions { display: flex; gap: 1rem; flex-wrap: wrap; }
        .action-button { padding: 0.7rem 1.5rem; background-color: var(--primary-color); color: white; border: none; border-radius: 4px; cursor: pointer; display: inline-flex; align-items: center; transition: all 0.3s; text-decoration: none; font-size: 0.9rem; }
        .action-button:hover { background-color: #2980b9; transform: translateY(-2px); box-shadow: 0 4px 8px rgba(0,0,0,0.1); }
        .action-button i { margin-right: 8px; }
        .action-button.save-btn { background-color: var(--success-color); }
        /* ... autres styles boutons ... */
        .btn-sm { padding: 0.3rem 0.8rem; font-size: 0.85em; }
        .btn-secondary { background-color: var(--gray); color: white; border:none; border-radius: 4px; cursor:pointer; }
        .btn-secondary:hover { background-color: var(--dark-gray); }
        .btn-primary { background-color: var(--primary-color); color: white; border:none; border-radius: 4px; cursor:pointer; }
        .btn-primary:hover { background-color: #2980b9; }
        .btn-danger { background-color: var(--accent-color); color: white; border: none; border-radius: 4px; cursor: pointer; }
        .alert { padding: 1rem; border-radius: 4px; margin-bottom: 1.5rem; border: 1px solid transparent; }
        .alert-success { background-color: #d4edda; color: #155724; border-color: #c3e6cb; }
        .alert-danger { background-color: #f8d7da; color: #721c24; border-color: #f5c6cb; }
        /* Styles Formulaires Livewire */
        .cv-editor-container { }
        .cv-form-section { background: white; padding: 2rem; border-radius: 8px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); width: 100%; }
        .form-section { margin-bottom: 2.5rem; }
        .form-repeater-item { border: 1px solid #eee; padding: 1.5rem; margin-bottom: 1rem; border-radius: 5px; position: relative; background: #fafafa; }
        .item-actions { position: absolute; top: 10px; right: 10px; display: flex; gap: 8px; }
        .item-actions button { border: none; background: none; cursor: pointer; padding: 0; font-size: 1.1em; line-height: 1; }
        .item-actions .edit-item-btn { color: var(--primary-color); }
        .item-actions .delete-item-btn { color: var(--accent-color); }
        .form-section-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; border-bottom: 1px solid var(--border-color); padding-bottom: 0.8rem; }
        .form-section-header h4 { margin: 0; color: var(--primary-color); font-size: 1.3rem; }
        .add-item-btn { font-size: 0.9em; padding: 0.4rem 1rem; background-color: var(--primary-color); color: white; border: none; border-radius: 4px; cursor: pointer; display: inline-flex; align-items: center;}
        .add-item-btn i { margin-right: 5px; }
        .form-control { width: 100%; padding: 0.7rem 1rem; border: 1px solid #ccc; border-radius: 4px; margin-bottom: 0.2rem; font-size: 0.95rem; }
        .form-control:focus { border-color: var(--primary-color); box-shadow: 0 0 0 2px rgba(52, 152, 219, 0.2); outline: none; }
        .form-label { display: block; margin-bottom: 0.4rem; font-weight: 600; font-size: 0.9rem; color: var(--secondary-color); }
        .form-group { margin-bottom: 1rem; }
        .row { display: flex; flex-wrap: wrap; gap: 1.5rem; margin-bottom: 1rem; }
        .col { flex: 1; min-width: 200px; }
        /* Validation Livewire */
        .form-control.is-invalid { border-color: var(--accent-color) !important; }
        .invalid-feedback { color: var(--accent-color); font-size: 0.8em; display: block; min-height: 1.2em; }
        /* Styles Trix Editor */
        trix-toolbar [data-trix-button-group="file-tools"] { display: none; }
        .trix-content { background-color: white; border: 1px solid #ccc; border-radius: 4px; padding: 0.5rem; min-height: 100px; margin-top: 0.2rem; }
        .trix-content:focus-within { border-color: var(--primary-color); box-shadow: 0 0 0 2px rgba(52, 152, 219, 0.2); outline: none;}
        .trix-content.is-invalid { border-color: var(--accent-color) !important; }
         /* Style pour affichage carte */
         .description-display { font-size: 0.9em; color: #555; background-color: #f0f0f0; border-radius: 4px; padding: 8px 12px; margin-top: 8px; word-wrap: break-word; }
         /* Responsive */
        @media (max-width: 768px) { /* ... styles responsive ... */ }
    </style>

    {{-- Inclure Alpine.js --}}
    <script src="//unpkg.com/alpinejs" defer></script>
</head>
<body>

    {{-- Section Header --}}
    <header class="app-header">
        <div class="logo"> <i class="fas fa-briefcase"></i> <span>StagesBENIN</span> </div>
        <div class="header-actions">
            <div style="position: relative; margin-right: 1.5rem; cursor: pointer;"> <i class="fas fa-bell fa-lg"></i> </div>
            <div class="profile-menu"> <div class="profile-image"> <i class="fas fa-user"></i> </div> </div>
        </div>
    </header>

    {{-- Section Conteneur Principal --}}
    <div class="app-container">

        {{-- Section Sidebar --}}
        <aside class="app-sidebar">
             <nav class="sidebar-menu">
                 <a href="{{ route('etudiants.dashboard') ?? '#' }}" class="menu-item {{ request()->routeIs('etudiants.dashboard') ? 'active' : '' }}"> <i class="fas fa-home"></i> <span>Tableau de bord</span> </a>
                 <a href="{{ route('etudiants.cv.edit') }}" class="menu-item active"> <i class="fas fa-file-alt"></i> <span>Éditeur CV</span> </a>
                 <a href="{{ route('etudiants.cv.show') ?? '#' }}" class="menu-item {{ request()->routeIs('etudiants.cv.show') ? 'active' : '' }}"> <i class="fas fa-eye"></i> <span>Visualiser CV</span> </a>
                 <a href="{{ route('profile.edit') ?? '#' }}" class="menu-item {{ request()->routeIs('profile.edit') ? 'active' : '' }}"> <i class="fas fa-user-circle"></i> <span>Mon Profil</span> </a>
                 <a href="{{ route('logout') }}" class="menu-item" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"> <i class="fas fa-sign-out-alt"></i> <span>Déconnexion</span> </a>
                 <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;"> @csrf </form>
             </nav>
        </aside>

        {{-- Section Contenu Principal --}}
        <main class="main-content">
            <div class="content-header">
                 <div class="welcome-message"><h1>Éditeur de CV</h1><p>Modifiez chaque section.</p></div>
                 <div class="quick-actions">
                     <a href="{{ route('etudiants.cv.show') ?? '#' }}" class="action-button" target="_blank"><i class="fas fa-eye"></i> <span>Visualiser le CV Final</span></a>
                 </div>
            </div>

            {{-- Messages Flash Globaux --}}
            @if (session()->has('message')) <div class="alert alert-success" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)">{{ session('message') }}</div> @endif
            @if (session()->has('error')) <div class="alert alert-danger">{{ session('error') }}</div> @endif

            <div class="cv-editor-container">
                <div class="cv-form-section">
                    @isset($cvProfile)
                        {{-- Appel des composants Livewire --}}
                        @livewire('etudiants.cv-profile-form', ['cvProfileId' => $cvProfile->id], key('lw-profile-'.$cvProfile->id))
                        @livewire('etudiants.cv-formations-form', ['cvProfileId' => $cvProfile->id], key('lw-formations-'.$cvProfile->id))
                        @livewire('etudiants.cv-experiences-form', ['cvProfileId' => $cvProfile->id], key('lw-experiences-'.$cvProfile->id))
                        @livewire('etudiants.cv-competences-form', ['cvProfileId' => $cvProfile->id], key('lw-competences-'.$cvProfile->id))
                        @livewire('etudiants.cv-langues-form', ['cvProfileId' => $cvProfile->id], key('lw-langues-'.$cvProfile->id))
                        @livewire('etudiants.cv-centres-interet-form', ['cvProfileId' => $cvProfile->id], key('lw-interets-'.$cvProfile->id))
                        @livewire('etudiants.cv-certifications-form', ['cvProfileId' => $cvProfile->id], key('lw-certs-'.$cvProfile->id))
                        @livewire('etudiants.cv-projets-form', ['cvProfileId' => $cvProfile->id], key('lw-projets-'.$cvProfile->id))
                    @else
                        <div class="alert alert-danger">Erreur critique: Le profil CV n'a pas pu être chargé.</div>
                        @php \Log::critical("Variable \$cvProfile non définie/nulle lors du rendu de etudiants.cv.edit view."); @endphp
                    @endisset
                </div>
            </div>
        </main>
    </div>

    {{-- Scripts Livewire --}}
    @livewireScripts

    {{-- Trix Editor JS (après Livewire) --}}
    <script type="text/javascript" src="https://unpkg.com/trix@2.0.8/dist/trix.umd.min.js"></script>

    {{-- Script pour gérer le reset de Trix (global, car dispatchBrowserEvent) --}}
    <script>
         window.addEventListener('reset-trix', event => {
             if (event.detail && event.detail.inputId) {
                 const editor = document.querySelector(`trix-editor[input='${event.detail.inputId}']`);
                 const input = document.getElementById(event.detail.inputId);
                 if (editor && input) {
                      // Vider l'éditeur Trix visuellement
                      editor.editor.loadHTML('');
                      
                 }
             }
         });
    </script>

</body>
</html>