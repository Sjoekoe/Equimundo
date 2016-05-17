<?php

use EQM\Models\Users\User;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIpToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(User::TABLE, function(Blueprint $table) {
            $table->string('ip', 191);
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
            $table->dropColumn('ip');
        });
    }
}
