<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_details', function (Blueprint $table) {

            $table->bigInteger('id')->primary()->unsigned();

            $table->string('username');
            $table->char('phone',14)->nullable();
            $table->date('dob')->nullable();
            $table->string('country',100)->nullable();
            $table->text('user_bio')->nullable();
            $table->string('user_profile_picture',200)->nullable();
            $table->boolean('verified')->default(0);
            $table->integer('user_type')->default(1);
            // User type 1 indicate Student user and user type 2 indicate instructor type


            $table->foreign('id')->references('id')->on('users')
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
        Schema::dropIfExists('user_details');
    }
}
