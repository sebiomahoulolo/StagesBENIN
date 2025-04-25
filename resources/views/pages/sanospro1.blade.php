
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: white;
        }

        header {
            background: #0000ff !important;
        }
   body {
        font-family: 'Times New Roman', Times, serif;
    }
        .navbar {
            background-color: white;
        }
        
        .navbar-brand, .nav-link {
            color: #0000ff;
            font-weight: bold;
            font-size: 12px;
        }

        .navbar-brand {
            font-family: 'Arial Black', sans-serif;
            font-weight: bold;
            font-size: 26px;
            color: #0000FF;
        }
        .navbar-brand span {
            color: #0000FF;
            margin-left: -80px;
            font-size: 2rem;
        }

        .p{
            text-align: center;
            font-size: 1.5rem;
        }

        .hero {
        background-image: url('ecole.avif'); /* Remplace par ton image */
        background-size: cover;
        background-position: center;
        height: 100vh;
        position: relative;
        }

        .overlay {
        background: rgba(0, 0, 0, 0.6); /* Voile noir transparent */
        width: 100%;
        height: 100%;
        position: absolute;
        top: 0;
        left: 0;
        display: flex;
        align-items: center;
        justify-content: flex-start; /* Aligne à gauche */
        padding-left: 5%; /* Espace par rapport au bord gauche */
        }

        .hero-content {
        color: white;
        max-width: 600px;
        }

        .hero h1 {
        font-size: 3em;
        font-weight: bold;
        margin-bottom: 20px;
        }

        .hero p {
        font-size: 1.2em;
        margin-bottom: 20px;
        }

        .cta-button {
        padding: 10px 20px;
        font-size: 1.1em;
        background-color: #007bff;
        color: white;
        text-decoration: none;
        border-radius: 5px;
        display: inline-block;
        transition: background-color 0.3s ease;
        }

        .cta-button:hover {
        background-color: #0056b3;
        }

        .qui-sommes-nous {
            padding: 50px 0;
        }

        .container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 30px;
        }

        .text-section {
            width: 50%;
            padding-right: 30px;
        }

        .text-section p {
            font-size: 1.1em;
            color: black;
            line-height: 1.6;
            text-align: justify;
        }

        .image-section {
            width: 50%;
        }

        .image-section img {
            width: 100%;
            height: auto;
            border-radius: 8px;

        }

        .objectifs-section {
  padding: 60px 20px;
  background-color: #fff;
  font-family: 'Segoe UI', sans-serif;
}

.objectifs-section .container {
  display: flex;
  align-items: center;
  justify-content: space-between;
  max-width: 1200px;
  margin: auto;
  flex-wrap: wrap;
}

.objectifs-section .content {
display: flex;  min-width: 300px;
}

.objectifs-section h1 {
  font-size: 2.5rem;
  font-weight: bold;
  color: #0000ff;
  margin-bottom: 30px;
}

.objectifs-section ul {
  list-style: none;
  padding: 0;
}

.objectifs-section li {
  margin-bottom: 20px;
  font-size: 1.1rem;
  display: flex;
  align-items: flex-start;
  color: #333;
}

.objectifs-section li i {
  color: #007bff;
  margin-right: 10px;
  font-size: 1.2rem;
  margin-top: 4px;
}

.objectifs-section .illustration {
  flex: 1;
  display: flex;
  justify-content: center;
  min-width: 300px;
}

.objectifs-section .illustration img {
  max-width: 80%;
  height: auto;

}


        /* Animation fade-in */
@keyframes fadeIn {
    0% {
        opacity: 0;
        transform: translateY(20px);
    }
    100% {
        opacity: 1;
        transform: translateY(0);
    }
}

.fade-section {
    opacity: 0;
    animation: fadeIn 1.5s ease-in-out forwards;
}

/* Optionnel : petit décalage pour un effet en cascade */
.fade-delay-1 {
    animation-delay: 0.3s;
}
.fade-delay-2 {
    animation-delay: 0.6s;
}
.fade-delay-3 {
    animation-delay: 0.9s;
}

