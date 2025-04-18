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

    private function rules()
    {
        return [
            'newInteret.nom' => ['required', 'string', 'max:50'],
            'newInteret.order' => ['sometimes', 'integer'],
            'editInteret.nom' => ['required', 'string', 'max:50'],
            'editInteret.order' => ['sometimes', 'integer'],
        ];
    }

    protected function messages()
    {
        return [
            'newInteret.nom.required' => 'Le nom est requis.',
            'newInteret.nom.max' => 'Le nom ne doit pas dépasser 50 caractères.',
            'editInteret.nom.required' => 'Le nom est requis.',
            'editInteret.nom.max' => 'Le nom ne doit pas dépasser 50 caractères.',
        ];
    }

    public function updateInteret()
    {
        if ($this->editingIndex === null) return;
        $validatedData = $this->validate([
            'editingInteret.nom' => ['required', 'string', 'max:50'],
        ])['editingInteret'];
        $interetId = $this->centresInteret[$this->editingIndex]['id'] ?? null;

        if ($interetId) {
            $interet = CvCentreInteret::where('cv_profile_id', $this->cvProfileId)->find($interetId);
            if ($interet) {
                 $interet->update($validatedData);
                 $this->loadCentresInteret();
                 $this->resetForms();
                 session()->flash('interet_message', 'Centre d\'intérêt mis à jour.');
            } else { session()->flash('interet_error', 'Erreur: Centre d\'intérêt non trouvé.'); }
        } else { session()->flash('interet_error', 'Erreur: ID de centre d\'intérêt manquant.'); }
    }

    public function addInteret()
    {
        // Vérifier si le nombre maximal de centres d'intérêt est atteint
        if ($this->centresInteret->count() >= 4) {
            session()->flash('interet_error', 'Vous avez atteint la limite maximale de 4 centres d\'intérêt.');
            return;
        }
        
        $validatedData = $this->validate($this->rules())['newInteret'];
        CvCentreInteret::create(['cv_profile_id' => $this->cvProfileId, ...$validatedData]);
        $this->loadCentresInteret();
        $this->resetForms();
        session()->flash('interet_message', 'Centre d\'intérêt ajouté.');
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