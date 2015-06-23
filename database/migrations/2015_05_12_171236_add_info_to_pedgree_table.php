<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddInfoToPedgreeTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pedigrees', function($table) {
            $table->integer('breed');
            $table->string('height');
            $table->integer('color');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pedigrees', function($table) {
            $table->dropColumn(['breed', 'height', 'color']);
        });
    }

}
