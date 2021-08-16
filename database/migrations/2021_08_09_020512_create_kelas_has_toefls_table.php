<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKelasHasToeflsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kelas_has_toefls', function (Blueprint $table) {
            $table->foreignId('kelas_id')->constrained('kelas');
            $table->foreignId('toefl_id')->constrained('toefls');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kelas_has_toefls');
    }
}
