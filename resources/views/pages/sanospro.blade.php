@extends('layouts.layout')

@section('title', 'StagesBENIN')

@section('content')
 <style>
    /* Styles Globaux */
    body {
      font-family: 'Segoe UI', sans-serif;
      background-color: #f8f9fa;
    }
    .hero {
      background-color: #0056b3;
      color: white;
      padding: 50px 0;
      text-align: center;
    }
    .section-title {
      color: #0056b3;
      font-weight: bold;
      margin-top: 30px;
    }
    .btn-custom {
      background-color: #0056b3;
      color: white;
    }
    .btn-custom:hover {
      background-color: #003d80;
    }
    ul li {
      margin-bottom: 8px;
    }
  </style>

  <!-- Section Héro -->
  <header class="mb-4 text-center">
  <h1 class="fw-bold" style="color: #0056b3">Les Ecoles de SaNOSPro</h1>
  <p class="lead">StagesBENIN lance Les Écoles de SaNOSPRO, un programme de formation pratique pour renforcer l’employabilité des jeunes durant les congés et vacances scolaires.</p>
  <a href="#details" class="btn btn-custom mt-3">Voir tous les Détails</a>
</header>


  <!-- Section Détails -->
  <div class="container mt-5" id="details">
    <h2 class="section-title">Une Formation Pratique pour l’Avenir des Jeunes !</h2>
    <p>
      Dans un contexte où l’insertion professionnelle des jeunes constitue un enjeu majeur, StagesBENIN, à travers son programme
      <strong>Salon National d’Orientation et de Stage Professionnel (SaNOSPRO)</strong>, initie un projet innovant visant à accompagner
      les apprenants et étudiants durant les congés et vacances scolaires. L’objectif principal est de leur offrir une formation
      pratique dans plusieurs domaines stratégiques afin de renforcer leurs compétences et d’accroître leur employabilité.
    </p>
    <p>Ce projet permettra également de promouvoir la marque StagesBENIN en tant qu’acteur incontournable de la formation et de l’accompagnement professionnel.</p>

    <!-- Section Objectifs -->
    <h3 class="section-title">Nos objectifs sont clairs</h3>
    <ul>
      <li>Offrir une formation de qualité dans des domaines stratégiques tels que l'informatique, le marketing digital, les ressources humaines, la maîtrise des logiciels comptables et le développement web.</li>
      <li>Permettre aux jeunes de développer des compétences pratiques en lien avec les besoins du marché du travail.</li>
      <li>Favoriser l'insertion professionnelle des participants à travers des formations certifiantes.</li>
      <li>Promouvoir l'image et la notoriété de StagesBENIN en tant que structure d'accompagnement des jeunes vers l'emploi.</li>
    </ul>

  <!-- Section Domaines de Formation -->
<h3 class="section-title">Domaines de formation</h3>
<p>Boostez vos compétences avec SaNOSPRO !</p>
<div class="row">
  <!-- Card Informatique -->
  <div class="col-md-4">
    <div class="card shadow-lg mb-4">
      <div class="card-body text-center">
        <i class="bi bi-laptop display-4 text-primary"></i>
        <h5 class="card-title mt-3">Informatique</h5>
        <p class="card-text">Initiation à l'utilisation des outils bureautiques et avancés.</p>
      </div>
    </div>
  </div>

  <!-- Card Marketing Digital -->
  <div class="col-md-4">
    <div class="card shadow-lg mb-4">
      <div class="card-body text-center">
        <i class="bi bi-bar-chart-line display-4 text-success"></i>
        <h5 class="card-title mt-3">Marketing Digital</h5>
        <p class="card-text">Techniques de publicité en ligne, référencement et gestion des réseaux sociaux.</p>
      </div>
    </div>
  </div>

  <!-- Card Ressources Humaines -->
  <div class="col-md-4">
    <div class="card shadow-lg mb-4">
      <div class="card-body text-center">
        <i class="bi bi-people-fill display-4 text-danger"></i>
        <h5 class="card-title mt-3">Ressources Humaines</h5>
        <p class="card-text">Bases du recrutement, gestion des talents et droit du travail.</p>
      </div>
    </div>
  </div>

  <!-- Card Logiciels Comptables -->
  <div class="col-md-6">
    <div class="card shadow-lg mb-4">
      <div class="card-body text-center">
        <i class="bi bi-calculator display-4 text-warning"></i>
        <h5 class="card-title mt-3">Maîtrise des logiciels comptables</h5>
        <p class="card-text">Utilisation de Sage, Hypersoft, Perfecto et autres logiciels spécialisés.</p>
      </div>
    </div>
  </div>

  <!-- Card Développement Web -->
  <div class="col-md-6">
    <div class="card shadow-lg mb-4">
      <div class="card-body text-center">
        <i class="bi bi-code-slash display-4 text-info"></i>
        <h5 class="card-title mt-3">Développement Web</h5>
        <p class="card-text">Conception ; développement de sites internet et d'applications mobiles.</p>
      </div>
    </div>
  </div>
</div>


    <div class="container mt-5">
  <div class="row">
    <!-- Card Conditions d'accès -->
    <div class="col-md-6">
      <div class="card shadow-lg mb-4">
        <div class="card-body">
          <h3 class="section-title">Conditions d'accès</h3>
          <ul>
            <li>Être âgé de 18 à 28 ans.</li>
            <li>Être ouvert d'esprit et curieux.</li>
            <li>Avoir le Baccalauréat ou un diplôme équivalent.</li>
            <li>Disposer d'un ordinateur pour participer aux activités de formation.</li>
            <li>S'acquitter des frais d'inscription de 10 000 F, à payer à l'inscription.</li>
            <li>Chaque lot de formation sera composé de 20 participants.</li>
          </ul>
        </div>
      </div>
    </div>

    <!-- Card Modalités de Formation -->
    <div class="col-md-6">
      <div class="card shadow-lg mb-4">
        <div class="card-body">
          <h3 class="section-title">Périodes et Modalités de Formation</h3>
          <ul>
            <li><strong>École de Pâques :</strong> du 21 au 25 Avril 2025.</li>
            <li><strong>École de Vacances :</strong> du 30 Juin au 04 Juillet 2025.</li>
            <li><strong>Durée :</strong> 30 heures de formation.</li>
            <li><strong>Format :</strong> Présentiel et/ou en ligne.</li>
            <li><strong>Encadrement :</strong> Formateurs expérimentés.</li>
            <li><strong>Attestation :</strong> Attestation de participation délivrée.</li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</div>


    <!-- Section Inscription -->
    <div class="text-center mt-5" id="inscription">
      <a href="https://docs.google.com/forms/d/e/1FAIpQLSeXrujRhqkFTUkVPHJtTbgFANv2qukvq5GCiiqStk_VEFryLQ/viewform" class="btn btn-lg btn-success">S'INSCRIRE MAINTENANT</a>
    </div>
  </div>

  <!-- Scripts -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

@endsection