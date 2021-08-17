<?php

namespace App\Http\Controllers;

use App\Actions\Fortify\PasswordValidationRules;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    use PasswordValidationRules;

    public function participantRegister(Kelas $kelas)
    {
        return view('guest.register', compact('kelas'));
        // return view('participant.kelas.register', compact('kelas'));
    }

    public function storeParticipantRegister(Request $request, Kelas $kelas)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['required', 'numeric'],
            'address' => ['required', 'string'],
            'password' => $this->passwordRules(),
            'receipt_of_payment' => ['required', 'image'],
        ]);

        // simpan bukti transfer ke dalam directory public dan ganti isi dari receipt of payment
        $path = $validated['receipt_of_payment']->store("participant/receipt");
        $validated['receipt_of_payment'] = $path;

        $validated['password'] = Hash::make($validated['password']); // bikin password enkripsi
        // $validated['kelas_id'] = $kelas->id;

        $user = $kelas->users()->create($validated);

        $user->assignRole('participant'); // user diberi role participant

        // peserta yang mendaftar diberi hak akses untuk melihat status pendaftaran
        $user->syncPermissions('view status');

        return redirect('/participant/dashboard');
    }
}
