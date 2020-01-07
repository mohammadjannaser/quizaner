<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInstructorUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('instructor_users', function (Blueprint $table) {
            $table->bigInteger('instructor_id')->primary()->unsigned();
            $table->string('instructor_name');
            $table->text('instructor_bio');
            $table->char('instructor_phone',14);
            $table->string('instructor_address',200);
            $table->string('user_profile_picture',200);

            
            $table->foreign('instructor_id')->references('id')->on('users')
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
        Schema::dropIfExists('instructor_users');
    }
}
