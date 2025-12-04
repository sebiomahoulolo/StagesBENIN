{{-- Vue mise à jour - resultats_pratique.blade.php --}}
@extends('layouts.admin.app')

@section('title', 'StagesBENIN')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="card-title mb-0">
                            <i class="fas fa-clipboard-list me-2"></i>
                            Résultats du test Pratiques
                        </h3>
                    </div>
                </div>

                <!-- Section des filtres -->
                <div class="card-body border-bottom">
                    <form id="filterForm" method="GET" class="row g-3">
                        <div class="col-md-3">
                            <input type="text" class="form-control" name="search" placeholder="Rechercher..." value="{{ request('search') }}">
                        </div>
                      
                       
                    </form>
                </div>
                
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped mb-0">
                            <thead class="table">
                                <tr>
                                    {{-- <th scope="col">Test</th> --}}
                                    <th scope="col">Nom & Prénom</th>
                                    {{-- <th scope="col">Annonce</th> --}}
                                    <th scope="col">Niveau</th>
                                    <th scope="col">Formation</th>
                                    <th scope="col">Date Passage et Heure</th>
                                    <th scope="col">Note total</th>
                                    <th scope="col" class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($examens as $index => $examen)
                                    <tr class="align-middle">
                                        {{-- <td>
                                            @php $entretien = $examen->entretien ?? null; @endphp
                                            @if($entretien)
                                                <span class="fw-semibold">{{ $entretien->reference ?? $entretien->id }}</span><br>
                                                <small class="text-muted">{{ is_string($entretien->date) ? $entretien->date : ($entretien->date ? $entretien->date->format('d/m/Y') : '') }}</small>
                                            @else
                                                <span class="text-muted">N/A</span>
                                            @endif
                                        </td> --}}
                                        <td>
                                            <div class="fw-semibold">{{ $examen->etudiant->nom ?? 'N/A' }} {{ $examen->etudiant->prenom ?? '' }}</div>
                                        </td>
                                        {{-- <td>
                                            @php $annonce = $entretien && $entretien->annonce ? $entretien->annonce : null; @endphp
                                            {{ $annonce ? $annonce->nom_du_poste : 'N/A' }}
                                        </td> --}}
                                        
                                        <td>
                                            <span class="bg-info">{{ $examen->etudiant->niveau ?? 'N/A' }}</span>
                                        </td>
                                        
                                        <td>
                                            <span class="text-wrap">
                                                @php
                                                    $specialite = \App\Models\Specialite::find($examen->etudiant->formation);
                                                @endphp
                                                {{ $specialite ? $specialite->nom : 'N/A' }}
                                            </span>
                                        </td>
                                        
                                        <td>
                                            <br>
                                            <small class="text-muted">
                                                @php
                                                    $candidature = $examen->etudiant->candidatures()
                                                        ->whereHas('annonce', function($query) {
                                                            $query->whereHas('entretiens');
                                                        })
                                                        ->first();
                                                    
                                                    $entretien = $candidature ? $candidature->annonce->entretiens->first() : null;
                                                @endphp
                                                @if($entretien)
                                                    <i class="fas fa-calendar"></i> {{ is_string($entretien->date) ? $entretien->date : $entretien->date->format('d/m/Y') }}
                                                    <i class="fas fa-clock ms-2"></i> {{ $entretien->heure }}
                                                    <br>
                                                    <i class="fas fa-hourglass-half"></i> {{ $entretien->duree }} min
                                                @endif
                                            </small>
                                        </td>
                                        
                                        <td class="text-center">
                                            <div class="score-container">
                                                <span class="fs-6 {{ $examen->score >= 5 ? 'bg-success' : 'bg-danger' }}">
                                                    {{ $examen->score }}
                                                </span>
                                              
                                            </div>
                                        </td>
                                        
                                      
                                        
                                        <td class="text-center">
                                              <a href="{{ route('admin.cvtheque.view', $examen->etudiant->id) }}" 
                                                   class="btn btn-outline-info btn-sm" 
                                                   title="Voir le CV" 
                                                   data-bs-toggle="tooltip">
                                                    <i class="fas fa-eye"></i>CV
                                                </a>
                                            <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#detailsModal{{ $examen->id }}">
                                                <i class="fas fa-eye me-2"></i>Noter
                                            </button>
                                        </td>
                                    </tr>

                                    <!-- Modal pour les détails -->
                                    <div class="modal fade" id="detailsModal{{ $examen->id }}" tabindex="-1" aria-labelledby="detailsModalLabel{{ $examen->id }}" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header bg-info text-white">
                                                    <h5 class="modal-title" id="detailsModalLabel{{ $examen->id }}">
                                                        <i class="fas fa-clipboard-list me-2"></i>
                                                        Cas Pratiques - {{ $examen->etudiant->nom }} {{ $examen->etudiant->prenom }}
                                                    </h5>
                                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row mb-4">
                                                        <div class="col-md-6">
                                                            <h6 class="text-primary mb-3">Informations de l'étudiant</h6>
                                                            <ul class="list-group list-group-flush">
                                                                <li class="list-group-item d-flex justify-content-between">
                                                                    <span class="fw-bold">Nom:</span>
                                                                    <span>{{ $examen->etudiant->nom }} {{ $examen->etudiant->prenom }}</span>
                                                                </li>
                                                               
                                                            </ul>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <h6 class="text-primary mb-3">Informations du test</h6>
                                                            <ul class="list-group list-group-flush">
                                                                @php
                                                                    $candidature = $examen->etudiant->candidatures()
                                                                        ->whereHas('annonce', function($query) {
                                                                            $query->whereHas('entretiens');
                                                                        })
                                                                        ->first();
                                                                    
                                                                    $entretien = $candidature ? $candidature->annonce->entretiens->first() : null;
                                                                @endphp
                                                                @if($entretien)
                                                                    <li class="list-group-item d-flex justify-content-between">
                                                                        <span class="fw-bold">Date:</span>
                                                                        <span>{{ is_string($entretien->date) ? $entretien->date : $entretien->date->format('d/m/Y') }}</span>
                                                                    </li>
                                                                    
                                                                   
                                                                @endif
                                                            </ul>
                                                        </div>
                                                    </div>

                                                    <h6 class="text-primary mb-3">Cas pratiques</h6>
                                                    <div class="accordion" id="questionsAccordion{{ $examen->id }}">
                                                        @php
                                                            // Récupération de l'entretien et de l'annonce
                                                            $candidature = $examen->etudiant->candidatures()
                                                                ->whereHas('annonce', function($query) {
                                                                    $query->whereHas('entretiens');
                                                                })
                                                                ->first();
                                                            
                                                            $entretien = $candidature ? $candidature->annonce->entretiens->first() : null;
                                                            
                                                            // Décodage des réponses JSON avec meilleure gestion des erreurs
                                                            $reponses = [];
                                                            if ($examen->reponses) {
                                                            try {
                                                                    // Nettoyage du JSON si nécessaire
                                                                    $cleanedJson = str_replace(['\\', '\"'], ['', '"'], $examen->reponses);
                                                                    $reponses = json_decode($cleanedJson, true);
                                                                    
                                                                    // Si le décodage échoue, essayer une autre approche
                                                                    if (json_last_error() !== JSON_ERROR_NONE) {
                                                                        $reponses = json_decode($examen->reponses, true);
                                                                    }
                                                                    
                                                                    // Si toujours pas de succès, essayer de parser manuellement
                                                                    if (json_last_error() !== JSON_ERROR_NONE) {
                                                                        $reponses = [];
                                                                        $pairs = explode(',', trim($examen->reponses, '{}'));
                                                                        foreach ($pairs as $pair) {
                                                                            if (strpos($pair, ':') !== false) {
                                                                                list($key, $value) = explode(':', $pair);
                                                                                $key = trim(trim($key), '"\'');
                                                                                $value = trim(trim($value), '"\'');
                                                                                $reponses[$key] = $value;
                                                                            }
                                                                        }
                                                                }
                                                            } catch (\Exception $e) {
                                                                $reponses = [];
                                                                }
                                                            }
                                                            
                                                            // Récupération des questions en utilisant les IDs des réponses
                                                            $casPratiques = collect();
                                                            if (!empty($reponses)) {
                                                                $questionIds = array_keys($reponses);
                                                                $casPratiques = \App\Models\Question::whereIn('id', $questionIds)
                                                                    ->where('type', 'cas_pratique')
                                                                    ->get();
                                                            }
                                                        @endphp
                                                        
                                                        @forelse($casPratiques as $index => $question)
                                                            <div class="accordion-item">
                                                                <h2 class="accordion-header">
                                                                    <button class="accordion-button {{ $index === 0 ? '' : 'collapsed' }}" type="button" data-bs-toggle="collapse" data-bs-target="#question{{ $question->id }}">
                                                                        <strong>Cas pratique {{ $index + 1 }}</strong>
                                                                    </button>
                                                                </h2>
                                                                <div id="question{{ $question->id }}" class="accordion-collapse collapse {{ $index === 0 ? 'show' : '' }}">
                                                                    <div class="accordion-body">
                                                                        <div class="mb-3">
                                                                            <h6 class="text-primary">Énoncé :</h6>
                                                                            <p class="mb-0">{{ $question->question }}</p>
                                                                        </div>
                                                                        <div class="mb-3">
                                                                            <h6 class="text-success">Réponse de l'étudiant :</h6>
                                                                            <p class="mb-0">{{ $reponses[$question->id] ?? 'Aucune réponse' }}</p>
                                                                            </div>
                                                                        
                                                                        
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @empty
                                                            <div class="alert alert-warning">
                                                                Aucun cas pratique trouvé pour cet examen
                                                            </div>
                                                        @endforelse
                                                    </div>
                                                </div>
                                                <div class="mt-4">
                                                    @php
                                                        // Récupération de la candidature et de l'entretien programmé
                                                        $candidature = $examen->etudiant->candidatures()
                                                            ->whereHas('annonce', function($query) {
                                                                $query->whereHas('entretiens', function($q) {
                                                                    $q->where('status', 'planifié');
                                                                });
                                                            })
                                                            ->first();
                                                        
                                                        $entretien = $candidature ? $candidature->annonce->entretiens()
                                                            ->where('status', 'planifié')
                                                            ->first() : null;
                                                        
                                                        // Récupération des questions de l'entretien programmé
                                                        $questions = $entretien ? $entretien->questions()
                                                            ->where('type', 'cas_pratique')
                                                            ->get() : collect();
                                                    @endphp
                                                    @if($entretien && $questions->isNotEmpty())
                                                        <div class="card">
                                                            <div class="card-header bg-primary text-white">
                                                                <h5 class="mb-0">
                                                                    <i class="fas fa-star me-2"></i>
                                                                    Système de notation - Test du {{ is_string($entretien->date) ? $entretien->date : $entretien->date->format('d/m/Y') }}
                                                                </h5>
                                                            </div>
                                                            <div class="card-body">
                                                                @foreach($questions as $question)
                                                                    <div class="mb-4">
                                                                        <h6 class="text-primary mb-3">Cas pratique {{ $loop->iteration }}</h6>
                                                                        <form action="{{ route('admin.noter.cas.pratique', ['examen' => $examen->id, 'question' => $question->id]) }}" method="POST" class="notation-form" id="notationForm{{ $examen->id }}_{{ $question->id }}">
                                                                            @csrf
                                                                            <input type="hidden" name="examen_id" value="{{ $examen->id }}">
                                                                            <input type="hidden" name="question_id" value="{{ $question->id }}">
                                                                            <div class="row align-items-end">
                                                                                <div class="col-md-6">
                                                                                    <div class="form-group">
                                                                                        <label for="note{{ $examen->id }}_{{ $question->id }}" class="form-label">Note sur 10</label>
                                                                                        <input type="number" class="form-control" id="note{{ $examen->id }}_{{ $question->id }}" name="note" min="0" max="10" step="0.5" required>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-6">
                                                                                    <button type="submit" class="btn btn-primary w-100">
                                                                                        <i class="fas fa-check me-2"></i>Valider la note
                                                                                    </button>
                                                                                </div>
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="alert alert-warning">
                                                            <i class="fas fa-exclamation-triangle me-2"></i>
                                                            Aucun test programmé
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                        <i class="fas fa-times me-2"></i>Fermer
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <script>
                                    document.addEventListener('DOMContentLoaded', function() {
                                        // Handle all notation forms
                                        document.querySelectorAll('form[id^="notationForm"]').forEach(function(form) {
                                            form.addEventListener('submit', function(e) {
                                                e.preventDefault();
                                                
                                                // Récupérer le bouton de soumission
                                                const submitButton = form.querySelector('button[type="submit"]');
                                                
                                                // Afficher le message de succès
                                                const alertDiv = document.createElement('div');
                                                alertDiv.className = 'alert alert-success alert-dismissible fade show';
                                                alertDiv.innerHTML = `
                                                    <i class="fas fa-check-circle me-2"></i>
                                                    Note attribuée avec succès
                                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                                `;
                                                form.parentNode.insertBefore(alertDiv, form);
                                            });
                                        });
                                    });
                                    </script>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-5">
                                            <div class="text-muted">
                                                <i class="fas fa-inbox fa-3x mb-3"></i>
                                                <h5>Aucun test trouvé</h5>
                                                <p>Il n'y a pas encore test pratiques enregistrés.</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                
                @if($examens->hasPages())
                    <div class="card-footer">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="text-muted">
                                Affichage de {{ $examens->firstItem() }} à {{ $examens->lastItem() }} 
                                sur {{ $examens->total() }} résultats
                            </div>
                            {{ $examens->links() }}
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialisation des tooltips Bootstrap
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // Gestion du tri
    document.querySelectorAll('.sortable').forEach(function(header) {
        header.addEventListener('click', function() {
            const sortBy = this.dataset.sort;
            const currentDir = new URLSearchParams(window.location.search).get('sort_dir') || 'desc';
            const newDir = currentDir === 'asc' ? 'desc' : 'asc';
            
            const url = new URL(window.location.href);
            url.searchParams.set('sort_by', sortBy);
            url.searchParams.set('sort_dir', newDir);
            window.location.href = url.toString();
        });
    });

    // Gestion des formulaires de notation
    document.querySelectorAll('.notation-form').forEach(function(form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Récupérer le bouton de soumission
            const submitButton = form.querySelector('button[type="submit"]');
            
            // Afficher le message de succès
            const alertDiv = document.createElement('div');
            alertDiv.className = 'alert alert-success alert-dismissible fade show';
            alertDiv.innerHTML = `
                <i class="fas fa-check-circle me-2"></i>
                Note attribuée avec succès
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            `;
            form.parentNode.insertBefore(alertDiv, form);
            });
        });

    // Animation des badges au survol
    document.querySelectorAll('.badge').forEach(function(badge) {
        badge.addEventListener('mouseenter', function() {
            this.style.transform = 'scale(1.05)';
            this.style.transition = 'transform 0.2s ease';
        });
        
        badge.addEventListener('mouseleave', function() {
            this.style.transform = 'scale(1)';
        });
    });

    // Animation des cartes de statistiques
    document.querySelectorAll('.card').forEach(function(card) {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-2px)';
            this.style.transition = 'transform 0.2s ease';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });
});
</script>

<style>
.sortable {
    cursor: pointer;
    position: relative;
}

.sortable:hover {
    background-color: rgba(0,0,0,0.05);
}

.sortable i {
    margin-left: 5px;
    opacity: 0.5;
}

.sortable:hover i {
    opacity: 1;
}

.table th {
    white-space: nowrap;
}

.score-container {
    display: inline-block;
    padding: 5px 10px;
    border-radius: 4px;
}

.bg-success, .bg-danger {
    color: white;
    padding: 2px 8px;
    border-radius: 4px;
}

.btn-group .btn {
    margin: 0 2px;
}

@media (max-width: 768px) {
    .table-responsive {
        font-size: 0.9rem;
    }
    
    .btn-group .btn {
        padding: 0.25rem 0.5rem;
    }
}
</style>
@endsection