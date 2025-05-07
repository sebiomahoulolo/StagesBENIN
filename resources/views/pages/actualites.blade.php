@extends('layouts.layout')
@section('title', 'StagesBENIN')
@section('content')

<!-- Main Content -->
<div class="container-fluid mt-4">
    <div class="row">
        <!-- Filters Sidebar -->
        <div class="col-lg-3 mb-4">
            <div class="filter-sidebar">
                <h5><i class="fas fa-filter me-2"></i>FILTRES</h5>
                <div class="results-count mb-3 ps-2">
                    2 RÉSULTATS
                </div>
                
                <!-- Recherche par mot clé -->
                <div class="filter-group">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control form-control-sm" placeholder="Recherche par mot clé...">
                        <button class="btn btn-sm btn-ok" type="button">OK</button>
                    </div>
                </div>

                <!-- Année de gestion -->
                <div class="filter-group">
                    <label for="anneeGestion">ANNÉE DE GESTION</label>
                    <select class="form-select form-select-sm" id="anneeGestion">
                        <option selected>2025</option>
                        <option>2024</option>
                        <option>2023</option>
                    </select>
                </div>

                <!-- Type d'autorité contractante -->
                <div class="filter-group">
                    <label for="typeAutorite">TYPE D'AUTORITÉ CONTRACTANTE</label>
                    <select class="form-select form-select-sm" id="typeAutorite">
                        <option selected>Choisir...</option>
                    </select>
                </div>
                
                <!-- Autorité contractante -->
                <div class="filter-group">
                    <label for="autoriteContractante">AUTORITÉ CONTRACTANTE</label>
                    <select class="form-select form-select-sm" id="autoriteContractante">
                        <option selected>(CAMO) Programme de Filets de...</option>
                    </select>
                </div>
                
                <!-- Filtrage par montant -->
                <div class="filter-group">
                    <label>MONTANT (CFA)</label>
                    <div class="d-flex justify-content-between mb-2">
                        <small>Min : 1 K</small>
                        <small>Max : 250 G</small>
                    </div>
                    <div class="text-end">
                        <button class="btn btn-sm btn-ok" type="button">OK</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Results Section -->
        <div class="col-lg-9">
            <!-- Vue Liste -->
            <div class="results-container" id="view-list">
                <p class="results-count">(2) résultats</p>
                <div class="list-item-header d-none d-md-flex">
                    <div class="col-md-6">Autorité contractante</div>
                    <div class="col-md-2 text-center">Gestion</div>
                    <div class="col-md-3 text-center">Date de publication</div>
                    <div class="col-md-1 text-center">Détails</div>
                </div>
                
                <!-- Item 1 -->
                <div class="list-item">
                    <div class="col-12 col-md-6">
                        <small class="d-md-none fw-bold">Autorité contractante: </small>
                        (CAMO) Programme de Filets de Protection Sociale Productifs "GBESSOKE"
                    </div>
                    <div class="col-4 col-md-2 text-md-center">
                        <small class="d-md-none fw-bold">Gestion: </small>2025
                    </div>
                    <div class="col-5 col-md-3 text-md-center">
                        <small class="d-md-none fw-bold">Publication: </small>31-03-2025
                    </div>
                    <div class="col-3 col-md-1 text-center">
                        <a href="#" class="details-icon" onclick="showDetailView(event)"><i class="fas fa-eye"></i></a>
                    </div>
                </div>
                
                <!-- Item 2 -->
                <div class="list-item">
                    <div class="col-12 col-md-6">
                        <small class="d-md-none fw-bold">Autorité contractante: </small>
                        Agence Béninoise de Gestion Intégrée des Espaces Frontaliers
                    </div>
                    <div class="col-4 col-md-2 text-md-center">
                        <small class="d-md-none fw-bold">Gestion: </small>2025
                    </div>
                    <div class="col-5 col-md-3 text-md-center">
                        <small class="d-md-none fw-bold">Publication: </small>27-02-2025
                    </div>
                    <div class="col-3 col-md-1 text-center">
                        <a href="#" class="details-icon" onclick="showDetailView(event)"><i class="fas fa-eye"></i></a>
                    </div>
                </div>
            </div>

            <!-- Vue Détaillée -->
            <div class="results-container" id="view-detail" style="display: none;">
                <div class="detail-header-bar">
                    <div>
                        <label for="versionSelect" class="form-label-sm me-2">Version</label>
                        <select class="form-select form-select-sm d-inline-block" id="versionSelect" style="width: auto;">
                            <option selected>Version 2</option>
                            <option>Version 1</option>
                        </select>
                    </div>
                    <div class="legend">
                        <span><span class="badge badge-nouveau"></span> Délai > 3 jours</span>
                        <span><span class="badge badge-modifie"></span> Délai <= 3 jours</span>
                        <span><span class="badge badge-supprime"></span> Délai expiré</span>
                    </div>
                </div>

                <!-- Item de plan détaillé -->
                <div class="plan-item-card">
                    <div class="card-header">
                        CELLULE D'APPUI À LA MISE EN ŒUVRE DU PROGRAMME DE FILETS DE PROTECTION SOCIALE PRODUCTIF "GBESSOKE"
                    </div>
                    <div class="card-body">
                        <div class="status-badge-container">
                            <div class="status-badge">NOUVEAU</div>
                            <a href="#detailsPlan2" class="expand-button" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="detailsPlan2">
                                <i class="fas fa-chevron-down"></i>
                            </a>
                        </div>
                        <p class="plan-title">Acquisition de batteries, de pneus et des bâches pour les véhicules de la Cellule d'Appui à la Mise en Œuvre du programme (CAMO)</p>
                        <div class="info-grid">
                            <div>
                                <strong>Montant</strong>
                                <span>15 322 034 CFA</span>
                            </div>
                            <div>
                                <strong>Type de marché</strong>
                                <span>Fournitures</span>
                            </div>
                            <div>
                                <strong>Mode de passation</strong>
                                <span>Demande de Renseignement et de prix (DRP)</span>
                            </div>
                        </div>
                        <div class="collapse collapsed-details" id="detailsPlan2">
                            <div class="info-grid mt-3">
                                <div>
                                    <strong>Ref</strong>
                                    <span>F_CAMO/GBESSOKE_108451</span>
                                </div>
                                <div>
                                    <strong>Délai d'exécution</strong>
                                    <span>1 Mois</span>
                                </div>
                                <div>
                                    <strong>Source de financement</strong>
                                    <span>BN</span>
                                </div>
                                <div>
                                    <strong>Date de notification du contrat</strong>
                                    <span>-</span>
                                </div>
                                <div>
                                    <strong>Date d'autorisation du lancement du DAO</strong>
                                    <span>19-08-2025</span>
                                </div>
                                <div>
                                    <strong>Date de publication de l'avis par la PRMP</strong>
                                    <span>-</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Boutons d'action -->
                <div class="action-buttons mt-4">
                    <a href="" download class="button">Télécharger le PDF</a>
                    <button class="button share-button" onclick="openShareModal()">Partager</button>
                </div>

                <!-- Bouton de retour -->
                <div class="text-center mt-4">
                    <button class="btn btn-secondary" onclick="showListView()">
                        <i class="fas fa-arrow-left me-2"></i>Retour à la liste
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de partage -->
<div class="modal fade" id="shareModal" tabindex="-1" aria-labelledby="shareModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="shareModalLabel">Partager sur</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="d-flex justify-content-around">
                    <a href="#" onclick="share('facebook')" class="share-link facebook">
                        <i class="fab fa-facebook-f fa-2x"></i>
                        <span>Facebook</span>
                    </a>
                    <a href="#" onclick="share('twitter')" class="share-link twitter">
                        <i class="fab fa-twitter fa-2x"></i>
                        <span>Twitter</span>
                    </a>
                    <a href="#" onclick="share('linkedin')" class="share-link linkedin">
                        <i class="fab fa-linkedin-in fa-2x"></i>
                        <span>LinkedIn</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<!-- Font Awesome -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/js/all.min.js"></script>

