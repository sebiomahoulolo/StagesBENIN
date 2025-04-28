@extends('layouts.etudiant.app')

@section('title', 'Postuler à ' . $offre->titre)

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Postuler à l'offre</h5>
                        <a href="{{ route('etudiants.offres.show', $offre->id) }}" class="btn btn-sm btn-outline-secondary">
                            <i class="fas fa-arrow-left me-1"></i> Retour aux détails
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Informations sur l'offre -->
                    <div class="alert alert-info mb-4">
                        <h6 class="alert-heading">Vous postulez à :</h6>
                        <p class="mb-0"><strong>{{ $offre->titre }}</strong> chez <strong>{{ $offre->entreprise->nom ?? 'Entreprise non spécifiée' }}</strong></p>
                    </div>
                    
                    <!-- Formulaire de candidature -->
                    <form action="{{ route('etudiants.offres.soumettre-candidature', $offre->id) }}" method="POST" enctype="multipart/form-data" id="candidatureForm">
                        @csrf
                        
                        <div class="row">
                            <!-- Informations personnelles -->
                            <div class="col-md-6 mb-4">
                                <h5 class="mb-3">Informations personnelles</h5>
                                
                                <div class="mb-3">
                                    <label for="nom" class="form-label">Nom</label>
                                    <input type="text" class="form-control" id="nom" value="{{ Auth::user()->etudiant->nom ?? '' }}" readonly>
                                    <small class="text-muted">Ces informations sont pré-remplies à partir de votre profil.</small>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="prenom" class="form-label">Prénom</label>
                                    <input type="text" class="form-control" id="prenom" value="{{ Auth::user()->etudiant->prenom ?? '' }}" readonly>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" value="{{ Auth::user()->email }}" readonly>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="telephone" class="form-label">Téléphone</label>
                                    <input type="text" class="form-control" id="telephone" value="{{ Auth::user()->etudiant->telephone ?? '' }}" readonly>
                                </div>
                            </div>
                            
                            <!-- Documents de candidature -->
                            <div class="col-md-6 mb-4">
                                <h5 class="mb-3">Documents de candidature</h5>
                                
                                <div class="mb-3">
                                    <label for="cv" class="form-label">CV (PDF, DOC, DOCX) <span class="text-danger">*</span></label>
                                    <input type="file" class="form-control @error('cv') is-invalid @enderror" id="cv" name="cv" required>
                                    <div class="form-text">Format accepté : PDF, DOC, DOCX. Taille maximale : 2 Mo.</div>
                                    @error('cv')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label for="lettre_motivation" class="form-label">Lettre de motivation <span class="text-danger">*</span></label>
                                    <textarea class="form-control @error('lettre_motivation') is-invalid @enderror" id="lettre_motivation" name="lettre_motivation" rows="6" required>{{ old('lettre_motivation') }}</textarea>
                                    <div class="form-text">Minimum 100 caractères.</div>
                                    @error('lettre_motivation')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <!-- Bouton de soumission -->
                        <div class="text-center mt-4">
                            <button type="submit" class="btn btn-primary btn-lg" id="submitBtn">
                                <i class="fas fa-paper-plane me-2"></i> Soumettre ma candidature
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('candidatureForm');
        const submitBtn = document.getElementById('submitBtn');
        
        // Validation du formulaire avant soumission
        form.addEventListener('submit', function(event) {
            // Vérifier si un CV a été sélectionné
            const cvInput = document.getElementById('cv');
            if (!cvInput.files.length) {
                event.preventDefault();
                alert('Veuillez sélectionner un CV.');
                return;
            }
            
            // Vérifier la longueur de la lettre de motivation
            const lettreInput = document.getElementById('lettre_motivation');
            if (lettreInput.value.length < 100) {
                event.preventDefault();
                alert('Votre lettre de motivation doit contenir au moins 100 caractères.');
                return;
            }
            
            // Désactiver le bouton pour éviter les soumissions multiples
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Traitement en cours...';
        });
    });
</script>
@endpush 