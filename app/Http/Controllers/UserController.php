<?php

namespace App\Http\Controllers;

use App\Actions\Fortify\PasswordValidationRules;
use App\Exports\ParticipantsExport;
use App\Models\Kelas;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    use PasswordValidationRules;

    public function participantRegister(Kelas $kelas)
    {
        #cek kalau kuotanya udah penuh atau waktu pendaftaran sudah habis.details-heading
        if ($kelas->register_status_id == 2 || $kelas->register_status_id == 3) {
            return redirect()->back()->with('message', 'Kuota penuh atau pendaftaran berakhir');
        }

        return view('guest.register', compact('kelas'));
    }

    public function storeParticipantRegister(Request $request, Kelas $kelas)
    {
        $attributes = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['required', 'numeric'],
            'address' => ['required', 'string'],
            'password' => $this->passwordRules(),
            'receipt_of_payment' => ['required', 'image'],
        ]);

        #cek kalau kuotanya udah penuh atau waktu pendaftaran sudah habis.details-heading
        if ($kelas->register_status_id == 2 || $kelas->register_status_id == 3) {
            return redirect('/')->with('message', 'Kuota penuh atau pendaftaran berakhir');
        }

        // simpan bukti transfer ke dalam directory public dan ganti isi dari receipt of payment
        $attributes['receipt_of_payment'] = $attributes['receipt_of_payment']->store("participant/receipts");

        $attributes['password'] = Hash::make($attributes['password']); // bikin password enkripsi

        $attributes['status_id'] = 1; //set status peserta sebagai pengajuan pendaftaran

        // ambil random 1 toefl dari kelas. kelas punya bnyk toefl utk keamanan test
        // ini mestinya ketika diverifikasi saja
        $attributes['toefl_id'] = Arr::random($kelas->toefls()->pluck('id')->toArray());
        
        $user = $kelas->users()->create($attributes);

        $user->assignRole('participant'); // user diberi role participant

        // peserta yang mendaftar diberi hak akses untuk melihat status pendaftaran
        // $user->syncPermissions('view status');
        // cek jika kuota kelas sudah penuh, maka ganti statusnya biar ga ada yg daftar
        if ($kelas->users->count() >= $kelas->quota) {
            $kelas->update([
                'register_status_id' => 2,
            ]);
        }

        return redirect('/participant/dashboard');
    }

    public function uji()
    {
        dd(true);
    }
}
