@extends('layouts.layout')

@section('title', 'Configuration du profil - StagesBENIN')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h2 class="text-center mb-0">Complétez votre profil</h2>
                </div>
                <div class="card-body">
                    <form action="{{ route('profile.setup.etudiant.save') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- Formation -->
                        <div class="mb-3">
                            <label for="formation" class="form-label">Formation actuelle</label>
                            <input type="text" class="form-control @error('formation') is-invalid @enderror" 
                                   id="formation" name="formation" value="{{ old('formation') }}" required>
                            @error('formation')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Niveau -->
                        <div class="mb-3">
                            <label for="niveau" class="form-label">Niveau d'études</label>
                            <select class="form-select @error('niveau') is-invalid @enderror" 
                                    id="niveau" name="niveau" required>
                                <option value="">Choisir un niveau</option>
                                <option value="Licence 1" {{ old('niveau') == 'Licence 1' ? 'selected' : '' }}>Licence 1</option>
                                <option value="Licence 2" {{ old('niveau') == 'Licence 2' ? 'selected' : '' }}>Licence 2</option>
                                <option value="Licence 3" {{ old('niveau') == 'Licence 3' ? 'selected' : '' }}>Licence 3</option>
                                <option value="Master 1" {{ old('niveau') == 'Master 1' ? 'selected' : '' }}>Master 1</option>
                                <option value="Master 2" {{ old('niveau') == 'Master 2' ? 'selected' : '' }}>Master 2</option>
                            </select>
                            @error('niveau')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Date de naissance -->
                        <div class="mb-3">
                            <label for="date_naissance" class="form-label">Date de naissance</label>
                            <input type="date" class="form-control @error('date_naissance') is-invalid @enderror" 
                                   id="date_naissance" name="date_naissance" value="{{ old('date_naissance') }}" required>
                            @error('date_naissance')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Spécialité -->
                        <div class="mb-3">
                            <label for="specialite_id" class="form-label">Spécialité</label>
                            <select class="form-select @error('specialite_id') is-invalid @enderror" 
                                    id="specialite_id" name="specialite_id" required>
                                <option value="">Choisir une spécialité</option>
                                @foreach($specialites as $specialite)
                                    <option value="{{ $specialite->id }}">{{ $specialite->nom }}</option>
                                @endforeach
                            </select>
                            @error('specialite_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Photo -->
                        <div class="mb-3">
                            <label for="photo" class="form-label">Photo de profil</label>
                            <input type="file" class="form-control @error('photo') is-invalid @enderror" 
                                   id="photo" name="photo" accept="image/*">
                            @error('photo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">Enregistrer et continuer</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection