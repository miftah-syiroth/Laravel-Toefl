<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Toefl extends Model
{
    use HasFactory;

    protected $table = 'toefls';

    // ada direction ada imageable, belum nemu fitur rich text yg bisa akomodir gambar dalam text area, krn berbayar
    protected $fillable = [
        'title',
        'duration',
        'section_1_direction',
        'section_1_imageable',
        'section_1_track',
        'part_a_direction',
        'part_a_imageable',
        'part_a_track',
        'part_b_direction',
        'part_b_imageable',
        'part_b_track',
        'part_c_direction',
        'part_c_imageable',
        'part_c_track',
        'section_2_direction',
        'section_2_imageable',
        'structure_direction',
        'structure_imageable',
        'written_expression_direction',
        'written_expression_imageable',
        'section_3_direction',
        'section_3_imageable',
    ];

    // sebuah toefl memiliki banyak soal
    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    // sebuah toefl memiliki banyak passage untuk section 3
    public function passages()
    {
        return $this->hasMany(Passage::class);
    }

    // banyak toefl dimiliki oleh banyak kelas
    public function kelas()
    {
        return $this->belongsToMany(Kelas::class, 'kelas_has_toefls', 'toefl_id', 'kelas_id');
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
