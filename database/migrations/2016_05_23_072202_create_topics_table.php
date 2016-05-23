<?php

use EQM\Models\Wiki\Topics\Topic;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTopicsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(Topic::TABLE, function (Blueprint $table) {
            $table->increments('id');
            $table->string('title', 191);
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
        Schema::drop(Topic::TABLE);
    }
}
