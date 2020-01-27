<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTestResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('test_results', function (Blueprint $table) {
         
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('test_id')->unsigned();
            $table->integer('correct_answer');
            $table->integer('wrong_answer');
            $table->integer('score');
            $table->integer('duration_time');// in second
            $table->integer('rank');

            $table->primary(['user_id', 'test_id']);

            $table->foreign('user_id')->references('id')->on('users')
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
        Schema::dropIfExists('test_results');
    }
}
