@extends('layouts.etudiant.app')

@section('title', 'StagesBENIN')

@push('styles')
<style>
    .page-header {
        background: #4e73df;
        padding: 2rem 0;
        margin-bottom: 2rem;
    }

    .page-title {
        color: white;
        font-size: 1.8rem;
        font-weight: 600;
        margin: 0;
    }

    .entretien-card {
        border: 1px solid #e3e6f0;
        border-radius: 10px;
        background: white;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    }

    .card-header {
        background: #4e73df;
        color: white;
        border-bottom: none;
        padding: 1rem;
    }

    .info-item {
        padding: 1rem;
        border-bottom: 1px solid #e3e6f0;
    }

    .info-item:last-child {
        border-bottom: none;
    }

    .info-label {
        color: #6c757d;
        font-size: 0.9rem;
        margin-bottom: 0.3rem;
    }

    .info-value {
        color: #2d3748;
        font-weight: 500;
    }

    .status-badge {
        padding: 0.4rem 1rem;
        border-radius: 5px;
        font-size: 0.9rem;
        background: #e3e6f0;
        color: #4e73df;
    }

    .btn-entretien {
        background: #4e73df;
        color: white;
        border: none;
        padding: 0.5rem 1rem;
        border-radius: 5px;
        font-size: 0.9rem;
        transition: background-color 0.3s ease;
    }

    .btn-entretien:hover {
        background: #2e59d9;
    }

    .empty-state {
        text-align: center;
        padding: 3rem 2rem;
        background: #f8f9fc;
        border-radius: 10px;
        margin: 2rem 0;
    }

    .empty-state i {
        font-size: 4rem;
        color: #e3e6f0;
        margin-bottom: 1rem;
    }

    .empty-state h4 {
        color: #4e73df;
        font-weight: 600;
        margin-bottom: 0.5rem;
    }

    .warning-alert {
        font-size: 0.9rem;
        background-color: #fff3cd;
        color: #856404;
        padding: 0.5rem;
        border-radius: 5px;
        margin-top: 10px;
    }
</style>
@endpush

@section('content')
<div class="page-header">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-12">
                <h1 class="page-title">
                    <i class="fas fa-calendar-check me-2"></i>
                    Les tests de niveau programmés
                </h1>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="row">
        @forelse ($entretiens as $entretien)
            @php
                $dateSeule = \Carbon\Carbon::parse($entretien->date)->format('Y-m-d');
                $heureSeule = \Carbon\Carbon::parse($entretien->heure)->format('H:i:s');
                $heureEntretien = \Carbon\Carbon::parse($dateSeule . ' ' . $heureSeule);
            @endphp

            <div class="col-md-4 mb-4">
                <div class="card entretien-card p-3">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-briefcase me-2"></i>
                            Poste : {{ $entretien->nom_du_poste }}
                        </h5><br>
                        <div class="warning-alert">
                            ⚠️ Attention : Une note en dessous de 12/20 entraîne une disqualification automatique.
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="info-item d-flex justify-content-between">
                            <span class="info-label"><i class="fas fa-calendar me-2"></i> Date de démarrage :</span>
                            <span class="info-value"><strong>{{ $heureEntretien->format('d/m/Y') }}</strong></span>
                        </div>

                        <div class="info-item d-flex justify-content-between">
                            <span class="info-label"><i class="fas fa-clock me-2"></i> Heure :</span>
                            <span class="info-value"><strong>{{ $heureEntretien->format('H:i') }}</strong></span>
                        </div>

                        <div class="info-item d-flex justify-content-between">
                            <span class="info-label"><i class="fas fa-clock me-2"></i> Durée :</span>
                            <span class="info-value"><strong>{{ $entretien->duree }} min</strong></span>
                        </div>
                    </div>

                    <div class="card-footer bg-light d-flex justify-content-between align-items-center">
                        <span class="status-badge">
                            <i class="fas fa-clock me-1"></i> Planifié
                        </span>

                        <div class="entretien-wrapper"
                            data-debut="{{ $heureEntretien->format('Y-m-d\TH:i:s') }}"
                            data-duree="{{ $entretien->duree }}"
                            data-id="{{ $entretien->entretien_id }}">

                            <a href="{{ route('etudiants.examen', ['etudiant_id' => $entretien->etudiant_id, 'entretien_id' => $entretien->entretien_id]) }}"
                                class="btn btn-entretien"
                                id="btn-entretien-{{ $entretien->entretien_id }}"
                                style="display: none;">
                                <i class="fas fa-video me-2"></i> Commencer le test
                            </a>

                            <div id="compte-a-rebours-{{ $entretien->entretien_id }}" class="text-warning fw-bold"></div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center">
                <div class="empty-state">
                    <i class="fas fa-calendar-times"></i>
                    <h4>Aucun test programmé</h4>
                    <p class="text-muted">Vous n'avez aucun test de niveau prévu pour le moment.</p>
                </div>
            </div>
        @endforelse
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const wrappers = document.querySelectorAll('.entretien-wrapper');

        wrappers.forEach(function(wrapper) {
            const debut = new Date(wrapper.dataset.debut);
            const dureeMinutes = parseInt(wrapper.dataset.duree || '0');
            const id = wrapper.dataset.id;

            const btn = document.getElementById('btn-entretien-' + id);
            const compte = document.getElementById('compte-a-rebours-' + id);

            if (!btn || !compte) {
                console.error('Éléments manquants pour l\'entretien ID:', id);
                return;
            }

            function updateCountdown() {
                const now = new Date();
                const fin = new Date(debut.getTime() + dureeMinutes * 60000);

                if (now >= fin) {
                    btn.style.display = 'none';
                    compte.style.display = 'none';
                    compte.innerHTML = '';
                    return;
                }

                if (now >= debut && now < fin) {
                    btn.style.display = 'inline-block';
                    compte.style.display = 'none';
                    return;
                }

                const diff = debut - now;
                const jours = Math.floor(diff / (1000 * 60 * 60 * 24));
                const heures = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
                const secondes = Math.floor((diff % (1000 * 60)) / 1000);

                let texte = "L'entretien sera disponible dans ";
                if (jours > 0) texte += `${jours} jour${jours !== 1 ? 's' : ''}, `;
                texte += `${heures} heure${heures !== 1 ? 's' : ''}, `;
                texte += `${minutes} minute${minutes !== 1 ? 's' : ''}, `;
                texte += `${secondes} seconde${secondes !== 1 ? 's' : ''}.`;

                compte.textContent = texte;
            }

            if (isNaN(debut.getTime())) {
                compte.textContent = 'Erreur de date';
                return;
            }

            updateCountdown();
            const intervalId = setInterval(updateCountdown, 1000);

            setTimeout(() => {
                clearInterval(intervalId);
            }, 24 * 60 * 60 * 1000);
        });
    });
</script>
@endpush
