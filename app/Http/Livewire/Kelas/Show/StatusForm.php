<?php

namespace App\Http\Livewire\Kelas\Show;

use App\Models\Status;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class StatusForm extends Component
{
    public $kelas; // passed from view admin.kelas.show
    public $status;
    public $statuses;

    
    
    protected $rules = [
        'secondaryStatus' => 'required',
    ];

    public function changeStatus(Status $status)
    {
        
    }

    public function mount($kelas, $statuses)
    {
        $isComplete = $kelas->statuses()->where('id', 6)->first(); // cek udah complete atau blm
        if ($isComplete) {
            $this->statuses = $statuses->take(2); // published or unpublished
        } else {
            $this->statuses = $statuses->whereIn('id', [3, 4, 5, ]);
        }
    }

    public function render()
    {
        return view('livewire.kelas.show.status-form');
    }
}
