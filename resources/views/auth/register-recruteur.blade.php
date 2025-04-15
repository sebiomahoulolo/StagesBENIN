{{-- Utilise le layout principal de l'application --}}
@extends('layouts.layout')

{{-- Définit le titre spécifique de la page --}}
@section('title', 'Inscription Recruteur - StagesBENIN')

{{-- Injecte les styles spécifiques pour cette page --}}
@section('styles')
    <link rel="stylesheet" href="{{ asset('css/register-recruteur.css') }}">
@endsection

{{-- Contenu principal de la page --}}
@section('content')
    <div class="recruiter-signup-wrapper">
        <div class="container">
            <div class="row align-items-center justify-content-center center-form-md">

                <!-- Colonne Formulaire -->
                <div class="col-lg-6 col-md-8 col-sm-11">
                    <div class="signup-form-container">

                        <h2 class="signup-form-title">Inscription Recruteur</h2>
                        <p class="signup-form-subtitle">Créez votre compte entreprise.</p>

                        {{-- Formulaire HTML Classique --}}
                        <form class="signup-form" method="POST" action="{{ route('register.recruteur.store') }}">
                            @csrf

                            {{-- Affichage des erreurs générales (session flash) --}}
                            @if (session('error'))
                                <div class="alert alert-danger mb-3 text-center">{{ session('error') }}</div>
                            @endif

                            {{-- Affichage global des erreurs de validation --}}
                            @if ($errors->any())
                                <div class="alert alert-danger mb-4">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <!-- Email Address (Login) -->
                            <div class="mb-3">
                                <label for="email" class="form-label">{{ __('Votre Email de Connexion') }}</label>
                                <input type="email"
                                       id="email"
                                       name="email"
                                       class="form-control @error('email') is-invalid @enderror"
                                       value="{{ old('email') }}"
                                       required
                                       autocomplete="username">
                                @error('email')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Password -->
                            <div class="mb-3 password-wrapper">
                                <label for="signup-password" class="form-label">{{ __('Mot de passe') }}</label>
                                <input type="password"
                                       id="signup-password"
                                       name="password"
                                       class="form-control @error('password') is-invalid @enderror"
                                       required
                                       autocomplete="new-password">
                                <i class="fas fa-eye toggle-password" id="togglePassword"></i>
                                @error('password')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Confirm Password -->
                            <div class="mb-3 password-wrapper">
                                <label for="signup-password-confirm" class="form-label">{{ __('Confirmer le mot de passe') }}</label>
                                <input type="password"
                                       id="signup-password-confirm"
                                       name="password_confirmation"
                                       class="form-control"
                                       required
                                       autocomplete="new-password">
                                {{-- Erreur 'confirmed' gérée automatiquement --}}
                            </div>

                            {{-- Suppression du champ Nom Entreprise effectuée --}}

                            {{-- Wrapper pour aligner le lien et le bouton --}}
                            <div class="login-link-wrapper">
                                <div class="login-link">
                                    <a href="{{ route('login') }}">
                                        {{ __('Déjà inscrit?') }}
                                    </a>
                                </div>
                                {{-- Bouton HTML classique --}}
                                <button type="submit" class="btn btn-submit">
                                    {{ __('S\'inscrire comme Recruteur') }}
                                </button>
                            </div>

                            {{-- Lien optionnel pour s'inscrire comme étudiant --}}
                            <div class="text-center mt-4">
                                <a class="text-sm" style="color: var(--custom-primary); text-decoration: underline;" href="{{ route('register.etudiant.create') }}">
                                    {{ __('S\'inscrire comme Étudiant ?') }}
                                </a>
                            </div>
                        </form>

                    </div> {{-- Fin .signup-form-container --}}
                </div> {{-- Fin .col (formulaire) --}}

                <!-- Colonne Image -->
                <div class="col-lg-6 d-none d-lg-block text-center ps-lg-5">
                    <img src="{{ asset('assets/images/bonne-verification-documents-par-experts.png') }}" alt="Inscription Recruteur Illustration" class="signup-illustration-img">
                </div>

            </div> {{-- Fin .row --}}
        </div> {{-- Fin .container --}}
    </div> {{-- Fin .recruiter-signup-wrapper --}}
@endsection {{-- <<< Fin de la section 'content' --}}

{{-- Injecte les scripts spécifiques --}}
@section('scripts')
    <script>
        // Script pour voir/cacher le mot de passe
        const togglePassword = document.querySelector('#togglePassword');
        const passwordInput = document.querySelector('#signup-password'); // Cible l'input par ID

        if (togglePassword && passwordInput) {
            // Initialise l'icône
             if (passwordInput.getAttribute('type') === 'password') {
                 togglePassword.classList.remove('fa-eye-slash');
                 togglePassword.classList.add('fa-eye');
            } else {
                 togglePassword.classList.remove('fa-eye');
                 togglePassword.classList.add('fa-eye-slash');
            }
            // Ajoute l'écouteur d'événement
             togglePassword.addEventListener('click', function () {
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
                this.classList.toggle('fa-eye');
                this.classList.toggle('fa-eye-slash');
            });
        } // <<< Fin du IF pour le script JS
    </script>
@endsection {{-- <<< Fin de la section 'scripts' --}}