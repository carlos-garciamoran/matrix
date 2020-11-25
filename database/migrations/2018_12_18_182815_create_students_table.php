<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->unsignedInteger('user_id')->primary();
            $table->string('nickname')->nullable();
            $table->string('country');
            $table->tinyInteger('grade');
            $table->tinyInteger('residence');
            $table->tinyInteger('house');
            $table->char('room', 1);
            $table->date('birthdate')->nullable();
            $table->string('phone')->nullable()->unique();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('students');
    }
}
