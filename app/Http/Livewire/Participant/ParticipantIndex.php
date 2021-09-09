<?php

namespace App\Http\Livewire\Participant;

use App\Exports\ParticipantsExport;
use App\Models\Kelas;
use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use function PHPUnit\Framework\isEmpty;

class ParticipantIndex extends Component
{
    public $participants;
    public $kelas;

    public $sortBy;
    public $order;
    public $is_sorted = false;

    public $participant_status;
    public $is_filtered = false;

    protected $rules = [
        'sortBy' => 'required|string',
        'order' => 'required|string',
    ];

    public function sorting()
    {
        $this->validate();
        $this->is_sorted = true;

        if ($this->is_filtered == true) {

            if ($this->kelas) {
                $this->participants = $this->kelas->users()->where('status_id', $this->participant_status)->orderBy($this->sortBy, $this->order)->get();
            } else {
                $this->participants = User::role('participant')->with('kelas')->where('status_id', $this->participant_status)->orderBy($this->sortBy, $this->order)->get();
            }
            
        } else {

            if ($this->kelas) {
                $this->participants = $this->kelas->users()->orderBy($this->sortBy, $this->order)->get();
            } else {
                $this->participants = User::role('participant')->with('kelas')->orderBy($this->sortBy, $this->order)->get();
            }
        }
    }

    public function filtering()
    {
        $this->is_filtered = true;

        // $this->is_sorted = false; // ini biar yakin aja sih
        $this->reset(['sortBy', 'order', 'is_sorted']);

        if ($this->kelas) {
            $this->participants = $this->kelas->users->where('status_id', $this->participant_status)->orderBy('id', 'DESC')->get();
        } else {
            $this->participants = User::role('participant')->with('kelas')->where('status_id', $this->participant_status)->orderBy('id', 'DESC')->get();
        }
    }

    public function export()
    {
        return Excel::download(new ParticipantsExport($this->participants), 'participants.xlsx');
    }

    public function mount($kelas = null) #sintaks PHP optional argument
    {
        if ($kelas) {
            $this->kelas = Kelas::with('users')->find($kelas);
            $this->participants = $this->kelas->users()->orderBy('id', 'DESC')->get();
        } else {
            $this->participants = User::role('participant')->with('kelas')->orderBy('id', 'DESC')->get();
        }
    }

    public function render()
    {
        return view('livewire.participant.participant-index');
    }
}
