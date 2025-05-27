@extends('layouts.layout')

{{-- Définit le titre spécifique de la page --}}
@section('title', 'Inscription Étudiant - StagesBENIN')

{{-- Injecte les styles spécifiques pour cette page --}}
@section('styles')
    <link rel="stylesheet" href="{{ asset('css/register-etudiant.css') }}">
    {{-- Ajoutez Font Awesome si non inclus globalement dans layout.blade.php --}}
    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"> --}}
@endsection

{{-- Contenu principal de la page --}}
@section('content')
    <main id="content" class="site-main">
        {{-- Section contenant le formulaire --}}
        <section class="candidate-signup-section">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-7 col-md-9 col-sm-11"> {{-- Colonne pour le formulaire --}}
                        <div class="signup-form-container">

                            <h2 class="signup-form-title">Inscription Étudiant</h2>
                            <p class="signup-form-subtitle">Créez votre compte pour trouver votre stage.</p>

                            {{-- Formulaire utilisant les classes Bootstrap et les directives Blade --}}
                            <form class="signup-form" method="POST" action="{{ route('register.etudiant.store') }}">
                                @csrf

                                {{-- Affichage des erreurs générales (session flash) --}}
                                @if (session('error'))
                                    <div class="alert alert-danger mb-3 text-center small">{{ session('error') }}</div>
                                @endif

                                {{-- Affichage global des erreurs de validation (optionnel si vous les affichez par champ) --}}
                                {{-- @if ($errors->any())
                                <div class="alert alert-danger mb-4">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif --}}

                                <!-- Prénom -->
                                <div class="mb-3">
                                    <label for="prenom" class="form-label">{{ __('Prénom') }}</label>
                                    <input type="text" id="prenom" name="prenom"
                                        class="form-control @error('prenom') is-invalid @enderror"
                                        value="{{ old('prenom') }}" required autofocus autocomplete="given-name">
                                    @error('prenom')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Nom -->
                                <div class="mb-3">
                                    <label for="nom" class="form-label">{{ __('Nom') }}</label>
                                    <input type="text" id="nom" name="nom"
                                        class="form-control @error('nom') is-invalid @enderror" value="{{ old('nom') }}"
                                        required autocomplete="family-name">
                                    @error('nom')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Email Address -->
                                <div class="mb-3">
                                    <label for="email" class="form-label">{{ __('Email') }}</label>
                                    <input type="email" id="email" name="email"
                                        class="form-control @error('email') is-invalid @enderror"
                                        value="{{ old('email') }}" required autocomplete="username">
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Téléphone -->
                                <div class="mb-3">
                                    <label for="telephone" class="form-label">{{ __('Téléphone') }}</label>
                                    <input type="tel" id="telephone" name="telephone"
                                        class="form-control @error('telephone') is-invalid @enderror"
                                        value="{{ old('telephone') }}" required autocomplete="tel">
                                    @error('telephone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Secteur -->
                                <div class="mb-3">
                                    <label for="secteur" class="form-label">{{ __('Secteur') }}</label>
                                    <select class="form-select @error('secteur_id') is-invalid @enderror" id="secteur"
                                        name="secteur_id" required>
                                        <option value="">Sélectionner un secteur</option>
                                        @foreach ($secteurs as $secteur)
                                            <option value="{{ $secteur->id }}"
                                                {{ old('secteur_id') == $secteur->id ? 'selected' : '' }}>
                                                {{ $secteur->nom }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('secteur_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Formation -->
                                <div class="mb-3">
                                    <label for="formation" class="form-label">{{ __('Formation') }}</label>
                                    <select class="form-select @error('specialite_id') is-invalid @enderror" id="formation"
                                        name="specialite_id" required>
                                        <option value="">Sélectionner une spécialité</option>
                                    </select>
                                    @error('specialite_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Niveau d'étude -->
                                <div class="mb-3">
                                    <label for="niveau" class="form-label">{{ __('Niveau d\'étude') }}</label>
                                    <select id="niveau" name="niveau"
                                        class="form-select @error('niveau') is-invalid @enderror" required>
                                        <option value="">Sélectionner un niveau</option>
                                        <option value="BEPC">BEPC</option>
                                        <option value="Bac">Bac</option>
                                        <option value="Bac+1">Bac+1</option>
                                        <option value="Bac+2">Bac+2</option>
                                        <option value="Bac+3">Bac+3</option>
                                        <option value="Bac+4">Bac+4</option>
                                        <option value="Bac+5">Bac+5</option>
                                        <option value="Doctorat">Doctorat</option>
                                    </select>
                                    @error('niveau')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Password -->
                                <div class="mb-3 password-wrapper">
                                    <label for="password" class="form-label">{{ __('Mot de passe') }}</label>
                                    <input type="password" id="password" name="password"
                                        class="form-control @error('password') is-invalid @enderror" required
                                        autocomplete="new-password">
                                    <span class="toggle-password" id="togglePassword"><i class="fas fa-eye"></i></span>
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Confirm Password -->
                                <div class="mb-3 password-wrapper">
                                    <label for="password_confirmation"
                                        class="form-label">{{ __('Confirmer le mot de passe') }}</label>
                                    <input type="password" id="password_confirmation" name="password_confirmation"
                                        class="form-control" required autocomplete="new-password">
                                    <span class="toggle-password" id="toggleConfirmPassword"><i
                                            class="fas fa-eye"></i></span>
                                    {{-- L'erreur 'confirmed' sera liée au champ 'password' principal par défaut --}}
                                </div>

                                <!-- type_emploi d'étude -->
                                <div class="mb-3">
                                    <label for="type_emploi" class="form-label">{{ __('Type Emploi') }}</label>
                                    <select id="type_emploi" name="type_emploi"
                                        class="form-select @error('type_emploi') is-invalid @enderror" required>
                                        <option value="">Sélectionner un type emploi</option>
                                        <option value="Stage">Stage</option>
                                        <option value="Emploi">Emploi</option>
                                    </select>
                                    @error('type_emploi')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Bouton de soumission --}}
                                <button type="submit" class="btn btn-submit">
                                    {{ __('S\'inscrire comme Étudiant') }}
                                </button>

                                {{-- Liens en bas --}}
                                <div class="bottom-links-wrapper">
                                    <div class="login-link">
                                        <a href="{{ route('login') }}">
                                            {{ __('Déjà inscrit?') }}
                                        </a>
                                    </div>

                                    <div class="switch-register-link">
                                        <a href="{{ route('register.recruteur.create') }}">
                                            {{ __('S\'inscrire comme Recruteur ?') }}
                                        </a>
                                    </div>
                                </div>

                            </form>
                        </div> {{-- Fin .signup-form-container --}}
                    </div> {{-- Fin .col --}}
                </div> {{-- Fin .row --}}
            </div> {{-- Fin .container --}}
        </section>
    </main>
@endsection

{{-- Injecte les scripts spécifiques --}}
@section('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // Fonction générique pour basculer la visibilité d'un champ mot de passe
        function setupPasswordToggle(toggleId, inputId) {
            const toggleElement = document.getElementById(toggleId);
            const inputElement = document.getElementById(inputId);

            if (toggleElement && inputElement) {
                const icon = toggleElement.querySelector('i');

                // Initialise l'icône
                if (inputElement.getAttribute('type') === 'password') {
                    icon.classList.add('fa-eye');
                    icon.classList.remove('fa-eye-slash');
                } else {
                    icon.classList.add('fa-eye-slash');
                    icon.classList.remove('fa-eye');
                }

                toggleElement.addEventListener('click', function() {
                    const type = inputElement.getAttribute('type') === 'password' ? 'text' : 'password';
                    inputElement.setAttribute('type', type);
                    // Bascule les classes de l'icône Font Awesome
                    icon.classList.toggle('fa-eye');
                    icon.classList.toggle('fa-eye-slash');
                });
            }
        }

        // Appliquer la fonction aux champs mot de passe sur chargement du DOM
        document.addEventListener('DOMContentLoaded', function() {
            setupPasswordToggle('togglePassword', 'password');
            setupPasswordToggle('toggleConfirmPassword', 'password_confirmation');
        });

        $(document).ready(function() {
            // Gestion du chargement dynamique des spécialités
            $('#secteur').on('change', function() {
                const secteurId = $(this).val();
                const $formationSelect = $('#formation');

                // Réinitialiser le select des formations
                $formationSelect.html('<option value="">Sélectionner une spécialité</option>');

                if (!secteurId) return;

                // Afficher un indicateur de chargement
                $formationSelect.prop('disabled', true);
                $formationSelect.html('<option value="">Chargement...</option>');

                // Faire la requête AJAX
                $.ajax({
                    url: "{{ route('get.specialites') }}",
                    method: 'GET',
                    data: {
                        secteur_id: secteurId
                    },
                    success: function(specialites) {
                        // Réinitialiser le select
                        $formationSelect.html(
                            '<option value="">Sélectionner une spécialité</option>');

                        // Ajouter les options
                        specialites.forEach(function(specialite) {
                            $formationSelect.append(
                                $('<option></option>')
                                .val(specialite.id)
                                .text(specialite.nom)
                            );
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error('Erreur lors du chargement des spécialités:', error);
                        $formationSelect.html('<option value="">Erreur de chargement</option>');
                    },
                    complete: function() {
                        $formationSelect.prop('disabled', false);
                    }
                });
            });

            // Si un secteur est déjà sélectionné au chargement de la page
            if ($('#secteur').val()) {
                $('#secteur').trigger('change');
            }
        });
    </script>
@endsection
