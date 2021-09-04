<?php

namespace App\Http\Livewire\Question;

use App\Models\Passage;
use App\Models\Question;
use App\Models\Toefl;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class CreateSection3 extends Component
{
    use WithFileUploads;

    public $toefl;
    public $questions;
    public $passages;
    public $isComplete;
    public $max_questions = 50;

    public $passage_selected; // passage yg dipilih dari navigasi
    public $question_selected;

    /**properti untuk tabel questions */
    public $question, $option_a, $option_b, $option_c, $option_d, $key_answer;

    # properti untuk tabel passages
    public $passage; // di table namanya imageable

    protected $rules = [
        'question' => 'required',
        'option_a' => 'required',
        'option_b' => 'required',
        'option_c' => 'required',
        'option_d' => 'required',
        'key_answer' => 'required',
    ];

    public function newPassage()
    {
        $this->reset(['passage', 'passage_selected', 'option_a', 'option_b', 'option_c', 'option_d', 'key_answer', 'question', 'questions', 'question_selected']);
    }

    // action dari navigasi passage
    public function selectPassage(Passage $passage)
    {
        $this->passage_selected = $passage; # masukkan retrived row ke properti passage selected

        $this->reset(['passage', 'option_a', 'option_b', 'option_c', 'option_d', 'key_answer', 'question', 'question_selected']);
        
        $this->questions = $this->passage_selected->questions()->get();
    }

    // menyimpan input dari form
    public function savePassage()
    {
        $this->validate([
            'passage' => 'required|image',
        ]);

        /**kalau update narasi berdasarkan nomor navigasi yg dipilih*/
        if ($this->passage_selected) {
            $this->updatePassage();
        } else {
            $this->storePassage(); /**simpan soal baru */
        }
    }

    // menyimpan passage baru
    public function storePassage()
    {
        if (!$this->isComplete) {
            $this->passage = $this->passage->store("toefl/images/passages");

            $this->toefl->passages()->create([
                'imageable' => $this->passage,
            ]);

            //update model toeflnya dulu setelah save narasi biar keubah
            $this->passages = Toefl::find($this->toefl->id)->passages()->get();

            $this->reset(['passage', 'passage_selected']);
        } else {
            session()->flash('message', 'Soal sudah maksimal');
        }
    }

    // update passage
    public function updatePassage()
    {
        Storage::delete($this->passage_selected->imageable); // hapus gambar sebelumnya dari storage
        $this->passage = $this->passage->store("toefl/images/question/written-expression");

        $this->passage_selected->update([
            'imageable' => $this->passage,
        ]);
        $this->reset(['passage', 'passage_selected']);
    }


    // ini method untuk pembuatan soal

    public function selectQuestion(Question $question)
    {
        /**isi form dengan isi row dari question yang dipilih */
        $this->question = $question->question;
        $this->option_a = $question->option_a;
        $this->option_b = $question->option_b;
        $this->option_c = $question->option_c;
        $this->option_d = $question->option_d;
        $this->key_answer = $question->key_answer;

        /**questionSelected menyimpan data soal yang akan diupdate atau dipilih dari navigasi */
        $this->question_selected = $question;
    }

    // fungsi ketika new question diklik, akan dihapus beberapa properti seperti berikut
    public function newQuestion()
    {
        /**kalau mencet tombol NEW, maka akan dihapus isi formnya */
        $this->reset(['option_a', 'option_b', 'option_c', 'option_d', 'key_answer', 'question_selected', 'question']);
    }

    public function saveQuestion()
    {
        $this->validate(); // validasi dulu
        
        /**kalau ada pertanyaan terdahulu yang dipilih untuk diubah, maka update soal tersebut*/
        if ($this->question_selected) {
            $this->updateQuestion();
        } else {
            $this->storeQuestion(); /**simpan soal baru */
        }
    }

    // fungsi untuk menyimpan pertanyaan baru
    public function storeQuestion()
    {
        $this->passage_selected->questions()->create([
            'section_id' => 3,
            'toefl_id' => $this->toefl->id,
            'question' => $this->question,
            'option_a' => $this->option_a,
            'option_b' => $this->option_b,
            'option_c' => $this->option_c,
            'option_d' => $this->option_d,
            'key_answer' => $this->key_answer,
        ]);

        $this->reset(['option_a', 'option_b', 'option_c', 'option_d', 'key_answer', 'question']);

        $this->questions = $this->passage_selected->questions()->get();
    }

    // fungsi untuk mengupdate pertanyaan
    public function updateQuestion()
    {
        $this->question_selected->update([
            'question' => $this->question,
            'option_a' => $this->option_a,
            'option_b' => $this->option_b,
            'option_c' => $this->option_c,
            'option_d' => $this->option_d,
            'key_answer' => $this->key_answer,
        ]);

        $this->reset(['option_a', 'option_b', 'option_c', 'option_d', 'key_answer', 'question_selected', 'question']);
    }

    public function mount(Toefl $toefl)
    {
        $this->toefl = $toefl;

        # pembuatan soal dibuat urut dari section 1 s,d 3. Maka cek apakah section sebelumnya sudah full atau blm.
        if ($toefl->questions()->where('section_id', 2)->count() < 40) {
            session()->flash('message', 'Mulai dari Section 2');
            return redirect()->to('/admin/toefls/' . $toefl->id);
        }

        // # perlu menentukan sekarang sub section apa
        // $this->questions = $toefl->questions()->where('section_id', 3)->get();
        # ambil passages yg ada
        $this->passages = $toefl->passages()->get();
        # cek udah complete 50 atau belum
        $this->isComplete = $toefl->questions()->where('section_id', 3)->count() == 50 ? true : false;
    }

    public function render()
    {
        return view('livewire.question.create-section3');
    }
}