.formations-section {
  padding: 60px 20px;
  background-color: #f9f9f9;
  text-align: center;
  font-family: 'Segoe UI', sans-serif;
}

.section-title h2 {
  font-size: 2.5rem;
  margin-bottom: 10px;
  color: #333;
}

.section-title p {
  font-size: 1.1rem;
  color: #555;
  margin-bottom: 40px;
}

.formations-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
  gap: 30px;
  max-width: 1200px;
  margin: auto;
}

.formation-card {
  background-color: #fff;
  padding: 30px 20px;
  border-radius: 15px;
  box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
  transition: transform 0.3s ease;
}

.formation-card:hover {
  transform: translateY(-10px);
}

.formation-card i {
  font-size: 2.5rem;
  color: #007bff;
  margin-bottom: 15px;
}

.formation-card h3 {
  font-size: 1.3rem;
  color: #222;
  margin-bottom: 10px;
}

.formation-card p {
  font-size: 1rem;
  color: #555;
}


    </style>



    <section class="hero fade-section fade-delay-1">
    <div class="overlay">
    <div class="hero-content">
      <h1>Les Ecoles de SaNOSPro</h1>
      <p>
        <strong>StagesBENIN</strong> lance <strong>Les Ecole de SaNOSPRO</strong>, un programme de formation pratique
        pour renforcer l’employabilité des jeunes durant les congés et vacances scolaires.
      </p>
      <a href="#" class="cta-button">VOIR TOUT LES DETAILS</a>
    </div>
  </div>
</section>

<section class="qui-sommes-nous fade-section fade-delay-2">
        <div class="container">
            <div class="text-section">
            <h1 style="font-size: 2.5em;
            color: #0000ff;
            margin-bottom: 20px;
            font-weight: bold;
            text-align: left;">Une Formation Pratique pour l’Avenir des Jeunes !</h1>  
                <p>Dans un contexte où l’insertion professionnelle des jeunes constitue un enjeu majeur, 
                    StagesBENIN, à travers son programme Salon National d’Orientation et de Stage Professionnel 
                    (SaNOSPRO), initie un projet innovant visant à accompagner les apprenants et étudiants durant 
                    les congés et vacances scolaires. L’objectif principal est de leur offrir une formation pratique 
                    dans plusieurs domaines stratégiques afin de renforcer leurs compétences et d’accroître leur 
                    employabilité. Ce projet permettra également de promouvoir la marque StagesBENIN en tant 
                    qu’acteur incontournable de la formation et de l’accompagnement professionnel.
                </p>
            </div>
            <div class="image-section">
                <img src="jeunes.jpg" alt="Image" />
            </div>
        </div>
    </section>


    <section class="objectifs-section fade-section fade-delay-3"">
        <div class="container">
            <div class="content">
                    
                <div class="text-section">
                    <h1>Nos objectifs sont clairs</h1>
                    <ul>
                        <li>
                        <i class="fas fa-bullseye"></i>
                        Offrir une formation de qualité dans des domaines stratégiques tels que l'informatique, le marketing digital, les ressources humaines, la maîtrise des logiciels comptables et le développement web.
                        </li>
                        <li>
                        <i class="fas fa-bullseye"></i>
                        Permettre aux jeunes de développer des compétences pratiques en lien avec les besoins du marché du travail.
                        </li>
                        <li>
                        <i class="fas fa-bullseye"></i>
                        Favoriser l'insertion professionnelle des participants à travers des formations certifiantes.
                        </li>
                        <li>
                        <i class="fas fa-bullseye"></i>
                        Promouvoir l'image et la notoriété de StagesBENIN en tant que structure d'accompagnement des jeunes vers l'emploi.
                        </li>
                    </ul>
                </div>
        
            </div>
   
        </div>
</section>


<section class="formations-section">
  <div class="section-title">
    <h1>Domaines de formation</h1>
    <p>Boostez vos compétences avec SaNOSPRO !<br>
