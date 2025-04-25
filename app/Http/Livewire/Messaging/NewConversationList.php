<?php

namespace App\Http\Livewire\Messaging;

use App\Models\Conversation;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class NewConversationList extends Component
{
    public $conversations = [];
    public $selectedConversationId = null;
    public $searchQuery = '';

    protected $listeners = [
        'conversationCreated' => 'refreshList',
        'messageReceived' => 'refreshList',
        'refresh' => 'refreshList'
    ];

    public function mount()
    {
        $this->loadConversations();
    }

    /**
     * Charge la liste des conversations de l'utilisateur
     */
    public function loadConversations()
    {
        $this->conversations = Auth::user()->conversations()
            ->with(['participants' => function($query) {
                $query->where('user_id', '!=', Auth::id());
            }, 'lastMessage'])
            ->when($this->searchQuery, function($query) {
                $query->whereHas('participants', function($q) {
                    $q->where('name', 'like', '%' . $this->searchQuery . '%');
                })->orWhere('name', 'like', '%' . $this->searchQuery . '%');
            })
            ->get();
    }

    /**
     * Rafraîchit la liste des conversations
     */
    public function refreshList()
    {
        $this->loadConversations();
    }

    /**
     * Sélectionne une conversation
     *
     * @param int $conversationId
     */
    public function selectConversation($conversationId)
    {
        $this->selectedConversationId = $conversationId;
        $this->emitUp('conversationSelected', $conversationId);

        // Marquer les messages comme lus
        $conversation = Conversation::find($conversationId);
        if ($conversation) {
            $conversation->messages()
                ->where('user_id', '!=', Auth::id())
                ->where('is_read', false)
                ->update(['is_read' => true]);

            // Mettre à jour la dernière lecture
            $conversation->participants()
                ->updateExistingPivot(Auth::id(), ['last_read' => now()]);
        }
    }

    /**
     * Met à jour la requête de recherche
     */
    public function updatedSearchQuery()
    {
        $this->loadConversations();
    }

    /**
     * Vérifie si l'utilisateur est un étudiant
     */
    public function isStudent()
    {
        return Auth::user()->isEtudiant();
    }

    public function render()
    {
        return view('livewire.messaging.new-conversation-list');
    }
} 