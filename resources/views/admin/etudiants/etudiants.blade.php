@extends('layouts.admin.app')

@section('title', 'StagesBENIN')

@push('styles')
<style>
    /* Styles pour améliorer la pagination */
    .pagination {
        display: flex;
        justify-content: center;
        align-items: center;
        margin-top: 1.5rem;
    }
    
    .pagination .page-item {
        margin: 0 2px;
    }
    
    .pagination .page-link {
        border-radius: 4px;
        padding: 0.5rem 0.75rem;
        color: #0d6efd;
        background-color: #fff;
        border: 1px solid #dee2e6;
    }
    
    .pagination .page-item.active .page-link {
        background-color: #0d6efd;
        border-color: #0d6efd;
        color: white;
    }
    
    .pagination .page-link:hover {
        background-color: #e9ecef;
        border-color: #dee2e6;
    }
    
    /* Style pour les lignes en surbrillance lors de la recherche */
    #etudiantTable tbody tr.highlight {
        background-color: rgba(208, 231, 255, 0.5);
        transition: background-color 0.3s ease;
    }

    /* Styles pour les filtres */
    .filters-section {
        background-color: #f8f9fa;
        border-radius: 8px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .filter-group {
        display: flex;
        flex-wrap: wrap;
        gap: 1rem;
        align-items: end;
    }

    .filter-item {
        flex: 1;
        min-width: 200px;
    }

    .filter-item label {
        font-weight: 500;
        margin-bottom: 0.5rem;
        display: block;
    }

    /* Statistiques */
    .stats-container {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
        margin-bottom: 2rem;
    }

    .stat-card {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-radius: 12px;
        padding: 1.5rem;
        text-align: center;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        transition: transform 0.3s ease;
    }

    .stat-card:hover {
        transform: translateY(-5px);
    }

    .stat-card i {
        font-size: 2.5rem;
        margin-bottom: 1rem;
        opacity: 0.8;
    }

    .stat-card h5 {
        margin-bottom: 0.5rem;
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .stat-card p {
        font-size: 2rem;
        font-weight: bold;
        margin: 0;
    }

    /* Différentes couleurs pour chaque carte */
    .stat-card:nth-child(1) {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }

    .stat-card:nth-child(2) {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    }

    .stat-card:nth-child(3) {
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
    }

    .stat-card:nth-child(4) {
        background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
    }

    /* Table responsive */
    .table-container {
        background: white;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }

    /* Animation pour les résultats */
    .fade-in {
        animation: fadeIn 0.5s ease-in;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* Message aucun résultat */
    .no-results {
        text-align: center;
        padding: 3rem;
        color: #6c757d;
    }

    .no-results i {
        font-size: 4rem;
        margin-bottom: 1rem;
        opacity: 0.5;
    }

    /* Style pour les dates */
    .date-range-container {
        display: flex;
        gap: 0.5rem;
        align-items: center;
    }

    .date-range-container input {
        flex: 1;
    }
</style>
@endpush

@section('content')

<div class="tab-content active" id="etudiants-content" role="tabpanel" aria-labelledby="etudiants-tab">
    
    <!-- Barre d'actions -->
    <div class="action-bar d-flex justify-content-between align-items-center mb-4">
        <div class="action-buttons">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#etudiantModal">
                <i class="fas fa-plus-circle me-1"></i> Ajouter Étudiant
            </button>
        </div>
        
        <div class="d-flex gap-2">
            <button type="button" class="btn btn-outline-secondary" id="resetFilters">
                <i class="fas fa-refresh me-1"></i> Réinitialiser
            </button>
            <button type="button" class="btn btn-outline-primary" id="exportBtn">
                <i class="fas fa-download me-1"></i> Exporter
            </button>
        </div>
    </div>

    <!-- Section des filtres -->
    <div class="filters-section">
        <h5 class="mb-3"><i class="fas fa-filter me-2"></i>Filtres et Recherche</h5>
        <div class="filter-group">
            <div class="filter-item">
                <label for="etudiantSearch">Recherche globale</label>
                <div class="input-group">
                    <input type="text" id="etudiantSearch" class="form-control" placeholder="Nom, prénom, téléphone, formation...">
                    <button class="btn btn-outline-secondary" type="button" id="clearSearch">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            
            <div class="filter-item">
                <label for="niveauFilter">Niveau</label>
                <select id="niveauFilter" class="form-select">
                    <option value="">Tous les niveaux</option>
                </select>
            </div>
            
            <div class="filter-item">
                <label for="formationFilter">Formation</label>
                <select id="formationFilter" class="form-select">
                    <option value="">Toutes les formations</option>
                </select>
            </div>
            
            <div class="filter-item">
                <label>Période d'inscription</label>
                <select id="dateFilter" class="form-select mb-2">
                    <option value="">Sélectionner une période</option>
                    <option value="today">Aujourd'hui</option>
                    <option value="yesterday">Hier</option>
                    <option value="week">Cette semaine</option>
                    <option value="last_week">Semaine dernière</option>
                    <option value="month">Ce mois</option>
                    <option value="last_month">Mois dernier</option>
                    <option value="year">Cette année</option>
                    <option value="custom">Période personnalisée</option>
                </select>
                <div id="customDateRange" class="date-range-container d-none">
                    <input type="date" id="dateFrom" class="form-control" placeholder="Du">
                    <span>au</span>
                    <input type="date" id="dateTo" class="form-control" placeholder="Au">
                </div>
            </div>
        </div>
    </div>

    <!-- Statistiques -->
    <div class="stats-container">
        <div class="stat-card">
            <i class="fas fa-users"></i>
            <h5>Total Étudiants</h5>
            <p id="totalStudentsCard">
                @php
                    $totalCount = \App\Models\Etudiant::count();
                @endphp
                {{ $totalCount }}
            </p>
        </div>

        <div class="stat-card">
            <i class="fas fa-user-plus"></i>
            <h5>Inscrits aujourd'hui</h5>
            <p>{{ \App\Models\Etudiant::whereDate('created_at', now()->toDateString())->count() }}</p>
        </div>

        <div class="stat-card">
            <i class="fas fa-calendar-week"></i>
            <h5>Cette semaine</h5>
            <p>{{ \App\Models\Etudiant::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count() }}</p>
        </div>

        <div class="stat-card">
            <i class="fas fa-calendar-alt"></i>
            <h5>Ce mois</h5>
            <p>{{ \App\Models\Etudiant::whereBetween('created_at', [now()->startOfMonth(), now()->endOfMonth()])->count() }}</p>
        </div>
    </div>

    <!-- Résultats et Table -->
    <div class="table-container">
        <div class="p-3 border-bottom bg-light">
            <div class="d-flex justify-content-between align-items-center">
                <h6 class="mb-0">
                    <span id="resultsCount">{{ $etudiants->count() }}</span> étudiant(s) affiché(s)
                    <span id="totalCount" class="text-muted">sur {{ \App\Models\Etudiant::count() }} au total</span>
                </h6>
                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-outline-info btn-sm" id="showAllBtn">
                        <i class="fas fa-eye me-1"></i> Afficher tout
                    </button>
                </div>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0" id="etudiantTable">
                <thead class="table-light">
                    <tr>
                        <th>
                            <div class="d-flex align-items-center">
                                Nom 
                                <button class="btn btn-sm btn-link p-0 ms-1 sort-btn" data-column="nom">
                                    <i class="fas fa-sort"></i>
                                </button>
                            </div>
                        </th>
                        <th>
                            <div class="d-flex align-items-center">
                                Prénom
                                <button class="btn btn-sm btn-link p-0 ms-1 sort-btn" data-column="prenom">
                                    <i class="fas fa-sort"></i>
                                </button>
                            </div>
                        </th>
                        <th>Téléphone</th>
                        <th>
                            <div class="d-flex align-items-center">
                                Niveau
                                <button class="btn btn-sm btn-link p-0 ms-1 sort-btn" data-column="niveau">
                                    <i class="fas fa-sort"></i>
                                </button>
                            </div>
                        </th>
                        <th>
                            <div class="d-flex align-items-center">
                                Formation
                                <button class="btn btn-sm btn-link p-0 ms-1 sort-btn" data-column="formation">
                                    <i class="fas fa-sort"></i>
                                </button>
                            </div>
                        </th>
                        <th>
                            <div class="d-flex align-items-center">
                                Date d'inscription
                                <button class="btn btn-sm btn-link p-0 ms-1 sort-btn" data-column="created_at">
                                    <i class="fas fa-sort"></i>
                                </button>
                            </div>
                        </th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="studentsTableBody">
                    @forelse($etudiants as $etudiant)
                        <tr data-student-id="{{ $etudiant->id }}">
                            <td>{{ $etudiant->nom }}</td>
                            <td>{{ $etudiant->prenom }}</td>
                            <td>{{ $etudiant->telephone ?: '-' }}</td>
                            <td>{{ $etudiant->niveau ?: '-' }}</td>
                            <td>{{ $etudiant->formation ?: '-' }}</td>
                            <td>{{ $etudiant->created_at->format('d/m/Y') }}</td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('admin.etudiants.show', $etudiant->id) }}" 
                                       class="btn btn-info btn-sm" data-bs-toggle="tooltip" title="Voir détails">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <button type="button" class="btn btn-{{ $etudiant->statut == 1 ? 'warning' : 'success' }} btn-sm toggle-status" 
                                        data-id="{{ $etudiant->id }}" data-status="{{ $etudiant->statut }}"
                                        data-bs-toggle="tooltip" 
                                        title="{{ $etudiant->statut == 1 ? 'Bloquer' : 'Débloquer' }}">
                                        <i class="fas fa-{{ $etudiant->statut == 1 ? 'ban' : 'check' }}"></i>
                                    </button>
                                    <button type="button" class="btn btn-danger btn-sm delete-student" 
                                            data-id="{{ $etudiant->id }}" data-bs-toggle="tooltip" title="Supprimer">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr id="noStudentsRow">
                            <td colspan="7" class="text-center py-4">
                                <i class="fas fa-users fa-3x text-muted mb-3"></i>
                                <h5 class="text-muted">Aucun étudiant trouvé</h5>
                                <p class="text-muted">Commencez par ajouter des étudiants.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Message aucun résultat (pour les recherches) -->
        <div id="noResults" class="no-results d-none">
            <i class="fas fa-search"></i>
            <h5>Aucun étudiant trouvé</h5>
            <p>Essayez de modifier vos critères de recherche ou de filtrage.</p>
        </div>

        <!-- Loading spinner -->
        <div id="loadingSpinner" class="text-center p-4 d-none">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Chargement...</span>
            </div>
        </div>
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-4" id="paginationContainer">
        {{ $etudiants->links('pagination::bootstrap-4') }}
    </div>
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Variables globales
    let allStudents = [];
    let filteredStudents = [];
    let currentSort = { column: null, direction: 'asc' };
    let isLoading = false;
    let originalTableData = [];

    // Éléments DOM
    const searchInput = document.getElementById('etudiantSearch');
    const niveauFilter = document.getElementById('niveauFilter');
    const formationFilter = document.getElementById('formationFilter');
    const dateFilter = document.getElementById('dateFilter');
    const dateFrom = document.getElementById('dateFrom');
    const dateTo = document.getElementById('dateTo');
    const customDateRange = document.getElementById('customDateRange');
    const clearSearchBtn = document.getElementById('clearSearch');
    const resetFiltersBtn = document.getElementById('resetFilters');
    const showAllBtn = document.getElementById('showAllBtn');
    const tableBody = document.getElementById('studentsTableBody');
    const noResults = document.getElementById('noResults');
    const resultsCount = document.getElementById('resultsCount');
    const loadingSpinner = document.getElementById('loadingSpinner');
    const paginationContainer = document.getElementById('paginationContainer');

    // Fonction pour extraire les données du tableau HTML existant
    function extractTableData() {
        const rows = tableBody.querySelectorAll('tr[data-student-id]');
        originalTableData = Array.from(rows).map(row => {
            const cells = row.querySelectorAll('td');
            const studentId = row.getAttribute('data-student-id');
            
            return {
                id: studentId,
                nom: cells[0]?.textContent.trim() || '',
                prenom: cells[1]?.textContent.trim() || '',
                telephone: cells[2]?.textContent.trim() === '-' ? null : cells[2]?.textContent.trim(),
                niveau: cells[3]?.textContent.trim() === '-' ? null : cells[3]?.textContent.trim(),
                formation: cells[4]?.textContent.trim() === '-' ? null : cells[4]?.textContent.trim(),
                created_at: cells[5]?.textContent.trim() || '',
                statut: row.querySelector('.toggle-status')?.getAttribute('data-status') || '1'
            };
        });

        allStudents = [...originalTableData];
        filteredStudents = [...originalTableData];
        
        // Peupler les options de filtres
        populateFilterOptions();
        
        // Mettre à jour le compteur
        updateResultsCount();
    }

    // Fonction pour charger tous les étudiants via AJAX
    async function loadAllStudents() {
        if (isLoading) return;
        
        isLoading = true;
        showLoading(true);
        
        try {
            const response = await fetch('/admin/etudiants/all-students', {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            });
            
            if (!response.ok) throw new Error('Erreur réseau');
            
            const data = await response.json();
            
            if (data.students && Array.isArray(data.students)) {
                allStudents = data.students;
                filteredStudents = [...allStudents];
                populateFilterOptions();
                updateDisplay();
                paginationContainer.style.display = 'none';
                showToast('Tous les étudiants ont été chargés', 'success');
            } else {
                throw new Error('Format de données invalide');
            }
            
        } catch (error) {
            console.error('Erreur lors du chargement des étudiants:', error);
            showToast('Erreur lors du chargement. Utilisation des données actuelles.', 'warning');
        } finally {
            isLoading = false;
            showLoading(false);
        }
    }

    // Fonction pour peupler les options de filtres
    function populateFilterOptions() {
        // Niveaux uniques
        const niveaux = [...new Set(allStudents.map(s => s.niveau).filter(n => n && n !== '-'))];
        niveauFilter.innerHTML = '<option value="">Tous les niveaux</option>';
        niveaux.forEach(niveau => {
            niveauFilter.innerHTML += `<option value="${niveau}">${niveau}</option>`;
        });

        // Formations uniques
        const formations = [...new Set(allStudents.map(s => s.formation).filter(f => f && f !== '-'))];
        formationFilter.innerHTML = '<option value="">Toutes les formations</option>';
        formations.forEach(formation => {
            formationFilter.innerHTML += `<option value="${formation}">${formation}</option>`;
        });
    }

    // Fonction de debounce
    function debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    }

    // Fonction pour convertir une date au format français en objet Date
    function parseDate(dateStr) {
        if (!dateStr) return new Date();
        
        // Si c'est déjà au format ISO
        if (dateStr.includes('-') && dateStr.length > 8) {
            return new Date(dateStr);
        }
        
        // Si c'est au format dd/mm/yyyy
        const parts = dateStr.split('/');
        if (parts.length === 3) {
            return new Date(parts[2], parts[1] - 1, parts[0]);
        }
        
        return new Date(dateStr);
    }

    // Fonction pour filtrer par date
    function filterByDate(studentDateStr, filterValue, customFrom = null, customTo = null) {
        const studentDate = parseDate(studentDateStr);
        const now = new Date();
        
        switch (filterValue) {
            case 'today':
                return studentDate.toDateString() === now.toDateString();
            
            case 'yesterday':
                const yesterday = new Date(now);
                yesterday.setDate(yesterday.getDate() - 1);
                return studentDate.toDateString() === yesterday.toDateString();
            
            case 'week':
                const weekStart = new Date(now);
                weekStart.setDate(now.getDate() - now.getDay());
                weekStart.setHours(0, 0, 0, 0);
                return studentDate >= weekStart;
            
            case 'last_week':
                const lastWeekStart = new Date(now);
                lastWeekStart.setDate(now.getDate() - now.getDay() - 7);
                lastWeekStart.setHours(0, 0, 0, 0);
                const lastWeekEnd = new Date(lastWeekStart);
                lastWeekEnd.setDate(lastWeekStart.getDate() + 6);
                lastWeekEnd.setHours(23, 59, 59, 999);
                return studentDate >= lastWeekStart && studentDate <= lastWeekEnd;
            
            case 'month':
                return studentDate.getMonth() === now.getMonth() && 
                       studentDate.getFullYear() === now.getFullYear();
            
            case 'last_month':
                const lastMonth = new Date(now.getFullYear(), now.getMonth() - 1, 1);
                const lastMonthEnd = new Date(now.getFullYear(), now.getMonth(), 0);
                return studentDate >= lastMonth && studentDate <= lastMonthEnd;
            
            case 'year':
                return studentDate.getFullYear() === now.getFullYear();
            
            case 'custom':
                if (!customFrom || !customTo) return true;
                const fromDate = new Date(customFrom);
                const toDate = new Date(customTo);
                toDate.setHours(23, 59, 59, 999);
                return studentDate >= fromDate && studentDate <= toDate;
            
            default:
                return true;
        }
    }

    // Fonction principale de filtrage
    function filterStudents() {
        const searchValue = searchInput.value.toLowerCase().trim();
        const niveauValue = niveauFilter.value;
        const formationValue = formationFilter.value;
        const dateValue = dateFilter.value;
        const customFrom = dateFrom.value;
        const customTo = dateTo.value;

        filteredStudents = allStudents.filter(student => {
            // Recherche globale
            if (searchValue) {
                const searchableText = [
                    student.nom || '',
                    student.prenom || '',
                    student.telephone || '',
                    student.niveau || '',
                    student.formation || ''
                ].join(' ').toLowerCase();
                
                if (!searchableText.includes(searchValue)) {
                    return false;
                }
            }

            // Filtre niveau
            if (niveauValue && student.niveau !== niveauValue) {
                return false;
            }

            // Filtre formation
            if (formationValue && student.formation !== formationValue) {
                return false;
            }

            // Filtre date
            if (dateValue) {
                if (!filterByDate(student.created_at, dateValue, customFrom, customTo)) {
                    return false;
                }
            }

            return true;
        });

        updateDisplay();
    }

    // Fonction de tri
    function sortStudents(column) {
        if (currentSort.column === column) {
            currentSort.direction = currentSort.direction === 'asc' ? 'desc' : 'asc';
        } else {
            currentSort.column = column;
            currentSort.direction = 'asc';
        }

        filteredStudents.sort((a, b) => {
            let valueA = a[column] || '';
            let valueB = b[column] || '';

            // Traitement spécial pour les dates
            if (column === 'created_at') {
                valueA = parseDate(valueA);
                valueB = parseDate(valueB);
            }

            if (valueA < valueB) {
                return currentSort.direction === 'asc' ? -1 : 1;
            }
            if (valueA > valueB) {
                return currentSort.direction === 'asc' ? 1 : -1;
            }
            return 0;
        });

        updateSortIcons();
        updateDisplay();
    }

    // Mise à jour des icônes de tri
    function updateSortIcons() {
        document.querySelectorAll('.sort-btn i').forEach(icon => {
            icon.className = 'fas fa-sort';
        });

        if (currentSort.column) {
            const activeButton = document.querySelector(`[data-column="${currentSort.column}"] i`);
            if (activeButton) {
                activeButton.className = `fas fa-sort-${currentSort.direction === 'asc' ? 'up' : 'down'}`;
            }
        }
    }

    // Créer une ligne de tableau pour un étudiant
    function createStudentRow(student) {
        const row = document.createElement('tr');
        row.setAttribute('data-student-id', student.id);
        
        // Formater la date
        let formattedDate = student.created_at;
        if (student.created_at && student.created_at.includes('-')) {
            const date = new Date(student.created_at);
            formattedDate = date.toLocaleDateString('fr-FR');
        }
        
        row.innerHTML = `
            <td>${student.nom || ''}</td>
            <td>${student.prenom || ''}</td>
            <td>${student.telephone || '-'}</td>
            <td>${student.niveau || '-'}</td>
            <td>${student.formation || '-'}</td>
            <td>${formattedDate}</td>
            <td>
                <div class="btn-group" role="group">
                    <a href="/admin/etudiants/${student.id}" 
                       class="btn btn-info btn-sm" data-bs-toggle="tooltip" title="Voir détails">
                        <i class="fas fa-eye"></i>
                    </a>
                    <button type="button" class="btn btn-${student.statut == 1 ? 'warning' : 'success'} btn-sm toggle-status" 
                        data-id="${student.id}" data-status="${student.statut}"
                        data-bs-toggle="tooltip" 
                        title="${student.statut == 1 ? 'Bloquer' : 'Débloquer'}">
                        <i class="fas fa-${student.statut == 1 ? 'ban' : 'check'}"></i>
                    </button>
                    <button type="button" class="btn btn-danger btn-sm delete-student" 
                            data-id="${student.id}" data-bs-toggle="tooltip" title="Supprimer">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </td>
        `;
        return row;
    }

    // Mise à jour de l'affichage
    function updateDisplay() {
        // Masquer le message "aucun étudiant" par défaut
        const noStudentsRow = document.getElementById('noStudentsRow');
        if (noStudentsRow) {
            noStudentsRow.style.display = 'none';
        }

        // Vider le tableau
        tableBody.innerHTML = '';

        if (filteredStudents.length > 0) {
            filteredStudents.forEach((student, index) => {
                const row = createStudentRow(student);
                tableBody.appendChild(row);
                
                // Animation séquentielle
                setTimeout(() => {
                    row.classList.add('fade-in');
                }, index * 10);
            });

            noResults.classList.add('d-none');
            document.querySelector('.table-responsive').style.display = '';
        } else {
            // Si on a appliqué des filtres et qu'il n'y a pas de résultats
            if (isFilterActive()) {
                noResults.classList.remove('d-none');
                document.querySelector('.table-responsive').style.display = 'none';
            } else {
                // Si pas de filtres actifs et pas d'étudiants, afficher le message original
                tableBody.innerHTML = `
                    <tr>
                        <td colspan="7" class="text-center py-4">
                            <i class="fas fa-users fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">Aucun étudiant trouvé</h5>
                            <p class="text-muted">Commencez par ajouter des étudiants.</p>
                        </td>
                    </tr>
                `;
                noResults.classList.add('d-none');
                document.querySelector('.table-responsive').style.display = '';
            }
        }

        updateResultsCount();
        
        // Masquer la pagination si filtrage actif
        if (isFilterActive()) {
            paginationContainer.style.display = 'none';
        } else {
            paginationContainer.style.display = 'flex';
        }

        // Réinitialiser les tooltips
        initializeTooltips();
    }

    // Mettre à jour le compteur de résultats
    function updateResultsCount() {
        resultsCount.textContent = filteredStudents.length;
    }

    // Vérifier si un filtre est actif
    function isFilterActive() {
        return searchInput.value.trim() !== '' ||
               niveauFilter.value !== '' ||
               formationFilter.value !== '' ||
               dateFilter.value !== '';
    }

    // Réinitialiser les filtres
    function resetFilters() {
        searchInput.value = '';
        niveauFilter.value = '';
        formationFilter.value = '';
        dateFilter.value = '';
        dateFrom.value = '';
        dateTo.value = '';
        customDateRange.classList.add('d-none');
        currentSort = { column: null, direction: 'asc' };
        
        filteredStudents = [...allStudents];
        updateSortIcons();
        updateDisplay();
        
        showToast('Filtres réinitialisés', 'info');
    }

    // Afficher/masquer le loading
    function showLoading(show) {
        if (show) {
            loadingSpinner.classList.remove('d-none');
        } else {
            loadingSpinner.classList.add('d-none');
        }
    }

    // Export des données
    function exportData() {
        if (filteredStudents.length === 0) {
            showToast('Aucune donnée à exporter', 'warning');
            return;
        }

        const csvContent = "data:text/csv;charset=utf-8," + 
            "Nom,Prénom,Téléphone,Niveau,Formation,Date d'inscription\n" +
            filteredStudents.map(student => {
                const date = student.created_at && student.created_at.includes('-') 
                    ? new Date(student.created_at).toLocaleDateString('fr-FR')
                    : student.created_at || '';
                    
                return [
                    `"${student.nom || ''}"`,
                    `"${student.prenom || ''}"`,
                    `"${student.telephone || ''}"`,
                    `"${student.niveau || ''}"`,
                    `"${student.formation || ''}"`,
                    `"${date}"`
                ].join(',');
            }).join('\n');

        const encodedUri = encodeURI(csvContent);
        const link = document.createElement("a");
        link.setAttribute("href", encodedUri);
        link.setAttribute("download", `etudiants_${new Date().toISOString().split('T')[0]}.csv`);
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
        
        showToast('Export réalisé avec succès', 'success');
    }

    // Fonction pour afficher les toasts
    function showToast(message, type = 'info') {
        const toast = document.createElement('div');
        const alertClass = type === 'error' ? 'danger' : type;
        toast.className = `alert alert-${alertClass} position-fixed`;
        toast.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
        toast.innerHTML = `
            <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'error' ? 'exclamation-circle' : 'info-circle'} me-2"></i>
            ${message}
            <button type="button" class="btn-close" onclick="this.parentElement.remove()"></button>
        `;
        document.body.appendChild(toast);
        
        setTimeout(() => {
            if (toast.parentElement) {
                toast.remove();
            }
        }, 4000);
    }

    // Gestion des actions AJAX pour les étudiants
    async function toggleStudentStatus(studentId, currentStatus) {
        try {
            showLoading(true);
            const response = await fetch(`/admin/etudiants/toggle-status/${studentId}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content'),
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });

            if (response.ok) {
                // Mettre à jour le statut dans nos données locales
                const student = allStudents.find(s => s.id == studentId);
                if (student) {
                    student.statut = student.statut == 1 ? 0 : 1;
                }
                
                const filteredStudent = filteredStudents.find(s => s.id == studentId);
                if (filteredStudent) {
                    filteredStudent.statut = filteredStudent.statut == 1 ? 0 : 1;
                }
                
                updateDisplay();
                showToast(`Statut de l'étudiant ${currentStatus == 1 ? 'bloqué' : 'activé'}`, 'success');
            } else {
                throw new Error('Erreur de mise à jour');
            }
        } catch (error) {
            console.error('Erreur:', error);
            showToast('Erreur lors de la mise à jour du statut', 'error');
        } finally {
            showLoading(false);
        }
    }

    async function deleteStudent(studentId) {
        try {
            showLoading(true);
            const response = await fetch(`/admin/etudiants/${studentId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content'),
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });

            if (response.ok) {
                // Retirer l'étudiant de nos données locales
                allStudents = allStudents.filter(s => s.id != studentId);
                filteredStudents = filteredStudents.filter(s => s.id != studentId);
                
                updateDisplay();
                showToast('Étudiant supprimé avec succès', 'success');
                
                // Mettre à jour le compteur total
                const totalElement = document.getElementById('totalStudentsCard');
                if (totalElement) {
                    const currentTotal = parseInt(totalElement.textContent) - 1;
                    totalElement.textContent = currentTotal;
                }
            } else {
                throw new Error('Erreur de suppression');
            }
        } catch (error) {
            console.error('Erreur:', error);
            showToast('Erreur lors de la suppression', 'error');
        } finally {
            showLoading(false);
        }
    }

    // Initialiser les tooltips
    function initializeTooltips() {
        // Supprimer les anciens tooltips
        const existingTooltips = document.querySelectorAll('.tooltip');
        existingTooltips.forEach(tooltip => tooltip.remove());
        
        // Initialiser les nouveaux tooltips
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    }

    // Event listeners
    const debouncedFilter = debounce(filterStudents, 300);
    
    searchInput.addEventListener('input', debouncedFilter);
    niveauFilter.addEventListener('change', filterStudents);
    formationFilter.addEventListener('change', filterStudents);
    
    dateFilter.addEventListener('change', function() {
        if (this.value === 'custom') {
            customDateRange.classList.remove('d-none');
        } else {
            customDateRange.classList.add('d-none');
        }
        filterStudents();
    });
    
    dateFrom.addEventListener('change', filterStudents);
    dateTo.addEventListener('change', filterStudents);
    
    clearSearchBtn.addEventListener('click', () => {
        searchInput.value = '';
        filterStudents();
    });
    
    resetFiltersBtn.addEventListener('click', resetFilters);
    showAllBtn.addEventListener('click', loadAllStudents);
    document.getElementById('exportBtn').addEventListener('click', exportData);

    // Event listeners pour le tri
    document.querySelectorAll('.sort-btn').forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            const column = btn.dataset.column;
            sortStudents(column);
        });
    });

    // Event delegation pour les actions sur les étudiants
    tableBody.addEventListener('click', async function(e) {
        if (e.target.closest('.delete-student')) {
            const btn = e.target.closest('.delete-student');
            if (confirm('Êtes-vous sûr de vouloir supprimer cet étudiant ? Cette action est irréversible.')) {
                await deleteStudent(btn.dataset.id);
            }
        }
        
        if (e.target.closest('.toggle-status')) {
            const btn = e.target.closest('.toggle-status');
            const currentStatus = btn.dataset.status;
            const action = currentStatus == 1 ? 'bloquer' : 'débloquer';
            
            if (confirm(`Êtes-vous sûr de vouloir ${action} cet étudiant ?`)) {
                await toggleStudentStatus(btn.dataset.id, currentStatus);
            }
        }
    });

    // Gestion des clics sur les liens de pagination
    paginationContainer.addEventListener('click', function(e) {
        const link = e.target.closest('a');
        if (link && isFilterActive()) {
            e.preventDefault();
            if (confirm('Changer de page va réinitialiser vos filtres. Continuer ?')) {
                resetFilters();
                window.location.href = link.href;
            }
        }
    });

    // Fonction d'initialisation
    function initialize() {
        // Extraire les données du tableau HTML
        extractTableData();
        
        // Initialiser les tooltips
        initializeTooltips();
        
        // Si aucun étudiant n'est présent, afficher le message approprié
        if (allStudents.length === 0) {
            updateDisplay();
        }
        
        console.log(`${allStudents.length} étudiant(s) chargé(s)`);
    }

    // Démarrer l'initialisation
    initialize();
});
</script>
@endpush