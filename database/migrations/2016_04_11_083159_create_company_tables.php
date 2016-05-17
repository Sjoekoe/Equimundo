<?php

use EQM\Models\Companies\Company;
use EQM\Models\Companies\Horses\CompanyHorse;
use EQM\Models\Companies\Users\CompanyUser;
use EQM\Models\Horses\Horse;
use EQM\Models\Users\User;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompanyTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(Company::TABLE, function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 191);
            $table->string('slug', 191);
            $table->string('telephone', 191);
            $table->string('website', 191);
            $table->string('email', 191);
            $table->longText('about', 191);
            $table->integer('address_id')->unsigned()->nullable();
            $table->foreign('address_id')->references('id')->on('addresses')->onDelete('set null');
            $table->string('type', 191);
            $table->timestamps();
        });

        Schema::create(CompanyUser::TABLE, function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on(User::TABLE)->onDelete('cascade');
            $table->integer('company_id')->unsigned();
            $table->foreign('company_id')->references('id')->on(Company::TABLE)->onDelete('cascade');
            $table->boolean('is_admin')->default(false);
            $table->string('type');
            $table->timestamps();
        });

        Schema::create(CompanyHorse::TABLE, function (Blueprint $table) {
            $table->increments('id');
            $table->integer('horse_id')->unsigned();
            $table->foreign('horse_id')->references('id')->on(Horse::TABLE)->onDelete('cascade');
            $table->integer('company_id')->unsigned();
            $table->foreign('company_id')->references('id')->on(Company::TABLE)->onDelete('cascade');
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
        Schema::drop(CompanyHorse::TABLE);
        Schema::drop(CompanyUser::TABLE);
        Schema::drop(Company::TABLE);
    }
}
