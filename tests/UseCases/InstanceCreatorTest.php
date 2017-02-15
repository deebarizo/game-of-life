<?php

namespace Tests\UseCases;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\UseCases\InstanceCreator;

use App\Models\Option;
use App\Models\DailyTask;
use App\Models\DailyTaskInstance;

class InstanceCreatorTest extends TestCase {

    use DatabaseTransactions;


	/****************************************************************************************
	TEST OPTION WITH ZERO START TIME
	****************************************************************************************/

    private function setUpZeroStartTime() {

        factory(Option::class)->create([
        
            'id' => 1,
            'start_time' => 0,
            'end_time' => 24
        ]);
    }

    /** @test */
    public function returns_same_date() {

        $this->setUpZeroStartTime();

        $instanceCreator = new InstanceCreator; 

        $option = Option::find(1);

        $date = new \DateTime('2017-02-13');
        
        $currentDate = $instanceCreator->getCurrentDate($option, $date);

        $this->assertContains($currentDate->format('Y-m-d'), '2017-02-13');
    }


	/****************************************************************************************
	TEST OPTION WITH NEGATIVE START TIME
	****************************************************************************************/

    private function setUpNegativeStartTime() {

        factory(Option::class)->create([
        
            'id' => 1,
            'start_time' => -8,
            'end_time' => 16
        ]);
    }

    /** @test */
    public function returns_same_date_because_less_than() {

        $this->setUpNegativeStartTime();

        $instanceCreator = new InstanceCreator; 

        $option = Option::find(1);

        $date = new \DateTime('2017-02-13');
        $date->setTime(15, 0); // 15 < 24 + -8
        
        $currentDate = $instanceCreator->getCurrentDate($option, $date);

        $this->assertContains($currentDate->format('Y-m-d'), '2017-02-13');
    }

    /** @test */
    public function returns_next_date_because_greater_than() {

        $this->setUpNegativeStartTime();

        $instanceCreator = new InstanceCreator; 

        $option = Option::find(1);

        $date = new \DateTime('2017-02-13');
        $date->setTime(22, 0); // 22 > 24 + -8
        
        $currentDate = $instanceCreator->getCurrentDate($option, $date);

        $this->assertContains($currentDate->format('Y-m-d'), '2017-02-14');
    }

    /** @test */
    public function returns_next_date_because_equals() {

        $this->setUpNegativeStartTime();

        $instanceCreator = new InstanceCreator; 

        $option = Option::find(1);

        $date = new \DateTime('2017-02-13');
        $date->setTime(16, 0); // 16 = 24 + -8
        
        $currentDate = $instanceCreator->getCurrentDate($option, $date);

        $this->assertContains($currentDate->format('Y-m-d'), '2017-02-14');
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

    	$this->setUpDailyTasks();
    	$this->setUpDailyTaskInstances();

    	$this->setUpZeroStartTime();

    	$instanceCreator = new InstanceCreator;
    	$date = new \DateTime('2017-02-14');

    	$currentDate = $instanceCreator->createInstances($type = 'Daily Task', $optionId = 1, $date);

    	$this->assertContains($currentDate->format('Y-m-d'), '2017-02-14');

    	$dailyTaskInstances = DailyTaskInstance::orderBy('date', 'asc')->get();

    	$this->assertCount(1, $dailyTaskInstances);
    	$this->assertContains('2017-02-14', $dailyTaskInstances[0]->date);
    }

    /** @test */
    public function stores_one_daily_task_instance_because_no_daily_task_instances_in_database() {

    	$this->setUpDailyTasks();

    	$this->setUpZeroStartTime();

    	$instanceCreator = new InstanceCreator;
    	$date = new \DateTime('2017-02-15');

    	$currentDate = $instanceCreator->createInstances($type = 'Daily Task', $optionId = 1, $date);

    	$this->assertContains($currentDate->format('Y-m-d'), '2017-02-15');

    	$dailyTaskInstances = DailyTaskInstance::orderBy('date', 'asc')->get();

    	$this->assertCount(1, $dailyTaskInstances);
    	$this->assertContains('2017-02-15', $dailyTaskInstances[0]->date);
    }

    /** @test */
    public function stores_one_daily_task_instance_because_date_does_not_exist() {

    	$this->setUpDailyTasks();
    	$this->setUpDailyTaskInstances();

    	$this->setUpZeroStartTime();

    	$instanceCreator = new InstanceCreator;
    	$date = new \DateTime('2017-02-15');

    	$currentDate = $instanceCreator->createInstances($type = 'Daily Task', $optionId = 1, $date);

    	$this->assertContains($currentDate->format('Y-m-d'), '2017-02-15');

    	$dailyTaskInstances = DailyTaskInstance::orderBy('date', 'asc')->get();

    	$this->assertCount(2, $dailyTaskInstances);
    	$this->assertContains('2017-02-14', $dailyTaskInstances[0]->date);
    	$this->assertContains('2017-02-15', $dailyTaskInstances[1]->date);
    }

    /** @test */
    public function stores_five_daily_task_instances_because_date_does_not_exist() {

    	$this->setUpDailyTasks();
    	$this->setUpDailyTaskInstances();

    	$this->setUpZeroStartTime();

    	$instanceCreator = new InstanceCreator;
    	$date = new \DateTime('2017-02-19');

    	$currentDate = $instanceCreator->createInstances($type = 'Daily Task', $optionId = 1, $date);

    	$this->assertContains($currentDate->format('Y-m-d'), '2017-02-19');

    	$dailyTaskInstances = DailyTaskInstance::orderBy('date', 'asc')->get();

    	$this->assertCount(6, $dailyTaskInstances);
    	$this->assertContains('2017-02-14', $dailyTaskInstances[0]->date);
    	$this->assertContains('2017-02-17', $dailyTaskInstances[3]->date);
    	$this->assertContains('2017-02-19', $dailyTaskInstances[5]->date);
    }
}
