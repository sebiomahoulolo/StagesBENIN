<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visualisation CV - {{ $cvProfile->nom_complet ?? 'Mon CV' }}</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background-color: #eef2f7; /* Fond légèrement différent */
            font-family: sans-serif;
            margin: 0;
            padding: 20px;
        }
        .cv-action-bar {
            background-color: #fff;
            padding: 15px 20px;
            margin-bottom: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 10px;
        }
        .cv-action-bar h2 {
            margin: 0;
            font-size: 1.4rem;
            color: #333;
        }
        .cv-action-bar .buttons a {
            display: inline-flex;
            align-items: center;
            padding: 8px 15px;
            margin-left: 10px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 0.9rem;
            border: 1px solid transparent;
            transition: all 0.3s;
        }
        .cv-action-bar .buttons a i {
            margin-right: 6px;
        }
        .cv-action-bar .btn-edit {
            background-color: #3498db;
            color: white;
        }
        .cv-action-bar .btn-edit:hover { background-color: #2980b9; }
        .cv-action-bar .btn-pdf {
            background-color: #e74c3c;
            color: white;
        }
         .cv-action-bar .btn-pdf:hover { background-color: #c0392b; }
        .cv-action-bar .btn-png {
            background-color: #9b59b6;
            color: white;
        }
         .cv-action-bar .btn-png:hover { background-color: #8e44ad; }

         /* Alerte flash */
        .flash-message {
             padding: 1rem; border-radius: 4px; margin-bottom: 1.5rem; border: 1px solid transparent;
         }
         .flash-success { background-color: #d4edda; color: #155724; border-color: #c3e6cb; }
         .flash-error { background-color: #f8d7da; color: #721c24; border-color: #f5c6cb; }

        /* Inclure ici les styles du template CV (identique à default.blade.php) */
        /* pour que la visualisation ressemble exactement au PDF/PNG */
        .cv-container { max-width: 900px; margin: 0 auto; /* Centrer le CV */ background-color: white; box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1); border-radius: 8px; overflow: hidden; position: relative; }
        /* ... TOUS les autres styles du template default.blade.php ... */
        /* ... */

    </style>
</head>
<body>

    <div class="cv-action-bar">
        <h2>Visualisation de votre CV</h2>
         {{-- Affichage des messages flash (si redirection depuis export PNG par ex) --}}
         @if(session('success')) <div class="flash-message flash-success" style="flex-basis: 100%; text-align:center;">{{ session('success') }}</div> @endif
         @if(session('error')) <div class="flash-message flash-error" style="flex-basis: 100%; text-align:center;">{{ session('error') }}</div> @endif
        <div class="buttons">
            <a href="{{ route('etudiant.cv.edit') }}" class="btn-edit"><i class="fas fa-edit"></i> Modifier</a>
            <a href="{{ route('etudiant.cv.export.pdf') }}" class="btn-pdf" target="_blank"><i class="fas fa-file-pdf"></i> Télécharger PDF</a>
            <a href="{{ route('etudiant.cv.export.png') }}" class="btn-png" target="_blank"><i class="fas fa-file-image"></i> Télécharger PNG</a>
        </div>
    </div>

    {{-- Inclure le template de CV pour l'affichage --}}
    {{-- Utilise la variable $cvProfile passée par le contrôleur --}}
    @include('etudiants.cv.templates.default', ['cvProfile' => $cvProfile])

</body>
</html>