{{-- /resources/views/etudiants/boostage.blade.php --}}
@extends('layouts.etudiant.app')

@section('title', 'StagesBENIN')

@push('styles')
<style>
    .container {
        max-width: 800px;
        margin: auto;
        background-color: #fff;
        padding: 30px;
        border-radius: 15px;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
    }

    .exam-header {
        background: linear-gradient(135deg, #ff6b6b, #ee5a24);
        color: white;
        padding: 30px;
        text-align: center;
        border-radius: 15px;
        margin-bottom: 30px;
    }

    .exam-header h1 {
        font-size: 2.5em;
        margin-bottom: 15px;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
    }

    .warning-alert {
        background: rgba(255,255,255,0.2);
        padding: 15px;
        border-radius: 10px;
        margin-top: 20px;
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255,255,255,0.3);
    }

    .info-section {
        background: linear-gradient(135deg, #74b9ff, #0984e3);
        color: white;
        padding: 25px;
        border-radius: 15px;
        margin-bottom: 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 20px;
    }

    .info-item {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 1.1em;
        font-weight: 600;
    }

    .timer {
        font-size: 1.5em;
        font-weight: bold;
        color: #ffeaa7;
        text-shadow: 1px 1px 2px rgba(0,0,0,0.3);
    }

    .timer.warning {
        color: #ff6b6b;
        animation: pulse 1s infinite;
    }

    @keyframes pulse {
        0% { opacity: 1; }
        50% { opacity: 0.7; }
        100% { opacity: 1; }
    }

    .comment-section {
        padding: 20px;
        background: #f8f9fa;
        border-radius: 15px;
        margin-bottom: 20px;
        text-align: center;
    }

    .comment-btn {
        background: linear-gradient(135deg, #00b894, #00a085);
        color: white;
        border: none;
        padding: 12px 25px;
        border-radius: 25px;
        cursor: pointer;
        font-size: 1em;
        font-weight: 600;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(0,184,148,0.3);
    }

    .comment-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0,184,148,0.4);
        color: white;
    }

    .comment-modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.8);
        z-index: 1000;
    }

    .modal-content {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background: white;
        padding: 30px;
        border-radius: 15px;
        max-width: 500px;
        width: 90%;
        text-align: center;
        box-shadow: 0 20px 40px rgba(0,0,0,0.3);
    }

    .modal-content h3 {
        color: #2d3436;
        margin-bottom: 20px;
    }

    .modal-content textarea {
        width: 100%;
        height: 120px;
        margin: 20px 0;
        padding: 15px;
        border: 2px solid #ddd;
        border-radius: 10px;
        font-family: inherit;
        resize: vertical;
        transition: border-color 0.3s ease;
    }

    .modal-content textarea:focus {
        border-color: #00b894;
        outline: none;
    }

    .modal-buttons {
        display: flex;
        gap: 15px;
        justify-content: center;
    }

    .modal-btn {
        border: none;
        padding: 12px 25px;
        border-radius: 8px;
        cursor: pointer;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .modal-btn.save {
        background: #00b894;
        color: white;
    }

    .modal-btn.cancel {
        background: #fd79a8;
        color: white;
    }

    .modal-btn:hover {
        transform: translateY(-2px);
    }

    .question-container {
        background: #f8f9fa;
        border-radius: 15px;
        padding: 25px;
        margin-bottom: 25px;
        border-left: 5px solid #667eea;
        transition: all 0.3s ease;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
    }

    .question-container:hover {
        transform: translateX(5px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
    }

    .question-container p {
        font-size: 1.2em;
        font-weight: bold;
        color: #2d3436;
        margin-bottom: 20px;
    }

    .form-check {
        display: flex;
        align-items: center;
        margin-bottom: 15px;
        padding: 15px;
        background: white;
        border-radius: 10px;
        cursor: pointer;
        transition: all 0.3s ease;
        border: 2px solid transparent;
    }

    .form-check:hover {
        background: #e3f2fd;
        border-color: #2196f3;
    }

    .form-check-input {
        margin-right: 15px;
        transform: scale(1.2);
    }

    .form-check-label {
        font-weight: 500;
        color: #495057;
        cursor: pointer;
        flex: 1;
    }

    .btn-group {
        display: flex;
        justify-content: space-between;
        gap: 20px;
        margin-top: 30px;
        padding: 30px;
        background: #f8f9fa;
        border-radius: 15px;
    }

    .btn {
        padding: 15px 30px;
        border-radius: 25px;
        font-size: 1.1em;
        font-weight: bold;
        transition: all 0.3s ease;
        flex: 1;
        max-width: 200px;
        text-decoration: none;
        text-align: center;
        display: inline-block;
    }

    .btn-outline-secondary {
        background: linear-gradient(135deg, #fd79a8, #e84393);
        color: white;
        border: none;
        box-shadow: 0 4px 15px rgba(232,67,147,0.3);
    }

    .btn-primary {
        background: linear-gradient(135deg, #00b894, #00a085);
        color: white;
        border: none;
        box-shadow: 0 4px 15px rgba(0,184,148,0.3);
    }

    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0,0,0,0.2);
        color: white;
        text-decoration: none;
    }

    .exam-completed {
        display: none;
        text-align: center;
        padding: 60px 30px;
        background: linear-gradient(135deg, #00b894, #00a085);
        color: white;
        border-radius: 15px;
        box-shadow: 0 20px 40px rgba(0,0,0,0.1);
    }

    .exam-completed h2 {
        font-size: 2.5em;
        margin-bottom: 20px;
    }

    .no-exam-message {
        display: none;
        text-align: center;
        padding: 60px 30px;
        background: white;
        border-radius: 15px;
        box-shadow: 0 20px 40px rgba(0,0,0,0.1);
    }

    .no-exam-message h2 {
        color: #636e72;
        font-size: 2em;
        margin-bottom: 20px;
    }

    .no-exam-message p {
        color: #74b9ff;
        font-size: 1.2em;
    }

    /* Styles pour les résultats existants */
    .results-section {
        margin-top: 40px;
    }

    @media (max-width: 768px) {
        .info-section {
            flex-direction: column;
            text-align: center;
        }
        
        .btn-group {
            flex-direction: column;
        }
        
        .btn {
            max-width: none;
        }

        .exam-header h1 {
            font-size: 1.8em;
        }
    }
</style>
@endpush

@section('content')
<div class="container">
    <!-- Interface d'examen -->
    <div id="examInterface">
        <div class="exam-header">
            <h1>🎓 Examen QCM pour l'entretien</h1>
            <div class="warning-alert">
                <strong>⚠️ Attention !</strong> Un score en dessous de 12/20 entraîne une disqualification automatique.
            </div>
        </div>



        <form action="{{ route('etudiants.examen.submit', ['etudiant_id' => $etudiant->id]) }}" method="POST">
            @csrf
            <input type="hidden" name="etudiant_id" value="{{ $etudiant->id }}">
        @if($examen)
            <div class="info-section">
                <div class="info-item">
                    <span>💼</span>
                    <span>
                        <strong>Poste :</strong> 
                        @foreach ($entretiens_planifies as $entretien)
                            {{ $entretien->annonce->nom_du_poste ?? 'Non défini' }}
                        @endforeach
                    </span>
                </div>
                <div class="info-item">
                    <span>📅</span>
                    <span><strong>Date :</strong> <span id="currentDate"></span></span>
                </div>
                <div class="info-item timer">
                    <span>⏰</span>
                    <span><strong>Temps restant :</strong> <span id="countdown">30:00</span></span>
                </div>
            </div>

            <!-- Section commentaire
            <div class="comment-section">
                <button type="button" class="comment-btn" onclick="showCommentModal()">
                    💬 Ajouter un commentaire
                </button>
            </div> -->
        @endif
            @foreach ($questions as $question)
                <div class="question-container">
                    <p><strong>Question :</strong> {{ $question->question }}</p>

                    @if (!empty($question->options))
                        @foreach ($question->options as $option)
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="reponses[{{ $question->id }}]" value="{{ $option }}" required>
                                <label class="form-check-label">{{ $option }}</label>
                            </div>
                        @endforeach
                    @else
                        <p class="text-danger">⚠️ Aucune option disponible pour cette question.</p>
                    @endif
                </div>
            @endforeach

            <div class="btn-group">
                <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary" onclick="return confirm('Êtes-vous sûr de vouloir annuler l\'examen ?')">❌ Annuler</a>
                <button type="submit" class="btn btn-primary" onclick="return confirmSubmit()">✅ Soumettre le test</button>
            </div>
        </form>
    </div>

    <!-- Message d'examen terminé -->
    <div id="examCompleted" class="exam-completed">
        <h2>🎉 Examen terminé !</h2>
        <p>Votre test a été soumis avec succès. Les résultats seront communiqués prochainement.</p>
    </div>

    <!-- Message aucun entretien -->
    <div id="noExamMessage" class="no-exam-message">
        <h2>📋 Aucun entretien n'est en cours</h2>
        <p>Il n'y a actuellement aucun examen disponible. Veuillez contacter l'administrateur pour plus d'informations.</p>
    </div>
</div>

<!-- Modal pour les commentaires 
<div id="commentModal" class="comment-modal">
    <div class="modal-content">
        <h3>💬 Commentaire sur l'examen</h3>
        <p><strong>Durée d'examen :</strong> <span id="examDuration">0 minutes</span></p>
        <textarea id="commentText" placeholder="Ajoutez votre commentaire ici..." maxlength="500"></textarea>
        <div class="modal-buttons">
            <button type="button" class="modal-btn save" onclick="saveComment()">Sauvegarder</button>
            <button type="button" class="modal-btn cancel" onclick="closeCommentModal()">Fermer</button>
        </div>
    </div>
</div>-->

<!-- Section des résultats (gardée identique) -->
@if(isset($examen) && $examen && $examen->score !== null)
<div class="results-section">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card shadow rounded mb-4">
                    <div class="card-header bg-success text-white text-center">
                        <h4>🎓 Résultat de l'examen</h4>
                    </div>

                    <div class="card-body text-center">
                        <h5 class="mb-3">Félicitations pour avoir terminé l'examen !</h5>

                        <p><strong>Score :</strong> {{ $examen->score }}/20</p>
                        <p><strong>Nombre de questions :</strong> {{ $examen->total_questions }}</p>
                        <p><strong>Bonnes réponses :</strong> {{ $examen->bonnes_reponses }}</p>

                        @php
                            $score = $examen->score;
                            if ($score >= 16) {
                                $commentaire = "Excellent travail, vous maîtrisez bien le sujet ! 🎉";
                            } elseif ($score >= 12) {
                                $commentaire = "Bon résultat, continuez à progresser ! 👍";
                            } elseif ($score >= 8) {
                                $commentaire = "Résultat moyen, un peu plus d'effort serait bénéfique. 💪";
                            } else {
                                $commentaire = "Il faut travailler davantage, ne baissez pas les bras ! 🚀";
                            }
                        @endphp

                        <div class="alert alert-info mt-4" role="alert">
                            {{ $commentaire }}
                        </div>

                        <hr>
                    </div>

                    <div class="card-footer text-muted text-center">
                        Passé le {{ \Carbon\Carbon::parse($examen->date_passage)->format('d/m/Y à H:i') }}
                    </div>
                </div>

                {{-- Détail des réponses --}}
                @php
                    $reponsesEtudiant = $examen->reponses ? json_decode($examen->reponses, true) : [];
                    $questions = !empty($reponsesEtudiant) ? \App\Models\Question::whereIn('id', array_keys($reponsesEtudiant))->get() : collect();
                @endphp

                @if($questions->count() > 0)
                <div class="card shadow rounded">
                    <div class="card-header bg-info text-white">
                        <h5>📋 Détail des réponses</h5>
                    </div>

                    <div class="card-body">
                        @foreach($questions as $index => $question)
                            @php
                                $reponsesCorrectes = \App\Models\Reponse::where('question_id', $question->id)
                                    ->where('valide', 1)
                                    ->pluck('texte')
                                    ->toArray();

                                $reponsesDonnees = $reponsesEtudiant[$question->id] ?? '';

                                if (!is_array($reponsesDonnees)) {
                                    $reponsesDonnees = [$reponsesDonnees];
                                }

                                $reponsesDonnees = array_filter($reponsesDonnees, function($value) {
                                    return !empty($value);
                                });
                            @endphp

                            <div class="mb-4">
                                <h6 class="text-primary"><strong>Question {{ $index + 1 }} :</strong> {{ $question->question }}</h6>

                                <div class="mb-2">
                                    <strong>Votre réponse :</strong>
                                    @if(!empty($reponsesDonnees))
                                        @foreach($reponsesDonnees as $rep)
                                            <span class="badge bg-{{ in_array($rep, $reponsesCorrectes) ? 'success' : 'danger' }}">
                                                {{ $rep }}
                                            </span>
                                        @endforeach
                                    @else
                                        <span class="badge bg-secondary">Aucune réponse</span>
                                    @endif
                                </div>

                                <div>
                                    <strong>Bonne(s) réponse(s) :</strong>
                                    @if(!empty($reponsesCorrectes))
                                        @foreach($reponsesCorrectes as $rc)
                                            <span class="badge bg-success">{{ $rc }}</span>
                                        @endforeach
                                    @else
                                        <span class="badge bg-warning">Aucune réponse correcte définie</span>
                                    @endif
                                </div>

                                @if($index < $questions->count() - 1)
                                    <hr>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endif

@endsection

@push('scripts')
<script>
// Variables globales
let examStartTime = new Date();
let examDuration = 60 * 30; // 30 minutes en secondes
let timeLeft = examDuration;
let examSubmitted = false;
let timerInterval;

const countdownElement = document.getElementById('countdown');

// Initialisation
document.addEventListener('DOMContentLoaded', function() {
    // Afficher la date actuelle
    const currentDateElement = document.getElementById('currentDate');
    if (currentDateElement) {
        currentDateElement.textContent = new Date().toLocaleDateString('fr-FR');
    }
    
    // Démarrer le timer
    if (countdownElement) {
        startTimer();
    }
});

// Gestion du timer
function startTimer() {
    timerInterval = setInterval(function() {
        if (timeLeft <= 0) {
            clearInterval(timerInterval);
            autoSubmitExam();
            return;
        }
        
        const minutes = Math.floor(timeLeft / 60);
        const seconds = timeLeft % 60;
        
        countdownElement.textContent = 
            `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
        
        // Changer la couleur et ajouter animation quand il reste moins de 5 minutes
        if (timeLeft <= 300) {
            countdownElement.parentElement.classList.add('warning');
        }
        
        timeLeft--;
    }, 1000);
}

// Calculer la durée de l'examen
function getExamDuration() {
    const now = new Date();
    const durationMs = now - examStartTime;
    return Math.floor(durationMs / (1000 * 60)); // en minutes
}

// Afficher le modal de commentaire
function showCommentModal() {
    const duration = getExamDuration();
    document.getElementById('examDuration').textContent = duration + ' minute' + (duration > 1 ? 's' : '');
    document.getElementById('commentModal').style.display = 'block';
}

// Fermer le modal de commentaire
function closeCommentModal() {
    document.getElementById('commentModal').style.display = 'none';
}

// Sauvegarder le commentaire
function saveComment() {
    const comment = document.getElementById('commentText').value.trim();
    if (comment) {
        // Ici, vous pourriez envoyer le commentaire au serveur via AJAX
        // Pour l'instant, on le stocke localement
        sessionStorage.setItem('examComment', comment);
        alert('💬 Commentaire sauvegardé avec succès !');
        closeCommentModal();
    } else {
        alert('⚠️ Veuillez saisir un commentaire.');
    }
}

// Confirmer la soumission
function confirmSubmit() {
    if (examSubmitted) return false;
    
    return confirm('Êtes-vous sûr de vouloir soumettre votre examen ? Cette action est irréversible.');
}

// Soumission automatique quand le temps est écoulé
function autoSubmitExam() {
    if (examSubmitted) return;
    
    alert('⏰ Temps écoulé ! L\'examen va être soumis automatiquement.');
    examSubmitted = true;
    
    // Soumettre le formulaire
    const form = document.querySelector('form');
    if (form) {
        form.submit();
    }
}

// Gérer la soumission du formulaire
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    if (form) {
        form.addEventListener('submit', function(e) {
            if (examSubmitted) return;
            
            examSubmitted = true;
            clearInterval(timerInterval);
            
            // Animation de transition
            setTimeout(function() {
                document.getElementById('examInterface').style.display = 'none';
                document.getElementById('examCompleted').style.display = 'block';
                
                // Après 3 secondes, afficher le message "aucun entretien"
                setTimeout(function() {
                    document.getElementById('examCompleted').style.display = 'none';
                    document.getElementById('noExamMessage').style.display = 'block';
                }, 3000);
            }, 1000);
        });
    }
});

// Fermer la modal en cliquant à l'extérieur
document.getElementById('commentModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeCommentModal();
    }
});

// Empêcher la fermeture accidentelle de la page
window.addEventListener('beforeunload', function(e) {
    if (!examSubmitted && timeLeft > 0) {
        e.preventDefault();
        e.returnValue = 'Êtes-vous sûr de vouloir quitter ? Votre examen sera perdu.';
    }
});

// Empêcher le clic droit et certaines touches
document.addEventListener('contextmenu', function(e) {
    e.preventDefault();
});

document.addEventListener('keydown', function(e) {
    // Empêcher F12, Ctrl+Shift+I, Ctrl+U, etc.
    if (e.key === 'F12' || 
        (e.ctrlKey && e.shiftKey && e.key === 'I') ||
        (e.ctrlKey && e.shiftKey && e.key === 'C') ||
        (e.ctrlKey && e.key === 'u')) {
        e.preventDefault();
    }
});
</script>
@endpush