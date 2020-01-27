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
        factory(App\Model\User::class,10)->create()->each(
            function($user){

                factory(App\Model\UserDetail::class)->create(['user_id' => $user->id]);

                factory(App\Model\Credit::class)->create(['user_id' => $user->id]);
                
            }
        );

    }
}
