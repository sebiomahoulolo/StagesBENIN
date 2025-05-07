@extends('layouts.admin.app')

@section('title', 'Détails Demande : ' . $demande->titre)

@push('styles')
<style>
    body {
        /* background-color: #f4f6f9; */
    }

    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid #e5e7eb;
    }

    .page-title {
        font-size: 1.875rem;
        font-weight: 700;
        color: #1f2937;
    }
    .page-subtitle {
        font-size: 0.875rem;
        color: #6b7280;
        margin-top: 0.25rem;
    }

    .content-wrapper {
        background-color: #ffffff;
        border-radius: 0.75rem;
        box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1), 0 2px 4px -1px rgba(0,0,0,0.06);
        overflow: hidden;
    }

    .section {
        padding: 1.5rem;
    }
    .section:not(:last-child) {
        border-bottom: 1px solid #e5e7eb;
    }

    .section-title {
        font-size: 1.125rem; /* text-lg, un peu plus petit pour les sections internes */
        font-weight: 600;
        color: #111827;
        margin-bottom: 1.25rem; /* Plus d'espace après le titre de section */
        /* padding-bottom: 0.75rem; */ /* Optionnel: bordure sous les titres de section */
        /* border-bottom: 1px solid #f3f4f6; */
    }

    .info-grid {
        display: grid;
        grid-template-columns: repeat(1, 1fr);
        gap: 1.25rem; /* Ajustement du gap */
    }
    @media (min-width: 768px) {
        .info-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }
    /* Grille spécifique pour les descriptions/compétences */
    .description-grid {
        display: grid;
        grid-template-columns: repeat(1, 1fr);
        gap: 1.5rem;
    }
     @media (min-width: 1024px) { /* lg: */
        .description-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }


    .info-item label {
        display: block;
        font-size: 0.875rem;
        font-weight: 500;
        color: #4b5563;
        margin-bottom: 0.375rem; /* Espace accru */
    }
    .info-item p, .info-item .badge-display, .info-item .description-box {
        font-size: 0.9375rem;
        color: #1f2937;
        background-color: #f9fafb;
        padding: 0.625rem 0.875rem; /* Padding ajusté */
        border-radius: 0.375rem;
        border: 1px solid #e5e7eb;
        min-height: 40px;
        display: flex;
        align-items: center;
        word-break: break-word; /* Empêcher le débordement de texte long */
    }
    .info-item .description-box {
        white-space: pre-line;
        line-height: 1.6;
        align-items: flex-start; /* Pour que le texte commence en haut */
        min-height: 100px; /* Hauteur minimale pour les descriptions */
    }


    .status-badge {
        display: inline-flex;
        align-items: center;
        padding: 0.25rem 0.75rem;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 500;
        text-transform: capitalize;
    }
    .status-en_attente { background-color: #fef3c7; color: #92400e; }
    .status-approuvee { background-color: #d1fae5; color: #065f46; }
    .status-rejetee { background-color: #fee2e2; color: #991b1b; }
    .status-en_cours { background-color: #dbeafe; color: #1e40af; }


    .action-form select, .action-form textarea {
        display: block;
        width: 100%;
        border-radius: 0.375rem;
        border-color: #d1d5db;
        box-shadow: 0 1px 2px 0 rgba(0,0,0,0.05);
        padding: 0.5rem 0.75rem;
    }
    .action-form select:focus, .action-form textarea:focus {
        border-color: #3b82f6;
        outline: 2px solid transparent;
        outline-offset: 2px;
        --tw-ring-color: #3b82f6;
        box-shadow: 0 0 0 3px var(--tw-ring-color);
    }

    .btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0.625rem 1.25rem; /* py-2.5 px-5 pour des boutons plus grands */
        border-radius: 0.375rem;
        font-weight: 500;
        transition: background-color 0.15s ease-in-out;
        border: 1px solid transparent;
        font-size: 0.875rem; /* text-sm */
    }
    .btn-secondary {
        background-color: #6b7280; color: white;
    }
    .btn-secondary:hover { background-color: #4b5563; }
    .btn-success {
        background-color: #16a34a; color: white;
    }
    .btn-success:hover { background-color: #15803d; }
    .btn-danger {
        background-color: #dc2626; color: white;
    }
    .btn-danger:hover { background-color: #b91c1c; }

    .alert-flash {
        padding: 1rem; margin-bottom: 1.5rem; border-radius: 0.5rem; display: flex; align-items: center;
    }
    .alert-flash i { margin-right: 0.75rem; font-size: 1.25rem; }
    .alert-flash-success { background-color: #ecfdf5; border: 1px solid #a7f3d0; color: #059669; }
    .alert-flash-error { background-color: #fff5f5; border: 1px solid #fecaca; color: #c53030; }

    ul.list-disc { padding-left: 1.25rem; } /* Pour les compétences */
    ul.list-disc li { margin-bottom: 0.25rem; }

</style>
@endpush

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="page-header">
        <div>
            <h1 class="page-title">Détails de la Demande</h1>
            <p class="page-subtitle">
                Soumise par :
                <a href="#" class="text-blue-600 hover:text-blue-800 font-semibold">
                    {{ $demande->entreprise->nom ?? 'N/A' }}
                </a>
                (ID Demande: {{ $demande->id }})
            </p>
        </div>
        <a href="{{ route('admin.demandes.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left mr-2"></i>Retour à la liste
        </a>
    </div>

    @if(session('success'))
        <div class="alert-flash alert-flash-success" role="alert">
            <i class="fas fa-check-circle"></i>
            <div>
                <p class="font-bold">Succès!</p>
                <p>{{ session('success') }}</p>
            </div>
        </div>
    @endif
    @if(session('error'))
        <div class="alert-flash alert-flash-error" role="alert">
            <i class="fas fa-exclamation-triangle"></i>
             <div>
                <p class="font-bold">Erreur!</p>
                <p>{{ session('error') }}</p>
            </div>
        </div>
    @endif

    <div class="content-wrapper">
        {{-- Section Statut --}}
        <div class="section">
            <div class="flex flex-col sm:flex-row justify-between sm:items-center gap-2">
                <h2 class="section-title !border-b-0 !pb-0 !mb-0">Statut Actuel</h2>
                <span class="status-badge status-{{ $demande->statut }} self-start sm:self-center">
                    {{ str_replace('_', ' ', $demande->statut) }}
                </span>
            </div>
             @if($demande->statut === 'rejetee' && $demande->motif_rejet)
                <div class="mt-3 bg-red-50 p-4 rounded-md border border-red-200">
                    <p class="text-sm font-medium text-red-800"><i class="fas fa-info-circle mr-2"></i>Motif du rejet :</p>
                    <p class="text-sm text-red-700 mt-1">{{ $demande->motif_rejet }}</p>
                </div>
            @endif
            <p class="text-xs text-gray-500 mt-2">
                @if($demande->admin_id && $demande->admin)
                    Traité par : <span class="font-medium">{{ $demande->admin->name }}</span> le {{ $demande->updated_at->format('d/m/Y à H:i') }}
                @else
                    Soumis le : {{ $demande->created_at->format('d/m/Y à H:i') }}
                @endif
            </p>
        </div>

        {{-- Informations Générales --}}
        <div class="section">
            <h3 class="section-title">Informations Générales</h3>
            <div class="info-grid">
                <div class="info-item">
                    <label>Type de demande</label>
                    <p class="badge-display">
                        <span class="status-badge {{ $demande->type === 'emploi' ? 'bg-sky-100 text-sky-700' : 'bg-teal-100 text-teal-700' }}">
                            {{ ucfirst($demande->type) }}
                        </span>
                    </p>
                </div>
                <div class="info-item">
                    <label>Poste Recherché</label>
                    <p>{{ $demande->titre }}</p>
                </div>
                <div class="info-item">
                    <label>Nombre de postes</label>
                    <p>{{ $demande->nombre_postes }}</p>
                </div>
                <div class="info-item">
                    <label>Niveau d'études requis</label>
                    <p>{{ $demande->niveau_etude }}</p>
                </div>
                 <div class="info-item">
                    <label>Domaine</label>
                    <p>{{ $demande->domaine ?? 'Non spécifié' }}</p>
                </div>
                <div class="info-item">
                    <label>Expérience requise</label>
                    <p>{{ $demande->niveau_experience ?? 'Non spécifiée' }}</p>
                </div>
            </div>
        </div>

        {{-- Détails du Contrat et Conditions --}}
        <div class="section">
            <h3 class="section-title">Détails du Contrat et Conditions</h3>
            <div class="info-grid">
                <div class="info-item">
                    <label>Type de contrat</label>
                    <p>{{ $demande->type_contrat }}</p>
                </div>
                <div class="info-item">
                    <label>Lieu de travail</label>
                    <p>{{ $demande->lieu }}</p>
                </div>
                <div class="info-item">
                    <label>Date de début souhaitée</label>
                    <p>{{ $demande->date_debut ? $demande->date_debut->isoFormat('LL') : 'Non spécifiée' }}</p> {{-- Format localisé --}}
                </div>
                <div class="info-item">
                    <label>Rémunération (min)</label>
                    <p>{{ $demande->salaire_min ? number_format($demande->salaire_min, 0, ',', ' ') . ' FCFA' : 'Non spécifiée' }}</p>
                </div>
                 @if($demande->salaire_max)
                    <div class="info-item">
                        <label>Rémunération (max)</label>
                        <p>{{ number_format($demande->salaire_max, 0, ',', ' ') }} FCFA</p>
                    </div>
                @endif
                 @if($demande->date_limite)
                    <div class="info-item">
                        <label>Date limite de candidature</label>
                        <p>{{ $demande->date_limite->isoFormat('LL') }}</p> {{-- Format localisé --}}
                    </div>
                @endif
            </div>
        </div>

        {{-- Description et Compétences --}}
        <div class="section">
            <div class="description-grid">
                <div>
                    <h3 class="section-title !mb-3">Description du Poste</h3>
                    <div class="info-item !p-0 !bg-transparent !border-none">
                        <p class="description-box !p-4 !bg-gray-50 !border !border-gray-200">
                            {!! nl2br(e($demande->description)) !!}
                        </p>
                    </div>
                </div>
                <div>
                    <h3 class="section-title !mb-3">Compétences Requises</h3>
                     <div class="info-item !p-0 !bg-transparent !border-none">
                        <div class="description-box !p-4 !bg-gray-50 !border !border-gray-200">
                            @if($demande->competences_requises)
                                @php
                                    try {
                                        $competences = json_decode($demande->competences_requises, false, 512, JSON_THROW_ON_ERROR);
                                    } catch (\JsonException $e) {
                                        $competences = null;
                                    }
                                @endphp
                                @if(is_array($competences) && !empty($competences))
                                    <ul class="list-disc list-inside">
                                        @foreach($competences as $competence)
                                            <li>{{ e($competence) }}</li>
                                        @endforeach
                                    </ul>
                                @elseif(is_string($demande->competences_requises))
                                    {{-- Si ce n'est pas un JSON valide mais une chaîne, on l'affiche --}}
                                    <p>{{ e($demande->competences_requises) }}</p>
                                @else
                                    <p class="text-gray-500">Non spécifiées</p>
                                @endif
                            @else
                                <p class="text-gray-500">Non spécifiées</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Informations supplémentaires (avantages, urgence) --}}
        @if((isset($demande->avantages_entreprise) && $demande->avantages_entreprise) || $demande->est_urgente)
        <div class="section">
            <h3 class="section-title">Informations Supplémentaires</h3>
            <div class="info-grid">
                @if(isset($demande->avantages_entreprise) && $demande->avantages_entreprise)
                    <div class="info-item md:col-span-2">
                        <label>Avantages proposés par l'entreprise</label>
                        <p class="description-box">{!! nl2br(e($demande->avantages_entreprise)) !!}</p>
                    </div>
                @endif
                @if($demande->est_urgente)
                    <div class="info-item">
                        <label>Urgence</label>
                        <p class="badge-display"><span class="status-badge" style="background-color: #fff7ed; color: #c2410c;"><i class="fas fa-exclamation-triangle mr-1"></i> Demande Urgente</span></p>
                    </div>
                @endif
            </div>
        </div>
        @endif


        {{-- Section d'action administrative --}}
        <div class="section action-form">
            <h3 class="section-title">Action Administrative</h3>
            @if($demande->statut === 'en_attente')
                <form action="{{ route('admin.demandes.updateStatus', $demande) }}" method="POST" class="space-y-6"> {{-- Augmentation de l'espace --}}
                    @csrf
                    @method('PATCH')
                    
                    <div>
                        <label for="statut_admin_action" class="block text-sm font-medium text-gray-700 mb-1">Changer le statut :</label>
                        <select name="statut" id="statut_admin_action" class="focus:ring-blue-500">
                            <option value="approuvee" {{ old('statut') == 'approuvee' ? 'selected' : '' }}>Approuver</option>
                            <option value="rejetee" {{ old('statut') == 'rejetee' ? 'selected' : '' }}>Rejeter</option>
                            {{-- <option value="en_cours">Marquer en cours de traitement</option> --}}
                        </select>
                    </div>

                    <div id="motif_rejet_container_admin" style="{{ old('statut') == 'rejetee' ? '' : 'display:none;' }}">
                        <label for="motif_rejet_admin" class="block text-sm font-medium text-gray-700 mb-1">Motif du Rejet <span class="text-red-500" id="motif_required_indicator" style="display:none;">*</span> :</label>
                        <textarea name="motif_rejet" id="motif_rejet_admin" rows="4" class="focus:ring-blue-500" placeholder="Indiquez la raison du rejet...">{{ old('motif_rejet') }}</textarea>
                         @error('motif_rejet') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="flex justify-end pt-2">
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save mr-2"></i>Enregistrer la décision
                        </button>
                    </div>
                </form>
            @else
                <p class="text-gray-700"><i class="fas fa-info-circle text-blue-500 mr-2"></i>La décision pour cette demande a déjà été prise.</p>
                {{-- 
                <form action="{{ route('admin.demandes.updateStatus', $demande) }}" method="POST" class="mt-4">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="statut" value="en_attente">
                    <button type="submit" class="btn btn-secondary text-sm">
                        <i class="fas fa-undo mr-2"></i>Réinitialiser en "En attente"
                    </button>
                </form> 
                --}}
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const statutSelect = document.getElementById('statut_admin_action'); // ID unique
        const motifRejetContainer = document.getElementById('motif_rejet_container_admin'); // ID unique
        const motifRejetTextarea = document.getElementById('motif_rejet_admin'); // ID unique
        const motifRequiredIndicator = document.getElementById('motif_required_indicator');

        function toggleMotifRejet() {
            if (statutSelect && motifRejetContainer && motifRejetTextarea && motifRequiredIndicator) {
                if (statutSelect.value === 'rejetee') {
                    motifRejetContainer.style.display = 'block';
                    motifRejetTextarea.setAttribute('required', 'required');
                    motifRequiredIndicator.style.display = 'inline';
                } else {
                    motifRejetContainer.style.display = 'none';
                    motifRejetTextarea.removeAttribute('required');
                    motifRequiredIndicator.style.display = 'none';
                    motifRejetTextarea.value = ''; // Effacer le contenu si on change d'avis
                }
            }
        }

        if (statutSelect) {
            statutSelect.addEventListener('change', toggleMotifRejet);
            toggleMotifRejet(); // Appel initial
        }
    });
</script>
@endpush