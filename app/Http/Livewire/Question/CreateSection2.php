<?php

namespace App\Http\Livewire\Question;

use App\Models\Question;
use App\Models\SubSection;
use App\Models\Toefl;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class CreateSection2 extends Component
{
    use WithFileUploads;

    public $toefl;
    public $sub_section; // sub section saat ini
    public $questions; // untuk membuat navigasi

    public $isComplete; //apakah soal sudah complete 40 atau belum

    public $question_selected;

    /**properti untuk tabel questions */
    public $question, $imageable, $option_a, $option_b, $option_c, $option_d, $key_answer;

    protected $rules = [
        'option_a' => 'required',
        'option_b' => 'required',
        'option_c' => 'required',
        'option_d' => 'required',
        'key_answer' => 'required',
    ];

    public function newQuestion()
    {
        # sub section kembali default yaitu sesuai jumlah soal yg ada, menggunakan method
        $this->sub_section = $this->checkSubSection($this->questions); 
        # hapus semua properti
        $this->reset(['question', 'imageable', 'option_a', 'option_b', 'option_c', 'option_d', 'key_answer', 'question_selected']);
    }

    public function selectQuestion(Question $question)
    {
        /**isi form dengan isi row dari question yang dipilih */
        $this->question = $question->question;
        $this->option_a = $question->option_a;
        $this->option_b = $question->option_b;
        $this->option_c = $question->option_c;
        $this->option_d = $question->option_d;
        $this->key_answer = $question->key_answer;

        /**questionSelected menyimpan soal yang akan diupdate atau dipilih dari navigasi soal */
        $this->question_selected = $question;
        # sub section disesuaikan dengan sub_section_id pada soal terpilih
        $this->sub_section = SubSection::find($question->sub_section_id);
    }

    public function save()
    {
        $this->validate();

        /**kalau ada pertanyaan terdahulu yang dipilih untuk diubah, maka update soal tersebut*/
        if ($this->question_selected) {
            $this->update();
        } else {
            $this->store(); /**simpan soal baru */
        }
    }

    public function store()
    {
        # cek ada input gambar ngga, bisa aja cek sub_section written expression, krn cuma sub_section_id 2 yg ada input gambar. Tp mending cek file aja
        if ($this->sub_section->id == 2) {
            $this->validate([
                'imageable' => 'required|image'
            ]);
            $this->imageable = $this->imageable->store("toefl/images/question/written-expression");
        } else { # validasi question, karna hanya structure yg pakai question text
            $this->validate([
                'question' => 'required',
            ]);
        }

        # cek udah komplet atau belum, kalau udah, ga bisa create baris baru
        if (!$this->isComplete) { # selama belum komplit, bisa buat baru

            $this->toefl->questions()->create([
                'sub_section_id' => $this->sub_section->id,
                'section_id' => 2,
                'question' => $this->question,
                'written_expression_imageable' => $this->imageable,
                'option_a' => $this->option_a,
                'option_b' => $this->option_b,
                'option_c' => $this->option_c,
                'option_d' => $this->option_d,
                'key_answer' => $this->key_answer,
            ]);

            // update properti questions, harus gini atau ga akan update viewnya
            $this->questions = Toefl::find($this->toefl->id)->questions()->where('section_id', 2)->get();
            # sub section kembali default yaitu sesuai jumlah soal yg ada, menggunakan method
            $this->sub_section = $this->checkSubSection($this->questions);
            # cek iscomplete
            $this->isComplete = $this->questions->count() == 40 ? true : false;

            $this->reset(['question', 'option_a', 'option_b', 'option_c', 'option_d', 'key_answer', 'imageable']);  // hapus field input
        } else {
            session()->flash('message', 'Soal sudah maksimal');
        }
    }

    //  fungsi mengupdate soal yang dipilih dari navigasi soal
    public function update()
    {
        # cek input gambar utk sub section id 2
        if ($this->sub_section->id == 2) {
            // jika ganti gambar, maka hapus file gambar terdahulu, simpan yg baru dan ambil pathnya
            if ($this->imageable) {
                Storage::delete($this->question_selected->written_expression_imageable); // hapus track lama toefl dari storage
                $this->imageable = $this->imageable->store("toefl/images/question/written-expression");
            } else { #jika engga maka isi pakai path file sebelumnya
                $this->imageable = $this->question_selected->written_expression_imageable;
            }
        }
        
        $this->question_selected->update([
            'question' => $this->question,
            'written_expression_imageable' => $this->imageable,
            'option_a' => $this->option_a,
            'option_b' => $this->option_b,
            'option_c' => $this->option_c,
            'option_d' => $this->option_d,
            'key_answer' => $this->key_answer,
        ]);

        # sub section kembali default yaitu sesuai jumlah soal yg ada, menggunakan method
        $this->sub_section = $this->checkSubSection($this->questions);
        $this->reset(['question', 'imageable', 'option_a', 'option_b', 'option_c', 'option_d', 'key_answer', 'question_selected']);
    }

    public function checkPreviousSection()
    {
        if ($this->toefl->questions()->where('section_id', 1)->count() < 50) {
            session()->flash('message', 'Mulai dari Section 1');
            return redirect()->to('/admin/toefls/' . $this->toefl->id);
        }
    }
    
    public function checkSubSection($questions)
    {
        # kita buat prosedural ketika menginput soal, urutan dari part a hingga b
        # structure 15 soal (1-15), written 25 soal (16-40)
        $count = $questions->count();

        if ($count < 15) {
            return SubSection::find(1);
        } else { 
            return SubSection::find(2);
        }
    }

    public function mount(Toefl $toefl)
    {
        $this->toefl = $toefl;

        # pembuatan soal dibuat urut dari section 1 s,d 3. Maka cek apakah section sebelumnya sudah full atau blm.
        $this->checkPreviousSection();

        $this->questions = $toefl->questions()->where('section_id', 2)->get();

        # perlu menentukan sekarang sub section apa
        $this->sub_section = $this->checkSubSection($this->questions);
        # cek udah complete 50 atau belum
        $this->isComplete = $this->questions->count() == 40 ? true : false;
    }

    public function render()
    {
        return view('livewire.question.create-section2');
    }
}
