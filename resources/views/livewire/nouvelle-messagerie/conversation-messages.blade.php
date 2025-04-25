<div class="card-body py-0 d-flex flex-column" data-conversation-id="{{ $conversationId }}">
    <div class="position-relative h-100 min-vh-50 min-vh-lg-auto d-flex flex-column">
        @if($conversation)
        <div class="card-header border-0">
            <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-end">
                <div class="d-flex align-items-center">
                    <!-- Avatars des participants -->
                    <div class="avatar-group me-2">
                        @php
                            $displayedParticipants = 0;
                            $maxDisplayed = 3;
                            $remainingCount = 0;
                            $users = [];
                            
                            // Récupérer les utilisateurs associés aux participants
                            foreach($conversation->participants as $participant) {
                                if($participant->id != auth()->id()) {
                                    $users[] = $participant;
                                }
                            }
                        @endphp
                        @foreach($users as $user)
                            @if($displayedParticipants < $maxDisplayed)
                                <div class="avatar avatar-circle avatar-sm">
                                    @if($user->avatar)
                                        <img src="{{ asset('storage/' . $user->avatar) }}" alt="{{ $user->name }}" class="avatar-img border border-2 border-white" width="40" height="40">
                                    @else
                                        <span class="avatar-title text-bg-dark border border-2 border-white">
                                            {{ substr($user->name, 0, 2) }}
                                        </span>
                                    @endif
                                </div>
                                @php $displayedParticipants++; @endphp
                            @else
                                @php $remainingCount++; @endphp
                            @endif
                        @endforeach

                        @if($remainingCount > 0)
                            <div class="avatar avatar-circle avatar-sm">
                                <span class="avatar-title text-bg-primary border border-2 border-white">
                                    {{ $remainingCount }}+
                                </span>
                            </div>
                        @endif
                    </div>
                    <!-- Titre de la conversation -->
                    <h2 class="card-header-title h3">
                        {{ $conversation->name ?? 'Conversation' }}
                    </h2>
                </div>
                <div class="d-flex align-items-center ms-md-auto mt-3 mt-md-0 mb-3 mb-md-0">
                    <span class="fs-5 text-body-secondary me-3 d-none d-xl-inline">
                        {{ count($conversation->participants) }} participants
                    </span>
                </div>
            </div>
        </div>

        <!-- Conteneur des messages -->
        <div class="overflow-auto flex-grow-1 pe-3 scroll-shadow" id="messageContainer" 
             wire:poll.10s="loadMessages" style="max-height: calc(100vh - 250px);">
            @if(count($messages) > 0)
                @php
                    $previousMessageDate = null;
                    $previousSender = null;
                @endphp
                @foreach($messages as $message)
                    @php
                        // Récupérer l'utilisateur pour ce message
                        $messageUser = $message->user;
                        if (!$messageUser) continue; // Skip si utilisateur introuvable
                        
                        $messageDate = $message->created_at->format('Y-m-d');
                        $showDateHeader = $previousMessageDate !== $messageDate;
                        $sameAsPreviousSender = $previousSender === $message->user_id;
                        $previousMessageDate = $messageDate;
                        $previousSender = $message->user_id;
                        $isCurrentUser = $message->user_id === auth()->id();
                    @endphp

                    @if($showDateHeader)
                        <div class="text-center my-3">
                            <span class="badge bg-light text-secondary px-3 py-2">
                                {{ $message->created_at->format('d F Y') }}
                            </span>
                        </div>
                    @endif

                    <div class="d-flex {{ $isCurrentUser ? 'flex-row-reverse' : '' }} mb-4" 
                         wire:key="message-{{ $message->id }}">
                        @if(!$isCurrentUser && !$sameAsPreviousSender)
                            <div class="avatar avatar-circle avatar-sm me-2">
                                @if($messageUser->avatar)
                                    <img src="{{ asset('storage/' . $messageUser->avatar) }}" alt="{{ $messageUser->name }}" class="avatar-img" width="40" height="40">
                                @else
                                    <span class="avatar-title">{{ substr($messageUser->name, 0, 2) }}</span>
                                @endif
                            </div>
                        @elseif(!$isCurrentUser && $sameAsPreviousSender)
                            <div class="avatar avatar-sm me-2 invisible"></div>
                        @endif
                        <div class="d-flex flex-column {{ $isCurrentUser ? 'align-items-end' : 'align-items-start' }}">
                            @if(!$sameAsPreviousSender)
                                <span class="text-body-secondary fs-5">
                                    {{ $isCurrentUser ? $message->created_at->format('H:i') : $messageUser->name . ', ' . $message->created_at->format('H:i') }}
                                    @if($isCurrentUser)
                                        <span class="d-inline-flex">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" height="11" width="11" class="text-primary">
                                                <path d="M23.15,5.4l-2.8-2.8a.5.5,0,0,0-.7,0L7.85,14.4a.5.5,0,0,1-.7,0l-2.8-2.8a.5.5,0,0,0-.7,0L.85,14.4a.5.5,0,0,0,0,.7l6.3,6.3a.5.5,0,0,0,.7,0L23.15,6.1A.5.5,0,0,0,23.15,5.4Z" style="fill: currentColor"/>
                                            </svg>
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" height="11" width="11" class="text-primary ms-n1">
                                                <path d="M23.15,5.4l-2.8-2.8a.5.5,0,0,0-.7,0L7.85,14.4a.5.5,0,0,1-.7,0l-2.8-2.8a.5.5,0,0,0-.7,0L.85,14.4a.5.5,0,0,0,0,.7l6.3,6.3a.5.5,0,0,0,.7,0L23.15,6.1A.5.5,0,0,0,23.15,5.4Z" style="fill: currentColor"/>
                                            </svg>
                                        </span>
                                    @endif
                                </span>
                            @endif
                            
                            <div class="mb-1 p-4 {{ $isCurrentUser ? 'rounded-start rounded-bottom text-bg-primary' : 'rounded-end rounded-bottom bg-gray-300' }}">
                                {!! nl2br(e($message->body)) !!}
                            </div>
                            
                            <!-- Pièces jointes -->
                            @if($message->attachments && $message->attachments->count() > 0)
                                @foreach($message->attachments as $attachment)
                                    <div class="mb-1 {{ $isCurrentUser ? 'rounded-start rounded-bottom' : 'rounded-end rounded-bottom' }}">
                                        @if(Str::startsWith($attachment->file_type, 'image/'))
                                            <a href="{{ asset('storage/' . $attachment->file_path) }}" target="_blank">
                                                <img src="{{ asset('storage/' . $attachment->file_path) }}" alt="{{ $attachment->file_name }}" class="{{ $isCurrentUser ? 'rounded-start rounded-bottom' : 'rounded-end rounded-bottom' }} w-300px" width="300">
                                            </a>
                                        @else
                                            <div class="d-flex align-items-center p-3 bg-light {{ $isCurrentUser ? 'rounded-start rounded-bottom' : 'rounded-end rounded-bottom' }}">
                                                <i class="fas fa-file-alt me-2"></i>
                                                <a href="{{ asset('storage/' . $attachment->file_path) }}" download="{{ $attachment->file_name }}">
                                                    {{ $attachment->file_name }} ({{ round($attachment->file_size / 1024, 2) }} KB)
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            @endif
                            
                            <!-- Actions sur le message (uniquement pour les messages reçus par l'étudiant) -->
                            @if(!$isCurrentUser && $userRole === 'etudiant')
                                <div class="student-actions mt-2">
                                    <button class="btn btn-sm btn-outline-primary" wire:click="commentMessage({{ $message->id }})">
                                        <i class="fas fa-comment"></i> Commenter
                                    </button>
                                    <button class="btn btn-sm btn-outline-secondary" wire:click="shareMessage({{ $message->id }})">
                                        <i class="fas fa-share"></i> Partager
                                    </button>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            @else
                <div class="text-center p-5 text-body-secondary">
                    <p>Aucun message dans cette conversation</p>
                    <p>Commencez à échanger dès maintenant!</p>
                </div>
            @endif
        </div>
        @else
            <div class="text-center p-5 text-body-secondary">
                <p>Sélectionnez une conversation pour voir les messages</p>
            </div>
        @endif
    </div>
</div>

<script>
    document.addEventListener('livewire:load', function () {
        // Fonction pour scroller en bas
        window.scrollToBottom = function() {
            const container = document.getElementById('messageContainer');
            if (container) {
                container.scrollTop = container.scrollHeight;
            }
        };
        
        // Scroll en bas quand les messages sont chargés
        Livewire.hook('message.processed', function (message, component) {
            if (component.fingerprint.name === 'nouvelle-messagerie.conversation-messages') {
                scrollToBottom();
            }
        });

        // Écoutez les événements du navigateur
        window.addEventListener('messagesLoaded', function() {
            scrollToBottom();
        });
        
        window.addEventListener('newMessageReceived', function() {
            scrollToBottom();
        });
    });
</script> 