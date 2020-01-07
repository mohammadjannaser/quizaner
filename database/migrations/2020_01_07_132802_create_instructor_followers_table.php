<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInstructorFollowersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('instructor_followers', function (Blueprint $table) {

            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('instructor_id')->unsigned();
            
            $table->primary(['user_id', 'instructor_id']);

            $table->foreign('user_id')->references('user_id')->on('student_users')
            ->onUpdate('restrict')->onDelete('cascade');
            $table->foreign('instructor_id')->references('instructor_id')->on('instructor_users')
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
        Schema::dropIfExists('instructor_followers');
    }
}
