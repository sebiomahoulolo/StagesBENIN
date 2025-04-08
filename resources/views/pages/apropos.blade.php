@extends('layouts.layout')

@section('title', 'StagesBENIN')

@section('content')
<section class="qui-sommes-nous py-5" style="background-color: rgb(244, 244, 245);">
    <div class="container">
        <h1 class="text-center mb-4 text-primary" style="font-size: 3em;">Qui sommes-nous ?</h1>
        <div class="row align-items-center">
            <div class="col-md-6">
                <p style="font-size: 1.1em; text-align: justify; line-height: 1.6;">
                    Nous sommes StagesBENIN, une start-up initiée par des jeunes visionnaires, entrepreneurs et investisseurs,
                    qui se positionne comme un catalyseur de l’insertion professionnelle au Bénin. Notre plateforme offre une
                    référence web exhaustive des entreprises à travers neuf (09) services pour la croissance du chiffre
                    d’affaires, facilitant la mise en stage des étudiants et diplômés. Nous croyons en l’acquisition
                    d’expérience professionnelle significative grâce à des programmes de coaching personnalisés. Notre mission
                    va au-delà de la simple mise en relation des candidats et des entreprises, elle vise à réduire le taux de
                    chômage en résolvant la problématique d’absence d’expérience professionnelle.
                </p>
            </div>
            <div class="col-md-6">
                <img src="{{ asset('assets/images/img10.avif') }}" alt="Image" class="img-fluid rounded shadow">
            </div>
        </div>
    </div><br>
    <main class="container"> 
        <div class="info-cards">
            <div class="card">
                <h3> <i class="fas fa-bullseye text-primary me-2"></i>Objectifs</h3>
                <p>Découvrez nos objectifs ambitieux, au cœur de notre engagement à fournir une plateforme de stages inégalée pour les étudiants en fin de formation, afin de les soutenir dans leur transition vers le monde professionnel et de contribuer à leur succès dans leur carrière future.</p>
                <a href="#objectifs" class="cta-button">En savoir plus</a>
            </div>
            
            <div class="card">
                <h3><i class="fas fa-eye text-primary me-2"></i>Visions</h3>
                <p>Nos visions audacieuses tracent la voie pour un avenir prometteur, où les étudiants en fin de formation trouvent leur place dans le monde professionnel grâce à notre plateforme de stages, tout en développant leurs compétences et leur réseau professionnel.</p>
                <a href="#visions" class="cta-button">En savoir plus</a>
            </div>
            
            <div class="card">
                <h3><i class="fas fa-hand-holding-heart text-primary me-2"></i>Valeurs</h3>
                <p>Nos valeurs fondamentales guident chacune de nos actions, assurant que notre plateforme offre une expérience de qualité, éthique et centrée sur les besoins des étudiants et des entreprises partenaires.</p>
                <a href="#valeurs" class="cta-button">En savoir plus</a>
            </div>
        </div>
       </main> 
</section>

