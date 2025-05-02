@extends('layouts.etudiant.app')

@section('title', 'StagesBENIN')

@push('styles')
<style>
    .candidature-form .form-label {
        font-weight: 600;
        color: #333;
        font-size: 1.1rem;
        margin-bottom: 1rem;
        display: block;
    }
    
    .candidature-card {
        border: none;
        border-radius: 12px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        overflow: hidden;
    }
    
    .candidature-card .card-header {
        background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%);
        padding: 1.2rem 1.5rem;
        border-bottom: none;
    }
    
    .form-control, .form-select {
        border-radius: 8px;
        padding: 0.75rem 1rem;
        border: 1px solid #ced4da;
        transition: all 0.3s ease;
    }
    
    .form-control:focus, .form-select:focus {
        box-shadow: 0 0 0 3px rgba(13, 110, 253, 0.15);
    }
    
    .submit-btn {
        padding: 0.75rem 2rem;
        font-weight: 500;
        border-radius: 8px;
        transition: all 0.3s ease;
    }
    
    .submit-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
    }
    
    .required-star {
        color: #dc3545;
        font-weight: bold;
    }
    
    .form-section {
        background-color: white;
        border-radius: 10px;
        padding: 2rem;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        margin-bottom: 1.5rem;
    }
    
    .cv-upload-zone {
        border: 2px dashed #ced4da;
        padding: 2rem;
        text-align: center;
        border-radius: 8px;
        transition: all 0.3s ease;
        background-color: #f8f9fa;
        position: relative;
        margin-bottom: 1.5rem;
    }
    
    .cv-upload-zone:hover {
        border-color: #0d6efd;
        background-color: rgba(13, 110, 253, 0.05);
    }
    
    .cv-upload-zone input[type="file"] {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        opacity: 0;
        cursor: pointer;
    }
    
    .cv-upload-text {
        color: #6c757d;
    }
    
    .cv-upload-icon {
        font-size: 2rem;
        color: #0d6efd;
        margin-bottom: 1rem;
    }
    
    .char-counter {
        text-align: right;
        color: #6c757d;
        margin-top: 1rem;
        font-size: 0.95rem;
    }
    
    .char-counter.invalid {
        color: #dc3545;
    }
    
    .char-counter.valid {
        color: #28a745;
    }
    
    .form-group {
        margin-bottom: 2.5rem;
    }
    
    /* Ajout de styles responsifs pour les appareils mobiles */
    @media (max-width: 767.98px) {
        .container {
            padding-left: 0.75rem;
            padding-right: 0.75rem;
        }
        
        .candidature-card .card-header {
            padding: 1rem;
        }
        
        .candidature-card .card-header h4 {
            font-size: 1.25rem;
        }
        
        .card-body {
            padding: 1.25rem !important;
        }
        
        .form-section {
            padding: 1.25rem;
        }
        
        .cv-upload-zone {
            padding: 1.5rem 1rem;
        }
        
        .cv-upload-icon {
            font-size: 1.5rem;
            margin-bottom: 0.75rem;
        }
        
        .cv-upload-zone h5 {
            font-size: 1rem;
            margin-bottom: 0.5rem;
        }
        
        .cv-upload-text {
            font-size: 0.9rem;
        }
        
        .form-label {
            font-size: 1rem;
            margin-bottom: 0.75rem;
        }
        
        .input-group {
            flex-direction: column;
        }
        
        .input-group > :not(:first-child) {
            margin-left: 0;
            margin-top: 0.5rem;
            border-top-left-radius: 8px;
            border-bottom-left-radius: 8px;
        }
        
        .input-group > :not(:last-child) {
            border-top-right-radius: 8px;
            border-bottom-right-radius: 8px;
        }
        
        .input-group .form-control {
            width: 100%;
        }
        
        .input-group .input-group-text {
            width: 100%;
            justify-content: center;
        }
        
        .submit-btn {
            width: 100%;
            padding: 0.75rem 1rem;
        }
        
        .d-flex.justify-content-between {
            flex-direction: column;
            gap: 1rem;
        }
        
        .d-flex.justify-content-between a {
            text-align: center;
        }
    }
    
    @media (max-width: 575.98px) {
        .py-5 {
            padding-top: 2rem !important;
            padding-bottom: 2rem !important;
        }
        
        .form-section {
            padding: 1rem;
        }
        
        .form-label {
            font-size: 0.95rem;
            margin-bottom: 0.5rem;
        }
        
        .char-counter {
            font-size: 0.85rem;
        }
    }
