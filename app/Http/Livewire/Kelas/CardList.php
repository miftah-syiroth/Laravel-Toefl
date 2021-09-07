<?php

namespace App\Http\Livewire\Kelas;

use App\Models\Kelas;
use Livewire\Component;

class CardList extends Component
{
    public $kelas;

    public function updateKelas()
    {
        // tampilkan kelas yg terpublikasi dan register statusnya ga null
        $this->kelas = Kelas::with(['registerStatus'])->withCount('users')->where('ispublished', true)->orderBy('pendaftaran', 'ASC')->get();
    }

    public function mount()
    {
        $this->updateKelas();
    }

    public function render()
    {
        return view('livewire.kelas.card-list');
    }
}
