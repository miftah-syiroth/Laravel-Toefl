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

        // hapus questionny
        $toefl->questions()->delete();

        $toefl->delete(); // hapus row

        return redirect('/admin/toefls');
    }

    public function examination()
    {
        # controller digunakan untuk membatasi akses via url, daripada membatasi di route
        # cek apakah pekerjaan baru atau sedang mengerjakan, atau sudah selesai
        # ambil soal terakhir, value null jika pekerjaan baru, retrive a row jika sudah pernah mengerjakan
        $lastQuestion = Auth::user()->questions()->orderBy('question_id', 'desc')->first();

        if ($lastQuestion) { # jika retrive a row, masih ada kemungkinan lanjut atau sudah selesai
            # exam selesai, yaitu jika waktu pelaksanaan habis, atau ATAU berada pada section 3 soal ke 50 ATAU section 3 dgn last_minute <=0. SYARAT PERTAMA BELUM DIIMPLEMENTASI
            if ($lastQuestion->section_id == 3 && ($lastQuestion->pivot->last_question >= 49 || $lastQuestion->pivot->last_minute <= 0)) { 
                return redirect('/participant/dashboard');
            } else { # exam belum tuntas tp masih ada kesempatan waktu
                // cek lg untuk tiap2 section
                if ($lastQuestion->section_id == 1) { // jika belum selesai di section 1
                    // cek lg barangkali udh selesai di akhir soal atau kehabisa waktu
                    if ($lastQuestion->pivot->last_question >= 49 || $lastQuestion->pivot->last_minute <= 0) {
                        return redirect()->to('/participant/toefls/structure-and-written-expression');
                    } else {
                        return redirect()->to('/participant/toefls/listening-comprehension');
                    }
                    
                } elseif ($lastQuestion->section_id == 2) { // section 2
                    // cek lg barangkali udh di akhir soal atau kehabisan waktu
                    if ($lastQuestion->pivot->last_question >= 39 || $lastQuestion->pivot->last_minute <= 0) {
                        return redirect()->to('/participant/toefls/reading-comprehension');
                    } else { // belum selesai dan masih ada waktu
                        return redirect()->to('/participant/toefls/structure-and-written-expression');
                    }
                } else { // section 3
                    // cek lg barangkali udh di akhir soal atau kehabisan waktu
                    // if ($lastQuestion->pivot->last_question >= 49 || $lastQuestion->pivot->last_minute <= 0) {
                    //     return redirect()->to('/participant/dashboard');
                    // } else { // belum selesai dan masih ada waktu
                    //     return redirect()->to('/participant/toefls/reading-comprehension');
                    // }
                    return view('participant.toefl-worksheet.section3');
                }
            }
            
        } else { # jika null, artinya perkejaan baru. start dari section 1
            return view('participant.toefl-worksheet.section1');
        }
        
    }

    public function examValidation()
    {
        $lastQuestion = Auth::user()->questions()->orderBy('question_id', 'desc')->first();

    }

    public function section1Exam()
    {
        // batasi akses fungsi ini ketika pekerjaan sudah selesai atau sedang mengerjakan section lain
        # selesai adalah jika melewati waktu pelaksanaan ATAU berada pada section 3 soal ke 50 ATAU section 3 dgn last_minute <=0. SYARAT PERTAMA BELUM DIIMPLEMENTASI
        # cek jika waktu pengerjaan sudah berakhir

        $lastQuestion = Auth::user()->questions()->orderBy('question_id', 'desc')->first();

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
        $lastQuestion = Auth::user()->questions()->orderBy('question_id', 'desc')->first();

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
        $lastQuestion = Auth::user()->questions()->orderBy('question_id', 'desc')->first();

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
