<?php

namespace Tests\Feature;

use Tests\TestCase;

use App\Task;

class CreateTasksTest extends TestCase
{
	/** @test */
    public function anyone_can_create_a_task()
    {
        $task = factory('App\Task')->make([
        	'name' => 'Wash Dishes'
        ]);

        $this->post('/tasks', $task->toArray());

        $task = Task::find(1);

        $this->assertEquals($task->name, 'Wash Dishes');
    }
}
