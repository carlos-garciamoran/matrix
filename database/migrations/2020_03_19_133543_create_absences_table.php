<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAbsencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('absences', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('advisor_id');
            $table->date('leave_date');
            $table->date('return_date');
            $table->set('reason', ['Medical', 'Personal', 'Professional development', 'School-related', 'Other']);
            $table->text('comment', 500)->nullable();
            $table->boolean('approved')->nullable();
            $table->timestamps();

            // TODO: set onDelete action (delete, update, "let alone")
            $table->foreign('advisor_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('absences');
    }
}
