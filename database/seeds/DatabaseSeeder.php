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
        factory(App\Model\User::class,50)->create();
        factory(App\Model\StudentUser::class,40)->create();
        factory(App\Model\InstructorUser::class,10)->create();
        factory(App\Model\Post::class,100)->create();
        
    }
}
?>