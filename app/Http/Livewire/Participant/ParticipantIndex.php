<?php

namespace App\Http\Livewire\Participant;

use App\Models\User;
use Livewire\Component;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class ParticipantIndex extends Component
{
    public $participants;

    public function mount()
    {
        $this->participants = User::role('participant')->with('kelas')->get();
    }

    public function render()
    {
        return view('livewire.participant.participant-index');
    }
}