<section class="qui-sommes-nous py-5">
    <div class="container">
        <h1 class="text-center mb-4 text-primary" style="font-size: 3em;">Pourquoi cette plateforme ?</h1>
        <div class="row align-items-center">
            <div class="col-md-6">
                <img src="{{ asset('assets/images/WhatsApp-Image-2025-04-01-a-11.53.25_2c78898f.jpg') }}" alt="Image" class="img-fluid rounded shadow">
            </div>
            <div class="col-md-6">
                <p style="font-size: 1.1em; text-align: justify; line-height: 1.6;">
                    StagesBENIN se propose de faciliter l’insertion professionnelle des étudiants et diplômés voire leur
                    recrutement. Nous comprenons les défis auxquels ces derniers sont confrontés lors de la transition de
                    l’université vers le monde professionnel. C’est le but de la création de cette plateforme spécialement
                    conçue pour aider à une navigation qualitative dans cette étape cruciale de votre carrière. Nous accompagnons
                    aussi les entreprises locales et internationales à avoir plus de visibilité et expérimenter la croissance
                    de leur chiffre d’affaires.
                </p>
            </div>
        </div><br>
        <main class="container"> 
        <section id="objectifs" class="section">
            <h2> <i class="fas fa-bullseye text-primary me-2"></i>Nos Objectifs</h2>
            <ul class="objectives-list">
                <li>
                    <strong>Renforcer la qualité des offres de stage</strong>
                    <p>Travailler en étroite collaboration avec les entreprises partenaires pour améliorer la qualité des descriptions d'offres de stage, en mettant l'accent sur les responsabilités, les compétences requises et les avantages offerts aux stagiaires.</p>
                    <p>Veiller à ce que les offres de stage proposées sur notre plateforme soient conformes aux normes professionnelles et offrent de réelles opportunités de développement aux candidats.</p>
                </li>
                <li>
                    <strong>Promouvoir l'employabilité des candidats</strong>
                    <p>Fournir des ressources et des conseils approfondis sur la rédaction de CV, la préparation aux entretiens et le développement des compétences clés recherchées par les employeurs.</p>
                    <p>Organiser des webinaires et des ateliers virtuels pour aider les candidats à améliorer leur employabilité et à se démarquer sur le marché du travail.</p>
                </li>
                <li>
                    <strong>Établir une communauté d'échange et de partage</strong>
                    <p>Créer un espace interactif où les candidats et les entreprises peuvent interagir, échanger des conseils, des expériences et des opportunités professionnelles.</p>
                    <p>Encourager les utilisateurs à partager leurs réussites, leurs témoignages et à créer des liens qui favorisent le réseautage et la collaboration.</p>
                </li>
                <li>
                    <strong>Établir une réputation de référence dans le domaine des stages</strong>
                    <p>Travailler à la reconnaissance de notre plateforme en tant que source fiable et de confiance pour les stages professionnels.</p>
                    <p>Collaborer avec des institutions éducatives, des organisations professionnelles et des acteurs clés du secteur pour renforcer notre crédibilité et notre visibilité.</p>
                </li>
            </ul>
        </section>
        
        <section id="visions" class="section">
            <h2><i class="fas fa-eye text-primary me-2"></i>Notre Vision</h2>
            <p>Chez StagesBENIN, nous aspirons à créer un écosystème dynamique où les talents béninois peuvent s'épanouir professionnellement. Notre vision s'articule autour de plusieurs axes fondamentaux :</p>
            <ul class="vision-list">
                <li>Devenir la plateforme de référence pour les stages au Bénin, reconnue pour la qualité de nos offres et l'efficacité de notre mise en relation</li>
                <li>Contribuer activement à la réduction du chômage des jeunes diplômés en facilitant leur insertion professionnelle</li>
                <li>Développer un réseau solide d'entreprises partenaires engagées dans la formation de la prochaine génération de professionnels</li>
                <li>Promouvoir une culture de l'excellence et de l'apprentissage continu chez les jeunes professionnels</li>
                <li>Soutenir l'innovation et l'entrepreneuriat en mettant en relation les jeunes talents avec des entreprises visionnaires</li>
            </ul>
        </section>

    </div>
</section>

        <section id="valeurs" class="section">
            <h2> <i class="fas fa-hand-holding-heart text-primary me-2"></i>Nos Valeurs</h2>
            <div class="info-cards">
                <div class="card">
                    <h3><i class="fas fa-star text-primary me-2"></i>Excellence</h3>
                    <p>Nous nous engageons à maintenir les plus hauts standards de qualité dans tous nos services et interactions.</p>
                </div>
                <div class="card">
                    <h3><i class="fas fa-universal-access text-primary me-2"></i>Accessibilité</h3>
                    <p>Nous croyons que chaque étudiant mérite une chance équitable d'accéder à des opportunités de stage de qualité.</p>
                </div>
                <div class="card">
                    <h3><i class="fas fa-lightbulb text-primary me-2"></i>Innovation</h3>
                    <p>Nous encourageons la créativité et l'adoption de nouvelles approches pour résoudre les défis d'emploi des jeunes.</p>
                </div>
                <div class="card">
                    <h3><i class="fas fa-balance-scale text-primary me-2"></i>Intégrité</h3>
                    <p>Nous agissons avec honnêteté et transparence dans toutes nos interactions avec les étudiants et les entreprises.</p>
                </div>
            </div>
        </section>
     </main>
