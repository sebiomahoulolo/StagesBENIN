@extends('layouts.admin.app')

@section('title', 'StagesBENIN')

@section('content')
    <div class="container-fluid mt-4"> {{-- Ajout d'un container pour une meilleure mise en page --}}
        <div class="card"> {{-- Encapsulation dans une card Bootstrap --}}
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="mb-0">Liste des Boosts Enregistrés (<span id="totalTiers">{{ $tiers->total() }}</span> affichés /
                    {{ $tiers->total() }} total)</h4>
                <div class="action-buttons">
                    {{-- Barre de recherche --}}
                    <input type="text" id="searchInput" class="form-control d-inline-block w-auto ms-3"
                        placeholder="Rechercher...">
                </div>
            </div>

            <div class="card-body">
                <div class="content-area table-responsive">
                    @if ($tiers->isNotEmpty())
                        <table class="table table-hover table-bordered align-middle" id="tierTable">
                            <thead>
                                <tr>

                                    <th>Utilisateur</th> {{-- Afficher nom ou email --}}
                                    <th>Titre Boost</th>
                                    <th>Prix (FCFA)</th>
                                    <th class="searchable">Statut Paiement</th> {{-- Rendre le statut searchable --}}
                                    <th>Date Création</th>
                                    <th>Date Paiement</th>

                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($tiers as $tier)
                                    {{-- Afficher le nom ou l'email de l'utilisateur lié (nécessite Eager Loading) --}}
                                    <td class="searchable">
                                        @if ($tier->user)
                                            <a href="#">{{-- Lien vers profil utilisateur admin ? --}}
                                                {{ $tier->user->name ?? $tier->user->email }}
                                            </a>
                                        @else
                                            Utilisateur Supprimé (ID: {{ $tier->user_id }})
                                        @endif
                                    </td>
                                    <td class="searchable">{{ $tier->title ?? '-' }}</td>
                                    <td>{{ number_format($tier->price ?? 0, 0, ',', ' ') }}</td>
                                    <td>
                                        {{-- Affichage du statut avec un badge pour la clarté --}}
                                        <span
                                            class="badge
                                            @if ($tier->payment_status === 'paid') bg-success
                                            @elseif($tier->payment_status === 'failed') bg-danger
                                            @elseif($tier->payment_status === 'pending') bg-warning text-dark
                                            @else bg-secondary @endif">
                                            {{ ucfirst($tier->payment_status ?? 'Inconnu') }}
                                        </span>
                                    </td>
                                    <td>{{ $tier->created_at?->format('d/m/Y H:i') ?? '-' }}</td>
                                    <td>{{ $tier->payment_date?->format('d/m/Y H:i') ?? '-' }}</td>

                                    <td>
                                        <div class="d-flex gap-1 flex-wrap justify-content-center">
                                            {{-- Bouton Valider : Affiché seulement si le statut N'EST PAS 'paid' --}}
                                            @if ($tier->payment_status !== 'paid')
                                                <form action="{{ route('admin.boost') }}" method="POST"
                                                    style="display:inline;"
                                                    onsubmit="return confirm('Êtes-vous sûr de vouloir marquer ce boost comme Payé ?');">
                                                    @csrf
                                                    @method('PATCH') {{-- Toujours nécessaire pour simuler PATCH --}}

                                                    {{-- CHAMP CACHÉ ESSENTIEL pour envoyer l'ID du Tier --}}
                                                    <input type="hidden" name="tier_id" value="{{ $tier->id }}">

                                                    <button type="submit" class="btn btn-warning btn-sm"
                                                        data-bs-toggle="tooltip" title="Valider le Paiement">
                                                        <i class="fas fa-check-circle"></i> Valider
                                                    </button>
                                                </form>
                                            @else
                                                {{-- Afficher un indicateur si déjà payé --}}
                                                <span class="text-white btn btn-success btn-sm" data-bs-toggle="tooltip"
                                                    title="Paiement déjà validé"><i class="fas fa-check-circle"></i>
                                                    Payé</span>
                                                    <div class="btn-group">
                                                        <a href="{{ route('admin.cvtheque.view',  $tier->etudiant_id) }}" class="btn btn-info btn-sm" title="Voir le CV">
                                                            <i class="fas fa-eye"></i> Voir
                                                        </a>
                                                    </div>
                                            @endif

                                            {{-- Autres actions possibles (Voir, Modifier, Supprimer) - À décommenter/adapter si besoin --}}
                                            {{--
                                            <a href="{{ route('admin.tiers.show', $tier->id) }}" class="btn btn-info btn-sm" data-bs-toggle="tooltip" title="Voir Détails"><i class="fas fa-eye"></i></a>
                                            <a href="{{ route('admin.tiers.edit', $tier->id) }}" class="btn btn-warning btn-sm" data-bs-toggle="tooltip" title="Modifier"><i class="fas fa-edit"></i></a>
                                            <form action="{{ route('admin.tiers.destroy', $tier->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce boost ? Cette action est irréversible.');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" data-bs-toggle="tooltip" title="Supprimer"><i class="fas fa-trash"></i></button>
                                            </form>
                                             --}}
                                        </div>
                                    </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        {{-- Liens de pagination --}}
                        <div class="d-flex justify-content-center mt-3">
                            {{ $tiers->links() }}
                        </div>
                    @else
                        <div class="alert alert-info text-center">
                            <i class="fas fa-info-circle"></i> Aucun enregistrement de boost trouvé.
                        </div>
                    @endif
                </div>
            </div> {{-- Fin card-body --}}
        </div> {{-- Fin card --}}
    </div> {{-- Fin container-fluid --}}
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Activation des tooltips Bootstrap (si vous les utilisez)
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });

            // Fonction de recherche
            const searchInput = document.getElementById("searchInput");
            const tableBody = document.querySelector("#tierTable tbody");
            const tierRows = tableBody ? tableBody.querySelectorAll("tr") : [];
            const totalTiersSpan = document.getElementById("totalTiers"); // Pour MAJ le compteur affiché

            if (searchInput && tableBody) {
                searchInput.addEventListener("keyup", function() {
                    const searchTerm = this.value.toLowerCase().trim();
                    let visibleCount = 0;

                    tierRows.forEach(row => {
                        // Recherche dans toutes les cellules ou seulement celles marquées 'searchable'
                        // Ici on recherche dans toutes les <td> pour plus de flexibilité
                        // const searchableCells = row.querySelectorAll("td.searchable"); // Option plus restrictive
                        const cells = row.querySelectorAll("td");
                        let found = false;
                        cells.forEach(cell => {
                            if (cell.textContent.toLowerCase().includes(searchTerm)) {
                                found = true;
                            }
                        });

                        // Afficher ou masquer la ligne
                        if (found) {
                            row.style.display = "";
                            visibleCount++;
                        } else {
                            row.style.display = "none";
                        }
                    });

                    // Mettre à jour le compteur affiché (optionnel)
                    // Note: $tiers->total() donne le total *avant* recherche côté client.
                    // Ce compteur reflète le nombre de lignes visibles *après* filtre JS.
                    // totalTiersSpan.textContent = `${visibleCount} affichés / {{ $tiers->total() }} total`;
                });
            } else {
                console.warn("Élément de recherche ou corps du tableau non trouvé.");
            }
        });
    </script>
@endpush
