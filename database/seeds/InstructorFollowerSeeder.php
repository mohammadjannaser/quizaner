<?php

use Illuminate\Database\Seeder;

class InstructorFollowerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Model\InstructorFollower::class,100)->create();
    }
}