<section class="py-5">
    <div class="container">
        <h1 class="text-center mb-4 text-primary" style="font-size: 3em;">Galerie de nos événements</h1>
        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="card shadow">
                    <img src="{{ asset('assets/images/IMG-20240904-WA0029.jpg') }}" alt="Événement 1" class="card-img-top">
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card shadow">
                    <img src="{{ asset('assets/images/IMG_4387-scaled.jpg') }}" alt="Événement 2" class="card-img-top">
                  
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card shadow">
                    <img src="{{ asset('assets/images/IMG-20240904-WA0019.jpg ') }}" alt="Événement 3" class="card-img-top">
                </div>
            </div>
        </div>
    </div>
</section>



   
    <main class="container"> 
<section class="section py-5">
    <h2 class="text-center mb-4 text-primary">Foire Aux Questions</h2>
    <div class="accordion" id="faqAccordion">
        <!-- Question 1 -->
        <div class="accordion-item">
            <h2 class="accordion-header" id="faqHeading1">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapse1" aria-expanded="true" aria-controls="faqCollapse1">
                    Qu'est-ce que StagesBENIN ?
                </button>
            </h2>
            <div id="faqCollapse1" class="accordion-collapse collapse show" aria-labelledby="faqHeading1" data-bs-parent="#faqAccordion">
                <div class="accordion-body">
                    StagesBENIN est une plateforme en ligne qui facilite la recherche de stages et d'opportunités professionnelles
                    pour les étudiants et les jeunes professionnels au Bénin. Elle met en relation les étudiants avec des entreprises offrant des stages de qualité
                    et assure le référencement web des entreprises pour leur donner une visibilité sur les moteurs de recherche.
                </div>
            </div>
        </div>
        <!-- Question 2 -->
        <div class="accordion-item">
            <h2 class="accordion-header" id="faqHeading2">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapse2" aria-expanded="false" aria-controls="faqCollapse2">
                    Comment puis-je m'inscrire sur StagesBENIN ?
                </button>
            </h2>
            <div id="faqCollapse2" class="accordion-collapse collapse" aria-labelledby="faqHeading2" data-bs-parent="#faqAccordion">
                <div class="accordion-body">
                    Pour vous inscrire sur StagesBénin, rendez-vous sur notre site web, cliquez sur « Inscription » et suivez les étapes pour créer un compte.
                    Vous devrez fournir des informations de base et télécharger votre CV si vous êtes candidat et des détails sur votre entreprise si vous êtes employeur.
                </div>
            </div>
        </div>
        <div class="accordion-item">
            <h2 class="accordion-header" id="faqHeading3">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapse3" aria-expanded="false" aria-controls="faqCollapse3">
  Qui peut s'inscrire sur StagesBENIN ?
                </button>
            </h2>
            <div id="faqCollapse3" class="accordion-collapse collapse" aria-labelledby="faqHeading3" data-bs-parent="#faqAccordion">
                <div class="accordion-body">
                    La plateforme est ouverte aux étudiants, aux jeunes professionnels, aux entreprises et aux organisations qui cherchent à proposer des stages ou à recruter des stagiaires au Bénin.
                </div>
            </div>
        </div>

        <div class="accordion-item">
            <h2 class="accordion-header" id="faqHeading4">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapse4" aria-expanded="false" aria-controls="faqCollapse4">
                  Comment puis-je rechercher des offres de stage sur StagesBENIN ?
                </button>
            </h2>
            <div id="faqCollapse4" class="accordion-collapse collapse" aria-labelledby="faqHeading4" data-bs-parent="#faqAccordion">
                <div class="accordion-body">
                   Une fois connecté à votre compte, vous pouvez utiliser notre MENU de recherche pour trouver des offres de stage. Vous pouvez filtrer les résultats par domaine, par lieu, par niveau de formation, etc. 
                </div>
            </div>
        </div>
        <div class="accordion-item">
            <h2 class="accordion-header" id="faqHeading5">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapse5" aria-expanded="false" aria-controls="faqCollapse5">
                  Comment les entreprises postent-elles des annonces sur StagesBENIN ?
                </button>
            </h2>
            <div id="faqCollapse5" class="accordion-collapse collapse" aria-labelledby="faqHeading5" data-bs-parent="#faqAccordion">
                <div class="accordion-body">
    Les entreprises peuvent créer un compte entreprise sur StagesBénin, puis publier leurs annonces à travers le MENU CREER ANNONCE disponible sur leur tableau de bord. Elles peuvent décrire les missions, les qualifications requises et les avantages offerts aux stagiaires.
                </div>
            </div>
        </div>
        <div class="accordion-item">
            <h2 class="accordion-header" id="faqHeading6">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapse6" aria-expanded="false" aria-controls="faqCollapse6">
                    Les stages sont-ils rémunérés sur StagesBENIN ?
                </button>
            </h2>
            <div id="faqCollapse6" class="accordion-collapse collapse" aria-labelledby="faqHeading6" data-bs-parent="#faqAccordion">
                <div class="accordion-body">
