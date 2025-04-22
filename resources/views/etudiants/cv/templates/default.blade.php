{{-- /resources/views/etudiants/cv/templates/default.blade.php --}}
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>CV - {{ $cvProfile->nom_complet ?? 'Mon CV' }}</title>
    <style>
        /* =========================================== */
        /* === STYLES INTÉGRÉS POUR PDF (SIMPLIFIÉS) === */
        /* =========================================== */

        /* --- Couleurs Fixes (remplacement des variables) --- */
        /* Bleu foncé principal (titres, etc.) */
        /* #2c3e50 */
        /* Bleu moyen (liens, accents) */
        /* #005a9e */
        /* Bleu header (section titre) */
        /* #1a4a8b */
        /* Bordure header */
        /* #005a9e */
        /* Fond colonne droite */
        /* #f8f9fa */
        /* Texte normal */
        /* #333333 */
        /* Texte léger (dates, niveaux) */
        /* #555555 */
        /* Bordures légères */
        /* #eaeaea */
        /* Fond barres compétences */
        /* #e9ecef */
        /* Remplissage barres compétences & points langues */
        /* #0078d4 */

        /* --- Reset & Base --- */
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'DejaVu Sans', Arial, sans-serif; }
        body { background-color: white; color: #333333; line-height: 1.4; font-size: 10pt; -webkit-font-smoothing: antialiased; }
        h1, h2, h3, h4, h5, h6 { font-weight: 600; color: #2c3e50; }
        p { margin-bottom: 0.6em; }
        a { color: #005a9e; text-decoration: none; }
        ul { list-style-position: outside; }

        /* --- Conteneur Principal --- */
        .cv-container { width: 100%; max-width: 800px; margin: 0 auto; background-color: white; border: 1px solid #eeeeee; }

        /* --- En-tête (couleur unie) --- */
        .cv-header {
            background-color: #1a4a8b; /* Couleur unie */
            color: white;
            padding: 25px 35px;
            border-bottom: 4px solid #005a9e;
            display: block; /* Ou table */
            width: 100%;
        }
        .header-table { display: table; width: 100%; border-spacing: 0; }
        .header-table-row { display: table-row; }
        .header-photo-cell { display: table-cell; width: 130px; vertical-align: top; padding-right: 30px; }
        .header-content-cell { display: table-cell; vertical-align: middle; }

        .photo-container { width: 110px; height: 110px; overflow: hidden; border-radius: 50%; border: 3px solid white; background-color: #e0e0e0; }
        .photo-container img { display: block; width: 100%; height: 100%; object-fit: cover; border-radius: 50%; }

        .header-content h1 { font-size: 22pt; font-weight: 700; margin-bottom: 5px; color: white; }
        .header-content h2 { font-size: 13pt; font-weight: 400; margin-bottom: 15px; color: white; opacity: 0.95; }
        .contact-info { margin-top: 15px; }
        .contact-item { margin-right: 15px; margin-bottom: 5px; display: inline-block; font-size: 9pt; color: white; white-space: nowrap; }
        /* Icônes gérées par ::before plus bas */
        .contact-item a { color: white; text-decoration: none; }

        /* --- Corps du CV - Layout Deux Colonnes --- */
        .cv-body { padding: 0; font-size: 0; /* Hack inline-block */ }
        .left-column, .right-column { display: inline-block; vertical-align: top; width: 100%; padding: 25px; font-size: 10pt; }
        .left-column { width: 65%; padding-right: 30px; border-right: 1px solid #eaeaea; }
        .right-column { width: 35%; padding-left: 20px; background-color: #f8f9fa; }

        /* --- Sections --- */
        .section { margin-bottom: 25px; page-break-inside: avoid; }
        .section:last-child { margin-bottom: 0; }
        .section-title { font-size: 14pt; color: #1a4a8b; padding-bottom: 8px; margin-bottom: 15px; font-weight: 600; border-bottom: 2px solid #0078d4; }

        /* --- Styles Contenu Spécifique --- */
        .profile-text { font-size: 10pt; line-height: 1.5; color: #444444; text-align: justify; }

        /* Items Expérience, Formation etc. */
        .experience-item, .education-item, .certification-item, .project-item {
            margin-bottom: 20px; position: relative; padding-left: 18px; page-break-inside: avoid;
        }
        .experience-item:last-child, .education-item:last-child, .certification-item:last-child, .project-item:last-child { margin-bottom: 0; }
        /* Puce personnalisée */
        .experience-item::before, .education-item::before, .certification-item::before, .project-item::before {
            content: "•"; position: absolute; left: 0; top: 1px; font-size: 14pt; color: #0078d4; line-height: 1;
        }

        .job-title, .degree, .certification-name, .project-name { font-size: 11pt; font-weight: bold; color: #2c3e50; margin-bottom: 2px; }
        .company, .school, .organization, .project-url { font-size: 10pt; font-weight: 500; color: #005a9e; margin-bottom: 2px; }
        .project-url a { color: #005a9e; text-decoration: none; word-break: break-all; }
        .period, .year { font-size: 9pt; color: #555555; margin-bottom: 6px; font-style: italic; }
        /* Icône calendrier gérée par ::before plus bas */

        .item-description, .job-description, .project-description { font-size: 10pt; color: #444444; margin-bottom: 8px; line-height: 1.4; text-align: justify; white-space: pre-wrap; }
        .technologies { font-size: 9pt; color: #0078d4; margin-top: 5px; font-style: italic; }

        /* Liste à puces pour Réalisations (Tâches) */
        .achievements-title { font-size: 10pt; font-weight: 600; color: #333333; margin-top: 8px; margin-bottom: 4px; }
        ul.achievements { padding-left: 15px; margin-left: 5px; margin-top: 0; list-style-type: disc; list-style-position: outside; }
        ul.achievements li { margin-bottom: 4px; color: #444444; font-size: 9.5pt; line-height: 1.4; text-align: left; page-break-inside: avoid; }

        /* Compétences */
        .skill-category { margin-bottom: 15px; page-break-inside: avoid;}
        .skill-title { font-weight: 600; margin-bottom: 8px; color: #1a4a8b; font-size: 10.5pt; }
        .skill-item { margin-bottom: 8px; }
        .skill-bar { height: 7px; background-color: #e9ecef; border-radius: 3px; overflow: hidden; margin-top: 3px; }
        .skill-fill { height: 100%; background-color: #0078d4; border-radius: 3px; }
        .skill-percent { display: block; margin-bottom: 2px; }
        .skill-name { font-weight: 500; font-size: 10pt; display:inline-block; margin-right: 5px;}
        .skill-level-text { font-size: 8.5pt; color: #555555; display: inline-block; }

        /* Langues */
        .language-item { margin-bottom: 10px; }
        .language-name { font-weight: 500; display: block; font-size: 10pt; margin-bottom: 2px; }
        .language-level-text { font-size: 9pt; color: #555555; font-style: italic; display: block; }
        .language-level-dots { margin-top: 3px; line-height: 1; }
        .level-dot { width: 9px; height: 9px; background-color: #e0e0e0; border-radius: 50%; margin-right: 4px; display: inline-block; }
        .level-dot.active { background-color: #0078d4; }

        /* Centres d'intérêt */
        .interests { line-height: 1.8; }
        .interest-item { display: inline; font-size: 9pt; color: #005a9e; padding: 0 5px; border-right: 1px solid #cccccc; }
         .interest-item:first-child { padding-left: 0; }
         .interest-item:last-child { border-right: none; padding-right: 0; }

        /* Informations Personnelles */
        .personal-info-section .info-item { margin-bottom: 8px; font-size: 10pt; page-break-inside: avoid; }
        .personal-info-section .info-label { font-weight: 600; color: #1a4a8b; display: inline-block; width: 80px; }
        .personal-info-section .info-value { color: #444444; }

        /* Références */
        .references-section .reference-item { margin-bottom: 15px; font-size: 10pt; page-break-inside: avoid; border-left: 3px solid #e9ecef; padding-left: 10px; }
        .references-section .reference-name { font-weight: 600; color: #2c3e50; margin-bottom: 2px; }
        .references-section .reference-position { font-size: 9.5pt; color: #005a9e; margin-bottom: 2px; }
        .references-section .reference-relation { font-size: 9pt; color: #555555; font-style: italic; margin-bottom: 4px; display: inline-block; margin-left: 5px; }
        .references-section .reference-contact { font-size: 9pt; color: #444444; }

         /* Correction icônes PDF (via ::before) */
        /* Assurez-vous que la police FontAwesome est bien chargée si vous utilisez ses glyphes Unicode */
        /* Utilisation de DejaVu Sans pour des symboles basiques peut être plus fiable */
        .contact-item i::before, .period i::before, .project-url i::before, .certification-item .period i::before /* Cibler aussi icone lien certification */ {
            display: inline-block;
            font-style: normal;
            font-variant: normal;
            text-rendering: auto;
            -webkit-font-smoothing: antialiased;
            font-family: 'DejaVu Sans'; /* Priorité à DejaVu */
            font-weight: normal; /* Normal pour DejaVu */
            width: 15px;
            text-align: center;
            margin-right: 8px;
        }
        /* Mapping des icônes vers les caractères DejaVu Sans ou Unicode standard si possible */
        .contact-item i.fa-phone::before { content: '\260E'; } /* Symbole téléphone standard */
        .contact-item i.fa-envelope::before { content: '\2709'; } /* Symbole enveloppe standard */
        .contact-item i.fa-map-marker-alt::before { content: '\1F4CD'; } /* Punaise ronde */
        .contact-item i.fa-link::before { content: '\1F517'; } /* Chaînon */
        .contact-item i.fab.fa-linkedin::before { content: 'L'; font-weight: bold; } /* Fallback texte */
        .period i.fa-calendar-alt::before { content: '\1F4C5'; } /* Calendrier */
        .project-url i.fa-link::before { content: '\1F517'; } /* Chaînon */
        .certification-item .period i.fa-link::before { content: '\1F517'; } /* Chaînon */

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
                 {{-- Ajout de la section Informations Personnelles --}}
                 <div class="section personal-info-section">
                     <h3 class="section-title">INFORMATIONS</h3>
                     <div class="info-item">
                         <span class="info-label">Naissance:</span>
                         <span class="info-value">{{ $cvProfile->date_naissance ? $cvProfile->date_naissance->translatedFormat('d F Y') : 'N/A' }}{{ $cvProfile->lieu_naissance ? ' à ' . e($cvProfile->lieu_naissance) : '' }}</span>
                     </div>
                     @if($cvProfile->nationalite)
                     <div class="info-item">
                         <span class="info-label">Nationalité:</span>
                         <span class="info-value">{{ e($cvProfile->nationalite) }}</span>
                     </div>
                     @endif
                     @if($cvProfile->situation_matrimoniale)
                     <div class="info-item">
                         <span class="info-label">Situation:</span>
                         <span class="info-value">{{ e($cvProfile->situation_matrimoniale) }}</span>
                     </div>
                     @endif
                 </div>
                 {{-- Fin section Informations Personnelles --}}

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

                {{-- Ajout Section Références --}}
                @if($cvProfile->references->isNotEmpty())
                <div class="section references-section">
                    <h3 class="section-title">RÉFÉRENCES</h3>
                    @foreach($cvProfile->references as $ref)
                    <div class="reference-item">
                        <div class="reference-name">{{ $ref->nom_complet }}</div>
                        @if($ref->poste)<div class="reference-position">{{ $ref->poste }}</div>@endif
                        @if($ref->relation)<div class="reference-relation">({{ $ref->relation }})</div>@endif
                        <div class="reference-contact">Contact: {{ $ref->contact }}</div>
                    </div>
                    @endforeach
                </div>
                @endif
                {{-- Fin Section Références --}}

            </div>
        </div>
    </div>
</body>
</html>