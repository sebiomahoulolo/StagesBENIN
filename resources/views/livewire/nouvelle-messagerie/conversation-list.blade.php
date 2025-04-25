<div class="card border-0 flex-grow-1 mb-3 mb-md-0">
    <div class="card-header border-0 py-3">
        <div class="input-group">
            <span class="input-group-text bg-transparent border-end-0">
                <i class="fas fa-search"></i>
            </span>
            <input type="text" class="form-control border-start-0 ps-0" 
                   placeholder="Rechercher..." 
                   wire:model.debounce.300ms="searchTerm">
        </div>
    </div>
    
    <div class="card-body p-0">
        <div class="list-group list-group-flush scroll-shadow overflow-auto" style="max-height: calc(100vh - 220px);">
            @if(count($conversations) > 0)
                @foreach($conversations as $conversation)
                    <a href="javascript:void(0);" 
                       class="list-group-item list-group-item-action px-3 py-3 d-flex align-items-center 
                              {{ $selectedConversationId == $conversation->id ? 'active bg-light fw-bold' : '' }}"
                       wire:click="selectConversation({{ $conversation->id }})">
                       
                        <!-- Avatar du destinataire ou groupe d'avatars -->
                        <div class="position-relative me-3">
                            @php
                                $otherParticipants = $conversation->participants->filter(function($participant) {
                                    return $participant->id != auth()->id();
                                });
                                
                                $unreadCount = $conversation->unreadMessagesCount(auth()->id());
                            @endphp
                            
                            @if($conversation->is_group && $otherParticipants->count() > 1)
                                <div class="avatar-group">
                                    @foreach($otherParticipants->take(2) as $participant)
                                        <div class="avatar avatar-circle avatar-sm">
                                            @if($participant->avatar)
                                                <img src="{{ asset('storage/' . $participant->avatar) }}" alt="{{ $participant->name }}" class="avatar-img border border-2 border-white" width="40" height="40">
                                            @else
                                                <span class="avatar-title text-bg-dark border border-2 border-white">
                                                    {{ substr($participant->name, 0, 2) }}
                                                </span>
                                            @endif
                                        </div>
                                    @endforeach
                                    
                                    @if($otherParticipants->count() > 2)
                                        <div class="avatar avatar-circle avatar-sm">
                                            <span class="avatar-title text-bg-primary border border-2 border-white">
                                                {{ $otherParticipants->count() - 2 }}+
                                            </span>
                                        </div>
                                    @endif
                                </div>
                            @else
                                <div class="avatar avatar-circle avatar-sm">
                                    @if($otherParticipants->isNotEmpty() && $otherParticipants->first()->avatar)
                                        <img src="{{ asset('storage/' . $otherParticipants->first()->avatar) }}" alt="{{ $otherParticipants->first()->name }}" class="avatar-img" width="40" height="40">
                                    @else
                                        <span class="avatar-title">
                                            {{ $otherParticipants->isNotEmpty() ? substr($otherParticipants->first()->name, 0, 2) : 'ME' }}
                                        </span>
                                    @endif
                                </div>
                            @endif
                            
                            @if($unreadCount > 0)
                                <span class="position-absolute top-0 end-0 translate-middle badge rounded-pill bg-danger">
                                    {{ $unreadCount > 99 ? '99+' : $unreadCount }}
                                </span>
                            @endif
                        </div>
                        
                        <!-- Informations de la conversation -->
                        <div class="flex-grow-1 overflow-hidden">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <h6 class="mb-0 text-truncate">{{ $this->getConversationName($conversation) }}</h6>
                                <small class="text-muted ms-2">
                                    {{ $conversation->updated_at->format('H:i') }}
                                </small>
                            </div>
                            
                            <p class="mb-0 text-truncate text-muted small">
                                @if($conversation->lastMessage)
                                    @if($conversation->lastMessage->user_id == auth()->id())
                                        <span class="text-primary fw-bold">Vous:</span>
                                    @else
                                        <span class="fw-bold">{{ $conversation->lastMessage->user->name ?? 'Utilisateur' }}:</span>
                                    @endif
                                    {{ Str::limit($conversation->lastMessage->body, 30) }}
                                @else
                                    <span class="fst-italic">Aucun message</span>
                                @endif
                            </p>
                        </div>
                    </a>
                @endforeach
            @else
                <div class="p-4 text-center text-muted">
                    @if($searchTerm)
                        <p>Aucune conversation ne correspond à votre recherche</p>
                    @else
                        <p>Vous n'avez pas encore de conversations</p>
                        <p>Cliquez sur "Nouvelle conversation" pour commencer</p>
                    @endif
                </div>
            @endif
        </div>
    </div>
</div> 