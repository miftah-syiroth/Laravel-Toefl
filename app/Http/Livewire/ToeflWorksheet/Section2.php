<?php

namespace App\Http\Livewire\ToeflWorksheet;

use App\Models\Question;
use App\Models\SubSection;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Section2 extends Component
{
    // 1500
    public $timer = 1500, $menit, $detik;

    public $toefl;
    public $arrayOfQuestions; // array of id of questions
    public $answer; // input radio button
    public $sub_section;
    public $question; // soal yang sedang dikerjakan
    public $question_selected;
    public $index = 0;
    public $direction; // petunjuk yg ditampilkan berdasarkan interval soal. cek fungsi checkDirection
    public $questions_answered; // soal2 yg sudah dijawab akan menjadi navigasi utk keperluan update

    protected $rules = [
        'answer' => 'required',
    ];

    public function countdown()
    {
        $this->timer -= 2; //kurangi dua karena wire:poll update setiap 2 detik
        $this->menit = intval($this->timer / 60);
        $this->detik = intval($this->timer % 60);

        // cek jika timer <= 0, harus distop dan next section 3
        if ($this->timer <= 0) {
            $this->save();
            return redirect()->to('/participant/toefls/reading-comprehension');
        }
    }

    /**
     * fungsi ini mengecek sudah sub section apa, direction yg perlu dimunculkan. dan pada sub section written expression, pertanyaan menggunakan gambar
     */
    public function checkSubSection()
    {
        if ($this->index < 15) {
            $this->sub_section = SubSection::find(1);
            $this->direction = $this->toefl->structure_imageable;
        } else {
            $this->sub_section = SubSection::find(2);
            $this->direction = $this->toefl->written_expression_imageable;
        }
    }

    public function selectQuestion(Question $question, $index)
    {
        $this->index = $index;
        $this->question_selected = Auth::user()->questions()->find($question->id);
        $this->checkSubSection();
    }

    public function lastQuestion()
    {
        $this->reset(['question_selected']);
        // method ini akan mengembalikan $this-question pada soal terakhir, mengatur index dan timer

        // ketika baru akan mengerjakan section 2, maka last_question = 49 yg diambil dari index array soal section 1. Sedangkan section 2 index hanya sampai 39. bisa juga dia selesai section 1 krn kehabisan waktu atau last_minute <=0. ini mestinya bisa pakai last(), tp ga bisa, jd urutin dulu kebalik lalu first
        $lastQuestion = Auth::user()->questions()->orderBy('question_id', 'desc')->first();

        // kalau section_id dari soal sebelumnya adalah 2, maka timer set pada menit terakhir dan index pada soal terakhir + 1. sedangkan jika bukan section_2 (section_1) maka index dibuat 0 atau index pertama, dan timer mengikuti nilai default.
        if ($lastQuestion->section_id == 2) {
            $this->index = $lastQuestion->pivot->last_question + 1;
            $this->timer = $lastQuestion->pivot->last_minute;
        } else {
            $this->index = 0;
            $this->timer = 1500;
        }

        // soal yg terakhir akan ditampilkan untuk dijawab
        $this->question = $this->toefl->questions()->find($this->arrayOfQuestions[$this->index]);
    }

    public function save()
    {
        $this->validate();
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

        // simpan baru jawaban ke tabel intermediate
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
            return redirect()->to('/participant/toefls/reading-comprehension');
        } else {
            $this->index += 1;
            $this->question = $this->toefl->questions()->find($this->arrayOfQuestions[$this->index]);
            $this->questions_answered = Auth::user()->questions()->where('section_id', 2)->get();
            $this->checkSubSection();
        }
    }

    public function mount()
    {
        $this->toefl = Auth::user()->toefl()->first(); // ambil toefl
        // ambil semua question_id dari section 2 ke sebuah array. Array akan digunakan untuk menampilkan pertanyaan satu persatu dgn index terdepan.
        $this->arrayOfQuestions=$this->toefl->questions()->where('section_id', 2)->pluck('id')->toArray();
        // soal2 yg pernah dijawab oleh user akan dijadikan navigasi
        $this->questions_answered = Auth::user()->questions()->where('section_id', 2)->get();

        $this->lastQuestion();

        $this->checkSubSection(); #fungsi untuk menampilkan direction dan lainnya
    }

    public function render()
    {
        return view('livewire.toefl-worksheet.section2');
    }
}
