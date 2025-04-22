<?php

namespace App\Http\Livewire\Etudiants; // Ou App\Livewire\Etudiants;

use Livewire\Component;
use App\Models\CvProfile;
use App\Models\CvFormation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;
// Supprimer : use Mews\Purifier\Facades\Purifier;

class CvFormationsForm extends Component
{
    public $cvProfileId;
    public Collection $formations;
    public $newFormation = []; // Initialisé dans resetForms

    public bool $showAddForm = false;
    public ?int $editingIndex = null;
    public array $editingFormation = []; // Initialisé dans resetForms

    public function mount($cvProfileId)
    {
        $this->cvProfileId = $cvProfileId;
        $this->loadFormations();
        $this->resetForms(); // Initialise les tableaux ici
    }

    public function loadFormations()
    {
        $profile = CvProfile::findOrFail($this->cvProfileId); // findOrFail est plus direct
        $this->authorizeInteraction($profile);
        // Charger les formations, s'assurer que 'description' est bien récupérée
        $this->formations = $profile->formations()
                                    ->orderBy('annee_debut', 'desc') // Trier par année début (ou 'order' si vous l'avez)
                                    ->get()
                                    ->map(fn ($item) => $item->toArray());
    }

    private function authorizeInteraction(CvProfile $profile) {
         if ($profile->etudiant_id !== Auth::user()->etudiant?->id) {
             abort(403, 'Action non autorisée.');
         }
    }

    // Réinitialise les formulaires et l'état d'édition
    public function resetForms() {
        // Assure que tous les champs attendus sont présents, y compris description
        $this->newFormation = ['diplome' => '', 'etablissement' => '', 'ville' => '', 'annee_debut' => '', 'annee_fin' => null, 'description' => ''];
        $this->editingFormation = ['diplome' => '', 'etablissement' => '', 'ville' => '', 'annee_debut' => '', 'annee_fin' => null, 'description' => ''];
        $this->editingIndex = null;
        $this->showAddForm = false;
        $this->resetValidation(); // Réinitialise les erreurs de validation
    }

    public function toggleAddForm()
    {
        // Si on ouvre l'ajout alors qu'on éditait, on annule l'édition
        if (!$this->showAddForm && $this->editingIndex !== null) {
             $this->cancelEdit();
        }
        $this->showAddForm = !$this->showAddForm;
        $this->resetValidation(); // Toujours reset la validation en changeant d'état
    }

    public function edit($index)
    {
        if(!isset($this->formations[$index])) {
            session()->flash('formation_error', 'Erreur : Formation introuvable.');
            return;
        }
        $this->resetValidation();
        $this->editingIndex = $index;
        // Assurez-vous que la description est bien copiée
        $this->editingFormation = $this->formations[$index];
        $this->showAddForm = false; // Ferme le formulaire d'ajout si ouvert
    }

    public function cancelEdit()
    {
        $this->resetForms(); // Appelle la fonction centralisée de reset
    }

    // Règles de validation (la règle pour 'description' est correcte)
    protected function rules()
    {
        $rulesBase = [
            'diplome' => 'required|string|max:255',
            'etablissement' => 'required|string|max:255',
            'ville' => 'nullable|string|max:100',
            'annee_debut' => 'required|integer|min:1950|max:'.(date('Y') + 2),
            'annee_fin' => 'nullable|integer|min:1950|max:'.(date('Y') + 5).'|gte:annee_debut',
            'description' => 'nullable|string|max:1000', // OK pour textarea
        ];

        if ($this->editingIndex !== null) {
            // Ajuste la règle gte pour pointer vers la bonne année de début lors de l'édition
            $rulesBase['annee_fin'] = 'nullable|integer|min:1950|max:'.(date('Y') + 5).'|gte:editingFormation.annee_debut';
            // Préfixe les clés avec 'editingFormation.'
            return collect($rulesBase)->mapWithKeys(fn($rule, $key) => ["editingFormation.{$key}" => $rule])->toArray();
        } else {
             // Ajuste la règle gte pour pointer vers la bonne année de début lors de l'ajout
            $rulesBase['annee_fin'] = 'nullable|integer|min:1950|max:'.(date('Y') + 5).'|gte:newFormation.annee_debut';
            // Préfixe les clés avec 'newFormation.'
            return collect($rulesBase)->mapWithKeys(fn($rule, $key) => ["newFormation.{$key}" => $rule])->toArray();
        }
    }

    // Messages d'erreur personnalisés
    protected function messages() {
         $prefix = ($this->editingIndex !== null) ? 'editingFormation.' : 'newFormation.';
         return [
             $prefix.'diplome.required' => 'Le diplôme est requis.',
             $prefix.'etablissement.required' => 'L\'établissement est requis.',
             $prefix.'annee_debut.required' => 'L\'année de début est requise.',
             $prefix.'annee_fin.gte' => 'L\'année de fin doit être supérieure ou égale à l\'année de début.',
             $prefix.'description.max' => 'La description ne doit pas dépasser 1000 caractères.'
         ];
     }

     // Met à jour une formation existante
     public function updateFormation()
     {
         if ($this->editingIndex === null || !isset($this->formations[$this->editingIndex])) return;

         // Valide les données préfixées 'editingFormation.'
         $validatedData = $this->validate($this->rules())['editingFormation'];
         $formationId = $this->formations[$this->editingIndex]['id']; // ID de la formation à éditer

         $formation = CvFormation::where('cv_profile_id', $this->cvProfileId)->find($formationId);
         if ($formation) {
             // Met à jour directement avec les données validées (description est une string)
             $formation->update($validatedData);
             $this->loadFormations(); // Recharge les données
             $this->resetForms(); // Réinitialise l'état
             session()->flash('formation_message', 'Formation mise à jour avec succès.');
         } else {
             session()->flash('formation_error_'.$this->editingIndex, 'Erreur lors de la mise à jour.'); // Erreur spécifique à l'item
         }
     }

     // Ajoute une nouvelle formation
     public function addFormation()
     {
         // Valide les données préfixées 'newFormation.'
         $validatedData = $this->validate($this->rules())['newFormation'];

         // Crée la formation (description est une string)
         CvFormation::create([
             'cv_profile_id' => $this->cvProfileId,
             ...$validatedData // Utilise l'opérateur spread
         ]);

         $this->loadFormations(); // Recharge les données
         $this->resetForms(); // Réinitialise l'état
         session()->flash('formation_message', 'Formation ajoutée avec succès.');
     }

    // Supprime une formation
    public function removeFormation($index)
    {
        if (!isset($this->formations[$index])) return; // Vérification supplémentaire

        $formationId = $this->formations[$index]['id'];
        $formation = CvFormation::where('cv_profile_id', $this->cvProfileId)->find($formationId);

        if ($formation) {
            $formation->delete();
            $this->loadFormations(); // Recharge après suppression
             // Si on supprime l'item qu'on était en train d'éditer, on reset
            if ($this->editingIndex === $index) {
                $this->cancelEdit();
            }
            session()->flash('formation_message', 'Formation supprimée.');
        } else {
             session()->flash('formation_error', 'Erreur : Impossible de supprimer la formation.');
        }
    }

    public function render()
    {
        return view('livewire.etudiants.cv-formations-form');
    }
}