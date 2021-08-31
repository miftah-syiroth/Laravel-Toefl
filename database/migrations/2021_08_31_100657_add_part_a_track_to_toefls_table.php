<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPartATrackToToeflsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('toefls', function (Blueprint $table) {
            $table->string('part_a_track')->nullable();
            $table->string('part_b_track')->nullable();
            $table->string('part_c_track')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('toefls', function (Blueprint $table) {
            //
        });
    }
}