La rémunération des stages varie en fonction des offres proposées par les entreprises. Certaines offres de stage peuvent être rémunérées, tandis que d’autres peuvent être non rémunérées. Les détails sont généralement inclus dans la description de l’offre.
                </div>
            </div>
        </div>

        <div class="accordion-item">
            <h2 class="accordion-header" id="faqHeading7">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapse7" aria-expanded="false" aria-controls="faqCollapse7">
Puis-je postuler à plusieurs offres de stage en même temps ?
                </button>
            </h2>
            <div id="faqCollapse7" class="accordion-collapse collapse" aria-labelledby="faqHeading7" data-bs-parent="#faqAccordion">
                <div class="accordion-body">
                   Oui, vous pouvez postuler à autant d’offres de stage que vous le souhaitez, tant que vous répondez aux critères de qualification requis pour chaque offre.
                </div>
            </div>
        </div>

        <div class="accordion-item">
            <h2 class="accordion-header" id="faqHeading8">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapse8" aria-expanded="false" aria-controls="faqCollapse8">
                   Comment puis-je mettre à jour mon profil sur StagesBENIN ?
                </button>
            </h2>
            <div id="faqCollapse8" class="accordion-collapse collapse" aria-labelledby="faqHeading8" data-bs-parent="#faqAccordion">
                <div class="accordion-body">
        Vous pouvez mettre à jour votre profil en vous connectant à votre compte et en cliquant sur « Mon Profil ». Vous pourrez alors modifier vos informations personnelles, télécharger de nouvelles versions de votre CV, etc.
                </div>
            </div>
        </div>

        <div class="accordion-item">
            <h2 class="accordion-header" id="faqHeading9">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapse9" aria-expanded="false" aria-controls="faqCollapse9">
                    Comment puis-je contacter le support technique de StagesBENIN en cas de problème ?
                </button>
            </h2>
            <div id="faqCollapse9" class="accordion-collapse collapse" aria-labelledby="faqHeading9" data-bs-parent="#faqAccordion">
                <div class="accordion-body">
                    Pour contacter notre équipe d’assistance, vous pouvez utiliser la page de contact sur notre site web, où vous pourrez soumettre une demande d’assistance et obtenir de l’aide en cas de problème technique.
                </div>
            </div>
        </div>

        <div class="accordion-item">
            <h2 class="accordion-header" id="faqHeading10">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapse10" aria-expanded="false" aria-controls="faqCollapse10">
                   StagesBENIN propose-t-il d'autres services en plus des offres de stage ?
                </button>
            </h2>
            <div id="faqCollapse10" class="accordion-collapse collapse" aria-labelledby="faqHeading10" data-bs-parent="#faqAccordion">
                <div class="accordion-body">
                    Oui, StagesBENIN propose également des services de formation, de conseil en insertion professionnelle et d’orientation de carrière pour aider les étudiants à développer leurs compétences et à réussir leur transition vers le monde professionnel.
