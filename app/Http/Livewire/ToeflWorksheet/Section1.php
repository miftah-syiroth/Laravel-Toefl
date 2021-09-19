<?php

namespace App\Http\Livewire\ToeflWorksheet;

use App\Models\Question;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Section1 extends Component
{
    // 2100
    public $timer = 21, $menit, $detik;

    public $toefl;

    public $answer; // input radio button

    public $direction;

    public $question; // soal yang sedang dikerjakan
    public $arrayOfQuestions; // array of id of questions
    public $index = 0;

    protected $rules = [
        'answer' => 'required'
    ];

    public function countdown()
    {
        $this->timer -= 2; //kurangi dua karena wire:poll update setiap 2 detik
        $this->menit = intval($this->timer / 60);
        $this->detik = intval($this->timer % 60);

        // cek jika timer <= 0, harus distop dan next section 2
        if ($this->timer <= 0) {
            $this->saveAnswer();
            return redirect()->to('/participant/toefls/structure-and-written-expression');
        }
    }

    public function checkDirection()
    {
        if ($this->index < 30) {
            $this->direction = $this->toefl->part_a_imageable;
        } elseif ($this->index < 38) {
            $this->direction = $this->toefl->part_b_imageable;
        } else {
            $this->direction = $this->toefl->part_c_imageable;
        }
    }

    public function saveAnswer()
    {
        // $this->validate();
        
        // score 1 jika answer == key_answer, 0 jika salah
        $score = $this->question->key_answer == $this->answer ? 1 : 0;

        // simpan jawaban ke tabel intermediate
        Auth::user()->questions()->attach($this->question->id, [
            'answer' => $this->answer,
            'score' => $score,
            'last_question' => $this->index,
            'last_minute' => $this->timer,
        ]);

        $this->reset('answer');

        // cek if sudah soal terakhir, jika terakhir akan dioper ke section 2
        if ($this->index + 1 == count($this->arrayOfQuestions)) { // indeks ke 49 yaitu udah soal ke 50/50
            // lakukan redirect ke komponen main
            return redirect()->to('/participant/toefls/structure-and-written-expression');
        } else { // ga perlu pakai else jg bisa, kan return lgsg
            $this->index += 1;
            $this->question = $this->toefl->questions()->find($this->arrayOfQuestions[$this->index]);
            $this->checkDirection();
        }
    }

    public function mount()
    {
        $this->toefl = Auth::user()->toefl()->first(); // ambil toefl untuk retrive audio section 1

        // ambil semua question_id dari soal toefl dgn section 1 ke sebuah array. pembuatan soal oleh admin urutan, jd aman. Array akan digunakan untuk menampilkan pertanyaan satu persatu dgn index terdepan.
        $this->arrayOfQuestions= $this->toefl->questions()->where('section_id', 1)->pluck('id')->toArray();

        // cek apakah peserta sudah pernah mengerjakan soal section 1 (melanjutkan krn sebelumnya keluar lembar soal), lalu ambil index terakhir soal yg dikerjakan sebelumnya. lalu soal yg akan ditampilkan adalah +1 index terakhir.  data diambil dari tabel pivot answers. query dibawah bersifat umum dan mungkin mengembalikan soal terakhir yg bukan section_1, tp ini sudah difilter bahwa yg mengakses page ini hanya yg mengerjakan section 1.
        $lastQuestion = Auth::user()->questions()->orderBy('question_id', 'desc')->first();

        if ($lastQuestion) { # jika not null, artinya melanjutkkan pekerjaan sebelumnya
            $this->index = $lastQuestion->pivot->last_question + 1; #kolom last_question menyimpan index terakhir
            $this->timer = $lastQuestion->pivot->last_minute; #kolim last_minute menyimpan sisa waktu terakhir
        } else {
            $this->index = 0;
        }
        
        $this->checkDirection();
        $this->question = $this->toefl->questions()->find($this->arrayOfQuestions[$this->index]);
    }

    public function render()
    {
        return view('livewire.toefl-worksheet.section1');
    }
}
