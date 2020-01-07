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
            $table->bigInteger('instructor_id')->unsigned();
            $table->string('test_name');
            $table->integer('test_duration');
            $table->integer('number_of_question');
            $table->integer('test_score');
            $table->dateTime('test_hoding_date');
            $table->mediumText('test_description');
            $table->integer('test_cost');
            $table->integer('test_privacy');
            $table->integer('test_category');
            
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
        Schema::dropIfExists('tests');
    }
}
