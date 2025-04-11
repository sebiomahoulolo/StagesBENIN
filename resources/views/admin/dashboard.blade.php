<title>StagesBENIN</title>

<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- Font Awesome (Optional: Replace emojis with FA icons) -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<style>
    :root {
        --primary: #2563eb;
        --primary-dark: #1d4ed8;
        --secondary: #4f46e5;
        --success: #10b981;
        --danger: #ef4444;
        --warning: #f59e0b;
        --info: #3b82f6;
        --light: #f9fafb;
        --dark: #1f2937;
        --gray: #6b7280;
        --sidebar-width: 250px;
        --sidebar-width-collapsed: 70px;
        --header-height: 60px;
        --border-radius: 8px;
        --transition: all 0.3s ease;
    }

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    body {
        background-color: #f3f4f6;
        overflow-x: hidden; /* Prevent horizontal scroll */
    }

    /* Scrollbar styling */
    ::-webkit-scrollbar { width: 6px; height: 6px; }
    ::-webkit-scrollbar-track { background: #f1f1f1; }
    ::-webkit-scrollbar-thumb { background: var(--gray); border-radius: 4px; }
    ::-webkit-scrollbar-thumb:hover { background: var(--primary); }

    .dashboard {
        display: flex;
        min-height: 100vh;
    }

    /* Sidebar */
    .sidebar {
        width: var(--sidebar-width);
        background-color: var(--dark);
        color: white;
        height: 100vh;
        position: fixed;
        top: 0;
        left: 0;
        z-index: 100;
        transition: var(--transition);
        box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
        display: flex;
        flex-direction: column;
    }

    .sidebar-header {
        display: flex;
        align-items: center;
        padding: 15px 20px;
        height: var(--header-height);
        background-color: rgba(0, 0, 0, 0.2);
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        flex-shrink: 0; /* Prevent shrinking */
    }

    .sidebar-logo {
        width: 35px;
        height: 35px;
        border-radius: 6px;
        margin-right: 10px;
        background-color: var(--primary);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
        font-weight: bold;
        flex-shrink: 0;
    }

    .sidebar-header h2 {
        font-size: 1.2rem;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        transition: opacity 0.2s ease;
    }

    .sidebar-menu {
        padding: 15px 0;
        overflow-y: auto;
        flex-grow: 1; /* Take remaining height */
        height: calc(100vh - var(--header-height));
    }

    .menu-category {
        font-size: 0.75rem;
        text-transform: uppercase;
        padding: 12px 20px 8px;
        color: var(--gray);
        letter-spacing: 0.5px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .menu-item {
        padding: 10px 20px;
        display: flex;
        align-items: center;
        cursor: pointer;
        transition: var(--transition);
        margin: 2px 0;
        position: relative;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        text-decoration: none; /* For links */
        color: white; /* For links */
    }

    .menu-item.active, .menu-item:hover {
        background-color: rgba(255, 255, 255, 0.1);
        color: var(--primary);
    }
    .menu-item a { text-decoration: none; color: inherit; display: flex; align-items: center; width: 100%; }


    .menu-item.active::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        width: 3px;
        height: 100%;
        background-color: var(--primary);
    }

    .menu-icon {
        width: 20px;
        margin-right: 10px;
        display: inline-flex;
        justify-content: center;
        flex-shrink: 0;
    }

    .menu-text {
         transition: opacity 0.2s ease;
    }

    .menu-badge {
        background-color: var(--danger);
        color: white;
        border-radius: 10px;
        padding: 2px 8px;
        font-size: 0.7rem;
        margin-left: auto;
        transition: opacity 0.2s ease;
        flex-shrink: 0;
    }

    /* Main Content */
    .main-content {
        flex: 1;
        margin-left: var(--sidebar-width);
        transition: margin-left var(--transition);
    }

    .header {
        height: var(--header-height);
        background-color: white;
        display: flex;
        align-items: center;
        padding: 0 20px;
        position: sticky;
        top: 0;
        z-index: 99;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
    }

    .toggle-sidebar {
        margin-right: 15px;
        background: none;
        border: none;
        font-size: 1.4rem;
        cursor: pointer;
        color: var(--dark);
    }

    .search-bar {
        flex: 1;
        max-width: 400px;
        position: relative;
        margin-right: 20px;
    }

    .search-bar input {
        width: 100%;
        padding: 8px 15px 8px 35px;
        border-radius: var(--border-radius);
        border: 1px solid #e5e7eb;
        background-color: #f9fafb;
    }
    .search-bar input:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 2px rgba(37, 99, 235, 0.2);
    }

    .search-icon {
        position: absolute;
        left: 10px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--gray);
    }

    .header-actions {
        display: flex;
        align-items: center;
        margin-left: auto;
        gap: 5px; /* Spacing between icons */
    }

    .header-icon {
        width: 35px;
        height: 35px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        position: relative;
        transition: var(--transition);
        color: var(--dark);
        border: none;
        background: none;
    }

    .header-icon:hover {
        background-color: #f3f4f6;
        color: var(--primary);
    }

    .notification-badge {
        position: absolute;
        top: 2px;
        right: 2px;
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background-color: var(--danger);
    }

    .user-profile {
        display: flex;
        align-items: center;
        margin-left: 15px;
        cursor: pointer;
        position: relative;
    }

    .profile-image {
        width: 35px;
        height: 35px;
        border-radius: 50%;
        background-color: var(--primary);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        margin-right: 10px;
    }

    .profile-info { display: flex; flex-direction: column; }
    .profile-name { font-size: 0.9rem; font-weight: 500; color: var(--dark); }
    .profile-role { font-size: 0.7rem; color: var(--gray); }

    /* Dashboard content */
    .content { padding: 25px; }
    .dashboard-title { margin-bottom: 25px; font-size: 1.6rem; color: var(--dark); font-weight: 600; }

    .stats-container {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }

    .stat-card {
        background-color: white;
        border-radius: var(--border-radius);
        padding: 20px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        display: flex;
        flex-direction: column;
        transition: var(--transition);
        border: 1px solid #e5e7eb;
    }

    .stat-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.08);
    }

    .stat-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px; }
    .stat-title { color: var(--gray); font-size: 0.9rem; }

    .stat-icon {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
    }
    .stat-icon i { font-size: 1.1rem; } /* Adjust icon size */

    .bg-primary { background-color: var(--primary); }
    .bg-success { background-color: var(--success); }
    .bg-warning { background-color: var(--warning); }
    .bg-danger { background-color: var(--danger); }

    .stat-value { font-size: 1.8rem; font-weight: bold; color: var(--dark); margin-bottom: 8px; }
    .stat-progress { font-size: 0.8rem; display: flex; align-items: center; color: var(--gray); }
    .stat-progress i { margin-right: 4px; font-size: 0.7rem;}
    .up { color: var(--success); }
    .down { color: var(--danger); }

    /* Tabs */
    .tabs-container {
        background-color: white;
        border-radius: var(--border-radius);
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        border: 1px solid #e5e7eb;
        margin-bottom: 30px;
        overflow: hidden;
    }

    .tabs-header {
        display: flex;
        border-bottom: 1px solid #e5e7eb;
        overflow-x: auto;
        scrollbar-width: none; /* Firefox */
        -ms-overflow-style: none;  /* IE/Edge */
        flex-wrap: wrap; /* Allow wrapping on small screens */
    }
    .tabs-header::-webkit-scrollbar { display: none; } /* Chrome/Safari */

    .tab {
        padding: 15px 20px;
        cursor: pointer;
        white-space: nowrap;
        color: var(--gray);
        position: relative;
        transition: var(--transition);
        font-weight: 500;
        border: none; /* Remove default button border */
        background: none; /* Remove default button background */
        border-bottom: 3px solid transparent; /* Bottom border for active state */
         flex: 0 0 auto; /* Prevent stretching, allow shrinking */
    }

    .tab:hover { color: var(--primary); background-color: #f9fafb; }
    .tab.active { color: var(--primary); border-bottom-color: var(--primary); }

    .tab-content { display: none; padding: 25px; }
    .tab-content.active { display: block; animation: fadeIn 0.5s; }

    @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }

    /* Table Styles (using Bootstrap classes mostly, but can add custom overrides) */
    .table { margin-bottom: 0; } /* Remove default bottom margin inside tab content */
    .table th { background-color: #f9fafb; font-weight: 600; }
    .table td { vertical-align: middle; }
    .table-hover tbody tr:hover { background-color: #f9fafb; }

    .status {
        display: inline-flex; align-items: center;
        padding: 4px 10px; border-radius: 15px;
        font-size: 0.75rem; font-weight: 500;
        white-space: nowrap;
    }
    .status-active { background-color: rgba(16, 185, 129, 0.1); color: var(--success); }
    .status-pending { background-color: rgba(245, 158, 11, 0.1); color: var(--warning); }
    .status-blocked { background-color: rgba(239, 68, 68, 0.1); color: var(--danger); }

    .action-bar { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; flex-wrap: wrap; gap: 15px;}
    .action-buttons { display: flex; gap: 10px; flex-wrap: wrap; }

    /* Modal Styles (Leverage Bootstrap, customize if needed) */
    .modal-content { border-radius: var(--border-radius); border: none; box-shadow: 0 5px 15px rgba(0,0,0,0.15); }
    .modal-header { border-bottom: 1px solid #e5e7eb; padding: 1rem 1.5rem; }
    .modal-title { font-size: 1.2rem; font-weight: 600; }
    .modal-body { padding: 1.5rem; }
    .modal-footer { border-top: 1px solid #e5e7eb; padding: 1rem 1.5rem; background-color: #f9fafb; border-bottom-left-radius: var(--border-radius); border-bottom-right-radius: var(--border-radius); }

    /* Form Styles (Leverage Bootstrap, customize if needed) */
    .form-label { font-weight: 500; margin-bottom: 0.3rem; color: var(--dark); }
    .form-control:focus, .form-select:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 0.25rem rgba(37, 99, 235, 0.25);
    }
    textarea.form-control { min-height: 100px; resize: vertical; }

    /* Sidebar Collapsed State */
    .sidebar.collapsed { width: var(--sidebar-width-collapsed); }
    .sidebar.collapsed .sidebar-header h2,
    .sidebar.collapsed .menu-text,
    .sidebar.collapsed .menu-category,
    .sidebar.collapsed .menu-badge {
        opacity: 0;
        width: 0; /* Helps with hiding */
        overflow: hidden; /* Ensures it's hidden */
        white-space: nowrap;
    }
     .sidebar.collapsed .menu-item { justify-content: center; }
    .sidebar.collapsed .menu-icon { margin-right: 0; }
    .sidebar.collapsed .menu-badge { position: absolute; top: 5px; right: 5px; opacity: 1; width: auto; } /* Keep badge visible potentially */


    .main-content.collapsed { margin-left: var(--sidebar-width-collapsed); }

    /* Responsive Adjustments */
    @media (max-width: 992px) {
         /* Apply collapsed styles by default on smaller screens if desired */
         /* Or just adjust layout */
        .profile-info { display: none; } /* Hide text on smaller screens */
    }

    @media (max-width: 768px) {
        .stats-container { grid-template-columns: 1fr; }
        .search-bar { max-width: 200px; }
        .header-actions { gap: 2px; } /* Reduce gap */
        .user-profile { margin-left: 5px; }
        .profile-image { margin-right: 0; } /* Hide text AND image margin */
         .toggle-sidebar { display: block; } /* Ensure toggle is always visible */
         /* Force sidebar collapsed on very small screens if needed */
         .sidebar { width: var(--sidebar-width-collapsed); }
         .main-content { margin-left: var(--sidebar-width-collapsed); }
         .sidebar .sidebar-header h2,
         .sidebar .menu-text,
         .sidebar .menu-category,
         .sidebar .menu-badge:not(.absolute-badge) { display: none; } /* Force hide elements */
         .sidebar .menu-item { justify-content: center; }
         .sidebar .menu-icon { margin-right: 0; }
         .menu-badge.absolute-badge { position: absolute; top: 5px; right: 5px; display: block !important; }

    }

    @media (max-width: 576px) {
        .content { padding: 15px; }
        .dashboard-title { font-size: 1.4rem; }
        .header { padding: 0 15px; }
        .search-bar { display: none; } /* Hide search on very small screens */
        .action-bar { flex-direction: column; align-items: flex-start; }
        .tabs-header { flex-wrap: nowrap; } /* Prevent wrapping if too many tabs */
         .tab { padding: 12px 15px; font-size: 0.9rem; }
    }

</style>
Use code with caution.
</head>
<body>
    <div class="dashboard">
        <!-- Sidebar -->
        <div class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <div class="sidebar-logo">S</div>
                <h2>StagesBENIN</h2>
            </div>
            <div class="sidebar-menu">
                <div class="menu-category">Principal</div>
                 <!-- Add "active" class to the current page's menu item -->
                <a href="#" class="menu-item active">
                    <div class="menu-icon"><i class="fas fa-tachometer-alt"></i></div>
                    <span class="menu-text">Tableau de bord</span>
                </a>
                <a href="#" class="menu-item">
                    <div class="menu-icon"><i class="fas fa-newspaper"></i></div>
                    <span class="menu-text">Actualités</span>
                    <span class="menu-badge">5</span>
                </a>
                 <a href="#" class="menu-item">
                    <div class="menu-icon"><i class="fas fa-briefcase"></i></div>
                    <span class="menu-text">Recrutements</span>
                 </a>
                <a href="{{ route('pages.evenements') }}" class="menu-item"> <!-- Assuming this route exists -->
                    <div class="menu-icon"><i class="fas fa-calendar-alt"></i></div>
                    <span class="menu-text">Événements</span>
                </a>
<div class="menu-category">Gestion</div>
            <a href="#" class="menu-item">
                <div class="menu-icon"><i class="fas fa-users"></i></div>
                <span class="menu-text">Étudiants</span>
                <span class="menu-badge absolute-badge">12</span> <!-- Add class if needed for positioning when collapsed -->
            </a>
            <a href="#" class="menu-item">
                <div class="menu-icon"><i class="fas fa-building"></i></div>
                <span class="menu-text">Entreprises</span>
            </a>
            <a href="#" class="menu-item">
                <div class="menu-icon"><i class="fas fa-book"></i></div>
                <span class="menu-text">Catalogue</span>
            </a>
            <a href="#" class="menu-item">
                <div class="menu-icon"><i class="fas fa-comments"></i></div>
                <span class="menu-text">Messages</span>
                <span class="menu-badge absolute-badge">7</span>
            </a>

            <div class="menu-category">Configuration</div>
             <a href="#" class="menu-item">
                <div class="menu-icon"><i class="fas fa-cog"></i></div>
                <span class="menu-text">Paramètres</span>
            </a>
            <a href="#" class="menu-item">
                <div class="menu-icon"><i class="fas fa-user-shield"></i></div>
                <span class="menu-text">Administrateurs</span>
            </a>
            <a href="#" class="menu-item">
                <div class="menu-icon"><i class="fas fa-file-alt"></i></div>
                <span class="menu-text">Logs</span>
            </a>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content" id="main-content">
        <div class="header">
            <button class="toggle-sidebar" id="toggle-sidebar-btn" aria-label="Basculer la barre latérale">
                <i class="fas fa-bars"></i>
            </button>

            <div class="search-bar">
                <i class="fas fa-search search-icon"></i>
                <input type="text" placeholder="Rechercher..." aria-label="Rechercher">
            </div>

            <div class="header-actions">
                <button class="header-icon" aria-label="Notifications">
                    <i class="fas fa-bell"></i>
                    <span class="notification-badge"></span>
                </button>
                <button class="header-icon" aria-label="Messages">
                    <i class="fas fa-envelope"></i>
                    <span class="notification-badge"></span>
                </button>
                <div class="user-profile" role="button" aria-label="Profil utilisateur">
                    <div class="profile-image">A</div>
                    <div class="profile-info">
                        <span class="profile-name">Admin</span>
                        <span class="profile-role">Super Admin</span>
                    </div>
                    <!-- Add dropdown menu here if needed -->
                </div>
            </div>
        </div>

        <div class="content">
            <h1 class="dashboard-title">Tableau de bord</h1>

            <!-- Stats Section -->
            <div class="stats-container">
                <div class="stat-card">
                    <div class="stat-header">
                        <div class="stat-title">Étudiants inscrits</div>
                        <div class="stat-icon bg-primary"><i class="fas fa-user-graduate"></i></div>
                    </div>
                    <div class="stat-value">{{ $totalEtudiants ?? 0 }}</div> <!-- Default to 0 if variable not set -->
                    <div class="stat-progress up">
                        <i class="fas fa-arrow-up"></i> {{ $progression ?? 'N/A' }} <!-- Default if variable not set -->
                    </div>
                </div>
                 <div class="stat-card">
                    <div class="stat-header">
                        <div class="stat-title">Entreprises partenaires</div>
                        <div class="stat-icon bg-success"><i class="fas fa-building"></i></div>
                    </div>
                    <div class="stat-value">86</div> <!-- Replace with dynamic data -->
                    <div class="stat-progress up">
                        <i class="fas fa-arrow-up"></i> 5% depuis le mois dernier
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-header">
                        <div class="stat-title">Offres actives</div>
                        <div class="stat-icon bg-warning"><i class="fas fa-briefcase"></i></div>
                    </div>
                    <div class="stat-value">124</div> <!-- Replace with dynamic data -->
                    <div class="stat-progress down">
                        <i class="fas fa-arrow-down"></i> 3% depuis le mois dernier
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-header">
                        <div class="stat-title">Entretiens programmés</div>
                        <div class="stat-icon bg-danger"><i class="fas fa-calendar-check"></i></div>
                    </div>
                    <div class="stat-value">37</div> <!-- Replace with dynamic data -->
                    <div class="stat-progress up">
                        <i class="fas fa-arrow-up"></i> 8% depuis le mois dernier
                    </div>
                </div>
            </div>

            <!-- Tabs Section -->
            <div class="tabs-container">
                <div class="tabs-header" role="tablist">
                    <button class="tab active" data-tab="etudiants" role="tab" aria-selected="true" aria-controls="etudiants-content">Étudiants</button>
                    <button class="tab" data-tab="entreprises" role="tab" aria-selected="false" aria-controls="entreprises-content">Entreprises</button>
                    <button class="tab" data-tab="recrutements" role="tab" aria-selected="false" aria-controls="recrutements-content">Recrutements</button>
                    <button class="tab" data-tab="actualites" role="tab" aria-selected="false" aria-controls="actualites-content">Actualités</button>
                    <button class="tab" data-tab="evenements" role="tab" aria-selected="false" aria-controls="evenements-content">Événements</button>
                    <button class="tab" data-tab="catalogue" role="tab" aria-selected="false" aria-controls="catalogue-content">Catalogue</button>
                </div>

                <!-- Tab Content Panels -->
                <div class="tab-content active" id="etudiants-content" role="tabpanel">
                    <div class="action-bar">
                        <div class="action-buttons">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#etudiantModal">
                                <i class="fas fa-plus-circle me-1"></i> Ajouter Étudiant
                            </button>
                        </div>
                        <!-- Add Filters/Search for Students here -->
                    </div>
                    <div class="content-area table-responsive"> <!-- Make table responsive -->
                  
                            
<style>
    .student-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
        background-color: #fff;
        box-shadow: 0 0 12px rgba(0, 0, 0, 0.08);
        border-radius: 10px;
        overflow: hidden;
    }

    .student-table th,
    .student-table td {
        padding: 12px 16px;
        text-align: left;
        border-bottom: 1px solid #dee2e6;
    }

    .student-table th {
        background-color: #212529;
        color: #fff;
        font-weight: 600;
    }

    .student-table tr:last-child td {
        border-bottom: none;
    }

    .btn {
        padding: 8px 12px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 14px;
        transition: all 0.3s ease;
    }

    .btn-warning {
        background-color: #ffc107;
        border: none;
        color: #000;
    }

    .btn-warning:hover {
        background-color: #e0a800;
    }

    .btn-danger {
        background-color: #dc3545;
        border: none;
        color: #fff;
    }

    .btn-danger:hover {
        background-color: #c82333;
    }
</style>

<div class="container py-4">
    <h1 class="mb-4">Liste des Étudiants</h1>
    <table class="student-table">
        <thead>
            <tr>
               
                <th>Nom</th>
                 <th>Prénom</th>
               
                <th>Téléphone</th>
                <th>Niveau</th>
                <th>Formation</th>
                  <th>Profil</th>
                <th>Actions</th>
                  <th>Décision</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($etudiants as $etudiant)
            <tr>
                <td>{{ $etudiant->nom }}</td>
                 <td>{{ $etudiant->prenom }}</td>
               
                 <td>{{ $etudiant->telephone}}</td>
                <td>{{ $etudiant->niveau }}</td>
                <td>{{ $etudiant->formation }}</td>
                <td>  <!-- Voir le profil complet -->
    <a href="{{ route('etudiants.show', $etudiant->id) }}" class="btn btn-info">Voir</a></td>
               <td>
    
  
<!-- Télécharger le CV 
    <a href="{{ route('etudiants.cv.download', $etudiant->id) }}" class="btn btn-secondary">CV</a>-->

    <!-- Inviter à un entretien -->
    <a href="{{ route('etudiants.entretiens', ['etudiant_id' => $etudiant->id]) }}" class="btn btn-primary">Entretien</a>

    <a href="{{ route('etudiants.envoyer.examen', $etudiant->id) }}" class="btn btn-warning mt-1">Examen</a> 
</td>
<td>
<!-- Accepter la candidature -->
    <form action="{{ route('candidatures.accepter', $etudiant->id) }}" method="POST" style="display:inline;">
        @csrf
        <button type="submit" class="btn btn-success"> Accepter</button>
    </form>

    <!-- Rejeter la candidature -->
    <form action="{{ route('candidatures.rejeter', $etudiant->id) }}" method="POST" style="display:inline;">
        @csrf
        <button type="submit" class="btn btn-outline-danger">Rejeter</button>
    </form>
    </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
                      
                    </div>
                </div>

                <div class="tab-content" id="entreprises-content" role="tabpanel">
                    <div class="action-bar">
                        <div class="action-buttons">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#entrepriseModal">
                                <i class="fas fa-plus-circle me-1"></i> Ajouter Entreprise
                            </button>
                        </div>
                    </div>
                     <div class="content-area table-responsive">
                        <h4>Liste des Entreprises</h4>
                        <p>Tableau des entreprises apparaîtra ici.</p>
                     </div>
                </div>

                <div class="tab-content" id="recrutements-content" role="tabpanel">
                     <div class="action-bar">
                        <div class="action-buttons">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#recrutementModal">
                                <i class="fas fa-plus-circle me-1"></i> Ajouter Recrutement
                            </button>
                        </div>
                    </div>
                     <div class="content-area table-responsive">
                        <h4>Liste des Recrutements</h4>
                        <p>Tableau des recrutements apparaîtra ici.</p>
                     </div>
                </div>

                <div class="tab-content" id="actualites-content" role="tabpanel">
                    <div class="action-bar">
                       <div class="action-buttons">
                           <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#actualiteModal">
                               <i class="fas fa-plus-circle me-1"></i> Ajouter Actualité
                           </button>
                       </div>
                   </div>
                    <div class="content-area table-responsive">
                       <h4>Liste des Actualités</h4>
            


                    </div>
                </div>

                <div class="tab-content" id="evenements-content" role="tabpanel">
                    <div class="action-bar">
                        <div class="action-buttons">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#eventModal">
                                <i class="fas fa-plus-circle me-1"></i> Ajouter Événement
                            </button>
                        </div>
                    </div>
                    <div class="content-area table-responsive">
                        <h4>Liste des Événements</h4>
                        @if(isset($events) && !$events->isEmpty())
                            <table class="table table-hover table-bordered">
                                <thead>
                                    <tr>
                                        <th>Titre</th>
                                        <th>Début</th>
                                        <th>Fin</th>
                                        <th>Lieu</th>
                                        <th>Type</th>
                                        <th>Statut</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($events as $event)
                                    <tr>
                                        <td>{{ $event->title }}</td>
                                        <td>{{ \Carbon\Carbon::parse($event->start_date)->format('d/m/Y H:i') }}</td>
                                        <td>{{ \Carbon\Carbon::parse($event->end_date)->format('d/m/Y H:i') }}</td>
                                        <td>{{ $event->location ?? '-' }}</td>
                                        <td>{{ $event->type ?? '-' }}</td>
                                        <td>
                                            {{-- Status Toggle Form --}}
                                            <form action="{{ route('evenements.toggleStatus', $event->id) }}" method="POST" style="display: inline-block;">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-sm {{ $event->is_published ? 'btn-success' : 'btn-secondary' }} status">
                                                    {{ $event->is_published ? 'Publié' : 'Privé' }}
                                                </button>
                                            </form>
                                        </td>
                                        <td>
                                            <div class="d-flex gap-1">
                                                 <a href="{{ route('evenements.show', $event->id) }}" class="btn btn-info btn-sm" title="Voir"><i class="fas fa-eye"></i></a>
                                                 <a href="{{ route('evenements.edit', $event->id) }}" class="btn btn-warning btn-sm" title="Modifier"><i class="fas fa-edit"></i></a>
                                                 {{-- Delete Form --}}
                                                 <form action="{{ route('evenements.destroy', $event->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Confirmer la suppression de cet événement ?')">
                                                     @csrf
                                                     @method('DELETE')
                                                     <button type="submit" class="btn btn-danger btn-sm" title="Supprimer"><i class="fas fa-trash"></i></button>
                                                 </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{-- Add Pagination Links if needed: $events->links() --}}
                        @else
                            <div class="alert alert-info">Aucun événement trouvé pour le moment.</div>
                        @endif
                    </div>
                </div>

                <div class="tab-content" id="catalogue-content" role="tabpanel">
                     <div class="action-bar">
                        <div class="action-buttons">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#catalogueModal">
                                <i class="fas fa-plus-circle me-1"></i> Ajouter au Catalogue
                            </button>
                        </div>
                    </div>
                     <div class="content-area table-responsive">
                        <h4>Catalogue de Formations</h4>
                        <p>Contenu du catalogue apparaîtra ici.</p>
                     </div>
                </div>
            </div>

        </div> <!-- /.content -->
    </div> <!-- /.main-content -->
</div> <!-- /.dashboard -->

<!-- Modals -->

<!-- Event Modal -->
<div class="modal fade" id="eventModal" tabindex="-1" aria-labelledby="eventModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="eventModalLabel">Ajouter un événement</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="eventForm" action="{{ route('events.store') }}" method="POST" class="needs-validation" novalidate enctype="multipart/form-data">
         @csrf <!-- CSRF Token for Laravel -->
          <div class="modal-body">
              <div class="mb-3">
                <label for="event_title" class="form-label">Titre de l'événement*</label>
                <input type="text" class="form-control" id="event_title" name="title" required>
                <div class="invalid-feedback">Veuillez saisir un titre.</div>
              </div>
              <div class="mb-3">
                <label for="event_description" class="form-label">Description</label>
                <textarea class="form-control" id="event_description" name="description" rows="3"></textarea>
              </div>
              <div class="row">
                <div class="col-md-6 mb-3">
                  <label for="event_start_date" class="form-label">Date et heure de début*</label>
                  <input type="datetime-local" class="form-control" id="event_start_date" name="start_date" required>
                  <div class="invalid-feedback">Veuillez saisir une date de début valide.</div>
                </div>
                <div class="col-md-6 mb-3">
                  <label for="event_end_date" class="form-label">Date et heure de fin*</label>
                  <input type="datetime-local" class="form-control" id="event_end_date" name="end_date" required>
                  <div class="invalid-feedback">La date de fin doit être postérieure à la date de début.</div>
                </div>
              </div>
              <div class="mb-3">
                <label for="event_location" class="form-label">Lieu</label>
                <input type="text" class="form-control" id="event_location" name="location">
              </div>
              <div class="row">
                <div class="col-md-6 mb-3">
                  <label for="event_type" class="form-label">Type d'événement</label>
                  <select class="form-select" id="event_type" name="type">
                    <option value="">Sélectionner un type</option>
                    <option value="Conférence">Conférence</option>
                    <option value="Workshop">Workshop</option>
                    <option value="Salon">Salon</option>
                    <option value="Formation">Formation</option>
                    <option value="Networking">Networking</option>
                    <option value="Autre">Autre</option>
                  </select>
                </div>
                <div class="col-md-6 mb-3">
                  <label for="event_max_participants" class="form-label">Nombre max. de participants</label>
                  <input type="number" class="form-control" id="event_max_participants" name="max_participants" min="1">
                </div>
              </div>
              <div class="mb-3">
                <label for="event_image" class="form-label">Image (affiche)</label>
                <input type="file" class="form-control" id="event_image" name="image" accept="image/*">
              </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
            <button type="submit" class="btn btn-primary submit-btn" id="submitEvent">Enregistrer</button>
          </div>
      </form>
    </div>
  </div>
</div>

<!-- Student Modal -->
<div class="modal fade" id="etudiantModal" tabindex="-1" aria-labelledby="etudiantModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="etudiantModalLabel">Ajouter un étudiant</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="etudiantForm" action="{{ route('etudiants.store') }}" method="POST" class="needs-validation" novalidate enctype="multipart/form-data">
         @csrf
          <div class="modal-body">
              <div class="row">
                <div class="col-md-6 mb-3">
                  <label for="etudiant_nom" class="form-label">Nom*</label>
                  <input type="text" class="form-control" id="etudiant_nom" name="nom" required>
                  <div class="invalid-feedback">Veuillez saisir un nom.</div>
                </div>
                <div class="col-md-6 mb-3">
                  <label for="etudiant_prenom" class="form-label">Prénom*</label>
                  <input type="text" class="form-control" id="etudiant_prenom" name="prenom" required>
                  <div class="invalid-feedback">Veuillez saisir un prénom.</div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6 mb-3">
                  <label for="etudiant_email" class="form-label">Email*</label>
                  <input type="email" class="form-control" id="etudiant_email" name="email" required>
                  <div class="invalid-feedback">Veuillez saisir une adresse email valide.</div>
                </div>
                <div class="col-md-6 mb-3">
                  <label for="etudiant_telephone" class="form-label">Téléphone</label>
                  <input type="tel" class="form-control" id="etudiant_telephone" name="telephone">
                </div>
              </div>
              <div class="row">
                <div class="col-md-6 mb-3">
                  <label for="etudiant_formation" class="form-label">Formation</label>
                  <input type="text" class="form-control" id="etudiant_formation" name="formation">
                </div>
                <div class="col-md-6 mb-3">
                  <label for="etudiant_niveau" class="form-label">Niveau</label>
                  <select class="form-select" id="etudiant_niveau" name="niveau">
                    <option value="">Sélectionner un niveau</option>
                    <option value="Bac">Bac</option>
                    <option value="Bac+1">Bac+1</option>
                    <option value="Bac+2">Bac+2</option>
                    <option value="Bac+3">Bac+3</option>
                    <option value="Bac+4">Bac+4</option>
                    <option value="Bac+5">Bac+5</option>
                    <option value="Doctorat">Doctorat</option>
                  </select>
                </div>
              </div>
              <div class="mb-3">
                <label for="etudiant_date_naissance" class="form-label">Date de naissance</label>
                <input type="date" class="form-control" id="etudiant_date_naissance" name="date_naissance">
              </div>
              <div class="row">
                <div class="col-md-6 mb-3">
                  <label for="etudiant_cv" class="form-label">CV (PDF)</label>
                  <input type="file" class="form-control" id="etudiant_cv" name="cv" accept=".pdf">
                </div>
                <div class="col-md-6 mb-3">
                  <label for="etudiant_photo" class="form-label">Photo</label>
                  <input type="file" class="form-control" id="etudiant_photo" name="photo" accept="image/*">
                </div>
              </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
            <button type="submit" class="btn btn-primary submit-btn" id="submitEtudiant">Enregistrer</button>
          </div>
      </form>
    </div>
  </div>
</div>

<!-- Enterprise Modal -->
<div class="modal fade" id="entrepriseModal" tabindex="-1" aria-labelledby="entrepriseModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="entrepriseModalLabel">Ajouter une entreprise</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="entrepriseForm" action="{{ route('entreprises.store') }}" method="POST" class="needs-validation" novalidate enctype="multipart/form-data">
        @csrf
        <div class="modal-body">
             <div class="mb-3">
               <label for="entreprise_nom" class="form-label">Nom de l'entreprise*</label>
               <input type="text" class="form-control" id="entreprise_nom" name="nom" required>
               <div class="invalid-feedback">Veuillez saisir un nom d'entreprise.</div>
             </div>
             <div class="row">
               <div class="col-md-6 mb-3">
                 <label for="entreprise_secteur" class="form-label">Secteur d'activité</label>
                 <input type="text" class="form-control" id="entreprise_secteur" name="secteur">
               </div>
               <div class="col-md-6 mb-3">
                 <label for="entreprise_contact" class="form-label">Contact principal</label>
                 <input type="text" class="form-control" id="entreprise_contact" name="contact_principal">
               </div>
             </div>
             <div class="mb-3">
               <label for="entreprise_description" class="form-label">Description</label>
               <textarea class="form-control" id="entreprise_description" name="description" rows="3"></textarea>
             </div>
             <div class="mb-3">
               <label for="entreprise_adresse" class="form-label">Adresse</label>
               <textarea class="form-control" id="entreprise_adresse" name="adresse" rows="2"></textarea>
             </div>
             <div class="row">
               <div class="col-md-6 mb-3">
                 <label for="entreprise_email" class="form-label">Email*</label>
                 <input type="email" class="form-control" id="entreprise_email" name="email" required>
                 <div class="invalid-feedback">Veuillez saisir une adresse email valide.</div>
               </div>
               <div class="col-md-6 mb-3">
                 <label for="entreprise_telephone" class="form-label">Téléphone</label>
                 <input type="tel" class="form-control" id="entreprise_telephone" name="telephone">
               </div>
             </div>
             <div class="row">
               <div class="col-md-6 mb-3">
                 <label for="entreprise_website" class="form-label">Site web</label>
                 <input type="url" class="form-control" id="entreprise_website" name="site_web" placeholder="https://example.com">
               </div>
               <div class="col-md-6 mb-3">
                 <label for="entreprise_logo" class="form-label">Logo</label>
                 <input type="file" class="form-control" id="entreprise_logo" name="logo" accept="image/*">
               </div>
             </div>
         </div>
         <div class="modal-footer">
           <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
           <button type="submit" class="btn btn-primary submit-btn" id="submitEntreprise">Enregistrer</button>
         </div>
       </form>
    </div>
  </div>
</div>

 <!-- Recruitment Modal -->
<div class="modal fade" id="recrutementModal" tabindex="-1" aria-labelledby="recrutementModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="recrutementModalLabel">Ajouter une offre de recrutement</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="recrutementForm" action="{{ route('recrutements.store') }}" method="POST" class="needs-validation" novalidate>
        @csrf
        <div class="modal-body">
            <div class="mb-3">
                <label for="recrutement_titre" class="form-label">Titre de l'offre*</label>
                <input type="text" class="form-control" id="recrutement_titre" name="titre" required>
                <div class="invalid-feedback">Veuillez saisir un titre.</div>
            </div>
            <div class="mb-3">
                <label for="recrutement_entreprise_id" class="form-label">Entreprise*</label>
                <select class="form-select" id="recrutement_entreprise_id" name="entreprise_id" required>
                  <option value="">Sélectionner une entreprise</option>
                  <!-- TODO: Populate with entreprises from backend -->
                  {{-- Example:
                  @foreach($entreprises as $entreprise)
                    <option value="{{ $entreprise->id }}">{{ $entreprise->nom }}</option>
                  @endforeach
                  --}}
                </select>
                <div class="invalid-feedback">Veuillez sélectionner une entreprise.</div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                  <label for="recrutement_type_contrat" class="form-label">Type de contrat*</label>
                  <select class="form-select" id="recrutement_type_contrat" name="type_contrat" required>
                    <option value="">Sélectionner un type</option>
                    <option value="CDI">CDI</option>
                    <option value="CDD">CDD</option>
                    <option value="Stage">Stage</option>
                    <option value="Alternance">Alternance</option>
                    <option value="Freelance">Freelance</option>
                  </select>
                  <div class="invalid-feedback">Veuillez sélectionner un type de contrat.</div>
                </div>
                <div class="col-md-6 mb-3">
                  <label for="recrutement_lieu" class="form-label">Lieu</label>
                  <input type="text" class="form-control" id="recrutement_lieu" name="lieu">
                </div>
            </div>
            <div class="mb-3">
                <label for="recrutement_description" class="form-label">Description*</label>
                <textarea class="form-control" id="recrutement_description" name="description" rows="4" required></textarea>
                <div class="invalid-feedback">Veuillez saisir une description.</div>
            </div>
            <div class="mb-3">
                <label for="recrutement_competences" class="form-label">Compétences requises</label>
                <textarea class="form-control" id="recrutement_competences" name="competences_requises" rows="3" placeholder="Compétence 1, Compétence 2..."></textarea>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                  <label for="recrutement_date_debut" class="form-label">Date de début</label>
                  <input type="date" class="form-control" id="recrutement_date_debut" name="date_debut">
                </div>
                <div class="col-md-6 mb-3">
                  <label for="recrutement_salaire" class="form-label">Salaire</label>
                  <input type="text" class="form-control" id="recrutement_salaire" name="salaire" placeholder="Ex: 1500€/mois, à négocier...">
                </div>
            </div>
            <div class="mb-3">
                <label for="recrutement_date_expiration" class="form-label">Date d'expiration de l'offre</label>
                <input type="date" class="form-control" id="recrutement_date_expiration" name="date_expiration">
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
          <button type="submit" class="btn btn-primary submit-btn" id="submitRecrutement">Enregistrer</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- News Modal -->
<div class="modal fade" id="actualiteModal" tabindex="-1" aria-labelledby="actualiteModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="actualiteModalLabel">Ajouter une actualité</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="actualiteForm" action="{{ route('actualites.store') }}" method="POST" class="needs-validation" novalidate enctype="multipart/form-data">
        @csrf
         <div class="modal-body">
            <div class="mb-3">
              <label for="actualite_titre" class="form-label">Titre*</label>
              <input type="text" class="form-control" id="actualite_titre" name="titre" required>
              <div class="invalid-feedback">Veuillez saisir un titre.</div>
            </div>
            <div class="mb-3">
              <label for="actualite_contenu" class="form-label">Contenu*</label>
              <textarea class="form-control" id="actualite_contenu" name="contenu" rows="5" required></textarea>
              <div class="invalid-feedback">Veuillez saisir un contenu.</div>
            </div>
            <div class="row">
              <div class="col-md-6 mb-3">
                <label for="actualite_categorie" class="form-label">Catégorie</label>
                <select class="form-select" id="actualite_categorie" name="categorie">
                  <option value="">Sélectionner une catégorie</option>
                  <option value="Événement">Événement</option>
                  <option value="Recrutement">Recrutement</option>
                  <option value="Formation">Formation</option>
                  <option value="Campus">Campus</option>
                  <option value="Partenariat">Partenariat</option>
                   <option value="Autre">Autre</option>
                </select>
              </div>
              <div class="col-md-6 mb-3">
                <label for="actualite_date_publication" class="form-label">Date de publication*</label>
                <input type="datetime-local" class="form-control" id="actualite_date_publication" name="date_publication" required>
                <div class="invalid-feedback">Veuillez saisir une date de publication.</div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6 mb-3">
                <label for="actualite_auteur" class="form-label">Auteur</label>
                <input type="text" class="form-control" id="actualite_auteur" name="auteur">
              </div>
              <div class="col-md-6 mb-3">
                <label for="actualite_image" class="form-label">Image</label>
                <input type="file" class="form-control" id="actualite_image" name="image" accept="image/*">
              </div>
            </div>
         </div>
         <div class="modal-footer">
           <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
           <button type="submit" class="btn btn-primary submit-btn" id="submitActualite">Enregistrer</button>
         </div>
      </form>
    </div>
  </div>
</div>

<!-- Catalog Modal -->
<div class="modal fade" id="catalogueModal" tabindex="-1" aria-labelledby="catalogueModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="catalogueModalLabel">Ajouter une formation au catalogue</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
       <form id="catalogueForm" action="{{ route('catalogue.store') }}" method="POST" class="needs-validation" novalidate enctype="multipart/form-data">
        @csrf
        <div class="modal-body">
            <div class="mb-3">
              <label for="catalogue_titre" class="form-label">Titre de la formation*</label>
              <input type="text" class="form-control" id="catalogue_titre" name="titre" required>
              <div class="invalid-feedback">Veuillez saisir un titre.</div>
            </div>
            <div class="mb-3">
              <label for="catalogue_description" class="form-label">Description*</label>
              <textarea class="form-control" id="catalogue_description" name="description" rows="3" required></textarea>
              <div class="invalid-feedback">Veuillez saisir une description.</div>
            </div>
            <div class="row">
              <div class="col-md-4 mb-3">
                <label for="catalogue_duree" class="form-label">Durée</label>
                <input type="text" class="form-control" id="catalogue_duree" name="duree" placeholder="Ex: 3 jours, 35 heures...">
              </div>
              <div class="col-md-4 mb-3">
                <label for="catalogue_type" class="form-label">Type</label>
                <select class="form-select" id="catalogue_type" name="type">
                  <option value="">Sélectionner un type</option>
                  <option value="Présentiel">Présentiel</option>
                  <option value="Distanciel">Distanciel</option>
                  <option value="Hybride">Hybride</option>
                </select>
              </div>
              <div class="col-md-4 mb-3">
                <label for="catalogue_niveau" class="form-label">Niveau</label>
                <select class="form-select" id="catalogue_niveau" name="niveau">
                  <option value="">Sélectionner un niveau</option>
                  <option value="Débutant">Débutant</option>
                  <option value="Intermédiaire">Intermédiaire</option>
                  <option value="Avancé">Avancé</option>
                  <option value="Expert">Expert</option>
                </select>
              </div>
            </div>
            <div class="mb-3">
              <label for="catalogue_prerequis" class="form-label">Pré-requis</label>
              <textarea class="form-control" id="catalogue_prerequis" name="pre_requis" rows="2"></textarea>
            </div>
            <div class="mb-3">
              <label for="catalogue_contenu" class="form-label">Contenu de la formation</label>
              <textarea class="form-control" id="catalogue_contenu" name="contenu" rows="4"></textarea>
            </div>
            <div class="mb-3">
              <label for="catalogue_image" class="form-label">Image</label>
              <input type="file" class="form-control" id="catalogue_image" name="image" accept="image/*">
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
          <button type="submit" class="btn btn-primary submit-btn" id="submitCatalogue">Enregistrer</button>
        </div>
      </form>
    </div>
  </div>
</div>


<!-- Toast Container -->
<div class="toast-container position-fixed bottom-0 end-0 p-3">
  <div id="successToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="toast-header bg-success text-white">
      <i class="fas fa-check-circle me-2"></i>
      <strong class="me-auto">Succès</strong>
      <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
    <div class="toast-body">
      Opération effectuée avec succès !
    </div>
  </div>
   <div id="errorToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header bg-danger text-white">
            <i class="fas fa-exclamation-circle me-2"></i>
            <strong class="me-auto">Erreur</strong>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">
            Une erreur s'est produite. <span id="errorToastMessage"></span>
        </div>
    </div>
</div>

<!-- Bootstrap Bundle JS (includes Popper) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // --- Sidebar Toggle ---
    const sidebar = document.getElementById('sidebar');
    const mainContent = document.getElementById('main-content');
    const toggleButton = document.getElementById('toggle-sidebar-btn');

    if (toggleButton && sidebar && mainContent) {
        toggleButton.addEventListener('click', () => {
            sidebar.classList.toggle('collapsed');
            mainContent.classList.toggle('collapsed');
        });
    }

    // --- Tab System ---
    const tabs = document.querySelectorAll('.tab');
    const tabContents = document.querySelectorAll('.tab-content');

    tabs.forEach(tab => {
        tab.addEventListener('click', () => {
            // Deactivate all tabs and content
            tabs.forEach(t => {
                 t.classList.remove('active');
                 t.setAttribute('aria-selected', 'false');
            });
            tabContents.forEach(content => {
                content.classList.remove('active');
            });

            // Activate clicked tab and corresponding content
            tab.classList.add('active');
            tab.setAttribute('aria-selected', 'true');
            const targetContentId = tab.getAttribute('aria-controls'); // Use aria-controls
            const targetContent = document.getElementById(targetContentId);
            if(targetContent) {
                targetContent.classList.add('active');
            }
             // Optional: Store active tab in localStorage
             // localStorage.setItem('activeDashboardTab', tab.getAttribute('data-tab'));
        });
    });

     // Optional: Restore active tab on page load
     /*
     const activeTabId = localStorage.getItem('activeDashboardTab');
     if (activeTabId) {
         const activeTab = document.querySelector(`.tab[data-tab="${activeTabId}"]`);
         if (activeTab) {
             activeTab.click(); // Simulate click to activate
         }
     }
     */


    // --- Modal Form Handling ---
    const successToastElement = document.getElementById('successToast');
    const errorToastElement = document.getElementById('errorToast');
    const errorToastMessage = document.getElementById('errorToastMessage');
    const successToast = successToastElement ? new bootstrap.Toast(successToastElement) : null;
    const errorToast = errorToastElement ? new bootstrap.Toast(errorToastElement) : null;

    // Select all forms within modals that should be submitted via AJAX
    const ajaxForms = document.querySelectorAll('.modal form.needs-validation');

    ajaxForms.forEach(form => {
        const modalElement = form.closest('.modal');
        const modalInstance = modalElement ? bootstrap.Modal.getInstance(modalElement) || new bootstrap.Modal(modalElement) : null;
        const submitBtn = form.querySelector('.submit-btn'); // Ensure submit buttons have this class

        if (form && submitBtn && modalInstance) {
             // Special handling for event dates
             if (form.id === 'eventForm') {
                initEventDateValidation(form);
             }

            form.addEventListener('submit', function(event) {
                event.preventDefault(); // Prevent default browser submission
                submitAjaxForm(form, submitBtn, modalInstance);
            });
        }
    });

    // --- Event Date Validation ---
    function initEventDateValidation(form) {
        const startDateInput = form.querySelector('#event_start_date');
        const endDateInput = form.querySelector('#event_end_date');

        if (!startDateInput || !endDateInput) return;

        // Set minimum date for start date (optional: allow past dates?)
        // const today = new Date().toISOString().slice(0, 16);
        // startDateInput.min = today;

        const validateEndDate = () => {
            if (startDateInput.value && endDateInput.value) {
                if (new Date(endDateInput.value) <= new Date(startDateInput.value)) {
                    endDateInput.setCustomValidity('La date de fin doit être strictement postérieure à la date de début.');
                    endDateInput.classList.add('is-invalid'); // Force show invalid state
                } else {
                    endDateInput.setCustomValidity('');
                    endDateInput.classList.remove('is-invalid');
                }
            } else {
                 endDateInput.setCustomValidity(''); // Clear validation if dates are missing
                 endDateInput.classList.remove('is-invalid');
            }
             // Trigger validation feedback display
            form.checkValidity(); // Check overall form validity
            if (!endDateInput.checkValidity()) {
                endDateInput.reportValidity(); // Show browser default message if invalid
            }
        };

        startDateInput.addEventListener('change', () => {
             if (startDateInput.value) {
                 endDateInput.min = startDateInput.value; // Set min for end date
             }
             validateEndDate();
        });
        endDateInput.addEventListener('change', validateEndDate);
    }


    // --- Generic AJAX Form Submission Function ---
    function submitAjaxForm(form, submitBtn, modalInstance) {
        // Client-side validation check
        if (!form.checkValidity()) {
            form.classList.add('was-validated'); // Show validation feedback
            // Find first invalid field and focus (optional)
            const firstInvalid = form.querySelector(':invalid');
            if(firstInvalid) firstInvalid.focus();
            return;
        }

        const formData = new FormData(form);
        const url = form.action; // Get URL from form's action attribute
        const method = form.method.toUpperCase();
        const originalBtnContent = submitBtn.innerHTML;
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

        // Disable button and show loading state
        submitBtn.disabled = true;
        submitBtn.innerHTML = `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Enregistrement...`;

        fetch(url, {
            method: method,
            body: formData,
            headers: {
                'X-CSRF-TOKEN': csrfToken, // Crucial for Laravel POST/PUT/PATCH/DELETE
                'Accept': 'application/json', // Expect JSON response
                'X-Requested-With': 'XMLHttpRequest' // Identify as AJAX
            }
        })
        .then(response => {
            if (!response.ok) {
                 // Try to parse error details from Laravel validation response
                 return response.json().then(err => { throw err; });
            }
            return response.json(); // Assuming server sends JSON on success
        })
        .then(data => {
            // Success
            form.reset(); // Clear the form
            form.classList.remove('was-validated'); // Hide validation feedback
            modalInstance.hide(); // Close the modal

            if (successToast) {
                successToast.show(); // Show success notification
            }

             // Optional: Reload part of the page or update table data
             // e.g., location.reload(); // Simple full page reload
             // Or more sophisticated update based on `data` response
             console.log("Success:", data); // Log success data
        })
        .catch(error => {
            // Error handling
            console.error("Erreur:", error);
            let message = "Une erreur inattendue s'est produite.";
             // Check if it's a Laravel validation error object
             if (error && error.errors) {
                 // Extract first validation error message
                 const firstErrorKey = Object.keys(error.errors)[0];
                 message = error.errors[firstErrorKey][0] || 'Veuillez vérifier les champs du formulaire.';
             } else if (error && error.message) {
                 message = error.message; // Use message from generic Error
             }

            if (errorToast && errorToastMessage) {
                errorToastMessage.textContent = message;
                errorToast.show();
            } else {
                alert("Erreur: " + message); // Fallback alert
            }
        })
        .finally(() => {
            // Restore button state regardless of success/failure
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalBtnContent;
        });
    }

}); // End DOMContentLoaded
</script>