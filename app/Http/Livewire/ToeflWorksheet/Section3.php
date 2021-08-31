<?php

namespace App\Http\Livewire\ToeflWorksheet;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class Section3 extends Component
{
    // 3300, sebenarnya di section udah ada detikkan. tp biarlah ga terlalu banyak query
    public $timer = 30, $menit, $detik;

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
            Auth::user()->syncPermissions('view certificate');
            return redirect()->to('/participant/dashboard');
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
            // buat permission view certificate ke user
            Auth::user()->syncPermissions('view certificate');
            // $user->syncPermissions('view status');
            // lakukan redirect
            return redirect()->to('/participant/dashboard');
        } else {
            $this->index += 1;
            $this->question = $this->toefl->questions()->find($this->arrayOfQuestions[$this->index]);
        }
    }

    public function mount()
    {
        $this->toefl = Auth::user()->toefl()->first(); // ambil toefl
        // ambil semua question_id dari section 3 ke sebuah array. Array akan digunakan untuk menampilkan pertanyaan satu persatu dgn index terdepan.
        $this->arrayOfQuestions=$this->toefl->questions()->where('section_id', 3)->pluck('id')->toArray();

        // ketika baru akan mengerjakan section 3, maka last_question = 39 yg diambil dari index array soal section 1. Sedangkan section 2 index hanya sampai 39. bisa juga dia selesai section 1 krn kehabisan waktu atau last_minute <=0
        $lastQuestion = Auth::user()->questions()->orderBy('question_id', 'desc')->first();

        // cek. jika section id adalah 3, maka gunakan timer dan index soal terakhir sebagai kelanjutannya. jika bukan section id 3, yaitu section 2 soal terakhir atau kehabisan waktu, maka set index dan timer secara default.
        if ($lastQuestion->section_id == 3) {
            $this->index = $lastQuestion->pivot->last_question + 1;
            $this->timer = $lastQuestion->pivot->last_minute;
        }

        $this->question = $this->toefl->questions()->find($this->arrayOfQuestions[$this->index]);
    }

    public function render()
    {
        return view('livewire.toefl-worksheet.section3');
    }
}
