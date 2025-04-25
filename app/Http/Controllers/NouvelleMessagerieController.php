<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\Message;
use App\Models\MessageAttachment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Events\MessageSent;

class NouvelleMessagerieController extends Controller
{
    /**
     * Afficher la page principale de messagerie
     */
    public function index()
    {
        return view('nouvelle-messagerie.index');
    }

    /**
     * Afficher une conversation spécifique
     */
    public function show(Conversation $conversation)
    {
        // Vérifier si l'utilisateur fait partie de la conversation
        if (!$conversation->isParticipant(Auth::id())) {
            return redirect()->route('nouvelle-messagerie.index')
                ->with('error', 'Vous n\'avez pas accès à cette conversation.');
        }

        // Marquer les messages comme lus
        $conversation->participants()
            ->updateExistingPivot(Auth::id(), ['last_read' => now()]);

        return view('nouvelle-messagerie.show', compact('conversation'));
    }

    /**
     * Afficher le formulaire de création d'une nouvelle conversation
     */
    public function create()
    {
        $user = Auth::user();
        $potentialContacts = $this->getPotentialContacts($user);
        
        return view('nouvelle-messagerie.create', compact('potentialContacts'));
    }

    /**
     * Stocker une nouvelle conversation
     */
    public function store(Request $request)
    {
        // Validation des données
        $request->validate([
            'recipient_ids' => 'required|array',
            'recipient_ids.*' => 'exists:users,id',
            'message' => 'required|string',
        ]);

        $recipientIds = $request->recipient_ids;
        $isGroup = count($recipientIds) > 1;
        $name = $isGroup ? ($request->name ?? 'Groupe') : null;

        // Vérifier si l'utilisateur est autorisé à créer une conversation
        if (Auth::user()->role === User::ROLE_ETUDIANT && !$this->canStudentCreateConversation()) {
            return redirect()->route('nouvelle-messagerie.index')
                ->with('error', 'Vous n\'êtes pas autorisé à créer une nouvelle conversation.');
        }

        // Vérifier si une conversation existe déjà (pour les discussions 1-à-1)
        if (!$isGroup && count($recipientIds) === 1) {
            $existingConversation = $this->findExistingConversation(Auth::id(), $recipientIds[0]);
            
            if ($existingConversation) {
                // Ajouter le message à la conversation existante
                $message = $existingConversation->messages()->create([
                    'user_id' => Auth::id(),
                    'body' => $request->message,
                    'type' => 'text',
                ]);

                // Diffuser le message en temps réel
                event(new MessageSent($message));

                return redirect()->route('nouvelle-messagerie.show', $existingConversation->id);
            }
        }

        // Créer une nouvelle conversation
        $conversation = Conversation::create([
            'name' => $name,
            'is_group' => $isGroup,
        ]);

        // Ajouter tous les participants
        $conversation->participants()->attach(Auth::id(), ['last_read' => now()]);
        foreach ($recipientIds as $id) {
            $conversation->participants()->attach($id);
        }

        // Ajouter le premier message
        $message = $conversation->messages()->create([
            'user_id' => Auth::id(),
            'body' => $request->message,
            'type' => 'text',
        ]);

        // Diffuser le message en temps réel
        event(new MessageSent($message));

        return redirect()->route('nouvelle-messagerie.show', $conversation->id);
    }

