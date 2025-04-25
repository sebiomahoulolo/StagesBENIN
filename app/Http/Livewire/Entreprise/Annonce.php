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
    public $entreprise_id = 6; //6;
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
            'entreprise_id' => 'required',
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
        // EntrepriseAnnonce::create($validated);
        EntrepriseAnnonce::create([
            'entreprise_id' => Auth::user()->id,
            'nom_du_poste' => $this->nom_du_poste,
            'type_de_poste' => $this->type_de_poste,
            'nombre_de_place' => $this->nombre_de_place,
            'niveau_detude' => $this->niveau_detude,
            'domaine' => $this->domaine,
            'lieu' => $this->lieu,
            'email' => $this->email,
            'date_cloture' => $this->date_cloture,
            'description' => $this->description,
        ]);
        session()->flash('success', 'Annonce crée et publié.');
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
