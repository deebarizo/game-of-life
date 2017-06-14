<?php

namespace Tests\Feature;

use Tests\TestCase;

class ViewBadHabitsTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->bad_habit = factory('App\BadHabit')->create();
    }

    /** @test */
    public function anyone_can_view_all_tasks()
    {
        $this->get('/bad_habits')
            ->assertSee($this->bad_habit->name);
    }
}
