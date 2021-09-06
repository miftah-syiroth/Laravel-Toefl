<?php

namespace App\Http\Livewire\Kelas;

use App\Models\Kelas;
use App\Models\RegisterStatus;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;

class KelasShow extends Component
{
    public $register_statuses;
    public $kelas;
    public $ispublished;

    public function registration(RegisterStatus $status)
    {
        $this->kelas->update([
            'register_status_id' => $status->id,
        ]);

        $this->updateKelas();
    }

    public function publication()
    {
        $this->ispublished = $this->kelas->ispublished ? 0 : 1 ;

        $this->kelas->update([
            'ispublished' => $this->ispublished,
        ]);

        $this->updateKelas();
    }

    public function updateKelas()
    {
        $this->kelas = Kelas::withCount([
            'users',
            'users as peserta_ditolak' => function (Builder $query) {
                $query->where('status_id', 3);
            },
            'users as peserta_mengerjakan' => function (Builder $query) {
                $query->where('status_id', 5);
            },
            'users as peserta_kadaluwarsa' => function (Builder $query) {
                $query->where('status_id', 6);
            },
        ])->find($this->kelas->id);
    }

    public function deleteKelas()
    {
        
    }

    public function mount(Kelas $kelas)
    {
        $this->register_statuses = RegisterStatus::all();

        $this->kelas = Kelas::withCount([
            'users',
            'users as peserta_ditolak' => function (Builder $query) {
                $query->where('status_id', 3);
            },
            'users as peserta_mengerjakan' => function (Builder $query) {
                $query->where('status_id', 5);
            },
            'users as peserta_kadaluwarsa' => function (Builder $query) {
                $query->where('status_id', 6);
            },
        ])->find($kelas->id);
    }

    public function render()
    {
        return view('livewire.kelas.kelas-show');
    }
}
