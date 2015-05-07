<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePedigreeTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pedigrees', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('horse_id')->unsigned();
            $table->foreign('horse_id')->references('id')->on('horses')->onDelete('cascade');
            $table->integer('type');
            $table->string('family_name');
            $table->string('family_life_number')->nullable();
            $table->integer('family_id')->unsigned()->nullable();
            $table->foreign('family_id')->references('id')->on('horses')->onDelete('set null');
            $table->timestamp('date_of_birth')->nullable();
            $table->timestamp('date_of_death')->nullable();
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
        Schema::drop('pedigrees');
    }

}
