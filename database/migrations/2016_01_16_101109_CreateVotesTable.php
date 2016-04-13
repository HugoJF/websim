<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateVotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('votes', function (Blueprint $table) {
            // Primary key
            $table->increments('id');

            // Polymorphic relation
            $table->integer('owner_id')->index()->unsigned();
            $table->string('owner_type');

            // User
            $table->integer('user_id')->index()->unsigned();
            $table->foreign('user_id')->references('id')->on('users');

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
        Schema::drop('votes');
    }
}
