 
 @extends('layouts.layout')

@section('title', 'StagesBENIN')

@push('styles')
    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />
    <!-- Animation CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet" />
  @endpush

@section('content')
<div class="container py-4 py-lg-5">
    <div class="row gx-lg-5">
        <div class="col-lg-4">
            {{-- Section Filtres --}}
            <aside class="filter-section shadow-sm mb-4 mb-lg-0">
                <h5 class="filter-section-title"><i class="fas fa-filter me-2"></i>Filtres</h5>
                <form action="{{ route('etudiants.offres.index') }}" method="GET" id="filterForm">
                    <div class="filter-group">
                        <label for="search" class="form-label">Mots-clés</label>
                        <div class="input-group input-group-sm"> {{-- Utilisation de input-group pour l'icône --}}
                            <span class="input-group-text"><i class="fas fa-search"></i></span>
                            <input type="text" class="form-control" id="search" name="search"
                                   value="{{ request('search') }}" placeholder="Poste, compétence...">
                        </div>
                    </div>

                    <div class="filter-group">
                        <label for="secteur_id" class="form-label">Secteur d'activité</label>
                        <select class="form-select form-select-sm select2-filter" id="secteur_id" name="secteur_id" data-placeholder="Choisir un secteur">
                            <option value=""></option> {{-- Placeholder pour Select2 --}}
                            @foreach($secteurs as $secteur)
                                <option value="{{ $secteur->id }}" {{ request('secteur_id') == $secteur->id ? 'selected' : '' }}>
                                    {{ $secteur->nom }}
                                </option>
                            @endforeach
                        </select>
                    </div>
<div class="filter-group">
                        <label for="type_de_poste" class="form-label">Type de poste</label>
                        <select class="form-select form-select-sm" id="type_de_poste" name="type_de_poste">
                            <option value="">Tous</option>
                            <option value="Stage" {{ request('type_de_poste') == 'Stage' ? 'selected' : '' }}>Stage</option>
                            <option value="Emploi" {{ request('type_de_poste') == 'Emploi' ? 'selected' : '' }}>Emploi</option>
                            <option value="Alternance" {{ request('type_de_poste') == 'Alternance' ? 'selected' : '' }}>Alternance</option>
                        </select>
                    </div>

                    <div class="filter-group">
                        <label for="niveau_detude" class="form-label">Niveau d'étude</label>
                        <select class="form-select form-select-sm" id="niveau_detude" name="niveau_detude">
                            <option value="">Tous</option>
                            <option value="BEPC" {{ request('niveau_detude') == 'BEPC' ? 'selected' : '' }}>BEPC</option>
                            <option value="CAP" {{ request('niveau_detude') == 'CAP' ? 'selected' : '' }}>CAP</option>
                            <option value="BAC" {{ request('niveau_detude') == 'BAC' ? 'selected' : '' }}>BAC</option>
                            <option value="BAC+1" {{ request('niveau_detude') == 'BAC+1' ? 'selected' : '' }}>BAC+1</option>
                            <option value="BAC+2" {{ request('niveau_detude') == 'BAC+2' ? 'selected' : '' }}>BAC+2</option>
                            <option value="BAC+3" {{ request('niveau_detude') == 'BAC+3' ? 'selected' : '' }}>BAC+3</option>
                            <option value="BAC+4" {{ request('niveau_detude') == 'BAC+4' ? 'selected' : '' }}>BAC+4</option>
                            <option value="BAC+5" {{ request('niveau_detude') == 'BAC+5' ? 'selected' : '' }}>BAC+5</option>
                            <option value="Doctorat" {{ request('niveau_detude') == 'Doctorat' ? 'selected' : '' }}>Doctorat</option>
                        </select>
                    </div>

                    <div class="filter-group">
                        <label for="lieu" class="form-label">Localisation</label>
                        <input type="text" class="form-control form-control-sm" id="lieu" name="lieu"
                               value="{{ request('lieu') }}" placeholder="Ex: Cotonou, Paris...">
                    </div>

                    <button type="submit" class="btn btn-primary filter-btn w-100 mt-2">
                        <i class="fas fa-search me-1"></i>Rechercher
                    </button>
                    <a href="{{ route('etudiants.offres.index') }}" class="btn btn-outline-secondary w-100 mt-2">
                        <i class="fas fa-times me-1"></i> Réinitialiser
                    </a>
                </form>
            </aside>
        </div>

        <div class="col-lg-8">
            {{-- Entête de la liste des offres --}}
            <div class="list-header mb-4 p-3 bg-white rounded shadow-sm">
                <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                    <h5 class="mb-2 mb-sm-0 text-primary fw-bold">
                        @if($annonces->total() > 0)
                            {{ $annonces->total() }} Offre{{ $annonces->total() > 1 ? 's' : '' }} trouvée{{ $annonces->total() > 1 ? 's' : '' }}
                        @else
                            Offres disponibles
                        @endif
                    </h5>
                    <a href="{{ route('etudiants.candidatures.index') }}" class="btn btn-outline-primary btn-sm">
                        <i class="fas fa-file-alt me-1"></i> Mes candidatures
                    </a>
                </div>
            </div>

            {{-- Liste des Annonces --}}
            @if($annonces->isEmpty())
                <div class="text-center py-5 bg-light rounded shadow-sm">
                    <i class="fas fa-folder-open fa-4x text-muted mb-3"></i>
                    <h4 class="mb-2">Aucune offre ne correspond à vos critères.</h4>
                    <p class="text-muted">Essayez de modifier vos filtres ou de les réinitialiser.</p>
                    <a href="{{ route('etudiants.offres.index') }}" class="btn btn-primary mt-2">
                        Réinitialiser les filtres
                    </a>
                </div>
            @else
                <div class="annonces-list">
                    @foreach($annonces as $annonce)
                        <article class="offre-card card mb-3 animate__animated animate__fadeInUp" style="animation-delay: {{ $loop->index * 0.07 }}s">
                            <div class="card-body">
                                <div class="d-flex flex-column flex-md-row justify-content-between mb-2">
                                    <h5 class="offre-card-title mb-1">
                                        <a href="{{ route('etudiants.offres.show', $annonce) }}" class="text-decoration-none">
                                            {{ $annonce->nom_du_poste }}
                                        </a>
                                    </h5>
                                    {{-- Affichage du logo de l'entreprise s'il existe 
                                    @if($annonce->entreprise && $annonce->entreprise->logo)
                                    <img src="{{ asset('storage/' . $annonce->entreprise->logo) }}" alt="Logo {{ $annonce->entreprise->nom }}" class="offre-entreprise-logo ms-md-3 align-self-md-start" >
                                    @elseif($annonce->entreprise)
                                    <p class="offre-card-entreprise text-muted small ms-md-3 mb-0 align-self-md-center">{{ $annonce->entreprise->nom }}</p>
                                    @endif
                                </div>
                                @if($annonce->entreprise && !$annonce->entreprise->logo) {{-- Nom de l'entreprise si pas de logo --}}
                                
                             

                                <div class="badge-container mb-3">
                                    <span class="badge bg-primary-soft text-primary"><i class="fas fa-briefcase me-1"></i>{{ $annonce->type_de_poste }}</span>
                                    @if($annonce->secteur)
                                    <span class="badge bg-success-soft text-success"><i class="fas fa-tags me-1"></i>{{ $annonce->secteur->nom }}</span>
                                    @endif
                                    @if($annonce->specialite)
                                    <span class="badge bg-info-soft text-info"><i class="fas fa-cogs me-1"></i>{{ $annonce->specialite->nom }}</span>
                                    @endif
                                    <span class="badge bg-warning-soft text-warning"><i class="fas fa-graduation-cap me-1"></i>{{ $annonce->niveau_detude }}</span>
                                    <span class="badge bg-secondary-soft text-secondary"><i class="fas fa-map-marker-alt me-1"></i>{{ $annonce->lieu }}</span>
                                </div>

                                <p class="offre-card-description text-muted">
                                    {{ Str::limit(strip_tags($annonce->description_du_poste), 180) }}
                                </p>
                            </div>
                            <div class="card-footer bg-light-subtle border-top-0"> {{-- bg-light-subtle pour un fond très clair --}}
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="date-cloture text-muted small">
                                        <i class="fas fa-clock me-1"></i>
                                        Clôture le {{ $annonce->date_cloture ? $annonce->date_cloture->format('d/m/Y') : 'Non spécifiée' }}
                                    </span>
                                    <a href="{{ route('etudiants.offres.show', $annonce) }}" class="btn btn-primary btn-sm btn-voir-offre">
                                       Postuler <i class="fas fa-arrow-right ms-1"></i>
                                    </a>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>

                {{-- Pagination --}}
                @if ($annonces->hasPages())
                <div class="d-flex justify-content-center mt-4 pt-2">
                    {{ $annonces->appends(request()->query())->links() }} {{-- appends pour garder les filtres --}}
                </div>
                @endif
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
<!-- jQuery (Select2 dependency) -->
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize Select2 for filter elements
    $('.select2-filter').select2({
        theme: "bootstrap-5",
        width: '100%',
        // placeholder: $(this).data('placeholder'), // Géré par l'attribut data-placeholder sur le select
        allowClear: true, // Permet de déselectionner
        language: {
            noResults: function() { return "Aucun résultat"; },
            searching: function() { return "Recherche..."; }
        }
    });

    const secteurSelect = $('#secteur_id');
    const specialiteSelect = $('#specialite_id');
    const initialSecteurId = secteurSelect.val();
    const initialSpecialiteValue = "{{ request('specialite_id') }}";

    function loadSpecialites(secteurId, selectedSpecialiteId = null) {
        const placeholderText = specialiteSelect.data('placeholder') || "Choisir une spécialité";
        specialiteSelect.empty().append($('<option></option>').val("").text(placeholderText)).prop('disabled', true);

        if (secteurId) {
            specialiteSelect.data('placeholder', 'Chargement...'); // Update placeholder during load
            specialiteSelect.trigger('change.select2'); // Refresh Select2 to show new placeholder

            fetch(`/api/specialites/${secteurId}`) // Assurez-vous que cette route API existe et retourne du JSON
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(specialites => {
                    specialiteSelect.prop('disabled', false);
                    specialiteSelect.data('placeholder', placeholderText); // Restore original placeholder

                    if (specialites.length > 0) {
                        specialites.forEach(specialite => {
                            const option = $('<option></option>')
                                .val(specialite.id)
                                .text(specialite.nom);
                            if (specialite.id == selectedSpecialiteId) {
                                option.prop('selected', true);
                            }
                            specialiteSelect.append(option);
                        });
                    } else {
                        specialiteSelect.append($('<option></option>').val("").text("Aucune spécialité disponible"));
                    }
                    specialiteSelect.trigger('change.select2'); // Notify select2 of new options
                })
                .catch(error => {
                    console.error('Erreur lors du chargement des spécialités:', error);
                    specialiteSelect.prop('disabled', false);
                    specialiteSelect.data('placeholder', placeholderText);
                    specialiteSelect.append($('<option></option>').val("").text("Erreur de chargement"));
                    specialiteSelect.trigger('change.select2');
                });
        } else {
            specialiteSelect.data('placeholder', "D'abord un secteur");
            specialiteSelect.trigger('change.select2');
        }
    }

    secteurSelect.on('change', function() {
        loadSpecialites($(this).val());
        // Optionnel: soumettre le formulaire si vous ne voulez pas que l'utilisateur clique sur "Rechercher"
        // $('#filterForm').submit();
    });

    // Load specialities on page load if a secteur is already selected
    if (initialSecteurId) {
        loadSpecialites(initialSecteurId, initialSpecialiteValue);
    }

    // Optionnel: soumission automatique du formulaire (sans debounce pour l'instant)
    // Vous pouvez ajouter un debounce si vous constatez trop de requêtes
    // $('#filterForm select:not(#secteur_id), #filterForm input[type="text"]').on('change', function() {
    //     $('#filterForm').submit();
    // });
    // $('#search, #lieu').on('blur', function() { // Pour les champs texte, soumettre sur perte de focus
    //     $('#filterForm').submit();
    // });

    // Pour la démo, on laisse l'utilisateur cliquer sur le bouton "Rechercher"
    // Si vous préférez la soumission auto, décommentez les lignes ci-dessus et commentez/supprimez le bouton "Rechercher".
});
</script>
@endpush
 
 <style>
:root {
    --bs-primary-rgb: 52, 152, 219; /* Bleu que vous utilisiez */
    --bs-primary: #3498db;
    --bs-primary-hover: #2980b9;
    --bs-secondary-rgb: 108, 117, 125;
    --bs-secondary: #6c757d;
    --bs-success-rgb: 34, 170, 96; /* Vert un peu plus doux */
    --bs-success: #22aa60;
    --bs-info-rgb: 91, 89, 182; /* Violet que vous utilisiez pour spécialité */
    --bs-info: #5b59b6; /* Corrigé de #9b59b6 */
    --bs-warning-rgb: 241, 196, 15; /* Jaune que vous utilisiez */
    --bs-warning: #f1c40f;
    --bs-danger-rgb: 231, 76, 60; /* Rouge que vous utilisiez */
    --bs-danger: #e74c3c;
    --text-muted-light: #869099;
    --card-border-color: #e0e0e0; /* Bordure plus claire */
    --card-bg: #ffffff;
    --body-bg: #f4f7f9; /* Fond de page très légèrement grisé */
    --default-shadow: 0 0.125rem 0.375rem rgba(0,0,0,0.06);
    --hover-shadow: 0 0.375rem 0.875rem rgba(0,0,0,0.08);
    --input-border-radius: 0.25rem;
    --card-border-radius: 0.5rem; /* Rayon plus doux pour les cartes */
    --badge-padding-y: 0.4em;
    --badge-padding-x: 0.75em;
    --font-family-sans-serif: "Inter", system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", "Liberation Sans", sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
}

body {
    font-family: var(--font-family-sans-serif);
    background-color: var(--body-bg);
    color: #374151; /* Gris foncé pour le texte principal */
    font-size: 0.95rem; /* Taille de police de base légèrement ajustée */
}

/* === Section Filtres === */
.filter-section {
    background: var(--card-bg);
    border-radius: var(--card-border-radius);
    padding: 20px 25px; /* Plus de padding horizontal */
    position: sticky;
    top: 80px; /* Ajustez selon la hauteur de votre navbar */
    max-height: calc(100vh - 100px);
    overflow-y: auto;
    border: 1px solid var(--card-border-color);
}

.filter-section-title {
    color: var(--bs-primary);
    font-weight: 600;
    margin-bottom: 1.5rem;
    padding-bottom: 0.75rem;
    border-bottom: 1px solid var(--card-border-color);
    font-size: 1.1rem;
}

.filter-group {
    margin-bottom: 1rem;
}

.filter-group .form-label {
    font-weight: 500;
    color: #4b5563; /* Gris moyen pour les labels */
    margin-bottom: 0.4rem;
    font-size: 0.875rem;
}

.filter-group .form-control,
.filter-group .form-select {
    border-radius: var(--input-border-radius);
    border: 1px solid #d1d5db; /* Bordure d'input légèrement plus visible */
    font-size: 0.875rem;
    padding: 0.4rem 0.75rem; /* Padding ajusté pour form-control-sm feeling */
    transition: border-color 0.2s ease, box-shadow 0.2s ease;
}
.filter-group .form-control:focus,
.filter-group .form-select:focus {
    border-color: var(--bs-primary);
    box-shadow: 0 0 0 0.2rem rgba(var(--bs-primary-rgb), 0.15); /* Ombre focus plus subtile */
}

.filter-group .input-group-text {
    background-color: #f3f4f6; /* Fond plus clair pour l'icône */
    border-radius: var(--input-border-radius) 0 0 var(--input-border-radius);
    border-right: 0;
    color: #6b7280;
    font-size: 0.875rem;
    padding: 0.4rem 0.6rem;
}
.filter-group .input-group .form-control {
    border-left: 0;
    padding-left: 0.5rem;
}
.filter-group .input-group .form-control:focus { /* Pour que l'icône change de couleur aussi au focus */
    border-left:0; /* On le remet car BS peut le modifier */
}
.filter-group .input-group:focus-within .input-group-text {
    border-color: var(--bs-primary);
    color: var(--bs-primary);
    box-shadow: 0 0 0 0.2rem rgba(var(--bs-primary-rgb), 0.15); /* Sauf le côté droit */
    border-right:0;
}


/* Select2 Specific styling for filters */
.select2-container--bootstrap-5.select2-container--focus .select2-selection,
.select2-container--bootstrap-5.select2-container--open .select2-selection {
    border-color: var(--bs-primary);
    box-shadow: 0 0 0 0.2rem rgba(var(--bs-primary-rgb), 0.15);
}
.select2-container--bootstrap-5 .select2-selection {
    font-size: 0.875rem;
    min-height: calc(1.5em + (0.4rem * 2) + 2px); /* Match form-control-sm style */
    padding: 0.4rem 0.75rem;
    border: 1px solid #d1d5db;
    border-radius: var(--input-border-radius);
}
.select2-container--bootstrap-5 .select2-dropdown {
    font-size: 0.875rem;
    border-color: #d1d5db;
    border-radius: var(--input-border-radius);
    box-shadow: var(--default-shadow);
}
.select2-container--bootstrap-5 .select2-results__option--highlighted:not([aria-selected="true"]) {
    background-color: rgba(var(--bs-primary-rgb), 0.1);
    color: var(--bs-primary);
}
.select2-container--bootstrap-5 .select2-results__option[aria-selected="true"] {
    background-color: var(--bs-primary);
    color: white;
}

/* === Entête de la liste des offres === */
.list-header {
    border: 1px solid var(--card-border-color);
}
.list-header h5 {
    font-weight: 600;
}

/* === Carte d'Offre (Article) === */
.offre-card {
    border: 1px solid var(--card-border-color);
    border-radius: var(--card-border-radius);
    background-color: var(--card-bg);
    transition: box-shadow 0.2s ease-in-out, transform 0.2s ease-in-out, border-color 0.2s ease-in-out;
    box-shadow: var(--default-shadow);
}

.offre-card:hover {
    box-shadow: var(--hover-shadow);
    transform: translateY(-4px); /* Effet de soulèvement plus marqué */
    border-color: rgba(var(--bs-primary-rgb), 0.4);
}

.offre-card-title a {
    font-size: 1.1rem; /* Légèrement réduit pour équilibre */
    font-weight: 600;
    color: #1f2937; /* Titre plus foncé */
    text-decoration: none;
    transition: color 0.2s ease;
}
.offre-card-title a:hover {
    color: var(--bs-primary);
}

.offre-entreprise-logo {
    max-height: 35px; /* Taille logo réduite */
    max-width: 100px;
    object-fit: contain;
    border-radius: 4px; /* Coins arrondis pour logo */
}
.offre-card-entreprise {
    font-size: 0.85rem;
    color: var(--text-muted-light);
}

.offre-card-description {
    font-size: 0.9rem;
    line-height: 1.65; /* Meilleure lisibilité */
    color: #4b5563;
    margin-bottom: 1rem;
}

.badge-container {
    display: flex;
    flex-wrap: wrap;
    gap: 0.4rem 0.6rem; /* Espacement ajusté */
}

.badge-container .badge {
    padding: var(--badge-padding-y) var(--badge-padding-x);
    font-size: 0.725rem; /* Badges un peu plus petits */
    font-weight: 500;
    border-radius: 50px; /* Pill badges */
    display: inline-flex;
    align-items: center;
    line-height: 1; /* Pour un meilleur alignement vertical de l'icône */
}
.badge-container .badge i {
    font-size: 0.85em; /* Taille icône relative au texte du badge */
    margin-right: 0.35em;
}

/* Soft Badges (couleurs de fond claires, texte foncé/primaire) */
.bg-primary-soft { background-color: rgba(var(--bs-primary-rgb), 0.1); }
.text-primary { color: var(--bs-primary) !important; }

.bg-success-soft { background-color: rgba(var(--bs-success-rgb), 0.1); }
.text-success { color: var(--bs-success) !important; }

.bg-info-soft { background-color: rgba(var(--bs-info-rgb), 0.1); }
.text-info { color: var(--bs-info) !important; }

.bg-warning-soft { background-color: rgba(var(--bs-warning-rgb), 0.15); }
.text-warning { color: #b48c00 !important; } /* Jaune foncé pour texte */

.bg-secondary-soft { background-color: rgba(var(--bs-secondary-rgb), 0.1); }
.text-secondary { color: var(--bs-secondary) !important; }

/* Pied de carte */
.offre-card .card-footer {
    padding: 0.75rem 1.25rem; /* Padding ajusté */
}

.date-cloture {
    font-size: 0.8rem;
}

.btn-voir-offre {
    font-weight: 500;
    padding: 0.3rem 0.8rem; /* Bouton un peu plus petit */
    font-size: 0.85rem;
    transition: background-color 0.2s ease, transform 0.2s ease, box-shadow 0.2s ease;
}
.btn-voir-offre:hover {
    transform: translateY(-2px);
    box-shadow: 0 2px 4px rgba(var(--bs-primary-rgb),0.3);
}

/* === Pagination === */
.pagination .page-item .page-link {
    border-radius: var(--input-border-radius);
    margin: 0 2px; /* Espacement réduit */
    color: var(--bs-primary);
    border: 1px solid #d1d5db;
    font-size: 0.875rem;
    padding: 0.4rem 0.75rem;
    transition: background-color 0.2s ease, color 0.2s ease, border-color 0.2s ease;
}
.pagination .page-item.active .page-link {
    background-color: var(--bs-primary);
    border-color: var(--bs-primary);
    color: #fff;
    box-shadow: 0 1px 3px rgba(var(--bs-primary-rgb),0.2);
}
.pagination .page-item.disabled .page-link {
    color: #9ca3af;
    background-color: #f9fafb;
}
.pagination .page-item:not(.active) .page-link:hover {
    background-color: rgba(var(--bs-primary-rgb), 0.05);
    border-color: rgba(var(--bs-primary-rgb), 0.3);
    color: var(--bs-primary-hover);
}

/* === Placeholder "Aucune offre" === */
.fa-folder-open { /* Déjà bien, juste pour référence */
    font-size: 4rem;
}

/* === Animations (Animate.css) === */
.animate__fadeInUp {
    animation-duration: 0.4s; /* Animation un peu plus rapide */
}

/* === Responsive Design === */
@media (max-width: 991.98px) { /* lg breakpoint */
    .filter-section {
        position: relative;
        top: 0;
        max-height: none;
        overflow-y: visible;
        margin-bottom: 2rem;
    }
    .offre-card-title a {
        font-size: 1.05rem; /* Un peu plus grand sur tablette */
    }
}

@media (max-width: 767.98px) { /* md breakpoint */
    .filter-section {
        padding: 15px 20px; /* Moins de padding sur mobile */
    }
    .filter-section-title {
        font-size: 1rem;
        margin-bottom: 1rem;
        padding-bottom: 0.5rem;
    }
    .list-header .d-flex {
        flex-direction: column;
        align-items: stretch !important; /* Assurer que les éléments prennent toute la largeur */
        gap: 0.75rem; /* Espace entre titre et bouton "Mes candidatures" */
    }
    .list-header h5 {
        text-align: center;
    }
    .list-header .btn {
        width: 100%; /* Bouton prend toute la largeur */
    }
    .offre-card-title a {
        font-size: 1rem;
    }
    .offre-card .card-body, .offre-card .card-footer {
        padding: 1rem; /* Moins de padding dans les cartes sur mobile */
    }
    .offre-card-description {
        font-size: 0.875rem;
    }
    .badge-container .badge {
        font-size: 0.7rem;
        padding: 0.35em 0.65em;
    }
    .pagination .page-item .page-link {
        font-size: 0.8rem;
        padding: 0.35rem 0.65rem;
    }
}

/* Custom scrollbar for filter section (optionnel, pour un look plus "pro") */
.filter-section::-webkit-scrollbar {
    width: 6px;
}
.filter-section::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 10px;
}
.filter-section::-webkit-scrollbar-thumb {
    background: #c1c1c1;
    border-radius: 10px;
}
.filter-section::-webkit-scrollbar-thumb:hover {
    background: #a1a1a1;
}

 </style>