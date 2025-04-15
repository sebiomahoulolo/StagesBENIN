{{-- /resources/views/etudiants/profile/edit.blade.php --}}

@extends('layouts.etudiant.app')

@section('title', 'Mon Profil')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/profile-edit.css') }}">
    <style>
        .photo-preview-container img { width: 80px; height: 80px; border-radius: 50%; object-fit: cover; border: 2px solid var(--border-color); }
        .photo-preview-container .placeholder { width: 80px; height: 80px; border-radius: 50%; background-color: var(--light-gray); display:flex; align-items:center; justify-content:center; border: 2px solid var(--border-color); }
        .photo-preview-container .placeholder i { font-size: 2rem; color: var(--gray); }
    </style>
@endpush

@section('content')
    <div class="content-header">
        <div class="welcome-message">
            <h1>Mon Profil</h1>
            <p>Gérez les informations de votre compte et de votre profil étudiant.</p>
        </div>
    </div>

    <div class="profile-page-container">

        {{-- Messages Flash --}}
        @if (session('status'))
            <div class="alert alert-success mb-4" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)">
                @switch(session('status'))
                    @case('profile-updated') Informations du compte mises à jour. @break
                    @case('student-info-updated') Informations étudiant mises à jour. @break
                    @case('profile-photo-updated') Photo de profil mise à jour. @break
                    @case('password-updated') Mot de passe mis à jour. @break
                    @default Opération réussie.
                @endswitch
            </div>
        @endif
         @if ($errors->any() && !$errors->hasBag('updatePassword') && !$errors->hasBag('updateProfileInformation'))
            <div class="alert alert-danger mb-4">
                 Une ou plusieurs erreurs sont survenues. Veuillez vérifier les formulaires.
            </div>
         @endif

        {{-- 1. Section: Informations Générales du Compte --}}
        <div class="form-section">
            <header>
                <h2 class="section-title">Informations du Compte</h2>
                <p class="section-description">Mettez à jour le nom et l'adresse e-mail de votre compte.</p>
            </header>

            <form method="post" action="{{ route('etudiants.profile.updateGeneral') }}" class="mt-4 space-y-6">
                @csrf @method('patch')
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label for="name" class="form-label">{{ __('Name') }} <span class="text-danger">*</span></label>
                        <input id="name" name="name" type="text" class="form-control @error('name', 'updateProfileInformation') is-invalid @enderror" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name" />
                        @error('name', 'updateProfileInformation') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="email" class="form-label">{{ __('Email') }} <span class="text-danger">*</span></label>
                        <input id="email" name="email" type="email" class="form-control @error('email', 'updateProfileInformation') is-invalid @enderror" value="{{ old('email', $user->email) }}" required autocomplete="username" />
                        @error('email', 'updateProfileInformation') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        {{-- Vérification Email ... --}}
                    </div>
                </div>
                <div class="flex items-center gap-4 mt-4">
                    {{-- CORRECTION: Suppression de la classe 'save-btn' --}}
                    <button type="submit" class="action-button">Enregistrer</button>
                    @if (session('status') === 'profile-updated')
                        <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2500)" class="text-sm text-success font-medium">Enregistré.</p>
                    @endif
                </div>
            </form>
        </div>

        {{-- 2. Section: Informations Spécifiques Étudiant --}}
        <div class="form-section">
            <header>
                <h2 class="section-title">Informations Étudiant</h2>
                <p class="section-description">Complétez ou modifiez vos informations complémentaires.</p>
            </header>
            <form method="post" action="{{ route('etudiants.profile.updateEtudiantInfo') }}" class="mt-4 space-y-6">
                @csrf @method('patch')
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label for="etudiant_telephone" class="form-label">Téléphone</label>
                        <input id="etudiant_telephone" name="telephone" type="tel" class="form-control @error('telephone') is-invalid @enderror" value="{{ old('telephone', $etudiant->telephone) }}" autocomplete="tel">
                        @error('telephone') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="etudiant_date_naissance" class="form-label">Date de Naissance</label>
                        <input id="etudiant_date_naissance" name="date_naissance" type="date" class="form-control @error('date_naissance') is-invalid @enderror" value="{{ old('date_naissance', $etudiant->date_naissance) }}">
                        @error('date_naissance') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label for="etudiant_formation" class="form-label">Formation Actuelle</label>
                        <input id="etudiant_formation" name="formation" type="text" class="form-control @error('formation') is-invalid @enderror" value="{{ old('formation', $etudiant->formation) }}">
                        @error('formation') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="etudiant_niveau" class="form-label">Niveau d'Études</label>
                        <input id="etudiant_niveau" name="niveau" type="text" class="form-control @error('niveau') is-invalid @enderror" value="{{ old('niveau', $etudiant->niveau) }}" placeholder="Ex: Licence 3, Master 1...">
                        @error('niveau') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="flex items-center gap-4 mt-4">
                    {{-- CORRECTION: Suppression de la classe 'save-btn' --}}
                    <button type="submit" class="action-button">Enregistrer Infos Étudiant</button>
                    @if (session('status') === 'student-info-updated')
                        <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2500)" class="text-sm text-success font-medium">Enregistré.</p>
                    @endif
                </div>
            </form>
        </div>

        {{-- 3. Section: Photo de Profil --}}
        <div class="form-section profile-photo-section">
            <header>
                <h2 class="section-title">Photo de Profil</h2>
                <p class="section-description">Ajoutez ou modifiez votre photo.</p>
            </header>
            <form method="post" action="{{ route('etudiants.profile.updatePhoto') }}" enctype="multipart/form-data" class="mt-4 space-y-6">
                @csrf
                <div class="row">
                    <div class="col-md-7 form-group upload-area" x-data="{ photoPreview: null }">
                        <label for="photo" class="form-label">Choisir une nouvelle photo (Max 2Mo)</label>
                        <input id="photo" name="photo" type="file" class="form-control @error('photo') is-invalid @enderror"
                               accept="image/png, image/jpeg, image/jpg, image/gif"
                               @change="const reader = new FileReader(); reader.onload = (e) => { photoPreview = e.target.result; }; reader.readAsDataURL($event.target.files[0]);">
                        @error('photo') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
                        {{-- Preview --}}
                        <div class="mt-3 photo-preview-container">
                            <span class="form-label d-block mb-2">Aperçu :</span>
                            <template x-if="photoPreview"><img :src="photoPreview" alt="Aperçu nouvelle photo"></template>
                            <template x-if="!photoPreview">
                                @if ($etudiant->photo_path) <img src="{{ Storage::url($etudiant->photo_path) }}" alt="Photo actuelle">
                                @else <div class="placeholder"><i class="fas fa-user"></i></div>
                                @endif
                            </template>
                        </div>
                    </div>
                    <div class="col-md-5 d-flex align-items-end">
                        <div class="flex items-center gap-4 w-100">
                            {{-- CORRECTION: Suppression de la classe 'save-btn' --}}
                            <button type="submit" class="action-button">Mettre à jour Photo</button>
                            @if (session('status') === 'profile-photo-updated')
                                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2500)" class="text-sm text-success font-medium">Photo MAJ.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </form>
        </div>

        {{-- 4. Section: Mise à jour du Mot de Passe --}}
        <div class="form-section">
            <header>
                <h2 class="section-title">{{ __('Update Password') }}</h2>
                <p class="section-description">{{ __('Ensure your account is using a long, random password to stay secure.') }}</p>
            </header>
            <form method="post" action="{{ route('password.update') }}" class="mt-4 space-y-6">
                @csrf @method('put')
                <div class="form-group">
                    <label for="update_password_current_password" class="form-label">{{ __('Current Password') }}</label>
                    <input id="update_password_current_password" name="current_password" type="password" class="form-control @error('current_password', 'updatePassword') is-invalid @enderror" autocomplete="current-password" />
                    @error('current_password', 'updatePassword') <span class="invalid-feedback">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label for="update_password_password" class="form-label">{{ __('New Password') }}</label>
                    <input id="update_password_password" name="password" type="password" class="form-control @error('password', 'updatePassword') is-invalid @enderror" autocomplete="new-password" />
                    @error('password', 'updatePassword') <span class="invalid-feedback">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label for="update_password_password_confirmation" class="form-label">{{ __('Confirm Password') }}</label>
                    <input id="update_password_password_confirmation" name="password_confirmation" type="password" class="form-control @error('password_confirmation', 'updatePassword') is-invalid @enderror" autocomplete="new-password" />
                    @error('password_confirmation', 'updatePassword') <span class="invalid-feedback">{{ $message }}</span> @enderror
                </div>
                <div class="flex items-center gap-4 mt-4">
                    {{-- CORRECTION: Suppression de la classe 'save-btn' --}}
                    <button type="submit" class="action-button">Enregistrer Nouveau Mot de Passe</button>
                    @if (session('status') === 'password-updated')
                         <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2500)" class="text-sm text-success font-medium">Mot de passe MAJ.</p>
                    @endif
                </div>
            </form>
        </div>

        {{-- 5. Optionnel: Section Suppression Compte --}}
        {{-- ... --}}

    </div>
@endsection

@push('scripts')
@endpush