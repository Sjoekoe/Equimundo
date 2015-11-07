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
			$table->string('name');
			$table->string('gender');
			$table->integer('breed');
			$table->string('height');
            $table->date('date_of_birth')->nullable();
			$table->string('color');
			$table->string('life_number')->unique();
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