StagesBENIN vous offre des formations pratiques en informatique, marketing digital, ressources humaines, comptabilité et développement web. Profitez des congés et vacances pour renforcer votre employabilité avec des formations certifiantes adaptées aux besoins du marché !</p>
  </div>
  <div class="formations-grid">
    <div class="formation-card">
      <i class="fas fa-desktop"></i>
      <h3>Informatique</h3>
      <p>Acquérez des compétences techniques solides en informatique pour le monde professionnel.</p>
    </div>
    <div class="formation-card">
      <i class="fas fa-bullhorn"></i>
      <h3>Marketing digital</h3>
      <p>Maîtrisez les outils du marketing numérique pour booster la visibilité des marques.</p>
    </div>
    <div class="formation-card">
      <i class="fas fa-users"></i>
      <h3>Ressources Humaines</h3>
      <p>Développez vos compétences en gestion du personnel et en relations humaines.</p>
    </div>
    <div class="formation-card">
      <i class="fas fa-calculator"></i>
      <h3>Logiciels Comptables</h3>
      <p>Apprenez à utiliser les logiciels de comptabilité les plus demandés.</p>
    </div>
    <div class="formation-card">
      <i class="fas fa-code"></i>
      <h3>Développement Web</h3>
      <p>Créez des sites et applications web modernes avec les technologies les plus récentes.</p>
    </div>
  </div>
</section>



<section class="objectifs-section fade-section fade-delay-3">
        <div class="container">
            <div class="content">
                    
                <div class="text-section">
                    <h1>Conditions D'accès</h1>
                
                    <ul>
                        <p>Le projet s'adresse aux jeunes remplissant les conditions suivantes :</p><br>
                        <li>
                        <i class="fa-solid fa-check"></i></i>
                        Être âgé de 18 à 28 ans.
                        </li>
                        <li>
                        <i class="fa-solid fa-check"></i></i>
                        Être ouvert d'esprit et curieux.
                        </li>
                        <li>
                        <i class="fa-solid fa-check"></i></i>                       
                        Avoir le Baccalauréat ou un diplôme équivalent.
                        </li>
                        <li>
                        <i class="fa-solid fa-check"></i></i>
                        Disposer d'un ordinateur pour participer aux activités de formation.
                        </li>
                        <i class="fa-solid fa-check"></i></i>
                        S'acquitter des frais d'inscription de 10 000 F, à payer à l'inscription.
                        </li>
                        <i class="fa-solid fa-check"></i></i>
                        Chaque lot de formation sera composé de 20 participants.
                        </li>
                    </ul>
                </div>
        
            </div>
   
        </div>
</section>


<section class="objectifs-section fade-section fade-delay-3"">
        <div class="container">

        <h1>Périodes et Modalités de Formation</h1>

            <div class="content">
                <div class="text-section">
                
                    <ul>
                        <p>Les formations se feront comme suit:</p><br>
                        <li>
                        <i class="fa-solid fa-check"></i></i>
                        École de Pâques : Formation pendant les vacances de Pâques. (Du 21 Avril au 25 Avril 2025)
                        </li>
                        <li>
                        <i class="fa-solid fa-check"></i></i>
                        École de Vacances : Formation pendant les grandes vacances. (Du 30 Juin au 04 Juillet 2025)                        </li>
                        <li>
                    </ul>
                </div>

                <div class="text-section">
                
                <ul>
                    <li>
                    <i class="fa-solid fa-check"></i></i>
                    Durée : Les formations se dérouleront sur une période de 30 heures.
                    </li>
                    <li>
                    <i class="fa-solid fa-check"></i></i>
                    Format : Sessions en présentiel et/ou en ligne selon les disponibilités des participants.                    </li>
                    <li>
                    <i class="fa-solid fa-check"></i></i>                       
                    Encadrement : Des formateurs expérimentés seront mobilisés pour assurer un suivi pédagogique rigoureux.                    </li>
                    <li>
                    <i class="fa-solid fa-check"></i></i>
                    Attestation : Une attestation de participation sera délivrée à chaque participant à la fin du programme.
                    </li>
                </ul>
                </div>

            </div>
            <a href="#"style="font-weight: bold;
        background-color: #007bff; padding: 20px;
        text-decoration: none;
        color: white;">S'INSCRIRE MAINTENANT</a>
        </div>
</section>