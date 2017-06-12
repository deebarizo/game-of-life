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
        	'name' => 'Wash Dishes',
            'image_url' => null,
            'is_in_history' => 1,
            'description' => 'Test description',
            'link' => 'http://test.com',
        ]);

        $this->post('/tasks', $task->toArray());

        $task = Task::find(1);
        # ddAll($task);

        $this->assertEquals($task->name, 'Wash Dishes');
        $this->assertEquals($task->is_in_history, 1);
        $this->assertEquals($task->description, 'Test description');
        $this->assertEquals($task->link, 'http://test.com');
    }

    /** @test */
    public function use_default_image_if_image_is_not_given()
    {
        $task = factory('App\Task')->make([
            'image_url' => null
        ]);

        $this->post('/tasks', $task->toArray());

        $task = Task::find(1);

        $this->assertEquals($task->image_url, 'files/images/experiment.png');
    }
}
