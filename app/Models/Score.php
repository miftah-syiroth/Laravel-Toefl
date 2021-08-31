<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Score extends Model
{
    use HasFactory;

    protected $table = 'scores';
    protected $guarded = [];

    // one to one peserta memiliki satu score
    public function user()
    {
        return $this->hasOne(User::class);
    }
}
