<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDisciplinesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('disciplines', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('discipline');
            $table->integer('horse_id')->unsigned()->index();
            $table->foreign('horse_id')->references('id')->on('horses')->onDelete('cascade');
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
		Schema::drop('disciplines');
	}

}
