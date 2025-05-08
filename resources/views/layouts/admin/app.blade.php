<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    {{-- CSRF Token for AJAX requests --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'StagesBENIN - Admin')</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style>
        /* Global Variables */
        :root {
            --primary: #2563eb; /* Blue 600 */
            --primary-dark: #1d4ed8; /* Blue 700 */
            --secondary: #4f46e5; /* Indigo 600 */
            --success: #10b981; /* Emerald 500 */
            --danger: #ef4444; /* Red 500 */
            --warning: #f59e0b; /* Amber 500 */
            --info: #3b82f6; /* Blue 500 */
            --light: #f9fafb; /* Gray 50 */
            --dark: #1f2937; /* Gray 800 */
            --gray: #6b7280; /* Gray 500 */
            --sidebar-width: 250px;
            --sidebar-width-collapsed: 70px;
            --header-height: 60px;
            --border-radius: 8px;
            --transition: all 0.3s ease;
            --box-shadow-sm: 0 1px 3px rgba(0, 0, 0, 0.05);
            --box-shadow: 0 4px 10px rgba(0, 0, 0, 0.08);
            --box-shadow-lg: 0 5px 15px rgba(0,0,0,0.15);
            --border-color: #e5e7eb; /* Gray 200 */
        }

        /* Base Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: #f3f4f6; /* Gray 100 */
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
        }

        /* Sidebar Base (moved to partials/sidebar.blade.php for structure) */
        /* Main Content Area */
        .main-content {
            flex: 1;
            margin-left: var(--sidebar-width);
            transition: margin-left var(--transition);
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* Header Base (moved to partials/header.blade.php for structure) */

        /* Content Area within Main */
        .content {
            padding: 25px;
            flex-grow: 1; /* Ensure content area takes available space */
        }

        .dashboard-title {
            margin-bottom: 25px;
            font-size: 1.6rem;
            color: var(--dark);
            font-weight: 600;
        }

        /* Stats Cards */
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
            box-shadow: var(--box-shadow-sm);
            display: flex;
            flex-direction: column;
            transition: var(--transition);
            border: 1px solid var(--border-color);
        }

        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: var(--box-shadow);
        }

        .stat-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }
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
        .stat-icon i { font-size: 1.1rem; }

        .bg-primary { background-color: var(--primary); }
        .bg-success { background-color: var(--success); }
        .bg-warning { background-color: var(--warning); }
        .bg-danger { background-color: var(--danger); }

        .stat-value {
            font-size: 1.8rem;
            font-weight: bold;
            color: var(--dark);
            margin-bottom: 8px;
        }
        .stat-progress {
            font-size: 0.8rem;
            display: flex;
            align-items: center;
            color: var(--gray);
        }
        .stat-progress i { margin-right: 4px; font-size: 0.7rem;}
        .stat-progress.up { color: var(--success); }
        .stat-progress.down { color: var(--danger); }

        /* Tabs */
        .tabs-container {
            background-color: white;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow-sm);
            border: 1px solid var(--border-color);
            margin-bottom: 30px;
            overflow: hidden;
        }

        .tabs-header {
            display: flex;
            border-bottom: 1px solid var(--border-color);
            overflow-x: auto;
            scrollbar-width: none; /* Firefox */
            -ms-overflow-style: none;  /* IE/Edge */
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
            border: none;
            background: none;
            border-bottom: 3px solid transparent;
            flex-shrink: 0;
        }

        .tab:hover { color: var(--primary); background-color: var(--light); }
        .tab.active { color: var(--primary); border-bottom-color: var(--primary); }

        .tab-content { display: none; padding: 25px; }
        .tab-content.active { display: block; animation: fadeIn 0.5s; }

        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }

        /* Table Styles */
        .table {
            margin-bottom: 1rem; /* Restore some default margin for tables */
            border-color: var(--border-color);
        }
        .table th {
            background-color: var(--light);
            font-weight: 600;
            white-space: nowrap;
        }
        .table td {
            vertical-align: middle;
        }
        .table-hover > tbody > tr:hover > * {
             background-color: #f3f4f6; /* Gray 100 for hover */
        }
        .table-bordered th, .table-bordered td {
             border: 1px solid var(--border-color);
        }
        .table-responsive {
            margin-bottom: 1rem;
        }

         /* Student Table Specific Styles (kept here for simplicity, could be page specific) */
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
            border-bottom: 1px solid var(--border-color);
        }

        .student-table th {
            background-color: var(--dark);
            color: #fff;
            font-weight: 600;
        }

        .student-table tr:last-child td {
            border-bottom: none;
        }

        /* Status Badges/Indicators */
        .status {
            display: inline-flex;
            align-items: center;
            padding: 4px 10px;
            border-radius: 15px;
            font-size: 0.75rem;
            font-weight: 500;
            white-space: nowrap;
        }
        /* Example Status colors (adjust as needed) */
        .status-active, .badge.bg-success {
            background-color: rgba(16, 185, 129, 0.1);
            color: var(--success);
        }
        .status-pending, .badge.bg-warning {
            background-color: rgba(245, 158, 11, 0.1);
            color: var(--warning);
        }
        .status-blocked, .badge.bg-danger {
            background-color: rgba(239, 68, 68, 0.1);
            color: var(--danger);
        }
         .badge.bg-secondary {
            background-color: rgba(107, 114, 128, 0.1); /* Gray 500 with opacity */
            color: var(--gray);
        }
         .badge.bg-info {
            background-color: rgba(59, 130, 246, 0.1); /* Blue 500 with opacity */
            color: var(--info);
        }

        /* Action Bar */
        .action-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            flex-wrap: wrap;
            gap: 15px;
        }
        .action-buttons {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        /* Button Styles (Leverage Bootstrap, add overrides if needed) */
        .btn {
            border-radius: var(--border-radius);
            font-weight: 500;
            padding: 0.5rem 1rem;
            transition: var(--transition);
        }
        .btn-sm {
            padding: 0.25rem 0.6rem;
            font-size: 0.8rem;
        }

        /* Modal Styles */
        .modal-content {
            border-radius: var(--border-radius);
            border: none;
            box-shadow: var(--box-shadow-lg);
        }
        .modal-header {
            border-bottom: 1px solid var(--border-color);
            padding: 1rem 1.5rem;
        }
        .modal-title { font-size: 1.2rem; font-weight: 600; }
        .modal-body { padding: 1.5rem; }
        .modal-footer {
            border-top: 1px solid var(--border-color);
            padding: 1rem 1.5rem;
            background-color: var(--light);
            border-bottom-left-radius: var(--border-radius);
            border-bottom-right-radius: var(--border-radius);
        }

        /* Form Styles */
        .form-label { font-weight: 500; margin-bottom: 0.3rem; color: var(--dark); }
        .form-control, .form-select {
            border-radius: var(--border-radius);
            border-color: var(--border-color);
        }
        .form-control:focus, .form-select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 0.25rem rgba(37, 99, 235, 0.25);
        }
        textarea.form-control { min-height: 100px; resize: vertical; }
        .needs-validation .form-control:invalid, .needs-validation .form-select:invalid {
            border-color: var(--danger);
        }
        .was-validated .form-control:invalid:focus, .was-validated .form-select:invalid:focus {
            box-shadow: 0 0 0 0.25rem rgba(239, 68, 68, 0.25); /* Red shadow */
        }
        .invalid-feedback {
            color: var(--danger);
        }

        /* Sidebar Collapsed State */
        .sidebar.collapsed {
            width: var(--sidebar-width-collapsed);
        }
        .sidebar.collapsed .sidebar-header h2,
        .sidebar.collapsed .menu-text,
        .sidebar.collapsed .menu-category,
        .sidebar.collapsed .menu-badge:not(.absolute-badge) { /* Hide normal badge unless absolute */
            opacity: 0;
            width: 0;
            overflow: hidden;
            white-space: nowrap;
            transition: opacity 0.1s ease, width 0.1s ease; /* Faster hide */
        }
        .sidebar.collapsed .menu-item {
            justify-content: center;
            padding-left: 10px; /* Adjust padding */
            padding-right: 10px;
        }
        .sidebar.collapsed .menu-icon {
            margin-right: 0;
        }
        /* Keep absolute positioned badge visible and centered */
        .sidebar.collapsed .menu-badge.absolute-badge {
            position: absolute;
            top: 5px;
            right: 5px;
            opacity: 1;
            width: auto;
            /* display: block !important; /* Ensure visible */
        }

        .main-content.collapsed {
            margin-left: var(--sidebar-width-collapsed);
        }

        /* Tooltips */
        .tooltip-inner {
            background-color: var(--dark);
            color: white;
            font-size: 0.75rem;
            padding: 4px 8px;
        }
        .tooltip.bs-tooltip-auto[data-popper-placement^=top] .tooltip-arrow::before,
        .tooltip.bs-tooltip-top .tooltip-arrow::before {
            border-top-color: var(--dark);
        }
        /* Add other directions as needed */

        /* Responsive Adjustments */
        @media (max-width: 992px) {
            .profile-info { display: none; } /* Hide profile text */
        }

        @media (max-width: 768px) {
            .stats-container { grid-template-columns: 1fr; }
            .search-bar { max-width: 200px; }
            .header-actions { gap: 2px; }
            .user-profile { margin-left: 5px; }
            .profile-image { margin-right: 0; }
            .toggle-sidebar { display: block; } /* Ensure always visible */

            /* Force sidebar collapse on smaller screens */
            .sidebar {
                width: var(--sidebar-width-collapsed);
            }
            .sidebar .sidebar-header h2,
            .sidebar .menu-text,
            .sidebar .menu-category,
            .sidebar .menu-badge:not(.absolute-badge) {
                display: none; /* Use display none instead of opacity for better reflow */
            }
            .sidebar .menu-item {
                justify-content: center;
                 padding-left: 10px;
                 padding-right: 10px;
            }
            .sidebar .menu-icon {
                margin-right: 0;
            }
            .sidebar .menu-badge.absolute-badge {
                display: inline-block !important; /* Ensure visible */
            }
            .main-content {
                margin-left: var(--sidebar-width-collapsed);
            }
        }

        @media (max-width: 576px) {
            .content { padding: 15px; }
            .dashboard-title { font-size: 1.4rem; }
            .header { padding: 0 15px; }
            .search-bar { display: none; }
            .action-bar {
                flex-direction: column;
                align-items: stretch; /* Stack buttons full width */
            }
             .action-buttons {
                 width: 100%;
                 justify-content: flex-start; /* Align buttons left */
             }
            .tabs-header { flex-wrap: nowrap; } /* Prevent wrapping */
            .tab { padding: 12px 15px; font-size: 0.9rem; }
            .modal-dialog { max-width: 95%; margin: 1rem auto; } /* Adjust modal size */
        }
    </style>

    @stack('styles') {{-- Placeholder for page-specific CSS --}}

