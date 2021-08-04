<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasFactory;

    protected $table = 'sections';
    protected $fillable = [
        'name',
        'sub_title',
        'duration',
        'max_score',
        'min_score',
        'total_question',
    ];

    // sebuah section memiliki beberapa sub, yaitu pada section 1 dan 2
    public function subSections()
    {
        return $this->hasMany(SubSection::class);
    }

    // section digunakan oleh banyak soal
    public function questions()
    {
        return $this->hasMany(Question::class);
    }
}
