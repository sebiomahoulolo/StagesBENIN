@extends('layouts.admin.app')

@section('title', 'StagesBENIN')

@section('content')
<div class="content-area table-responsive">
    <h4>Liste des Étudiants et Entretiens</h4>

    @if(isset($etudiants) && !$etudiants->isEmpty())
        <table class="table table-hover table-bordered align-middle">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Email</th>
                    <th>Offre</th>
                    <th>Actions - Entretiens</th>
                    <th>Actions - Candidatures</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($etudiants as $etudiant)
                    <tr>
                        <td>{{ $etudiant->nom }}</td>
                        <td>{{ $etudiant->email }}</td>
                        <td>{{ $etudiant->offre->titre ?? '-' }}</td>
                        <td>
                            <div class="d-flex gap-1">
                                {{-- Télécharger le CV --}}
                                @if(isset($etudiant->cv))
                                    <a href="{{ route('etudiants.cv.download', $etudiant->id) }}" class="btn btn-secondary btn-sm" data-bs-toggle="tooltip" title="Télécharger CV">
                                        <i class="fas fa-file-download"></i> CV
                                    </a>
                                @endif

                                {{-- Planifier un entretien --}}
                                <a href="{{ route('etudiants.entretiens', ['etudiant_id' => $etudiant->id]) }}" class="btn btn-primary btn-sm" data-bs-toggle="tooltip" title="Planifier entretien">
                                    Entretien
                                </a>

                                {{-- Envoyer un examen --}}
                                <a href="{{ route('etudiants.envoyer.examen', $etudiant->id) }}" class="btn btn-warning btn-sm" data-bs-toggle="tooltip" title="Envoyer examen">
                                    Examen
                                </a>
                            </div>
                        </td>
                        <td>
                            <div class="d-flex gap-1">
                                {{-- Accepter la candidature --}}
                                <form action="{{ route('candidatures.accepter', $etudiant->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Confirmer l\'acceptation de cette candidature ?');">
                                    @csrf
                                    <button type="submit" class="btn btn-success btn-sm" data-bs-toggle="tooltip" title="Accepter">
                                        Accepter
                                    </button>
                                </form>

                                {{-- Rejeter la candidature --}}
                                <form action="{{ route('candidatures.rejeter', $etudiant->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Confirmer le rejet de cette candidature ?');">
                                    @csrf
                                    <button type="submit" class="btn btn-outline-danger btn-sm" data-bs-toggle="tooltip" title="Rejeter">
                                        Rejeter
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $etudiants->links() }} {{-- Pagination --}}
    @else
        <div class="alert alert-info">Aucun étudiant trouvé pour le moment.</div>
    @endif
</div>
@endsection
