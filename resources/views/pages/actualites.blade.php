@extends('layouts.layout')
@section('title', 'StagesBENIN - Marchés Publics et Privés')
@section('content')
<div class="container-fluid py-5">
    <div class="row mb-5">
        <div class="col-12">
            <h6 class="display-4 fw-bold text-center position-relative">
                <span class="text-primary">Liste des marchés publics et privés</span>
                <span class="position-absolute start-50 translate-middle-x" style="bottom: -15px; width: 80px; height: 4px; background-color: var(--bs-primary);"></span>
            </h6>
        </div>
    </div>

    <!-- Filtres et recherche -->
    <div class="row mb-4">
        <div class="col-lg-4 mb-3 mb-lg-0">
            <div class="input-group shadow-sm rounded-pill overflow-hidden">
                <input type="text" class="form-control border-0 py-3" id="searchMarket" placeholder="Rechercher par titre, autorité...">
                <button class="btn btn-primary px-4" type="button" id="searchButton">
                    <i class="bi bi-search me-2"></i>Rechercher
                </button>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="row g-2">
                <div class="col-md-4">
                    <select class="form-select border-0 shadow-sm rounded-pill py-3" id="filterCategory">
                        <option value="">Toutes les Catégories</option>
                        <option value="appel_offre">Appel d'Offre</option>
                        <option value="avis_attribution">Avis d'Attribution</option>
                        <option value="manifestation_interet">Avis de Manifestation d'Intérêt</option>
                        <option value="resultats">Résultats</option>
                        <option value="autre_publication">Autre Publication</option>
                    </select>
                </div>
                <div class="col-md-4">
                     <select class="form-select border-0 shadow-sm rounded-pill py-3" id="filterStatus">
                        <option value="">Tous les statuts</option>
                        <option value="published">En cours</option> {{-- Modifié selon votre indication --}}
                        <option value="cloture">Clôturé</option>   {{-- ou 'closed' si c'est la valeur en BDD --}}
                    </select>
                </div>
                <div class="col-md-4">
                    <select class="form-select border-0 shadow-sm rounded-pill py-3" id="filterYear">
                        <option value="">Toutes les Années</option>
                        @php
                            $currentYear = date('Y');
                            $startYear = $currentYear; // ou 2024 comme demandé
                            $endYear = $currentYear + 6; // 2030 si currentYear est 2024
                            for ($year = $endYear; $year >= $startYear; $year--) {
                                echo "<option value=\"{$year}\">{$year}</option>";
                            }
                        @endphp
                    </select>
                </div>
            </div>
        </div>
    </div>

    <!-- Tableau des marchés -->
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                <div class="card-header bg-white py-3 border-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 text-primary fw-bold">
                            <i class="bi bi-list-ul me-2"></i>Tous les marchés
                        </h5>
                        <div class="action-buttons">
                            {{-- Bouton "Télécharger la liste" retiré --}}
                            <button class="btn btn-sm btn-outline-info rounded-pill" id="sharePageButton" data-bs-toggle="modal" data-bs-target="#shareModal">
                                <i class="bi bi-share-fill me-2"></i>Partager cette page
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0" id="marchesTable">
                            <thead class="table-light">
                                <tr>
                                    <th class="py-3 ps-4">Titre</th>
                                    <th class="py-3">Autorité Contractante</th>
                                    <th class="py-3">Type Publication</th>
                                    <th class="py-3">Montant</th>
                                    <th class="py-3">Mode Passation</th>
                                    <th class="py-3">Date Publication</th>
                                    <th class="py-3">Statut</th>
                                    <th class="py-3 text-center">Détails</th> {{-- Colonne renommée --}}
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $categoryDisplayNames = [
                                        'appel_offre' => "Appel d'Offre",
                                        'avis_attribution' => "Avis d'Attribution",
                                        'manifestation_interet' => "Avis de Manifestation d'Intérêt",
                                        'resultats' => "Résultats",
                                        'autre_publication' => "Autre Publication",
                                    ];
                                @endphp
                                @forelse($actualites as $index => $marche)
                                <tr class="marche-row"
                                    data-category="{{ $marche->categorie }}"
                                    data-status="{{ $marche->status }}"
                                    data-date="{{ $marche->date_publication->format('Y-m-d') }}">
                                    <td class="py-3 ps-4">
                                        <div class="d-flex align-items-center">
                                            <div class="category-icon me-3">
                                                @if(in_array($marche->categorie, ['appel_offre', 'manifestation_interet']))
                                                <div class="icon-circle bg-primary bg-opacity-10 text-primary"><i class="bi bi-bullhorn"></i></div>
                                                @elseif(in_array($marche->categorie, ['avis_attribution', 'resultats']))
                                                <div class="icon-circle bg-success bg-opacity-10 text-success"><i class="bi bi-patch-check"></i></div>
                                                @else
                                                <div class="icon-circle bg-secondary bg-opacity-10 text-secondary"><i class="bi bi-file-earmark-text"></i></div>
                                                @endif
                                            </div>
                                            <div>
                                                <h6 class="mb-1 fw-semibold">{{ Str::limit($marche->titre, 40) }}</h6>
                                                <span class="badge bg-info-subtle text-info-emphasis rounded-pill">
                                                    {{ $categoryDisplayNames[$marche->categorie] ?? Str::ucfirst(str_replace('_', ' ', $marche->categorie)) }}
                                                </span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-3">{{ $marche->autorite_contractante }}</td>
                                    <td class="py-3">{{ $marche->type_marche }}</td>
                                    <td class="py-3">
                                        <span class="fw-bold">{{ $marche->montant ? number_format($marche->montant, 0, ',', ' ') . ' FCFA' : 'N/A' }}</span>
                                    </td>
                                    <td class="py-3">{{ $marche->mode_passation }}</td>
                                    <td class="py-3">{{ $marche->date_publication->format('d/m/Y') }}</td>
                                    <td class="py-3">
                                        @if($marche->status == 'published') {{-- Modifié --}}
                                        <span class="badge bg-success-subtle text-success px-3 py-2 rounded-pill"><i class="bi bi-clock-history me-1"></i>En cours</span>
                                        @else
                                        <span class="badge bg-danger-subtle text-danger px-3 py-2 rounded-pill"><i class="bi bi-calendar-check me-1"></i>Clôturé</span>
                                        @endif
                                    </td>
                                    <td class="py-3 text-center">
                                        {{-- Bouton Détails simplifié, sans dropdown --}}
                                        <button type="button" class="btn btn-sm btn-outline-primary rounded-pill details-btn"
                                                title="Voir les détails"
                                                data-bs-toggle="collapse"
                                                data-bs-target="#details-{{ $marche->id }}"
                                                aria-expanded="false"
                                                aria-controls="details-{{ $marche->id }}">
                                            <i class="bi bi-eye-fill"></i>
                                        </button>
                                    </td>
                                </tr>
                                {{-- NOUVELLE STRUCTURE POUR LA LIGNE DE DÉTAILS AVEC SOUS-TABLEAU --}}
                                <tr class="collapse details-row" id="details-{{ $marche->id }}">
                                    <td colspan="8" class="p-0">
                                        <div class="p-3 bg-light-subtle border-top"> {{-- bg-light-subtle pour un fond doux, border-top pour séparation --}}
                                            <h6 class="text-primary mb-3"><i class="bi bi-info-circle-fill me-2"></i>Détails et Actions : <span class="fw-normal">{{ $marche->titre }}</span></h6>
                                            <table class="table table-sm table-bordered table-detail-view mb-3">
                                                <tbody>
                                                    <tr>
                                                        <th style="width: 25%;" class="bg-white">Type de Marché</th>
                                                        <td class="bg-white">{{ $marche->type_marche ?? 'Non spécifié' }}</td>
                                                    </tr>
                                                     <tr>
                                                        <th class="bg-white">Catégorie de Publication</th>
                                                        <td class="bg-white">{{ $categoryDisplayNames[$marche->categorie] ?? Str::ucfirst(str_replace('_', ' ', $marche->categorie)) }}</td>
                                                    </tr>
                                                    @if($marche->details)
                                                    <tr>
                                                        <th class="bg-white">Description détaillée</th>
                                                        <td class="bg-white">
                                                            <div class="details-content">{!! nl2br(e($marche->details)) !!}</div>
                                                        </td>
                                                    </tr>
                                                    @endif
                                                    @if($marche->document_contenu)
                                                    <tr>
                                                        <th class="bg-white">Contenu du Document (Extrait)</th>
                                                        <td class="bg-white">
                                                            <div class="document-content-extrait">{!! nl2br(e(Str::limit($marche->document_contenu, 1000))) !!}</div>
                                                        </td>
                                                    </tr>
                                                    @endif
                                                    {{-- Placeholder pour "gestion" --}}
                                                    {{--
                                                    @if(isset($marche->gestion_info) && $marche->gestion_info)
                                                    <tr>
                                                        <th class="bg-white">Informations de Gestion</th>
                                                        <td class="bg-white">{{ $marche->gestion_info }}</td>
                                                    </tr>
                                                    @endif
                                                    --}}
                                                </tbody>
                                            </table>

                                            <div class="d-flex justify-content-start flex-wrap gap-2">
                                                <button class="btn btn-sm btn-primary share-btn-item" data-bs-toggle="modal" data-bs-target="#shareModal" data-id="{{ $marche->id }}" data-title="{{ $marche->titre }}">
                                                    <i class="bi bi-share-fill me-1"></i> Partager
                                                </button>
                                                @if($marche->document_path)
                                                <a class="btn btn-sm btn-danger" href="{{ asset('documents/' . $marche->document_path) }}" download="{{ $marche->document_titre ?? Str::slug($marche->titre) . '.pdf' }}">
                                                    <i class="bi bi-file-earmark-pdf-fill me-1"></i> Télécharger PDF
                                                </a>
                                                @endif
                                                <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#contactModal" data-id="{{ $marche->id }}">
                                                    <i class="bi bi-chat-dots-fill me-1"></i> Contacter
                                                </button>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="text-center py-5">
                                        <div class="empty-state">
                                            <i class="bi bi-folder2-open display-4 text-muted mb-3"></i>
                                            <h5>Aucun marché disponible</h5>
                                            <p class="text-muted">Aucun marché ne correspond à vos critères de recherche ou aucun marché n'a été publié.</p>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer bg-white py-3 border-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="text-muted small">
                            Affichage de <span class="fw-semibold">{{ $actualites->firstItem() ?? 0 }}</span> à
                            <span class="fw-semibold">{{ $actualites->lastItem() ?? 0 }}</span> sur
                            <span class="fw-semibold">{{ $actualites->total() }}</span> marché(s)
                        </div>
                        <div>
                            {{ $actualites->appends(request()->except('page'))->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de partage (inchangé) -->
<div class="modal fade" id="shareModal" tabindex="-1" aria-labelledby="shareModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow rounded-4">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title" id="shareModalLabel">Partager</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pt-0">
                <p class="text-muted small mb-4" id="shareTitle">Partagez ce contenu avec vos contacts.</p>
                <div class="share-options d-flex flex-wrap gap-2 justify-content-center">
                    <button class="btn btn-lg btn-outline-primary share-social" data-type="facebook"><i class="bi bi-facebook"></i></button>
                    <button class="btn btn-lg btn-outline-info share-social" data-type="twitter"><i class="bi bi-twitter"></i></button>
                    <button class="btn btn-lg btn-outline-success share-social" data-type="whatsapp"><i class="bi bi-whatsapp"></i></button>
                    <button class="btn btn-lg btn-outline-primary share-social" data-type="linkedin"><i class="bi bi-linkedin"></i></button>
                    <button class="btn btn-lg btn-outline-secondary share-social" data-type="email"><i class="bi bi-envelope"></i></button>
                </div>
                <div class="mt-4">
                    <div class="input-group">
                        <input type="text" class="form-control" id="shareLink" readonly>
                        <button class="btn btn-primary" id="copyLink"><i class="bi bi-clipboard me-2"></i>Copier</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de contact (inchangé) -->
<div class="modal fade" id="contactModal" tabindex="-1" aria-labelledby="contactModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow rounded-4">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="contactModalLabel">Contacter l'autorité contractante</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="contactForm">
                    <div class="mb-3"><label for="name" class="form-label">Nom complet</label><input type="text" class="form-control" id="name" placeholder="Votre nom complet"></div>
                    <div class="mb-3"><label for="email" class="form-label">Email</label><input type="email" class="form-control" id="email" placeholder="votre@email.com"></div>
                    <div class="mb-3"><label for="phone" class="form-label">Téléphone</label><input type="tel" class="form-control" id="phone" placeholder="Votre numéro de téléphone"></div>
                    <div class="mb-3"><label for="message" class="form-label">Message</label><textarea class="form-control" id="message" rows="4" placeholder="Votre message concernant ce marché..."></textarea></div>
                    <input type="hidden" id="marcheId" value="">
                </form>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-outline-secondary rounded-pill px-4" data-bs-dismiss="modal">Annuler</button>
                <button type="button" class="btn btn-primary rounded-pill px-4" id="sendContactForm"><i class="bi bi-send me-2"></i>Envoyer</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
@parent
<style>
    /* ... (Styles généraux et pour le tableau principal conservés) ... */
    .table thead th { font-weight: 600; letter-spacing: 0.5px; font-size: 0.85rem; text-transform: uppercase; color: #6c757d; }
    .table tbody tr.marche-row { transition: background-color 0.2s ease; }
    .table tbody tr.marche-row:hover { background-color: rgba(var(--bs-primary-rgb), 0.03); }
    .icon-circle { width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.25rem; }

    @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
    .marche-row { animation: fadeIn 0.4s ease forwards; animation-delay: calc(var(--row-index, 0) * 0.04s); opacity: 0; }

    /* Styles pour la ligne de détails (sous-tableau) */
    .details-row td {
        border-top: none !important; /* Enlève la bordure supérieure par défaut de la cellule de la ligne de détails */
        padding: 0 !important; /* Important pour que le div interne prenne toute la place */
    }
    .details-row .bg-light-subtle {
        background-color: var(--bs-gray-100) !important; /* Un fond légèrement gris pour la section détails */
    }
    .table-detail-view th {
        font-weight: 600;
        color: var(--bs-emphasis-color);
    }
    .table-detail-view td {
        color: var(--bs-secondary-color);
    }
    .details-content, .document-content-extrait {
        white-space: pre-wrap; /* Conserve les espaces et retours à la ligne */
        font-size: 0.9rem;
        line-height: 1.6;
    }
    .document-content-extrait {
        max-height: 250px; /* Limite la hauteur et ajoute un scroll si besoin */
        overflow-y: auto;
        background-color: var(--bs-white);
        padding: 0.5rem;
        border: 1px solid var(--bs-border-color-translucent);
        border-radius: 0.25rem;
    }

    /* Changement d'icône pour le bouton détails */
    .details-btn .bi-eye-fill::before { content: "\F341"; } /* Oeil ouvert par défaut (Unicode pour bi-eye-fill) */
    .details-btn[aria-expanded="true"] .bi-eye-fill::before { content: "\F340"; } /* Oeil fermé (Unicode pour bi-eye-slash-fill) lorsque détails ouverts */
    .details-btn[aria-expanded="true"] {
        background-color: var(--bs-primary); /* Optionnel: changer la couleur du bouton quand actif */
        border-color: var(--bs-primary);
        color: var(--bs-white);
    }


    /* Share modal styles */
    .share-options .btn-lg { width: 50px; height: 50px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.3rem; transition: all 0.2s ease; }
    .share-options .btn-lg:hover { transform: translateY(-3px); box-shadow: 0 4px 10px rgba(0,0,0,0.1); }
    .share-social[data-type="facebook"]:hover { background-color: #3b5998; border-color: #3b5998; color: white; }
    .share-social[data-type="twitter"]:hover { background-color: #1da1f2; border-color: #1da1f2; color: white; }
    .share-social[data-type="whatsapp"]:hover { background-color: #25d366; border-color: #25d366; color: white; }
    .share-social[data-type="linkedin"]:hover { background-color: #0077b5; border-color: #0077b5; color: white; }
    .share-social[data-type="email"]:hover { background-color: #6c757d; border-color: #6c757d; color: white; }


    @media (max-width: 767.98px) {
        .table thead { display: none; } /* Cacher l'entête sur mobile */
        .table tbody tr.marche-row {
            display: block;
            margin-bottom: 1rem;
            border: 1px solid var(--bs-border-color);
            border-radius: 0.375rem;
            box-shadow: 0 0.125rem 0.25rem rgba(0,0,0,0.075);
        }
        .table tbody tr.marche-row td {
            display: block;
            text-align: right;
            padding-left: 50%; /* Pour l'espace du label */
            position: relative;
            border-top: 1px solid var(--bs-border-color-translucent);
        }
        .table tbody tr.marche-row td:first-child { border-top: 0; }
        .table tbody tr.marche-row td::before {
            content: attr(data-label);
            position: absolute;
            left: 0.75rem;
            width: 45%;
            padding-right: 0.5rem;
            font-weight: 600;
            text-align: left;
            white-space: nowrap;
        }
         /* Ajout des data-label pour l'affichage mobile */
        #marchesTable tbody tr.marche-row td:nth-of-type(1)::before { content: "Titre:"; }
        #marchesTable tbody tr.marche-row td:nth-of-type(2)::before { content: "Autorité:"; }
        #marchesTable tbody tr.marche-row td:nth-of-type(3)::before { content: "Type Pub.:"; }
        #marchesTable tbody tr.marche-row td:nth-of-type(4)::before { content: "Montant:"; }
        #marchesTable tbody tr.marche-row td:nth-of-type(5)::before { content: "Passation:"; }
        #marchesTable tbody tr.marche-row td:nth-of-type(6)::before { content: "Date Pub.:"; }
        #marchesTable tbody tr.marche-row td:nth-of-type(7)::before { content: "Statut:"; }
        #marchesTable tbody tr.marche-row td:nth-of-type(8)::before { content: "Détails:"; }
        #marchesTable tbody tr.marche-row td:nth-of-type(8) { text-align: center; } /* Centrer le bouton détails */
        #marchesTable tbody tr.marche-row td:nth-of-type(8)::before { display:none; } /* Pas de label pour le bouton détails */


        .action-buttons { display: flex; flex-direction: column; gap: 0.5rem; align-items: flex-end;}
        .action-buttons .btn { width: 100%; max-width:250px; align-self: flex-end; }

        /* Styles pour le sous-tableau en mode mobile */
        .details-row td .table-detail-view th,
        .details-row td .table-detail-view td {
            display: block;
            width: 100% !important; /* Forcer la pleine largeur */
            text-align: left !important; /* Aligner le texte à gauche */
        }
        .details-row td .table-detail-view th {
            background-color: var(--bs-gray-200) !important; /* Fond distinct pour les en-têtes */
            padding: 0.5rem;
            border-bottom: none; /* Pas de bordure sous l'en-tête */
        }
         .details-row td .table-detail-view td {
            padding: 0.5rem;
            border-bottom: 1px solid var(--bs-border-color-translucent); /* Ligne de séparation */
        }
    }
</style>
@endsection

@section('scripts')
@parent
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Animation pour les lignes
    const rows = document.querySelectorAll('.marche-row');
    rows.forEach((row, index) => {
        row.style.setProperty('--row-index', index);
    });

    // Initialisation des tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl, { container: 'body' })
    });

    const searchInput = document.getElementById('searchMarket');
    const searchButton = document.getElementById('searchButton');
    const filterCategorySelect = document.getElementById('filterCategory');
    const filterStatusSelect = document.getElementById('filterStatus');
    const filterYearSelect = document.getElementById('filterYear');
    const tableRows = document.querySelectorAll('#marchesTable tbody tr.marche-row');
    const emptyStateRow = document.querySelector('#marchesTable tbody tr:not(.marche-row):not(.details-row)'); // Cible la ligne "aucun résultat"

    function applyFilters() {
        const searchTerm = searchInput.value.toLowerCase().trim();
        const categoryFilter = filterCategorySelect.value;
        const statusFilter = filterStatusSelect.value;
        const yearFilter = filterYearSelect.value;

        let visibleRows = 0;

        tableRows.forEach(row => {
            const title = row.querySelector('h6').textContent.toLowerCase();
            const autorite = row.cells[1].textContent.toLowerCase(); // Assurez-vous que l'index est correct
            const rowCategory = row.dataset.category;
            const rowStatus = row.dataset.status;
            const rowDateStr = row.dataset.date; // e.g., "2023-10-26"

            const matchSearch = searchTerm === '' || title.includes(searchTerm) || autorite.includes(searchTerm);
            const matchCategory = categoryFilter === '' || rowCategory === categoryFilter;
            const matchStatus = statusFilter === '' || rowStatus === statusFilter;
            const matchYear = yearFilter === '' || (rowDateStr && rowDateStr.startsWith(yearFilter));


            if (matchSearch && matchCategory && matchStatus && matchYear) {
                row.style.display = document.documentElement.clientWidth < 768 ? 'block' : ''; // Gérer l'affichage mobile

                // S'assurer que la ligne de détails associée est affichée correctement si elle est ouverte
                const detailsRowId = row.querySelector('.details-btn')?.dataset.bsTarget;
                if (detailsRowId) {
                    const detailsRow = document.querySelector(detailsRowId);
                    if (detailsRow && detailsRow.classList.contains('show')) {
                        // Laisser Bootstrap gérer l'affichage pour 'collapse.show'
                        // Pas besoin de row.nextElementSibling.style.display = ''; ici, Bootstrap le fait
                    }
                }
                visibleRows++;
            } else {
                row.style.display = 'none';
                // Cacher aussi la ligne de détails si elle existe et est ouverte
                const detailsRowId = row.querySelector('.details-btn')?.dataset.bsTarget;
                if (detailsRowId) {
                    const detailsRow = document.querySelector(detailsRowId);
                    if (detailsRow) {
                         detailsRow.classList.remove('show'); // S'assurer que les détails sont aussi cachés
                         detailsRow.style.display = 'none'; // Forcer le masquage
                         const triggerBtn = row.querySelector(`[data-bs-target="${detailsRowId}"]`);
                         if(triggerBtn) triggerBtn.setAttribute('aria-expanded', 'false');
                    }
                }
            }
        });

        if (emptyStateRow) {
            emptyStateRow.style.display = visibleRows === 0 ? '' : 'none';
        }
        adjustMobileDisplay(); // Appeler après filtrage pour s'assurer du bon affichage des lignes visibles
    }

    searchInput.addEventListener('keyup', function(event) {
        if (event.key === 'Enter') applyFilters();
    });
    searchButton.addEventListener('click', applyFilters);
    filterCategorySelect.addEventListener('change', applyFilters);
    filterStatusSelect.addEventListener('change', applyFilters);
    filterYearSelect.addEventListener('change', applyFilters);

    // Gestion du modal de partage
    const shareModalEl = document.getElementById('shareModal');
    const shareModal = bootstrap.Modal.getOrCreateInstance(shareModalEl); // Obtenir/créer instance
    const shareTitleEl = document.getElementById('shareTitle');
    const shareLinkInput = document.getElementById('shareLink');

    // Pour "Partager cette page" (bouton en haut du tableau)
    document.getElementById('sharePageButton')?.addEventListener('click', function() {
        shareTitleEl.textContent = "Partager cette page : " + document.title;
        shareLinkInput.value = window.location.href;
        // Le modal s'ouvre via data-bs-toggle="modal"
    });

    // Pour les boutons "Partager ce marché" DANS LE SOUS-TABLEAU (ligne de détails)
    // Utilisation de la délégation d'événements car ces boutons sont dans des lignes potentiellement cachées/dynamiques
    document.body.addEventListener('click', function(event) {
        const shareButton = event.target.closest('.share-btn-item');
        if (shareButton) {
            const marcheId = shareButton.dataset.id;
            const marcheTitle = shareButton.dataset.title;
            shareTitleEl.textContent = "Partager le marché : " + marcheTitle;
            // Construire l'URL spécifique au marché. Ajustez le chemin si nécessaire.
            shareLinkInput.value = `${window.location.origin}/marches/${marcheId}`; // Exemple d'URL
            // Le modal est déjà ciblé par data-bs-toggle="modal" data-bs-target="#shareModal" sur le bouton
            // shareModal.show(); // Pas nécessaire si data-bs-toggle est utilisé
        }
    });
    
    document.getElementById('copyLink').addEventListener('click', function() {
        shareLinkInput.select();
        navigator.clipboard.writeText(shareLinkInput.value).then(() => {
            this.innerHTML = '<i class="bi bi-check2 me-2"></i>Copié';
            setTimeout(() => { this.innerHTML = '<i class="bi bi-clipboard me-2"></i>Copier'; }, 2000);
        }).catch(err => {
            console.error('Erreur de copie: ', err);
            // Fallback (moins fiable)
            try {
                document.execCommand('copy');
                this.innerHTML = '<i class="bi bi-check2 me-2"></i>Copié (fallback)';
                setTimeout(() => { this.innerHTML = '<i class="bi bi-clipboard me-2"></i>Copier'; }, 2000);
            } catch (e) {
                showToast('Impossible de copier le lien.', 'danger');
            }
        });
    });

    document.querySelectorAll('.share-social').forEach(button => {
        button.addEventListener('click', function() {
            const type = this.dataset.type;
            const url = encodeURIComponent(shareLinkInput.value);
            const title = encodeURIComponent(shareTitleEl.textContent.replace("Partager le marché : ", "")); // Nettoyer titre pour partage
            let shareUrl = '';

            switch(type) {
                case 'facebook': shareUrl = `https://www.facebook.com/sharer/sharer.php?u=${url}`; break;
                case 'twitter': shareUrl = `https://twitter.com/intent/tweet?url=${url}&text=${title}`; break;
                case 'whatsapp': shareUrl = `https://api.whatsapp.com/send?text=${title}%20-%20${url}`; break;
                case 'linkedin': shareUrl = `https://www.linkedin.com/sharing/share-offsite/?url=${url}`; break;
                case 'email': shareUrl = `mailto:?subject=${title}&body=Découvrez ce contenu : ${url}`; break;
            }
            if (shareUrl) window.open(shareUrl, '_blank', 'width=600,height=400,noopener,noreferrer');
        });
    });

    // Gestion du modal de contact
    const contactModalEl = document.getElementById('contactModal');
    const contactModal = bootstrap.Modal.getOrCreateInstance(contactModalEl);

    // Utilisation de l'événement 'shown.bs.modal' pour récupérer le data-id du bouton qui a déclenché le modal
    // Cela fonctionne bien pour les boutons dans les lignes de détails.
    contactModalEl.addEventListener('shown.bs.modal', function (event) {
        const button = event.relatedTarget; // Le bouton qui a déclenché le modal
        if (button && button.dataset.id) {
            const marcheId = button.dataset.id;
            document.getElementById('marcheId').value = marcheId;
            // Optionnel: Mettre à jour le titre du modal ou un placeholder
            // const marcheTitle = button.closest('tr.details-row').querySelector('h6 span.fw-normal').textContent;
            // document.getElementById('contactModalLabel').textContent = `Contacter au sujet de: ${marcheTitle}`;
        }
    });

    document.getElementById('sendContactForm').addEventListener('click', function() {
        this.disabled = true;
        this.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Envoi...';
        // Simuler un envoi
        setTimeout(() => {
            contactModal.hide();
            document.getElementById('contactForm').reset();
            this.disabled = false;
            this.innerHTML = '<i class="bi bi-send me-2"></i>Envoyer';
            showToast('Votre message a été envoyé avec succès !', 'success');
        }, 1500);
    });

    // Ajuster l'affichage des lignes pour mobile
    function adjustMobileDisplay() {
        if (document.documentElement.clientWidth < 768) {
            tableRows.forEach(row => {
                if (row.style.display !== 'none') { // Si la ligne est visible (non filtrée)
                    row.style.display = 'block';
                }
            });
        } else {
             tableRows.forEach(row => {
                if (row.style.display !== 'none') {
                    row.style.display = ''; // Revenir à l'affichage par défaut de la table (tr)
                }
            });
        }
    }
    window.addEventListener('resize', adjustMobileDisplay);
    
    // Appeler applyFilters une fois au chargement pour l'état initial et l'ajustement mobile
    applyFilters(); 
    // adjustMobileDisplay(); // Est appelé à la fin de applyFilters

    // Fonction Toast (inchangée, mais utile)
    function showToast(message, type = 'info') {
        const toastContainer = document.querySelector('.toast-container') || (() => {
            const container = document.createElement('div');
            container.className = 'toast-container position-fixed bottom-0 end-0 p-3';
            container.style.zIndex = "1090"; // Plus haut que les modals Bootstrap (1055, 1060)
            document.body.appendChild(container);
            return container;
        })();
        
        const toastId = 'toast-' + Date.now();
        const toastHTML = `
            <div id="${toastId}" class="toast align-items-center text-bg-${type} border-0" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">${message}</div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>`;
        toastContainer.insertAdjacentHTML('beforeend', toastHTML);
        const toastEl = document.getElementById(toastId);
        const toast = new bootstrap.Toast(toastEl, { delay: 5000 });
        toast.show();
        toastEl.addEventListener('hidden.bs.toast', () => toastEl.remove());
    }
});
</script>
@endsection