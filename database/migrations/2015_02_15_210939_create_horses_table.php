<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHorsesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('horses', function(Blueprint $table) {
            $table->increments('id');
            $table->string('name', 191);
            $table->string('gender', 191);
            $table->integer('breed');
            $table->string('height', 191);
            $table->dateTime('date_of_birth')->nullable();
            $table->string('color', 191);
            $table->string('life_number', 191)->nullable();
            $table->string('slug', 191);
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
        Schema::drop('horses');
    }

}
