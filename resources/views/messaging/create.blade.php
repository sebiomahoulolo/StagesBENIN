@extends('layouts.etudiant.app')

@section('title', 'Nouvelle conversation')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm">
        <div class="card-header bg-white">
            <div class="d-flex align-items-center">
                <a href="{{ route('messaging.index') }}" class="btn btn-link text-dark">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <h1 class="h4 mb-0">Nouvelle conversation</h1>
            </div>
        </div>
        
        <div class="card-body">
            <form action="{{ route('messaging.store') }}" method="POST">
                @csrf
                
                <div class="mb-4">
                    <label for="recipient_ids" class="form-label">Destinataires</label>
                    <select class="form-select select2-multiple" id="recipient_ids" name="recipient_ids[]" multiple required>
                        @foreach($potentialContacts as $contact)
                            <option value="{{ $contact->id }}">
                                {{ $contact->name }} 
                                @if($contact->role == 'etudiant')
                                    (Étudiant)
                                @elseif($contact->role == 'recruteur')
                                    (Recruteur)
                                @endif
                            </option>
                        @endforeach
                    </select>
                    
                    @error('recipient_ids')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="mb-4 conversation-name-container" style="display: none;">
                    <label for="name" class="form-label">Nom du groupe</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Entrez un nom pour le groupe">
                </div>
                
                <div class="mb-4">
                    <label for="message" class="form-label">Premier message</label>
                    <textarea class="form-control" id="message" name="message" rows="4" required></textarea>
                    
                    @error('message')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <a href="{{ route('messaging.index') }}" class="btn btn-outline-secondary">Annuler</a>
                    <button type="submit" class="btn btn-primary">Envoyer</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    .select2-container {
        width: 100% !important;
    }
    
    .select2-selection--multiple {
        min-height: 38px;
        border: 1px solid #ced4da !important;
    }
    
    .select2-container--default .select2-selection--multiple .select2-selection__choice {
        background-color: #e9ecef;
        border: 1px solid #ced4da;
        border-radius: 4px;
        margin: 5px 5px 0 0;
        padding: 2px 5px;
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        // Initialisation de Select2 pour la sélection multiple
        $('.select2-multiple').select2({
            placeholder: 'Sélectionnez un ou plusieurs destinataires',
            language: 'fr',
            allowClear: true
        });
        
        // Afficher/masquer le champ de nom de groupe si plusieurs destinataires sont sélectionnés
        $('#recipient_ids').on('change', function() {
            const selectedCount = $(this).val() ? $(this).val().length : 0;
            $('.conversation-name-container').toggle(selectedCount > 1);
        });
    });
</script>
@endpush 