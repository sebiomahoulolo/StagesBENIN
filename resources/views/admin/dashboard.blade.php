<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
       
  
    <title>StagesBENIN</title>
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
            overflow-x: hidden;
        }
        
        /* Scrollbar styling */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }
        
        ::-webkit-scrollbar-thumb {
            background: var(--gray);
            border-radius: 4px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: var(--primary);
        }
        
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
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }
        
        .sidebar-header {
            display: flex;
            align-items: center;
            padding: 15px 20px;
            height: var(--header-height);
            background-color: rgba(0, 0, 0, 0.2);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .sidebar-header h2 {
            font-size: 1.2rem;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
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
        }
        
        .sidebar-menu {
            padding: 15px 0;
            overflow-y: auto;
            height: calc(100vh - var(--header-height));
        }
        
        .menu-category {
            font-size: 0.75rem;
            text-transform: uppercase;
            padding: 12px 20px 8px;
            color: var(--gray);
            letter-spacing: 0.5px;
        }
        
        .menu-item {
            padding: 10px 20px;
            display: flex;
            align-items: center;
            cursor: pointer;
            transition: var(--transition);
            margin: 2px 0;
            position: relative;
        }
        
        .menu-item.active, .menu-item:hover {
            background-color: rgba(255, 255, 255, 0.1);
            color: var(--primary);
        }
        
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
        }
        
        .menu-badge {
            background-color: var(--danger);
            color: white;
            border-radius: 10px;
            padding: 2px 8px;
            font-size: 0.7rem;
            margin-left: auto;
        }
        
        /* Main Content */
        .main-content {
            flex: 1;
            margin-left: var(--sidebar-width);
            transition: var(--transition);
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
        }
        
        .header-icon {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-left: 10px;
            cursor: pointer;
            position: relative;
            transition: var(--transition);
            color: var(--dark);
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
            margin-left: 20px;
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
        
        .profile-info {
            display: flex;
            flex-direction: column;
        }
        
        .profile-name {
            font-size: 0.9rem;
            font-weight: 500;
        }
        
        .profile-role {
            font-size: 0.7rem;
            color: var(--gray);
        }
        
        /* Dashboard content */
        .content {
            padding: 20px;
        }
        
        .dashboard-title {
            margin-bottom: 20px;
            font-size: 1.5rem;
            color: var(--dark);
        }
        
        .stats-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 20px;
        }
        
        .stat-card {
            background-color: white;
            border-radius: var(--border-radius);
            padding: 20px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
            display: flex;
            flex-direction: column;
            transition: var(--transition);
        }
        
        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        
        .stat-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }
        
        .stat-title {
            color: var(--gray);
            font-size: 0.9rem;
        }
        
        .stat-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
        }
        
        .bg-primary {
            background-color: var(--primary);
        }
        
        .bg-success {
            background-color: var(--success);
        }
        
        .bg-warning {
            background-color: var(--warning);
        }
        
        .bg-danger {
            background-color: var(--danger);
        }
        
        .stat-value {
            font-size: 1.8rem;
            font-weight: bold;
            color: var(--dark);
        }
        
        .stat-progress {
            font-size: 0.8rem;
            display: flex;
            align-items: center;
        }
        
        .up {
            color: var(--success);
        }
        
        .down {
            color: var(--danger);
        }
        
        /* Tabs */
        .tabs-container {
            background-color: white;
            border-radius: var(--border-radius);
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
            margin-bottom: 20px;
            overflow: hidden;
        }
        
        .tabs-header {
            display: flex;
            border-bottom: 1px solid #e5e7eb;
            overflow-x: auto;
            scrollbar-width: none;
            -ms-overflow-style: none;
        }
        
        .tabs-header::-webkit-scrollbar {
            display: none;
        }
        
        .tab {
            padding: 15px 20px;
            cursor: pointer;
            white-space: nowrap;
            color: var(--gray);
            position: relative;
            transition: var(--transition);
            font-weight: 500;
        }
        
        .tab.active {
            color: var(--primary);
        }
        
        .tab.active::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 2px;
            background-color: var(--primary);
        }
        
        .tab-content {
            padding: 20px;
            display: none;
        }
        
        .tab-content.active {
            display: block;
        }
        
        /* Table */
        .action-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        
        .action-buttons {
            display: flex;
            gap: 10px;
        }
        
        .btn {
            padding: 8px 15px;
            border-radius: var(--border-radius);
            border: none;
            cursor: pointer;
            font-weight: 500;
            display: flex;
            align-items: center;
            transition: var(--transition);
            gap: 5px;
        }
        
        .btn-primary {
            background-color: var(--primary);
            color: white;
        }
        
        .btn-primary:hover {
            background-color: var(--primary-dark);
        }
        
        .btn-outline {
            background-color: transparent;
            border: 1px solid #e5e7eb;
            color: var(--dark);
        }
        
        .btn-outline:hover {
            background-color: #f3f4f6;
        }
        
        .filter-container {
            display: flex;
            gap: 10px;
        }
        
        .select-container {
            position: relative;
        }
        
        .select-container select {
            padding: 8px 15px;
            border-radius: var(--border-radius);
            border: 1px solid #e5e7eb;
            background-color: white;
            min-width: 120px;
            appearance: none;
            padding-right: 30px;
        }
        
        .select-icon {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            pointer-events: none;
            color: var(--gray);
        }
        
        .table-container {
            overflow-x: auto;
        }
        
        .data-table {
            width: 100%;
            border-collapse: collapse;
            min-width: 800px;
        }
        
        .data-table th {
            background-color: #f9fafb;
            padding: 12px 15px;
            text-align: left;
            font-weight: 500;
            color: var(--dark);
            border-bottom: 1px solid #e5e7eb;
        }
        
        .data-table td {
            padding: 12px 15px;
            border-bottom: 1px solid #e5e7eb;
            color: var(--gray);
        }
        
        .data-table tr:hover {
            background-color: #f9fafb;
        }
        
        .status {
            display: inline-flex;
            align-items: center;
            padding: 3px 8px;
            border-radius: 15px;
            font-size: 0.75rem;
            font-weight: 500;
        }
        
        .status-active {
            background-color: rgba(16, 185, 129, 0.1);
            color: var(--success);
        }
        
        .status-pending {
            background-color: rgba(245, 158, 11, 0.1);
            color: var(--warning);
        }
        
        .status-blocked {
            background-color: rgba(239, 68, 68, 0.1);
            color: var(--danger);
        }
        
        .table-actions {
            display: flex;
            gap: 5px;
        }
        
        .action-icon {
            width: 28px;
            height: 28px;
            border-radius: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: var(--transition);
            background-color: #f9fafb;
        }
        
        .action-icon:hover {
            background-color: #e5e7eb;
        }
        
        .edit-icon {
            color: var(--primary);
        }
        
        .delete-icon {
            color: var(--danger);
        }
        
        .view-icon {
            color: var(--dark);
        }
        
        /* Pagination */
        .pagination {
            display: flex;
            justify-content: flex-end;
            margin-top: 20px;
            align-items: center;
        }
        
        .page-info {
            margin-right: 15px;
            color: var(--gray);
            font-size: 0.9rem;
        }
        
        .page-buttons {
            display: flex;
            gap: 5px;
        }
        
        .page-btn {
            width: 32px;
            height: 32px;
            border-radius: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: var(--transition);
            background-color: #f9fafb;
            color: var(--dark);
            border: 1px solid #e5e7eb;
            font-weight: 500;
        }
        
        .page-btn.active {
            background-color: var(--primary);
            color: white;
            border-color: var(--primary);
        }
        
        .page-btn:hover:not(.active) {
            background-color: #e5e7eb;
        }
        
        /* Form modal */
        .modal {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1000;
            padding: 20px;
            opacity: 0;
            visibility: hidden;
            transition: var(--transition);
        }
        
        .modal.show {
            opacity: 1;
            visibility: visible;
        }
        
        .modal-content {
            background-color: white;
            border-radius: var(--border-radius);
            max-width: 600px;
            width: 100%;
            max-height: 90vh;
            overflow-y: auto;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            transform: translateY(-20px);
            transition: var(--transition);
        }
        
        .modal.show .modal-content {
            transform: translateY(0);
        }
        
        .modal-header {
            padding: 15px 20px;
            border-bottom: 1px solid #e5e7eb;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        
        .modal-title {
            font-size: 1.2rem;
            font-weight: 500;
        }
        
        .close-modal {
            background: none;
            border: none;
            font-size: 1.5rem;
            cursor: pointer;
            color: var(--gray);
            transition: var(--transition);
        }
        
        .close-modal:hover {
            color: var(--danger);
        }
        
        .modal-body {
            padding: 20px;
        }
        
        .form-group {
            margin-bottom: 15px;
        }
        
        .form-label {
            display: block;
            margin-bottom: 5px;
            font-weight: 500;
            color: var(--dark);
        }
        
        .form-control {
            width: 100%;
            padding: 10px 15px;
            border-radius: var(--border-radius);
            border: 1px solid #e5e7eb;
            transition: var(--transition);
        }
        
        .form-control:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 2px rgba(37, 99, 235, 0.2);
        }
        
        .form-control-textarea {
            min-height: 100px;
            resize: vertical;
        }
        
        .modal-footer {
            padding: 15px 20px;
            border-top: 1px solid #e5e7eb;
            display: flex;
            justify-content: flex-end;
            gap: 10px;
        }
        
        /* Responsive */
        @media (max-width: 992px) {
            .sidebar {
                width: 70px;
            }
            
            .sidebar.expanded {
                width: var(--sidebar-width);
            }
            
            .main-content {
                margin-left: 70px;
            }
            
            .main-content.expanded {
                margin-left: var(--sidebar-width);
            }
            
            .sidebar-header h2 {
                display: none;
            }
            
            .sidebar.expanded .sidebar-header h2 {
                display: block;
            }
            
            .menu-text, .menu-category {
                display: none;
            }
            
            .sidebar.expanded .menu-text, 
            .sidebar.expanded .menu-category {
                display: block;
            }
            
            .menu-item {
                justify-content: center;
            }
            
            .sidebar.expanded .menu-item {
                justify-content: flex-start;
            }
            
            .menu-badge {
                position: absolute;
                top: 5px;
                right: 5px;
            }
            
            .sidebar.expanded .menu-badge {
                position: static;
            }
        }
        
        @media (max-width: 768px) {
            .stats-container {
                grid-template-columns: 1fr;
            }
            
            .profile-info {
                display: none;
            }
            
            .search-bar {
                max-width: 200px;
            }
        }
        
        @media (max-width: 576px) {
            .header-actions {
                gap: 5px;
            }
            
            .search-bar {
                max-width: 150px;
            }
            
            .action-bar {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }
            
            .filter-container {
                width: 100%;
                justify-content: space-between;
            }
            
            .select-container {
                flex: 1;
            }
            
            .select-container select {
                width: 100%;
            }
        }


        .add-event-btn {
    border-radius: 50px;
    padding: 8px 20px;
    font-weight: 500;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
}

