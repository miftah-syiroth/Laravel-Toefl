<?php

namespace App\Http\Livewire\Question\Section2;

use App\Models\Question;
use Livewire\Component;

class SubQuestionNavigation extends Component
{
    public $toefl; // passed from view
    public $section; // passed from view
    public $questions; // questions untuk navigasi

    public $subSection = 1;

    protected $listeners = [
        'questionAdded',
        'switchSubSection',
        'questionDeleted',
    ];

    // tombol pindah soal
    public function switchQuestion(Question $question)
    {
        // kirim id question ke dalam component form
        $this->emit('switchQuestion', $question);
    }

    // mengosongkan form input soal baru
    public function newQuestion()
    {
        /**kalau mencet tombol NEW, maka akan dihapus isi formnya. Pakai event ke form question komponen */
        $this->emit('newQuestion');
    }

    // listener dari komopen question form ketika soal baru ditambah supaya jumlah soal navigasi berubah
    public function questionAdded($questions)
    {
        // argumen bersifat array of array
        $this->questions = $questions;
    }

    // event hapus question dari form question
    public function questionDeleted($questions)
    {
        // argumen bersifat array of array
        $this->questions = $questions;
    }

    // event listener dari navigasi subsection
    public function switchSubSection($subSection)
    {
        $this->subSection = $subSection;
        $this->questions = $this->toefl->questions()->where('sub_section_id', $this->subSection)->get();
    }

    public function mount($toefl)
    {
        $this->questions = $toefl->questions()->where('sub_section_id', $this->subSection)->get();
    }

    public function render()
    {
        return view('livewire.question.section2.sub-question-navigation');
    }
}
