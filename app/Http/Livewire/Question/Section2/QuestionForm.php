<?php

namespace App\Http\Livewire\Question\Section2;

use App\Models\Question;
use App\Models\Toefl;
use Livewire\Component;

class QuestionForm extends Component
{
    public $toefl; // passed from view or route or url
    public $section; // passed from view or route or url
    public $subSection = 1; // passed from event switch sub section, defaultnya structure
    public $questionSelected; // soal yang dipilih untuk diedit

    //  listeners yang berasal dari navigasi sub section dan navigasi soal
    protected $listeners = [
        'switchSubSection',
        'switchQuestion',
        'newQuestion',
    ];

    /**properti untuk tabel questions */
    public $question;
    public $option_a;
    public $option_b;
    public $option_c;
    public $option_d;
    public $key_answer;

    // rules validasi input form
    protected $rules = [
        'question' => 'required',
        'option_a' => 'required',
        'option_b' => 'required',
        'option_c' => 'required',
        'option_d' => 'required',
        'key_answer' => 'required',
    ];

    // fungsi action save dari form
    public function save()
    {
       //  validasi dulu
       $this->validate();

       /**kalau ada pertanyaan terdahulu yang dipilih untuk diubah, maka update soal tersebut*/
       if ($this->questionSelected) {
           $this->update();
       } else {
           /**simpan soal baru */
           $this->store();
       }
    }

    //  fungsi menyimpan soal baru
    public function store()
    {
        /** ini sementara untuk create */
        $this->toefl->questions()->create([
            'sub_section_id' => $this->subSection,
            'section_id' => $this->section->id,
            'question' => $this->question,
            'option_a' => $this->option_a,
            'option_b' => $this->option_b,
            'option_c' => $this->option_c,
            'option_d' => $this->option_d,
            'key_answer' => $this->key_answer,
        ]);

        // hapus field input
        $this->reset(['question', 'option_a', 'option_b', 'option_c', 'option_d', 'key_answer']);
        // update database dan emit ke komponen navigasi soal
        $questions = Toefl::find($this->toefl->id)->questions()->where('sub_section_id', $this->subSection)->get();
        $this->emit('questionAdded', $questions);
    }

    //  fungsi mengupdate soal yang dipilih dari navigasi soal
    public function update()
    {
        $this->questionSelected->update([
            'question' => $this->question,
            'option_a' => $this->option_a,
            'option_b' => $this->option_b,
            'option_c' => $this->option_c,
            'option_d' => $this->option_d,
            'key_answer' => $this->key_answer,
        ]);

        $this->reset(['question', 'option_a', 'option_b', 'option_c', 'option_d', 'key_answer', 'questionSelected']);
    }

    // 
    public function delete()
    {
        // ambil konten soal yang dipilih, yaitu questionSelected lalu hapus
        $this->questionSelected->delete();

        // hapus field input formnya
        $this->reset(['question', 'option_a', 'option_b', 'option_c', 'option_d', 'key_answer', 'questionSelected']);
        
        /**update jumlah questionnya, biar update harus akses model dulu, kalau pakai toefl instance sebelumnya ga bakan update */
        $questions = Toefl::find($this->toefl->id)->questions()->where('sub_section_id', $this->subSection)->get();

        // emit akan dibaca oleh navigasi soal
        $this->emit('questionDeleted', $questions);
    }

    // listener event ketika ganti sub section, maka akan diganti properti sub section dan dihapus input formnya
    public function switchSubSection($subSection)
    {
        $this->subSection = $subSection;
        $this->reset(['question', 'option_a', 'option_b', 'option_c', 'option_d', 'key_answer', 'questionSelected']);
    }

    // listener dari switch question dari komponen Sub section question navigation
    public function switchQuestion(Question $question)
    {
        /**isi form dengan isi row dari question yang dipilih */
        $this->question = $question->question;
        $this->option_a = $question->option_a;
        $this->option_b = $question->option_b;
        $this->option_c = $question->option_c;
        $this->option_d = $question->option_d;
        $this->key_answer = $question->key_answer;

        /**questionSelected menyimpan collection soal yang akan diupdate atau dipilih dari navigasi soal */
        $this->questionSelected = $question;
    }

    // listener new question dari navigasi soal. digunakan untuk membersihkan form
    public function newQuestion()
    {
        $this->reset(['question', 'option_a', 'option_b', 'option_c', 'option_d', 'key_answer', 'questionSelected']);
    }

    public function render()
    {
        return view('livewire.question.section2.question-form');
    }
}
