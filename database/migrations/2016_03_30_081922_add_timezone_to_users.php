<?php

use EQM\Models\Users\User;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTimezoneToUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(User::TABLE, function (Blueprint $table) {
            $table->string('timezone', 191)->default('UTC');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table(User::TABLE, function (Blueprint $table) {
            $table->dropColumn('timezone');
        });
    }
}
