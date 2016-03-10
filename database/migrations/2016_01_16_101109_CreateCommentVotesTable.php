<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommentVotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comment_votes', function (Blueprint $table) {
            // Primary key
            $table->increments('id');

            // What user create the vote
			$table->integer('user_id')->unsigned();
			$table->foreign('user_id')->references('id')->on('users');

            // What comment this vote belongs to
			$table->integer('comment_id')->unsigned();
			$table->foreign('comment_id')->references('id')->on('comments');

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
        Schema::drop('comment_votes');
    }
}
