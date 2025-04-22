<div class="card border-0 flex-md-grow-1">
    @php
        use App\Models\User;
    @endphp
    <div class="card-header border-0">
        <div class="input-group input-group-merge">
            <!-- Input -->
            <input type="text" wire:model.debounce.300ms="searchTerm" class="form-control bg-light-green border-0" placeholder="Rechercher contact...">
            <!-- Button -->
            <span class="input-group-text p-0 border-0 bg-light-green">
                <button class="btn btn-link text-secondary px-3" type="button">
                    <svg viewBox="0 0 24 24" height="18" width="18" xmlns="http://www.w3.org/2000/svg">
                        <path d="M0.750 9.812 A9.063 9.063 0 1 0 18.876 9.812 A9.063 9.063 0 1 0 0.750 9.812 Z" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" transform="translate(-3.056 4.62) rotate(-23.025)"/>
                        <path d="M16.221 16.22L23.25 23.25" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"/>
                    </svg>
                </button>
            </span>
        </div>
    </div>
    <div class="position-relative h-100 min-vh-50 min-vh-md-25 min-vh-md-auto">
        <div class="overflow-auto position-absolute w-100 h-100 rounded-bottom">
            <div class="list-group rounded-0">
                @forelse($conversations as $conversation)
                    <a href="javascript:void(0);" 
                       wire:key="conversation-{{ $conversation->id }}"
                       wire:click="selectConversation({{ $conversation->id }})" 
                       class="list-group-item list-group-item-action border-0 {{ $selectedConversationId == $conversation->id ? 'active' : '' }}">
                        <div class="d-flex align-items-center">
                            @php
                                // Vérifier si c'est une conversation de groupe
                                $isGroup = $conversation->is_group || $conversation->participants->count() > 2;
                                
                                // Pour les conversations privées, trouver l'autre utilisateur
                                $otherUser = null;
                                $displayName = $conversation->name;
                                
                                if (!$isGroup) {
                                    // Récupérer l'autre utilisateur de la collection de participants
                                    $otherParticipant = $conversation->participants->where('id', '!=', auth()->id())->first();
                                    if ($otherParticipant) {
                                        $displayName = $otherParticipant->name;
                                        $otherUser = $otherParticipant;
                                    } else {
                                        $displayName = 'Contact';
                                    }
                                } elseif (empty($displayName)) {
                                    // Pour un groupe sans nom défini, créer un nom par défaut
                                    $displayName = 'Groupe (' . $conversation->participants->count() . ')';
                                }
                                
                                // Calculer le statut de lecture
                                $authUser = $conversation->participants->where('id', auth()->id())->first();
                                $lastRead = $authUser ? $authUser->pivot->last_read : null;
                                $hasUnread = $conversation->lastMessage && (!$lastRead || $conversation->lastMessage->created_at > $lastRead);
                                
                                // Classes pour les avatars
                                $statusClass = $hasUnread ? 'avatar-online' : '';
                                $bgClass = $isGroup ? ($conversation->participants->count() > 3 ? 'text-bg-primary-soft' : 'text-bg-success-soft') : '';
                            @endphp
                            
                            <div class="avatar avatar-circle avatar-xs {{ $statusClass }} me-2 position-relative">
                                @if($isGroup)
                                    <span class="avatar-title {{ $bgClass }}">{{ substr($displayName, 0, 2) }}</span>
                                @elseif($otherUser && !empty($otherUser->avatar))
                                    <img src="{{ asset('storage/' . $otherUser->avatar) }}" alt="{{ $displayName }}" class="avatar-img" width="30" height="30">
                                @else
                                    <span class="avatar-title bg-secondary">{{ substr($displayName, 0, 2) }}</span>
                                @endif
                                
                                @if($hasUnread)
                                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" 
                                          style="font-size: 0.65rem; transform: translate(-50%, -50%);">
                                        !
                                    </span>
                                @endif
                            </div>
                            <div class="d-flex flex-fill flex-column text-truncate">
                                <span class="fw-bold d-inline-block text-truncate">{{ $displayName }}</span>
                                <span class="fs-5 d-inline-block {{ $hasUnread ? 'fw-bold' : 'text-body-secondary' }} text-truncate">
                                    {{ $conversation->lastMessage ? Str::limit($conversation->lastMessage->body, 40) : 'Pas de messages' }}
                                </span>
                            </div>
                            <span class="d-flex align-self-start fs-6 text-body-secondary">
                                {{ $conversation->lastMessage ? $conversation->lastMessage->created_at->format('d.m.Y') : '' }}
                            </span>
                        </div>
                    </a>
                @empty
                    <div class="text-center p-4 text-body-secondary">
                        <p>Aucune conversation trouvée</p>
                        <p>Commencez une nouvelle conversation!</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
