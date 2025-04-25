<?php

namespace App\Http\Livewire\Entreprise;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Event as ModelsEvent;
use Illuminate\Support\Facades\Auth;

class Event extends Component
{
    use WithFileUploads;

    public $user_id = 0;
    public $title;
    public $description;
    public $start_date;
    public $end_date;
    public $location;
    public $max_participants;
    public $type;
    public $image;


    public function storeEvent()
    {
        $validated = $this->validate([
            'title' => 'required',
            'description' => 'required|min:3',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'location' => 'required|min:3',
            'type' => 'required|min:3',
            'location' => 'required|min:3',
            'max_participants' => 'required|integer',
            'image' => 'required|image',
        ]);
        if ($this->start_date < $this->end_date) {
            // Traitement de l'image si elle existe
            $this->image->store('images/events');
            $imageName = time() . '.' . $this->image->getClientOriginalExtension();

            ModelsEvent::create([
                'user_id' => Auth::user()->id,
                'title' => $this->title,
                'description' => $this->description,
                'start_date' => $this->start_date,
                'end_date' => $this->end_date,
                'location' => $this->location,
                'type' => $this->type,
                'max_participants' => $this->max_participants,
                'image' => $imageName,
                'is_published' => 0
            ]);
            session()->flash('success', 'Eévènement enrégistré avec succès.');
            $this->reset();
        } else {
            session()->flash('warning', 'Revoyez les dates du début et de fin de l\'évènement.');
        }
    }
    public function render()
    {
        return view('livewire.entreprise.event');
    }
}
