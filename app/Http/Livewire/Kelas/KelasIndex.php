<?php

namespace App\Http\Livewire\Kelas;

use App\Models\Kelas;
use Livewire\Component;

class KelasIndex extends Component
{
    public $kelas;

    public function updateKelas()
    {
        $this->kelas = Kelas::with(['users', 'registerStatus'])->withCount('users')->orderBy('id', 'DESC')->get();
    }

    public function mount()
    {
        $this->kelas = Kelas::with(['users', 'registerStatus'])->withCount('users')->orderBy('id', 'DESC')->get();
    }

    public function render()
    {
        return view('livewire.kelas.kelas-index');
    }
}
