<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Status;
use App\Models\Toefl;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class KelasController extends Controller
{
    public function create()
    {
        // ambil toefl hanya yg lengkap jumlah soalnya yaitu 140
        $toefls = Toefl::withCount('questions')->having('questions_count', 140)->get();
        return view('admin.kelas.create', compact('toefls'));
    }

    public function store(Request $request)
    {
        // validasi dulu
        $attributes = $request->validate([
            'nama' => 'required|unique:kelas|max:255|string',
            'pelaksanaan' => 'required|date|after:pendaftaran',
            'akhir_pelaksanaan' => 'required|date|after:pelaksanaan',
            'pendaftaran' => 'required|date|before:pelaksanaan|after:tomorrow',
            'quota' => 'required',
            'toefls' => 'required|array',
            'price' => 'required|integer',
        ]);

        $attributes['ispublished'] = false; // buat tidak terpublikasi ketika pertama dibuat
        $attributes['register_status_id'] = 2; // buat pendaftaran ditutup ketika pertama dibuat

        $kelas = Kelas::create($attributes);

        $kelas->toefls()->attach($request['toefls']); // simpan toefl-toefl yang akan digunakan

        return redirect('/admin/kelas');
    }

    public function edit(Kelas $kelas)
    {
        $toefls = Toefl::withCount('questions')->having('questions_count', 140)->get();
        return view('admin.kelas.edit', compact('kelas', 'toefls'));
    }

    public function update(Request $request, Kelas $kelas)
    {
        // validasi dulu
        $validated = $request->validate([
            'nama' => 'required|max:255|string',
            'pelaksanaan' => 'required|date|after:pendaftaran',
            'akhir_pelaksanaan' => 'required|date|after:pelaksanaan',
            'pendaftaran' => 'required|date|before:pelaksanaan',
            'quota' => 'required|integer',
            'toefls' => 'array',
            'price' => 'required|integer',
        ]);

        $kelas->update($validated);

        // cek apa ada perubahan pada toefls yg dipilih
        if (Arr::exists($validated, 'toefls')) { 
            $kelas->toefls()->sync($validated['toefls']); //sinkronisasi kelas,
        }
        
        return redirect('/admin/kelas/' . $kelas->id);
    }
    
    public function destroy(Kelas $kelas)
    {
        $kelas->statuses()->detach(); // hapus relasi dengan status kelas
        $kelas->toefls()->detach(); // hapus relasi dengan many toefls
        $kelas->delete(); // hapus kelas
        return redirect('admin/kelas'); // redirect ke index
    }
}
