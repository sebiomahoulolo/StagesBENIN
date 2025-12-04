@extends('layouts.layout')

@section('title', 'Inscription Étudiant - StagesBENIN')

@section('styles')
<br><br><br>
    <link rel="stylesheet" href="{{ asset('css/register-etudiant.css') }}">
    <style>
        :root {
            --bleu-azur: #0077b6;
            --bleu-azur-light: #48cae4;
            --bleu-azur-dark: #023e8a;
            --bleu-azur-very-light: #caf0f8;
        }
        
        .progress-bar {
            background-color: var(--bleu-azur);
        }
        
        /* Styles améliorés pour les options de formule */
        .formule-option {
            border: 2px solid #ddd;
            border-radius: 15px;
            padding: 25px;
            margin-bottom: 25px;
            cursor: pointer;
            transition: all 0.3s;
            position: relative;
            height: 100%;
            min-height: 450px; /* Hauteur minimale augmentée */
            display: flex;
            flex-direction: column;
        }
        
        .formule-option:hover {
            border-color: var(--bleu-azur-light);
            background-color: var(--bleu-azur-very-light);
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }
        
        .formule-option.selected {
            border-color: var(--bleu-azur);
            background-color: var(--bleu-azur-very-light);
            box-shadow: 0 0 0 3px rgba(0, 119, 182, 0.2),
                        0 10px 20px rgba(0, 119, 182, 0.1);
        }
        
        .formule-title {
            font-size: 1.8rem; /* Taille de police augmentée */
            font-weight: 700;
            color: var(--bleu-azur);
            margin-bottom: 20px;
            text-align: center;
        }
        
        .formule-price {
            font-size: 2rem; /* Taille de police augmentée */
            font-weight: 800;
            margin-bottom: 25px;
            text-align: center;
            color: var(--bleu-azur-dark);
        }
        
        .formule-badge {
            position: absolute;
            top: 15px;
            right: 15px;
            background-color: var(--bleu-azur);
            color: white;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.9rem;
            font-weight: 600;
        }
        
        .avantage-list {
            list-style-type: none;
            padding-left: 0;
            margin-bottom: 20px;
            flex-grow: 1;
        }
        
        .avantage-list li {
            margin-bottom: 12px; /* Espacement augmenté */
            padding-left: 30px;
            position: relative;
            font-size: 1.05rem; /* Taille de police augmentée */
            line-height: 1.5;
        }
        
        .avantage-list li:before {
            content: "✓";
            color: #28a745;
            font-weight: bold;
            position: absolute;
            left: 5px;
            font-size: 1.2rem;
        }
        
        .limitation-list {
            list-style-type: none;
            padding-left: 0;
            margin-top: 20px;
            color: #6c757d;
            flex-grow: 1;
        }
        
        .limitation-list li {
            margin-bottom: 12px; /* Espacement augmenté */
            padding-left: 30px;
            position: relative;
            font-size: 1.05rem; /* Taille de police augmentée */
            line-height: 1.5;
        }
        
        .limitation-list li:before {
            content: "✗";
            color: #dc3545;
            font-weight: bold;
            position: absolute;
            left: 5px;
            font-size: 1.2rem;
        }
        
        .step {
            display: none;
        }
        
        .step.active {
            display: block;
            animation: fadeIn 0.5s;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        
        /* Améliorations pour la section des formules */
        .formule-section {
            padding: 20px 0;
        }
        
        .formule-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
        }
        
        .formule-col {
            flex: 1;
            min-width: 300px;
            max-width: 500px;
        }
        
        @media (max-width: 768px) {
            .formule-option {
                padding: 20px;
                min-height: auto;
            }
        
            .formule-title {
                font-size: 1.5rem;
            }
            
            .formule-price {
                font-size: 1.8rem;
            }
            
            .avantage-list li,
            .limitation-list li {
                font-size: 1rem;
            }
        }
    </style>
@endsection

