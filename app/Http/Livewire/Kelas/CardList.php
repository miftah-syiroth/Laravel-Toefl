<?php

namespace App\Http\Livewire\Kelas;

use App\Models\Kelas;
use Livewire\Component;

class CardList extends Component
{
    public $kelas;

    public function checkRegistrationTime(Kelas $kelas)
    {
        // jika waktu pendaftaran lebih kecil atau sudah melewati
        if ($kelas->pendaftaran <= now()) {
            $kelas->update([
                'register_status_id' => 2,
            ]);
        }

    }

    // public function updateKelas()
    // {
    //     $this->kelas = Kelas::with(['registerStatus'])->withCount('users')->where('ispublished', true)->whereNotNull('register_status_id')->orderBy('pendaftaran', 'ASC')->get();
    // }

    public function mount()
    {
        // tampilkan kelas yg terpublikasi dan register statusnya ga null
        $this->kelas = Kelas::with(['registerStatus'])->withCount('users')->where('ispublished', true)->whereNotNull('register_status_id')->orderBy('pendaftaran', 'ASC')->get();
    }

    public function render()
    {
        return view('livewire.kelas.card-list');
    }
}
