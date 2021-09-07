<?php

namespace App\Http\Livewire\ToeflWorksheet;

use App\Models\Question;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class Section3 extends Component
{
    // 3300, sebenarnya di section udah ada detikkan. tp biarlah ga terlalu banyak query
    public $timer, $menit, $detik;
    public $index = 0;
    public $direction_visible = false;

    public $toefl;

    public $answer; // input radio button

    public $question; // soal yang sedang dikerjakan
    public $question_selected; // soal yg dipilih dari navigasi
    public $arrayOfQuestions; // array of id of questions
    public $questions_answered; // soal2 yg sudah dijawab akan menjadi navigasi utk keperluan update

    protected $rules = [
        'answer' => 'required',
    ];
    
    public function countdown()
    {
        $this->timer -= 2; //kurangi dua karena wire:poll update setiap 2 detik
        $this->menit = intval($this->timer / 60);
        $this->detik = intval($this->timer % 60);

        // cek jika timer <= 0, harus distop dan next section 2
        if ($this->timer <= 0) {
            $this->save();
            $user = Auth::user()->update([
                'status_id' => 5,
            ]);
            $user->givePermissionTo('melihat skor');
            // hapus permission mengerjakan toefl supaya ga bisa ngerjain lg
            $user->revokePermissionTo('mengerjakan toefl');
            return redirect()->to('/participant/dashboard');
        }
    }

    // ini untuk mengatur visibilitas direction
    public function directionVisible()
    {
        if ($this->direction_visible == true) {
            $this->direction_visible = false;
        } else {
            $this->direction_visible = true;
        }
    }

    public function selectQuestion(Question $question, $index)
    {
        $this->index = $index;
        $this->question_selected = Auth::user()->questions()->find($question->id);
    }

    public function save()
    {
        $this->validate();
        if ($this->question_selected) {
            $this->updateAnswer();
        } else {
            $this->storeAnswer();
        }
    }

    public function updateAnswer()
    {
        // score 1 jika answer == key_answer, 0 jika salah
        $score = $this->question_selected->key_answer == $this->answer ? 1 : 0;

        // update jawaban
        Auth::user()->questions()->updateExistingPivot($this->question_selected->id, [
            'answer' => $this->answer,
            'score' => $score,
            'last_question' => $this->index,
            'last_minute' => $this->timer,
        ]);

        $this->reset(['question_selected', 'answer']);

        // kembalikan ke soal terakhir
        $this->lastQuestion();
    }

    public function storeAnswer()
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
            // buat status sudah peserta menjadi sudah selesai toefl
            $user = Auth::user()->update([
                'status_id' => 5,
            ]);
            $user->givePermissionTo('melihat skor');
            // hapus permission mengerjakan toefl supaya ga bisa ngerjain lg
            $user->revokePermissionTo('mengerjakan toefl');
            // lakukan redirect
            return redirect()->to('/participant/dashboard');
        } else {
            $this->index += 1;
            // mestinya bisa pakai method lastquestion(), tp males
            $this->question = $this->toefl->questions()->find($this->arrayOfQuestions[$this->index]);
            $this->questions_answered = Auth::user()->questions()->with('passage')->where('section_id', 3)->orderBy('passage_id', 'ASC')->orderBy('id')->get();
        }
    }

    public function lastQuestion()
    {
        $this->reset(['question_selected']);
        // method ini akan mengembalikan $this-question pada soal terakhir, mengatur index dan timer

        // ketika baru akan mengerjakan section 3, maka last_question = 39 yg diambil dari index array terakhir soal section 2. bisa juga dia selesai section 2 krn kehabisan waktu atau last_minute <=0. ini mestinya bisa pakai last(), tp ga bisa, jd urutin dulu kebalik lalu first
        $lastQuestion = Auth::user()->questions()->orderBy('passage_id', 'DESC')->orderBy('id', 'DESC')->first();

        // kalau section_id dari soal sebelumnya adalah 3, maka timer set pada menit terakhir dan index pada soal terakhir + 1. sedangkan jika bukan section_2 (section_1) maka index dibuat 0 atau index pertama, dan timer mengikuti nilai default.
        if ($lastQuestion->section_id == 3) {
            $this->index = $lastQuestion->pivot->last_question + 1;
            $this->timer = $lastQuestion->pivot->last_minute;
        } else {
            $this->index = 0;
            $this->timer = 3300;
        }

        // soal yg terakhir akan ditampilkan untuk dijawab
        $this->question = $this->toefl->questions()->find($this->arrayOfQuestions[$this->index]);
    }

    public function mount()
    {
        $this->toefl = Auth::user()->toefl()->first(); // ambil toefl
        // ambil semua question_id dari section 3 ke sebuah array. Array akan digunakan untuk menampilkan pertanyaan satu persatu dgn index terdepan. urutkan pertama kali berdasarkan passage_id lalu id soal
        $this->arrayOfQuestions=$this->toefl->questions()->where('section_id', 3)->orderBy('passage_id', 'ASC')->orderBy('id')->pluck('id')->toArray();

        // soal2 yg pernah dijawab oleh user akan dijadikan navigasi
        $this->questions_answered = Auth::user()->questions()->with('passage')->where('section_id', 3)->orderBy('passage_id', 'ASC')->orderBy('id')->get();
        // dd($this->questions_answered);

        $this->lastQuestion();
    }

    public function render()
    {
        return view('livewire.toefl-worksheet.section3');
    }
}
