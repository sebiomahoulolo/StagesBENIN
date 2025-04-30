@extends('layouts.admin.app')

@section('title', 'Créer une annonce')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Créer une nouvelle annonce</h1>
        <a href="{{ route('admin.annonces.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Retour
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Formulaire de création</h6>
        </div>
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.annonces.store') }}" method="POST" class="needs-validation" novalidate>
                @csrf
                <div class="row g-4">
                    <!-- Première colonne -->
                    <div class="col-lg-6">
                        <div class="card mb-4">
                            <div class="card-header bg-light">
                                <h6 class="mb-0">Informations principales</h6>
                            </div>
                            <div class="card-body">
                                <!-- Entreprise -->
                                <div class="mb-3">
                                    <label for="entreprise_id" class="form-label">Entreprise <span class="text-danger">*</span></label>
                                    <select class="form-select @error('entreprise_id') is-invalid @enderror" id="entreprise_id" name="entreprise_id" required>
                                        <option value="">Sélectionner une entreprise</option>
                                        @foreach($entreprises as $entreprise)
                                            <option value="{{ $entreprise->user_id }}" {{ old('entreprise_id') == $entreprise->user_id ? 'selected' : '' }}>
                                                {{ $entreprise->nom }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('entreprise_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Titre du poste -->
                                <div class="mb-3">
                                    <label for="nom_du_poste" class="form-label">Titre du poste <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('nom_du_poste') is-invalid @enderror" id="nom_du_poste" name="nom_du_poste" value="{{ old('nom_du_poste') }}" required>
                                    @error('nom_du_poste')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Type de poste -->
                                <div class="mb-3">
                                    <label for="type_de_poste" class="form-label">Type de poste <span class="text-danger">*</span></label>
                                    <select class="form-select @error('type_de_poste') is-invalid @enderror" id="type_de_poste" name="type_de_poste" required>
                                        <option value="">Sélectionner un type</option>
                                        <option value="Stage" {{ old('type_de_poste') == 'Stage' ? 'selected' : '' }}>Stage</option>
                                        <option value="CDI" {{ old('type_de_poste') == 'CDI' ? 'selected' : '' }}>CDI</option>
                                        <option value="CDD" {{ old('type_de_poste') == 'CDD' ? 'selected' : '' }}>CDD</option>
                                        <option value="Alternance" {{ old('type_de_poste') == 'Alternance' ? 'selected' : '' }}>Alternance</option>
                                    </select>
                                    @error('type_de_poste')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Spécialité -->
                                <div class="mb-3">
                                    <label for="specialite_id" class="form-label">Spécialité <span class="text-danger">*</span></label>
                                    <select class="form-select @error('specialite_id') is-invalid @enderror" id="specialite_id" name="specialite_id" required>
                                        <option value="">Sélectionner une spécialité</option>
                                        @foreach($specialites as $specialite)
                                            <option value="{{ $specialite->id }}" {{ old('specialite_id') == $specialite->id ? 'selected' : '' }}>
                                                {{ $specialite->nom }} ({{ $specialite->secteur->nom }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('specialite_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Niveau d'étude -->
                                <div class="mb-3">
                                    <label for="niveau_detude" class="form-label">Niveau d'étude requis <span class="text-danger">*</span></label>
                                    <select class="form-select @error('niveau_detude') is-invalid @enderror" id="niveau_detude" name="niveau_detude" required>
                                        <option value="">Sélectionner un niveau</option>
                                        <option value="Bac" {{ old('niveau_detude') == 'Bac' ? 'selected' : '' }}>Bac</option>
                                        <option value="Bac+2" {{ old('niveau_detude') == 'Bac+2' ? 'selected' : '' }}>Bac+2</option>
                                        <option value="Bac+3" {{ old('niveau_detude') == 'Bac+3' ? 'selected' : '' }}>Bac+3</option>
                                        <option value="Bac+5" {{ old('niveau_detude') == 'Bac+5' ? 'selected' : '' }}>Bac+5</option>
                                        <option value="Doctorat" {{ old('niveau_detude') == 'Doctorat' ? 'selected' : '' }}>Doctorat</option>
                                    </select>
                                    @error('niveau_detude')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Deuxième colonne -->
                    <div class="col-lg-6">
                        <div class="card mb-4">
                            <div class="card-header bg-light">
                                <h6 class="mb-0">Informations complémentaires</h6>
                            </div>
                            <div class="card-body">
                                <!-- Lieu -->
                                <div class="mb-3">
                                    <label for="lieu" class="form-label">Lieu <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('lieu') is-invalid @enderror" id="lieu" name="lieu" value="{{ old('lieu') }}" required>
                                    @error('lieu')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Nombre de places -->
                                <div class="mb-3">
                                    <label for="nombre_de_place" class="form-label">Nombre de places <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control @error('nombre_de_place') is-invalid @enderror" id="nombre_de_place" name="nombre_de_place" value="{{ old('nombre_de_place', 1) }}" min="1" required>
                                    @error('nombre_de_place')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Prétention salariale -->
                                <div class="mb-3">
                                    <label for="pretension_salariale" class="form-label">Prétention salariale (FCFA)</label>
                                    <input type="number" class="form-control @error('pretension_salariale') is-invalid @enderror" id="pretension_salariale" name="pretension_salariale" value="{{ old('pretension_salariale') }}" min="0">
                                    @error('pretension_salariale')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Date de clôture -->
                                <div class="mb-3">
                                    <label for="date_cloture" class="form-label">Date de clôture <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control @error('date_cloture') is-invalid @enderror" id="date_cloture" name="date_cloture" value="{{ old('date_cloture') }}" required>
                                    @error('date_cloture')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Email de contact -->
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email de contact <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="col-12">
                        <div class="card mb-4">
                            <div class="card-header bg-light">
                                <h6 class="mb-0">Description du poste <span class="text-danger">*</span></h6>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="6" required>{{ old('description') }}</textarea>
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
                        <i class="fas fa-save"></i> Créer l'annonce
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Validation du formulaire Bootstrap
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