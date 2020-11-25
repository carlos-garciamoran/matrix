<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTripsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trips', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('student_id')->index();
            $table->boolean('signed_in')->default(false);
            $table->boolean('overnight')->default(false);
            $table->boolean('overdue_notification')->default(false);
            $table->dateTime('return_date');
            $table->string('destination', 50);
            $table->tinyInteger('school_phone')->nullable();
            $table->boolean('charger')->nullable();
            $table->timestamps();

            // TODO: set onDelete action (delete, update, "let alone")
            $table->foreign('student_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trips');
    }
}
