@if($demandes->isEmpty())
    <div class="text-center py-4">
        <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
        <p>Aucune demande trouvée dans cette catégorie.</p>
    </div>
@else
    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Entreprise</th>
                    <th>Poste</th>
                    <th>Type</th>
                    <th>Lieu</th>
                    <th>Date limite</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($demandes as $demande)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                @if($demande->entreprise->logo_path)
                                    <img src="{{ asset($demande->entreprise->logo_path) }}" alt="Logo" class="me-2 rounded-circle" style="width: 32px; height: 32px; object-fit: cover;">
                                @endif
                                {{ $demande->entreprise->nom }}
                            </div>
                        </td>
                        <td>
                            <div class="fw-semibold">{{ $demande->titre_poste }}</div>
                            @if($demande->urgent)
                                <span class="badge bg-danger">Urgent</span>
                            @endif
                        </td>
                        <td>{{ $demande->type_contrat }}</td>
                        <td>{{ $demande->lieu_travail }}</td>
                        <td>
                            @if($demande->date_limite)
                                {{ \Carbon\Carbon::parse($demande->date_limite)->format('d/m/Y') }}
                            @else
                                <span class="text-muted">Non définie</span>
                            @endif
                        </td>
                        <td>
                            @switch($demande->status)
                                @case('en_attente')
                                    <span class="badge bg-warning">En attente</span>
                                    @break
                                @case('active')
                                    <span class="badge bg-success">Active</span>
                                    @break
                                @case('fermee')
                                    <span class="badge bg-danger">Fermée</span>
                                    @break
                                @case('archive')
                                    <span class="badge bg-secondary">Archivée</span>
                                    @break
                            @endswitch
                        </td>
                        <td>
                            <div class="btn-group">
                                <a href="{{ route('admin.demande-employes.show', $demande) }}" class="btn btn-sm btn-outline-primary" title="Voir les détails">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <button type="button" class="btn btn-sm btn-outline-success update-status-btn" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#updateStatusModal" 
                                        data-demande-id="{{ $demande->id }}"
                                        data-current-status="{{ $demande->status }}"
                                        title="Mettre à jour le statut">
                                    <i class="fas fa-sync-alt"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
    <div class="d-flex justify-content-center mt-4">
        {{ $demandes->links() }}
    </div>
@endif

<!-- Update Status Modal -->
<div class="modal fade" id="updateStatusModal" tabindex="-1" aria-labelledby="updateStatusModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateStatusModalLabel">Mettre à jour le statut</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="updateStatusForm" method="POST">
                @csrf
                @method('PATCH')
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="status" class="form-label">Nouveau statut</label>
                        <select class="form-select" id="status" name="status" required>
                            <option value="en_attente">En attente</option>
                            <option value="active">Active</option>
                            <option value="fermee">Fermée</option>
                            <option value="archive">Archivée</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="notes_internes" class="form-label">Notes internes (optionnel)</label>
                        <textarea class="form-control" id="notes_internes" name="notes_internes" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const updateStatusModal = document.getElementById('updateStatusModal');
    const updateStatusForm = document.getElementById('updateStatusForm');
    const statusSelect = document.getElementById('status');

    document.querySelectorAll('.update-status-btn').forEach(button => {
        button.addEventListener('click', function() {
            const demandeId = this.dataset.demandeId;
            const currentStatus = this.dataset.currentStatus;
            
            // Update form action URL
            updateStatusForm.action = `/admin/demande-employes/${demandeId}/status`;
            
            // Set current status as selected
            statusSelect.value = currentStatus;
        });
    });
});
</script>
@endpush