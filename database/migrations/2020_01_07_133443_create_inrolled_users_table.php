<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInrolledUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inrolled_users', function (Blueprint $table) {
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('test_id')->unsigned();

            $table->primary(['user_id', 'test_id']);

            $table->foreign('user_id')->references('user_id')->on('student_users')
            ->onUpdate('restrict')->onDelete('cascade');
    
            $table->foreign('test_id')->references('id')->on('tests')
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
        Schema::dropIfExists('inrolled_users');
    }
}
