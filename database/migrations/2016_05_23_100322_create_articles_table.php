<?php

use EQM\Models\Wiki\Articles\Article;
use EQM\Models\Wiki\Topics\Topic;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(Article::TABLE, function (Blueprint $table) {
            $table->increments('id');
            $table->string('title', 191);
            $table->string('slug', 191);
            $table->longText('body');
            $table->integer('views')->default(0);
            $table->integer('topic_id')->unsigned();
            $table->foreign('topic_id')->references('id')->on(Topic::TABLE)->onDelete('cascade');
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
        Schema::drop(Article::TABLE);
    }
}
