@extends('layouts.etudiant.app')

@section('title', 'Annonce - ' . Str::limit($post->content, 30))

@push('styles')
<style>
    .post-card {
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        border-radius: 8px;
        overflow: hidden;
        margin-bottom: 20px;
    }
    
    .post-header {
        padding: 15px;
        border-bottom: 1px solid #f0f2f5;
        background-color: #fff;
    }
    
    .post-body {
        padding: 20px;
        background-color: #fff;
    }
    
    .post-footer {
        border-top: 1px solid #f0f2f5;
        padding: 10px 15px;
        background-color: #fff;
    }
    
    .post-actions {
        display: flex;
        justify-content: space-between;
    }
    
    .action-button {
        border: none;
        background-color: transparent;
        color: #65676b;
        font-weight: 600;
        flex-grow: 1;
        padding: 8px 0;
        border-radius: 4px;
        transition: background-color 0.2s;
    }
    
    .action-button:hover {
        background-color: #f0f2f5;
    }
    
    .comment-section {
        padding: 15px;
        background-color: #f8f9fa;
        border-top: 1px solid #f0f2f5;
    }
    
    .comment {
        display: flex;
        margin-bottom: 12px;
    }
    
    .comment-avatar {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        margin-right: 10px;
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: #e4e6eb;
        color: #65676b;
        font-weight: bold;
    }
    
    .comment-bubble {
        background-color: #e4e6eb;
        border-radius: 18px;
        padding: 8px 12px;
        max-width: calc(100% - 50px);
    }
    
    .comment-author {
        font-weight: 600;
        margin-bottom: 2px;
        font-size: 0.9rem;
    }
    
    .comment-text {
        margin-bottom: 0;
    }
    
    .comment-actions {
        margin-top: 2px;
        display: flex;
        font-size: 0.75rem;
    }
    
    .comment-action {
        margin-right: 10px;
        color: #65676b;
        font-weight: 600;
        cursor: pointer;
    }
    
    .comment-action:hover {
        text-decoration: underline;
    }
    
    .comment-form {
        display: flex;
        margin-top: 15px;
    }
    
    .comment-input {
        flex-grow: 1;
        border: none;
        background-color: #e4e6eb;
        border-radius: 18px;
        padding: 8px 12px;
        resize: none;
    }
    
    .comment-input:focus {
        outline: none;
        box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.5);
    }
    
    .view-more-btn {
        background-color: #e4e6eb;
        border: none;
        border-radius: 4px;
        padding: 5px 10px;
        font-size: 0.8rem;
        color: #65676b;
        cursor: pointer;
        font-weight: 600;
        display: block;
        width: 100%;
        text-align: center;
        margin: 10px 0;
    }
    
    .view-more-btn:hover {
        background-color: #d8dadf;
    }
    
    .replies-container {
        margin-left: 46px;
    }
    
    .reply-form {
        margin-left: 46px;
        margin-top: 5px;
        display: flex;
    }
    
    .btn-share-post {
        background-color: #4267B2;
        color: white;
        border: none;
        border-radius: 4px;
        padding: 8px 16px;
        font-weight: 600;
        transition: background-color 0.2s;
    }
    
    .btn-share-post:hover {
        background-color: #365899;
    }
    
    .btn-return {
        display: inline-flex;
        align-items: center;
        padding: 8px 16px;
        background-color: #f0f2f5;
        color: #050505;
        border-radius: 6px;
        font-weight: 600;
        border: none;
        transition: background-color 0.2s;
    }
    
    .btn-return:hover {
        background-color: #e4e6eb;
        text-decoration: none;
    }
    
    .btn-return i {
        margin-right: 8px;
    }
    
    .share-info {
        background-color: #e7f3ff;
        padding: 12px;
        border-radius: 8px;
        margin-bottom: 15px;
    }
    
    .share-info h5 {
        color: #1877f2;
        font-size: 1rem;
        margin-bottom: 5px;
    }

    .comment-thread {
        margin-bottom: 15px;
    }
    
    .replies {
        margin-left: 40px;
        margin-top: 10px;
    }
    
    .reply-form {
        margin-left: 40px;
        margin-top: 10px;
    }

    /* Pour des avatars de taille uniforme */
    .comment-avatar {
        width: 36px;
        height: 36px;
        overflow: hidden;
    }
    
    .reply-avatar {
        width: 28px;
        height: 28px;
        overflow: hidden;
    }
</style>
@endpush

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h4">Détails de l'annonce</h1>
                <a href="{{ route('messagerie-sociale.index') }}" class="btn-return">
                    <i class="fas fa-arrow-left"></i> Retour au canal
                </a>
            </div>
            
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                    @if(session('share_url'))
                        <div class="mt-2">
                            <p class="mb-1">Lien de partage:</p>
                            <div class="input-group">
                                <input type="text" class="form-control" value="{{ session('share_url') }}" id="sessionShareUrl" readonly>
                                <button class="btn btn-outline-primary" type="button" onclick="copyShareUrl('sessionShareUrl')">
                                    <i class="fas fa-copy"></i>
                                </button>
                            </div>
                        </div>
                    @endif
                </div>
            @endif
            
            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
            
            @if(isset($share))
                <div class="share-info">
                    <h5>Annonce partagée par {{ $share->user->name }}</h5>
                    @if($share->comment)
                        <p>{{ $share->comment }}</p>
                    @endif
                    <hr>
                    <p class="mb-0 small text-muted">Partagé le {{ $share->created_at->format('d/m/Y à H:i') }}</p>
                </div>
            @endif
            
            <div class="post-card">
                <div id="post-{{ $post->id }}">
                    @livewire('nouvelle-messagerie.post-card', ['post' => $post])
                </div>
            </div>
            
            <!-- Modal pour afficher tous les commentaires -->
            <div class="modal fade" id="allCommentsModal" tabindex="-1" aria-labelledby="commentsModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-scrollable modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="commentsModalLabel">Tous les commentaires</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body" id="all-comments-container">
                            <!-- Les commentaires seront chargés ici via JavaScript -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function copyShareUrl(elementId) {
        const shareUrlInput = document.getElementById(elementId);
        shareUrlInput.select();
        document.execCommand('copy');
        
        // Optional: Show a copy confirmation
        const button = shareUrlInput.nextElementSibling;
        const originalHTML = button.innerHTML;
        button.innerHTML = '<i class="fas fa-check"></i>';
        setTimeout(() => {
            button.innerHTML = originalHTML;
        }, 2000);
    }
    
    document.addEventListener('DOMContentLoaded', function() {
        // Fonction pour charger les commentaires dans le modal
        window.loadCommentsIntoModal = function() {
            const sourceContainer = document.querySelector('.comments-section');
            const targetContainer = document.getElementById('all-comments-container');
            
            if (sourceContainer && targetContainer) {
                targetContainer.innerHTML = sourceContainer.innerHTML;
            }
        };
        
        // Écouteur d'événement Livewire pour la mise à jour des commentaires
        window.addEventListener('refreshComments', function() {
            if (document.getElementById('allCommentsModal').classList.contains('show')) {
                window.loadCommentsIntoModal();
            }
        });
    });
</script>
@endsection 