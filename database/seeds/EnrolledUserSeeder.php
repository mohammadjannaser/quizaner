<?php

use Illuminate\Database\Seeder;

class EnrolledUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Model\EnrolledUser::class,500)->create();
    }
}
