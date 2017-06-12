<?php

namespace Tests\Feature;

use Tests\TestCase;

class ViewTasksTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->task = factory('App\Task')->create();
    }

    /** @test */
    public function anyone_can_view_all_tasks()
    {
        $this->get('/tasks')
            ->assertSee($this->task->name);
    }
}
