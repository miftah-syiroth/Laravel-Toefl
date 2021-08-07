<?php

namespace App\Http\Livewire\Question\Section2;

use Livewire\Component;

class SubSectionNavigation extends Component
{
    public $toefl; // berasal dari view, BELUM DIGUNAKAN
    public $section; // berasal dari view

    public $subSection = 1; // set awal untuk Structure

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
        return view('livewire.question.section2.sub-section-navigation');
    }
}
