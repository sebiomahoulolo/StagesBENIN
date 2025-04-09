<?php

namespace App\Http\Controllers\Etudiant;

use App\Http\Controllers\Controller;
use App\Models\CvProfile; // Ensure this model exists in the App\Models namespace
use App\Models\Etudiant; // Assurez-vous du namespace
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator; // Pour validation plus fine si besoin
use Barryvdh\DomPDF\Facade\Pdf; // Pour l'export PDF
use Illuminate\Support\Str; // Pour les fonctions de manipulation de chaînes

class CvController extends Controller
{
    // Middleware pour s'assurer que seul l'étudiant connecté accède
    public function __construct()
    {
        // Applique le middleware auth sur toutes les méthodes
        // Vous pourriez avoir un middleware spécifique 'isEtudiant'
        $this->middleware('auth');
        // Vous pourriez ajouter un middleware pour vérifier le rôle 'etudiant' ici
        // $this->middleware('role:etudiant');
    }

    // Méthode pour afficher le formulaire d'édition/création
    public function edit()
    {
        $etudiantId = Auth::id(); // Ou la clé primaire de votre modèle Etudiant si différent
        $etudiant = Etudiant::findOrFail($etudiantId); // Récupère l'étudiant connecté

        // Trouve ou crée le profil CV pour cet étudiant
        $cvProfile = CvProfile::with([
            'formations', 'experiences', 'competences', 'langues',
            'centresInteret', 'certifications', 'projets'
        ])->firstOrCreate(
            ['etudiant_id' => $etudiant->id]
            // Vous pouvez ajouter des valeurs par défaut ici si 'firstOrCreate' le crée
            // ['titre_profil' => 'Mon Profil Professionnel']
        );

        // Préparer les données pour le JS (facilite le travail côté client)
        $cvData = [
            'profile' => $cvProfile->toArray(), // Convertit le modèle et ses relations chargées en tableau
            // Ajouter d'autres infos si nécessaire
            'etudiant' => [
                'nom' => $etudiant->nom,
                'prenom' => $etudiant->prenom,
                'email' => $etudiant->email,
                'telephone' => $etudiant->telephone,
                'photo_path' => $etudiant->photo_path ? asset($etudiant->photo_path) : 'https://via.placeholder.com/150/e0e0e0/333?text=Photo',
            ]
        ];

        // Charger la vue d'édition avec les données
        return view('etudiants.cv.edit', compact('cvProfile', 'cvData'));
    }

    // Méthode pour sauvegarder les modifications du CV
    public function update(Request $request)
    {
        $etudiantId = Auth::id();
        $cvProfile = CvProfile::where('etudiant_id', $etudiantId)->firstOrFail();

        // Validation (Simplifiée - utilisez une Form Request pour une meilleure pratique)
        $validatedData = $request->validate([
            'profile.titre_profil' => 'nullable|string|max:255',
            'profile.resume_profil' => 'nullable|string',
            'profile.adresse' => 'nullable|string|max:255',
            'profile.telephone_cv' => 'nullable|string|max:20',
            'profile.email_cv' => 'nullable|email|max:255',
            'profile.linkedin_url' => 'nullable|url|max:255',
            'profile.portfolio_url' => 'nullable|url|max:255',

            // Validation pour les éléments répétables (arrays)
            'formations' => 'nullable|array',
            'formations.*.id' => 'nullable|integer|exists:cv_formations,id,cv_profile_id,'.$cvProfile->id, // Vérifie que l'ID existe et appartient à ce profil
            'formations.*.diplome' => 'required|string|max:255',
            'formations.*.etablissement' => 'required|string|max:255',
            'formations.*.ville' => 'nullable|string|max:255',
            'formations.*.annee_debut' => 'required|integer|digits:4',
            'formations.*.annee_fin' => 'nullable|integer|digits:4|gte:formations.*.annee_debut',
            'formations.*.description' => 'nullable|string',

            'experiences' => 'nullable|array',
            'experiences.*.id' => 'nullable|integer|exists:cv_experiences,id,cv_profile_id,'.$cvProfile->id,
            'experiences.*.poste' => 'required|string|max:255',
            'experiences.*.entreprise' => 'required|string|max:255',
            'experiences.*.ville' => 'nullable|string|max:255',
            'experiences.*.date_debut' => 'required|date',
            'experiences.*.date_fin' => 'nullable|date|after_or_equal:experiences.*.date_debut',
            'experiences.*.description' => 'nullable|string',
            'experiences.*.taches_realisations' => 'nullable|string',

            'competences' => 'nullable|array',
            'competences.*.id' => 'nullable|integer|exists:cv_competences,id,cv_profile_id,'.$cvProfile->id,
            'competences.*.categorie' => 'required|string|max:255',
            'competences.*.nom' => 'required|string|max:255',
            'competences.*.niveau' => 'required|integer|min:0|max:100',

            'langues' => 'nullable|array',
            'langues.*.id' => 'nullable|integer|exists:cv_langues,id,cv_profile_id,'.$cvProfile->id,
            'langues.*.langue' => 'required|string|max:100',
            'langues.*.niveau' => 'required|string|max:100', // Ex: Natif, Courant...

            'centres_interet' => 'nullable|array',
            'centres_interet.*.id' => 'nullable|integer|exists:cv_centres_interet,id,cv_profile_id,'.$cvProfile->id,
            'centres_interet.*.nom' => 'required|string|max:100',

            'certifications' => 'nullable|array',
            'certifications.*.id' => 'nullable|integer|exists:cv_certifications,id,cv_profile_id,'.$cvProfile->id,
            'certifications.*.nom' => 'required|string|max:255',
            'certifications.*.organisme' => 'required|string|max:255',
            'certifications.*.annee' => 'nullable|integer|digits:4',
            'certifications.*.url_validation' => 'nullable|url|max:255',

            'projets' => 'nullable|array',
            'projets.*.id' => 'nullable|integer|exists:cv_projets,id,cv_profile_id,'.$cvProfile->id,
            'projets.*.nom' => 'required|string|max:255',
            'projets.*.url_projet' => 'nullable|url|max:255',
            'projets.*.description' => 'nullable|string',
            'projets.*.technologies' => 'nullable|string|max:255',
        ]);

        DB::beginTransaction();
        try {
            // 1. Mettre à jour le profil principal
            $cvProfile->update($validatedData['profile']);

            // 2. Gérer les sections (Ajout/Modification/Suppression)
            $this->syncSection($cvProfile, 'formations', $request->input('formations', []));
            $this->syncSection($cvProfile, 'experiences', $request->input('experiences', []));
            $this->syncSection($cvProfile, 'competences', $request->input('competences', []));
            $this->syncSection($cvProfile, 'langues', $request->input('langues', []));
            $this->syncSection($cvProfile, 'centresInteret', $request->input('centres_interet', [])); // Nom de la relation
            $this->syncSection($cvProfile, 'certifications', $request->input('certifications', []));
            $this->syncSection($cvProfile, 'projets', $request->input('projets', []));

            DB::commit();

            return redirect()->route('etudiants.cv.edit')->with('success', 'CV mis à jour avec succès !');

        } catch (\Exception $e) {
            DB::rollBack();
            // Log l'erreur : Log::error($e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Erreur lors de la mise à jour du CV. Détails: ' . $e->getMessage());
        }
    }

