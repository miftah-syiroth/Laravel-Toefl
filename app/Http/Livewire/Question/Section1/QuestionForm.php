<?php

namespace App\Http\Livewire\Question\Section1;

use App\Models\Question;
use App\Models\SubSection;
use App\Models\Toefl;
use Livewire\Component;

class QuestionForm extends Component
{
    public $toefl; // passed from view or route or url
    public $section; // passed from view or route or url
    public $subSection = 3; // passed from event switch sub section, defaultnya part A
    public $questionSelected; // soal yang dipilih untuk diedit

    /**properti untuk tabel questions */
    public $option_a;
    public $option_b;
    public $option_c;
    public $option_d;
    public $key_answer;

    //  listeners yang berasal dari navigasi sub section
    protected $listeners = [
        'switchSubSection',
        'switchQuestion',
        'newQuestion',
    ];

    // rules validasi input form
    protected $rules = [
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
            'option_a' => $this->option_a,
            'option_b' => $this->option_b,
            'option_c' => $this->option_c,
            'option_d' => $this->option_d,
            'key_answer' => $this->key_answer,
        ]);

        // hapus field input
        $this->reset(['option_a', 'option_b', 'option_c', 'option_d', 'key_answer']);
        // update database dan emit ke komponen navigasi soal
        $questions = Toefl::find($this->toefl->id)->questions()->where('sub_section_id', $this->subSection)->get();
        $this->emit('questionAdded', $questions);
    }

    //  fungsi mengupdate soal yang dipilih dari navigasi soal
    public function update()
    {
        $this->questionSelected->update([
            'option_a' => $this->option_a,
            'option_b' => $this->option_b,
            'option_c' => $this->option_c,
            'option_d' => $this->option_d,
            'key_answer' => $this->key_answer,
        ]);

        $this->reset(['option_a', 'option_b', 'option_c', 'option_d', 'key_answer', 'questionSelected']);
    }

    public function delete()
    {
        // ambil konten soal yang dipilih, yaitu questionSelected lalu hapus
        $this->questionSelected->delete();

        // hapus field input formnya
        $this->reset(['option_a', 'option_b', 'option_c', 'option_d', 'key_answer', 'questionSelected']);
        
        /**update jumlah questionnya, biar update harus akses model dulu, kalau pakai toefl instance sebelumnya ga bakan update */
        $questions = Toefl::find($this->toefl->id)->questions()->where('sub_section_id', $this->subSection)->get();
        $this->emit('questionDeleted', $questions);
    }

    //  listener switch sub section dari komponen sub section navigation
    public function switchSubSection($subSection)
    {
        $this->subSection = $subSection;
        $this->reset(['option_a', 'option_b', 'option_c', 'option_d', 'key_answer', 'questionSelected']);
    }

    // listener dari switch question dari komponen Sub section question navigation
    public function switchQuestion(Question $question)
    {
        /**isi form dengan isi row dari question yang dipilih */
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
        $this->reset(['option_a', 'option_b', 'option_c', 'option_d', 'key_answer', 'questionSelected']);
    }

    public function render()
    {
        return view('livewire.question.section1.question-form');
    }
}
