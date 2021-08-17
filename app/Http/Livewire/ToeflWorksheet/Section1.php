<?php

namespace App\Http\Livewire\ToeflWorksheet;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Section1 extends Component
{
    public $timer = 2100, $menit, $detik;

    public $toefl;

    public function countdown()
    {
        $this->timer -= 1; //kurangi dua karena wire:poll update setiap 2 detik
        $this->menit = intval($this->timer / 60);
        $this->detik = intval($this->timer % 60);
    }

    public function mount()
    {
        $this->toefl = Auth::user()->toefl()->first();
    }

    public function render()
    {
        return view('livewire.toefl-worksheet.section1');
    }
}
