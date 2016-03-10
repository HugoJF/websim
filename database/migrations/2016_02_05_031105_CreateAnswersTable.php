<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('answers', function (Blueprint $table) {
            // Primary key
            $table->increments('id');

            // The index of the chosen answer in the possible answers array
            $table->integer('answer');

            // What attempt this answer belongs to, NULL when answering outside a test
            $table->integer('attempt_id')->unsigned()->nullable();
            $table->foreign('attempt_id')->references('id')->on('tests_attempts');

            // What question this answer belongs to
            $table->integer('question_id')->unsigned();
            $table->foreign('question_id')->references('id')->on('questions');

            // What user created the answer
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');

            // What test we belong
            $table->integer('test_id')->unsigned();
            $table->foreign('test_id')->references('id')->on('tests');

            // An attempt shouldn't have duplicate answers for the same question
            $table->unique(['attempt_id', 'question_id']);

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
        Schema::drop('answers');
    }
}
