@extends('layouts.app')

@section('content')
<style>
    /* Ajoutez vos styles ici */
    .container {
        max-width: 850px;
        margin: auto;
        background-color: #fff;
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }

    .section-title {
        font-size: 24px;
        font-weight: bold;
        color: #212529;
        text-align: center;
        margin-bottom: 20px;
    }

    .form-grid {
        display: grid;
        grid-template-columns: auto 1fr;
        gap: 16px;
        align-items: center;
    }

    .form-label {
        font-weight: 600;
        color: #495057;
    }

    .form-control {
        border-radius: 8px;
        padding: 10px;
        border: 1px solid #ced4da;
        box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.08);
    }

    .form-control:focus {
        border-color: #28a745;
        box-shadow: 0 0 4px rgba(40, 167, 69, 0.3);
    }

    .btn-group {
        display: flex;
        justify-content: space-between;
        margin-top: 30px;
    }

    .btn {
        padding: 12px 20px;
        border-radius: 10px;
        font-weight: bold;
        transition: all 0.2s ease-in-out;
    }

    .btn-outline-danger {
        border: 2px solid #dc3545;
        color: #dc3545;
    }

    .btn-outline-danger:hover {
        background-color: #dc3545;
        color: #fff;
    }

    .btn-success {
        background-color: #28a745;
        border: none;
        color: #fff;
    }

    .btn-success:hover {
        background-color: #218838;
    }
</style>

<div class="container">
    <h1 class="section-title">Modifier le Catalogue</h1>

    <form action="{{ route('catalogue.update', $catalogue->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-grid">
            <label for="titre" class="form-label">Titre :</label>
            <input type="text" name="titre" id="titre" class="form-control" value="{{ old('titre', $catalogue->titre) }}" required maxlength="255">

            <label for="description" class="form-label">Description :</label>
            <textarea name="description" id="description" rows="4" class="form-control" required>{{ old('description', $catalogue->description) }}</textarea>

            <label for="localisation" class="form-label">Localisation :</label>
            <input type="text" name="localisation" id="localisation" class="form-control" value="{{ old('localisation', $catalogue->localisation) }}" maxlength="255">

            <label for="nb_activites" class="form-label">Nombre d'activités :</label>
            <input type="number" name="nb_activites" id="nb_activites" class="form-control" value="{{ old('nb_activites', $catalogue->nb_activites) }}">

            <label for="activite_principale" class="form-label">Activité principale :</label>
            <input type="text" name="activite_principale" id="activite_principale" class="form-control" value="{{ old('activite_principale', $catalogue->activite_principale) }}" maxlength="255">

            <label for="desc_activite_principale" class="form-label">Description de l'activité principale :</label>
            <textarea name="desc_activite_principale" id="desc_activite_principale" rows="4" class="form-control">{{ old('desc_activite_principale', $catalogue->desc_activite_principale) }}</textarea>

            <label for="activite_secondaire" class="form-label">Activité secondaire :</label>
            <input type="text" name="activite_secondaire" id="activite_secondaire" class="form-control" value="{{ old('activite_secondaire', $catalogue->activite_secondaire) }}" maxlength="255">

            <label for="desc_activite_secondaire" class="form-label">Description de l'activité secondaire :</label>
            <textarea name="desc_activite_secondaire" id="desc_activite_secondaire" rows="4" class="form-control">{{ old('desc_activite_secondaire', $catalogue->desc_activite_secondaire) }}</textarea>

            <label for="autres" class="form-label">Autres informations :</label>
            <textarea name="autres" id="autres" rows="4" class="form-control">{{ old('autres', $catalogue->autres) }}</textarea>

            <label for="logo" class="form-label">Logo :</label>
            <input type="file" name="logo" id="logo" class="form-control">

            <label for="image" class="form-label">Image :</label>
            <input type="file" name="image" id="image" class="form-control">
        </div>

        <div class="btn-group">
            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-danger">❌ Annuler</a>
            <button type="submit" class="btn btn-success">💾 Enregistrer</button>
        </div>
    </form>
</div>
@endsection
