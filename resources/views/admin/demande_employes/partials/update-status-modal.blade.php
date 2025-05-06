<div class="modal fade" id="updateStatusModal" tabindex="-1" aria-labelledby="updateStatusModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateStatusModalLabel">Mettre à jour le statut</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.demande-employes.update-status', $demande) }}" method="POST">
                @csrf
                @method('PATCH')
                <div class="modal-body">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        Statut actuel: 
                        <strong>
                            @switch($demande->status)
                                @case('en_attente')
                                    En attente
                                    @break
                                @case('active')
                                    Active
                                    @break
                                @case('fermee')
                                    Fermée
                                    @break
                                @case('archive')
                                    Archivée
                                    @break
                            @endswitch
                        </strong>
                    </div>
                    
                    <div class="mb-3">
                        <label for="status" class="form-label">Nouveau statut</label>
                        <select class="form-select" id="status" name="status" required>
                            <option value="en_attente" {{ $demande->status === 'en_attente' ? 'selected' : '' }}>En attente</option>
                            <option value="active" {{ $demande->status === 'active' ? 'selected' : '' }}>Active</option>
                            <option value="fermee" {{ $demande->status === 'fermee' ? 'selected' : '' }}>Fermée</option>
                            <option value="archive" {{ $demande->status === 'archive' ? 'selected' : '' }}>Archivée</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="notes_internes" class="form-label">Notes sur le changement (optionnel)</label>
                        <textarea class="form-control" id="notes_internes" name="notes_internes" rows="3" 
                                placeholder="Ajoutez des notes internes concernant ce changement de statut..."></textarea>
                    </div>

                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="notifier_entreprise" name="notifier_entreprise" checked>
                        <label class="form-check-label" for="notifier_entreprise">
                            Notifier l'entreprise du changement
                        </label>
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