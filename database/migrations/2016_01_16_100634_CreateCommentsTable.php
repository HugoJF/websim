<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

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
            $table->integer('user_id')->index()->unsigned();
            $table->foreign('user_id')->references('id')->on('users');

            // What thing this comment this belongs to
            $table->integer('owner_id')->index()->unsigned();
            $table->string('owner_type');

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
