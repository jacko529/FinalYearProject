<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Questions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questions', function (Blueprint $table) {

      $table->bigIncrements('id')->index();
        $table->string('name');
        $table->date('date_taken');
        $table->date('date_finished');
        $table->integer('student_id');
        $table->integer('course_id');
        $table->integer('teacher_id');
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
