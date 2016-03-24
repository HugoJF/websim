<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tests', function (Blueprint $table) {
            // Primary key
            $table->increments('id');

            // The description/name of the test
            $table->string('name');

            // What user created the test
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');

            // If the test is unlisted
            $table->boolean('unlisted');

            // Random characters that point to this question
            $table->string('stub', 10)->nullable();

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
        Schema::drop('tests');
    }
}
