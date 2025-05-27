@extends('layouts.admin.app')

@section('title', 'StagesBENIN')

@section('content')
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6 text-center alert alert-info">
            <h4>QCM</h4>
        </div>
        <div class="col-md-3"></div>
    </div>

    <form id="qcm-form" method="POST" action="{{ route('admin.entretiens.store') }}">
        @csrf

        <div class="content-area table-responsive">
            <div class="card my-3 shadow-lg rounded-3">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Sélection de l'offre</h5>
                </div>
                <div class="card-body">
                    <label for="annonce_id" class="form-label">Sélectionner l'annonce <span class="text-danger fw-bold">*</span></label>
                    <select name="annonce_id" id="annonce_id" class="form-select form-control-lg">
                        <option value="">Sélectionner l'annonce</option>
                        @foreach ($offres as $annonce)
                            <option value="{{ $annonce->id }}">{{ $annonce->nom_du_poste }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Bouton d'ajout -->
            <button id="add-questionnaire" type="button" class="btn btn-primary my-3 btn-lg w-100">
                <i class="fas fa-plus-circle me-2"></i>Ajouter une question
            </button>

            <!-- Conteneur des questionnaires -->
            <div id="qcm-container"></div>

            <!-- Bouton pour envoyer le formulaire -->
            <button type="submit" class="btn btn-success btn-lg w-100 my-4" id="submit-qcm" disabled>
                <i class="fas fa-save me-2"></i>Enregistrer le QCM
            </button>
        </div>
    </form>
@endsection

@push('scripts')
    <script>
        let questionIndex = 0;

        function toggleSubmitButton() {
            const hasQuestionnaire = $('#qcm-container .card').length > 0;
            $('#submit-qcm').prop('disabled', !hasQuestionnaire);
        }

        // Fonction pour générer une réponse
        function generateReponseInput(questionIndex, reponseIndex) {
            return `
                <div class="form-group d-flex align-items-center mb-3 reponse-item">
                    <div class="form-check me-3">
                        <input type="checkbox" class="form-check-input" value="true"
                               name="data_questions[${questionIndex}][reponses][${reponseIndex}][valide]"
                               id="reponse_${questionIndex}_${reponseIndex}">
                        <label class="form-check-label" for="reponse_${questionIndex}_${reponseIndex}">Correcte</label>
                    </div>
                    <input type="text" class="form-control"
                           name="data_questions[${questionIndex}][reponses][${reponseIndex}][texte]"
                           placeholder="Texte de la réponse">
                    <button type="button" class="btn btn-danger ms-2 remove-reponse">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            `;
        }

        // Au clic sur le bouton "Ajouter une questionnaire"
        $('#add-questionnaire').on('click', function() {
            let reponseIndex = 0;

            let card = `
                <div class="card my-4 shadow-lg rounded-3 question-card">
                    <div class="card-header bg-info text-white d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Question ${questionIndex + 1}</h5>
                        <button type="button" class="btn btn-light btn-sm remove-questionnaire">
                            <i class="fas fa-trash me-1"></i>Supprimer
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="form-group mb-4">
                            <label class="form-label">Question</label>
                            <input type="text" class="form-control form-control-lg"
                                   name="data_questions[${questionIndex}][question]"
                                   placeholder="Entrer la question">
                        </div>
                        <div class="reponses-container">
                            ${generateReponseInput(questionIndex, reponseIndex++)}
                            ${generateReponseInput(questionIndex, reponseIndex++)}
                        </div>
                        <button type="button" class="btn btn-secondary btn-sm mt-3 add-reponse"
                                data-question-index="${questionIndex}">
                            <i class="fas fa-plus me-1"></i>Ajouter une réponse
                        </button>
                    </div>
                </div>
            `;

            $('#qcm-container').append(card);
            toggleSubmitButton();
            questionIndex++;
        });

        // Délégation pour ajouter une réponse
        $(document).on('click', '.add-reponse', function() {
            const container = $(this).siblings('.reponses-container');
            const qIndex = $(this).data('question-index');
            const currentCount = container.children().length;
            container.append(generateReponseInput(qIndex, currentCount));
        });

        // Délégation pour supprimer une réponse
        $(document).on('click', '.remove-reponse', function() {
            $(this).closest('.reponse-item').remove();
        });

        // Délégation pour supprimer une carte/questionnaire
        $(document).on('click', '.remove-questionnaire', function() {
            $(this).closest('.card').remove();
            toggleSubmitButton();
        });
    </script>

    <style>
        .content-area {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .card {
            border: none;
            transition: all 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .card-header {
            border-bottom: none;
            padding: 1rem;
        }

        .form-control, .form-select {
            border-radius: 8px;
            border: 1px solid #ced4da;
            padding: 0.75rem;
            transition: all 0.3s ease;
        }

        .form-control:focus, .form-select:focus {
            border-color: #80bdff;
            box-shadow: 0 0 0 0.2rem rgba(0,123,255,.25);
        }

        .btn {
            border-radius: 8px;
            padding: 0.75rem 1.5rem;
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

        .btn-secondary {
            background: linear-gradient(45deg, #6c757d, #545b62);
            border: none;
        }

        .reponse-item {
            background-color: #f8f9fa;
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1rem;
        }

        .form-check-input {
            width: 1.2em;
            height: 1.2em;
            margin-top: 0.25em;
        }

        .form-check-label {
            font-weight: 500;
        }

        .question-card {
            background-color: #fff;
            border-radius: 15px;
            overflow: hidden;
        }

        .question-card .card-header {
            background: linear-gradient(45deg, #17a2b8, #138496);
        }

        .alert-info {
            background: linear-gradient(45deg, #17a2b8, #138496);
            color: white;
            border: none;
            border-radius: 10px;
        }

        #submit-qcm:disabled {
            background: #6c757d;
            cursor: not-allowed;
            transform: none;
        }

        .shadow-lg {
            box-shadow: 0 1rem 3rem rgba(0,0,0,.175)!important;
        }
    </style>
@endpush
