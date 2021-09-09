<?php

namespace App\Http\Livewire\Kelas;

use App\Models\Kelas;
use Livewire\Component;

class CardList extends Component
{
    public $kelas;

    public $sortBy;
    public $order;
    public $is_sorted = false;

    public $register_status;
    public $is_filtered = false;

    protected $rules = [
        'sortBy' => 'required|string',
        'order' => 'required|string',
    ];

    public function sorting()
    {
        $this->validate();
        $this->is_sorted = true;

        if ($this->is_filtered == true) {
            $this->kelas = Kelas::with(['registerStatus'])->withCount(['users'])->where('ispublished', true)->where('register_status_id', $this->register_status)->orderBy($this->sortBy, $this->order)->get();
        } else {
            $this->kelas = Kelas::with(['registerStatus'])->withCount(['users'])->where('ispublished', true)->orderBy($this->sortBy, $this->order)->get();
        }
    }

    public function filtering()
    {
        $this->is_filtered = true;

        $this->reset(['sortBy', 'order', 'is_sorted']);

        $this->kelas = Kelas::with(['registerStatus'])->withCount(['users'])->where('ispublished', true)->where('register_status_id', $this->register_status)->orderBy('id', 'DESC')->get();
    }

    public function updateKelas()
    {
        if ($this->is_sorted == true) {
            $this->sorting();
        } elseif ($this->is_filtered == true) {
            $this->filtering();
        } else {
            $this->kelas = Kelas::with(['registerStatus'])->withCount('users')->where('ispublished', true)->orderBy('pendaftaran', 'ASC')->get();
        }
    }

    public function mount()
    {
        $this->kelas = Kelas::with(['registerStatus'])->withCount('users')->where('ispublished', true)->orderBy('pendaftaran', 'ASC')->get();
    }

    public function render()
    {
        return view('livewire.kelas.card-list');
    }
}
