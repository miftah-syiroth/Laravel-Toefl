<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('scores', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users');
            $table->integer('section1_answered')->nullable();
            $table->integer('section2_answered')->nullable();
            $table->integer('section3_answered')->nullable();
            $table->integer('section1_correct')->nullable();
            $table->integer('section2_correct')->nullable();
            $table->integer('section3_correct')->nullable();
            $table->integer('section1_score')->nullable();
            $table->integer('section2_score')->nullable();
            $table->integer('section3_score')->nullable();
            $table->integer('final_score')->nullable();
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
        Schema::dropIfExists('scores');
    }
}
