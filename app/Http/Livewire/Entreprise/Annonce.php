<?php

namespace App\Http\Livewire\Entreprise;

use App\Models\Annonce as EntrepriseAnnonce;
use Livewire\Component;

class Annonce extends Component
{
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
        EntrepriseAnnonce::create($validated);
    }

    public function render()
    {
        return view('livewire.entreprise.annonce');
    }
}
