<?php

namespace App\Http\Livewire\Participant;

use App\Models\Kelas;
use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Collection;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use function PHPUnit\Framework\isEmpty;

class ParticipantIndex extends Component
{
    public $participants;

    public function mount($kelas = null) #sintaks PHP optional argument
    {
        if ($kelas) {
            $this->participants = Kelas::find($kelas)->users;
        } else {
            $this->participants = User::role('participant')->with('kelas')->get();
        }
    }

    public function render()
    {
        return view('livewire.participant.participant-index');
    }
}
