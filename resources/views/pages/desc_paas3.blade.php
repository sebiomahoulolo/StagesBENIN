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
        <!-- Appel à candidature -->
        <section class="section">
            <h2>Appel à candidature</h2>
            <p>Sélection des entreprises capables de recevoir des étudiants en stage pour l’acquisition de compétences.</p>
        </section>

        <!-- Conditions d'éligibilité -->
        <section class="section">
            <h2>1. Conditions d’éligibilité</h2>
            <ul>
                <li>Être une entreprise légalement constituée avec un RCCM ou NIF.</li>
                <li>Être en activité depuis au moins 2 ans pour assurer la stabilité du stagiaire.</li>
                <li>Disposer de ressources financières suffisantes pour rémunérer au moins au SMIG.</li>
                <li>Fournir un cadre de travail structuré avec locaux équipés et normes d’hygiène respectées.</li>
                <li>Désigner un tuteur qualifié pour suivre les stagiaires.</li>
                <li>Exercer une activité en lien avec la formation du stagiaire.</li>
                <li>S’engager à respecter les termes de la convention de stage.</li>
                <li>Être en règle avec les autorités fiscales et sociales.</li>
                <li>Limiter l’accueil à un maximum de 10 stagiaires simultanément.</li>
                <li>Fournir une évaluation de fin de stage.</li>
            </ul>
        </section>

        <!-- Constitution du dossier -->
        <section class="section">
            <h2>2. Constitution du Dossier de Candidature</h2>
            <ul>
                <li><strong>Informations générales :</strong> Raison sociale, RCCM/IFU, adresse, téléphone, email.</li>
                <li><strong>Profil de l’entreprise :</strong> Secteur d’activité, nombre d’employés, années d’expérience.</li>
                <li><strong>Capacité d’accueil :</strong> Nombre de stagiaires, durée du stage, locaux équipés.</li>
                <li><strong>Encadrement proposé :</strong> Nom et poste du tuteur, expérience professionnelle.</li>
                <li><strong>Pièces à fournir :</strong> RCCM, NIF, certificat d’existence, CV du tuteur, photos des locaux.</li>
            </ul>
        </section>

        <!-- Engagements -->
        <section class="section">
            <h2>3. Engagements de l’entreprise</h2>
            <ul>
                <li>Assurer un cadre professionnel respectant les normes de sécurité et d’éthique.</li>
                <li>Fournir un encadrement pédagogique adapté.</li>
                <li>Rémunérer le stagiaire au moins au SMIG.</li>
                <li>Respecter les termes de la convention de stage.</li>
                <li>Fournir une évaluation finale du stagiaire.</li>
                <li>Informer StagesBENIN en cas de difficultés ou abandon.</li>
            </ul>
        </section>

        <!-- Comment postuler -->
        <section class="section">
            <h2>4. Comment postuler ?</h2>
            <p>Les cabinets intéressés doivent soumettre leur dossier :</p>
            <ul>
                <li>Par e-mail à : <strong>depot@stagesbenin.com</strong> (un fichier PDF).</li>
                <li>En présentiel au siège de StagesBENIN, situé au Premier Immeuble après la pharmacie Kindonou.</li>
            </ul>
            <p>📞 Contact WhatsApp : <strong>+229 01 41733175</strong></p>
        </section>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

@endsection