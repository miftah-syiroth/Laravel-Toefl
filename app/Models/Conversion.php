<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conversion extends Model
{
    use HasFactory;

    protected $table = 'conversions';
    protected $fillable = [
        'correct_amount',
        'section_1',
        'section_2',
        'section_3',
    ];
}
