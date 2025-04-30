@extends('layouts.app')

@section('title', 'StagesBENIN')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="mb-4">
                <a href="{{ route('messagerie-sociale.index') }}" class="btn btn-primary rounded-pill">
                    <i class="fas fa-arrow-left me-2"></i>Retour au canal
                </a>
            </div>
            
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title mb-3">{{ $post->title ?? 'Publication' }}</h5>
                    
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    
                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif
                    
                    @livewire('nouvelle-messagerie.post-card', ['post' => $post])
                </div>
            </div>
            
            <!-- Section des commentaires récents -->
            <div class="card">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Tous les commentaires</h5>
                </div>
                <div class="card-body">
                    @if($post->comments->count() > 0)
                        <div class="comments-list">
                            @foreach($post->comments()->whereNull('parent_id')->latest()->get() as $comment)
                                <div class="comment-thread mb-4 border-bottom pb-3">
                                    <div class="comment d-flex">
                                        <div class="flex-shrink-0 me-3">
                                            @if($comment->user->avatar)
                                                <img src="{{ asset('storage/' . $comment->user->avatar) }}" class="rounded-circle" width="48" height="48" alt="{{ $comment->user->name }}">
                                            @else
                                                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                                                    {{ strtoupper(substr($comment->user->name, 0, 2)) }}
                                                </div>
                                            @endif
                                        </div>
                                        <div class="flex-grow-1">
                                            <div class="bg-light p-3 rounded-3 mb-2">
                                                <div class="d-flex justify-content-between align-items-center mb-2">
                                                    <div>
                                                        <h6 class="mb-0 fw-bold">{{ $comment->user->name }}</h6>
                                                        <small class="text-muted">{{ $comment->created_at->format('d/m/Y à H:i') }}</small>
                                                    </div>
                                                    @if(auth()->id() === $comment->user_id || auth()->user()->isAdmin())
                                                        <form action="{{ route('messagerie-sociale.delete-comment', $comment) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce commentaire?')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    @endif
                                                </div>
                                                <p class="mb-0">{!! nl2br(e($comment->content)) !!}</p>
                                            </div>
                                            
                                            <div class="d-flex mb-3">
                                                <button class="btn btn-sm btn-outline-primary reply-toggle" data-comment-id="{{ $comment->id }}">
                                                    <i class="fas fa-reply me-1"></i> Répondre
                                                </button>
                                            </div>
                                            
                                            <!-- Formulaire de réponse (caché par défaut) -->
                                            <div class="reply-form-{{ $comment->id }}" style="display: none;">
                                                <form action="{{ route('messagerie-sociale.reply-comment', $comment) }}" method="POST" class="mb-3">
                                                    @csrf
                                                    <div class="input-group">
                                                        <textarea name="content" class="form-control" rows="2" placeholder="Écrire une réponse..." required></textarea>
                                                        <button type="submit" class="btn btn-primary">
                                                            <i class="fas fa-paper-plane"></i>
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                            
                                            <!-- Réponses au commentaire -->
                                            @if($comment->replies->count() > 0)
                                                <div class="replies ms-4 mt-3">
                                                    @foreach($comment->replies as $reply)
                                                        <div class="reply d-flex mb-3">
                                                            <div class="flex-shrink-0 me-2">
                                                                @if($reply->user->avatar)
                                                                    <img src="{{ asset('storage/' . $reply->user->avatar) }}" class="rounded-circle" width="32" height="32" alt="{{ $reply->user->name }}">
                                                                @else
                                                                    <div class="bg-secondary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; font-size: 12px;">
                                                                        {{ strtoupper(substr($reply->user->name, 0, 2)) }}
                                                                    </div>
                                                                @endif
                                                            </div>
                                                            <div class="flex-grow-1">
                                                                <div class="bg-light p-2 rounded-3">
                                                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                                                        <div>
                                                                            <h6 class="mb-0 small fw-bold">{{ $reply->user->name }}</h6>
                                                                            <small class="text-muted" style="font-size: 0.7rem;">{{ $reply->created_at->format('d/m/Y à H:i') }}</small>
                                                                        </div>
                                                                        @if(auth()->id() === $reply->user_id || auth()->user()->isAdmin())
                                                                            <form action="{{ route('messagerie-sociale.delete-comment', $reply) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette réponse?')">
                                                                                @csrf
                                                                                @method('DELETE')
                                                                                <button type="submit" class="btn btn-sm btn-outline-danger" style="padding: 0.1rem 0.3rem;">
                                                                                    <i class="fas fa-trash" style="font-size: 0.7rem;"></i>
                                                                                </button>
                                                                            </form>
                                                                        @endif
                                                                    </div>
                                                                    <p class="mb-0 small">{!! nl2br(e($reply->content)) !!}</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center p-4">
                            <p class="text-muted mb-0">Aucun commentaire pour le moment. Soyez le premier à commenter!</p>
                        </div>
                    @endif
                    
                    <!-- Formulaire pour ajouter un commentaire -->
                    <div class="add-comment mt-4">
                        <h5 class="mb-3">Ajouter un commentaire</h5>
                        <form action="{{ route('messagerie-sociale.add-comment', $post) }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <textarea 
                                    name="content" 
                                    class="form-control @error('content') is-invalid @enderror" 
                                    rows="3" 
                                    placeholder="Écrire un commentaire..."
                                    required
                                ></textarea>
                                @error('content')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-paper-plane me-2"></i>Publier
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Gestion des boutons de réponse
        const replyButtons = document.querySelectorAll('.reply-toggle');
        
        replyButtons.forEach(button => {
            button.addEventListener('click', function() {
                const commentId = this.getAttribute('data-comment-id');
                const replyForm = document.querySelector('.reply-form-' + commentId);
                
                if (replyForm.style.display === 'none') {
                    replyForm.style.display = 'block';
                    this.innerHTML = '<i class="fas fa-times me-1"></i> Annuler';
                } else {
                    replyForm.style.display = 'none';
                    this.innerHTML = '<i class="fas fa-reply me-1"></i> Répondre';
                }
            });
        });
    });
</script>
@endpush
@endsection
