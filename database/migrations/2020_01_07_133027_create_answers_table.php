<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('answers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('question_id')->unsigned();
            $table->text('answer1');
            $table->string('answer1_image', 200);
            $table->text('answer2');
            $table->string('answer2_image', 200);
            $table->text('answer3');
            $table->string('answer3_image', 200);
            $table->text('answer4');
            $table->string('answer4_image', 200);
            $table->smallInteger('correct_answer');
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
        Schema::dropIfExists('answers');
    }
}
