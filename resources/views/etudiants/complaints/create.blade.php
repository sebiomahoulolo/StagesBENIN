@extends('layouts.etudiant.app')

@section('title', 'StagesBENIN')

@push('styles')
<style>
    /* Styles pour le formulaire de création des plaintes et suggestions */
    .complaint-page-container {
        max-width: 900px;
        margin: 0 auto;
        animation: fadeIn 0.5s ease forwards;
    }
    
    .page-header {
        margin-bottom: 2rem;
    }
    
    .page-title {
        color: #1e40af;
        font-size: 1.75rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }
    
    .page-description {
        color: #6b7280;
        font-size: 1rem;
        max-width: 80%;
        margin-bottom: 2rem;
    }
    
    .complaint-form-card {
        border: none;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        border-radius: 12px;
        overflow: hidden;
        transition: all 0.3s ease;
        background-color: white;
    }
    
    .form-header {
        padding: 25px 30px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        display: flex;
        align-items: center;
        gap: 15px;
    }
    
    .form-header.plainte {
        background: linear-gradient(135deg, #ef4444, #b91c1c);
    }
    
    .form-header.suggestion {
        background: linear-gradient(135deg, #0ea5e9, #0369a1);
    }
    
    .form-header.neutral {
        background: linear-gradient(135deg, #6b7280, #374151);
    }
    
    .form-header h2 {
        color: white;
        font-weight: 700;
        margin: 0;
        font-size: 1.5rem;
    }
    
    .form-header .icon-container {
        background-color: rgba(255, 255, 255, 0.2);
        border-radius: 50%;
        width: 45px;
        height: 45px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .form-header .icon-container i {
        color: white;
        font-size: 1.25rem;
    }
    
    .form-body {
        padding: 30px;
    }
    
    .form-section {
        margin-bottom: 2.5rem;
        animation: fadeInUp 0.5s ease forwards;
        opacity: 0;
    }
    
    .form-section:nth-child(1) { animation-delay: 0.1s; }
    .form-section:nth-child(2) { animation-delay: 0.2s; }
    .form-section:nth-child(3) { animation-delay: 0.3s; }
    .form-section:nth-child(4) { animation-delay: 0.4s; }
    .form-section:nth-child(5) { animation-delay: 0.5s; }
    
    .section-label {
        font-size: 1.1rem;
        font-weight: 600;
        color: #1f2937;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
    }
    
    .section-label i {
        margin-right: 10px;
        color: #4b5563;
    }
    
    .form-label {
        font-weight: 600;
        color: #4b5563;
        margin-bottom: 8px;
        display: block;
    }
    
    .form-control, .form-select {
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        padding: 12px 16px;
        font-size: 1rem;
        transition: all 0.2s ease;
        width: 100%;
        color: #1f2937;
    }
    
    .form-control:focus, .form-select:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15);
        outline: none;
    }
    
    .form-select {
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='%234b5563' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: calc(100% - 12px) center;
        padding-right: 36px;
    }
    
    .form-control.is-invalid, .form-select.is-invalid {
        border-color: #dc2626;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='%23dc2626' viewBox='0 0 16 16'%3E%3Cpath d='M8 2a6 6 0 0 1 6 6 6 6 0 0 1-6 6 6 6 0 0 1-6-6 6 6 0 0 1 6-6zm0 9a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm0-7a1 1 0 0 0-1 1v4a1 1 0 0 0 2 0V5a1 1 0 0 0-1-1z'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 12px center;
        padding-right: 40px;
    }
    
    .invalid-feedback {
        color: #dc2626;
        font-size: 0.875rem;
        margin-top: 4px;
        display: block;
    }
    
    .form-text {
        color: #6b7280;
        font-size: 0.875rem;
        margin-top: 4px;
    }
    
    .form-check {
        display: flex;
        align-items: center;
        padding: 0;
        margin-bottom: 0;
    }
    
    .form-check-input {
        width: 1.25rem;
        height: 1.25rem;
        margin-top: 0;
        margin-right: 0.5rem;
        border: 1px solid #d1d5db;
        border-radius: 4px;
        transition: all 0.2s ease;
        flex-shrink: 0;
    }
    
    .form-check-input:checked {
        background-color: #2563eb;
        border-color: #2563eb;
    }
    
    .form-check-input:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15);
    }
    
    .form-check-label {
        font-weight: 500;
        color: #4b5563;
        cursor: pointer;
    }
    
    .anonymous-info {
        background-color: rgba(79, 70, 229, 0.08);
        border-left: 3px solid #4f46e5;
        padding: 12px 16px;
        border-radius: 0 6px 6px 0;
        margin-top: 12px;
        display: flex;
        align-items: center;
    }
    
    .anonymous-info i {
        font-size: 1.25rem;
        margin-right: 12px;
        color: #4f46e5;
    }
    
    .anonymous-info p {
        margin-bottom: 0;
        font-size: 0.875rem;
        color: #4338ca;
    }
    
    .form-buttons {
        display: flex;
        justify-content: space-between;
        margin-top: 2rem;
    }
    
    .btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-weight: 500;
        border-radius: 8px;
        padding: 12px 24px;
        transition: all 0.3s ease;
        gap: 8px;
    }
    
    .btn-primary {
        background-color: #2563eb;
        border-color: #2563eb;
        color: white;
    }
    
    .btn-primary:hover {
        background-color: #1d4ed8;
        border-color: #1d4ed8;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.2);
    }
    
    .btn-outline-secondary {
        color: #4b5563;
        border-color: #d1d5db;
        background-color: transparent;
    }
    
    .btn-outline-secondary:hover {
        background-color: #f3f4f6;
        border-color: #9ca3af;
        color: #111827;
        transform: translateY(-2px);
    }
    
    .btn i {
        font-size: 1rem;
    }
    
    .alert-danger {
        background-color: #fee2e2;
        border: none;
        border-left: 4px solid #dc2626;
        color: #b91c1c;
        border-radius: 6px;
        padding: 16px 20px;
        margin-bottom: 20px;
        display: flex;
        align-items: flex-start;
    }
    
    .alert-danger i {
        font-size: 1.25rem;
        margin-right: 12px;
        margin-top: 2px;
    }
    
    .alert-danger ul {
        margin: 0;
        padding-left: 0;
        list-style-position: inside;
    }
    
    /* Type toggle selector */
    .type-toggle {
        display: flex;
        border-radius: 8px;
        overflow: hidden;
        margin-bottom: 20px;
        border: 1px solid #e5e7eb;
    }
    
    .type-toggle-option {
        flex: 1;
        text-align: center;
        padding: 15px;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        font-weight: 500;
        color: #4b5563;
        position: relative;
        overflow: hidden;
    }
    
    .type-toggle-option.active.plainte {
        background-color: rgba(239, 68, 68, 0.1);
        color: #dc2626;
    }
    
    .type-toggle-option.active.suggestion {
        background-color: rgba(14, 165, 233, 0.1);
        color: #0369a1;
    }
    
    .type-toggle-option i {
        font-size: 1.1rem;
    }
    
    .type-toggle-option:first-child {
        border-right: 1px solid #e5e7eb;
    }
    
    /* Photo upload */
    .photo-upload-container {
        border: 2px dashed #d1d5db;
        border-radius: 8px;
        padding: 20px;
        text-align: center;
        transition: all 0.3s ease;
        background-color: #f9fafb;
        position: relative;
        cursor: pointer;
    }
    
    .photo-upload-container:hover {
        border-color: #3b82f6;
        background-color: rgba(59, 130, 246, 0.05);
    }
    
    .photo-upload-container input[type="file"] {
        position: absolute;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        opacity: 0;
        cursor: pointer;
    }
    
    .photo-upload-icon {
        font-size: 2.5rem;
        color: #6b7280;
        margin-bottom: 15px;
        transition: all 0.3s ease;
    }
    
    .photo-upload-container:hover .photo-upload-icon {
        color: #3b82f6;
        transform: translateY(-3px);
    }
    
    .photo-upload-text {
        font-weight: 500;
        color: #4b5563;
        margin-bottom: 5px;
    }
    
    .photo-upload-hint {
        font-size: 0.875rem;
        color: #6b7280;
    }
    
    .photo-preview {
        margin-top: 15px;
        border-radius: 6px;
        overflow: hidden;
        display: none;
        position: relative;
    }
    
    .photo-preview img {
        width: 100%;
        max-height: 200px;
        object-fit: contain;
        background-color: #f3f4f6;
    }
    
    .photo-remove {
        position: absolute;
        top: 10px;
        right: 10px;
        background-color: rgba(239, 68, 68, 0.9);
        color: white;
        border: none;
        border-radius: 50%;
        width: 30px;
        height: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    
    .photo-remove:hover {
        background-color: #dc2626;
        transform: scale(1.1);
    }
    
    /* Animations */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(15px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    @media (max-width: 768px) {
        .form-header {
            padding: 20px;
        }
        
        .form-body {
            padding: 20px;
        }
        
        .form-buttons {
            flex-direction: column-reverse;
            gap: 15px;
        }
        
        .btn {
            width: 100%;
        }
        
        .page-description {
            max-width: 100%;
        }
    }
</style>
@endpush

@section('content')
<div class="container py-4 complaint-page-container">
    <div class="page-header">
        <h1 class="page-title">Soumettre une plainte ou suggestion</h1>
        <p class="page-description">Utilisez ce formulaire pour soumettre vos remarques, préoccupations ou idées d'amélioration. Toutes les soumissions sont examinées par notre équipe.</p>
    </div>

    <div class="complaint-form-card" id="complaint-form-card">
        <div class="form-header neutral" id="form-header">
            <div class="icon-container">
                <i class="fas fa-comment-alt"></i>
            </div>
            <h2>Nouvelle soumission</h2>
        </div>
        
        <div class="form-body">
            @if ($errors->any())
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-circle"></i>
                <div>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
            @endif

            <form action="{{ route('etudiants.complaints.store') }}" method="POST" id="complaint-form" enctype="multipart/form-data">
                @csrf
                
                <div class="form-section">
                    <div class="section-label">
                        <i class="fas fa-tag"></i> Type de soumission
                    </div>
                    
                    <div class="type-toggle">
                        <label class="type-toggle-option plainte {{ old('type') == 'plainte' ? 'active' : '' }}" for="type-plainte">
                            <i class="fas fa-exclamation-circle"></i>
                            <span>Plainte</span>
                        </label>
                        <label class="type-toggle-option suggestion {{ old('type') == 'suggestion' ? 'active' : '' }}" for="type-suggestion">
                            <i class="fas fa-lightbulb"></i>
                            <span>Suggestion</span>
                        </label>
                    </div>
                    
                    <select class="visually-hidden" id="type" name="type" required>
                        <option value="">Sélectionnez un type</option>
                        <option value="plainte" id="type-plainte" {{ old('type') == 'plainte' ? 'selected' : '' }}>Plainte</option>
                        <option value="suggestion" id="type-suggestion" {{ old('type') == 'suggestion' ? 'selected' : '' }}>Suggestion</option>
                    </select>
                    
                    @error('type')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-section">
                    <div class="section-label">
                        <i class="fas fa-heading"></i> Sujet
                    </div>
                    
                    <div class="mb-3">
                        <input type="text" class="form-control @error('sujet') is-invalid @enderror" id="sujet" name="sujet" value="{{ old('sujet') }}" placeholder="Entrez un titre clair et concis" required>
                        @error('sujet')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="form-section">
                    <div class="section-label">
                        <i class="fas fa-align-left"></i> Contenu
                    </div>
                    
                    <div class="mb-3">
                        <textarea class="form-control @error('contenu') is-invalid @enderror" id="contenu" name="contenu" rows="6" placeholder="Décrivez votre plainte ou suggestion en détail..." required>{{ old('contenu') }}</textarea>
                        @error('contenu')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Soyez précis et incluez tous les détails pertinents pour faciliter le traitement de votre soumission.</div>
                    </div>
                </div>
                
                <div class="form-section" id="photo-upload-section" style="display: none;">
                    <div class="section-label">
                        <i class="fas fa-camera"></i> Preuve photo
                    </div>
                    
                    <div class="photo-upload-container" id="photo-upload-container">
                        <input type="file" name="photo" id="photo-input" accept="image/*" class="@error('photo') is-invalid @enderror">
                        <div class="photo-upload-icon">
                            <i class="fas fa-cloud-upload-alt"></i>
                        </div>
                        <div class="photo-upload-text">Cliquez ou déposez une image ici</div>
                        <div class="photo-upload-hint">JPEG, PNG, GIF - Max 2MB</div>
                        
                        <div class="photo-preview" id="photo-preview">
                            <img id="preview-image" src="#" alt="Aperçu de l'image">
                            <button type="button" class="photo-remove" id="remove-photo">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                    
                    @error('photo')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <div class="form-text mt-2">Ajouter une photo comme preuve peut aider à mieux comprendre votre plainte.</div>
                </div>
                
                <div class="form-section">
                    <div class="section-label">
                        <i class="fas fa-user-shield"></i> Visibilité
                    </div>
                    
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="is_anonymous" name="is_anonymous" value="1" {{ old('is_anonymous') ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_anonymous">Soumettre anonymement</label>
                    </div>
                    
                    <div class="anonymous-info">
                        <i class="fas fa-info-circle"></i>
                        <p>Si vous choisissez de soumettre anonymement, votre identité ne sera pas visible par les administrateurs qui traiteront votre soumission.</p>
                    </div>
                </div>
                
                <div class="form-buttons">
                    <a href="{{ route('etudiants.complaints.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left"></i> Retour à la liste
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-paper-plane"></i> Soumettre
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Gestion des boutons de type
        const plainteOption = document.querySelector('.type-toggle-option.plainte');
        const suggestionOption = document.querySelector('.type-toggle-option.suggestion');
        const typeSelect = document.getElementById('type');
        const formHeader = document.getElementById('form-header');
        const formCard = document.getElementById('complaint-form-card');
        const photoSection = document.getElementById('photo-upload-section');
        
        function updateTypeStyles() {
            const selectedValue = typeSelect.value;
            
            // Mettre à jour l'état actif des boutons
            plainteOption.classList.toggle('active', selectedValue === 'plainte');
            suggestionOption.classList.toggle('active', selectedValue === 'suggestion');
            
            // Mettre à jour la classe de l'en-tête
            formHeader.className = 'form-header ' + (selectedValue || 'neutral');
            
            // Changer l'icône et le texte de l'en-tête
            const iconContainer = formHeader.querySelector('.icon-container i');
            const headerTitle = formHeader.querySelector('h2');
            
            if (selectedValue === 'plainte') {
                iconContainer.className = 'fas fa-exclamation-circle';
                headerTitle.textContent = 'Nouvelle plainte';
                photoSection.style.display = 'block'; // Afficher la section de téléchargement de photo
            } else if (selectedValue === 'suggestion') {
                iconContainer.className = 'fas fa-lightbulb';
                headerTitle.textContent = 'Nouvelle suggestion';
                photoSection.style.display = 'none'; // Masquer la section de téléchargement de photo
            } else {
                iconContainer.className = 'fas fa-comment-alt';
                headerTitle.textContent = 'Nouvelle soumission';
                photoSection.style.display = 'none'; // Masquer la section de téléchargement de photo
            }
        }
        
        // Gestion de l'upload de photo
        const photoInput = document.getElementById('photo-input');
        const photoPreview = document.getElementById('photo-preview');
        const previewImage = document.getElementById('preview-image');
        const removePhotoButton = document.getElementById('remove-photo');
        
        photoInput.addEventListener('change', function(event) {
            if (this.files && this.files[0]) {
                const file = this.files[0];
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    previewImage.src = e.target.result;
                    photoPreview.style.display = 'block';
                }
                
                reader.readAsDataURL(file);
            }
        });
        
        removePhotoButton.addEventListener('click', function(event) {
            event.preventDefault();
            photoInput.value = '';
            photoPreview.style.display = 'none';
            previewImage.src = '#';
        });
        
        // Initialiser les styles basés sur la valeur actuelle
        updateTypeStyles();
        
        // Ajouter des écouteurs d'événements
        plainteOption.addEventListener('click', function() {
            typeSelect.value = 'plainte';
            updateTypeStyles();
        });
        
        suggestionOption.addEventListener('click', function() {
            typeSelect.value = 'suggestion';
            updateTypeStyles();
        });
        
        // Écouter les changements directs du select
        typeSelect.addEventListener('change', updateTypeStyles);
    });
</script>
@endpush
@endsection 