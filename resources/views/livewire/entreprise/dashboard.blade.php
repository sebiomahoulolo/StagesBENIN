<div>
    <div class="stats-container">
        <div class="stat-card">
            <div class="stat-icon blue">
                <i class="fas fa-file-alt"></i>
            </div>
            <div class="stat-info">
                <div class="stat-value">Actualités</div>
                <div class="stat-label">28</div>
                <!-- <div class="trend up">
                    <i class="fas fa-arrow-up"></i>
                    <span>12% ce mois-ci</span>
                </div> -->
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon green">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-info">

                <div class="stat-value">CV Thèque</div>
                <div class="stat-label">100 Postulants</div>
                <a href="">
                    <div class="trend up">
                        <i class="fas fa-arrow-up"></i>
                        <!-- <span>8% cette semaine</span> -->
                    </div>
                </a>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon orange">
                <i class="fas fa-handshake"></i>
            </div>
            <div class="stat-info">
                <a href="{{ route('entreprises.annonces.create') }}">
                    <div class="stat-value">Créer une annonce</div>
                    <div class="trend up">
                        <i class="fas fa-arrow-up"></i>
                        <span>Publier vos annonces ici</span>
                    </div>
                </a>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon red">
                <i class="fas fa-user-check"></i>
            </div>
            <div class="stat-info">
                <div class="stat-value">Messagerie</div>
                <!-- <div class="stat-label">Postes pourvus</div> -->
                <a href="{{ route('entreprises.messagerie') }}">
                    <div class="trend down">
                        <i class="fas fa-arrow-down"></i>
                        <span>Envoyez un message ou faites une publication</span>
                    </div>
                </a>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon red">
                <i class="fas fa-user-check"></i>
            </div>
            <div class="stat-info">
                <a href="">
                    <div class="stat-value">Voir les annonces</div>
                    <!-- <div class="stat-label">Postes pourvus</div> -->
                    <div class="trend down">
                        <i class="fas fa-arrow-down"></i>
                        <span>Toutes les annonces</span>
                    </div>
                </a>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon red">
                <i class="fas fa-user-check"></i>
            </div>
            <div class="stat-info">
                <a href="{{ route('entreprises.evenements.create') }}">
                    <div class="stat-value">Evènement</div>
                    <div class="trend down">
                        <i class="fas fa-arrow-down"></i>
                        <span>Créer un évènement</span>
                    </div>
                </a>
            </div>
        </div>
    </div>

    @if($loading)
        <div class="text-center py-4">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Chargement...</span>
            </div>
        </div>
    @else
        @if($annonces->isEmpty())
            <div class="alert alert-info">
                Aucune annonce trouvée. <a href="{{ route('entreprises.annonces.create') }}" class="alert-link">Créer une nouvelle annonce</a>
            </div>
        @else
            <div class="row">
                @foreach($annonces as $annonce)
                    <div class="col-md-6 mb-4">
                        <div class="card h-100">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="card-title mb-0">{{ $annonce->nom_du_poste }}</h5>
                                <span class="badge bg-{{ $annonce->statut === 'approuve' ? 'success' : ($annonce->statut === 'en_attente' ? 'warning' : 'danger') }}">
                                    {{ ucfirst($annonce->statut) }}
                                </span>
                            </div>
                            <div class="card-body">
                                <p class="card-text">{{ Str::limit($annonce->description, 200) }}</p>
                                <div class="mb-3">
                                    <small class="text-muted">
                                        <i class="fas fa-map-marker-alt"></i> {{ $annonce->lieu }}
                                    </small>
                                </div>
                                <div class="mb-3">
                                    <small class="text-muted">
                                        <i class="fas fa-graduation-cap"></i> {{ $annonce->niveau_detude }}
                                    </small>
                                </div>
                                <div class="mb-3">
                                    <small class="text-muted">
                                        <i class="fas fa-users"></i> {{ $annonce->candidatures->count() }} candidatures
                                    </small>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="d-flex justify-content-between">
                                    <a href="{{ route('entreprises.annonces.show', $annonce) }}" class="btn btn-primary btn-sm">
                                        <i class="fas fa-eye"></i> Voir détails
                                    </a>
                                    <a href="{{ route('entreprises.annonces.edit', $annonce) }}" class="btn btn-secondary btn-sm">
                                        <i class="fas fa-edit"></i> Modifier
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    @endif
</div>