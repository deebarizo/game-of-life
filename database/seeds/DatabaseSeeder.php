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
	    factory(App\Task::class, 5)->create();

	    factory(App\BadHabit::class, 2)->create();
    }
}
