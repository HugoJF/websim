<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            // AUTO
            $table->increments('id');
            $table->string('path', 255)->nullable();
            $table->integer('parent_id')->unsigned()->nullable();
            $table->integer('level')->default(0);
            $table->timestamps();
            $table->index(['path', 'parent_id', 'level']);
            $table->foreign('parent_id')->references('id')->on('categories')->onDelete('CASCADE');
            }
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('categories');
    }
}
