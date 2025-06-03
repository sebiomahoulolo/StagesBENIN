@extends('layouts.admin.app')

@section('title', 'StagesBENIN')

@push('styles')
    <style>
        .specialite-container {
            padding: 1.5rem;
        }

        .search-container {
            padding: 1rem;
            background: #f8f9fa;
            border-bottom: 1px solid #dee2e6;
        }

        .search-input {
            max-width: 500px;
            margin: 0 auto;
        }

        .table-responsive {
            margin-top: 1rem;
        }

        .table th {
            background-color: #f8f9fa;
            font-weight: 600;
        }

        .table td,
        .table th {
            vertical-align: middle;
        }

        .table thead.table-light th {
            background-color: #f8f9fa;
            border-bottom: 2px solid #dee2e6;
        }

        .table-hover tbody tr:hover {
            background-color: rgba(0, 0, 0, .075);
        }

        .btn-group {
            display: flex;
            gap: 0.25rem;
        }

        .btn-sm {
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
        }

        .filter-section {
            display: flex;
            gap: 1rem;
            align-items: center;
            margin-bottom: 1rem;
        }

        .niveau-select {
            min-width: 200px;
        }

        .highlight {
            background-color: #fff3cd;
            padding: 0.2rem;
            border-radius: 0.2rem;
        }
    </style>
@endpush

@section('content')
    <div class="container-fluid">
        <div class="specialite-container">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>{{ $specialite->nom }}</h2>
                <div class="badge bg-primary fs-5">
                    {{ $nombreEtudiants }} étudiant(s)
                </div>
            </div>

            <div class="search-container mb-4">
                <div class="filter-section">
                    <div class="niveau-select">
                        <select id="niveauFilter" class="form-select">
                            <option value="">Tous les niveaux</option>
                            @foreach ($niveaux as $niveau)
                                <option value="{{ $niveau }}">{{ $niveau }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            @if ($etudiants->isEmpty())
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i>
                    Aucun étudiant disponible pour cette spécialité.
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover table-bordered align-middle" id="cvTable">
                        <thead class="table-light">
                            <tr>
                                <th>Nom</th>
                                <th>Email</th>
                                <th>Téléphone</th>
                                <th>Niveau</th>
                                <th>Date d'inscription</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($etudiants as $etudiant)
                                <tr data-niveau="{{ $etudiant->niveau }}">
                                    <td>{{ $etudiant->prenom ?? 'Non spécifié' }} {{ $etudiant->nom ?? 'Non spécifié' }}</td>
                                    <td>{{ $etudiant->email ?? 'Non spécifié' }}</td>
                                    <td>{{ $etudiant->telephone ?? 'Non spécifié' }}</td>
                                    <td>{{ $etudiant->niveau ?? 'Non spécifié' }}</td>
                                    <td>{{ $etudiant->created_at->format('d/m/Y H:i') }}</td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{ route('admin.cvtheque.view', $etudiant->id) }}"
                                                class="btn btn-info btn-sm" title="Voir le CV">
                                                <i class="fas fa-eye"></i> Voir
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const niveauFilter = document.getElementById('niveauFilter');
            const tableRows = document.querySelectorAll('#cvTable tbody tr');

            function filtrerEtudiants() {
                const niveauChoisi = niveauFilter.value;

                tableRows.forEach(row => {
                    const niveau = row.getAttribute('data-niveau');
                    row.style.display = (niveauChoisi === '' || niveau === niveauChoisi) ? '' : 'none';
                });
            }

            niveauFilter.addEventListener('change', filtrerEtudiants);

            // Filtrage au chargement (si nécessaire)
            filtrerEtudiants();
        });
    </script>
@endpush


