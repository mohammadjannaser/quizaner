<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_users', function (Blueprint $table) {
            $table->bigInteger('user_id')->primary()->unsigned();
            $table->string('username');
            $table->string('user_address',200);
            $table->dateTime('dob');
            $table->text('user_bio');
            $table->string('user_profile_picture',200);

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
        Schema::dropIfExists('student_users');
    }
}
