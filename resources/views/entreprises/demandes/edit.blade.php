@extends('layouts.entreprises.master')

@section('title', 'Modifier la demande - StagesBENIN')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/shared-styles.css') }}">
<style>
    .form-section {
        background: white;
        border-radius: 0.5rem;
        padding: 1.75rem;
        margin-bottom: 1.75rem;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        border: 1px solid #edf2f7;
    }
    
    .section-title {
        font-size: 1.25rem;
        color: #1f2937;
        margin-bottom: 1.5rem;
        padding-bottom: 0.75rem;
        border-bottom: 1px solid #e5e7eb;
        font-weight: 600;
    }
    
    .form-label {
        font-weight: 500;
        margin-bottom: 0.5rem;
        display: block;
        color: #374151;
    }
    
    .form-control {
        width: 100%;
        padding: 0.625rem 0.875rem;
        border: 1px solid #d1d5db;
        border-radius: 0.375rem;
        font-size: 0.95rem;
    }
    
    .form-control:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        outline: none;
    }

    .row {
        display: flex;
        flex-wrap: wrap;
        margin-left: -0.75rem;
        margin-right: -0.75rem;
    }

    .col-md-6, .col-md-12, .col-12 {
        padding-left: 0.75rem;
        padding-right: 0.75rem;
        margin-bottom: 1.25rem;
    }

    .col-12, .col-md-12 {
        width: 100%;
    }

    .col-md-6 {
        width: 50%;
    }

    .form-help-text {
        font-size: 0.875rem;
        color: #64748b;
        margin-top: 0.35rem;
    }
    
    .competences-container {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
        margin-top: 0.75rem;
        min-height: 2.5rem;
        padding: 0.25rem 0;
    }
    
    .competence-tag {
        background: #f3f4f6;
        border: 1px solid #e5e7eb;
        border-radius: 2rem;
        padding: 0.35rem 0.75rem;
        font-size: 0.875rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .competence-tag button {
        background: none;
        border: none;
        padding: 0;
        color: #ef4444;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 18px;
        height: 18px;
    }
    
    .custom-btn {
        padding: 0.625rem 1.25rem;
        border-radius: 0.375rem;
        font-weight: 500;
        transition: all 0.2s ease;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
    }
    
    .custom-btn-primary {
        background-color: #3b82f6;
        color: white;
        border: none;
    }
    
    .custom-btn-primary:hover {
        background-color: #2563eb;
        transform: translateY(-1px);
    }
    
    .btn-light {
        background-color: #f3f4f6;
        color: #4b5563;
        border: 1px solid #d1d5db;
        padding: 0.625rem 1.25rem;
        border-radius: 0.375rem;
        font-weight: 500;
        cursor: pointer;
    }
    
    .btn-light:hover {
        background-color: #e5e7eb;
    }
    
    .content-header {
        margin-bottom: 1.5rem;
    }
    
    .h2 {
        font-size: 1.5rem;
        font-weight: 600;
        color: #111827;
        margin: 0;
    }
    
    .input-group {
        display: flex;
        margin-bottom: 0.5rem;
    }
    
    .input-group .form-control {
        border-top-right-radius: 0;
        border-bottom-right-radius: 0;
        flex: 1;
    }
    
    .input-group .btn {
        border-top-left-radius: 0;
        border-bottom-left-radius: 0;
        padding-left: 0.875rem;
        padding-right: 0.875rem;
    }
    
    .btn-primary {
        background-color: #3b82f6;
        color: white;
        border: none;
        cursor: pointer;
    }
    
    .btn-primary:hover {
        background-color: #2563eb;
    }
    
    .card-body {
        padding: 2rem;
    }
    
    .justify-content-end {
        display: flex;
        justify-content: flex-end;
    }
    
    .gap-2 {
        gap: 0.75rem;
    }
    
    .invalid-feedback {
        color: #ef4444;
        font-size: 0.875rem;
        margin-top: 0.25rem;
        display: block;
    }
    
    textarea.form-control {
        min-height: 6rem;
        resize: vertical;
    }
    
    .btn-outline-secondary {
        color: #64748b;
        border: 1px solid #cbd5e1;
        background-color: transparent;
        padding: 0.625rem 1.25rem;
        border-radius: 0.375rem;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        transition: all 0.2s;
    }
    
    .btn-outline-secondary:hover {
        background-color: #f1f5f9;
        color: #475569;
    }
    
    .me-2 {
        margin-right: 0.5rem;
    }
    
    .d-flex {
        display: flex;
    }
    
    .justify-content-between {
        justify-content: space-between;
    }
    
    .align-items-center {
        align-items: center;
    }
    
    @media (max-width: 768px) {
        .col-md-6 {
            width: 100%;
        }
        
        .form-section {
            padding: 1.25rem;
            margin-bottom: 1.25rem;
            border-radius: 0.375rem;
        }
        
        .section-title {
            font-size: 1.125rem;
            margin-bottom: 1.25rem;
            padding-bottom: 0.625rem;
        }
        
        .row {
            margin-left: -0.5rem;
            margin-right: -0.5rem;
        }
        
        .col-md-6, .col-md-12, .col-12 {
            padding-left: 0.5rem;
            padding-right: 0.5rem;
            margin-bottom: 1rem;
        }
        
        .card-body {
            padding: 1.25rem;
        }
    }
</style>
@endpush

@section('content')
<div class="content-header">
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="h2">Modifier la demande</h1>
        <a href="{{ route('entreprises.demandes.show', $demande) }}" class="btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Retour aux détails
        </a>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="custom-card fade-in">
            <div class="card-body">
                <form action="{{ route('entreprises.demandes.update', $demande) }}" method="POST" class="needs-validation" novalidate>
                    @csrf
                    @method('PUT')
                    
                    <div class="form-section mb-4">
                        <h3 class="section-title">Type de demande</h3>
                        
                        <div class="row">
                            <div class="col-md-12">
                                <label for="type_demande" class="form-label">Type de demande *</label>
                                <select class="form-control @error('type_demande') is-invalid @enderror" 
                                        id="type_demande" name="type_demande" required>
                                    <option value="">Sélectionnez un type</option>
                                    <option value="employe" {{ old('type_demande', $demande->type === 'emploi' ? 'employe' : '') === 'employe' ? 'selected' : '' }}>Employé</option>
                                    <option value="stagiaire" {{ old('type_demande', $demande->type === 'stage' ? 'stagiaire' : '') === 'stagiaire' ? 'selected' : '' }}>Stagiaire</option>
                                </select>
                                @error('type_demande')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-section mb-4">
                        <h3 class="section-title">Informations du poste</h3>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <label for="poste" class="form-label">Poste recherché *</label>
                                <input type="text" class="form-control @error('poste') is-invalid @enderror" 
                                       id="poste" name="poste" value="{{ old('poste', $demande->titre) }}" required>
                                @error('poste')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6">
                                <label for="nombre_postes" class="form-label">Nombre de postes *</label>
                                <input type="number" class="form-control @error('nombre_postes') is-invalid @enderror" 
                                       id="nombre_postes" name="nombre_postes" value="{{ old('nombre_postes', $demande->nombre_postes) }}" min="1" required>
                                @error('nombre_postes')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6">
                                <label for="type_contrat" class="form-label">Type de contrat *</label>
                                <select class="form-control @error('type_contrat') is-invalid @enderror" 
                                        id="type_contrat" name="type_contrat" required>
                                    <option value="">Sélectionnez un type</option>
                                    <option value="CDI" {{ old('type_contrat', $demande->type_contrat) === 'CDI' ? 'selected' : '' }}>CDI</option>
                                    <option value="CDD" {{ old('type_contrat', $demande->type_contrat) === 'CDD' ? 'selected' : '' }}>CDD</option>
                                    <option value="Stage" {{ old('type_contrat', $demande->type_contrat) === 'Stage' ? 'selected' : '' }}>Stage</option>
                                    <option value="Freelance" {{ old('type_contrat', $demande->type_contrat) === 'Freelance' ? 'selected' : '' }}>Freelance</option>
                                </select>
                                @error('type_contrat')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6">
                                <label for="domaine" class="form-label">Domaine</label>
                                <input type="text" class="form-control @error('domaine') is-invalid @enderror" 
                                       id="domaine" name="domaine" value="{{ old('domaine', $demande->domaine) }}">
                                @error('domaine')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-12">
                                <label for="description_poste" class="form-label">Description du poste *</label>
                                <textarea class="form-control @error('description_poste') is-invalid @enderror" 
                                          id="description_poste" name="description_poste" rows="4" required>{{ old('description_poste', $demande->description) }}</textarea>
                                @error('description_poste')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-help-text">
                                    Décrivez les responsabilités, les missions et le contexte du poste.
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-section mb-4">
                        <h3 class="section-title">Profil recherché</h3>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <label for="niveau_etude" class="form-label">Niveau d'études requis *</label>
                                <select class="form-control @error('niveau_etude') is-invalid @enderror" 
                                        id="niveau_etude" name="niveau_etude" required>
                                    <option value="">Sélectionnez un niveau</option>
                                    <option value="Bac" {{ old('niveau_etude', $demande->niveau_etude) === 'Bac' ? 'selected' : '' }}>Bac</option>
                                    <option value="Bac+2" {{ old('niveau_etude', $demande->niveau_etude) === 'Bac+2' ? 'selected' : '' }}>Bac+2</option>
                                    <option value="Bac+3" {{ old('niveau_etude', $demande->niveau_etude) === 'Bac+3' ? 'selected' : '' }}>Bac+3</option>
                                    <option value="Bac+4" {{ old('niveau_etude', $demande->niveau_etude) === 'Bac+4' ? 'selected' : '' }}>Bac+4</option>
                                    <option value="Bac+5" {{ old('niveau_etude', $demande->niveau_etude) === 'Bac+5' ? 'selected' : '' }}>Bac+5</option>
                                </select>
                                @error('niveau_etude')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6">
                                <label for="experience_requise" class="form-label">Expérience requise *</label>
                                <select class="form-control @error('experience_requise') is-invalid @enderror" 
                                        id="experience_requise" name="experience_requise" required>
                                    <option value="">Sélectionnez une expérience</option>
                                    <option value="Débutant" {{ old('experience_requise', $demande->niveau_experience) === 'Débutant' ? 'selected' : '' }}>Débutant</option>
                                    <option value="1-2 ans" {{ old('experience_requise', $demande->niveau_experience) === '1-2 ans' ? 'selected' : '' }}>1-2 ans</option>
                                    <option value="3-5 ans" {{ old('experience_requise', $demande->niveau_experience) === '3-5 ans' ? 'selected' : '' }}>3-5 ans</option>
                                    <option value="5-10 ans" {{ old('experience_requise', $demande->niveau_experience) === '5-10 ans' ? 'selected' : '' }}>5-10 ans</option>
                                    <option value="10+ ans" {{ old('experience_requise', $demande->niveau_experience) === '10+ ans' ? 'selected' : '' }}>10+ ans</option>
                                </select>
                                @error('experience_requise')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-12">
                                <label for="competences" class="form-label">Compétences requises *</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="competence-input" 
                                           placeholder="Ajouter une compétence">
                                    <button type="button" class="btn btn-primary" id="add-competence">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                                <div class="competences-container" id="competences-container"></div>
                                <input type="hidden" name="competences_requises" id="competences-hidden" value="{{ old('competences_requises', $demande->competences_requises) }}">
                                @error('competences_requises')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-section mb-4">
                        <h3 class="section-title">Conditions</h3>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <label for="salaire_propose" class="form-label">Rémunération (FCFA) *</label>
                                <input type="number" class="form-control @error('salaire_propose') is-invalid @enderror" 
                                       id="salaire_propose" name="salaire_propose" value="{{ old('salaire_propose', $demande->salaire_min) }}" required>
                                @error('salaire_propose')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6">
                                <label for="lieu_travail" class="form-label">Lieu de travail *</label>
                                <input type="text" class="form-control @error('lieu_travail') is-invalid @enderror" 
                                       id="lieu_travail" name="lieu_travail" value="{{ old('lieu_travail', $demande->lieu) }}" required>
                                @error('lieu_travail')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6">
                                <label for="date_debut_souhaitee" class="form-label">Date de début souhaitée *</label>
                                <input type="date" class="form-control @error('date_debut_souhaitee') is-invalid @enderror" 
                                       id="date_debut_souhaitee" name="date_debut_souhaitee" value="{{ old('date_debut_souhaitee', $demande->date_debut ? $demande->date_debut->format('Y-m-d') : '') }}" required>
                                @error('date_debut_souhaitee')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="justify-content-end gap-2" style="display: flex; margin-top: 1.5rem;">
                        <button type="button" onclick="window.history.back()" class="btn-light">Annuler</button>
                        <button type="submit" class="custom-btn custom-btn-primary">
                            <i class="fas fa-save me-2"></i>Enregistrer les modifications
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Gestion des compétences
    const competenceInput = document.getElementById('competence-input');
    const addCompetenceBtn = document.getElementById('add-competence');
    const competencesContainer = document.getElementById('competences-container');
    const competencesHidden = document.getElementById('competences-hidden');
    let competences = [];

    // Charger les compétences existantes
    if (competencesHidden.value) {
        try {
            competences = JSON.parse(competencesHidden.value);
            renderCompetences();
        } catch (e) {
            console.error("Erreur lors du parsing des compétences:", e);
        }
    }

    addCompetenceBtn.addEventListener('click', () => {
        addCompetence();
    });
    
    competenceInput.addEventListener('keypress', (e) => {
        if (e.key === 'Enter') {
            e.preventDefault();
            addCompetence();
        }
    });

    function addCompetence() {
        const competence = competenceInput.value.trim();
        if (competence && !competences.includes(competence)) {
            competences.push(competence);
            competencesHidden.value = JSON.stringify(competences);
            renderCompetences();
            competenceInput.value = '';
        }
    }

    function renderCompetences() {
        competencesContainer.innerHTML = competences.map(competence => `
            <div class="competence-tag">
                ${competence}
                <button type="button" onclick="removeCompetence('${competence.replace("'", "\\'")}')">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        `).join('');
    }

    function removeCompetence(competence) {
        competences = competences.filter(c => c !== competence);
        competencesHidden.value = JSON.stringify(competences);
        renderCompetences();
    }

    // Validation du formulaire
    (function() {
        'use strict';
        const form = document.querySelector('.needs-validation');
        
        form.addEventListener('submit', function(event) {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
            
            // Vérification supplémentaire pour les compétences
            if (competences.length === 0) {
                event.preventDefault();
                alert("Veuillez ajouter au moins une compétence requise.");
            }
            
            form.classList.add('was-validated');
        });
    })();
</script>
@endpush