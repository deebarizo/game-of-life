<?php

namespace Tests\Feature;

use Tests\TestCase;

use App\Task;

class EditTasksTest extends TestCase
{
	/** @test */
    public function anyone_can_edit_a_task()
    {
        $task = factory('App\Task')->create([
        	'id' => 1,
        	'name' => 'Wash Dishes',
            'is_in_history' => 1,
            'description' => 'Test description',
            'link' => 'http://test.com'
        ]);

        $newTask = factory('App\Task')->make([
        	'id' => 1,
        	'name' => 'Wash Dishes and Pots',
            'is_in_history' => 0,
            'description' => 'Test description but different',
            'link' => 'http://test.com/different'
        ]);

        $response = $this->put($task->path(), $newTask->toArray());

        $task = Task::find(1);

        $this->assertEquals($task->name, 'Wash Dishes and Pots');
        $this->assertEquals($task->is_in_history, 0);
        $this->assertEquals($task->description, 'Test description but different');
        $this->assertEquals($task->link, 'http://test.com/different');
    }

    /** @test */
    public function use_old_image_url_if_a_new_image_is_not_uploaded()
    {
        $task = factory('App\Task')->create([
            'id' => 1
        ]);

        $newTask = factory('App\Task')->make([
            'id' => 1,
            'image_url' => null
        ]);

        $response = $this->put($task->path(), $newTask->toArray());

        $task = Task::find(1);

        $this->assertEquals($task->image_url, 'files/images/experiment.png');
    }
}
