@extends('layouts.admin.app')

@section('title', 'StagesBENIN')

@section('content')
<div class="tab-content active" id="entreprises-content" role="tabpanel" aria-labelledby="entreprises-tab">
    <div class="action-bar d-flex justify-content-between align-items-center">
        <h4 class="mb-0">Liste des Entreprises (<span id="totalEntreprises">{{ $entreprises->count() }}</span>)</h4>
        <div class="action-buttons">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#entrepriseModal">
                <i class="fas fa-plus-circle me-1"></i> Ajouter Entreprise
            </button>
            <input type="text" id="searchInput" class="form-control ms-3" placeholder="Rechercher par nom, secteur, email ou téléphone...">
        </div>
    </div>

    <div class="content-area table-responsive mt-3">
        @if ($entreprises->isNotEmpty())
            <table class="table table-hover table-bordered align-middle" id="entrepriseTable">
                <thead>
                    <tr>
                       
                        <th>Nom</th>
                        <th>Secteur</th>
                        <th>Email</th>
                        <th>Téléphone</th>
                        <th>Logo</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($entreprises as $entreprise)
                        <tr>
                           
                            <td class="searchable">{{ $entreprise->nom }}</td>
                            <td class="searchable">{{ $entreprise->secteur ?? '-' }}</td>
                            <td class="searchable">{{ $entreprise->email }}</td>
                            <td class="searchable">{{ $entreprise->telephone ?? '-' }}</td>
                            <td>
                                @if ($entreprise->logo_path && Storage::exists($entreprise->logo_path))
                                    <img src="{{ Storage::url($entreprise->logo_path) }}" alt="Logo {{ $entreprise->nom }}" style="width:40px;height:40px; object-fit:contain;">
                                @else
                                    <span class="text-muted small">N/A</span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex gap-1 flex-wrap">
                                    <a href="{{ route('entreprises.show', $entreprise->id) }}" class="btn btn-info btn-sm" data-bs-toggle="tooltip" title="Voir"><i class="fas fa-eye"></i></a>
                                    <a href="{{--{{ route('entreprises.contact', $entreprise->id) }}--}}" class="btn btn-primary btn-sm" data-bs-toggle="tooltip" title="Contacter"><i class="fas fa-envelope"></i></a>
                                    <a href="{{ route('entreprises.follow', $entreprise->id) }}" class="btn btn-success btn-sm" data-bs-toggle="tooltip" title="Suivre"><i class="fas fa-star"></i></a>
                                    <a href="{{--{{ route('entreprises.edit', $entreprise->id) }}--}}" class="btn btn-warning btn-sm" data-bs-toggle="tooltip" title="Modifier"><i class="fas fa-edit"></i></a>
                                    <!--form action="{{--{{ route('entreprises.destroy', $entreprise->id) }}--}}" method="POST" style="display:inline;" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette entreprise?');">
                                        {{--@csrf--}}
                                        {{--@method('DELETE')--}}
                                        <button type="submit" class="btn btn-danger btn-sm" data-bs-toggle="tooltip" title="Supprimer"><i class="fas fa-trash"></i></button>
                                    </form -->
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $entreprises->links() }}
        @else
            <div class="alert alert-info text-center">
                <i class="fas fa-exclamation-circle"></i> Aucune entreprise trouvée pour le moment.
            </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.getElementById("searchInput").addEventListener("keyup", function() {
        const value = this.value.toLowerCase();
        let count = 0;

        document.querySelectorAll("#entrepriseTable tbody tr").forEach(row => {
            const found = [...row.querySelectorAll(".searchable")].some(cell => 
                cell.textContent.toLowerCase().includes(value)
            );
            row.style.display = found ? "" : "none";

            if (found) count++;
        });

        document.getElementById("totalEntreprises").textContent = count;
    });
</script>
@endpush