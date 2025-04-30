<!DOCTYPE html>
<html lang="fr">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>StagesBENIN - {{ $cvProfile->nom_complet ?? 'Mon CV' }}</title>
    <style>
        /* Reset et configuration de base */
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'DejaVu Sans', Arial, sans-serif; }
        body { margin: 0; padding: 0; background-color: white; color: #333; line-height: 1.4; font-size: 9pt; }
        
        /* Configuration de la page - Format A4 explicite */
        @page {
            size: A4 portrait;
            margin: 0;
            padding: 0;
        }
        
        /* Pour assurer que les pages suivantes n'ont pas d'en-tête répété */
        .cv-page { 
            width: 100%; 
            margin: 0; 
            padding: 0;
        }
        
        /* Table principale - Structure globale */
        .main-table { 
            width: 100%; 
            border-collapse: collapse; 
            margin: 0; 
            padding: 0;
        }
        
        /* En-tête - Seulement sur la première page */
        .header-row { 
            background-color: #1a4a8b; 
            color: white;
        }
        .header-cell { 
            padding: 12px 20px 10px 20px;
            border-bottom: 3px solid #005a9e;
        }
        
        /* Structure interne de l'en-tête */
        .header-layout { 
            display: table; 
            width: 100%;
        }
        .header-photo { 
            display: table-cell; 
            width: 95px;
            vertical-align: middle; 
            padding-right: 15px;
        }
        .photo-container { 
            width: 170px;
            height: 170px; 
            border-radius: 50%; 
            border: 3px solid white;
            overflow: hidden; 
            background: #e0e0e0;
        }
        .photo-container img { 
            width: 170px; 
            height: 170px; 
            object-fit: cover; 
            border-radius: 50%;
        }
        
        .header-content { 
            display: table-cell; 
            vertical-align: middle;
        }
        .header-content h1 { 
            font-size: 16pt;
            margin: 0 0 2px 0;
            color: white; 
            font-weight: bold;
        }
        .header-content h2 { 
            font-size: 11pt;
            font-weight: normal; 
            margin: 0 0 5px 0;
            color: white; 
            opacity: 0.95;
        }
        
        .contact-info { 
            margin-top: 3px;
        }
        .contact-item { 
            display: inline-block; 
            margin-right: 12px; 
            margin-bottom: 2px;
            font-size: 8.5pt;
            color: white; 
            white-space: nowrap;
        }
        .contact-item a { 
            color: white; 
            text-decoration: none;
        }
        
        /* Colonnes de contenu */
        .content-row {
            page-break-inside: avoid;
            page-break-after: auto;
        }
        
        .left-column { 
            width: 63%; 
            padding: 10px 15px 10px 20px;
            vertical-align: top; 
            border-right: 1px solid #eaeaea;
        }
        .right-column { 
            width: 37%; 
            padding: 10px 20px 10px 15px;
            vertical-align: top; 
            background-color: #f8f9fa;
        }
        
        /* Pour les pages suivantes */
        .continuation-page {
            margin-top: 10px;
        }
        
        /* Sections avec meilleure gestion des sauts de page */
        .section { 
            margin-bottom: 10px;
            page-break-inside: auto;
        }
        .section-title { 
            font-size: 12pt;
            color: #1a4a8b; 
            border-bottom: 2px solid #0078d4; 
            margin-bottom: 7px;
            padding-bottom: 3px;
            font-weight: bold;
            page-break-after: avoid;
        }
        
        /* Contenu texte */
        p { 
            margin-bottom: 0.5em;
        }
        .profile-text { 
            font-size: 9pt; 
            text-align: justify; 
            line-height: 1.3;
            color: #444;
        }
        
        /* Éléments d'expérience, formation, etc. */
        .item { 
            margin-bottom: 8px;
            position: relative; 
            padding-left: 12px;
            page-break-inside: auto;
        }
        .item::before { 
            content: "•"; 
            position: absolute; 
            left: 0; 
            top: 0; 
            font-size: 11pt;
            color: #0078d4; 
            line-height: 1;
        }
        .item-title { 
            font-weight: bold; 
            font-size: 10pt;
            color: #2c3e50; 
            margin-bottom: 1px;
            page-break-after: avoid;
        }
        .item-subtitle { 
            font-size: 9pt;
            color: #005a9e; 
            font-weight: 500; 
            margin-bottom: 1px;
        }
        .item-date { 
            font-size: 8pt;
            color: #555; 
            font-style: italic; 
            margin-bottom: 3px;
        }
        .item-desc { 
            font-size: 9pt; 
            color: #444; 
            margin-bottom: 4px;
            line-height: 1.3;
        }
        
        /* Listes */
        ul { 
            margin: 4px 0 6px 0;
            padding-left: 14px;
            list-style-type: disc; 
            list-style-position: outside;
        }
        li { 
            margin-bottom: 2px;
            font-size: 8.5pt;
            color: #444; 
            line-height: 1.3;
        }
        
        /* Compétences */
        .skill-category { 
            margin-bottom: 8px;
        }
        .skill-title { 
            font-size: 9.5pt;
            font-weight: 600; 
            color: #1a4a8b; 
            margin-bottom: 4px;
        }
        .skill-item { 
            margin-bottom: 5px;
        }
        .skill-name { 
            font-weight: 500; 
            font-size: 9pt;
            display: inline-block; 
            margin-right: 5px;
        }
        .skill-level { 
            font-size: 8pt;
            color: #555; 
            display: inline-block;
        }
        .skill-bar { 
            height: 5px;
            background-color: #e9ecef; 
            border-radius: 3px; 
            margin-top: 2px; 
            overflow: hidden;
        }
        .skill-fill { 
            height: 100%; 
            background-color: #0078d4; 
            border-radius: 3px;
        }
        
        /* Langues */
        .language-item { 
            margin-bottom: 6px;
        }
        .language-name { 
            font-weight: 500; 
            font-size: 9pt;
            margin-bottom: 1px;
        }
        .language-level { 
            font-size: 8pt;
            color: #555; 
            font-style: italic;
        }
        .dots { 
            margin-top: 2px;
        }
        .dot { 
            display: inline-block; 
            width: 7px;
            height: 7px;
            border-radius: 50%; 
            background-color: #e0e0e0; 
            margin-right: 3px;
        }
        .dot.active { 
            background-color: #0078d4;
        }
        
        /* Centres d'intérêt */
        .interests-list { 
            line-height: 1.5;
        }
        .interest { 
            display: inline; 
            font-size: 8.5pt;
            color: #005a9e; 
            padding: 0 3px; 
            border-right: 1px solid #ccc; 
            margin-right: 3px;
        }
        .interest:first-child { 
            padding-left: 0;
        }
        .interest:last-child { 
            border-right: none; 
            padding-right: 0; 
            margin-right: 0;
        }
        
        /* Informations personnelles */
        .info-item { 
            margin-bottom: 5px;
            font-size: 9pt;
            display: table; 
            width: 100%;
        }
        .info-label { 
            font-weight: 600; 
            color: #1a4a8b; 
            display: table-cell; 
            width: 75px;
            vertical-align: top;
        }
        .info-value { 
            color: #444; 
            display: table-cell; 
            vertical-align: top;
        }
        
        /* Références */
        .reference { 
            margin-bottom: 7px;
            padding-left: 6px;
            border-left: 2px solid #e9ecef;
            font-size: 8.5pt;
        }
        .reference-name { 
            font-weight: 600; 
            color: #2c3e50; 
            margin-bottom: 1px;
        }
        .reference-position { 
            font-size: 8.5pt;
            color: #005a9e; 
            margin-bottom: 1px;
        }
        .reference-relation { 
            font-style: italic; 
            color: #555; 
            font-size: 8pt;
            margin-bottom: 1px; 
            display: inline-block; 
            margin-left: 4px;
        }
        .reference-contact { 
            font-size: 8pt;
            color: #444;
        }
        
        /* Icônes */
        .icon { 
            display: inline-block; 
            width: 1em; 
            margin-right: 3px;
            text-align: center; 
            line-height: 1;
            font-size: 0.9em;
        }

        /* Gestion des sauts de page manuelle */
        .page-break {
            page-break-after: always;
            height: 0;
            clear: both;
        }
    </style>
</head>
<body>
    <div class="cv-page">
        <!-- Première page avec en-tête -->
        <table class="main-table" cellpadding="0" cellspacing="0" border="0">
            <!-- En-tête - Uniquement sur la première page -->
            <tr class="header-row">
                <td class="header-cell" colspan="2">
                    <div class="header-layout">
                        @if($cvProfile->photo_cv_path)
                        <div class="header-photo">
                            <div class="photo-container">
                                @php
                                    $photoPath = null; $imageData = null;
                                    try { 
                                        if (Storage::disk('public')->exists($cvProfile->photo_cv_path)) { 
                                            $photoPath = Storage::disk('public')->path($cvProfile->photo_cv_path); 
                                            $imageData = base64_encode(file_get_contents($photoPath)); 
                                        } 
                                    } catch (\Exception $e) { 
                                        \Log::error("Erreur chargement image PDF: ".$e->getMessage()); 
                                    }
                                @endphp
                                @if($imageData)
                                    <img src="data:image/{{ pathinfo($photoPath ?? $cvProfile->photo_cv_path, PATHINFO_EXTENSION) }};base64,{{ $imageData }}" alt="Photo">
                                @else
                                    <div style="width: 100%; height: 100%; background-color: #ccc;"></div>
                                @endif
                            </div>
                        </div>
                        @endif
                        
                        <div class="header-content">
                            <h1>{{ $cvProfile->nom_complet ?? 'Nom Prénom' }}</h1>
                            @if($cvProfile->titre_profil)<h2>{{ $cvProfile->titre_profil }}</h2>@endif
                            
                            <div class="contact-info">
                                @if($cvProfile->contact_telephone)<div class="contact-item"><span class="icon">☎</span>{{ $cvProfile->contact_telephone }}</div>@endif
                                @if($cvProfile->contact_email)<div class="contact-item"><span class="icon">✉</span><a href="mailto:{{ $cvProfile->contact_email }}">{{ $cvProfile->contact_email }}</a></div>@endif
                                @if($cvProfile->adresse)<div class="contact-item"><span class="icon">📍</span>{{ $cvProfile->adresse }}</div>@endif
                                @if($cvProfile->linkedin_url)<div class="contact-item"><span class="icon">L</span><a href="{{ $cvProfile->linkedin_url }}">LinkedIn</a></div>@endif
                                @if($cvProfile->portfolio_url)<div class="contact-item"><span class="icon">🔗</span><a href="{{ $cvProfile->portfolio_url }}">Portfolio</a></div>@endif
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
            
            <!-- Contenu principal (continues automatiquement sur les pages suivantes) -->
            <tr class="content-row">
                <!-- Colonne gauche -->
                <td class="left-column">
                    @if($cvProfile->resume_profil)
                    <div class="section">
                        <h3 class="section-title">PROFIL</h3>
                        <p class="profile-text">{!! nl2br(e($cvProfile->resume_profil)) !!}</p>
                    </div>
                    @endif
                    
                    @if($cvProfile->experiences->isNotEmpty())
                    <div class="section">
                        <h3 class="section-title">EXPÉRIENCE PROFESSIONNELLE</h3>
                        @foreach($cvProfile->experiences()->orderBy('date_debut', 'desc')->get() as $exp)
                        <div class="item">
                            <div class="item-title">{{ $exp->poste }}</div>
                            <div class="item-subtitle">{{ $exp->entreprise }} {{ $exp->ville ? '| '.$exp->ville : '' }}</div>
                            <div class="item-date"><span class="icon">📅</span>{{ $exp->periode }}</div>
                            @if($exp->description)<div class="item-desc">{!! nl2br(e($exp->description)) !!}</div>@endif
                            
                            @php $taches = collect([$exp->tache_1, $exp->tache_2, $exp->tache_3])->filter()->all(); @endphp
                            @if(!empty($taches))
                            <ul>
                                @foreach($taches as $tache)<li>{{ e(trim($tache)) }}</li>@endforeach
                            </ul>
                            @endif
                        </div>
                        @endforeach
                    </div>
                    @endif
                    
                    @if($cvProfile->formations->isNotEmpty())
                    <div class="section">
                        <h3 class="section-title">FORMATION</h3>
                        @foreach($cvProfile->formations()->orderBy('annee_debut', 'desc')->get() as $form)
                        <div class="item">
                            <div class="item-title">{{ $form->diplome }}</div>
                            <div class="item-subtitle">{{ $form->etablissement }} {{ $form->ville ? '| '.$form->ville : '' }}</div>
                            <div class="item-date"><span class="icon">📅</span>{{ $form->annee_debut }} {{ $form->annee_fin ? '- '.$form->annee_fin : ($form->annee_debut ? '- En cours' : '') }}</div>
                            @if($form->description)<div class="item-desc">{!! nl2br(e($form->description)) !!}</div>@endif
                        </div>
                        @endforeach
                    </div>
                    @endif
                    
                    @if($cvProfile->projets->isNotEmpty())
                    <div class="section">
                        <h3 class="section-title">PROJETS</h3>
                        @foreach($cvProfile->projets as $proj)
                        <div class="item">
                            <div class="item-title">{{ $proj->nom }}</div>
                            @if($proj->url_projet)<div class="item-subtitle"><span class="icon">🔗</span><a href="{{ $proj->url_projet }}">{{ Str::limit(str_replace(['https://', 'http://'], '', $proj->url_projet), 40) }}</a></div>@endif
                            @if($proj->description)<div class="item-desc">{!! nl2br(e($proj->description)) !!}</div>@endif
                            @if($proj->technologies)<div style="font-size: 8pt; color: #0078d4; font-style: italic;">Technologies: {{ $proj->technologies }}</div>@endif
                        </div>
                        @endforeach
                    </div>
                    @endif
                </td>
                
                <!-- Colonne droite -->
                <td class="right-column">
                    <div class="section">
                        <h3 class="section-title">INFORMATIONS</h3>
                        <div class="info-item">
                            <div class="info-label">Naissance:</div>
                            <div class="info-value">{{ $cvProfile->date_naissance ? $cvProfile->date_naissance->translatedFormat('d F Y') : 'N/A' }}{{ $cvProfile->lieu_naissance ? ' à ' . e($cvProfile->lieu_naissance) : '' }}</div>
                        </div>
                        @if($cvProfile->nationalite)
                        <div class="info-item">
                            <div class="info-label">Nationalité:</div>
                            <div class="info-value">{{ e($cvProfile->nationalite) }}</div>
                        </div>
                        @endif
                        @if($cvProfile->situation_matrimoniale)
                        <div class="info-item">
                            <div class="info-label">Situation:</div>
                            <div class="info-value">{{ e($cvProfile->situation_matrimoniale) }}</div>
                        </div>
                        @endif
                    </div>
                    
                    @if($cvProfile->competences->isNotEmpty())
                    <div class="section">
                        <h3 class="section-title">COMPÉTENCES</h3>
                        @foreach($cvProfile->competences->groupBy('categorie') as $categorie => $competences)
                        <div class="skill-category">
                            <div class="skill-title">{{ $categorie }}</div>
                            @foreach($competences as $comp)
                            <div class="skill-item">
                                <div>
                                    <span class="skill-name">{{ $comp->nom }}</span>
                                    @if($comp->niveau)<span class="skill-level">{{ $comp->niveau }}%</span>@endif
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
                    <div class="section">
                        <h3 class="section-title">LANGUES</h3>
                        @foreach($cvProfile->langues as $lang)
                        <div class="language-item">
                            <div class="language-name">{{ $lang->langue }}</div>
                            <div class="language-level">{{ $lang->niveau }}</div>
                            @if(isset($lang->niveauPoints) && $lang->niveauPoints > 0)
                            @php $points = $lang->niveauPoints; @endphp
                            <div class="dots">
                                @for($i = 1; $i <= 5; $i++)
                                <span class="dot {{ $i <= $points ? 'active' : '' }}"></span>
                                @endfor
                            </div>
                            @endif
                        </div>
                        @endforeach
                    </div>
                    @endif
                    
                    @if($cvProfile->certifications->isNotEmpty())
                    <div class="section">
                        <h3 class="section-title">CERTIFICATIONS</h3>
                        @foreach($cvProfile->certifications as $cert)
                        <div class="item">
                            <div class="item-title">{{ $cert->nom }}</div>
                            <div class="item-subtitle">{{ $cert->organisme }} {{ $cert->annee ? '| '.$cert->annee : '' }}</div>
                            @if($cert->url_validation)<div style="font-size: 8pt; color: #555;"><span class="icon">🔗</span><a href="{{ $cert->url_validation }}" style="color: #555;">Validation</a></div>@endif
                        </div>
                        @endforeach
                    </div>
                    @endif
                    
                    @if($cvProfile->centresInteret->isNotEmpty())
                    <div class="section">
                        <h3 class="section-title">CENTRES D'INTÉRÊT</h3>
                        <div class="interests-list">
                            @foreach($cvProfile->centresInteret as $interet)
                            <span class="interest">{{ $interet->nom }}</span>
                            @endforeach
                        </div>
                    </div>
                    @endif
                    
                    @if($cvProfile->references->isNotEmpty())
                    <div class="section">
                        <h3 class="section-title">RÉFÉRENCES</h3>
                        @foreach($cvProfile->references as $ref)
                        <div class="reference">
                            <div class="reference-name">{{ $ref->nom_complet }}</div>
                            @if($ref->poste)<div class="reference-position">{{ $ref->poste }}</div>@endif
                            @if($ref->relation)<span class="reference-relation">({{ $ref->relation }})</span>@endif
                            <div class="reference-contact">Contact: {{ $ref->contact }}</div>
                        </div>
                        @endforeach
                    </div>
                    @endif
                </td>
            </tr>
        </table>
    </div>
</body>
</html> 