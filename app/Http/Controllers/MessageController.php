<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\Message;
use App\Models\MessageAttachment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Events\MessageSent;

class MessageController extends Controller
{
    /**
     * Créer un nouveau message dans une conversation et le diffuser
     *
     * @param Request $request
     * @param int $conversationId
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request, $conversationId)
    {
        // Vérifier si l'utilisateur fait partie de la conversation
        $conversation = Conversation::findOrFail($conversationId);
        if (!$conversation->isParticipant(Auth::id())) {
            return response()->json(['error' => 'Non autorisé'], 403);
        }

        // Valider les données
        $validatedData = $request->validate([
            'message' => 'required_without:attachments|nullable|string',
            'attachments' => 'nullable|array',
            'attachments.*' => 'file|max:10240', // 10MB max
        ]);

        // Créer le message
        $message = $conversation->messages()->create([
            'user_id' => Auth::id(),
            'body' => $request->message ?? null,
            'type' => 'text',
        ]);

        // Mettre à jour l'horodatage de la conversation
        $conversation->touch();
        
        // Mettre à jour la dernière lecture pour l'expéditeur
        $conversation->participants()
            ->updateExistingPivot(Auth::id(), ['last_read' => now()]);

        // Diffuser le message en temps réel
        event(new MessageSent($message->load('user')));

        return response()->json([
            'success' => true,
            'message' => $message
        ]);
    }

    /**
     * Supprimer un message
     *
     * @param Request $request
     * @param int $messageId
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request, $messageId)
    {
        $message = Message::findOrFail($messageId);
        
        // Vérifier si l'utilisateur est l'auteur du message
        if ($message->user_id !== Auth::id()) {
            return response()->json(['error' => 'Non autorisé'], 403);
        }

        // Supprimer le message
        $message->delete();

        return response()->json([
            'success' => true,
            'message' => 'Message supprimé avec succès'
        ]);
    }

    /**
     * Récupérer tous les messages d'une conversation
     *
     * @param int $conversationId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getMessages($conversationId)
    {
        $conversation = Conversation::findOrFail($conversationId);
        
        // Vérifier si l'utilisateur fait partie de la conversation
        if (!$conversation->isParticipant(Auth::id())) {
            return response()->json(['error' => 'Non autorisé'], 403);
        }

        // Récupérer les messages
        $messages = $conversation->messages()
            ->with('user', 'attachments')
            ->orderBy('created_at', 'asc')
            ->get();

        return response()->json([
            'success' => true,
            'messages' => $messages
        ]);
    }
} 