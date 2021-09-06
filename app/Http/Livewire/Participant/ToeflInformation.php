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

    public function mount()
    {
        // $this->user = User::with(['kelas', 'status'])->find($user_id);
        $this->user = Auth::user()->load(['kelas', 'status', 'questions']);

        if ($this->user->status->id == 2 && now() >= $this->user->kelas->pelaksanaan) {
            $this->user->givePermissionTo(['mengerjakan toefl']);
        }
    }

    public function render()
    {
        return view('livewire.participant.toefl-information');
    }
}
