<?php

namespace Tests\Feature;

use Tests\TestCase;

use App\Task;
use App\BadHabit;

use App\UseCases\DailyTasksProcessor;

class RunDailyProcessTest extends TestCase
{
    /** @test */
    public function add_daily_tasks()
    {
        $task = factory('App\Task')->create([
        	'id' => 1,
        	'name' => 'Not from Yesterday',
        	'is_daily' => 1,
        	'updated_at' => '2017-06-12 06:47:39'
        ]);

        $task = factory('App\Task')->create([
        	'id' => 2,
        	'is_daily' => 1,
        	'name' => 'Valid Task #2',
        	'updated_at' => '2017-06-13 04:53:15',
            'is_complete' => 1, 
        	'order' => 20
        ]);

        $task = factory('App\Task')->create([
        	'id' => 3,
        	'is_daily' => 0,
        	'name' => 'Not a Daily Task',
        	'is_complete' => 1,
        	'updated_at' => '2017-06-13 04:53:15'
        ]);

        $task = factory('App\Task')->create([
        	'id' => 4,
        	'is_daily' => 1,
        	'name' => 'Valid Task #1',
        	'updated_at' => '2017-06-13 04:53:15',
            'is_complete' => 1,
        	'order' => 10
        ]);

        $todayDate = new \DateTime('2017-06-14');
        $dateString = $todayDate->format('Y-m-d');

        $dailyTasksProcessor = new DailyTasksProcessor;

        $dailyTasksProcessor->generate_daily_tasks($todayDate);

        $tasks = Task::where('updated_at', 'LIKE', $dateString.'%')->orderBy('order', 'asc')->get();

        $this->assertEquals($tasks[0]->name, 'Valid Task #1');
        $this->assertEquals($tasks[1]->name, 'Valid Task #2');

        $this->assertEquals($tasks[0]->is_complete, 0);
        $this->assertEquals($tasks[1]->is_complete, 0);

        $this->assertCount(2, $tasks);
    }

    /** @test */
    public function add_incomplete_non_daily_tasks_and_change_its_updated_at_date_time()
    {
        $task = factory('App\Task')->create([
        	'id' => 2,
        	'is_daily' => 1,
        	'name' => 'Valid Task #2',
        	'updated_at' => '2017-06-13 04:53:15',
        	'order' => 20
        ]);

        $task = factory('App\Task')->create([
        	'id' => 3,
        	'is_daily' => 0,
        	'name' => 'Incomplete Non-Daily Task',
        	'is_complete' => 0,
            'created_at' => '2017-06-13 04:53:15',
        	'updated_at' => '2017-06-13 04:53:15',
        	'order' => 5
        ]);

        $task = factory('App\Task')->create([
        	'id' => 4,
        	'is_daily' => 1,
        	'name' => 'Valid Task #1',
        	'updated_at' => '2017-06-13 04:53:15',
        	'order' => 10
        ]);

        $todayDate = new \DateTime('2017-06-14');
        $dateString = $todayDate->format('Y-m-d');

        $dailyTasksProcessor = new DailyTasksProcessor;

        $dailyTasksProcessor->generate_daily_tasks($todayDate);

        $tasks = Task::where('updated_at', 'LIKE', $dateString.'%')->orderBy('order', 'asc')->get();

        $this->assertEquals($tasks[0]->name, 'Incomplete Non-Daily Task');
        $this->assertEquals($tasks[1]->name, 'Valid Task #1');
        $this->assertEquals($tasks[2]->name, 'Valid Task #2');

        $dateString = $tasks[2]->updated_at->format('Y-m-d');
        $this->assertContains($dateString, '2017-06-14');
    }

    /** @test */
    public function add_daily_bad_habits()
    {
        $badHabit = factory('App\BadHabit')->create([
            'id' => 1,
            'name' => 'Not from Yesterday',
            'created_at' => '2017-06-12 06:47:39',
            'is_success' => 1
        ]);

        $badHabit = factory('App\BadHabit')->create([
            'id' => 2,
            'name' => 'Valid BadHabit #1',
            'created_at' => '2017-06-13 04:53:15',
            'is_success' => 0
        ]);

        $badHabit = factory('App\BadHabit')->create([
            'id' => 3,
            'name' => 'Valid BadHabit #2',
            'created_at' => '2017-06-13 04:53:15',
            'is_success' => 1
        ]);

        $todayDate = new \DateTime('2017-06-14');
        $dateString = $todayDate->format('Y-m-d');

        $dailyTasksProcessor = new DailyTasksProcessor;

        $dailyTasksProcessor->generate_daily_tasks($todayDate);

        $badHabits = BadHabit::where('created_at', 'LIKE', $dateString.'%')->orderBy('id', 'asc')->get();

        $this->assertEquals($badHabits[0]->name, 'Valid BadHabit #1');
        $this->assertEquals($badHabits[1]->name, 'Valid BadHabit #2');

        $this->assertEquals($badHabits[0]->is_success, 1);
        $this->assertEquals($badHabits[1]->is_success, 1);

        $this->assertCount(2, $badHabits);
    }
}
