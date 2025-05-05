@extends('layouts.layout')

@section('title', 'StagesBENIN')

@section('content')
<div style=" background-image: url('{{ asset('assets/images/Outils-de-recrutements.png') }}'); background-size: cover; background-attachment: fixed;">
<div style="text-align: center; padding: 20px;">
    <p style="font-size: 17px; font-weight: bold; color: rgb(14, 40, 145); display: inline;">
        Le moyen le plus simple d'obtenir
    </p>
    <p id="animatedText" style="font-size: 17px; font-weight: bold; color:rgb(14, 40, 145); display: inline;"></p>
</div>
<div style="display: flex; justify-content: center; align-items: center; text-align: center;">
    <p style="font-size: 16px; color:rgb(14, 40, 145); line-height: 1.5;">
        Trouvez votre chemin vers une carrière épanouissante grâce à notre plateforme de recrutement et d’insertion professionnelle, 
        où les opportunités s’ouvrent à vous et les talents sont valorisés.
    </p>
</div>
<div class="container mt-4">
    <!-- Barre de recherche -->
    <div class="row mb-4">
        <div class="col-md-8 mx-auto">
            <div class="input-group">
                <input type="text" class="form-control" placeholder="Rechercher un stage, une entreprise...">
                <button class="btn btn-primary">Rechercher</button>
            </div>
        </div>
    </div>
<div class="text-center my-4">
  <a href="{{ route('login') }}" class="btn btn-primary px-4 py-2 fw-bold rounded">RECRUTER EMPLOYE / STAGIAIRE</a><br><br>
</div>
</div>
</div>






<script>
const messages = [
    "votre stage professionnel !.",
    "vos futurs cadres !.",
    "le stage de vos rêves !."
];

let messageIndex = 0;
let charIndex = 0;
const textContainer = document.getElementById("animatedText");

function typeWriterEffect() {
    if (charIndex < messages[messageIndex].length) {
        textContainer.innerHTML += messages[messageIndex].charAt(charIndex);
        charIndex++;
        setTimeout(typeWriterEffect, 50);
    } else {
        setTimeout(() => {
            textContainer.innerHTML = "";  
            charIndex = 0;
            messageIndex = (messageIndex + 1) % messages.length;
            typeWriterEffect();
        }, 2000);
    }
}

typeWriterEffect();
</script>

    <div class="row">
   <!-- Dernières Publications -->
<div class="col-md-4">
    <div class="card shadow-lg">
        <div class="card-header bg-primary text-white text-center">
            💼Dernières offres disponibles (<h5 style="color: white; display: inline;">{{ $nombre_offres ?? 0 }}</h5>)
        </div>
        <div class="card-body text-start"> <!-- Alignement à gauche -->
            @if(isset($annonces) && $annonces->count() > 0)
                <ul class="list-unstyled">
                    @foreach($annonces as $annonce)
                        <li class="text-primary fw-bold">
                            {{ $annonce->nom_du_poste }} ({{ $annonce->type_de_poste }})
                        </li>
                    @endforeach
                </ul>
            @else
                <p class="text">Aucune offre n'est disponible pour le moment.</p>
            @endif
        </div>
        <div class="card-footer text-center">
            <a href=" {{ route('etudiants.offres.index') }}" class="btn btn-outline-primary">Consulter</a>
        </div>
    </div>
</div>

<!-- Section des Événements -->
<div class="col-md-4">
    <div class="card shadow-lg">
        <div class="card-header bg-primary text-white text-center">
            📅 Événements à venir (<h5 style="color: white; display: inline;">{{ $nombre_events ?? 0 }}</h5>)
        </div>
        <div class="card-body text-start"> <!-- Alignement à gauche -->
            @if(isset($evenements) && $evenements->count() > 0)
    <ul class="list-unstyled">
      
        @foreach($evenements as $evenement)
            <li class="text-primary fw-bold">{{ $evenement->title }}</li>
        @endforeach
    </ul>
@else
    <p class="text">Aucun événement n'est disponible pour le moment.</p>
@endif

        </div>
        <div class="card-footer text-center">
            <a href="{{ route('pages.evenements') }}" class="btn btn-outline-primary">Voir plus</a>
        </div>
    </div>
