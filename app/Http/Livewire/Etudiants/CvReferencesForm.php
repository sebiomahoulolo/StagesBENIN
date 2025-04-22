<?php
namespace App\Http\Livewire\Etudiants;

use Livewire\Component;
use App\Models\CvProfile;
use App\Models\CvReference;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;

class CvReferencesForm extends Component
{
    public $cvProfileId;
    public Collection $references;
    public $newReference = [];

    public bool $showAddForm = false;
    public ?int $editingIndex = null;
    public array $editingReference = [];

    public function mount($cvProfileId)
    {
        $this->cvProfileId = $cvProfileId;
        $this->loadReferences();
        $this->resetForms();
    }

    public function loadReferences()
    {
        $profile = CvProfile::find($this->cvProfileId);
        if (!$profile) abort(404);
        $this->authorizeInteraction($profile);

        $this->references = $profile->references()
                                    ->orderBy('order', 'asc')
                                    ->get()
                                    ->map(fn ($item) => $item->toArray());
    }

    private function authorizeInteraction(CvProfile $profile)
    {
        if ($profile->etudiant_id !== Auth::user()->etudiant?->id) {
            abort(403, 'Action non autorisée.');
        }
    }

    public function resetForms()
    {
        $this->newReference = ['nom' => '', 'prenom' => '', 'contact' => '', 'poste' => '', 'relation' => ''];
        $this->editingReference = ['nom' => '', 'prenom' => '', 'contact' => '', 'poste' => '', 'relation' => ''];
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
        if (!isset($this->references[$index])) {
            session()->flash('reference_error', 'Référence introuvable.');
            return;
        }
        $this->resetValidation();
        $this->editingIndex = $index;
        $this->editingReference = $this->references[$index];
        $this->showAddForm = false;
    }

    public function cancelEdit()
    {
        $this->resetForms();
    }

    protected function rules()
    {
        $rulesBase = [
            'nom' => 'required|string|max:100',
            'prenom' => 'required|string|max:100',
            'contact' => 'required|string|max:255', // Peut être email ou téléphone
            'poste' => 'nullable|string|max:100',
            'relation' => 'nullable|string|max:255',
        ];

        $prefix = $this->editingIndex !== null ? 'editingReference.' : 'newReference.';
        return collect($rulesBase)->mapWithKeys(fn ($rule, $key) => [$prefix . $key => $rule])->toArray();
    }

    protected function messages()
    {
        $prefix = $this->editingIndex !== null ? 'editingReference.' : 'newReference.';
        return [
            $prefix . 'nom.required' => 'Le nom est requis.',
            $prefix . 'prenom.required' => 'Le prénom est requis.',
            $prefix . 'contact.required' => 'Le contact (email/tél) est requis.',
        ];
    }

    public function updateReference()
    {
        if ($this->editingIndex === null) return;
        $validatedData = $this->validate($this->rules())['editingReference'];
        $referenceId = $this->references[$this->editingIndex]['id'] ?? null;

        if ($referenceId) {
            $reference = CvReference::where('cv_profile_id', $this->cvProfileId)->find($referenceId);
            if ($reference) {
                $reference->update($validatedData);
                $this->loadReferences();
                $this->resetForms();
                session()->flash('reference_message', 'Référence mise à jour.');
            } else {
                session()->flash('reference_error_' . $this->editingIndex, 'Erreur: Référence non trouvée.');
            }
        } else {
            session()->flash('reference_error_' . $this->editingIndex, 'Erreur: ID de référence manquant.');
        }
    }

    public function addReference()
    {
        $validatedData = $this->validate($this->rules())['newReference'];
        CvReference::create(['cv_profile_id' => $this->cvProfileId, ...$validatedData]);
        $this->loadReferences();
        $this->resetForms();
        session()->flash('reference_message', 'Référence ajoutée.');
    }

    public function removeReference($index)
    {
        $referenceId = $this->references[$index]['id'] ?? null;
        if ($referenceId) {
            $reference = CvReference::where('cv_profile_id', $this->cvProfileId)->find($referenceId);
            if ($reference) $reference->delete();
        }
        $this->loadReferences();
        if ($this->editingIndex === $index) {
            $this->cancelEdit();
        }
        session()->flash('reference_message', 'Référence supprimée.');
    }

    public function render()
    {
        return view('livewire.etudiants.cv-references-form');
    }
} 