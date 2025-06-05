<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Convocation à un entretien</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            padding: 20px;
            color: #333333;
        }

        .email-content {
            background-color: #ffffff;
            padding: 25px;
            border-radius: 8px;
            max-width: 600px;
            margin: auto;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            line-height: 1.6;
        }

        .email-content p {
            margin-bottom: 15px;
        }

        .signature {
            margin-top: 30px;
        }
    </style>
</head>

<body>
    <div class="email-content">
        <p>Bonjour, {{ $data['etudiant'] }}</p>

        <p>
            Vous êtes convoqué(e) à un entretien concernant l'annonce
            <strong>« Développeur d'application web full stack »</strong>.
        </p>

        <p>Voici les détails de l'entretien :</p>

        <p>
            - <strong>Référence</strong> : {{ $data['reference'] }}<br>
            - <strong>Date</strong> : {{ \Carbon\Carbon::parse($data['date'])->format('d-m-Y') }}
            <strong>à</strong>  {{ \Carbon\Carbon::parse($data['heure'])->format('H:i') }}<br>
            - <strong>Durée</strong> : {{ $data['duree'] }} minutes<br>
        </p>

        <p>
            Nous vous prions de bien vouloir être ponctuel(le) à la date et à l'heure indiquées.
        </p>

        <p class="signature">
            Cordialement,<br>
            <strong>L’équipe de recrutement</strong>
        </p>

        <a href="{{ route('etudiants.entretiens.programmes') }}">Cliquer ici pour confirmer votre présence</a>
    </div>
</body>

</html>
