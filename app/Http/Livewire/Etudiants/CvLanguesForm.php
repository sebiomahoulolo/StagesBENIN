<?php

namespace App\Http\Livewire\Etudiants; // Ou App\Livewire\Etudiants;

use Livewire\Component;
use App\Models\CvProfile;
use App\Models\CvLangue;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;
use Illuminate\Validation\Rule;

class CvLanguesForm extends Component
{
    public $cvProfileId;
    public Collection $langues;
    public $newLangue = [];

    public bool $showAddForm = false;
    public ?int $editingIndex = null;
    public array $editingLangue = [];

    public $niveauOptions = [
        'Natif' => 'Natif', 'Courant' => 'Courant (C1/C2)',
        'Intermédiaire' => 'Intermédiaire (B1/B2)', 'Débutant' => 'Débutant (A1/A2)',
        'Notions' => 'Notions',
    ];

    public function mount($cvProfileId)
    {
        $this->cvProfileId = $cvProfileId;
        $this->loadLangues();
        $this->resetForms();
    }

     public function loadLangues()
    {
        $profile = CvProfile::find($this->cvProfileId);
        if (!$profile) abort(404);
        $this->authorizeInteraction($profile);

        $this->langues = $profile->langues()
                                ->orderBy('order', 'asc') // ou 'langue'
                                ->get()
                                ->map(fn ($item) => $item->toArray());
    }

     private function authorizeInteraction(CvProfile $profile) {
         if ($profile->etudiant_id !== Auth::user()->etudiant?->id) {
             abort(403, 'Action non autorisée.');
         }
    }

    public function resetForms() {
        $this->newLangue = ['langue' => '', 'niveau' => ''];
        $this->editingLangue = ['langue' => '', 'niveau' => ''];
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
        $this->editingLangue = $this->langues[$index];
        $this->showAddForm = false;
    }

    public function cancelEdit()
    {
        $this->resetForms();
    }

    protected function rules()
    {
        $niveauRule = ['required', 'string', Rule::in(array_keys($this->niveauOptions))];
        $rulesBase = ['langue' => 'required|string|max:100', 'niveau' => $niveauRule];

        if ($this->editingIndex !== null) {
            return collect($rulesBase)->mapWithKeys(fn($rule, $key) => ["editingLangue.{$key}" => $rule])->toArray();
        } else {
            return collect($rulesBase)->mapWithKeys(fn($rule, $key) => ["newLangue.{$key}" => $rule])->toArray();
        }
    }

    protected function messages() {
        $prefix = ($this->editingIndex !== null) ? 'editingLangue.' : 'newLangue.';
        return [
            $prefix.'langue.required' => 'La langue est requise.',
            $prefix.'niveau.required' => 'Le niveau est requis.',
            $prefix.'niveau.in' => 'Le niveau sélectionné est invalide.',
        ];
    }

     public function updateLangue()
    {
        if ($this->editingIndex === null) return;
        $validatedData = $this->validate($this->rules())['editingLangue'];
        $langueId = $this->langues[$this->editingIndex]['id'] ?? null;

        if ($langueId) {
            $langue = CvLangue::where('cv_profile_id', $this->cvProfileId)->find($langueId);
            if ($langue) {
                 $langue->update($validatedData);
                 $this->loadLangues();
                 $this->resetForms();
                 session()->flash('langue_message', 'Langue mise à jour.');
            } else { session()->flash('langue_error', 'Erreur: Langue non trouvée.'); }
        } else { session()->flash('langue_error', 'Erreur: ID de langue manquant.'); }
    }

    public function addLangue()
    {
        $validatedData = $this->validate($this->rules())['newLangue'];
        CvLangue::create(['cv_profile_id' => $this->cvProfileId, ...$validatedData]);
        $this->loadLangues();
        $this->resetForms();
        session()->flash('langue_message', 'Langue ajoutée.');
    }

    public function removeLangue($index)
    {
        $langueId = $this->langues[$index]['id'] ?? null;
        if ($langueId) {
             $langue = CvLangue::where('cv_profile_id', $this->cvProfileId)->find($langueId);
             if ($langue) $langue->delete();
        }
        $this->loadLangues();
        if ($this->editingIndex === $index) {
            $this->cancelEdit();
        }
        session()->flash('langue_message', 'Langue supprimée.');
    }

    public function render()
    {
        return view('livewire.etudiants.cv-langues-form');
    }
}