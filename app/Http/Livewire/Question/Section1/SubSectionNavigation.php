<?php

namespace App\Http\Livewire\Question\Section1;

use Livewire\Component;

class SubSectionNavigation extends Component
{
    public $toefl; // berasal dari view, BELUM DIGUNAKAN
    public $section; // berasal dari view

    public $subSection = 3; // set awal untuk part A

    public function changeSubSection()
    {
        // emit akan dibaca oleh komponen form dan navigasi soal
        // kirim id subSection aja, masih ragu mau kirim model atau id
        $this->emit('switchSubSection', $this->subSection);
    }

    public function mount($toefl, $section)
    {
        #
    }

    public function render()
    {
        return view('livewire.question.section1.sub-section-navigation');
    }
}
