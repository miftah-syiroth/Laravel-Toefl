<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Status;
use App\Models\Toefl;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class KelasController extends Controller
{
    public function index()
    {
        $kelas = Kelas::all();
        return view('admin.kelas.index', compact('kelas'));
    }

    public function create()
    {
        $toefls = Toefl::all();
        return view('admin.kelas.create', compact('toefls'));
    }

    public function store(Request $request)
    {
        // validasi dulu
        $validated = $request->validate([
            'nama' => 'required|unique:kelas|max:255|string',
            'pelaksanaan' => 'required|date|after:pendaftaran',
            'pendaftaran' => 'required|date|before:pelaksanaan|after:tomorrow',
            'quota' => 'required',
            'toefls' => 'required|array',
        ]);

        $kelas = Kelas::create($validated);

        $kelas->statuses()->attach([2, 3]); // buat status unpublish id=2 dan archived id=3

        $kelas->toefls()->attach($request['toefls']); // simpan toefl-toefl yang akan digunakan

        return redirect('/admin/kelas');
    }

    function show(Kelas $kelas)
    {
        $statuses = Status::all();
        return view('admin.kelas.show', compact('kelas', 'statuses'));
    }

    public function edit(Kelas $kelas)
    {
        $toefls = Toefl::all();
        return view('admin.kelas.edit', compact('kelas', 'toefls'));
    }

    public function update(Request $request, Kelas $kelas)
    {
        // validasi dulu
        $validated = $request->validate([
            'nama' => 'required|max:255|string',
            'pelaksanaan' => 'required|date|after:pendaftaran',
            'pendaftaran' => 'required|date|before:pelaksanaan|after:tomorrow',
            'quota' => 'required',
            'toefls' => 'array',
        ]);
        $kelas->update($validated);

        // cek apa ada perubahan pada toefls yg dipilih
        if (Arr::exists($validated, 'toefls')) { 
            $kelas->toefls()->sync($validated['toefls']); //sinkronisasi kelas,
        }
        
        return redirect('/admin/kelas');
    }
    
    public function destroy(Kelas $kelas)
    {
        $kelas->statuses()->detach(); // hapus relasi dengan status kelas
        $kelas->toefls()->detach(); // hapus relasi dengan many toefls
        $kelas->delete(); // hapus kelas
        return redirect('admin/kelas'); // redirect ke index
    }
}
