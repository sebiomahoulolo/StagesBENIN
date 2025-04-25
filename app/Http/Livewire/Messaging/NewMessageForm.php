<?php

namespace App\Http\Livewire\Messaging;

use App\Models\Conversation;
use App\Models\Message;
use App\Models\MessageAttachment;
use App\Events\MessageSent;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class NewMessageForm extends Component
{
    use WithFileUploads;

    public $conversationId;
    public $message = '';
    public $attachments = [];
    public $conversation;
    
    protected $rules = [
        'message' => 'required_without:attachments|nullable|string',
        'attachments.*' => 'nullable|file|max:10240', // 10MB max
    ];

    public function mount($conversationId)
    {
        $this->conversationId = $conversationId;
        $this->loadConversation();
    }

    /**
     * Charge la conversation
     */
    private function loadConversation()
    {
        $this->conversation = Conversation::findOrFail($this->conversationId);
        
        // Vérifier si l'utilisateur est un participant
        if (!$this->conversation->isParticipant(Auth::id())) {
            $this->redirect(route('messaging.new.index'));
            return;
        }
    }

    /**
     * Envoie un message
     */
    public function sendMessage()
    {
        // Vérifier si l'utilisateur est un participant
        if (!$this->conversation->isParticipant(Auth::id())) {
            session()->flash('error', 'Vous n\'êtes pas autorisé à envoyer des messages dans cette conversation.');
            return;
        }

        $this->validate();

        // Créer le message
        $newMessage = $this->conversation->messages()->create([
            'user_id' => Auth::id(),
            'body' => $this->message,
            'type' => $this->determineMessageType(),
        ]);

        // Traiter les pièces jointes si elles existent
        if (count($this->attachments) > 0) {
            foreach ($this->attachments as $file) {
                $path = $file->store('message_attachments/' . $this->conversationId, 'public');
                
                $attachment = new MessageAttachment([
                    'file_path' => $path,
                    'file_name' => $file->getClientOriginalName(),
                    'file_type' => $file->getMimeType(),
                    'file_size' => $file->getSize(),
                ]);
                
                $newMessage->attachments()->save($attachment);
            }
        }

        // Mettre à jour l'horodatage de la conversation
        $this->conversation->touch();
        
        // Mettre à jour la dernière lecture pour l'expéditeur
        $this->conversation->participants()
            ->updateExistingPivot(Auth::id(), ['last_read' => now()]);

        // Émettre un événement pour le temps réel
        event(new MessageSent($newMessage->load('user', 'attachments')));

        // Réinitialiser le formulaire
        $this->reset(['message', 'attachments']);
        
        // Émettre un événement pour informer que le message a été envoyé
        $this->emit('messageSent');
    }

    /**
     * Détermine le type de message en fonction des pièces jointes
     */
    private function determineMessageType()
    {
        if (count($this->attachments) === 0) {
            return 'text';
        }

        $file = $this->attachments[0];
        $mimeType = $file->getMimeType();

        if (strpos($mimeType, 'image/') === 0) {
            return 'image';
        } elseif (strpos($mimeType, 'video/') === 0) {
            return 'video';
        } elseif (strpos($mimeType, 'audio/') === 0) {
            return 'audio';
        } else {
            return 'file';
        }
    }

    /**
     * Supprime une pièce jointe du tableau avant l'envoi
     */
    public function removeAttachment($index)
    {
        unset($this->attachments[$index]);
        $this->attachments = array_values($this->attachments);
    }

    /**
     * Vérifie si l'utilisateur est un étudiant
     */
    public function isStudent()
    {
        return Auth::user()->isEtudiant();
    }

    /**
     * Vérifie si l'utilisateur est un admin ou une entreprise
     */
    public function isAdminOrEnterprise()
    {
        return Auth::user()->isAdmin() || Auth::user()->isRecruteur();
    }

    public function render()
    {
        return view('livewire.messaging.new-message-form');
    }
} 