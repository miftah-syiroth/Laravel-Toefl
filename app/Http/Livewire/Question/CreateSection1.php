<?php

namespace App\Http\Livewire\Question;

use App\Models\Question;
use App\Models\Section;
use App\Models\SubSection;
use App\Models\Toefl;
use Livewire\Component;

class CreateSection1 extends Component
{
    public $toefl;
    public $sub_section; // sub section saat ini
    public $questions; // untuk membuat navigasi

    public $isComplete; //apakah soal sudah complete 50 atau belum

    public $question_selected;

    /**properti untuk tabel questions */
    public $option_a, $option_b, $option_c, $option_d, $key_answer; 

    // rules validasi input form
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
        $this->reset(['option_a', 'option_b', 'option_c', 'option_d', 'key_answer', 'question_selected']);
    }

    public function selectQuestion(Question $question)
    {
        /**isi form dengan isi row dari question yang dipilih */
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
        //  validasi dulu
       $this->validate();

        /**kalau ada pertanyaan terdahulu yang dipilih untuk diubah, maka update soal tersebut*/
        if ($this->question_selected) {
            $this->update();
        } else {
            /**simpan soal baru */
            $this->store();
        }
    }

    public function store()
    {
        # cek udah komplet atau belum, kalau udah ga bisa create baris baru
        if (!$this->isComplete) {
            $this->toefl->questions()->create([
                'sub_section_id' => $this->sub_section->id,
                'section_id' => 1,
                'option_a' => $this->option_a,
                'option_b' => $this->option_b,
                'option_c' => $this->option_c,
                'option_d' => $this->option_d,
                'key_answer' => $this->key_answer,
            ]);

            // update properti questions, harus gini atau ga akan update viewnya
            $this->questions = Toefl::find($this->toefl->id)->questions()->where('section_id', 1)->get();
            # sub section kembali default yaitu sesuai jumlah soal yg ada, menggunakan method
            $this->sub_section = $this->checkSubSection($this->questions);
            # cek iscomplete
            $this->isComplete = $this->questions->count() == 50 ? true : false;

            $this->reset(['option_a', 'option_b', 'option_c', 'option_d', 'key_answer']);  // hapus field input
        } else {
            session()->flash('message', 'Soal sudah maksimal');
        }
    }

    //  fungsi mengupdate soal yang dipilih dari navigasi soal
    public function update()
    {
        $this->question_selected->update([
            'option_a' => $this->option_a,
            'option_b' => $this->option_b,
            'option_c' => $this->option_c,
            'option_d' => $this->option_d,
            'key_answer' => $this->key_answer,
        ]);

        # sub section kembali default yaitu sesuai jumlah soal yg ada, menggunakan method
        $this->sub_section = $this->checkSubSection($this->questions);
        $this->reset(['option_a', 'option_b', 'option_c', 'option_d', 'key_answer', 'question_selected']);
    }

    public function checkSubSection($questions)
    {
        # kita buat prosedural ketika menginput soal, urutan dari part a hingga b
        # part a 30 soal (1-30), b 8 soal (31-38), c 12 soal (39-50)
        $count = $questions->count();

        if ($count < 30) {
            return SubSection::find(3);
        } elseif ($count < 38) {
            return SubSection::find(4);
        } else { 
            return SubSection::find(5);
        }
    }

    public function mount(Toefl $toefl)
    {
        $this->toefl = $toefl;
        
        $this->questions = $toefl->questions()->where('section_id', 1)->get();

        # perlu menentukan sekarang sub section apa
        $this->sub_section = $this->checkSubSection($this->questions);
        # cek udah complete 50 atau belum
        $this->isComplete = $this->questions->count() == 50 ? true : false;
    }

    public function render()
    {
        return view('livewire.question.create-section1');
    }
}
