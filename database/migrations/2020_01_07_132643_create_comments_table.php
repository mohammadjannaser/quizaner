<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            
            $table->bigIncrements('id');
            $table->bigInteger('post_id')->unsigned();
            $table->bigInteger('user_id')->unsigned();
            $table->text('comment_text');

            $table->foreign('post_id')->references('id')->on('posts')
            ->onUpdate('restrict')->onDelete('cascade');

            $table->foreign('user_id')->references('id')->on('users')
            ->onUpdate('restrict')->onDelete('cascade');

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
        Schema::dropIfExists('comments');
    }
}
