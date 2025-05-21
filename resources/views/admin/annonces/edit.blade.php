@extends('layouts.admin.app')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Modifier l'Annonce</h1>
    
    @if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
    @endif

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-edit me-1"></i>
            Modification de l'annonce
        </div>
        <div class="card-body">
            <form action="{{ route('admin.annonces.update', $annonce) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="entreprise" class="form-label">Entreprise <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('entreprise') is-invalid @enderror" 
                               id="entreprise" name="entreprise" value="{{ old('entreprise', $annonce->entreprise) }}" required>
                        @error('entreprise')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="nom_du_poste" class="form-label">Nom du poste <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('nom_du_poste') is-invalid @enderror" 
                               id="nom_du_poste" name="nom_du_poste" value="{{ old('nom_du_poste', $annonce->nom_du_poste) }}" required>
                        @error('nom_du_poste')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="type_de_poste" class="form-label">Type de poste <span class="text-danger">*</span></label>
                        <select class="form-select @error('type_de_poste') is-invalid @enderror" 
                                id="type_de_poste" name="type_de_poste" required>
                            <option value="">Sélectionnez un type</option>
                            <option value="CDI" {{ old('type_de_poste', $annonce->type_de_poste) == 'CDI' ? 'selected' : '' }}>CDI</option>
                            <option value="CDD" {{ old('type_de_poste', $annonce->type_de_poste) == 'CDD' ? 'selected' : '' }}>CDD</option>
                            <option value="Stage" {{ old('type_de_poste', $annonce->type_de_poste) == 'Stage' ? 'selected' : '' }}>Stage</option>
                            <option value="Freelance" {{ old('type_de_poste', $annonce->type_de_poste) == 'Freelance' ? 'selected' : '' }}>Freelance</option>
                        </select>
                        @error('type_de_poste')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="nombre_de_place" class="form-label">Nombre de places <span class="text-danger">*</span></label>
                        <input type="number" class="form-control @error('nombre_de_place') is-invalid @enderror" 
                               id="nombre_de_place" name="nombre_de_place" 
                               value="{{ old('nombre_de_place', $annonce->nombre_de_place) }}" min="1" required>
                        @error('nombre_de_place')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="niveau_detude" class="form-label">Niveau d'étude <span class="text-danger">*</span></label>
                        <select class="form-select @error('niveau_detude') is-invalid @enderror" 
                                id="niveau_detude" name="niveau_detude" required>
                            <option value="">Sélectionnez un niveau</option>
                            <option value="Bac" {{ old('niveau_detude', $annonce->niveau_detude) == 'Bac' ? 'selected' : '' }}>Bac</option>
                            <option value="Bac+2" {{ old('niveau_detude', $annonce->niveau_detude) == 'Bac+2' ? 'selected' : '' }}>Bac+2</option>
                            <option value="Bac+3" {{ old('niveau_detude', $annonce->niveau_detude) == 'Bac+3' ? 'selected' : '' }}>Bac+3</option>
                            <option value="Bac+4" {{ old('niveau_detude', $annonce->niveau_detude) == 'Bac+4' ? 'selected' : '' }}>Bac+4</option>
                            <option value="Bac+5" {{ old('niveau_detude', $annonce->niveau_detude) == 'Bac+5' ? 'selected' : '' }}>Bac+5</option>
                        </select>
                        @error('niveau_detude')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="specialite_id" class="form-label">Spécialité <span class="text-danger">*</span></label>
                        <select class="form-select @error('specialite_id') is-invalid @enderror" 
                                id="specialite_id" name="specialite_id" required>
                            <option value="">Sélectionnez une spécialité</option>
                            @foreach($specialites as $specialite)
                                <option value="{{ $specialite->id }}" 
                                    {{ old('specialite_id', $annonce->specialite_id) == $specialite->id ? 'selected' : '' }}>
                                    {{ $specialite->nom }} ({{ $specialite->secteur->nom }})
                                </option>
                            @endforeach
                        </select>
                        @error('specialite_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="lieu" class="form-label">Lieu <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('lieu') is-invalid @enderror" 
                               id="lieu" name="lieu" value="{{ old('lieu', $annonce->lieu) }}" required>
                        @error('lieu')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" 
                               id="email" name="email" value="{{ old('email', $annonce->email) }}" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="date_cloture" class="form-label">Date de clôture <span class="text-danger">*</span></label>
                        <input type="date" class="form-control @error('date_cloture') is-invalid @enderror" 
                               id="date_cloture" name="date_cloture" 
                               value="{{ old('date_cloture', $annonce->date_cloture->format('Y-m-d')) }}" required>
                        @error('date_cloture')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="pretension_salariale" class="form-label">Prétention salariale</label>
                        <input type="number" step="0.01" class="form-control @error('pretension_salariale') is-invalid @enderror" 
                               id="pretension_salariale" name="pretension_salariale" 
                               value="{{ old('pretension_salariale', $annonce->pretension_salariale) }}">
                        @error('pretension_salariale')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Description <span class="text-danger">*</span></label>
                    <textarea class="form-control @error('description') is-invalid @enderror" 
                              id="description" name="description" rows="5" required>{{ old('description', $annonce->description) }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('admin.annonces.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Retour
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Enregistrer les modifications
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection 