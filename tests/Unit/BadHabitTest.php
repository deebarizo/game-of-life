<?php

namespace Tests\Unit;

use Tests\TestCase;

use App\BadHabit;

class BadHabitTest extends TestCase
{
    /** @test */
    public function group_bad_habits_by_date()
    {
        $badHabit = factory('App\BadHabit')->create([
        	'id' => 1,
        	'created_at' => '2017-06-09 04:42:30'
        ]);

        $badHabit = factory('App\BadHabit')->create([
        	'id' => 2,
        	'created_at' => '2017-06-12 06:46:55'
        ]);

        $badHabit = factory('App\BadHabit')->create([
        	'id' => 3,
        	'created_at' => '2017-06-12 06:47:39'
        ]);

        $badHabit = factory('App\BadHabit')->create([
        	'id' => 4,
        	'created_at' => '2017-06-13 04:53:15'
        ]);

        $todayDate = new \DateTime('2017-06-14');

        $badHabits = BadHabit::groupByDate(7, $todayDate);

        $this->assertEquals(7, count($badHabits));

        $this->assertEquals(0, count($badHabits['2017-06-14']));
        $this->assertEquals(2, count($badHabits['2017-06-12']));
        $this->assertEquals(0, count($badHabits['2017-06-10']));
        $this->assertEquals(1, count($badHabits['2017-06-09']));
        $this->assertEquals(0, count($badHabits['2017-06-08']));

        $this->assertEquals($badHabits['2017-06-13'][0]->id, 4);
        $this->assertEquals($badHabits['2017-06-09'][0]->id, 1);

        $this->assertTrue(array_key_exists('2017-06-11', $badHabits));
        $this->assertFalse(array_key_exists('2017-06-01', $badHabits));
    }
}
