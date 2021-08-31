<?php

namespace App\Http\Livewire\Kelas;

use App\Models\Kelas;
use Livewire\Component;

class CardList extends Component
{
    public $kelas;

    public function updateKelas()
    {
        $this->kelas = Kelas::withCount('users')->get();
    }

    public function mount()
    {
        $this->kelas = Kelas::withCount('users')->get();
    }

    public function render()
    {
        return view('livewire.kelas.card-list');
    }
}
