<?php

use Illuminate\Database\Seeder;

class InstructorUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        factory(App\Model\InstructorUser::class,10)->create();
    }
}