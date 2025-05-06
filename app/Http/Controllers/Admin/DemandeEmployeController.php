<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DemandeEmploye;
use App\Models\SocialPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DemandeEmployeController extends Controller
{
    public function index()
    {
        $demandes = DemandeEmploye::with('entreprise')
            ->orderBy('created_at', 'desc')
            ->get();
        return view('admin.demandes.index', compact('demandes'));
    }

    public function show(DemandeEmploye $demande)
    {
        return view('admin.demandes.show', compact('demande'));
    }

    public function updateStatus(Request $request, DemandeEmploye $demande)
    {
        $validated = $request->validate([
            'statut' => 'required|in:approuvee,rejetee,en_cours',
            'commentaire_admin' => 'nullable|string',
        ]);

        $demande->update([
            'statut' => $validated['statut'],
            'commentaire_admin' => $validated['commentaire_admin'],
            'admin_id' => Auth::id(),
        ]);

        return redirect()->route('admin.demandes.index')
            ->with('success', 'Le statut de la demande a été mis à jour avec succès.');
    }

    public function destroy(DemandeEmploye $demande)
    {
        $demande->delete();
        return redirect()->route('admin.demandes.index')
            ->with('success', 'La demande a été supprimée avec succès.');
    }

    public function createPost()
    {
        return view('messagerie-sociale.entreprise.create-post');
    }

    public function storePost(Request $request)
    {
        $request->validate([
            'content' => 'required|string|min:5',
            'attachments.*' => 'nullable|file|max:10240', // 10MB max per file
        ]);

        try {
            $post = new SocialPost();
            $post->content = $request->content;
            $post->user_id = Auth::id();
            $post->save();

            // Handle attachments if any
            if ($request->hasFile('attachments')) {
                foreach ($request->file('attachments') as $file) {
                    $path = $file->store('posts_attachments', 'public');
                    $post->attachments()->create([
                        'file_path' => $path,
                        'file_name' => $file->getClientOriginalName(),
                        'file_type' => $file->getMimeType(),
                        'file_size' => $file->getSize(),
                    ]);
                }
            }

            // Generate a share link
            $shareToken = Str::random(32);
            $shareLink = route('messagerie-sociale.shared', ['token' => $shareToken]);

            // Store the share information
            $post->shares()->create([
                'user_id' => Auth::id(),
                'token' => $shareToken,
            ]);

            return redirect()->route('messagerie-sociale.entreprise.index')
                ->with('success', 'Annonce publiée avec succès!')
                ->with('share_url', $shareLink);
        } catch (\Exception $e) {
            return back()->with('error', 'Erreur lors de la publication: ' . $e->getMessage());
        }
    }

    public function indexPosts()
    {
        return view('messagerie-sociale.entreprise.index');
    }

    public function showPost(SocialPost $post)
    {
        return view('messagerie-sociale.entreprise.show-post', compact('post'));
    }
}
