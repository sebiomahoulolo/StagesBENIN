@extends('layouts.admin.app')

@section('title', 'StagesBENIN')

@section('content')
<div class="container-fluid py-4">
    <div class="mb-4">
        <a href="{{ route('admin.complaints.show', $complaintSuggestion->id) }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-1"></i> Retour aux détails
        </a>
    </div>
    
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h4 class="m-0">Répondre à la {{ $complaintSuggestion->type == 'plainte' ? 'plainte' : 'suggestion' }} #{{ $complaintSuggestion->id }}</h4>
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
                    
                    <div class="mb-4">
                        <h5 class="border-bottom pb-2">Sujet</h5>
                        <p class="fw-bold">{{ $complaintSuggestion->sujet }}</p>
                    </div>
                    
                    <div class="mb-4">
                        <h5 class="border-bottom pb-2">Contenu</h5>
                        <div class="p-3 bg-light rounded">
                            {!! nl2br(e($complaintSuggestion->contenu)) !!}
                        </div>
                    </div>
                    
                    <form action="{{ route('admin.complaints.update', $complaintSuggestion->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label for="statut" class="form-label">Changer le statut</label>
                            <select class="form-select @error('statut') is-invalid @enderror" id="statut" name="statut">
                                <option value="nouveau" {{ $complaintSuggestion->statut == 'nouveau' ? 'selected' : '' }}>Nouveau</option>
                                <option value="en_cours" {{ $complaintSuggestion->statut == 'en_cours' ? 'selected' : '' }}>En cours</option>
                                <option value="résolu" {{ $complaintSuggestion->statut == 'résolu' ? 'selected' : '' }}>Résolu</option>
                            </select>
                            @error('statut')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="reponse" class="form-label">Votre réponse</label>
                            <textarea class="form-control @error('reponse') is-invalid @enderror" id="reponse" name="reponse" rows="6">{{ old('reponse', $complaintSuggestion->reponse) }}</textarea>
                            @error('reponse')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">Une réponse est requise si vous marquez cette plainte/suggestion comme résolue.</small>
                        </div>
                        
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i> Enregistrer
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 