.add-event-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
}

.modal-content {
    border-radius: 10px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
}

.modal-header {
    border-top-left-radius: 10px;
    border-top-right-radius: 10px;
}

.form-label {
    font-weight: 500;
    margin-bottom: 0.25rem;
}

.input-group-text {
    background-color: #f8f9fa;
}

textarea {
    resize: vertical;
    min-height: 100px;
}

/* Animation pour le toast */
.toast {
    transition: transform 0.3s ease;
}

.toast.showing {
    transform: translateY(20px);
}

@media (max-width: 576px) {
    .modal-dialog {
        margin: 0.5rem;
    }
}
  

        .tabs-container {
            margin: 20px auto;
            max-width: 1200px;
        }
        
        .tabs-header {
            display: flex;
            border-bottom: 1px solid #dee2e6;
            margin-bottom: 20px;
        }
        
        .tab {
            padding: 12px 20px;
            cursor: pointer;
            font-weight: 500;
            transition: all 0.3s ease;
            border-bottom: 3px solid transparent;
        }
        
        .tab:hover {
            background-color: #f8f9fa;
        }
        
        .tab.active {
            border-bottom: 3px solid #0d6efd;
            color: #0d6efd;
        }
        
        .tab-content {
            display: none;
            padding: 20px;
            background-color: #fff;
            border-radius: 0 0 5px 5px;
        }
        
        .tab-content.active {
            display: block;
        }
        
        .action-bar {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }
        
        .action-buttons {
            display: flex;
            gap: 10px;
        }

.tabs-header {
    display: flex;
    border-bottom: 1px solid #dee2e6;
    margin-bottom: 1rem;
}

.tab {
    padding: 0.75rem 1rem;
    cursor: pointer;
    margin-bottom: -1px;
    border: 1px solid transparent;
    border-top-left-radius: 0.25rem;
    border-top-right-radius: 0.25rem;
}

.tab:hover {
    border-color: #e9ecef #e9ecef #dee2e6;
    background-color: #f8f9fa;
}

.tab.active {
    color: #495057;
    background-color: #fff;
    border-color: #dee2e6 #dee2e6 #fff;
}

.tab-content {
    display: none;
}

.tab-content.active {
    display: block;
}

.action-bar {
    margin-bottom: 1rem;
}

.tabs-header {
  
    flex-wrap: wrap; /* Permet aux onglets de passer à la ligne si nécessaire */
  
}

.tab {
    
    background-color: #f0f0f0;

    cursor: pointer;
    flex: 1 1 calc(100% / 4); /* Ajuste la largeur des onglets */
}

.tab.active {
    background-color: #007bff;
    color: white;
}

@media (max-width: 768px) {
    .tab {
        flex: 1 1 100%; /* Les onglets prennent toute la largeur sur les petits écrans */
    }
}

</style>
</head>
<body>
    <div class="dashboard">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="sidebar-header">
                <div class="sidebar-logo">S</div>
                <h2>StagesBENIN</h2>
            </div>
            <div class="sidebar-menu">
                <div class="menu-category">Principal</div>
                <div class="menu-item active">
                    <div class="menu-icon">
                        <i class="fas fa-tachometer-alt">📊</i>
                    </div>
                    <span class="menu-text">Tableau de bord</span>
                </div>
                <div class="menu-item">
                    <div class="menu-icon">
                        <i class="fas fa-newspaper">📰</i>
                    </div>
                    <span class="menu-text">Actualités</span>
                    <span class="menu-badge">5</span>
                </div>
                <div class="menu-item">
                    <div class="menu-icon">
                        <i class="fas fa-briefcase">💼</i>
                    </div>
                    <span class="menu-text">Recrutements</span>
                </div>
                <div class="menu-item">
                <a href="{{ route('pages.evenements') }}">
                    <div class="menu-icon">
                        <i class="fas fa-calendar-alt">📅</i>
                    </div>
                    <span class="menu-text">Événements</span></a>
                </div>
                
                <div class="menu-category">Gestion</div>
                <div class="menu-item">
                    <div class="menu-icon">
                        <i class="fas fa-users">👥</i>
                    </div>
                    <span class="menu-text">Étudiants</span>
                    <span class="menu-badge">12</span>
                </div>
                <div class="menu-item">
                    <div class="menu-icon">
                        <i class="fas fa-building">🏢</i>
                    </div>
                    <span class="menu-text">Entreprises</span>
                </div>
                <div class="menu-item">
                    <div class="menu-icon">
                        <i class="fas fa-book">📚</i>
                    </div>
                    <span class="menu-text">Catalogue</span>
                </div>
                <div class="menu-item">
                    <div class="menu-icon">
                        <i class="fas fa-comments">💬</i>
                    </div>
                    <span class="menu-text">Messages</span>
                    <span class="menu-badge">7</span>
                </div>
                
                <div class="menu-category">Configuration</div>
                <div class="menu-item">
                    <div class="menu-icon">
                        <i class="fas fa-cog">⚙️</i>
                    </div>
                    <span class="menu-text">Paramètres</span>
                </div>
                <div class="menu-item">
                    <div class="menu-icon">
                        <i class="fas fa-user-shield">🛡️</i>
                    </div>
                    <span class="menu-text">Administrateurs</span>
                </div>
                <div class="menu-item">
                    <div class="menu-icon">
                        <i class="fas fa-file-alt">📄</i>
                    </div>
                    <span class="menu-text">Logs</span>
                </div>
            </div>
        </div>
        
        <!-- Main Content -->
        <div class="main-content">
            <div class="header">
                <button class="toggle-sidebar">
                    <i class="fas fa-bars">☰</i>
                </button>
                
                <div class="search-bar">
                    <i class="fas fa-search search-icon">🔍</i>
                    <input type="text" placeholder="Rechercher...">
                </div>
                
                <div class="header-actions">
                    <div class="header-icon">
                        <i class="fas fa-bell">🔔</i>
                        <span class="notification-badge"></span>
                    </div>
                    <div class="header-icon">
                        <i class="fas fa-envelope">✉️</i>
                        <span class="notification-badge"></span>
                    </div>
                    <div class="user-profile">
                        <div class="profile-image">A</div>
                        <div class="profile-info">
                            <span class="profile-name">Admin</span>
                            <span class="profile-role">Super Admin</span>
                        </div>
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
                            <div class="stat-icon bg-primary">
                                <i class="fas fa-user-graduate">👨‍🎓</i>
                            </div>
                        </div>
                        <div class="stat-value">1,247</div>
                        <div class="stat-progress up">
                            <i class="fas fa-arrow-up">↑</i> 12% depuis le mois dernier
                        </div>
                    </div>
                    
                    <div class="stat-card">
                        <div class="stat-header">
                            <div class="stat-title">Entreprises partenaires</div>
                            <div class="stat-icon bg-success">
                                <i class="fas fa-building">🏢</i>
                            </div>
                        </div>
                        <div class="stat-value">86</div>
                        <div class="stat-progress up">
                            <i class="fas fa-arrow-up">↑</i> 5% depuis le mois dernier
                        </div>
                    </div>
                    
                    <div class="stat-card">
                        <div class="stat-header">
                            <div class="stat-title">Offres actives</div>
                            <div class="stat-icon bg-warning">
                                <i class="fas fa-briefcase">💼</i>
                            </div>
                        </div>
                        <div class="stat-value">124</div>
                        <div class="stat-progress down">
                            <i class="fas fa-arrow-down">↓</i> 3% depuis le mois dernier
                        </div>
                    </div>
                    
                    <div class="stat-card">
                        <div class="stat-header">
                            <div class="stat-title">Entretiens programmés</div>
                            <div class="stat-icon bg-danger">
                                <i class="fas fa-calendar-check">📆</i>
                            </div>
                        </div>
                        <div class="stat-value">37</div>
                        <div class="stat-progress up">
                            <i class="fas fa-arrow-up">↑</i> 8% depuis le mois dernier
                        </div>
                    </div>
                </div>


<div class="container">
    <div class="tabs-container">
        
       <div class="tabs-header">
    <div class="tab active" data-tab="etudiants">Étudiants</div>
    <div class="tab" data-tab="entreprises">Entreprises</div>
    <div class="tab" data-tab="recrutements">Recrutements</div>
    <div class="tab" data-tab="actualites">Actualités</div>
    <div class="tab" data-tab="evenements">Événements</div>
    <div class="tab" data-tab="catalogue">Catalogue</div>
</div>

        
        <!-- Tab: Étudiants -->
        <div class="tab-content active" id="etudiants">
            <div class="action-bar">
                <div class="action-buttons">
                    <button type="button" class="btn btn-primary add-btn" data-bs-toggle="modal" data-bs-target="#etudiantModal">
                        <i class="fas fa-plus-circle"></i> Ajouter
                    </button>
                    
                </div>
            </div>
            <div class="content-area">
                <h4>Contenu des étudiants</h4>
                <p>Liste des étudiants apparaîtra ici.</p>
            </div>
        </div>
        
        <!-- Tab: Entreprises -->
        <div class="tab-content " id="entreprises">
            <div class="action-bar">
                <div class="action-buttons">
                    <button type="button" class="btn btn-primary add-btn" data-bs-toggle="modal" data-bs-target="#entrepriseModal">
                        <i class="fas fa-plus-circle"></i> Ajouter
                    </button>
                    
                </div>
            </div>
            <div class="content-area">
                <h4>Contenu des entreprises</h4>
                <p>Liste des entreprises apparaîtra ici.</p>
            </div>
        </div>
        
        <!-- Tab: Recrutements -->
        <div class="tab-content " id="recrutements">
            <div class="action-bar">
                <div class="action-buttons">
                    <button type="button" class="btn btn-primary add-btn" data-bs-toggle="modal" data-bs-target="#recrutementModal">
                        <i class="fas fa-plus-circle"></i> Ajouter
                    </button>
                   
                </div>
            </div>
            <div class="content-area">
                <h4>Contenu des recrutements</h4>
                <p>Liste des recrutements apparaîtra ici.</p>
            </div>
        </div>
        
        <!-- Tab: Actualités -->
        <div class="tab-content " id="actualites">
            <div class="action-bar">
                <div class="action-buttons">
                    <button type="button" class="btn btn-primary add-btn" data-bs-toggle="modal" data-bs-target="#actualiteModal">
                        <i class="fas fa-plus-circle"></i> Ajouter
                    </button>
                    
                </div>
            </div>
            <div class="content-area">
                <h4>Contenu des actualités</h4>
                <p>Liste des actualités apparaîtra ici.</p>
            </div>
        </div>
        
        <!-- Tab: Événements (reusing the original eventModal) -->
        <div class="tab-content" id="evenements">
            <div class="action-bar">
                <div class="action-buttons">
                    <button type="button" class="btn btn-primary add-btn" data-bs-toggle="modal" data-bs-target="#eventModal">
                        <i class="fas fa-plus-circle"></i> Ajouter
                    </button>
                   
                </div>
            </div>
            <div class="content-area">
                <h4>Contenu des événements</h4>
               <!-- Liste des événements avec fonctionnalités de gestion -->
