<?php

namespace App\Http\Livewire\NouvelleMessagerie;

use App\Models\Conversation;
use App\Models\Message;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class ConversationMessages extends Component
{
    public $conversationId = null;
    public $messages = [];
    public $conversation = null;
    public $userRole = '';
    
    protected $listeners = [
        'conversationSelected' => 'setConversation',
        'conversationChanged' => 'setConversation',
        'messageSent' => 'loadMessages',
        'echo-private:conversation.{conversationId},MessageSent' => 'handleNewMessage'
    ];

    public function mount($conversationId = null)
    {
        $this->userRole = Auth::user()->role;
        
        if ($conversationId) {
            $this->setConversation($conversationId);
        }
    }

    public function setConversation($conversationId)
    {
        if ($this->conversationId != $conversationId) {
            $this->conversationId = $conversationId;
            $this->loadMessages();
            $this->markAsRead();
            
            $this->dispatchBrowserEvent('conversationChanged', ['id' => $conversationId]);
        }
    }

    public function loadMessages()
    {
        if (!$this->conversationId) {
            return;
        }

        $this->conversation = Conversation::with(['participants'])
            ->findOrFail($this->conversationId);
            
        $this->messages = Message::where('conversation_id', $this->conversationId)
            ->with('user', 'attachments')
            ->orderBy('created_at', 'asc')
            ->get();
            
        $this->dispatchBrowserEvent('messagesLoaded');
    }

    public function markAsRead()
    {
        if (!$this->conversationId) {
            return;
        }

        // Marquer les messages comme lus
        $conversation = Conversation::find($this->conversationId);
        if ($conversation) {
            $participant = $conversation->participants()
                ->where('user_id', Auth::id())
                ->first();
                
            if ($participant) {
                $conversation->participants()
                    ->updateExistingPivot(Auth::id(), ['last_read' => now()]);
                    
                // Rafraîchir le compteur et la liste des conversations
                $this->emit('refreshConversationList');
            }
        }
    }
    
    /**
     * Gère l'arrivée d'un nouveau message via WebSocket
     */
    public function handleNewMessage($event)
    {
        $messageData = $event['message'];
        
        // Vérifier si le message appartient à la conversation actuelle
        if ($messageData['conversation_id'] == $this->conversationId) {
            // Recharger les messages pour être sûr d'avoir les derniers
            $this->loadMessages();
            
            // Marquer comme lu si c'est la conversation active
            $this->markAsRead();
            
            // Déclencher l'événement pour le scroll automatique
            $this->dispatchBrowserEvent('newMessageReceived');
        } else {
            // Notifier qu'un nouveau message est arrivé dans une autre conversation
            $this->emit('refreshConversationList');
        }
    }
    
    /**
     * Vérifier si l'utilisateur peut effectuer des actions sur un message
     */
    public function canPerformActions()
    {
        return Auth::user()->isAdmin() || Auth::user()->isRecruteur();
    }
    
    /**
     * Ouvrir la modal de partage pour un message
     */
    public function shareMessage($messageId)
    {
        $this->dispatchBrowserEvent('openShareModal', ['messageId' => $messageId]);
    }
    
    /**
     * Ouvrir la modal de commentaire pour un message
     */
    public function commentMessage($messageId)
    {
        $this->dispatchBrowserEvent('openCommentModal', ['messageId' => $messageId]);
    }

    public function render()
    {
        return view('livewire.nouvelle-messagerie.conversation-messages');
    }
} 