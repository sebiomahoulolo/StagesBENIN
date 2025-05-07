<?php

namespace App\Http\Controllers\Entreprises;

use App\Http\Controllers\Controller;
use App\Models\MessagePost;
use App\Models\MessageComment;
use App\Models\MessageShare;
use App\Models\MessagePostAttachment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MessagerieSocialeController extends Controller
{
    /**
     * Afficher la liste des posts dans le canal de messagerie de l'entreprise.
     */
    public function index()
    {
        $user = Auth::user();
        $posts = MessagePost::with(['user', 'comments.user', 'attachments'])
            ->where(function ($query) use ($user) {
                $query->where('user_id', $user->id)
                      ->orWhere(function($q) { // Condition pour les posts publics si nécessaire
                          // $q->where('is_published', true)->whereNull('targeted_role_id_or_similar');
                          // Pour l'instant, une entreprise ne voit que ses posts
                      });
            })
            ->where('is_published', true) // Afficher seulement les posts publiés (même les siens)
            ->latest()
            ->paginate(10);

        return view('entreprises.messagerie-sociale.index', compact('posts')); // Chemin de vue corrigé
    }

    /**
     * Afficher le formulaire de création d'un nouveau post.
     */
    public function createPost()
    {
        if (!Gate::allows('create-post')) {
            abort(403, 'Action non autorisée.');
        }
        return view('entreprises.messagerie-sociale.create-post'); // Chemin de vue corrigé
    }

    /**
     * Enregistrer un nouveau post.
     */
    public function storePost(Request $request)
    {
        if (!Gate::allows('create-post')) {
            abort(403, 'Action non autorisée.');
        }

        $validatedData = $request->validate([
            'content' => 'required|string|max:5000',
            'attachments.*' => 'nullable|file|mimes:jpg,jpeg,png,gif,pdf,doc,docx,xls,xlsx,ppt,pptx|max:10240', // 10MB max par fichier
        ]);

        try {
            $post = MessagePost::create([
                'user_id' => Auth::id(),
                'content' => $validatedData['content'],
                'is_published' => true,
            ]);

            if ($request->hasFile('attachments')) {
                foreach ($request->file('attachments') as $file) {
                    $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
                    $path = $file->storeAs('message_post_attachments', $filename, 'public');

                    $post->attachments()->create([
                        'path' => $path,
                        'original_name' => $file->getClientOriginalName(),
                        'mime_type' => $file->getMimeType(),
                        'size' => $file->getSize(),
                    ]);
                }
            }

            session()->flash('success', 'Votre post a été publié avec succès!');
            // *** CORRECTION DU NOM DE LA ROUTE DE REDIRECTION ICI ***
            return redirect()->route('messagerie-sociale.index');

        } catch (\Exception $e) {
            Log::error('Erreur lors de la création du post par entreprise: ' . $e->getMessage(), [
                'user_id' => Auth::id(),
                'request_data' => $request->all(),
                'exception_trace' => $e->getTraceAsString()
            ]);
            return back()->with('error', 'Une erreur est survenue lors de la publication. Veuillez réessayer.')->withInput();
        }
    }

    /**
     * Afficher un post spécifique.
     */
    public function showPost(MessagePost $post)
    {
        if (!Gate::allows('view-post', $post)) {
            if (!$post->is_published && (Auth::guest() || Auth::id() !== $post->user_id)) {
                 abort(404, 'Post non trouvé ou non autorisé.');
            }
        }
        $post->load(['user', 'comments.user', 'attachments', 'shares.user']);
        return view('entreprises.messagerie-sociale.show-post', compact('post')); // Chemin de vue corrigé
    }


    /**
     * Afficher le formulaire d'édition d'un post.
     */
    public function editPost(MessagePost $post)
    {
        if (!Gate::allows('update-post', $post)) {
            abort(403, 'Action non autorisée.');
        }
        return view('entreprises.messagerie-sociale.edit-post', compact('post')); // Chemin de vue corrigé
    }


    /**
     * Mettre à jour un post existant.
     */
    public function updatePost(Request $request, MessagePost $post)
    {
        if (!Gate::allows('update-post', $post)) {
            abort(403, 'Action non autorisée.');
        }

        $validatedData = $request->validate([
            'content' => 'required|string|max:5000',
            // Gérer la suppression des pièces jointes existantes si une case est cochée
            'remove_attachments.*' => 'nullable|integer|exists:message_post_attachments,id',
            // Gérer l'ajout de nouvelles pièces jointes
            'new_attachments.*' => 'nullable|file|mimes:jpg,jpeg,png,gif,pdf,doc,docx,xls,xlsx,ppt,pptx|max:10240',
        ]);

        try {
            $post->update([
                'content' => $validatedData['content'],
                'edited_at' => now(),
            ]);

            // Supprimer les pièces jointes sélectionnées
            if ($request->has('remove_attachments')) {
                foreach ($request->input('remove_attachments') as $attachmentId) {
                    $attachment = MessagePostAttachment::where('id', $attachmentId)->where('post_id', $post->id)->first();
                    if ($attachment) {
                        Storage::disk('public')->delete($attachment->path);
                        $attachment->delete();
                    }
                }
            }

            // Ajouter de nouvelles pièces jointes
            if ($request->hasFile('new_attachments')) {
                foreach ($request->file('new_attachments') as $file) {
                    $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
                    $path = $file->storeAs('message_post_attachments', $filename, 'public');
                    $post->attachments()->create([
                        'path' => $path,
                        'original_name' => $file->getClientOriginalName(),
                        'mime_type' => $file->getMimeType(),
                        'size' => $file->getSize(),
                    ]);
                }
            }


            session()->flash('success', 'Post mis à jour avec succès!');
            return redirect()->route('entreprises.messagerie-sociale.show-post', $post); // Rediriger vers le post mis à jour

        } catch (\Exception $e) {
            Log::error('Erreur lors de la mise à jour du post par entreprise: ' . $e->getMessage(), [
                'user_id' => Auth::id(),
                'post_id' => $post->id,
                'exception' => $e
            ]);
            return back()->with('error', 'Une erreur est survenue lors de la mise à jour. Veuillez réessayer.')->withInput();
        }
    }

    /**
     * Supprimer un post.
     */
    public function destroyPost(MessagePost $post)
    {
        if (!Gate::allows('delete-post', $post)) {
            abort(403, 'Action non autorisée.');
        }

        try {
            foreach ($post->attachments as $attachment) {
                Storage::disk('public')->delete($attachment->path);
                $attachment->delete();
            }
            $post->comments()->delete();
            $post->shares()->delete();
            $post->delete();

            session()->flash('success', 'Post supprimé avec succès!');
            return redirect()->route('entreprises.messagerie-sociale.index');

        } catch (\Exception $e) {
            Log::error('Erreur lors de la suppression du post par entreprise: ' . $e->getMessage(), [
                'user_id' => Auth::id(),
                'post_id' => $post->id,
                'exception' => $e
            ]);
            return redirect()->route('entreprises.messagerie-sociale.index')
                ->with('error', 'Une erreur est survenue lors de la suppression.');
        }
    }

    /**
     * Enregistrer un nouveau commentaire.
     */
    public function storeComment(Request $request, MessagePost $post)
    {
        if (!$post->is_published && (Auth::guest() || !Gate::allows('view-post', $post))) {
            abort(403, 'Vous ne pouvez pas commenter ce post.');
        }

        $validatedData = $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        try {
            $comment = $post->comments()->create([
                'user_id' => Auth::id(),
                'content' => $validatedData['content'],
            ]);

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'comment' => $comment->load('user')
                ]);
            }
            session()->flash('success', 'Commentaire ajouté avec succès!');
            return redirect()->route('entreprises.messagerie-sociale.show-post', $post);

        } catch (\Exception $e) {
            Log::error('Erreur lors de l\'ajout du commentaire par entreprise: ' . $e->getMessage());
            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => 'Erreur serveur.'], 500);
            }
            return back()->with('error', 'Erreur lors de l\'ajout du commentaire.')->withInput();
        }
    }

    /**
     * Supprimer un commentaire.
     */
    public function destroyComment(MessageComment $comment)
    {
        if (!Gate::allows('delete-comment', $comment)) {
            abort(403, 'Action non autorisée.');
        }

        try {
            $postId = $comment->post_id;
            $comment->delete();

            session()->flash('success', 'Commentaire supprimé avec succès!');
            return redirect()->route('entreprises.messagerie-sociale.show-post', $postId);
        } catch (\Exception $e) {
            Log::error('Erreur lors de la suppression du commentaire par entreprise: ' . $e->getMessage());
            return back()->with('error', 'Erreur lors de la suppression du commentaire.');
        }
    }

    /**
     * Partager un post.
     */
    public function sharePost(Request $request, MessagePost $post)
    {
        if (!Gate::allows('share-post', $post)) {
            abort(403, 'Vous ne pouvez pas partager ce post.');
        }

        $validatedData = $request->validate([
            'comment' => 'nullable|string|max:1000',
        ]);

        try {
            $share = MessageShare::create([
                'user_id' => Auth::id(),
                'post_id' => $post->id,
                'comment' => $validatedData['comment'] ?? null,
                // 'share_token' => Str::random(32), // Si vous utilisez un token pour des liens de partage uniques
            ]);

            // Assurez-vous que le modèle MessageShare a un accesseur getShareUrlAttribute()
            // ou définissez l'URL de partage ici.
            // Pour l'instant, nous n'utilisons pas de token de partage spécifique dans cette logique.
            $shareUrl = route('entreprises.messagerie-sociale.show-post', $post); // Ou une route dédiée aux partages si implémentée

            if ($request->ajax()) {
                return response()->json(['success' => true, 'share_url' => $shareUrl]);
            }

            session()->flash('success', 'Post partagé avec succès!');
            // session()->flash('share_url', $shareUrl); // Peut être utilisé dans la vue si besoin

            return redirect()->route('entreprises.messagerie-sociale.show-post', $post);

        } catch (\Exception $e) {
            Log::error('Erreur lors du partage du post par entreprise: ' . $e->getMessage(), [
                'user_id' => Auth::id(),
                'post_id' => $post->id,
                'exception' => $e
            ]);
            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => 'Erreur serveur.'], 500);
            }
            return back()->with('error', 'Erreur lors du partage du post.');
        }
    }
}