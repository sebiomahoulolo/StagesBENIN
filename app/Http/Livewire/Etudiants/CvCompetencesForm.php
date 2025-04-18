<?php

namespace App\Http\Livewire\Etudiants; // Ou App\Livewire\Etudiants;

use Livewire\Component;
use App\Models\CvProfile;
use App\Models\CvCompetence;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;
use Illuminate\Validation\Rule;

class CvCompetencesForm extends Component
{
    public $cvProfileId;
    public Collection $competences;
    public $newCompetence = [];

    public bool $showAddForm = false;
    public ?int $editingIndex = null;
    public array $editingCompetence = [];

    public function mount($cvProfileId)
    {
        $this->cvProfileId = $cvProfileId;
        $this->loadCompetences();
        $this->resetForms();
    }

     public function loadCompetences()
    {
        $profile = CvProfile::find($this->cvProfileId);
        if (!$profile) abort(404);
        $this->authorizeInteraction($profile);

        $this->competences = $profile->competences()
                                    ->orderBy('categorie', 'asc')
                                    ->orderBy('order', 'asc') // ou 'nom'
                                    ->get()
                                    ->map(fn ($item) => $item->toArray());
    }

     private function authorizeInteraction(CvProfile $profile) {
         if ($profile->etudiant_id !== Auth::user()->etudiant?->id) {
             abort(403, 'Action non autorisée.');
         }
    }

    public function resetForms() {
        $this->newCompetence = ['categorie' => 'Autres', 'nom' => '', 'niveau' => 50];
        $this->editingCompetence = ['categorie' => '', 'nom' => '', 'niveau' => 50];
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
        $this->editingCompetence = $this->competences[$index];
        $this->showAddForm = false;
    }

    public function cancelEdit()
    {
        $this->resetForms();
    }

    protected function rules()
    {
        $rulesBase = [
            'categorie' => 'required|string|max:100',
            'nom' => 'required|string|max:100',
            'niveau' => 'required|integer|min:0|max:100',
        ];
        if ($this->editingIndex !== null) {
            return collect($rulesBase)->mapWithKeys(fn($rule, $key) => ["editingCompetence.{$key}" => $rule])->toArray();
        } else {
            return collect($rulesBase)->mapWithKeys(fn($rule, $key) => ["newCompetence.{$key}" => $rule])->toArray();
        }
    }

    protected function messages() {
        $prefix = ($this->editingIndex !== null) ? 'editingCompetence.' : 'newCompetence.';
        return [
            $prefix.'categorie.required' => 'La catégorie est requise.',
            $prefix.'nom.required' => 'Le nom de la compétence est requis.',
            $prefix.'niveau.required' => 'Le niveau est requis.',
            $prefix.'niveau.*' => 'Le niveau doit être entre 0 et 100.', // Message générique pour min/max/integer
        ];
    }

     public function updateCompetence()
    {
        if ($this->editingIndex === null) return;
        $validatedData = $this->validate([
            'editingCompetence.nom' => ['required', 'string', 'max:100'],
            'editingCompetence.niveau' => ['required', 'integer', 'min:1', 'max:5'],
            'editingCompetence.categorie' => ['nullable', 'string', 'max:100'],
        ])['editingCompetence'];
        $competenceId = $this->competences[$this->editingIndex]['id'] ?? null;

        if ($competenceId) {
            $competence = CvCompetence::where('cv_profile_id', $this->cvProfileId)->find($competenceId);
            if ($competence) {
                $competence->update($validatedData);
                $this->loadCompetences();
                $this->resetForms();
                session()->flash('competence_message', 'Compétence mise à jour.');
            } else { session()->flash('competence_error', 'Erreur: Compétence non trouvée.'); }
        } else { session()->flash('competence_error', 'Erreur: ID de compétence manquant.'); }
    }

    public function addCompetence()
    {
        $validatedData = $this->validate($this->rules())['newCompetence'];
        CvCompetence::create(['cv_profile_id' => $this->cvProfileId, ...$validatedData]);
        $this->loadCompetences();
        $this->resetForms();
        session()->flash('competence_message', 'Compétence ajoutée.');
    }

    public function removeCompetence($index)
    {
        $competenceId = $this->competences[$index]['id'] ?? null;
        if ($competenceId) {
             $competence = CvCompetence::where('cv_profile_id', $this->cvProfileId)->find($competenceId);
             if ($competence) $competence->delete();
        }
        $this->loadCompetences();
        if ($this->editingIndex === $index) {
            $this->cancelEdit();
        }
        session()->flash('competence_message', 'Compétence supprimée.');
    }

    public function render()
    {
        $categories = CvCompetence::where('cv_profile_id', $this->cvProfileId)
                                    ->distinct()
                                    ->pluck('categorie')
                                    ->merge(['Langages', 'Frameworks/Bibliothèques', 'Bases de données', 'Outils/Méthodes', 'Systèmes', 'Autres'])
                                    ->unique()->sort()->all();
        return view('livewire.etudiants.cv-competences-form', compact('categories'));
    }
}