<?php

namespace App\Http\Livewire\NouvelleMessagerie;

use Livewire\Component;
use App\Models\MessagePost;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;

class CreatePostForm extends Component
{
    use WithFileUploads;
    
    public $content = '';
    public $attachments = [];
    public $isSubmitting = false;
    
    protected $rules = [
        'content' => 'required|string|max:5000',
        'attachments.*' => 'nullable|file|max:10240', // 10MB max par fichier
    ];

    // Listener pour détecter les erreurs du formulaire
    protected $listeners = ['formSubmitted'];
    
    public function mount()
    {
        if (!Gate::allows('create-post')) {
            session()->flash('error', 'Vous n\'êtes pas autorisé à créer des posts.');
            return redirect()->route('messagerie-sociale.index');
        }
    }
    
    public function formSubmitted()
    {
        session()->flash('submit_error', 'Le formulaire a été soumis mais a rencontré un problème.');
    }
    
    public function submitPost()
    {
        $this->emit('formSubmitted');
        
        if (!Gate::allows('create-post')) {
            session()->flash('error', 'Vous n\'êtes pas autorisé à créer des posts.');
            return;
        }
        
        Log::info('Tentative de soumission du formulaire avec contenu: ' . substr($this->content, 0, 50));

        // Validation avec affichage des erreurs
        $validated = $this->validate();
        
        $this->isSubmitting = true;
        
        try {
            Log::info('Création du post après validation réussie');
            
            // Créer le post
            $post = MessagePost::create([
                'user_id' => Auth::id(),
                'content' => $this->content,
                'is_published' => true,
            ]);
            
            Log::info('Post créé avec ID: ' . $post->id);
            
            // Traiter les pièces jointes
            if (!empty($this->attachments)) {
                Log::info('Traitement de ' . count($this->attachments) . ' pièces jointes');
                
                foreach ($this->attachments as $attachment) {
                    $path = $attachment->store('message_post_attachments', 'public');
                    $post->attachments()->create([
                        'path' => $path,
                        'original_name' => $attachment->getClientOriginalName(),
                        'mime_type' => $attachment->getMimeType(),
                        'size' => $attachment->getSize(),
                    ]);
                }
            }
            
            $this->reset(['content', 'attachments']);
            session()->flash('success', 'Post publié avec succès!');
            $this->emit('postCreated');
            
            Log::info('Redirection vers la vue du post');
            
            // Rediriger vers la vue du post
            return redirect()->route('messagerie-sociale.show-post', $post);
            
        } catch (\Exception $e) {
            Log::error('Erreur lors de la création du post: ' . $e->getMessage());
            session()->flash('error', 'Erreur lors de la création du post: ' . $e->getMessage());
        } finally {
            $this->isSubmitting = false;
        }
    }
    
    public function removeAttachment($index)
    {
        if (isset($this->attachments[$index])) {
            array_splice($this->attachments, $index, 1);
        }
    }
    
    public function render()
    {
        return view('livewire.nouvelle-messagerie.create-post-form');
    }
} 