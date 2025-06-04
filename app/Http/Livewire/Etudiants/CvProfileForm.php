<?php

namespace App\Http\Livewire\Etudiants;

use Livewire\Component;
use App\Models\CvProfile;
use App\Models\Etudiant;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
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
        try {
            $this->cvProfileId = $cvProfileId;

            // Vérifier que l'utilisateur est connecté et a un profil étudiant
            if (!Auth::check() || !Auth::user()->etudiant) {
                session()->flash('error', 'Vous devez être connecté en tant qu\'étudiant pour accéder à cette page.');
                return redirect()->route('login');
            }

            $this->etudiant = Auth::user()->etudiant;
            $this->loadProfileData();
        } catch (\Exception $e) {
            session()->flash('error', 'Une erreur est survenue lors du chargement du profil.');
            \Log::error("Erreur dans CvProfileForm::mount : " . $e->getMessage());
        }
    }

    public function loadProfileData()
    {
        try {
            $profile = CvProfile::findOrFail($this->cvProfileId);

            // Vérifier que le profil appartient à l'étudiant connecté
            if ($profile->etudiant_id !== $this->etudiant->id) {
                session()->flash('error', 'Vous n\'êtes pas autorisé à modifier ce profil.');
                return;
            }

            $this->cvProfile = $profile;

            $this->titre_profil = $profile->titre_profil;
            $this->resume_profil = strip_tags($profile->resume_profil ?? '');
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
        } catch (\Exception $e) {
            session()->flash('error', 'Une erreur est survenue lors du chargement des données du profil.');
            \Log::error("Erreur dans CvProfileForm::loadProfileData : " . $e->getMessage());
        }
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
        $this->validate([
            'titre_profil' => 'required|string|max:255',
            'email_cv' => 'required|email|max:255',
            'telephone_cv' => 'required|string|max:20',
            'adresse' => 'required|string|max:255',
            'situation_matrimoniale' => 'required|string|in:Célibataire,Marié(e),Divorcé(e),Veuf(ve),Autre',
            'nationalite' => 'required|string|max:100',
            'date_naissance' => 'required|date',
            'lieu_naissance' => 'required|string|max:255',
            'resume_profil' => 'required|string|min:50',
            'linkedin_url' => 'nullable|url|max:255',
            'portfolio_url' => 'nullable|url|max:255',
            'photo_cv' => 'nullable|image|max:2048|mimes:jpeg,png,jpg'
        ], [
            'titre_profil.required' => 'Le titre du profil est obligatoire',
            'email_cv.required' => 'L\'email de contact est obligatoire',
            'email_cv.email' => 'Veuillez entrer une adresse email valide',
            'telephone_cv.required' => 'Le numéro de téléphone est obligatoire',
            'adresse.required' => 'L\'adresse est obligatoire',
            'situation_matrimoniale.required' => 'La situation matrimoniale est obligatoire',
            'nationalite.required' => 'La nationalité est obligatoire',
            'date_naissance.required' => 'La date de naissance est obligatoire',
            'lieu_naissance.required' => 'Le lieu de naissance est obligatoire',
            'resume_profil.required' => 'Le résumé du profil est obligatoire',
            'resume_profil.min' => 'Le résumé doit contenir au moins 50 caractères',
            'linkedin_url.url' => 'L\'URL LinkedIn doit être valide',
            'portfolio_url.url' => 'L\'URL du portfolio doit être valide',
            'photo_cv.image' => 'Le fichier doit être une image',
            'photo_cv.max' => 'L\'image ne doit pas dépasser 2Mo',
            'photo_cv.mimes' => 'L\'image doit être au format jpeg, png ou jpg'
        ]);

        try {
            DB::beginTransaction();

            $cvProfile = CvProfile::updateOrCreate(
                ['etudiant_id' => $this->etudiant->id],
                [
                    'titre_profil' => $this->titre_profil,
                    'email_cv' => $this->email_cv,
                    'telephone_cv' => $this->telephone_cv,
                    'adresse' => $this->adresse,
                    'linkedin_url' => $this->linkedin_url,
                    'portfolio_url' => $this->portfolio_url,
                    'situation_matrimoniale' => $this->situation_matrimoniale,
                    'nationalite' => $this->nationalite,
                    'date_naissance' => $this->date_naissance,
                    'lieu_naissance' => $this->lieu_naissance,
                    'resume_profil' => $this->resume_profil
                ]
            );

            if ($this->photo_cv) {
                // Supprimer l'ancienne photo si elle existe
                if ($cvProfile->photo_cv_path) {
                    Storage::delete($cvProfile->photo_cv_path);
                }

                // Sauvegarder la nouvelle photo
                $path = $this->photo_cv->store('cv-photos', 'public');
                $cvProfile->update(['photo_cv_path' => $path]);
            }

            DB::commit();

            session()->flash('profile_form_message', 'Profil CV mis à jour avec succès !');
            $this->emit('profileUpdated');

        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Une erreur est survenue lors de la sauvegarde du profil.');
        }
    }

    public function render()
    {
        return view('livewire.etudiants.cv-profile-form', [
            'etudiant' => $this->etudiant,
            'componentId' => $this->id // Passer l'ID du composant
        ]);
    }
}
