@extends('layouts.layout')
@section('title', 'StagesBENIN')
@section('content')

<style>
    /* Base styles */
    * {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
    }

    body {
        font-family: 'Roboto', sans-serif;
        line-height: 1.6;
        color: #333;
    }

    .container {
        width: 90%;
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 15px;
    }

    img {
        max-width: 100%;
        height: auto;
    }

    /* Animation effects */
    .fade-in {
        opacity: 0;
        transform: translateY(30px);
        transition: opacity 1s ease-out, transform 1s ease-out;
    }

    .fade-in.show {
        opacity: 1;
        transform: translateY(0);
    }

    .zoom-in {
        transform: scale(0.8);
        opacity: 0;
        transition: transform 0.8s ease-out, opacity 0.8s ease-out;
    }

    .zoom-in.show {
        transform: scale(1);
        opacity: 1;
    }

    /* Page title */
    .page-title {
        text-align: center;
        color: #0056b3;
        margin: 40px 0;
        font-size: 2.5rem;
        font-weight: 700;
    }

    @media (max-width: 768px) {
        .page-title {
            font-size: 2rem;
            margin: 30px 0;
        }
    }

    /* About section */
    .stages-section {
        padding: 60px 0;
    }

    .stages-title {
        font-weight: bold;
        position: relative;
        display: inline-block;
        padding-bottom: 10px;
        color: #0000ff;
        font-size: 2rem;
        margin-bottom: 20px;
    }

    .stages-title::after {
        content: '';
        width: 80px;
        height: 3px;
        background-color: #007bff;
        position: absolute;
        bottom: 0;
        left: 0;
    }

    .stages-text {
        font-size: 1.1rem;
        color: #444;
        line-height: 1.8;
    }

    .stages-text b {
        color: #000;
    }

    .row {
        display: flex;
        flex-wrap: wrap;
        margin: 0 -15px;
    }

    .col-md-6 {
        flex: 0 0 50%;
        max-width: 50%;
        padding: 0 15px;
    }

    @media (max-width: 768px) {
        .col-md-6 {
            flex: 0 0 100%;
            max-width: 100%;
            margin-bottom: 30px;
        }
    }

    .img-fluid {
        width: 100%;
        border-radius: 8px;
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    }

    /* Services section */
    .services-container {
        max-width: 1200px;
        margin: auto;
        padding: 50px 20px;
    }

    .section-container {
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        background-color: rgb(250, 250, 253);
        margin-top: 10px;
        padding: 40px 0;
    }

    .section-title {
        text-align: center;
        font-weight: bold;
        font-size: 2.2rem;
        color: black;
        margin-bottom: 40px;
        margin-top: 20px;
        position: relative;
    }

    .section-title::after {
        content: '';
        width: 80px;
        height: 3px;
        background-color: #0000ff;
        position: absolute;
        bottom: -10px;
        left: 50%;
        transform: translateX(-50%);
    }

    .section-subtitle {
        text-align: center;
        font-size: 2rem;
        font-weight: 700;
        color: black;
        margin-bottom: 40px;
    }

    .service-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 20px;
        margin-top: 40px;
    }

    @media (max-width: 768px) {
        .service-grid {
            grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
        }
    }

    @media (max-width: 576px) {
        .service-grid {
            grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
        }
    }

    .service-card {
        background: white;
        border-radius: 10px;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        text-align: center;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        padding: 30px 20px;
    }

    .service-card:hover {
        transform: translateY(-5px);
        box-shadow: 0px 8px 20px rgba(0, 0, 0, 0.15);
    }

    .service-icon {
        font-size: 2.5rem;
        color: #0000ff;
        margin-bottom: 15px;
    }

    .service-card h5 {
        font-size: 1.2rem;
        font-weight: bold;
        color: #333;
        margin-bottom: 15px;
    }

    @media (max-width: 576px) {
        .service-card {
            padding: 20px 15px;
        }
        
        .service-icon {
            font-size: 2rem;
        }
        
        .service-card h5 {
            font-size: 1rem;
        }
    }

    /* Packs section */
    .tab-container {
        display: flex;
        justify-content: center;
        margin-top: 20px;
        gap: 20px;
        flex-wrap: wrap;
    }

    .tab-button {
        background-color: #1E90FF;
        color: white;
        border: none;
        padding: 15px 30px;
        cursor: pointer;
        font-size: 18px;
        border-radius: 5px;
        transition: background-color 0.3s ease, transform 0.2s ease;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .tab-button:hover {
        background-color: #1565c0;
        transform: translateY(-2px);
    }

    .tab-button.active {
        background-color: rgb(26, 18, 117);
        box-shadow: 0 4px 8px rgba(0,0,0,0.2);
    }

    @media (max-width: 576px) {
        .tab-container {
            flex-direction: column;
            gap: 10px;
        }
        
        .tab-button {
            width: 100%;
            padding: 12px;
            font-size: 16px;
            justify-content: center;
        }
    }

    .packs-container {
        margin-top: 30px;
        display: none;
    }

    .packs-container.active {
        display: block;
        animation: fadeIn 0.5s ease;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .content {
        display: flex;
        margin-top: 20px;
        gap: 30px;
        flex-wrap: wrap;
        justify-content: center;
    }

    .pack {
        background: white;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        text-align: left;
        width: 30%;
        min-width: 300px;
        margin: 20px 0;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .pack:hover {
        transform: translateY(-5px);
        box-shadow: 0px 8px 20px rgba(0, 0, 0, 0.15);
    }

    @media (max-width: 992px) {
        .pack {
            width: 45%;
            min-width: 250px;
        }
    }

    @media (max-width: 768px) {
        .pack {
            width: 100%;
            min-width: 0;
        }
        
        .content {
            gap: 20px;
        }
    }

    .pack h1 {
        background: rgb(26, 18, 117);
        color: white;
        padding: 15px;
        text-align: center;
        border-radius: 5px;
        font-size: 2rem;
        margin-top: 0;
    }

    .pack h2 {
        color: #0000ff;
        text-align: center;
        font-size: 1.8rem;
        border-bottom: 2px solid #0000ff;
        padding-bottom: 10px;
        margin-bottom: 20px;
    }

    .price {
        font-size: 35px;
        font-weight: bold;
        color: black;
        text-align: center;
        margin: 20px 0;
    }

    .old-price {
        text-decoration: line-through;
        color: red;
        font-size: 25px;
    }

    @media (max-width: 576px) {
        .pack h1 {
            font-size: 1.7rem;
        }
        
        .pack h2 {
            font-size: 1.5rem;
        }
        
        .price {
            font-size: 28px;
        }
        
        .old-price {
            font-size: 20px;
        }
    }

    .features {
        list-style: none;
        padding: 0;
    }

    .features li {
        padding: 12px 0;
        font-size: 18px;
        border-bottom: 1px solid #eee;
    }

    .features li:last-child {
        border-bottom: none;
    }

    @media (max-width: 576px) {
        .features li {
            font-size: 16px;
            padding: 10px 0;
        }
    }

    .btn-subscribe {
        display: block;
        text-align: center;
        background: rgb(26, 18, 117);
        color: white;
        text-decoration: none;
        padding: 15px;
        border-radius: 5px;
        margin-top: 20px;
        font-weight: bold;
        transition: background 0.3s ease, transform 0.2s ease;
    }

    .btn-subscribe:hover {
        background: rgb(31, 15, 71);
        transform: translateY(-2px);
        color: white;
        text-decoration: none;
    }

/* Styles généraux */
.tab-container {
    display: flex;
    justify-content: center;
    margin: 30px 0;
}

.tab-button {
    padding: 12px 24px;
    margin: 0 10px;
    border: none;
    background-color:rgb(14, 40, 145);
    border-radius: 5px;
    cursor: pointer;
    font-weight: bold;
    transition: all 0.3s ease;
}

.tab-button.active {
    background-color:rgb(14, 40, 145);
    color: white;
}

.packs-container {
    display: none;
}

.packs-container.active {
    display: block;
}

/* Nouvelle disposition pour les packs Candidats */
.packs-row {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 25px;
    margin-bottom: 40px;
}

.pack-card {
    flex: 1;
    min-width: 300px;
    max-width: 380px;
    border-radius: 12px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    background-color: white;
    overflow: hidden;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    display: flex;
    flex-direction: column;
}

.pack-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
}

.pack-header {
    background-color: #007bff;
    color: white;
    padding: 20px;
    text-align: center;
}

.pack-title {
    margin: 0;
    font-size: 24px;
    font-weight: 700;
}

.pack-subtitle {
    margin: 5px 0 0;
    font-size: 16px;
    opacity: 0.9;
}

.pack-price {
    margin: 10px 0 0;
    font-size: 22px;
    font-weight: 700;
}

.old-price {
    text-decoration: line-through;
    opacity: 0.7;
    margin-right: 8px;
    font-size: 18px;
}

.pack-content {
    padding: 20px;
    flex-grow: 1;
}

.pack-section {
    margin-bottom: 20px;
}

.pack-icon {
    font-size: 24px;
    margin-bottom: 5px;
}

.pack-section-title {
    margin: 0 0 10px;
    font-size: 18px;
    font-weight: 600;
    color: #333;
}

.pack-text {
    margin: 0;
    color: #555;
    line-height: 1.5;
}

.pack-list {
    margin: 0;
    padding-left: 20px;
    color: #555;
}

.pack-list li {
    margin-bottom: 5px;
    line-height: 1.5;
}

.pack-features {
    margin: 0;
    padding: 0;
    list-style: none;
}

.pack-features li {
    margin-bottom: 8px;
    display: flex;
    align-items: flex-start;
    line-height: 1.5;
}

.check-icon {
    color: #4CAF50;
    font-weight: bold;
    margin-right: 8px;
    font-size: 18px;
}

.btn-subscribe {
    display: block;
    background-color: #007bff;
    color: white;
    text-align: center;
    padding: 15px;
    margin: 0 20px 20px;
    text-decoration: none;
    border-radius: 8px;
    font-weight: bold;
    transition: background-color 0.3s ease;
}



/* Styles pour l'ancienne disposition (Entreprises) */
.content {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    margin-bottom: 40px;
}

.pack {
    margin: 15px;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    background-color: white;
    flex: 1;
    min-width: 250px;
    max-width: 350px;
}

.price {
    display: flex;
    align-items: center;
    gap: 10px; /* Espacement entre les éléments */
    font-size: 14px; /* Ajustez la taille globale de la police */
}

.old-price {
    text-decoration: line-through;
 
    font-size: 20px; 
}

.current-price {
    font-weight: bold;
    color: #000;
      font-size: 20px; 
}

.duration {
    font-size: 20px; 
    color: #555; 
}



</style>

<section class="stages-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6 fade-in">
                <h1 class="stages-title">StagesBENIN</h1>
                <p class="stages-text" style="text-align: justify;">
                    Est une start-up initiée par de jeunes entrepreneurs depuis août 2023 spécialisée dans :
                    <br><b> L'insertion professionnelle</b> à travers la mise en stage et l'emploi.
                    <br><b> La visibilité digitale</b> des entreprises et le référencement web.
                    <br>Nous résolvons la problématique de la transition des jeunes en fin de formation vers le monde professionnel, en leur offrant un coaching personnalisé et en nous occupant de leur mise en relation avec les entreprises partenaires.
                </p>
            </div>
            <div class="col-md-6 fade-in">
                <img src="{{ asset('assets/images/img1.avif') }}" class="img-fluid" alt="Statistiques">
            </div>
        </div>
    </div>
</section>

<!-- Services Section -->
<div class="section-container">
    <!-- Enterprise Services -->
    <div class="services-container fade-in">
        <h2 class="section-title zoom-in">Nos services pour Entreprises</h2>
        
        <div class="service-grid">
            <div class="service-card zoom-in">
                <i class="bi bi-person-plus service-icon"></i>
                <h5>Visibilité dès l'inscription</h5>
            </div>
            <div class="service-card zoom-in">
                <i class="bi bi-list service-icon"></i>
                <h5>Page de service</h5>
            </div>
            <div class="service-card zoom-in">
                <i class="bi bi-chat-dots service-icon"></i>
                <h5>Messagerie instantanée</h5>
            </div>
            <div class="service-card zoom-in">
                <i class="bi bi-calendar-event service-icon"></i>
                <h5>Page évènement</h5>
            </div>
            <div class="service-card zoom-in">
                <i class="bi bi-envelope service-icon"></i>
                <h5>Campagnes mailing & SMS</h5>
            </div>
            <div class="service-card zoom-in">
                <i class="bi bi-camera-video service-icon"></i>
                <h5>Campagnes Vidéos</h5>
            </div>
            <div class="service-card zoom-in">
                <i class="bi bi-images service-icon"></i>
                <h5>Campagnes affiches</h5>
            </div>
            <div class="service-card zoom-in">
                <i class="bi bi-file-earmark-person service-icon"></i>
                <h5>CV Thèque</h5>
            </div>
            <div class="service-card zoom-in">
                <i class="bi bi-briefcase service-icon"></i>
                <h5>Marchés Privés / Publics</h5>
            </div>
            <div class="service-card zoom-in">
    <i class="fa-solid fa-briefcase service-icon"></i>
    <h5>Création & Gestion d'Entreprise</h5>
</div>

            <div class="service-card zoom-in">
                <i class="bi bi-search service-icon"></i>
                <h5>Étude de marché</h5>
            </div>
             <div class="service-card zoom-in">
        <i class="fa-solid fa-chart-line service-icon"></i>
        <h5 class="service-title">Réalisation de plan d'affaires</h5>
    </div>

    <div class="service-card zoom-in">
        <i class="fa-solid fa-hand-holding-dollar service-icon"></i>
        <h5 class="service-title">Levée de fonds</h5>
    </div>
        </div>
    </div>

    <!-- Candidate Services -->
    <div class="services-container fade-in">
        <h2 class="section-title zoom-in">Nos Services pour Candidats</h2>

        <div class="service-grid">
            <div class="service-card zoom-in">
                <i class="bi bi-person-plus service-icon"></i>
                <h5>Inscription</h5>
            </div>
            <div class="service-card zoom-in">
                <i class="bi bi-chat-dots service-icon"></i>
                <h5>Entretien</h5>
            </div>
            <div class="service-card zoom-in">
                <i class="bi bi-compass service-icon"></i>
                <h5>Orientation</h5>
            </div>
            <div class="service-card zoom-in">
                <i class="bi bi-mortarboard service-icon"></i>
                <h5>Formation</h5>
            </div>
            <div class="service-card zoom-in">
    <i class="fa-solid fa-building service-icon"></i>
    <h5>Intégration</h5>
</div>

            <div class="service-card zoom-in">
                <i class="bi bi-person-lines-fill service-icon"></i>
                <h5>Accompagnement</h5>
            </div>
            <div class="service-card zoom-in">
                <i class="bi bi-arrow-repeat service-icon"></i>
                <h5>Suivis</h5>
            </div>
            <div class="service-card zoom-in">
                <i class="bi bi-briefcase service-icon"></i>
                <h5>Formation de Carrière</h5>
            </div>
           <div class="service-card zoom-in">
    <i class="fa-solid fa-users service-icon"></i>
    <h5>Réseautage / Networking</h5>
</div>

        </div>
    </div>
</div>

<!-- Packs Section -->
<div class="container fade-in" style="margin-top: 60px; margin-bottom: 60px;">
    <h5 class="section-subtitle">Découvrez nos packs conçus sur mesure pour répondre aux besoins des entreprises, des professionnels et des stagiaires en quête d'expérience.</h5>  <!-- Tab Buttons -->
    <div class="tab-container">
     <button id="entreprisesBtn" class="tab-button  active">
            <i class="bi bi-building"></i> Entreprises
        </button>
        <button id="candidatsBtn" class="tab-button" style=" background-color: #007bff">
            <i class="bi bi-person-badge"></i> Candidats
        </button>
    </div>

    <!-- Candidats Packs -->
    <div id="candidatsPacks" class="packs-container ">
        <div class="packs-row">
            <!-- Pack Stage de Découverte -->
            <div class="pack-card">
                <div class="pack-header">
                    <h2 class="pack-title">1️⃣ Stage de Découverte</h2>
                    <p class="pack-subtitle">(Stage d'Observation)</p>
                </div>
                
                <div class="pack-content">
                    <div class="pack-section">
                        <h3 class="pack-section-title">🎯Objectif</h3>
                        <p class="pack-text">Permettre une première immersion en entreprise pour découvrir un métier ou un secteur d'activité avant d'engager une formation ou une spécialisation.</p>
                   
                        <h3 class="pack-section-title">📌Public cible</h3>
                        <ul class="pack-list">
                            <li>Lycéens en phase d'orientation</li>
                            <li>Étudiants débutants souhaitant explorer un domaine</li>
                            <li>Toute personne curieuse d'un secteur avant d'entamer une formation spécialisée</li>
                        </ul>
            
                        <h3 class="pack-section-title">📅Durée  1 à 3 mois</h3>
                <h3 class="pack-section-title">📦Services inclus</h3>
                        <ul class="pack-features">
                            <li><span class="check-icon">✓</span> Accompagnement dans la définition des attentes et objectifs</li>
                            <li><span class="check-icon">✓</span> Recherche et mise en relation avec une entreprise adaptée</li>
                            <li><span class="check-icon">✓</span> Assistance pour la rédaction du CV et de la lettre de motivation</li>
                            <li><span class="check-icon">✓</span> Préparation à l'entretien d'entrée en stage</li>
                            <li><span class="check-icon">✓</span> Accompagnement administratif pour la convention de stage</li>
                        </ul>
                    </div>
                </div>
          
            </div>
            
            <!-- Pack "Formation professionnelle" (exemple de second pack) -->
            <div class="pack-card">
                <div class="pack-header">
                    <h2 class="pack-title">2️⃣ Stage d’Immersion Académique</h2>
                </div>
                
                <div class="pack-content">
                    <div class="pack-section">
                        <h3 class="pack-section-title">🎯Objectif</h3>
                        <p class="pack-text">Permettre aux étudiants d’acquérir une expérience pratique en entreprise en lien avec leur formation académique.</p>
               
                        <h3 class="pack-section-title">📌Public cible</h3>
                        <ul class="pack-list">
                            <li> Étudiants en BTS, Licence, Master nécessitant un stage pour valider leur formation</li>
                            <li>Étudiants en fin de cycle souhaitant renforcer leur employabilité</li>
                        </ul>
                       
                        <h3 class="pack-section-title">📅Durée 3 mois</h3>
                         <h3 class="pack-section-title">📦Services inclus</h3>
                        <ul class="pack-features">
                            <li><span class="check-icon">✓</span> Analyse approfondie du profil et des objectifs professionnels</li>
                            <li><span class="check-icon">✓</span> Sélection et mise en relation avec des entreprises partenaires</li>
                            <li><span class="check-icon">✓</span> Assistance pour la rédaction et l’optimisation des outils de candidature</li>
                            <li><span class="check-icon">✓</span> Coaching pour la réussite des entretiens</li>
                            <li><span class="check-icon">✓</span> Suivi et évaluation pendant la période de stage</li>
                        </ul>
                    </div>
                </div>
            </div>

            

                        <!-- Pack "Formation professionnelle" (exemple de second pack) -->
            <div class="pack-card">
                <div class="pack-header">
                    <h2 class="pack-title">3️⃣ Stage Professionnel</h2>
                    <p class="pack-subtitle">(Pré-emploi)</p>
                </div>
                
                <div class="pack-content">
                    <div class="pack-section">
                        <h3 class="pack-section-title">🎯Objectif</h3>
                        <p class="pack-text">Permettre aux étudiants d’acquérir une expérience pratique en entreprise en lien avec leur formation académique.</p>
               
                        <h3 class="pack-section-title">📌Public cible</h3>
                        <ul class="pack-list">
                            <li>Jeunes diplômés en recherche de première expérience</li>
                            <li>Professionnels en reconversion ou en quête d’une spécialisation</li>
                        </ul>
                       
                        <h3 class="pack-section-title">📅Durée 3 à 6 mois</h3>
                        <h3 class="pack-section-title">📦Services inclus</h3>
                        <ul class="pack-features">
                            <li><span class="check-icon">✓</span> Analyse des compétences et attentes professionnelles</li>
                            <li><span class="check-icon">✓</span> Sélection des opportunités avec perspectives d’embauche</li>
                            <li><span class="check-icon">✓</span> Assistance pour la rédaction et l’optimisation des outils de candidature</li>
                            <li><span class="check-icon">✓</span> Coaching en soft skills et intégration en entreprise</li>
                            <li><span class="check-icon">✓</span> Assistance pour la négociation des conditions du stage</li>
                            <li><span class="check-icon">✓</span> Suivi personnalisé et accompagnement post-stage</li>
                        </ul>
                    </div>
                </div>
            </div>


                        <!-- Pack "Formation professionnelle" (exemple de second pack) -->
            <div class="pack-card">
                <div class="pack-header">
                    <h2 class="pack-title">4️⃣ Stage Formatif</h2>
                <p class="pack-subtitle">(Acquisition de Compétences Spécifiques)</p>
                </div>
                
                <div class="pack-content">
                    <div class="pack-section">
                        <h3 class="pack-section-title">🎯Objectif</h3>
                        <p class="pack-text">Développer des compétences pratiques ciblées en entreprise pour renforcer son employabilité.</p>
               
                        <h3 class="pack-section-title">📌Public cible</h3>
                        <ul class="pack-list">
                            <li>Étudiants, jeunes diplômés ou professionnels en quête de compétences spécifiques pratiques (Informatique de gestion, Entreprenariat …)</li>
                    
                        </ul>
                       
                        <h3 class="pack-section-title">📅Durée 3 à 6 mois</h3>
                        <h3 class="pack-section-title">📦Services inclus</h3>
                        <ul class="pack-features">
                            <li><span class="check-icon">✓</span> Diagnostic des besoins en formation</li>
                            <li><span class="check-icon">✓</span> Placement dans une entreprise formatrice</li>
                            <li><span class="check-icon">✓</span> Suivi des compétences acquises et évaluations intermédiaires</li>
                            <li><span class="check-icon">✓</span> Attestation et recommandations professionnelles à la fin du stage</li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- Pack "Formation professionnelle" (exemple de second pack) -->
            <div class="pack-card">
                <div class="pack-header">
                    <h2 class="pack-title">5️⃣ Accompagnement pour la Recherche d’Emploi</h2>
                                        
                </div>
                
                <div class="pack-content">
                    <div class="pack-section">
                        <h3 class="pack-section-title">🎯Objectif</h3>
                        <p class="pack-text">Maximiser les chances de trouver un emploi stable et adapté au profil du candidat.</p>
               
                        <h3 class="pack-section-title">📌Public cible</h3>
                        <ul class="pack-list">
                            <li>Jeunes diplômés et demandeurs d’emploi</li>
                            <li>Professionnels en reconversion</li>
                        </ul>
                       
                         <h3 class="pack-section-title">📦Services inclus</h3>
                        <ul class="pack-features">
                            <li><span class="check-icon">✓</span> Diagnostic de carrière et définition d’une stratégie de recherche</li>
                            <li><span class="check-icon">✓</span> Rédaction et optimisation du CV et de la lettre de motivation </li>
                            <li><span class="check-icon">✓</span> Coaching intensif pour réussir les entretiens</li>
                            <li><span class="check-icon">✓</span> Mise en relation avec des entreprises ayant des postes ouverts</li>
                            <li><span class="check-icon">✓</span> Optimisation du profil LinkedIn et stratégie de networking</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Entreprises Packs (inchangé) -->
    <div id="entreprisesPacks" class="packs-container active">
        <div class="content">
            <div class="pack">
                <h1>Pack 1</h1>
                <p class="price"><span class="old-price">30 000F</span> 15 000F / ANNÉE</p>
                <ul class="features">
                    <li>&#10004; La CVthèque</li>
                    <li>&#10004; Page de services</li>
                    <li>&#10004; Page d'événements</li>
                    <li>&#10004; Visibilité dès l'inscription</li>
                    <li>&#10004; Messagerie instantanée</li>
                </ul>
                <a href="{{ route('register') }}" class="btn-subscribe ">Souscrire</a>
            </div>
            <div class="pack">
                <h2>AVANTAGES</h2>
                <ul class="features">
                    <li>&#10004; Accès aux profils disponibles dans la CV thèque</li>
                    <li>&#10004; Possibilité de partager son activité, service ou produit</li>
                </ul>
            </div>
            <div class="pack">
                <h2>LIMITES</h2>
                <ul class="features">
                    <li>&#10004; Recrutement de personnel et stagiaire facturé</li>
                    <li>&#10004; Page de service limitée Visibilité limitée</li>
                </ul>
            </div>
        </div>

        <div class="content">
            <div class="pack">
                <h1>Pack 2</h1>
                         <span class="badge badge-custom bg-info text-white">Populaire</span>
 <p class="price"><span class="old-price">100 000F</span> 60 000F / ANNÉE</p>
                <ul class="features">
                    <li>&#10004; La CVthèque</li>
                    <li>&#10004; Page de services</li>
                    <li>&#10004; Page d'événements</li>
                    <li>&#10004; Visibilité dès l'inscription</li>
                    <li>&#10004; Messagerie instantanée</li>
                    <li>&#10004; Campagne SMS</li>
                    <li>&#10004; Campagne Email</li>
                    <li>&#10004; Campagne affiche</li>
                    <li>&#10004; Assistance de 6 mois</li>
                </ul>
                <a href="{{ route('register') }}" class="btn-subscribe">Souscrire</a>
            </div>
            <div class="pack">
                <h2>AVANTAGES</h2>
                <ul class="features">
                    <li>&#10004; Accès aux profils disponibles dans la CV thèque</li>
                    <li>&#10004; Possibilité de partager son activité, service ou produit</li>
                    <li>&#10004; Accès aux campagnes SMS, email et affiche</li>
                </ul>
            </div>
            <div class="pack">
                <h2>LIMITES</h2>
                <ul class="features">
                    <li>&#10004; Recrutement de personnel et stagiaire facturé</li>
                    <li>&#10004; Page de service limitée Visibilité limitée</li>
                    <li>&#10004; Campagnes SMS, Email et affiche limitées</li>
                </ul>
            </div>
        </div>

        <div class="content">
            <div class="pack">
                <h1>Pack 3</h1>
                  <span class="badge badge-custom bg-warning text-dark">Recommandé</span>
                <p class="price"><span class="old-price">180 000F</span> 120 000F / ANNÉE</p>
                <ul class="features">
                    <li>&#10004; La CVthèque</li>
                    <li>&#10004; Page de services</li>
                    <li>&#10004; Page d'événements</li>
                    <li>&#10004; Visibilité dès l'inscription</li>
                    <li>&#10004; Messagerie instantanée</li>
                    <li>&#10004; Campagne SMS</li>
                    <li>&#10004; Campagne Email</li>
                    <li>&#10004; Campagne affiche</li>
                    <li>&#10004; Assistance de 6 mois</li>
                    <li>&#10004;  Page marché public/privé</li>
                </ul>
                <a href="{{ route('register') }}" class="btn-subscribe">Souscrire</a>
            </div>
            <div class="pack">
                <h2>AVANTAGES</h2>
                <ul class="features">
                    <li>&#10004; Accès aux meilleurs profils de la CV thèque et recrutement non facturé</li>
                    <li>&#10004; Accès à six pages de service où détailler ces activités et produits</li>
                    <li>&#10004; Visibilité illimitée</li>
                <li>&#10004; Donne l’accès aux appels d’offre</li>
                <li>&#10004; Suivi et accompagnement de 6 mois</li>
                <li>&#10004; Campagnes SMS, email et affiche illimités</li>
                </ul>
            </div>
            <div class="pack">
                <h2>LIMITES</h2>
                <ul class="features">
                    <li>&#10004; Pas d’accès à un site personnalisé</li>
                </ul>
            </div>
        </div>



          <div class="content">
            <div class="pack">
                <h1>Pack 4</h1>
                 <span class="badge badge-custom bg-danger text-white">Recommandé</span>
                <p class="price"> <span style="color:red">Prix sur mesure</span> / ANNÉE</p>
                
                <ul class="features">
                    <li>&#10004; La CVthèque</li>
                    <li>&#10004; Page de services</li>
                    <li>&#10004; Page d'événements</li>
                    <li>&#10004; Visibilité dès l'inscription</li>
                    <li>&#10004; Messagerie instantanée</li>
                    <li>&#10004; Campagne SMS</li>
                    <li>&#10004; Campagne Email</li>
                    <li>&#10004; Campagne affiche</li>
                    <li>&#10004; Assistance de 6 mois</li>
                    <li>&#10004; Page marché public/privé</li>
                    <li>&#10004; Conception  des sites web</li>
                    <li>&#10004; Application et Logiciel</li>
                    <li>&#10004; Gestion des sites</li>
                </ul>
                <a href="{{ route('register') }}" class="btn-subscribe">Souscrire</a>
            </div>
            <div class="pack">
                <h2>AVANTAGES</h2>
                <ul class="features">
                    <li>&#10004; Accès aux meilleurs profils de la CV thèque et recrutement non facturé</li>
                    <li>&#10004; Accès à six pages de service où détailler ces activités et produits</li>
                    <li>&#10004; Visibilité illimitée</li>
                    <li>&#10004; Donne l’accès aux appels d’offre</li>
                    <li>&#10004; Suivi et accompagnement de 6 mois</li>
                    <li>&#10004; Campagnes SMS, email et affiche illimités</li>
                    <li>&#10004; Conception et gestion de site web</li>
                </ul>
            </div>
            <div class="pack">
                <h2>LIMITES</h2>
                <ul class="features">
                    <li>&#10004; Néant</li>
                   
                </ul>
            </div>
        </div>
    </div>
</div>


<script>
document.addEventListener('DOMContentLoaded', function() {
    const candidatsBtn = document.getElementById('candidatsBtn');
    const entreprisesBtn = document.getElementById('entreprisesBtn');
    const candidatsPacks = document.getElementById('candidatsPacks');
    const entreprisesPacks = document.getElementById('entreprisesPacks');
    
    // Fonction pour changer d'onglet
    function switchTab(activeBtn, inactiveBtn, activeContainer, inactiveContainer) {
        activeBtn.classList.add('active');
        inactiveBtn.classList.remove('active');
        activeContainer.classList.add('active');
        inactiveContainer.classList.remove('active');
    }
    
    // Écouteurs d'événements pour les boutons
    candidatsBtn.addEventListener('click', function() {
        switchTab(candidatsBtn, entreprisesBtn, candidatsPacks, entreprisesPacks);
    });
    
    entreprisesBtn.addEventListener('click', function() {
        switchTab(entreprisesBtn, candidatsBtn, entreprisesPacks, candidatsPacks);
    });
});
</script>
<script>

document.addEventListener("DOMContentLoaded", function () {
    // Éléments à animer
    const fadeElements = document.querySelectorAll(".fade-in");
    const zoomElements = document.querySelectorAll(".zoom-in");

    // Observer pour les animations de fondu
    const fadeObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                setTimeout(() => {
                    entry.target.classList.add("show");
                }, 100);
                fadeObserver.unobserve(entry.target);
            }
        });
    }, { threshold: 0.1, rootMargin: "0px 0px -50px 0px" });

    // Observer pour les animations de zoom
    const zoomObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                setTimeout(() => {
                    entry.target.classList.add("show");
                }, 100);
                zoomObserver.unobserve(entry.target);
            }
        });
    }, { threshold: 0.1, rootMargin: "0px 0px -50px 0px" });

    // Appliquer les observers aux éléments
    fadeElements.forEach(element => {
        fadeObserver.observe(element);
    });

    zoomElements.forEach(element => {
        zoomObserver.observe(element);
    });
});
</script>


<!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endsection