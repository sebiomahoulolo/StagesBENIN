<div class="card-body py-0 d-flex flex-column">
    <div class="position-relative h-100 min-vh-50 min-vh-lg-auto d-flex flex-column">
        @if($conversation)
        <div class="card-header border-0">
            <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-end">
                <div class="d-flex align-items-center">
                    <!-- Avatar group -->
                    <div class="avatar-group me-2">
                        @php
                            $displayedParticipants = 0;
                            $maxDisplayed = 3;
                            $remainingCount = 0;
                            $users = [];
                            
                            // Récupérer les utilisateurs associés aux participants
                            foreach($conversation->participants as $participant) {
                                $user = \App\Models\User::find($participant->user_id);
                                if ($user) {
                                    $users[] = $user;
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
                    <!-- Title -->
                    <h2 class="card-header-title h3">
                        {{ $conversation->name ?? 'Conversation' }}
                    </h2>
                </div>
                <div class="d-flex align-items-center ms-md-auto mt-5 mt-md-0 mb-3 mb-md-0">
                    <span class="fs-5 text-body-secondary me-3 d-none d-xl-inline">
                        {{ count($users) }} participants
                    </span>
                    <!-- Button -->
                    <a href="javascript: void(0);" class="d-flex align-items-center justify-content-center btn btn-light-green link-secondary rounded-circle w-40px h-40px p-0" data-bs-toggle="tooltip" title="Inviter participants">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" height="18" width="18">
                            <g>
                                <circle cx="14.5" cy="3.5" r="3" style="fill: currentColor"/>
                                <path d="M11.93,11.26a.24.24,0,0,0,.39.09A8,8,0,0,1,17.5,9.44h.2a.26.26,0,0,0,.24-.14.24.24,0,0,0,0-.27,4.55,4.55,0,0,0-7,.23.26.26,0,0,0,0,.31A6.92,6.92,0,0,1,11.93,11.26Z" style="fill: currentColor"/>
                                <path d="M.5,18H2.31a.25.25,0,0,1,.25.23L3,23.54a.5.5,0,0,0,.5.46h4a.5.5,0,0,0,.5-.46l.44-5.31A.25.25,0,0,1,8.69,18h.57a.23.23,0,0,0,.18-.08.26.26,0,0,0,.07-.19,2.71,2.71,0,0,1,0-.29A7.92,7.92,0,0,1,10.84,13a.26.26,0,0,0,0-.19A5.5,5.5,0,0,0,0,14v3.5A.5.5,0,0,0,.5,18Z" style="fill: currentColor"/>
                                <circle cx="5.5" cy="3.5" r="3.5" style="fill: currentColor"/>
                                <path d="M11,17.5A6.5,6.5,0,1,0,17.5,11,6.51,6.51,0,0,0,11,17.5Zm3-1h2.25a.25.25,0,0,0,.25-.25V14a1,1,0,0,1,2,0v2.25a.25.25,0,0,0,.25.25H21a1,1,0,0,1,0,2H18.75a.25.25,0,0,0-.25.25V21a1,1,0,0,1-2,0V18.75a.25.25,0,0,0-.25-.25H14a1,1,0,0,1,0-2Z" style="fill: currentColor"/>
                            </g>
                        </svg>
                    </a>
                    <div class="vr bg-gray-700 mx-2 mx-lg-4"></div>
                    <!-- Button -->
                    <a href="javascript: void(0);" class="d-flex align-items-center justify-content-center btn btn-light-green link-secondary rounded-circle me-2 w-40px h-40px p-0" data-bs-toggle="tooltip" title="Appel vocal">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" height="18" width="18">
                            <path d="M22.67,17l-2.45-2.45a2.8,2.8,0,0,0-4,0l-.49.49a54,54,0,0,1-6.81-6.8l.5-.5a2.83,2.83,0,0,0,0-4L7,1.32a2.87,2.87,0,0,0-4,0L1.66,2.66a4,4,0,0,0-.5,5A54.24,54.24,0,0,0,16.33,22.83a4,4,0,0,0,5-.5L22.67,21a2.8,2.8,0,0,0,0-4Z" style="fill: currentColor"/>
                        </svg>
                    </a>
                    <!-- Button -->
                    <a href="javascript: void(0);" class="d-flex align-items-center justify-content-center btn btn-light-green link-secondary rounded-circle w-40px h-40px p-0" data-bs-toggle="tooltip" title="Appel vidéo">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" height="18" width="18">
                            <g>
                                <path d="M12,5.75A3.25,3.25,0,1,0,15.25,9,3.26,3.26,0,0,0,12,5.75ZM12,10a1,1,0,1,1,1-1A1,1,0,0,1,12,10Z" style="fill: currentColor"/>
                                <path d="M14.15,17.73a9,9,0,1,0-4.3,0L5.29,22.29a1,1,0,0,0,1.42,1.42l3.86-3.87a.26.26,0,0,1,.28-.05A.25.25,0,0,1,11,20v3a1,1,0,0,0,2,0V20a.25.25,0,0,1,.15-.23.26.26,0,0,1,.28.05l3.86,3.87a1,1,0,0,0,1.42-1.42ZM11,1.25h2a.75.75,0,0,1,0,1.5H11a.75.75,0,0,1,0-1.5Zm1,12.5A4.75,4.75,0,1,1,16.75,9,4.75,4.75,0,0,1,12,13.75Z" style="fill: currentColor"/>
                            </g>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
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
                        $messageUser = \App\Models\User::find($message->user_id);
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

                    <div class="d-flex {{ $isCurrentUser ? 'flex-row-reverse' : '' }} mb-6" 
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
                                {{ $message->body }}
                            </div>
                            
                            @if($message->attachments && $message->attachments->count() > 0)
                                @foreach($message->attachments as $attachment)
                                    <div class="mb-1 {{ $isCurrentUser ? 'rounded-start rounded-bottom' : 'rounded-end rounded-bottom' }}">
                                        @if(Str::startsWith($attachment->type, 'image/'))
                                            <a href="{{ asset('storage/' . $attachment->path) }}" target="_blank">
                                                <img src="{{ asset('storage/' . $attachment->path) }}" alt="{{ $attachment->name }}" class="{{ $isCurrentUser ? 'rounded-start rounded-bottom' : 'rounded-end rounded-bottom' }} w-300px" width="300">
                                            </a>
                                        @else
                                            <div class="d-flex align-items-center p-3 bg-light {{ $isCurrentUser ? 'rounded-start rounded-bottom' : 'rounded-end rounded-bottom' }}">
                                                <i class="fas fa-file-alt me-2"></i>
                                                <a href="{{ asset('storage/' . $attachment->path) }}" download="{{ $attachment->name }}">
                                                    {{ $attachment->name }} ({{ round($attachment->size / 1024, 2) }} KB)
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
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
        // Scroll en bas quand les messages sont chargés
        Livewire.hook('message.processed', function (message, component) {
            if (component.fingerprint.name === 'messaging.conversation-messages') {
                scrollToBottom();
            }
        });

        // Écoutez les événements du navigateur
        window.addEventListener('messagesLoaded', function() {
            scrollToBottom();
        });
        
        window.addEventListener('messageSent', function() {
            scrollToBottom();
        });
    });

    function scrollToBottom() {
        const messageContainer = document.getElementById('messageContainer');
        if (messageContainer) {
            messageContainer.scrollTop = messageContainer.scrollHeight;
        }
    }

    // Auto-scroll on new message
    document.addEventListener('DOMContentLoaded', function() {
        scrollToBottom();
    });
</script>
