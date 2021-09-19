<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Section;
use App\Models\Toefl;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

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
            'section_1_imageable' => 'required|image',
            'section_1_track' => 'required|mimes:mp3',
            'part_a_imageable' => 'required|image',
            'part_b_imageable' => 'required|image',
            'part_c_imageable' => 'required|image',
            'section_2_imageable' => 'required|image',
            'structure_imageable' => 'required|image',
            'written_expression_imageable' => 'required|image',
            'section_3_imageable' => 'required|image',
        ]);

        // simpan audio full section 1 dan ambil pathnya
        $attributes['section_1_track'] = $attributes['section_1_track']->store("toefl/tracks/listening");

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
        $attributes['duration'] = 6900; // in second
        
        // simpan semua input ke dalam database
        Toefl::create($attributes);

        // redirect ke index toefls
        return redirect('/admin/toefls');
    }

    // fungsi untuk melihat detil toefl
    public function show(Toefl $toefl)
    {
        $sections = Section::with(['subSections'])->withCount(['subSections'])->get();
       
        $toefl = Toefl::with('kelas')->withCount([
            'questions', #toal soal yg telah dibuat
            'questions as section_1_count' => function (Builder $query) {
                $query->where('section_id', 1);
            },
            'questions as section_2_count' => function (Builder $query) {
                $query->where('section_id', 2);
            },
            'questions as section_3_count' => function (Builder $query) {
                $query->where('section_id', 3);
            },
            'questions as part_a_count' => function (Builder $query) {
                $query->where('sub_section_id', 3);
            },
            'questions as part_b_count' => function (Builder $query) {
                $query->where('sub_section_id', 4);
            },
            'questions as part_c_count' => function (Builder $query) {
                $query->where('sub_section_id', 5);
            },
            'questions as structure_count' => function (Builder $query) {
                $query->where('sub_section_id', 1);
            },
            'questions as written_expression_count' => function (Builder $query) {
                $query->where('sub_section_id', 2);
            },
            'kelas',
            'users' => function (Builder $query) {
                $query->where('status_id', 5);
            },
        ])->find($toefl->id);
        
        return view('admin.toefl.show', compact("toefl"));
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
        $attributes = $request->validate([
            'title' => 'required|max:255|string',
            'section_1_imageable' => 'image',
            'section_1_track' => 'mimes:mp3',
            'part_a_imageable' => 'image',
            'part_b_imageable' => 'image',
            'part_c_imageable' => 'image',
            'section_2_imageable' => 'image',
            'structure_imageable' => 'image',
            'written_expression_imageable' => 'image',
            'section_3_imageable' => 'image',
        ]);

        $attributes = $this->checkUploadedFile($attributes, $toefl);

        // update toefl dgn array validated
        $toefl->update($attributes);

        return redirect('/admin/toefls');
    }

    public function checkUploadedFile($attributes, Toefl $toefl)
    {
        // simpan audio full section 1 dan ambil pathnya

        if (isset($attributes['section_1_track'])) { // cek ada input audio ssection 1, jik true
            Storage::delete($toefl->section_1_track); // hapus track lama toefl dari storage
            $attributes['section_1_track'] = $attributes['section_1_track']->store("toefl/tracks/listening");
        }
        
        // simpan gambarnya
        if (isset($attributes['section_1_imageable'])) { // cek ada input audio ssection 1, jik true
            Storage::delete($toefl->section_1_imageable); // hapus track lama toefl dari storage
            $attributes['section_1_imageable'] = $attributes['section_1_imageable']->store("toefl/images/section-1");
        }
        
        if (isset($attributes['part_a_imageable'])) { // cek ada input audio ssection 1, jik true
            Storage::delete($toefl->part_a_imageable); // hapus track lama toefl dari storage
            $attributes['part_a_imageable'] = $attributes['part_a_imageable']->store("toefl/images/part-a");
        }
        
        if (isset($attributes['part_b_imageable'])) { // cek ada input audio ssection 1, jik true
            Storage::delete($toefl->part_b_imageable); // hapus track lama toefl dari storage
            $attributes['part_b_imageable'] = $attributes['part_b_imageable']->store("toefl/images/part-b");
        }
        
        if (isset($attributes['part_c_imageable'])) { // cek ada input audio ssection 1, jik true
            Storage::delete($toefl->part_c_imageable); // hapus track lama toefl dari storage
            $attributes['part_c_imageable'] = $attributes['part_c_imageable']->store("toefl/images/part-c");
        }
        
        if (isset($attributes['section_2_imageable'])) { // cek ada input audio ssection 1, jik true
            Storage::delete($toefl->section_2_imageable); // hapus track lama toefl dari storage
            $attributes['section_2_imageable'] = $attributes['section_2_imageable']->store("toefl/images/section-2");
        }
        
        if (isset($attributes['structure_imageable'])) { // cek ada input audio ssection 1, jik true
            Storage::delete($toefl->structure_imageable); // hapus track lama toefl dari storage
            $attributes['structure_imageable'] = $attributes['structure_imageable']->storeAs("toefl/images/structure");
        }
        
        if (isset($attributes['written_expression_imageable'])) {
            Storage::delete($toefl->written_expression_imageable); // hapus track lama toefl dari storage
            $attributes['written_expression_imageable'] = $attributes['written_expression_imageable']->store("toefl/images/written-expression");
        }

        if (isset($attributes['section_3_imageable'])) { // cek ada input audio ssection 1, jik true
            Storage::delete($toefl->section_3_imageable); // hapus track lama toefl dari storage
            $attributes['section_3_imageable'] = $attributes['section_3_imageable']->store("toefl/images/section-3");
        }
        
        return $attributes;
    }

    public function destroy(Toefl $toefl)
    {
        // hapus semua file track dan image yg ada pada tabel
        $this->deleteFileUploaded($toefl);

        // hapus jawaban peserta yang soalnya dari toefl ini
        // $toefl->questions()->users()->detach();
        foreach ($toefl->questions as $key => $question) {
            $question->users()->detach();
        }

        // hapus questionny
        $toefl->questions()->delete();

        // hapus pesertanya, sebenernya bisa tambah manajemen lain. tp males
        $toefl->users()->delete();

        $toefl->delete(); // hapus row

        return redirect('/admin/toefls');
    }

    public function deleteFileUploaded($toefl)
    {
        Storage::delete($toefl->section_1_track); // hapus track lama toefl dari storage

        Storage::delete($toefl->section_1_imageable);
        Storage::delete($toefl->part_a_imageable);
        Storage::delete($toefl->part_b_imageable); 
        Storage::delete($toefl->part_c_imageable);
        Storage::delete($toefl->section_2_imageable); 
        Storage::delete($toefl->structure_imageable);
        Storage::delete($toefl->written_expression_imageable);
        Storage::delete($toefl->section_3_imageable);
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
                $user->givePermissionTo('melihat skor');
                // hapus permission mengerjakan toefl supaya ga bisa ngerjain lg
                $user->revokePermissionTo('mengerjakan toefl');
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
                $user->givePermissionTo('melihat skor');
                // hapus permission mengerjakan toefl supaya ga bisa ngerjain lg
                $user->revokePermissionTo('mengerjakan toefl');
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
        $user = Auth::user();
        $lastQuestion = $user->questions()->orderBy('passage_id', 'DESC')->orderBy('id', 'DESC')->first();

        if ($lastQuestion) {
            #cek kalau udah selesai garapnya
            if ($lastQuestion->section_id == 3 && ($lastQuestion->pivot->last_question >= 49 || $lastQuestion->pivot->last_minute <= 0)) {
                $user->givePermissionTo('melihat skor');
                // hapus permission mengerjakan toefl supaya ga bisa ngerjain lg
                $user->revokePermissionTo('mengerjakan toefl');
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
