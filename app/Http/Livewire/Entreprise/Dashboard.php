<?php

namespace App\Http\Livewire\Entreprise;

use Livewire\Component;
use App\Models\Annonce;
use Illuminate\Support\Facades\Auth;

class Dashboard extends Component
{
    public $annonces = [];
    public $loading = true;

    public function mount()
    {
        $this->loadAnnonces();
    }

    public function loadAnnonces()
    {
        try {
            $this->annonces = Annonce::where('entreprise_id', Auth::id())
                ->with(['candidatures', 'entreprise'])
                ->latest()
                ->take(5)
                ->get();
        } catch (\Exception $e) {
            session()->flash('error', 'Erreur lors du chargement des annonces');
        } finally {
            $this->loading = false;
        }
    }

    public function render()
    {
        return view('livewire.entreprise.dashboard', [
            'annonces' => $this->annonces,
            'loading' => $this->loading
        ]);
    }
}
