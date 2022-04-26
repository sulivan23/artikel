<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbArticleAttachments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_article_attachments', function (Blueprint $table) {
            $table->increments('attachments_id')->unsigned();
            $table->unsignedInteger('article_id');
            $table->foreign('article_id')->references('article_id')->on('tb_article')->cascadeOnDelete();
            $table->string('attachment_url');
            $table->enum('attachment_type',['Image', 'Files']);
            $table->string('attachment_size');
            $table->string('tag');
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
        Schema::dropIfExists('tb_article_attachments');
    }
}
