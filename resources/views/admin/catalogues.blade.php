@extends('layouts.admin.app')

@section('title', 'StagesBENIN')

@push('styles')
    @section('content')

        <div class="tab-content active" id="catalogue-content" role="tabpanel" aria-labelledby="catalogue-tab">
            <div class="action-bar">
                <div class="action-buttons">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#catalogueModal">
                        <i class="fas fa-plus-circle me-1"></i> Ajouter au Catalogue
                    </button>
                </div>
            </div>
            <div class="content-area table-responsive">
                <h4> Liste des Catalogues</h4>
                @if (isset($catalogueItems) && !$catalogueItems->isEmpty())
                    <table class="table table-bordered table-striped">
                        <thead class="table">
                            <tr>
                                <th>Nom de l'Établissement</th>
                                <th>Localisation</th>
                                <th>Activités principale</th>
                                <!--th>Actions</th>
                        </tr-->
                        </thead>
                        <tbody>
                            @foreach ($catalogueItems as $index => $item)
                                <tr>
                                    <td>{{ $item->titre }}</td>
                                    <td>{{ $item->localisation }}</td>
                                    <td>{{ $item->activite_principale }}</td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="alert alert-info">Aucun élément trouvé dans le catalogue pour le moment.</div>
                @endif
            </div>
        </div>
        </div>
    @endsection

    @push('scripts')
        {{-- Scripts spécifiques si besoin --}}
    @endpush
