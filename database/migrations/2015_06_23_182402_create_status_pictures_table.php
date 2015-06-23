<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStatusPicturesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('picture_status', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('status_id')->unsigned()->index();
            $table->foreign('status_id')->references('id')->on('statuses')->onDelete('cascade');
            $table->integer('picture_id')->unsigned()->index();
            $table->foreign('picture_id')->references('id')->on('pictures')->onDelete('cascade');
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
		Schema::drop('picture_status');
	}

}
