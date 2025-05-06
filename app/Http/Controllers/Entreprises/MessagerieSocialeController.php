<?php

namespace App\Http\Controllers\Entreprises;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\PostAttachment;
use App\Models\PostShare;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MessagerieSocialeController extends Controller
{
    /**
     * Afficher la liste des posts dans le canal de messagerie
     */
    public function index()
    {
        return view('entreprises.messagerie.index');
    }

    /**
     * Afficher le formulaire de création d'un nouveau post
     */
    public function createPost()
    {
        return view('entreprises.messagerie.create-post');
    }

    /**
     * Enregistrer un nouveau post
     */
    public function storePost(Request $request)
    {
        $validated = $request->validate([
            'content' => 'required|string|min:5',
            'attachments.*' => 'sometimes|file|max:10240', // 10MB par fichier
        ]);

        DB::beginTransaction();
        try {
            // Créer le post
            $post = new Post();
            $post->user_id = Auth::id();
            $post->content = $validated['content'];
            $post->type = 'enterprise'; // Type de post: enterprise
            $post->status = 'published'; // Le post est immédiatement publié
            $post->slug = Str::slug(Str::limit(strip_tags($validated['content']), 50)) . '-' . Str::random(5);
            $post->save();

            // Traiter les pièces jointes si nécessaire
            if ($request->hasFile('attachments')) {
                foreach ($request->file('attachments') as $file) {
                    $filename = time() . '_' . $file->getClientOriginalName();
                    $path = $file->storeAs('posts/attachments', $filename, 'public');

                    $attachment = new PostAttachment();
                    $attachment->post_id = $post->id;
                    $attachment->file_path = $path;
                    $attachment->file_name = $file->getClientOriginalName();
                    $attachment->file_size = $file->getSize();
                    $attachment->file_type = $file->getMimeType();
                    $attachment->save();
                }
            }

            DB::commit();

            // Générer un lien de partage
            $shareUrl = route('messagerie-sociale.show-post', ['post' => $post->id]);
            
            return redirect()->route('entreprises.messagerie.index')
                ->with('success', 'Votre annonce a été publiée avec succès.')
                ->with('share_url', $shareUrl);
                
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Erreur lors de la création du post: ' . $e->getMessage(), [
                'user_id' => Auth::id(),
                'exception' => $e
            ]);
            
            return back()->with('error', 'Une erreur est survenue lors de la publication de votre annonce. Veuillez réessayer.')
                ->withInput();
        }
    }

    /**
     * Afficher un post spécifique
     */
    public function showPost(Post $post)
    {
        // Vérifier si le post est accessible à l'utilisateur
        $share = null;

        return view('entreprises.messagerie.show-post', compact('post', 'share'));
    }

    /**
     * Partager un post existant
     */
    public function sharePost(Request $request, Post $post)
    {
        $validated = $request->validate([
            'comment' => 'nullable|string|max:500',
        ]);

        try {
            $share = new PostShare();
            $share->user_id = Auth::id();
            $share->post_id = $post->id;
            $share->comment = $validated['comment'] ?? null;
            $share->save();

            // Générer un lien de partage
            $shareUrl = route('messagerie-sociale.show-shared-post', ['share' => $share->id]);
            
            return redirect()->route('entreprises.messagerie.index')
                ->with('success', 'L\'annonce a été partagée avec succès.')
                ->with('share_url', $shareUrl);
                
        } catch (\Exception $e) {
            Log::error('Erreur lors du partage du post: ' . $e->getMessage(), [
                'user_id' => Auth::id(),
                'post_id' => $post->id,
                'exception' => $e
            ]);
            
            return back()->with('error', 'Une erreur est survenue lors du partage de l\'annonce. Veuillez réessayer.');
        }
    }

    /**
     * Supprimer un post
     */
    public function destroyPost(Post $post)
    {
        // Vérifier que l'utilisateur est bien le propriétaire du post
        if ($post->user_id !== Auth::id() && !Auth::user()->hasRole('admin')) {
            return redirect()->route('entreprises.messagerie.index')
                ->with('error', 'Vous n\'êtes pas autorisé à supprimer cette annonce.');
        }

        try {
            // Supprimer les pièces jointes du stockage
            foreach ($post->attachments as $attachment) {
                Storage::disk('public')->delete($attachment->file_path);
            }
            
            // Supprimer le post et les relations associées (via onDelete cascade)
            $post->delete();
            
            return redirect()->route('entreprises.messagerie.index')
                ->with('success', 'L\'annonce a été supprimée avec succès.');
                
        } catch (\Exception $e) {
            Log::error('Erreur lors de la suppression du post: ' . $e->getMessage(), [
                'user_id' => Auth::id(),
                'post_id' => $post->id,
                'exception' => $e
            ]);
            
            return redirect()->route('entreprises.messagerie.index')
                ->with('error', 'Une erreur est survenue lors de la suppression de l\'annonce. Veuillez réessayer.');
        }
    }
}