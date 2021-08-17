<?php

namespace App\Http\Livewire\Question;

use App\Models\Question;
use App\Models\Toefl;
use Livewire\Component;

class Section2 extends Component
{
    public $toefl; // berasal dari view
    public $section; // berasal dari view
    public $questions; // questions untuk navigasi

    public $subSection = 1; // set awal untuk Structure

    public $questionSelected; // soal yang dipilih untuk diedit

    /**properti untuk tabel questions */
    public $question, $option_a, $option_b, $option_c, $option_d, $key_answer;

    // rules validasi input form
    protected $rules = [
        'question' => 'required',
        'option_a' => 'required',
        'option_b' => 'required',
        'option_c' => 'required',
        'option_d' => 'required',
        'key_answer' => 'required',
    ];

    public function switchSubSection()
    {
        $this->reset(['question', 'option_a', 'option_b', 'option_c', 'option_d', 'key_answer', 'questionSelected']);
        $this->questions = $this->toefl->questions()->where('sub_section_id', $this->subSection)->get();
    }

    // tombol pindah soal
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

    // mengosongkan form input soal baru
    public function newQuestion()
    {
        $this->reset(['question', 'option_a', 'option_b', 'option_c', 'option_d', 'key_answer', 'questionSelected']);
    }

    // fungsi action save dari form
    public function save()
    {
       $this->validate(); //  validasi dulu

       /**kalau ada pertanyaan terdahulu yang dipilih untuk diubah, maka update soal tersebut*/
       if ($this->questionSelected) {
           $this->update();
       } else {
           $this->store(); /**simpan soal baru */
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
        $this->questions = Toefl::find($this->toefl->id)->questions()->where('sub_section_id', $this->subSection)->get();
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

    public function delete()
    {
        // ambil konten soal yang dipilih, yaitu questionSelected lalu hapus
        $this->questionSelected->delete();

        // hapus field input formnya
        $this->reset(['question', 'option_a', 'option_b', 'option_c', 'option_d', 'key_answer', 'questionSelected']);
        
        /**update jumlah questionnya, biar update harus akses model dulu, kalau pakai toefl instance sebelumnya ga bakan update */
        $this->questions = Toefl::find($this->toefl->id)->questions()->where('sub_section_id', $this->subSection)->get();
    }

    public function mount($toefl)
    {
        $this->questions = $toefl->questions()->where('sub_section_id', $this->subSection)->get();
    }

    public function render()
    {
        return view('livewire.question.section2');
    }
}
