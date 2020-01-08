<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
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
                }
               
                
            }
        );
    }
}