</div>


  <!-- Section des Actualités -->
<div class="col-md-4">
    <div class="card shadow-lg">
        <div class="card-header bg-primary text-white text-center">
            📰 Actualités (<h5 style="color: white; display: inline;">{{ $nombre_actualites }}</h5>)
        </div>
     <div class="card-body text-center">
    @if(isset($nombre_actualites) && $nombre_actualites > 0)
        <ul class="list-unstyled text-start"> <!-- Alignement à gauche -->
            @foreach($actualites as $actualite)
                <li class="text-primary fw-bold">{{ $actualite->titre }}</li> <!-- Titres en bleu et en gras -->
            @endforeach
        </ul>
    @else
        <p class="text">Aucune actualité n'est disponible pour le moment.</p> <!-- Message en rouge -->
    @endif
</div>

                <div class="card-footer text-center">
                    <a href="{{ route('pages.actualites') }}
" class="btn btn-outline-primary">Voir plus</a>
                </div>
            </div>
        </div>
    </div>
</div>
<br>
<section class="catalogue-section py-5" style="background-color:rgb(226, 226, 229);; background-size: cover; background-position: center; background-repeat: no-repeat;">
  <div class="container">
    <h5 class="catalogue-title text-center fw-bold mb-4 ">Catalogue des Entreprises</h5>
    <div class="row align-items-center">
      <!-- Texte à gauche -->
      <div class="col-md-6">
        <p class="fs-5">
          Explorez une sélection prestigieuse d'entreprises leaders dans leurs domaines respectifs. Chacune d'elles 
          incarne l'innovation, l'excellence et la vision stratégique. Ce catalogue est votre porte d'accès à des partenaires 
          fiables et des solutions adaptées à vos besoins, peu importe votre secteur ou vos ambitions.
        </p>
        <a href="{{ route('pages.catalogue') }}" class="btn btn-lg btn-primary shadow">Découvrir le Catalogue</a>
      </div>
      <!-- Image à droite -->
      <div class="col-md-6 text-center">
        <img src=" {{ asset('assets/images/besoins-en-recrutement.jpeg') }}" alt="Illustration Catalogue" class="img-fluid rounded shadow">
      </div>
    </div>
  </div>
</section>








<section class="services-section py-5" style="background-color:rgb(193, 220, 247);">
  <div class="container">
    <h2 class="services-title text-center fw-bold mb-4 text-primary">Nos Services</h2>
    
    <!-- Row: Service Description -->
    <div class="row align-items-center mb-5">
      <!-- Image à gauche -->
      <div class="col-md-6 text-center">
        <img src="{{ asset('assets/images/R.jpg') }}" alt="Illustration des Services" class="img-fluid rounded shadow">
      </div>
      
      <!-- Texte à droite -->
      <div class="col-md-6">
        <p class="fs-5">
          StagesBENIN est une entreprise spécialisée dans l’insertion professionnelle et la visibilité digitale des entreprises. 
      </p>
        <p class="fs-5 mb-4">
          Nos packs, adaptés aux besoins des entreprises et des candidats, incluent des services tels que la CV thèque, 
          campagnes digitales, études de marché, création d'entreprise, et bien plus encore.
        </p>
        <a href="{{ route('pages.services') }}" class="btn btn-lg btn-primary shadow">Voir Plus</a>
      </div>
    </div>
  </div>
</section>

<div class="software-card">
    <h2>Logiciels à vendre <button class="sell-btn">Vendre mes logiciels</button></h2>   
    <div class="software-list">
        <div class="no-software">
            <p>Aucun logiciel n'est disponible pour le moment.</p>
        </div>
    </div>
</div>



