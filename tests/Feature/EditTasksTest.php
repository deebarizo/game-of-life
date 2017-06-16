<?php

namespace Tests\Feature;

use Tests\TestCase;

use App\Task;

class EditTasksTest extends TestCase
{
	/** @test */
    public function anyone_can_edit_a_task()
    {
        $task = factory('App\Image')->create([
            'id' => 1
        ]);

        $task = factory('App\Image')->create([
            'id' => 2
        ]);

        $task = factory('App\Task')->create([
        	'id' => 1,
            'image_id' => 1,
        	'name' => 'Wash Dishes',
            'is_daily' => 0,
            'is_in_history' => 1,
            'description' => 'Test description',
            'link' => 'http://test.com'
        ]);

        $newTask = factory('App\Task')->make([
        	'id' => 1,
            'image_id' => 2,
        	'name' => 'Wash Dishes and Pots',
            'is_daily' => 1,
            'is_in_history' => 0,
            'description' => 'Test description but different',
            'link' => 'http://test.com/different'
        ]);

        $response = $this->put($task->path(), $newTask->toArray());

        $task = Task::find(1);

        $this->assertEquals($task->image_id, 2);
        $this->assertEquals($task->name, 'Wash Dishes and Pots');
        $this->assertEquals($task->is_daily, 1);
        $this->assertEquals($task->is_in_history, 0);
        $this->assertEquals($task->description, 'Test description but different');
        $this->assertEquals($task->link, 'http://test.com/different');
    }
}
