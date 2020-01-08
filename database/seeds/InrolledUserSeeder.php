<?php

use Illuminate\Database\Seeder;

class InrolledUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Model\InrolledUser::class,500)->create();
    }
}
