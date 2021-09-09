<?php

namespace App\Exports;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ParticipantsExport implements FromView
{
    public $participants;

    public function __construct($participants)
    {
        $this->participants = $participants;
    }

    public function view(): View
    {
        return view('admin.participant.export', [
            'participants' => $this->participants,
        ]);
    }
}
