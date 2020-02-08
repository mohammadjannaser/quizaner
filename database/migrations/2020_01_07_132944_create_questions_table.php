<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('test_id')->unsigned();
            $table->text('question_text');
            $table->string('question_image')->nullable();
            /**
             * There are three type of questions
             * 1. MSQ Questions
             * 2. information question
             * 3. long answer question
             */
            $table->integer('question_type')->default(1);
            // limit the time of answer of question.
            $table->integer('question_duration')->default(60);
            $table->integer('question_mark')->default(1);

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
        Schema::dropIfExists('questions');
    }
}
