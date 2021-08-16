<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAddressToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('kelas_id')->nullable()->constrained('kelas');
            $table->foreignId('toefl_id')->nullable()->constrained('toefls');
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->string('receipt_of_payment')->nullable();
            $table->string('certificate')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
}
