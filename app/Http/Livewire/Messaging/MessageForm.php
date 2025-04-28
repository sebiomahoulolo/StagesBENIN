<?php

namespace App\Http\Livewire\Messaging;

use App\Events\MessageSent;
use App\Models\Conversation;
use App\Models\Message;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MessageForm extends Component
{
    use WithFileUploads;

    public $conversationId = null;
    public $message = '';
    public $attachments = [];
    public $isSending = false;

    protected $listeners = [
        'conversationSelected' => 'setConversation',
        'refresh' => '$refresh'
    ];

    protected $rules = [
        'message' => 'required_without:attachments|nullable|string',
        'attachments.*' => 'sometimes|file|max:10240', // 10MB max
    ];

    public function mount($conversationId = null)
    {
        if ($conversationId) {
            $this->setConversation($conversationId);
        }
    }

    public function setConversation($conversationId)
    {
        $this->conversationId = $conversationId;
        $this->resetForm();
    }

    public function sendMessage()
    {
        if (!$this->conversationId) {
            return;
        }

        // Marquer comme en cours d'envoi
        $this->isSending = true;
        
        // Vérifier si le message ou les pièces jointes sont vides
        if (empty($this->message) && empty($this->attachments)) {
            $this->isSending = false;
            return;
        }

        // Vérifier si l'utilisateur est un participant de la conversation
        $conversation = Conversation::findOrFail($this->conversationId);
        if (!$conversation->participants()->where('user_id', Auth::id())->exists()) {
            session()->flash('error', 'Vous n\'êtes pas autorisé à envoyer des messages dans cette conversation.');
            $this->isSending = false;
            return;
        }

        $this->validate();

        try {
            // Créer le message
            $newMessage = $conversation->messages()->create([
                'user_id' => Auth::id(),
                'body' => $this->message ?: '',
                'type' => 'text',
            ]);

            // Gérer les pièces jointes si présentes
            if (!empty($this->attachments)) {
                foreach ($this->attachments as $attachment) {
                    $path = $attachment->store('message-attachments', 'public');
                    $newMessage->attachments()->create([
                        'path' => $path,
                        'name' => $attachment->getClientOriginalName(),
                        'type' => $attachment->getClientMimeType(),
                        'size' => $attachment->getSize(),
                    ]);
                }
            }

            // Mettre à jour l'horodatage de la conversation
            $conversation->touch();
            
            // Mettre à jour la dernière lecture pour l'expéditeur
            $conversation->participants()
                ->updateExistingPivot(Auth::id(), ['last_read' => now()]);

            // Diffuser l'événement en temps réel
            $messageWithRelations = $newMessage->load('user', 'attachments');
            event(new MessageSent($messageWithRelations));

            // Émettre des événements pour actualiser les interfaces
            $this->emit('messageSent');
            $this->emit('refreshConversations');
            
            // Signal JS pour scroll en bas
            $this->dispatchBrowserEvent('messageSent');

            $this->resetForm();
        } catch (\Exception $e) {
            session()->flash('error', 'Erreur lors de l\'envoi du message: ' . $e->getMessage());
            $this->isSending = false;
        }
    }

    private function resetForm()
    {
        $this->message = '';
        $this->attachments = [];
        $this->isSending = false;
    }

    public function render()
    {
        return view('livewire.messaging.message-form');
    }
}
