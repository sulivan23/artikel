<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbComments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_comments', function (Blueprint $table) {
            $table->increments('comment_id');
            $table->string('comment_value');
            $table->string('user_id');
            $table->enum('is_reply_comment',['Y','T']);
            $table->integer('reply_comment_id');
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
        Schema::dropIfExists('tb_comments');
    }
}