<section class="partenaires-section py-5">
  <div class="container">
    <h2 class="partenaires-title text-center fw-bold mb-4" style ="color: #007bff; ">Nos Partenaires</h2>
    <h5 class="partenaires-title text-center fw-bold mb-4" style ="color:rgb(23, 23, 23); ">Ceux qui nous ont déjà fait confiance</h5>

    <div id="partenairesCarousel" class="carousel slide" data-bs-ride="carousel">
      <div class="carousel-inner">
        <!-- Première slide -->
        <div class="carousel-item active">
          <div class="d-flex justify-content-center gap-4 p-4 border rounded bg-light shadow">
            <img src="{{ asset('assets/images/unnamed-file-6-150x150.webp') }}" alt="Partenaire 1" class="img-fluid" style="max-height: 100px;">
            <img src="{{ asset('assets/images/unnamed-file-3-150x150.webp') }}" alt="Partenaire 2" class="img-fluid" style="max-height: 100px;">
            <img src="{{ asset('assets/images/nikola-ets-150x150.webp') }}" alt="Partenaire 3" class="img-fluid" style="max-height: 100px;">
            <img src="{{ asset('assets/images/Racines-Affro-150x150.png') }}" alt="Partenaire 4" class="img-fluid" style="max-height: 100px;">
            <img src="{{ asset('assets/images/Df-fifatin-150x150.png') }}" alt="Partenaire 5" class="img-fluid" style="max-height: 100px;">
            <img src="{{ asset('assets/images/sedric-Sarl-150x150.png') }}" alt="Partenaire 6" class="img-fluid" style="max-height: 100px;">
                      <img src="{{ asset('assets/images/nnnnnn-1-150x150.webp') }}" alt="Partenaire 7" class="img-fluid" style="max-height: 100px;">
            <img src="{{ asset('assets/images/unnamed-file-3-150x150.webp') }}" alt="Partenaire 8" class="img-fluid" style="max-height: 100px;">
          </div>
        </div>

        <!-- Deuxième slide -->
        <div class="carousel-item">
          <div class="d-flex justify-content-center gap-4 p-4 border rounded bg-light shadow">
                      <img src="{{ asset('assets/images/sedric-Sarl-150x150.png') }}" alt="Partenaire 9" class="img-fluid" style="max-height: 100px;">
<img src="{{ asset('assets/images/Dame-immo-150x150.png') }}" alt="Partenaire 7" class="img-fluid" style="max-height: 100px;">
            <img src="{{ asset('assets/images/Df-fifatin-150x150.png') }}" alt="Partenaire 10" class="img-fluid" style="max-height: 100px;">
            <img src="{{ asset('assets/images/sedric-Sarl-150x150.png') }}" alt="Partenaire 11" class="img-fluid" style="max-height: 100px;">
            <img src="{{ asset('assets/images/unnamed-file-6-150x150.webp') }}" alt="Partenaire 12" class="img-fluid" style="max-height: 100px;">
            <img src="{{ asset('assets/images/007-Security-150x150.png') }}" alt="Partenaire 13" class="img-fluid" style="max-height: 100px;">
          <img src="{{ asset('assets/images/Racines-Affro-150x150.png') }}" alt="Partenaire 14" class="img-fluid" style="max-height: 100px;">
            <img src="{{ asset('assets/images/Df-fifatin-150x150.png') }}" alt="Partenaire 15" class="img-fluid" style="max-height: 100px;">
          </div>
        </div>

        
        

      <!-- Flèches de navigation -->
      <button class="carousel-control-prev" type="button" data-bs-target="#partenairesCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#partenairesCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
      </button>
    </div>
  </div>
</section>



