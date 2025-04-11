<!DOCTYPE html>
<html lang="fr">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/> {{-- Important pour DomPDF --}}
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CV - {{ $cvProfile->nom_complet ?? 'Mon CV' }}</title>
    {{-- <link rel="stylesheet" href="{{ public_path('css/fontawesome-all.min.css') }}"> --}} {{-- Optionnel si FA non inclus autrement --}}
    <style>
        /* Réinitialisation et Polices */
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'DejaVu Sans', 'Roboto', 'Segoe UI', Arial, sans-serif; /* DejaVu Sans pour PDF */ }
        body { background-color: white; color: #333; line-height: 1.5; font-size: 10pt; }

        /* Conteneur principal */
        .cv-container { max-width: 800px; margin: 20px auto; background-color: white; border: 1px solid #eee; }

        /* En-tête */
        .cv-header { background: linear-gradient(135deg, #1a4a8b 0%, #0078d4 100%); color: white; padding: 25px 35px; display: flex; align-items: center; border-bottom: 4px solid #005a9e; }
        .photo-container { width: 120px; height: 120px; overflow: hidden; border-radius: 50%; border: 3px solid white; margin-right: 30px; background-color: #e0e0e0; flex-shrink: 0; }
        .photo-container img { display: block; width: 100%; height: 100%; object-fit: cover; }
        .header-content { flex: 1; }
        .header-content h1 { font-size: 24pt; font-weight: 700; margin-bottom: 5px; }
        .header-content h2 { font-size: 14pt; font-weight: 400; margin-bottom: 15px; opacity: 0.95; }
        .contact-info { display: flex; flex-wrap: wrap; margin-top: 15px; }
        .contact-item { margin-right: 20px; margin-bottom: 8px; display: flex; align-items: center; font-size: 9pt; }
        .contact-item i { margin-right: 8px; width: 15px; text-align: center; }
        .contact-item a { color: white; text-decoration: none; }
        .contact-item a:hover { text-decoration: underline; }

        /* Corps du CV */
        .cv-body { display: flex; }
        .left-column { width: 65%; padding: 25px 30px; border-right: 1px solid #eaeaea; }
        .right-column { width: 35%; padding: 25px 20px; background-color: #f8f9fa; }

        /* Sections */
        .section { margin-bottom: 25px; }
        .section:last-child { margin-bottom: 0; }
        .section-title { font-size: 14pt; color: #1a4a8b; padding-bottom: 8px; margin-bottom: 15px; position: relative; font-weight: 600; border-bottom: 2px solid #0078d4; }

        /* Styles spécifiques aux sections */
        .profile-text { font-size: 10pt; line-height: 1.6; color: #444; text-align: justify; }
        .experience-item, .education-item, .certification-item, .project-item { margin-bottom: 20px; position: relative; padding-left: 18px; }
        .experience-item:last-child, .education-item:last-child, .certification-item:last-child, .project-item:last-child { margin-bottom: 0; }
        .experience-item::before, .education-item::before, .certification-item::before, .project-item::before { content: "•"; position: absolute; left: 0; top: 4px; font-size: 14pt; color: #0078d4; line-height: 1; }

        .job-title, .degree, .certification-name, .project-name { font-size: 11pt; font-weight: bold; color: #2c3e50; margin-bottom: 3px; }
        .company, .school, .organization, .project-url { font-size: 10pt; font-weight: 500; color: #005a9e; margin-bottom: 3px; }
        .project-url a { color: #005a9e; text-decoration: none; word-break: break-all; }
        .period, .year { font-size: 9pt; color: #555; margin-bottom: 8px; font-style: italic; }
        .period i { margin-right: 5px; }

        .item-description, .job-description, .project-description { font-size: 10pt; color: #444; margin-bottom: 8px; line-height: 1.5; text-align: justify; white-space: pre-wrap; /* Respecte les sauts de ligne des textarea */ }

        .technologies { font-size: 9pt; color:#0078d4; margin-top: 5px; font-style: italic; }

        /* --- Section des réalisations / Tâches --- */
        .achievements-title {
            font-size: 10pt;
            font-weight: 600; /* Un peu plus gras */
            color: #333;
            margin-top: 10px; /* Espace avant le titre */
            margin-bottom: 5px; /* Espace avant la liste */
        }
        ul.achievements {
            padding-left: 20px;  /* Indentation standard pour les listes */
            margin-left: 5px;   /* Légère marge additionnelle si besoin */
            margin-top: 0;      /* Enlever la marge top par défaut de ul */
            list-style-type: disc; /* <<<<< ICI: Puces rondes pleines standard */
            list-style-position: outside; /* Puces à l'extérieur du texte */
        }
        ul.achievements li {
            margin-bottom: 5px; /* Espace entre les puces */
            color: #444;        /* Couleur du texte */
            font-size: 9.5pt;   /* Taille du texte */
            line-height: 1.4;   /* Interligne */
            text-align: justify;/* Justifier le texte de chaque puce */
        }
        /* --- Fin Section Réalisations --- */

        /* Compétences */
        .skill-category { margin-bottom: 15px; }
        .skill-title { font-weight: 600; margin-bottom: 8px; color: #1a4a8b; font-size: 10.5pt; }
        .skill-item { margin-bottom: 10px; }
        .skill-bar { height: 8px; background-color: #e9ecef; border-radius: 4px; overflow: hidden; margin-top: 3px; }
        .skill-fill { height: 100%; background: #0078d4; border-radius: 4px; }
        .skill-percent { display: flex; justify-content: space-between; align-items: center; margin-bottom: 2px; }
        .skill-name { font-weight: 500; font-size: 10pt; }
        .skill-level-text { font-size: 8.5pt; color: #555; }

        /* Langues */
        .language-item { margin-bottom: 10px; }
        .language-name { font-weight: 500; display: flex; justify-content: space-between; align-items: center; font-size: 10pt; margin-bottom: 4px; }
        .language-level-text { font-size: 9pt; color: #555; font-style: italic; }
        .language-level-dots { display: flex; }
        .level-dot { width: 10px; height: 10px; background-color: #e0e0e0; border-radius: 50%; margin-right: 4px; }
        .level-dot.active { background-color: #0078d4; }

        /* Centres d'intérêt */
        .interests { display: flex; flex-wrap: wrap; gap: 8px; }
        .interest-item { background-color: #e8f4fc; padding: 5px 12px; border-radius: 15px; font-size: 9pt; color: #005a9e; }

        /* Adaptation pour impression / PDF */
        @media print {
            body { background-color: white; font-size: 9.5pt; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
            .cv-container { margin: 0; box-shadow: none; border-radius: 0; border: none; max-width: 100%; }
            .cv-header { padding: 20px 30px; }
            .photo-container { width: 100px; height: 100px; }
            .header-content h1 { font-size: 20pt; }
            .header-content h2 { font-size: 12pt; }
            .contact-item { font-size: 8.5pt; margin-right: 15px; margin-bottom: 5px; }
            .left-column, .right-column { padding: 20px; width: 65% !important; /* Forcer la largeur pour PDF si flex pose problème */ }
            .right-column { width: 35% !important; }
            .section { margin-bottom: 20px; }
            .section-title { font-size: 12pt; margin-bottom: 10px; padding-bottom: 5px; }
            .experience-item, .education-item, .certification-item, .project-item { margin-bottom: 15px; padding-left: 15px; }
            .job-title, .degree, .certification-name, .project-name { font-size: 10.5pt; }
            .company, .school, .organization, .project-url { font-size: 9.5pt; }
            .period, .year { font-size: 8.5pt; margin-bottom: 6px; }
            .item-description, .job-description, .project-description { font-size: 9.5pt; }
            .achievements-title { font-size: 9.5pt; }
            ul.achievements li { font-size: 9pt; }
            .skill-title { font-size: 10pt; }
            .skill-name { font-size: 9.5pt; }
            .language-name { font-size: 9.5pt; }
            .language-level-text { font-size: 8.5pt; }
            .interest-item { font-size: 8.5pt; padding: 4px 10px; }
            /* Éviter les coupures */
            .section, .experience-item, .education-item, .certification-item, .project-item, .skill-category { page-break-inside: avoid; }
            ul.achievements { page-break-inside: auto; } /* Permet la coupure DANS la liste si nécessaire */
            ul.achievements li { page-break-inside: avoid; } /* Essaye d'éviter la coupure au milieu d'un item de liste */

        }

        /* Correction icônes PDF (via ::before) */
        .contact-item i::before, .period i::before, .project-url i::before { display: inline-block; font-style: normal; font-variant: normal; text-rendering: auto; -webkit-font-smoothing: antialiased; font-family: 'Font Awesome 6 Free'; font-weight: 900; width: 15px; text-align: center; margin-right: 8px; }
        .contact-item i.fab::before { font-family: 'Font Awesome 6 Brands'; font-weight: 400; } /* Spécifique pour Brands */

        .contact-item i.fa-phone::before { content: '\f095'; }
        .contact-item i.fa-envelope::before { content: '\f0e0'; }
        .contact-item i.fa-map-marker-alt::before { content: '\f3c5'; }
        .contact-item i.fa-link::before { content: '\f0c1'; }
        .contact-item i.fab.fa-linkedin::before { content: '\f0e1'; } /* Utilise fab */
        .period i.fa-calendar-alt::before { content: '\f073'; }
        .project-url i.fa-link::before { content: '\f0c1'; }
        /* Ajoutez d'autres icônes si nécessaire */

    </style>
</head>
<body>
    <div class="cv-container" id="cv-preview-content">
        {{-- En-tête (Header) --}}
        <div class="cv-header">
            {{-- Photo --}}
            @if($cvProfile->photo_url)
            <div class="photo-container">
                 @php
                    $photoPath = public_path(str_replace(asset('/'), '', $cvProfile->photo_url));
                    $imageData = null;
                    try { if (file_exists($photoPath)) { $imageData = base64_encode(file_get_contents($photoPath)); } } catch (\Exception $e) { \Log::error("Erreur chargement image CV: ".$e->getMessage()); }
                 @endphp
                 @if($imageData)
                     <img src="data:image/png;base64,{{ $imageData }}" alt="Photo {{ $cvProfile->nom_complet }}" />
                 @else
                     <div style="width: 100%; height: 100%; background-color: #ccc; display: flex; align-items: center; justify-content: center; font-size: 8pt; color: #555;"><span>Photo</span></div>
                 @endif
            </div>
            @endif
            {{-- Informations Nom, Titre, Contact --}}
            <div class="header-content">
                <h1>{{ $cvProfile->nom_complet ?? 'Nom Prénom' }}</h1>
                @if($cvProfile->titre_profil)<h2>{{ $cvProfile->titre_profil }}</h2>@endif
                <div class="contact-info">
                    @if($cvProfile->contact_telephone)<div class="contact-item"><i class="fas fa-phone"></i> {{ $cvProfile->contact_telephone }}</div>@endif
                    @if($cvProfile->contact_email)<div class="contact-item"><i class="fas fa-envelope"></i> <a href="mailto:{{ $cvProfile->contact_email }}">{{ $cvProfile->contact_email }}</a></div>@endif
                    @if($cvProfile->adresse)<div class="contact-item"><i class="fas fa-map-marker-alt"></i> {{ $cvProfile->adresse }}</div>@endif
                    {{-- Utilisation de l'icône Brands pour LinkedIn --}}
                    @if($cvProfile->linkedin_url)<div class="contact-item"><i class="fab fa-linkedin"></i> <a href="{{ $cvProfile->linkedin_url }}" target="_blank">{{ Str::limit(str_replace(['https://', 'http://', 'www.', 'linkedin.com/in/'], '', rtrim($cvProfile->linkedin_url,'/')), 30) }}</a></div>@endif
                    @if($cvProfile->portfolio_url)<div class="contact-item"><i class="fas fa-link"></i> <a href="{{ $cvProfile->portfolio_url }}" target="_blank">{{ Str::limit(str_replace(['https://', 'http://', 'www.'], '', rtrim($cvProfile->portfolio_url,'/')), 30) }}</a></div>@endif
                </div>
            </div>
        </div>

        {{-- Corps du CV (Colonnes) --}}
        <div class="cv-body">
            {{-- COLONNE GAUCHE --}}
            <div class="left-column">
                {{-- Section Profil --}}
                @if($cvProfile->resume_profil)
                <div class="section profile-section">
                    <h3 class="section-title">PROFIL</h3>
                    <p class="profile-text">{!! nl2br(e($cvProfile->resume_profil)) !!}</p>
                </div>
                @endif

                {{-- Section Expériences --}}
                @if($cvProfile->experiences->isNotEmpty())
                <div class="section experiences-section">
                    <h3 class="section-title">EXPÉRIENCE PROFESSIONNELLE</h3>
                    @foreach($cvProfile->experiences()->orderBy('date_debut', 'desc')->get() as $exp) {{-- Trier par date début décroissante --}}
                    <div class="experience-item">
                        <div class="job-title">{{ $exp->poste }}</div>
                        <div class="company">{{ $exp->entreprise }} {{ $exp->ville ? '| '.$exp->ville : '' }}</div>
                        <div class="period"><i class="fas fa-calendar-alt"></i> {{ $exp->periode }}</div> {{-- Utilise l'accesseur 'periode' du modèle --}}
                        {{-- Description Générale --}}
                        @if($exp->description)
                            <p class="job-description">{!! nl2br(e($exp->description)) !!}</p>
                        @endif

                        {{-- **** Tâches / Réalisations (Vérifié et Correct) **** --}}
                        @php
                            // Utilise l'accesseur défini dans le modèle CvExperience
                            // $taches = $exp->listeTaches ?? []; // S'assure que c'est un tableau
                            // Alternative si l'accesseur n'existe pas :
                             $taches = collect([$exp->tache_1, $exp->tache_2, $exp->tache_3])->filter()->all();
                        @endphp
                        {{-- Condition pour afficher la section seulement si taches non vides --}}
                        @if(!empty($taches))
                            <h4 class="achievements-title">Réalisations / Tâches :</h4>
                            <ul class="achievements">
                                @foreach($taches as $tache)
                                     {{-- trim() pour ignorer les espaces vides, e() pour sécurité --}}
                                    <li>{{ e(trim($tache)) }}</li>
                                @endforeach
                            </ul>
                        @endif
                        {{-- **** Fin Tâches / Réalisations **** --}}

                    </div>
                    @endforeach
                </div>
                @endif

                 {{-- Section Formation --}}
                 @if($cvProfile->formations->isNotEmpty())
                 <div class="section education-section">
                     <h3 class="section-title">FORMATION</h3>
                     @foreach($cvProfile->formations()->orderBy('annee_debut', 'desc')->get() as $form) {{-- Trier --}}
                     <div class="education-item">
                         <div class="degree">{{ $form->diplome }}</div>
                         <div class="school">{{ $form->etablissement }} {{ $form->ville ? '| '.$form->ville : '' }}</div>
                         <div class="period"><i class="fas fa-calendar-alt"></i> {{ $form->annee_debut }} {{ $form->annee_fin ? '- '.$form->annee_fin : ($form->annee_debut ? '- En cours' : '') }}</div>
                         @if($form->description)
                             <p class="item-description">{!! nl2br(e($form->description)) !!}</p>
                         @endif
                     </div>
                     @endforeach
                 </div>
                 @endif

                 {{-- Section Projets --}}
                 @if($cvProfile->projets->isNotEmpty())
                 <div class="section projects-section">
                     <h3 class="section-title">PROJETS</h3>
                     @foreach($cvProfile->projets as $proj)
                     <div class="project-item">
                         <div class="project-name">{{ $proj->nom }}</div>
                         @if($proj->url_projet)
                         <div class="project-url">
                             <i class="fas fa-link"></i> <a href="{{ $proj->url_projet }}" target="_blank">{{ Str::limit(str_replace(['https://', 'http://'], '', $proj->url_projet), 40) }}</a>
                         </div>
                         @endif
                         @if($proj->description)
                         <p class="project-description">{!! nl2br(e($proj->description)) !!}</p>
                         @endif
                         @if($proj->technologies)
                             <p class="technologies">Technologies: {{ $proj->technologies }}</p>
                         @endif
                     </div>
                     @endforeach
                 </div>
                 @endif

            </div> {{-- Fin left-column --}}

            {{-- COLONNE DROITE --}}
            <div class="right-column">
                {{-- Section Compétences --}}
                @if($cvProfile->competences->isNotEmpty())
                <div class="section skills-section">
                    <h3 class="section-title">COMPÉTENCES</h3>
                     @foreach($cvProfile->competences->groupBy('categorie') as $categorie => $competences)
                    <div class="skill-category">
                        <div class="skill-title">{{ $categorie }}</div>
                         @foreach($competences as $comp)
                         <div class="skill-item">
                             <div class="skill-percent">
                                 <span class="skill-name">{{ $comp->nom }}</span>
                                 @if($comp->niveau) {{-- Affiche le % seulement s'il existe --}}
                                    <span class="skill-level-text">{{ $comp->niveau }}%</span>
                                 @endif
                             </div>
                             @if($comp->niveau) {{-- Affiche la barre seulement si % existe --}}
                                <div class="skill-bar">
                                    <div class="skill-fill" style="width: {{ $comp->niveau }}%;"></div>
                                </div>
                             @endif
                         </div>
                         @endforeach
                    </div>
                     @endforeach
                </div>
                @endif

                {{-- Section Langues --}}
                @if($cvProfile->langues->isNotEmpty())
                <div class="section languages-section">
                    <h3 class="section-title">LANGUES</h3>
                    @foreach($cvProfile->langues as $lang)
                    <div class="language-item">
                        <div class="language-name">
                            <span>{{ $lang->langue }}</span>
                            <span class="language-level-text">{{ $lang->niveau }}</span> {{-- Niveau textuel (A1, B2...) --}}
                        </div>
                        {{-- Affichage optionnel par points si vous avez un accesseur 'niveauPoints' --}}
                         @if(isset($lang->niveauPoints) && $lang->niveauPoints > 0)
                             @php $points = $lang->niveauPoints; @endphp
                             <div class="language-level-dots">
                                 @for($i = 1; $i <= 5; $i++)
                                 <div class="level-dot {{ $i <= $points ? 'active' : '' }}"></div>
                                 @endfor
                             </div>
                         @endif
                    </div>
                    @endforeach
                </div>
                @endif

                 {{-- Section Certifications --}}
                 @if($cvProfile->certifications->isNotEmpty())
                 <div class="section certifications-section">
                     <h3 class="section-title">CERTIFICATIONS</h3>
                     @foreach($cvProfile->certifications as $cert)
                     <div class="certification-item">
                         <div class="certification-name">{{ $cert->nom }}</div>
                         <div class="organization">{{ $cert->organisme }} {{ $cert->annee ? '| '.$cert->annee : '' }}</div>
                          @if($cert->url_validation)
                              <div class="period" style="margin-bottom: 0;"><i class="fas fa-link"></i> <a href="{{ $cert->url_validation }}" target="_blank" style="font-size:8.5pt; color: #555;">Validation</a></div>
                          @endif
                     </div>
                     @endforeach
                 </div>
                 @endif

                {{-- Section Centres d'intérêt --}}
                @if($cvProfile->centresInteret->isNotEmpty())
                <div class="section interests-section">
                    <h3 class="section-title">CENTRES D'INTÉRÊT</h3>
                    <div class="interests">
                         @foreach($cvProfile->centresInteret as $interet)
                        <span class="interest-item">{{ $interet->nom }}</span>
                         @endforeach
                    </div>
                </div>
                @endif
            </div> {{-- Fin right-column --}}
        </div> {{-- Fin cv-body --}}
    </div> {{-- Fin cv-container --}}
</body>
</html>