<div class="container mt-4">
  <h2>Gestion des événements</h2>
  
  <div class="d-flex justify-content-between align-items-center mb-3">
    <div>
      <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#eventModal">
        <i class="bi bi-plus-circle"></i> Ajouter un événement
      </button>
    </div>
    <div class="form-group">
      <input type="text" id="searchEvent" class="form-control" placeholder="Rechercher un événement...">
    </div>
  </div>

  <div class="table-responsive">
    <table class="table table-striped table-hover" id="eventsTable">
      <thead class="bg-light">
        <tr>
          <th>Titre</th>
          <th>Date début</th>
          <th>Date fin</th>
          <th>Lieu</th>
          <th>Type</th>
          <th>Statut</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <!-- Les événements seront chargés ici dynamiquement -->
      </tbody>
    </table>
  </div>
  
  <div class="text-center mt-3 d-none" id="eventsLoading">
    <div class="spinner-border text-primary" role="status">
      <span class="visually-hidden">Chargement...</span>
    </div>
  </div>
  
  <div class="alert alert-info d-none" id="noEventsMessage">
    Aucun événement disponible pour le moment.
  </div>
</div>

<!-- Modal de confirmation de suppression -->
<div class="modal fade" id="deleteEventModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-danger text-white">
        <h5 class="modal-title">Confirmer la suppression</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p>Êtes-vous sûr de vouloir supprimer cet événement ? Cette action est irréversible.</p>
        <p class="fw-bold" id="eventToDeleteName"></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
        <button type="button" class="btn btn-danger" id="confirmDeleteEvent">Supprimer</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal d'édition d'événement -->
