<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            // Primary key
            $table->increments('id');

            // What user created the comment
			$table->integer('user_id')->unsigned();
			$table->foreign('user_id')->references('id')->on('users');

            // What question this comment this belongs to
			$table->integer('question_id')->unsigned();
			$table->foreign('question_id')->references('id')->on('questions');

            // The comment itself
			$table->text('comment');

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
        Schema::drop('comments');
    }
}
