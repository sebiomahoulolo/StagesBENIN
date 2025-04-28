<div class="card border-0 flex-grow-1">
    <div class="card-header border-0 d-flex align-items-center justify-content-between">
        <h3 class="card-title h4 mb-0">Nouvelle conversation</h3>
        <button type="button" class="btn-close" wire:click="cancel"></button>
    </div>
    
    <div class="card-body">
        @if(!$canCreateConversation)
            <div class="alert alert-warning">
                <i class="fas fa-exclamation-triangle me-2"></i>
                Vous n'êtes pas autorisé à créer une nouvelle conversation.
            </div>
        @else
            <form wire:submit.prevent="createConversation">
                <!-- Recherche de destinataires -->
                <div class="mb-4">
                    <label class="form-label">Destinataires</label>
                    <div class="input-group mb-2">
                        <span class="input-group-text">
                            <i class="fas fa-search"></i>
                        </span>
                        <input type="text" class="form-control" 
                               placeholder="Rechercher un destinataire..." 
                               wire:model.debounce.300ms="searchTerm">
                    </div>
                    
                    <!-- Affichage des destinataires sélectionnés -->
                    @if(count($selectedRecipients) > 0)
                        <div class="selected-recipients d-flex flex-wrap my-2">
                            @foreach($selectedRecipients as $recipientId)
                                @php
                                    $recipient = $recipients->firstWhere('id', $recipientId);
                                @endphp
                                @if($recipient)
                                    <div class="badge bg-primary d-flex align-items-center me-2 mb-2 p-2">
                                        <span>{{ $recipient->name }}</span>
                                        <button type="button" class="btn-close btn-close-white ms-2" 
                                                wire:click="toggleRecipient({{ $recipientId }})"
                                                style="font-size: 0.5rem;"></button>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    @endif
                    
                    @error('selectedRecipients')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                    
                    <!-- Liste des destinataires disponibles -->
                    <div class="recipients-list mt-3 border rounded overflow-auto p-2" style="max-height: 250px;">
                        @if($recipients->count() > 0)
                            @foreach($recipients as $recipient)
                                <div class="recipient-item p-2 rounded {{ $this->isSelected($recipient->id) ? 'bg-light' : '' }}"
                                     wire:click="toggleRecipient({{ $recipient->id }})">
                                    <div class="d-flex align-items-center">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" 
                                                   {{ $this->isSelected($recipient->id) ? 'checked' : '' }}>
                                        </div>
                                        <div class="avatar avatar-circle avatar-xs me-2">
                                            @if($recipient->avatar)
                                                <img src="{{ asset('storage/' . $recipient->avatar) }}" alt="{{ $recipient->name }}" class="avatar-img" width="32" height="32">
                                            @else
                                                <span class="avatar-title">{{ substr($recipient->name, 0, 2) }}</span>
                                            @endif
                                        </div>
                                        <div class="recipient-info">
                                            <div class="recipient-name">{{ $recipient->name }}</div>
                                            <div class="recipient-email text-muted small">{{ $recipient->email }}</div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="text-center p-3 text-muted">
                                @if($searchTerm)
                                    <p class="mb-0">Aucun résultat pour "{{ $searchTerm }}"</p>
                                @else
                                    <p class="mb-0">Aucun destinataire disponible</p>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
                
                <!-- Nom du groupe (visible uniquement si plusieurs destinataires) -->
                @if(count($selectedRecipients) > 1)
                    <div class="mb-4">
                        <label for="name" class="form-label">Nom du groupe</label>
                        <input type="text" class="form-control" id="name" 
                               wire:model.defer="name" 
                               placeholder="Entrez un nom pour le groupe">
                        @error('name')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                @endif
                
                <!-- Message initial -->
                <div class="mb-4">
                    <label for="message" class="form-label">Premier message</label>
                    <textarea class="form-control" id="message" 
                              wire:model.defer="message" 
                              rows="4" 
                              placeholder="Écrivez votre message..."></textarea>
                    @error('message')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>
                
                <!-- Boutons d'action -->
                <div class="d-flex justify-content-end">
                    <button type="button" class="btn btn-secondary me-2" wire:click="cancel">
                        Annuler
                    </button>
                    <button type="submit" class="btn btn-primary" {{ count($selectedRecipients) === 0 ? 'disabled' : '' }}>
                        Créer la conversation
                    </button>
                </div>
            </form>
        @endif
    </div>
</div> 