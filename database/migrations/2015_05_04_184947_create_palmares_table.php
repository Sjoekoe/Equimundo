<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePalmaresTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('palmares', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('horse_id')->unsigned();
            $table->foreign('horse_id')->references('id')->on('horses')->onDelete('cascade');
            $table->integer('event_id')->unsigned()->nullable();
            $table->foreign('event_id')->references('id')->on('events')->onDelete('set null');
            $table->integer('discipline');
            $table->string('level');
            $table->integer('ranking');
            $table->timestamp('date');
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
        Schema::drop('palmares');
    }
}
