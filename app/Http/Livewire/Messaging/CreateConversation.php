<?php

namespace App\Http\Livewire\Messaging;

use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class CreateConversation extends Component
{
    public $selectedUsers = [];
    public $groupName = '';
    public $firstMessage = '';
    public $showGroupNameField = false;
    public $users = [];

    protected $rules = [
        'selectedUsers' => 'required|array|min:1',
        'groupName' => 'required_if:showGroupNameField,true',
        'firstMessage' => 'required|string|min:1|max:500',
    ];

    protected $messages = [
        'selectedUsers.required' => 'Veuillez sélectionner au moins un participant',
        'selectedUsers.min' => 'Veuillez sélectionner au moins un participant',
        'groupName.required_if' => 'Un nom de groupe est requis pour les conversations de groupe',
        'firstMessage.required' => 'Veuillez saisir un message',
        'firstMessage.max' => 'Le message ne peut pas dépasser 500 caractères',
    ];

    public function mount()
    {
        $this->loadUsers();
    }

    public function loadUsers()
    {
        // Charger les utilisateurs disponibles pour créer une conversation
        // Exclure l'utilisateur courant
        $this->users = User::where('id', '!=', Auth::id())->get();
    }

    public function updatedSelectedUsers()
    {
        // Si plus de 2 participants (incluant l'utilisateur courant), c'est un groupe
        $this->showGroupNameField = count($this->selectedUsers) > 1;
    }

    public function createConversation()
    {
        $this->validate();

        // Créer une nouvelle conversation
        $conversation = new Conversation();
        
        // Si c'est un groupe, définir le nom
        if ($this->showGroupNameField) {
            $conversation->name = $this->groupName;
        }
        
        $conversation->save();

        // Ajouter tous les participants, y compris l'utilisateur courant
        $participantIds = array_merge($this->selectedUsers, [Auth::id()]);
        
        foreach ($participantIds as $userId) {
            $conversation->participants()->attach($userId, [
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

        // Ajouter le premier message
        $message = new Message([
            'user_id' => Auth::id(),
            'body' => $this->firstMessage,
            'conversation_id' => $conversation->id
        ]);
        
        $message->save();
        
        // Mettre à jour l'horodatage de la conversation
        $conversation->touch();

        // Réinitialiser le formulaire
        $this->reset(['selectedUsers', 'groupName', 'firstMessage', 'showGroupNameField']);
        
        // Émettre un événement pour informer le composant parent
        $this->emit('conversationCreated', $conversation->id);
        $this->emit('refreshConversations');
    }

    public function render()
    {
        return view('livewire.messaging.create-conversation');
    }
} 