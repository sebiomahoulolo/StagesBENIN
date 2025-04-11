<?php

namespace App\Http\Livewire\Etudiants;

use Livewire\Component;
use App\Models\CvProfile;
use App\Models\CvExperience;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;
use Carbon\Carbon;

class CvExperiencesForm extends Component
{
    public $cvProfileId;
    public Collection $experiences;
    public $newExperience = [];

    public bool $showAddForm = false;
    public ?int $editingIndex = null;
    public array $editingExperience = [];

    // Pas de listeners ou handlers pour Trix/Quill

    public function mount($cvProfileId)
    {
        $this->cvProfileId = $cvProfileId;
        $this->loadExperiences();
        $this->resetForms();
    }

    public function loadExperiences()
    {
        $profile = CvProfile::find($this->cvProfileId);
        if (!$profile) abort(404);
        $this->authorizeInteraction($profile);

        $this->experiences = $profile->experiences()
                                     ->orderBy('date_debut', 'desc')
                                     ->get()
                                     ->map(function ($item) {
            $itemArray = $item->toArray();
            $itemArray['date_debut'] = $item->date_debut ? Carbon::parse($item->date_debut)->format('Y-m-d') : null;
            $itemArray['date_fin'] = $item->date_fin ? Carbon::parse($item->date_fin)->format('Y-m-d') : null;
            // Assurer que les clés tache_x existent, même si nulles dans la DB
            for ($i = 1; $i <= 3; $i++) {
                $itemArray['tache_'.$i] = $item->{'tache_'.$i} ?? '';
            }
            // Important : Supprimer l'ancienne clé si elle existe encore pour éviter confusion
            unset($itemArray['taches_realisations']);
            return $itemArray;
        });
    }

    private function authorizeInteraction(CvProfile $profile) {
         if ($profile->etudiant_id !== Auth::user()->etudiant?->id) {
             abort(403, 'Action non autorisée.');
         }
    }

    public function resetForms() {
        // Initialiser avec les nouveaux champs tache_x
        $this->newExperience = $this->emptyExperienceData();
        $this->editingExperience = $this->emptyExperienceData();
        $this->editingIndex = null;
        $this->showAddForm = false;
        $this->resetValidation();
    }

    // Helper pour initialiser les données d'une expérience
    private function emptyExperienceData(): array {
        return [
            'poste' => '', 'entreprise' => '', 'ville' => '',
            'date_debut' => '', 'date_fin' => null, 'description' => '',
            'tache_1' => '', 'tache_2' => '', 'tache_3' => ''
        ];
    }

    public function toggleAddForm() {
        $this->resetValidation();
        if (!$this->showAddForm && $this->editingIndex !== null) {
             $this->cancelEdit();
        }
        $this->showAddForm = !$this->showAddForm;
    }

    public function edit($index) {
         if(!isset($this->experiences[$index])) return;
         $this->resetValidation();
         $this->editingIndex = $index;
         // Charger les données, y compris les tâches
         $this->editingExperience = $this->experiences[$index];
         // Assurer que les clés tache_x existent
         for ($i = 1; $i <= 3; $i++) {
              $this->editingExperience['tache_'.$i] = $this->experiences[$index]['tache_'.$i] ?? '';
         }
         $this->showAddForm = false;
     }

    public function cancelEdit() { $this->resetForms(); }

    // Pas de handler Trix

    protected function rules()
    {
         // Adapter les règles pour les champs texte et les nouvelles tâches
         $rulesBase = [
             'poste' => 'required|string|max:255',
             'entreprise' => 'required|string|max:255',
             'ville' => 'nullable|string|max:100',
             'date_debut' => 'required|date',
             'date_fin' => 'nullable|date|after_or_equal:date_debut',
             'description' => 'nullable|string|max:1500', // Limite pour textarea
             // Limites pour les champs input des tâches
             'tache_1' => 'nullable|string|max:255',
             'tache_2' => 'nullable|string|max:255',
             'tache_3' => 'nullable|string|max:255',
         ];

         if ($this->editingIndex !== null) {
              $rulesBase['date_fin'] = 'nullable|date|after_or_equal:editingExperience.date_debut';
              return collect($rulesBase)->mapWithKeys(fn($rule, $key) => ["editingExperience.{$key}" => $rule])->toArray();
         } else {
               $rulesBase['date_fin'] = 'nullable|date|after_or_equal:newExperience.date_debut';
               return collect($rulesBase)->mapWithKeys(fn($rule, $key) => ["newExperience.{$key}" => $rule])->toArray();
         }
    }

     protected function messages() {
         $prefix = ($this->editingIndex !== null) ? 'editingExperience.' : 'newExperience.';
         return [
             $prefix.'poste.required' => 'Le poste est requis.',
             $prefix.'entreprise.required' => 'L\'entreprise est requise.',
             $prefix.'date_debut.required' => 'La date de début est requise.',
             $prefix.'*.max' => 'Ce champ est trop long.', // Message générique pour max
             $prefix.'date_fin.after_or_equal' => 'La date de fin doit être après ou égale à la date de début.',
         ];
     }

     public function updateExperience()
    {
         if ($this->editingIndex === null) return;
         // Valide les données incluant les 3 tâches
         $validatedData = $this->validate($this->rules())['editingExperience'];
         $experienceId = $this->experiences[$this->editingIndex]['id'] ?? null;

         if ($experienceId) {
             $experience = CvExperience::where('cv_profile_id', $this->cvProfileId)->find($experienceId);
             if ($experience) {
                 // Enregistre directement les données validées (pas de Trix/Purifier)
                 $experience->update($validatedData);
                 $this->loadExperiences(); // Recharge pour màj et ordre
                 $this->resetForms();
                 session()->flash('experience_message', 'Expérience mise à jour.');
             } else { session()->flash('experience_error_' . $this->editingIndex, 'Erreur: Expérience non trouvée.'); }
         } else { session()->flash('experience_error_' . $this->editingIndex, 'Erreur: ID d\'expérience manquant.'); }
    }

    public function addExperience()
    {
        $validatedData = $this->validate($this->rules())['newExperience'];
         // Enregistre directement les données validées
        CvExperience::create(['cv_profile_id' => $this->cvProfileId, ...$validatedData]);
        $this->loadExperiences(); // Recharge
        $this->resetForms(); // Réinitialise et cache
        session()->flash('experience_message', 'Expérience ajoutée.');
    }

    public function removeExperience($index)
    {
        $experienceId = $this->experiences[$index]['id'] ?? null;
        if ($experienceId) {
            $experience = CvExperience::where('cv_profile_id', $this->cvProfileId)->find($experienceId);
            if ($experience) $experience->delete();
        }
        $this->loadExperiences();
        if ($this->editingIndex === $index) {
            $this->cancelEdit();
        }
        session()->flash('experience_message', 'Expérience supprimée.');
    }

    public function render()
    {
        return view('livewire.etudiants.cv-experiences-form', [
            'componentId' => $this->id // Passer l'ID unique du composant
        ]);
    }
}