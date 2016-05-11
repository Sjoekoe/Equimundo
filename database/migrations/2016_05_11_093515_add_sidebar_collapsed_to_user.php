<?php

use EQM\Models\Users\User;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSidebarCollapsedToUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(User::TABLE, function(Blueprint $table) {
            $table->boolean('sidebar_collapsed')->default(true);
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
            $table->dropColumn('sidebar_collapsed');
        });
    }
}
