<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('email', 191)->unique();
            $table->string('first_name', 191);
            $table->string('last_name', 191);
            $table->dateTime('date_of_birth')->nullable();
            $table->string('country', 3)->nullable();
            $table->string('gender', 1);
            $table->text('about')->nullable();
            $table->string('password', 60);
            $table->boolean('activated');
            $table->boolean('email_notifications')->default(true);
            $table->string('date_format', 191)->default('d/m/Y');
            $table->string('language', 191)->default('en');
            $table->rememberToken()->nullable();
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
        Schema::drop('users');
    }

}
