<?php

namespace App\Http\Controllers\Entreprises;

use App\Http\Controllers\Controller;
use App\Models\DemandeEmploye;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log; // Ajout pour le débogage si besoin

class DemandeEmployeController extends Controller
{
    public function index()
    {
        // Assurez-vous que l'utilisateur est authentifié et a une entreprise associée
        if (!Auth::check() || !Auth::user()->entreprise) {
            // Redirigez ou affichez une erreur appropriée
            return redirect()->route('home')->with('error', 'Vous devez être connecté en tant qu\'entreprise pour voir cette page.');
        }

        $demandes = DemandeEmploye::where('entreprise_id', Auth::user()->entreprise->id)
            ->orderBy('created_at', 'desc')
            ->get();
        return view('entreprises.demandes.index', compact('demandes'));
    }

    public function create()
    {
        return view('entreprises.demandes.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'type_demande' => 'required|in:employe,stagiaire', // Les valeurs du formulaire
            'poste' => 'required|string|max:255',
            'nombre_postes' => 'required|integer|min:1',
            'niveau_etude' => 'required|string|max:255',
            'experience_requise' => 'required|string|max:255',
            'competences_requises' => 'required|string', // Sera un JSON string
            'description_poste' => 'required|string',
            'type_contrat' => 'required|string|max:255',
            'salaire_propose' => 'nullable|numeric|min:0',
            'lieu_travail' => 'required|string|max:255',
            'date_debut_souhaitee' => 'required|date|after_or_equal:today', // after_or_equal est plus permissif
            'avantages' => 'nullable|string',
            'domaine' => 'nullable|string|max:255', // Ajout de la validation pour domaine
        ]);

        // Assurez-vous que l'utilisateur est authentifié et a une entreprise associée
        if (!Auth::check() || !Auth::user()->entreprise) {
            return redirect()->back()->with('error', 'Action non autorisée.')->withInput();
        }

        // *** CORRECTION ICI: Mapper 'employe' à 'emploi' pour la base de données ***
        $dbType = ($validated['type_demande'] === 'employe') ? 'emploi' : 'stage';

        // Adapter les noms de champs à ceux du modèle
        $demandeData = [
            'entreprise_id' => Auth::user()->entreprise->id,
            'titre' => $validated['poste'],
            'description' => $validated['description_poste'],
            'type' => $dbType, // Utilisation de la valeur corrigée
            'domaine' => $validated['domaine'] ?? 'Non spécifié', // Utiliser la valeur validée
            'niveau_experience' => $validated['experience_requise'],
            'niveau_etude' => $validated['niveau_etude'],
            'competences_requises' => $validated['competences_requises'], // Le JSON string est OK pour la colonne TEXT
            'nombre_postes' => $validated['nombre_postes'],
            'salaire_min' => $validated['salaire_propose'],
            'type_contrat' => $validated['type_contrat'],
            'date_debut' => $validated['date_debut_souhaitee'],
            'lieu' => $validated['lieu_travail'],
            'statut' => 'en_attente',
            'est_active' => true
            // 'avantages' n'est pas dans le modèle DemandeEmploye, si vous voulez le stocker, ajoutez-le au modèle et à la migration.
        ];

        try {
            DemandeEmploye::create($demandeData);
        } catch (\Exception $e) {
            Log::error('Erreur lors de la création de la demande d\'employé: ' . $e->getMessage(), ['data' => $demandeData, 'exception' => $e]);
            return redirect()->back()
                ->with('error', 'Une erreur est survenue lors de la création de la demande. Veuillez réessayer. Détail: ' . $e->getMessage())
                ->withInput();
        }


        return redirect()->route('entreprises.demandes.index')
            ->with('success', 'Votre demande a été soumise avec succès et est en attente de validation.');
    }

    public function show(DemandeEmploye $demande)
    {
        // Assurez-vous que $demande existe et que l'utilisateur est autorisé
        // La Policy s'en charge si elle est bien configurée
        $this->authorize('view', $demande);
        return view('entreprises.demandes.show', compact('demande'));
    }

    public function edit(DemandeEmploye $demande)
    {
        $this->authorize('update', $demande);
        return view('entreprises.demandes.edit', compact('demande'));
    }

    public function update(Request $request, DemandeEmploye $demande)
    {
        $this->authorize('update', $demande);

        $validated = $request->validate([
            'type_demande' => 'required|in:employe,stagiaire',
            'poste' => 'required|string|max:255',
            'nombre_postes' => 'required|integer|min:1',
            'niveau_etude' => 'required|string|max:255',
            'experience_requise' => 'required|string|max:255',
            'competences_requises' => 'required|string',
            'description_poste' => 'required|string',
            'type_contrat' => 'required|string|max:255',
            'salaire_propose' => 'nullable|numeric|min:0',
            'lieu_travail' => 'required|string|max:255',
            'date_debut_souhaitee' => 'required|date|after_or_equal:today',
            'avantages' => 'nullable|string',
            'domaine' => 'nullable|string|max:255', // Ajout de la validation pour domaine
        ]);

        // *** CORRECTION ICI: Mapper 'employe' à 'emploi' pour la base de données ***
        $dbType = ($validated['type_demande'] === 'employe') ? 'emploi' : 'stage';

        // Adapter les noms de champs à ceux du modèle
        $demandeData = [
            'titre' => $validated['poste'],
            'description' => $validated['description_poste'],
            'type' => $dbType, // Utilisation de la valeur corrigée
            'domaine' => $validated['domaine'] ?? 'Non spécifié', // Utiliser la valeur validée
            'niveau_experience' => $validated['experience_requise'],
            'niveau_etude' => $validated['niveau_etude'],
            'competences_requises' => $validated['competences_requises'],
            'nombre_postes' => $validated['nombre_postes'],
            'salaire_min' => $validated['salaire_propose'],
            'type_contrat' => $validated['type_contrat'],
            'date_debut' => $validated['date_debut_souhaitee'],
            'lieu' => $validated['lieu_travail'],
            // 'avantages' n'est pas dans le modèle DemandeEmploye.
            // Le statut et est_active ne sont généralement pas modifiés par l'entreprise ici.
        ];

        try {
            $demande->update($demandeData);
        } catch (\Exception $e) {
            Log::error('Erreur lors de la mise à jour de la demande d\'employé: ' . $e->getMessage(), ['id' => $demande->id, 'data' => $demandeData, 'exception' => $e]);
            return redirect()->back()
                ->with('error', 'Une erreur est survenue lors de la mise à jour de la demande. Veuillez réessayer. Détail: ' . $e->getMessage())
                ->withInput();
        }

        return redirect()->route('entreprises.demandes.index')
            ->with('success', 'La demande a été mise à jour avec succès.');
    }

    public function destroy(DemandeEmploye $demande)
    {
        $this->authorize('delete', $demande);

        try {
            $demande->delete();
        } catch (\Exception $e) {
            Log::error('Erreur lors de la suppression de la demande d\'employé: ' . $e->getMessage(), ['id' => $demande->id, 'exception' => $e]);
            return redirect()->route('entreprises.demandes.index')
                ->with('error', 'Une erreur est survenue lors de la suppression de la demande. Veuillez réessayer. Détail: ' . $e->getMessage());
        }


        return redirect()->route('entreprises.demandes.index')
            ->with('success', 'La demande a été supprimée avec succès.');
    }
}