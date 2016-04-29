<?php

use EQM\Models\Addresses\Address;
use EQM\Models\Events\Event;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAddressToEvents extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(Event::TABLE, function (Blueprint $table) {
            $table->integer('address_id')->unsigned()->nullable();
            $table->foreign('address_id')->references('id')->on(Address::TABLE)->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table(Event::TABLE, function (Blueprint $table) {
            $table->dropForeign('events_address_id_foreign');
            $table->dropColumn('address_id');
        });
    }
}
