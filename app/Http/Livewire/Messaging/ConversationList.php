<?php

namespace App\Http\Livewire\Messaging;

use App\Models\Conversation;
use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class ConversationList extends Component
{
    public $conversations = [];
    public $selectedConversationId = null;
    public $searchTerm = '';

    protected $listeners = ['conversationSelected', 'refreshConversations' => 'loadConversations'];

    public function mount()
    {
        $this->loadConversations();
    }

    public function loadConversations()
    {
        $query = Conversation::whereHas('participants', function ($query) {
            $query->where('user_id', Auth::id());
        })
        ->with(['participants', 'lastMessage']);
        
        // Appliquer le filtre de recherche si présent
        if (!empty($this->searchTerm)) {
            $query->where(function($q) {
                // Rechercher dans le nom des groupes
                $q->where('name', 'like', '%' . $this->searchTerm . '%')
                  // Ou dans les noms des participants via une sous-requête
                  ->orWhereHas('participants', function($participantQuery) {
                      $participantQuery->whereIn('user_id', function($userQuery) {
                          $userQuery->select('id')
                              ->from('users')
                              ->where('name', 'like', '%' . $this->searchTerm . '%');
                      });
                  })
                  // Ou dans les messages
                  ->orWhereHas('messages', function($messageQuery) {
                      $messageQuery->where('body', 'like', '%' . $this->searchTerm . '%');
                  });
            });
        }
        
        $this->conversations = $query->orderBy('updated_at', 'desc')->get();
        
        // Si une conversation est déjà sélectionnée, nous la gardons
        if (!$this->selectedConversationId && count($this->conversations) > 0) {
            $this->selectedConversationId = $this->conversations->first()->id;
            $this->emitUp('conversationSelected', $this->selectedConversationId);
        }
    }

    public function selectConversation($conversationId)
    {
        $this->selectedConversationId = $conversationId;
        $this->emitUp('conversationSelected', $conversationId);
        
        // Émettons également un événement direct pour les autres composants
        $this->emit('selectedConversation', $conversationId);
    }

    public function updatedSearchTerm()
    {
        $this->loadConversations();
    }

    public function render()
    {
        return view('livewire.messaging.conversation-list');
    }
}
