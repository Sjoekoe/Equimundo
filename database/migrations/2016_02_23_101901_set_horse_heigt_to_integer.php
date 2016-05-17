<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SetHorseHeigtToInteger extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('horses', function(Blueprint $table) {
            $table->integer('height')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('horses', function(Blueprint $table) {
            $table->string('height', 191)->change();
        });
    }
}
