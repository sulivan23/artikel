<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbArticle extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_article', function (Blueprint $table) {
            $table->increments('article_id');
            $table->string('judul_artikel', 255);
            $table->integer('category_id');
            $table->unsignedInteger('author_id');
            $table->index('author_id');
            $table->foreign('author_id')->references('id')->on('users')->cascadeOnDelete();
            $table->string('tags',100);
            $table->string('walpaper',255);
            $table->longText('content');
            $table->integer('views_count');
            $table->integer('likes_account');
            $table->enum('status',['Draft','Published','Need Verified','Delete']);
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
        Schema::dropIfExists('tb_article');
    }
}
