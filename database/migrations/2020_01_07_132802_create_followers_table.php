<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFollowersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('followers', function (Blueprint $table) {

            $table->bigInteger('user1_id')->unsigned();
            $table->bigInteger('user2_id')->unsigned();
            
            $table->primary(['user1_id', 'user2_id']);

            $table->foreign('user1_id')->references('id')->on('users')
            ->onUpdate('restrict')->onDelete('cascade');

            $table->foreign('user2_id')->references('id')->on('users')
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
        Schema::dropIfExists('followers');
    }
}