    // Fonction helper pour synchroniser les sections (formations, experiences, etc.)
    private function syncSection(CvProfile $cvProfile, string $relationName, array $itemsData)
    {
        $existingIds = $cvProfile->$relationName()->pluck('id')->toArray();
        $submittedIds = collect($itemsData)->pluck('id')->filter()->toArray(); // Prend les IDs non null

        // 1. Supprimer les éléments qui ne sont plus dans la requête
        $idsToDelete = array_diff($existingIds, $submittedIds);
        if (!empty($idsToDelete)) {
            $cvProfile->$relationName()->whereIn('id', $idsToDelete)->delete();
        }

        // 2. Mettre à jour ou Créer les éléments
        foreach ($itemsData as $index => $itemData) {
            $itemData['order'] = $index + 1; // Assigner l'ordre basé sur l'index
            if (isset($itemData['id']) && in_array($itemData['id'], $existingIds)) {
                // Mettre à jour l'élément existant
                $item = $cvProfile->$relationName()->find($itemData['id']);
                if ($item) {
                    $item->update($itemData);
                }
            } else {
                // Créer un nouvel élément
                // Assurez-vous que les clés non désirées comme 'id' (s'il est null/vide) sont retirées
                unset($itemData['id']);
                $cvProfile->$relationName()->create($itemData);
            }
        }
    }

     // Méthode pour afficher la prévisualisation (utilisée par le JS et le PDF)
     public function preview(Request $request)
     {
         $etudiantId = Auth::id();
         $cvProfile = CvProfile::with([
             'etudiant', // Charger l'étudiant lié
             'formations', 'experiences', 'competences', 'langues',
             'centresInteret', 'certifications', 'projets'
         ])->where('etudiant_id', $etudiantId)->firstOrFail();

         // Retourne la vue du template de CV remplie avec les données
         return view('etudiants.cv.templates.default', compact('cvProfile')); // Assurez-vous que le chemin est correct
     }


    // Méthode pour exporter le CV en PDF
    public function exportPdf()
    {
        $etudiantId = Auth::id();
        $cvProfile = CvProfile::with([
            'etudiant', 'formations', 'experiences', 'competences', 'langues',
            'centresInteret', 'certifications', 'projets'
        ])->where('etudiant_id', $etudiantId)->firstOrFail();

        // Charger la vue du template avec les données
        $html = view('etudiants.cv.templates.default', compact('cvProfile'))->render();

        // Charger le HTML dans DomPDF
        $pdf = Pdf::loadHTML($html);

        // Optionnel : Définir la taille du papier, l'orientation, etc.
        $pdf->setPaper('a4', 'portrait');

        // Générer le nom du fichier
        $filename = 'CV_' . Str::slug($cvProfile->etudiant->prenom . '_' . $cvProfile->etudiant->nom) . '.pdf';

        // Retourner le PDF pour téléchargement
        return $pdf->download($filename);

        // Ou pour l'afficher dans le navigateur :
        // return $pdf->stream($filename);
    }


    // --- Les méthodes show, create, destroy, index ne sont pas utilisées ici ---
    public function index() { abort(404); }
    public function create() { abort(404); }
    public function show(CvProfile $cvProfile) { abort(404); } // Pourrait servir à une vue publique plus tard
    public function destroy(CvProfile $cvProfile) { abort(404); } // Pas de suppression directe ici
}