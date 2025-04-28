<div class="card post-card mb-4 shadow-sm" id="post-{{ $post->id }}">
    <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
        <div class="d-flex align-items-center">
            @if($post->user->avatar)
                <img src="{{ asset('storage/' . $post->user->avatar) }}" class="rounded-circle me-3" width="48" height="48" alt="{{ $post->user->name }}" style="object-fit: cover;">
            @else
                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 48px; height: 48px; font-size: 18px;">
                    {{ strtoupper(substr($post->user->name, 0, 2)) }}
                </div>
            @endif
            <div>
                <h5 class="mb-0 fw-bold">{{ $post->user->name }}</h5>
                <small class="text-muted">
                    {{ $post->created_at->diffForHumans() }}
                    @if($post->edited_at)
                        <span class="ms-1 fst-italic">(modifié)</span>
                    @endif
                </small>
            </div>
        </div>
        
        @if(auth()->id() === $post->user_id || auth()->user()->isAdmin())
            <div class="dropdown">
                <button class="btn btn-sm btn-light rounded-circle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-ellipsis-h"></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                    @can('update-post', $post)
                        <li>
                            <a class="dropdown-item" href="{{ route('messagerie-sociale.edit-post', $post) }}">
                                <i class="fas fa-edit me-2 text-primary"></i> Modifier
                            </a>
                        </li>
                    @endcan
                    @can('delete-post', $post)
                        <li>
                            <button class="dropdown-item text-danger" wire:click="deletePost" wire:loading.attr="disabled">
                                <i class="fas fa-trash me-2"></i> Supprimer
                            </button>
                        </li>
                    @endcan
                </ul>
            </div>
        @endif
    </div>
    
    <div class="card-body">
        <div class="post-content mb-3">
            {!! nl2br(e($post->content)) !!}
        </div>
        
        @if($post->attachments->count() > 0)
            <div class="post-attachments mb-3">
                <div class="row g-2">
                    @php
                        $attachmentsCount = $post->attachments->count();
                        $colClass = $attachmentsCount == 1 ? 'col-12' : ($attachmentsCount == 2 ? 'col-6' : 'col-md-4 col-sm-6');
                    @endphp
                    
                    @foreach($post->attachments as $attachment)
                        <div class="{{ $colClass }}">
                            @if($attachment->isImage())
                                <a href="{{ $attachment->getUrlAttribute() }}" target="_blank" class="d-block position-relative rounded overflow-hidden">
                                    <img src="{{ $attachment->getUrlAttribute() }}" class="img-fluid w-100" alt="{{ $attachment->original_name }}" style="object-fit: cover; height: {{ $attachmentsCount == 1 ? '350px' : '200px' }};">
                                </a>
                            @elseif($attachment->isVideo())
                                <div class="ratio ratio-16x9">
                                    <video src="{{ $attachment->getUrlAttribute() }}" controls class="rounded"></video>
                                </div>
                            @else
                                <a href="{{ $attachment->getUrlAttribute() }}" class="d-flex align-items-center p-3 bg-light rounded text-decoration-none" download>
                                    <i class="fas fa-file me-2 fa-2x text-secondary"></i>
                                    <div class="overflow-hidden">
                                        <p class="mb-0 text-truncate">{{ $attachment->original_name }}</p>
                                        <small class="text-muted">{{ $attachment->getFormattedSizeAttribute() }}</small>
                                    </div>
                                </a>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
        
        <div class="post-stats d-flex align-items-center text-muted mb-2 px-2">
            <div class="me-3">
                @if(isset($hasParentIdColumn) && $hasParentIdColumn)
                    <i class="far fa-comment me-1"></i> {{ $post->comments->where('parent_id', null)->count() }} commentaires
                @else
                    <i class="far fa-comment me-1"></i> {{ $post->comments->count() }} commentaires
                @endif
            </div>
            <div>
                <i class="far fa-share-square me-1"></i> {{ $post->shares->count() }} partages
            </div>
        </div>
        
        <div class="post-actions d-flex border-top border-bottom py-2 mb-3">
            <button class="btn btn-light flex-fill me-1 rounded-pill" wire:click="toggleComments">
                <i class="far fa-comment me-1"></i> Commenter
            </button>
            <button class="btn btn-light flex-fill ms-1 rounded-pill" wire:click="toggleShareForm">
                <i class="far fa-share-square me-1"></i> Partager
            </button>
        </div>
        
        @if($showShareForm)
            <div class="share-form mb-3">
                <div class="card shadow-sm border">
                    <div class="card-body">
                        @if($shareUrl)
                            <div class="alert alert-success">
                                <p class="mb-2">Votre lien de partage a été créé :</p>
                                <div class="input-group">
                                    <input type="text" class="form-control" value="{{ $shareUrl }}" id="shareUrl{{ $post->id }}" readonly>
                                    <button class="btn btn-outline-primary" type="button" onclick="copyShareUrl('shareUrl{{ $post->id }}')">
                                        <i class="fas fa-copy"></i>
                                    </button>
                                </div>
                                <div id="copyConfirmation{{ $post->id }}" class="mt-2 text-success d-none">
                                    Lien copié !
                                </div>
                            </div>
                        @else
                            <form wire:submit.prevent="sharePost">
                                <div class="mb-3">
                                    <label for="shareComment" class="form-label">Commentaire (optionnel)</label>
                                    <textarea 
                                        id="shareComment" 
                                        class="form-control @error('shareComment') is-invalid @enderror" 
                                        wire:model.defer="shareComment" 
                                        rows="2" 
                                        placeholder="Ajouter un commentaire à votre partage..."
                                        @if($isSubmitting) disabled @endif
                                    ></textarea>
                                    @error('shareComment')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="d-flex justify-content-end">
                                    <button type="button" class="btn btn-light me-2" wire:click="toggleShareForm" @if($isSubmitting) disabled @endif>
                                        Annuler
                                    </button>
                                    <button type="submit" class="btn btn-primary" @if($isSubmitting) disabled @endif>
                                        @if($isSubmitting)
                                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                            Partage en cours...
                                        @else
                                            Partager
                                        @endif
                                    </button>
                                </div>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        @endif
        
        @if($showComments)
            <div class="comments-section" id="comments-container">
                @if($post->comments->count() > 0)
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <h6 class="mb-0">Commentaires ({{ $post->comments->count() }})</h6>
                        @if(isset($hasParentIdColumn) && $hasParentIdColumn)
                            @if($post->comments->where('parent_id', null)->count() > 3 && $commentsToShow < $post->comments->count())
                                <button id="show-all-comments" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                                    Voir tous les commentaires
                                </button>
                            @endif
                        @endif
                    </div>
                    
                    @php 
                        $displayedComments = 0; 
                        if(isset($hasParentIdColumn) && $hasParentIdColumn) {
                            $mainComments = $post->comments->whereNull('parent_id')->sortByDesc('created_at');
                        } else {
                            $mainComments = $post->comments->sortByDesc('created_at');
                        }
                    @endphp
                    
                    @foreach($mainComments as $comment)
                        @if($displayedComments < $commentsToShow)
                            @php $displayedComments++; @endphp
                            <div class="comment-thread mb-3" id="comment-{{ $comment->id }}">
                                <!-- Commentaire principal -->
                                <div class="comment d-flex mb-2">
                                    <div class="flex-shrink-0 me-2">
                                        @if($comment->user->avatar)
                                            <img src="{{ asset('storage/' . $comment->user->avatar) }}" class="rounded-circle" width="40" height="40" alt="{{ $comment->user->name }}" style="object-fit: cover;">
                                        @else
                                            <div class="bg-secondary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; font-size: 14px;">
                                                {{ strtoupper(substr($comment->user->name, 0, 2)) }}
                                            </div>
                                        @endif
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="bg-light p-3 rounded">
                                            <div class="d-flex justify-content-between align-items-start mb-1">
                                                <div class="fw-bold">{{ $comment->user->name }}</div>
                                                <div class="dropdown">
                                                    @if(auth()->id() === $comment->user_id || auth()->user()->isAdmin())
                                                        <button class="btn btn-sm p-0 border-0" type="button" data-bs-toggle="dropdown">
                                                            <i class="fas fa-ellipsis-h text-muted"></i>
                                                        </button>
                                                        <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                                                            <li>
                                                                <button class="dropdown-item text-danger" wire:click="deleteComment({{ $comment->id }})" wire:loading.attr="disabled">
                                                                    <i class="fas fa-trash me-2"></i> Supprimer
                                                                </button>
                                                            </li>
                                                        </ul>
                                                    @endif
                                                </div>
                                            </div>
                                            <p class="mb-0">{!! nl2br(e($comment->content)) !!}</p>
                                        </div>
                                        <div class="d-flex mt-1 align-items-center ms-2">
                                            <small class="text-muted me-3">{{ $comment->created_at->diffForHumans() }}</small>
                                            @if(isset($hasParentIdColumn) && $hasParentIdColumn)
                                                <button class="btn btn-sm p-0 border-0 text-primary reply-button" data-comment-id="{{ $comment->id }}" wire:click="startReply({{ $comment->id }})">
                                                    <small>Répondre</small>
                                                </button>
                                            @endif
                                        </div>
                                        
                                        @if(isset($hasParentIdColumn) && $hasParentIdColumn)
                                            <!-- Formulaire de réponse -->
                                            @if($replyToComment === $comment->id)
                                                <div class="reply-form mt-2" id="reply-form-{{ $comment->id }}">
                                                    <div class="d-flex">
                                                        <div class="flex-shrink-0 me-1" style="margin-top:3px;">
                                                            @if(auth()->user()->avatar)
                                                                <img src="{{ asset('storage/' . auth()->user()->avatar) }}" class="rounded-circle" width="32" height="32" alt="{{ auth()->user()->name }}" style="object-fit: cover;">
                                                            @else
                                                                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; font-size: 12px;">
                                                                    {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                                                                </div>
                                                            @endif
                                                        </div>
                                                        <div class="flex-grow-1">
                                                            <form wire:submit.prevent="submitReply">
                                                                <div class="input-group">
                                                                    <input 
                                                                        type="text" 
                                                                        class="form-control form-control-sm rounded-pill @error('replyContent') is-invalid @enderror" 
                                                                        wire:model.defer="replyContent" 
                                                                        placeholder="Répondre à {{ $comment->user->name }}..."
                                                                        @if($isSubmitting) disabled @endif
                                                                    >
                                                                    <button 
                                                                        class="btn btn-sm btn-primary rounded-circle ms-1" 
                                                                        type="submit"
                                                                        @if($isSubmitting) disabled @endif
                                                                    >
                                                                        @if($isSubmitting)
                                                                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                                                        @else
                                                                            <i class="fas fa-paper-plane"></i>
                                                                        @endif
                                                                    </button>
                                                                    <button 
                                                                        class="btn btn-sm btn-light rounded-circle ms-1"
                                                                        type="button"
                                                                        wire:click="cancelReply"
                                                                        @if($isSubmitting) disabled @endif
                                                                    >
                                                                        <i class="fas fa-times"></i>
                                                                    </button>
                                                                </div>
                                                                @error('replyContent')
                                                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                                                @enderror
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                            
                                            <!-- Réponses aux commentaires -->
                                            @if($comment->replies && $comment->replies->count() > 0)
                                                <div class="replies ms-4 mt-2">
                                                    @foreach($comment->replies as $reply)
                                                        <div class="reply d-flex mb-2" id="comment-{{ $reply->id }}">
                                                            <div class="flex-shrink-0 me-2">
                                                                @if($reply->user->avatar)
                                                                    <img src="{{ asset('storage/' . $reply->user->avatar) }}" class="rounded-circle" width="30" height="30" alt="{{ $reply->user->name }}" style="object-fit: cover;">
                                                                @else
                                                                    <div class="bg-secondary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 30px; height: 30px; font-size: 10px;">
                                                                        {{ strtoupper(substr($reply->user->name, 0, 2)) }}
                                                                    </div>
                                                                @endif
                                                            </div>
                                                            <div class="flex-grow-1">
                                                                <div class="bg-light p-2 rounded">
                                                                    <div class="d-flex justify-content-between align-items-center">
                                                                        <div class="fw-bold small">{{ $reply->user->name }}</div>
                                                                        <div class="dropdown">
                                                                            @if(auth()->id() === $reply->user_id || auth()->user()->isAdmin())
                                                                                <button class="btn btn-sm p-0 border-0" type="button" data-bs-toggle="dropdown" style="font-size: 0.7rem;">
                                                                                    <i class="fas fa-ellipsis-h text-muted"></i>
                                                                                </button>
                                                                                <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                                                                                    <li>
                                                                                        <button class="dropdown-item text-danger" wire:click="deleteComment({{ $reply->id }})" wire:loading.attr="disabled">
                                                                                            <i class="fas fa-trash me-2"></i> Supprimer
                                                                                        </button>
                                                                                    </li>
                                                                                </ul>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                    <p class="mb-0 small">{!! nl2br(e($reply->content)) !!}</p>
                                                                </div>
                                                                <div class="mt-1 ms-2">
                                                                    <small class="text-muted" style="font-size: 0.7rem;">{{ $reply->created_at->diffForHumans() }}</small>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                    
                    @if($mainComments->count() > $commentsToShow)
                        <div class="text-center mb-3">
                            <button class="btn btn-outline-primary btn-sm rounded-pill" wire:click="showAllComments">
                                Voir {{ $mainComments->count() - $commentsToShow }} commentaires supplémentaires
                            </button>
                        </div>
                    @endif
                @else
                    <div class="text-center text-muted py-3">
                        <p class="mb-0">Aucun commentaire. Soyez le premier à commenter!</p>
                    </div>
                @endif
                
                <div class="add-comment mt-3">
                    <form wire:submit.prevent="addComment" class="d-flex">
                        <div class="flex-shrink-0 me-2">
                            @if(auth()->user()->avatar)
                                <img src="{{ asset('storage/' . auth()->user()->avatar) }}" class="rounded-circle" width="40" height="40" alt="{{ auth()->user()->name }}" style="object-fit: cover;">
                            @else
                                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; font-size: 14px;">
                                    {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                                </div>
                            @endif
                        </div>
                        <div class="flex-grow-1">
                            <div class="input-group">
                                <input 
                                    type="text" 
                                    class="form-control rounded-pill @error('newComment') is-invalid @enderror" 
                                    wire:model.defer="newComment" 
                                    placeholder="Écrire un commentaire..."
                                    @if($isSubmitting) disabled @endif
                                >
                                <button 
                                    class="btn btn-primary rounded-circle ms-2" 
                                    type="submit"
                                    @if($isSubmitting) disabled @endif
                                >
                                    @if($isSubmitting)
                                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                    @else
                                        <i class="fas fa-paper-plane"></i>
                                    @endif
                                </button>
                            </div>
                            @error('newComment')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </form>
                </div>
            </div>
        @endif
    </div>
</div>

<style>
/* Styles Facebook pour post-card */
.post-card {
    border-radius: 8px;
    border: none;
    transition: box-shadow 0.2s;
}

.post-card .card-header {
    background-color: #fff;
    border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    padding: 12px 16px;
    border-radius: 8px 8px 0 0;
}

.post-card .rounded-circle {
    object-fit: cover;
    border: 1px solid rgba(0, 0, 0, 0.1);
}

.post-card h5.mb-0 {
    font-size: 15px;
    font-weight: 600;
    color: #050505;
}

.post-card .text-muted {
    color: #65676B !important;
    font-size: 13px;
}

.post-card .card-body {
    padding: 16px;
    font-size: 15px;
    color: #050505;
}

.post-card .post-content {
    line-height: 1.5;
    white-space: pre-line;
}

.post-card .post-actions {
    border-color: rgba(0, 0, 0, 0.05) !important;
    padding: 4px 0;
}

.post-card .btn-light {
    background-color: #f0f2f5;
    border: none;
    color: #65676B;
    font-weight: 600;
    font-size: 14px;
    transition: background-color 0.2s;
}

.post-card .btn-light:hover {
    background-color: #e4e6e9;
}

.post-card .btn-primary {
    background-color: #1877F2;
    border-color: #1877F2;
}

.post-card .btn-primary:hover {
    background-color: #166FE5;
    border-color: #166FE5;
}

.post-card .btn-outline-primary {
    color: #1877F2;
    border-color: #1877F2;
}

.post-card .btn-outline-primary:hover {
    background-color: rgba(24, 119, 242, 0.1);
    color: #1877F2;
}

/* Commentaires style Facebook */
.post-card .comments-section {
    margin-top: 8px;
}

.post-card .comment .bg-light, 
.post-card .reply .bg-light {
    background-color: #f0f2f5 !important;
    border-radius: 18px !important;
    padding: 8px 12px !important;
}

.post-card .comment .fw-bold,
.post-card .reply .fw-bold {
    font-size: 13px;
    margin-bottom: 2px;
}

.post-card .reply .fw-bold {
    font-size: 12px;
}

.post-card .comment p,
.post-card .reply p {
    margin-bottom: 0;
    font-size: 14px;
}

.post-card .reply p {
    font-size: 12px;
}

/* Formulaire de commentaire */
.post-card .add-comment .form-control,
.post-card .reply-form .form-control {
    background-color: #f0f2f5;
    border: none;
    padding-left: 16px;
    padding-right: 16px;
    height: 36px;
}

.post-card .add-comment .form-control:focus,
.post-card .reply-form .form-control:focus {
    background-color: #f0f2f5;
    box-shadow: none;
    border: none;
}

/* Boutons et interactions */
.post-card .dropdown-menu {
    box-shadow: 0 1px 5px rgba(0, 0, 0, 0.2);
    border: none;
    border-radius: 8px;
    font-size: 14px;
}

.post-card .dropdown-item {
    padding: 8px 16px;
}

.post-card .dropdown-item:hover {
    background-color: #f0f2f5;
}

/* Attachements */
.post-card .post-attachments img {
    border-radius: 8px;
    transition: filter 0.2s;
}

.post-card .post-attachments img:hover {
    filter: brightness(0.95);
}

/* Boutons répondre */
.post-card .reply-button {
    opacity: 0.8;
    font-size: 12px;
    font-weight: 600;
}

.post-card .reply-button:hover {
    opacity: 1;
    text-decoration: underline;
}

/* Formulaire de partage */
.post-card .share-form .card {
    border-radius: 8px;
    overflow: hidden;
}

/* Ajustements responsive */
@media (max-width: 576px) {
    .post-card .card-header {
        padding: 10px 12px;
    }
    
    .post-card .card-body {
        padding: 12px;
    }
    
    .post-card h5.mb-0 {
        font-size: 14px;
    }
    
    .post-card .post-content {
        font-size: 14px;
    }
}

/* Animation pour les interactions */
.post-card .btn {
    transition: all 0.2s;
}

.post-card .btn:active {
    transform: scale(0.97);
}

/* Hover sur les commentaires */
.post-card .comment:hover .dropdown .btn,
.post-card .reply:hover .dropdown .btn {
    visibility: visible;
    opacity: 1;
}

.post-card .comment .dropdown .btn,
.post-card .reply .dropdown .btn {
    visibility: hidden;
    opacity: 0.5;
    transition: visibility 0s, opacity 0.2s;
}

/* Couleurs personnalisées Facebook */
:root {
    --fb-blue: #1877F2;
    --fb-dark-blue: #166FE5;
    --fb-green: #42B72A;
    --fb-grey: #F0F2F5;
    --fb-dark-grey: #E4E6E9;
    --fb-text: #050505;
    --fb-secondary-text: #65676B;
}
</style>

<script>
    function copyShareUrl(elementId) {
        const shareUrlInput = document.getElementById(elementId);
        shareUrlInput.select();
        document.execCommand('copy');
        
        // Afficher confirmation
        const confirmation = document.getElementById('copyConfirmation' + elementId.replace('shareUrl', ''));
        confirmation.classList.remove('d-none');
        
        // Cacher après 2 secondes
        setTimeout(() => {
            confirmation.classList.add('d-none');
        }, 2000);
    }
    
    document.addEventListener('DOMContentLoaded', function() {
        // Gérer l'affichage du modal de commentaires si besoin
        const showAllCommentsBtn = document.getElementById('show-all-comments');
        if (showAllCommentsBtn) {
            showAllCommentsBtn.addEventListener('click', function() {
                const commentsModal = new bootstrap.Modal(document.getElementById('allCommentsModal'));
                commentsModal.show();
            });
        }
        
        // Animer les boutons lors du clic
        const buttons = document.querySelectorAll('.post-card .btn');
        buttons.forEach(button => {
            button.addEventListener('mousedown', function() {
                this.style.transform = 'scale(0.97)';
            });
            button.addEventListener('mouseup', function() {
                this.style.transform = 'scale(1)';
            });
        });
    });
    
    // Cette fonction est appelée via Livewire quand un nouveau commentaire est ajouté
    window.addEventListener('comment-added', event => {
        // Faire défiler vers le nouveau commentaire
        const commentElement = document.getElementById('comment-' + event.detail.commentId);
        if (commentElement) {
            commentElement.scrollIntoView({ behavior: 'smooth' });
        }
    });
</script> 