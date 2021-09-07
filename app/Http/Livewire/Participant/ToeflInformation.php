<?php

namespace App\Http\Livewire\Participant;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class ToeflInformation extends Component
{
    public $user;
    // public $kelas;
    // public $status;

    public function startToefl()
    {
        $lastQuestion = $this->user->questions()->orderBy('question_id', 'desc')->first();

        // cek $questions, jika array ada isinya maka sudh pernah mengerjakan, jika kosong maka masih baru
        if ($lastQuestion) { // pernah mengerjakan
            
            // cek lg untuk tiap2 section, selesai dimana
            if ($lastQuestion->section_id == 1) { // section 1
                // cek lg barangkali udh selesai di akhir soal atau kehabisa waktu
                if ($lastQuestion->pivot->last_question >= 49 || $lastQuestion->pivot->last_minute <= 0) {
                    return redirect()->to('/participant/toefls/structure-and-written-expression');
                } else {
                    return redirect()->to('/participant/toefls/listening-comprehension');
                }
                
            } elseif ($lastQuestion->section_id == 2) { // section 2
                // cek lg barangkali udh di akhir soal atau kehabisan waktu
                if ($lastQuestion->pivot->last_question >= 39 || $lastQuestion->pivot->last_minute <= 0) {
                    return redirect()->to('/participant/toefls/reading-comprehension');
                } else { // belum selesai dan masih ada waktu
                    return redirect()->to('/participant/toefls/structure-and-written-expression');
                }
            } else { // section 3
                // cek lg barangkali udh di akhir soal atau kehabisan waktu
                if ($lastQuestion->pivot->last_question >= 49 || $lastQuestion->pivot->last_minute <= 0) {
                    return redirect()->to('/participant/dashboard');
                } else { // belum selesai dan masih ada waktu
                    return redirect()->to('/participant/toefls/reading-comprehension');
                }
            }
            
        } else { // belum pernah mengerjakan
            return redirect()->to('/participant/toefls/listening-comprehension');
        }
    }

    public function downloadReceipt()
    {
        // dd($this->user->receipt_of_payment);
    }

    public function checkStatusPermission()
    {
        // kalau masih pengajuan dan udh lewat waktu pelaksanaan, set menjadi ditolak
        if ($this->user->status_id == 1 && now() >= $this->user->kelas->pelaksanaan) {
            $this->user->status_id == 3;
        }

        # jika sudah diacc atau id 2, dia ga akan dapat hak akses selama belum waktu pelaksanaan. jika sudah punya hak akses, ada kemungkinan dia tidak mengerjakan sama sekali atau mengerjakan tp kehabisa waktu
        if ($this->user->status_id == 2) {

            # kalau udah punya hak akses mengerjakan toefl
            if ($this->user->hasPermissionTo('mengerjakan toefl')) {
                // jika batas pengerjaan sudah lewat
                if (now() >= $this->user->kelas->akhir_pelaksanaan) { // beri akses lihat skor
                    // ambil record jawaban. apakah sudah pernah input sebelumnya
                    $lastQuestion = $this->user->questions()->get();
                    if ($lastQuestion->isNotEmpty()) { # jika ada soal yg dijawab / kehabisa waktu menjawab soal. ubah status jd selesai
                        $this->user->update(['status_id' => 5]);
                    } else { # jika ga kerjain sama sekali maka ubah jd kadaluwarsa
                        $this->user->update(['status_id' => 6]);
                    }

                    $this->user->syncPermissions(['melihat skor']);

                }

            } else { #beri hak mengerjakan toefl jika sudah masuk waktu pelaksanaan dan belum berakhir

                if (now() >= $this->user->kelas->pelaksanaan) {
                    $this->user->givePermissionTo(['mengerjakan toefl']);
                } 

            }

        }
    }

    public function mount()
    {
        // $this->user = User::with(['kelas', 'status'])->find($user_id);
        $this->user = Auth::user()->load(['kelas', 'status', 'questions']);

        // jika dia sudah selesai mengerjakan (selesai toefl/ id status 5), biarkan aja ga usah diubah
        // jika peserta masih pengajuan (id status 1), ketika lewat waktu pelaksanaan, ubah jd pendaftaran ditolak.
        // jika peserta pendaftaran diterima (id status 2), maka jika :
        # tidak mengerjakan toefl sama sekali atau mengerjakan tidak selesai hingga batas akhir pelaksanaan, maka ubah jd kadaluwarsa, beri permission lihat skor.
        # ketika waktu pelaksanaan tiba, beri permission menerjakan toefl
        if ($this->user->status_id == 1 || $this->user->status_id == 2) {
            $this->checkStatusPermission();
        }
    }

    public function render()
    {
        return view('livewire.participant.toefl-information');
    }
}
