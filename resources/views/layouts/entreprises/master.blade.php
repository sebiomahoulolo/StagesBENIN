<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Espace Entreprise - StagesBENIN')</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
    <style>
        /* Variables globales */
        :root {
            --primary: #3498db;
            --primary-dark: #2980b9;
            --secondary: #2c3e50;
            --success: #2ecc71;
            --danger: #e74c3c;
            --warning: #f39c12;
            --info: #3498db;
            --light: #f9fafb;
            --dark: #1f2937;
            --gray: #6b7280;
            --sidebar-width: 250px;
            --sidebar-width-collapsed: 70px;
            --header-height: 60px;
            --border-radius: 8px;
            --transition: all 0.3s ease;
            --box-shadow-sm: 0 1px 3px rgba(0,0,0,0.05);
            --box-shadow: 0 4px 10px rgba(0,0,0,0.08);
            --box-shadow-lg: 0 5px 15px rgba(0,0,0,0.15);
            --border-color: #e5e7eb;
        }

        /* Base Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: #f3f4f6;
            overflow-x: hidden;
            color: var(--dark);
        }

        /* Scrollbar */
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; }
        ::-webkit-scrollbar-thumb { background: var(--gray); border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: var(--primary); }

        /* Dashboard Layout */
        .dashboard {
            display: flex;
            min-height: 100vh;
            position: relative;
        }

        /* Main Content Area */
        .main-content {
            flex: 1;
            margin-left: var(--sidebar-width);
            transition: margin-left var(--transition);
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .main-content.collapsed {
            margin-left: var(--sidebar-width-collapsed);
        }

        /* Content Area within Main */
        .content {
            padding: 25px;
            flex-grow: 1;
        }

        /* Overlay pour le mobile */
        .sidebar-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 99;
            display: none;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .sidebar-overlay.show {
            display: block;
            opacity: 1;
        }

        /* Responsive Adjustments */
        @media (max-width: 768px) {
            .main-content {
                margin-left: 0;
            }
            
            .main-content.with-sidebar {
                margin-left: var(--sidebar-width);
            }

            .sidebar {
                transform: translateX(-100%);
                z-index: 1000;
            }
            
            .sidebar.show {
                transform: translateX(0);
                box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
            }
        }

        @media (max-width: 576px) {
            .content { 
                padding: 15px; 
            }
        }
    </style>

    @stack('styles')
</head>

<body>
    <div class="dashboard">
        <!-- Overlay pour le mobile -->
        <div class="sidebar-overlay" id="sidebar-overlay"></div>

        @include('layouts.entreprises.aside')
        
        <div class="main-content" id="main-content">
            @include('layouts.entreprises.header')
            
            <!-- Page Content -->
            <main class="content">
            @yield('content')
        </main>
        </div>
    </div>

    <!-- Toast Container for notifications -->
    <div class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index: 1100">
        <div id="successToast" class="toast align-items-center text-white bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    <i class="fas fa-check-circle me-2"></i>
                    <span id="successToastMessage">Opération effectuée avec succès !</span>
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
        <div id="errorToast" class="toast align-items-center text-white bg-danger border-0" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <span id="errorToastMessage">Une erreur s'est produite.</span>
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>
    
    <!-- Logout Form (Hidden) -->
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
    
    <!-- Bootstrap Bundle JS (includes Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

    <!-- Core JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize Bootstrap Tooltips
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            });

            // Sidebar Elements
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('main-content');
            const toggleButton = document.getElementById('toggle-sidebar-btn');
            const overlay = document.getElementById('sidebar-overlay');

            console.log('Sidebar:', sidebar);
            console.log('Main Content:', mainContent);
            console.log('Toggle Button:', toggleButton);
            console.log('Overlay:', overlay);

            // État mobile vs desktop
            const isMobile = () => window.innerWidth <= 768;
            
            // Gérer l'état du sidebar
            const updateSidebarState = (isCollapsed) => {
                if (!sidebar || !mainContent) return;
                
                if (isMobile()) {
                    // Sur mobile
                    if (isCollapsed) {
                        sidebar.classList.remove('show');
                        overlay.classList.remove('show');
                        document.body.style.overflow = '';
                    } else {
                        sidebar.classList.add('show');
                        overlay.classList.add('show');
                        document.body.style.overflow = 'hidden'; // Bloque le scroll de la page
                    }
                } else {
                    // Sur desktop
                    if (isCollapsed) {
                        sidebar.classList.add('collapsed');
                        mainContent.classList.add('collapsed');
                    } else {
                        sidebar.classList.remove('collapsed');
                        mainContent.classList.remove('collapsed');
                    }
                }
                
                localStorage.setItem('sidebarCollapsed', isCollapsed ? 'true' : 'false');
            };

            // État initial
            const setupInitialState = () => {
                const savedState = localStorage.getItem('sidebarCollapsed') === 'true';
                
                if (isMobile()) {
                    // Sur mobile, toujours commencer avec le menu fermé
                    updateSidebarState(true);
                } else {
                    // Sur desktop, utiliser l'état sauvegardé
                    updateSidebarState(savedState);
                }
            };
            
            // Initialiser
            setupInitialState();
            
            // Gérer le redimensionnement de la fenêtre
            window.addEventListener('resize', () => {
                setupInitialState();
            });

            // Click sur le bouton de toggle
            if (toggleButton && sidebar && mainContent) {
                toggleButton.addEventListener('click', (e) => {
                    e.preventDefault();
                    console.log('Toggle button clicked');
                    
                    const isCurrentlyCollapsed = isMobile() 
                        ? !sidebar.classList.contains('show')
                        : sidebar.classList.contains('collapsed');
                    
                    updateSidebarState(!isCurrentlyCollapsed);
                });
            }
            
            // Click sur l'overlay pour fermer
            if (overlay) {
                overlay.addEventListener('click', () => {
                    updateSidebarState(true);
                });
            }

            // Success and Error toasts
            const successToast = document.getElementById('successToast');
            const errorToast = document.getElementById('errorToast');
            
            if (successToast) {
                const bsSuccessToast = new bootstrap.Toast(successToast);
                window.showSuccessToast = function(message) {
                    const messageEl = document.getElementById('successToastMessage');
                    if (messageEl) messageEl.textContent = message;
                    bsSuccessToast.show();
                };
            }
            
            if (errorToast) {
                const bsErrorToast = new bootstrap.Toast(errorToast);
                window.showErrorToast = function(message) {
                    const messageEl = document.getElementById('errorToastMessage');
                    if (messageEl) messageEl.textContent = message;
                    bsErrorToast.show();
                };
            }

            // Flash messages
            @if(session('success'))
                window.showSuccessToast("{{ session('success') }}");
            @endif

            @if(session('error'))
                window.showErrorToast("{{ session('error') }}");
            @endif
        });
    </script>

    @stack('scripts')
</body>
</html>