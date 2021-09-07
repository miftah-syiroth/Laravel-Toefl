<?php

namespace App\Http\Livewire\Kelas;

use App\Models\Kelas;
use Livewire\Component;

class KelasIndex extends Component
{
    public $kelas;

    // it is planned for polling, but it's not important anymore to realtime at this page
    public function updateKelas()
    {
        $this->kelas = Kelas::with(['registerStatus'])->withCount(['users'])->orderBy('id', 'DESC')->get();
    }

    public function mount()
    {
        $this->updateKelas();
    }

    public function render()
    {
        return view('livewire.kelas.kelas-index');
    }
}
