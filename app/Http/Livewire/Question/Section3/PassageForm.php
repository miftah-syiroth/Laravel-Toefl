<?php

namespace App\Http\Livewire\Question\Section3;

use Livewire\Component;

class PassageForm extends Component
{
    public $toefl; // passed from view
    public $section; // passed from view

    public $passageSelected;

    // menyimpan input dari form
    public function save()
    {
        /**kalau update narasi berdasarkan nomor navigasi yg dipilih*/
        if ($this->passageSelected) {
            $this->updatePassage();
        } else {
            /**simpan soal baru */
            $this->storePassage();
        }
    }

    // menyimpan narasi baru
    public function storePassage()
    {
        $this->toefl->passages()->create([
            'naration' => $this->naration,
            'section_id' => 3,
        ]);

        $this->reset('naration'); //hapus kolom input narasi

        //update model toeflnya dulu setelah save narasi biar keubah
        $toefl = Toefl::find($this->toefl->id);
        $this->narations = $toefl->narations()->get();
    }

    public function render()
    {
        return view('livewire.question.section3.passage-form');
    }
}
