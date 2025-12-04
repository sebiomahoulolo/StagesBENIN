{{-- /resources/views/etudiants/cv/templates/default.blade.php --}}
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>{{ $cvProfile->nom ?? 'Mon CV' }}</title>
<style>
        /* Styles généraux */
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'DejaVu Sans', Arial, sans-serif; }
        body { background-color: white; color: #333333; line-height: 1.4; font-size: 10pt; }
        h1, h2, h3, h4, h5, h6 { font-weight: 600; color: #2c3e50; }
        p { margin-bottom: 0.6em; }
        a { color: #005a9e; text-decoration: none; }
        ul { list-style-position: inside; padding-left: 5px; }

        /* Conteneur Principal */
        .cv-container {
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
            background-color: white;
            border-collapse: collapse;
        }

        /* En-tête */
        .header-cell {
            background-color: #1a4a8b;
            color: white;
            padding: 15px 20px;
            border-bottom: 4px solid #005a9e;
        }

        .header-inner-table {
            width: 100%;
            border-collapse: collapse;
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
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .header-content h1 {
            font-size: 20pt;
            color: white;
            margin-bottom: 4px;
        }

        .header-content h2 {
            font-size: 12pt;
            color: white;
            opacity: 0.95;
            margin-bottom: 10px;
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
        }

        /* Colonnes */
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

        /* Sections */
        .section {
            margin-bottom: 15px;
        }

        .section-title {
            font-size: 13pt;
            color: #1a4a8b;
            padding-bottom: 6px;
            margin-bottom: 10px;
            border-bottom: 2px solid #0078d4;
        }

        /* Contenu */
        .profile-text {
            font-size: 9.5pt;
            line-height: 1.45;
            color: #444444;
            text-align: justify;
        }

        .experience-item, .education-item, .project-item {
            margin-bottom: 15px;
            position: relative;
            padding-left: 15px;
        }

        .experience-item::before, .education-item::before, .project-item::before {
            content: "•";
            position: absolute;
            left: 0;
            top: 0;
            font-size: 14pt;
            color: #0078d4;
        }

        .job-title, .degree, .project-name {
            font-size: 10.5pt;
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 1px;
        }

        .company, .school, .project-url {
            font-size: 9.5pt;
            color: #005a9e;
            margin-bottom: 1px;
        }

        .period {
            font-size: 8.5pt;
            color: #555555;
            margin-bottom: 5px;
            font-style: italic;
        }

        .job-description, .item-description, .project-description {
            font-size: 9.5pt;
            color: #444444;
            margin-bottom: 6px;
            line-height: 1.4;
        }

        .technologies {
            font-size: 8.5pt;
            color: #0078d4;
            margin-top: 4px;
            font-style: italic;
        }

        /* Compétences */
        .skill-category {
            margin-bottom: 10px;
        }

        .skill-title {
            font-weight: 600;
            margin-bottom: 5px;
            color: #1a4a8b;
            font-size: 10pt;
        }

        .skill-item {
            margin-bottom: 5px;
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
            margin-bottom: 6px;
        }

        .language-name {
            font-weight: 500;
            font-size: 9.5pt;
            margin-bottom: 1px;
        }

        .language-level-text {
            font-size: 8.5pt;
            color: #555555;
            font-style: italic;
        }

        .language-level-dots {
            margin-top: 2px;
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

        .interest-item:last-child {
            border-right: none;
            margin-right: 0;
        }

        /* Informations personnelles */
        .info-item {
            margin-bottom: 5px;
            font-size: 9.5pt;
        }

        .info-label {
            font-weight: 600;
            color: #1a4a8b;
            display: inline-block;
            width: 75px;
        }

        .info-value {
            color: #444444;
        }

        /* Icônes */
        .contact-item i::before {
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
        .contact-item i.fab.fa-linkedin::before { content: 'L'; font-weight: bold; font-family: sans-serif; }
        .contact-item i.fa-link::before { content: '\1F517'; }
        .period i.fa-calendar-alt::before { content: '\1F4C5'; }

        /* Certifications */
        .certification-item {
            margin-bottom: 10px;
        }

        .certification-name {
            font-weight: bold;
            color: #0d6efd;
        }

        .organization {
            color: #6c757d;
            font-size: 0.9em;
            margin: 3px 0;
        }

        /* Références */
        .reference-item {
            margin-bottom: 10px;
        }

        .reference-name {
            font-weight: bold;
            color: #0d6efd;
        }

        .reference-position {
            color: #6c757d;
            font-size: 0.9em;
            margin: 3px 0;
        }

        .reference-contact {
            font-size: 0.9em;
            color: #6c757d;
        }

        /* Optimisations pour éviter les pages vides */
        @page {
            margin: 0.1cm;
            size: A4 portrait;
        }
        
        body {
            margin: 0;
            padding: 0;
            min-height: 0;
        }
        
        .cv-container {
            page-break-inside: avoid;
            height: auto;
        }
        
        .section {
            page-break-inside: avoid;
            margin-bottom: 12px;
        }
        
        .section:last-child {
            margin-bottom: 0;
        }
        
        /* Forcer la suppression des pages vides */
        tr.content-row {
            page-break-inside: avoid;
        }
        
        .left-column-cell, .right-column-cell {
            page-break-inside: avoid;
        }
        
        /* Réduire les marges des sections */
        .section-title {
            margin-bottom: 8px;
        }
        
        .experience-item, .education-item, .project-item {
            margin-bottom: 12px;
        }
        
        .experience-item:last-child, .education-item:last-child, .project-item:last-child {
            margin-bottom: 0;
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
        <div class="photo-container">
            @if($cvProfile->photo)
                <img src="{{ public_path('cv/' . $cvProfile->photo) }}" alt="Photo de profil" style="max-width:100%; height:auto;">
            @else
                <div style="width: 100%; height: 100%; background-color: #ccc; border-radius: 50%;"></div>
            @endif
      </div>
</td>
                        <!-- Cellule Contenu -->
                        <td class="header-content-cell">
                        <div class="header-content">
                            <h1>{{ $cvProfile->username }} </h1>
                            @if($cvProfile->title)<h2>{{ $cvProfile->title }}</h2>@endif
                            <div class="contact-info">
                                @if($cvProfile->phone)<div class="contact-item"><i class="fas fa-phone"></i> {{ $cvProfile->phone }}</div>@endif
                                @if($cvProfile->email)<div class="contact-item"><i class="fas fa-envelope"></i> <a href="mailto:{{ $cvProfile->email }}" style="color: white">{{ $cvProfile->email }}</a></div>@endif
                                @if($cvProfile->city)<div class="contact-item"><i class="fas fa-map-marker-alt"></i> {{ $cvProfile->city }}</div>@endif
                                @if($cvProfile->url_linkedin)<div class="contact-item"><i class="fab fa-linkedin"></i> <a href="{{ $cvProfile->url_linkedin }}" target="_blank" style="color: white">{{ Str::limit(str_replace(['https://', 'http://', 'www.', 'linkedin.com/in/'], '', rtrim($cvProfile->url_linkedin,'/')), 30) }}</a></div>@endif
                                @if($cvProfile->url_portfolio)<div class="contact-item"><i class="fas fa-link"></i> <a href="{{ $cvProfile->url_portfolio }}" target="_blank" style="color: white">{{ Str::limit(str_replace(['https://', 'http://', 'www.'], '', rtrim($cvProfile->url_portfolio,'/')), 30) }}</a></div>@endif
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
                @if($cvProfile->resume)
                <div class="section profile-section">
                    <h3 class="section-title">PROFIL</h3>
                    <p class="profile-text">{!! nl2br(e($cvProfile->resume)) !!}</p>
                </div>
                @endif

                @if($cvProfile->experiences->isNotEmpty())
                <div class="section experiences-section">
                    <h3 class="section-title">EXPÉRIENCE PROFESSIONNELLE</h3>
                    @foreach($cvProfile->experiences as $exp)
                    <div class="experience-item">
                        <div class="job-title">{{ $exp->poste }}</div>
                        <div class="company">{{ $exp->entreprise }} {{ $exp->ville ? '| '.$exp->ville : '' }}</div>
                        <div class="period"><i class="fas fa-calendar-alt"></i> {{ $exp->date_debut}} / {{ $exp->date_fin}}</div>
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
                     @foreach($cvProfile->formations as $form)
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
                         <div class="project-name">{{ $proj->titre }}</div>
                        @if($proj->lien)<div class="project-url"><i class="fas fa-link"></i>&nbsp;<a href="{{ $proj->lien }}" target="_blank">{{ Str::limit(str_replace(['https://', 'http://'], '', $proj->lien), 40) }}</a></div>@endif
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
    <span class="info-label">Naissance:</span> <span class="info-value">
        {{ $cvProfile->birthday ? \Carbon\Carbon::parse($cvProfile->birthday)->translatedFormat('d F Y') : 'N/A' }}
        {{ $cvProfile->lieu_naissance ? ' à ' . e($cvProfile->lieu_naissance) : '' }}
    </span>
   
</div>

                     @if($cvProfile->nationality)
                     <div class="info-item">
                         <span class="info-label">Nationalité:</span>  <span class="info-value">{{ e($cvProfile->nationality) }}</span>
                       
                     </div>
                     @endif
                     @if($cvProfile->situation_mat)
                     <div class="info-item">
                         <span class="info-label">Situation:</span><span class="info-value">{{ e($cvProfile->situation_mat) }}</span>
                         
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
                                 <span class="skill-name">{{ $comp->competence }}</span>
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

              

                @if($cvProfile->certifications->isNotEmpty())
                 <div class="section certifications-section">
                     <h3 class="section-title">CERTIFICATIONS</h3>
                     @foreach($cvProfile->certifications as $cert)
                     <div class="certification-item">
                         <div class="certification-name">{{ $cert->certification }}</div>
                         <div class="organization">{{ $cert->organisme }} {{ $cert->date_obtention ? '| '.$cert->date_obtention : '' }}</div>
                          @if($cert->url_validation)<div class="period" style="margin-bottom: 0;"><i class="fas fa-link"></i> <a href="{{ $cert->url_validation }}" target="_blank" style="font-size:8.5pt; color: #555;">Validation</a></div>@endif
                     </div>
                     @endforeach
                 </div>
                 @endif

                    @if($cvProfile->langues->isNotEmpty())
                <div class="section languages-section">
                    <h3 class="section-title">LANGUES</h3>
                    @foreach($cvProfile->langues as $lang)
                    <div class="language-item">
                                           <div class="language-name">{{ $lang->langue }} | {{ $lang->niveau }}</div>

                         @if(isset($lang->niveauPoints) && $lang->niveauPoints > 0)
                         @php $points = $lang->niveauPoints; @endphp
                         <div class="language-level-dots">@for($i = 1; $i <= 5; $i++)<div class="level-dot {{ $i <= $points ? 'active' : '' }}"></div>@endfor</div>
                         @endif
                    </div>
                    @endforeach
                </div>
                @endif

                 @if($cvProfile->loisirs->isNotEmpty())
                <div class="section interests-section">
                    <h3 class="section-title">CENTRES D'INTÉRÊT</h3>
                    <p class="interests">
                         @foreach($cvProfile->loisirs as $index => $interet)
                            <span class="interest-item">{{ $interet->loisir }}</span>{{ !$loop->last ? '' : '' }}
                         @endforeach
                    </p>
                </div>
                @endif

                @if($cvProfile->references->isNotEmpty())
                <div class="section references-section">
                    <h3 class="section-title">RÉFÉRENCES</h3>
                    @foreach($cvProfile->references as $ref)
                    <div class="reference-item">
                        <div class="reference-name">{{ $ref->nom }}</div>
                        @if($ref->relation)<div class="reference-position">{{ $ref->relation }}</div>@endif
                        @if($ref->commentaire)<div class="reference-relation">({{ $ref->commentaire }})</div>@endif
                        <div class="reference-contact">Contact: {{ $ref->telephone }}</div>
                    </div>
                    @endforeach
                </div>
                @endif
            </td>
        </tr>
    </table>
</body>
</html>   