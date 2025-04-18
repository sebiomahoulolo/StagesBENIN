@extends('layouts.layout')

{{-- Définit le titre spécifique de la page --}}
@section('title', 'Connexion - StagesBENIN')

{{-- Injecte les styles spécifiques pour cette page --}}
@section('styles')
    {{-- Réutilise le CSS de l'inscription pour l'instant --}}
    <link rel="stylesheet" href="{{ asset('css/register-etudiant.css') }}">
@endsection

{{-- Contenu principal de la page --}}
@section('content')
<main id="content" class="site-main">
    {{-- Section contenant le formulaire --}}
    <section class="candidate-signup-section"> {{-- Utilise la même classe de section --}}
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6 col-md-8 col-sm-10"> {{-- Colonne légèrement plus petite pour le login --}}
                    <div class="signup-form-container"> {{-- Conteneur du formulaire --}}

                        <h2 class="signup-form-title">Connexion</h2>
                        <p class="signup-form-subtitle">Accédez à votre compte StagesBENIN.</p>

                        <!-- Session Status -->
                        <x-auth-session-status class="mb-4 alert alert-success text-center small" :status="session('status')" />

                        {{-- Affichage des erreurs de validation générales --}}
                        @if ($errors->any())
                            <div class="alert alert-danger mb-3 text-center small">
                                <ul class="mb-0 list-unstyled">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        {{-- Formulaire de connexion --}}
                        <form class="signup-form" method="POST" action="{{ route('login') }}">
                            @csrf

                            <!-- Email Address -->
                            <div class="mb-3">
                                <label for="email" class="form-label">{{ __('Email') }}</label>
                                <input type="email"
                                       id="email"
                                       name="email"
                                       class="form-control @error('email', 'login') is-invalid @enderror" {{-- Spécifier le bag d'erreur 'login' si nécessaire --}}
                                       value="{{ old('email') }}"
                                       required
                                       autofocus
                                       autocomplete="username">
                                @error('email', 'login')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Password -->
                            <div class="mb-3">
                                <label for="password" class="form-label">{{ __('Mot de passe') }}</label>
                                <input type="password"
                                       id="password"
                                       name="password"
                                       class="form-control @error('password', 'login') is-invalid @enderror"
                                       required
                                       autocomplete="current-password">
                                @error('password', 'login')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Remember Me -->
                            <div class="mb-3 form-check">
                                <input id="remember_me" type="checkbox" class="form-check-input" name="remember">
                                <label class="form-check-label" for="remember_me">{{ __('Se souvenir de moi') }}</label>
                            </div>

                            {{-- Bouton de soumission et lien mot de passe oublié --}}
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                @if (Route::has('password.request'))
                                    <a class="small text-decoration-none password-forgot-link" href="{{ route('password.request') }}">
                                        {{ __('Mot de passe oublié?') }}
                                    </a>
                                @endif
                                <button type="submit" class="btn btn-submit ms-auto"> {{-- ms-auto pour aligner à droite si pas de lien mdp oublié --}}
                                    {{ __('Se connecter') }}
                                </button>
                            </div>

                             {{-- Liens en bas --}}
                            <div class="bottom-links-wrapper">
                                <div class="switch-register-link text-center"> {{-- Texte centré pour un seul lien --}}
                                    <a href="{{ route('register') }}"> {{-- Assurez-vous que 'register' est la route correcte pour la page de choix d'inscription --}}
                                        {{ __('Pas encore de compte ? S\'inscrire') }}
                                    </a>
                                </div>
                                {{-- Si vous avez des pages d'inscription séparées comme avant :
                                <div class="switch-register-link">
                                    <a href="{{ route('register.etudiant.create') }}">{{ __('S\'inscrire comme Étudiant ?') }}</a>
                                </div>
                                <div class="switch-register-link mt-2">
                                    <a href="{{ route('register.recruteur.create') }}">{{ __('S\'inscrire comme Recruteur ?') }}</a>
                                </div>
                                --}}
                            </div>

                        </form>
                    </div> {{-- Fin .signup-form-container --}}
                </div> {{-- Fin .col --}}
            </div> {{-- Fin .row --}}
        </div> {{-- Fin .container --}}
    </section>
</main>
@endsection

{{-- Pas de scripts spécifiques nécessaires pour le login simple, mais on garde la section vide --}}
@section('scripts')
@endsection
