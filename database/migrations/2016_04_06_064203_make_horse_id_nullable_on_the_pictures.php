<?php

use EQM\Models\Pictures\Picture;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MakeHorseIdNullableOnThePictures extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(Picture::TABLE, function (Blueprint $table) {
            $table->integer('horse_id')->unsigned()->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table(Picture::TABLE, function (Blueprint $table) {
            $table->integer('horse_id')->unsigned()->change();
        });
    }
}
