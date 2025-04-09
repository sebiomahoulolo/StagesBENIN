<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- Utiliser le nom de l'étudiant dans le titre --}}
    <title>CV - {{ $cvProfile->nom_complet ?? 'Mon CV' }}</title>
    {{-- Inclure FontAwesome si pas déjà dans le layout principal lors de l'export PDF --}}
    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"> --}}
    <style>
        /* Collez TOUT le CSS du template fourni ici */
        
        * { margin: 0; 
            padding: 0; 
            box-sizing: border-box; 
            font-family: 'Roboto', 'Segoe UI', Arial, sans-serif; 
        }

        body { background-color: #f0f2f5; 
            color: #333; 
            line-height: 1.6; 
        }
        
        .cv-container { 
            max-width: 900px; 
            margin: 20px auto; 
            background-color: white; 
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1); 
            border-radius: 8px; 
            overflow: hidden; 
            position: relative; 
        }
        .cv-header {
            background: linear-gradient(135deg, #1a4a8b 0%, #0078d4 100%);
            color: white;
            padding: 40px 50px;
            position: relative;
            display: flex;
            align-items: center;
        }
        
        .photo-container {
            width: 150px;
            height: 150px;
            overflow: hidden;
            border-radius: 50%;
            border: 4px solid white;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            margin-right: 40px;
            background-color: #e0e0e0;
            position: relative;
            flex-shrink: 0;
        }
        
        .photo-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .header-content {
            flex: 1;
        }
        
        .header-content h1 {
            font-size: 42px;
            font-weight: 700;
            margin-bottom: 8px;
            letter-spacing: 1px;
        }
        
        .header-content h2 {
            font-size: 22px;
            font-weight: 400;
            margin-bottom: 20px;
            opacity: 0.9;
        }
        
        .contact-info {
            display: flex;
            flex-wrap: wrap;
            margin-top: 25px;
        }
        
        .contact-item {
            margin-right: 25px;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            font-size: 16px;
        }
        
        .contact-item i {
            margin-right: 10px;
            font-size: 18px;
            width: 20px;
            text-align: center;
        }
        
        .cv-body {
            display: flex;
        }
        
        .left-column {
            width: 50%;
            padding: 40px 30px;
            border-right: 1px solid #eaeaea;
            background-color: #f9fafc;
        }
        
        .right-column {
            width: 50%;
            padding: 40px 30px;
        }
        
        .section {
            margin-bottom: 40px;
        }
        
        .section-title {
            font-size: 22px;
            color: #1a4a8b;
            padding-bottom: 10px;
            margin-bottom: 20px;
            position: relative;
            font-weight: 600;
        }
        
        .section-title::after {
            content: "";
            position: absolute;
            left: 0;
            bottom: 0;
            width: 50px;
            height: 3px;
            background-color: #0078d4;
        }
        
        .profile-text {
            font-size: 16px;
            line-height: 1.8;
            color: #555;
        }
        
        .experience-item, .education-item {
            margin-bottom: 30px;
            position: relative;
            padding-left: 20px;
        }
        
        .experience-item::before, .education-item::before {
            content: "";
            position: absolute;
            left: 0;
            top: 8px;
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background-color: #0078d4;
        }
        
        .job-title, .degree {
            font-size: 18px;
            font-weight: 600;
            color: #1a4a8b;
            margin-bottom: 5px;
        }
        
        .company, .school {
            font-size: 16px;
            font-weight: 500;
            color: #0078d4;
            margin-bottom: 5px;
        }
        
        .period {
            font-size: 14px;
            color: #777;
            margin-bottom: 12px;
            display: flex;
            align-items: center;
        }
        
        .period i {
            margin-right: 5px;
        }
        
        .job-description {
            font-size: 15px;
            color: #555;
            margin-bottom: 10px;
            line-height: 1.7;
        }
        
        ul.achievements {
            padding-left: 20px;
            margin-top: 10px;
        }
        
        ul.achievements li {
            margin-bottom: 8px;
            position: relative;
            color: #444;
            font-size: 14px;
        }
        
        .skill-category {
            margin-bottom: 25px;
        }
        
        .skill-title {
            font-weight: 600;
            margin-bottom: 12px;
            color: #1a4a8b;
            font-size: 16px;
        }
        
        .skill-bar {
            height: 10px;
            background-color: #e0e0e0;
            border-radius: 5px;
            margin-bottom: 20px;
            overflow: hidden;
        }
        
        .skill-fill {
            height: 100%;
            background: linear-gradient(90deg, #0078d4, #3498db);
            border-radius: 5px;
        }
        
        .skill-percent {
            display: flex;
            justify-content: space-between;
            margin-bottom: 5px;
        }
        
        .skill-name {
            font-weight: 500;
        }
        
        .language-item {
            margin-bottom: 15px;
        }
        
        .language-name {
            font-weight: 500;
            margin-bottom: 5px;
            display: flex;
            justify-content: space-between;
        }
        
        .language-level {
            display: flex;
        }
        
        .level-dot {
            width: 12px;
            height: 12px;
            background-color: #e0e0e0;
            border-radius: 50%;
            margin-right: 5px;
        }
        
        .level-dot.active {
            background-color: #0078d4;
        }
        
        .interests {
            display: flex;
            flex-wrap: wrap;
        }
        
        .interest-item {
            background-color: #e8f4fc;
            padding: 8px 15px;
            margin: 0 10px 10px 0;
            border-radius: 20px;
            font-size: 14px;
            color: #0078d4;
            transition: all 0.3s ease;
        }
        
        .interest-item:hover {
            background-color: #0078d4;
            color: white;
            transform: translateY(-3px);
        }
        
        /* Animation effects */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .section {
            animation: fadeInUp 0.5s ease-out forwards;
        }
        
        .section:nth-child(1) { animation-delay: 0.1s; }
        .section:nth-child(2) { animation-delay: 0.2s; }
        .section:nth-child(3) { animation-delay: 0.3s; }
        .section:nth-child(4) { animation-delay: 0.4s; }
        
        .experience-item, .education-item, .skill-category {
            animation: fadeInUp 0.5s ease-out forwards;
            animation-delay: calc(0.1s * var(--i, 1));
            opacity: 0;
        }
        
        @media (max-width: 768px) {
            .cv-body {
                flex-direction: column;
            }
            
            .left-column, .right-column {
                width: 100%;
                border-right: none;
                border-bottom: 1px solid #eaeaea;
            }
            
            .cv-header {
                flex-direction: column;
                align-items: center;
                text-align: center;
            }
            
            .photo-container {
                margin-right: 0;
                margin-bottom: 20px;
            }
            
            .contact-info {
                justify-content: center;
            }
        }

         /* Styles spécifiques pour PDF (peuvent différer légèrement du rendu web) */
        @media print {
             body { background-color: white; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
             .cv-container { margin: 0; box-shadow: none; border-radius: 0; max-width: 100%; }
             /* Ajustez les paddings/margins si nécessaire pour l'impression */
        }

        /* Correction possible pour les chemins d'icônes FontAwesome dans PDF */
         .contact-item i::before, .period i::before { /* Utilisez les pseudo-éléments si les <i> ne marchent pas */
            font-family: 'Font Awesome 6 Free'; /* ou le nom correct de la police FA */
            font-weight: 900; /* Pour les icônes solides */
            /* content: '\f095'; */ /* Code Unicode de l'icône téléphone, par exemple */
            margin-right: 10px;
            display: inline-block; /* Important */
            width: 20px; text-align: center;
         }
         /* Ajoutez les content: '\codeUnicode'; pour chaque icône */
         .contact-item i.fa-phone::before { content: '\f095'; }
         .contact-item i.fa-envelope::before { content: '\f0e0'; }
         .contact-item i.fa-linkedin::before { content: '\f0e1'; } /* Ou \f08c pour LinkedIn In */
         .contact-item i.fa-map-marker-alt::before { content: '\f3c5'; }
         .contact-item i.fa-link::before { content: '\f0c1';}
         .period i.fa-calendar-alt::before { content: '\f073'; }


    </style>
    {{-- Inclure FontAwesome ici si nécessaire pour l'export PDF standalone --}}
     <link rel="stylesheet" href="{{ public_path('css/fontawesome-all.min.css') }}"> {{-- Chemin absolu pour DomPDF --}}

</head>
<body>
    <div class="cv-container" id="cv-preview-content"> {{-- ID utile pour le JS --}}
        <div class="cv-header">
            <div class="photo-container">
                {{-- Utiliser l'accesseur pour la photo --}}
                <img src="{{ $cvProfile->photo_url }}" alt="Photo {{ $cvProfile->nom_complet }}" />
            </div>
            <div class="header-content">
                <h1>{{ $cvProfile->nom_complet ?? 'Nom Prénom' }}</h1>
                <h2>{{ $cvProfile->titre_profil ?? 'Titre du profil' }}</h2>
                <div class="contact-info">
                    {{-- Utiliser les accesseurs pour les contacts --}}
                    @if($cvProfile->contact_telephone)
                    <div class="contact-item">
                        <i class="fas fa-phone"></i> {{ $cvProfile->contact_telephone }}
                    </div>
                    @endif
                    @if($cvProfile->contact_email)
                    <div class="contact-item">
                        <i class="fas fa-envelope"></i> {{ $cvProfile->contact_email }}
                    </div>
                    @endif
                    @if($cvProfile->linkedin_url)
                    <div class="contact-item">
                         {{-- Essayez avec l'icône de classe --}}
                         <i class="fab fa-linkedin"></i> {{-- Ou fas fa-linkedin --}}
                         <a href="{{ $cvProfile->linkedin_url }}" target="_blank" style="color:white; text-decoration: none;">{{ Str::limit(str_replace(['https://', 'http://', 'www.'], '', $cvProfile->linkedin_url), 30) }}</a>
                    </div>
                    @endif
                     @if($cvProfile->portfolio_url)
                    <div class="contact-item">
                         <i class="fas fa-link"></i>
                         <a href="{{ $cvProfile->portfolio_url }}" target="_blank" style="color:white; text-decoration: none;">{{ Str::limit(str_replace(['https://', 'http://', 'www.'], '', $cvProfile->portfolio_url), 30) }}</a>
                    </div>
                    @endif
                    @if($cvProfile->adresse)
                    <div class="contact-item">
                        <i class="fas fa-map-marker-alt"></i> {{ $cvProfile->adresse }}
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="cv-body">
            <!-- COLONNE GAUCHE -->
            <div class="left-column">
                @if($cvProfile->resume_profil)
                <div class="section" style="--i: 1;">
                    <h3 class="section-title">PROFIL</h3>
                    <p class="profile-text">
                       {!! nl2br(e($cvProfile->resume_profil)) !!} {{-- nl2br pour les sauts de ligne, e() pour échapper --}}
                    </p>
                </div>
                @endif

                @if($cvProfile->experiences->isNotEmpty())
                <div class="section" style="--i: 2;">
                    <h3 class="section-title">EXPÉRIENCE PROFESSIONNELLE</h3>
                    @foreach($cvProfile->experiences as $index => $exp)
                    <div class="experience-item" style="--i: {{ $index + 1 }};">
                        <div class="job-title">{{ $exp->poste }}</div>
                        <div class="company">{{ $exp->entreprise }} {{ $exp->ville ? '| '.$exp->ville : '' }}</div>
                        <div class="period"><i class="fas fa-calendar-alt"></i> {{ $exp->periode }}</div>
                        @if($exp->description)
                        <p class="job-description">{!! nl2br(e($exp->description)) !!}</p>
                        @endif
                        {{-- Afficher la liste des tâches/réalisations --}}
                         @php $taches = $exp->listeTaches; @endphp {{-- Utilise l'helper du modèle --}}
                         @if(!empty($taches))
                            <ul class="achievements">
                                 @foreach($taches as $tache)
                                     {{-- Enlever les marqueurs potentiels comme '*' ou '-' --}}
                                     <li>{{ e(ltrim(trim($tache), '*- ')) }}</li>
                                 @endforeach
                            </ul>
                         @endif
                    </div>
                    @endforeach
                </div>
                @endif

                 @if($cvProfile->formations->isNotEmpty())
                <div class="section" style="--i: 3;">
                    <h3 class="section-title">FORMATION</h3>
                     @foreach($cvProfile->formations as $index => $form)
                    <div class="education-item" style="--i: {{ $index + 1 }};">
                        <div class="degree">{{ $form->diplome }}</div>
                        <div class="school">{{ $form->etablissement }} {{ $form->ville ? '| '.$form->ville : '' }}</div>
                         <div class="period"><i class="fas fa-calendar-alt"></i> {{ $form->annee_debut }} {{ $form->annee_fin ? '- '.$form->annee_fin : '- Présent' }}</div>
                         @if($form->description)
                            {{-- Afficher comme liste si formaté, sinon paragraphe --}}
                            @php $details = preg_split('/[\r\n]+/', trim($form->description), -1, PREG_SPLIT_NO_EMPTY); @endphp
                            @if(count($details) > 1)
                                <ul class="achievements">
                                    @foreach($details as $detail)
                                    <li>{{ e(ltrim(trim($detail), '*- ')) }}</li>
                                    @endforeach
                                </ul>
                            @else
                                <p class="job-description">{{ e($form->description) }}</p>
                            @endif
                        @endif
                    </div>
                    @endforeach
                </div>
                 @endif

                @if($cvProfile->centresInteret->isNotEmpty())
                <div class="section" style="--i: 4;">
                    <h3 class="section-title">CENTRES D'INTÉRÊT</h3>
                    <div class="interests">
                         @foreach($cvProfile->centresInteret as $interet)
                        <div class="interest-item">{{ $interet->nom }}</div>
                         @endforeach
                    </div>
                </div>
                @endif
            </div>

            <!-- COLONNE DROITE -->
            <div class="right-column">
                @if($cvProfile->competences->isNotEmpty())
                <div class="section" style="--i: 1;">
                    <h3 class="section-title">COMPÉTENCES</h3>
                     {{-- Regrouper les compétences par catégorie --}}
                     @foreach($cvProfile->competences->groupBy('categorie') as $categorie => $competences)
                    <div class="skill-category" style="--i: {{ $loop->iteration }};">
                        <div class="skill-title">{{ $categorie }}</div>
                         @foreach($competences as $comp)
                        <div class="skill-percent">
                            <span class="skill-name">{{ $comp->nom }}</span>
                            <span>{{ $comp->niveau }}%</span>
                        </div>
                        <div class="skill-bar">
                            <div class="skill-fill" style="width: {{ $comp->niveau }}%;"></div>
                        </div>
                         @endforeach
                    </div>
                     @endforeach
                </div>
                @endif

                @if($cvProfile->langues->isNotEmpty())
                <div class="section" style="--i: 2;">
                    <h3 class="section-title">LANGUES</h3>
                    @foreach($cvProfile->langues as $lang)
                    <div class="language-item">
                        <div class="language-name">
                            <span>{{ $lang->langue }}</span>
                            <span>{{ $lang->niveau }}</span> {{-- Ex: Courant --}}
                        </div>
                        {{-- Afficher les points basés sur le niveau --}}
                         @php $points = $lang->niveauPoints; @endphp {{-- Utilise l'helper --}}
                        <div class="language-level">
                            @for($i = 1; $i <= 5; $i++)
                            <div class="level-dot {{ $i <= $points ? 'active' : '' }}"></div>
                            @endfor
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif

                @if($cvProfile->certifications->isNotEmpty())
                <div class="section" style="--i: 3;">
                    <h3 class="section-title">CERTIFICATIONS</h3>
                    @foreach($cvProfile->certifications as $index => $cert)
                    <div class="education-item" style="--i: {{ $index + 1 }};">
                        <div class="degree">{{ $cert->nom }}</div>
                        <div class="school">{{ $cert->organisme }} {{ $cert->annee ? '| '.$cert->annee : '' }}</div>
                         @if($cert->url_validation)
                             <div class="period"><i class="fas fa-link"></i> <a href="{{ $cert->url_validation }}" target="_blank" style="font-size:13px; color: #555;">Validation</a></div>
                         @endif
                    </div>
                    @endforeach
                </div>
                @endif

                 @if($cvProfile->projets->isNotEmpty())
                <div class="section" style="--i: 4;">
                    <h3 class="section-title">PROJETS PERSONNELS</h3>
                    @foreach($cvProfile->projets as $index => $proj)
                    <div class="education-item" style="--i: {{ $index + 1 }};">
                        <div class="degree">{{ $proj->nom }}</div>
                         @if($proj->url_projet)
                        <div class="period"><i class="fas fa-link"></i> <a href="{{ $proj->url_projet }}" target="_blank" style="font-size:13px; color: #555;">{{ Str::limit(str_replace(['https://', 'http://'], '', $proj->url_projet), 40) }}</a></div>
                         @endif
                         @if($proj->description)
                        <p class="job-description">{!! nl2br(e($proj->description)) !!}</p>
                         @endif
                         @if($proj->technologies)
                             <p style="font-size: 13px; color:#0078d4; margin-top: 5px;"><i>Technologies: {{ $proj->technologies }}</i></p>
                         @endif
                    </div>
                    @endforeach
                </div>
                @endif
            </div>
        </div>
    </div>

     {{-- Script pour les animations (si nécessaire, mais peut causer des pbs avec PDF) --}}
     {{-- <script>
         // Simple script pour ajouter les délais d'animation si non fait en CSS pur complexe
         document.querySelectorAll('.section, .experience-item, .education-item, .skill-category').forEach((el, index) => {
             el.style.setProperty('--i', index + 1);
         });
     </script> --}}
</body>
</html>