<?php

use EQM\Models\Users\User;
use EQM\Models\Users\UserInterests;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInterestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(UserInterests::TABLE, function (Blueprint $table) {
            $table->increments('id');
            $table->integer('type');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on(User::TABLE)->onDelete('cascade');
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
        Schema::drop(UserInterests::TABLE);
    }
}
