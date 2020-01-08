<?php

use Illuminate\Database\Seeder;

class ChallengersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Model\Challengers::class,500)->create();
    }
}
