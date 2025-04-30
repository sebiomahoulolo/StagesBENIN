<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StagesBENIN</title>
    <style>
        :root {
            --primary-color: #2c3e50;
            --secondary-color: #1abc9c;
            --accent-color: #e74c3c;
            --success-color: #27ae60;
            --warning-color: #f39c12;
            --light-gray: #f5f7fa;
            --gray: #95a5a6;
            --dark-gray: #7f8c8d;
            --blue: #3498db;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: #f8f9fa;
        }

        header {
            background: linear-gradient(135deg, var(--primary-color), #34495e);
            color: white;
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .logo {
            font-size: 1.8rem;
            font-weight: bold;
            display: flex;
            align-items: center;
        }

        .logo i {
            margin-right: 10px;
        }

        .header-actions {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .search-box {
            position: relative;
            width: 300px;
        }

        .search-box input {
            width: 100%;
            padding: 8px 15px;
            border-radius: 20px;
            border: none;
            font-size: 0.9rem;
            padding-left: 40px;
        }

        .search-box i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--gray);
        }

        .notifications,
        .messages {
            position: relative;
            cursor: pointer;
        }

        .badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background-color: var(--accent-color);
            color: white;
            font-size: 0.7rem;
            width: 18px;
            height: 18px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .profile-menu {
            display: flex;
            align-items: center;
            cursor: pointer;
            position: relative;
        }

        .profile-image {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: var(--secondary-color);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 10px;
            color: white;
        }

        .profile-info {
            display: flex;
            flex-direction: column;
        }

        .profile-name {
            font-weight: bold;
            font-size: 0.9rem;
        }

        .profile-role {
            font-size: 0.8rem;
            opacity: 0.8;
        }

        /* Styles pour le dropdown du profil */
        .dropdown-menu {
            position: absolute;
            right: 0;
            top: 100%;
            width: 250px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            z-index: 100;
            padding: 0.5rem 0;
            margin-top: 0.5rem;
        }
        
        .dropdown-user-info {
            padding: 1rem;
            border-bottom: 1px solid var(--light-gray);
        }
        
        .dropdown-separator {
            height: 1px;
            background-color: var(--light-gray);
            margin: 0.3rem 0;
        }
        
        .dropdown-item {
            display: flex;
            align-items: center;
            padding: 0.7rem 1rem;
            color: var(--primary-color);
            text-decoration: none;
            transition: background-color 0.2s;
        }
        
        .dropdown-item:hover {
            background-color: var(--light-gray);
        }
        
        /* Animation et utilitaires */
        .transition {
            transition-property: background-color, border-color, color, fill, stroke, opacity, box-shadow, transform;
        }
        
        .duration-150 {
            transition-duration: 150ms;
        }
        
        .duration-200 {
            transition-duration: 200ms;
        }
        
        .ease-in {
            transition-timing-function: cubic-bezier(0.4, 0, 1, 1);
        }
        
        .ease-out {
            transition-timing-function: cubic-bezier(0, 0, 0.2, 1);
        }
        
        [x-cloak] {
            display: none !important;
        }

        .container {
            display: flex;
        }

        .sidebar {
            width: 260px;
            background-color: white;
            min-height: calc(100vh - 70px);
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.05);
            z-index: 10;
        }

        .sidebar-menu {
            padding: 1rem 0;
        }

        .menu-category {
            padding: 0.5rem 1.5rem;
            font-size: 0.75rem;
            text-transform: uppercase;
            color: var(--gray);
            font-weight: bold;
            margin-top: 1rem;
        }

        .menu-item {
            padding: 0.8rem 1.5rem;
            display: flex;
            align-items: center;
            color: var(--dark-gray);
            text-decoration: none;
            transition: all 0.3s;
            font-size: 0.95rem;
            position: relative;
        }

        .menu-item i {
            margin-right: 10px;
            width: 20px;
            text-align: center;
        }

        .menu-item:hover,
        .menu-item.active {
            background-color: rgba(26, 188, 156, 0.1);
            color: var(--secondary-color);
            border-left: 3px solid var(--secondary-color);
        }

        .menu-item.active {
            font-weight: bold;
        }

        .menu-badge {
            position: absolute;
            right: 15px;
            background-color: var(--accent-color);
            color: white;
            font-size: 0.7rem;
            padding: 2px 8px;
            border-radius: 10px;
        }

        .main-content {
            flex: 1;
            padding: 2rem;
        }

        .page-title {
            margin-bottom: 2rem;
            color: var(--primary-color);
        }

        .stats-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            padding: 1.5rem;
            transition: all 0.3s;
            display: flex;
            align-items: center;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        }

        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin-right: 1rem;
        }

        .stat-icon.blue {
            background-color: rgba(52, 152, 219, 0.1);
            color: var(--blue);
        }

        .stat-icon.green {
            background-color: rgba(39, 174, 96, 0.1);
            color: var(--success-color);
        }

        .stat-icon.orange {
            background-color: rgba(243, 156, 18, 0.1);
            color: var(--warning-color);
        }

        .stat-icon.red {
            background-color: rgba(231, 76, 60, 0.1);
            color: var(--accent-color);
        }

        .stat-info {
            flex: 1;
        }

        .stat-value {
            font-size: 1.8rem;
            font-weight: bold;
            color: var(--primary-color);
            margin-bottom: 0.3rem;
        }

        .stat-label {
            color: var(--gray);
            font-size: 0.9rem;
        }

        .trend {
            font-size: 0.8rem;
            display: flex;
            align-items: center;
        }

        .trend.up {
            color: var(--success-color);
        }

        .trend.down {
            color: var(--accent-color);
        }

        .trend i {
            margin-right: 5px;
        }

        .dashboard-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .recent-applications,
        .upcoming-interviews,
        .activity-feed {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            padding: 1.5rem;
            height: 100%;
        }

        .widget-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .widget-title {
            font-size: 1.2rem;
            color: var(--primary-color);
            font-weight: bold;
        }

        .widget-action {
            color: var(--secondary-color);
            font-size: 0.9rem;
            text-decoration: none;
            display: flex;
            align-items: center;
        }

        .widget-action i {
            margin-left: 5px;
        }

        .application-item {
            display: flex;
            align-items: center;
            padding: 1rem 0;
            border-bottom: 1px solid var(--light-gray);
        }

        .application-item:last-child {
            border-bottom: none;
        }

        .application-position {
            flex: 1;
        }

        .position-title {
            font-weight: bold;
            color: var(--primary-color);
            margin-bottom: 0.3rem;
        }

        .position-info {
            display: flex;
            font-size: 0.85rem;
            color: var(--gray);
        }

        .position-info span {
            display: flex;
            align-items: center;
            margin-right: 1rem;
        }

        .position-info i {
            margin-right: 5px;
            font-size: 0.8rem;
        }

        .application-count {
            background-color: var(--light-gray);
            padding: 0.5rem 0.8rem;
            border-radius: 4px;
            font-weight: bold;
            color: var(--primary-color);
            margin-right: 1rem;
        }

        .application-actions button {
            padding: 0.5rem;
            border: none;
            background-color: transparent;
            cursor: pointer;
            color: var(--dark-gray);
            transition: color 0.3s;
        }

        .application-actions button:hover {
            color: var(--primary-color);
        }

        .interview-item {
            padding: 1rem;
            background-color: var(--light-gray);
            border-radius: 6px;
            margin-bottom: 1rem;
        }

        .interview-date {
            display: flex;
            align-items: center;
            margin-bottom: 0.5rem;
            font-size: 0.9rem;
            color: var(--primary-color);
        }

        .interview-date i {
            margin-right: 8px;
        }

        .interview-position {
            font-weight: bold;
            margin-bottom: 0.3rem;
        }

        .interview-candidates {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
            margin-top: 0.8rem;
        }

        .candidate-tag {
            background-color: white;
            padding: 0.3rem 0.8rem;
            border-radius: 20px;
            font-size: 0.8rem;
            display: flex;
            align-items: center;
        }

        .candidate-tag i {
            margin-right: 5px;
            font-size: 0.7rem;
        }

        .activity-item {
            display: flex;
            padding: 1rem 0;
            border-bottom: 1px solid var(--light-gray);
        }

        .activity-item:last-child {
            border-bottom: none;
        }

        .activity-dot {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            margin-right: 15px;
            margin-top: 5px;
        }

        .activity-dot.blue {
            background-color: var(--blue);
        }

        .activity-dot.green {
            background-color: var(--success-color);
        }

        .activity-dot.orange {
            background-color: var(--warning-color);
        }

        .activity-dot.red {
            background-color: var(--accent-color);
        }

        .activity-content {
            flex: 1;
        }

        .activity-text {
            margin-bottom: 0.3rem;
        }

        .activity-text strong {
            color: var(--primary-color);
            font-weight: 600;
        }

        .activity-time {
            font-size: 0.8rem;
            color: var(--gray);
        }

        @media (max-width: 1200px) {
            .dashboard-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 992px) {
            .stats-container {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 768px) {
            .container {
                flex-direction: column;
            }

            .sidebar {
                width: 100%;
                min-height: auto;
            }

            .search-box {
                display: none;
            }

            .stats-container {
                grid-template-columns: 1fr;
            }
        }

        /* Styles supplémentaires pour le dropdown */
        .profile-dropdown {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            padding: 0.5rem 0;
            width: 250px;
            z-index: 9999;
        }
        
        /* Assurer que les transitions d'Alpine.js fonctionnent */
        .opacity-0 {
            opacity: 0;
        }
        
        .opacity-100 {
            opacity: 1;
        }
        
        .scale-95 {
            transform: scale(0.95);
        }
        
        .scale-100 {
            transform: scale(1);
        }
    </style>
    {{-- Alpine.js (déplacé en haut pour être chargé en premier) --}}
    <script src="//unpkg.com/alpinejs" defer></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    @livewireStyles()
</head>

<body>
    @include('layouts.entreprises.header')

    <div class="container">
        @include('layouts.entreprises.aside')
        <main class="main-content">
            @yield('content')

        </main>
    </div>
    
    {{-- Formulaire de déconnexion --}}
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
    @stack('script')
    @livewireScripts()
</body>
</html>