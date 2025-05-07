@extends('layouts.entreprises.master')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">Créer un événement</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('entreprises.evenements.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        @if($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="mb-3">
                            <label for="title" class="form-label">Titre de l'événement <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                   id="title" name="title" value="{{ old('title') }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" name="description" rows="5" required>{{ old('description') }}</textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="start_date" class="form-label">Date de début <span class="text-danger">*</span></label>
                                <input type="datetime-local" class="form-control @error('start_date') is-invalid @enderror" 
                                       id="start_date" name="start_date" value="{{ old('start_date') }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="end_date" class="form-label">Date de fin <span class="text-danger">*</span></label>
                                <input type="datetime-local" class="form-control @error('end_date') is-invalid @enderror" 
                                       id="end_date" name="end_date" value="{{ old('end_date') }}" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="location" class="form-label">Lieu <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('location') is-invalid @enderror" 
                                   id="location" name="location" value="{{ old('location') }}" required>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="type" class="form-label">Type d'événement</label>
                                <select class="form-select @error('type') is-invalid @enderror" id="type" name="type">
                                    <option value="">Sélectionnez un type</option>
                                    <option value="Formation" {{ old('type') == 'Formation' ? 'selected' : '' }}>Formation</option>
                                    <option value="Conférence" {{ old('type') == 'Conférence' ? 'selected' : '' }}>Conférence</option>
                                    <option value="Séminaire" {{ old('type') == 'Séminaire' ? 'selected' : '' }}>Séminaire</option>
                                    <option value="Atelier" {{ old('type') == 'Atelier' ? 'selected' : '' }}>Atelier</option>
                                    <option value="Hackathon" {{ old('type') == 'Hackathon' ? 'selected' : '' }}>Hackathon</option>
                                    <option value="Autre" {{ old('type') == 'Autre' ? 'selected' : '' }}>Autre</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="max_participants" class="form-label">Nombre maximum de participants</label>
                                <input type="number" class="form-control @error('max_participants') is-invalid @enderror" 
                                       id="max_participants" name="max_participants" value="{{ old('max_participants') }}" 
                                       min="1" placeholder="Illimité si vide">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="image" class="form-label">Image de l'événement</label>
                            <input type="file" class="form-control @error('image') is-invalid @enderror" 
                                   id="image" name="image" accept="image/*">
                            <div class="form-text">Format recommandé : 1200x600px, max 2Mo</div>
                        </div>

                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            Votre événement sera soumis à validation avant d'être publié.
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('entreprises.evenements.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Retour
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Créer l'événement
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Valider que la date de fin est après la date de début
    const startDateInput = document.getElementById('start_date');
    const endDateInput = document.getElementById('end_date');

    function validateDates() {
        if (startDateInput.value && endDateInput.value) {
            const startDate = new Date(startDateInput.value);
            const endDate = new Date(endDateInput.value);
            
            if (endDate <= startDate) {
                endDateInput.setCustomValidity('La date de fin doit être après la date de début');
            } else {
                endDateInput.setCustomValidity('');
            }
        }
    }

    startDateInput.addEventListener('change', validateDates);
    endDateInput.addEventListener('change', validateDates);
});
</script>
@endpush
@endsection