</head>
<body>
    <div class="dashboard">
        {{-- Sidebar --}}
        @include('layouts.admin.partials.sidebar')

        {{-- Main Content --}}
        <div class="main-content" id="main-content">
            {{-- Header --}}
            @include('layouts.admin.partials.header')

            {{-- Page Content --}}
            <main class="content">
                @yield('content')
            </main>

            {{-- Footer (Optional) --}}
            {{-- <footer class="footer mt-auto py-3 bg-light">
                <div class="container text-center">
                    <span class="text-muted">© {{ date('Y') }} StagesBENIN. Tous droits réservés.</span>
                </div>
            </footer> --}}
        </div>
    </div>

     {{-- Modals defined in dashboard.blade.php will be included here --}}
     {{-- because they are within the @section('content') of that file --}}
     {{-- If modals need to be accessible globally, define them here outside the @yield --}}
     {{-- Or use @stack/'modals' --}}

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
                   <!-- Début ajout option ticket -->
                   <div class="row">
                     <div class="col-md-6 mb-3">
                       <label for="event_requires_ticket" class="form-label">Vente de ticket</label>
                       <select class="form-select" id="event_requires_ticket" name="requires_ticket" onchange="toggleTicketPrice()">
                         <option value="non">Non</option>
                         <option value="oui">Oui</option>
                       </select>
                     </div>
                     <div class="col-md-6 mb-3" id="ticket_price_container" style="display: none;">
                       <label for="event_ticket_price" class="form-label">Prix du ticket*</label>
                       <input type="number" class="form-control" id="event_ticket_price" name="ticket_price" min="0" step="0.01" required>
                     </div>
                   </div>
                   <!-- Fin ajout option ticket -->
                   
               </div>
               <div class="modal-footer">
                 <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                 <button type="submit" class="btn btn-primary submit-btn" id="submitEvent">Enregistrer</button>
               </div>
           </form>
         </div>
       </div>
     </div>

     <!-- Script pour gérer l'affichage du champ prix -->
     <script>
       function toggleTicketPrice() {
         const requiresTicket = document.getElementById('event_requires_ticket').value;
         const priceContainer = document.getElementById('ticket_price_container');
         
         if (requiresTicket === 'oui') {
           priceContainer.style.display = 'block';
         } else {
           priceContainer.style.display = 'none';
           document.getElementById('event_ticket_price').value = '';
         }
       }
       
       // Exécuter au chargement de la page pour initialiser l'état
       document.addEventListener('DOMContentLoaded', function() {
         toggleTicketPrice();
       });
     </script>

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
                      <label for="entreprise_contact" class="form-label">Nom complet du PDG</label>
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
        @if(isset($globalEntreprises))
            @foreach($globalEntreprises as $entreprise)
                <option value="{{ $entreprise->id }}">{{ $entreprise->nom }}</option>
            @endforeach
        @endif
        <option value="autre">Autre</option> <!-- Option Autre -->
    </select>
    <div class="invalid-feedback">Veuillez sélectionner une entreprise.</div>
</div>

<!-- Champ caché par défaut -->
<div class="mb-3" id="autre_entreprise_div" style="display: none;">
    <label for="autre_entreprise" class="form-label">Nom de l'entreprise*</label>
    <input type="text" class="form-control" id="autre_entreprise" name="autre_entreprise" placeholder="Entrez le nom de votre entreprise">
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const entrepriseSelect = document.getElementById('recrutement_entreprise_id');
        const autreEntrepriseDiv = document.getElementById('autre_entreprise_div');

        entrepriseSelect.addEventListener('change', function() {
            if (this.value === 'autre') {
                autreEntrepriseDiv.style.display = 'block';
                document.getElementById('autre_entreprise').required = true;
            } else {
                autreEntrepriseDiv.style.display = 'none';
                document.getElementById('autre_entreprise').required = false;
            }
        });
    });
</script>

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
             <h5 class="modal-title" id="actualiteModalLabel">Ajouter un marché</h5>
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

  <!-- Titre -->
  <div class="mb-3">
    <label for="catalogue_titre" class="form-label">Nom Officiel de l'Établissement*</label>
    <input type="text" class="form-control" id="catalogue_titre" name="titre" required>
    <div class="invalid-feedback">Veuillez saisir un titre.</div>
  </div>

<!-- Sélection du secteur d'activité -->
<div class="mb-3">
  <label for="secteur_activite" class="form-label">Secteur d'activité*</label>
  <select class="form-select" id="secteur_activite" name="secteur_activite" required>
    <option value="">Sélectionnez un secteur</option>
    <option value="Agriculture et agroalimentaire (production, transformation, distribution)">Agriculture et agroalimentaire (production, transformation, distribution)</option>
    <option value="Industrie (manufacture, textile, automobile, chimie)">Industrie (manufacture, textile, automobile, chimie)</option>
    <option value="Commerce et distribution (boutiques, supermarchés, import-export)">Commerce et distribution (boutiques, supermarchés, import-export)</option>
    <option value="Transport et logistique (fret, livraison, aérien, maritime)">Transport et logistique (fret, livraison, aérien, maritime)</option>
    <option value="BTP et immobilier (construction, architecture, ingénierie, agences immobilières)">BTP et immobilier (construction, architecture, ingénierie, agences immobilières)</option>
    <option value="Énergie et environnement (énergies renouvelables, pétrole, gestion des déchets)">Énergie et environnement (énergies renouvelables, pétrole, gestion des déchets)</option>
    <option value="Technologie et numérique (informatique, télécommunications, intelligence artificielle)">Technologie et numérique (informatique, télécommunications, intelligence artificielle)</option>
    <option value="Finance et assurance (banques, microfinance, assurances)">Finance et assurance (banques, microfinance, assurances)</option>
    <option value="Santé et bien-être (hôpitaux, pharmacies, cosmétiques)">Santé et bien-être (hôpitaux, pharmacies, cosmétiques)</option>
    <option value="Éducation et formation (écoles, universités, formations professionnelles)">Éducation et formation (écoles, universités, formations professionnelles)</option>
    <option value="Tourisme et loisirs (hôtellerie, restauration, évènementiel)">Tourisme et loisirs (hôtellerie, restauration, évènementiel)</option>
    <option value="Arts, culture et médias (cinéma, musique, presse, publicité)">Arts, culture et médias (cinéma, musique, presse, publicité)</option>
    <option value="Services aux entreprises (consulting, marketing, sécurité)">Services aux entreprises (consulting, marketing, sécurité)</option>
  </select>
  <div class="invalid-feedback">Veuillez sélectionner un secteur.</div>
