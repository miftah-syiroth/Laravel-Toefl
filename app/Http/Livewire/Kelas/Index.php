<?php

namespace App\Http\Livewire\Kelas;

use App\Models\Kelas;
use App\Models\Status;
use Livewire\Component;

class Index extends Component
{
    public $kelas;
    public $statuses;

    public function openRegistration(Kelas $kelas)
    {
        $kelas->statuses()->sync([1, 4]);
        // update tabel kelasnya
        $this->kelas = Kelas::with(['statuses'])->get();
    }

    public function mount()
    {
        // kalau pakai polling, berarti taruh di sini
        $this->kelas = Kelas::with(['statuses'])->get();
    }

    public function render()
    {
        return view('livewire.kelas.index');
    }
}
