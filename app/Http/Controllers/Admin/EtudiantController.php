<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Etudiant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class EtudiantController extends Controller
{
    //
public function index(Request $request)
{
    $query = Etudiant::query();

    $etudiants = Etudiant::paginate(10);


    // Gestion des filtres existants
    if ($request->has('filter')) {
        switch ($request->filter) {
            case 'today':
                $query->whereDate('created_at', now()->toDateString());
                break;
            case 'week':
                $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
                break;
            case 'month':
                $query->whereBetween('created_at', [now()->startOfMonth(), now()->endOfMonth()]);
                break;
        }
    }

    // Si on demande tous les étudiants (paramètre 'all=true')
    if ($request->get('all') === 'true') {
        $etudiants = $query->orderBy('created_at', 'desc')->get();
        
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'students' => $etudiants->map(function ($etudiant) {
                    return [
                        'id' => $etudiant->id,
                        'nom' => $etudiant->nom,
                        'prenom' => $etudiant->prenom,
                        'telephone' => $etudiant->telephone,
                        'niveau' => $etudiant->niveau,
                        'formation' => $etudiant->formation,
                        'statut' => $etudiant->statut,
                        'created_at' => $etudiant->created_at->toISOString(),
                    ];
                }),
                'total' => $etudiants->count()
            ]);
        }
    }

    // Pagination normale (par défaut 25 par page)
    $perPage = $request->get('per_page', 25);
    $etudiants = $query->orderBy('created_at', 'desc')->paginate($perPage);

    // Statistiques
    $stats = [
        'total' => Etudiant::count(),
        'today' => Etudiant::whereDate('created_at', now()->toDateString())->count(),
        'week' => Etudiant::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count(),
        'month' => Etudiant::whereBetween('created_at', [now()->startOfMonth(), now()->endOfMonth()])->count(),
    ];

    return view('admin.etudiants.etudaints', compact('etudiants', 'stats'));
}


    /**
     * Affiche la page de visualisation du CV d'un étudiant spécifique pour l'admin.
     *
     * @param  Etudiant $etudiant
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function showDetails(Etudiant $etudiant)
    {
        try {
            // Charger le profil CV avec toutes ses relations (similaire à CvController)
            $cvProfile = $etudiant->cvProfile()->with([
                'etudiant',
                'formations' => fn($query) => $query->orderBy('annee_debut', 'desc'),
                'experiences' => fn($query) => $query->orderBy('date_debut', 'desc'),
                'competences' => fn($query) => $query->orderBy('categorie')->orderBy('order', 'asc'),
                'langues' => fn($query) => $query->orderBy('order', 'asc'),
                'centresInteret' => fn($query) => $query->orderBy('order', 'asc'),
                'certifications' => fn($query) => $query->orderBy('annee', 'desc')->orderBy('order', 'asc'),
                'projets' => fn($query) => $query->orderBy('order', 'asc'),
                'references' => fn($query) => $query->orderBy('order', 'asc')
            ])->first();

            $nom_complet = $etudiant->nom . ' ' . $etudiant->prenom;

            // Si l'étudiant n'a pas encore de profil CV (cas rare mais possible)
            if (!$cvProfile) {
                // Option 1: Rediriger avec un message
                // return redirect()->route('admin.etudiants.index')->with('warning', 'Cet étudiant n\'a pas encore créé son profil CV.');
                
                // Option 2: Créer un profil vide à la volée (peut être moins souhaitable)
                 $cvProfile = $etudiant->cvProfile()->create([]); // Crée un profil minimal
                 $cvProfile->load('etudiant'); // Recharger avec l'étudiant
                 Log::info("Profil CV créé à la volée pour l'étudiant ID {$etudiant->id} par l'admin.");
                 // Ou créer un objet vide pour le template
                 // $cvProfile = new \App\Models\CvProfile(); 
                 // $cvProfile->etudiant = $etudiant; // Assigner l'étudiant manuellement
            }
            
            // Vérifier si le template CV existe
            if (!view()->exists('etudiants.cv.templates.default')) {
                Log::error("Le template CV 'etudiants.cv.templates.default' est introuvable pour l'admin.");
                abort(500, "Erreur de configuration du template CV.");
            }

            Log::info("Admin visualise les détails de l'étudiant ID: {$etudiant->id}, Profile ID: {$cvProfile->id}");

            // Passer le $cvProfile (potentiellement créé à la volée ou existant) à la vue
            return view('admin.etudiants.show', compact('cvProfile', 'etudiant', 'nom_complet'));

        } catch (\Exception $e) {
            Log::error("Erreur admin lors de la visualisation des détails de l'étudiant ID {$etudiant->id}: " . $e->getMessage(), ['exception' => $e]);
            // Rediriger vers une page d'erreur admin ou la liste des étudiants
            return redirect()->route('admin.dashboard') // Ou admin.etudiants.index si elle existe
                      ->with('error', 'Impossible d\'afficher les détails de cet étudiant : ' . $e->getMessage());
        }
    }


// Dans votre EtudiantController, ajoutez ces méthodes :

/**
 * Retourner tous les étudiants (pour le filtrage dynamique)
 */
