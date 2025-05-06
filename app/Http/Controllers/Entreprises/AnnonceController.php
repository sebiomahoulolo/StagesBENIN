<?php

namespace App\Http\Controllers\Entreprises;

use App\Http\Controllers\Controller;
use App\Models\Annonce;
use App\Models\Secteur;      // Assurez-vous que ce modèle existe et est utilisé correctement
use App\Models\Specialite;
use App\Models\Entreprise; // Ajoutez ceci si vous utilisez le modèle directement
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log; // Utile pour le débogage

class AnnonceController extends Controller
{
    public function index()
    {
        // Récupérer l'entreprise associée à l'utilisateur connecté
        $entreprise = Auth::user()->entreprise;

        // Vérifier si l'utilisateur a une entreprise
        if (!$entreprise) {
            // Rediriger vers une page appropriée, peut-être le profil ou une page d'erreur dédiée
            return redirect()->route('entreprise.profile.show') // Mettez une route pertinente
                       ->with('error', 'Veuillez compléter les informations de votre entreprise pour gérer les annonces.');
        }

        // Filtrer les annonces par l'ID de l'entreprise (entreprise.id)
        $annonces = Annonce::where('entreprise_id', $entreprise->id) // <-- CORRECTION ICI
            ->with(['candidatures', /*'entreprise',*/ 'secteur', 'specialite']) // 'entreprise' est moins utile ici car on filtre déjà
            ->latest() // orderBy('created_at', 'desc')
            ->paginate(10);

        return view('entreprises.annonces.index', compact('annonces'));
    }

