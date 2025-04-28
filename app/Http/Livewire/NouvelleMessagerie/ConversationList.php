<?php

namespace App\Http\Livewire\NouvelleMessagerie;

use App\Models\Conversation;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class ConversationList extends Component
{
    public $conversations = [];
    public $selectedConversationId = null;
    public $searchTerm = '';
    
    protected $listeners = [
        'refreshConversationList' => 'loadConversations',
        'conversationChanged' => 'setSelectedConversation'
    ];
    
    public function mount()
    {
        $this->loadConversations();
    }
    
    public function loadConversations()
    {
        $query = Auth::user()->conversations()
            ->with(['participants' => function($query) {
                $query->where('user_id', '!=', Auth::id());
            }, 'lastMessage'])
            ->orderBy('updated_at', 'desc');
        
        // Filtrer si terme de recherche présent
        if (!empty($this->searchTerm)) {
            $searchTerm = '%' . $this->searchTerm . '%';
            
            $query->where(function($q) use ($searchTerm) {
                // Recherche par nom de conversation
                $q->where('name', 'like', $searchTerm)
                  // Ou par nom de participant
                  ->orWhereHas('participants', function($query) use ($searchTerm) {
                      $query->where('name', 'like', $searchTerm);
                  });
            });
        }
        
        $this->conversations = $query->get();
    }
    
    public function updatedSearchTerm()
    {
        $this->loadConversations();
    }
    
    public function selectConversation($conversationId)
    {
        $this->selectedConversationId = $conversationId;
        $this->emit('conversationSelected', $conversationId);
    }
    
    public function setSelectedConversation($conversationId)
    {
        $this->selectedConversationId = $conversationId;
    }
    
    public function getUnreadCount($conversationId)
    {
        $conversation = Conversation::find($conversationId);
        if (!$conversation) return 0;
        
        return $conversation->unreadMessagesCount(Auth::id());
    }
    
    public function getConversationName($conversation)
    {
        if ($conversation->is_group && $conversation->name) {
            return $conversation->name;
        }
        
        $otherParticipants = $conversation->participants->where('id', '!=', Auth::id());
        
        if ($otherParticipants->isEmpty()) {
            return 'Aucun participant';
        } elseif ($otherParticipants->count() == 1) {
            return $otherParticipants->first()->name;
        } else {
            $names = $otherParticipants->take(2)->pluck('name')->join(', ');
            $remaining = $otherParticipants->count() - 2;
            return $names . ($remaining > 0 ? " et {$remaining} autres" : '');
        }
    }
    
    public function render()
    {
        return view('livewire.nouvelle-messagerie.conversation-list');
    }
} 