<?php

namespace App\Http\Livewire\Participant;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class ToeflInformation extends Component
{
    public $user;
    public $kelas;
    public $status;

    public function downloadReceipt()
    {
        // dd($this->user->receipt_of_payment);
    }

    public function mount()
    {
        $this->user = Auth::user();

        $this->kelas = $this->user->kelas;
    }

    public function render()
    {
        return view('livewire.participant.toefl-information');
    }
}
