<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSection1DirectionToToeflsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('toefls', function (Blueprint $table) {
            $table->text('section_1_direction')->nullable();
            $table->text('part_a_direction')->nullable();
            $table->text('part_b_direction')->nullable();
            $table->text('part_c_direction')->nullable();
            $table->string('section_1_imageable')->nullable();
            $table->string('part_a_imageable')->nullable();
            $table->string('part_b_imageable')->nullable();
            $table->string('part_c_imageable')->nullable();
            $table->string('section_2_imageable')->nullable();
            $table->string('structure_imageable')->nullable();
            $table->string('written_expression_imageable')->nullable();
            $table->string('section_3_imageable')->nullable();
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
