@extends('layouts.layout')

@section('title', 'Configuration du profil - StagesBENIN')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h2 class="text-center mb-0">Complétez le profil de votre entreprise</h2>
                </div>
                <div class="card-body">
                    <form action="{{ route('profile.setup.recruteur.save') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- Secteur -->
                        <div class="mb-3">
                            <label for="secteur_id" class="form-label">Secteur d'activité</label>
                            <select class="form-select @error('secteur_id') is-invalid @enderror" 
                                    id="secteur_id" name="secteur_id" required>
                                <option value="">Choisir un secteur d'activité</option>
                                @foreach($secteurs as $secteur)
                                    <option value="{{ $secteur->id }}">{{ $secteur->nom }}</option>
                                @endforeach
                            </select>
                            @error('secteur_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div class="mb-3">
                            <label for="description" class="form-label">Description de l'entreprise</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" name="description" rows="4" required>{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Adresse -->
                        <div class="mb-3">
                            <label for="adresse" class="form-label">Adresse</label>
                            <input type="text" class="form-control @error('adresse') is-invalid @enderror" 
                                   id="adresse" name="adresse" value="{{ old('adresse') }}" required>
                            @error('adresse')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Site web -->
                        <div class="mb-3">
                            <label for="site_web" class="form-label">Site web</label>
                            <input type="url" class="form-control @error('site_web') is-invalid @enderror" 
                                   id="site_web" name="site_web" value="{{ old('site_web') }}" placeholder="https://">
                            @error('site_web')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Contact principal -->
                        <div class="mb-3">
                            <label for="contact_principal" class="form-label">Contact principal</label>
                            <input type="text" class="form-control @error('contact_principal') is-invalid @enderror" 
                                   id="contact_principal" name="contact_principal" value="{{ old('contact_principal') }}" required>
                            @error('contact_principal')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Logo -->
                        <div class="mb-3">
                            <label for="logo" class="form-label">Logo de l'entreprise</label>
                            <input type="file" class="form-control @error('logo') is-invalid @enderror" 
                                   id="logo" name="logo" accept="image/*">
                            <small class="form-text text-muted">Format recommandé : PNG ou JPEG, max 2MB</small>
                            @error('logo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">Enregistrer et continuer</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection