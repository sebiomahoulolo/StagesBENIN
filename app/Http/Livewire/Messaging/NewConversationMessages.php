<?php

namespace App\Http\Livewire\Messaging;

use App\Models\Conversation;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class NewConversationMessages extends Component
{
    public $conversationId;
    public $messages = [];
    public $conversation;
    public $participants = [];
    public $messageCount = 0;
    
    protected $listeners = [
        'messageSent' => 'loadMessages',
        'echo:new-message,MessageSent' => 'handleBroadcastedMessage',
        'loadMore' => 'loadMoreMessages'
    ];

    public function getListeners()
    {
        return [
            'messageSent' => 'loadMessages',
            'echo:new-message,MessageSent' => 'handleBroadcastedMessage',
            'loadMore' => 'loadMoreMessages'
        ];
    }

    public function mount($conversationId)
    {
        $this->conversationId = $conversationId;
        $this->loadConversation();
        $this->loadMessages();
    }

    /**
     * Charge la conversation
     */
    public function loadConversation()
    {
        $this->conversation = Conversation::findOrFail($this->conversationId);
        
        // Vérifier si l'utilisateur est un participant
        if (!$this->conversation->isParticipant(Auth::id())) {
            $this->redirect(route('messaging.new.index'));
            return;
        }

        $this->participants = $this->conversation->participants()
            ->where('user_id', '!=', Auth::id())
            ->get();
    }

    /**
     * Charge les messages de la conversation
     */
    public function loadMessages()
    {
        $this->messages = $this->conversation->messages()
            ->with('user', 'attachments')
            ->orderBy('created_at', 'desc')
            ->take(20)
            ->get()
            ->reverse()
            ->values();

        $this->messageCount = $this->conversation->messages()->count();
        
        // Marquer les messages comme lus
        $this->markAsRead();
    }

    /**
     * Charge plus de messages (pour le scroll infini)
     */
    public function loadMoreMessages()
    {
        $this->messages = $this->conversation->messages()
            ->with('user', 'attachments')
            ->orderBy('created_at', 'desc')
            ->take(20 + count($this->messages))
            ->get()
            ->reverse()
            ->values();
    }

    /**
     * Marquer les messages comme lus
     */
    public function markAsRead()
    {
        $this->conversation->messages()
            ->where('user_id', '!=', Auth::id())
            ->where('is_read', false)
            ->update(['is_read' => true]);

        $this->conversation->participants()
            ->updateExistingPivot(Auth::id(), ['last_read' => now()]);
    }

    /**
     * Gère un message diffusé via WebSockets
     */
    public function handleBroadcastedMessage($event)
    {
        $message = Message::with('user', 'attachments')->find($event['message']['id']);
        
        if ($message && $message->conversation_id == $this->conversationId) {
            $this->loadMessages();
            
            // Si le message n'est pas de l'utilisateur actuel, le marquer comme lu
            if ($message->user_id != Auth::id()) {
                $this->markAsRead();
            }
        }
    }

    /**
     * Vérifie si l'utilisateur est un étudiant
     */
    public function isStudent()
    {
        return Auth::user()->isEtudiant();
    }

    /**
     * Vérifie si l'utilisateur est un admin ou une entreprise
     */
    public function isAdminOrEnterprise()
    {
        return Auth::user()->isAdmin() || Auth::user()->isRecruteur();
    }

    public function render()
    {
        return view('livewire.messaging.new-conversation-messages');
    }
}