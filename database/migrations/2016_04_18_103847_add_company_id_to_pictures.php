<?php

use EQM\Models\Companies\Company;
use EQM\Models\Pictures\Picture;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCompanyIdToPictures extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(Picture::TABLE, function (Blueprint $table) {
            $table->integer('company_id')->unsigned()->nullable();
            $table->foreign('company_id')->references('id')->on(Company::TABLE)->onDelete('cascade');
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
            $table->dropForeign('pictures_company_id_foreign');
            $table->dropColumn('company_id');
        });
    }
}
