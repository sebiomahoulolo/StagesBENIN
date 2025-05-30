@extends('layouts.etudiant.app')

@section('title', 'Entretiens programmés')

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
            color: white;
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
    </style>
@endpush

@section('content')
    <div class="page-header">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-12">
                    <h1 class="page-title">
                        <i class="fas fa-calendar-check me-2"></i>
                        Mes entretiens programmés
                    </h1>
                </div>
            </div>
        </div>
    </div>

<div class="container-fluid">
    <div class="row">
        @forelse ($entretiens as $entretien)
            <div class="col-md-4 mb-4">
                <div class="entretien-card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-briefcase me-2"></i>
                       Poste :      {{ $entretien->nom_du_poste }}
                        </h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="info-item">
                            <div class="info-label">
                                <i class="fas fa-calendar me-2"></i>
                                Date de l'entretien : <strong class="info-value">      {{ \Carbon\Carbon::parse($entretien->date)->format('d/m/Y') }} </strong>
                            </div>
                        </div>

                         <div class="info-item ">
    <div class="info-label">
        <i class="fas fa-clock me-2"></i> Heure de démarrage : <strong class="info-value"> {{ $entretien->heure }}</strong> 
    </div>
</div>

                        <div class="info-item">
                            <div class="info-label">
                                <i class="fas fa-clock me-2"></i>
                                Durée : <strong class="info-value"> {{ $entretien->duree }} minutes</strong>
                            </div>
                        </div>
                    <div class="card-footer bg-light px-4">
                        <div class="d-flex justify-content-between align-items-center px-3 py-3">
                            <span class="status-badge">
                                <i class="fas fa-clock me-1"></i>
                                Planifié
                            </span>

                            <a href="{{ route('etudiants.examen', ['etudiant_id' => $entretien->entretien_id]) }}"
                                class="btn btn-entretien">
                                <i class="fas fa-video me-2"></i>
                                Passer l'entretien
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="empty-state">
                        <i class="fas fa-calendar-times"></i>
                        <h4>Aucun entretien programmé</h4>
                        <p class="text-muted">Vous n'avez aucun entretien programmé pour le moment.</p>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Ajoutez ici vos scripts si nécessaire
    </script>
@endpush
