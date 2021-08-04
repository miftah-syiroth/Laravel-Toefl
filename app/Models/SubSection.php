<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubSection extends Model
{
    use HasFactory;

    protected $table = 'sub_sections';
    protected $fillable = [
        'name',
        'section_id',
    ];

    // sebuah sub section memiliki satu parent section
    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    // sub section digunakan oleh banyak soal
    public function questions()
    {
        return $this->hasMany(Question::class);
    }
}