</style>
@endpush

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            
            <div class="card candidature-card mb-4">
                <div class="card-header">
                    <h4 class="mb-0 text-white">
                        Postuler à l'offre : {{ $annonce->nom_du_poste }}
                    </h4>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('etudiants.offres.postuler.submit', $annonce) }}" method="POST" enctype="multipart/form-data" class="candidature-form">
                        @csrf

                        <div class="form-section">
                            <!-- Prétention salariale -->
                            <div class="form-group">
                                <label for="pretention_salariale" class="form-label">
                                    Prétention salariale (FCFA) <span class="required-star">*</span>
                                </label>
                                <div class="input-group">
                                    <input type="number" class="form-control @error('pretention_salariale') is-invalid @enderror" 
                                        id="pretention_salariale" name="pretention_salariale" 
                                        value="{{ old('pretention_salariale') }}" min="0" required
                                        placeholder="Ex: 150000">
                                    <span class="input-group-text">FCFA</span>
                                </div>
                                @error('pretention_salariale')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- CV en PDF -->
                            <div class="form-group">
                                <label for="cv_file" class="form-label">
                                    CV (format PDF uniquement) <span class="required-star">*</span>
                                </label>
                                <div class="cv-upload-zone">
                                    <input type="file" class="@error('cv_file') is-invalid @enderror" id="cv_file" name="cv_file" accept=".pdf" required>
                                    <div class="cv-upload-icon">
                                        <i class="fas fa-cloud-upload-alt"></i>
                                    </div>
                                    <h5>Déposez votre CV ici</h5>
                                    <p class="cv-upload-text">ou cliquez pour parcourir vos fichiers (PDF uniquement, max 5 Mo)</p>
                                    <div id="file-selected"></div>
                                </div>
                                @error('cv_file')
                                    <div class="invalid-feedback d-block mt-2">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Lettre de motivation -->
                            <div class="form-group mb-0">
                                <label for="lettre_motivation" class="form-label">
                                    Lettre de motivation <span class="required-star">*</span>
                                </label>
                                <textarea class="form-control @error('lettre_motivation') is-invalid @enderror" 
                                    id="lettre_motivation" name="lettre_motivation" rows="10" required
                                    placeholder="Expliquez pourquoi vous êtes intéressé(e) par ce poste et pourquoi vous seriez un bon candidat...">{{ old('lettre_motivation') }}</textarea>
                                <div id="char-counter" class="char-counter">0/1500 caractères (minimum 1500)</div>
                                @error('lettre_motivation')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('etudiants.offres.show', $annonce) }}" class="btn btn-outline-secondary">
                                Retour
                            </a>
                            <button type="submit" class="btn btn-primary submit-btn">
                                Soumettre ma candidature
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Gestion du compteur de caractères pour la lettre de motivation
        const lettreMotivation = document.getElementById('lettre_motivation');
        const charCounter = document.getElementById('char-counter');
        const minChar = 100; // Augmentation de la limite à 1500 caractères
        
        if (lettreMotivation && charCounter) {
            // Initialisation du compteur
            updateCounter();
            
            lettreMotivation.addEventListener('input', function() {
                updateCounter();
                validateLetterLength();
            });
            
            function updateCounter() {
                const length = lettreMotivation.value.length;
                charCounter.textContent = length + '/' + minChar + ' caractères (minimum ' + minChar + ')';
                
                if (length < minChar) {
                    charCounter.classList.add('invalid');
                    charCounter.classList.remove('valid');
                } else {
                    charCounter.classList.add('valid');
                    charCounter.classList.remove('invalid');
                }
            }
            
            function validateLetterLength() {
                if (lettreMotivation.value.length < minChar) {
                    lettreMotivation.classList.add('is-invalid');
                    lettreMotivation.classList.remove('is-valid');
                } else {
                    lettreMotivation.classList.remove('is-invalid');
                    lettreMotivation.classList.add('is-valid');
                }
            }
        }
        
        // Gestion de l'affichage du nom du fichier sélectionné
        const cvFile = document.getElementById('cv_file');
        const fileSelected = document.getElementById('file-selected');
        
        if (cvFile && fileSelected) {
            cvFile.addEventListener('change', function() {
                if (this.files.length > 0) {
                    fileSelected.innerHTML = '<div class="alert alert-success mt-3 mb-0">Fichier sélectionné : ' + this.files[0].name + '</div>';
                } else {
                    fileSelected.innerHTML = '';
                }
            });
        }
    });
</script>
@endpush