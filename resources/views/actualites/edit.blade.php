@extends('layouts.app')

@section('content')
<style>
    .card-container {
        max-width: 800px;
        margin: 40px auto;
        background: #fff;
        padding: 40px;
        border-radius: 16px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.07);
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .card-container h1 {
        font-size: 28px;
        font-weight: bold;
        color: #343a40;
        margin-bottom: 30px;
        text-align: center;
    }

    .form-label {
        font-weight: 600;
        color: #495057;
        display: block;
        margin-bottom: 6px;
    }

    .form-control {
        width: 100%;
        padding: 12px;
        border-radius: 8px;
        border: 1px solid #ced4da;
        margin-bottom: 20px;
        transition: border 0.3s, box-shadow 0.3s;
    }

    .form-control:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 6px rgba(13, 110, 253, 0.3);
    }

    .form-textarea {
        resize: vertical;
    }

    .image-preview {
        width: 100%;
        max-height: 200px;
        object-fit: cover;
        border-radius: 8px;
        margin-top: 10px;
        margin-bottom: 20px;
    }

    .btn-group {
        display: flex;
        justify-content: space-between;
        gap: 10px;
        margin-top: 30px;
        flex-wrap: wrap;
    }

    .btn-primary,
    .btn-secondary {
        padding: 12px 24px;
        border-radius: 10px;
        font-weight: 600;
        text-transform: uppercase;
        transition: 0.3s ease-in-out;
        flex: 1 1 45%;
        text-align: center;
    }

    .btn-primary {
        background-color: #0d6efd;
        border: none;
        color: #fff;
    }

    .btn-primary:hover {
        background-color: #0b5ed7;
    }

    .btn-secondary {
        background-color: #6c757d;
        border: none;
        color: #fff;
    }

    .btn-secondary:hover {
        background-color: #5a6268;
    }

    /* Responsive Design */
    @media (max-width: 576px) {
        .card-container {
            padding: 20px;
            margin: 20px 10px;
        }

        .card-container h1 {
            font-size: 22px;
        }

        .btn-group {
            flex-direction: column;
        }

        .btn-primary,
        .btn-secondary {
            width: 100%;
        }
    }
</style>

<div class="card-container">
    <h1>Modifier l'actualité</h1>
    <form action="{{ route('actualites.update', $actualite->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PATCH')

        <!-- Titre -->
        <label for="titre" class="form-label">Titre de l’actualité</label>
        <input type="text" name="titre" id="titre" class="form-control" value="{{ $actualite->titre }}" required>

        <!-- Contenu -->
        <label for="contenu" class="form-label">Contenu</label>
        <textarea name="contenu" id="contenu" rows="6" class="form-control form-textarea" required>{{ $actualite->contenu }}</textarea>

        <!-- Date -->
        <label for="date_publication" class="form-label">Date de publication</label>
        <input type="date" name="date_publication" id="date_publication" class="form-control" value="{{ $actualite->date_publication->format('Y-m-d') }}" required>

        <!-- Catégorie (Optionnel) -->
        <label for="categorie" class="form-label">Catégorie (optionnelle)</label>
        <input type="text" name="categorie" id="categorie" class="form-control" value="{{ $actualite->categorie }}" placeholder="Exemple : Technologie, Santé, etc.">

        <!-- Image actuelle -->
        @if($actualite->image_path)
            <label class="form-label">Image actuelle</label>
            <img src="{{ asset('images/actualites/' . $actualite->image_path) }}" alt="Image actuelle" class="image-preview">
        @endif

        <!-- Nouvelle image -->
        <label for="image_path" class="form-label">Changer l'image (optionnel)</label>
        <input type="file" name="image_path" id="image_path" class="form-control" accept="image/*" onchange="previewImage(event)">

        <!-- Aperçu image sélectionnée -->
        <img id="preview" class="image-preview" style="display:none;" />

        <!-- Boutons -->
        <div class="btn-group">
            <button type="submit" class="btn btn-primary">Enregistrer</button>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">Annuler</a>
        </div>
    </form>
</div>

<script>
    function previewImage(event) {
        const preview = document.getElementById('preview');
        const file = event.target.files[0];
        if (file) {
            preview.src = URL.createObjectURL(file);
            preview.style.display = 'block';
        }
    }
</script>
@endsection
