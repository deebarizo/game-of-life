<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class FocusTasksTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->task = factory('App\Task')->create([
        	'id' => 1,
        	'name' => 'A Great Task',
        	'description' => 'A great description',
        	'link' => 'http://example.com',
        	'is_in_history' => 1
        ]);
    }

    /** @test */
    public function anyone_can_focus_on_a_task()
    {
        $this->get($this->task->path().'/focus')
            ->assertSee($this->task->name)
            ->assertSee($this->task->description)
            ->assertSee($this->task->link)
            ->assertSee('star.png');
    }
}
