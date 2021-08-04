<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateToeflsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('toefls', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->bigInteger('duration')->nullable();
            $table->string('section_1_track');
            $table->text('section_2_direction');
            $table->text('section_3_direction');
            $table->text('structure_direction');
            $table->text('written_expression_direction');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('toefls');
    }
}