public function getAllStudents(Request $request)
{
    try {
        // Récupérer tous les étudiants avec leurs relations si nécessaire
        $etudiants = Etudiant::select([
            'id', 'nom', 'prenom', 'telephone', 'niveau', 
            'formation', 'statut', 'created_at', 'updated_at'
        ])
        ->orderBy('created_at', 'desc')
        ->get()
        ->map(function ($etudiant) {
            return [
                'id' => $etudiant->id,
                'nom' => $etudiant->nom,
                'prenom' => $etudiant->prenom,
                'telephone' => $etudiant->telephone,
                'niveau' => $etudiant->niveau,
                'formation' => $etudiant->formation,
                'statut' => $etudiant->statut,
                'created_at' => $etudiant->created_at->toISOString(),
                'updated_at' => $etudiant->updated_at->toISOString(),
            ];
        });

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'students' => $etudiants,
                'total' => $etudiants->count()
            ]);
        }

        return response()->json(['students' => $etudiants]);
        
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Erreur lors de la récupération des étudiants',
            'error' => $e->getMessage()
        ], 500);
    }
}

/**
 * Index principal avec support pour "tous les étudiants"
 */


/**
 * Changer le statut d'un étudiant (AJAX)
 */
public function toggleStatus(Request $request, $id)
{
    try {
        $etudiant = Etudiant::findOrFail($id);
        $etudiant->statut = $etudiant->statut == 1 ? 0 : 1;
        $etudiant->save();

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Statut mis à jour avec succès',
                'new_status' => $etudiant->statut
            ]);
        }

        return redirect()->back()->with('success', 'Statut mis à jour avec succès');
        
    } catch (\Exception $e) {
        if ($request->ajax()) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la mise à jour du statut'
            ], 500);
        }

        return redirect()->back()->with('error', 'Erreur lors de la mise à jour du statut');
    }
}

/**
 * Supprimer un étudiant (AJAX)
 */
public function destroy(Request $request, $id)
{
    try {
        $etudiant = Etudiant::findOrFail($id);
        $etudiant->delete();

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Étudiant supprimé avec succès'
            ]);
        }

        return redirect()->back()->with('success', 'Étudiant supprimé avec succès');
        
    } catch (\Exception $e) {
        if ($request->ajax()) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la suppression'
            ], 500);
        }

        return redirect()->back()->with('error', 'Erreur lors de la suppression');
    }
}

/**
 * Recherche d'étudiants (AJAX)
 */
public function search(Request $request)
{
    $query = $request->get('q', '');
    $filters = $request->only(['niveau', 'formation', 'statut', 'date_filter', 'date_from', 'date_to']);
    
    $etudiants = Etudiant::query();
    
    // Recherche globale
    if (!empty($query)) {
        $etudiants->where(function($q) use ($query) {
            $q->where('nom', 'LIKE', "%{$query}%")
              ->orWhere('prenom', 'LIKE', "%{$query}%")
              ->orWhere('telephone', 'LIKE', "%{$query}%")
              ->orWhere('niveau', 'LIKE', "%{$query}%")
              ->orWhere('formation', 'LIKE', "%{$query}%");
        });
    }
    
    // Filtres
    if (!empty($filters['niveau'])) {
        $etudiants->where('niveau', $filters['niveau']);
    }
    
    if (!empty($filters['formation'])) {
        $etudiants->where('formation', $filters['formation']);
    }
    
    if (isset($filters['statut']) && $filters['statut'] !== '') {
        $etudiants->where('statut', $filters['statut']);
    }
    
    // Filtres de date
    if (!empty($filters['date_filter'])) {
        switch ($filters['date_filter']) {
            case 'today':
                $etudiants->whereDate('created_at', now()->toDateString());
                break;
            case 'yesterday':
                $etudiants->whereDate('created_at', now()->subDay()->toDateString());
                break;
            case 'week':
                $etudiants->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
                break;
            case 'last_week':
                $start = now()->subWeek()->startOfWeek();
                $end = now()->subWeek()->endOfWeek();
                $etudiants->whereBetween('created_at', [$start, $end]);
                break;
            case 'month':
                $etudiants->whereBetween('created_at', [now()->startOfMonth(), now()->endOfMonth()]);
                break;
            case 'last_month':
                $start = now()->subMonth()->startOfMonth();
                $end = now()->subMonth()->endOfMonth();
                $etudiants->whereBetween('created_at', [$start, $end]);
                break;
            case 'year':
                $etudiants->whereYear('created_at', now()->year);
                break;
            case 'custom':
                if (!empty($filters['date_from']) && !empty($filters['date_to'])) {
                    $etudiants->whereBetween('created_at', [
                        $filters['date_from'] . ' 00:00:00',
                        $filters['date_to'] . ' 23:59:59'
                    ]);
                }
                break;
        }
    }
    
    $results = $etudiants->orderBy('created_at', 'desc')->get();
    
    return response()->json([
        'success' => true,
        'students' => $results->map(function ($etudiant) {
            return [
                'id' => $etudiant->id,
                'nom' => $etudiant->nom,
                'prenom' => $etudiant->prenom,
                'telephone' => $etudiant->telephone,
                'niveau' => $etudiant->niveau,
                'formation' => $etudiant->formation,
                'statut' => $etudiant->statut,
                'created_at' => $etudiant->created_at->toISOString(),
            ];
        }),
        'total' => $results->count()
    ]);

}}
