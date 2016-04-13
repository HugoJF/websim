<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTestsAttemptsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tests_attempts', function (Blueprint $table) {
            // Primary key
            $table->increments('id');

            // What user created the attempt
            $table->integer('user_id')->index()->unsigned();
            $table->foreign('user_id')->references('id')->on('users');

            // What test user is attempting
            $table->integer('test_id')->index()->unsigned();
            $table->foreign('test_id')->references('id')->on('tests');

            // If attempt is finished
            $table->boolean('finished');

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
        Schema::drop('tests_attempts');
    }
}
