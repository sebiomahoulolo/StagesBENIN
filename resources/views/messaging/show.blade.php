@extends('layouts.etudiant.app')

@section('title', 'Conversation')

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/emoji-mart/css/emoji-mart.css" />
<style>
    /* Styles pour la vue de conversation - Version moderne */
    .messaging-container {
        display: flex;
        height: calc(100vh - 220px);
        min-height: 600px;
        border-radius: 1rem;
        background-color: #fff;
        overflow: hidden;
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
    }
    
    /* Sidebar de conversation */
    .conversation-sidebar {
        width: 320px;
        border-right: 1px solid #f0f2f5;
        display: flex;
        flex-direction: column;
        transition: all 0.3s ease;
    }
    
    .participants-header {
        padding: 18px 20px;
        border-bottom: 1px solid #f0f2f5;
        font-weight: 600;
        color: #050505;
        font-size: 1.1rem;
        background-color: #f9fafb;
    }
    
    .participants-list {
        flex-grow: 1;
        overflow-y: auto;
        padding: 12px 10px;
    }
    
    .participant-item {
        display: flex;
        align-items: center;
        padding: 10px;
        border-radius: 8px;
        transition: all 0.2s ease;
        margin-bottom: 4px;
    }
    
    .participant-item:hover {
        background-color: #f0f2f5;
    }
    
    .participant-avatar {
        width: 42px;
        height: 42px;
        border-radius: 50%;
        background-color: #f0f2f5;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 12px;
        color: #65676b;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    }
    
    .participant-name {
        font-size: 0.95rem;
        font-weight: 500;
        color: #050505;
    }
    
    /* Zone principale de conversation */
    .conversation-main {
        flex-grow: 1;
        display: flex;
        flex-direction: column;
        background-color: #fff;
    }
    
    .conversation-header {
        padding: 15px 20px;
        border-bottom: 1px solid #f0f2f5;
        display: flex;
        align-items: center;
        justify-content: space-between;
        background-color: #f9fafb;
        z-index: 10;
    }
    
    .conversation-title {
        font-size: 1.1rem;
        font-weight: 600;
        margin: 0;
        color: #050505;
    }
    
    .conversation-actions a {
        color: #1877f2;
        margin-left: 15px;
        font-size: 1.1rem;
        transition: transform 0.2s ease;
    }
    
    .conversation-actions a:hover {
        transform: scale(1.1);
        color: #0d6efd;
    }
    
    /* Conteneur des messages */
    .messages-container {
        flex-grow: 1;
        overflow-y: auto;
        padding: 20px;
        background-color: #fff;
        scroll-behavior: smooth;
    }
    
    .message-date-divider {
        text-align: center;
        margin: 20px 0;
        position: relative;
    }
    
    .message-date-divider:before {
        content: '';
        position: absolute;
        top: 50%;
        left: 0;
        right: 0;
        height: 1px;
        background-color: #f0f2f5;
        z-index: 1;
    }
    
    .message-date-divider span {
        position: relative;
        background-color: #fff;
        padding: 0 15px;
        font-size: 0.8rem;
        color: #65676b;
        z-index: 2;
        border-radius: 10px;
    }
    
    .message-group {
        margin-bottom: 2px;
        display: flex;
        flex-direction: column;
    }
    
    .message-item {
        max-width: 65%;
        margin-bottom: 2px;
        position: relative;
        display: flex;
        flex-direction: column;
    }
    
    .message-sender {
        font-size: 0.85rem;
        margin-bottom: 4px;
        color: #65676b;
        font-weight: 500;
    }
    
    .message-bubble {
        padding: 10px 14px;
        border-radius: 18px;
        position: relative;
        word-break: break-word;
        box-shadow: 0 1px 2px rgba(0,0,0,0.1);
        line-height: 1.4;
    }
    
    .message-time {
        font-size: 0.7rem;
        color: #65676b;
        margin-top: 4px;
        align-self: flex-end;
    }
    
    /* Styles des messages sortants (envoyés par l'utilisateur) */
    .message-outgoing {
        align-self: flex-end;
    }
    
    .message-outgoing .message-bubble {
        background-color: #0084ff;
        color: white;
        border-bottom-right-radius: 4px;
    }
    
    /* Groupage des messages sortants consécutifs */
    .message-outgoing + .message-outgoing .message-bubble {
        border-top-right-radius: 12px;
        border-bottom-right-radius: 4px;
        margin-top: 2px;
    }
    
    .message-outgoing:last-child .message-bubble {
        border-bottom-right-radius: 18px;
    }
    
    /* Styles des messages entrants (reçus) */
    .message-incoming {
        align-self: flex-start;
    }
    
    .message-incoming .message-bubble {
        background-color: #f0f2f5;
        color: #050505;
        border-bottom-left-radius: 4px;
    }
    
    /* Groupage des messages entrants consécutifs */
    .message-incoming + .message-incoming .message-bubble {
        border-top-left-radius: 12px;
        border-bottom-left-radius: 4px;
        margin-top: 2px;
    }
    
    .message-incoming:last-child .message-bubble {
        border-bottom-left-radius: 18px;
    }
    
    /* Zone de saisie du message */
    .message-form-container {
        border-top: 1px solid #f0f2f5;
        padding: 15px 20px;
        background-color: #f9fafb;
    }
    
    .message-form {
        display: flex;
        align-items: flex-end;
    }
    
    .message-input-container {
        flex-grow: 1;
        position: relative;
        border-radius: 24px;
        background-color: #f0f2f5;
        transition: all 0.3s ease;
    }
    
    .message-input-container:focus-within {
        background-color: #fff;
        box-shadow: 0 2px 12px rgba(0,0,0,0.1);
    }
    
    .message-input {
        width: 100%;
        border: none;
        background: transparent;
        border-radius: 20px;
        padding: 12px 45px 12px 20px;
        resize: none;
        max-height: 120px;
        line-height: 1.5;
        color: #050505;
    }
    
    .message-input:focus {
        outline: none;
    }
    
    .message-attachments-btn {
        position: absolute;
        right: 15px;
        bottom: 10px;
        background: none;
        border: none;
        color: #0084ff;
        cursor: pointer;
        font-size: 1.1rem;
        transition: transform 0.2s ease;
    }
    
    .message-attachments-btn:hover {
        transform: scale(1.1);
    }
    
    .message-send-btn {
        background-color: #0084ff;
        color: white;
        border: none;
        border-radius: 50%;
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-left: 10px;
        cursor: pointer;
        transition: all 0.2s ease;
        box-shadow: 0 2px 8px rgba(0, 132, 255, 0.3);
    }
    
    .message-send-btn:hover {
        background-color: #0070db;
        transform: scale(1.05);
        box-shadow: 0 4px 12px rgba(0, 132, 255, 0.4);
    }
    
    .message-send-btn:disabled {
        background-color: #b0d6ff;
        cursor: not-allowed;
        transform: none;
        box-shadow: none;
    }
    
    /* Prévisualisation des pièces jointes */
    .attachments-preview {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-bottom: 10px;
        padding: 10px;
        border-radius: 12px;
        background-color: #f9fafb;
    }
    
    .attachment-preview {
        position: relative;
        width: 100px;
        height: 100px;
        border-radius: 8px;
        overflow: hidden;
        background-color: #f0f2f5;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        transition: transform 0.2s ease;
    }
    
    .attachment-preview:hover {
        transform: translateY(-2px);
    }
    
    .attachment-preview img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .attachment-preview video,
    .attachment-preview audio {
        width: 100%;
        height: 100%;
        object-fit: contain;
    }
    
    .attachment-preview .file-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        height: 100%;
        color: #65676b;
    }
    
    .attachment-preview .remove-attachment {
        position: absolute;
        top: 5px;
        right: 5px;
        width: 22px;
        height: 22px;
        border-radius: 50%;
        background-color: rgba(0, 0, 0, 0.6);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.8rem;
        cursor: pointer;
        z-index: 5;
        transition: background-color 0.2s ease;
    }
    
    .attachment-preview .remove-attachment:hover {
        background-color: rgba(0, 0, 0, 0.8);
    }
    
    /* Styles des pièces jointes dans les messages */
    .message-attachment {
        margin-top: 8px;
    }
    
    .attachment-image {
        max-width: 250px;
        max-height: 200px;
        border-radius: 12px;
        cursor: pointer;
        box-shadow: 0 2px 12px rgba(0,0,0,0.1);
        transition: transform 0.2s ease;
        display: block;
    }
    
    .attachment-image:hover {
        transform: scale(1.02);
    }
    
    .attachment-video {
        max-width: 300px;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 2px 12px rgba(0,0,0,0.1);
    }
    
    .attachment-audio {
        width: 100%;
        max-width: 300px;
        margin-top: 5px;
        border-radius: 8px;
        overflow: hidden;
    }
    
    .attachment-file {
        display: flex;
        align-items: center;
        padding: 10px 12px;
        background-color: rgba(0, 0, 0, 0.05);
        border-radius: 8px;
        margin-top: 5px;
        transition: background-color 0.2s ease;
    }
    
    .message-outgoing .attachment-file {
        background-color: rgba(255, 255, 255, 0.2);
    }
    
    .attachment-file:hover {
        background-color: rgba(0, 0, 0, 0.08);
    }
    
    .message-outgoing .attachment-file:hover {
        background-color: rgba(255, 255, 255, 0.25);
    }
    
    .attachment-file-icon {
        margin-right: 10px;
        font-size: 1.5rem;
        color: #65676b;
    }
    
    .message-outgoing .attachment-file-icon {
        color: #ffffff;
    }
    
    .attachment-file-info {
        display: flex;
        flex-direction: column;
        flex: 1;
    }
    
    .attachment-file-name {
        font-weight: 500;
        margin-bottom: 2px;
        color: #050505;
        font-size: 0.9rem;
    }
    
    .message-outgoing .attachment-file-name {
        color: #ffffff;
    }
    
    .attachment-file-size {
        font-size: 0.8rem;
        color: #65676b;
    }
    
    .message-outgoing .attachment-file-size {
        color: rgba(255, 255, 255, 0.8);
    }
    
    /* Sélecteur d'émojis */
    .emoji-picker-container {
        position: absolute;
        bottom: 50px;
        right: 0;
        z-index: 1000;
        border-radius: 12px;
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
        transition: all 0.3s ease;
        transform-origin: bottom right;
    }
    
    .emoji-btn {
        background: none;
        border: none;
        color: #0084ff;
        cursor: pointer;
        font-size: 1.3rem;
        margin-right: 14px;
        transition: transform 0.2s ease;
        padding: 0;
    }
    
    .emoji-btn:hover {
        transform: scale(1.1);
        color: #0070db;
    }
    
    /* Indicateur de frappe */
    .typing-indicator {
        display: flex;
        align-items: center;
        margin: 10px 0;
        padding: 5px 10px;
        width: fit-content;
        border-radius: 16px;
        background-color: #f0f2f5;
    }
    
    .typing-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background-color: #65676b;
        margin: 0 2px;
        animation: typingAnimation 1.5s infinite ease-in-out;
    }
    
    .typing-dot:nth-child(1) {
        animation-delay: 0s;
    }
    
    .typing-dot:nth-child(2) {
        animation-delay: 0.2s;
    }
    
    .typing-dot:nth-child(3) {
        animation-delay: 0.4s;
    }
    
    @keyframes typingAnimation {
        0%, 60%, 100% {
            transform: translateY(0);
        }
        30% {
            transform: translateY(-8px);
        }
    }
    
    /* Responsive */
    @media (max-width: 992px) {
        .conversation-sidebar {
            width: 260px;
        }
        
        .message-item {
            max-width: 80%;
        }
    }
    
    @media (max-width: 768px) {
        .conversation-sidebar {
            display: none;
        }
        
        .message-item {
            max-width: 80%;
        }
    }
    
    /* Animation pour les nouveaux messages */
    @keyframes fadeIn {
        0% { opacity: 0; transform: translateY(10px); }
        100% { opacity: 1; transform: translateY(0); }
    }
    
    .new-message {
        animation: fadeIn 0.3s ease-out forwards;
    }
    
    /* Style amélioré pour les modals d'image */
    .modal-content {
        border: none;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.4);
    }
    
    .modal-header {
        border: none;
        padding: 15px;
        background-color: rgba(0, 0, 0, 0.03);
    }
    
    .modal-body {
        padding: 0;
    }
    
    .modal-body img {
        max-height: 85vh;
        border-radius: 0;
    }
    
    .btn-close {
        background-color: white;
        border-radius: 50%;
        padding: 8px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
        opacity: 1;
    }
    
    .btn-close:hover {
        background-color: #f8f9fa;
    }
