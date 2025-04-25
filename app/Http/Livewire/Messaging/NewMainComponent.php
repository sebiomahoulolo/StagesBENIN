<?php

namespace App\Http\Livewire\Messaging;

use App\Models\Conversation;
use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class NewMainComponent extends Component
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
     * Seulement disponible pour admin et entreprises
     *
     * @return void
     */
    public function toggleCreateConversation()
    {
        // Vérifier si l'utilisateur a les droits de créer une conversation
        if (Auth::user()->isAdmin() || Auth::user()->isRecruteur()) {
            $this->showCreateConversation = !$this->showCreateConversation;
            if ($this->showCreateConversation) {
                $this->selectedConversationId = null;
            }
        } else {
            // Pour les étudiants, afficher un message
            session()->flash('error', 'Vous n\'avez pas les droits pour créer une nouvelle conversation.');
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

    /**
     * Vérifie si l'utilisateur est un étudiant
     *
     * @return bool
     */
    public function isStudent()
    {
        return Auth::user()->isEtudiant();
    }

    /**
     * Vérifie si l'utilisateur est un admin ou une entreprise
     *
     * @return bool
     */
    public function isAdminOrEnterprise()
    {
        return Auth::user()->isAdmin() || Auth::user()->isRecruteur();
    }

    public function render()
    {
        return view('livewire.messaging.new-main-component');
    }
} 