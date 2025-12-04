<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>CV LINK </title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Inter', Arial, sans-serif;
      background: linear-gradient(135deg, #f8fafc 0%, #e3f0ff 100%);
      min-height: 100vh;
    }
    .navbar-brand {
      font-weight: 700;
      font-size: 2rem;
      color: #0d6efd !important;
      letter-spacing: 1px;
    }
    .navbar-slogan {
      font-size: 1rem;
      color: #6c757d;
      margin-top: -0.5rem;
    }
    .avatar-default {
      width: 36px;
      height: 36px;
      border-radius: 50%;
      background: #e3f0ff;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      font-size: 1.3rem;
      color: #0d6efd;
      margin-right: 0.5rem;
    }
    .card {
      border-radius: 18px;
      box-shadow: 0 6px 18px rgba(13,110,253,0.08), 0 1.5px 4px rgba(0,0,0,0.04);
      border: none;
      transition: transform 0.3s;
    }
    .card:hover {
      transform: translateY(-7px) scale(1.03);
      box-shadow: 0 12px 32px rgba(13,110,253,0.13), 0 2px 8px rgba(0,0,0,0.06);
    }
    .subscribe-btn {
      background-color: #0d6efd;
      color: white;
      font-weight: bold;
      border-radius: 2rem;
      transition: background 0.3s;
      padding-left: 2rem;
      padding-right: 2rem;
    }
    .subscribe-btn:hover {
      background-color: #0b5ed7;
    }
    .footer {
      background: #f8fafc;
      color: #6c757d;
      text-align: center;
      padding: 1.2rem 0 0.5rem 0;
      font-size: 1rem;
      border-top: 1px solid #e3e3e3;
      margin-top: 3rem;
    }
  </style>
</head>
<body>
  <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm mb-4">
    <div class="container">
      <a class="navbar-brand" href="/">CV LINK</a>
      <span class="navbar-slogan d-none d-md-inline ms-2">Créez votre CV professionnel facilement</span>
      <div class="ms-auto d-flex align-items-center gap-2">
        @auth
          <span class="avatar-default me-2"><svg xmlns='http://www.w3.org/2000/svg' width='22' height='22' fill='currentColor' viewBox='0 0 16 16'><path d='M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z'/></svg></span>
          <span class="text-success fw-semibold me-2">Connecté{{ Auth::user() ? ' : '.Auth::user()->name : '' }}</span>
          <form method="POST" action="{{ route('logout') }}" class="d-inline">
            @csrf
            <button type="submit" class="btn btn-outline-danger btn-sm">Déconnexion</button>
          </form>
        @else
            <a href="
                    {{ route('login') }}" class="btn btn-outline-primary me-2">Connexion</a>
                    <a href="
                    {{ route('register') }}" class="btn btn-primary">Créer un compte</a>
               @endauth
      </div>
    </div>
  </nav>
  <div class="container py-5">
    <h2 class="text-center mb-4 fw-bold" style="color:#0d6efd; font-size:2.2rem;">Abonnez-vous à notre service de création de CV professionnel</h2>
    <div class="row row-cols-1 row-cols-md-3 g-4">
      <!-- Offre 3 mois -->
      {{-- <div class="col">
        <div class="card h-100 border-success">
          <div class="card-body text-center">
            <h5 class="card-title">3 Mois</h5>
            <p class="card-text">Accès illimité aux outils de création de CV pendant 3 mois.</p>
            <h6 class="text-success">Prix : 5 000 F</h6>
            <button class="btn subscribe-btn" onclick="commander('3 mois', 5000)">Commander</button>
          </div>
        </div>
      </div> --}}
      <!-- Offre 6 mois -->
      {{-- <div class="col">
        <div class="card h-100 border-primary">
          <div class="card-body text-center">
            <h5 class="card-title">6 Mois</h5>
            <p class="card-text">Bénéficiez d'un accompagnement personnalisé et de modèles avancés pendant 6 mois.</p>
            <h6 class="text-primary">Prix : 10 000 F</h6>
            <button class="btn subscribe-btn" onclick="commander('6 mois', 10000)">Commander</button>
          </div>
        </div>
      </div> --}}
      <!-- Offre 1 an -->
      <div class="col">
        <div class="card h-100 border-warning">
          <div class="card-body text-center">
            <h5 class="card-title">1 An</h5>
            <p class="card-text">Accès Premium complet avec révisions illimitées, pour une année entière.</p>
            <h6 class="text-warning">Prix : 5000 F</h6>
            <button class="btn subscribe-btn" onclick="window.location.href='{{ route('abonnement.payer') }}'">S'abonner maintenant</button>
          </div>
        </div>
      </div>
    </div>
  </div>
 <footer class="footer">
            &copy; {{ date('Y') }} CV LINK by <a href="stagesbenin.com">StagesBENIN</a>. Tous droits réservés.
        </footer>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    function commander(plan, prix) {
      alert(`Vous avez choisi l'abonnement de ${plan} à ${prix}F. Merci !`);
      // Tu peux remplacer ce alert() avec une redirection ou une requête POST Laravel
    }
  </script>
</body>
</html>