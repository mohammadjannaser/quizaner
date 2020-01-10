<?php
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        factory(App\Model\User::class,50)->create()->each(
            function($user){

                if($user->id%4==0){
                    factory(App\Model\InstructorUser::class)->create(['instructor_id' => $user->id]);
                }else {
                    factory(App\Model\StudentUser::class)->create(['user_id' => $user->id]);
                    factory(App\Model\Credit::class)->create(['user_id' => $user->id]);
                }  
            }
        );

        
        factory(App\Model\Post::class,100)->create()->each(
            function($post){
                factory(App\Model\Comment::class,10)->create(['post_id' => $post->id]);
            }
        );
       
       
        factory(App\Model\TestCategory::class,50)->create();

        factory(App\Model\Test::class,100)->create();
        factory(App\Model\Question::class,500)->create()->each(
            function($question){
                factory(App\Model\Answer::class)->create(['question_id'=> $question->id]);
            }
        );
      

        factory(App\Model\InstructorFollower::class,50)->create();
        factory(App\Model\UserSelectedCategory::class,50)->create();
        
        
    }
}
?>