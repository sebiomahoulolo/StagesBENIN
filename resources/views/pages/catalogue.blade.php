@extends('layouts.layout')
 
@section('title', 'StagesBENIN ')

@section('content')

<style>
 .sector-card {
    transition: transform 0.2s ease-in-out;
    border-radius: 12%;
    box-shadow: 0 4px 6px #777; /* Ajoutez une ombre si nécessaire */
    border-color: #3498db;
    border-width: 5px; /* Augmentez la valeur ici pour des bordures plus larges */
    border-style: solid; /* Assurez-vous d'ajouter un style de bordure si ce n'est pas déjà fait */
}

  body {
        font-family: 'Times New Roman', Times, serif;
    }
  .sector-card:hover {
    transform: scale(1.02);
   background-color: #0056b3;
        color: white;
  }
</style>

<div class="container py-5">
  <h1 class="text-center mb-4">Liste par secteurs d'activités</h1>

  <!-- Barre de recherche -->
  <div class="row mb-4">
    <div class="col-md-8 offset-md-2" style=" border-radius: 12%;
            border-color: #3498db">
      <input type="text" class="form-control" id="searchInput" placeholder="Rechercher un secteur...">
    </div>
  </div>

  <!-- Cartes des secteurs -->
  <div class="row" id="sectorContainer">
    <!-- Cartes dynamiques injectées ici -->
  </div>
</div>

<script>
  const sectors = [
    "Agriculture et agroalimentaire (production, transformation, distribution)",
    "Industrie (manufacture, textile, automobile, chimie)",
    "Commerce et distribution (boutiques, supermarchés, import-export)",
    "Transport et logistique (fret, livraison, aérien, maritime)",
    "BTP et immobilier (construction, architecture, ingénierie, agences immobilières)",
    "Énergie et environnement (énergies renouvelables, pétrole, gestion des déchets)",
    "Technologie et numérique (informatique, télécommunications, intelligence artificielle)",
    "Finance et assurance (banques, microfinance, assurances)",
    "Santé et bien-être (hôpitaux, pharmacies, cosmétiques)",
    "Éducation et formation (écoles, universités, formations professionnelles)",
    "Tourisme et loisirs (hôtellerie, restauration, évènementiel)",
    "Arts, culture et médias (cinéma, musique, presse, publicité)",
    "Services aux entreprises (consulting, marketing, sécurité)"
  ];

  const sectorContainer = document.getElementById('sectorContainer');

  function displaySectors(filter = '') {
    sectorContainer.innerHTML = '';
    sectors
      .filter(sector => sector.toLowerCase().includes(filter.toLowerCase()))
      .forEach(sector => {
        const col = document.createElement('div');
        col.className = 'col-md-4 mb-4';

        const secteur_activiteURL = encodeURIComponent(sector);

        col.innerHTML = `
          <a href="/catalogueplus/${secteur_activiteURL}" class="text-decoration-none text-dark">
            <div class="card sector-card shadow-sm h-100">
              <div class="card-body">
                <h5 class="card-title">${sector}</h5>
              </div>
            </div>
          </a>
        `;
        sectorContainer.appendChild(col);
      });
  }

  document.getElementById('searchInput').addEventListener('input', (e) => {
    displaySectors(e.target.value);
  });

  // Affichage initial
  displaySectors();
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

@endsection
