<?php

namespace App\Http\Livewire\Kelas;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class RegistrationStatus extends Component
{
    public $kelas;

    public function mount()
    {
        $this->kelas = Auth::user()->kelas;
    }

    public function render()
    {
        return view('livewire.kelas.registration-status');
    }
}
