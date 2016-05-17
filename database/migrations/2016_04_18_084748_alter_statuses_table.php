<?php

use EQM\Models\Companies\Company;
use EQM\Models\Statuses\Status;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(Status::TABLE, function (Blueprint $table) {
            $table->string('type', 191);
            $table->integer('company_id')->unsigned()->nullable();
            $table->foreign('company_id')->references('id')->on(Company::TABLE)->onDelete('cascade');
            $table->integer('horse_id')->unsigned()->nullable()->change();
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
            $table->integer('horse_id')->unsigned()->change();
            $table->dropForeign('statuses_company_id_foreign');
            $table->dropColumn(['type', 'company_id']);
        });
    }
}