</style>
@endpush

@section('content')
<div class="container py-4">
    <div class="card shadow-sm">
        <div class="card-header bg-white p-0">
            <div class="d-flex align-items-center">
                <a href="{{ route('messaging.index') }}" class="btn btn-link text-dark">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <h1 class="h5 mb-0">
                    @if($conversation->is_group)
                        {{ $conversation->name }}
                    @else
                        {{ $participants->first()->name ?? 'Conversation privée' }}
                    @endif
                </h1>
            </div>
        </div>
        
        <div class="card-body p-0">
            <div class="messaging-container">
                <!-- Sidebar avec les participants -->
                <div class="conversation-sidebar">
                    <div class="participants-header">
                        Participants ({{ $participants->count() + 1 }})
                    </div>
                    <div class="participants-list">
                        <!-- L'utilisateur actuel -->
                        <div class="participant-item">
                            <div class="participant-avatar">
                                <i class="fas fa-user"></i>
                            </div>
                            <div class="participant-name">
                                {{ Auth::user()->name }} (Vous)
                            </div>
                        </div>
                        
                        <!-- Les autres participants -->
                        @foreach($participants as $participant)
                            <div class="participant-item">
                                <div class="participant-avatar">
                                    <i class="fas fa-user"></i>
                                </div>
                                <div class="participant-name">
                                    {{ $participant->name }}
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                
                <!-- Contenu principal de la conversation -->
                <div class="conversation-main">
                    <div class="conversation-header">
                        <h2 class="conversation-title">
                            @if($conversation->is_group)
                                {{ $conversation->name }}
                            @else
                                {{ $participants->first()->name ?? 'Conversation privée' }}
                            @endif
                        </h2>
                        <div class="conversation-actions">
                            <a href="#" id="refreshBtn" title="Rafraîchir">
                                <i class="fas fa-sync-alt"></i>
                            </a>
                        </div>
                    </div>
                    
                    <!-- Conteneur des messages -->
                    <div class="messages-container" id="messagesContainer">
                        @php
                            $currentDate = null;
                            $currentSenderId = null;
                        @endphp
                        
                        @foreach($messages as $message)
                            @php
                                $messageDate = $message->created_at->format('Y-m-d');
                                $isNewDate = $currentDate !== $messageDate;
                                $isNewSender = $currentSenderId !== $message->user_id;
                                $currentDate = $messageDate;
                                $currentSenderId = $message->user_id;
                                $isOutgoing = $message->user_id === Auth::id();
                            @endphp
                            
                            @if($isNewDate)
                                <div class="message-date-divider">
                                    <span>{{ $message->created_at->isoFormat('dddd D MMMM YYYY') }}</span>
                                </div>
                            @endif
                            
                            <div class="message-group">
                                <div class="message-item {{ $isOutgoing ? 'message-outgoing' : 'message-incoming' }}">
                                    @if(!$isOutgoing && $isNewSender)
                                        <div class="message-sender">
                                            {{ $message->user->name }}
                                        </div>
                                    @endif
                                    
                                    <div class="message-bubble">
                                        @if($message->body)
                                            {!! nl2br(e($message->body)) !!}
                                        @endif
                                        
                                        @if($message->attachments->count() > 0)
                                            @foreach($message->attachments as $attachment)
                                                <div class="message-attachment">
                                                    @if($attachment->isImage())
                                                        <img src="{{ $attachment->getUrl() }}" alt="{{ $attachment->file_name }}" class="attachment-image" onclick="openImage('{{ $attachment->getUrl() }}')">
                                                    @elseif($attachment->isVideo())
                                                        <video controls class="attachment-video">
                                                            <source src="{{ $attachment->getUrl() }}" type="{{ $attachment->file_type }}">
                                                            Votre navigateur ne supporte pas les vidéos.
                                                        </video>
                                                    @elseif($attachment->isAudio())
                                                        <audio controls class="attachment-audio">
                                                            <source src="{{ $attachment->getUrl() }}" type="{{ $attachment->file_type }}">
                                                            Votre navigateur ne supporte pas l'audio.
                                                        </audio>
                                                    @else
                                                        <div class="attachment-file">
                                                            <div class="attachment-file-icon">
                                                                <i class="fas fa-file"></i>
                                                            </div>
                                                            <div class="attachment-file-info">
                                                                <span class="attachment-file-name">{{ $attachment->file_name }}</span>
                                                                <span class="attachment-file-size">{{ $attachment->getFormattedSize() }}</span>
                                                            </div>
                                                            <a href="{{ $attachment->getUrl() }}" class="ms-auto" download="{{ $attachment->file_name }}" target="_blank">
                                                                <i class="fas fa-download"></i>
                                                            </a>
                                                        </div>
                                                    @endif
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                    <div class="message-time">
                                        {{ $message->created_at->format('H:i') }}
                                        @if($isOutgoing)
                                            <i class="fas fa-check {{ $message->is_read ? 'text-primary' : '' }}" title="{{ $message->is_read ? 'Lu' : 'Envoyé' }}"></i>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    
                    <!-- Formulaire d'envoi -->
                    <div class="message-form-container">
                        <form id="messageForm" method="POST" action="{{ route('messaging.send-message', $conversation->id) }}" enctype="multipart/form-data">
                            @csrf
                            
                            <div class="attachments-preview" id="attachmentsPreview" style="display: none;"></div>
                            
                            <div class="message-form">
                                <div class="d-flex align-items-center me-2">
                                    <input type="file" id="fileAttachment" name="attachments[]" multiple style="display: none;" accept="image/*,video/*,audio/*,.pdf,.doc,.docx,.xls,.xlsx,.zip,.rar">
                                    <button type="button" id="attachmentBtn" class="btn btn-link text-secondary p-0">
                                        <i class="fas fa-paperclip"></i>
                                    </button>
                                    <button type="button" id="emojiBtn" class="emoji-btn">
                                        <i class="far fa-smile"></i>
                                    </button>
                                </div>
                                
                                <div class="message-input-container">
                                    <textarea class="message-input" id="messageInput" name="message" placeholder="Tapez votre message..." rows="1"></textarea>
                                    <div class="emoji-picker-container" id="emojiPicker" style="display: none;"></div>
                                </div>
                                
                                <button type="submit" class="message-send-btn">
                                    <i class="fas fa-paper-plane"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Modal pour afficher les images en grand -->
    <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                </div>
                <div class="modal-body text-center">
                    <img id="modalImage" src="" alt="Image en plein écran" style="max-width: 100%; max-height: 80vh;">
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/emoji-mart@latest/dist/browser.js"></script>
<script src="https://js.pusher.com/8.3.0/pusher.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const messagesContainer = document.getElementById('messagesContainer');
        const messageForm = document.getElementById('messageForm');
        const messageInput = document.getElementById('messageInput');
        const fileAttachment = document.getElementById('fileAttachment');
        const attachmentBtn = document.getElementById('attachmentBtn');
        const attachmentsPreview = document.getElementById('attachmentsPreview');
        const emojiBtn = document.getElementById('emojiBtn');
        const emojiPicker = document.getElementById('emojiPicker');
        const refreshBtn = document.getElementById('refreshBtn');
        
        // Faire défiler jusqu'au bas des messages
        function scrollToBottom() {
            messagesContainer.scrollTop = messagesContainer.scrollHeight;
        }
        
        // Appelé au chargement initial
        scrollToBottom();
        
        // Ajuster la hauteur du textarea
        function adjustTextareaHeight() {
            messageInput.style.height = 'auto';
            messageInput.style.height = Math.min(messageInput.scrollHeight, 120) + 'px';
        }
        
        // Événements pour ajuster la hauteur du textarea
        messageInput.addEventListener('input', adjustTextareaHeight);
        messageInput.addEventListener('focus', adjustTextareaHeight);
        
        // Prévisualisation des pièces jointes
        attachmentBtn.addEventListener('click', function() {
            fileAttachment.click();
        });
        
        fileAttachment.addEventListener('change', function() {
            attachmentsPreview.innerHTML = '';
            attachmentsPreview.style.display = 'flex';
            
            Array.from(this.files).forEach((file, index) => {
                const reader = new FileReader();
                const preview = document.createElement('div');
                preview.className = 'attachment-preview';
                
                const removeBtn = document.createElement('div');
                removeBtn.className = 'remove-attachment';
                removeBtn.innerHTML = '<i class="fas fa-times"></i>';
                removeBtn.addEventListener('click', function() {
                    // Ne peut pas supprimer directement du FileList, donc nous recréons l'input
                    attachmentsPreview.removeChild(preview);
                    if (attachmentsPreview.children.length === 0) {
                        attachmentsPreview.style.display = 'none';
                    }
                });
                
                preview.appendChild(removeBtn);
                
                if (file.type.startsWith('image/')) {
                    reader.onload = function(e) {
                        const img = document.createElement('img');
                        img.src = e.target.result;
                        preview.appendChild(img);
                    };
                    reader.readAsDataURL(file);
                } else if (file.type.startsWith('video/')) {
                    const videoIcon = document.createElement('div');
                    videoIcon.className = 'file-icon';
                    videoIcon.innerHTML = '<i class="fas fa-video fa-2x"></i><span style="margin-top: 5px; font-size: 0.8rem;">' + file.name + '</span>';
                    preview.appendChild(videoIcon);
                } else if (file.type.startsWith('audio/')) {
                    const audioIcon = document.createElement('div');
                    audioIcon.className = 'file-icon';
                    audioIcon.innerHTML = '<i class="fas fa-microphone fa-2x"></i><span style="margin-top: 5px; font-size: 0.8rem;">' + file.name + '</span>';
                    preview.appendChild(audioIcon);
                } else {
                    const fileIcon = document.createElement('div');
                    fileIcon.className = 'file-icon';
                    fileIcon.innerHTML = '<i class="fas fa-file fa-2x"></i><span style="margin-top: 5px; font-size: 0.8rem;">' + file.name + '</span>';
                    preview.appendChild(fileIcon);
                }
                
                attachmentsPreview.appendChild(preview);
            });
        });
        
        // Sélecteur d'emoji
        emojiBtn.addEventListener('click', function() {
            if (emojiPicker.style.display === 'none') {
                emojiPicker.style.display = 'block';
                
                if (!emojiPicker.hasChildNodes()) {
                    new EmojiMart.Picker({
                        onEmojiSelect: (emoji) => {
                            messageInput.value += emoji.native;
                            emojiPicker.style.display = 'none';
                            adjustTextareaHeight();
                        },
                        locale: 'fr'
                    }).appendTo(emojiPicker);
                }
            } else {
                emojiPicker.style.display = 'none';
            }
        });
        
        // Fermer le sélecteur d'emoji en cliquant ailleurs
        document.addEventListener('click', function(e) {
            if (emojiPicker.style.display === 'block' && !emojiPicker.contains(e.target) && e.target !== emojiBtn) {
                emojiPicker.style.display = 'none';
            }
        });
        
        // Ajout de l'indicateur de frappe
        let typingTimer;
        const typingIndicator = document.createElement('div');
        typingIndicator.className = 'typing-indicator';
        typingIndicator.innerHTML = '<div class="typing-dot"></div><div class="typing-dot"></div><div class="typing-dot"></div>';
        typingIndicator.style.display = 'none';
        messagesContainer.appendChild(typingIndicator);
        
        messageInput.addEventListener('input', function() {
            // TODO: Envoyer l'événement de frappe à Pusher
            // Pour l'instant nous simulons juste l'affichage local
        });
        
        // Envoi du formulaire
        messageForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Si le message est vide et aucune pièce jointe n'est sélectionnée, ne pas envoyer
            if (messageInput.value.trim() === '' && (!fileAttachment.files || fileAttachment.files.length === 0)) {
                return;
            }
            
            // Désactiver temporairement le bouton d'envoi pour éviter les doubles soumissions
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalContent = submitBtn.innerHTML;
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
            
            // Envoyer le formulaire via AJAX
            const formData = new FormData(this);
            
            fetch(this.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => response.json())
            .then(data => {
                // Effacer l'entrée et réinitialiser l'interface
                messageInput.value = '';
                messageInput.style.height = 'auto';
                
                fileAttachment.value = '';
                attachmentsPreview.innerHTML = '';
                attachmentsPreview.style.display = 'none';
                
                // Réactiver le bouton d'envoi
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalContent;
                
                // Pas besoin d'ajouter le message manuellement, il sera reçu via Pusher
            })
            .catch(error => {
                console.error('Erreur d\'envoi:', error);
                alert('Erreur lors de l\'envoi du message. Veuillez réessayer.');
                
                // Réactiver le bouton d'envoi
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalContent;
            });
        });
        
        // Rafraîchir les messages
        refreshBtn.addEventListener('click', function(e) {
            e.preventDefault();
            location.reload();
        });
        
        // Fonction pour ouvrir l'image dans une modal
        window.openImage = function(url) {
            const modalImage = document.getElementById('modalImage');
            modalImage.src = url;
            
            const imageModal = new bootstrap.Modal(document.getElementById('imageModal'));
            imageModal.show();
        };
        
        // Configuration de Pusher pour les messages en temps réel
        const pusher = new Pusher('{{ env('PUSHER_APP_KEY', 'your-pusher-key') }}', {
            cluster: '{{ env('PUSHER_APP_CLUSTER', 'eu') }}',
            encrypted: true
        });
        
        console.log('Connecting to Pusher - Channel: conversation.{{ $conversation->id }}');
        const channel = pusher.subscribe('private-conversation.{{ $conversation->id }}');
        
        channel.bind('pusher:subscription_succeeded', function() {
            console.log('Subscription to channel succeeded');
        });
        
        channel.bind('pusher:subscription_error', function(status) {
            console.error('Subscription to channel failed with status', status);
        });
        
        // Écouter l'événement MessageSent
        channel.bind('message.sent', function(data) {
            console.log('Message received from Pusher:', data);
            // Ajouter le nouveau message à la conversation
            const isOutgoing = data.user_id === {{ Auth::id() }};
            
            // Vérifier si une date-divider existe déjà pour aujourd'hui
            const today = new Date().toISOString().split('T')[0];
            const existingDateDivider = document.querySelector(`.message-date-divider[data-date="${today}"]`);
            
            if (!existingDateDivider) {
                const dateDivider = document.createElement('div');
                dateDivider.className = 'message-date-divider';
                dateDivider.setAttribute('data-date', today);
                
                const dateSpan = document.createElement('span');
                const nowDate = new Date();
                dateSpan.textContent = nowDate.toLocaleDateString('fr-FR', { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' });
                
                dateDivider.appendChild(dateSpan);
                messagesContainer.appendChild(dateDivider);
            }
            
            const messageGroup = document.createElement('div');
            messageGroup.className = 'message-group';
            
            const messageItem = document.createElement('div');
            messageItem.className = `message-item ${isOutgoing ? 'message-outgoing' : 'message-incoming'} new-message`;
            
            // Nom de l'expéditeur (seulement pour les messages entrants)
            if (!isOutgoing) {
                const sender = document.createElement('div');
                sender.className = 'message-sender';
                sender.textContent = data.user_name;
                messageItem.appendChild(sender);
            }
            
            // Bulle de message
            const messageBubble = document.createElement('div');
            messageBubble.className = 'message-bubble';
            
            // Contenu du message
            if (data.body) {
                messageBubble.innerHTML = data.body.replace(/\n/g, '<br>');
            }
            
            // Pièces jointes
            if (data.attachments && data.attachments.length > 0) {
                data.attachments.forEach(attachment => {
                    const attachmentDiv = document.createElement('div');
                    attachmentDiv.className = 'message-attachment';
                    
                    if (attachment.is_image) {
                        const img = document.createElement('img');
                        img.src = attachment.url;
                        img.alt = attachment.file_name;
                        img.className = 'attachment-image';
                        img.onclick = function() { openImage(attachment.url) };
                        attachmentDiv.appendChild(img);
                    } else if (attachment.is_video) {
                        const video = document.createElement('video');
                        video.className = 'attachment-video';
                        video.controls = true;
                        
                        const source = document.createElement('source');
                        source.src = attachment.url;
                        source.type = attachment.file_type;
                        
                        video.appendChild(source);
                        attachmentDiv.appendChild(video);
                    } else if (attachment.is_audio) {
                        const audio = document.createElement('audio');
                        audio.className = 'attachment-audio';
                        audio.controls = true;
                        
                        const source = document.createElement('source');
                        source.src = attachment.url;
                        source.type = attachment.file_type;
                        
                        audio.appendChild(source);
                        attachmentDiv.appendChild(audio);
                    } else {
                        // Fichier
                        const fileDiv = document.createElement('div');
                        fileDiv.className = 'attachment-file';
                        fileDiv.innerHTML = `
                            <div class="attachment-file-icon">
                                <i class="fas fa-file"></i>
                            </div>
                            <div class="attachment-file-info">
                                <span class="attachment-file-name">${attachment.file_name}</span>
                                <span class="attachment-file-size">${attachment.file_size} octets</span>
                            </div>
                            <a href="${attachment.url}" class="ms-auto" download="${attachment.file_name}" target="_blank">
                                <i class="fas fa-download"></i>
                            </a>
                        `;
                        attachmentDiv.appendChild(fileDiv);
                    }
                    
                    messageBubble.appendChild(attachmentDiv);
                });
            }
            
            messageItem.appendChild(messageBubble);
            
            // Heure du message
            const messageTime = document.createElement('div');
            messageTime.className = 'message-time';
            const date = new Date(data.created_at);
            messageTime.textContent = date.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
            
            if (isOutgoing) {
                messageTime.innerHTML += ' <i class="fas fa-check" title="Envoyé"></i>';
            }
            
            messageItem.appendChild(messageTime);
            messageGroup.appendChild(messageItem);
            
            messagesContainer.appendChild(messageGroup);
            scrollToBottom();
            
            // Jouer un son de notification pour les messages entrants
            if (!isOutgoing) {
                const notificationSound = new Audio('/sounds/message-notification.mp3');
                notificationSound.volume = 0.5;
                notificationSound.play().catch(e => console.log('Erreur de lecture du son:', e));
                
                // Marquer le message comme lu
                fetch(`{{ route('messaging.mark-as-read', $conversation->id) }}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    }
                });
            }
        });
        
        // Observer l'arrivée au bas de la conversation pour marquer comme lu
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    fetch(`{{ route('messaging.mark-as-read', $conversation->id) }}`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json',
                            'Accept': 'application/json'
                        }
                    });
                }
            });
        }, { threshold: 0.5 });
        
        // Observer le dernier message
        const messages = document.querySelectorAll('.message-item');
        if (messages.length > 0) {
            observer.observe(messages[messages.length - 1]);
        }
        
        // Gestion du focus sur l'input
        messageInput.addEventListener('focus', function() {
            messagesContainer.scrollTo({
                top: messagesContainer.scrollHeight,
                behavior: 'smooth'
            });
        });
        
        // Soumission du formulaire avec Entrée (mais Shift+Entrée pour nouvelle ligne)
        messageInput.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' && !e.shiftKey) {
                e.preventDefault();
                messageForm.dispatchEvent(new Event('submit'));
            }
        });
    });
</script>
@endpush 