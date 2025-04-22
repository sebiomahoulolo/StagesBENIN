<?php

namespace App\Http\Livewire\Etudiants; // Ou App\Livewire\Etudiants;

use Livewire\Component;
use App\Models\CvProfile;
use App\Models\CvCertification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;
use Illuminate\Validation\Rule;

class CvCertificationsForm extends Component
{
    public $cvProfileId;
    public Collection $certifications;
    public $newCertification = [];

    public bool $showAddForm = false;
    public ?int $editingIndex = null;
    public array $editingCertification = [];

    public function mount($cvProfileId)
    {
        $this->cvProfileId = $cvProfileId;
        $this->loadCertifications();
        $this->resetForms();
    }

    public function loadCertifications()
    {
        $profile = CvProfile::find($this->cvProfileId);
        if (!$profile) abort(404);
        $this->authorizeInteraction($profile);

        $this->certifications = $profile->certifications()
                                        ->orderBy('annee', 'desc')
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
        $this->newCertification = ['nom' => '', 'organisme' => '', 'annee' => null, 'url_validation' => ''];
        $this->editingCertification = ['nom' => '', 'organisme' => '', 'annee' => null, 'url_validation' => ''];
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
        $this->editingCertification = $this->certifications[$index];
        $this->showAddForm = false;
    }

    public function cancelEdit()
    {
        $this->resetForms();
    }

    protected function rules()
    {
        $rulesBase = [
            'nom' => 'required|string|max:255',
            'organisme' => 'required|string|max:255',
            'annee' => 'nullable|integer|min:1980|max:'.(date('Y') + 1),
            'url_validation' => 'nullable|url|max:255',
        ];

        if ($this->editingIndex !== null) {
            return collect($rulesBase)->mapWithKeys(fn($rule, $key) => ["editingCertification.{$key}" => $rule])->toArray();
        } else {
            return collect($rulesBase)->mapWithKeys(fn($rule, $key) => ["newCertification.{$key}" => $rule])->toArray();
        }
    }

    protected function messages() {
        $prefix = ($this->editingIndex !== null) ? 'editingCertification.' : 'newCertification.';
        return [
            $prefix.'nom.required' => 'Le nom de la certification est requis.',
            $prefix.'organisme.required' => 'L\'organisme est requis.',
            $prefix.'annee.integer' => 'L\'année doit être un nombre.',
            $prefix.'annee.min' => 'L\'année semble trop ancienne.',
            $prefix.'annee.max' => 'L\'année ne peut pas être dans le futur lointain.',
            $prefix.'url_validation.url' => 'L\'URL doit être valide (commençant par http/https).',
        ];
    }

    public function updateCertification()
    {
        if ($this->editingIndex === null) return;
        $validatedData = $this->validate($this->rules())['editingCertification'];
        $certificationId = $this->certifications[$this->editingIndex]['id'] ?? null;

        if ($certificationId) {
            $certification = CvCertification::where('cv_profile_id', $this->cvProfileId)->find($certificationId);
            if ($certification) {
                 $certification->update($validatedData);
                 $this->loadCertifications();
                 $this->resetForms();
                 session()->flash('certification_message', 'Certification mise à jour.');
            } else { session()->flash('certification_error', 'Erreur: Certification non trouvée.'); }
        } else { session()->flash('certification_error', 'Erreur: ID de certification manquant.'); }
    }

    public function addCertification()
    {
        $validatedData = $this->validate($this->rules())['newCertification'];
        CvCertification::create(['cv_profile_id' => $this->cvProfileId, ...$validatedData]);
        $this->loadCertifications();
        $this->resetForms();
        session()->flash('certification_message', 'Certification ajoutée.');
    }

    public function removeCertification($index)
    {
        $certificationId = $this->certifications[$index]['id'] ?? null;
        if ($certificationId) {
             $certification = CvCertification::where('cv_profile_id', $this->cvProfileId)->find($certificationId);
             if ($certification) $certification->delete();
        }
        $this->loadCertifications();
        if ($this->editingIndex === $index) {
            $this->cancelEdit();
        }
        session()->flash('certification_message', 'Certification supprimée.');
    }

    public function render()
    {
        return view('livewire.etudiants.cv-certifications-form');
    }
}