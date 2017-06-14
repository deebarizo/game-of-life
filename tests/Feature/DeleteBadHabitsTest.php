<?php

namespace Tests\Feature;

use Tests\TestCase;

use App\BadHabit;

class DeleteBadHabitsTest extends TestCase
{
	/** @test */
    public function anyone_can_delete_a_task()
    {
        $badHabit = factory('App\BadHabit')->create();

        $response = $this->delete($badHabit->path());

        $badHabits = BadHabit::all();

        $this->assertCount(0, $badHabits);
    }
}
