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
            $table->string('first_name', 191);
            $table->string('last_name', 191);
            $table->string('email', 191)->unique();
            $table->string('telephone', 191);
            $table->timestamps();
        });

        Schema::create(AdvertisingCompany::TABLE, function(Blueprint $table) {
            $table->increments('id');
            $table->string('name', 191);
            $table->string('tax', 191)->nullable();
            $table->string('telephone', 191)->nullable();
            $table->string('email', 191);
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
            $table->string('type', 191);
            $table->boolean('paid');
            $table->string('amount', 191);
            $table->integer('clicks');
            $table->integer('views');
            $table->string('website', 191);
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
