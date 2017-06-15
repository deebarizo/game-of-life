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
            'image_url' => null, // this is needed because we are posting an http request and the method uses the FileUploader use case
            'is_in_history' => 1,
            'is_daily' => 1,
            'description' => 'Test description',
            'link' => 'http://test.com',
            'order' => 5
        ]);

        $this->post('/tasks', $task->toArray());

        $task = Task::find(1);

        $this->assertEquals($task->name, 'Wash Dishes');
        $this->assertEquals($task->is_in_history, 1);
        $this->assertEquals($task->is_daily, 1);
        $this->assertEquals($task->description, 'Test description');
        $this->assertEquals($task->link, 'http://test.com');
        $this->assertEquals($task->order, 5);
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

    /** @test */
    public function show_field_for_making_task_a_daily_task()
    {
        $this->get('/tasks/create')
            ->assertSee('Is This a Daily Task?');
    }
}
