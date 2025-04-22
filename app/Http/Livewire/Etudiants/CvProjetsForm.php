<?php

namespace App\Http\Livewire\Etudiants; // Ou App\Livewire\Etudiants;

use Livewire\Component;
use App\Models\CvProfile;
use App\Models\CvProjet;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;
use Illuminate\Validation\Rule;

class CvProjetsForm extends Component
{
    public $cvProfileId;
    public Collection $projets;
    public $newProjet = [];

    public bool $showAddForm = false;
    public ?int $editingIndex = null;
    public array $editingProjet = [];

    protected $listeners = ['trixValueUpdated' => 'handleTrixValueUpdated'];

    public function mount($cvProfileId)
    {
        $this->cvProfileId = $cvProfileId;
        $this->loadProjets();
        $this->resetForms();
    }

    public function loadProjets()
    {
        $profile = CvProfile::find($this->cvProfileId);
         if (!$profile) abort(404);
        $this->authorizeInteraction($profile);

        $this->projets = $profile->projets()
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
        $this->newProjet = ['nom' => '', 'url_projet' => '', 'description' => '', 'technologies' => ''];
        $this->editingProjet = ['nom' => '', 'url_projet' => '', 'description' => '', 'technologies' => ''];
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
        $this->editingProjet = $this->projets[$index];
        $this->showAddForm = false;
    }

    public function cancelEdit()
    {
        $this->resetForms();
    }

    public function handleTrixValueUpdated($payload)
    {
         if (isset($payload['inputId'])) {
             $parts = explode('.', $payload['inputId']);
             if (count($parts) === 2 && $parts[0] === 'newProjet' && $parts[1] === 'description') {
                  // !! Sécurité Trix !!
                  $this->newProjet['description'] = $payload['content'];
             } elseif (count($parts) === 2 && $parts[0] === 'editingProjet' && $parts[1] === 'description') {
                  // !! Sécurité Trix !!
                  $this->editingProjet['description'] = $payload['content'];
             }
         }
    }

    protected function rules()
    {
        $rulesBase = [
            'nom' => 'required|string|max:255',
            'url_projet' => 'nullable|url|max:255',
            'description' => 'nullable|string|max:2000',
            'technologies' => 'nullable|string|max:255',
        ];

        if ($this->editingIndex !== null) {
            return collect($rulesBase)->mapWithKeys(fn($rule, $key) => ["editingProjet.{$key}" => $rule])->toArray();
        } else {
            return collect($rulesBase)->mapWithKeys(fn($rule, $key) => ["newProjet.{$key}" => $rule])->toArray();
        }
    }

    protected function messages() {
        $prefix = ($this->editingIndex !== null) ? 'editingProjet.' : 'newProjet.';
        return [
            $prefix.'nom.required' => 'Le nom du projet est requis.',
            $prefix.'url_projet.url' => 'L\'URL doit être valide (commençant par http/https).',
        ];
    }

    public function updateProjet()
    {
        if ($this->editingIndex === null) return;
        $validatedData = $this->validate($this->rules())['editingProjet'];
        $projetId = $this->projets[$this->editingIndex]['id'] ?? null;

        if ($projetId) {
            $projet = CvProjet::where('cv_profile_id', $this->cvProfileId)->find($projetId);
            if ($projet) {
                 // !! Sécurité Trix !!
                 $projet->update($validatedData);
                 $this->loadProjets();
                 $this->resetForms();
                 session()->flash('projet_message', 'Projet mis à jour.');
            } else { session()->flash('projet_error', 'Erreur: Projet non trouvé.'); }
        } else { session()->flash('projet_error', 'Erreur: ID de projet manquant.'); }
    }

    public function addProjet()
    {
        $validatedData = $this->validate($this->rules())['newProjet'];
         // !! Sécurité Trix !!
        CvProjet::create(['cv_profile_id' => $this->cvProfileId, ...$validatedData]);
        $this->dispatchBrowserEvent('reset-trix', ['inputId' => 'newProjet.description']);
        $this->loadProjets();
        $this->resetForms();
        session()->flash('projet_message', 'Projet ajouté.');
    }

    public function removeProjet($index)
    {
        $projetId = $this->projets[$index]['id'] ?? null;
        if ($projetId) {
             $projet = CvProjet::where('cv_profile_id', $this->cvProfileId)->find($projetId);
             if ($projet) $projet->delete();
        }
        $this->loadProjets();
        if ($this->editingIndex === $index) {
            $this->cancelEdit();
        }
        session()->flash('projet_message', 'Projet supprimé.');
    }

    public function render()
    {
        return view('livewire.etudiants.cv-projets-form');
    }
}