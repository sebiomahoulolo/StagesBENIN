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
        justify-content: center;
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
        text-decoration: none;
        text-align: center;
        display: inline-block;
        cursor: pointer;
    }

    .btn-primary {
        background: linear-gradient(135deg, #00b894, #00a085);
        color: white;
        border: none;
        box-shadow: 0 4px 15px rgba(0,184,148,0.3);
    }

    .btn-secondary {
        background: linear-gradient(135deg, #74b9ff, #0984e3);
        color: white;
        border: none;
        box-shadow: 0 4px 15px rgba(116,185,255,0.3);
    }

    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0,0,0,0.2);
        color: white;
        text-decoration: none;
    }

    /* Sections d'affichage */
    .exam-interface,
    .results-section,
    .no-exam-message {
        display: none;
    }

    .exam-interface.active,
    .results-section.active,
    .no-exam-message.active {
        display: block;
    }

    .results-section {
        text-align: center;
        padding: 40px;
        background: linear-gradient(135deg, #4a91fa, #00a085);
        color: white;
        border-radius: 15px;
        box-shadow: 0 20px 40px rgba(0,0,0,0.1);
    }

    .results-section h2 {
        font-size: 2.5em;
        margin-bottom: 20px;
    }

    .score-display {
        font-size: 2em;
        margin: 20px 0;
        padding: 20px;
        background: rgba(255,255,255,0.2);
        border-radius: 10px;
        backdrop-filter: blur(10px);
    }

    .result-details {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
        margin: 30px 0;
    }

    .result-item {
        background: rgba(255,255,255,0.2);
        padding: 20px;
        border-radius: 10px;
        backdrop-filter: blur(10px);
    }

    .no-exam-message {
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

    .loading-spinner {
        display: none;
        text-align: center;
        padding: 40px;
    }

    .loading-spinner.active {
        display: block;
    }

    .spinner {
        border: 4px solid #f3f3f3;
        border-top: 4px solid #00b894;
        border-radius: 50%;
        width: 50px;
        height: 50px;
        animation: spin 1s linear infinite;
        margin: 0 auto 20px;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
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
            width: 100%;
        }

        .exam-header h1 {
            font-size: 1.8em;
        }

        .result-details {
            grid-template-columns: 1fr;
        }
    }
</style>
@endpush

@section('content')
<div class="container">
    <!-- Interface d'entretien -->
    <div id="examInterface" class="exam-interface {{ !isset($examen) || $examen->score === null ? 'active' : '' }}">
        @if(count($questions) > 0)
            <div class="exam-header">
                <h1>🎓 QCM pour l'entretien</h1>
                <div class="warning-alert">
                    <strong>⚠️ Attention !</strong> Une note en dessous de 12/20 entraîne une disqualification automatique.
                </div>
            </div>

            <div class="info-section">
                <div class="info-item">
                    <span></span>
                    <span>
                        <strong></strong> 
                        {{-- @foreach ($entretiens_planifies as $entretien)
                            {{ $entretien->annonce->nom_du_poste ?? 'Non défini' }}
                        @endforeach --}}
                    </span>
                </div>
                <div class="info-item timer">
                    <span>⏰</span>
                    <span><strong>Temps restant :</strong> <span id="countdown">{{ $entretien->duree ?? '30:00' }}</span></span>
                </div>
            </div>

         <form id="examForm" action="{{ route('etudiants.examen.submit', ['etudiant_id' => $etudiant->id]) }}" method="POST">
    @csrf
    <input type="hidden" name="etudiant_id" value="{{ $etudiant->id }}">

    @php $numeroQuestion = 1; @endphp

    @foreach ($questions as $question)
        <div class="question-container mb-4">
            <p><strong>Question {{ $numeroQuestion }} :</strong> {{ $question->question }}</p>

            @php
                $type = $question->type; // 'qcm' ou 'cas_pratique'
                $reponses = $question->reponses;
            @endphp

            {{-- QCM --}}
            @if ($type === 'qcm' && $reponses->count())
                @php $bonnes_reponses = $reponses->where('valide', 1); @endphp

                @if ($bonnes_reponses->count() === 1)
                    {{-- Choix unique (radio) --}}
                    @foreach ($reponses as $reponse)
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="reponses[{{ $question->id }}]" value="{{ $reponse->texte }}" required>
                            <label class="form-check-label">{{ $reponse->texte }}</label>
                        </div>
                    @endforeach
                @elseif ($bonnes_reponses->count() > 1)
                    {{-- Choix multiple (checkbox) --}}
                    @foreach ($reponses as $reponse)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="reponses[{{ $question->id }}][]" value="{{ $reponse->texte }}">
                            <label class="form-check-label">{{ $reponse->texte }}</label>
                        </div>
                    @endforeach
                @else
                    <p class="text-danger">⚠️ Aucune bonne réponse définie pour cette question.</p>
                @endif

            {{-- Cas pratique --}}
            @elseif ($type === 'cas_pratique')
                <textarea name="reponses[{{ $question->id }}]" class="form-control pratique-textarea" maxlength="340" rows="4" required></textarea>
                <small class="text-muted"><span class="caracteres-restants">340</span> caractères restants</small>

            {{-- Type non reconnu --}}
            @else
                <p class="text-danger">⚠️ Type de question inconnu.</p>
            @endif
        </div>

        @php $numeroQuestion++; @endphp
    @endforeach

    <div class="btn-group">
        <button type="submit" class="btn btn-primary">✅ Soumettre l'entretien</button>
    </div>
</form>


<script>
    document.addEventListener('DOMContentLoaded', function () {
        const textareas = document.querySelectorAll('textarea[maxlength="340"]');

        textareas.forEach(function (textarea) {
            // Création de l'affichage du compteur
            const counter = document.createElement('small');
            counter.classList.add('form-text', 'text-muted');
            counter.innerText = `340 caractères restants`;
            textarea.parentNode.appendChild(counter);

            // Fonction de mise à jour du compteur
            const updateCounter = () => {
                const remaining = 340 - textarea.value.length;
                counter.innerText = `${remaining} caractère${remaining !== 1 ? 's' : ''} restant${remaining !== 1 ? 's' : ''}`;
                counter.style.color = remaining <= 10 ? 'red' : '#6c757d'; // rouge si proche de la limite
            };

            // Initialisation
            textarea.addEventListener('input', updateCounter);
        });
    });
</script>

        @else
            <div class="no-exam-message active">
                <h2>📋 Aucun entretien disponible</h2>
                <p>Il n'y a actuellement aucun entretien ou question disponible.</p>
                <div style="margin-top: 30px;">
                    <a href="{{ route('etudiants.dashboard') }}" class="btn btn-secondary">
                        🏠 Retour au tableau de bord
                    </a>
                </div>
            </div>
        @endif
    </div>

    <!-- Indicateur de chargement -->
    <div id="loadingSpinner" class="loading-spinner">
        <div class="spinner"></div>
        <h3>Traitement de votre examen...</h3>
        <p>Veuillez patienter pendant que nous calculons vos résultats.</p>
    </div>

    <!-- Section des résultats -->
    <div id="resultsSection" class="results-section {{ isset($examen) && $examen->score !== null ? 'active' : '' }}">
        @if(isset($examen) && $examen->score !== null)
        
        <h2>Résultats de votre entretien</h2>
             <div class="warning-alert">
                    <strong>⚠️ Attention !</strong> Une note en dessous de 12/20 entraîne une disqualification automatique.
                </div>   
            <div class="score-display">
                <strong>Votre note : {{ $examen->score }}/20</strong>
            </div>

            <div class="result-details">
                <div class="result-item">
                    <h4>📊 Questions totales</h4>
                    <p>{{ $examen->total_questions }}</p>
                </div>
                <div class="result-item">
                    <h4>✅ Bonnes réponses</h4>
                    <p>{{ $examen->bonnes_reponses }}</p>
                </div>
                <div class="result-item">
                    <h4>❌ Mauvaises réponses</h4>
                    <p>{{ $examen->total_questions - $examen->bonnes_reponses }}</p>
                </div>
            </div>

            @php
                $score = $examen->score;
                if ($score >= 16) {
                    $commentaire = "🌟 Excellent travail.";
                } elseif ($score >= 12) {
                    $commentaire = "👍 Bon résultat.";
                } elseif ($score >= 8) {
                    $commentaire = "⚠️ Résultat moyen. Il serait bien de réviser certains points.";
                } else {
                    $commentaire = "❌ Résultat insuffisant. Nous vous encourageons à approfondir vos connaissances.";
                }
            @endphp

            <div style="background: rgba(255,255,255,0.2); padding: 20px; border-radius: 10px; margin: 30px 0;">
                <h4>💬 Commentaire</h4>
                <p>{{ $commentaire }}</p>
            </div>

            <div style="margin-top: 40px;">
                <a href="{{ route('etudiants.dashboard') }}" class="btn btn-secondary" style="background: rgba(255,255,255,0.2); border: 2px solid white;">
                    🏠 Fermer et retourner au tableau de bord
                </a>
            </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
// Variables globales
let examStartTime = new Date();
let examDuration = {{ isset($entretien) && $entretien->duree ? $entretien->duree * 60 : 30 * 60 }}; // Durée en secondes
let timeLeft = examDuration;
let examSubmitted = false;
let timerInterval;

const countdownElement = document.getElementById('countdown');
const examInterface = document.getElementById('examInterface');
const loadingSpinner = document.getElementById('loadingSpinner');
const resultsSection = document.getElementById('resultsSection');

// Initialisation
document.addEventListener('DOMContentLoaded', function() {
    console.log('Page chargée, initialisation...');
    
    // Vérifier s'il y a déjà un examen terminé
    if (resultsSection && resultsSection.classList.contains('active')) {
        console.log('Examen déjà terminé, affichage des résultats');
        return;
    }
    
    // Démarrer le timer si l'interface d'examen est active
    if (examInterface && examInterface.classList.contains('active') && countdownElement) {
        console.log('Démarrage du timer pour', examDuration, 'secondes');
        startTimer();
    }
    
    // Gérer la soumission du formulaire
    const examForm = document.getElementById('examForm');
    if (examForm) {
        examForm.addEventListener('submit', handleExamSubmission);
    }
});

// Gestion du timer
function startTimer() {
    // Mettre à jour immédiatement l'affichage
    updateTimerDisplay();
    
    timerInterval = setInterval(function() {
        timeLeft--;
        
        updateTimerDisplay();
        
        // Changer la couleur et ajouter animation quand il reste moins de 5 minutes
        if (timeLeft <= 300 && timeLeft > 0) {
            countdownElement.parentElement.classList.add('warning');
        }
        
        // Temps écoulé
        if (timeLeft <= 0) {
            clearInterval(timerInterval);
            autoSubmitExam();
        }
    }, 1000);
}

function updateTimerDisplay() {
    if (!countdownElement) return;
    
    const minutes = Math.floor(timeLeft / 60);
    const seconds = timeLeft % 60;
    
    countdownElement.textContent = 
        `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
}

// Gérer la soumission de l'examen
function handleExamSubmission(e) {
    e.preventDefault();
    
    if (examSubmitted) {
        console.log('Examen déjà soumis');
        return false;
    }
    
    // Confirmer la soumission
    if (!confirm('Êtes-vous sûr de vouloir soumettre votre examen ? Cette action est irréversible.')) {
        return false;
    }
    
    console.log('Soumission de l\'examen...');
    examSubmitted = true;
    
    // Arrêter le timer
    if (timerInterval) {
        clearInterval(timerInterval);
    }
    
    // Afficher le spinner de chargement
    showLoadingSpinner();
    
    // Soumettre le formulaire via AJAX pour une meilleure expérience
    submitExamViaAjax();
}

function showLoadingSpinner() {
    if (examInterface) {
        examInterface.classList.remove('active');
    }
    if (loadingSpinner) {
        loadingSpinner.classList.add('active');
    }
}

function submitExamViaAjax() {
    const form = document.getElementById('examForm');
    const formData = new FormData(form);
    
    fetch(form.action, {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || 
                           document.querySelector('input[name="_token"]')?.value
        }
    })
    .then(response => {
        if (response.ok) {
            // Simuler un délai pour l'expérience utilisateur
            setTimeout(() => {
                window.location.reload();
            }, 2000);
        } else {
            throw new Error('Erreur lors de la soumission');
        }
    })
    .catch(error => {
        console.error('Erreur:', error);
        // En cas d'erreur, soumettre le formulaire normalement
        form.submit();
    });
}

// Soumission automatique quand le temps est écoulé
function autoSubmitExam() {
    if (examSubmitted) return;
    
    alert('⏰ Temps écoulé ! L\'examen va être soumis automatiquement.');
    
    // Déclencher la soumission
    const submitEvent = new Event('submit', { bubbles: true, cancelable: true });
    const form = document.getElementById('examForm');
    if (form) {
        form.dispatchEvent(submitEvent);
    }
}

// Empêcher la fermeture accidentelle de la page
window.addEventListener('beforeunload', function(e) {
    if (!examSubmitted && timeLeft > 0 && examInterface && examInterface.classList.contains('active')) {
        e.preventDefault();
        e.returnValue = 'Êtes-vous sûr de vouloir quitter ? Votre examen sera perdu.';
    }
});

// Empêcher certaines actions pendant l'examen
document.addEventListener('contextmenu', function(e) {
    if (examInterface && examInterface.classList.contains('active') && !examSubmitted) {
        e.preventDefault();
    }
});

document.addEventListener('keydown', function(e) {
    if (examInterface && examInterface.classList.contains('active') && !examSubmitted) {
        // Empêcher F12, Ctrl+Shift+I, Ctrl+U, etc.
        if (e.key === 'F12' || 
            (e.ctrlKey && e.shiftKey && e.key === 'I') ||
            (e.ctrlKey && e.shiftKey && e.key === 'C') ||
            (e.ctrlKey && e.key === 'u')) {
            e.preventDefault();
        }
    }
});

// Debug: afficher les informations importantes
console.log('Configuration de l\'examen:', {
    examDuration: examDuration,
    timeLeft: timeLeft,
    examSubmitted: examSubmitted
});
</script>
@endpush