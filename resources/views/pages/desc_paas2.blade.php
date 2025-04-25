@extends('layouts.layout')

@section('title', 'StagesBENIN')

@section('content')
 <style>
        body {
            background-color: #f4f6f9;
          
        font-family: 'Times New Roman', Times, serif;

            line-height: 1.6;
        }
        h1, h2 {
            color: #0d6efd;
            font-weight: bold;
        }
        .section {
            margin-top: 40px;
        }
        .form-section {
            background: #fff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .btn-primary {
            background-color: #0d6efd;
            border-color: #0d6efd;
        }
        a {
            text-decoration: none;
            color: #0d6efd;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>

    <div class="container py-5">
        <header class="mb-4 text-center">
        
            <h1 class="fw-bold">Programme d’Accompagnement Professionnel et de Stages (PAPS)</h1>
            <p class="lead">Offrir une feuille de route claire et structurée aux étudiants pour leur intégration professionnelle.</p>
        </header>

        <!-- Appel à Candidature -->
        <section class="section">
            <h2>Appel à Candidature</h2>
            <p><strong>Sélection de 1 500 étudiants</strong> en formation, en fin de formation ou diplômés à la recherche de stages.</p>
        </section>

        <!-- Conditions d’éligibilité -->
        <section class="section">
            <h2>1 - Conditions d’éligibilité</h2>
            <ul>
                <li>Être diplômé d’une université ou d’un centre de formation reconnu.</li>
                <li>S’inscrire sur la plateforme <a href="https://www.stagesbenin.com" target="_blank">www.stagesbenin.com</a>.</li>
                <li>Être disponible durant la période de stage.</li>
                <li>Posséder une maîtrise de l’outil informatique (obligatoire).</li>
                <li>Avoir une attestation de formation sur un logiciel ou un outil clé, délivrée par un cabinet, une entreprise ou un centre accrédité par StagesBENIN.</li>
                <li>Être motivé et prêt à s’engager dans un stage selon leur niveau :
                    <ul>
                        <li>Stage de découverte : 1 mois (1ère année).</li>
                        <li>Stage d’immersion : 2 mois (2ème année).</li>
                        <li>Stage académique : 3 mois (3ème année et fin d’études).</li>
                        <li>Stage professionnel : 3 à 6 mois.</li>
                        <li>Stage formatif : selon la filière.</li>
                    </ul>
                </li>
            </ul>
        </section>

        <!-- Filières proposées -->
        <section class="section">
            <h2>2 - Filières proposées pour les stagiaires</h2>
               <img src="{{ asset('assets/images/x4.webp') }}" alt="Image de Cible du projet" style="width: 80%;  height: auto;">
        </section>

        <!-- Dossier de candidature -->
        <section class="section">
            <h2>3 - Constitution du dossier de candidature</h2>
            <ul>
                <li>CV détaillé.</li>
                <li>Copie du diplôme ou attestation de formation.</li>
                <li>Certificat de maîtrise de l’outil informatique.</li>
                <li>Certificat d’un logiciel ou outil clé de leur domaine.</li>
                <li>Lettre de motivation expliquant leur projet professionnel.</li>
                <li>Copie de la pièce d’identité.</li>
            </ul>
        </section>

        <!-- Avantages pour les stagiaires -->
        <section class="section">
            <h2>4 - Avantages pour les stagiaires</h2>
            <ul>
                <li>Accès à des stages de qualité en entreprise.</li>
                <li>Formation et accompagnement pour renforcer leurs compétences.</li>
                <li>Opportunité d’insertion professionnelle après le stage.</li>
                <li>Renforcement des compétences numériques via des outils certifiés.</li>
                <li>CV valorisé.</li>
                <li>Suivi personnalisé et accompagnement post-stage.</li>
                <li>Prolongation ou emploi éventuel à la fin du stage.</li>
                <li>Rémunération au SMIG minimum (stages professionnels uniquement).</li>
            </ul>
        </section>

        <!-- Calendrier -->
        <section class="section">
            <h2>5 - Domaines de formation</h2>
               <img src="{{ asset('assets/images/1.webp') }}" alt="Image de Cible du projet" style="width: 80%;  height: auto;">
        </section>

        <section class="section">
            <h2>6 - Calendrier de sélection</h2>
              <img src="{{ asset('assets/images/23.png') }}" alt="Image de Cible du projet" style="width: 80%;  height: auto;">
        </section>

        <!-- Postuler -->
        <section class="section">
            <h2>7 - Comment postuler ?</h2>
            <p>Les candidats doivent soumettre leur dossier :  
                - En ligne via <a href="https://www.stagesbenin.com" target="_blank">www.stagesbenin.com</a>.  
                - Ou en présentiel au siège de StagesBENIN à Kindonou.  
            </p>
            <p><strong>📩 Contact :</strong> postule@stagesbenin.com</p>
        </section>

        <!-- Préinscription -->
        <section class="section">
            <h2>Préinscription</h2>
            <div class="form-section mt-4">
                <form>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="nom" class="form-label">Nom</label>
                            <input type="text" class="form-control" id="nom" placeholder="Votre nom" required>
                        </div>
                        <div class="col-md-6">
                            <label for="prenoms" class="form-label">Prénoms</label>
                            <input type="text" class="form-control" id="prenoms" placeholder="Vos prénoms" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="contact" class="form-label">Contact WhatsApp</label>
                        <input type="tel" class="form-control" id="contact" placeholder="+22997979797" required>
                    </div>
                    <div class="mb-3">
                        <label for="filiere" class="form-label">Filière</label>
                        <input type="text" class="form-control" id="filiere" placeholder="Votre filière" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" placeholder="email@example.com" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Êtes-vous à la recherche d’un stage ?</label><br>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="stage" id="oui" value="OUI" required>
                            <label class="form-check-label" for="oui">OUI</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="stage" id="non" value="NON">
                            <label class="form-check-label" for="non">NON</label>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary mt-3">Soumettre la préinscription</button>
                </form>
            </div>
        </section>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

@endsection