{{-- Vue Blade corrigée - resultats_pratique.blade.php --}}
@extends('layouts.admin.app')

@section('title', 'StagesBENIN')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Résultats des Examens Pratiques</h3>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Nom</th>
                                <th>Niveau</th>
                                <th>Formation</th>
                                <th>Note QCM</th>
                                <th>Total Questions</th>
                                <th>Bonnes Réponses</th>
                                <th>Date Passage</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($examens as $examen)
                                <tr>
                                    <td>{{ $examen->etudiant->nom ?? 'N/A' }}</td>
                                    <td>{{ $examen->etudiant->niveau ?? 'N/A' }}</td>
                                    <td>{{ $examen->etudiant->formation ?? 'N/A' }}</td>
                                    <td>
                                        <span class="{{ $examen->score >= 5 ? 'success' : 'danger' }}">
                                            {{ $examen->score }}/10
                                        </span>
                                    </td>
                                    <td>{{ $examen->total_questions }}</td>
                                    <td>{{ $examen->bonnes_reponses }}</td>
                                    <td>{{ $examen->created_at->format('d/m/Y H:i') }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            {{-- Action Voir le CV --}}
                                            <a href="{{ route('admin.cvtheque.view', $examen->etudiant->id) }}" 
                                               class="btn btn-info btn-sm" 
                                               title="Voir le CV">
                                                <i class="fas fa-eye"></i> Voir
                                            </a>
                                            
                                            {{-- Action Noter --}}
                                            <button type="button" 
                                                    class="btn btn-success btn-sm" 
                                                    data-toggle="modal" 
                                                    data-target="#modalNoter{{ $examen->id }}"
                                                    title="Noter l'examen">
                                                <i class="fas fa-star"></i> Noter
                                            </button>
                                        </div>
                                    </td>
                                </tr>

                                {{-- Modal pour noter --}}
                                <div class="modal fade" id="modalNoter{{ $examen->id }}" tabindex="-1" role="dialog">
                                    <div class="modal-dialog modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">
                                                    Noter l'examen de {{ $examen->etudiant->nom }}
                                                </h5>
                                                <button type="button" class="close" data-dismiss="modal">
                                                    <span>&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                {{-- Informations de l'étudiant --}}
                                                <div class="row mb-3">
                                                    <div class="col-md-6">
                                                        <strong>Étudiant:</strong> {{ $examen->etudiant->nom }}<br>
                                                        <strong>Formation:</strong> {{ $examen->etudiant->formation }}<br>
                                                        <strong>Niveau:</strong> {{ $examen->etudiant->niveau }}
                                                    </div>
                                                    <div class="col-md-6">
                                                        <strong>Date d'examen:</strong> {{ $examen->created_at->format('d/m/Y H:i') }}<br>
                                                        <strong>Score actuel:</strong> {{ $examen->score }}/10<br>
                                                        <strong>Réponses correctes:</strong> {{ $examen->bonnes_reponses }}/{{ $examen->total_questions }}
                                                    </div>
                                                </div>

                                                <hr>

                                                {{-- Questions et réponses --}}
                                                <h6>Questions et Réponses:</h6>
                                                <div class="accordion" id="accordionQuestions{{ $examen->id }}">
                                                    @if(isset($examen->reponses_details) && is_array($examen->reponses_details))
                                                        @foreach($examen->reponses_details as $index => $reponse)
                                                            <div class="card">
                                                                <div class="card-header" id="heading{{ $examen->id }}_{{ $index }}">
                                                                    <h6 class="mb-0">
                                                                        <button class="btn btn-link collapsed" type="button" 
                                                                                data-toggle="collapse" 
                                                                                data-target="#collapse{{ $examen->id }}_{{ $index }}">
                                                                            Question {{ $index + 1 }}
                                                                            <span class="badge badge-{{ $reponse['correct'] ? 'success' : 'danger' }} ml-2">
                                                                                {{ $reponse['correct'] ? 'Correct' : 'Incorrect' }}
                                                                            </span>
                                                                        </button>
                                                                    </h6>
                                                                </div>
                                                                <div id="collapse{{ $examen->id }}_{{ $index }}" 
                                                                     class="collapse" 
                                                                     data-parent="#accordionQuestions{{ $examen->id }}">
                                                                    <div class="card-body">
                                                                        <p><strong>Question:</strong> {{ $reponse['question'] }}</p>
                                                                        <p><strong>Réponse donnée:</strong> 
                                                                            <span class="text-{{ $reponse['correct'] ? 'success' : 'danger' }}">
                                                                                {{ $reponse['reponse_donnee'] }}
                                                                            </span>
                                                                        </p>
                                                                        @if(!$reponse['correct'])
                                                                            <p><strong>Bonne réponse:</strong> 
                                                                                <span class="text-success">{{ $reponse['bonne_reponse'] }}</span>
                                                                            </p>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    @else
                                                        <div class="alert alert-info">
                                                            Les détails des réponses ne sont pas disponibles pour cet examen.
                                                        </div>
                                                    @endif
                                                </div>

                                                <hr>

                                                {{-- Formulaire de notation --}}
                                                <form action="" method="POST">
                                                    @csrf
                                                    <div class="form-group">
                                                        <label for="note{{ $examen->id }}">
                                                            <strong>Attribuer une note finale:</strong>
                                                        </label>
                                                        <select name="note" id="note{{ $examen->id }}" class="form-control" required>
                                                            <option value="">-- Sélectionner une note --</option>
                                                            @for($i = 1; $i <= 9; $i++)
                                                                <option value="{{ $i }}" {{ (isset($examen->note_finale) && $examen->note_finale == $i) ? 'selected' : '' }}>
                                                                    {{ $i }}/9
                                                                </option>
                                                            @endfor
                                                        </select>
                                                    </div>
                                                    
                                                    <div class="form-group">
                                                        <label for="commentaire{{ $examen->id }}">Commentaire (optionnel):</label>
                                                        <textarea name="commentaire" 
                                                                  id="commentaire{{ $examen->id }}" 
                                                                  class="form-control" 
                                                                  rows="3" 
                                                                  placeholder="Commentaire sur la performance de l'étudiant...">{{ $examen->commentaire ?? '' }}</textarea>
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                                    Annuler
                                                </button>
                                                <button type="submit" 
                                                        form="formNote{{ $examen->id }}" 
                                                        class="btn btn-success">
                                                    <i class="fas fa-save"></i> Enregistrer la note
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center">Aucun examen trouvé</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Script pour améliorer l'UX --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Soumettre le formulaire quand on clique sur le bouton de sauvegarde
    document.querySelectorAll('[data-target^="#modalNoter"]').forEach(function(button) {
        button.addEventListener('click', function() {
            const modalId = this.getAttribute('data-target');
            const modal = document.querySelector(modalId);
            
            // Ajouter l'événement de soumission au bouton de sauvegarde
            const saveButton = modal.querySelector('.btn-success');
            const form = modal.querySelector('form');
            
            saveButton.addEventListener('click', function(e) {
                e.preventDefault();
                form.submit();
            });
        });
    });
});
</script>
@endsection