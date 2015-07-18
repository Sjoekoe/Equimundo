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
            $table->integer('user_id')->unsigned()->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
			$table->string('name');
			$table->string('gender');
			$table->integer('breed');
			$table->string('height');
            $table->timestamp('date_of_birth')->nullable();
			$table->string('color');
			$table->string('life_number');
            $table->string('slug');
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
