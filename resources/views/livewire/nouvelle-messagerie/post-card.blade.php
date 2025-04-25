<div class="card post-card mb-4" id="post-{{ $post->id }}">
    <div class="card-header d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center">
            @if($post->user->avatar)
                <img src="{{ asset('storage/' . $post->user->avatar) }}" class="rounded-circle me-2" width="40" height="40" alt="{{ $post->user->name }}">
            @else
                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 40px; height: 40px;">
                    {{ strtoupper(substr($post->user->name, 0, 2)) }}
                </div>
            @endif
            <div>
                <h5 class="mb-0">{{ $post->user->name }}</h5>
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
                <button class="btn btn-sm btn-light" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-ellipsis-v"></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    @can('update-post', $post)
                        <li>
                            <a class="dropdown-item" href="{{ route('messagerie-sociale.edit-post', $post) }}">
                                <i class="fas fa-edit me-2"></i> Modifier
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
                <div class="row g-3">
                    @foreach($post->attachments as $attachment)
                        <div class="col-md-4 col-sm-6">
                            @if($attachment->isImage())
                                <a href="{{ $attachment->getUrlAttribute() }}" target="_blank">
                                    <img src="{{ $attachment->getUrlAttribute() }}" class="img-fluid rounded" alt="{{ $attachment->original_name }}">
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
        
        <div class="post-stats d-flex align-items-center text-muted mb-2">
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
            <button class="btn btn-light flex-fill me-1" wire:click="toggleComments">
                <i class="far fa-comment me-1"></i> Commenter
            </button>
            <button class="btn btn-light flex-fill ms-1" wire:click="toggleShareForm">
                <i class="far fa-share-square me-1"></i> Partager
            </button>
        </div>
        
        @if($showShareForm)
            <div class="share-form mb-3">
                <div class="card">
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
                    <h6 class="mb-3 d-flex align-items-center justify-content-between">
                        <span>Commentaires ({{ $post->comments->count() }})</span>
                        @if(isset($hasParentIdColumn) && $hasParentIdColumn)
                            @if($post->comments->where('parent_id', null)->count() > 3 && $commentsToShow < $post->comments->count())
                                <button id="show-all-comments" class="btn btn-sm btn-outline-primary">
                                    Voir tous les commentaires
                                </button>
                            @endif
                        @endif
                    </h6>
                    
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
                                            <img src="{{ asset('storage/' . $comment->user->avatar) }}" class="rounded-circle" width="36" height="36" alt="{{ $comment->user->name }}">
                                        @else
                                            <div class="bg-secondary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                                                {{ strtoupper(substr($comment->user->name, 0, 2)) }}
                                            </div>
                                        @endif
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="bg-light p-3 rounded">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div class="fw-bold">{{ $comment->user->name }}</div>
                                                @if(auth()->id() === $comment->user_id || auth()->user()->isAdmin())
                                                    <button class="btn btn-sm text-danger p-0 border-0" wire:click="deleteComment({{ $comment->id }})" wire:loading.attr="disabled">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                @endif
                                            </div>
                                            <p class="mb-0">{!! nl2br(e($comment->content)) !!}</p>
                                        </div>
                                        <div class="d-flex mt-1 align-items-center">
                                            <small class="text-muted me-2">{{ $comment->created_at->diffForHumans() }}</small>
                                            @if(isset($hasParentIdColumn) && $hasParentIdColumn)
                                                <button class="btn btn-sm p-0 reply-button border-0 text-primary" data-comment-id="{{ $comment->id }}" wire:click="startReply({{ $comment->id }})">
                                                    Répondre
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
                                                                <img src="{{ asset('storage/' . auth()->user()->avatar) }}" class="rounded-circle" width="28" height="28" alt="{{ auth()->user()->name }}">
                                                            @else
                                                                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 28px; height: 28px; font-size: 10px;">
                                                                    {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                                                                </div>
                                                            @endif
                                                        </div>
                                                        <div class="flex-grow-1">
                                                            <form wire:submit.prevent="submitReply">
                                                                <div class="input-group">
                                                                    <input 
                                                                        type="text" 
                                                                        class="form-control form-control-sm @error('replyContent') is-invalid @enderror" 
                                                                        wire:model.defer="replyContent" 
                                                                        placeholder="Répondre à {{ $comment->user->name }}..."
                                                                        @if($isSubmitting) disabled @endif
                                                                    >
                                                                    <button 
                                                                        class="btn btn-sm btn-primary" 
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
                                                                        class="btn btn-sm btn-outline-secondary"
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
                                                                    <img src="{{ asset('storage/' . $reply->user->avatar) }}" class="rounded-circle" width="28" height="28" alt="{{ $reply->user->name }}">
                                                                @else
                                                                    <div class="bg-secondary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 28px; height: 28px; font-size: 10px;">
                                                                        {{ strtoupper(substr($reply->user->name, 0, 2)) }}
                                                                    </div>
                                                                @endif
                                                            </div>
                                                            <div class="flex-grow-1">
                                                                <div class="bg-light p-2 rounded">
                                                                    <div class="d-flex justify-content-between align-items-center">
                                                                        <div class="fw-bold small">{{ $reply->user->name }}</div>
                                                                        @if(auth()->id() === $reply->user_id || auth()->user()->isAdmin())
                                                                            <button class="btn btn-sm text-danger p-0 border-0" style="font-size: 0.7rem;" wire:click="deleteComment({{ $reply->id }})" wire:loading.attr="disabled">
                                                                                <i class="fas fa-times"></i>
                                                                            </button>
                                                                        @endif
                                                                    </div>
                                                                    <p class="mb-0 small">{!! nl2br(e($reply->content)) !!}</p>
                                                                </div>
                                                                <div class="mt-1">
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
                            <button class="btn btn-outline-primary btn-sm" wire:click="showAllComments">
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
                                <img src="{{ asset('storage/' . auth()->user()->avatar) }}" class="rounded-circle" width="36" height="36" alt="{{ auth()->user()->name }}">
                            @else
                                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                                    {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                                </div>
                            @endif
                        </div>
                        <div class="flex-grow-1">
                            <div class="input-group">
                                <input 
                                    type="text" 
                                    class="form-control @error('newComment') is-invalid @enderror" 
                                    wire:model.defer="newComment" 
                                    placeholder="Écrire un commentaire..."
                                    @if($isSubmitting) disabled @endif
                                >
                                <button 
                                    class="btn btn-primary" 
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