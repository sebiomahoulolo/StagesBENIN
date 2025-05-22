{{-- resources/views/etudiants/cv/show-pdf.blade.php --}}

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>CV PDF</title>
    <style>
        /* Un peu de CSS pour le rendu PDF */
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
        }
        .cv-section {
            margin-bottom: 20px;
        }
        .section-title {
            font-weight: bold;
            font-size: 14px;
            margin-bottom: 5px;
        }
    </style>
</head>
<body>
    {{-- Contenu du CV --}}
    @include('etudiants.cv.templates.default', ['cvProfile' => $cvProfile])
</body>
</html>
