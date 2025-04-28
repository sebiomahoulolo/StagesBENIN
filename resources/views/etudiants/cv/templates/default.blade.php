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
        body {
            background-color: white;
            color: #333333;
            line-height: 1.4;
            font-size: 10pt;
            -webkit-font-smoothing: antialiased;
            margin: 0; /* Assurer aucune marge body */
            padding: 0; /* Assurer aucun padding body */
        }
        h1, h2, h3, h4, h5, h6 { font-weight: 600; color: #2c3e50; }
        p { margin-bottom: 0.6em; }
        a { color: #005a9e; text-decoration: none; }
        ul { list-style-position: inside; padding-left: 5px; } /* Ajustement pour listes */

        /* --- Conteneur Principal et Table Principale --- */
        .cv-container {
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
            background-color: white;
            border-collapse: collapse; /* Important pour dompdf */
        }

        /* --- Styles pour cellule d'en-tête --- */
        .header-cell {
            background-color: #1a4a8b;
            color: white;
            padding: 15px 20px;
            border-bottom: 4px solid #005a9e;
        }

        /* Layout interne de l'en-tête */
        .header-inner-table {
            width: 100%;
            border-collapse: collapse;
            border-spacing: 0;
        }
        
        .header-photo-cell {
            width: 120px;
            vertical-align: middle;
            padding-right: 20px;
        }
        
        .header-content-cell {
            vertical-align: middle;
        }

        .photo-container {
            width: 100px;
            height: 100px;
            overflow: hidden;
            border-radius: 50%;
            border: 3px solid white;
            background-color: #e0e0e0;
        }
        
        .photo-container img {
            display: block;
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 50%;
        }

        .header-content h1 {
            font-size: 20pt;
            font-weight: 700;
            margin-bottom: 4px;
            color: white;
        }
        
        .header-content h2 {
            font-size: 12pt;
            font-weight: 400;
            margin-bottom: 10px;
            color: white;
            opacity: 0.95;
        }
        
        .contact-info {
            margin-top: 8px;
        }
        
        .contact-item {
            margin-right: 12px;
            margin-bottom: 4px;
            display: inline-block;
            font-size: 9pt;
            color: white;
            white-space: nowrap;
        }
        
        .contact-item a {
            color: white;
        }

        /* --- Cellules des colonnes de contenu --- */
        .no-space-row {
            height: 0;
            line-height: 0;
        }
        
        .content-row {
            page-break-inside: auto;
            page-break-after: auto;
        }
        
        .left-column-cell {
            width: 63%;
            padding: 15px;
            padding-right: 12px;
            vertical-align: top;
            border-right: 1px solid #eaeaea;
        }
        
        .right-column-cell {
            width: 37%;
            padding: 15px;
            padding-left: 12px;
            vertical-align: top;
            background-color: #f8f9fa;
        }

        /* --- Sections --- */
        .section {
            margin-bottom: 18px;
            page-break-inside: auto;
        }
        
        .section:first-child {
            margin-top: 0;
        }
        
        .section:last-child {
            margin-bottom: 0;
        }
        
        .section-title {
            font-size: 13pt;
            color: #1a4a8b;
            padding-bottom: 6px;
            margin-bottom: 12px;
            font-weight: 600;
            border-bottom: 2px solid #0078d4;
            page-break-after: avoid;
        }

        /* --- Styles Contenu --- */
        .profile-text {
            font-size: 9.5pt;
            line-height: 1.45;
            color: #444444;
            text-align: justify;
        }

        /* Items Expérience, Formation etc. */
        .experience-item, .education-item, .certification-item, .project-item {
            margin-bottom: 18px;
            position: relative;
            padding-left: 15px;
            page-break-inside: auto;
        }
        
        .experience-item:last-child, .education-item:last-child, .certification-item:last-child, .project-item:last-child {
            margin-bottom: 0;
        }
        
        .experience-item::before, .education-item::before, .certification-item::before, .project-item::before {
            content: "•";
            position: absolute;
            left: 0;
            top: 0;
            font-size: 14pt;
            color: #0078d4;
            line-height: 1;
        }

        .job-title, .degree, .certification-name, .project-name {
            font-size: 10.5pt;
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 1px;
            page-break-after: avoid;
        }
        
        .company, .school, .organization, .project-url {
            font-size: 9.5pt;
            font-weight: 500;
            color: #005a9e;
            margin-bottom: 1px;
        }
        
        .project-url a {
            word-break: break-all;
        }
        
        .period, .year {
            font-size: 8.5pt;
            color: #555555;
            margin-bottom: 5px;
            font-style: italic;
        }

        .item-description, .job-description, .project-description {
            font-size: 9.5pt;
            color: #444444;
            margin-bottom: 6px;
            line-height: 1.4;
            text-align: justify;
            white-space: pre-wrap;
        }
        
        .technologies {
            font-size: 8.5pt;
            color: #0078d4;
            margin-top: 4px;
            font-style: italic;
        }

        /* Liste à puces pour Réalisations (Tâches) */
        .achievements-title {
            font-size: 9.5pt;
            font-weight: 600;
            color: #333333;
            margin-top: 6px;
            margin-bottom: 3px;
        }
        
        ul.achievements {
            padding-left: 15px;
            margin-left: 0px;
            margin-top: 0;
            list-style-type: disc;
        }
        
        ul.achievements li {
            margin-bottom: 3px;
            color: #444444;
            font-size: 9pt;
            line-height: 1.35;
        }

        /* Compétences */
        .skill-category {
            margin-bottom: 12px;
        }
        
        .skill-title {
            font-weight: 600;
            margin-bottom: 6px;
            color: #1a4a8b;
            font-size: 10pt;
        }
        
        .skill-item {
            margin-bottom: 6px;
        }
        
        .skill-bar {
            height: 6px;
            background-color: #e9ecef;
            border-radius: 3px;
            overflow: hidden;
            margin-top: 2px;
        }
        
        .skill-fill {
            height: 100%;
            background-color: #0078d4;
            border-radius: 3px;
        }
        
        .skill-percent {
            display: block;
            margin-bottom: 1px;
        }
        
        .skill-name {
            font-weight: 500;
            font-size: 9.5pt;
            display: inline-block;
            margin-right: 4px;
        }
        
        .skill-level-text {
            font-size: 8pt;
            color: #555555;
            display: inline-block;
        }

        /* Langues */
        .language-item {
            margin-bottom: 8px;
        }
        
        .language-name {
            font-weight: 500;
            display: block;
            font-size: 9.5pt;
            margin-bottom: 1px;
        }
        
        .language-level-text {
            font-size: 8.5pt;
            color: #555555;
            font-style: italic;
            display: block;
        }
        
        .language-level-dots {
            margin-top: 2px;
            line-height: 1;
        }
        
        .level-dot {
            width: 8px;
            height: 8px;
            background-color: #e0e0e0;
            border-radius: 50%;
            margin-right: 3px;
            display: inline-block;
        }
        
        .level-dot.active {
            background-color: #0078d4;
        }

        /* Centres d'intérêt */
        .interests {
            line-height: 1.6;
        }
        
        .interest-item {
            display: inline;
            font-size: 9pt;
            color: #005a9e;
            padding: 0 4px;
            border-right: 1px solid #cccccc;
            margin-right: 4px;
        }
        
        .interest-item:first-child {
            padding-left: 0;
        }
        
        .interest-item:last-child {
            border-right: none;
            padding-right: 0;
            margin-right: 0;
        }

        /* Informations Personnelles */
        .personal-info-section .info-item {
            margin-bottom: 6px;
            font-size: 9.5pt;
        }
        
        .personal-info-section .info-label {
            font-weight: 600;
            color: #1a4a8b;
            display: inline-block;
            width: 75px;
        }
        
        .personal-info-section .info-value {
            color: #444444;
        }

        /* Références */
        .references-section .reference-item {
            margin-bottom: 12px;
            font-size: 9.5pt;
            border-left: 3px solid #e9ecef;
            padding-left: 8px;
        }
        
        .references-section .reference-name {
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 1px;
        }
        
        .references-section .reference-position {
            font-size: 9pt;
            color: #005a9e;
            margin-bottom: 1px;
        }
        
        .references-section .reference-relation {
            font-size: 8.5pt;
            color: #555555;
            font-style: italic;
            margin-bottom: 3px;
            display: inline-block;
            margin-left: 4px;
        }
        
        .references-section .reference-contact {
            font-size: 8.5pt;
            color: #444444;
        }

        /* Icônes PDF */
        .contact-item i::before, .period i::before, .project-url i::before, .certification-item .period i::before {
            display: inline-block;
            font-style: normal;
            font-variant: normal;
            text-rendering: auto;
            -webkit-font-smoothing: antialiased;
            font-family: 'DejaVu Sans';
            font-weight: normal;
            width: 1.2em;
            text-align: left;
            margin-right: 5px;
            line-height: 1;
        }
        
        .contact-item i.fa-phone::before { content: '\260E'; }
        .contact-item i.fa-envelope::before { content: '\2709'; }
        .contact-item i.fa-map-marker-alt::before { content: '\1F4CD'; }
        .contact-item i.fa-link::before { content: '\1F517'; }
        .contact-item i.fab.fa-linkedin::before { content: 'L'; font-weight: bold; font-family: sans-serif; }
        .period i.fa-calendar-alt::before { content: '\1F4C5'; }
        .project-url i.fa-link::before { content: '\1F517'; }
        .certification-item .period i.fa-link::before { content: '\1F517'; }
        
        /* Gestion des sauts de page pour l'impression */
        @media print {
            @page {
                size: A4 portrait;
                margin: 0;
            }
            
            body {
                margin: 0;
                padding: 0;
            }
            
            .cv-container {
                width: 100%;
                height: auto;
            }
            
            /* Pour éviter les sauts de page indésirables */
            tr.content-row {
                page-break-inside: auto;
            }
            
            /* Titres des sections restent avec leur contenu */
            .section-title {
                page-break-after: avoid;
            }
            
            /* Éléments qui ne doivent pas être coupés */
            .job-title, .degree, .certification-name, .project-name {
                page-break-after: avoid;
            }
            
            /* L'en-tête reste sur la première page uniquement */
            .header-cell {
                display: table-cell;
            }
        }
    </style>
</head>
<body>
    <!-- Table principale qui contient tout le CV (en-tête + colonnes) -->
    <table class="cv-container" id="cv-preview-content" cellpadding="0" cellspacing="0" border="0">
        <!-- Ligne d'en-tête -->
        <tr>
            <td class="header-cell" colspan="2">
                <!-- Table interne pour l'en-tête -->
                <table class="header-inner-table" cellpadding="0" cellspacing="0" border="0">
                    <tr>
                        <!-- Cellule Photo -->
                        <td class="header-photo-cell">
                            @if($cvProfile->photo_cv_path)
                        <div class="photo-container">
                             @php
                                $photoPath = null; $imageData = null;
                                    try { 
                                        if (Storage::disk('public')->exists($cvProfile->photo_cv_path)) { 
                                            $photoPath = Storage::disk('public')->path($cvProfile->photo_cv_path); 
                                            $imageData = base64_encode(file_get_contents($photoPath)); 
                                        } 
                                    } catch (\Exception $e) { 
                                        \Log::error("Erreur chargement image CV PDF: ".$e->getMessage()); 
                                    }
                             @endphp
                             @if($imageData)
                                 <img src="data:image/{{ pathinfo($photoPath ?? $cvProfile->photo_cv_path, PATHINFO_EXTENSION) }};base64,{{ $imageData }}" alt="Photo {{ $cvProfile->nom_complet }}" />
                             @else
                                 <div style="width: 100%; height: 100%; background-color: #ccc;"></div>
                             @endif
                        </div>
                        @endif
                        </td>
                        <!-- Cellule Contenu -->
                        <td class="header-content-cell">
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
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        
        <!-- Ligne principale de contenu -->
        <tr class="content-row">
            <!-- CELLULE GAUCHE -->
            <td class="left-column-cell">
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
                        @if($proj->url_projet)<div class="project-url"><i class="fas fa-link"></i>&nbsp;<a href="{{ $proj->url_projet }}" target="_blank">{{ Str::limit(str_replace(['https://', 'http://'], '', $proj->url_projet), 40) }}</a></div>@endif
                         @if($proj->description)<p class="project-description">{!! nl2br(e($proj->description)) !!}</p>@endif
                         @if($proj->technologies)<p class="technologies">Technologies: {{ $proj->technologies }}</p>@endif
                     </div>
                     @endforeach
                 </div>
                 @endif
            </td>

            <!-- CELLULE DROITE -->
            <td class="right-column-cell">
                <!-- Section Informations Personnelles -->
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
                            <span class="interest-item">{{ $interet->nom }}</span>{{ !$loop->last ? '' : '' }}
                         @endforeach
                    </p>
                </div>
                @endif

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
            </td>
        </tr>
    </table>
</body>
</html>