StagesBENIN propose un service de référencement web des entreprises afin de leur assurer une visibilité sur les moteurs des recherches dont les avantages sont énormes.
                </div>
            </div>
        </div>
        <!-- Ajouter d'autres questions de la même manière -->
            <div class="accordion-item">
            <h2 class="accordion-header" id="faqHeading11">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapse11" aria-expanded="false" aria-controls="faqCollapse11">
                  Quels sont nos objectifs en tant que plateforme de stages ?
                </button>
            </h2>
            <div id="faqCollapse11" class="accordion-collapse collapse" aria-labelledby="faqHeading11" data-bs-parent="#faqAccordion">
                <div class="accordion-body">
                    Découvrez nos objectifs ambitieux, au cœur de notre engagement à fournir une plateforme de stages inégalée pour les étudiants en fin de formation, afin de les soutenir dans leur transition vers le monde professionnel et de contribuer à leur succès dans leur carrière future.
                </div>
            </div>
        </div>

                <div class="accordion-item">
            <h2 class="accordion-header" id="faqHeading12">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapse12" aria-expanded="false" aria-controls="faqCollapse12">
                  Quelles sont nos visions pour le développement des étudiants en fin de formation ?
                </button>
            </h2>
            <div id="faqCollapse12" class="accordion-collapse collapse" aria-labelledby="faqHeading12" data-bs-parent="#faqAccordion">
                <div class="accordion-body">
                    Nos visions audacieuses tracent la voie pour un avenir prometteur, où les étudiants en fin de formation trouvent leur place dans le monde professionnel grâce à notre plateforme de stages, tout en développant leurs compétences et leur réseau professionnel.
                </div>
            </div>
        </div>    
    
    </div>


</section>

    </main>

































 <style>
        :root {
            --primary-color: #0056b3;
            --secondary-color: #17a2b8;
            --accent-color: #ffc107;
            --dark-color: #343a40;
            --light-color: #f8f9fa;
            --transition: all 0.3s ease;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f5f5f5;
        }
        
        .container {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }
        
       
        
        h1 {
            font-size: 2.5rem;
            margin-bottom: 1rem;
        }
        
        .tagline {
            font-size: 1.2rem;
            font-style: italic;
            margin-bottom: 1rem;
        }
        
        .section {
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
            padding: 2rem;
            margin-bottom: 2rem;
            transition: var(--transition);
        }
        
        .section:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.15);
        }
        
        h2 {
            color: var(--primary-color);
            margin-bottom: 1.5rem;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid var(--accent-color);
        }
        
        .info-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            margin-bottom: 2rem;
        }
        
        .card {
            background: var(--light-color);
            border-radius: 8px;
            padding: 1.5rem;
            border-left: 4px solid var(--primary-color);
            transition: var(--transition);
        }
        
        .card:hover {
            transform: translateY(-3px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        
        .card h3 {
            color: var(--primary-color);
            margin-bottom: 1rem;
        }
        
        .faq {
            margin-bottom: 2rem;
        }
        
        .faq-item {
            margin-bottom: 1.5rem;
            border-bottom: 1px solid #eee;
            padding-bottom: 1rem;
        }
        
        .faq-question {
            font-weight: bold;
            color: var(--dark-color);
            margin-bottom: 0.5rem;
        }
        
        .faq-answer {
            padding-left: 1rem;
        }
        
        .objectives-list li, .vision-list li {
            margin-bottom: 1rem;
            list-style-type: none;
            padding-left: 1.5rem;
            position: relative;
        }
        
        .objectives-list li:before, .vision-list li:before {
            content: "•";
            color: var(--accent-color);
            font-weight: bold;
            position: absolute;
            left: 0;
        }
        
        .cta-button {
            display: inline-block;
            background-color: var(--primary-color);
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
            transition: var(--transition);
            margin-top: 1rem;
        }
        
        .cta-button:hover {
            background-color: var(--secondary-color);
            transform: scale(1.05);
        }
        
       
        
        /* Responsive adjustments */
        @media (max-width: 768px) {
            h1 {
                font-size: 2rem;
            }
            
            .info-cards {
                grid-template-columns: 1fr;
            }
            
            .section {
                padding: 1.5rem;
            }
        }
    </style> 
@endsection
