<?php

namespace App\Http\Livewire\NouvelleMessagerie;

use Livewire\Component;
use App\Models\MessagePost;
use App\Models\MessageComment;
use App\Models\MessageShareToken;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Schema;

class PostCard extends Component
{
    public MessagePost $post;
    public $newComment = '';
    public $shareComment = '';
    public $showComments = false;
    public $showShareForm = false;
    public $shareUrl = null;
    public $isSubmitting = false;
    public $replyToComment = null;
    public $replyContent = '';
    public $commentsToShow = 3;

    protected $listeners = ['refreshComments' => 'refreshPost'];

    public function mount(MessagePost $post)
    {
        $this->post = $post;
    }

    public function refreshPost()
    {
        // Recharge le post depuis la base de données
        $this->post = MessagePost::with(['user', 'attachments'])->find($this->post->id);
        
        // Vérifier si la colonne parent_id existe avant de charger les relations hiérarchiques
        if (Schema::hasColumn('message_comments', 'parent_id')) {
            $this->post->load(['comments.user', 'comments.replies.user']);
        } else {
            $this->post->load(['comments.user']);
        }
    }

    protected function rules()
    {
        return [
            'newComment' => ['required', 'string', 'max:500'],
            'shareComment' => ['nullable', 'string', 'max:500'],
            'replyContent' => ['required', 'string', 'max:500'],
        ];
    }

    public function toggleComments()
    {
        $this->showComments = !$this->showComments;
    }

    public function toggleShareForm()
    {
        $this->showShareForm = !$this->showShareForm;
        $this->shareUrl = null;
    }

    public function sharePost()
    {
        if (!Gate::allows('share-post', $this->post)) {
            return;
        }

        $this->isSubmitting = true;

        try {
            $token = Str::random(32);
            
            MessageShareToken::create([
                'user_id' => Auth::id(),
                'post_id' => $this->post->id,
                'token' => $token,
                'comment' => $this->shareComment,
            ]);
            
            $this->shareUrl = URL::route('messagerie-sociale.shared-post', ['token' => $token]);
            $this->shareComment = '';
            $this->isSubmitting = false;
            
            // Mettre à jour le nombre de partages
            $this->post = $this->post->fresh();
        } catch (\Exception $e) {
            session()->flash('error', 'Une erreur est survenue lors du partage de la publication.');
            $this->isSubmitting = false;
        }
    }

    public function addComment()
    {
        $this->validate([
            'newComment' => ['required', 'string', 'max:500'],
        ]);

        $this->isSubmitting = true;

        try {
            $comment = new MessageComment([
                'user_id' => Auth::id(),
                'content' => $this->newComment,
            ]);
            
            $this->post->comments()->save($comment);
            $this->newComment = '';
            
            // Refresh les commentaires
            $this->refreshPost();
            $this->emit('refreshComments');
            
            // Garder les commentaires ouverts
            $this->showComments = true;
        } catch (\Exception $e) {
            session()->flash('error', 'Une erreur est survenue lors de l\'ajout du commentaire.');
        }

        $this->isSubmitting = false;
    }

    public function deleteComment($commentId)
    {
        $comment = MessageComment::find($commentId);
        
        if (!$comment) {
            return;
        }
        
        if (Gate::allows('delete-comment', $comment)) {
            // Supprimer également les réponses à ce commentaire si la colonne parent_id existe
            if (Schema::hasColumn('message_comments', 'parent_id')) {
                if (!$comment->parent_id) {
                    MessageComment::where('parent_id', $comment->id)->delete();
                }
            }
            
            $comment->delete();
            
            // Refresh les commentaires
            $this->refreshPost();
            $this->emit('refreshComments');
        }
    }

    public function startReply($commentId)
    {
        // Vérifier si la fonctionnalité de réponse est disponible
        if (!Schema::hasColumn('message_comments', 'parent_id')) {
            session()->flash('error', 'La fonctionnalité de réponse aux commentaires n\'est pas encore disponible.');
            return;
        }
        
        $this->replyToComment = $commentId;
        $this->replyContent = '';
    }

    public function cancelReply()
    {
        $this->replyToComment = null;
        $this->replyContent = '';
    }

    public function submitReply()
    {
        // Vérifier si la fonctionnalité de réponse est disponible
        if (!Schema::hasColumn('message_comments', 'parent_id')) {
            session()->flash('error', 'La fonctionnalité de réponse aux commentaires n\'est pas encore disponible.');
            return;
        }
        
        $this->validate([
            'replyContent' => ['required', 'string', 'max:500'],
        ]);

        $this->isSubmitting = true;

        try {
            $parentComment = MessageComment::find($this->replyToComment);
            
            if ($parentComment) {
                $reply = new MessageComment([
                    'user_id' => Auth::id(),
                    'content' => $this->replyContent,
                    'parent_id' => $this->replyToComment,
                ]);
                
                $this->post->comments()->save($reply);
                
                // Réinitialiser le formulaire de réponse
                $this->replyToComment = null;
                $this->replyContent = '';
                
                // Refresh les commentaires
                $this->refreshPost();
                $this->emit('refreshComments');
            }
        } catch (\Exception $e) {
            session()->flash('error', 'Une erreur est survenue lors de l\'ajout de la réponse.');
        }

        $this->isSubmitting = false;
    }

    public function showAllComments()
    {
        // Afficher tous les commentaires
        $this->commentsToShow = $this->post->comments->count();
    }

    public function deletePost()
    {
        if (Gate::allows('delete-post', $this->post)) {
            $this->post->delete();
            $this->emit('postDeleted');
        }
    }

    public function render()
    {
        // Passer l'information sur la colonne parent_id à la vue
        $hasParentIdColumn = Schema::hasColumn('message_comments', 'parent_id');
        
        return view('livewire.nouvelle-messagerie.post-card', [
            'hasParentIdColumn' => $hasParentIdColumn
        ]);
    }
} 