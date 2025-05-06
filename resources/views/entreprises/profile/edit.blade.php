@extends('layouts.entreprises.master')

@section('title', 'StagesBENIN')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/profile-edit.css') }}">
    <style>
        .logo-preview-container img { width: 120px; height: 120px; object-fit: cover; border: 2px solid var(--border-color); }
        .logo-preview-container .placeholder { width: 120px; height: 120px; background-color: var(--light-gray); display:flex; align-items:center; justify-content:center; border: 2px solid var(--border-color); }
        .logo-preview-container .placeholder i { font-size: 2.5rem; color: var(--gray); }
    </style>
@endpush

@section('content')
    <div class="content-header">
        <div class="welcome-message">
            <h1>Mon Profil</h1>
            <p>Gérez les informations de votre compte et de votre entreprise.</p>
        </div>
    </div>

    <div class="profile-page-container">
        {{-- Messages Flash --}}
        @if (session('status'))
            <div class="alert alert-success mb-4" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)">
                @switch(session('status'))
                    @case('profile-updated') Informations du compte mises à jour. @break
                    @case('entreprise-info-updated') Informations entreprise mises à jour. @break
                    @case('logo-updated') Logo mis à jour. @break
                    @case('password-updated') Mot de passe mis à jour. @break
                    @default Opération réussie.
                @endswitch
            </div>
        @endif

        {{-- 1. Section: Informations Générales du Compte --}}
        <div class="form-section">
            <header>
                <h2 class="section-title">Informations du Compte</h2>
                <p class="section-description">Mettez à jour le nom et l'adresse e-mail de votre compte.</p>
            </header>

            <form method="post" action="{{ route('entreprises.profile.updateGeneral') }}" class="mt-4">
                @csrf
                @method('patch')
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label for="name">Nom</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                               id="name" name="name" value="{{ old('name', $user->name) }}" required>
                        @error('name')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" 
                               id="email" name="email" value="{{ old('email', $user->email) }}">
                        @error('email')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="mt-3">
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                </div>
            </form>
        </div>

        {{-- 2. Section: Informations Entreprise --}}
        <div class="form-section">
            <header>
                <h2 class="section-title">Informations Entreprise</h2>
                <p class="section-description">Complétez ou modifiez les informations de votre entreprise.</p>
            </header>

            <form method="post" action="{{ route('entreprises.profile.updateEntrepriseInfo') }}" class="mt-4">
                @csrf
                @method('patch')
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label for="nom">Nom de l'entreprise</label>
                        <input type="text" class="form-control @error('nom') is-invalid @enderror" 
                               id="nom" name="nom" value="{{ old('nom', $entreprise->nom) }}" required>
                        @error('nom')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="secteur">Secteur d'activité</label>
                        <input type="text" class="form-control @error('secteur') is-invalid @enderror" 
                               id="secteur" name="secteur" value="{{ old('secteur', $entreprise->secteur) }}" required>
                        @error('secteur')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-12 form-group">
                        <label for="description">Description</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                  id="description" name="description" rows="4">{{ old('description', $entreprise->description) }}</textarea>
                        @error('description')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-6 form-group">
                        <label for="adresse">Adresse</label>
                        <input type="text" class="form-control @error('adresse') is-invalid @enderror" 
                               id="adresse" name="adresse" value="{{ old('adresse', $entreprise->adresse) }}">
                        @error('adresse')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="telephone">Téléphone</label>
                        <input type="tel" class="form-control @error('telephone') is-invalid @enderror" 
                               id="telephone" name="telephone" value="{{ old('telephone', $entreprise->telephone) }}">
                        @error('telephone')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-6 form-group">
                        <label for="site_web">Site Web</label>
                        <input type="url" class="form-control @error('site_web') is-invalid @enderror" 
                               id="site_web" name="site_web" value="{{ old('site_web', $entreprise->site_web) }}">
                        @error('site_web')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="contact_principal">Contact Principal</label>
                        <input type="text" class="form-control @error('contact_principal') is-invalid @enderror" 
                               id="contact_principal" name="contact_principal" value="{{ old('contact_principal', $entreprise->contact_principal) }}">
                        @error('contact_principal')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="mt-3">
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                </div>
            </form>
        </div>

        {{-- 3. Section: Logo --}}
        <div class="form-section">
            <header>
                <h2 class="section-title">Logo Entreprise</h2>
                <p class="section-description">Ajoutez ou modifiez le logo de votre entreprise.</p>
            </header>

            <form method="post" action="{{ route('entreprises.profile.updateLogo') }}" 
                  enctype="multipart/form-data" class="mt-4">
                @csrf
                <div class="row">
                    <div class="col-md-7">
                        <div class="form-group" x-data="{ logoPreview: null }">
                            <label for="logo">Choisir un nouveau logo (Max 2Mo)</label>
                            <input type="file" class="form-control @error('logo') is-invalid @enderror"
                                   id="logo" name="logo" accept="image/png,image/jpeg,image/jpg,image/gif"
                                   @change="const reader = new FileReader();
                                           reader.onload = (e) => { logoPreview = e.target.result; };
                                           reader.readAsDataURL($event.target.files[0]);">
                            @error('logo')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror

                            <div class="mt-3 logo-preview-container">
                                <span class="form-label d-block mb-2">Aperçu :</span>
                                <template x-if="logoPreview">
                                    <img :src="logoPreview" alt="Aperçu nouveau logo">
                                </template>
                                <template x-if="!logoPreview">
                                    @if ($entreprise->logo_path)
                                        <img src="{{ Storage::url($entreprise->logo_path) }}" alt="Logo actuel">
                                    @else
                                        <div class="placeholder">
                                            <i class="fas fa-building"></i>
                                        </div>
                                    @endif
                                </template>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary">Mettre à jour le Logo</button>
                    </div>
                </div>
            </form>
        </div>

        {{-- 4. Section: Mise à jour du Mot de Passe --}}
        <div class="form-section">
            <header>
                <h2 class="section-title">Modification du Mot de Passe</h2>
                <p class="section-description">Assurez la sécurité de votre compte en utilisant un mot de passe fort.</p>
            </header>

            <form method="post" action="{{ route('password.update') }}" class="mt-4">
                @csrf
                @method('put')

                <div class="row">
                    <div class="col-md-4 form-group">
                        <label for="current_password">Mot de passe actuel</label>
                        <input type="password" class="form-control @error('current_password') is-invalid @enderror" 
                               id="current_password" name="current_password" required>
                        @error('current_password')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-4 form-group">
                        <label for="password">Nouveau mot de passe</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" 
                               id="password" name="password" required>
                        @error('password')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-4 form-group">
                        <label for="password_confirmation">Confirmer le mot de passe</label>
                        <input type="password" class="form-control" 
                               id="password_confirmation" name="password_confirmation" required>
                    </div>
                </div>
                <div class="mt-3">
                    <button type="submit" class="btn btn-primary">Mettre à jour le mot de passe</button>
                </div>
            </form>
        </div>
    </div>
@endsection