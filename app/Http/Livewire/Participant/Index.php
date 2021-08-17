<?php

namespace App\Http\Livewire\Participant;

use App\Models\User;
use Illuminate\Support\Arr;
use Livewire\Component;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class Index extends Component
{
    public $participants;

    public function acceptRegistration(User $user)
    {
        $kelas = $user->kelas()->first(); // ambil kelas dari kelas_id di row user
        // ambil id toefl-toefl yg digunakaan dari kelas. bisa pakai looping, tp coba mbok ada cara mudah
        $toefls = $kelas->toefls()->pluck('id')->toArray();
        // randomly get toefl_id then insert into user
        $toefl_id = Arr::random($toefls); 
        $user->update(['toefl_id' => $toefl_id]);
        // ubah permission dari user tsb ke do toefl
        $user->syncPermissions('do toefl');

        $this->participants = User::role('participant')->get();
    }

    public function mount()
    {
        $this->participants = User::role('participant')->get();
    }

    public function render()
    {
        return view('livewire.participant.index');
    }
}
