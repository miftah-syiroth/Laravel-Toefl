<?php

namespace App\Http\Livewire\Participant;

use App\Models\ParticipantStatus;
use App\Models\User;
use Livewire\Component;
use Livewire\WithFileUploads;

class ShowParticipant extends Component
{
    use WithFileUploads;

    public $participant;

    public $statuses;
    public $status; # ini adalah aksi yg diberikan kepada peserta untuk merubah status pendaftaran

    public $certificate;

    protected $listeners = [
        'actionDone' => 'changeParticipantStatus',
        'certificateUploaded',
    ];

    public function uploadCertificate()
    {
        $this->validate([
            'certificate' => 'image|required',
        ]);

        $path = $this->certificate->store('certificates', 'local');

        $this->participant->update(['certificate' => $path]);

        $this->reset('certificate');

        $this->emitSelf('certificateUploaded');
    }

    public function actionToParticipant()
    {
        // kalau permissin ga bernilai null
        if ($this->status) {
            // ubah status pendaftaran
            $this->participant->update(['status_id' => $this->status]);
        }

        $this->reset('status');

        $this->emitSelf('actionDone');
    }

    // event aja biar re render datanya
    public function changeParticipantStatus()
    {
        # code...
    }

    public function certificateUploaded()
    {
        # code...
    }

    public function mount($participant)
    {
        $this->participant = User::with('status')->find($participant);

        // ambil status peserta yaitu terima, tolak, dan blokir sebagai aksi
        $this->statuses = ParticipantStatus::whereIn('id', [2, 3, 4])->get();
    }

    public function render()
    {
        return view('livewire.participant.show-participant');
    }
}
