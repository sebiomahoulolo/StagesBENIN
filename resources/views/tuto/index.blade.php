<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CV LINK</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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
        .tuto-card {
            border-radius: 18px;
            box-shadow: 0 6px 18px rgba(13,110,253,0.08), 0 1.5px 4px rgba(0,0,0,0.04);
            border: none;
            background: #fff;
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
        
        <h1 class="text-center mb-5 fw-bold" style="font-size:2.2rem; color:#0d6efd; letter-spacing:1px;">Tutoriel : Créez un CV parfait</h1>
        <div class="text-center mt-4">
                    
                    {{-- <a href="/index"
 class="btn btn-primary btn-lg rounded-pill px-5">🔁 Revenir à l'Accueil</a>
                 ou  --}}
                                     <a href="{{ route('cv.index') }}" class="btn btn-primary btn-lg rounded-pill px-5">✍️ Commencer mon CV maintenant </a>
                </div>
        <div class="row justify-content-center mb-4">
            <div class="col-lg-10">
                <div class="card tuto-card p-4 mb-4">
                @php
    $elements = [
                        [ 'title' => 'Profil', 'desc' => "Une courte introduction qui résume qui vous êtes, votre domaine d'expertise et vos objectifs professionnels. Restez clair, concis et pertinent pour le poste visé." ],
                        [ 'title' => 'Expérience Professionnelle', 'desc' => "Listez vos postes précédents en précisant : intitulé du poste, entreprise, dates, missions principales et résultats obtenus. Mettez l'accent sur les réalisations concrètes et mesurables." ],
                        [ 'title' => 'Formation', 'desc' => "Mentionnez vos diplômes, établissements, dates et spécialités. N'ajoutez que les formations pertinentes pour le poste que vous visez." ],
                        [ 'title' => 'Projets', 'desc' => "Ajoutez vos projets personnels, académiques ou professionnels les plus pertinents. Décrivez brièvement l'objectif, votre rôle, les technologies utilisées et les résultats." ],
                        [ 'title' => 'Certifications & Attestations', 'desc' => "Inscrivez toutes les certifications pertinentes (ex: Google, Cisco, Microsoft, Udemy, etc.). Cela renforce la crédibilité de vos compétences techniques." ],
                        [ 'title' => 'Informations Personnelles', 'desc' => "Indiquez votre date de naissance, nationalité, situation matrimoniale (facultatif). Attention : soyez conforme aux règles du pays. En France par exemple, ces infos ne sont pas obligatoires." ],
                        [ 'title' => 'Compétences', 'desc' => "Listez vos compétences techniques (logiciels, langages de programmation, outils…) et vos soft skills (communication, travail en équipe, leadership…)." ],
                        [ 'title' => "Centres d'intérêt", 'desc' => "Mentionnez vos passions ou loisirs qui vous mettent en valeur : sport d'équipe (esprit collectif), lecture (curiosité), bénévolat (sens du service), etc." ],
                        [ 'title' => 'Références', 'desc' => "Ajoutez des contacts professionnels (anciens managers, professeurs…) qui peuvent témoigner de vos compétences. Toujours demander leur accord avant de les mentionner." ],
    ];
@endphp
                    <h2 class="h5 mb-4 text-primary">Les éléments essentiels d'un CV</h2>
                    <div class="row g-3">
               @foreach ($elements as $item)
                        <div class="col-md-6 col-lg-4">
                            <div class="border rounded-4 p-3 h-100 bg-light">
                                <h4 class="fw-bold mb-2" style="color:#0d6efd;">{{ $item['title'] }}</h4>
                                <p class="mb-0">{{ $item['desc'] }}</p>
                            </div>
    </div>
@endforeach
                    </div>
                </div>
                <div class="text-center mt-4">
                    
                    {{-- <a href="/index"
 class="btn btn-primary btn-lg rounded-pill px-5">🔁 Revenir à l'Accueil</a>
                 ou  --}}
                                     <a href="{{ route('cv.index') }}" class="btn btn-primary btn-lg rounded-pill px-5">✍️ Commencer mon CV maintenant </a>
                </div>
                <div class="card tuto-card p-4 mb-4">
                    <h2 class="h5 mb-4 text-primary">Tutoriels vidéo</h2>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="ratio ratio-16x9 rounded-4 overflow-hidden shadow-sm">
                                <iframe src="https://www.youtube.com/embed/cr0a7Bsd-SI" frameborder="0" allowfullscreen></iframe>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="ratio ratio-16x9 rounded-4 overflow-hidden shadow-sm">
                                <iframe src="https://www.youtube.com/embed/VIDEO_ID_2" frameborder="0" allowfullscreen></iframe>
                            </div>
                        </div>
            </div>
        </div>
        <div class="text-center mt-4">
                    
                    {{-- <a href="/index"
 class="btn btn-primary btn-lg rounded-pill px-5">🔁 Revenir à l'Accueil</a>
                 ou  --}}
                                     <a href="{{ route('cv.index') }}" class="btn btn-primary btn-lg rounded-pill px-5">✍️ Commencer mon CV maintenant </a>
                </div>
                <div class="card tuto-card p-4 mb-4">
                    <h2 class="h5 mb-4 text-primary">Conseils rapides</h2>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">✅ <b>Adaptez votre CV à chaque offre d'emploi</b> : Analysez l'offre d'emploi et reprenez les mots-clés dans votre CV. Cela montre que vous avez compris les attentes de l'entreprise et augmente vos chances de passer les filtres automatisés (ATS).</li>
                        <li class="list-group-item">✅ <b>Utilisez des verbes d'action puissants</b> : Privilégiez des verbes comme : « Dirigé », « Conçu », « Optimisé », « Développé », « Négocié ».</li>
                        <li class="list-group-item">✅ <b>Gardez une mise en page claire et professionnelle</b> : Structure aérée, police lisible, couleurs sobres.</li>
                        <li class="list-group-item">✅ <b>Limitez votre CV à 1 ou 2 pages maximum</b> : Soyez synthétique, allez à l'essentiel.</li>
                        <li class="list-group-item">✅ <b>Mettez en avant les résultats obtenus</b> : Chiffrez vos réussites si possible.</li>
                        <li class="list-group-item">✅ <b>Personnalisez votre résumé professionnel</b> : Expliquez ce que vous apportez et ce que vous recherchez.</li>
                        <li class="list-group-item">✅ <b>Évitez les fautes d'orthographe</b> : Relisez plusieurs fois, utilisez un correcteur.</li>
                    </ul>
                </div>
                <div class="text-center mt-4">
                    
                    <a href="/index"
 class="btn btn-primary btn-lg rounded-pill px-5">🔁 Revenir à l'Accueil</a>
                 ou 
                                     <a href="{{ route('cv.index') }}" class="btn btn-primary btn-lg rounded-pill px-5">✍️ Commencer mon CV maintenant </a>
                </div>
            </div>
        </div>
    </div>
   <footer class="footer">
            &copy; {{ date('Y') }} CV LINK by <a href="stagesbenin.com">StagesBENIN</a>. Tous droits réservés.
        </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
