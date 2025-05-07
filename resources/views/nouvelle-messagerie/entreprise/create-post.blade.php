@extends('layouts.entreprises.master')

@section('title', 'Créer une annonce | StagesBENIN')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-9">
            <div class="card">
                <div class="card-header">
                    <h1 class="h3 mb-0">Créer une annonce</h1>
                </div>
                <div class="card-body">
                    <form action="{{ route('entreprises.messagerie-sociale.store-post') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="form-group mb-3">
                            <label for="title">Titre de l'annonce</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title') }}" required>
                            @error('title')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        
                        <div class="form-group mb-3">
                            <label for="content">Contenu de l'annonce</label>
                            <textarea class="form-control @error('content') is-invalid @enderror" id="content" name="content" rows="6" required>{{ old('content') }}</textarea>
                            @error('content')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        
                        <div class="form-group mb-3">
                            <label for="attachments">Pièces jointes (optionnel)</label>
                            <input type="file" class="form-control @error('attachments.*') is-invalid @enderror" id="attachments" name="attachments[]" multiple>
                            <small class="form-text text-muted">Vous pouvez sélectionner plusieurs fichiers (PDF, images, documents, etc.)</small>
                            @error('attachments.*')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        
                        <div class="form-group mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="important" name="important" {{ old('important') ? 'checked' : '' }}>
                                <label class="form-check-label" for="important">
                                    Marquer comme important
                                </label>
                            </div>
                        </div>
                        
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('entreprises.messagerie-sociale.index') }}" class="btn btn-secondary">Annuler</a>
                            <button type="submit" class="btn btn-primary">Publier l'annonce</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection