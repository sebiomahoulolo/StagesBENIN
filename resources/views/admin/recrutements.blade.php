        @extends('layouts.admin.app')

        @section('title', 'StagesBENIN')

        @push('styles')
            @section('content')
                <div class="tab-content active" id="recrutements-content" role="tabpanel" aria-labelledby="recrutements-tab">
                    <div class="action-bar">
                        <div class="action-buttons">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#recrutementModal">
                                <i class="fas fa-plus-circle me-1"></i> Ajouter Recrutement
                            </button>
                        </div>
                    </div>
                    <div class="content-area table-responsive">
                        <h4>Liste des Recrutements</h4>
                        {{-- Placeholder for Recruitment table - ensure $recrutements is passed from controller --}}
                        @if (isset($recrutements) && !$recrutements->isEmpty())
                            <p>Tableau des recrutements ici.</p>
                            {{-- Populate table similar to others --}}
                        @else
                            <div class="alert alert-info">Aucun recrutement trouvé pour le moment.</div>
                        @endif
                    </div>
                </div>
            @endsection

            @push('scripts')
                {{-- Scripts spécifiques si besoin --}}
            @endpush
