<?php

namespace App\Http\Livewire\Etudiants; // Ou App\Livewire\Etudiants;

use Livewire\Component;
use App\Models\CvProfile;
use App\Models\CvCentreInteret;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;
use Illuminate\Validation\Rule;

class CvCentresInteretForm extends Component
{
    public $cvProfileId;
    public Collection $centresInteret;
    public $newInteret = [];

    public bool $showAddForm = false;
    public ?int $editingIndex = null;
    public array $editingInteret = [];

    public function mount($cvProfileId)
    {
        $this->cvProfileId = $cvProfileId;
        $this->loadCentresInteret();
        $this->resetForms();
    }

     public function loadCentresInteret()
    {
        $profile = CvProfile::find($this->cvProfileId);
        if (!$profile) abort(404);
        $this->authorizeInteraction($profile);

        $this->centresInteret = $profile->centresInteret() // Assurez-vous que la relation s'appelle bien 'centresInteret'
                                            ->orderBy('order', 'asc')
                                            ->get()
                                            ->map(fn ($item) => $item->toArray());
    }

     private function authorizeInteraction(CvProfile $profile) {
         if ($profile->etudiant_id !== Auth::user()->etudiant?->id) {
             abort(403, 'Action non autorisée.');
         }
    }

    public function resetForms() {
        $this->newInteret = ['nom' => ''];
        $this->editingInteret = ['nom' => ''];
        $this->editingIndex = null;
        $this->showAddForm = false;
        $this->resetValidation();
    }

     public function toggleAddForm()
    {
        $this->resetValidation();
         if (!$this->showAddForm && $this->editingIndex !== null) {
             $this->cancelEdit();
         }
        
        // Vérifier si le nombre maximal de centres d'intérêt est atteint
        if ($this->centresInteret->count() >= 4 && !$this->showAddForm) {
            session()->flash('interet_error', 'Vous avez atteint la limite maximale de 4 centres d\'intérêt.');
            return;
        }
        
        $this->showAddForm = !$this->showAddForm;
    }

    public function edit($index)
    {
        $this->resetValidation();
        $this->editingIndex = $index;
        $this->editingInteret = $this->centresInteret[$index];
        $this->showAddForm = false;
    }

    public function cancelEdit()
    {
        $this->resetForms();
    }

    protected function rules()
    {
        return [
            'newInteret.nom' => ['required', 'string', 'max:50'],
            'newInteret.order' => ['sometimes', 'integer'],
            'editingInteret.nom' => ['required', 'string', 'max:50'],
            'editingInteret.order' => ['sometimes', 'integer'],
        ];
    }

    protected function messages()
    {
        return [
            'newInteret.nom.required' => 'Le nom est requis.',
            'newInteret.nom.max' => 'Le nom ne doit pas dépasser 50 caractères.',
            'editingInteret.nom.required' => 'Le nom est requis.',
            'editingInteret.nom.max' => 'Le nom ne doit pas dépasser 50 caractères.',
        ];
    }

    public function updateInteret()
    {
        if ($this->editingIndex === null) return;
        
        try {
            // Valider uniquement le champ requis
            $validated = $this->validate([
                'editingInteret.nom' => ['required', 'string', 'max:50'],
            ]);
            
            $interetId = $this->centresInteret[$this->editingIndex]['id'] ?? null;
    
            if ($interetId) {
                $interet = CvCentreInteret::where('cv_profile_id', $this->cvProfileId)->find($interetId);
                if ($interet) {
                    $interet->update([
                        'nom' => $validated['editingInteret']['nom']
                    ]);
                    $this->loadCentresInteret();
                    $this->resetForms();
                    session()->flash('interet_message', 'Centre d\'intérêt mis à jour avec succès.');
                } else { 
                    session()->flash('interet_error', 'Erreur: Centre d\'intérêt non trouvé.'); 
                }
            } else { 
                session()->flash('interet_error', 'Erreur: ID de centre d\'intérêt manquant.'); 
            }
        } catch (\Exception $e) {
            // Capturer et afficher l'erreur pour déboguer
            session()->flash('interet_error', 'Erreur lors de la mise à jour: ' . $e->getMessage());
        }
    }

    public function addInteret()
    {
        // Vérifier si le nombre maximal de centres d'intérêt est atteint
        if ($this->centresInteret->count() >= 4) {
            session()->flash('interet_error', 'Vous avez atteint la limite maximale de 4 centres d\'intérêt.');
            return;
        }
        
        try {
            // Valider uniquement le champ nécessaire sans passer par rules() qui contient trop de règles
            $validated = $this->validate([
                'newInteret.nom' => ['required', 'string', 'max:50'],
            ]);
            
            // Créer le centre d'intérêt avec des données explicites
            CvCentreInteret::create([
                'cv_profile_id' => $this->cvProfileId,
                'nom' => $validated['newInteret']['nom'],
                'order' => $this->centresInteret->count() + 1 // Attribuer un ordre basé sur le nombre actuel
            ]);
            
            // Recharger les données
            $this->loadCentresInteret();
            $this->resetForms();
            
            // Message de succès
            session()->flash('interet_message', 'Centre d\'intérêt ajouté avec succès.');
            
        } catch (\Exception $e) {
            // Capturer et afficher l'erreur pour déboguer
            session()->flash('interet_error', 'Erreur: ' . $e->getMessage());
        }
    }

    public function removeInteret($index)
    {
        $interetId = $this->centresInteret[$index]['id'] ?? null;
        if ($interetId) {
             $interet = CvCentreInteret::where('cv_profile_id', $this->cvProfileId)->find($interetId);
             if ($interet) $interet->delete();
        }
        $this->loadCentresInteret();
        if ($this->editingIndex === $index) {
            $this->cancelEdit();
        }
        session()->flash('interet_message', 'Centre d\'intérêt supprimé.');
    }

    public function render()
    {
        return view('livewire.etudiants.cv-centres-interet-form');
    }
}