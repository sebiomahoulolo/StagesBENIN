@extends('layouts.layout')

@section('title', 'StagesBENIN')

@section('content')
    <style>
    body {
        font-family: 'Times New Roman', Times, serif;
        
    }
        .text-section {
            display: flex;
            align-items: center;
        }
        .image-section img {
            max-width: 100%;
            height: auto;
            border-radius: 10px;
            object-fit: cover;
            max-height: 300px; /* Limite la hauteur des images */
        }
        .info-box {
            border: 5px solid #007bff;
            border-radius: 10px;
            padding: 20px;
            background-color: #f8f9fa;
            box-shadow: 8px 9px 12px  #007bff; /* Ombre bleue pour tous les cadres */
            text-align: center;
            margin-bottom: 20px;
        }
        .info-title {
            font-weight: bold;
            color: #007bff;
            margin-bottom: 15px;
        }
        .btn-custom {
            background-color: #007bff;
            color: white;
        }
        .btn-custom:hover {
            background-color: #0056b3;
        }
        .objective-section {
            display: flex;
            align-items: center;
            gap: 20px;
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 15px;
            box-shadow: 10px 9px 8px 9px 12px  #007bff; /* Ombre bleue */
            margin-bottom: 30px;
        }
    
    .align-letf {
        text-align: left;
    }

        .objective-section img {
            max-width: 100%;
            height: auto;
            border-radius: 15px;
            max-height: 250px; /* Limite la hauteur */
            object-fit: cover;
        }
        .objective-content h3 {
            color: #007bff;
            text-transform: uppercase;
            font-weight: bold;
            
        }
        .objective-content ul {
            list-style-type: disc;
            padding-left: 20px;
        }
        .section-container {
            display: flex;
            align-items: center;
            gap: 20px;
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 20px;
            box-shadow: 5px 9px 12px  #007bff; /* Ombre bleue */
            margin-bottom: 30px;
        }
        .section-container img {
            max-width: 100%;
            height: auto;
            border-radius: 10px;
            max-height: 300px; /* Limite la hauteur */
            object-fit: cover;
        }
        .section-content h2, .section-content h3 {
            color: #007bff;
            text-transform: uppercase;
            font-weight: bold;
        }
        .section-content ul {
            list-style-type: disc;
            padding-left: 20px;
        }
        .section-title {
            color: #007bff;
            text-transform: uppercase;
            font-weight: bold;
        }
        .highlight {
            color: #dc3545;
            font-weight: bold;
        }
        /* Style pour les boutons de téléchargement */
        .btn {
            margin-right: 10px;
            margin-bottom: 10px;
            box-shadow: 0 2px 8px rgba(0, 123, 255, 0.2);
        }
    </style>

    <div class="container mt-5">
        <header class="text-center mb-5">
            <h3 class="section-title">Programme d'Accompagnement Professionnel et de Stages (PAPS)</h3>
            <p>Offrir une feuille de route claire et structurée aux étudiants pour leur intégration professionnelle.</p>
        </header>

        <div class="container">
            <!-- Section 1 -->
            <section class="section-container">
                <div class="col-md-5">
                    <img src="{{ asset('assets/images/0a3e522878.webp') }}" alt="Appel à Candidature">
                </div>
                <div class="col-md-7 section-content">
                    <h2>Appel à Candidature</h2>
                    <h3 class="mt-3">Pourquoi le P.A.P.S. ?</h3>
                    <p>
                        L'entrée sur le marché de l'emploi représente un défi majeur pour de nombreux jeunes diplômés au Bénin. Malgré leurs qualifications académiques, beaucoup d'entre eux se trouvent confrontés à un manque d'expérience professionnelle, à des compétences non alignées avec les besoins du marché et à des difficultés à trouver des opportunités d'emploi correspondant à leurs aspirations.
                    </p>
                    <p>
                        Cette situation requiert un accompagnement efficace pour faciliter l'insertion professionnelle des étudiants de nos formations académiques supérieures.
                    </p>
                </div>
            </section>

            <!-- Section 2 -->
            <section class="section-container flex-row-reverse">
                <div class="col-md-5">
                    <img src="{{ asset('assets/images/portrait-young-student-class-1024x683.webp') }}" alt="Les avantages du programme">
                </div>
                <div class="col-md-7 section-content">
                    <h3>Les avantages du programme</h3>
                    <ul>
                        <li>Adaptation aux besoins du marché</li>
                        <li>Accompagnement global</li>
                        <li>Mise en réseau</li>
                        <li>Développement personnel</li>
                        <li>Suivi Post-Programme</li>
                    </ul>
                </div>
            </section>
        </div>

        <div class="container">
            <section class="objective-section">
                <div class="col-md-5">
                    <img src="{{ asset('assets/images/20943892-1024x1024.webp') }}" alt="Image de Cible du projet">
                </div>
                <div class="col-md-7 objective-content">
                    <h3>Nos objectifs</h3>
                    <ul>
                        <li>Combler le fossé entre l'éducation et l'opportunité professionnelle</li>
                        <li>Renforcement de l'employabilité</li>
                        <li>Encouragement de l'entrepreneuriat</li>
                        <li>Facilitation de la transition vers le monde professionnel</li>
                    </ul>
                </div>
            </section>
        </div>

        <div class="container">
            <section class="section-container">
                <div class="col-md-7 text-section">
                    <div>
                        <h3 class="section-title">Cible du projet</h3>
                        <ul>
                            <li>Les étudiants de la 1re à la 3e année en cours de cycle</li>
                            <li>Les étudiants en fin de formation</li>
                            <li>Jeunes diplômés</li>
                            <li>Les universités publiques et privées</li>
                            <li>Les entreprises locales</li>
                            <li>Les Organisations non gouvernementales (ONG)</li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-5 image-section">
                    <img src="{{ asset('assets/images/3582365-1024x1024.webp') }} " alt="Image de Cible du projet">
                </div>
            </section>
        </div>
          
        <section class="mb-4">
            <h4 class="section-title text-center" style="color:black">APPEL À CANDIDATURE – PROGRAMME D'ACCOMPAGNEMENT PROFESSIONNEL ET DE STAGE (PAPS)</h4>
        </section>

        <div class="container">
            <section class="row g-4">
                <!-- Bloc 1 -->
                <div class="col-md-4">
                    <div class="info-box">
                        <h4 class="info-title">Sélection des cabinets, entreprises et centres de formation </h4>
                        <p class="align-left">
    StagesBENIN est une entreprise de FHC Groupe qui accompagne les jeunes diplômés depuis 2023 en matière de stages et d'insertion professionnelle.
    FHC GROUPE est le porteur du projet StagesBENIN et a été sélectionné comme lauréat du projet RISE (Renforcement de la croissance et de la résilience des PME au Bénin).
