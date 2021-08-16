<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function kelasRegister(Kelas $kelas)
    {
        return view('participant.kelas.register', compact('kelas'));
    }

    public function storeKelasRegister(Request $request, Kelas $kelas)
    {
         // validasi
         $validated = $request->validate([
            'receipt_of_payment' => 'required|image',
        ]);

        // simpan bukti transfer ke dalam directory public dan ganti isi dari receipt of payment
        $path = $validated['receipt_of_payment']->store("participant/receipt");
        $validated['receipt_of_payment'] = $path;
        $validated['kelas_id'] = $kelas->id;

        $user = Auth::user();

        $user->update($validated);

        // peserta yang mendaftar diberi hak akses untuk melihat status pendaftaran
        $user->syncPermissions('view status');

        return redirect('/participant/dashboard');
    }
}
