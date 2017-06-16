<?php

namespace Tests\Feature;

use Tests\TestCase;

use App\Task;

class CreateTasksTest extends TestCase
{
	/** @test */
    public function anyone_can_create_a_task()
    {
        $task = factory('App\Image')->create([
            'id' => 1
        ]);

        $task = factory('App\Task')->make([
            'image_id' => 1,
        	'name' => 'Wash Dishes',
            'is_in_history' => 1,
            'is_daily' => 1,
            'description' => 'Test description',
            'link' => 'http://test.com',
            'order' => 5
        ]);

        $response = $this->post('/tasks', $task->toArray());

        $task = Task::find(1);

        $this->assertEquals($task->image_id, 1);
        $this->assertEquals($task->name, 'Wash Dishes');
        $this->assertEquals($task->is_in_history, 1);
        $this->assertEquals($task->is_daily, 1);
        $this->assertEquals($task->description, 'Test description');
        $this->assertEquals($task->link, 'http://test.com');
        $this->assertEquals($task->order, 5);
    }

    /** @test */
    public function show_field_for_making_task_a_daily_task()
    {
        $this->get('/tasks/create')
            ->assertSee('Is This a Daily Task?');
    }
}
