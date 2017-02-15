<?php

namespace Tests\UseCases;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\UseCases\InstanceCreator;
use App\UseCases\DateCalculator;

use App\Models\Option;
use App\Models\DailyTask;
use App\Models\DailyTaskInstance;
use App\Models\BadHabit;
use App\Models\BadHabitInstance;

class InstanceCreatorTest extends TestCase {

    use DatabaseTransactions;


    /****************************************************************************************
    SET UP OPTION
    ****************************************************************************************/

    private function setUpOption() {

        factory(Option::class)->create([
        
            'id' => 1,
            'start_time' => 0,
            'end_time' => 24
        ]);
    }


	/****************************************************************************************
	SET UP DAILY TASKS AND DAILY TASK INSTANCES
	****************************************************************************************/

    private function setUpDailyTasks() {

        factory(DailyTask::class)->create([
        
            'id' => 1,
            'name' => 'Plan Meals',
            'deleted_at' => null
        ]);
    }

    private function setUpDailyTaskInstances() {

        factory(DailyTaskInstance::class)->create([ 
        
            'id' => 1,
            'daily_task_id' => 1,
            'date' => '2017-02-14',
        ]);
    }

    /** @test */
    public function does_not_store_any_daily_task_instances_because_date_exists() {

        $this->setUpOption();
    	$this->setUpDailyTasks();
    	$this->setUpDailyTaskInstances();

    	$instanceCreator = new InstanceCreator;
    	$currentDate = new \DateTime('2017-02-14');

        $option = Option::find(1);

    	$instanceCreator->createInstances($type = 'Daily Task', $currentDate, $option);

    	$dailyTaskInstances = DailyTaskInstance::orderBy('date', 'asc')->get();

    	$this->assertCount(1, $dailyTaskInstances);
    	$this->assertContains('2017-02-14', $dailyTaskInstances[0]->date);
    }

    /** @test */
    public function stores_one_daily_task_instance_because_no_daily_task_instances_in_database() {

        $this->setUpOption();
    	$this->setUpDailyTasks();

    	$instanceCreator = new InstanceCreator;
    	$currentDate = new \DateTime('2017-02-15');

        $option = Option::find(1);

    	$instanceCreator->createInstances($type = 'Daily Task', $currentDate, $option);

    	$dailyTaskInstances = DailyTaskInstance::orderBy('date', 'asc')->get();

    	$this->assertCount(1, $dailyTaskInstances);
    	$this->assertContains('2017-02-15', $dailyTaskInstances[0]->date);
    }

    /** @test */
    public function stores_one_daily_task_instance_because_date_does_not_exist() {

        $this->setUpOption();
    	$this->setUpDailyTasks();
    	$this->setUpDailyTaskInstances();

    	$instanceCreator = new InstanceCreator;
    	$currentDate = new \DateTime('2017-02-15');

        $option = Option::find(1);

    	$instanceCreator->createInstances($type = 'Daily Task', $currentDate, $option);

    	$dailyTaskInstances = DailyTaskInstance::orderBy('date', 'asc')->get();

    	$this->assertCount(2, $dailyTaskInstances);
    	$this->assertContains('2017-02-14', $dailyTaskInstances[0]->date);
    	$this->assertContains('2017-02-15', $dailyTaskInstances[1]->date);
    }

    /** @test */
    public function stores_five_daily_task_instances_because_date_does_not_exist() {

        $this->setUpOption();
    	$this->setUpDailyTasks();
    	$this->setUpDailyTaskInstances();

    	$instanceCreator = new InstanceCreator;
    	$currentDate = new \DateTime('2017-02-19');

        $option = Option::find(1);

    	$instanceCreator->createInstances($type = 'Daily Task', $currentDate, $option);

       	$dailyTaskInstances = DailyTaskInstance::orderBy('date', 'asc')->get();

    	$this->assertCount(6, $dailyTaskInstances);
    	$this->assertContains('2017-02-14', $dailyTaskInstances[0]->date);
    	$this->assertContains('2017-02-17', $dailyTaskInstances[3]->date);
    	$this->assertContains('2017-02-19', $dailyTaskInstances[5]->date);
    }


    /****************************************************************************************
    SET UP BAD HABITS AND BAD HABIT INSTANCES
    ****************************************************************************************/

    private function setUpBadHabits() {

        factory(BadHabit::class)->create([
        
            'id' => 1,
            'name' => 'Do Not Smoke',
            'deleted_at' => null
        ]);
    }

    private function setUpBadHabitInstances() {

        factory(BadHabitInstance::class)->create([
        
            'id' => 1,
            'bad_habit_id' => 1,
            'date' => '2017-02-14',
        ]);
    }

    /** @test */
    public function does_not_store_any_bad_habit_instances_because_date_exists() {

        $this->setUpOption();
        $this->setUpBadHabits();
        $this->setUpBadHabitInstances();

        $instanceCreator = new InstanceCreator;
        $currentDate = new \DateTime('2017-02-14');

        $option = Option::find(1);

        $instanceCreator->createInstances($type = 'Bad Habit', $currentDate, $option);

        $badHabitInstances = BadHabitInstance::orderBy('date', 'asc')->get();

        $this->assertCount(1, $badHabitInstances);
        $this->assertContains('2017-02-14', $badHabitInstances[0]->date);
    }

    /** @test */
    public function stores_one_bad_habit_instance_because_no_bad_habit_instances_in_database() {

        $this->setUpOption();
        $this->setUpBadHabits();

        $instanceCreator = new InstanceCreator;
        $currentDate = new \DateTime('2017-02-15');

        $option = Option::find(1);

        $instanceCreator->createInstances($type = 'Bad Habit', $currentDate, $option);

        $badHabitInstances = BadHabitInstance::orderBy('date', 'asc')->get();

        $this->assertCount(1, $badHabitInstances);
        $this->assertContains('2017-02-15', $badHabitInstances[0]->date);
    }

    /** @test */
    public function stores_one_bad_habit_instance_because_date_does_not_exist() {

        $this->setUpOption();
        $this->setUpBadHabits();
        $this->setUpBadHabitInstances();

        $instanceCreator = new InstanceCreator;
        $currentDate = new \DateTime('2017-02-15');

        $option = Option::find(1);

        $instanceCreator->createInstances($type = 'Bad Habit', $currentDate, $option);

        $badHabitInstances = BadHabitInstance::orderBy('date', 'asc')->get();

        $this->assertCount(2, $badHabitInstances);
        $this->assertContains('2017-02-14', $badHabitInstances[0]->date);
        $this->assertContains('2017-02-15', $badHabitInstances[1]->date);
    }

    /** @test */
    public function stores_five_bad_habit_instances_because_date_does_not_exist() {

        $this->setUpOption();
        $this->setUpBadHabits();
        $this->setUpBadHabitInstances();

        $instanceCreator = new InstanceCreator;
        $currentDate = new \DateTime('2017-02-19');

        $option = Option::find(1);

        $instanceCreator->createInstances($type = 'Bad Habit', $currentDate, $option);

        $badHabitInstances = BadHabitInstance::orderBy('date', 'asc')->get();

        $this->assertCount(6, $badHabitInstances);
        $this->assertContains('2017-02-14', $badHabitInstances[0]->date);
        $this->assertContains('2017-02-17', $badHabitInstances[3]->date);
        $this->assertContains('2017-02-19', $badHabitInstances[5]->date);
    }
}
