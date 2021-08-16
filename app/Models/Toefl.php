<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Toefl extends Model
{
    use HasFactory;

    protected $table = 'toefls';
    protected $fillable = [
        'title',
        'duration',
        'section_1_track',
        'section_2_direction',
        'section_3_direction',
        'structure_direction',
        'written_expression_direction',
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
    public function classes()
    {
        return $this->belongsToMany(Kelas::class, 'kelas_has_toefls', 'toefl_id', 'kelas_id');
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
