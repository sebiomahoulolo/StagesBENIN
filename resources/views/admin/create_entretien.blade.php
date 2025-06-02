@extends('layouts.admin.app')

@section('title', 'StagesBENIN')

@section('content')
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6 text-center alert alert-info">
            <h4>Etablir le QCM pour l'entretien {{ $entretien->reference }}</h4>
        </div>
        <div class="col-md-3"></div>
    </div>

    <form id="qcm-form" method="POST" action="{{ route('admin.entretiens.storeQuestionnaire') }}">
        @csrf

        <div class="content-area table-responsive">
            {{-- <div class="card my-3 shadow-lg rounded-3">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">{{ $entretien->reference }}</h5>
                </div>
            </div> --}}
            <input type="hidden" name="annonce_id" id="annonce_id" class="form-control form-control-md" value="{{ $entretien->id }}" readonly>

            <!-- Bouton d'ajout -->
            <div class="d-flex gap-3 my-3">
                <button id="add-questionnaire" type="button" class="btn btn-primary btn-md flex-grow-1">
                    <i class="fas fa-plus-circle me-2"></i>Ajouter une question QCM
                </button>
                <button id="add-cas-pratique" type="button" class="btn btn-success btn-md flex-grow-1">
                    <i class="fas fa-file-alt me-2"></i>Ajouter un cas pratique
                </button>
            </div>

            <!-- Conteneur des questionnaires -->
            <div id="qcm-container">
                @if(isset($questions) && count($questions) > 0)
                    @foreach($questions as $index => $question)
                        <div class="card my-4 shadow-lg rounded-3 question-card">
                            <div class="card-header bg-info text-white d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">Question {{ $index + 1 }}</h5>
                                <button type="button" class="btn btn-light btn-sm remove-questionnaire">
                                    <i class="fas fa-trash me-1"></i>Supprimer
                                </button>
                            </div>
                            <div class="card-body">
                                <div class="form-group mb-4">
                                    <label class="form-label">Question</label>
                                    <input type="text" class="form-control form-control-lg"
                                           name="data_questions[{{ $index }}][question]"
                                           value="{{ $question->question }}"
                                           placeholder="Entrer la question">
                                </div>
                                <div class="reponses-container">
                                    @foreach($question->reponses as $reponseIndex => $reponse)
                                        <div class="form-group d-flex align-items-center mb-3 reponse-item">
                                            <div class="form-check me-3">
                                                <input type="checkbox" class="form-check-input" value="true"
                                                       name="data_questions[{{ $index }}][reponses][{{ $reponseIndex }}][valide]"
                                                       id="reponse_{{ $index }}_{{ $reponseIndex }}"
                                                       {{ $reponse->valide ? 'checked' : '' }}>
                                                <label class="form-check-label" for="reponse_{{ $index }}_{{ $reponseIndex }}">Correcte</label>
                                            </div>
                                            <input type="text" class="form-control"
                                                   name="data_questions[{{ $index }}][reponses][{{ $reponseIndex }}][texte]"
                                                   value="{{ $reponse->texte }}"
                                                   placeholder="Texte de la réponse">
                                            <button type="button" class="btn btn-danger ms-2 remove-reponse">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </div>
                                    @endforeach
                                </div>
                                <button type="button" class="btn btn-secondary btn-sm mt-3 add-reponse"
                                        data-question-index="{{ $index }}">
                                    <i class="fas fa-plus me-1"></i>Ajouter une réponse
                                </button>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>

            <!-- Conteneur des cas pratiques -->
            <div id="cas-pratique-container">
            </div>

            <!-- Bouton pour envoyer le formulaire -->
            <button type="submit" class="btn btn-success btn-md w-100 my-4" id="submit-qcm">
                <i class="fas fa-save me-2"></i>Enregistrer le QCM
            </button>
        </div>
    </form>
@endsection

@push('scripts')
    <script>
        let questionIndex = {{ isset($questions) ? count($questions) : 0 }};
        let casPratiqueIndex = 0;

        function toggleSubmitButton() {
            const hasQuestionnaire = $('#qcm-container .card').length > 0;
            const hasCasPratique = $('#cas-pratique-container .card').length > 0;
            $('#submit-qcm').prop('disabled', !(hasQuestionnaire || hasCasPratique));
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

        // Fonction pour générer un cas pratique
        function generateCasPratique() {
            return `
                <div class="card my-4 shadow-lg rounded-3 cas-pratique-card">
                    <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Cas Pratique ${casPratiqueIndex + 1}</h5>
                        <button type="button" class="btn btn-light btn-sm remove-cas-pratique">
                            <i class="fas fa-trash me-1"></i>Supprimer
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="form-group mb-4">
                            <label class="form-label">Énoncé du cas pratique</label>
                            <textarea class="form-control form-control-lg"
                                    name="data_cas_pratique[${casPratiqueIndex}][question]"
                                    rows="4"
                                    placeholder="Entrer l'énoncé du cas pratique"></textarea>
                        </div>
                       
                    </div>
                </div>
            `;
        }

        // Au clic sur le bouton "Ajouter une question QCM"
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

        // Au clic sur le bouton "Ajouter un cas pratique"
        $('#add-cas-pratique').on('click', function() {
            $('#cas-pratique-container').append(generateCasPratique());
            toggleSubmitButton();
            casPratiqueIndex++;
        });

        // Délégation pour supprimer un cas pratique
        $(document).on('click', '.remove-cas-pratique', function() {
            $(this).closest('.cas-pratique-card').remove();
            toggleSubmitButton();
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

        // Initialiser l'état du bouton submit
        toggleSubmitButton();
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

        .question-card, .cas-pratique-card {
            background-color: #fff;
            border-radius: 15px;
            overflow: hidden;
        }

        .question-card .card-header {
            background: linear-gradient(45deg, #17a2b8, #138496);
        }

        .cas-pratique-card .card-header {
            background: linear-gradient(45deg, #28a745, #1e7e34);
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

        textarea.form-control {
            min-height: 120px;
            resize: vertical;
        }
    </style>
@endpush
