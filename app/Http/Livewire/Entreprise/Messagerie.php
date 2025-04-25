<?php

namespace App\Http\Livewire\Entreprise;

use Livewire\Component;
use App\Models\Messagerie as EntrepriseMessage;
use Illuminate\Support\Facades\Auth;

class Messagerie extends Component
{
    public $entreprise_id = 0;
    public $objet;
    public $message;

    public function storeMessage()
    {
        $validated = $this->validate([
            'entreprise_id' => 'required',
            'objet' => 'required|min:3|max:50',
            'message' => 'required|min:3',
        ]);
        EntrepriseMessage::create([
            'entreprise_id' => Auth::user()->id, //Auth::user()->id,
            'objet' => $this->objet,
            'message' => $this->message,
        ]);
        session()->flash('success', 'Message envoyé.');
        $this->reset();
    }

    public function render()
    {


        //$entreprise_id = Auth::user()->id;

        return view('livewire.entreprise.messagerie',); //['entreprise_id' => $entreprise_id]
    }
}
