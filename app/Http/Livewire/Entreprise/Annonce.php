<?php

namespace App\Http\Livewire\Entreprise;

use App\Models\User;
//use Illuminate\Support\Facades\Auth;
//use Illuminate\Foundation\Auth\User;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\Annonce as EntrepriseAnnonce;

class Annonce extends Component
{
    //public User $user;
    public $nom_du_poste;
    public $type_de_poste;
    public $nombre_de_place;
    public $niveau_detude;
    public $domaine;
    public $lieu;
    public $email;
    public $date_cloture;
    public $description;

    public function storeAnnonce()
    {
        $validated = $this->validate([
            'nom_du_poste' => 'required|min:3|max:50',
            'type_de_poste' => 'required|min:3|max:50',
            'nombre_de_place' => 'required|integer',
            'niveau_detude' => 'required|min:3|max:50',
            'domaine' => 'required',
            'lieu' => 'required',
            'email' => 'required|email|',
            'date_cloture' => 'required',
            'description' => 'required',
        ]);

        EntrepriseAnnonce::create([
            'entreprise_id' => Auth::user()->entreprise->id,
            'nom_du_poste' => $this->nom_du_poste,
            'type_de_poste' => $this->type_de_poste,
            'nombre_de_place' => $this->nombre_de_place,
            'niveau_detude' => $this->niveau_detude,
            'domaine' => $this->domaine,
            'lieu' => $this->lieu,
            'email' => $this->email,
            'date_cloture' => $this->date_cloture,
            'description' => $this->description,
            'statut' => 'en_attente',
            'est_active' => true,
        ]);

        session()->flash('success', 'Annonce créée avec succès et en attente de validation.');
        $this->resetInput();
    }

    public function resetInput()
    {
        $this->reset();
    }

    public function render()
    {
        return view('livewire.entreprise.annonce');
    }
}
