<?php

namespace Tests\Unit;

use Tests\TestCase;

use App\Task;

class TaskTest extends TestCase
{
    /** @test */
    public function group_tasks_by_date()
    {
        $task = factory('App\Task')->create([
        	'id' => 1,
        	'updated_at' => '2017-06-09 04:42:30'
        ]);

        $task = factory('App\Task')->create([
        	'id' => 2,
        	'updated_at' => '2017-06-12 06:46:55'
        ]);

        $task = factory('App\Task')->create([
        	'id' => 3,
        	'updated_at' => '2017-06-12 06:47:39'
        ]);

        $task = factory('App\Task')->create([
        	'id' => 4,
        	'updated_at' => '2017-06-13 04:53:15'
        ]);

        $todayDate = new \DateTime('2017-06-14');

        $tasks = Task::groupByDate(7, $todayDate);

        $this->assertEquals(7, count($tasks));

        $this->assertEquals(0, count($tasks['2017-06-14']));
        $this->assertEquals(2, count($tasks['2017-06-12']));
        $this->assertEquals(0, count($tasks['2017-06-10']));
        $this->assertEquals(1, count($tasks['2017-06-09']));
        $this->assertEquals(0, count($tasks['2017-06-08']));

        $this->assertEquals($tasks['2017-06-13'][0]->id, 4);
        $this->assertEquals($tasks['2017-06-09'][0]->id, 1);

        $this->assertTrue(array_key_exists('2017-06-11', $tasks));
        $this->assertFalse(array_key_exists('2017-06-01', $tasks));
    }
}
