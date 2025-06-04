{{-- Page de notation - noter_examen.blade.php --}}
@extends('layouts.admin.app')

@section('title', 'StagesBENIN')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            {{-- En-tête avec informations de l'étudiant --}}
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">
                            <i class="fas fa-star"></i> Notation de l'entretien
                        </h4>
                       
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h5><i class="fas fa-user"></i> {{ $examen->etudiant->nom }}</h5>
                            <p class="mb-1"><strong>Niveau:</strong> {{ $examen->etudiant->niveau ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-1"><strong>Date de passage:</strong> {{ $examen->created_at->format('d/m/Y à H:i') }}</p>
                               <span class="badge badge-{{ $examen->score >= 5 ? 'success' : 'danger' }}">
                                    {{ $examen->score }}/10
                                </span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
@if(isset($examen->reponses) && is_array($examen->reponses))
    <div class="accordion" id="accordionQuestions">
        @foreach($examen->reponses as $questionId => $reponse)
            @php
                $question = $examen->questions ? $examen->questions->where('id', $questionId)->first() : null;
            @endphp
            <div class="accordion-item">
                <h2 class="accordion-header" id="heading{{ $questionId }}">
                    <button class="accordion-button collapsed" 
                            type="button" 
                            data-bs-toggle="collapse" 
                            data-bs-target="#collapse{{ $questionId }}" 
                            aria-expanded="false" 
                            aria-controls="collapse{{ $questionId }}">
                        <div class="d-flex align-items-center w-100">
                            <span class="me-3">Question {{ $loop->iteration }}</span>
                            <small class="text-muted ms-auto me-3">
                                {{ $question ? Str::limit($question->texte, 50) : 'Question non trouvée' }}
                            </small>
                        </div>
                    </button>
                </h2>
                <div id="collapse{{ $questionId }}" 
                     class="accordion-collapse collapse" 
                     aria-labelledby="heading{{ $questionId }}" 
                     data-bs-parent="#accordionQuestions">
                    <div class="accordion-body">
                        <strong>Réponse donnée :</strong> 
                        {{ is_array($reponse) ? implode(', ', $reponse) : $reponse }}
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@else
    <div class="alert alert-warning">
        <i class="fas fa-exclamation-triangle"></i> 
        Les réponses ne sont pas disponibles pour cet examen.
    </div>
@endif


            {{-- Formulaire de notation pratique --}}
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-clipboard-check"></i> Attribution de la note pratique
                    </h5>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle"></i> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-triangle"></i> 
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form action="{{ route('admin.examens.noter', $examen->id) }}" method="POST" id="formNotation">
                        @csrf
                        
                        {{-- <div class="row">
                            <div class="col-md-8">
                                <div class="card border-info mb-4">
                                    <div class="card-header bg-info text-white">
                                        <h6 class="mb-0">
                                            <i class="fas fa-calculator"></i> Calcul de la note finale
                                        </h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="row text-center">
                                            <div class="col-md-4">
                                                <div class="bg-light p-3 rounded">
                                                    <h5 class="text-primary">{{ $examen->score }}/10</h5>
                                                    <small class="text-muted">Note QCM</small>
                                                </div>
                                            </div>
                                            <div class="col-md-1 d-flex align-items-center justify-content-center">
                                                <i class="fas fa-plus text-success fa-2x"></i>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="bg-light p-3 rounded">
                                                    <h5 class="text-warning" id="notePratiqueDisplay">
                                                        {{ isset($examen->note_pratique) ? $examen->note_pratique . '/10' : '0/10' }}
                                                    </h5>
                                                    <small class="text-muted">Note Pratique</small>
                                                </div>
                                            </div>
                                            <div class="col-md-1 d-flex align-items-center justify-content-center">
                                                <i class="fas fa-divide text-info fa-2x"></i>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="bg-primary text-white p-3 rounded">
                                                    <h5 id="noteFinaleDisplay">
                                                        {{ isset($examen->note_finale) ? number_format($examen->note_finale, 1) . '/10' : '0/10' }}
                                                    </h5>
                                                    <small>Note Finale</small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="text-center mt-3">
                                            <small class="text-muted">
                                                <i class="fas fa-info-circle"></i> 
                                                Formule: (Note QCM + Note Pratique) ÷ 2 = Note Finale
                                            </small>
                                        </div>
                                    </div>
                                </div> --}}

                                <div class="form-group mb-4">
                                    <label for="note_pratique" class="form-label">
                                        <strong><i class="fas fa-star text-warning"></i> Note pratique (sur 10):</strong>
                                    </label>
                                    <select name="note_pratique" id="note_pratique" class="form-select form-select-lg" required>
                                        <option value="">-- Sélectionner une note pratique --</option>
                                        @for($i = 0; $i <= 10; $i += 0.5)
                                            <option value="{{ $i }}" 
                                                    {{ (isset($examen->note_pratique) && $examen->note_pratique == $i) ? 'selected' : '' }}>
                                                {{ $i }}
                                                @if($i >= 8.5) 
                                                @elseif($i >= 7) 
                                                @elseif($i >= 5.5)
                                                @elseif($i >= 4) 
                                                @else 
                                                @endif
                                            </option>
                                        @endfor
                                    </select>
                                </div>

 

                            <div class="col-md-4">
                                {{-- Résumé actuel --}}
                                @if(isset($examen->note_finale))
                                    <div class="card border-success">
                                        <div class="card-header bg-success text-white">
                                            <h6 class="mb-0">
                                                <i class="fas fa-check-circle"></i> Évaluation actuelle
                                            </h6>
                                        </div>
                                        <div class="card-body">
                                            <p><strong>Note QCM:</strong> {{ $examen->score }}/10</p>
                                            <p><strong>Note Pratique:</strong> {{ $examen->note_pratique ?? 'Non évaluée' }}/10</p>
                                            <p><strong>Note Finale:</strong> 
                                                <span class="badge bg-{{ $examen->note_finale >= 5 ? 'success' : 'danger' }} fs-6">
                                                    {{ number_format($examen->note_finale, 1) }}/10
                                                </span>
                                            </p>
                                         
                                        </div>
                                    </div>
                                @endif

                                {{-- Guide de notation --}}
</div>
                        <div class="row">
                            <div class="col-12">
                                <div class="d-flex justify-content-between">
                                    <a href="" class="btn btn-secondary btn-lg">
                                        <i class="fas fa-times"></i> Annuler
                                    </a>
                                    <button type="submit" class="btn btn-success btn-lg">
                                        <i class="fas fa-save"></i> Enregistrer la notation
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const notePratiqueSelect = document.getElementById('note_pratique');
    const notePratiqueDisplay = document.getElementById('notePratiqueDisplay');
    const noteFinaleDisplay = document.getElementById('noteFinaleDisplay');
    const noteQCM = {{ $examen->score }};

    // Fonction pour calculer et afficher la note finale
    function calculerNoteFinale() {
        const notePratique = parseFloat(notePratiqueSelect.value) || 0;
        const noteFinale = (noteQCM + notePratique) / 2;
        
        notePratiqueDisplay.textContent = notePratique + '/10';
        noteFinaleDisplay.textContent = noteFinale.toFixed(1) + '/10';
        
        // Changer la couleur selon la note
        const displayElement = document.querySelector('#noteFinaleDisplay').parentElement;
        displayElement.className = 'bg-' + (noteFinale >= 5 ? 'success' : 'danger') + ' text-white p-3 rounded';
    }

    // Événement de changement de la note pratique
    notePratiqueSelect.addEventListener('change', calculerNoteFinale);

    // Calcul initial si une note est déjà sélectionnée
    if (notePratiqueSelect.value) {
        calculerNoteFinale();
    }

    // Validation du formulaire
    document.getElementById('formNotation').addEventListener('submit', function(e) {
        if (!notePratiqueSelect.value) {
            e.preventDefault();
            alert('Veuillez sélectionner une note pratique avant de valider.');
            notePratiqueSelect.focus();
            return false;
        }

        // Confirmation avant soumission
        const notePratique = parseFloat(notePratiqueSelect.value);
        const noteFinale = (noteQCM + notePratique) / 2;
        
        if (!confirm(`Confirmer la notation ?\n\nNote QCM: ${noteQCM}/10\nNote Pratique: ${notePratique}/10\nNote Finale: ${noteFinale.toFixed(1)}/10`)) {
            e.preventDefault();
            return false;
        }
    });
});
</script>
@endsection