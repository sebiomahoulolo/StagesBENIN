@extends('layouts.recruteur.app')

@section('title', 'StagesBENIN')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-9">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3">Créer une nouvelle annonce</h1>
                <a href="{{ route('messagerie-sociale.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left"></i> Retour
                </a>
            </div>
            
            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
            
            <div class="card">
                <div class="card-header">
                    <h4>Créer un nouveau post</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('messagerie-sociale.store-post') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="content" class="form-label">Contenu</label>
                            <textarea 
                                id="content" 
                                name="content"
                                class="form-control @error('content') is-invalid @enderror" 
                                rows="5" 
                                placeholder="Rédigez votre message ici..."
                            >{{ old('content') }}</textarea>
                            @error('content')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="attachments" class="form-label d-block">Pièces jointes</label>
                            <input 
                                type="file" 
                                id="attachments" 
                                name="attachments[]"
                                class="form-control @error('attachments.*') is-invalid @enderror" 
                                multiple 
                            >
                            <small class="text-muted">Taille maximale: 10MB par fichier</small>
                            @error('attachments.*')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('messagerie-sociale.index') }}" class="btn btn-secondary">Annuler</a>
                            <button type="submit" class="btn btn-primary">Publier</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 