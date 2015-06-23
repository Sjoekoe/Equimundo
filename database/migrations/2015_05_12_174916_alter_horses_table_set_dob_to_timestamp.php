<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterHorsesTableSetDobToTimestamp extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('horses', function($table) {
            $table->dropColumn('date_of_birth');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::table('horses', function($table) {
            $table->string('date_of_birth')->nullable();
        });
	}

}
