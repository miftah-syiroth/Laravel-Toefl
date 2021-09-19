<?php

namespace App\Http\Livewire\Toefl;

use App\Models\Toefl;
use Livewire\Component;

class ToeflIndex extends Component
{
    public $toefls;

    public $sortBy;
    public $order;
    public $is_sorted = false;

    protected $rules = [
        'sortBy' => 'required|string',
        'order' => 'required|string',
    ];

    public function sorting()
    {
        $this->validate();
        
        $this->is_sorted = true;

        $this->toefls = Toefl::withCount(['questions', 'kelas', 'users'])->orderBy($this->sortBy, $this->order)->get();
    }

    public function updateToefls()
    {
        if ($this->is_sorted == true) {
            $this->sorting();
        } else {
            $this->toefls = Toefl::withCount(['questions', 'kelas', 'users'])->orderBy('id', 'DESC')->get();
        }
        
    }

    public function mount()
    {
        $this->toefls = Toefl::withCount(['questions', 'kelas', 'users'])->orderBy('id', 'DESC')->get();
    }

    public function render()
    {
        return view('livewire.toefl.toefl-index');
    }
}
