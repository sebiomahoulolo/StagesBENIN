<?php

namespace App\Http\Controllers\NouvelleMessagerie;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MessagePost;
use App\Models\MessageComment;
use App\Models\MessageShare;
use App\Models\MessagePostAttachment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class MessagerieSocialeController extends Controller
{
    /**
     * Afficher la page d'accueil de la messagerie sociale
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $user = Auth::user();
        $posts = MessagePost::with(['user', 'comments.user', 'attachments'])
            ->where('is_published', true)
            ->latest()
            ->paginate(10);

        // Déterminer quelle vue utiliser en fonction du type d'utilisateur
        if ($user->isAdmin()) {
            return view('nouvelle-messagerie.index', compact('posts'));
        } elseif ($user->isEtudiant()) {
            return view('nouvelle-messagerie.etudiant.index', compact('posts'));
        } elseif ($user->isRecruteur()) {
            return view('nouvelle-messagerie.entreprise.index', compact('posts'));
        } else {
            // Vue par défaut si aucun type spécifique reconnu
            return view('nouvelle-messagerie.index', compact('posts'));
        }
    }

    /**
     * Créer un nouveau message (post)
     * Seulement disponible pour admin et entreprises
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storePost(Request $request)
    {
        if (!Gate::allows('create-post')) {
            abort(403, 'Non autorisé à créer des posts.');
        }

        $validatedData = $request->validate([
            'content' => 'required|string|max:5000',
            'attachments.*' => 'nullable|file|max:10240', // 10MB max par fichier
        ]);

        $post = MessagePost::create([
            'user_id' => Auth::id(),
            'content' => $validatedData['content'],
            'is_published' => true,
        ]);

        // Traitement des fichiers joints si présents
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $path = $file->store('message_post_attachments', 'public');
                $post->attachments()->create([
                    'path' => $path,
                    'original_name' => $file->getClientOriginalName(),
                    'mime_type' => $file->getMimeType(),
                    'size' => $file->getSize(),
                ]);
            }
        }

        session()->flash('success', 'Message publié avec succès!');
        return redirect()->route('messagerie-sociale.index');
    }

    /**
     * Afficher le formulaire de création d'un post
     * Accessible uniquement pour les administrateurs et recruteurs
     *
     * @return \Illuminate\View\View
     */
    public function createPost()
    {
        if (!Gate::allows('create-post')) {
            abort(403, 'Non autorisé à créer des posts.');
        }

        $user = Auth::user();

        if ($user->isAdmin()) {
            return view('nouvelle-messagerie.create-post');
        } elseif ($user->isRecruteur()) {
            return view('nouvelle-messagerie.entreprise.create-post');
        } else {
            // Vue par défaut
            return view('nouvelle-messagerie.create-post');
        }
    }

    /**
     * Afficher un post spécifique et ses commentaires
     *
     * @param  \App\Models\MessagePost  $post
     * @return \Illuminate\View\View
     */
    public function showPost(MessagePost $post)
    {
        if (!$post->is_published) {
            abort(404, 'Post non trouvé');
        }

        $post->load(['user', 'comments.user', 'attachments']);
        $user = Auth::user();

        if ($user->isAdmin()) {
            return view('nouvelle-messagerie.show-post', compact('post'));
        } elseif ($user->isEtudiant()) {
            return view('nouvelle-messagerie.etudiant.show-post', compact('post'));
        } elseif ($user->isRecruteur()) {
            return view('nouvelle-messagerie.entreprise.show-post', compact('post'));
        } else {
            // Vue par défaut
            return view('nouvelle-messagerie.show-post', compact('post'));
        }
    }

    /**
     * Afficher un post partagé via un token
     *
     * @param  string  $token
     * @return \Illuminate\View\View
     */
    public function showSharedPost($token)
    {
        $share = MessageShare::where('share_token', $token)->firstOrFail();
        $post = $share->post;

        if (!$post->is_published) {
            abort(404, 'Post non trouvé');
        }

        $post->load(['user', 'comments.user', 'attachments']);
        $user = Auth::user();

        if ($user->isAdmin()) {
            return view('nouvelle-messagerie.show-post', compact('post', 'share'));
        } elseif ($user->isEtudiant()) {
            return view('nouvelle-messagerie.etudiant.show-post', compact('post', 'share'));
        } elseif ($user->isRecruteur()) {
            return view('nouvelle-messagerie.entreprise.show-post', compact('post', 'share'));
        } else {
            // Vue par défaut
            return view('nouvelle-messagerie.show-post', compact('post', 'share'));
        }
    }

    /**
     * Mettre à jour un message existant
     * Seulement disponible pour admin et entreprises
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MessagePost  $post
     * @return \Illuminate\Http\Response
     */
    // public function updatePost(Request $request, MessagePost $post)
    // {
    //     if (!Gate::allows('update-post', $post)) {
    //         abort(403, 'Non autorisé à modifier ce post.');
    //     }

    //     $validatedData = $request->validate([
    //         'content' => 'required|string|max:5000',
    //     ]);

    //     $post->update([
    //         'content' => $validatedData['content'],
    //         'edited_at' => now(),
    //     ]);

    //     session()->flash('success', 'Message mis à jour avec succès!');
    //     return redirect()->route('messagerie-sociale.show-post', $post);
    // }

    /**
     * Supprimer un message
     * Seulement disponible pour admin et entreprises
     *
     * @param  \App\Models\MessagePost  $post
     * @return \Illuminate\Http\Response
     */
    public function destroyPost(MessagePost $post)
    {
        if (!Gate::allows('delete-post', $post)) {
            abort(403, 'Non autorisé à supprimer ce post.');
        }

        $post->delete();

        session()->flash('success', 'Message supprimé avec succès!');
        return redirect()->route('messagerie-sociale.index');
    }

    /**
     * Ajouter un commentaire à un message
     * Disponible pour tous les utilisateurs
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MessagePost  $post
     * @return \Illuminate\Http\Response
     */
    public function storeComment(Request $request, MessagePost $post)
    {
        $validatedData = $request->validate([
            'content' => 'required|string|max:1000',
        ]);

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
        return redirect()->route('messagerie-sociale.show-post', $post);
    }

    /**
     * Supprimer un commentaire
     *
     * @param MessageComment $comment
     * @return \Illuminate\Http\Response
     */
    public function destroyComment(MessageComment $comment)
    {
        if (!Gate::allows('delete-comment', $comment)) {
            abort(403, 'Non autorisé à supprimer ce commentaire.');
        }

        $postId = $comment->post_id;
        $comment->delete();

        session()->flash('success', 'Commentaire supprimé avec succès!');
        return redirect()->route('messagerie-sociale.show-post', $postId);
    }

    /**
     * Partager un message
     * Disponible pour tous les utilisateurs
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MessagePost  $post
     * @return \Illuminate\Http\Response
     */
    public function sharePost(Request $request, MessagePost $post)
    {
        $validatedData = $request->validate([
            'comment' => 'nullable|string|max:1000',
        ]);

        $share = MessageShare::create([
            'user_id' => Auth::id(),
            'post_id' => $post->id,
            'comment' => $validatedData['comment'] ?? null,
        ]);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'share_url' => $share->share_url
            ]);
        }

        session()->flash('success', 'Message partagé avec succès!');
        session()->flash('share_url', $share->share_url);

        return redirect()->route('messagerie-sociale.show-post', $post);
    }

    /**
     * Vérifie si l'utilisateur est un administrateur
     */
    private function isAdmin()
    {
        return auth()->check() && auth()->user()->role === 'admin';
    }

    /**
     * Vérifie si l'utilisateur est un étudiant
     */
    private function isEtudiant()
    {
        return auth()->check() && auth()->user()->role === 'etudiant';
    }

    /**
     * Vérifie si l'utilisateur est un recruteur
     */
    private function isRecruteur()
    {
        return auth()->check() && auth()->user()->role === 'recruteur';
    }

    /**
     * Afficher le formulaire d'édition d'un post
     * Seulement disponible pour admin et entreprises
     *
     * @param  \App\Models\MessagePost  $post
     * @return \Illuminate\View\View
     */
    public function editPost(MessagePost $post)
    {
        if (!Gate::allows('update-post', $post)) {
            abort(403, 'Non autorisé à modifier ce post.');
        }

        $user = Auth::user();

        if ($user->isAdmin()) {
            return view('nouvelle-messagerie.edit-post', compact('post'));
        } elseif ($user->isRecruteur()) {
            return view('nouvelle-messagerie.entreprise.edit-post', compact('post'));
        } else {
            // Vue par défaut
            return view('nouvelle-messagerie.edit-post', compact('post'));
        }
    }

    /**
     * Met à jour un post existant
     *
     * @param \Illuminate\Http\Request $request
     * @param int $post
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updatePost(Request $request, $post)
    {
        $post = MessagePost::findOrFail($post);

        // Vérifier si l'utilisateur est autorisé à modifier ce post
        if (auth()->id() !== $post->user_id) {
            return redirect()->back()->with('error', 'Vous n\'êtes pas autorisé à modifier ce post.');
        }

        $validated = $request->validate([
            'contenu' => 'required|string|max:1000',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        // Mise à jour du contenu
        $post->contenu = $validated['contenu'];

        // Gestion de l'image si une nouvelle est fournie
        if ($request->hasFile('image')) {
            // Supprimer l'ancienne image si elle existe
            if ($post->image && Storage::exists($post->image)) {
                Storage::delete($post->image);
            }

            // Sauvegarder la nouvelle image
            $path = $request->file('image')->store('posts', 'public');
            $post->image = $path;
        }

        $post->save();

        return redirect()->route('messagerie-sociale.index')
            ->with('success', 'Le post a été mis à jour avec succès.');
    }
}
