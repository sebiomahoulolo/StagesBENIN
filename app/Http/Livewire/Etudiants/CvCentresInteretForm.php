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
        $rulesBase = ['nom' => 'required|string|max:100'];

        if ($this->editingIndex !== null) {
            return collect($rulesBase)->mapWithKeys(fn($rule, $key) => ["editingInteret.{$key}" => $rule])->toArray();
        } else {
            return collect($rulesBase)->mapWithKeys(fn($rule, $key) => ["newInteret.{$key}" => $rule])->toArray();
        }
    }

    protected function messages() {
        $prefix = ($this->editingIndex !== null) ? 'editingInteret.' : 'newInteret.';
        return [$prefix.'nom.required' => 'Le nom de l\'intérêt est requis.'];
    }

    public function updateInteret()
    {
        if ($this->editingIndex === null) return;
        $validatedData = $this->validate($this->rules())['editingInteret'];
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