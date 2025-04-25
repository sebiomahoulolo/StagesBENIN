<div class="card-body p-0 d-flex flex-column">
    <div class="conversation-header bg-light border-bottom p-3">
        <div class="d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                @if($conversation->is_group)
                    <div class="avatar-group me-3">
                        @foreach($participants->take(3) as $participant)
                            <div class="avatar avatar-sm avatar-circle position-relative">
                                <div class="avatar-title bg-primary">{{ substr($participant->name, 0, 1) }}</div>
                            </div>
                        @endforeach
                    </div>
                    <div>
                        <h5 class="mb-0">{{ $conversation->name }}</h5>
                        <small class="text-muted">{{ $participants->count() }} participants</small>
                    </div>
                @else
                    <div class="avatar avatar-sm me-3 avatar-circle position-relative avatar-online">
                        <div class="avatar-title bg-primary">{{ substr($participants->first()->name ?? '?', 0, 1) }}</div>
                    </div>
                    <div>
                        <h5 class="mb-0">{{ $participants->first()->name ?? 'Conversation' }}</h5>
                        <small class="text-muted">En ligne</small>
                    </div>
                @endif
            </div>
            <div>
                @if($isAdminOrEnterprise())
                <div class="dropdown">
                    <button class="btn btn-icon btn-light" id="conversation-actions" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-ellipsis-v"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="conversation-actions">
                        <li><h6 class="dropdown-header">Options</h6></li>
                        <li><a class="dropdown-item" href="#"><i class="fas fa-info-circle me-2"></i> Infos de la conversation</a></li>
                        <li><a class="dropdown-item" href="#"><i class="fas fa-search me-2"></i> Rechercher</a></li>
                        <li><a class="dropdown-item" href="#"><i class="fas fa-bell-slash me-2"></i> Désactiver les notifications</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item text-danger" href="#"><i class="fas fa-trash-alt me-2"></i> Supprimer la conversation</a></li>
                    </ul>
                </div>
                @endif
            </div>
        </div>
    </div>

    <div id="messageContainer" class="flex-grow-1 overflow-auto p-3" style="max-height: calc(100vh - 300px);" wire:poll.10s>
        <!-- Messages -->
        @if($messageCount > count($messages))
            <div class="text-center mb-3">
                <button class="btn btn-sm btn-light" wire:click="loadMoreMessages">
                    Charger les messages précédents
                </button>
            </div>
        @endif
        
        @foreach($messages as $message)
            @php
                $isMine = $message->user_id === Auth::id();
                $senderName = $message->user->name;
                $isImage = $message->isImage();
                $isVideo = $message->isVideo();
                $isFile = $message->isFile() || $message->isAudio();
            @endphp
            
            <div class="message-item d-flex flex-column {{ $isMine ? 'align-items-end' : 'align-items-start' }} mb-3">
                @if(!$isMine)
                    <div class="d-flex align-items-center mb-1">
                        <div class="avatar avatar-xs avatar-circle me-2">
                            <div class="avatar-title bg-{{ $isMine ? 'primary' : 'secondary' }}">
                                {{ substr($senderName, 0, 1) }}
                            </div>
                        </div>
                        <small class="text-muted">{{ $senderName }}</small>
                    </div>
                @endif
                
                <div class="message-content {{ $isMine ? 'bg-primary text-white' : 'bg-light' }} rounded p-3 shadow-sm"
                     style="max-width: 75%;">
                    @if($isImage)
                        <img src="{{ Storage::url($message->attachments->first()->file_path) }}" class="img-fluid rounded" alt="Image">
                    @elseif($isVideo)
                        <video controls class="w-100 rounded">
                            <source src="{{ Storage::url($message->attachments->first()->file_path) }}" type="{{ $message->attachments->first()->file_type }}">
                            Votre navigateur ne supporte pas la lecture de vidéos.
                        </video>
                    @elseif($isFile)
                        <div class="d-flex align-items-center">
                            <i class="fas fa-file-alt fa-2x text-{{ $isMine ? 'white' : 'primary' }} me-2"></i>
                            <div>
                                <div>{{ $message->attachments->first()->file_name }}</div>
                                <small>{{ round($message->attachments->first()->file_size / 1024) }} KB</small>
                            </div>
                        </div>
                    @else
                        <div class="message-text">{{ $message->body }}</div>
                    @endif
                </div>
                
                <div class="d-flex align-items-center mt-1">
                    <small class="text-muted me-2">{{ $message->created_at->format('H:i') }}</small>
                    @if($isMine)
                        <small class="text-muted">
                            <i class="fas fa-check{{ $message->is_read ? '-double' : '' }} me-2"></i>
                        </small>
                    @endif
                    
                    <div class="dropdown">
                        <button class="btn btn-sm text-muted p-0" data-bs-toggle="dropdown">
                            <i class="fas fa-ellipsis-h"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            @if($isStudent() && !$isMine)
                                <li><a class="dropdown-item" href="#"><i class="fas fa-comment me-2"></i> Commenter</a></li>
                                <li><a class="dropdown-item" href="#"><i class="fas fa-share me-2"></i> Partager</a></li>
                            @elseif($isAdminOrEnterprise())
                                <li><a class="dropdown-item" href="#"><i class="fas fa-reply me-2"></i> Répondre</a></li>
                                <li><a class="dropdown-item" href="#"><i class="fas fa-forward me-2"></i> Transférer</a></li>
                                <li><a class="dropdown-item" href="#"><i class="fas fa-comment me-2"></i> Commenter</a></li>
                                <li><a class="dropdown-item" href="#"><i class="fas fa-share me-2"></i> Partager</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item text-danger" href="#"><i class="fas fa-trash-alt me-2"></i> Supprimer</a></li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

@push('scripts')
<script>
    // Faire défiler automatiquement vers le bas des messages lors du chargement
    document.addEventListener('livewire:load', function() {
        scrollToBottom();
        
        // Faire défiler vers le bas à chaque mise à jour du composant
        Livewire.on('messageSent', function() {
            scrollToBottom();
        });
    });
    
    function scrollToBottom() {
        const container = document.getElementById('messageContainer');
        if (container) {
            container.scrollTop = container.scrollHeight;
        }
    }
    
    // Écouter les événements Pusher pour les nouveaux messages
    window.addEventListener('DOMContentLoaded', (event) => {
        // Vérifie si le composant actuel est bien le composant de messages
        const component = window.livewire.find(document.querySelector('[wire\\:id]').getAttribute('wire:id'));
        
        if (component.fingerprint.name === 'messaging.new-conversation-messages') {
            const conversationId = component.conversationId;
            
            // Écouter l'événement de nouveau message
            Echo.private('new-message')
                .listen('MessageSent', (e) => {
                    if (e.message.conversation_id == conversationId) {
                        // Rafraîchir les messages
                        Livewire.emit('messageSent');
                    }
                });
        }
    });
</script>
@endpush 