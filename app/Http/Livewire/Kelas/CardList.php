<?php

namespace App\Http\Livewire\Kelas;

use App\Models\Kelas;
use Livewire\Component;

class CardList extends Component
{
    public $kelas;

    public function mount()
    {
        // pusher dipikirin
        $this->kelas = Kelas::all();
    }

    public function render()
    {
        return view('livewire.kelas.card-list');
    }
}