</div>
  <!-- Description -->
  <div class="mb-3">
    <label for="catalogue_description" class="form-label">Courte Description de votre Ets*</label>
    <textarea class="form-control" id="catalogue_description" name="description" rows="3" required></textarea>
    <div class="invalid-feedback">Veuillez saisir une description.</div>
  </div>

  <!-- Logo -->
  <div class="mb-3">
    <label for="catalogue_logo" class="form-label">Logo</label>
    <input type="file" class="form-control" id="catalogue_logo" name="logo" accept="image/*">
  </div>

  <!-- Localisation -->
  <div class="mb-3">
    <label for="catalogue_localisation" class="form-label">Localisation</label>
    <input type="text" class="form-control" id="catalogue_localisation" name="localisation">
  </div>

  <!-- Nombre d'activités -->
  <div class="mb-3">
    <label for="catalogue_nb_activites" class="form-label">Nombre d'activités</label>
    <select class="form-select" id="catalogue_nb_activites" name="nb_activites" onchange="afficherActivites()">
      <option value="">Sélectionner...</option>
      <option value="1">1 activité</option>
      <option value="2">2 activités</option>
      <option value="3">3 activités</option>
      <option value="4">4 activités</option>
    </select>
  </div>

  <!-- Activités dynamiques -->
  <div id="activites_container">
    <!-- Les champs seront ajoutés ici par le JavaScript -->
  </div>

  <!-- Autres infos -->
  <div class="mb-3">
    <label for="catalogue_autres" class="form-label">Autres informations</label>
    <textarea class="form-control" id="catalogue_autres" name="autres" rows="2"></textarea>
  </div>

  <!-- Image -->
  <div class="mb-3">
    <label for="catalogue_image" class="form-label">Image en arrière-plan</label>
    <input type="file" class="form-control" id="catalogue_image" name="image" accept="image/*">
  </div>

