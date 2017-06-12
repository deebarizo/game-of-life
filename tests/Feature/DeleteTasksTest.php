<?php

namespace Tests\Feature;

use Tests\TestCase;

use App\Task;

class DeleteTasksTest extends TestCase
{
	/** @test */
    public function anyone_can_delete_a_task()
    {
        $task = factory('App\Task')->create([
        	'id' => 1,
        	'name' => 'Wash Dishes',
            'is_in_history' => 1,
            'description' => 'Test description',
            'link' => 'http://test.com'
        ]);

        $response = $this->delete($task->path());

        $tasks = Task::all();

        $this->assertCount(0, $tasks);
    }
}
