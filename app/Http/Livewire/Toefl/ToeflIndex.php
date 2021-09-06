<?php

namespace App\Http\Livewire\Toefl;

use App\Models\Toefl;
use Livewire\Component;

class ToeflIndex extends Component
{
    public $toefls;

    public function mount()
    {
        $this->toefls = Toefl::with(['kelas'])->withCount(['questions', 'kelas', 'users'])->orderBy('id', 'DESC')->get();
    }

    public function render()
    {
        return view('livewire.toefl.toefl-index');
    }
}