<div class="container">
  <div class="row">
    <!-- Nos Statistiques Section -->
    <div class="col-md-6">
      <section class="statistiques-section py-5 text-center bg-light rounded shadow">
        <div class="container">
          <h2 class="fw-bold mb-4" style ="color: #007bff; ">Nos Statistiques</h2>
          <div class="row">
            <div class="col-md-6 mb-4">
              <div class="stat-box p-4 border rounded bg-white shadow d-flex align-items-center">
                <i class="fas fa-briefcase fa-3x text-primary me-3"></i>
                <div>
                  <h3 class="stat-count mt-2" data-target="2000">+ 0</h3>
                  <p class="fw-bold">Stages disponibles</p>
                </div>
              </div>
            </div>
            <div class="col-md-6 mb-4">
              <div class="stat-box p-4 border rounded bg-white shadow d-flex align-items-center">
                <i class="fas fa-users fa-3x text-success me-3"></i>
                <div>
                  <h3 class="stat-count mt-2" data-target="500"> + 0</h3>
                  <p class="fw-bold">Candidats inscrits</p>
                </div>
              </div>
            </div>
            <div class="col-md-6 mb-4">
              <div class="stat-box p-4 border rounded bg-white shadow d-flex align-items-center">
                <i class="fas fa-user-check fa-3x text-warning me-3"></i>
                <div>
                  <h3 class="stat-count mt-2" data-target="350">+ 0</h3>
                  <p class="fw-bold">Candidats insérés</p>
                </div>
              </div>
            </div>
            <div class="col-md-6 mb-4">
              <div class="stat-box p-4 border rounded bg-white shadow d-flex align-items-center">
                <i class="fas fa-hourglass-half fa-3x text-danger me-3"></i>
                <div>
                  <h3 class="stat-count mt-2" data-target="1500">+ 0</h3>
                  <p class="fw-bold">Reste à insérer</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>




    <!-- Ils Nous Font Confiance Section -->
    <div class="col-md-6">
      <section class="temoignages-section py-5 text-center">
        <div class="container">
          <h2 class="fw-bold mb-4" style ="color: #007bff; ">Ils nous font confiance</h2>
          <div id="temoignagesCarousel" class="carousel slide" data-bs-ride="carousel">
          
           <p>  Découvrez les témoignages de nos partenaires entreprises et des candidats qui ont trouvé des stages professionnels grâce à Stages Bénin et qui sont pleinement satisfaits de leur expérience.   </p>
            <div class="carousel-inner">
            
              <div class="carousel-item active">
                <div class="testimonial border rounded p-4 bg-light shadow-sm">
                <h6 style ="color: #007bff; ">Ex candidat</h6>
                  <p>"StagesBENIN nous a permis de trouver des stagiaires hautement qualifiés, correspondant parfaitement à nos besoins. Leur plateforme est efficace et nous sommes très satisfaits des résultats obtenus."</p>
                  <img src="{{ asset('assets/images/111.png') }}" alt="Image Description" class="card-img-top rounded-circle" style="width: 150px; height: 150px; object-fit: cover;">
                  <h5>Duolicasse A. Comptable</h5>
                <h6>Comptable</h6>
                  <div class="stars">⭐⭐⭐⭐⭐</div>
                </div>
              </div>

             
              <div class="carousel-item">
                <div class="testimonial border rounded p-4 bg-light shadow-sm">
                <h6 style ="color:rgb(246, 29, 231); ">Recruteur</h6>
                  <p>"Grâce à StagesBENIN, nous avons trouvé des stagiaires compétents qui ont apporté une réelle valeur ajoutée à notre entreprise. Nous sommes pleinement satisfaits de notre expérience et nous continuerons à utiliser leur plateforme pour recruter de futurs talents."</p>
                      <img src="{{ asset('assets/images/Racines-Affro.png') }}" alt="Image Description" class="card-img-top rounded-circle" style="width: 150px; height: 150px; object-fit: cover;">
                  <h5>Racines</h5>
                  <h6>AFFRO</h6>
                  <div class="stars">🌟🌟🌟🌟🌟</div>
                </div>
              </div>
              <div class="carousel-item">
                <div class="testimonial border rounded p-4 bg-light shadow-sm">
                <h6 style ="color:rgb(246, 29, 231); ">Recruteur</h6>
                  <p>"StagesBENIN nous a permis de trouver des stagiaires hautement qualifiés, correspondant parfaitement à nos besoins. Leur plateforme est efficace et nous sommes très satisfaits des résultats obtenus."</p>
                      <img src="{{ asset('assets/images/Dame-immo.png') }}" alt="Image Description" class="card-img-top rounded-circle" style="width: 150px; height: 150px; object-fit: cover;">
                   <h5>DAME </h5>
                <h6>IMMO</h6>
                  <div class="stars">🌟🌟🌟🌟</div>
                </div>
              </div>
               <div class="carousel-item">
                <div class="testimonial border rounded p-4 bg-light shadow-sm">
                <h6 style ="color:#007bff; ">Ex candidat</h6>
                  <p>"StagesBENIN m'a permis de décrocher un stage qui a été une expérience précieuse pour mon développement professionnel. Je recommande fortement leur plateforme pour trouver des opportunités de stage de qualité."</p>
                      <img src="{{ asset('assets/images/222.png') }}" alt="Image Description" class="card-img-top rounded-circle" style="width: 150px; height: 150px; object-fit: cover;">
                  <h5>Kouêtè T.</h5>
                  <h6>Secrétariat Comptable</h6>
                  <div class="stars">⭐⭐⭐⭐</div>
                </div>
              </div>
              <div class="carousel-item">
                <div class="testimonial border rounded p-4 bg-light shadow-sm">
                <h6 style ="color: rgb(246, 29, 231); ">Recruteur</h6>
                  <p>"Nous sommes vraiment satisfaits de notre collaboration avec StagesBENIN. Grâce à leur plateforme, nous avons recruté des stagiaires compétents qui ont contribué au succès de nos projets. Nous recommandons vivement leurs services."</p>
                      <img src="{{ asset('assets/images/iba-managent.png') }}" alt="Image Description" class="card-img-top rounded-circle" style="width: 150px; height: 150px; object-fit: cover;">
                  <h5>IBA</h5>
                  <h6>MANAGEMENT</h6>
                  <div class="stars">🌟🌟🌟🌟</div>
                </div>
              </div>
              



              <div class="carousel-item">
                <div class="testimonial border rounded p-4 bg-light shadow-sm">
                <h6 style ="color: #007bff; ">Ex candidat</h6>
                  <p>"Grâce à StagesBENIN, j'ai pu trouver rapidement un stage professionnel dans mon domaine d'études. Je suis ravi de l'opportunité qui m'a été offerte et je remercie Stages Bénin pour leur plateforme efficace."</p>
