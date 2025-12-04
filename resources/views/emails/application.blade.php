<!DOCTYPE html>
<html>
<head>
    <title>Nouvelle candidature</title>
</head>
<body>
    <h2>Nouvelle candidature reçue</h2>
    
    <p><strong>Poste:</strong> {{ $data['poste'] }}</p>
    <p><strong>Nom:</strong> {{ $data['civilite'] }} {{ $data['nom'] }} {{ $data['prenom'] }}</p>
    <p><strong>Email:</strong> {{ $data['email'] }}</p>
    <p><strong>Téléphone:</strong> {{ $data['telephone'] }}</p>
    <p><strong>Adresse:</strong> {{ $data['adresse'] }}, {{ $data['ville'] }}</p>
    <p><strong>Date de naissance:</strong> {{ $data['naissance'] }}</p>
    
    <h3>Formation</h3>
    <p><strong>Niveau:</strong> {{ $data['niveau'] }}</p>
    <p><strong>Dernier diplôme:</strong> {{ $data['diplome'] }}</p>
    <p><strong>Expérience:</strong> {{ $data['experience'] ?? 'Non spécifié' }} ans</p>
    
    <h3>Compétences</h3>
    <p>{{ $data['competences'] ?? 'Non spécifié' }}</p>
    
    <h3>Lettre de motivation</h3>
    <p>{{ $data['motivation'] }}</p>
    
    <p>Le dossier du candidat est joint à cet email.</p>
</body>
</html>