<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
       
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->unsigned();
            $table->text('post_text')->nullable();
            $table->string('post_image',200)->nullable();

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
        Schema::dropIfExists('posts');
    }
}
