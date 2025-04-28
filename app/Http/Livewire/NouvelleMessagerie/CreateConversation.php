<?php

namespace App\Http\Livewire\NouvelleMessagerie;

use App\Models\Conversation;
use App\Models\Message;
use App\Events\MessageSent;
use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class CreateConversation extends Component
{
    public $recipients = [];
    public $message = '';
    public $name = '';
    public $selectedRecipients = [];
    public $searchTerm = '';
    public $canCreateConversation = true;
    
    protected $rules = [
        'selectedRecipients' => 'required|array|min:1',
        'message' => 'required|string',
        'name' => 'nullable|string|max:255',
    ];
    
    public function mount()
    {
        $this->loadPotentialRecipients();
        $this->canCreateConversation = $this->checkCanCreateConversation();
    }
    
    public function loadPotentialRecipients()
    {
        $user = Auth::user();
        
        if ($user->isEtudiant()) {
            // Les étudiants peuvent contacter d'autres étudiants et les recruteurs
            $this->recipients = User::where('id', '!=', $user->id)
                ->where(function($query) {
                    $query->where('role', User::ROLE_ETUDIANT)
                        ->orWhere('role', User::ROLE_RECRUTEUR);
                });
        } elseif ($user->isRecruteur()) {
            // Les recruteurs peuvent contacter les étudiants
            $this->recipients = User::where('id', '!=', $user->id)
                ->where('role', User::ROLE_ETUDIANT);
        } else {
            // Admin peut contacter tout le monde
            $this->recipients = User::where('id', '!=', $user->id);
        }
        
        // Appliquer le filtre de recherche si présent
        if (!empty($this->searchTerm)) {
            $this->recipients = $this->recipients->where(function($query) {
                $query->where('name', 'like', '%' . $this->searchTerm . '%')
                    ->orWhere('email', 'like', '%' . $this->searchTerm . '%');
            });
        }
        
        $this->recipients = $this->recipients->get();
    }
    
    public function updatedSearchTerm()
    {
        $this->loadPotentialRecipients();
    }
    
    public function toggleRecipient($recipientId)
    {
        $key = array_search($recipientId, $this->selectedRecipients);
        if ($key !== false) {
            unset($this->selectedRecipients[$key]);
            $this->selectedRecipients = array_values($this->selectedRecipients);
        } else {
            $this->selectedRecipients[] = $recipientId;
        }
    }
    
    public function isSelected($recipientId)
    {
        return in_array($recipientId, $this->selectedRecipients);
    }
    
    public function createConversation()
    {
        if (!$this->canCreateConversation) {
            session()->flash('error', 'Vous n\'êtes pas autorisé à créer une nouvelle conversation.');
            return;
        }
        
        $this->validate();
        
        $isGroup = count($this->selectedRecipients) > 1;
        $name = $isGroup ? $this->name : null;
        
        // Vérifier si une conversation existe déjà (pour les 1 à 1)
        if (!$isGroup && count($this->selectedRecipients) == 1) {
            $existingConversation = $this->findExistingConversation(Auth::id(), $this->selectedRecipients[0]);
            
            if ($existingConversation) {
                // Ajouter le message à la conversation existante
                $message = $existingConversation->messages()->create([
                    'user_id' => Auth::id(),
                    'body' => $this->message,
                    'type' => 'text',
                ]);
                
                // Diffuser le message
                event(new MessageSent($message));
                
                // Réinitialiser et sélectionner la conversation
                $this->resetForm();
                $this->emit('conversationCreated', $existingConversation->id);
                return;
            }
        }
        
        // Créer une nouvelle conversation
        $conversation = Conversation::create([
            'name' => $name,
            'is_group' => $isGroup,
        ]);
        
        // Ajouter les participants
        $conversation->participants()->attach(Auth::id(), ['last_read' => now()]);
        foreach ($this->selectedRecipients as $recipientId) {
            $conversation->participants()->attach($recipientId);
        }
        
        // Ajouter le premier message
        $message = $conversation->messages()->create([
            'user_id' => Auth::id(),
            'body' => $this->message,
            'type' => 'text',
        ]);
        
        // Diffuser le message
        event(new MessageSent($message));
        
        // Réinitialiser et sélectionner la conversation
        $this->resetForm();
        $this->emit('conversationCreated', $conversation->id);
    }
    
    public function resetForm()
    {
        $this->selectedRecipients = [];
        $this->message = '';
        $this->name = '';
        $this->searchTerm = '';
        $this->loadPotentialRecipients();
    }
    
    public function cancel()
    {
        $this->resetForm();
        $this->emit('closeCreateConversation');
    }
    
    /**
     * Vérifier si l'utilisateur peut créer une conversation
     */
    private function checkCanCreateConversation()
    {
        $user = Auth::user();
        
        // Les admin et recruteurs peuvent toujours créer une conversation
        if ($user->isAdmin() || $user->isRecruteur()) {
            return true;
        }
        
        // Pour les étudiants, on peut ajouter une logique de restriction
        if ($user->isEtudiant()) {
            // Par exemple, vérifier une limite quotidienne
            // Pour l'instant, on autorise
            return true;
        }
        
        return false;
    }
    
    /**
     * Trouver une conversation existante entre deux utilisateurs
     */
    private function findExistingConversation($userId1, $userId2)
    {
        $user1Conversations = Conversation::whereHas('participants', function ($query) use ($userId1) {
            $query->where('user_id', $userId1);
        })->where('is_group', false)->get();

        foreach ($user1Conversations as $conversation) {
            if ($conversation->participants()->where('user_id', $userId2)->exists() && 
                $conversation->participants()->count() == 2) {
                return $conversation;
            }
        }

        return null;
    }
    
    public function render()
    {
        return view('livewire.nouvelle-messagerie.create-conversation');
    }
} 