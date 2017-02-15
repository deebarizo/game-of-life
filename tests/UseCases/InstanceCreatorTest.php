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
	ZERO START TIME
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

        $this->assertContains($currentDate, '2017-02-13');
    }


	/****************************************************************************************
	NEGATE START TIME
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

        $this->assertContains($currentDate, '2017-02-13');
    }

    /** @test */
    public function returns_next_date_because_greater_than() {

        $this->setUpNegativeStartTime();

        $instanceCreator = new InstanceCreator; 

        $option = Option::find(1);

        $date = new \DateTime('2017-02-13');
        $date->setTime(22, 0); // 22 > 24 + -8
        
        $currentDate = $instanceCreator->getCurrentDate($option, $date);

        $this->assertContains($currentDate, '2017-02-14');
    }

    /** @test */
    public function returns_next_date_because_equals() {

        $this->setUpNegativeStartTime();

        $instanceCreator = new InstanceCreator; 

        $option = Option::find(1);

        $date = new \DateTime('2017-02-13');
        $date->setTime(16, 0); // 16 = 24 + -8
        
        $currentDate = $instanceCreator->getCurrentDate($option, $date);

        $this->assertContains($currentDate, '2017-02-14');
    }
}
