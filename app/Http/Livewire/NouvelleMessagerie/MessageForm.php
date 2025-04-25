<?php

namespace App\Http\Livewire\NouvelleMessagerie;

use App\Models\Conversation;
use App\Models\Message;
use App\Models\MessageAttachment;
use App\Events\MessageSent;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MessageForm extends Component
{
    use WithFileUploads;
    
    public $conversationId;
    public $messageText = '';
    public $attachments = [];
    public $uploading = false;
    public $userRole = '';
    
    protected $listeners = [
        'conversationSelected' => 'setConversation',
        'conversationChanged' => 'setConversation',
        'resetForm' => 'resetForm'
    ];
    
    protected $rules = [
        'messageText' => 'required_without:attachments|nullable|string',
        'attachments.*' => 'nullable|file|max:10240', // 10MB max
    ];
    
    public function mount($conversationId = null)
    {
        $this->userRole = Auth::user()->role;
        $this->setConversation($conversationId);
    }
    
    public function setConversation($conversationId)
    {
        $this->conversationId = $conversationId;
        $this->resetForm();
    }
    
    public function resetForm()
    {
        $this->messageText = '';
        $this->attachments = [];
        $this->uploading = false;
    }
    
    public function removeAttachment($index)
    {
        if (isset($this->attachments[$index])) {
            unset($this->attachments[$index]);
            $this->attachments = array_values($this->attachments);
        }
    }
    
    public function sendMessage()
    {
        if (!$this->conversationId) {
            session()->flash('error', 'Aucune conversation sélectionnée.');
            return;
        }
        
        // Vérifier si l'utilisateur est un étudiant et s'il peut envoyer des messages
        if (Auth::user()->isEtudiant() && !$this->canStudentSendMessage()) {
            session()->flash('error', 'Vous ne pouvez pas envoyer de message dans cette conversation.');
            return;
        }
        
        $this->validate();
        
        $conversation = Conversation::find($this->conversationId);
        if (!$conversation) {
            session()->flash('error', 'Conversation introuvable.');
            return;
        }
        
        // Vérifier si l'utilisateur est participant
        if (!$conversation->isParticipant(Auth::id())) {
            session()->flash('error', 'Vous n\'êtes pas autorisé à envoyer des messages dans cette conversation.');
            return;
        }
        
        $this->uploading = true;
        
        // Créer le message
        $message = $conversation->messages()->create([
            'user_id' => Auth::id(),
            'body' => $this->messageText,
            'type' => 'text',
        ]);
        
        // Traiter les pièces jointes
        if (count($this->attachments) > 0) {
            foreach ($this->attachments as $attachment) {
                $path = $attachment->store('message_attachments/' . $conversation->id, 'public');
                
                $messageAttachment = new MessageAttachment([
                    'message_id' => $message->id,
                    'file_path' => $path,
                    'file_name' => $attachment->getClientOriginalName(),
                    'file_type' => $attachment->getMimeType(),
                    'file_size' => $attachment->getSize(),
                ]);
                
                $messageAttachment->save();
            }
            
            // Mise à jour du type de message si nécessaire
            if (empty($this->messageText) && count($this->attachments) == 1) {
                $message->update([
                    'type' => $this->determineMessageType($this->attachments[0])
                ]);
            }
        }
        
        // Mettre à jour l'horodatage de la conversation
        $conversation->touch();
        
        // Mettre à jour la dernière lecture pour l'expéditeur
        $conversation->participants()
            ->updateExistingPivot(Auth::id(), ['last_read' => now()]);
        
        // Diffuser le message en temps réel
        event(new MessageSent($message->load('user', 'attachments')));
        
        // Émettre l'événement pour recharger les messages et réinitialiser le formulaire
        $this->emit('messageSent');
        $this->resetForm();
        $this->uploading = false;
    }
    
    /**
     * Vérifier si un étudiant peut envoyer un message
     */
    private function canStudentSendMessage()
    {
        // Par défaut, les étudiants peuvent toujours envoyer des messages
        return true;
    }
    
    /**
     * Déterminer le type de message en fonction du fichier
     */
    private function determineMessageType($file)
    {
        $mimeType = $file->getMimeType();
        
        if (Str::startsWith($mimeType, 'image/')) {
            return 'image';
        } elseif (Str::startsWith($mimeType, 'video/')) {
            return 'video';
        } elseif (Str::startsWith($mimeType, 'audio/')) {
            return 'audio';
        } else {
            return 'file';
        }
    }
    
    public function render()
    {
        return view('livewire.nouvelle-messagerie.message-form');
    }
} 