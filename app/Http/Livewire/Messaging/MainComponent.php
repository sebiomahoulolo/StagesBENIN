<?php

namespace App\Http\Livewire\Messaging;

use App\Models\Conversation;
use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class MainComponent extends Component
{
    public $selectedConversationId = null;
    public $showCreateConversation = false;
    public $users = [];
    
    protected $listeners = [
        'conversationSelected' => 'setSelectedConversation',
        'conversationCreated' => 'handleConversationCreated',
        'closeCreateConversation' => 'hideCreateConversation'
    ];

    public function mount()
    {
        // Vérifier si l'utilisateur a des conversations existantes
        $conversation = Conversation::whereHas('participants', function($query) {
            $query->where('user_id', Auth::id());
        })->first();
        
        if ($conversation) {
            $this->selectedConversationId = $conversation->id;
        }
    }

    /**
     * Définit la conversation sélectionnée
     *
     * @param int $conversationId
     * @return void
     */
    public function setSelectedConversation($conversationId)
    {
        $this->selectedConversationId = $conversationId;
        $this->showCreateConversation = false;
    }

    /**
     * Gère la création d'une nouvelle conversation
     *
     * @param int $conversationId
     * @return void
     */
    public function handleConversationCreated($conversationId)
    {
        $this->selectedConversationId = $conversationId;
        $this->showCreateConversation = false;
    }

    /**
     * Affiche/cache le formulaire de création de conversation
     *
     * @return void
     */
    public function toggleCreateConversation()
    {
        $this->showCreateConversation = !$this->showCreateConversation;
        if ($this->showCreateConversation) {
            $this->selectedConversationId = null;
        }
    }

    /**
     * Cache le formulaire de création de conversation
     *
     * @return void
     */
    public function hideCreateConversation()
    {
        $this->showCreateConversation = false;
    }

    public function render()
    {
        return view('livewire.messaging.main-component');
    }
}
