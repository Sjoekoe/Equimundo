<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddWistiaIdToHorse extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('horses', function (Blueprint $table) {
            $table->string('wistia_project_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('horses', function (Blueprint $table) {
            $table->dropColumn('wistia_project_id');
        });
    }
}
