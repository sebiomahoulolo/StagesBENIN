@extends('layouts.admin.app')

@section('title', 'StagesBENIN')

@push('styles')
    @section('content')
        <div class="tab-content active" id="actualites-content" role="tabpanel" aria-labelledby="actualites-tab">
            <div class="action-bar">
                <div class="action-buttons">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#actualiteModal">
                        <i class="fas fa-plus-circle me-1"></i> Ajouter Actualité
                    </button>
                </div>
            </div>
            <div class="content-area table-responsive">
                <h4>Liste des Actualités</h4>
                {{-- Ensure $actualites is passed from the controller --}}
                @if (isset($actualites) && !$actualites->isEmpty())
                    <table class="table table-hover table-bordered align-middle">
                        <thead>
                            <tr>
                                <th>Titre</th>
                                <th>Catégorie</th>
                                <th>Auteur</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($actualites as $actualite)
                                <tr>
                                    <td>{{ $actualite->titre }}</td>
                                    <td>{{ $actualite->categorie ?? '-' }}</td>
                                    <td>{{ $actualite->auteur ?? '-' }}</td>
                                    <td>{{ $actualite->date_publication ? \Carbon\Carbon::parse($actualite->date_publication)->isoFormat('DD MMM YYYY') : '-' }}
                                    </td>
                                    {{-- <td>
                                    Status - Assuming an 'is_published' field 
                                    @if ($actualite->is_published)
                                        <span class="badge bg-success">Publiée</span>
                                    @else
                                        <span class="badge bg-secondary">Brouillon</span>
                                    @endif
                                </td> --}}
                                    <td>
                                        <div class="d-flex gap-1">
                                            {{-- Ensure routes exist --}}
                                            {{-- <a href="{{ route('actualites.show', $actualite->id) }}" class="btn btn-info btn-sm" data-bs-toggle="tooltip" title="Voir"><i class="fas fa-eye"></i></a> --}}
                                            <a href="{{ route('actualites.edit', $actualite->id) }}"
                                                class="btn btn-warning btn-sm" data-bs-toggle="tooltip" title="Modifier"><i
                                                    class="fas fa-edit"></i></a>
                                            <form action="{{ route('actualites.destroy', $actualite->id) }}" method="POST"
                                                style="display: inline-block;"
                                                onsubmit="return confirm('Confirmer la suppression de cette actualité ?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" data-bs-toggle="tooltip"
                                                    title="Supprimer">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $actualites->links() }} {{-- Render pagination links --}}
                @else
                    <div class="alert alert-info">Aucune actualité trouvée pour le moment.</div>
                @endif
            </div>
        </div>
    @endsection
    @push('scripts')
        {{-- Scripts spécifiques si besoin --}}
    @endpush
