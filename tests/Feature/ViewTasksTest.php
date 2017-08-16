<?php

namespace Tests\Feature;

use Tests\TestCase;

class ViewTasksTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();

        $task = factory('App\Task')->create([
            'id' => 1,
            'name' => 'Not in History',
            'is_daily' => 1,
            'is_in_history' => 0
        ]);

        $task = factory('App\Task')->create([
            'id' => 2,
            'name' => 'Is In History',
            'is_daily' => 1,
            'is_in_history' => 1
        ]);
    }

    /** @test */
    public function anyone_can_view_all_tasks()
    {
        $this->get('/tasks')
            ->assertSee('Is In History');
    }
}
