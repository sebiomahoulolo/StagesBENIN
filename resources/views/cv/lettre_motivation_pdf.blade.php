<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Lettre de motivation</title>
    <style>
        body { font-family: DejaVu Sans, Arial, sans-serif; font-size: 14px; color: #222; }
        .lettre-container { max-width: 700px; margin: 0 auto; padding: 2rem; }
        p { margin-bottom: 1em; }
        b, strong { font-weight: bold; }
        i, em { font-style: italic; }
        u { text-decoration: underline; }
    </style>
</head>
<body>
    <div class="lettre-container">
        @foreach(explode("\n", $lettre) as $ligne)
            <p>{!! $ligne !!}</p>
        @endforeach
    </div>
</body>
</html> 