{{-- /resources/views/etudiants/profile/edit.blade.php --}}

@extends('layouts.etudiant.app')

@section('title', 'Édition du profil - StagesBENIN')

@push('styles')
<style>
    .profile-section {
        background-color: #fff;
        border-radius: 12px;
        padding: 2rem;
        box-shadow: 0 4px 15px rgba(0,0,0,0.08);
        margin-bottom: 2rem;
    }
    .photo-preview-container {
        width: 150px;
        height: 150px;
        margin-bottom: 1rem;
        position: relative;
        border-radius: 50%;
        overflow: hidden;
        border: 3px solid #0d6efd;
        margin: 0 auto 1rem auto;
    }
    .photo-preview {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 50%;
    }
    .photo-placeholder {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: #e9ecef;
        color: #6c757d;
        font-size: 3rem;
    }
    .photo-upload-zone {
        border: 2px dashed #ced4da;
        padding: 2rem;
        text-align: center;
        border-radius: 8px;
        transition: all 0.3s ease;
        background-color: #f8f9fa;
        margin-bottom: 1.5rem;
        cursor: pointer;
    }
    .photo-upload-zone:hover {
        border-color: #0d6efd;
        background-color: rgba(13, 110, 253, 0.05);
    }
</style>
@endpush

@section('content')
<div class="container py-4">
    <h1 class="mb-4">Édition du profil</h1>

    <div class="row">
        <div class="col-md-4">
            <div class="profile-section">
                <h3 class="mb-4">Photo de profil</h3>
                
                <div class="photo-preview-container" id="photoPreviewContainer">
                    @if($etudiant->photo_path)
                        <img src="{{ Storage::url($etudiant->photo_path) }}" alt="Photo de profil" class="photo-preview" id="photoPreview">
                    @else
                        <div class="photo-placeholder">
                            <i class="fas fa-user"></i>
                        </div>
                    @endif
                </div>

                <form action="{{ route('etudiants.profile.photo') }}" method="POST" enctype="multipart/form-data" id="photoForm">
                    @csrf
                    <div class="photo-upload-zone" onclick="document.getElementById('photo').click()">
                        <i class="fas fa-camera mb-2" style="font-size: 2rem; color: #0d6efd"></i>
                        <p class="mb-0">Cliquez ou glissez une photo ici</p>
                        <input type="file" name="photo" id="photo" accept="image/*" style="display: none">
                    </div>
                    <button type="submit" class="btn btn-primary w-100" id="uploadButton" disabled>
                        <i class="fas fa-upload me-2"></i>Télécharger la photo
                    </button>
                </form>
            </div>
        </div>

        <div class="col-md-8">
            <div class="profile-section">
                <h3 class="mb-4">Informations personnelles</h3>
                <form action="{{ route('etudiants.profile.update-info') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="telephone" class="form-label">Téléphone</label>
                        <input type="tel" class="form-control @error('telephone') is-invalid @enderror" 
                               id="telephone" name="telephone" value="{{ old('telephone', $etudiant->telephone) }}">
                        @error('telephone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="formation" class="form-label">Formation</label>
                        <input type="text" class="form-control @error('formation') is-invalid @enderror" 
                               id="formation" name="formation" value="{{ old('formation', $etudiant->formation) }}">
                        @error('formation')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="niveau" class="form-label">Niveau</label>
                        <input type="text" class="form-control @error('niveau') is-invalid @enderror" 
                               id="niveau" name="niveau" value="{{ old('niveau', $etudiant->niveau) }}">
                        @error('niveau')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="date_naissance" class="form-label">Date de naissance</label>
                        <input type="date" class="form-control @error('date_naissance') is-invalid @enderror" 
                               id="date_naissance" name="date_naissance" 
                               value="{{ old('date_naissance', $etudiant->date_naissance ? $etudiant->date_naissance->format('Y-m-d') : '') }}">
                        @error('date_naissance')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Enregistrer les modifications
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const photoInput = document.getElementById('photo');
    const photoPreviewContainer = document.getElementById('photoPreviewContainer');
    const uploadButton = document.getElementById('uploadButton');
    
    photoInput.addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const img = document.createElement('img');
                img.src = e.target.result;
                img.classList.add('photo-preview');
                img.id = 'photoPreview';
                
                // Remplacer le contenu actuel par la nouvelle image
                photoPreviewContainer.innerHTML = '';
                photoPreviewContainer.appendChild(img);
                
                // Activer le bouton d'upload
                uploadButton.disabled = false;
            }
            reader.readAsDataURL(file);
        }
    });
});
</script>
@endpush