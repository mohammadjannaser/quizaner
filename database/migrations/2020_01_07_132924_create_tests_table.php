<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tests', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->bigInteger('user_id')->unsigned();
            $table->string('test_name');
            $table->integer('test_duration');
            $table->integer('number_of_question');
            $table->integer('test_score');
            $table->dateTime('test_holding_date');
            $table->mediumText('test_description');
            $table->integer('test_cost')->default(0);
            $table->integer('test_privacy')->default(0);
            $table->integer('test_category');
            $table->string('test_image',200)->nullable();
            
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
        Schema::dropIfExists('tests');
    }
}
