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
                <a href="{{ route('recruteur.annonce') }}">
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
                <a href="{{ route('recruteur.messagerie') }}">
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
                <a href="{{ route('recruteur.event') }}">
                    <div class="stat-value">Evènement</div>
                    <div class="trend down">
                        <i class="fas fa-arrow-down"></i>
                        <span>Créer un évènement</span>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>