</p>

                        <a href="{{ route('pages.desc_paas1') }}" class="btn btn-custom mt-3">Savoir plus</a>
                    </div>
                </div>

                <!-- Bloc 2 -->
                <div class="col-md-4">
                    <div class="info-box">
                     <h4 class="info-title">Sélection de 1500 étudiants en formation ou diplômés</h4>

                        <p>
                            Dans le cadre de son programme de formation, notre établissement met en place des stages académiques professionnels, de découverte et d'immersion afin de permettre aux étudiants d'acquérir une première expérience concrète en entreprise. Ce stage vise à renforcer les compétences techniques, l'esprit d'équipe et la culture professionnelle des stagiaires.
                        </p>
                        <a href="{{ route('pages.desc_paas2') }}" class="btn btn-custom mt-3">Savoir plus</a>
                    </div>
                </div>

                <!-- Bloc 3 -->
                <div class="col-md-4">
                    <div class="info-box">
                        <h4 class="info-title">Sélection des entreprises capables de recevoir des étudiants en stage</h4>                       
                        <p>
                            StagesBENIN ambitionne de placer 1 500 diplômés en stages, accompagnés d'un suivi personnalisé incluant orientation et intégration professionnelle à travers le Programme d'Accompagnement Professionnel et de Stage (PAPS) qui s'inscrit dans une démarche visant à améliorer l'employabilité des jeunes diplômés.
                        </p>
                        <a href="{{ route('pages.desc_paas3') }}" class="btn btn-custom mt-3">Savoir plus</a>
                    </div>
                </div>
            </section>
        </div>
        <hr>

        <section class="mb-5 text-center">
            <h3 class="section-title">Téléchargements</h3>
            <div class="mt-3">
                <a href="{{ asset('assets/images/formations/Dossier-PAPS_Lot1_SELECTION-DES-CABINETS-ENTREPRISES-ET-CENTRES-DE-FORMATION-.pdf') }}" 
                class="btn btn-success" 
                download="Dossier-PAPS_Lot1_SELECTION-DES-CABINETS-ENTREPRISES-ET-CENTRES-DE-FORMATION-.pdf">
                    Télécharger le document
                </a>
                <a href="https://me.fedapay.com/appel-cabinets-centre" class="btn btn-primary">Payez votre quittance en ligne</a>
            </div>
        </section>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endsection