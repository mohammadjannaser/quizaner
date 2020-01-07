<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserSelectedCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_selected_categories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('category_id')->unsigned();

            $table->foreign('user_id')->references('user_id')->on('student_users')
            ->onUpdate('restrict')->onDelete('cascade');

            $table->foreign('category_id')->references('id')->on('test_categories')
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
        Schema::dropIfExists('user_selected_categories');
    }
}
