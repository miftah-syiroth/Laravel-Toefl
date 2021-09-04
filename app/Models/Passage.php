<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Passage extends Model
{
    use HasFactory;

    protected $table = 'passages';
    protected $fillable = [
        'passage',
        'toefl_id',
        'imageable', #buat nampung gambar passage
    ];

    // banyak passage terhubung pada satu toefl
    public function toefl()
    {
        return $this->belongsTo(Toefl::class);
    }

    /**relasi one to many ke model question */
    public function questions()
    {
        return $this->hasMany(Question::class);
    }
}
