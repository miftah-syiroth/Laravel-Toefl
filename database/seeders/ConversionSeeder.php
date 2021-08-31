<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ConversionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('conversions')->insert([
            ['correct_amount' => 0, 'section_1' => 24, 'section_2' => 20, 'section_3' => 21],
            ['correct_amount' => 1, 'section_1' => 25, 'section_2' => 20, 'section_3' => 22],
            ['correct_amount' => 2, 'section_1' => 26, 'section_2' => 21, 'section_3' => 23],
            ['correct_amount' => 3, 'section_1' => 27, 'section_2' => 22, 'section_3' => 23],
            ['correct_amount' => 4, 'section_1' => 28, 'section_2' => 23, 'section_3' => 24],
            ['correct_amount' => 5, 'section_1' => 29, 'section_2' => 25, 'section_3' => 25],
            ['correct_amount' => 6, 'section_1' => 30, 'section_2' => 26, 'section_3' => 26],
            ['correct_amount' => 7, 'section_1' => 31, 'section_2' => 27, 'section_3' => 27],
            ['correct_amount' => 8, 'section_1' => 32, 'section_2' => 29, 'section_3' => 28],
            ['correct_amount' => 9, 'section_1' => 32, 'section_2' => 31, 'section_3' => 28],
            ['correct_amount' => 10, 'section_1' => 33, 'section_2' => 33, 'section_3' => 29],
            ['correct_amount' => 11, 'section_1' => 35, 'section_2' => 35, 'section_3' => 30],
            ['correct_amount' => 12, 'section_1' => 37, 'section_2' => 36, 'section_3' => 31],
            ['correct_amount' => 13, 'section_1' => 38, 'section_2' => 37, 'section_3' => 32],
            ['correct_amount' => 14, 'section_1' => 39, 'section_2' => 38, 'section_3' => 34],
            ['correct_amount' => 15, 'section_1' => 41, 'section_2' => 40, 'section_3' => 35],
            ['correct_amount' => 16, 'section_1' => 41, 'section_2' => 40, 'section_3' => 36],
            ['correct_amount' => 17, 'section_1' => 42, 'section_2' => 41, 'section_3' => 37],
            ['correct_amount' => 18, 'section_1' => 43, 'section_2' => 42, 'section_3' => 38],
            ['correct_amount' => 19, 'section_1' => 44, 'section_2' => 43, 'section_3' => 39],
            ['correct_amount' => 20, 'section_1' => 45, 'section_2' => 44, 'section_3' => 40],
            ['correct_amount' => 21, 'section_1' => 45, 'section_2' => 45, 'section_3' => 41],
            ['correct_amount' => 22, 'section_1' => 46, 'section_2' => 46, 'section_3' => 42],
            ['correct_amount' => 23, 'section_1' => 47, 'section_2' => 47, 'section_3' => 43],
            ['correct_amount' => 24, 'section_1' => 47, 'section_2' => 48, 'section_3' => 43],
            ['correct_amount' => 25, 'section_1' => 48, 'section_2' => 49, 'section_3' => 44],
            ['correct_amount' => 26, 'section_1' => 48, 'section_2' => 50, 'section_3' => 45],
            ['correct_amount' => 27, 'section_1' => 49, 'section_2' => 51, 'section_3' => 46],
            ['correct_amount' => 28, 'section_1' => 49, 'section_2' => 52, 'section_3' => 46],
            ['correct_amount' => 29, 'section_1' => 50, 'section_2' => 53, 'section_3' => 47],
            ['correct_amount' => 30, 'section_1' => 51, 'section_2' => 54, 'section_3' => 48],
            ['correct_amount' => 31, 'section_1' => 51, 'section_2' => 55, 'section_3' => 48],
            ['correct_amount' => 32, 'section_1' => 52, 'section_2' => 56, 'section_3' => 49],
            ['correct_amount' => 33, 'section_1' => 52, 'section_2' => 57, 'section_3' => 50],
            ['correct_amount' => 34, 'section_1' => 53, 'section_2' => 58, 'section_3' => 51],
            ['correct_amount' => 35, 'section_1' => 54, 'section_2' => 60, 'section_3' => 52],
            ['correct_amount' => 36, 'section_1' => 54, 'section_2' => 61, 'section_3' => 52],
            ['correct_amount' => 37, 'section_1' => 55, 'section_2' => 63, 'section_3' => 53],
            ['correct_amount' => 38, 'section_1' => 56, 'section_2' => 65, 'section_3' => 54],
            ['correct_amount' => 39, 'section_1' => 57, 'section_2' => 67, 'section_3' => 54],
            ['correct_amount' => 40, 'section_1' => 57, 'section_2' => 68, 'section_3' => 55],
            ['correct_amount' => 41, 'section_1' => 58, 'section_2' => null, 'section_3' => 56],
            ['correct_amount' => 42, 'section_1' => 59, 'section_2' => null, 'section_3' => 57],
            ['correct_amount' => 43, 'section_1' => 60, 'section_2' => null, 'section_3' => 58],
            ['correct_amount' => 44, 'section_1' => 61, 'section_2' => null, 'section_3' => 59],
            ['correct_amount' => 45, 'section_1' => 62, 'section_2' => null, 'section_3' => 60],
            ['correct_amount' => 46, 'section_1' => 63, 'section_2' => null, 'section_3' => 61],
            ['correct_amount' => 47, 'section_1' => 65, 'section_2' => null, 'section_3' => 63],
            ['correct_amount' => 48, 'section_1' => 66, 'section_2' => null, 'section_3' => 65],
            ['correct_amount' => 49, 'section_1' => 67, 'section_2' => null, 'section_3' => 66],
            ['correct_amount' => 50, 'section_1' => 68, 'section_2' => null, 'section_3' => 67],
        ]);
    }
}
