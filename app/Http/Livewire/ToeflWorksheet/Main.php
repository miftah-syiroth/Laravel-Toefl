<?php

namespace App\Http\Livewire\ToeflWorksheet;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Main extends Component
{
    // public $lastQuestion; //pertanyaan terakhir yg dikerjakan
    public $button = '';
    public $status; // 1 for new, 2 for continue, 3 for end

    public function startToefl()
    {
        $lastQuestion = Auth::user()->questions()->orderBy('question_id', 'desc')->first();

        // cek $questions, jika array ada isinya maka sudh pernah mengerjakan, jika kosong maka masih baru
        if ($lastQuestion) { // pernah mengerjakan
            
            // cek lg untuk tiap2 section
            if ($lastQuestion->section_id == 1) { // section 1
                // cek lg barangkali udh selesai di akhir soal atau kehabisa waktu
                if ($lastQuestion->pivot->last_question >= 49 || $lastQuestion->pivot->last_minute <= 0) {
                    return redirect()->to('/participant/toefls/structure-and-written-expression');
                } else {
                    return redirect()->to('/participant/toefls/listening-comprehension');
                }
                // return redirect()->to('/participant/toefls/listening-comprehension');
                
            } elseif ($lastQuestion->section_id == 2) { // section 2
                // cek lg barangkali udh di akhir soal atau kehabisan waktu
                if ($lastQuestion->pivot->last_question >= 39 || $lastQuestion->pivot->last_minute <= 0) {
                    return redirect()->to('/participant/toefls/reading-comprehension');
                } else { // belum selesai dan masih ada waktu
                    return redirect()->to('/participant/toefls/structure-and-written-expression');
                }
                // return redirect()->to('/participant/toefls/structure-and-written-expression');
            } else { // section 3
                // cek lg barangkali udh di akhir soal atau kehabisan waktu
                if ($lastQuestion->pivot->last_question >= 49 || $lastQuestion->pivot->last_minute <= 0) {
                    return redirect()->to('/participant/dashboard');
                } else { // belum selesai dan masih ada waktu
                    return redirect()->to('/participant/toefls/reading-comprehension');
                }
                // return redirect()->to('/participant/toefls/reading-comprehension');
            }
            
        } else { // belum pernah mengerjakan
            return redirect()->to('/participant/toefls/listening-comprehension');
        }
    }

    public function mount()
    {
        # di sini dicek nih, apakah test baru, atau pekerjaan lama, atau sudah selesai.
        $lastQuestion = Auth::user()->questions()->orderBy('question_id', 'desc')->first();
        # jika baru atau lama maka akan ada tombol link redirect ke /participant/toefls/examination, controller yg akan memeriksa selanjutnya, jika sudah selesai maka munculkan informasi selesai tanpa ada tombol link
        if ($lastQuestion) { // pekerjaan lama atau sdh selesai
            # selesai adalah jika melewati waktu pelaksanaan ATAU berada pada section 3 soal ke 50 ATAU section 3 dgn last_minute <=0. SYARAT PERTAMA BELUM DIIMPLEMENTASI
            if ($lastQuestion->section_id == 3 && ($lastQuestion->pivot->last_question >= 49 || $lastQuestion->pivot->last_minute <= 0)) {
                $this->status = 3;
            } else {
                $this->status = 2;
                $this->button = 'Lanjutkan Toefl';
            }
            
        } else {
            $this->status = 1;
            $this->button = 'Mulai Toefl';
        }
    }

    public function render()
    {
        return view('livewire.toefl-worksheet.main');
    }
}
