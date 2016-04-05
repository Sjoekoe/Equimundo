<?php

use EQM\Models\Advertising\Advertisements\Advertisement;
use EQM\Models\Advertising\Companies\AdvertisingCompany;
use EQM\Models\Advertising\Contacts\AdvertisingContact;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdvertisingCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(AdvertisingContact::TABLE, function(Blueprint $table) {
            $table->increments('id');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->string('telephone');
            $table->timestamps();
        });

        Schema::create(AdvertisingCompany::TABLE, function(Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('tax')->nullable();
            $table->string('telephone')->nullable();
            $table->string('email');
            $table->integer('adv_contact_id')->unsigned();
            $table->foreign('adv_contact_id')->references('id')->on(AdvertisingContact::TABLE)->onDelete('cascade');
            $table->integer('address_id')->unsigned()->nullable();
            $table->foreign('address_id')->references('id')->on('addresses')->onDelete('set null');
            $table->timestamps();
        });

        Schema::create(Advertisement::TABLE, function(Blueprint $table) {
            $table->increments('id');
            $table->dateTime('start');
            $table->dateTime('end');
            $table->integer('type');
            $table->boolean('paid');
            $table->string('amount');
            $table->integer('clicks');
            $table->integer('views');
            $table->string('website');
            $table->integer('adv_company_id')->unsigned();
            $table->foreign('adv_company_id')->references('id')->on(AdvertisingCompany::TABLE)->onDelete('cascade');
            $table->integer('picture_id')->unsigned()->nullable();
            $table->foreign('picture_id')->references('id')->on('pictures')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop(Advertisement::TABLE);
        Schema::drop(AdvertisingCompany::TABLE);
        Schema::drop(AdvertisingContact::TABLE);
    }
}
