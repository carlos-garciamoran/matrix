<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOvernightAuthorisationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('overnight_authorisations', function (Blueprint $table) {
            $table->unsignedInteger('student_id')->unique()->index();
            $table->unsignedInteger('advisor_id');
            $table->date('leave_date');
            $table->date('return_date');

            $table->primary(['advisor_id', 'student_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('overnight_authorisations');
    }
}
