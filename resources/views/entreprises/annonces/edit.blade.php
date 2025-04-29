@extends('layouts.entreprises.master')

@section('title', 'Modifier l\'annonce')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-12 col-xl-10">
            <div class="card shadow-sm">
                <div class="card-header bg-white py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Modifier l'annonce</h5>
                        <a href="{{ route('entreprises.annonces.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Retour
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <form action="{{ route('entreprises.annonces.update', $annonce) }}" method="POST" class="needs-validation" novalidate>
                        @csrf
                        @method('PUT')

                        <div class="row g-4">
                            <!-- Titre du poste -->
                            <div class="col-md-12">
                                <label for="nom_du_poste" class="form-label">Titre du poste *</label>
                                <input type="text" class="form-control @error('nom_du_poste') is-invalid @enderror" 
                                       id="nom_du_poste" name="nom_du_poste" 
                                       value="{{ old('nom_du_poste', $annonce->nom_du_poste) }}" required>
                                @error('nom_du_poste')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Type de poste -->
                            <div class="col-md-6">
                                <label for="type_de_poste" class="form-label">Type de poste *</label>
                                <select class="form-select @error('type_de_poste') is-invalid @enderror" 
                                        id="type_de_poste" name="type_de_poste" required>
                                    <option value="">Sélectionnez un type</option>
                                    <option value="Stage" {{ old('type_de_poste', $annonce->type_de_poste) == 'Stage' ? 'selected' : '' }}>Stage</option>
                                    <option value="CDI" {{ old('type_de_poste', $annonce->type_de_poste) == 'CDI' ? 'selected' : '' }}>CDI</option>
                                    <option value="CDD" {{ old('type_de_poste', $annonce->type_de_poste) == 'CDD' ? 'selected' : '' }}>CDD</option>
                                    <option value="Alternance" {{ old('type_de_poste', $annonce->type_de_poste) == 'Alternance' ? 'selected' : '' }}>Alternance</option>
                                </select>
                                @error('type_de_poste')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Secteur d'activité -->
                            <div class="col-md-6">
                                <label for="secteur_id" class="form-label">Secteur d'activité *</label>
                                <select class="form-select select2 @error('secteur_id') is-invalid @enderror" 
                                        id="secteur_id" name="secteur_id" required>
                                    <option value="">Sélectionnez un secteur</option>
                                    @foreach($secteurs as $secteur)
                                        <option value="{{ $secteur->id }}" {{ old('secteur_id', $annonce->secteur_id) == $secteur->id ? 'selected' : '' }}>
                                            {{ $secteur->nom }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('secteur_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Spécialité -->
                            <div class="col-md-6">
                                <label for="specialite_id" class="form-label">Spécialité *</label>
                                <select class="form-select select2 @error('specialite_id') is-invalid @enderror" 
                                        id="specialite_id" name="specialite_id" required>
                                    <option value="">Sélectionnez une spécialité</option>
                                    @foreach($specialites as $specialite)
                                        <option value="{{ $specialite->id }}" {{ old('specialite_id', $annonce->specialite_id) == $specialite->id ? 'selected' : '' }}>
                                            {{ $specialite->nom }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('specialite_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Niveau d'études -->
                            <div class="col-md-6">
                                <label for="niveau_detude" class="form-label">Niveau d'études requis *</label>
                                <select class="form-select @error('niveau_detude') is-invalid @enderror" 
                                        id="niveau_detude" name="niveau_detude" required>
                                    <option value="">Sélectionnez un niveau</option>
                                    <option value="Bac" {{ old('niveau_detude', $annonce->niveau_detude) == 'Bac' ? 'selected' : '' }}>Bac</option>
                                    <option value="Bac+2" {{ old('niveau_detude', $annonce->niveau_detude) == 'Bac+2' ? 'selected' : '' }}>Bac+2</option>
                                    <option value="Bac+3" {{ old('niveau_detude', $annonce->niveau_detude) == 'Bac+3' ? 'selected' : '' }}>Bac+3</option>
                                    <option value="Bac+5" {{ old('niveau_detude', $annonce->niveau_detude) == 'Bac+5' ? 'selected' : '' }}>Bac+5</option>
                                </select>
                                @error('niveau_detude')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Localisation -->
                            <div class="col-md-6">
                                <label for="lieu" class="form-label">Lieu *</label>
                                <input type="text" class="form-control @error('lieu') is-invalid @enderror" 
                                       id="lieu" name="lieu" 
                                       value="{{ old('lieu', $annonce->lieu) }}" required>
                                @error('lieu')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Nombre de postes -->
                            <div class="col-md-6">
                                <label for="nombre_de_place" class="form-label">Nombre de places *</label>
                                <input type="number" class="form-control @error('nombre_de_place') is-invalid @enderror" 
                                       id="nombre_de_place" name="nombre_de_place" 
                                       value="{{ old('nombre_de_place', $annonce->nombre_de_place) }}" required min="1">
                                @error('nombre_de_place')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Prétention salariale -->
                            <div class="col-md-6">
                                <label for="pretension_salariale" class="form-label">Prétention salariale (FCFA)</label>
                                <input type="number" class="form-control @error('pretension_salariale') is-invalid @enderror" 
                                       id="pretension_salariale" name="pretension_salariale" 
                                       value="{{ old('pretension_salariale', $annonce->pretension_salariale) }}" min="0" step="1000">
                                @error('pretension_salariale')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Date de clôture -->
                            <div class="col-md-6">
                                <label for="date_cloture" class="form-label">Date de clôture *</label>
                                <input type="date" class="form-control @error('date_cloture') is-invalid @enderror" 
                                       id="date_cloture" name="date_cloture" 
                                       value="{{ old('date_cloture', $annonce->date_cloture->format('Y-m-d')) }}" required>
                                @error('date_cloture')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Email de contact -->
                            <div class="col-md-12">
                                <label for="email" class="form-label">Email de contact *</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                       id="email" name="email" 
                                       value="{{ old('email', $annonce->email) }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Description du poste -->
                            <div class="col-12">
                                <label for="description" class="form-label">Description du poste *</label>
                                <textarea class="form-control @error('description') is-invalid @enderror" 
                                          id="description" name="description" rows="6" required>{{ old('description', $annonce->description) }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Enregistrer les modifications
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />
<style>
    .form-label {
        font-weight: 500;
        color: #2c3e50;
    }

    .form-control, .form-select {
        border-radius: 0.375rem;
        border: 1px solid #dee2e6;
        padding: 0.5rem 0.75rem;
    }

    .form-control:focus, .form-select:focus {
        border-color: #80bdff;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    }

    .btn-primary {
        background-color: #3498db;
        border-color: #3498db;
        padding: 0.5rem 1.5rem;
    }

    .btn-primary:hover {
        background-color: #2980b9;
        border-color: #2980b9;
    }

    .card {
        border: none;
        border-radius: 0.5rem;
    }

    .card-header {
        border-bottom: 1px solid rgba(0, 0, 0, 0.125);
    }

    @media (max-width: 768px) {
        .container-fluid {
            padding: 1rem;
        }
        
        .card {
            margin: 0 -1rem;
            border-radius: 0;
        }
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
// Initialisation de Select2
$(document).ready(function() {
    $('.select2').select2({
        theme: "bootstrap-5",
        width: '100%'
    });

    // Gestion dynamique des spécialités
    $('#secteur_id').on('change', function() {
        const secteurId = $(this).val();
        const specialiteSelect = $('#specialite_id');
        
        specialiteSelect.empty().append('<option value="">Sélectionnez une spécialité</option>');
        
        if (secteurId) {
            fetch(`/api/specialites/${secteurId}`)
                .then(response => response.json())
                .then(specialites => {
                    specialites.forEach(specialite => {
                        specialiteSelect.append(
                            $('<option></option>')
                                .val(specialite.id)
                                .text(specialite.nom)
                        );
                    });
                });
        }
    });

    // Si un secteur est déjà sélectionné (en cas d'erreur de validation)
    if ($('#secteur_id').val()) {
        $('#secteur_id').trigger('change');
    }
});

// Validation des formulaires Bootstrap
(function () {
    'use strict'
    var forms = document.querySelectorAll('.needs-validation')
    Array.prototype.slice.call(forms).forEach(function (form) {
        form.addEventListener('submit', function (event) {
            if (!form.checkValidity()) {
                event.preventDefault()
                event.stopPropagation()
            }
            form.classList.add('was-validated')
        }, false)
    })
})()
</script>
@endpush
@endsection 