    /**
     * Envoyer un message dans une conversation
     */
    public function sendMessage(Request $request, Conversation $conversation)
    {
        // Vérifier si l'utilisateur fait partie de la conversation
        if (!$conversation->isParticipant(Auth::id())) {
            return response()->json(['error' => 'Non autorisé'], 403);
        }

        // Validation
        $validatedData = $request->validate([
            'message' => 'required_without:attachments|nullable|string',
            'attachments' => 'nullable|array',
            'attachments.*' => 'file|max:10240', // 10MB max
        ]);

        // Créer le message
        $message = $conversation->messages()->create([
            'user_id' => Auth::id(),
            'body' => $request->message ?? null,
            'type' => $request->attachments ? 
                $this->determineMessageType($request->file('attachments')[0]) : 'text',
        ]);

        // Traiter les pièces jointes
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $path = $file->store('message_attachments/' . $conversation->id, 'public');
                
                $attachment = new MessageAttachment([
                    'file_path' => $path,
                    'file_name' => $file->getClientOriginalName(),
                    'file_type' => $file->getMimeType(),
                    'file_size' => $file->getSize(),
                ]);
                
                $message->attachments()->save($attachment);
            }
        }

        // Mettre à jour l'horodatage de la conversation
        $conversation->touch();
        
        // Mettre à jour la dernière lecture pour l'expéditeur
        $conversation->participants()
            ->updateExistingPivot(Auth::id(), ['last_read' => now()]);

        // Diffuser le message
        event(new MessageSent($message->load('user', 'attachments')));

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => $message->load('user', 'attachments')
            ]);
        }

        return redirect()->route('nouvelle-messagerie.show', $conversation->id);
    }

    /**
     * Partager un message
     */
    public function shareMessage(Request $request, Message $message)
    {
        // Vérifier si l'utilisateur a accès au message
        if (!$message->conversation->isParticipant(Auth::id())) {
            return response()->json(['error' => 'Non autorisé'], 403);
        }

        // Validation
        $request->validate([
            'recipient_ids' => 'required|array',
            'recipient_ids.*' => 'exists:users,id',
        ]);

        $recipientIds = $request->recipient_ids;
        $success = 0;

        // Partager avec chaque destinataire
        foreach ($recipientIds as $recipientId) {
            // Trouver ou créer une conversation avec ce destinataire
            $conversation = $this->findOrCreateConversation(Auth::id(), $recipientId);
            
            // Partager le message
            $newMessage = $conversation->messages()->create([
                'user_id' => Auth::id(),
                'body' => "Message partagé : \n\n" . $message->body,
                'type' => 'text',
            ]);
            
            // Partager les pièces jointes si nécessaire
            foreach ($message->attachments as $attachment) {
                $newAttachment = new MessageAttachment([
                    'file_path' => $attachment->file_path,
                    'file_name' => $attachment->file_name,
                    'file_type' => $attachment->file_type,
                    'file_size' => $attachment->file_size,
                ]);
                
                $newMessage->attachments()->save($newAttachment);
            }
            
            // Diffuser le message
            event(new MessageSent($newMessage->load('user', 'attachments')));
            $success++;
        }

        return response()->json([
            'success' => true,
            'message' => "Message partagé avec $success destinataire(s)."
        ]);
    }

    /**
     * Commenter un message
     */
    public function commentMessage(Request $request, Message $message)
    {
        // Vérifier si l'utilisateur a accès au message
        if (!$message->conversation->isParticipant(Auth::id())) {
            return response()->json(['error' => 'Non autorisé'], 403);
        }

        // Validation
        $request->validate([
            'comment' => 'required|string',
        ]);

        // Créer le commentaire comme un nouveau message
        $comment = $message->conversation->messages()->create([
            'user_id' => Auth::id(),
            'body' => "Commentaire sur: \"" . Str::limit($message->body, 50) . "\"\n\n" . $request->comment,
            'type' => 'comment',
            'parent_id' => $message->id, // Référence au message original
        ]);

        // Mettre à jour l'horodatage de la conversation
        $message->conversation->touch();
        
        // Mettre à jour la dernière lecture pour l'expéditeur
        $message->conversation->participants()
            ->updateExistingPivot(Auth::id(), ['last_read' => now()]);

        // Diffuser le commentaire
        event(new MessageSent($comment->load('user')));

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'comment' => $comment->load('user')
            ]);
        }

        return redirect()->route('nouvelle-messagerie.show', $message->conversation->id);
    }

    /**
     * Obtenir les contacts potentiels selon le rôle
     */
    private function getPotentialContacts(User $user)
    {
        if ($user->isEtudiant()) {
            // Les étudiants peuvent contacter d'autres étudiants et les recruteurs
            return User::where('id', '!=', $user->id)
                ->where(function($query) {
                    $query->where('role', User::ROLE_ETUDIANT)
                        ->orWhere('role', User::ROLE_RECRUTEUR);
                })
                ->get();
        } elseif ($user->isRecruteur()) {
            // Les recruteurs peuvent contacter les étudiants
            return User::where('id', '!=', $user->id)
                ->where('role', User::ROLE_ETUDIANT)
                ->get();
        } else {
            // Admin peut contacter tout le monde
            return User::where('id', '!=', $user->id)->get();
        }
    }

    /**
     * Vérifier si un étudiant peut créer des conversations
     */
    private function canStudentCreateConversation()
    {
        // Ici vous pouvez implémenter votre logique pour restreindre la création
        // Par exemple, limite quotidienne, autorisation spéciale, etc.
        return true; // Par défaut, autorisé
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

    /**
     * Trouver ou créer une conversation entre deux utilisateurs
     */
    private function findOrCreateConversation($userId1, $userId2)
    {
        $existingConversation = $this->findExistingConversation($userId1, $userId2);
        
        if ($existingConversation) {
            return $existingConversation;
        }
        
        // Créer une nouvelle conversation
        $conversation = Conversation::create([
            'is_group' => false,
        ]);
        
        // Ajouter les participants
        $conversation->participants()->attach($userId1, ['last_read' => now()]);
        $conversation->participants()->attach($userId2);
        
        return $conversation;
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

    /**
     * Récupérer la liste des contacts potentiels pour un partage de message
     */
    public function getContacts()
    {
        $user = Auth::user();
        $contacts = $this->getPotentialContacts($user);
        
        return response()->json($contacts);
    }
} 