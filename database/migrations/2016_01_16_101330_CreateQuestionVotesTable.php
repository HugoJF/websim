<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuestionVotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('question_votes', function (Blueprint $table) {
            // Primary key
            $table->increments('id');

            // What user created the vote
			$table->integer('user_id')->unsigned();
			$table->foreign('user_id')->references('id')->on('users');

            // What question the vote belongs to
			$table->integer('question_id')->unsigned();
			$table->foreign('question_id')->references('id')->on('questions');

            // TRUE if positive, FALSE if negative
			$table->boolean('direction');

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
        Schema::drop('question_votes');
    }
}
