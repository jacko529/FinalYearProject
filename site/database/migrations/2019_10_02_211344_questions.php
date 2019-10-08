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

      $table->bigIncrements('id')->unsigned();
        $table->string('name');
        $table->date('date_taken');
        $table->integer('marks')->nullable();
        $table->bigInteger('exam_id')->unsigned();
        $table->foreign('exam_id')->references('id')->on('exam');
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