@section('content')
    <main id="content" class="site-main">
        <section class="candidate-signup-section">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-10 col-md-12 col-sm-12">
                        <div class="signup-form-container">
                            <h2 class="signup-form-title">Inscription Étudiant</h2>
                            <p class="signup-form-subtitle">Créez votre compte en 4 étapes simples</p>

                            <div class="progress mb-4">
                                <div class="progress-bar" role="progressbar" style="width: 25%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">Étape 1 sur 4</div>
                            </div>

                            <form class="signup-form" method="POST" action="{{ route('register.etudiant.store') }}" id="registrationForm">
                                @csrf
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul class="mb-0">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <!-- Étape 1: Informations personnelles -->
                                <div class="step active" id="step1">
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

                                    <!-- Téléphone -->
                                    <div class="mb-3">
                                        <label for="telephone" class="form-label">{{ __('Téléphone') }}</label>
                                        <input 
                                            type="tel" 
                                            id="telephone" 
                                            name="telephone"
                                            class="form-control @error('telephone') is-invalid @enderror"
                                            value="{{ old('telephone') }}" 
                                            required 
                                            autocomplete="tel"
                                            placeholder="+22901XXXXXXXX"
                                            pattern="^\+22901[0-9]{8}$"
                                            title="Le numéro doit commencer par +22901 suivi de 8 chiffres">
                                        @error('telephone')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="d-flex justify-content-between mt-4">
                                        <button type="button" class="btn btn-outline-primary" disabled>Précédent</button>
                                        <button type="button" class="btn btn-primary" onclick="nextStep(1)">Suivant</button>
                                    </div>
                                </div>

                                <!-- Étape 2: Formation -->
                                <div class="step" id="step2">
                                    <!-- Niveau d'étude -->
                                    <div class="mb-3">
                                        <label for="niveau" class="form-label">{{ __('Niveau d\'étude') }}</label>
                                        <select id="niveau" name="niveau"
                                            class="form-select @error('niveau') is-invalid @enderror" required>
                                            <option value="">Sélectionner un niveau</option>
                                            <option value="BEPC" {{ old('niveau') == 'BEPC' ? 'selected' : '' }}>BEPC</option>
                                            <option value="Bac" {{ old('niveau') == 'Bac' ? 'selected' : '' }}>Bac</option>
                                            <option value="Bac+1" {{ old('niveau') == 'Bac+1' ? 'selected' : '' }}>Bac+1</option>
                                            <option value="Bac+2" {{ old('niveau') == 'Bac+2' ? 'selected' : '' }}>Bac+2</option>
                                            <option value="Bac+3" {{ old('niveau') == 'Bac+3' ? 'selected' : '' }}>Bac+3</option>
                                            <option value="Bac+4" {{ old('niveau') == 'Bac+4' ? 'selected' : '' }}>Bac+4</option>
                                            <option value="Bac+5" {{ old('niveau') == 'Bac+5' ? 'selected' : '' }}>Bac+5</option>
                                            <option value="Doctorat" {{ old('niveau') == 'Doctorat' ? 'selected' : '' }}>Doctorat</option>
                                        </select>
                                        @error('niveau')
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

                                    <div class="d-flex justify-content-between mt-4">
                                        <button type="button" class="btn btn-outline-primary" onclick="prevStep(2)">Précédent</button>
                                        <button type="button" class="btn btn-primary" onclick="nextStep(2)">Suivant</button>
                                    </div>
                                </div>

                                <!-- Étape 3: Compte -->
                                <div class="step" id="step3">
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
                                    </div>

                                    <div class="d-flex justify-content-between mt-4">
                                        <button type="button" class="btn btn-outline-primary" onclick="prevStep(3)">Précédent</button>
                                        <button type="button" class="btn btn-primary" onclick="nextStep(3)">Suivant</button>
                                    </div>
                                </div>

                                <!-- Étape 4: Formules - Version améliorée -->
                                <div class="step" id="step4">
                                    <h3 class="mb-4 text-center">Choisissez votre formule</h3>
                                    <p class="text-center mb-4">Sélectionnez l'option qui correspond le mieux à vos besoins</p>
                                    
                                    <div class="formule-section">
                                        <div class="formule-container">
                                            <!-- Formule Simple -->
                                            <div class="formule-col">
                                                <div class="formule-option" onclick="selectFormule('simple')" id="simpleOption">
                                                    <div class="formule-title">Formule Simple</div>
                                                    <div class="formule-price">500 FCFA/mois</div>
                                                    <ul class="avantage-list">
                                                        <li>Accès complet à la plateforme</li>
                                                        <li>Consultation des offres</li>
                                                        <li>Possibilité de postuler aux offres</li>
                                                        <li>Évaluation automatique des compétences</li>
                                                        <li>Conseils basiques par email</li>
                                                    </ul>
                                                    <ul class="limitation-list">
                                                        <li>Coaching personnalisé non inclus</li>
                                                        <li>Générateur de CV désactivé</li>
                                                        <li>Profil invisible aux entreprises partenaires</li>
                                                        <li>Pas de priorité sur les offres premium</li>
                                                    </ul>
                                                </div>
                                            </div>
                                            
                                            <!-- Formule Premium -->
                                            <div class="formule-col">
                                                <div class="formule-option" onclick="selectFormule('premium')" id="premiumOption">
                                                    <div class="formule-badge">Recommandé</div>
                                                    <div class="formule-title">Formule Premium</div>
                                                    <div class="formule-price">5.000 FCFA/an</div>
                                                    <ul class="avantage-list">
                                                        <li>Accès complet à la plateforme</li>
                                                        <li>Consultation des offres</li>
                                                        <li>Possibilité de postuler aux offres</li>
                                                        <li>Évaluation automatique des compétences</li>
                                                        <li>Conseils basiques par email</li>
                                                        <li>Coaching personnalisé</li>
                                                        <li>Générateur de CV professionnel</li>
                                                        <li>Profil visible et promu auprès des partenaires</li>
                                                        <li>Accès prioritaire aux offres premium</li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <input type="hidden" id="formule" name="formule" value="">
                                    <div id="formuleError" class="alert alert-danger d-none mb-4">Veuillez choisir une formule avant de finaliser votre inscription.</div>

                                    <!-- Checkbox conditions générales -->
                                    <div class="form-check mb-4">
                                        <input class="form-check-input" type="checkbox" value="1" id="cguCheck" required>
                                        <label class="form-check-label" for="cguCheck">
                                            J'accepte les <a href="#termsModal" data-bs-toggle="modal" style="text-decoration: underline; cursor: pointer;">conditions générales</a>
                                        </label>
                                    </div>

                                    <div class="d-flex justify-content-between mt-4">
                                        <button type="button" class="btn btn-outline-primary" onclick="prevStep(4)">Précédent</button>
                                        <button type="submit" class="btn btn-submit" id="finalizeBtn" disabled>Finaliser mon inscription</button>
                                    </div>
                                </div>
                            </form>

                            <div class="bottom-links-wrapper mt-4">
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
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- Modal Conditions Générales -->
    <div class="modal fade" id="termsModal" tabindex="-1" aria-labelledby="termsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="termsModalLabel">Conditions Générales</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h6>1. Engagement du programme</h6>
                    <p>Le programme d'insertion professionnelle s'engage à fournir un accompagnement personnalisé pour faciliter l'accès à l'emploi des diplômés.</p>
                    
                    <h6>2. Formules d'abonnement</h6>
                    <p>La formule Simple est facturée mensuellement et peut être résiliée à tout moment. La formule Premium est un abonnement annuel avec engagement.</p>
                    
                    <h6>3. Confidentialité</h6>
                    <p>Vos données personnelles seront utilisées uniquement dans le cadre du programme et ne seront pas partagées avec des tiers sans votre consentement.</p>
                    
                    <h6>4. Remboursement</h6>
                    <p>Pour la formule Premium, un remboursement pro-rata est possible dans les 14 jours suivant l'adhésion. La formule Simple n'est pas remboursable.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">J'ai compris</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        let currentStep = 1;
        let selectedFormule = '';
        
        function updateProgressBar() {
            const progressPercentage = (currentStep / 4) * 100;
            const progressBar = document.querySelector('.progress-bar');
            progressBar.style.width = `${progressPercentage}%`;
            progressBar.setAttribute('aria-valuenow', progressPercentage);
            progressBar.textContent = `Étape ${currentStep} sur 4`;
        }
        
        function showStep(stepNumber) {
            document.querySelectorAll('.step').forEach(step => {
                step.classList.remove('active');
            });
            document.getElementById(`step${stepNumber}`).classList.add('active');
            updateProgressBar();
        }
        
        function nextStep(current) {
            if (validateStep(current)) {
                currentStep = current + 1;
                showStep(currentStep);
            }
        }
        
        function prevStep(current) {
            currentStep = current - 1;
            showStep(currentStep);
        }
        
        function validateStep(step) {
            let isValid = true;
            
            if (step === 1) {
                const prenom = document.getElementById('prenom').value;
                const nom = document.getElementById('nom').value;
                const telephone = document.getElementById('telephone').value;
                const phoneRegex = /^\+22901[0-9]{8}$/;
                if (!prenom || !nom || !telephone) {
                    alert('Veuillez remplir tous les champs obligatoires');
                    isValid = false;
                } else if (!phoneRegex.test(telephone)) {
                    alert('Le numéro de téléphone doit être au format béninois : +22901XXXXXXXX');
                    isValid = false;
                }
            } else if (step === 2) {
                const niveau = document.getElementById('niveau').value;
                const secteur = document.getElementById('secteur').value;
                const formation = document.getElementById('formation').value;
                
                if (!niveau || !secteur || !formation) {
                    alert('Veuillez remplir tous les champs obligatoires');
                    isValid = false;
                }
            } else if (step === 3) {
                const email = document.getElementById('email').value;
                const password = document.getElementById('password').value;
                const confirmPassword = document.getElementById('password_confirmation').value;
                
                if (!email || !password || !confirmPassword) {
                    alert('Veuillez remplir tous les champs obligatoires');
                    isValid = false;
                } else if (password !== confirmPassword) {
                    alert('Les mots de passe ne correspondent pas');
                    isValid = false;
                } else if (password.length < 8) {
                    alert('Le mot de passe doit contenir au moins 8 caractères');
                    isValid = false;
                }
            }
            
            return isValid;
        }
        
        function selectFormule(formule) {
            selectedFormule = formule;
            document.getElementById('formule').value = formule;
            
            // Mise à jour de l'affichage visuel
            document.querySelectorAll('.formule-option').forEach(el => {
                el.classList.remove('selected');
            });
            
            if (formule === 'simple') {
                document.getElementById('simpleOption').classList.add('selected');
            } else {
                document.getElementById('premiumOption').classList.add('selected');
            }
            
            // Activer le bouton de finalisation
            document.getElementById('finalizeBtn').disabled = false;
            // Cacher l'erreur
            document.getElementById('formuleError').classList.add('d-none');
        }
        
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

            // S'assurer que la formule est sélectionnée avant de soumettre le formulaire
            $('#registrationForm').on('submit', function(e) {
                if (!$('#formule').val()) {
                    $('#formuleError').removeClass('d-none');
                    $('#finalizeBtn').prop('disabled', true);
                    e.preventDefault();
                    // Faire défiler jusqu'à l'erreur
                    $('html, body').animate({
                        scrollTop: $('#formuleError').offset().top - 100
                    }, 500);
                }
                
                if (!$('#cguCheck').prop('checked')) {
                    alert('Veuillez accepter les conditions générales');
                    e.preventDefault();
                }
            });

            // Activer/désactiver le bouton de finalisation selon la case CGU
            $('#cguCheck').on('change', function() {
                $('#finalizeBtn').prop('disabled', !this.checked || !$('#formule').val());
            });
        });
    </script>
@endsection