<?php

namespace App\Http\Livewire\ToeflWorksheet;

use App\Models\Question;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Section1 extends Component
{
    // 2100
    public $timer = 2100, $menit, $detik;

    public $toefl;

    public $answer; // input radio button

    public $question; // soal yang sedang dikerjakan
    public $arrayOfQuestions; // array of id of questions
    public $index = 0;

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

    public function saveAnswer()
    {
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
        if ($this->index + 1 == count($this->arrayOfQuestions)) { // kalau udah soal ke 50/50
            // lakukan emit ke komponen main
            return redirect()->to('/participant/toefls/structure-and-written-expression');
        } else {
            $this->index += 1;
            $this->question = $this->toefl->questions()->find($this->arrayOfQuestions[$this->index]);
        }
    }

    public function mount()
    {
        $this->toefl = Auth::user()->toefl()->first(); // ambil toefl untuk retrive audio section 1

        // ambil semua question_id dari section 1 ke sebuah array. Array akan digunakan untuk menampilkan pertanyaan satu persatu dgn index terdepan.
        $this->arrayOfQuestions= $this->toefl->questions()->where('section_id', 1)->pluck('id')->toArray();

        // cek apakah peserta sudah pernah mengerjakan soal section 2, lalu ambil index terakhir soal yg dikerjakan sebelumnya. lalu soal yg akan ditampilkan adalah +1 index terakhir
        $lastQuestion = Auth::user()->questions()->orderBy('question_id', 'desc')->first();
        
        // $this->index = $lastQuestion ? $lastQuestion->pivot->last_question + 1 : 0;

        if ($lastQuestion) {
            $this->index = $lastQuestion->pivot->last_question + 1;
            $this->timer = $lastQuestion->pivot->last_minute;
        } else {
            $this->index = 0;
        }
        
        $this->question = $this->toefl->questions()->find($this->arrayOfQuestions[$this->index]);
    }

    public function render()
    {
        return view('livewire.toefl-worksheet.section1');
    }
}
