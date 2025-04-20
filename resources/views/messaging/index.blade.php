@extends('layouts.etudiant.app')

@section('title', 'Messagerie')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center bg-white">
            <h1 class="h4 mb-0">Messagerie</h1>
            <a href="{{ route('messaging.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-1"></i> Nouvelle conversation
            </a>
        </div>
        
        <div class="card-body p-0">
            <div class="messaging-container">
                <div class="conversations-container">
                    @if($conversations->isEmpty())
                        <div class="p-4 text-center">
                            <div class="empty-state">
                                <i class="fas fa-comments text-muted" style="font-size: 3rem;"></i>
                                <p class="mt-3">Vous n'avez aucune conversation.</p>
                                <a href="{{ route('messaging.create') }}" class="btn btn-sm btn-primary mt-2">
                                    Démarrer une nouvelle conversation
                                </a>
                            </div>
                        </div>
                    @else
                        <div class="conversation-list">
                            @foreach($conversations as $conversation)
                                @php
                                    $otherParticipants = $conversation->participants->where('id', '!=', Auth::id());
                                    $lastMessage = $conversation->lastMessage;
                                    $unreadCount = $conversation->unreadMessagesCount(Auth::id());
                                @endphp
                                <a href="{{ route('messaging.show', $conversation->id) }}" class="conversation-item {{ request()->route('conversation') && request()->route('conversation')->id == $conversation->id ? 'active' : '' }}">
                                    <div class="conversation-avatar">
                                        @if($conversation->is_group)
                                            <div class="group-avatar">
                                                <i class="fas fa-users"></i>
                                            </div>
                                        @else
                                            <div class="user-avatar">
                                                <i class="fas fa-user"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="conversation-info">
                                        <div class="conversation-name">
                                            @if($conversation->is_group)
                                                {{ $conversation->name }}
                                            @else
                                                {{ $otherParticipants->first()->name ?? 'Utilisateur inconnu' }}
                                            @endif
                                            @if($unreadCount > 0)
                                                <span class="badge bg-primary">{{ $unreadCount }}</span>
                                            @endif
                                        </div>
                                        <div class="conversation-last-message">
                                            @if($lastMessage)
                                                @if($lastMessage->user_id == Auth::id())
                                                    <span class="text-muted">Vous: </span>
                                                @else
                                                    <span class="text-muted">{{ $lastMessage->user->name ?? 'Inconnu' }}: </span>
                                                @endif
                                                
                                                @if($lastMessage->type === 'text')
                                                    {{ Str::limit($lastMessage->body, 30) }}
                                                @elseif($lastMessage->type === 'image')
                                                    <i class="fas fa-image"></i> Image
                                                @elseif($lastMessage->type === 'video')
                                                    <i class="fas fa-video"></i> Vidéo
                                                @elseif($lastMessage->type === 'audio')
                                                    <i class="fas fa-microphone"></i> Audio
                                                @elseif($lastMessage->type === 'file')
                                                    <i class="fas fa-file"></i> Fichier
                                                @endif
                                            @else
                                                <span class="text-muted">Aucun message</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="conversation-time">
                                        @if($lastMessage)
                                            {{ $lastMessage->created_at->diffForHumans(null, true, true) }}
                                        @endif
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .messaging-container {
        display: flex;
        height: calc(100vh - 280px);
        min-height: 500px;
        border-radius: 0.375rem;
    }
    
    .conversations-container {
        width: 100%;
        border-right: 1px solid #e5e7eb;
        overflow-y: auto;
    }
    
    .conversation-list {
        display: flex;
        flex-direction: column;
    }
    
    .conversation-item {
        display: flex;
        padding: 15px;
        border-bottom: 1px solid #f3f4f6;
        text-decoration: none;
        color: inherit;
        transition: background-color 0.15s ease-in-out;
    }
    
    .conversation-item:hover, .conversation-item.active {
        background-color: #f9fafb;
    }
    
    .conversation-avatar {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background-color: #e5e7eb;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 15px;
        flex-shrink: 0;
    }
    
    .user-avatar, .group-avatar {
        font-size: 1.5rem;
        color: #6b7280;
    }
    
    .conversation-info {
        flex-grow: 1;
        overflow: hidden;
    }
    
    .conversation-name {
        font-weight: 600;
        margin-bottom: 5px;
        display: flex;
        justify-content: space-between;
    }
    
    .conversation-last-message {
        color: #6b7280;
        font-size: 0.875rem;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    
    .conversation-time {
        font-size: 0.75rem;
        color: #9ca3af;
        margin-left: 10px;
        white-space: nowrap;
    }
    
    .empty-state {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 3rem;
        color: #6b7280;
    }
</style>
@endsection 