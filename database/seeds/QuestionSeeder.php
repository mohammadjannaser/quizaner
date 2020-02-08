<?php

use Illuminate\Database\Seeder;

class QuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Model\Question::class,100)->create()->each(
            function($question){
                factory(App\Model\Answer::class)->create(['question_id'=> $question->id]);
            }
        );
      
    }
}