<script>
    // Script pour la gestion des vues (liste et détail)
    function showDetailView(event) {
        event.preventDefault();
        document.getElementById('view-list').style.display = 'none';
        document.getElementById('view-detail').style.display = 'block';
        window.scrollTo(0, 0); // Scroll to top
    }

    function showListView() {
        document.getElementById('view-detail').style.display = 'none';
        document.getElementById('view-list').style.display = 'block';
        window.scrollTo(0, 0); // Scroll to top
    }

    // Script pour l'affichage et le partage de la modal
    function openShareModal() {
        var shareModal = new bootstrap.Modal(document.getElementById('shareModal'));
        shareModal.show();
    }

    function share(platform) {
        // Logique de partage (à implémenter selon les besoins réels)
        console.log("Partage sur " + platform);
        
        // URL actuelle à partager
        const url = window.location.href;
        const title = "StagesBENIN - Détails du marché public";
        
        // Configurations selon la plateforme
        let shareUrl;
        switch(platform) {
            case 'facebook':
                shareUrl = `https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(url)}`;
                break;
            case 'twitter':
                shareUrl = `https://twitter.com/intent/tweet?url=${encodeURIComponent(url)}&text=${encodeURIComponent(title)}`;
                break;
            case 'linkedin':
                shareUrl = `https://www.linkedin.com/sharing/share-offsite/?url=${encodeURIComponent(url)}`;
                break;
        }
        
        // Ouvrir dans une nouvelle fenêtre
        if (shareUrl) {
            window.open(shareUrl, '_blank', 'width=600,height=400');
        }
        
        // Fermer la modal
        var shareModalEl = document.getElementById('shareModal');
        var shareModal = bootstrap.Modal.getInstance(shareModalEl);
        shareModal.hide();
    }

    // Script pour changer l'icône chevron lors du collapse/expand
    document.addEventListener('DOMContentLoaded', function() {
        const collapseElements = document.querySelectorAll('.collapse');
        collapseElements.forEach(function(collapseEl) {
            collapseEl.addEventListener('show.bs.collapse', function() {
                const triggerButton = document.querySelector(`[data-bs-target="#${this.id}"] i, [href="#${this.id}"] i`);
                if (triggerButton) {
                    triggerButton.classList.remove('fa-chevron-down');
                    triggerButton.classList.add('fa-chevron-up');
                }
            });
            collapseEl.addEventListener('hide.bs.collapse', function() {
                const triggerButton = document.querySelector(`[data-bs-target="#${this.id}"] i, [href="#${this.id}"] i`);
                if (triggerButton) {
                    triggerButton.classList.remove('fa-chevron-up');
                    triggerButton.classList.add('fa-chevron-down');
                }
            });
        });
    });
