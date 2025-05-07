<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DemandeEmploye;
// Supprimez App\Models\SocialPost si non utilisé dans CE contrôleur
// use App\Models\SocialPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log; // Utile pour le débogage
// Supprimez Storage et Str si non utilisés directement dans CE contrôleur
// use Illuminate\Support\Facades\Storage;
// use Illuminate\Support\Str;

class DemandeEmployeController extends Controller
{
    public function index()
    {
        $demandes = DemandeEmploye::with('entreprise')
            ->latest() // Raccourci pour orderBy('created_at', 'desc')
            ->paginate(15); // Ajout de la pagination pour de meilleures performances et UI
        return view('admin.demandes.index', compact('demandes'));
    }

    public function show(DemandeEmploye $demande)
    {
        // Charger les relations pour éviter les requêtes N+1 dans la vue
        $demande->load(['entreprise', 'admin']);
        return view('admin.demandes.show', compact('demande'));
    }

    public function updateStatus(Request $request, DemandeEmploye $demande)
    {
        $validated = $request->validate([
            'statut' => 'required|in:approuvee,rejetee,en_cours', // Assurez-vous que 'en_cours' est un statut valide dans votre BDD
            // 'motif_rejet' est utilisé dans la vue du modal, donc il devrait être ici
            'motif_rejet' => 'nullable|string|max:1000', // Augmenter la limite si nécessaire
        ]);

        // Logique pour le champ commentaire_admin vs motif_rejet
        // Si le statut est 'rejetee', le commentaire_admin sera le motif_rejet.
        // Sinon, il sera null ou vide si aucun motif n'est fourni pour d'autres statuts.
        $commentaireAdmin = null;
        if ($validated['statut'] === 'rejetee') {
            $commentaireAdmin = $validated['motif_rejet'] ?? null;
        } else {
            // Si vous aviez un champ séparé pour les commentaires généraux,
            // vous le récupéreriez ici. Actuellement, il semble que 'motif_rejet'
            // serve de commentaire principal quand on rejette.
            // $commentaireAdmin = $request->input('commentaire_admin_general'); // Exemple
        }


        try {
            $demande->update([
                'statut' => $validated['statut'],
                // *** CORRECTION ICI ***
                // Utiliser 'motif_rejet' comme nom de colonne dans la BDD
                // si c'est ce qui est défini dans votre modèle et migration.
                // Si vous avez une colonne 'commentaire_admin' et une 'motif_rejet',
                // vous devez décider laquelle utiliser ou les remplir toutes les deux.
                // En se basant sur le formulaire et le modèle, il semble que 'motif_rejet' soit la bonne colonne.
                'motif_rejet' => $commentaireAdmin, // Affecte le motif de rejet
                'admin_id' => Auth::id(), // L'ID de l'admin qui a fait la modification
                // 'commentaire_admin' => $commentaireAdmin, // Décommentez si vous avez une colonne distincte 'commentaire_admin'
            ]);

            $message = 'Le statut de la demande a été mis à jour avec succès.';
            if ($validated['statut'] === 'rejetee' && $commentaireAdmin) {
                $message .= ' Motif du rejet enregistré.';
            }

            return redirect()->route('admin.demandes.index')
                         ->with('success', $message);

        } catch (\Exception $e) {
            Log::error("Erreur lors de la mise à jour du statut de la demande #{$demande->id}: " . $e->getMessage());
            return redirect()->back()
                         ->with('error', 'Une erreur est survenue lors de la mise à jour du statut.');
        }
    }

    public function destroy(DemandeEmploye $demande)
    {
        try {
            $demande->delete();
            return redirect()->route('admin.demandes.index')
                           ->with('success', 'La demande a été supprimée avec succès.');
        } catch (\Exception $e) {
            Log::error("Erreur lors de la suppression de la demande #{$demande->id}: " . $e->getMessage());
            return redirect()->route('admin.demandes.index')
                           ->with('error', 'Une erreur est survenue lors de la suppression de la demande.');
        }
    }

    // Les méthodes createPost, storePost, indexPosts, showPost semblent appartenir
    // à un contrôleur de messagerie sociale et non à la gestion des DemandeEmploye.
    // Il faudrait les déplacer dans le contrôleur approprié si ce n'est pas déjà fait.
    // Je vais les commenter pour l'instant dans ce contrôleur.

    /*
    public function createPost()
    {
        // return view('messagerie-sociale.entreprise.create-post'); // Probablement pour un autre contrôleur
    }

    public function storePost(Request $request)
    {
        // ... Logique de messagerie sociale ...
    }

    public function indexPosts()
    {
        // return view('messagerie-sociale.entreprise.index'); // Probablement pour un autre contrôleur
    }

    public function showPost(SocialPost $post) // Modèle SocialPost utilisé ici
    {
        // return view('messagerie-sociale.entreprise.show-post', compact('post')); // Probablement pour un autre contrôleur
    }
    */
}