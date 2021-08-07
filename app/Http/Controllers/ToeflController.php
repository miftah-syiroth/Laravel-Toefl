<?php

namespace App\Http\Controllers;

use App\Models\Section;
use App\Models\Toefl;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;

class ToeflController extends Controller
{
    // fungsi ini menampilkan list of toefls untuk dikelola oleh admin
    public function index()
    {
        // ambil semua toefls row yang ada utk ditampilkan pada tabel index
        $toefls = Toefl::all();
        return view('admin.toefl.index', compact('toefls'));
    }

    // fungsi untuk membuat toefl baru
    public function create()
    {
        return view('admin.toefl.create');
    }

    public function store(Request $request)
    {
        // validasi dulu
        $validated = $request->validate([
            'title' => 'required|unique:toefls|max:255|string',
            'section_1_track' => 'required|mimes:mp3',
            'section_2_direction' => 'required',
            'section_3_direction' => 'required',
            'structure_direction' => 'required',
            'written_expression_direction' => 'required',
        ]);

        // simpan track ke dalam directory public dan ganti isi dari section_1_track
        $path = $validated['section_1_track']->store("toefl/tracks");
        $validated['section_1_track'] = $path;

        // tambahkan durasi
        $validated['duration'] = 6900; // in second
        
        // simpan semua input ke dalam database
        Toefl::create($validated);

        // redirect ke index toefls
        return redirect('/admin/toefls');
    }

    // fungsi untuk melihat detil toefl
    public function show(Toefl $toefl)
    {
        $sections = Section::with(['subSections'])->get();

        $total_question = 0;
        foreach ($sections as $key => $section) {
            $total_question += $section->total_question;
        }
        
        return view('admin.toefl.show', compact("toefl", "sections", "total_question"));
    }

    // fungsi edit toefl
    public function edit(Toefl $toefl)
    {
        return view('admin.toefl.edit', compact('toefl'));  
    }

    // menyimpan data dari form edit
    public function update(Request $request, Toefl $toefl)
    {
        // validasi
        $validated = $request->validate([
            'title' => 'required|max:255|string',
            'section_1_track' => 'mimes:mp3',
            'section_2_direction' => 'required',
            'section_3_direction' => 'required',
            'structure_direction' => 'required',
            'written_expression_direction' => 'required',
        ]);

        // cek apa ada perubahan pada input track audio listening
        if (Arr::exists($validated, 'section_1_track')) { //kalau ada input audio baru
            Storage::delete($toefl->section_1_track); // hapus track lama toefl dari storage
            
            $path = $validated['section_1_track']->store("toefl/tracks"); // simpan track baru dan ambil path
            
            $validated['section_1_track'] = $path; // masukkan ke key section_1_track
        }

        // update toefl dgn array validated
        $toefl->update($validated);

        return redirect('/admin/toefls');
        
    }

    public function destroy(Toefl $toefl)
    {
        Storage::delete($toefl->section_1_track); // hapus track lama toefl dari storage

        $toefl->delete(); // hapus row

        return redirect('/admin/toefls');
    }
}
