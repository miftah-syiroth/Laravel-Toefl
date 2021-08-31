<?php

namespace App\Http\Controllers;

use App\Models\Section;
use App\Models\Toefl;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ToeflController extends Controller
{
    // fungsi untuk membuat toefl baru
    public function create()
    {
        return view('admin.toefl.create');
    }

    public function store(Request $request)
    {
        // validasi dulu
        $attributes = $request->validate([
            'title' => 'required|unique:toefls|max:255|string',
            'section_1_direction' => 'required',
            'section_1_imageable' => 'required|image',
            'section_1_track' => 'required|mimes:mp3',
            'part_a_direction' => 'required',
            'part_a_imageable' => 'required|image',
            'part_a_track' => 'required|mimes:mp3',
            'part_b_direction' => 'required',
            'part_b_imageable' => 'required|image',
            'part_b_track' => 'required|mimes:mp3',
            'part_c_direction' => 'required',
            'part_c_imageable' => 'required|image',
            'part_c_track' => 'required|mimes:mp3',
            'section_2_direction' => 'required',
            'section_2_imageable' => 'required|image',
            'structure_direction' => 'required',
            'structure_imageable' => 'required|image',
            'written_expression_direction' => 'required',
            'written_expression_imageable' => 'required|image',
            'section_3_direction' => 'required',
            'section_3_imageable' => 'required|image',
        ]);

        // simpan audio full section 1 dan ambil pathnya
        $attributes['section_1_track'] = $attributes['section_1_track']->store("toefl/tracks/listening");
        $attributes['part_a_track'] = $attributes['part_a_track']->store("toefl/tracks/part-a");
        $attributes['part_b_track'] = $attributes['part_b_track']->store("toefl/tracks/part-b");
        $attributes['part_c_track'] = $attributes['part_c_track']->store("toefl/tracks/part-c");

        // simpan gambarnya
        $attributes['section_1_imageable'] = $attributes['section_1_imageable']->store("toefl/images/section-1");
        $attributes['part_a_imageable'] = $attributes['part_a_imageable']->store("toefl/images/part-a");
        $attributes['part_b_imageable'] = $attributes['part_b_imageable']->store("toefl/images/part-b");
        $attributes['part_c_imageable'] = $attributes['part_c_imageable']->store("toefl/images/part-c");
        $attributes['section_2_imageable'] = $attributes['section_2_imageable']->store("toefl/images/section-2");
        $attributes['structure_imageable'] = $attributes['structure_imageable']->store("toefl/images/structure");
        $attributes['written_expression_imageable'] = $attributes['written_expression_imageable']->store("toefl/images/written-expression");
        $attributes['section_3_imageable'] = $attributes['section_3_imageable']->store("toefl/images/section-3");
       
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

        // hapus questionny
        $toefl->questions()->delete();

        $toefl->delete(); // hapus row

        return redirect('/admin/toefls');
    }

    public function getLastQuestion()
    {
        return Auth::user()->questions()->orderBy('question_id', 'desc')->first();
        // $lastQuestion = Auth::user()->questions()->orderBy('question_id', 'desc')->first();

    }

    public function section1Exam()
    {
        // batasi akses fungsi ini ketika pekerjaan sudah selesai atau sedang mengerjakan section lain
        # selesai adalah jika melewati waktu pelaksanaan ATAU berada pada section 3 soal ke 50 ATAU section 3 dgn last_minute <=0. SYARAT PERTAMA BELUM DIIMPLEMENTASI
        # cek jika waktu pengerjaan sudah berakhir

        $lastQuestion = $this->getLastQuestion();

        if ($lastQuestion) {
            #cek kalau udah selesai garapnya
            if ($lastQuestion->section_id == 3 && ($lastQuestion->pivot->last_question >= 49 || $lastQuestion->pivot->last_minute <= 0)) {
                return redirect('/participant/dashboard');
            }

            # masih section_id 1 tp udah selesai garapannya atau kehabisan waktu di section 1. = ui section 2
            if ($lastQuestion->section_id == 1 && ($lastQuestion->pivot->last_question >= 49 || $lastQuestion->pivot->last_minute <= 0)) {
                return redirect()->to('/participant/toefls/structure-and-written-expression');
            }

            # di section_id 2 dan belum selesai = ui section 2
            if ($lastQuestion->section_id == 2 && ($lastQuestion->pivot->last_question < 39 && $lastQuestion->pivot->last_minute > 0)) {
                return redirect()->to('/participant/toefls/structure-and-written-expression');
            }

            # di section_id 2 tp udah selesai garapannya atau kehabisan waktu di section 2. = ui section 3
            if ($lastQuestion->section_id == 2 && ($lastQuestion->pivot->last_question >= 39 || $lastQuestion->pivot->last_minute <= 0)) {
                return redirect()->to('/participant/toefls/reading-comprehension');
            }

            # di section_id 3 dan belum selesai
            if ($lastQuestion->section_id == 3 && ($lastQuestion->pivot->last_question < 49 && $lastQuestion->pivot->last_minute > 0)) {
                return redirect()->to('/participant/toefls/reading-comprehension');
            }
        }
        
        return view('participant.toefl-worksheet.section1');
    }

    public function section2Exam()
    {
        // batasi akses fungsi ini ketika pekerjaan sudah selesai atau sedang mengerjakan section lain
        # selesai adalah jika melewati waktu pelaksanaan ATAU berada pada section 3 soal ke 50 ATAU section 3 dgn last_minute <=0. SYARAT PERTAMA BELUM DIIMPLEMENTASI
        # cek jika waktu pengerjaan sudah berakhir

        #cek perkejaan baru, kembalikan ke pekerjaan semestinya atau sudah selesai
        $lastQuestion = $this->getLastQuestion();

        if ($lastQuestion) {
            #cek kalau udah selesai garapnya
            if ($lastQuestion->section_id == 3 && ($lastQuestion->pivot->last_question >= 49 || $lastQuestion->pivot->last_minute <= 0)) {
                return redirect('/participant/dashboard');
            }

            # masih section_id 1, soal belum selesai dan waktu masih sisa (ui section 1)
            if ($lastQuestion->section_id == 1 && ($lastQuestion->pivot->last_question < 49 && $lastQuestion->pivot->last_minute > 0)) {
                return redirect()->to('/participant/toefls/listening-comprehension');
            }

            # di section_id 2 tp udah selesai garapannya atau kehabisan waktu di section 2. (ui section 3)
            if ($lastQuestion->section_id == 2 && ($lastQuestion->pivot->last_question >= 39 || $lastQuestion->pivot->last_minute <= 0)) {
                return redirect()->to('/participant/toefls/reading-comprehension');
            }

            # di section_id 3 dan belum selesai. = ui section 3
            if ($lastQuestion->section_id == 3 && ($lastQuestion->pivot->last_question < 49 && $lastQuestion->pivot->last_minute > 0)) {
                return redirect()->to('/participant/toefls/reading-comprehension');
            }

            return view('participant.toefl-worksheet.section2');

        } else { # soal baru, masih kosong semua
            return redirect('/participant/dashboard');
        }

    }

    public function section3Exam()
    {
        // batasi akses fungsi ini ketika pekerjaan sudah selesai atau sedang mengerjakan section lain
        # selesai adalah jika melewati waktu pelaksanaan ATAU berada pada section 3 soal ke 50 ATAU section 3 dgn last_minute <=0. SYARAT PERTAMA BELUM DIIMPLEMENTASI
        # cek jika waktu pengerjaan sudah berakhir
        #cek perkejaan baru, kembalikan ke pekerjaan semestinya atau sudah selesai
        $lastQuestion = $this->getLastQuestion();

        if ($lastQuestion) {
            #cek kalau udah selesai garapnya
            if ($lastQuestion->section_id == 3 && ($lastQuestion->pivot->last_question >= 49 || $lastQuestion->pivot->last_minute <= 0)) {
                return redirect('/participant/dashboard');
            }

            # masih section_id 1, soal belum selesai dan waktu masih sisa (section 1)
            if ($lastQuestion->section_id == 1 && ($lastQuestion->pivot->last_question < 49 && $lastQuestion->pivot->last_minute > 0)) {
                return redirect()->to('/participant/toefls/listening-comprehension');
            }

            # masih section_id 1, soal sudah selesai atau kehabisa waktu (section 2)
            if ($lastQuestion->section_id == 1 && ($lastQuestion->pivot->last_question >= 49 || $lastQuestion->pivot->last_minute <= 0)) {
                return redirect()->to('/participant/toefls/structure-and-written-expression');
            }

            # masih section_id 2, soal belum selesai atau waktu masih tersedia (section 2)
            if ($lastQuestion->section_id == 2 && ($lastQuestion->pivot->last_question < 39 && $lastQuestion->pivot->last_minute > 0)) {
                return redirect()->to('/participant/toefls/structure-and-written-expression');
            }

            return view('participant.toefl-worksheet.section3');
            
        } else { # soal baru, masih kosong semua
            return redirect('/participant/dashboard');
        }
    }
}
