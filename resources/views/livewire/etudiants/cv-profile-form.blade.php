<div class="form-section">
    <div class="form-section-header">
        <h4>Informations Générales</h4>
        <button type="button" wire:click="save" class="action-button save-btn btn-sm">
            <i class="fas fa-save"></i> <span>Enregistrer</span>
        </button>
    </div>

    @if (session()->has('profile_form_message'))
        <div class="alert alert-success" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)">
            {{ session('profile_form_message') }}
        </div>
    @endif

    {{-- Champs standards (inchangés) --}}
    <div class="row profile-form-row">
        <div class="col-md-6 form-group">
            <label class="form-label">Nom Complet</label>
            <input type="text" class="form-control" value="{{ $etudiant->prenom ?? '' }} {{ $etudiant->nom ?? '' }}" readonly disabled>
        </div>
        <div class="col-md-6 form-group">
            <label for="profile_titre_{{ $componentId }}" class="form-label">Titre Profil CV <span style="color:red">*</span></label>
            <input type="text" id="profile_titre_{{ $componentId }}" wire:model.lazy="titre_profil" class="form-control @error('titre_profil') is-invalid @enderror" required>
            @error('titre_profil') <span class="invalid-feedback">{{ $message }}</span> @enderror
        </div>
    </div>
    <div class="row profile-form-row">
        <div class="col-md-6 form-group">
            <label for="profile_email_{{ $componentId }}" class="form-label">Email contact (CV)</label>
            <input type="email" id="profile_email_{{ $componentId }}" wire:model.lazy="email_cv" class="form-control @error('email_cv') is-invalid @enderror" placeholder="Par défaut: {{ $etudiant->email ?? '' }}">
            @error('email_cv') <span class="invalid-feedback">{{ $message }}</span> @enderror
        </div>
        <div class="col-md-6 form-group">
            <label for="profile_telephone_{{ $componentId }}" class="form-label">Téléphone (CV)</label>
            <input type="tel" id="profile_telephone_{{ $componentId }}" wire:model.lazy="telephone_cv" class="form-control @error('telephone_cv') is-invalid @enderror" placeholder="Par défaut: {{ $etudiant->telephone ?? '' }}">
            @error('telephone_cv') <span class="invalid-feedback">{{ $message }}</span> @enderror
        </div>
    </div>
     <div class="row profile-form-row">
        <div class="col-md-6 form-group">
            <label for="profile_adresse_{{ $componentId }}" class="form-label">Adresse / Ville</label>
            <input type="text" id="profile_adresse_{{ $componentId }}" wire:model.lazy="adresse" class="form-control @error('adresse') is-invalid @enderror">
            @error('adresse') <span class="invalid-feedback">{{ $message }}</span> @enderror
        </div>
        <div class="col-md-6 form-group">
            <label for="profile_linkedin_{{ $componentId }}" class="form-label">URL LinkedIn</label>
            <input type="url" id="profile_linkedin_{{ $componentId }}" wire:model.lazy="linkedin_url" class="form-control @error('linkedin_url') is-invalid @enderror" placeholder="https://linkedin.com/in/...">
            @error('linkedin_url') <span class="invalid-feedback">{{ $message }}</span> @enderror
        </div>
    </div>
     <div class="row profile-form-row">
        <div class="col-md-6 form-group">
            <label for="profile_portfolio_{{ $componentId }}" class="form-label">URL Portfolio/Site/GitHub</label>
            <input type="url" id="profile_portfolio_{{ $componentId }}" wire:model.lazy="portfolio_url" class="form-control @error('portfolio_url') is-invalid @enderror" placeholder="https://votresite.com">
            @error('portfolio_url') <span class="invalid-feedback">{{ $message }}</span> @enderror
        </div>
        <div class="col-md-6 form-group">
            <label for="profile_photo_cv_{{ $componentId }}" class="form-label">Photo CV (Max 2Mo)</label>
            <input type="file" id="profile_photo_cv_{{ $componentId }}" wire:model="photo_cv" class="form-control @error('photo_cv') is-invalid @enderror" accept="image/png, image/jpeg, image/jpg">
             <div wire:loading wire:target="photo_cv" style="font-size: 0.8em; color: var(--primary-color); margin-top: 5px;">Téléversement...</div>
            @error('photo_cv') <span class="invalid-feedback">{{ $message }}</span> @enderror
            <div style="margin-top: 10px;">
                 @if ($photo_cv) <img src="{{ $photo_cv->temporaryUrl() }}" alt="Aperçu" style="max-width: 60px; height: 60px; border-radius: 50%; object-fit: cover;">
                 @elseif ($photo_cv_path) <img src="{{ Storage::url($photo_cv_path) }}" alt="Photo CV" style="max-width: 60px; height: 60px; border-radius: 50%; object-fit: cover;">
                 @else <div style="width: 60px; height: 60px; border-radius: 50%; background-color: #e0e0e0; display:flex; align-items:center; justify-content:center; color: #aaa;"><i class="fas fa-user fa-2x"></i></div>
                 @endif
            </div>
        </div>
    </div>

    {{-- Ajout des nouveaux champs personnels --}}
    <div class="row profile-form-row">
        <div class="col-md-6 form-group">
            <label for="profile_sit_mat_{{ $componentId }}" class="form-label">Situation Matrimoniale</label>
            <select id="profile_sit_mat_{{ $componentId }}" wire:model.lazy="situation_matrimoniale" class="form-control @error('situation_matrimoniale') is-invalid @enderror">
                <option value="">-- Choisir --</option>
                <option value="Célibataire">Célibataire</option>
                <option value="Marié(e)">Marié(e)</option>
                <option value="Divorcé(e)">Divorcé(e)</option>
                <option value="Veuf(ve)">Veuf(ve)</option>
                <option value="Autre">Autre</option>
            </select>
            @error('situation_matrimoniale') <span class="invalid-feedback">{{ $message }}</span> @enderror
        </div>
        <div class="col-md-6 form-group">
            <label for="profile_nationalite_{{ $componentId }}" class="form-label">Nationalité</label>
            <input type="text" id="profile_nationalite_{{ $componentId }}" wire:model.lazy="nationalite" class="form-control @error('nationalite') is-invalid @enderror">
            @error('nationalite') <span class="invalid-feedback">{{ $message }}</span> @enderror
        </div>
    </div>
    <div class="row profile-form-row">
        <div class="col-md-6 form-group">
            <label for="profile_date_nais_{{ $componentId }}" class="form-label">Date de Naissance</label>
            <input type="date" id="profile_date_nais_{{ $componentId }}" wire:model.lazy="date_naissance" class="form-control @error('date_naissance') is-invalid @enderror">
            @error('date_naissance') <span class="invalid-feedback">{{ $message }}</span> @enderror
        </div>
        <div class="col-md-6 form-group">
            <label for="profile_lieu_nais_{{ $componentId }}" class="form-label">Lieu de Naissance</label>
            <input type="text" id="profile_lieu_nais_{{ $componentId }}" wire:model.lazy="lieu_naissance" class="form-control @error('lieu_naissance') is-invalid @enderror">
            @error('lieu_naissance') <span class="invalid-feedback">{{ $message }}</span> @enderror
        </div>
    </div>

    {{-- Remplacement de Trix par Textarea --}}
    <div class="form-group">
        <label for="resume_profil_textarea_{{ $componentId }}" class="form-label">Résumé du Profil</label>
        <textarea id="resume_profil_textarea_{{ $componentId }}"
                  wire:model.lazy="resume_profil"
                  class="form-control @error('resume_profil') is-invalid @enderror"
                  rows="5" {{-- Ajuster si besoin --}}
                  placeholder="Décrivez brièvement votre objectif professionnel, vos points forts...">{{ $resume_profil }}</textarea>
                  {{-- Le contenu est dans la balise pour textarea --}}
        @error('resume_profil') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
    </div>

</div>

<style>
/* Style additionnel pour ce composant si nécessaire */
.profile-form-row .form-group {
    margin-bottom: 1rem; /* Espace par défaut */
}

@media (max-width: 767.98px) {
    .profile-form-row .form-group {
        margin-bottom: 0.75rem; /* Espace légèrement réduit sur mobile quand empilé */
    }
    /* Réduire la marge sous les lignes sur mobile */
    .profile-form-row {
         margin-bottom: 0.5rem; /* Moins d'espace entre les lignes empilées */
    }
    .form-section-header {
         flex-direction: column;
         align-items: flex-start;
         gap: 0.5rem;
     }
}
</style>