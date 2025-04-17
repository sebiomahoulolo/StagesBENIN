<?php

namespace App\Http\Livewire\Etudiants;

use Livewire\Component;
use App\Models\CvProfile;
use App\Models\Etudiant;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
// Pas besoin de Purifier pour les textarea simples

class CvProfileForm extends Component
{
    use WithFileUploads;

    public CvProfile $cvProfile;
    public Etudiant $etudiant;

    // Propriétés publiques bindées
    public $titre_profil;
    public $resume_profil; // <- Sera un simple texte
    public $adresse;
    public $telephone_cv;
    public $email_cv;
    public $linkedin_url;
    public $portfolio_url;
    public $photo_cv_path;
    public $photo_cv;
    public $situation_matrimoniale;
    public $nationalite;
    public $date_naissance;
    public $lieu_naissance;

    public $cvProfileId;

    public function mount($cvProfileId)
    {
        $this->cvProfileId = $cvProfileId;
        $this->loadProfileData();
        $this->etudiant = Auth::user()->etudiant()->firstOrFail();
    }

    public function loadProfileData()
    {
        $profile = CvProfile::findOrFail($this->cvProfileId);
        if ($profile->etudiant_id !== Auth::user()->etudiant?->id) {
            abort(403, 'Action non autorisée.');
        }
        $this->cvProfile = $profile;

        $this->titre_profil = $profile->titre_profil;
        // Charger le texte brut. Si du HTML était stocké, il sera affiché tel quel dans le textarea.
        // Il serait bon de nettoyer la base de données une fois pour enlever le HTML existant.
        $this->resume_profil = strip_tags($profile->resume_profil ?? ''); // Enlève les balises HTML au chargement
        $this->adresse = $profile->adresse;
        $this->telephone_cv = $profile->telephone_cv;
        $this->email_cv = $profile->email_cv;
        $this->linkedin_url = $profile->linkedin_url;
        $this->portfolio_url = $profile->portfolio_url;
        $this->photo_cv_path = $profile->photo_cv_path;
        $this->photo_cv = null;
        $this->situation_matrimoniale = $profile->situation_matrimoniale;
        $this->nationalite = $profile->nationalite;
        $this->date_naissance = $profile->date_naissance ? $profile->date_naissance->format('Y-m-d') : null;
        $this->lieu_naissance = $profile->lieu_naissance;
    }

    protected function rules()
    {
        return [
            'titre_profil' => 'required|string|max:255',
            'resume_profil' => 'nullable|string|max:2000', // Valide une chaîne simple
            'adresse' => 'nullable|string|max:255',
            'telephone_cv' => 'nullable|string|max:20',
            'email_cv' => ['nullable','email','max:255', Rule::unique('cv_profiles', 'email_cv')->ignore($this->cvProfile->id)],
            'linkedin_url' => 'nullable|url|max:255',
            'portfolio_url' => 'nullable|url|max:255',
            'photo_cv' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'situation_matrimoniale' => 'nullable|string|max:100',
            'nationalite' => 'nullable|string|max:100',
            'date_naissance' => 'nullable|date_format:Y-m-d',
            'lieu_naissance' => 'nullable|string|max:100',
        ];
    }

    protected $messages = [
          'titre_profil.required' => 'Le titre du profil est obligatoire.',
          'email_cv.email' => 'L\'email de contact n\'est pas une adresse valide.',
          'email_cv.unique' => 'Cet email de contact est déjà utilisé.',
          '*.url' => 'Le champ :attribute doit être une URL valide.',
          'photo_cv.*' => 'La photo doit être une image valide (jpeg, png, jpg) de 2Mo max.',
          'date_naissance.date_format' => 'La date de naissance doit être au format AAAA-MM-JJ.',
     ];

    public function updatedPhotoCv() { $this->validateOnly('photo_cv'); }

    public function save()
    {
        $validatedData = $this->validate();

        // Gérer l'upload photo (inchangé)
        if ($this->photo_cv) {
            if ($this->cvProfile->photo_cv_path && Storage::disk('public')->exists($this->cvProfile->photo_cv_path)) {
                Storage::disk('public')->delete($this->cvProfile->photo_cv_path);
            }
            $path = $this->photo_cv->store('cv_photos', 'public');
            $validatedData['photo_cv_path'] = $path;
            $this->photo_cv_path = $path; // MAJ pour la vue
            $this->photo_cv = null;
        } else {
            unset($validatedData['photo_cv']);
        }

        // Le 'resume_profil' est déjà une chaîne simple venant du textarea
        // Pas besoin de Purifier

        $this->cvProfile->update($validatedData);
        session()->flash('profile_form_message', 'Informations générales mises à jour.');
         // Recharger pour s'assurer que la propriété $resume_profil reflète bien la DB (si strip_tags a modifié qqch)
         $this->loadProfileData();
    }

    public function render()
    {
        return view('livewire.etudiants.cv-profile-form', [
            'etudiant' => $this->etudiant,
            'componentId' => $this->id // Passer l'ID du composant
        ]);
    }
}