</script>

<style>
    body {
        background-color: #f0f2f5;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    /* Sidebar de filtres */
    .filter-sidebar {
        background-color: #ffffff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    .filter-sidebar h5 {
        background-color: #007bff;
        color: white;
        padding: 10px 15px;
        margin: -20px -20px 20px -20px;
        border-top-left-radius: 8px;
        border-top-right-radius: 8px;
        font-size: 1.1rem;
    }
    .filter-group {
        background-color: #f8f9fa;
        padding: 15px;
        border-radius: 5px;
        margin-bottom: 15px;
        border: 1px solid #e9ecef;
    }
    .filter-group label {
        font-weight: 500;
        font-size: 0.9rem;
        color: #555;
        margin-bottom: 5px;
        display: block;
    }
    .btn-ok {
        background-color: #6c757d;
        color: white;
    }
    .btn-ok:hover {
        background-color: #5a6268;
        color: white;
    }

    /* Section des résultats */
    .results-container {
        background-color: #ffffff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    .results-count {
        font-weight: bold;
        color: #333;
        margin-bottom: 15px;
    }
    .list-item-header {
        background-color: rgb(0, 69, 129);
        color: white;
        padding: 10px 15px;
        font-weight: bold;
    }
    .list-item {
        border: 1px solid #dee2e6;
        border-top: none;
        padding: 10px 15px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .list-item:hover {
        background-color: #f8f9fa;
    }
    .list-item .details-icon {
        color: #007bff;
        font-size: 1.2rem;
    }

    /* Styles pour la vue détaillée */
    .detail-header-bar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        padding-bottom: 15px;
        border-bottom: 1px solid #eee;
    }
    .legend span {
        margin-right: 15px;
        font-size: 0.9rem;
    }
    .legend .badge {
        width: 15px;
        height: 15px;
        display: inline-block;
        vertical-align: middle;
        margin-right: 5px;
        border-radius: 3px;
    }
    .badge-nouveau { background-color: #007bff; }
    .badge-modifie { background-color: #ffc107; }
    .badge-supprime { background-color: #dc3545; }

    .plan-item-card {
        border: 1px solid #dee2e6;
        border-left: 5px solid #007bff;
        border-radius: 0 5px 5px 0;
        margin-bottom: 20px;
        position: relative;
    }
    .plan-item-card .card-header {
        background-color: rgb(0, 69, 129);
        color: white;
        padding: 10px 15px;
        font-weight: 500;
        font-size: 0.95rem;
    }
    .plan-item-card .card-body {
        padding: 20px;
        position: relative;
    }
    .plan-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: #333;
        margin-bottom: 15px;
    }
    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 15px;
        font-size: 0.9rem;
    }
    .info-grid > div > strong {
        display: block;
        color: #555;
        margin-bottom: 3px;
        font-weight: 500;
    }
    .info-grid > div > span {
        color: #222;
    }

    .status-badge-container {
        position: absolute;
        top: 15px;
        right: -25px;
    }
    .status-badge {
        background-color: #007bff;
        color: white;
        padding: 20px 10px;
        writing-mode: vertical-rl;
        text-orientation: mixed;
        border-radius: 0 25px 25px 0;
        font-size: 0.8rem;
        font-weight: bold;
        text-transform: uppercase;
        height: 100px;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 2px 2px 5px rgba(0,0,0,0.1);
    }
    .expand-button {
        position: absolute;
        bottom: -20px;
        right: -20px;
        background-color: #007bff;
        color: white;
        border-radius: 50%;
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        z-index: 10;
    }
    .expand-button:hover {
        background-color: #0056b3;
        color: white;
    }
    .collapsed-details {
        border-top: 1px dashed #ccc;
        margin-top: 20px;
        padding-top: 20px;
    }

    /* Boutons d'action */
    .action-buttons {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }
    .button {
        display: inline-block;
        padding: 12px 20px;
        font-size: 16px;
        color: white;
        background-color: #007bff;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        text-decoration: none;
        transition: background-color 0.3s;
    }
    .button:hover {
        background-color: #0056b3;
        color: white;
        text-decoration: none;
    }
    .share-button {
        background-color: #28a745;
    }
    .share-button:hover {
        background-color: #218838;
    }

    /* Styles pour les liens de partage dans la modal */
    .share-link {
        display: flex;
        flex-direction: column;
        align-items: center;
        color: white;
        padding: 10px 15px;
        border-radius: 5px;
        text-decoration: none;
        width: 100px;
        transition: opacity 0.3s;
    }
    .share-link:hover {
        opacity: 0.8;
        text-decoration: none;
    }
    .share-link span {
        margin-top: 5px;
        font-size: 14px;
    }
    .share-link.facebook {
        background-color: #3b5998;
    }
    .share-link.twitter {
        background-color: #1DA1F2;
    }
    .share-link.linkedin {
        background-color: #0077b5;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .action-buttons {
            flex-direction: column;
        }
        .button {
            width: 100%;
            text-align: center;
        }
        .legend span {
            display: block;
            margin-bottom: 5px;
        }
    }
</style>
@endsection