<div class="modal fade" id="editEventModal" tabindex="-1" aria-labelledby="editEventModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editEventModalLabel">Modifier un événement</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="editEventForm" class="needs-validation" novalidate enctype="multipart/form-data">
          <input type="hidden" id="edit_event_id" name="id">
          
          <div class="mb-3">
            <label for="edit_title" class="form-label">Titre de l'événement*</label>
            <input type="text" class="form-control" id="edit_title" name="title" required>
            <div class="invalid-feedback">Veuillez saisir un titre.</div>
          </div>
          
          <div class="mb-3">
            <label for="edit_description" class="form-label">Description</label>
            <textarea class="form-control" id="edit_description" name="description" rows="3"></textarea>
          </div>
          
          <div class="row">
            <div class="col-md-6 mb-3">
              <label for="edit_start_date" class="form-label">Date et heure de début*</label>
              <input type="datetime-local" class="form-control" id="edit_start_date" name="start_date" required>
              <div class="invalid-feedback">Veuillez saisir une date de début valide.</div>
            </div>
            <div class="col-md-6 mb-3">
              <label for="edit_end_date" class="form-label">Date et heure de fin*</label>
              <input type="datetime-local" class="form-control" id="edit_end_date" name="end_date" required>
              <div class="invalid-feedback">Veuillez saisir une date de fin valide.</div>
            </div>
          </div>
          
          <div class="mb-3">
            <label for="edit_location" class="form-label">Lieu</label>
            <input type="text" class="form-control" id="edit_location" name="location">
          </div>
          
          <div class="row">
            <div class="col-md-6 mb-3">
              <label for="edit_type" class="form-label">Type d'événement</label>
              <select class="form-select" id="edit_type" name="type">
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
              <label for="edit_max_participants" class="form-label">Nombre max. de participants</label>
              <input type="number" class="form-control" id="edit_max_participants" name="max_participants" min="1">
            </div>
          </div>
          
          <div class="mb-3">
            <label for="edit_event_image" class="form-label">Image (affiche)</label>
            <input type="file" class="form-control" id="edit_event_image" name="image" accept="image/*">
            <div class="mt-2" id="currentImagePreview"></div>
          </div>
          
          <div class="form-check form-switch mb-3">
            <input class="form-check-input" type="checkbox" id="edit_is_published" name="is_published">
            <label class="form-check-label" for="edit_is_published">Publier cet événement</label>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
        <button type="button" class="btn btn-primary" id="saveEditEvent">Enregistrer les modifications</button>
      </div>
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Éléments du DOM
    const eventsTable = document.getElementById('eventsTable');
    const eventsTableBody = eventsTable.querySelector('tbody');
    const searchEventInput = document.getElementById('searchEvent');
    const eventsLoading = document.getElementById('eventsLoading');
    const noEventsMessage = document.getElementById('noEventsMessage');
    
    // Modals
    const deleteEventModal = new bootstrap.Modal(document.getElementById('deleteEventModal'));
    const editEventModal = new bootstrap.Modal(document.getElementById('editEventModal'));
    
    // Variables pour l'événement à supprimer
    let eventToDeleteId = null;
    
    // Charger la liste des événements
    loadEvents();
    
    // Écouteurs d'événements
    searchEventInput.addEventListener('keyup', function() {
        const searchTerm = this.value.toLowerCase();
        filterEvents(searchTerm);
    });
    
    document.getElementById('confirmDeleteEvent').addEventListener('click', function() {
        if (eventToDeleteId) {
            deleteEvent(eventToDeleteId);
        }
    });
    
    document.getElementById('saveEditEvent').addEventListener('click', function() {
        const form = document.getElementById('editEventForm');
        if (form.checkValidity()) {
            saveEventEdit(form);
        } else {
            form.classList.add('was-validated');
        }
    });
    
    // Fonctions
    function loadEvents() {
        // Afficher le chargement
        eventsLoading.classList.remove('d-none');
        noEventsMessage.classList.add('d-none');
        
        // Effectuer la requête pour récupérer les événements
        fetch('/api/events')
            .then(response => {
                if (!response.ok) {
                    throw new Error('Erreur lors de la récupération des événements');
                }
                return response.json();
            })
            .then(data => {
                // Masquer le chargement
                eventsLoading.classList.add('d-none');
                
                // Vérifier si des événements sont disponibles
                if (data.length === 0) {
                    noEventsMessage.classList.remove('d-none');
                    return;
                }
                
                // Vider le tableau
                eventsTableBody.innerHTML = '';
                
                // Remplir le tableau avec les événements
                data.forEach(event => {
                    const row = createEventRow(event);
                    eventsTableBody.appendChild(row);
                });
            })
            .catch(error => {
                console.error('Erreur:', error);
                eventsLoading.classList.add('d-none');
                noEventsMessage.textContent = 'Erreur lors du chargement des événements.';
                noEventsMessage.classList.remove('d-none');
                noEventsMessage.classList.remove('alert-info');
                noEventsMessage.classList.add('alert-danger');
            });
    }
    
    function createEventRow(event) {
        const row = document.createElement('tr');
        
        // Formater les dates
        const startDate = new Date(event.start_date).toLocaleString('fr-FR');
        const endDate = new Date(event.end_date).toLocaleString('fr-FR');
        
        // Définir le statut de publication
        const statusBadgeClass = event.is_published ? 'bg-success' : 'bg-secondary';
        const statusText = event.is_published ? 'Publié' : 'Privé';
        
        row.innerHTML = `
            <td>${event.title}</td>
            <td>${startDate}</td>
            <td>${endDate}</td>
            <td>${event.location || '-'}</td>
            <td>${event.type || '-'}</td>
            <td><span class="badge ${statusBadgeClass}">${statusText}</span></td>
            <td>
                <div class="btn-group btn-group-sm" role="group">
                    <button type="button" class="btn btn-outline-primary btn-edit" data-id="${event.id}" title="Modifier">
                        <i class="bi bi-pencil"></i>
                    </button>
                    <button type="button" class="btn btn-outline-danger btn-delete" data-id="${event.id}" data-title="${event.title}" title="Supprimer">
                        <i class="bi bi-trash"></i>
                    </button>
                    <button type="button" class="btn btn-outline-${event.is_published ? 'warning' : 'success'} btn-publish" data-id="${event.id}" data-published="${event.is_published}" title="${event.is_published ? 'Passer en privé' : 'Publier'}">
                        <i class="bi bi-${event.is_published ? 'eye-slash' : 'eye'}"></i>
                    </button>
                </div>
            </td>
        `;
        
        // Ajouter les gestionnaires d'événements pour les boutons
        row.querySelector('.btn-delete').addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            const title = this.getAttribute('data-title');
            showDeleteConfirmation(id, title);
        });
        
        row.querySelector('.btn-edit').addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            openEditModal(id);
        });
        
        row.querySelector('.btn-publish').addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            const isPublished = this.getAttribute('data-published') === 'true';
            toggleEventPublishStatus(id, !isPublished);
        });
        
        return row;
    }
    
    function filterEvents(searchTerm) {
        const rows = eventsTableBody.querySelectorAll('tr');
        
        rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            if (text.includes(searchTerm)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
        
        // Afficher un message si aucun résultat
        const visibleRows = Array.from(rows).filter(r => r.style.display !== 'none');
        if (visibleRows.length === 0) {
            noEventsMessage.textContent = 'Aucun événement ne correspond à votre recherche.';
            noEventsMessage.classList.remove('d-none');
        } else {
            noEventsMessage.classList.add('d-none');
        }
    }
    
    function showDeleteConfirmation(id, title) {
        eventToDeleteId = id;
        document.getElementById('eventToDeleteName').textContent = title;
        deleteEventModal.show();
    }
    
    function deleteEvent(id) {
        // Afficher l'indicateur de chargement
        const confirmBtn = document.getElementById('confirmDeleteEvent');
        const originalBtnText = confirmBtn.innerHTML;
        confirmBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Suppression...';
        confirmBtn.disabled = true;
        
        // Récupérer le token CSRF
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
        
        // Envoyer la requête de suppression
        fetch(`/api/events/${id}`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Erreur lors de la suppression');
            }
            return response.json();
        })
        .then(data => {
            // Fermer le modal et recharger les événements
            deleteEventModal.hide();
            showToast('Événement supprimé avec succès.', 'success');
            loadEvents();
        })
        .catch(error => {
            console.error('Erreur:', error);
            showToast('Erreur lors de la suppression de l\'événement.', 'danger');
        })
        .finally(() => {
            // Restaurer le bouton
            confirmBtn.innerHTML = originalBtnText;
            confirmBtn.disabled = false;
            eventToDeleteId = null;
        });
    }
    
    function openEditModal(id) {
        // Récupérer les données de l'événement
        fetch(`/api/events/${id}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Erreur lors de la récupération des détails de l\'événement');
                }
                return response.json();
            })
            .then(event => {
                // Remplir le formulaire avec les données de l'événement
                document.getElementById('edit_event_id').value = event.id;
                document.getElementById('edit_title').value = event.title;
                document.getElementById('edit_description').value = event.description || '';
                document.getElementById('edit_location').value = event.location || '';
                document.getElementById('edit_type').value = event.type || '';
                document.getElementById('edit_max_participants').value = event.max_participants || '';
                document.getElementById('edit_is_published').checked = event.is_published;
                
                // Formater les dates pour l'input datetime-local
                if (event.start_date) {
                    document.getElementById('edit_start_date').value = formatDateForInput(event.start_date);
                }
                if (event.end_date) {
                    document.getElementById('edit_end_date').value = formatDateForInput(event.end_date);
                }
                
                // Afficher l'image actuelle si elle existe
                const currentImagePreview = document.getElementById('currentImagePreview');
                if (event.image_url) {
                    currentImagePreview.innerHTML = `
                        <div class="mt-2">
                            <p class="mb-1">Image actuelle:</p>
                            <img src="${event.image_url}" alt="Image actuelle" class="img-thumbnail" style="max-height: 100px">
                        </div>
                    `;
                } else {
                    currentImagePreview.innerHTML = '<p class="text-muted">Aucune image</p>';
                }
                
                // Afficher le modal
                editEventModal.show();
            })
            .catch(error => {
                console.error('Erreur:', error);
                showToast('Erreur lors de la récupération des détails de l\'événement.', 'danger');
            });
    }
    
    function saveEventEdit(form) {
        // Récupérer l'ID de l'événement
        const eventId = document.getElementById('edit_event_id').value;
        
        // Afficher l'indicateur de chargement
        const saveBtn = document.getElementById('saveEditEvent');
        const originalBtnText = saveBtn.innerHTML;
        saveBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Enregistrement...';
        saveBtn.disabled = true;
        
        // Créer un objet FormData à partir du formulaire
        const formData = new FormData(form);
        formData.append('_method', 'PUT'); // Pour Laravel (méthode PUT)
        
        // Récupérer le token CSRF
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
        
        // Envoyer la requête de mise à jour
        fetch(`/api/events/${eventId}`, {
            method: 'POST', // La méthode POST est utilisée avec _method=PUT pour la compatibilité avec Laravel
            body: formData,
            headers: {
                'X-CSRF-TOKEN': csrfToken
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Erreur lors de la mise à jour');
            }
            return response.json();
        })
        .then(data => {
            // Fermer le modal et recharger les événements
            editEventModal.hide();
            showToast('Événement mis à jour avec succès.', 'success');
            loadEvents();
        })
        .catch(error => {
            console.error('Erreur:', error);
            showToast('Erreur lors de la mise à jour de l\'événement.', 'danger');
        })
        .finally(() => {
            // Restaurer le bouton
            saveBtn.innerHTML = originalBtnText;
            saveBtn.disabled = false;
            form.classList.remove('was-validated');
        });
    }
    
    function toggleEventPublishStatus(id, newStatus) {
        // Récupérer le token CSRF
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
        
        // Préparer les données
        const data = {
            is_published: newStatus
        };
        
        // Envoyer la requête de mise à jour du statut
        fetch(`/api/events/${id}/publish`, {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify(data)
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Erreur lors de la mise à jour du statut');
            }
            return response.json();
        })
        .then(data => {
            showToast(`Événement ${newStatus ? 'publié' : 'passé en privé'} avec succès.`, 'success');
            loadEvents();
        })
        .catch(error => {
            console.error('Erreur:', error);
            showToast('Erreur lors de la mise à jour du statut de l\'événement.', 'danger');
        });
    }
    
    // Fonction pour afficher une notification Toast
    function showToast(message, type = 'info') {
        // Vérifier si l'élément toast existe, sinon le créer
        let toastContainer = document.querySelector('.toast-container');
        
        if (!toastContainer) {
            toastContainer = document.createElement('div');
            toastContainer.className = 'toast-container position-fixed bottom-0 end-0 p-3';
            document.body.appendChild(toastContainer);
        }
        
        // Créer un identifiant unique pour le toast
        const toastId = 'toast-' + Date.now();
        
        // Créer le HTML du toast
        const toastHTML = `
            <div id="${toastId}" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-header bg-${type} text-white">
                    <strong class="me-auto">Notification</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body">
                    ${message}
                </div>
            </div>
        `;
        
        // Ajouter le toast au conteneur
        toastContainer.insertAdjacentHTML('beforeend', toastHTML);
        
        // Initialiser le toast et l'afficher
        const toastElement = document.getElementById(toastId);
        const toast = new bootstrap.Toast(toastElement, { delay: 5000 });
        toast.show();
        
        // Supprimer le toast après qu'il ait été masqué
        toastElement.addEventListener('hidden.bs.toast', function() {
            toastElement.remove();
        });
    }
    
    // Fonction pour formater les dates pour les inputs datetime-local
    function formatDateForInput(dateString) {
        const date = new Date(dateString);
        return date.toISOString().slice(0, 16); // Format: YYYY-MM-DDTHH:MM
    }
});
</script>
            </div>
        </div>
        
        <!-- Tab: Catalogue -->
        <div class="tab-content " id="catalogue">
            <div class="action-bar">
                <div class="action-buttons">
                    <button type="button" class="btn btn-primary add-btn" data-bs-toggle="modal" data-bs-target="#catalogueModal">
                        <i class="fas fa-plus-circle"></i> Ajouter
                    </button>
                   
                </div>
            </div>
            <div class="content-area">
                <h4>Contenu du catalogue</h4>
                <p>Liste des éléments du catalogue apparaîtra ici.</p>
            </div>
        </div>
    </div>
    
 

<!-- Formulaire d'ajout d'événement -->
<div class="modal fade" id="eventModal" tabindex="-1" aria-labelledby="eventModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="eventModalLabel">Ajouter un événement</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="eventForm" action="{{ route('events.store') }}" method="POST"  class="needs-validation" novalidate enctype="multipart/form-data">
          <input type="hidden" name="_token" value="{{ csrf_token() }}">
          
          <div class="mb-3">
            <label for="title" class="form-label">Titre de l'événement*</label>
            <input type="text" class="form-control" id="title" name="title" required>
            <div class="invalid-feedback">Veuillez saisir un titre.</div>
          </div>
          
          <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" name="description" rows="3"></textarea>
          </div>
          
          <div class="row">
            <div class="col-md-6 mb-3">
              <label for="start_date" class="form-label">Date et heure de début*</label>
              <input type="datetime-local" class="form-control" id="start_date" name="start_date" required>
              <div class="invalid-feedback">Veuillez saisir une date de début valide.</div>
            </div>
            <div class="col-md-6 mb-3">
              <label for="end_date" class="form-label">Date et heure de fin*</label>
              <input type="datetime-local" class="form-control" id="end_date" name="end_date" required>
              <div class="invalid-feedback">Veuillez saisir une date de fin valide.</div>
            </div>
          </div>
          
          <div class="mb-3">
            <label for="location" class="form-label">Lieu</label>
            <input type="text" class="form-control" id="location" name="location">
          </div>
          
          <div class="row">
            <div class="col-md-6 mb-3">
              <label for="type" class="form-label">Type d'événement</label>
              <select class="form-select" id="type" name="type">
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
              <label for="max_participants" class="form-label">Nombre max. de participants</label>
              <input type="number" class="form-control" id="max_participants" name="max_participants" min="1">
            </div>
          </div>
          
          <div class="mb-3">
            <label for="event_image" class="form-label">Image (affiche)</label>
            <input type="file" class="form-control" id="event_image" name="image" accept="image/*">
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
        <button type="button" class="btn btn-primary" id="submitEvent">Enregistrer</button>
      </div>
    </div>
  </div>
</div>

<!-- Formulaire d'ajout d'étudiant -->
<div class="modal fade" id="etudiantModal" tabindex="-1" aria-labelledby="etudiantModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="etudiantModalLabel">Ajouter un étudiant</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="etudiantForm"action="{{ route('etudiants.store') }}" method="POST" class="needs-validation" novalidate enctype="multipart/form-data">
          <input type="hidden" name="_token" value="{{ csrf_token() }}">
          
          <div class="row">
            <div class="col-md-6 mb-3">
              <label for="nom" class="form-label">Nom*</label>
              <input type="text" class="form-control" id="nom" name="nom" required>
              <div class="invalid-feedback">Veuillez saisir un nom.</div>
            </div>
            <div class="col-md-6 mb-3">
              <label for="prenom" class="form-label">Prénom*</label>
              <input type="text" class="form-control" id="prenom" name="prenom" required>
              <div class="invalid-feedback">Veuillez saisir un prénom.</div>
            </div>
          </div>
          
          <div class="row">
            <div class="col-md-6 mb-3">
              <label for="email" class="form-label">Email*</label>
              <input type="email" class="form-control" id="email" name="email" required>
              <div class="invalid-feedback">Veuillez saisir une adresse email valide.</div>
            </div>
            <div class="col-md-6 mb-3">
              <label for="telephone" class="form-label">Téléphone</label>
              <input type="tel" class="form-control" id="telephone" name="telephone">
            </div>
          </div>
          
          <div class="row">
            <div class="col-md-6 mb-3">
              <label for="formation" class="form-label">Formation</label>
              <input type="text" class="form-control" id="formation" name="formation">
            </div>
            <div class="col-md-6 mb-3">
              <label for="niveau" class="form-label">Niveau</label>
              <select class="form-select" id="niveau" name="niveau">
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
            <label for="date_naissance" class="form-label">Date de naissance</label>
            <input type="date" class="form-control" id="date_naissance" name="date_naissance">
          </div>
          
          <div class="row">
            <div class="col-md-6 mb-3">
              <label for="cv" class="form-label">CV (PDF)</label>
              <input type="file" class="form-control" id="cv" name="cv" accept=".pdf">
            </div>
            <div class="col-md-6 mb-3">
              <label for="photo" class="form-label">Photo</label>
              <input type="file" class="form-control" id="photo" name="photo" accept="image/*">
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
        <button type="button" class="btn btn-primary" id="submitEtudiant">Enregistrer</button>
      </div>
    </div>
  </div>
</div>

<!-- Formulaire d'ajout d'entreprise -->
<div class="modal fade" id="entrepriseModal" tabindex="-1" aria-labelledby="entrepriseModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="entrepriseModalLabel">Ajouter une entreprise</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="entrepriseForm" action="{{ route('entreprises.store') }}" method="POST" class="needs-validation" novalidate enctype="multipart/form-data">
          <input type="hidden" name="_token" value="{{ csrf_token() }}">
          
          <div class="mb-3">
            <label for="nom_entreprise" class="form-label">Nom de l'entreprise*</label>
            <input type="text" class="form-control" id="nom_entreprise" name="nom" required>
            <div class="invalid-feedback">Veuillez saisir un nom d'entreprise.</div>
          </div>
          
          <div class="row">
            <div class="col-md-6 mb-3">
              <label for="secteur" class="form-label">Secteur d'activité</label>
              <input type="text" class="form-control" id="secteur" name="secteur">
            </div>
            <div class="col-md-6 mb-3">
              <label for="contact_principal" class="form-label">Contact principal</label>
              <input type="text" class="form-control" id="contact_principal" name="contact_principal">
            </div>
          </div>
          
          <div class="mb-3">
            <label for="description_entreprise" class="form-label">Description</label>
            <textarea class="form-control" id="description_entreprise" name="description" rows="3"></textarea>
          </div>
          
          <div class="mb-3">
            <label for="adresse" class="form-label">Adresse</label>
            <textarea class="form-control" id="adresse" name="adresse" rows="2"></textarea>
          </div>
          
          <div class="row">
            <div class="col-md-6 mb-3">
              <label for="email_entreprise" class="form-label">Email*</label>
              <input type="email" class="form-control" id="email_entreprise" name="email" required>
              <div class="invalid-feedback">Veuillez saisir une adresse email valide.</div>
            </div>
            <div class="col-md-6 mb-3">
              <label for="telephone_entreprise" class="form-label">Téléphone</label>
              <input type="tel" class="form-control" id="telephone_entreprise" name="telephone">
            </div>
          </div>
          
          <div class="row">
            <div class="col-md-6 mb-3">
              <label for="site_web" class="form-label">Site web</label>
              <input type="url" class="form-control" id="site_web" name="site_web">
            </div>
            <div class="col-md-6 mb-3">
              <label for="logo" class="form-label">Logo</label>
              <input type="file" class="form-control" id="logo" name="logo" accept="image/*">
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
        <button type="button" class="btn btn-primary" id="submitEntreprise">Enregistrer</button>
      </div>
    </div>
  </div>
</div>

<!-- Formulaire d'ajout de recrutement -->
<div class="modal fade" id="recrutementModal" tabindex="-1" aria-labelledby="recrutementModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="recrutementModalLabel">Ajouter une offre de recrutement</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="recrutementForm" action="{{ route('recrutements.store') }}" method="POST" class="needs-validation" novalidate>
          <input type="hidden" name="_token" value="{{ csrf_token() }}">
          
          <div class="mb-3">
            <label for="titre_recrutement" class="form-label">Titre de l'offre*</label>
            <input type="text" class="form-control" id="titre_recrutement" name="titre" required>
            <div class="invalid-feedback">Veuillez saisir un titre.</div>
          </div>
          
          <div class="mb-3">
            <label for="entreprise_id" class="form-label">Entreprise*</label>
            <select class="form-select" id="entreprise_id" name="entreprise_id" required>
              <option value="">Sélectionner une entreprise</option>
              <!-- Options générées dynamiquement  -->
             

            </select>
            <div class="invalid-feedback">Veuillez sélectionner une entreprise.</div>
          </div>
          
          <div class="row">
            <div class="col-md-6 mb-3">
              <label for="type_contrat" class="form-label">Type de contrat*</label>
              <select class="form-select" id="type_contrat" name="type_contrat" required>
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
              <label for="lieu" class="form-label">Lieu</label>
              <input type="text" class="form-control" id="lieu" name="lieu">
            </div>
          </div>
          
          <div class="mb-3">
            <label for="description_recrutement" class="form-label">Description*</label>
            <textarea class="form-control" id="description_recrutement" name="description" rows="4" required></textarea>
            <div class="invalid-feedback">Veuillez saisir une description.</div>
          </div>
          
          <div class="mb-3">
            <label for="competences_requises" class="form-label">Compétences requises</label>
            <textarea class="form-control" id="competences_requises" name="competences_requises" rows="3"></textarea>
          </div>
          
          <div class="row">
            <div class="col-md-6 mb-3">
              <label for="date_debut" class="form-label">Date de début</label>
              <input type="date" class="form-control" id="date_debut" name="date_debut">
            </div>
            <div class="col-md-6 mb-3">
              <label for="salaire" class="form-label">Salaire</label>
              <input type="text" class="form-control" id="salaire" name="salaire">
            </div>
          </div>
          
          <div class="mb-3">
            <label for="date_expiration" class="form-label">Date d'expiration de l'offre</label>
            <input type="date" class="form-control" id="date_expiration" name="date_expiration">
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
        <button type="button" class="btn btn-primary" id="submitRecrutement">Enregistrer</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="actualiteModal" tabindex="-1" aria-labelledby="actualiteModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="actualiteModalLabel">Ajouter une actualité</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="actualiteForm" action="{{ route('actualites.store') }}" method="POST" class="needs-validation" novalidate enctype="multipart/form-data">
          <input type="hidden" name="_token" value="{{ csrf_token() }}">
          
          <div class="mb-3">
            <label for="titre_actualite" class="form-label">Titre*</label>
            <input type="text" class="form-control" id="titre_actualite" name="titre" required>
            <div class="invalid-feedback">Veuillez saisir un titre.</div>
          </div>
          
          <div class="mb-3">
            <label for="contenu" class="form-label">Contenu*</label>
            <textarea class="form-control" id="contenu" name="contenu" rows="5" required></textarea>
            <div class="invalid-feedback">Veuillez saisir un contenu.</div>
          </div>
          
          <div class="row">
            <div class="col-md-6 mb-3">
              <label for="categorie" class="form-label">Catégorie</label>
              <select class="form-select" id="categorie" name="categorie">
                <option value="">Sélectionner une catégorie</option>
                <option value="Événement">Événement</option>
                <option value="Recrutement">Recrutement</option>
                <option value="Formation">Formation</option>
                <option value="Campus">Campus</option>
                <option value="Partenariat">Partenariat</option>
              </select>
            </div>
            <div class="col-md-6 mb-3">
              <label for="date_publication" class="form-label">Date de publication*</label>
              <input type="datetime-local" class="form-control" id="date_publication" name="date_publication" required>
              <div class="invalid-feedback">Veuillez saisir une date de publication.</div>
            </div>
          </div>
          
          <div class="row">
            <div class="col-md-6 mb-3">
              <label for="auteur" class="form-label">Auteur</label>
              <input type="text" class="form-control" id="auteur" name="auteur">
            </div>
            <div class="col-md-6 mb-3">
              <label for="image_actualite" class="form-label">Image</label>
              <input type="file" class="form-control" id="image_actualite" name="image" accept="image/*">
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
        <button type="button" class="btn btn-primary" id="submitActualite">Enregistrer</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="catalogueModal" tabindex="-1" aria-labelledby="catalogueModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="catalogueModalLabel">Ajouter une formation au catalogue</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="catalogueForm" action="{{ route('catalogue.store') }}" method="POST" class="needs-validation" novalidate enctype="multipart/form-data">
          <input type="hidden" name="_token" value="{{ csrf_token() }}">
          
          <div class="mb-3">
            <label for="titre_formation" class="form-label">Titre de la formation*</label>
            <input type="text" class="form-control" id="titre_formation" name="titre" required>
            <div class="invalid-feedback">Veuillez saisir un titre.</div>
          </div>
          
          <div class="mb-3">
            <label for="description_formation" class="form-label">Description*</label>
            <textarea class="form-control" id="description_formation" name="description" rows="3" required></textarea>
            <div class="invalid-feedback">Veuillez saisir une description.</div>
          </div>
          
          <div class="row">
            <div class="col-md-4 mb-3">
              <label for="duree" class="form-label">Durée</label>
              <input type="text" class="form-control" id="duree" name="duree" placeholder="Ex: 3 jours, 35 heures...">
            </div>
            <div class="col-md-4 mb-3">
              <label for="type_formation" class="form-label">Type</label>
              <select class="form-select" id="type_formation" name="type">
                <option value="">Sélectionner un type</option>
                <option value="Présentiel">Présentiel</option>
                <option value="Distanciel">Distanciel</option>
                <option value="Hybride">Hybride</option>
              </select>
            </div>
            <div class="col-md-4 mb-3">
              <label for="niveau_formation" class="form-label">Niveau</label>
              <select class="form-select" id="niveau_formation" name="niveau">
                <option value="">Sélectionner un niveau</option>
                <option value="Débutant">Débutant</option>
                <option value="Intermédiaire">Intermédiaire</option>
                <option value="Avancé">Avancé</option>
                <option value="Expert">Expert</option>
              </select>
            </div>
          </div>
          
          <div class="mb-3">
            <label for="pre_requis" class="form-label">Pré-requis</label>
            <textarea class="form-control" id="pre_requis" name="pre_requis" rows="2"></textarea>
          </div>
          
          <div class="mb-3">
            <label for="contenu_formation" class="form-label">Contenu de la formation</label>
            <textarea class="form-control" id="contenu_formation" name="contenu" rows="4"></textarea>
          </div>
          
          <div class="mb-3">
            <label for="image_formation" class="form-label">Image</label>
            <input type="file" class="form-control" id="image_formation" name="image" accept="image/*">
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
        <button type="button" class="btn btn-primary" id="submitCatalogue">Enregistrer</button>
      </div>
    </div>
  </div>
</div>

<!-- Toast de confirmation -->
<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
  <div id="successToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="toast-header bg-success text-white">
      <strong class="me-auto">Confirmation</strong>
      <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
    <div class="toast-body">
      Enregistrement effectué avec succès !
    </div>
  </div>
</div>


<script>
document.addEventListener('DOMContentLoaded', function() {
    // Système d'onglets
    const tabs = document.querySelectorAll('.tab');
    const tabContents = document.querySelectorAll('.tab-content');
    
    tabs.forEach(tab => {
        tab.addEventListener('click', () => {
            // Retirer la classe active de tous les onglets et contenus
            tabs.forEach(t => t.classList.remove('active'));
            tabContents.forEach(content => content.classList.remove('active'));
            
            // Ajouter la classe active à l'onglet cliqué
            tab.classList.add('active');
            
            // Afficher le contenu correspondant
            const tabId = tab.getAttribute('data-tab');
            document.getElementById(tabId).classList.add('active');
        });
    });
    
    // Initialisation des modals
    const modals = [
        { id: 'eventModal', formId: 'eventForm', submitId: 'submitEvent', route: 'events.store' },
        { id: 'etudiantModal', formId: 'etudiantForm', submitId: 'submitEtudiant', route: 'etudiants.store' },
        { id: 'entrepriseModal', formId: 'entrepriseForm', submitId: 'submitEntreprise', route: 'entreprises.store' },
        { id: 'recrutementModal', formId: 'recrutementForm', submitId: 'submitRecrutement', route: 'recrutements.store' },
        { id: 'actualiteModal', formId: 'actualiteForm', submitId: 'submitActualite', route: 'actualites.store' },
        { id: 'catalogueModal', formId: 'catalogueForm', submitId: 'submitCatalogue', route: 'catalogue.store' }
    ];
    
    // Vérifier si l'élément successToast existe avant de l'initialiser
    let successToast;
    const successToastElement = document.getElementById('successToast');
    if (successToastElement) {
        successToast = new bootstrap.Toast(successToastElement);
    }
    
    // Fonction générique pour initialiser les modals et les formulaires
    modals.forEach(modal => {
        // Initialiser les modals Bootstrap
        const modalElement = document.getElementById(modal.id);
        if (modalElement) {
            const bootstrapModal = new bootstrap.Modal(modalElement);
            
            // Récupérer les éléments du formulaire
            const form = document.getElementById(modal.formId);
            const submitBtn = document.getElementById(modal.submitId);
            
            if (form && submitBtn) {
                // Initialiser les validations de date si c'est le modal d'événement
                if (modal.id === 'eventModal') {
                    initEventDateValidation();
                }
                
                // Gestion de la soumission du formulaire
                submitBtn.addEventListener('click', function(event) {
                    // Empêcher la soumission par défaut du formulaire
                    event.preventDefault();
                    submitForm(form, submitBtn, bootstrapModal, modal.route);
                });
            }
        }
    });
    
    // Validation spécifique pour les dates d'événements
    function initEventDateValidation() {
        const startDateInput = document.getElementById('start_date');
        const endDateInput = document.getElementById('end_date');
        
        // Définir la date minimale (aujourd'hui) pour les champs de date
        const today = new Date();
        const formattedDate = today.toISOString().slice(0, 16);
        if (startDateInput) {
            startDateInput.setAttribute('min', formattedDate);
            
            // Mettre à jour la date de fin minimale lorsque la date de début change
            startDateInput.addEventListener('change', function() {
                if (startDateInput.value && endDateInput) {
                    endDateInput.setAttribute('min', startDateInput.value);
                }
            });
        }
        
        // Validation personnalisée pour la date de fin
        if (endDateInput) {
            endDateInput.addEventListener('change', function() {
                if (startDateInput && startDateInput.value && endDateInput.value) {
                    if (new Date(endDateInput.value) <= new Date(startDateInput.value)) {
                        endDateInput.setCustomValidity('La date de fin doit être postérieure à la date de début');
                    } else {
                        endDateInput.setCustomValidity('');
                    }
                }
            });
        }
    }
    function submitForm(form, submitBtn, modal, route) {
  if (!form.checkValidity()) {
            form.classList.add('was-validated');
            return;
        }
        
        // Création et envoi des données
        const formData = new FormData(form);
        
        // Affichage de l'indicateur de chargement
        const originalBtnContent = submitBtn.innerHTML;
        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Enregistrement...';
        submitBtn.disabled = true;
        
        // Récupérer le token CSRF
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || 
                          document.querySelector('input[name="_token"]')?.value;
    // Utiliser l'URL définie dans l'attribut action du formulaire
    const formAction = form.getAttribute('action');
    
    // Effectuer la requête fetch avec l'URL complète
    fetch(formAction, {
        method: "POST",
        body: formData,
        headers: {
            'X-CSRF-TOKEN': csrfToken,
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    // ...
        .then(response => {
            if (!response.ok) {
                throw new Error('Erreur réseau ou serveur');
            }
            return response.json();
        })
        .then(data => {
            // Réinitialiser le formulaire
            form.reset();
            form.classList.remove('was-validated');
            
            // Fermer le modal et afficher la notification
            modal.hide();
            if (successToast) {
                successToast.show();
            }
        })
        .catch(error => {
            console.error("Erreur :", error);
            alert("Une erreur s'est produite. Veuillez réessayer.");
        })
        .finally(() => {
            // Restaurer le bouton
            submitBtn.innerHTML = originalBtnContent;
            submitBtn.disabled = false;
        });
    }

});


</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
