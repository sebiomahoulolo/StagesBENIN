<?php

namespace App\Http\Livewire\NouvelleMessagerie;

use App\Models\Conversation;
use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class MainComponent extends Component
{
    public $selectedConversationId = null;
    public $showCreateConversation = false;
    
    protected $listeners = [
        'conversationSelected' => 'setSelectedConversation',
        'conversationCreated' => 'handleConversationCreated',
        'closeCreateConversation' => 'hideCreateConversation',
        'echo-private:conversation.{conversationId},MessageSent' => 'notifyNewMessage'
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
     */
    public function setSelectedConversation($conversationId)
    {
        $this->selectedConversationId = $conversationId;
        $this->showCreateConversation = false;
        $this->emit('conversationChanged', $conversationId);
    }

    /**
     * Gère la création d'une nouvelle conversation
     */
    public function handleConversationCreated($conversationId)
    {
        $this->selectedConversationId = $conversationId;
        $this->showCreateConversation = false;
    }

    /**
     * Affiche/cache le formulaire de création de conversation
     */
    public function toggleCreateConversation()
    {
        // Si l'utilisateur est un étudiant, vérifier s'il peut créer une conversation
        if (Auth::user()->isEtudiant() && !$this->canStudentCreateConversation()) {
            session()->flash('error', 'Vous n\'êtes pas autorisé à créer une nouvelle conversation.');
            return;
        }
        
        $this->showCreateConversation = !$this->showCreateConversation;
        if ($this->showCreateConversation) {
            $this->selectedConversationId = null;
        }
    }

    /**
     * Cache le formulaire de création de conversation
     */
    public function hideCreateConversation()
    {
        $this->showCreateConversation = false;
    }
    
    /**
     * Notifie l'arrivée d'un nouveau message via WebSocket
     */
    public function notifyNewMessage($event)
    {
        $this->dispatchBrowserEvent('newMessageReceived', [
            'conversationId' => $event['message']['conversation_id'],
            'messageId' => $event['message']['id']
        ]);
        
        $this->emit('refreshConversationList');
    }
    
    /**
     * Vérifier si un étudiant peut créer des conversations
     */
    private function canStudentCreateConversation()
    {
        // Logique pour restreindre la création (à adapter selon vos besoins)
        return true; // Par défaut, autorisé
    }

    public function render()
    {
        return view('livewire.nouvelle-messagerie.main-component');
    }
} 