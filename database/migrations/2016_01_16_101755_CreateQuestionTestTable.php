<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateQuestionTestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('question_test', function (Blueprint $table) {
            //Primary key
            $table->increments('id');

            // What test entry is pointing
            $table->integer('test_id')->index()->unsigned();
            $table->foreign('test_id')->references('id')->on('tests');

            // What question entry is pointing
            $table->integer('question_id')->index()->unsigned();
            $table->foreign('question_id')->references('id')->on('questions');

            // Timestamps
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
        Schema::drop('question_test');
    }
}