<img src="{{ asset('assets/images/333.png') }}" alt="Image Description" class="card-img-top rounded-circle" style="width: 150px; height: 150px; object-fit: cover;">

                  <h5>Ketsia M.</h5>
                  <h6>Secrétariat Bureautique</h6>
                  <div class="stars">⭐⭐⭐⭐⭐</div>
                </div>
              </div>
              <div class="carousel-item">
                <div class="testimonial border rounded p-4 bg-light shadow-sm">
                <h6 style ="color: rgb(246, 29, 231); ">Recruteur</h6>
                  <p>"StagesBENIN a été une véritable ressource pour notre entreprise, nous permettant de trouver des stagiaires compétents et motivés. Nous sommes pleinement satisfaits de notre collaboration et nous recommandons vivement leur plateforme."</p>
                      <img src="{{ asset('assets/images/Df-fifatin.png') }}" alt="Image Description" class="card-img-top rounded-circle" style="width: 150px; height: 150px; object-fit: cover;">
                  <h5>DF</h5>
                  <h6>FIFATIN</h6>
                  <div class="stars">🌟🌟🌟🌟</div>
                </div>
              </div>
            </div>
           <!-- Flèches de navigation -->
<button class="carousel-control-prev" type="button" data-bs-target="#temoignagesCarousel" data-bs-slide="prev">
  <span class="carousel-control-prev-icon" style="color: rgb(246, 29, 231);"></span>
</button>
<button class="carousel-control-next" type="button" data-bs-target="#temoignagesCarousel" data-bs-slide="next">
  <span class="carousel-control-next-icon" style="color: rgb(246, 29, 231);"></span>
</button>

          </div>
        </div>
      </section>
    </div>
  </div>
</div>




<script>
document.addEventListener("DOMContentLoaded", function() {
    const counters = document.querySelectorAll('.stat-count');
    const speed = 100; // Vitesse d'animation

    counters.forEach(counter => {
        let updateCount = () => {
            let target = +counter.getAttribute('data-target');
            let count = +counter.innerText;
            let increment = Math.ceil(target / speed);

            if (count < target) {
                counter.innerText = count + increment;
                setTimeout(updateCount, 30);
            } else {
                counter.innerText = target;
            }
        };
        updateCount();
    });
});
</script>
 <style>
 .testimonial {
  background-color: #f9f9f9; 
  border: 1px solid #ddd; 
  padding: 20px; /* Space inside */
  border-radius: 10px; /* Rounded corners */
  box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1); /* Light shadow for depth */
  transition: transform 0.3s ease-in-out;
}

.testimonial:hover {
  transform: scale(1.05); /* Slight zoom effect on hover */
}
p {
    font-size: 1vw; /* La taille du texte s'ajuste à la largeur de l'écran */
  
    
}

