<?php

namespace App\Http\Livewire\Messaging;

use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class ConversationMessages extends Component
{
    public $conversationId = null;
    public $messages = [];
    public $conversation = null;
    
    protected $listeners = [
        'conversationSelected' => 'setConversation',
        'selectedConversation' => 'setConversation',
        'messageSent' => 'loadMessages',
        'refresh' => '$refresh',
        'echo:new-message,MessageSent' => 'handleNewMessage'
    ];

    public function mount($conversationId = null)
    {
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
            ->with('user')
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
                    
                // Rafraîchir le compteur dans le menu
                $this->emit('refreshUnreadCount');
                // Rafraîchir la liste des conversations pour mettre à jour l'indicateur non lu
                $this->emit('refreshConversations');
            }
        }
    }
    
    /**
     * Gère l'arrivée d'un nouveau message via le broadcast
     */
    public function handleNewMessage($event)
    {
        $messageData = $event['message'];
        
        // Vérifier si le message appartient à la conversation actuelle
        if ($messageData['conversation_id'] == $this->conversationId) {
            $this->loadMessages();
            $this->markAsRead();
        } else {
            // Notifier qu'un nouveau message est arrivé dans une autre conversation
            $this->emit('refreshConversations');
        }
    }

    public function render()
    {
        return view('livewire.messaging.conversation-messages');
    }
}
