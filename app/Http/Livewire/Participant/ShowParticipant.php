<?php

namespace App\Http\Livewire\Participant;

use App\Models\ParticipantStatus;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class ShowParticipant extends Component
{
    use WithFileUploads;

    public $participant;
    public $formActionVisible = false; // ini form utk menerima atau menolak peserta. ketika sudah pelaksanaan maka sembunyikan ini

    public $statuses;
    public $status; # ini adalah aksi yg diberikan kepada peserta untuk merubah status pendaftaran

    public $certificate;

    protected $listeners = [
        'actionDone' => 'changeParticipantStatus',
        'certificateUploaded',
    ];

    public function uploadCertificate()
    {
        $this->validate([
            'certificate' => 'image|required',
        ]);

        // cek dulu, upload baru atau update
        if ($this->participant->certificate) { //kalau ada isinya string path, hapus dulu file di storage
            Storage::delete($this->participant->certificate);
        }

        $path = $this->certificate->store('certificates', 'local');

        $this->participant->update(['certificate' => $path]);

        $this->reset('certificate');

        $this->updateParticipant();
    }

    public function downloadCertificate()
    {
        return Storage::disk('local')->download($this->participant->certificate);
    }

    public function downloadReceipt()
    {
        return Storage::disk('public')->download($this->participant->receipt_of_payment);
    }

    public function setParticipantStatus()
    {
        // kalau permissin ga bernilai null
        if ($this->status) {
            // ubah status pendaftaran
            $this->participant->update(['status_id' => $this->status]);
        }

        $this->reset('status');

        $this->emitSelf('actionDone');
    }

    // event aja biar re render datanya
    public function changeParticipantStatus()
    {
        # code...
    }

    public function certificateUploaded()
    {
        # code...
    }

    public function updateParticipant()
    {
        // kalau masih pengajuan dan udh lewat waktu pelaksanaan, set menjadi ditolak
        if ($this->participant->status_id == 1 && now() >= $this->participant->kelas->pelaksanaan) {
            $this->participant->status_id == 3;
        }

        # jika sudah diacc atau id 2, dia ga akan dapat hak akses selama belum waktu pelaksanaan. jika sudah punya hak akses, ada kemungkinan dia tidak mengerjakan sama sekali atau mengerjakan tp kehabisa waktu
        if ($this->participant->status_id == 2) {

            # kalau udah punya hak akses mengerjakan toefl
            if ($this->participant->hasPermissionTo('mengerjakan toefl')) {
                // jika batas pengerjaan sudah lewat
                if (now() >= $this->participant->kelas->akhir_pelaksanaan) { // beri akses lihat skor
                    // ambil record jawaban. apakah sudah pernah input sebelumnya
                    $lastQuestion = $this->participant->questions()->get();
                    if ($lastQuestion->isNotEmpty()) { # jika ada soal yg dijawab / kehabisa waktu menjawab soal. ubah status jd selesai
                        $this->participant->update(['status_id' => 5]);
                    } else { # jika ga kerjain sama sekali maka ubah jd kadaluwarsa
                        $this->participant->update(['status_id' => 6]);
                    }

                    $this->participant->syncPermissions(['melihat skor']);

                }

            } else { #beri hak mengerjakan toefl jika sudah masuk waktu pelaksanaan dan belum berakhir

                if (now() >= $this->participant->kelas->pelaksanaan) {
                    $this->participant->givePermissionTo(['mengerjakan toefl']);
                } 

            }

        }

        // fitur button visible. jika sudah masuk batas pendaftaran, maka hilangkan fitur button open participantnny
        if (now() > $this->participant->kelas->pelaksanaan) {
            $this->formActionVisible = false;
        } else {
            $this->formActionVisible = true;
        }
    }

    public function mount(User $participant)
    {
        $this->participant = $participant;

        // ambil status peserta yaitu terima, tolak, dan blokir sebagai aksi
        $this->statuses = ParticipantStatus::whereIn('id', [2, 3])->get();

        // jika dia sudah selesai mengerjakan (selesai toefl/ id status 5), biarkan aja ga usah diubah
        // jika peserta masih pengajuan (id status 1), ketika lewat waktu pelaksanaan, ubah jd pendaftaran ditolak.
        // jika peserta pendaftaran diterima (id status 2), maka jika :
        # tidak mengerjakan toefl sama sekali atau mengerjakan tidak selesai hingga batas akhir pelaksanaan, maka ubah jd kadaluwarsa, beri permission lihat skor.
        # ketika waktu pelaksanaan tiba, beri permission menerjakan toefl
        $this->updateParticipant();
    }

    public function render()
    {
        return view('livewire.participant.show-participant');
    }
}