#animatedText {
    font-size: 9vw; /* Texte légèrement plus grand */
}

@media screen and (max-width: 768px) {
    p {
        font-size: 14px;
    }
}

@media screen and (min-width: 769px) and (max-width: 1024px) {
    p {
        font-size: 18px;
    }
}

@media screen and (min-width: 1025px) {
    p {
        font-size: 22px;
    }
}
#animatedText {
    font-size: 8vw; /* Ajuste en fonction de la largeur de l'écran */
    color: rgb(14, 40, 145);
    font-weight: bold;
    white-space: nowrap; /* Empêche le retour à la ligne */
}

@media screen and (max-width: 768px) {
    #animatedText {
        font-size: 16px; /* Taille fixe sur mobile */
    }
}

@media screen and (min-width: 1024px) {
    #animatedText {
        font-size: 9vw; /* Augmente sur grand écran */
    }
}


.stars {
  font-size: 18px; /* Adjust star size */
  color: #ffd700; /* Gold color for stars */
}
.catalogue-title {
  font-size: 2rem;
  color: #007bff; /* Adjust title color */
  margin-bottom: 20px;
}

.software-card {
    max-width: 800px;
    margin: 20px auto;
    padding: 20px;
    border: 1px solid #3498db;
    border-radius: 10px;
    background-color: #f8f9fa;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.software-card h2 {
    text-align: center;
    color: #3498db;
    font-family: Arial, sans-serif;
    margin-bottom: 20px;
}

.software-list {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    justify-content: center;
}

.job-offers-section {
    max-width: 900px;
    margin: 20px auto;
    padding: 20px;
    background-color: #f8f9fa;
    border: 1px solid #ddd;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.job-offers-section h2 {
    text-align: center;
    color: #2c3e50;
    margin-bottom: 20px;
    font-family: Arial, sans-serif;
}

.job-offers-list {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    justify-content: center;
}

.job-offer-item {
    width: 280px;
    border: 1px solid #ccc;
    border-radius: 10px;
    background-color: #fff;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
    text-align: center;
    padding: 15px;
}

.job-offer-item h3 {
    font-size: 18px;
    color: #333;
}


.job-offer-item p {
    font-size: 16px;
    margin: 5px 0;
}

.salary {
    font-weight: bold;
    color: #e74c3c;
}

.apply-btn {
    background-color: #3498db;
    color: #fff;
    border: none;
    border-radius: 5px;
    padding: 10px;
    cursor: pointer;
    transition: background-color 0.3s;
}

.apply-btn:hover {
    background-color: #2980b9;
}

.software-item {
    width: 250px;
    border: 1px solid #ccc;
    border-radius: 10px;
    background-color: #fff;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
    text-align: center;
    padding: 10px;
}

.software-image {
    max-width: 100%;
    border-radius: 5px;
    margin-bottom: 10px;
}

.software-info h3 {
    font-size: 18px;
    color: #333;
}

.software-info p {
    font-size: 16px;
    margin-bottom: 10px;
}

.price {
    font-weight: bold;
    color: #e74c3c;
}

.sell-btn {
    background-color: #3498db;
    color: #fff;
    border: none;
    border-radius: 5px;
    padding: 10px;
    cursor: pointer;
    transition: background-color 0.3s;
}

.sell-btn:hover {
    background-color: #2980b9;
}


.card-img-top {
  max-height: 200px;
  object-fit: cover; /* Keeps images proportional */
}

   body {
        font-family: 'Times New Roman', Times, serif;
    }
.btn-primary {
  font-weight: bold;
  padding: 10px 15px;
}

.card {
  transition: transform 0.3s ease-in-out;
}

.card:hover {
  transform: scale(1.05); /* Slight zoom effect when hovered */
}

.btn {
  font-size: 1rem;
  transition: transform 0.2s ease-in-out;
}

.btn:hover {
  transform: scale(1.05); /* Slight zoom effect on hover */
  background-color: #0056b3; /* Darker shade on hover */
}
.card-img-top {
  border: 2px solid #ddd; /* Add a subtle border */
  padding: 5px; /* Space between the image and border */
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Light shadow for a polished look */
}

 </style>












<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
@endsection
