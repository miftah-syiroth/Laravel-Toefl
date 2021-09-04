<?php

namespace App\Http\Controllers;

use App\Actions\Fortify\PasswordValidationRules;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    use PasswordValidationRules;

    public function participantRegister(Kelas $kelas)
    {
        #cek kalau kuotanya udah penuh atau waktu pendaftaran sudah habis.details-heading
        if ($kelas->quota <= $kelas->users->count() || $kelas->pendaftaran < now()) {
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
        if ($kelas->quota <= $kelas->users->count() || $kelas->pendaftaran < now()) {
            return redirect('/')->with('message', 'Kuota penuh atau pendaftaran berakhir');
        }

        // simpan bukti transfer ke dalam directory public dan ganti isi dari receipt of payment
        $path = Storage::disk('local')->put('receipts', $attributes['receipt_of_payment']);
        $attributes['receipt_of_payment'] = $path;

        $attributes['password'] = Hash::make($attributes['password']); // bikin password enkripsi

        $attributes['status_id'] = 1; //set status peserta sebagai pengajuan pendaftaran

        // ambil random 1 toefl dari kelas. kelas punya bnyk toefl utk keamanan test
        // ini mestinya ketika diverifikasi saja
        $attributes['toefl_id'] = Arr::random($kelas->toefls()->pluck('id')->toArray());
        
        $user = $kelas->users()->create($attributes);

        $user->assignRole('participant'); // user diberi role participant

        // peserta yang mendaftar diberi hak akses untuk melihat status pendaftaran
        // $user->syncPermissions('view status');

        return redirect('/participant/dashboard');
    }
}
