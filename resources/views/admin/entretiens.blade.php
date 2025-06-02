@extends('layouts.admin.app')

@section('title', 'StagesBENIN')

@section('content')
    <div class="content-area">
        <div class="container-fluid py-4">
            <!-- Section Programmer un entretien -->
            <div class="row mb-4">
                <div class="col-md-12">
                    <div class="card shadow-lg border-0 rounded-3">
                        <div class="card-header bg-primary text-white py-3">
                            <h4 class="mb-0"><i class="fas fa-calendar-plus me-2"></i>Programmer un entretien</h4>
                        </div>
                        <div class="card-body p-4">
                            @if (session('success'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                            @endif

                            @if (session('error'))
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                            @endif

                            <form action="{{ route('admin.entretiens.store') }}" method="POST" class="needs-validation"
                                novalidate>
                                @csrf
                                <div class="row g-3">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="annonce_id" class="form-label fw-bold">Annonce</label>
                                            <select name="annonce_id" id="annonce_id"
                                                class="form-select form-select-md @error('annonce_id') is-invalid @enderror">
                                                <option value="">Selectionner une annonce</option>
                                                @foreach ($annonces as $annonce)
                                                    <option value="{{ $annonce->id }}"
                                                        {{ old('annonce_id') == $annonce->id ? 'selected' : '' }}>
                                                        {{ $annonce->nom_du_poste }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('annonce_id')
                                                <div class="invalid-feedback">
                                                    <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="date" class="form-label fw-bold">Date</label>
                                            <input type="date" name="date" id="date"
                                                class="form-control form-control-md @error('date') is-invalid @enderror"
                                                value="{{ old('date') }}">
                                            @error('date')
                                                <div class="invalid-feedback">
                                                    <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="heure" class="form-label fw-bold">Heure</label>
                                            <input type="time" name="heure" id="heure"
                                                class="form-control form-control-md @error('heure') is-invalid @enderror"
                                                value="{{ old('heure') }}">
                                            @error('heure')
                                                <div class="invalid-feedback">
                                                    <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="duree" class="form-label fw-bold">Durée (en minutes)</label>
                                            <input type="number" name="duree" id="duree" min="1"
                                                max="120" step="1"
                                                class="form-control form-control-md @error('duree') is-invalid @enderror"
                                                value="{{ old('duree') }}">
                                            @error('duree')
                                                <div class="invalid-feedback">
                                                    <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-4">
                                    <button type="submit" class="btn btn-primary btn-md px-4">
                                        <i class="fas fa-save me-2"></i>Programmer
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Section Liste des Entretiens -->
            <div class="row mb-4">
                <div class="col-md-12">
                    {{-- <div class="d-flex justify-content-between align-items-center mb-4">
                        <h4 class="mb-0"><i class="fas fa-list me-2"></i>Liste des Entretiens</h4>
                        <a href="{{ route('admin.entretiens.create') }}" class="btn btn-success btn-lg">
                            <i class="fas fa-plus-circle me-2"></i>Créer un questionnaire
                        </a>
                    </div> --}}

                    <div class="card shadow-lg border-0 rounded-3">
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0">
                                    <thead class="bg-light">
                                        <tr>
                                            <th class="py-3">Refernece</th>
                                            <th class="py-3">Annonce</th>
                                            <th class="py-3">Date</th>
                                            <th class="py-3">Heure Entretien</th>
                                            <th class="py-3">Durée Entretien</th>
                                            <th class="py-3">Statut</th>
                                            <th class="py-3">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($entretiens as $entretien)
                                            <tr>
                                                <td class="py-3">{{ $entretien->reference }}</td>
                                                <td class="py-3">{{ $entretien->nom_du_poste }}</td>
                                                <td class="py-3">{{ date('d-m-Y', strtotime($entretien->date)) }}</td>
                                                <td class="py-3">{{ $entretien->heure }}</td>
                                                <td class="py-3">{{ $entretien->duree }} minutes</td>
                                                <td class="py-3 flex flex-col gap-y-2">
                                                    @if ($entretien->status === 'en_attente')
                                                        <span class="badge bg-warning text-dark">En attente</span>
                                                        <button type="button" class="btn btn-primary btn-sm"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#updateStatusModal{{ $entretien->id }}">
                                                            <i class="fas fa-edit me-2"></i>Modifier
                                                        </button>
                                                    @elseif($entretien->status === 'planifié')
                                                        <span class="badge bg-info text-dark">Planifié</span>
                                                        <button type="button" class="btn btn-primary btn-sm"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#updateStatusModal{{ $entretien->id }}">
                                                            <i class="fas fa-edit me-2"></i>Modifier
                                                        </button>
                                                    @elseif($entretien->status === 'terminé')
                                                        <span class="badge bg-success text-white">Terminé</span>
                                                    @else
                                                        <span class="badge bg-secondary text-white">Inconnu</span>
                                                        <button type="button" class="btn btn-primary btn-sm"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#updateStatusModal{{ $entretien->id }}">
                                                            <i class="fas fa-edit me-2"></i>Modifier
                                                        </button>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($entretien->status === 'en_attente')
                                                        <a href="{{ route('admin.entretiens.create', ['id' => $entretien->id]) }}"
                                                            class="btn btn-primary btn-sm">
                                                            <i class="fas fa-edit me-2"></i>Créer le questionnaire
                                                        </a>
                                                    @endif
                                                    <button type="button" class="btn btn-warning btn-sm"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#viewEntretienModal{{ $entretien->id }}">
                                                        <i class="fas fa-eye me-2"></i>Voir
                                                    </button>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="text-center">
                                                    <h5>Aucun entretien trouvé</h5>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="mt-4">
                        {{ $entretiens->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>

    @foreach ($entretiens as $entretien)
        <!-- Modal de modification du statut -->
        <div class="modal fade" id="updateStatusModal{{ $entretien->id }}" tabindex="-1"
            aria-labelledby="updateStatusModalLabel{{ $entretien->id }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="updateStatusModalLabel{{ $entretien->id }}">
                            <i class="fas fa-edit me-2"></i>Modifier le statut
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <form action="{{ route('admin.entretiens.update-status', $entretien->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="status{{ $entretien->id }}" class="form-label fw-bold">Statut</label>
                                <select name="status" id="status{{ $entretien->id }}" class="form-select">
                                    <option value="en_attente"
                                        {{ $entretien->status === 'en_attente' ? 'selected' : '' }}>En attente</option>
                                    <option value="planifié" {{ $entretien->status === 'planifié' ? 'selected' : '' }}>
                                        Planifié</option>
                                    <option value="terminé" {{ $entretien->status === 'terminé' ? 'selected' : '' }}>
                                        Terminé</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                <i class="fas fa-times me-2"></i>Annuler
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Enregistrer
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal de détails de l'entretien -->
        <div class="modal fade" id="viewEntretienModal{{ $entretien->id }}" tabindex="-1"
            aria-labelledby="viewEntretienModalLabel{{ $entretien->id }}" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-warning text-dark">
                        <h5 class="modal-title" id="viewEntretienModalLabel{{ $entretien->id }}">
                            <i class="fas fa-info-circle me-2"></i>Détails de l'entretien
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <h6 class="text-primary mb-3">Informations générales</h6>
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <span class="fw-bold">Référence:</span>
                                            <span>{{ $entretien->reference }}</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <span class="fw-bold">Annonce:</span>
                                            <span>{{ $entretien->nom_du_poste }}</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <span class="fw-bold">Date:</span>
                                            <span>{{ date('d-m-Y', strtotime($entretien->date)) }}</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <span class="fw-bold">Heure:</span>
                                            <span>{{ $entretien->heure }}</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <span class="fw-bold">Durée:</span>
                                            <span>{{ $entretien->duree }} minutes</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <span class="fw-bold">Statut:</span>
                                            <span
                                                class="badge text-white bg-{{ $entretien->status === 'en_attente' ? 'warning' : ($entretien->status === 'planifié' ? 'info' : 'success') }}">
                                                {{ $entretien->status === 'en_attente' ? 'En attente' : ($entretien->status === 'planifié' ? 'Planifié' : 'Terminé') }}
                                            </span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <h6 class="text-primary mb-3">Questions du QCM</h6>
                                    @php
                                        $questions = \App\Models\Question::where('entretien_id', $entretien->id)
                                            ->with('reponses')
                                            ->get();
                                    @endphp
                                    @if ($questions->count() > 0)
                                        <div class="accordion" id="questionsAccordion{{ $entretien->id }}">
                                            @foreach ($questions as $index => $question)
                                                <div class="accordion-item">
                                                    <h2 class="accordion-header">
                                                        <button class="accordion-button collapsed" type="button"
                                                            data-bs-toggle="collapse"
                                                            data-bs-target="#question{{ $question->id }}">
                                                            Question {{ $index + 1 }}
                                                        </button>
                                                    </h2>
                                                    <div id="question{{ $question->id }}"
                                                        class="accordion-collapse collapse"
                                                        data-bs-parent="#questionsAccordion{{ $entretien->id }}">
                                                        <div class="accordion-body">
                                                            <p class="fw-bold mb-3">{{ $question->question }}</p>
                                                            <ul class="list-group">
                                                                @foreach ($question->reponses as $reponse)
                                                                    <li
                                                                        class="list-group-item d-flex justify-content-between align-items-center">
                                                                        {{ $reponse->texte }}
                                                                        @if ($reponse->valide)
                                                                            <span class="badge bg-success">Bonne
                                                                                réponse</span>
                                                                        @endif
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                        <div class="alert alert-info">
                                            <i class="fas fa-info-circle me-2"></i>Aucune question n'a été créée pour cet
                                            entretien.
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-2"></i>Fermer
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    <style>
        .content-area {
            background-color: #f8f9fa;
            min-height: 100vh;
        }

        .card {
            transition: transform 0.2s ease-in-out;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .form-control,
        .form-select {
            border-radius: 8px;
            border: 1px solid #ced4da;
            padding: 0.75rem;
            transition: all 0.3s ease;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #80bdff;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, .25);
        }

        .btn {
            border-radius: 8px;
            padding: 0.5rem 1rem;
            transition: all 0.3s ease;
        }

        .btn:hover {
            transform: translateY(-2px);
        }

        .btn-primary {
            background: linear-gradient(45deg, #007bff, #0056b3);
            border: none;
        }

        .btn-success {
            background: linear-gradient(45deg, #28a745, #1e7e34);
            border: none;
        }

        .btn-danger {
            background: linear-gradient(45deg, #dc3545, #bd2130);
            border: none;
        }

        .btn-warning {
            background: linear-gradient(45deg, #ffc107, #d39e00);
            border: none;
            color: #000;
        }

        .btn-info {
            background: linear-gradient(45deg, #17a2b8, #138496);
            border: none;
            color: #fff;
        }

        .table {
            border-collapse: separate;
            border-spacing: 0;
        }

        .table th {
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
        }

        .table td {
            vertical-align: middle;
        }

        .shadow-lg {
            box-shadow: 0 1rem 3rem rgba(0, 0, 0, .175) !important;
        }

        .alert {
            border-radius: 10px;
            border: none;
            padding: 1rem;
            margin-bottom: 1.5rem;
        }

        .alert-success {
            background: linear-gradient(45deg, #28a745, #1e7e34);
            color: white;
        }

        .alert-danger {
            background: linear-gradient(45deg, #dc3545, #bd2130);
            color: white;
        }

        .invalid-feedback {
            font-size: 0.875rem;
            margin-top: 0.25rem;
            color: #dc3545;
        }

        .is-invalid {
            border-color: #dc3545 !important;
        }

        .is-invalid:focus {
            box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25) !important;
        }

        .pagination {
            margin-bottom: 0;
        }

        .pagination .page-link {
            border-radius: 5px;
            margin: 0 2px;
            color: #007bff;
        }

        .pagination .page-item.active .page-link {
            background: linear-gradient(45deg, #007bff, #0056b3);
            border: none;
        }

        .modal-content {
            border: none;
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }

        .modal-header {
            border-top-left-radius: 15px;
            border-top-right-radius: 15px;
            padding: 1rem 1.5rem;
        }

        .modal-body {
            padding: 1.5rem;
        }

        .modal-footer {
            border-bottom-left-radius: 15px;
            border-bottom-right-radius: 15px;
            padding: 1rem 1.5rem;
        }

        .badge {
            padding: 0.5rem 1rem;
            font-size: 0.875rem;
            font-weight: 500;
            border-radius: 6px;
        }

        .bg-warning {
            background: linear-gradient(45deg, #ffc107, #d39e00) !important;
        }

        .bg-info {
            background: linear-gradient(45deg, #17a2b8, #138496) !important;
        }

        .bg-success {
            background: linear-gradient(45deg, #28a745, #1e7e34) !important;
        }

        .bg-secondary {
            background: linear-gradient(45deg, #6c757d, #545b62) !important;
        }
    </style>
@endsection
