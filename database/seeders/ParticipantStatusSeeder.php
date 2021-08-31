<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ParticipantStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('participant_statuses')->insert([
            ['status' => 'pengajuan pendaftaran'],
            ['status' => 'pendaftaran diterima'],
            ['status' => 'pendaftaran ditolak'],
            ['status' => 'diblokir'],
            ['status' => 'selesai toefl'],
            ['status' => 'kadaluwarsa'],
        ]);
    }
}
