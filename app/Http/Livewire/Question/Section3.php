<?php

namespace App\Http\Livewire\Question;

use App\Models\Passage;
use App\Models\Question;
use App\Models\Toefl;
use Livewire\Component;

class Section3 extends Component
{
    public $toefl; // passed from view yakni toefl yg sedang dikelola
    public $section; // passed from view yakni toefl yg sedang dikelola

    public $passage; /** properti passage table */
    
    public $passages; // array atau collection dari passages of the toefl untuk navigasi
    public $passageSelected; // passage yg dipilih di navigasi passage
    public $questions; // array atau collection dari questions of the passage untuk navigasi
    public $questionSelected; // question yg dipilih di navigasi soal
    

    //properti row tabel questions
    public $question;
    public $option_a;
    public $option_b;
    public $option_c;
    public $option_d;
    public $key_answer;

    protected $rules = [
        'passage' => 'required',
        'question' => 'required',
        'option_a' => 'required',
        'option_b' => 'required',
        'option_c' => 'required',
        'option_d' => 'required',
        'key_answer' => 'required',
    ];

    /** PASSAGE METHOD */
    
    // menyimpan input dari form
    public function savePassage()
    {
        $this->validate(); // validasi

        /**kalau update narasi berdasarkan nomor navigasi yg dipilih*/
        if ($this->passageSelected) {
            $this->updatePassage();
        } else {
            $this->storePassage(); /**simpan soal baru */
        }
    }

    // menyimpan passage baru
    public function storePassage()
    {
        $this->toefl->passages()->create([
            'passage' => $this->passage,
        ]);

        $this->reset('passage'); //hapus kolom input narasi

        //update model toeflnya dulu setelah save narasi biar keubah
        $this->passages = Toefl::find($this->toefl->id)->passages()->get();

        // emit ke dalam navigasi passage untuk update jumlah passagesnya
        // $this->emit('passageAdded', $passages);
    }

    // update passage
    public function updatePassage()
    {
        $this->passageSelected->update([
            'passage' => $this->passage,
        ]);
        $this->reset(['passage', 'passageSelected']);

        # emit ke komponen question-form dan question-nav untuk dihilangkan komponennya
        // $this->emit('passageUpdated');
    }

    // action hapus passage
    public function deletePassage()
    {
        # hapus passage dan soal-soal yang menyertai
        $this->passageSelected->questions()->delete();
        $this->passageSelected->delete();

        $this->reset(['passage', 'passageSelected', 'option_a', 'option_b', 'option_c', 'option_d', 'key_answer', 'question', 'questions', 'questionSelected']);

        //update model toeflnya dulu setelah save narasi biar keubah
        $this->passages = Toefl::find($this->toefl->id)->passages()->get();

        // emit ke navigasi passage & question form & navigation form
        // $this->emit('passageDeleted');
    }

    // action dari navigasi passage
    public function switchPassage(Passage $passage)
    {
        // $this->passage = $passage->passage; // form input passage diisi dengan value model
        $this->passageSelected = $passage;

        $this->reset(['passage', 'option_a', 'option_b', 'option_c', 'option_d', 'key_answer', 'question', 'questions', 'questionSelected']);

        $this->questions = $passage->questions()->get();
    }

    // action new dari navigasi passage
    public function newPassage()
    {
        $this->reset(['passage', 'passageSelected', 'option_a', 'option_b', 'option_c', 'option_d', 'key_answer', 'question', 'questions', 'questionSelected']);
    }
    /** END PASSAGE */


    /** QUESTIONS OF PASSAGE */
    // untuk menyimpan pertanyaan dari narasi yang dipilih
    public function saveQuestion()
    {
        $this->validate(); // validasi dulu
        
        /**kalau ada pertanyaan terdahulu yang dipilih untuk diubah, maka update soal tersebut*/
        if ($this->questionSelected) {
            $this->updateQuestion();
        } else {
            $this->storeQuestion(); /**simpan soal baru */
        }
    }

    // fungsi untuk menyimpan pertanyaan baru
    public function storeQuestion()
    {
        $this->passageSelected->questions()->create([
            'section_id' => $this->section->id,
            'toefl_id' => $this->toefl->id,
            'question' => $this->question,
            'option_a' => $this->option_a,
            'option_b' => $this->option_b,
            'option_c' => $this->option_c,
            'option_d' => $this->option_d,
            'key_answer' => $this->key_answer,
        ]);

        $this->reset(['option_a', 'option_b', 'option_c', 'option_d', 'key_answer', 'question']);

        $this->questions = $this->passageSelected->questions()->get();
    }

    // fungsi untuk mengupdate pertanyaan
    public function updateQuestion()
    {
        $this->questionSelected->update([
            'question' => $this->question,
            'option_a' => $this->option_a,
            'option_b' => $this->option_b,
            'option_c' => $this->option_c,
            'option_d' => $this->option_d,
            'key_answer' => $this->key_answer,
        ]);

        $this->reset(['option_a', 'option_b', 'option_c', 'option_d', 'key_answer', 'questionSelected', 'question']);
    }

    // hapus question
    public function deleteQuestion()
    {
        // ambil konten soal yang dipilih, yaitu questionSelected lalu hapus
        $this->questionSelected->delete();

        // hapus field input formnya
        $this->reset(['option_a', 'option_b', 'option_c', 'option_d', 'key_answer', 'questionSelected', 'question']);
        
        /**update jumlah questionnya, dari narasi selected */
        $this->questions = $this->passageSelected->questions()->get();
    }

    public function switchQuestion(Question $question)
    {
        /**isi form dengan isi row dari question yang dipilih */
        $this->question = $question->question;
        $this->option_a = $question->option_a;
        $this->option_b = $question->option_b;
        $this->option_c = $question->option_c;
        $this->option_d = $question->option_d;
        $this->key_answer = $question->key_answer;

        /**questionSelected menyimpan data soal yang akan diupdate atau dipilih dari navigasi */
        $this->questionSelected = $question;
    }

    // fungsi ketika new question diklik, akan dihapus beberapa properti seperti berikut
    public function newQuestion()
    {
        /**kalau mencet tombol NEW, maka akan dihapus isi formnya */
        $this->reset(['option_a', 'option_b', 'option_c', 'option_d', 'key_answer', 'questionSelected', 'question']);
    }

    /** END QUESTIONS OF PASSAGE */

    public function mount($toefl)
    {
        $this->passages = $toefl->passages()->get();
    }

    public function render()
    {
        return view('livewire.question.section3');
    }
}
