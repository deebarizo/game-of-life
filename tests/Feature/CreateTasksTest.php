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
            'id' => 1,
            'filename' => 'default.png'
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
        $task = factory('App\Image')->create([
            'id' => 1,
            'filename' => 'default.png'
        ]);
        
        $this->get('/tasks/create')
            ->assertSee('Is This a Daily Task?');
    }

    /** @test */
    public function show_correct_defaults()
    {
        $task = factory('App\Image')->create([
            'id' => 1,
            'filename' => 'foo.png'
        ]);

        $task = factory('App\Image')->create([
            'id' => 2,
            'filename' => 'bar.png'
        ]);

        $task = factory('App\Image')->create([
            'id' => 3,
            'filename' => 'default.png'
        ]);

        $task = factory('App\Image')->create([
            'id' => 4,
            'filename' => 'foobar.png'
        ]);

        $this->get('/tasks/create')
            ->assertSee('<input type="radio" name="is_daily" value="0" checked="checked">')
            ->assertSee('<input type="radio" name="is_in_history" value="1" checked="checked">')
            ->assertSee('<option value="3" selected="selected">default.png</option>');
    }
}
