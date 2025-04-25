<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails de l'événement</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .event-header {
            text-align: center;
            margin-bottom: 20px;
        }
        .event-header img {
            width: 150px;
        }
        .event-details {
            border: 1px solid #ddd;
            padding: 10px;
        }
        .event-details h1 {
            font-size: 24px;
            color: #007BFF;
        }
    </style>
</head>
<body>
    <div class="event-header">
        <img src="{{ asset('images/events/' . $event->image) }}" alt="{{ $event->title }}">
        <h1>{{ $event->title }}</h1>
    </div>
    <div class="event-details">
        <p><strong>Date :</strong> {{ $event->start_date }}</p>
        <p><strong>Catégorie :</strong> {{ $event->categorie }}</p>
        <p><strong>Localisation :</strong> {{ $event->location }}</p>
        <p>{{ $event->description }}</p>
    </div>
</body>
</html>
