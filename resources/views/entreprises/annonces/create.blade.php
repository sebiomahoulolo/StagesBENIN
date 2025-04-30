@extends('layouts.entreprises.master')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-0">Créer une nouvelle annonce</h5>
                        <small class="text-muted">Remplissez tous les champs requis</small>
                    </div>
                    <a href="{{ route('entreprises.annonces.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Retour
                    </a>
                </div>
                <div class="card-body">
                    <form action="{{ route('entreprises.annonces.store') }}" method="POST" class="needs-validation" novalidate>
                        @csrf
                        <div class="row g-4">
                            <!-- Informations principales -->
                            <div class="col-md-6">
                                <div class="card h-100">
                                    <div class="card-header bg-light">
                                        <h6 class="mb-0">Informations principales</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label for="nom_du_poste" class="form-label">
                                                Titre du poste <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" class="form-control @error('nom_du_poste') is-invalid @enderror" 
                                                id="nom_du_poste" name="nom_du_poste" value="{{ old('nom_du_poste') }}" required>
                                            @error('nom_du_poste')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="type_de_poste" class="form-label">
                                                Type de poste <span class="text-danger">*</span>
                                            </label>
                                            <select class="form-select @error('type_de_poste') is-invalid @enderror" 
                                                id="type_de_poste" name="type_de_poste" required>
                                                <option value="">Sélectionnez un type</option>
                                                <option value="Stage" {{ old('type_de_poste') == 'Stage' ? 'selected' : '' }}>Stage</option>
                                                <option value="CDI" {{ old('type_de_poste') == 'CDI' ? 'selected' : '' }}>CDI</option>
                                                <option value="CDD" {{ old('type_de_poste') == 'CDD' ? 'selected' : '' }}>CDD</option>
                                                <option value="Alternance" {{ old('type_de_poste') == 'Alternance' ? 'selected' : '' }}>Alternance</option>
                                            </select>
                                            @error('type_de_poste')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="specialite_id" class="form-label">
                                                Spécialité <span class="text-danger">*</span>
                                            </label>
                                            <select class="form-select select2 @error('specialite_id') is-invalid @enderror" 
                                                id="specialite_id" name="specialite_id" required>
                                                <option value="">Sélectionnez une spécialité</option>
                                                @foreach($specialites as $specialite)
                                                    <option value="{{ $specialite->id }}" {{ old('specialite_id') == $specialite->id ? 'selected' : '' }}>
                                                        {{ $specialite->nom }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('specialite_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="niveau_detude" class="form-label">
                                                Niveau d'étude requis <span class="text-danger">*</span>
                                            </label>
                                            <select class="form-select @error('niveau_detude') is-invalid @enderror" 
                                                id="niveau_detude" name="niveau_detude" required>
                                                <option value="">Sélectionnez un niveau</option>
                                                <option value="Bac" {{ old('niveau_detude') == 'Bac' ? 'selected' : '' }}>Bac</option>
                                                <option value="Bac+2" {{ old('niveau_detude') == 'Bac+2' ? 'selected' : '' }}>Bac+2</option>
                                                <option value="Bac+3" {{ old('niveau_detude') == 'Bac+3' ? 'selected' : '' }}>Bac+3</option>
                                                <option value="Bac+5" {{ old('niveau_detude') == 'Bac+5' ? 'selected' : '' }}>Bac+5</option>
                                            </select>
                                            @error('niveau_detude')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Informations complémentaires -->
                            <div class="col-md-6">
                                <div class="card h-100">
                                    <div class="card-header bg-light">
                                        <h6 class="mb-0">Informations complémentaires</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label for="lieu" class="form-label">
                                                Lieu <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" class="form-control @error('lieu') is-invalid @enderror" 
                                                id="lieu" name="lieu" value="{{ old('lieu') }}" required>
                                            @error('lieu')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="nombre_de_place" class="form-label">
                                                Nombre de places <span class="text-danger">*</span>
                                            </label>
                                            <input type="number" class="form-control @error('nombre_de_place') is-invalid @enderror" 
                                                id="nombre_de_place" name="nombre_de_place" value="{{ old('nombre_de_place') }}" min="1" required>
                                            @error('nombre_de_place')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="pretension_salariale" class="form-label">
                                                Prétention salariale (FCFA)
                                            </label>
                                            <input type="number" class="form-control @error('pretension_salariale') is-invalid @enderror" 
                                                id="pretension_salariale" name="pretension_salariale" 
                                                value="{{ old('pretension_salariale') }}" min="0">
                                            @error('pretension_salariale')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="date_cloture" class="form-label">
                                                Date de clôture <span class="text-danger">*</span>
                                            </label>
                                            <input type="date" class="form-control @error('date_cloture') is-invalid @enderror" 
                                                id="date_cloture" name="date_cloture" value="{{ old('date_cloture') }}" required>
                                            @error('date_cloture')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="email" class="form-label">
                                                Email de contact <span class="text-danger">*</span>
                                            </label>
                                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                                id="email" name="email" value="{{ old('email') }}" required>
                                            @error('email')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Description -->
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header bg-light">
                                        <h6 class="mb-0">Description du poste <span class="text-danger">*</span></h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                                id="description" name="description" rows="6" required>{{ old('description') }}</textarea>
                                            @error('description')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end mt-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-paper-plane me-2"></i>Publier l'annonce
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
    margin-bottom: 0.5rem;
}

.form-control, .form-select {
    border-radius: 0.375rem;
    padding: 0.5rem 0.75rem;
}

.form-control:focus, .form-select:focus {
    border-color: #86b7fe;
    box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
}

.invalid-feedback {
    font-size: 0.875rem;
}

.card {
    border: none;
    border-radius: 0.5rem;
}

.card-header {
    border-bottom: 1px solid rgba(0, 0, 0, 0.125);
    padding: 1rem;
}

.btn-primary {
    padding: 0.5rem 1.5rem;
}

@media (max-width: 768px) {
    .card {
        margin-bottom: 1rem;
    }
    
    .btn {
        width: 100%;
    }
}
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
$(document).ready(function() {
    // Initialisation de Select2 pour le champ spécialité
    $('.select2').select2({
        theme: "bootstrap-5",
        width: '100%',
        language: {
            noResults: function() {
                return "Aucun résultat trouvé";
            }
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
});
</script>
@endpush
@endsection 