</div>

<script>
  function afficherActivites() {
    const container = document.getElementById("activites_container");
    const nombre = parseInt(document.getElementById("catalogue_nb_activites").value);
    container.innerHTML = "";

    const labels = ["principale", "secondaire", "tertiaire", "quaternaire"];

    for (let i = 0; i < nombre; i++) {
      const type = labels[i] || `activite_${i + 1}`;
      const activiteHTML = `
        <div class="mb-3">
          <label for="catalogue_activite_${type}" class="form-label">Activité ${type}</label>
          <input type="text" class="form-control" id="catalogue_activite_${type}" name="activite_${type}">
        </div>
        <div class="mb-3">
          <label for="catalogue_desc_activite_${type}" class="form-label">Description de l'activité ${type}</label>
          <textarea class="form-control" id="catalogue_desc_activite_${type}" name="desc_activite_${type}" rows="3"></textarea>
        </div>
      `;
      container.innerHTML += activiteHTML;
    }
  }
</script>


             <div class="modal-footer">
               <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
               <button type="submit" class="btn btn-primary submit-btn" id="submitCatalogue">Enregistrer</button>
             </div>
           </form>
         </div>
       </div>
     </div>


    <!-- Toast Container -->
    <div class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index: 1100"> {{-- Ensure high z-index --}}
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

    <!-- Bootstrap Bundle JS (includes Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // --- Initialize Bootstrap Tooltips --- (Important for icons etc)
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })

        // --- Sidebar Toggle --- (Make sure IDs match header/sidebar partials)
        const sidebar = document.getElementById('sidebar');
        const mainContent = document.getElementById('main-content');
        const toggleButton = document.getElementById('toggle-sidebar-btn');

        // Function to check screen size and apply initial collapse
        const checkSidebarCollapse = () => {
            if (window.innerWidth <= 768) { // Matches CSS breakpoint
                sidebar?.classList.add('collapsed');
                mainContent?.classList.add('collapsed');
            } else {
                 // Optional: remove collapsed class on larger screens if you want it expanded by default
                 // sidebar?.classList.remove('collapsed');
                 // mainContent?.classList.remove('collapsed');
            }
        };

        // Initial check
        checkSidebarCollapse();
        // Check on resize
        window.addEventListener('resize', checkSidebarCollapse);

        if (toggleButton && sidebar && mainContent) {
            toggleButton.addEventListener('click', () => {
                sidebar.classList.toggle('collapsed');
                mainContent.classList.toggle('collapsed');
                // Optional: Save state in localStorage
                // localStorage.setItem('sidebarCollapsed', sidebar.classList.contains('collapsed'));
            });
        }
         // Optional: Restore sidebar state from localStorage on load
         /*
         if (localStorage.getItem('sidebarCollapsed') === 'true' && window.innerWidth > 768) {
             sidebar?.classList.add('collapsed');
             mainContent?.classList.add('collapsed');
         }
         */

        // --- Tab System --- (Make sure class names match dashboard content)
        const tabs = document.querySelectorAll('.tab');
        const tabContents = document.querySelectorAll('.tab-content');

        tabs.forEach(tab => {
            tab.addEventListener('click', (e) => {
                e.preventDefault(); // Prevent potential default button actions
                const targetContentId = tab.getAttribute('aria-controls');
                const targetContent = document.getElementById(targetContentId);

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
                if(targetContent) {
                    targetContent.classList.add('active');
                }
     });
        });

        // Optional: Restore active tab based on URL hash or localStorage
        const activateTabFromStorageOrHash = () => {
            let activeTabId = localStorage.getItem('activeDashboardTab');
            if (window.location.hash) {
                activeTabId = window.location.hash.substring(1); // Get tab ID from hash
            }

            if (activeTabId) {
                const activeTab = document.querySelector(`.tab[data-tab="${activeTabId}"]`);
                if (activeTab) {
                    activeTab.click(); // Simulate click to activate
                } else {
                    // Fallback to the first tab if stored/hashed tab not found
                    const firstTab = document.querySelector('.tab');
                    if (firstTab) firstTab.click();
                }
            } else {
                 // Activate the first tab by default if nothing stored/hashed
                const firstTab = document.querySelector('.tab');
                if (firstTab) firstTab.click();
            }
        };
 const successToastElement = document.getElementById('successToast');
        const errorToastElement = document.getElementById('errorToast');
        const successToastMessageEl = document.getElementById('successToastMessage');
        const errorToastMessageEl = document.getElementById('errorToastMessage');
        const successToast = successToastElement ? new bootstrap.Toast(successToastElement) : null;
        const errorToast = errorToastElement ? new bootstrap.Toast(errorToastElement) : null;

        // Select all forms within modals intended for AJAX submission
        const ajaxForms = document.querySelectorAll('.modal form.needs-validation');

        ajaxForms.forEach(form => {
            const modalElement = form.closest('.modal');
            // Ensure modalInstance is correctly initialized for hiding later
            const modalInstance = modalElement ? bootstrap.Modal.getOrCreateInstance(modalElement) : null;
            const submitBtn = form.querySelector('.submit-btn');

            if (form && submitBtn && modalInstance) {
                 // Add specific validation listeners if needed (like event dates)
                 if (form.id === 'eventForm') {
                    initEventDateValidation(form);
                 }

                form.addEventListener('submit', function(event) {
                    event.preventDefault();
                    event.stopPropagation(); // Stop propagation to prevent other listeners

                    submitAjaxForm(form, submitBtn, modalInstance);
                });
            }
        });

        // --- Event Date Validation Logic ---
        function initEventDateValidation(form) {
            const startDateInput = form.querySelector('#event_start_date');
            const endDateInput = form.querySelector('#event_end_date');

            if (!startDateInput || !endDateInput) return;

            const validateEndDate = () => {
                endDateInput.setCustomValidity(''); // Clear previous custom validity
                endDateInput.classList.remove('is-invalid'); // Clear explicit invalid state

                if (startDateInput.value && endDateInput.value) {
                    if (new Date(endDateInput.value) <= new Date(startDateInput.value)) {
                        endDateInput.setCustomValidity('La date de fin doit être strictement postérieure à la date de début.');
                    }
                }
                // Let the browser handle the final validation check based on custom validity and attributes
            };

            startDateInput.addEventListener('change', () => {
                 if (startDateInput.value) {
                     // Setting min directly might conflict with datetime-local display in some browsers
                     // Instead, rely on validation check
                     // endDateInput.min = startDateInput.value;
                 }
                 validateEndDate(); // Validate end date whenever start date changes
            });
            endDateInput.addEventListener('change', validateEndDate);
            endDateInput.addEventListener('input', validateEndDate); // Also check on input for immediate feedback
        }


        // --- Generic AJAX Form Submission Function ---
        function submitAjaxForm(form, submitBtn, modalInstance) {
            // Re-validate specifically for the event end date logic if applicable
            if (form.id === 'eventForm') {
                const endDateInput = form.querySelector('#event_end_date');
                if (endDateInput) initEventDateValidation(form); // Run the validation logic again
            }

            // Use Bootstrap's built-in validation check
            if (!form.checkValidity()) {
                form.classList.add('was-validated');
                // Find first invalid field and focus (optional)
                const firstInvalid = form.querySelector(':invalid, .is-invalid');
                if(firstInvalid) firstInvalid.focus();
                return;
            }

            const formData = new FormData(form);
            const url = form.action;
            const method = form.method.toUpperCase();
            const originalBtnContent = submitBtn.innerHTML;
            // Retrieve CSRF token from meta tag (ensure meta tag exists in <head>)
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

            // Disable button and show loading state
            submitBtn.disabled = true;
            submitBtn.innerHTML = `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Enregistrement...`;

            fetch(url, {
                method: method,
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': csrfToken, // Crucial for Laravel
                    'Accept': 'application/json', // Expect JSON response
                    'X-Requested-With': 'XMLHttpRequest' // Identify as AJAX
                }
            })
            .then(response => {
                 // Check if response is ok (status in the range 200-299)
                 if (!response.ok) {
                     // Attempt to parse JSON error body for Laravel validation errors
                     return response.json().then(errData => {
                         // Create an error object containing the parsed data and the status
                         const error = new Error(response.statusText || "Erreur serveur");
                         error.response = response; // Attach the full response
                         error.data = errData;      // Attach the parsed error data (like validation messages)
                         throw error;               // Throw the enhanced error object
                     }).catch(() => {
                         // If JSON parsing fails, throw a generic error with status
                         const error = new Error(`Erreur HTTP ${response.status}: ${response.statusText || 'Inconnue'}`);
                         error.response = response;
                         throw error;
                     });
                 }
                 // If response is ok, parse JSON body (assuming success returns JSON)
                 return response.json();
            })
            .then(data => {
                // --- Success --- 
                form.reset();
                form.classList.remove('was-validated');
                modalInstance.hide();

                if (successToast && successToastMessageEl) {
                    successToastMessageEl.textContent = data.message || 'Opération effectuée avec succès !'; // Use message from server if available
                    successToast.show();
                }

              console.log("Success Data:", data);
                 // Trigger a custom event that specific pages can listen for to update content
                 document.dispatchEvent(new CustomEvent('form-success', { detail: { formId: form.id, data: data } }));

                 // Simple Reload (uncomment if partial update is too complex for now)
                  // location.reload();
            })
            .catch(error => {
                // --- Error --- 
                console.error("AJAX Error:", error);
                let displayMessage = "Une erreur inattendue s'est produite.";

                // Check if it's our enhanced error with parsed data (Laravel validation)
                if (error.data && error.data.errors) {
                    const firstErrorKey = Object.keys(error.data.errors)[0];
                    displayMessage = error.data.errors[firstErrorKey][0] || 'Veuillez vérifier les champs.';
                } else if (error.message) {
                    // Use message from generic Error or the status text
                    displayMessage = error.message;
                }

                if (errorToast && errorToastMessageEl) {
                    errorToastMessageEl.textContent = displayMessage;
                    errorToast.show();
                } else {
                    alert("Erreur: " + displayMessage); // Fallback
                }
                 // Re-enable validation feedback on the form for the user to see errors
                form.classList.add('was-validated');
            })
            .finally(() => {
                // --- Finally --- (runs after success or error)
                // Restore button state
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalBtnContent;
            });
        }

        // Listener for custom event to handle UI updates after successful AJAX form submissions
        document.addEventListener('form-success', function(e) {
            console.log('Form Success Event:', e.detail);
            const { formId, data } = e.detail;

            // Example: Reload the page for any successful modal submission for now
            // More specific updates could be implemented here based on formId
            if (formId === 'eventForm' || formId === 'etudiantForm' || formId === 'entrepriseForm' || formId === 'recrutementForm' || formId === 'actualiteForm' || formId === 'catalogueForm') {
                console.log(`Reloading page after ${formId} success...`);
                location.reload(); // Simple solution for now
            }
        });

    }); // End DOMContentLoaded
    </script>

    @stack('scripts') {{-- Placeholder for page-specific JS --}}

</body>
</html> 