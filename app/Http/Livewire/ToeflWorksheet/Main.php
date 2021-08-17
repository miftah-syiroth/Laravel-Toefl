<?php

namespace App\Http\Livewire\ToeflWorksheet;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Main extends Component
{
    // [ 1=>'main', 2=>section1 , 3=> section2, 4=>section3 ]
    public $content = 1;
    public $user;

    public function startToefl()
    {
        // ketika tombol start dimulai, maka akan merender komponen section 1 dengan timernya.
        $this->content = 2;
    }

    public function mount()
    {
        $this->user = Auth::user();
    }

    public function render()
    {
        return view('livewire.toefl-worksheet.main');
    }
}
