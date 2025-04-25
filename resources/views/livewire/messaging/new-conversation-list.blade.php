<div class="card flex-grow-1 border-0 stretch-card">
    <div class="card-header border-0 bg-transparent py-3">
        <div class="input-group">
            <span class="input-group-text bg-transparent border-end-0">
                <i class="fas fa-search"></i>
            </span>
            <input type="text" class="form-control border-start-0 ps-0" placeholder="Rechercher..." wire:model.debounce.300ms="searchQuery">
        </div>
    </div>
    <div class="card-body p-0 overflow-auto scroll-shadow" style="max-height: calc(100vh - 250px);">
        <div class="list-group list-group-flush">
            @forelse($conversations as $conversation)
                @php
                    $unreadCount = $conversation->unreadMessagesCount(Auth::id());
                    $otherParticipant = $conversation->participants->first();
                    $isGroup = $conversation->is_group;
                    $lastMessage = $conversation->lastMessage;
                @endphp
                <a href="#" class="list-group-item list-group-item-action p-3 {{ $selectedConversationId == $conversation->id ? 'active' : '' }}"
                   wire:click.prevent="selectConversation({{ $conversation->id }})">
                    <div class="d-flex">
                        <div class="flex-shrink-0 me-3">
                            @if($isGroup)
                                <div class="avatar-group">
                                    @foreach($conversation->participants->take(3) as $participant)
                                        <div class="avatar avatar-xs avatar-circle">
                                            <div class="avatar-title">{{ substr($participant->name, 0, 1) }}</div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="avatar avatar-sm avatar-circle">
                                    <div class="avatar-title">{{ substr($otherParticipant->name, 0, 1) }}</div>
                                </div>
                            @endif
                        </div>
                        <div class="flex-grow-1 min-width-0">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <h5 class="text-truncate mb-0">
                                    {{ $isGroup ? $conversation->name : $otherParticipant->name }}
                                </h5>
                                <small class="text-muted">
                                    {{ $lastMessage ? $lastMessage->created_at->diffForHumans(null, true, true) : '' }}
                                </small>
                            </div>
                            <div class="d-flex justify-content-between">
                                <p class="text-truncate mb-0 small">
                                    @if($lastMessage)
                                        @if($lastMessage->user_id == Auth::id())
                                            <span class="text-muted">Vous:</span>
                                        @endif
                                        {{ Str::limit($lastMessage->body, 30) }}
                                    @else
                                        <span class="text-muted">Pas de messages</span>
                                    @endif
                                </p>
                                @if($unreadCount > 0)
                                    <span class="badge rounded-pill bg-primary ms-2">{{ $unreadCount }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </a>
            @empty
                <div class="text-center py-4">
                    <p class="text-muted mb-0">Aucune conversation trouvée</p>
                </div>
            @endforelse
        </div>
    </div>
</div> 