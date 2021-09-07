<?php

namespace App\Http\Livewire\Kelas;

use App\Models\Kelas;
use App\Models\RegisterStatus;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;

class KelasShow extends Component
{
    public $register_status; // variable status pendaftaran utk kepentingan pendaftaran peserta
    public $kelas;
    public $ispublished;
    public $button_visible;

    public function changeRegistrationStatus(RegisterStatus $status)
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
        $this->kelas = Kelas::with('users')->withCount([
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

        if ($this->kelas->register_status_id != 2) {
            // pengecekan status tutup jika melewati waktu pendaftaran   
            if (now() > $this->kelas->pendaftaran && now() < $this->kelas->akhir_pelaksanaan) {
                $this->kelas->update(['register_status_id' => 2]); 
            }

            // pengecekan status tutup jika peserta melebihi kuota
            if ($this->kelas->peserta_diterima >= $this->kelas->quota) {
                $this->kelas->update(['register_status_id' => 2]); 
            }
        }
        
        if ($this->kelas->register_status_id == 2) {
            # pengecekan status selesai
            if (now() > $this->kelas->akhir_pelaksanaan) {
                $this->kelas->update(['register_status_id' => 3]); 
            }
        }

        // fitur button visible. jika sudah masuk batas pendaftaran, maka hilangkan fitur button open participantnny
        if (now() < $this->kelas->pendaftaran) {
            $this->button_visible = true;
        } else {
            $this->button_visible = false;
        }
    }

    public function mount(Kelas $kelas)
    {
        $this->updateKelas();
    }

    public function render()
    {
        return view('livewire.kelas.kelas-show');
    }
}