    public function create()
    {
        // S'assurer que l'utilisateur a une entreprise avant de montrer le formulaire
        if (!Auth::user()->entreprise) {
             return redirect()->route('entreprise.profile.show') // Mettez une route pertinente
                       ->with('error', 'Veuillez compléter les informations de votre entreprise avant de créer une annonce.');
        }

        $specialites = Specialite::orderBy('nom')->get(); // Mieux de trier
        // Vous pourriez aussi avoir besoin des Secteurs si le formulaire les utilise
        // $secteurs = Secteur::orderBy('nom')->get();
        return view('entreprises.annonces.create', compact('specialites'/*, 'secteurs'*/));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom_du_poste' => 'required|string|max:255',
            'type_de_poste' => 'required|string|max:255', // Envisager enum/liste fixe?
            'nombre_de_place' => 'required|integer|min:1',
            'niveau_detude' => 'required|string|max:255', // Envisager enum/liste fixe?
            'specialite_id' => 'required|exists:specialites,id',
            'lieu' => 'required|string|max:255',
            'email' => 'required|email|max:255', // Email de contact pour l'annonce
            'date_cloture' => 'required|date|after_or_equal:today', // after_or_equal est souvent plus flexible
            'description' => 'required|string',
            'pretension_salariale' => 'nullable|numeric|min:0',
            // 'secteur_id' devrait être dérivé, pas soumis directement par l'utilisateur en général
        ]);

        // Récupérer l'entreprise associée
        $entreprise = Auth::user()->entreprise;
        if (!$entreprise) {
            return redirect()->back()->withInput()->with('error', 'Impossible de créer l\'annonce : informations entreprise manquantes.');
        }

        // Récupérer la spécialité pour obtenir le secteur_id
        $specialite = Specialite::find($validated['specialite_id']); // Utiliser find au lieu de findOrFail pour vérifier ensuite
        if (!$specialite || !$specialite->secteur_id) {
             // Log l'erreur peut être utile ici
             Log::warning('Tentative de création d\'annonce avec spécialité invalide ou sans secteur_id', [
                'specialite_id' => $validated['specialite_id'],
                'user_id' => Auth::id()
             ]);
             return redirect()->back()->withInput()->with('error', 'La spécialité sélectionnée est invalide ou n\'a pas de secteur associé.');
        }
        $validated['secteur_id'] = $specialite->secteur_id; // Ajouter le secteur_id aux données validées

        // Créer l'annonce en utilisant les données validées
        $annonce = new Annonce($validated);

        // Assigner l'ID de l'entreprise (entreprise.id)
        $annonce->entreprise_id = $entreprise->id; // <-- CORRECTION ICI

        // Les valeurs par défaut (statut, est_active) sont gérées par la migration/modèle
        // $annonce->statut = 'en_attente'; // Redondant si default dans la migration
        // $annonce->est_active = true; // Redondant si default dans la migration

        // Le slug est généré automatiquement via l'événement 'creating' du modèle

        $annonce->save(); // L'erreur devrait être résolue maintenant

        return redirect()->route('entreprises.annonces.index')
            ->with('success', 'Annonce créée avec succès. Elle sera publiée après validation par l\'administrateur.');
    }

    public function show(Annonce $annonce) // Utilise Route Model Binding (basé sur le slug par défaut grâce à getRouteKeyName)
    {
        // Vérifier que l'entreprise connectée est bien propriétaire de l'annonce
        $this->authorize('view', $annonce); // Utilise AnnoncePolicy (à créer si besoin)

        // Charger les relations nécessaires pour la vue
        $annonce->load(['candidatures.etudiant', 'secteur', 'specialite', 'entreprise']); // Charger 'entreprise' est utile ici
        return view('entreprises.annonces.show', compact('annonce'));
    }

    public function edit(Annonce $annonce)
    {
        // Vérifier que l'entreprise connectée est bien propriétaire de l'annonce
        $this->authorize('update', $annonce); // Utilise AnnoncePolicy

        // Charger les données nécessaires pour le formulaire d'édition
        $specialites = Specialite::orderBy('nom')->get();
        // Charger les secteurs si nécessaire pour un select dépendant par exemple
        $secteurs = Secteur::orderBy('nom')->get();

        return view('entreprises.annonces.edit', compact('annonce', 'specialites', 'secteurs'));
    }

    public function update(Request $request, Annonce $annonce)
    {
         // Vérifier que l'entreprise connectée est bien propriétaire de l'annonce
        $this->authorize('update', $annonce); // Utilise AnnoncePolicy

        // Valider les données (similaire à store, mais adapter si certaines choses ne peuvent pas changer)
        $validated = $request->validate([
            'nom_du_poste' => 'required|string|max:255',
            'type_de_poste' => 'required|string|max:255',
            'nombre_de_place' => 'required|integer|min:1',
            'niveau_detude' => 'required|string|max:255',
            'specialite_id' => 'required|exists:specialites,id',
            'lieu' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'date_cloture' => 'required|date|after_or_equal:today',
            'description' => 'required|string',
            'pretension_salariale' => 'nullable|numeric|min:0',
            // 'secteur_id' devrait être re-dérivé de specialite_id
        ]);

        // Re-dériver secteur_id basé sur la nouvelle spécialité
        $specialite = Specialite::find($validated['specialite_id']);
        if (!$specialite || !$specialite->secteur_id) {
            return redirect()->back()->withInput()->with('error', 'La spécialité sélectionnée est invalide ou n\'a pas de secteur associé.');
        }
        $validated['secteur_id'] = $specialite->secteur_id;

        // Mettre à jour l'annonce
        // Le slug n'est généralement pas mis à jour pour éviter les liens cassés
        // L'entreprise_id ne devrait pas changer non plus
        $annonce->update($validated);

        // Peut-être remettre le statut en attente si des modifs importantes ont été faites? Dépend des règles métier.
        // $annonce->statut = 'en_attente';
        // $annonce->save();

        return redirect()->route('entreprises.annonces.index')
            ->with('success', 'Annonce mise à jour avec succès.');
    }

    public function destroy(Annonce $annonce)
    {
        // Vérifier que l'entreprise connectée est bien propriétaire de l'annonce
        $this->authorize('delete', $annonce); // Utilise AnnoncePolicy

        $annonce->delete(); // Supprime l'annonce

        return redirect()->route('entreprises.annonces.index')
            ->with('success', 'Annonce supprimée avec succès.');
    }

    // Fonction utilitaire pour les selects dépendants (si utilisée)
    public function getSpecialites(Request $request) // Mieux de recevoir l'ID via Request
    {
        $secteurId = $request->input('secteur_id');
        if (!$secteurId) {
            return response()->json([]); // Retourner un tableau vide si pas d'ID
        }
        $secteur = Secteur::find($secteurId);
        if (!$secteur) {
             return response()->json([]); // Retourner un tableau vide si secteur non trouvé
        }
        // Retourner seulement id et nom pour alléger la réponse
        $specialites = $secteur->specialites()->orderBy('nom')->pluck('nom', 'id');
        return response()->json($specialites);
    }

    // --- Policy (Exemple rapide à mettre dans App\Policies\AnnoncePolicy.php) ---
    // Pensez à créer la Policy avec `php artisan make:policy AnnoncePolicy --model=Annonce`
    // et à l'enregistrer dans AuthServiceProvider.php

    // Dans AnnoncePolicy.php (exemple) :
    // public function view(User $user, Annonce $annonce): bool
    // {
    //     return $user->entreprise?->id === $annonce->entreprise_id;
    // }
    // public function update(User $user, Annonce $annonce): bool
    // {
    //     return $user->entreprise?->id === $annonce->entreprise_id;
    // }
    // public function delete(User $user, Annonce $annonce): bool
    // {
    //     return $user->entreprise?->id === $annonce->entreprise_id;
    // }
}