<?php

use EQM\Models\Statuses\Status;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPrefixLinkToStatuses extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(Status::TABLE, function (Blueprint $table) {
            $table->string('prefix_link')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table(Status::TABLE, function (Blueprint $table) {
            $table->dropColumn('prefix_link');
        });
    }
}
