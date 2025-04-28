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

class MessagingController extends Controller
{
    /**
     * Afficher la liste des conversations de l'utilisateur
     */
    public function index()
    {
        $conversations = Auth::user()->conversations()
            ->with(['participants' => function($query) {
                $query->where('user_id', '!=', Auth::id());
            }, 'lastMessage'])
            ->get();

        $unreadCount = Auth::user()->unreadMessagesCount();

        return view('messaging.index', compact('conversations', 'unreadCount'));
    }

    /**
     * Afficher une conversation spécifique
     */
    public function show(Conversation $conversation)
    {
        // Vérifier si l'utilisateur fait partie de la conversation
        if (!$conversation->isParticipant(Auth::id())) {
            return redirect()->route('messaging.index')
                ->with('error', 'Vous n\'avez pas accès à cette conversation.');
        }

        // Charger les messages et marquer comme lus
        $messages = $conversation->messages()->with('user', 'attachments')->get();
        
        // Marquer les messages comme lus
        $conversation->messages()
            ->where('user_id', '!=', Auth::id())
            ->where('is_read', false)
            ->update(['is_read' => true]);

        // Mettre à jour la dernière lecture
        $conversation->participants()
            ->updateExistingPivot(Auth::id(), ['last_read' => now()]);

        // Récupérer les autres participants
        $participants = $conversation->participants()
            ->where('user_id', '!=', Auth::id())
            ->get();

        $user = Auth::user();

        return view('messaging.show', compact('conversation', 'messages', 'participants', 'user'));
    }

    /**
     * Créer une nouvelle conversation
     */
    public function create()
    {
        $user = Auth::user();
        
        // Récupérer les utilisateurs avec qui on peut démarrer une conversation
        if ($user->isEtudiant()) {
            // Les étudiants peuvent contacter d'autres étudiants et les recruteurs
            $potentialContacts = User::where('id', '!=', $user->id)
                ->where(function($query) {
                    $query->where('role', User::ROLE_ETUDIANT)
                          ->orWhere('role', User::ROLE_RECRUTEUR);
                })
                ->get();
        } elseif ($user->isRecruteur()) {
            // Les recruteurs peuvent contacter les étudiants
            $potentialContacts = User::where('id', '!=', $user->id)
                ->where('role', User::ROLE_ETUDIANT)
                ->get();
        } else {
            // Admin peut contacter tout le monde
            $potentialContacts = User::where('id', '!=', $user->id)->get();
        }

        return view('messaging.create', compact('potentialContacts'));
    }

    /**
     * Stocker une nouvelle conversation
     */
    public function store(Request $request)
    {
        $request->validate([
            'recipient_ids' => 'required|array',
            'recipient_ids.*' => 'exists:users,id',
            'message' => 'required|string',
        ]);

        $recipientIds = $request->recipient_ids;
        $isGroup = count($recipientIds) > 1;
        $name = $isGroup ? ($request->name ?? 'Groupe') : null;

        // Vérifier si une conversation entre ces utilisateurs existe déjà (pour les 1-à-1)
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

                return redirect()->route('messaging.show', $existingConversation->id);
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

        return redirect()->route('messaging.show', $conversation->id);
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

        // Traiter les pièces jointes si elles existent
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

        // Diffuser le message en temps réel
        event(new MessageSent($message->load('user', 'attachments')));

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => $message->load('user', 'attachments')
            ]);
        }

        return redirect()->route('messaging.show', $conversation->id);
    }

    /**
     * Marquer tous les messages d'une conversation comme lus
     */
    public function markAsRead(Conversation $conversation)
    {
        // Vérifier si l'utilisateur fait partie de la conversation
        if (!$conversation->isParticipant(Auth::id())) {
            return response()->json(['error' => 'Non autorisé'], 403);
        }

        // Marquer les messages comme lus
        $conversation->messages()
            ->where('user_id', '!=', Auth::id())
            ->where('is_read', false)
            ->update(['is_read' => true]);

        // Mettre à jour la dernière lecture
        $conversation->participants()
            ->updateExistingPivot(Auth::id(), ['last_read' => now()]);

        return response()->json(['success' => true]);
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
     * Déterminer le type de message en fonction du type de fichier
     */
    private function determineMessageType($file)
    {
        $mime = $file->getMimeType();
        
        if (Str::startsWith($mime, 'image/')) {
            return 'image';
        } elseif (Str::startsWith($mime, 'video/')) {
            return 'video';
        } elseif (Str::startsWith($mime, 'audio/')) {
            return 'audio';
        } else {
            return 'file';
        }
    }
} 