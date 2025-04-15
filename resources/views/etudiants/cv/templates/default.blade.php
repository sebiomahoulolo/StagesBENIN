{{-- /resources/views/etudiants/cv/templates/default.blade.php --}}
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>CV - {{ $cvProfile->nom_complet ?? 'Mon CV' }}</title>
    <style>
        /* =========================================== */
        /* === STYLES INTÉGRÉS POUR PDF (ET PNG) === */
        /* =========================================== */

        /* --- Variables (utilisées ici pour clarté, mais seront remplacées) --- */
        :root {
            --primary-color-hex: #3498db; /* Bleu primaire */
            --secondary-color-hex: #2c3e50; /* Bleu foncé */
            --header-gradient-start: #1a4a8b;
            --header-gradient-end: #0078d4;
            --header-border: #005a9e;
            --right-column-bg: #f8f9fa; /* Gris clair colonne droite */
            --text-color: #333333;
            --text-light: #555555;
            --text-link: #005a9e;
            --border-light: #eaeaea;
            --skill-bar-bg: #e9ecef;
            --interest-bg: #e8f4fc;
            --interest-text: #005a9e;
        }

        /* --- Reset & Base --- */
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'DejaVu Sans', Arial, sans-serif; /* DejaVu Sans est crucial pour les caractères spéciaux en PDF */ }
        body { background-color: white; color: #333333; line-height: 1.4; font-size: 10pt; -webkit-font-smoothing: antialiased; }
        h1, h2, h3, h4, h5, h6 { font-weight: 600; color: #2c3e50; } /* Couleur titres par défaut */
        p { margin-bottom: 0.6em; }
        a { color: #005a9e; text-decoration: none; }
        ul { list-style-position: outside; } /* Puces à l'extérieur */

        /* --- Conteneur Principal --- */
        .cv-container {
            width: 100%; /* Prend toute la largeur disponible */
            max-width: 800px; /* Limite max */
            margin: 0 auto; /* Centre si largeur limitée */
            background-color: white;
            border: 1px solid #eeeeee; /* Bordure légère */
        }

        /* --- En-tête --- */
        .cv-header {
            background-color: #1a4a8b; /* Fallback si gradient échoue */
            /* background: linear-gradient(135deg, #1a4a8b 0%, #0078d4 100%); gradients sont peu fiables en PDF */
            color: white;
            padding: 25px 35px;
            border-bottom: 4px solid #005a9e;
            /* Utilisation de "table" pour aligner photo et contenu (plus fiable que flex pour PDF) */
            display: block; /* Ou table */
            width: 100%;
        }
        .header-table { display: table; width: 100%; border-spacing: 0; }
        .header-table-row { display: table-row; }
        .header-photo-cell { display: table-cell; width: 130px; /* Largeur fixe pour la photo + marge */ vertical-align: top; padding-right: 30px; }
        .header-content-cell { display: table-cell; vertical-align: middle; }

        .photo-container {
            width: 110px; /* Taille photo */
            height: 110px;
            overflow: hidden;
            border-radius: 50%;
            border: 3px solid white;
            background-color: #e0e0e0; /* Fond si image absente */
        }
        .photo-container img { display: block; width: 100%; height: 100%; object-fit: cover; border-radius: 50%; }

        .header-content h1 { font-size: 22pt; font-weight: 700; margin-bottom: 5px; color: white; }
        .header-content h2 { font-size: 13pt; font-weight: 400; margin-bottom: 15px; opacity: 0.95; color: white; }
        .contact-info { margin-top: 15px; }
        /* Affichage en ligne des infos contact */
        .contact-item { margin-right: 15px; margin-bottom: 5px; display: inline-block; /* Affichage en ligne */ font-size: 9pt; color: white; white-space: nowrap; }
        .contact-item i { margin-right: 6px; width: 14px; text-align: center; font-family: 'DejaVu Sans', 'Font Awesome 6 Free'; font-weight: 900; /* Utiliser la police FA si définie */ }
         .contact-item i.fab { font-family: 'DejaVu Sans', 'Font Awesome 6 Brands'; font-weight: 400; } /* Pour les icônes de marque */
        .contact-item a { color: white; text-decoration: none; }

        /* --- Corps du CV - Layout Deux Colonnes (SANS FLEXBOX) --- */
        .cv-body {
             /* display: block; */ /* Plus besoin de flex */
             padding: 0; /* Pas de padding sur le conteneur body */
             font-size: 0; /* Hack pour enlever espace entre inline-block elements */
        }
        .left-column, .right-column {
            display: inline-block; /* Affichage en ligne */
            vertical-align: top;   /* Alignement en haut */
            width: 100%;           /* Assurer que la largeur est calculée */
            padding: 25px;         /* Padding interne */
            font-size: 10pt;       /* Rétablir la taille de police */
        }
        .left-column {
            width: 65%; /* Largeur colonne gauche */
             padding-right: 30px;
             border-right: 1px solid #eaeaea; /* Séparateur */
        }
        .right-column {
            width: 35%; /* Largeur colonne droite */
            padding-left: 20px;
            background-color: #f8f9fa; /* Fond léger */
        }

        /* --- Sections --- */
        .section { margin-bottom: 25px; page-break-inside: avoid; /* Tente d'éviter coupure PDF */ }
        .section:last-child { margin-bottom: 0; }
        .section-title { font-size: 14pt; color: #1a4a8b; padding-bottom: 8px; margin-bottom: 15px; font-weight: 600; border-bottom: 2px solid #0078d4; }

        /* --- Styles Contenu Spécifique --- */
        .profile-text { font-size: 10pt; line-height: 1.5; color: #444444; text-align: justify; }

        /* Items Expérience, Formation etc. */
        .experience-item, .education-item, .certification-item, .project-item { margin-bottom: 20px; position: relative; padding-left: 18px; page-break-inside: avoid; }
        .experience-item:last-child, .education-item:last-child, .certification-item:last-child, .project-item:last-child { margin-bottom: 0; }
        /* Puce personnalisée */
        .experience-item::before, .education-item::before, .certification-item::before, .project-item::before { content: "•"; position: absolute; left: 0; top: 1px; /* Ajuster position verticale */ font-size: 14pt; color: #0078d4; line-height: 1; }

        .job-title, .degree, .certification-name, .project-name { font-size: 11pt; font-weight: bold; color: #2c3e50; margin-bottom: 2px; }
        .company, .school, .organization, .project-url { font-size: 10pt; font-weight: 500; color: #005a9e; margin-bottom: 2px; }
        .project-url a { color: #005a9e; text-decoration: none; word-break: break-all; }
        .period, .year { font-size: 9pt; color: #555555; margin-bottom: 6px; font-style: italic; }
        .period i { margin-right: 5px; font-family: 'DejaVu Sans', 'Font Awesome 6 Free'; font-weight: 900; } /* Police FA */

        .item-description, .job-description, .project-description { font-size: 10pt; color: #444444; margin-bottom: 8px; line-height: 1.4; text-align: justify; white-space: pre-wrap; /* Respecte sauts de ligne */ }
        .technologies { font-size: 9pt; color:#0078d4; margin-top: 5px; font-style: italic; }

        /* Liste à puces pour Réalisations (Tâches) */
        .achievements-title { font-size: 10pt; font-weight: 600; color: #333333; margin-top: 8px; margin-bottom: 4px; }
        ul.achievements { padding-left: 15px; /* Indentation réduite */ margin-left: 5px; margin-top: 0; list-style-type: disc; /* Puces standard */ list-style-position: outside; }
        ul.achievements li { margin-bottom: 4px; color: #444444; font-size: 9.5pt; line-height: 1.4; text-align: left; /* Justifier peut être moins lisible pour listes */ page-break-inside: avoid; }

        /* Compétences */
        .skill-category { margin-bottom: 15px; page-break-inside: avoid;}
        .skill-title { font-weight: 600; margin-bottom: 8px; color: #1a4a8b; font-size: 10.5pt; }
        .skill-item { margin-bottom: 8px; } /* Espace réduit */
        .skill-bar { height: 7px; background-color: #e9ecef; border-radius: 3px; overflow: hidden; margin-top: 3px; }
        .skill-fill { height: 100%; background-color: #0078d4; border-radius: 3px; } /* Couleur unie */
        .skill-percent { display: block; margin-bottom: 2px; /* Pour affichage simple nom + barre */ }
        .skill-name { font-weight: 500; font-size: 10pt; display:inline-block; margin-right: 5px;} /* Nom compétence */
        .skill-level-text { font-size: 8.5pt; color: #555555; display: inline-block; } /* Pourcentage optionnel */

        /* Langues */
        .language-item { margin-bottom: 10px; }
        .language-name { font-weight: 500; display: block; /* Affichage simple */ font-size: 10pt; margin-bottom: 2px; }
        .language-level-text { font-size: 9pt; color: #555555; font-style: italic; display: block; }
        .language-level-dots { margin-top: 3px; line-height: 1; } /* Pour les points */
        .level-dot { width: 9px; height: 9px; background-color: #e0e0e0; border-radius: 50%; margin-right: 4px; display: inline-block; } /* Affichage en ligne */
        .level-dot.active { background-color: #0078d4; }

        /* Centres d'intérêt */
        .interests { line-height: 1.8; /* Augmenter interligne pour lisibilité */ }
        .interest-item {
             /* Affichage simple en ligne avec séparateur */
            display: inline;
            font-size: 9pt;
            color: #005a9e;
            /* Ajouter un séparateur visuel */
            padding: 0 5px;
            border-right: 1px solid #cccccc;
        }
         .interest-item:first-child { padding-left: 0; }
         .interest-item:last-child { border-right: none; padding-right: 0; }


        /* Icônes PDF (Déjà défini, semble correct) */
        /* ... (garder les ::before pour les icônes) ... */
         /* Correction icônes PDF (via ::before) */
        .contact-item i::before, .period i::before, .project-url i::before { display: inline-block; font-style: normal; font-variant: normal; text-rendering: auto; -webkit-font-smoothing: antialiased; font-family: 'DejaVu Sans', 'Font Awesome 6 Free'; font-weight: 900; width: 15px; text-align: center; margin-right: 8px; }
        .contact-item i.fab::before { font-family: 'DejaVu Sans', 'Font Awesome 6 Brands'; font-weight: 400; } /* Spécifique pour Brands */

        .contact-item i.fa-phone::before { content: '\f095'; }
        .contact-item i.fa-envelope::before { content: '\f0e0'; }
        .contact-item i.fa-map-marker-alt::before { content: '\f3c5'; }
        .contact-item i.fa-link::before { content: '\f0c1'; }
        .contact-item i.fab.fa-linkedin::before { content: '\f0e1'; } /* Utilise fab */
        .period i.fa-calendar-alt::before { content: '\f073'; }
        .project-url i.fa-link::before { content: '\f0c1'; }


    </style>
</head>
<body>
    <div class="cv-container" id="cv-preview-content">
        {{-- En-tête (Header) --}}
        <div class="cv-header">
            <div class="header-table">
                <div class="header-table-row">
                    {{-- Cellule Photo --}}
                    <div class="header-photo-cell">
                        @if($cvProfile->photo_cv_path) {{-- Utiliser photo_cv_path --}}
                        <div class="photo-container">
                             @php
                                $photoPath = null; $imageData = null;
                                try { if (Storage::disk('public')->exists($cvProfile->photo_cv_path)) { $photoPath = Storage::disk('public')->path($cvProfile->photo_cv_path); $imageData = base64_encode(file_get_contents($photoPath)); } } catch (\Exception $e) { \Log::error("Erreur chargement image CV PDF: ".$e->getMessage()); }
                             @endphp
                             @if($imageData)
                                 <img src="data:image/{{ pathinfo($photoPath ?? $cvProfile->photo_cv_path, PATHINFO_EXTENSION) }};base64,{{ $imageData }}" alt="Photo {{ $cvProfile->nom_complet }}" />
                             @else
                                 {{-- Fallback si erreur lecture --}}
                                 <div style="width: 100%; height: 100%; background-color: #ccc;"></div>
                             @endif
                        </div>
                        @endif
                    </div>
                    {{-- Cellule Contenu --}}
                    <div class="header-content-cell">
                        <div class="header-content">
                            <h1>{{ $cvProfile->nom_complet ?? 'Nom Prénom' }}</h1>
                            @if($cvProfile->titre_profil)<h2>{{ $cvProfile->titre_profil }}</h2>@endif
                            <div class="contact-info">
                                @if($cvProfile->contact_telephone)<div class="contact-item"><i class="fas fa-phone"></i> {{ $cvProfile->contact_telephone }}</div>@endif
                                @if($cvProfile->contact_email)<div class="contact-item"><i class="fas fa-envelope"></i> <a href="mailto:{{ $cvProfile->contact_email }}">{{ $cvProfile->contact_email }}</a></div>@endif
                                @if($cvProfile->adresse)<div class="contact-item"><i class="fas fa-map-marker-alt"></i> {{ $cvProfile->adresse }}</div>@endif
                                @if($cvProfile->linkedin_url)<div class="contact-item"><i class="fab fa-linkedin"></i> <a href="{{ $cvProfile->linkedin_url }}" target="_blank">{{ Str::limit(str_replace(['https://', 'http://', 'www.', 'linkedin.com/in/'], '', rtrim($cvProfile->linkedin_url,'/')), 30) }}</a></div>@endif
                                @if($cvProfile->portfolio_url)<div class="contact-item"><i class="fas fa-link"></i> <a href="{{ $cvProfile->portfolio_url }}" target="_blank">{{ Str::limit(str_replace(['https://', 'http://', 'www.'], '', rtrim($cvProfile->portfolio_url,'/')), 30) }}</a></div>@endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Corps du CV (Colonnes) --}}
        <div class="cv-body">
            {{-- COLONNE GAUCHE --}}
            <div class="left-column">
                @if($cvProfile->resume_profil)
                <div class="section profile-section">
                    <h3 class="section-title">PROFIL</h3>
                    <p class="profile-text">{!! nl2br(e($cvProfile->resume_profil)) !!}</p>
                </div>
                @endif

                @if($cvProfile->experiences->isNotEmpty())
                <div class="section experiences-section">
                    <h3 class="section-title">EXPÉRIENCE PROFESSIONNELLE</h3>
                    @foreach($cvProfile->experiences()->orderBy('date_debut', 'desc')->get() as $exp)
                    <div class="experience-item">
                        <div class="job-title">{{ $exp->poste }}</div>
                        <div class="company">{{ $exp->entreprise }} {{ $exp->ville ? '| '.$exp->ville : '' }}</div>
                        <div class="period"><i class="fas fa-calendar-alt"></i> {{ $exp->periode }}</div>
                        @if($exp->description)<p class="job-description">{!! nl2br(e($exp->description)) !!}</p>@endif
                        @php $taches = collect([$exp->tache_1, $exp->tache_2, $exp->tache_3])->filter()->all(); @endphp
                        @if(!empty($taches))
                            <h4 class="achievements-title">Réalisations / Tâches :</h4>
                            <ul class="achievements">
                                @foreach($taches as $tache)<li>{{ e(trim($tache)) }}</li>@endforeach
                            </ul>
                        @endif
                    </div>
                    @endforeach
                </div>
                @endif

                @if($cvProfile->formations->isNotEmpty())
                 <div class="section education-section">
                     <h3 class="section-title">FORMATION</h3>
                     @foreach($cvProfile->formations()->orderBy('annee_debut', 'desc')->get() as $form)
                     <div class="education-item">
                         <div class="degree">{{ $form->diplome }}</div>
                         <div class="school">{{ $form->etablissement }} {{ $form->ville ? '| '.$form->ville : '' }}</div>
                         <div class="period"><i class="fas fa-calendar-alt"></i> {{ $form->annee_debut }} {{ $form->annee_fin ? '- '.$form->annee_fin : ($form->annee_debut ? '- En cours' : '') }}</div>
                         @if($form->description)<p class="item-description">{!! nl2br(e($form->description)) !!}</p>@endif
                     </div>
                     @endforeach
                 </div>
                 @endif

                 @if($cvProfile->projets->isNotEmpty())
                 <div class="section projects-section">
                     <h3 class="section-title">PROJETS</h3>
                     @foreach($cvProfile->projets as $proj)
                     <div class="project-item">
                         <div class="project-name">{{ $proj->nom }}</div>
                         @if($proj->url_projet)<div class="project-url"><i class="fas fa-link"></i> <a href="{{ $proj->url_projet }}" target="_blank">{{ Str::limit(str_replace(['https://', 'http://'], '', $proj->url_projet), 40) }}</a></div>@endif
                         @if($proj->description)<p class="project-description">{!! nl2br(e($proj->description)) !!}</p>@endif
                         @if($proj->technologies)<p class="technologies">Technologies: {{ $proj->technologies }}</p>@endif
                     </div>
                     @endforeach
                 </div>
                 @endif
            </div>

            {{-- COLONNE DROITE --}}
            <div class="right-column">
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
                                 @if($comp->niveau)<span class="skill-level-text">{{ $comp->niveau }}%</span>@endif
                             </div>
                             @if($comp->niveau)
                                <div class="skill-bar"><div class="skill-fill" style="width: {{ $comp->niveau }}%;"></div></div>
                             @endif
                         </div>
                         @endforeach
                    </div>
                     @endforeach
                </div>
                @endif

                 @if($cvProfile->langues->isNotEmpty())
                <div class="section languages-section">
                    <h3 class="section-title">LANGUES</h3>
                    @foreach($cvProfile->langues as $lang)
                    <div class="language-item">
                        <div class="language-name">{{ $lang->langue }}</div>
                        <span class="language-level-text">{{ $lang->niveau }}</span>
                         @if(isset($lang->niveauPoints) && $lang->niveauPoints > 0)
                         @php $points = $lang->niveauPoints; @endphp
                         <div class="language-level-dots">@for($i = 1; $i <= 5; $i++)<div class="level-dot {{ $i <= $points ? 'active' : '' }}"></div>@endfor</div>
                         @endif
                    </div>
                    @endforeach
                </div>
                @endif

                @if($cvProfile->certifications->isNotEmpty())
                 <div class="section certifications-section">
                     <h3 class="section-title">CERTIFICATIONS</h3>
                     @foreach($cvProfile->certifications as $cert)
                     <div class="certification-item">
                         <div class="certification-name">{{ $cert->nom }}</div>
                         <div class="organization">{{ $cert->organisme }} {{ $cert->annee ? '| '.$cert->annee : '' }}</div>
                          @if($cert->url_validation)<div class="period" style="margin-bottom: 0;"><i class="fas fa-link"></i> <a href="{{ $cert->url_validation }}" target="_blank" style="font-size:8.5pt; color: #555;">Validation</a></div>@endif
                     </div>
                     @endforeach
                 </div>
                 @endif

                 @if($cvProfile->centresInteret->isNotEmpty())
                <div class="section interests-section">
                    <h3 class="section-title">CENTRES D'INTÉRÊT</h3>
                    <p class="interests">
                         @foreach($cvProfile->centresInteret as $index => $interet)
                            <span class="interest-item">{{ $interet->nom }}</span>{{ !$loop->last ? '' : '' }} {{-- Séparateur optionnel si affichage en ligne --}}
                         @endforeach
                    </p>
                </div>
                @endif
            </div>
        </div>
    </div>
</body>
</html>